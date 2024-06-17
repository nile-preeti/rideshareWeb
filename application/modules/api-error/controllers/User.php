

<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class User extends BD_Controller {
    function __construct()
    {
        parent::__construct();
        $this->auth();
        $this->load->model(array('api/Auth_model'));
        $this->load->library(array('common/common'));
        $this->load->helper(array('common/common'));
    }
    


    // For fcm token testing
    public function test_fcm_post($value='')

    {

        $load = array();

        $load['title']  = SITE_TITLE;

        $load['msg']    = 'You have a new ride';

        $load['action'] = 'PENDING';

        $token = $this->input->post('token');  
        $this->common->android_push($token, $load, FCM_KEY);

    }

    

    /* get driver near by */

    public function nearby_get() {

        $result=array();

        $res = $this->Auth_model->get_nearby_driver();

        if ($res->num_rows()>0) {

           $result = $res->result();

        }

        $fares = $this->db->get_where("settings", array("name" => "FARE"));

        $unit = $this->db->get_where("settings", array("name" => "UNIT"));

        //echo $this->db->last_query();

        $this->response(array("status" => true, "fair" => array("cost" => $fares->result()[0]->value, "unit" => $unit->result()[0]->value), "data" =>$result));

    }



    /* Give feedback */
    public function give_feedback_post()
    {
        $feedback_arr = array(
            'driver_id'       => $this->input->post('driver_id'),
            'ride_id'       => $this->input->post('ride_id'),
            'rating'        => $this->input->post('rating'),
            'comment'       => $this->input->post('comment'),
            'created_date'  => date('Y-m-d H:i:s'),
            'updated_date'  => date('Y-m-d H:i:s'),
        );
        $feedback_id = $this->Auth_model->save(Tables::FEEDBACK,$feedback_arr);
        $user_detail = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->input->post('driver_id')),'gcm_token');
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

    /* Get vehicle type */


            /* (
            CASE WHEN DAYNAME(time)='Sunday' THEN 'sunday'
            WHEN DAYNAME(time)='Monday' THEN 'monday'
            WHEN DAYNAME(time)='Tuesday' THEN 'tuesday'
            WHEN DAYNAME(time)='Thursday' THEN 100*0.6
            WHEN DAYNAME(time)='Friday' THEN 'friday'
            WHEN DAYNAME(time)='Saturday' THEN 'saturday'

            ELSE 'sunday' 
            END) as day_name */


    public function getVehicleType_post()

    {

        $res = $this->Auth_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1,"rate!="=> "0.00"),'id,title,rate,short_description');

        $distance = $this->getDistance();

        $result_data = $res->result();



        $result_data['distance']  = $distance;

        $this->response(array("status" => true, 'message'=>'',"data" => $res->result(),'distance'=> bcadd(0,$distance,1),'unit'=>'KM'));

    }



    /* distance */    

    public function getDistance() 

    {
        $longitudeFrom = $this->input->post('longitudeFrom');

        $longitudeTo = $this->input->post('longitudeTo');

        $latitudeFrom = $this->input->post('latitudeFrom');

        $latitudeTo = $this->input->post('latitudeTo');

        $long1 = deg2rad($longitudeFrom); 

        $long2 = deg2rad($longitudeTo); 

        $lat1 = deg2rad($latitudeFrom); 

        $lat2 = deg2rad($latitudeTo);            

        //Haversine Formula 

        $dlong = $long2 - $long1; 

        $dlati = $lat2 - $lat1;           

        $val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2);
		
		$res = 2 * asin(sqrt($val)); 
		
		$radius = 3958.756;            

        return ($res*$radius*1.60934);

    }



    /* post ride to driver */

    public function postRideToDriver_post(){
		
		//$obj = modules::load('admin');
		
        $card_detail = $this->Auth_model->getCustomFields(Tables::CARD_DETAIL,array('user_id'=>$this->user_data->id,'is_default'=>1),'*');
        if($card_detail->num_rows()>0){
            $expiry_date = $card_detail->row()->expiry_date.'-'.$card_detail->row()->expiry_month;
            //echo strtotime($expiry_date);
            //echo strtotime(date('Y-m'));
            if(strtotime($expiry_date)<strtotime(date('Y-m'))){
                $this->response(array("status" => false, 'message'=>'Your card has been expired'));
            }
        }
		
        $user_detail_query = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'identification_expiry_date,profile_upload_date,status');
        if($user_detail_query->num_rows()>0){
			
            $user_detail = $user_detail_query->row();			
			
			if($user_detail->status==4){
                $this->response(array("status" => false, 'message'=>'your profile is inactive please contact to ridesharerates@gmail'));
            }
        }

        $this->form_validation->set_rules('pickup_lat','Error','required');
        $this->form_validation->set_rules('pickup_long','Error','required');
        $this->form_validation->set_rules('drop_lat','Error','required');
        $this->form_validation->set_rules('drop_long','Error','required');
        $this->form_validation->set_rules('drop_locatoin','Error','required');
        $this->form_validation->set_rules('pikup_location','Error','required');
        $this->form_validation->set_rules('drop_address','Error','required'); 
        $this->form_validation->set_rules('pickup_adress','Error','required'); 
        $this->form_validation->set_rules('txn_id','Error','required'); 
        if($this->form_validation->run()==false) 
        {
            $this->response(array("status" => false, 'message'=>'Enter valid location'));
            return true;
        } 
        $lat        = $this->input->post('pickup_lat');
        $long       = $this->input->post('pickup_long');
        $drop_lat  = $this->input->post('drop_lat');
        $drop_long  = $this->input->post('drop_long');
        $user_id    = $this->user_data->id;//$this->input->post('user_id');
        $distance   = $this->input->post('distance');
        $post_data  = $this->input->post();
        //print_r($post_data);return true;
        $vehicle_arr = $this->Auth_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('status'=>1,'id'=>$post_data['vehicle_type_id']),'*');
        $data=$vehicle_arr->result();
       
        $res_query = $this->Auth_model->getDriverFromUser($lat,$long,$distance,$post_data['vehicle_type_id']);
        $vehicle_type_id=$post_data['vehicle_type_id'];
		
        $authObj = modules::load('api/auth');
       
        if ($res_query->num_rows()>0) {
				$rates = $this->db->get(Tables::VEHICLE_SUBCATEGORY_TYPE)->row();
			
			//print_r($rates);die;
            $address_detail = $authObj->getAddressDetail($lat,$long);
            $drop_address_detail = $authObj->getAddressDetail($drop_lat,$drop_long);
            $post_data['driver_id'] = $res_query->row()->user_id;
            $post_data['status'] = 'NOT_CONFIRMED';
            $post_data['payment_status'] = 'PENDING';
            $post_data['city'] = $address_detail['city'];
            $post_data['state'] = $address_detail['state'];
            $post_data['time'] = date('Y-m-d H:i:s');
			$post_data['AdminRide_charges']=$data[0]->admin_charges;
            $post_data['country'] = $address_detail['country'];
            $post_data['drop_city'] = $drop_address_detail['city'];
            $post_data['drop_state'] = $drop_address_detail['state'];
            $post_data['drop_country'] = $drop_address_detail['country'];
            $post_data['base_fare_fee'] = $data[0]->base_fare_fee;
            $post_data['surcharge_fee'] = $data[0]->surcharge_fee;
            $post_data['taxes'] = $data[0]->taxes;
            $post_data['permile_rate'] = $data[0]->rate;
            $post_data['vehicle_category_id'] = $data[0]->vehicle_type_category_id;
            $post_data['vehicle_name'] = $data[0]->title;
            $post_data['cancellation_charge'] = $data[0]->cancellation_fee;
            //print_r($res_query->row());
            //echo $this->db->last_query();die;
            $post_data['vehicle_type_id'] = $vehicle_type_id;
            $post_data['is_destination_ride'] =  $res_query->row()->is_destination_ride;
            $post_data['distance'] =  bcadd($distance,1,2);
			
            $ride_id = $this->Auth_model->save(Tables::RIDE,$post_data);
            $post_data['ride_id'] = $ride_id;
			
            if ($ride_id) {
                $res_query->row()->ride_id = $ride_id;
                $res_query->row()->amount = $this->input->post('amount');
                $qry = $this->Auth_model->get_current_ride($ride_id);
                //echo $this->db->last_query();die;
                $res = $qry->row();
                if (!empty($res_query->row()->total_driver_ride)) {
                    $total_rating=($res_query->row()->total_rating/$res_query->row()->total_driver_ride);
                }else{
                    $total_rating=0;
                }
                //$api_data= $authObj->get_distance($res->pickup_adress,$res->drop_address);
                $api_data= $authObj->get_distance1($lat,$long,$drop_lat,$drop_long);
               
                if ($res->is_destination_ride==1) {
                    $api_driving_data= $authObj->get_distance1($lat,$long,$res_query->row()->destination_lat,$res_query->row()->destination_long);
					
					
                }else{
                    $api_driving_data= $authObj->get_distance1($lat,$long,$res_query->row()->latitude,$res_query->row()->longitude);
					
                }
                //print_r( $api_driving_data);die;
                $res_query->row()->total_rating = bcadd(0,( $total_rating), 1);

                $res_query->row()->total_time =  $api_data['time'];

                $res_query->row()->total_distance =$api_data['distance'];

                $res_query->row()->total_arrival_distance =$api_driving_data['distance'];

                $res_query->row()->total_arrival_time =$api_driving_data['time'];

                $res_query->row()->ride_status = $res->ride_status;

                $load = array();

                $load['title']  = SITE_TITLE;

                $load['msg']    = 'You have a new ride';

                $load['action'] = 'PENDING';

                $load['ride_id'] = $ride_id;

                $token = $res->driver_fcm;                

                $this->common->android_push($token, $load, FCM_KEY);
				
				#---Log Section start--
					#---Log Section start--
			//$obj = modules::load('admin');
			//$obj->custom_log('API',' PostRidetodriver, User Id: '.$this->user_data->id.', GOOGLE API Key '.GOOGLE_MAP_API_KEY);
			#--log End --
				#--log End --
				
                $this->response(array("status" => true, 'message'=>'Ride confirmed.',"ride_detail" =>$res_query->row()));

            }else{

                $this->response(array("status" => false, 'message'=>'Error occurred, please try after some time1',"data" =>''));

            }

        }else{

            $this->response(array("status" => false, 'message'=>'Driver was not found in your area',"data" =>''));

        }

    }

    /* Upload document */

    public function uploadDocument_post()

    {

        $obj = modules::load('admin');

        $theCredential = $this->user_data; 

        $user_id = $theCredential->id;



        $obj->do_upload('insurance_document',$user_id,'insurance');

            /*$this->response(array("status" => true, 'message'=>'Document uploaded successfully',"data" =>''));

        }else{

            $this->response(array("status" => false, 'message'=>'Error occurred, please try after some time',"data" =>''));

        }*/

        $obj->do_upload('license_document',$user_id,'license');

            /*$this->response(array("status" => true, 'message'=>'Document uploaded successfully',"data" =>''));

        }else{

            $this->response(array("status" => false, 'message'=>'Error occurred, please try after some time',"data" =>''));

        }*/

        $obj->do_upload('permit_document',$user_id,'permit');

            /*$this->response(array("status" => true, 'message'=>'Document uploaded successfully',"data" =>''));

        }else{

            $this->response(array("status" => false, 'message'=>'Error occurred, please try after some time',"data" =>''));

        }*/

        if (!empty($_FILES['car_pic']['name'])) {

            $this->do_upload('car_pic',$id,'car_pic');

        }

        $this->response(array("status" => true, 'message'=>'Document uploaded successfully',"data" =>''));

       

    }


    // For getting rides data
    public function rides_get() {        
        $id = $this->input->get('id');
        $status = $this->input->get('status');
        $utype = $this->input->get('utype');
        $per_page =$this->input->get('per_page');
        $rate_chart = $this->Auth_model->getCustomFields(Tables::RATE_CHART,'1=1','*');
        $rate_chart_row=$rate_chart->row_array();
        $start =$this->input->get('page_no')*$per_page-$per_page;

        $limit =$start-$per_page;
    
        $earning_detail = $this->Auth_model->get_total_earning($this->user_data);
		
		//print_r($earning_detail->result()); die;
        //$query = $this->Auth_model->payment_history($user_data);
        if (($status=='CANCELLED') && ($this->user_data->utype==2)) {
            $res =$this->Auth_model->getRejectedRide($this->user_data,$start,$per_page);
            //echo $this->db->last_query();
            $res1 =$this->Auth_model->getRide($this->user_data,null,null);
        }else{
            $res =$this->Auth_model->getRide($this->user_data,$start,$per_page);
            //echo $this->db->last_query();
            $res1 =$this->Auth_model->getRide($this->user_data,null,null);
        }
        ///echo $this->db->last_query();
        $ride_detail =array();
        $total_earning = 0;
        if ($res->num_rows()>0) {
            foreach ($res->result() as $row) {
				//print_r($row);die; 
                if($this->user_data->utype==2){                   
                    
                    $total_earning+=$row->amount-((int)$row->amount*($row->AdminRide_charges/100));
                }else
                    $total_earning+=$row->amount;
                    
				if($row->distance>0){
					$distance=$row->distance;
				}else{
					$distance=0;
				}
				//$totalmount=0;
				$totalmount =($this->user_data->utype==2)?number_format($row->amount-($row->amount*($row->AdminRide_charges/100)),2) :$row->amount;
				$tipamt=(string)preg_replace('/[^0-9\.]/ui','', $row->tip_amount);
				$total_amount=(string)preg_replace('/[^0-9\.]/ui','',$totalmount);
				$trip_charge= $row->distance* $row->permile_rate;
				$booking_charge= $row->base_fare_fee+$row->surcharge_fee;
				$taxeble_amount=$booking_charge+$trip_charge;
				$tax_charge= (int)$taxeble_amount*($row->taxes/100);
				
				$cancelcharge=0.0;
				$cancelcharge+=$row->cancellation_charge;
				
				
				
				$vehicle_query = $this->Auth_model->getCustomFields(Tables::VEHICLETYPE,array('id'=>$row->vehicle_category_id),'title');
             
             if($vehicle_query->num_rows()){
                $data=$vehicle_query->row();
				$vehicle_cat_name=$data->title;
			 }else{
				 $vehicle_cat_name=""; 
			 }
			//echo  $row->vehicle_category_id;
				if(($row->is_technical_issue!="Yes") && ($row->is_technical_issue!="No") ){
					$ride_detail[] = array(
						"ride_id"=> $row->ride_id,
						"user_id"=> $row->user_id,
						"driver_id"=> $row->driver_id,
						"pickup_adress"=> $row->pickup_adress,
						"drop_address"=> $row->drop_address,
						"pikup_location"=> $row->pikup_location,
						"short_pick_address"=> ($row->city)?$row->city.', '.$row->state.', '.$row->country:$row->pickup_adress,
						"short_drop_address"=> ($row->drop_city)?$row->drop_city.', '.$row->drop_state.', '.$row->drop_country:$row->drop_address,                   
						"pickup_lat"=> $row->pickup_lat,
						"pickup_long"=> $row->pickup_long,
						"drop_locatoin"=> $row->drop_locatoin,
						"drop_lat"=> $row->drop_lat,
						"drop_long"=> $row->drop_long,
						"distance"=> $row->distance,
						"cancellation_charge"=> (string)$cancelcharge,
					    "status"=> $row->status,
						"payment_status"=> $row->payment_status,
						"pay_driver"=> $row->pay_driver,
						"is_technical_issue"=> $row->is_technical_issue,
						"tip_amount"=>bcdiv($tipamt,1,2),
						"payment_mode"=> $row->payment_mode,
						"amount"=> bcdiv($total_amount,1,2),
						"trip_fare"=>(string)$row->base_fare_fee,
						"subtotal"=>(string)$trip_charge,
						"booking_fee"=>(string)$row->surcharge_fee,
						"tax_charge"=>(string)$tax_charge,					
						"time"=> date('m/d/y h:i A', strtotime($row->time)),
						"user_mobile"=> $row->user_mobile,
						"user_avatar"=> $row->user_avatar,
						"driver_avatar"=> $row->driver_avatar,
						"user_name"=> $row->user_name,
						"user_lastname"=> ($row->user_lastname)?$row->user_lastname:'',
						"user_titlename"=>($row->user_titlename)?$row->user_titlename:'',
						"driver_mobile"=> $row->driver_mobile,
						"driver_name"=>($row->driver_name)?$row->driver_name:'',
						"driver_title_name"=>($row->driver_title_name)?$row->driver_title_name:'',
						"driver_lastname"=>($row->driver_lastname)?$row->driver_lastname:'',
						"permile_rate"=> $row->permile_rate,
						"base_fare_fee"=> $row->base_fare_fee,
						"surcharge_fee"=> $row->surcharge_fee,
						"vehicle_name"=> $row->vehicle_name,
						"category_name"=> $vehicle_cat_name,
					);
				}
            }

        }  
		$tech_issue='';
		$tech_issue=$earning_detail->row()->earning_amount;
		if(($tech_issue=="Yes") && ($tech_issue=="No") ){
			$tech_issue;
		}
		
		//$obj->custom_log('info','This is Get Ride APi.'.json_encode($res->num_rows()));	
		
		// #---Log Section start--
		 	$obj = modules::load('admin');
		 	$obj->custom_log('API',' Get_Ride, User Id: , GOOGLE API Key '.GOOGLE_MAP_API_KEY);
		// 	#--log End --
        $this->set_response(array('status'=>true,'total_record'=>$res->num_rows(),'total_earning'=>number_format($tech_issue,1),'data'=> $ride_detail),REST_Controller::HTTP_OK); 
        //$this->response(array("status" => true, "data" => $ride_detail));

    }
    
        // For getting earn data
    public function earn_get() {
        $driver_id =$this->user_data->id;
        
        if (!empty($driver_id)) {
            
            $usermcount = [];
            $userArr = [];
            $rate_chart = $this->Auth_model->getCustomFields(Tables::RATE_CHART,'1=1','*');
            $rate_chart_row=$rate_chart->row_array();
            if($this->input->get('year')){
                $qry = $this->db->query("SELECT ph.amount as ph_amount,MONTH(ph.date) as 'month_name',DAYNAME(ph.date),sum(
                    CASE WHEN DAYNAME(ph.date)='Sunday' THEN ph.amount-(ph.amount*(r.AdminRide_charges/100))
                    WHEN DAYNAME(ph.date)='Monday' THEN ph.amount-(ph.amount*(r.AdminRide_charges/100))
                    WHEN DAYNAME(ph.date)='Tuesday' THEN ph.amount-(ph.amount*(r.AdminRide_charges/100))
                    WHEN DAYNAME(ph.date)='Wednesday' THEN ph.amount-(ph.amount*(r.AdminRide_charges/100))
                    WHEN DAYNAME(ph.date)='Thursday' THEN ph.amount-(ph.amount*(r.AdminRide_charges/100))
                    WHEN DAYNAME(ph.date)='Friday' THEN ph.amount-(ph.amount*(r.AdminRide_charges/100))
                    WHEN DAYNAME(ph.date)='Saturday' THEN ph.amount-(ph.amount*(r.AdminRide_charges/100))                 
                    END) as amount,sum(r.tip_amount) as tip_amount FROM payment_history as ph inner join rides as r on ph.ride_id=r.ride_id left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' and YEAR(ph.date) =  ".$this->input->get('year')." GROUP BY YEAR(ph.date),MONTH(ph.date)");/* YEAR(CURDATE()) */
                //echo $this->db->last_query();
                foreach ($qry->result() as $key => $value) {
                    $total_amount = $value->amount+$value->tip_amount;
                    $usermcount[(int)$value->month_name] = number_format((float)$total_amount, 2, '.', '');
                }
                $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                for ($i = 1; $i <= 12; $i++) {
                    if (!empty($usermcount[$i])) {
                        $userArr[]=array('amount' => $usermcount[$i],'month'=>$month[$i - 1]);
                    } else {
                        $userArr[]=array('amount' => 0,'month'=>$month[$i - 1]);
                    }
                    //$userArr[]['month'] = $month[$i - 1];
                }
            }
            if($this->input->get('month')){
                $qry = $this->db->query("SELECT DAY(time) as 'day_name',(
                    CASE WHEN DAYNAME(ph.date)='Sunday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Monday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Tuesday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Wednesday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Thursday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Friday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Saturday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))                   
                    END) as amount,sum(r.tip_amount) as tip_amount FROM ".Tables::PAYMENT_HISTORY." as ph inner join ".Tables::RIDE." as r on ph.ride_id=r.ride_id left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND MONTH(ph.date) = ".$this->input->get('month')." AND YEAR(ph.date) = YEAR(CURDATE()) GROUP BY DAY(ph.date)");/* YEAR(CURDATE()) */
                foreach ($qry->result() as $key => $value) {
                    $total_amount = $value->amount+$value->tip_amount;
                    $usermcount[(int)$value->day_name] =  number_format((float)$total_amount, 2, '.', '');
                }
                $last_day=$month_end = date('d',strtotime('last day of this month', strtotime(date('M',strtotime('01-'.$this->input->get('month').'-'.date('Y'))))));
                
                
                for ($i = 1; $i <= $last_day; $i++) {
                    if (!empty($usermcount[$i])) {
                        $userArr[]=array('amount' => $usermcount[$i],'day'=>date('D',strtotime(date('Y').'-'.$this->input->get('month').'-'.$i)));
                    } else {
                        $userArr[]=array('amount' => 0,'day'=>date('D',strtotime(date('Y').'-'.$this->input->get('month').'-'.$i)));
                    }
                    //$userArr[]['month'] = $month[$i - 1];
                }
            }
            if($this->input->get('week')){
                $last_day=$month_end = date('Y-m-d',strtotime(date('Y-m-d').' - '.($this->input->get('week')-1).' WEEK'));
                $qry =$this->db->query("SELECT  ph.date as time,DAY(ph.date) as day_name,(
                    CASE WHEN DAYNAME(ph.date)='Sunday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Monday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Tuesday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Wednesday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Thursday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Friday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                    WHEN DAYNAME(ph.date)='Saturday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))                   
                    END) as amount,sum(r.tip_amount) as tip_amount FROM ".Tables::PAYMENT_HISTORY." as ph inner join ".Tables::RIDE." as r on ph.ride_id=r.ride_id left join rate_chart on 1=1  WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND ph.date>= DATE('".$last_day."') - INTERVAL 7 DAY GROUP BY DAYNAME(ph.date) ORDER BY (ph.date) DESC") ; 
                               
                foreach ($qry->result() as $key => $value) {
                    $total_amount = $value->amount+$value->tip_amount;
                    $usermcount[(int)$value->day_name] =  number_format((float)$total_amount, 2, '.', '');
                }                
                for ($i = 0; $i < 7; $i++) {                    
                    if (!empty($usermcount[date('d',strtotime($last_day.' - '.$i.' day '))])) {
                        $userArr[]=array('amount' => $usermcount[date('d',strtotime($last_day.' - '.$i.' day '))],'day'=>date('D',strtotime($last_day.' - '.$i.' day ')));
                    } else {
                        $userArr[]=array('amount' => 0,'day'=>date('D',strtotime($last_day.' - '.$i.' day ')));
                    }
                    
                }
            }
           /*  $qry =$this->db->query("SELECT time,(
            CASE WHEN DAYNAME(time)='Sunday' THEN sum(amount-(amount*(rate_chart.sunday/100)))
            WHEN DAYNAME(time)='Monday' THEN sum(amount-(amount*(rate_chart.monday/100)))
            WHEN DAYNAME(time)='Tuesday' THEN sum(amount-(amount*(rate_chart.tuesday/100)))
            WHEN DAYNAME(time)='Wednesday' THEN sum(amount-(amount*(rate_chart.wednesday/100)))
            WHEN DAYNAME(time)='Thursday' THEN sum(amount-(amount*(rate_chart.thursday/100)))
            WHEN DAYNAME(time)='Friday' THEN sum(amount-(amount*(rate_chart.friday/100)))
            WHEN DAYNAME(time)='Saturday' THEN sum(amount-(amount*(rate_chart.saturday/100)))
           
            END) as amount FROM ".Tables::RIDE." left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND DATE(time)= DATE(NOW()) GROUP BY DAYNAME(time) ORDER BY (time) DESC") ; */

            $qry = $this->db->query("SELECT ph.date,(
                CASE WHEN DAYNAME(ph.date)='Sunday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                WHEN DAYNAME(ph.date)='Monday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                WHEN DAYNAME(ph.date)='Tuesday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                WHEN DAYNAME(ph.date)='Wednesday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                WHEN DAYNAME(ph.date)='Thursday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                WHEN DAYNAME(ph.date)='Friday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))
                WHEN DAYNAME(ph.date)='Saturday' THEN sum(ph.amount-(ph.amount*(r.AdminRide_charges/100)))                  
                END) as amount,sum(r.tip_amount) as tip_amount FROM ".Tables::PAYMENT_HISTORY." as ph inner join ".Tables::RIDE." as r on ph.ride_id=r.ride_id left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND DATE(ph.date)= DATE(NOW()) GROUP BY DAYNAME(ph.date) ORDER BY (ph.date) DESC"); 
            $current_amount=0;
            if($qry->num_rows()){ 
                $total_amount =  $qry->row()->amount+$qry->row()->tip_amount;          
                $current_amount=number_format((float)$total_amount, 2, '.', '');
            }
            $this->response(array("status" => true, 'current_day_earning'=>$current_amount,"data" =>$userArr));       

        } else {
            $this->response(array("status" => false, "data" => "This user does not exist"));

        }

    }
	
	
	
	/* public function earn_get() {
        $driver_id =$this->user_data->id;
        
        if (!empty($driver_id)) {
            
            $usermcount = [];
            $userArr = [];
            $rate_chart = $this->Auth_model->getCustomFields(Tables::RATE_CHART,'1=1','*');
            $rate_chart_row=$rate_chart->row_array();
            if($this->input->get('year')){
                $qry = $this->db->query("SELECT ph.amount as ph_amount,MONTH(ph.date) as 'month_name',DAYNAME(ph.date),sum(
                    CASE WHEN DAYNAME(ph.date)='Sunday' THEN ph.amount-(ph.amount*(rate_chart.sunday/100))
                    WHEN DAYNAME(ph.date)='Monday' THEN ph.amount-(ph.amount*(rate_chart.monday/100))
                    WHEN DAYNAME(ph.date)='Tuesday' THEN ph.amount-(ph.amount*(rate_chart.tuesday/100))
                    WHEN DAYNAME(ph.date)='Wednesday' THEN ph.amount-(ph.amount*(rate_chart.wednesday/100))
                    WHEN DAYNAME(ph.date)='Thursday' THEN ph.amount-(ph.amount*(rate_chart.thursday/100))
                    WHEN DAYNAME(ph.date)='Friday' THEN ph.amount-(ph.amount*(rate_chart.friday/100))
                    WHEN DAYNAME(ph.date)='Saturday' THEN ph.amount-(ph.amount*(rate_chart.saturday/100))                 
                    END) as amount,sum(r.tip_amount) as tip_amount FROM payment_history as ph inner join rides as r on ph.ride_id=r.ride_id left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' and YEAR(ph.date) =  ".$this->input->get('year')." GROUP BY YEAR(ph.date),MONTH(ph.date)");/* YEAR(CURDATE()) *
                //echo $this->db->last_query();
                foreach ($qry->result() as $key => $value) {
                    $total_amount = $value->amount+$value->tip_amount;
                    $usermcount[(int)$value->month_name] = number_format((float)$total_amount, 2, '.', '');
                }
                $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                for ($i = 1; $i <= 12; $i++) {
                    if (!empty($usermcount[$i])) {
                        $userArr[]=array('amount' => $usermcount[$i],'month'=>$month[$i - 1]);
                    } else {
                        $userArr[]=array('amount' => 0,'month'=>$month[$i - 1]);
                    }
                    //$userArr[]['month'] = $month[$i - 1];
                }
            }
            if($this->input->get('month')){
                $qry = $this->db->query("SELECT DAY(time) as 'day_name',(
                    CASE WHEN DAYNAME(ph.date)='Sunday' THEN sum(ph.amount-(ph.amount*(rate_chart.sunday/100)))
                    WHEN DAYNAME(ph.date)='Monday' THEN sum(ph.amount-(ph.amount*(rate_chart.monday/100)))
                    WHEN DAYNAME(ph.date)='Tuesday' THEN sum(ph.amount-(ph.amount*(rate_chart.tuesday/100)))
                    WHEN DAYNAME(ph.date)='Wednesday' THEN sum(ph.amount-(ph.amount*(rate_chart.wednesday/100)))
                    WHEN DAYNAME(ph.date)='Thursday' THEN sum(ph.amount-(ph.amount*(rate_chart.thursday/100)))
                    WHEN DAYNAME(ph.date)='Friday' THEN sum(ph.amount-(ph.amount*(rate_chart.friday/100)))
                    WHEN DAYNAME(ph.date)='Saturday' THEN sum(ph.amount-(ph.amount*(rate_chart.saturday/100)))                   
                    END) as amount,sum(r.tip_amount) as tip_amount FROM ".Tables::PAYMENT_HISTORY." as ph inner join ".Tables::RIDE." as r on ph.ride_id=r.ride_id left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND MONTH(ph.date) = ".$this->input->get('month')." AND YEAR(ph.date) = YEAR(CURDATE()) GROUP BY DAY(ph.date)");/* YEAR(CURDATE()) *
                foreach ($qry->result() as $key => $value) {
                    $total_amount = $value->amount+$value->tip_amount;
                    $usermcount[(int)$value->day_name] =  number_format((float)$total_amount, 2, '.', '');
                }
                $last_day=$month_end = date('d',strtotime('last day of this month', strtotime(date('M',strtotime('01-'.$this->input->get('month').'-'.date('Y'))))));
                
                
                for ($i = 1; $i <= $last_day; $i++) {
                    if (!empty($usermcount[$i])) {
                        $userArr[]=array('amount' => $usermcount[$i],'day'=>date('D',strtotime(date('Y').'-'.$this->input->get('month').'-'.$i)));
                    } else {
                        $userArr[]=array('amount' => 0,'day'=>date('D',strtotime(date('Y').'-'.$this->input->get('month').'-'.$i)));
                    }
                    //$userArr[]['month'] = $month[$i - 1];
                }
            }
            if($this->input->get('week')){
                $last_day=$month_end = date('Y-m-d',strtotime(date('Y-m-d').' - '.($this->input->get('week')-1).' WEEK'));
                $qry =$this->db->query("SELECT  ph.date as time,DAY(ph.date) as day_name,(
                    CASE WHEN DAYNAME(ph.date)='Sunday' THEN sum(ph.amount-(ph.amount*(rate_chart.sunday/100)))
                    WHEN DAYNAME(ph.date)='Monday' THEN sum(ph.amount-(ph.amount*(rate_chart.monday/100)))
                    WHEN DAYNAME(ph.date)='Tuesday' THEN sum(ph.amount-(ph.amount*(rate_chart.tuesday/100)))
                    WHEN DAYNAME(ph.date)='Wednesday' THEN sum(ph.amount-(ph.amount*(rate_chart.wednesday/100)))
                    WHEN DAYNAME(ph.date)='Thursday' THEN sum(ph.amount-(ph.amount*(rate_chart.thursday/100)))
                    WHEN DAYNAME(ph.date)='Friday' THEN sum(ph.amount-(ph.amount*(rate_chart.friday/100)))
                    WHEN DAYNAME(ph.date)='Saturday' THEN sum(ph.amount-(ph.amount*(rate_chart.saturday/100)))                   
                    END) as amount,sum(r.tip_amount) as tip_amount FROM ".Tables::PAYMENT_HISTORY." as ph inner join ".Tables::RIDE." as r on ph.ride_id=r.ride_id left join rate_chart on 1=1  WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND ph.date>= DATE('".$last_day."') - INTERVAL 7 DAY GROUP BY DAYNAME(ph.date) ORDER BY (ph.date) DESC") ; 
                               
                foreach ($qry->result() as $key => $value) {
                    $total_amount = $value->amount+$value->tip_amount;
                    $usermcount[(int)$value->day_name] =  number_format((float)$total_amount, 2, '.', '');
                }                
                for ($i = 0; $i < 7; $i++) {                    
                    if (!empty($usermcount[date('d',strtotime($last_day.' - '.$i.' day '))])) {
                        $userArr[]=array('amount' => $usermcount[date('d',strtotime($last_day.' - '.$i.' day '))],'day'=>date('D',strtotime($last_day.' - '.$i.' day ')));
                    } else {
                        $userArr[]=array('amount' => 0,'day'=>date('D',strtotime($last_day.' - '.$i.' day ')));
                    }
                    
                }
            }
           /*  $qry =$this->db->query("SELECT time,(
            CASE WHEN DAYNAME(time)='Sunday' THEN sum(amount-(amount*(rate_chart.sunday/100)))
            WHEN DAYNAME(time)='Monday' THEN sum(amount-(amount*(rate_chart.monday/100)))
            WHEN DAYNAME(time)='Tuesday' THEN sum(amount-(amount*(rate_chart.tuesday/100)))
            WHEN DAYNAME(time)='Wednesday' THEN sum(amount-(amount*(rate_chart.wednesday/100)))
            WHEN DAYNAME(time)='Thursday' THEN sum(amount-(amount*(rate_chart.thursday/100)))
            WHEN DAYNAME(time)='Friday' THEN sum(amount-(amount*(rate_chart.friday/100)))
            WHEN DAYNAME(time)='Saturday' THEN sum(amount-(amount*(rate_chart.saturday/100)))
           
            END) as amount FROM ".Tables::RIDE." left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND DATE(time)= DATE(NOW()) GROUP BY DAYNAME(time) ORDER BY (time) DESC") ; *

            $qry = $this->db->query("SELECT ph.date,(
                CASE WHEN DAYNAME(ph.date)='Sunday' THEN sum(ph.amount-(ph.amount*(rate_chart.sunday/100)))
                WHEN DAYNAME(ph.date)='Monday' THEN sum(ph.amount-(ph.amount*(rate_chart.monday/100)))
                WHEN DAYNAME(ph.date)='Tuesday' THEN sum(ph.amount-(ph.amount*(rate_chart.tuesday/100)))
                WHEN DAYNAME(ph.date)='Wednesday' THEN sum(ph.amount-(ph.amount*(rate_chart.wednesday/100)))
                WHEN DAYNAME(ph.date)='Thursday' THEN sum(ph.amount-(ph.amount*(rate_chart.thursday/100)))
                WHEN DAYNAME(ph.date)='Friday' THEN sum(ph.amount-(ph.amount*(rate_chart.friday/100)))
                WHEN DAYNAME(ph.date)='Saturday' THEN sum(ph.amount-(ph.amount*(rate_chart.saturday/100)))                  
                END) as amount,sum(r.tip_amount) as tip_amount FROM ".Tables::PAYMENT_HISTORY." as ph inner join ".Tables::RIDE." as r on ph.ride_id=r.ride_id left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND DATE(ph.date)= DATE(NOW()) GROUP BY DAYNAME(ph.date) ORDER BY (ph.date) DESC"); 
            $current_amount=0;
            if($qry->num_rows()){ 
                $total_amount =  $qry->row()->amount+$qry->row()->tip_amount;          
                $current_amount=number_format((float)$total_amount, 2, '.', '');
            }
            $this->response(array("status" => true, 'current_day_earning'=>$current_amount,"data" =>$userArr));       

        } else {
            $this->response(array("status" => false, "data" => "This user does not exist"));

        }

    } */
    
    // For getting earn data in ios
    public function earnios_get() {
        $driver_id =$this->user_data->id;
        
        if (!empty($driver_id)) {
            
            $usermcount = [];
            $userArr = [];
            $rate_chart = $this->Auth_model->getCustomFields(Tables::RATE_CHART,'1=1','*');
            $rate_chart_row=$rate_chart->row_array();
            if($this->input->get('year')){
                $qry = $this->db->query("SELECT ph.amount as ph_amount,MONTH(ph.date) as 'month_name',DAYNAME(ph.date),sum(
                    CASE WHEN DAYNAME(ph.date)='Sunday' THEN ph.amount-(ph.amount*(rate_chart.sunday/100))
                    WHEN DAYNAME(ph.date)='Monday' THEN ph.amount-(ph.amount*(rate_chart.monday/100))
                    WHEN DAYNAME(ph.date)='Tuesday' THEN ph.amount-(ph.amount*(rate_chart.tuesday/100))
                    WHEN DAYNAME(ph.date)='Wednesday' THEN ph.amount-(ph.amount*(rate_chart.wednesday/100))
                    WHEN DAYNAME(ph.date)='Thursday' THEN ph.amount-(ph.amount*(rate_chart.thursday/100))
                    WHEN DAYNAME(ph.date)='Friday' THEN ph.amount-(ph.amount*(rate_chart.friday/100))
                    WHEN DAYNAME(ph.date)='Saturday' THEN ph.amount-(ph.amount*(rate_chart.saturday/100))                 
                    END) as amount,sum(r.tip_amount) as tip_amount FROM payment_history as ph inner join rides as r on ph.ride_id=r.ride_id left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' and YEAR(ph.date) =  ".$this->input->get('year')." GROUP BY YEAR(ph.date),MONTH(ph.date)");/* YEAR(CURDATE()) */
                //echo $this->db->last_query();
                foreach ($qry->result() as $key => $value) {
                    $total_amount = $value->amount+$value->tip_amount;
                    $usermcount[(int)$value->month_name] = number_format((float)$total_amount, 2, '.', '');
                }
                $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                for ($i = 1; $i <= 12; $i++) {
                    if (!empty($usermcount[$i])) {
                        $userArr[]=array('amount' => $usermcount[$i],'month'=>$month[$i - 1]);
                    } else {
                        $userArr[]=array('amount' => "0",'month'=>$month[$i - 1]);
                    }
                    //$userArr[]['month'] = $month[$i - 1];
                }
            }
            if($this->input->get('month')){
                $qry = $this->db->query("SELECT DAY(time) as 'day_name',(
                    CASE WHEN DAYNAME(ph.date)='Sunday' THEN sum(ph.amount-(ph.amount*(rate_chart.sunday/100)))
                    WHEN DAYNAME(ph.date)='Monday' THEN sum(ph.amount-(ph.amount*(rate_chart.monday/100)))
                    WHEN DAYNAME(ph.date)='Tuesday' THEN sum(ph.amount-(ph.amount*(rate_chart.tuesday/100)))
                    WHEN DAYNAME(ph.date)='Wednesday' THEN sum(ph.amount-(ph.amount*(rate_chart.wednesday/100)))
                    WHEN DAYNAME(ph.date)='Thursday' THEN sum(ph.amount-(ph.amount*(rate_chart.thursday/100)))
                    WHEN DAYNAME(ph.date)='Friday' THEN sum(ph.amount-(ph.amount*(rate_chart.friday/100)))
                    WHEN DAYNAME(ph.date)='Saturday' THEN sum(ph.amount-(ph.amount*(rate_chart.saturday/100)))                   
                    END) as amount,sum(r.tip_amount) as tip_amount FROM ".Tables::PAYMENT_HISTORY." as ph inner join ".Tables::RIDE." as r on ph.ride_id=r.ride_id left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND MONTH(ph.date) = ".$this->input->get('month')." AND YEAR(ph.date) = YEAR(CURDATE()) GROUP BY DAY(ph.date)");/* YEAR(CURDATE()) */
                foreach ($qry->result() as $key => $value) {
                    $total_amount = $value->amount+$value->tip_amount;
                    $usermcount[(int)$value->day_name] =  number_format((float)$total_amount, 2, '.', '');
                }
                $last_day=$month_end = date('d',strtotime('last day of this month', strtotime(date('M',strtotime('01-'.$this->input->get('month').'-'.date('Y'))))));
                
                
                for ($i = 1; $i <= $last_day; $i++) {
                    if (!empty($usermcount[$i])) {
                        $userArr[]=array('amount' => $usermcount[$i],'day'=>date('D',strtotime(date('Y').'-'.$this->input->get('month').'-'.$i)));
                    } else {
                        $userArr[]=array('amount' => "0",'day'=>date('D',strtotime(date('Y').'-'.$this->input->get('month').'-'.$i)));
                    }
                    //$userArr[]['month'] = $month[$i - 1];
                }
            }
            if($this->input->get('week')){
                $last_day=$month_end = date('Y-m-d',strtotime(date('Y-m-d').' - '.($this->input->get('week')-1).' WEEK'));
                $qry =$this->db->query("SELECT  ph.date as time,DAY(ph.date) as day_name,(
                    CASE WHEN DAYNAME(ph.date)='Sunday' THEN sum(ph.amount-(ph.amount*(rate_chart.sunday/100)))
                    WHEN DAYNAME(ph.date)='Monday' THEN sum(ph.amount-(ph.amount*(rate_chart.monday/100)))
                    WHEN DAYNAME(ph.date)='Tuesday' THEN sum(ph.amount-(ph.amount*(rate_chart.tuesday/100)))
                    WHEN DAYNAME(ph.date)='Wednesday' THEN sum(ph.amount-(ph.amount*(rate_chart.wednesday/100)))
                    WHEN DAYNAME(ph.date)='Thursday' THEN sum(ph.amount-(ph.amount*(rate_chart.thursday/100)))
                    WHEN DAYNAME(ph.date)='Friday' THEN sum(ph.amount-(ph.amount*(rate_chart.friday/100)))
                    WHEN DAYNAME(ph.date)='Saturday' THEN sum(ph.amount-(ph.amount*(rate_chart.saturday/100)))                   
                    END) as amount,sum(r.tip_amount) as tip_amount FROM ".Tables::PAYMENT_HISTORY." as ph inner join ".Tables::RIDE." as r on ph.ride_id=r.ride_id left join rate_chart on 1=1  WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND ph.date>= DATE('".$last_day."') - INTERVAL 7 DAY GROUP BY DAYNAME(ph.date) ORDER BY (ph.date) DESC") ; 
                               
                foreach ($qry->result() as $key => $value) {
                    $total_amount = $value->amount+$value->tip_amount;
                    $usermcount[(int)$value->day_name] =  number_format((float)$total_amount, 2, '.', '');
                }                
                for ($i = 0; $i < 7; $i++) {                    
                    if (!empty($usermcount[date('d',strtotime($last_day.' - '.$i.' day '))])) {
                        $userArr[]=array('amount' => $usermcount[date('d',strtotime($last_day.' - '.$i.' day '))],'day'=>date('D',strtotime($last_day.' - '.$i.' day ')));
                    } else {
                        $userArr[]=array('amount' => "0",'day'=>date('D',strtotime($last_day.' - '.$i.' day ')));
                    }
                    
                }
            }
           /*  $qry =$this->db->query("SELECT time,(
            CASE WHEN DAYNAME(time)='Sunday' THEN sum(amount-(amount*(rate_chart.sunday/100)))
            WHEN DAYNAME(time)='Monday' THEN sum(amount-(amount*(rate_chart.monday/100)))
            WHEN DAYNAME(time)='Tuesday' THEN sum(amount-(amount*(rate_chart.tuesday/100)))
            WHEN DAYNAME(time)='Wednesday' THEN sum(amount-(amount*(rate_chart.wednesday/100)))
            WHEN DAYNAME(time)='Thursday' THEN sum(amount-(amount*(rate_chart.thursday/100)))
            WHEN DAYNAME(time)='Friday' THEN sum(amount-(amount*(rate_chart.friday/100)))
            WHEN DAYNAME(time)='Saturday' THEN sum(amount-(amount*(rate_chart.saturday/100)))
           
            END) as amount FROM ".Tables::RIDE." left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND DATE(time)= DATE(NOW()) GROUP BY DAYNAME(time) ORDER BY (time) DESC") ; */

            $qry = $this->db->query("SELECT ph.date,(
                CASE WHEN DAYNAME(ph.date)='Sunday' THEN sum(ph.amount-(ph.amount*(rate_chart.sunday/100)))
                WHEN DAYNAME(ph.date)='Monday' THEN sum(ph.amount-(ph.amount*(rate_chart.monday/100)))
                WHEN DAYNAME(ph.date)='Tuesday' THEN sum(ph.amount-(ph.amount*(rate_chart.tuesday/100)))
                WHEN DAYNAME(ph.date)='Wednesday' THEN sum(ph.amount-(ph.amount*(rate_chart.wednesday/100)))
                WHEN DAYNAME(ph.date)='Thursday' THEN sum(ph.amount-(ph.amount*(rate_chart.thursday/100)))
                WHEN DAYNAME(ph.date)='Friday' THEN sum(ph.amount-(ph.amount*(rate_chart.friday/100)))
                WHEN DAYNAME(ph.date)='Saturday' THEN sum(ph.amount-(ph.amount*(rate_chart.saturday/100)))                  
                END) as amount,sum(r.tip_amount) as tip_amount FROM ".Tables::PAYMENT_HISTORY." as ph inner join ".Tables::RIDE." as r on ph.ride_id=r.ride_id left join rate_chart on 1=1 WHERE r.driver_id=".$driver_id." and r.payout_status=2 AND `r`.`payment_status` = 'COMPLETED' AND `r`.`status` = 'COMPLETED' AND DATE(ph.date)= DATE(NOW()) GROUP BY DAYNAME(ph.date) ORDER BY (ph.date) DESC"); 
            $current_amount=0;
            if($qry->num_rows()){ 
                $total_amount =  $qry->row()->amount+$qry->row()->tip_amount;          
                $current_amount=number_format((float)$total_amount, 2, '.', '');
            }
            $this->response(array("status" => true, 'current_day_earning'=>$current_amount,"data" =>$userArr));       

        } else {
            $this->response(array("status" => false, "data" => "This user does not exist"));

        }

    }
    /* Get profile */

    public function profile_post() {

       $user_id =  $this->input->post('user_id');

        if (!empty($user_id)) {

            $res = $this->db->get_where("users", array("user_id" => $user_id))->row();

            if (!empty($res->avatar)) {

                $res->avatar = $this->config->base_url() . $res->avatar;

            }

            if (!empty($res->license)) {

                $res->license = $this->config->base_url() . $res->license;

            }

            if (!empty($res->insurance)) {

                $res->insurance = $this->config->base_url() . $res->insurance;

            }

            if (!empty($res->permit)) {

                $res->permit = $this->config->base_url() . $res->permit;

            }

            if (!empty($res->registration)) {

                $res->registration = $this->config->base_url() . $res->registration;

            }

            $this->response(array("status" => true, "data" => $res));

        } else {

            $this->response(array("status" => false, "data" => "User id not send"));

        }

    }
    /* Get ride status */

    public function get_ride_status_post(){
		
        
        $vehicle_query = $this->Auth_model->get_current_active_vehicle($this->user_data->id);     
        $license_expiry=false;
        $insurance_expiry=false;
        $car_expiry=false;
        $driver_rest_time=false;
        $change_vehicle=false;
        $inspection_expiry=false;
        if ($vehicle_query->num_rows()>0) {
            $vehicle_detail = $vehicle_query->row();
           
            if(strtotime($vehicle_detail->license_expiry_date)<strtotime(date('Y-m-d')))
                $license_expiry=true;
            if(strtotime($vehicle_detail->insurance_expiry_date)<strtotime(date('Y-m-d')))
                $insurance_expiry=true;
            if(strtotime($vehicle_detail->car_expiry_date)<strtotime(date('Y-m-d')))
                $car_expiry=true;
            if(date('Y')-$vehicle_detail->year>15)
                $change_vehicle=true; 
            if(strtotime(date('Y-m-d H:i:s'))<=(strtotime($vehicle_detail->inspection_expiry_date))){
                $inspection_expiry=true;
            } 
                        
        }
        $login_query = $this->db->query("SELECT user_id,login_time,last_name,gcm_token as driver_fcm_token FROM users WHERE login_time< DATE_ADD('".date('Y-m-d H:i:s')."', INTERVAL -12 HOUR);
        ");
        if($login_query->num_rows()>0 && ((strtotime(date('Y-m-d H:i:s'))-strtotime($login_query->row()->login_time))/3600<=5)){
            $driver_rest_time=true;
        }
        
        $res = $this->Auth_model->get_current_ride($this->input->post('ride_id'));

        $res = $qry->row();
		

       

        if ($res->num_rows()>0) {
            $row = $res->row();
           
            $res_query = $this->Auth_model->get_mechanic_detail($row->driver_id);           
                $row->ride_id = $this->input->post('ride_id');
            
                if (!empty($res_query->row()->total_driver_ride)) {

                    $total_rating=($res_query->row()->total_rating/$res_query->row()->total_driver_ride);

                }else{

                    $total_rating=0;

                }

                $authObj = modules::load('api/auth/');

                //$api_data= $authObj->get_distance($res->row()->pickup_adress,$res->row()->drop_address);

                $api_data= $authObj->get_distance1($row->pickup_lat,$row->pickup_long,$row->drop_lat,$row->drop_long);



                //$api_driving_data= $authObj->GetDrivingDistance_get($res_query->row()->latitude,$res_query->row()->longitude,$row->pickup_adress);

                if ($row->is_destination_ride==1) {

                    //$lat= $res_query->row()->destination_lat;

                    //$long= $res_query->row()->destination_long;

                    $api_driving_data= $authObj->get_distance1($row->pickup_lat,$row->pickup_long,$row->destination_lat,$row->destination_long);

                }else{

                    $api_driving_data= $authObj->get_distance1($row->pickup_lat,$row->pickup_long,$res_query->row()->latitude,$res_query->row()->longitude);

                }
				//print_r($res_query->row()); die;
				if($row->amount*$row->distance){
						$tamount=number_format((float)$row->amount,2);
					}else{
						$tamount=0;
				}
				$total_amount = (string)preg_replace('/[^0-9\.]/ui','',$tamount);
				//$API_dist=$api_driving_data['distance'];
				//$API_dist = explode(' ',$api_driving_data['distance']); 
				$API_dist1 = $API_dist[0]; 
				$Api_Distance = $api_driving_data['distance'];//$API_dist1 / 5280;
				$APIDISTANCE=(string)preg_replace('/[^0-9\.]/ui','',$Api_Distance);
                $row->total_arrival_distance = $APIDISTANCE;

                $row->total_arrival_time =$api_driving_data['time']; 
				
				//$row->total_amount= (float)preg_replace('/[^0-9\.]/ui','',$tamount);//number_format((float)$tamount,2);
				
				$row->total_amount= bcdiv($total_amount, 1,2);
                $row->total_rating = bcadd(0,( $total_rating), 1);

                $row->total_time = $api_data['time'];

                $row->total_distance = bcadd($api_data['distance'],1,2);

                $row->status = $res->row()->ride_status;

                $row->profile_pic = $res_query->row()->profile_pic;
                $row->driver_lastname = $res_query->row()->last_name;


			
            //$query = $this->Auth_model->getCustomFields(Tables::RIDE_AUDIO,array('ride_id'=>$this->input->post('ride_id')),'IFNULL(CONCAT("'.base_url('uploads/audio_capture/').'",audio_file)," ") as audio');

            //$row->audio =  $query->result();
			#---Log Section start--
				$obj = modules::load('admin');
				$obj->custom_log('API',' get_ride_status, User Id: '.$this->user_data->id.', GOOGLE API Key '.GOOGLE_MAP_API_KEY);
			#--log End --

           $this->response(array("status" => true,'license_expiry'=>$license_expiry,'insurance_expiry'=>$insurance_expiry,'car_expiry'=>$car_expiry,'driver_rest_time'=>$driver_rest_time,'change_vehicle'=>$change_vehicle,'inspection_expiry'=>$inspection_expiry,"data" =>$row ));  

        }else{

            $this->response(array("status" => false,'license_expiry'=>$license_expiry,'insurance_expiry'=>$insurance_expiry,'car_expiry'=>$car_expiry,'driver_rest_time'=>$driver_rest_time,'change_vehicle'=>$change_vehicle,'inspection_expiry'=>$inspection_expiry, "message" => 'Error occurred, please try after some time')); 

        }

    }


    // public function get_ride_status_post(){
       
    //     $vehicle_query = $this->Auth_model->get_current_active_vehicle($this->user_data->id);     
    //     $license_expiry=false;
    //     $insurance_expiry=false;
    //     $car_expiry=false;
    //     $driver_rest_time=false;
    //     $change_vehicle=false;
    //     $inspection_expiry=false;

    //     if ($vehicle_query->num_rows()>0) {
    //         $vehicle_detail = $vehicle_query->row();           
    //         if(strtotime($vehicle_detail->license_expiry_date)<strtotime(date('Y-m-d')))
    //             $license_expiry=true;
    //         if(strtotime($vehicle_detail->insurance_expiry_date)<strtotime(date('Y-m-d')))
    //             $insurance_expiry=true;
    //         if(strtotime($vehicle_detail->car_expiry_date)<strtotime(date('Y-m-d')))
    //             $car_expiry=true;
    //         if(date('Y')-$vehicle_detail->year>15)
    //             $change_vehicle=true; 
    //         if(strtotime(date('Y-m-d H:i:s'))<=(strtotime($vehicle_detail->inspection_expiry_date))){
    //             $inspection_expiry=true;
    //         } 
                        
    //     }

    //     $login_query = $this->db->query("SELECT user_id,login_time,last_name,gcm_token as driver_fcm_token FROM users WHERE login_time< DATE_ADD('".date('Y-m-d H:i:s')."', INTERVAL -12 HOUR);
    //     ");
    //     if($login_query->num_rows()>0 && ((strtotime(date('Y-m-d H:i:s'))-strtotime($login_query->row()->login_time))/3600<=5)){
    //         $driver_rest_time=true;
    //     }        
    //     $res = $this->Auth_model->get_current_ride($this->input->post('ride_id'));

    //     if ($res->num_rows()>0) {
    //             $row = $res->row();

    //         $res_query = $this->Auth_model->get_mechanic_detail($row->driver_id);

    //             $row->ride_id = $this->input->post('ride_id');
    //             if (!empty($res_query->row()->total_driver_ride)) {
    //                 $total_rating=($res_query->row()->total_rating/$res_query->row()->total_driver_ride);
    //             }else{

    //                 $total_rating=0;
    //             }

    //             $authObj = modules::load('api/auth/');
    //             $api_data = $authObj->get_distance1($row->pickup_lat,$row->pickup_long,$row->drop_lat,$row->drop_long);

    //             if ($row->is_destination_ride==1) {
                   
    //                 $api_driving_data = $authObj->get_distance1($row->pickup_lat,$row->pickup_long,$row->destination_lat,$row->destination_long);

    //             }else{
    //                 $api_driving_data = $authObj->get_distance1($row->pickup_lat,$row->pickup_long,$res_query->row()->latitude,$res_query->row()->longitude);

    //             }
	// 			//print_r($api_driving_data['time']); die;
	// 			if($row->amount*$row->distance){
	// 					$tamount=number_format((float)$row->amount,2);
	// 				}else{
	// 					$tamount=0;
	// 			}
	// 			$total_amount = (string)preg_replace('/[^0-9\.]/ui','',$tamount);
				
    //             $Api_Distance =$api_driving_data['distance'];
                
    //             $driving_hours = $this->time_conversion($api_driving_data['time']);
                
    //             $totalTime=$this->time_conversion($api_data['time']);

	// 			$APIDISTANCE=(string)preg_replace('/[^0-9\.]/ui','',$Api_Distance);

    //             if(($row->status=="PENDING")||($row->status=="ACCEPTED")||($row->status=="START_RIDE")){
    //                 $row->total_arrival_distance = (string)bcdiv($APIDISTANCE,1,2);
    //                 $row->total_arrival_time =(string)$driving_hours;
    //                 $row->total_time = (string)$totalTime;
    //                 $row->total_distance = (string)bcdiv($api_data['distance'],1,2);

    //             }else{

    //                 $row->total_arrival_distance = "0:0";
    //                 $row->total_arrival_time ="0:0";

    //                 $row->total_time = "0:0";
    //                 $row->total_distance = (string)bcdiv($res->row()->distance,1,2);

    //             }   
	// 			//$row->total_amount= (float)preg_replace('/[^0-9\.]/ui','',$tamount);//number_format((float)$tamount,2);
	// 			$row->total_amount= bcdiv($total_amount, 1,2);
    //             $row->total_rating = bcadd(0,( $total_rating), 1);                
    //             $row->distance = (string)bcdiv($res->row()->distance,1,2);
    //             $row->status = $res->row()->ride_status;
    //             $row->profile_pic = $res_query->row()->profile_pic;
    //             $row->driver_lastname = $res_query->row()->last_name;
            
	// 		#---Log Section start--
	// 			$obj = modules::load('admin');
	// 			$obj->custom_log('API',' get_ride_status, User Id: '.$this->user_data->id);
	// 		#--log End --
			
    //        $this->response(array("status" => true,'license_expiry'=>$license_expiry,'insurance_expiry'=>$insurance_expiry,'car_expiry'=>$car_expiry,'driver_rest_time'=>$driver_rest_time,'change_vehicle'=>$change_vehicle,'inspection_expiry'=>$inspection_expiry,"data" =>$row ));  

    //     }else{

    //         $this->response(array("status" => false,'license_expiry'=>$license_expiry,'insurance_expiry'=>$insurance_expiry,'car_expiry'=>$car_expiry,'driver_rest_time'=>$driver_rest_time,'change_vehicle'=>$change_vehicle,'inspection_expiry'=>$inspection_expiry, "message" => 'Error occurred, please try after some time')); 

    //     }

    // }


    /* change password API */

    public function change_password_post()
    {
        $this->form_validation->set_rules('new_password','New Password','required');

        $this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[new_password]');

        $this->form_validation->set_error_delimiters("","");

        if ($this->form_validation->run()==false) {

            $message ="";

            if (form_error('new_password')) {

                $message = form_error('new_password');

            }else if(form_error('confirm_password')){

                $message = form_error('confirm_password');

            }

            $this->set_response(['status'=>false,'message'=>$message], REST_Controller::HTTP_OK);

        }else{

            $affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('password'=>md5($this->input->post('new_password'))));

           // echo $this->db->last_query();

            if ($affected) {

                $this->set_response(['status'=>true,'message'=>'You password has been changed successfully'], REST_Controller::HTTP_OK);

            }else{

                $this->set_response(['status'=>false,'message'=>'Error occurred, Please try after some time'], REST_Controller::HTTP_OK);

            }

        }

    }
    /* update profile of user */
    public function update_profile_of_user_post()
    {
		//print_r($this->input->post());
		//die;
		
        $this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('country_code','Country Code','required');
        $this->form_validation->set_rules('mobile','Contact No','required|max_length[14]');

        $this->form_validation->set_error_delimiters("","");

        if ($this->form_validation->run()==false) {

            $message ="";

            if (form_error('name')) {

                $message = form_error('name');

            }else if(form_error('country_code')){

                $message = form_error('country_code');

            }else if(form_error('mobile')){

                $message = form_error('mobile');

            }

            $this->set_response(['status'=>false,'message'=>$message], REST_Controller::HTTP_OK);

        }else{
            $obj = modules::load('admin');
			$query = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'mobile');
             $flag=0;
             if ($query->num_rows()){
                $data=$query->row();
                
                if($this->input->post('mobile')==$data->mobile){
                    $flag=1;
                }

             }
                $countrycode=$this->input->post('country_code');
                $cfirst=substr($countrycode,0,1);
                if($cfirst=='+'){
                    $ctrcode=$countrycode;
                }else{
                    $ctrcode='+'.$countrycode;
                }
            $num   = $this->Auth_model->getSingleRecord(Tables::USER, array('mobile' => $this->input->post('mobile')));
                $total_count=$num->num_rows();
            if($total_count>$flag){
                    $this->set_response(['status'=>false,'message'=>'This number is already registered with another RideShareRates account'], REST_Controller::HTTP_OK);
            }else{ 
				$affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('name'=>$this->input->post('name'),'name_title'=>$this->input->post('name_title'),'last_name'=>$this->input->post('last_name'),'country_code'=>$ctrcode,'mobile'=>$this->input->post('mobile'),'countrycode_mobile'=>$ctrcode.$this->input->post('mobile'),'identification_document_id'=>$this->input->post('identification_document_id'),
				'identification_issue_date'=>$this->input->post('identification_issue_date'),
				'identification_expiry_date'=>$this->input->post('identification_expiry_date')));

				if (!empty($_FILES['verification_id']['name'])) {
					$obj->do_upload_profile('verification_document',$this->user_data->id,'verification_id');
					$affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('identification_document_id'=>$this->input->post('identification_document_id'),
				'identification_issue_date'=>$this->input->post('identification_issue_date'),
				'identification_expiry_date'=>$this->input->post('identification_expiry_date')));
				}

				if ($affected) {

					if (!empty($_FILES['profile_pic']['name'])) {                    

						$this->upload_profile_pic_post();
						$affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('profile_upload_date'=>date('Y-m-d')));
					}

					$this->set_response(['status'=>true,'message'=>'Your profile details has been changed successfully','data'=>array('name'=>$this->input->post('name'),'mobile'=>$this->input->post('mobile'))], REST_Controller::HTTP_OK);

				}else{

					$this->set_response(['status'=>false,'message'=>'Error occurred, Please try after some time'], REST_Controller::HTTP_OK);

				}
			}

        }

    }
    
    // For uploading profile picture
    public function upload_profile_pic_post()
    {
       if (!is_dir('uploads/profile_image/'.$this->user_data->id)) {

            mkdir('./uploads//profile_image/'.$this->user_data->id, 0777, TRUE);

        }

        $config['upload_path']   = './uploads//profile_image/'.$this->user_data->id; 

        $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG'; 

        $config['max_size']      = 10000; 

        //$config['max_width']     = 1024; 

        //$config['max_height']    = 768; 



        $path_info = pathinfo($_FILES['profile_pic']['name']);

        ////echo $path_info['extension'];

        $new_name = time().'ridesharerates'.$path_info['extension'];

        //die;

        $config['file_name'] = $new_name; 

        //$config['file_name'] = $_FILES['file']['name'];

        $this->load->library('upload', $config);

        $this->upload->initialize($config);

            

         if ( ! $this->upload->do_upload('profile_pic')) {



            $error = array('error' => $this->upload->display_errors()); 

            $this->set_response(['status'=>false,'message'=>$this->upload->display_errors()],REST_Controller::HTTP_OK);

            

            

         }else { 

            $query = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'avatar,user_id');

           

           

            $file_array = $this->upload->data();            

                  

            $affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('avatar'=>$file_array['file_name']));

            //echo $this->db->last_query();

            if ($affected) {

                if (!empty($query->row()->avatar)) {

                    $uploaded_image_path = 'uploads/profile_image/'.$this->user_data->id.'/'.$query->row()->avatar;

                    unlink($uploaded_image_path);

                }

                $this->set_response(['status'=>true,'message'=>'Your profile details has been changed successfully'],REST_Controller::HTTP_OK);

            }else{

                $this->set_response(['status'=>false,'message'=>'Error occurred, Please after some time'],REST_Controller::HTTP_OK);

            }

            

        } 

    } 
    /* get profile */
    public function get_profile_get()
    {  
		
		
		//$retings = $this->Auth_model->get_retings($this->user_data);
		//$retingavg=$retings->result();
        $query = $this->Auth_model->get_profile_detail($this->user_data);		
		
        if ($query->num_rows()>0){
			#---Log Section start--
			$obj = modules::load('admin');
			$obj->custom_log('API',' get_profile, User Id: '.$this->user_data->id.', GOOGLE API Key '.GOOGLE_MAP_API_KEY);
			#--log End --
            $this->set_response(['status'=>true,'message'=>'Successfully','data'=>$query->user_detail],REST_Controller::HTTP_OK);

        }else{
			
            $this->set_response(['status'=>false,'message'=>'Error occurred, Please after some time'],REST_Controller::HTTP_OK);
        }
    }
    /* cancelled ride from user */
    public function get_count_cancelled_ride_get()
    {
        $ride_id =$this->input->get('ride_id');
        $qry = $this->Auth_model->get_current_ride($ride_id);
        if ($qry->num_rows()==0) {
            $this->set_response(['status'=>false,'message'=>'Invalid parameter'],REST_Controller::HTTP_OK);
        }else{
            $row = $qry->row();        
            $this->set_response(['status'=>true,'message'=>'','count_ride'=>$row->cancelled_count],REST_Controller::HTTP_OK);
        }
    }
    
    // For getting payments data
    public function payment_get(){
        $user_data = $this->user_data;
        $user_data->from =$this->input->get('from');
        $user_data->to =$this->input->get('to');
        $per_page =$this->input->get('per_page');
        $start =$this->input->get('page_no')*$per_page-$per_page;
        $limit =$start-$per_page;
        $query = $this->Auth_model->payment_history($user_data,$start,$per_page);
       //echo $this->db->last_query();
        $result = array();
        $total_amount = 0;
        $total_payout_amount=0;
        $total_earning=0;
        if ($query->num_rows()>0) {

            $rate_detail =get_payout_amount();

            foreach ($query->result() as $key => $value) { 

                //$total_amount+=$value->amount;

                $day= strtolower(date('l',strtotime($value->date)));
               
                /* if($value->payout_status==1){
                    $total_earning+=($value->amount-($value->amount*($rate_detail->$day)/100))+$value->tip_amount;
                   
                }else{
                    $payout_amount =  ($value->amount-($value->amount*($rate_detail->$day)/100));  
                   // echo $payout_amount.'/';                  
                    $total_payout_amount+= $payout_amount+$value->tip_amount;
                    

                 } */
				 
				  if($value->payout_status==1){
                    $total_earning+=($value->amount+$value->tip_amount);
                   
                }else{
					$tamount=$value->amount;
					
					$admin_amount =  ($tamount*($value->AdminRide_charges)/100);
					//echo $admin_amount;die;
                    $payout_amount = $tamount-$admin_amount;  
				   //echo $payout_amount.'/';                  
                    $total_payout_amount+= $payout_amount+$value->tip_amount;
                    

                 }

                $result[]= array( 

                    "ride_id"=> $value->ride_id,

                    "user_id"=> $value->user_id,

                    "driver_id"=> $value->driver_id,

                    "vehicle_type_id"=> $value->vehicle_type_id,

                    "pickup_adress"=> $value->pickup_adress,

                    "is_destination_ride"=> $value->is_destination_ride,

                    "drop_address"=> $value->drop_address,

                    "pikup_location"=> $value->pikup_location,

                    "pickup_lat"=> $value->pickup_lat,

                    "pickup_long"=> $value->pickup_long,

                    "drop_locatoin"=> $value->drop_locatoin,

                    "drop_lat"=>$value->drop_lat,

                    "drop_long"=> $value->drop_long,

                    "distance"=> $value->distance,

                    "status"=> $value->status,

                    "cancelled_by"=> $value->cancelled_by,

                    "cancelled_count"=> $value->cancelled_count,

                    "payment_status"=> $value->payment_status,

                    "pay_driver"=> $value->pay_driver,

                    "payment_mode"=> $value->payment_mode,
                    "amount"=> number_format((float) ($payout_amount), 2, '.', ''),
                    "tip_amount"=> $value->tip_amount ,

                    "time"=> date('m/d/y h:i A', strtotime($value->time)),

                    "user_mobile"=> $value->user_mobile,

                    "user_avatar"=> $value->user_avatar,

                    "driver_avatar"=> $value->driver_avatar,

                    "user_name"=> $value->user_name,
                    "user_lastname"=>($value->user_lastname)?$value->user_lastname:'',
                    "driver_mobile"=> $value->driver_mobile,
                    "driver_name"=> $value->driver_name,
                    "driver_lastname"=>($value->driver_lastname)?$value->driver_lastname:'',

                    "vehicle_type_name"=> '',

                    "payout_amount"=> number_format((float) ( $payout_amount), 2, '.', ''),

                    "txn_id"=> $value->txn_id,

                    "payout_status"=> ($value->payout_status==1)?'Paid':'Non Paid',

                    "date"=> date('m/d/y h:i A', strtotime($value->date))
                    

                );

        }

           $this->set_response(array('status'=>true,'total_record'=>$this->Auth_model->payment_history($user_data,null,null)->num_rows(),'total_earning'=> number_format((float) ($total_earning), 2, '.', ''),'total_payout'=> number_format((float) ($total_payout_amount), 2, '.', ''),'data'=> $result),REST_Controller::HTTP_OK); 
        }else{
            $this->set_response(array('status'=>false,'data'=>$result),REST_Controller::HTTP_OK);
        }
    }

    // For getting driver status data
    public function get_driver_status_get(){  
        $query = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'is_online,user_id,status');
        $this->set_response(array('status'=>true,'data'=>$query->row()),REST_Controller::HTTP_OK);
    }

    /* upload document */
    public function upload_document_post()
    {
        $obj = modules::load('admin');
        $user_id =$this->user_data->id;  
        $vehicle_detail = $this->Auth_model->getCustomFields(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id,'status'=>1),'id'); 
        $vehicle_id =  $vehicle_detail->row()->id;                         
        if (!empty($_FILES['insurance']['name'])) {
            $obj->do_upload('insurance_document',$user_id,'insurance',$vehicle_id);
            $vehicle_arr = array(
                'insurance_issue_date'         =>$this->input->post('insurance_issue_date'),
                'insurance_expiry_date'         =>$this->input->post('insurance_expiry_date'),                            
                'updated_date'  =>date('Y-m-d H:i:s'),
                );
            $vehicle_id = $this->Auth_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id,'id'=>$vehicle_id),$vehicle_arr);
            $this->set_response(['status'=>true,'message'=>'Uploaded successfully'], REST_Controller::HTTP_OK);
        }
        if (!empty($_FILES['license']['name'])) {   
            $obj->do_upload('license_document',$user_id,'license',$vehicle_id);
            $vehicle_arr = array(             
                'license_expiry_date'         =>$this->input->post('license_expiry_date'),
                'license_issue_date'         =>$this->input->post('license_issue_date'),                             
                'updated_date'  =>date('Y-m-d H:i:s'),
                );
            $vehicle_id = $this->Auth_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id,'id'=>$vehicle_id),$vehicle_arr);
            $this->set_response(['status'=>true,'message'=>'Uploaded successfully'], REST_Controller::HTTP_OK);
        }                 
        if (!empty($_FILES['car_registration']['name'])) {
            $obj->do_upload('car_registration',$user_id,'car_registration',$vehicle_id);
            $vehicle_arr = array(
                'car_issue_date'         =>$this->input->post('car_issue_date'),
                'car_expiry_date'         =>$this->input->post('car_expiry_date'),
                'updated_date'  =>date('Y-m-d H:i:s'),
                );
            $vehicle_id = $this->Auth_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id,'id'=>$vehicle_id),$vehicle_arr);
            $this->set_response(['status'=>true,'message'=>'Uploaded successfully'], REST_Controller::HTTP_OK);
        } 
        if (!empty($_FILES['inspection_document']['name'])) {
            $obj->do_upload('inspection_document',$user_id,'inspection_document',$vehicle_id);
           
            $vehicle_arr = array(
                'inspection_issue_date'         =>$this->input->post('inspection_issue_date'),
                'inspection_expiry_date'         =>$this->input->post('inspection_expiry_date'),
                'inspection_approval_status'    =>2,
                'updated_date'  =>date('Y-m-d H:i:s'),
                );
                $vehicle_id = $this->Auth_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id,'id'=>$vehicle_id),$vehicle_arr);
            $this->set_response(['status'=>true,'message'=>'Uploaded successfully'], REST_Controller::HTTP_OK);
        } 
    }

    /* check expiry document */
    public function check_document_expiry_get()
    {
        $vehicle_query = $this->Auth_model->get_current_active_vehicle($this->user_data->id);
        $license_expiry=false;
        $insurance_expiry=false;
        $car_expiry=false;
        $driver_rest_time=false;
        $change_vehicle=false;
        $identification_expiry=false;
        $inspection_expiry=false;
        if ($vehicle_query->num_rows()>0) {
            $vehicle_detail = $vehicle_query->row(); 
            if(strtotime($vehicle_detail->license_expiry_date)<strtotime(date('Y-m-d')) || empty($vehicle_detail->license_expiry_date))

                $license_expiry=true;

            if(strtotime($vehicle_detail->insurance_expiry_date)<strtotime(date('Y-m-d')) || empty($vehicle_detail->insurance_expiry_date))

                $insurance_expiry=true;

            if(strtotime($vehicle_detail->car_expiry_date)<strtotime(date('Y-m-d')) || empty($vehicle_detail->car_expiry_date))

                $car_expiry=true;

            if(date('Y')-$vehicle_detail->year>15)

                $change_vehicle=true;                        

            if(strtotime(date('Y-m-d H:i:s'))>(strtotime($vehicle_detail->inspection_expiry_date))){
                $inspection_expiry=true;
            } 
           /*  if(strtotime($vehicle_detail->license_expiry_date)<strtotime(date('Y-m-d')) || (strtotime($vehicle_detail->car_expiry_date)<strtotime(date('Y-m-d'))) || (strtotime($vehicle_detail->insurance_expiry_date)<strtotime(date('Y-m-d')))|| (date('Y')-$vehicle_detail->year>15) || (strtotime(date('Y-m-d H:i:s'))>(strtotime($vehicle_detail->inspection_expiry_date))))
                $document_expire=true; */
        }

        $login_query = $this->db->query("SELECT user_id,identification_expiry_date,login_time,gcm_token as driver_fcm_token FROM ".Tables::USER." WHERE user_id=".$this->user_data->id); 

        if($login_query->num_rows()>0 && ((strtotime(date('Y-m-d H:i:s'))-strtotime($login_query->row()->login_time))/3600>=12) && ((strtotime(date('Y-m-d H:i:s'))-strtotime($login_query->row()->login_time))/3600<=17)){
            $driver_rest_time=true;
        } 
        $this->set_response(['status'=>true,'license_expiry'=>$license_expiry,'insurance_expiry'=>$insurance_expiry,'car_expiry'=>$car_expiry,'driver_rest_time'=>$driver_rest_time,'change_vehicle'=>$change_vehicle,'identification_expiry'=>$identification_expiry,'inspection_expiry'=>$inspection_expiry],REST_Controller::HTTP_OK);
    }
            // For logout    public function logout_post(Type $var = null)    {              $device_token='0';        $device_id='0';                    $data=$this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('device_type'=>$device_id,'device_token'=>$device_token));       $data=$this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('is_logged_in'=>2,'is_online'=>3));             //print_r($data);die;       $this->set_response(['status'=>true,'message'=>'You have logged out successfully','data'=>$this->user_data->id],REST_Controller::HTTP_OK);    }    /* update login */    public function updateloginlogout_post()    {        $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('is_logged_in'=>$this->input->post('status')));                $this->set_response(['status'=>true],REST_Controller::HTTP_OK);    }    public function checkdevicetoken_post()    {                    $userid=$this->user_data->id;             $data= $this->Auth_model->getdeviceToken('users',$userid);          $this->set_response(['status'=>true,'message'=>'success','device_type'=>$data[0]->device_type,'device_token'=>$data[0]->device_token],REST_Controller::HTTP_OK);        }
    // For logout/*
    public function logout_post(Type $var = null)
    {
       $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('is_logged_in'=>2,'is_online'=>3));
       $this->set_response(['status'=>true,'message'=>'You have logged out successfully'],REST_Controller::HTTP_OK);
    }
    
    public function updateloginlogout_post()
    {
        $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('is_logged_in'=>$this->input->post('status')));        
        $this->set_response(['status'=>true],REST_Controller::HTTP_OK);
    }
    public function checkdevicetoken_post()    {            
        $userid=$this->user_data->id;     
        $data= $this->Auth_model->getdeviceToken('users',$userid);  
        $this->set_response(['status'=>true,'message'=>'success','device_type'=>$data[0]->device_type,'device_token'=>$data[0]->device_token],REST_Controller::HTTP_OK);
        }

     
    public function rideTime_post()
    {
		//echo $this->user_data->id; die;
		
		$ride_details = $this->Auth_model->getCustomFields(Tables::RIDE,array('user_id'=>$this->user_data->id,'ride_id'=>$this->input->post('ride_id')),'time');
				
			$ride_time=$ride_details->row()->time;
			$t=date('Y-m-d H:i:s', time());
			$data=array(
			'ride_created_time'=>$ride_time,
			'current_time'=>$t,
			);			
		
        
        $this->set_response(['status'=>true,'result'=>$data],REST_Controller::HTTP_OK);
    }

    /*############# 
    seconds convert to hours minutes Start 
    ##########*/
    public function time_conversion($seconds){

        $init = round($seconds, 0);
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        //$seconds = $init % 60;

        return "$hours:$minutes";
    }

    /*############# 
    seconds convert to hours minutes end
    ##########*/

}

