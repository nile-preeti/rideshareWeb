<?php




defined('BASEPATH') OR exit('No direct script access allowed');



class Driver extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->auth();
        //$this->stripepayment();

        $this->load->model(array('api/Auth_model'));
		$this->load->helper(array('common/common','url'));
        $this->config->load('config');
		
	 }
    /*################################ 
    For accept ride from rider 
	##################################*/
    public function acceptRide_post(){
		
    	$ride_id = $this->input->post('ride_id');
    	$status = $this->input->post('status');
    	$is_technical_issue = $this->input->post('is_technical_issue');
        $qry = $this->Auth_model->get_current_ride($ride_id);
        if ((string)$qry->row()->ride_status=='CANCELLED') {
          $this->response(array("status" => false, 'message'=>'Ride has been cancelled already'));
        }else if($status=='DELETED'){
            $is_affected = $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('status'=>$status));
            $this->set_response(['status'=>true,'message'=>''],REST_Controller::HTTP_OK);
        }else{

            if ($this->user_data->utype==1) {// USER

                $condition = array('user_id'=>$this->user_data->id,'ride_id'=>$ride_id);

            }else{

                $condition = array('driver_id'=>$this->user_data->id,'ride_id'=>$ride_id);

            }

            if ((string)$status!='CANCELLED'){

        	   $is_affected = $this->Auth_model->update(Tables::RIDE,$condition,array('status'=>$status));

            }

            // is_online=2 that means user busy in ride

            // is_online=1 that means user online in ride

            // is_online=3 that means user offline in ride

            $qry = $this->Auth_model->get_current_ride($ride_id);

            $res = $qry->row();

            if ((string)$status=='PENDING') {

                $load = array();

                $load['title']  = SITE_TITLE;

                $load['msg']    = 'You have a new ride';

                $load['action'] = 'PENDING';

                $load['ride_id'] = $ride_id;

                $token = $res->driver_fcm; 

                //$this->common->android_push($token, $load, FCM_KEY);

            }else if ((string)$status=='ACCEPTED') {

                $load = array();

                if ($this->user_data->utype==2){

                    $user_detail['count_cancelled_ride']=0;

                }

                $vehicle_detail = $this->Auth_model->getCustomFields(Tables::VEHICLE_DETAIL,array('status'=>1,'user_id'=>$this->user_data->id),'id');

                //echo $this->db->last_query();die;

                $this->Auth_model->update(Tables::RIDE,$condition,array('vehicle_detail_id'=>$vehicle_detail->row()->id));

                $load['title']  = SITE_TITLE;

                $load['msg']    = 'Your ride has been accepted by '.$res->driver_name;

                $load['action'] = 'ACCEPTED';

                $load['ride_id'] = $ride_id;

                $load['driver_id'] = $qry->row()->driver_id;

                $token = $res->user_fcm; 

                //echo  $token; 

                $this->common->android_push($token, $load, FCM_KEY); 

               // $this->common->android_push($token, $load, FCM_KEY); 



            }else if ((string)$status=='START_RIDE') {

                $load = array();

                $load['title']  = SITE_TITLE;

                $load['msg']    = 'Your ride has been started';

                $load['action'] = 'START_RIDE';

                $load['ride_id'] = $ride_id;

                $token = $res->user_fcm;  

                $this->common->android_push($token, $load, FCM_KEY);

            }

            $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('confirmation_time'=>date('Y-m-d H:i:s')));

            $user_detail['is_online'] = 2;



            $message ="Ride confirmed";



            if ((string)$status=='COMPLETED' || (string)$status=='CANCELLED') {
                $user_detail = array('is_online'=>1);
                if ((string)$status=='COMPLETED') {
					if(!empty($is_technical_issue)){
						$ride_msg= "Dear Rider,I apologize for the inconvenience. We've identified a malfunction, and there won't be any charge to your card for this ride. We're working swiftly to resolve the issue.";
					}else{
						$ride_msg = "Your ride has been completed";
					}
                    $message ="Ride completed successfully";
                    $this->ride_complete_mail($res);
                    $load = array();
                    $load['title']  = SITE_TITLE;
                    $load['msg']    = $ride_msg;
                    $load['action'] = 'COMPLETED';
                    $load['is_technical_issue'] = $is_technical_issue;
                    $load['ride_id'] = $ride_id;
                    $token = $res->user_fcm; 
                    //echo  $token;  
                   $cancellation_amount=0;
                    $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('is_technical_issue'=>$is_technical_issue,'payment_status'=>'COMPLETED','cancellation_charge'=>$cancellation_amount,));
                   
                    $this->common->android_push($token, $load, FCM_KEY);
					
					$qry = $this->Auth_model->get_current_ride($ride_id);

					$res = $qry->row();
					
					//print_r($res); die;
					$this->load->library( 'common/stripe_lib');				
					
					$itemPriceCents = ( $res->amount*100 ); 
					$postdata=array(
						'txn_id'=>$res->txn_id,
						'amount'=>$itemPriceCents,
					);
						
					if(empty($is_technical_issue)){
						$charge= $this->stripe_lib->createPayment($res->card_id, $postdata);
					//echo $charge['status'];die;
					//$charge = $this->stripe_lib->createPayment( $api_data->api_secret, $customer->id, $payment_data );
						if($charge['status']=='succeeded'){
								
							$id = $this->Auth_model->save(TABLES::PAYMENT_HISTORY,array('ride_id'=>$ride_id,'amount'=>$res->amount,'txn_id'=>$res->txn_id,'date'=>date('Y-m-d H:i:s'),'cancellation_charge'=>0));
							  if ($id){
								  $affected= $this->Auth_model->update(TABLES::USER,array('user_id'=>$res->userid),array('cancellation_charge'=>0));

								  $affected= $this->Auth_model->update(TABLES::RIDE,array('ride_id'=>$ride_id),array('payment_status'=>'COMPLETED','payment_mode'=>'ONLINE'));
								  $queryamt = $this->Auth_model->getCustomFields(TABLES::HOLD_PAYMENT_HISTORY,array('txn_id'=>$res->txn_id),'*');
								  $rowamt = $queryamt->row();
								  $rest_amt= $rowamt->amount-$res->amount;
								  $affected= $this->Auth_model->update(TABLES::HOLD_PAYMENT_HISTORY,array('txn_id'=>$res->txn_id),array('status'=>'0','charge_amount'=>$res->amount,'rest_amount'=>$rest_amt));
								  
								 

								  $user_query = $this->Auth_model->get_current_ride($ride_id);

								  $load = array();

								  $load['title']  = SITE_TITLE;

								  $load['msg']    = 'Payment has been paid Successfully';

								  $load['action'] = 'FEEDBACK';                

								  $token =  $user_query->row()->user_fcm;                

								 $this->common->android_push($token, $load, FCM_KEY);



								  $load['title']  = SITE_TITLE;

								  $load['msg']    = 'Payment has been received successfully.';

								  $load['action'] = 'FEEDBACK';                

								  $token =  $user_query->row()->driver_fcm;

							 $this->common->android_push($token, $load, FCM_KEY);

								if ($affected) {

									 $this->set_response(['status'=>true,'message'=>"Payment has been paid successfully"], REST_Controller::HTTP_OK);

								}else{

									  $this->set_response(['status'=>false,'message'=>"Error occured, Please try after some time"], REST_Controller::HTTP_OK);

								}                

							}
							 $this->set_response(['status'=>true,'message'=>"Payment has been paid successfully"], REST_Controller::HTTP_OK);		
						}	
						
					}
                }else if ((string)$status=='CANCELLED'){ 
                    if ($this->user_data->utype==2){  
                        $user_detail['count_cancelled_ride']=$res->count_cancelled_ride+1;

                        $this->Auth_model->save(Tables::CANCELLED_RIDE,array('driver_id'=>$this->user_data->id,'ride_id'=>$ride_id,'created_date'=>date('Y-m-d H:i:s'),'updated_date'=>date('Y-m-d H:i:s')));
                        $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('cancelled_by'=>$this->user_data->id,'cancelled_count'=>$res->cancelled_count+1));
                        if($res->ride_status=='ACCEPTED'){
							$vehicle_subcategory_id=$this->Auth_model->getCustomFields(Tables::RIDE,array('ride_id'=>$ride_id),'vehicle_type_id');
							$subcat_id=$vehicle_subcategory_id->row()->vehicle_type_id;
							$cancellation_charge= $this->Auth_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('id'=>$subcat_id),'cancellation_fee');
							
                            $cancellation_amount= $cancellation_charge->row()->cancellation_fee;
                            $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('cancelled_by'=>$this->user_data->id,'cancelled_count'=>$res->cancelled_count+1,'cancellation_charge'=>$cancellation_amount,'status'=>$status));                          
                            $load = array();
                            $reason_message = "Your ride has been cancelled by driver.";
                            $load['title']  = SITE_TITLE;
                            if($this->input->post('reason')){
                                $reason_message= 'Ride cancelled: '. $this->input->post('reason');
                            }   
                            $load['msg']    = $reason_message;
                            //$load['reason']    = 'Rider cancelled:'. $this->input->post('reason');
                            $load['action'] = 'CANCELLED';
                            $load['ride_id'] = $ride_id;
                            $token = $res->user_fcm;;  
                            $this->common->android_push($token, $load, FCM_KEY);
                        }else{
                            $resp = $this->assign_ride_to_next_driver($res->pickup_lat,$res->pickup_long,$res->drop_lat,$res->drop_long,$res->ride_id,$res->distance,$res->vehicle_type_id);
                        
                            if (!$resp) {
                                $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('status'=>'FAILED'));
                                //$message ="Driver is not available in your range";
                            }
                        }
                        //echo $this->db->last_query();                                  
                        $message ="Ride cancelled successfully"; 
                    }else{
                        $cancellation_amount=0;
                        if($this->user_data->utype==1){ 
                            $confirmtimestamp = strtotime($qry->row()->confirmation_time.' + 5 minute'); 
                            $currenttimestamp= strtotime(date('Y-m-d H:i:s'));
                            //echo date('Y-m-d H:i:s',$currenttimestamp);
                            if($currenttimestamp>=$confirmtimestamp){								
							$vehicle_subcategory_id=$this->Auth_model->getCustomFields(Tables::RIDE,array('ride_id'=>$ride_id),'vehicle_type_id');
								$subcat_id=$vehicle_subcategory_id->row()->vehicle_type_id;
                               $cancellation_charge= $this->Auth_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('id'=>$subcat_id),'cancellation_fee');
							   //print_r($cancellation_charge); die;
                                if($cancellation_charge->row()->cancellation_fee)
                                    $cancellation_amount= $cancellation_charge->row()->cancellation_fee; 
								
                               $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('cancellation_charge'=>$cancellation_amount));							   
                               $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('status'=>'CANCELLED','cancelled_by'=>$this->user_data->id,'cancellation_time'=>date('Y-m-d H:i:s'),'cancellation_charge'=>$cancellation_amount));
                            }else{
                                $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('status'=>'CANCELLED','cancelled_by'=>$this->user_data->id,'cancellation_time'=>date('Y-m-d H:i:s')));
                            }
                        }                      

                        //$this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('status'=>'CANCELLED','cancelled_by'=>$this->user_data->id,'cancellation_time'=>date('Y-m-d H:i:s'),'cancellation_charge'=>5));
                        $message ="Ride completed successfully";
                        $load = array();
                        $load['title']  = SITE_TITLE;
                        $load['msg']    = 'Your ride has been cancelled by Customer';
                        $load['action'] = 'CANCELLED';
                        $load['ride_id'] = $ride_id;
                        $token = $res->driver_fcm;  
                        $this->common->android_push($token, $load, FCM_KEY);
                    }
                    $message ="Ride cancelled successfully";
                }
            }
            $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),$user_detail);
            //echo $this->db->last_query();
    		$this->response(array("status" => true, 'message'=> $message,'count_ride'=>$res->count_cancelled_ride)); 
        }
    }

    // For update vehicle status
    public function update_vehicle_status_post(){
        if (!empty($this->input->post('vehicle_detail_id'))) {   
           $this->Auth_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$this->user_data->id,'status!='=>3),array('status'=>2));
           $affected= $this->Auth_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$this->user_data->id,'id'=>$this->input->post('vehicle_detail_id')),array('status'=>$this->input->post('status')));
          // $detail_id = $this->input->post('vehicle_detail_id');
           //$affected= $this->Auth_model->update_vehicle_status($detail_id);
            if ( $affected) {  
                if ($this->input->post('status')==2) 
                    $this->response(array("status" => true, 'message'=>'Vehicle is deactivated successfully'));
                else
                    $this->response(array("status" => true, 'message'=>'Vehicle is activated successfully'));
            }else{
               $this->response(array("status" => false, 'message'=>'Invalid request'));
            }
        }else{
            $this->response(array("status" => false, 'message'=>'Invalid request'));
        }
    }

    /* get vehicle detail */
    public function get_vehicle_detail_get(){
        if (!empty($this->input->get('vehicle_detail_id'))) {  
            $query =$this->Auth_model->get_vehicle_detail($this->user_data->id,$this->input->get('vehicle_detail_id'));
            if ( $query->num_rows()>0) {  
                $this->response(array("status" => true, 'data'=>$query->row()));
            }else{
               $this->response(array("status" => false, 'message'=>'Invalid request')); 
            }
        }else{
            $this->response(array("status" => false, 'message'=>'Invalid request'));
        }
    }
    
    /* Assign ride to driver */
    public function assign_ride_to_next_driver($lat,$long,$drop_lat,$drop_long,$ride_id,$distance,$vehicle_type_id){ 
        /*$lat        = $this->input->post('pickup_lat');
        $long       = $this->input->post('pickup_long');
        $drop_long  = $this->input->post('drop_long');
        $drop_long  = $this->input->post('drop_long');
        $user_id    = $this->user_data->id;//$this->input->post('user_i);
        $distance   = $this->input->post('distance');
        $post_data  = $this->input->post();*/   
        $res_query = $this->Auth_model->get_next_driver($lat,$long,$distance,$ride_id,$vehicle_type_id);



       



        //echo $this->db->last_query();die;



        if ($res_query->num_rows()>0) {



            $post_data['driver_id'] = $res_query->row()->user_id;



            $post_data['status'] = 'NOT_CONFIRMED';



            $affected = $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('driver_id'=>$res_query->row()->user_id));



            $post_data['ride_id'] = $ride_id;







            $qry = $this->Auth_model->get_current_ride($ride_id);



            $res = $qry->row();          

                $load = array();
                $load['title']  = SITE_TITLE;
                $load['msg']    = 'You have a new ride';
                $load['action'] = 'PENDING';
                $token = $res->driver_fcm;
                $this->common->android_push($token, $load, FCM_KEY);  



           



            if ($affected) {
                return true;
                //$this->response(array("status" => true, 'message'=>'Ride confirmed.',"ride_detail" =>$res_query->row()));
            }else{
                //$this->response(array("status" => false, 'message'=>'Error occurred, please try after some time',"data" =>''));
                return false;
            }
        }else{
           return false;
        }
    }

    // For update driver status
    public function update_driver_status_post()
    {
        //$this->Auth_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$this->user_data->id),array('status'=>2));
        $driver_detail = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'*');
       
        //$remaining_time = (strtotime(date('Y-m-d H:i:s'))-strtotime($driver_detail->row()->offline_time))/3600;
        //echo $remaining_time;
        if($driver_detail->row()->status==3){
           /*  $total_working_hour = $driver_detail->row()->total_working_hour;           
            $day2 = explode(".", $total_working_hour); 
            $totalmins1= $day2[0] * 60;
            $totalmins1 += $day2[1]; */
            $this->response(array("status" => false, 'message'=>'Your approval is pending. We will update you within 48 hours.','login_time'=>$driver_detail->row()->online_time,'current_time'=>date('Y-m-d H:i:s'),'total_working_hour'=>$this->calculate_Working_hour()));
        }else if($driver_detail->row()->status==4){           
            $this->response(array("status" => false, 'message'=>'Your account deactivated by admin. Please contact to Support@RideShareRates.com','login_time'=>$driver_detail->row()->online_time,'current_time'=>date('Y-m-d H:i:s'),'total_working_hour'=>$this->calculate_Working_hour()));
        }else if($driver_detail->row()->is_online==$this->input->post('is_online')){
            $total_working_hour = $driver_detail->row()->total_working_hour;           
            
            $this->response(array("status" => true, 'message'=>'Successfully','login_time'=>$driver_detail->row()->online_time,'current_time'=>date('Y-m-d H:i:s'),'total_working_hour'=>$this->calculate_Working_hour()));
        }else if(($driver_detail->row()->total_working_hour<43200) && ($this->input->post('is_online')==1)){            
            $affected =$this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('online_time'
             =>date('Y-m-d H:i:s'),'is_online'=>$this->input->post('is_online')));            
            $total_working_hour = $driver_detail->row()->total_working_hour;           
            /* $day2 = explode(".", $total_working_hour);             
            $totalmins1= $day2[0] * 60;
            $totalmins1 += $day2[1]; */            
            $this->response(array("status" => true, 'message'=>'Successfully','login_time'=>$driver_detail->row()->online_time,'current_time'=>date('Y-m-d H:i:s'),'total_working_hour'=>$this->calculate_Working_hour() ));
        }else if(($driver_detail->row()->total_working_hour>43200) && ($this->input->post('is_online')==1)){
            $date1 = strtotime($driver_detail->row()->offline_time);
            $date2 = strtotime(date('Y-m-d H:i:s'));
            $diff = abs($date2 - $date1);
            if($diff>0){
                $affected =$this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('online_time'
                =>date('Y-m:d H:i:s'),'offline_time'=>NULL,'total_working_hour'=>0,'is_online'=>$this->input->post('is_online')));
                $this->response(array("status" => false, 'message'=>'Successfully','login_time'=>$driver_detail->row()->online_time,'current_time'=>date('Y-m-d H:i:s'),'total_working_hour'=>$this->calculate_Working_hour()));
            }else{
                $hour= intdiv($diff,3600);
                $minute= intdiv(($diff-($hour*3600)),60);
                if($minute<10){
                    $current_time = $hour.'.0'.$minute;
                }else{
                    $current_time = $hour.'.'.$minute;
                }
                //$total_working_hour = $driver_detail->row()->total_working_hour;
                $day1 = explode(".", '5.00');
                $day2 = explode(".", $current_time);            
                $totalmins = $day1[0] * 60;
                $totalmins += $day1[1];
                $totalmins1= $day2[0] * 60;
                $totalmins1 += $day2[1];
                $remaining_time = $totalmins-$totalmins1;
                $hour = intdiv($remaining_time,60);
                $minute = $remaining_time % 60; 
                
            $this->response(array("status" => false, 'message'=>'Your 12 hours have been completed. Please take a rest and join start the Ride with RideShareRates after '. $hour.' hours '.$minute.' Minutes','login_time'=>$driver_detail->row()->online_time,'current_time'=>date('Y-m-d H:i:s'),'total_working_hour'=>$this->calculate_Working_hour()));
            }
        }else if($this->input->post('is_online')==3){//offline
            $date1 = strtotime($driver_detail->row()->online_time);
            $date2 = strtotime(date('Y-m-d H:i:s'));
            $total_working_hour = $driver_detail->row()->total_working_hour;
            $diff = (abs($date2 - $date1)+ $total_working_hour);
            $hour= intdiv($diff,3600);
            $minute= intdiv(($diff-($hour*3600)),60);
            if($minute<10){
                $current_time = $hour.'.0'.$minute;
            }else{
                $current_time = $hour.'.'.$minute;
            }
            
           
            /* if($total_working_hour){
                $day1 = explode(".", $total_working_hour);
                $day2 = explode(".", $current_time );
                $totalmins = $day1[0] * 60;
                $totalmins += $day1[1];
                $totalmins += $day2[0] * 60;
                $totalmins += $day2[1];
                $hours = intdiv($totalmins,60);
                $minutes = $totalmins % 60;
                if($minutes<10){
                $totalhours = $hours.'.0'.$minutes;
    
                }else{
                    $totalhours = $hours.'.'.$minutes;
                }
            }else{
                
                $day2 = explode(".", $current_time );
                
                $totalmins = $day2[0] * 60;
                $totalmins += $day2[1];
                $hours = intdiv($totalmins,60);
                $minutes = $totalmins % 60;
                if($minutes<10){
                    $totalhours = $hours.'.0'.$minutes;
    
                }else{
                    $totalhours = $hours.'.'.$minutes;
                }
            }  */
            
           
           // echo $totalhours;
           if($diff<43200){ 
             $affected =$this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('online_time'
             =>date('Y-m:d H:i:s'),'total_working_hour'=>$diff,'is_online'=>$this->input->post('is_online')));
             
           }else if($diff>=43200){
              $affected =$this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('offline_time'
             =>date('Y-m-d H:i:s'),'total_working_hour'=>$diff,'is_online'=>$this->input->post('is_online')));
           }
            
            $this->response(array("status" => true, 'message'=>'Successfully','login_time'=>$driver_detail->row()->online_time,'current_time'=>date('Y-m-d H:i:s'),'total_working_hour'=>$diff));
        }
    



    }
    /* calculate hour */
    public function calculate_Working_hour(Type $var = null)
    {
        $driver_detail = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'*');
        $date1 = strtotime($driver_detail->row()->online_time);
        $date2 = strtotime(date('Y-m-d H:i:s'));
        $total_working_hour = $driver_detail->row()->total_working_hour; 
        $diff = (abs($date2 - $date1)+$total_working_hour);
        $hour= intdiv($diff,3600);
        $minute= intdiv(($diff-($hour*3600)),60);
        $second= (($diff-($hour*3600)-($minute*60)));
        if($minute<10){
            $current_time = $hour.'.0'.$minute;
        }else{
            $current_time = $hour.'.'.$minute;
        }
              
        /* if($total_working_hour){
            $day1 = explode(".", $total_working_hour);
            $day2 = explode(".", $current_time );
            $totalmins = $day1[0] * 60;
            $totalmins += $day1[1];
            $totalmins += $day2[0] * 60;
            $totalmins += $day2[1];
            $hours = intdiv($totalmins,60);
            $minutes = $totalmins % 60;
            if($minutes<10){
            $totalhours = $hours.'.0'.$minutes;

            }else{
                $totalhours = $hours.'.'.$minutes;
            }
        }else{
            
            $day2 = explode(".", $current_time );
            
            $totalmins = $day2[0] * 60;
            $totalmins += $day2[1];
            $hours = intdiv($totalmins,60);
            $minutes = $totalmins % 60;
            if($minutes<10){
            $totalhours = $hours.'.0'.$minutes;

            }else{
                $totalhours = $hours.'.'.$minutes;
            }
        } */
        if($this->input->post('is_online')==3){
            $diff=(integer)$total_working_hour;
        }
        return   $diff;
    }









    /* update profile of driver */

    public function update_profile_of_driver_post()
	{
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('mobile','Contact No','required|max_length[14]');
        $this->form_validation->set_error_delimiters("","");
        if ($this->form_validation->run()==false) {
            $message ="";
            if (form_error('name')) {
                $message = form_error('name');
            }else if(form_error('mobile')){
                $message = form_error('mobile');
            }
            $this->set_response(['status'=>false,'message'=>$message], REST_Controller::HTTP_OK);
        }else{
			$obj = modules::load('admin');
            $affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('name'=>$this->input->post('name'),'mobile'=>$this->input->post('mobile'),'identification_document_id'=>$this->input->post('identification_document_id'),

            'identification_issue_date'=>$this->input->post('identification_issue_date'),

            'identification_expiry_date'=>$this->input->post('identification_expiry_date')));

            if (!empty($_FILES['verification_id']['name'])) {

                $obj->do_upload_profile('verification_document',$this->user_data->id,'verification_id');

            }
            //echo $this->db->last_query();
            if ($affected) {

                $this->set_response(['status'=>true,'message'=>'You profile has been changed successfully'], REST_Controller::HTTP_OK);
            }else{
				
				$this->set_response(['status'=>false,'message'=>'Error occurred, Please try after some time'], REST_Controller::HTTP_OK);
            }
		}
	}



    /* Change ride status */
    public function change_ride_status_post(){
        $ride_id = $this->input->post('ride_id');
        $qry = $this->Auth_model->get_current_ride($ride_id);
        $row = $qry->row();
        if ((string)$row->ride_status == 'CANCELLED') {
           $this->set_response(['status'=>false,'message'=>'Ride has been cancelled already'],REST_Controller::HTTP_OK);
        }else{
            $affected = $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('status'=>$this->input->post('status')));
            if ($affected) {
                if ((string)$this->input->post('status')=='CANCELLED') {
                    $this->set_response(['status'=>true,'message'=>'Ride has been cancelled'], REST_Controller::HTTP_OK);
                }else{
                    $this->set_response(['status'=>true,'message'=>'Ride status has been changed successfully'], REST_Controller::HTTP_OK);
                }
            }else{
                $this->set_response(['status'=>false,'message'=>'Error occurred, Please try after some time'], REST_Controller::HTTP_OK);
            }
        }
    }

    /* */


    // For audio capture
    public function audio_capture_post(){



        //print_r($this->user_data);die;



        if (!is_dir('uploads/audio_capture/')) {



            mkdir('./uploads//audio_capture/', 0777, TRUE);



        }



        $config['upload_path']   = './uploads//audio_capture/'; 



        $config['allowed_types'] = '*'; 



        $config['max_size']      = 10000; 



        //$config['max_width']     = 1024; 



        //$config['max_height']    = 768; 







        $path_info = pathinfo($_FILES['audio']['name']);



        ////echo $path_info['extension'];



        $new_name = time().'ocory_audio';



        //die;



        $config['file_name'] = $new_name; 



        //$config['file_name'] = $_FILES['file']['name'];



        $this->load->library('upload', $config);



        $this->upload->initialize($config);



            



         if ( ! $this->upload->do_upload('audio')) {







            $error = array('error' => $this->upload->display_errors()); 



            $this->set_response(['status'=>false,'message'=>strip_tags($this->upload->display_errors())],REST_Controller::HTTP_OK);

        }else{
			
            $file_array = $this->upload->data();       

            $affected = $this->Auth_model->save(Tables::RIDE_AUDIO,array('user_id'=>$this->user_data->id,'ride_id'=>$this->input->post('ride_id'),'audio_file'=>$file_array['file_name'],'created_date'=>date('Y-m-d H:i:s'),'updated_date'=>date('Y-m-d H:i:s')));

            if ($affected) {

                $this->set_response(['status'=>true,'message'=>'Your audio has been saved successfully'],REST_Controller::HTTP_OK);

            }else{

                $this->set_response(['status'=>false,'message'=>'Error occurred, Please after some time'],REST_Controller::HTTP_OK);

            }         
		} 


	}







    /* update vehicle detail */

    public function update_vehicle_detail_post(){

        if (!empty($this->input->post('vehicle_detail_id'))) {

            $vehicle_arr = array(     

                'brand_id'=>$this->input->post('brand'),

                'model_id'=>$this->input->post('model'),

                'year'=>$this->input->post('year'),

                'color'=>$this->input->post('color'),

                'seat_no'=>$this->input->post('seat_no'),

                'vehicle_no'=>$this->input->post('vehicle_no'),

                'vehicle_type_id'=>$this->input->post('vehicle_type'),

                'license_expiry_date'=>$this->input->post('license_expiry_date'),

                'license_issue_date'=>$this->input->post('license_issue_date'),

                'insurance_issue_date'=>$this->input->post('insurance_issue_date'),

                'insurance_expiry_date'=>$this->input->post('insurance_expiry_date'),
                'premium_facility'         =>$this->input->post('premium_facility'),
                'car_issue_date'=>$this->input->post('car_issue_date'),
                'car_expiry_date'=>$this->input->post('car_expiry_date'),  
                'inspection_issue_date'         =>$this->input->post('inspection_issue_date'),
                'inspection_expiry_date'         =>$this->input->post('inspection_expiry_date'),
                'updated_date'=>date('Y-m-d H:i:s'),

           );

          $affected = $this->Auth_model->update(Tables::VEHICLE_DETAIL,array('id'=>$this->input->post('vehicle_detail_id'),'user_id'=>$this->user_data->id),$vehicle_arr);

            if($affected){  

                $authobj = modules::load('api/auth');

                $this->Auth_model->delete_by_condition(Tables::VEHICLE_SERVICE,array('user_id'=>$this->user_data->id,'vehicle_id'=>$this->input->post('vehicle_detail_id')));

                $authobj->get_vehicle_type_sheet_get($this->input->post('seat_no'),$this->input->post('vehicle_detail_id'),$this->user_data->id);               

                $obj = modules::load('admin');

                if (!empty($_FILES['car_pic']['name'])) {  

                    $obj->do_upload('car_pic',$this->user_data->id,'car_pic',$this->input->post('vehicle_detail_id'));

                }

                if (!empty($_FILES['insurance']['name'])) {

                    $obj->do_upload('insurance_document',$this->user_data->id,'insurance',$this->input->post('vehicle_detail_id'));

                }

                if (!empty($_FILES['license']['name'])) {   

                    $obj->do_upload('license_document',$this->user_data->id,'license',$this->input->post('vehicle_detail_id'));

                }

               /*  if (!empty($_FILES['permit']['name'])) {  

                    $obj->do_upload('permit_document',$this->user_data->id,'permit',$this->input->post('vehicle_detail_id'));

                } */

                /* if (!empty($_FILES['car_pic']['name'])) {

                    $obj->do_upload('car_pic',$this->user_data->id,'car_pic',$this->input->post('vehicle_detail_id'));

                } */

                if (!empty($_FILES['car_registration']['name'])) {

                    $obj->do_upload('car_registration',$this->user_data->id,'car_registration',$this->input->post('vehicle_detail_id'));

                }
                if (!empty($_FILES['inspection_document']['name'])) {
                    $obj->do_upload('inspection_document',$this->user_data->id,'inspection_document',$this->input->post('vehicle_detail_id'));                    
                   
                } 
                $this->set_response(['status'=>true,'message'=>'Your vehicle detail is updated successfully.'],REST_Controller::HTTP_OK);

            }else{

                $this->set_response(['status'=>false,'message'=>'Invalid request.'],REST_Controller::HTTP_OK);

            }  

        }else{

            $this->set_response(['status'=>false,'message'=>'Invalid request.'],REST_Controller::HTTP_OK);

        }

    }







    /* add vehicle detail */

    public function add_vehicle_detail_post(){

        $vehicle_arr = array(   

            'user_id'=>$this->user_data->id,

            'brand_id'=>$this->input->post('brand'),

            'model_id'=>$this->input->post('model'),

            'year'=>$this->input->post('year'),

            'color'=>$this->input->post('color'),

            'status'=>2,

            'seat_no'=>$this->input->post('seat_no'),

            'premium_facility'         =>$this->input->post('premium_facility'),

            'vehicle_no'=>$this->input->post('vehicle_no'),

            'vehicle_type_id'=>$this->input->post('vehicle_type'),

            'license_expiry_date'         =>$this->input->post('license_expiry_date'),

            'license_issue_date'         =>$this->input->post('license_issue_date'),

            'insurance_issue_date'         =>$this->input->post('insurance_issue_date'),

            'insurance_expiry_date'         =>$this->input->post('insurance_expiry_date'),

            'car_issue_date'         =>$this->input->post('car_issue_date'),

            'car_expiry_date'         =>$this->input->post('car_expiry_date'),
            'inspection_issue_date'         =>$this->input->post('inspection_issue_date'),
            'inspection_expiry_date'         =>$this->input->post('inspection_expiry_date'),

            'created_date'=>date('Y-m-d H:i:s'),

            'updated_date'=>date('Y-m-d H:i:s'),

       );

       $vehicle_id = $this->Auth_model->save(Tables::VEHICLE_DETAIL,$vehicle_arr);

        if($vehicle_id){ 

            $obj = modules::load('admin');

            $authobj = modules::load('api/auth');

            $authobj->get_vehicle_type_sheet_get($this->input->post('seat_no'),$vehicle_id,$this->user_data->id);

            if (!empty($_FILES['car_pic']['name'])) { 

                $obj->do_upload('car_pic',$this->user_data->id,'car_pic',$vehicle_id);

            }

            if (!empty($_FILES['insurance']['name'])) {

                $obj->do_upload('insurance_document',$this->user_data->id,'insurance',$vehicle_id);

            }

            if (!empty($_FILES['license']['name'])) {   

                $obj->do_upload('license_document',$this->user_data->id,'license',$vehicle_id);

            }

            if (!empty($_FILES['permit']['name'])) {  

                $obj->do_upload('permit_document',$this->user_data->id,'permit',$vehicle_id);

            }

            if (!empty($_FILES['car_pic']['name'])) {

                $obj->do_upload('car_pic',$this->user_data->id,'car_pic',$vehicle_id);

            }

            if (!empty($_FILES['car_registration']['name'])) {

                $obj->do_upload('car_registration',$this->user_data->id,'car_registration',$vehicle_id);

            }
            if (!empty($_FILES['inspection_document']['name'])) {
                $obj->do_upload('inspection_document',$this->user_data->id,'inspection_document',$vehicle_id);                    
               
            } 

            $this->set_response(['status'=>true,'message'=>'Your vehicle detail is added successfully.'],REST_Controller::HTTP_OK);



        }else{

            $this->set_response(['status'=>false,'message'=>'Invalid request.'],REST_Controller::HTTP_OK);

        } 

    }







    /* set driver destination loation */



    public function set_destination_location_post($value=''){



        $affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('destination_lat'=>$this->input->post('destination_lat'),'destination_long'=>$this->input->post('destination_long')));



        if ($affected) {



            $this->set_response(['status'=>true,'message'=>'Destination location is added successfully'],REST_Controller::HTTP_OK);



        }else{



            $this->set_response(['status'=>false,'message'=>'Invalid request.'],REST_Controller::HTTP_OK);



        }



    }



    /* public function add_service_post(){

        $this->Auth_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$this->user_data->id),array('status'=>2));

        $vehicle_type_id = explode(',',$this->input->post('vehicle_type_id'));

        $this->Auth_model->update_vehicle_status($vehicle_type_id,$this->user_data->id);

        $this->Auth_model->delete_by_condition(Tables::SELECTED_DRIVER_SERVICES,array('user_id'=>$this->user_data->id));

            foreach ($vehicle_type_id as $key => $value) {

                $this->Auth_model->save(Tables::SELECTED_DRIVER_SERVICES,array('vehicle_type_id'=>$value,'user_id'=>$this->user_data->id));

            }

        $this->set_response(['status'=>true,'message'=>'']);



    } */

    // For add service
    public function add_service_post(){
        $this->Auth_model->update(Tables::VEHICLE_SERVICE,array('user_id'=>$this->user_data->id,'id'=>$this->input->post('service_id')),array('status'=>$this->input->post('status'))); 
        $this->set_response(['status'=>true,'message'=>'']);
    }



    /* public function added_vehicle_services_get(){



        $query = $this->db->query("select vt.title,vt.id,



                (select (CASE



                WHEN sds.user_id >0 THEN 'true'                                



                ELSE 'false'



            END) from selected_driver_service as sds where sds.vehicle_type_id =vt.id AND sds.user_id=".$this->user_data->id." ) as status from vehicle_detail as vd 



                    inner join vehicle_type as vt on vt.id=vd.vehicle_type_id 



                    left join selected_driver_service as sds on sds.vehicle_type_id=vd.vehicle_type_id



                    where vd.user_id=".$this->user_data->id." group by vd.vehicle_type_id");



        echo $this->db->last_query();



        if ($query->num_rows()>0) {



            $this->set_response(['status'=>true,'message'=>'','data'=> $query->result()],REST_Controller::HTTP_OK);



        }else{



            $this->set_response(['status'=>false,'message'=>'','data'=>array()],REST_Controller::HTTP_OK);



        }



    } */


    // For add vehicle service
    public function added_vehicle_services_get(){
        $vehicle_query = $this->Auth_model->getCustomFields(Tables::VEHICLE_DETAIL,array('user_id'=>$this->user_data->id,'status'=>1),'id,user_id,brand_id');
         //$data=$vehicle_query->row();
		 //echo($vehicle_query->row()->brand_id); die;
        if($vehicle_query->num_rows()>0){
            $query = $this->Auth_model->get_active_services($this->user_data->id,$vehicle_query->row()->id,$vehicle_query->row()->brand_id);
            
            if($query->num_rows()>0) {
                $this->set_response(['status'=>true,'message'=>'','data'=> $query->result()],REST_Controller::HTTP_OK);
            }else{
                $this->set_response(['status'=>false,'message'=>'test','data'=>array()],REST_Controller::HTTP_OK);
            }
        }else{
            $this->set_response(['status'=>false,'message'=>'','data'=>array()],REST_Controller::HTTP_OK);
        }
    }


    // For getting last ride
    public function get_last_ride_get(){
        $rate_chart = $this->Auth_model->getCustomFields(Tables::RATE_CHART,'1=1','*');
        $rate_chart_row=$rate_chart->row_array();
        $vehicle_query = $this->Auth_model->get_current_active_vehicle($this->user_data->id);
        $user_detail = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'status');
        //print_r($user_detail); die;
		$license_expiry=false;
        $insurance_expiry=false;
        $car_expiry=false;
        $driver_rest_time=false;
        $change_vehicle=false;
        $identification_expiry=false;
        $inspection_expiry=false;
        $vehicle_detail=array();
		
        
        if ($vehicle_query->num_rows()>0) {
            $vehicle_detail = $vehicle_query->row(); 
            if(strtotime($vehicle_detail->license_expiry_date)<strtotime(date('Y-m-d')) || empty($vehicle_detail->license_expiry_date))
                $license_expiry=true;
            if(strtotime($vehicle_detail->insurance_expiry_date)<strtotime(date('Y-m-d')) || empty($vehicle_detail->insurance_expiry_date))
                $insurance_expiry=true;
            if(strtotime($vehicle_detail->car_expiry_date)<strtotime(date('Y-m-d')) || empty($vehicle_detail->car_expiry_date))
                $car_expiry=true;
            if(date('Y')-$vehicle_detail->year>99)
                $change_vehicle=true;                        
            if(strtotime(date('Y-m-d'))>(strtotime($vehicle_detail->inspection_expiry_date))){
                $inspection_expiry=true;
            } 
        }
        $login_query = $this->db->query("SELECT user_id,identification_expiry_date,login_time,gcm_token as driver_fcm_token FROM ".Tables::USER." WHERE user_id=".$this->user_data->id);         
        
       $query =$this->Auth_model->get_last_ride($this->user_data);
       if ($query->num_rows()>0) {
            $row = $query->row();
		
		$getmobile='0';		
        $amount = $row->amount;
        
            if ($this->user_data->utype==2) {
                //$amount=  $row->amount-($row->amount*($rate_chart_row[lcfirst($row->dayname)]/100));
				$taxeble_amount =($row->amount*($row->AdminRide_charges/100));
                $amount =$row->amount-number_format($taxeble_amount,2, '.', '');
            }
            
			
			if($this->user_data->utype==2){
				$get_mobile=$this->Auth_model->get_mobile($row->user_id);
				if ($get_mobile->num_rows()>0) {
				$mobile = $get_mobile->row();
				$getmobile=$mobile->mobile;
				}
			}
			if($this->user_data->utype==1){
				$get_mobile=$this->Auth_model->get_mobile($row->driver_id);
				if ($get_mobile->num_rows()>0) {
				$mobile = $get_mobile->row();
				$getmobile=$mobile->mobile;
				}
			}
			
            //unset($row->amount);
            //$row->amount =str_replace(',', '',number_format($amount,2));
			//print_r($row->amount); die;
            if (!empty($row->total_driver_ride)) {
                $total_rating=($row->total_rating/$row->total_driver_ride);
            }else{
                $total_rating=0;
            }   
            $authObj = modules::load('api/auth');
            
            //$api_data= $authObj->get_distance1($row->pickup_lat,$row->pickup_long,$row->drop_lat,$row->drop_long);
            
            //$api_driving_data= $authObj->get_distance1($row->pickup_lat,$row->pickup_long,$row->latitude,$row->longitude);
            //print_r( $api_driving_data);die;
			 $vehicle_image_query = $this->Auth_model->get_current_active_vehicle_image($row->driver_id);
                
				//$vehicle_img=
				if ($vehicle_image_query->num_rows()>0) {
					$car_row = $vehicle_image_query->row();
					$vehicle_img=$car_row->car_pic;
					if(!empty($vehicle_img)){
						$vehicle_pic= base_url('uploads/car_pic/'.$car_row->user_id.'/'.$vehicle_img);
					}else{                
					$vehicle_pic= base_url('uploads/no-vehicle.jpg');
					}
				}
				
				$total_amount=(string)preg_replace('/[^0-9\.]/ui','',$amount);
				//echo $total_amount; die;
				$row->mobile= $getmobile;	
			//(string)$tamount;	
			$row->total_amount = bcadd($total_amount,0,2);
            $row->total_rating = (string)bcadd(0,( $total_rating), 1);
            // $row->total_time =  (string)$api_data['time'];
            // $row->total_distance =(string)$api_data['distance'];
            // $row->total_arrival_distance =(string)$api_driving_data['distance'];
            // $row->total_arrival_time =(string)$api_driving_data['time']; 
			$row->vehicle_image =$vehicle_pic;
			
			#---Log Section start--
			$obj = modules::load('admin');
			$obj->custom_log('API',' get_last_ride, User Id: '.$this->user_data->id.', GOOGLE API Key '.MAPBOX_API_KEY);
			#--log End --
           $this->set_response(['status'=>true,'user_status'=>$user_detail->row()->status,'license_expiry'=>$license_expiry,'insurance_expiry'=>$insurance_expiry,'car_expiry'=>$car_expiry,'driver_rest_time'=>$driver_rest_time,'change_vehicle'=>$change_vehicle,'identification_expiry'=>$identification_expiry,'inspection_expiry'=>$inspection_expiry,'message'=>'','data'=>$row,'document_approval'=>$vehicle_detail],REST_Controller::HTTP_OK);
       }else{
            $this->set_response(['status'=>false,'user_status'=>$user_detail->row()->status,'license_expiry'=>$license_expiry,'insurance_expiry'=>$insurance_expiry,'car_expiry'=>$car_expiry,'driver_rest_time'=>$driver_rest_time,'change_vehicle'=>$change_vehicle,'identification_expiry'=>$identification_expiry,'inspection_expiry'=>$inspection_expiry,'message'=>'','data'=> $query->result(),'document_approval'=>$vehicle_detail],REST_Controller::HTTP_OK);
       }
    }






    // For received payment
    public function payment_as_recieved_post()
    {
        $driver_id = $this->user_data->id;

        $ride_id = $this->input->post('ride_id');

        $user_query = $this->Auth_model->get_current_ride($ride_id);

        if($user_query->num_rows()>0){

            $row = $user_query->row(); 

            $affected = $this->Auth_model->update(Tables::RIDE,array('ride_id'=>$ride_id),array('payment_mode'=>'CASH','payment_status'=>'COMPLETED'));


            $this->Auth_model->update(Tables::USER,array('user_id'=>$driver_id),array('is_online'=>$this->input->post('driver_status')));



            $load = array();



            /* $load['title']  = SITE_TITLE;



             $load['msg']    = 'Payment has been paid Successfully';



             $load['action'] = 'FEEDBACK';                



             $token =  $user_query->row()->gcm_token;                



             $this->common->android_push($token, $load, FCM_KEY);*/







             $user_query = $this->Auth_model->get_current_ride($ride_id);



             $load = array();



             $load['title']  = SITE_TITLE;



             $load['msg']    = 'Payment has been paid Successfully';



             $load['action'] = 'FEEDBACK';                



             $token =  $user_query->row()->user_fcm;                



             $this->common->android_push($token, $load, FCM_KEY);







             $load['title']  = SITE_TITLE;



             $load['msg']    = 'Payment has been received successfully.';



             $load['action'] = 'FEEDBACK';                



             $token =  $user_query->row()->driver_fcm;



             $this->common->android_push($token, $load, FCM_KEY);



            if ($affected) {



                $this->set_response(['status'=>true,'message'=>'Payment has been received successfully.'],REST_Controller::HTTP_OK);



            }



        }else{



            $this->set_response(['status'=>false,'message'=>'Please try after some time'],REST_Controller::HTTP_OK);



        }



           



    }



    ///gram post -chhota vidyapur thana adalhat distic - mirjapur
    //Question category
	public function get_question_category_get()
	{

		$query = $this->Auth_model->getCustomFields(Tables::QUESTION_CATEGORY,array('status'=>1,'user_type'=>$this->user_data->utype),'*');
		$res=$query->result();

		if ($query->num_rows()>0) {

		   $this->set_response(['status'=>true,'message'=>'','data'=>$res],REST_Controller::HTTP_OK);  

		} else{
			$this->set_response(['status'=>false,'message'=>'Please try after some time'],REST_Controller::HTTP_OK);

		}

	}

	// For getting answer of the question
	public function get_question_answer_get()

	{

		$query = $this->Auth_model->getCustomFields(Tables::QUESTION,array('question_category_id'=>$this->input->get('question_category_id')),'*');
		$res=$query->result();

		if ($query->num_rows()>0) {

		   $this->set_response(['status'=>true,'message'=>'','data'=>$res],REST_Controller::HTTP_OK);  

		} else{
			$this->set_response(['status'=>false,'message'=>'Please try after some time'],REST_Controller::HTTP_OK);

		}

	}

	/* save answer */
	public function save_answer_post()
	{
		$this->form_validation->set_rules('answer','Answer','required');
		$this->form_validation->set_error_delimiters("","");
		if ($this->form_validation->run()==false) {
			$this->set_response(['status'=>false,'message'=>form_error('answer')]);
		}else{
			$answer_arr = array(
				'user_id'=>$this->user_data->id,
				'ride_id'=>($this->input->post('ride_id'))?$this->input->post('ride_id'):NULL,
				'question_id'=>$this->input->post('question_id'),
				'answer'=>$this->input->post('answer'),
				'updated_date'=>date('Y-m-d H:i:s'),
				'created_date'=>date('Y-m-d H:i:s'),
			);
			$answer_id = $this->Auth_model->save(Tables::USER_ANSWER,$answer_arr);
			if($answer_id){
				$user_query= $this->Auth_model->get_question_answer($answer_id);
				//print_r($user_query->row()); die;
				$this->help_section_mail($user_query->row());
				$this->set_response(['status'=>true,'message'=>'Your answer has been saved successfully']);
			}else{
				$this->set_response(['status'=>false,'message'=>'Your answer has not been saved']);
			}
		}
	}

	/* get status of vehicle */
	public function approval_document_status_get()
	{
		$user_query = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'*');
		$vehicle_query = $this->Auth_model->getCustomFields(Tables::VEHICLE_DETAIL,array('user_id'=>$this->user_data->id,'status'=>1),'id,license_approve_status,insurance_approve_status,car_registration_approve_status,inspection_approval_status,inspection_expiry_date,year,car_expiry_date,insurance_expiry_date,license_expiry_date');
		$result=array();
		$license_expiry=false;
		$insurance_expiry=false;
		$car_expiry=false;
		$driver_rest_time=false;
		$change_vehicle=false;
		$identification_expiry=false;
		$inspection_expiry=false;
	   
		if($vehicle_query->num_rows()>0)
		{
			$row=$vehicle_query->row();         
			if(strtotime($row->license_expiry_date)<strtotime(date('Y-m-d')) || empty($row->license_expiry_date))
				$license_expiry=true;
			if(strtotime($row->insurance_expiry_date)<strtotime(date('Y-m-d')) || empty($row->insurance_expiry_date))
				$insurance_expiry=true;
			if(strtotime($row->car_expiry_date)<strtotime(date('Y-m-d')) || empty($row->car_expiry_date))
				$car_expiry=true;
			if(date('Y')-$row->year>99)
				$change_vehicle=true;  
			/*
			if(strtotime(date('Y-m-d H:i:s'))>(strtotime($user_query->row()->identification_expiry_date))){
				$identification_expiry=true;
			}  */     
			$result =array(
				'license_approve_status'=>$row->license_approve_status,
				'insurance_approve_status'=>$row->insurance_approve_status,
				'car_registration_approve_status'=>$row->car_registration_approve_status,                
				'inspection_approval_status'=>$row->inspection_approval_status,
				'inspection_expiry'=>$inspection_expiry,
				'change_vehicle'=>$change_vehicle, 
				'car_expiry'=>$car_expiry, 
				'insurance_expiry'=>$insurance_expiry,
				'insurance_expiry'=>$insurance_expiry,
				'license_expiry'=>$license_expiry,  
				'identification_expiry'=>$identification_expiry           
			);
			
			$this->set_response(['status'=>true,'data'=>$result,'verification_id_approval_atatus'=>$user_query->row()->verification_id_approval_atatus,'background_approval_status'=>$user_query->row()->background_approval_status]);
		}else{
			$this->set_response(['status'=>false,'data'=>$result]);

		}

	}
	/* delete account */
	public function deleteAccount_get()
	{
		if($this->user_data->utype==2){ // Driver
			$query = $this->Auth_model->getCustomFields(Tables::RIDE,array('driver_id'=>$this->user_data->id),'ride_id');
			if($query->num_rows()>0){
				foreach($query->result() as $row){
					$this->Auth_model->delete_by_condition(Tables::PAYMENT_HISTORY,array('ride_id'=>$row->ride_id));
					$this->Auth_model->delete_by_condition(Tables::RIDE_AUDIO,array('ride_id'=>$row->ride_id));
					$this->Auth_model->delete_by_condition(Tables::CANCELLED_RIDE,array('ride_id'=>$row->ride_id));
					$this->Auth_model->delete_by_condition(Tables::USER_ANSWER,array('ride_id'=>$row->ride_id));
					$this->Auth_model->delete_by_condition(Tables::FEEDBACK,array('ride_id'=>$row->ride_id));
					$this->Auth_model->delete_by_condition(Tables::RIDE,array('ride_id'=>$row->ride_id));
				}
			}
			$this->Auth_model->delete_by_condition(Tables::VEHICLE_SERVICE,array('user_id'=>$this->user_data->id));
			$this->Auth_model->delete_by_condition(Tables::VEHICLE_DETAIL,array('user_id'=>$this->user_data->id));
			$this->Auth_model->delete_by_condition(Tables::DRIVER_ACCOUNT_DETAIL,array('user_id'=>$this->user_data->id));
			$this->Auth_model->delete_by_condition(Tables::USER,array('user_id'=>$this->user_data->id));        
		}else{
			$this->Auth_model->update(Tables::RIDE,array('user_id'=>$this->user_data->id),array('user_id'=>NULL));
			$this->Auth_model->delete_by_condition(Tables::CARD_DETAIL,array('user_id'=>$this->user_data->id));
			$this->Auth_model->delete_by_condition(Tables::RIDE_AUDIO,array('user_id'=>$this->user_data->id));
			$this->Auth_model->delete_by_condition(Tables::USER_ANSWER,array('user_id'=>$this->user_data->id));
			$this->Auth_model->delete_by_condition(Tables::USER,array('user_id'=>$this->user_data->id));
		}
		
		$this->set_response(['status'=>true,'message'=>'Account has been deleted successfully']);
	}
	
	public function inactive_account_get(){
		$is_affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('is_deleted'=>'1','status'=>'3','is_online'=>'3','is_logged_in'=>'2'));
		if($is_affected){
			$this->set_response(['status'=>true,'message'=>'Account has been deleted successfully']);
		}
		
	}

	public function getBankDetails_get(){
		//$result=[];
		if($this->user_data->utype==2){ // Driver
			$query = $this->Auth_model->getCustomFields(Tables::DRIVER_ACCOUNT_DETAIL,array('user_id'=>$this->user_data->id),'*');
			
			if($query->num_rows()>0)
			{
				$row = $query->row();			 
				$result =array(
					'user_id'=>$row->user_id,
					'account_holder_name'=>encrypt_decrypt('decrypt',$row->account_holder_name),
					'bank_name'=>encrypt_decrypt('decrypt',$row->bank_name),
					'routing_number'=>encrypt_decrypt('decrypt',$row->routing_number),                
					'account_number'=>encrypt_decrypt('decrypt',$row->account_number),					
					'status'=>$row->status
				);
				
				$this->set_response(['status'=>true,'data'=>$result]);
			}else{
				
				$result =array(
					'user_id'=>"",
					'account_holder_name'=>"",
					'bank_name'=>"",
					'routing_number'=>"",                
					'account_number'=>"",					
					'status'=>""
				);
				
				$this->set_response(['status'=>true,'data'=>$result]);

			}
		}else{
				$this->set_response(['status'=>false,'message'=>' you are not authonticate to access this']);

			}
		
	}
	
	
	
	public function give_feedbackForRider_post()
    {
        $feedback_arr = array(
            'rider_id'       => $this->input->post('rider_id'),
            'ride_id'       => $this->input->post('ride_id'),
            'rating'        => $this->input->post('rating'),
            'comment'       => $this->input->post('comment'),
            'created_date'  => date('Y-m-d H:i:s'),
            'updated_date'  => date('Y-m-d H:i:s'),
        );
        $feedback_id = $this->Auth_model->save(Tables::RIDER_FEEDBACK,$feedback_arr);
        $user_detail = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->input->post('rider_id')),'gcm_token');
        if($this->input->post('rating')==5){
            $load = array();
            $load['title']  = SITE_TITLE;
            $load['msg']    = 'Excellent';
            $load['action'] = 'feedback';
            $token = $user_detail->row()->gcm_token;  
            $this->common->android_push($token, $load, FCM_KEY);
        }
        if ($feedback_id) {

           $this->set_response(array('status'=>true,'message'=>'Your feedback has been saved successfully'), REST_Controller::HTTP_OK);

        }else{

            $this->set_response(array('status'=>false,'message'=>'Error occurred, Please try after some time'), REST_Controller::HTTP_OK);

        }

    }
	
	
	
	/* public function driverCurrentLocation_post()
    {	
	//print_r($this->input->post()); die;
		if($this->user_data->utype==2){ // Driver
				
				$id		= $this->user_data->id;
				$latitude	= $this->input->post('latitude');
				$longitude 	= $this->input->post('longitude');            
			//print_r($data); die;
			
			$user_detail = $this->Auth_model->upddriver_location($id,$latitude,$longitude);
			
			if($user_detail){
				
			   $this->set_response(array('status'=>true,'message'=>'Your Location  has been updated successfully'), REST_Controller::HTTP_OK);
			}else{
				$this->set_response(array('status'=>false,'message'=>'Error occurred, Please try after some time'), REST_Controller::HTTP_OK);
			}
		}else{
			$this->set_response(array('status'=>false,'message'=>'Error occurred, invalid driver details'), REST_Controller::HTTP_OK);
		}

    } */
	
	
	 
 

}