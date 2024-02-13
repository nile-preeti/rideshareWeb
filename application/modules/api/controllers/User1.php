
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
        $this->load->model(array('api/Auth_model'));
        $this->load->library(array('common/common'));
    }
	
	public function test_post()
	{
       
        $theCredential = $this->user_data;  
        //echo $theCredential->user_id;     
        $this->response($theCredential, 200); // OK (200) being the HTTP response code
        
	}

    public function test_fcm_post($value='')
    {
        $load = array();
        $load['title']  = SITE_TITLE;
        $load['msg']    = 'You have a new ride';
        $load['action'] = 'PENDING';
        $token[] = 'eJZFZ93PeuA:APA91bFSy2sMifBhV-AcXfRNNQEJL6blSZllQ30DJSVd6_os4e18KtEqXzUSLsppALbeKcyI-ri4oJwaI8NTHRDjwOd4zA1kCN-OzR3i56Jklm9MIoAEFGRfiR4f5C_HZcn1xUBsTxJo';        
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

    public function addRide_post() {
        $post_data = $this->input->post();
        $ride_id = $this->Auth_model->save(Tables::RIDE, $post_data);
        if ($ride_id) {
            $this->db->select("gcm_token");
            $this->db->from("users u");
            $this->db->join("rides r", "r.driver_id = u.user_id");
            $this->db->where("r.ride_id", $ride_id);
            $qry = $this->db->get();
            $res = $qry->row();

            $load = array();
            $load['title'] = SITE_TITLE;
            $load['msg'] = 'You have a new ride';
            $load['action'] = 'PENDING';
            $token[] = $res->gcm_token;

            $admin = $this->db->get("admin")->row();
            $this->common->android_push($token, $load, $admin->api_key);
           $this->response(array("status" => true, 'message'=>'',"data" => $post_data));
        }else{
            $this->response(array("status" => false, 'message'=>'Error Try LAter.',"data" => ""));
        }
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
        if ($feedback_id) {
           $this->set_response(array('status'=>true,'message'=>'Your feedback has been saved successfully'), REST_Controller::HTTP_OK);
        }else{
            $this->set_response(array('status'=>false,'message'=>'Error occurred, Please try after some time'), REST_Controller::HTTP_OK);
        }
    }
    /* Get type */

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

    public function postRideToDriver_post()
    {
       
        $lat        = $this->input->post('pickup_lat');
        $long       = $this->input->post('pickup_long');
        $drop_long  = $this->input->post('drop_long');
        $drop_long  = $this->input->post('drop_long');
        $user_id    = $this->user_data->id;//$this->input->post('user_id');
        $distance   = $this->input->post('distance');
        $post_data  = $this->input->post();
        
        $res_query = $this->Auth_model->getDriverFromUser($lat,$long,$distance,$post_data['vehicle_type_id']+1);
        //echo $this->db->last_query();die;
        //die;
        if ($res_query->num_rows()>0) {
            $post_data['driver_id'] = $res_query->row()->user_id;
            $post_data['status'] = 'NOT_CONFIRMED';
            $ride_id = $this->Auth_model->save(Tables::RIDE,$post_data);
            $post_data['ride_id'] = $ride_id;
            if ($ride_id) {
                $res_query->row()->ride_id = $ride_id;
                $qry = $this->Auth_model->get_current_ride($ride_id);
                $res = $qry->row();
                if (!empty($res_query->row()->total_driver_ride)) {
                    $total_rating=($res_query->row()->total_rating/$res_query->row()->total_driver_ride);
                }else{
                    $total_rating=0;
                }
                $res_query->row()->total_rating = bcadd(0,( $total_rating), 1);
                $res_query->row()->total_time = bcadd(0,($res_query->row()->distance/30)*60, 2);
                $res_query->row()->total_distance = bcadd(0,($res_query->row()->distance*0.62), 2);
                $res_query->row()->ride_status = $res->ride_status;
                $load = array();
                $load['title']  = SITE_TITLE;
                $load['msg']    = 'You have a new ride';
                $load['action'] = 'PENDING';
                //$token[] = $res->gcm_token;                
                //$this->common->android_push($token, $load, FCM_KEY);
                $this->response(array("status" => true, 'message'=>'Ride confirmed.',"ride_detail" =>$res_query->row()));
            }else{
                $this->response(array("status" => false, 'message'=>'Error occurred, please try after some time1',"data" =>''));
            }
        }else{
            $this->response(array("status" => false, 'message'=>'Error occurred, please try after some time2',"data" =>''));
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

    public function rides_get() {        
        $id = $this->input->get('id');;
        $status = $this->input->get('status');
        $utype = $this->input->get('utype');
        $res =$this->Auth_model->getRide($this->user_data);
        $ride_detail =array();
        if ($res->num_rows()>0) {
            foreach ($res->result() as $row) {                
                $ride_detail[] = array(
                    "ride_id"=> $row->ride_id,
                    "user_id"=> $row->user_id,
                    "driver_id"=> $row->driver_id,
                    "pickup_adress"=> $row->pickup_adress,
                    "drop_address"=> $row->drop_address,
                    "pikup_location"=> $row->pikup_location,
                    "pickup_lat"=> $row->pickup_lat,
                    "pickup_long"=> $row->pickup_long,
                    "drop_locatoin"=> $row->drop_locatoin,
                    "drop_lat"=> $row->drop_lat,
                    "drop_long"=> $row->drop_long,
                    "distance"=> $row->distance,
                    "status"=> $row->status,
                    "payment_status"=> $row->payment_status,
                    "pay_driver"=> $row->pay_driver,
                    "payment_mode"=> $row->payment_mode,
                    "amount"=> $row->amount,
                    "time"=> $row->time,
                    "user_mobile"=> $row->user_mobile,
                    "user_avatar"=> $row->user_avatar,
                    "driver_avatar"=> $row->driver_avatar,
                    "user_name"=> $row->user_name,
                    "driver_mobile"=> $row->driver_mobile,
                    "driver_name"=> $row->driver_name,
                    "vehicle_type_name"=> $row->vehicle_type_name,
                    "audio"=> $this->Auth_model->getCustomFields(Tables::RIDE_AUDIO,array('ride_id'=>$row->ride_id,'user_id'=>$this->user_data->id),'IFNULL(CONCAT("'.base_url('uploads/audio_capture/').'",audio_file)," ") as audio')->result(),
                );
            }
        }        
        $this->response(array("status" => true, "data" => $ride_detail));
    }

    public function earn_post() {
        $driver_id =$this->user_data->id;
        //echo $driver_id;
        if (!empty($driver_id)) {
           
            $qry = $this->db->query("SELECT round(sum(amount),2) as month_earning,IFNULL((SELECT round(sum(amount),2) as earning FROM `rides` where driver_id = " . $driver_id . " and `time` >= DATE_SUB(NOW(), INTERVAL 7 DAY) and payment_status = 'PAID' group by driver_id),0) as week_earning,IFNULL((SELECT round(sum(amount),2) as earning FROM `rides` where driver_id = " . $driver_id . " and payment_status = 'PAID' group by driver_id),0) as total_earning,IFNULL((SELECT round(sum(amount),2) as earning FROM `rides` where driver_id = " . $driver_id . " and `time` >= DATE_SUB(NOW(), INTERVAL 1 DAY) and payment_status = 'PAID' group by driver_id),0) as today_earning,(SELECT count(ride_id) FROM `rides` where driver_id = " . $driver_id . " AND status='COMPLETED') as total_rides FROM `rides` where driver_id = " . $driver_id . " group by driver_id");
            //echo $this->db->last_query();
            $unit = $this->db->get_where("settings", array("name" => "UNIT"))->row();
            //echo $this->db->last_query();
            $res = $qry->row();
            
            if(empty($res)){
                //$res = (object)array();
                $res->month_earning = !empty($res->month_earning) ? $res->month_earning : '';
                $res->week_earning = !empty($res->week_earning) ? $res->week_earning : '';
                $res->total_earning = !empty($res->total_earning) ? $res->total_earning : '';
                $res->today_earning = !empty($res->today_earning) ? $res->today_earning : '';
                $res->total_rides = !empty($res->total_rides) ? $res->total_rides : '';
            }
            $res->unit = $unit->value;
            $url = base_url();
            $id = $driver_id;
             $qry = $this->db->query("select r.*,w.mobile as user_mobile,concat('$url','',w.avatar) as avatar,w.name as username from rides r left join users as w on r.user_id=w.user_id where r.driver_id = $id and r.status = 'ACCEPTED' order by r.ride_id desc limit 1");
             
                $rides = $qry->row();
                $res->request = (object) $rides;
            //echo $this->db->last_query();
            $this->response(array("status" => true, "data" => $res));
           
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
    public function get_ride_status_post()
    {

        $res = $this->Auth_model->getCustomFields(Tables::RIDE,array('ride_id'=>$this->input->post('ride_id'),'user_id'=>$this->user_data->id),'*');
       
        if ($res->num_rows()>0) {
            $row = $res->row();
            //$query = $this->Auth_model->getCustomFields(Tables::RIDE_AUDIO,array('ride_id'=>$this->input->post('ride_id')),'IFNULL(CONCAT("'.base_url('uploads/audio_capture/').'",audio_file)," ") as audio');
            //$row->audio =  $query->result();
           $this->response(array("status" => true, "data" =>$row ));  
        }else{
            $this->response(array("status" => false, "message" => 'Error occurred, please try after some time')); 
        }
    }

    /* change password */

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
            $affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('name'=>$this->input->post('name'),'mobile'=>$this->input->post('mobile')));
           
            if ($affected) {
                if (!empty($_FILES['profile_pic']['name'])) {                    
                    $this->upload_profile_pic_post();
                }
                $this->set_response(['status'=>true,'message'=>'You profile has been changed successfully','data'=>array('name'=>$this->input->post('name'),'mobile'=>$this->input->post('mobile'))], REST_Controller::HTTP_OK);
            }else{
                $this->set_response(['status'=>false,'message'=>'Error occurred, Please try after some time'], REST_Controller::HTTP_OK);
            }
        }
    }

    public function upload_profile_pic_post()
    {
       if (!is_dir('uploads/profile_image/'.$this->user_data->id)) {
            mkdir('./uploads//profile_image/'.$this->user_data->id, 0777, TRUE);
        }
        $config['upload_path']   = './uploads//profile_image/'.$this->user_data->id; 
        $config['allowed_types'] = 'jpg|png'; 
        $config['max_size']      = 10000; 
        //$config['max_width']     = 1024; 
        //$config['max_height']    = 768; 

        $path_info = pathinfo($_FILES['profile_pic']['name']);
        ////echo $path_info['extension'];
        $new_name = time().'ocory'.$path_info['extension'];
        //die;
        $config['file_name'] = $new_name; 
        //$config['file_name'] = $_FILES['file']['name'];
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
            
         if ( ! $this->upload->do_upload('profile_pic')) {

            $error = array('error' => $this->upload->display_errors()); 
            $this->set_response(['status'=>false,'message'=>$this->upload->display_errors()],REST_Controller::HTTP_OK);
            
            
         }else { 
            $file_array = $this->upload->data();            
                  
            $affected = $this->Auth_model->update(Tables::USER,array('user_id'=>$this->user_data->id),array('avatar'=>$file_array['file_name']));
            if ($affected) {
                $this->set_response(['status'=>true,'message'=>'Profile has been updated successfully'],REST_Controller::HTTP_OK);
            }else{
                $this->set_response(['status'=>false,'message'=>'Error occurred, Please after some time'],REST_Controller::HTTP_OK);
            }
            
        } 
    } 

    /* get profile */
    public function get_profile_get()
    {
        $query = $this->Auth_model->get_profile_detail($this->user_data);
        //echo $this->db->last_query();
        //print_r($query);die;
        if ($query->num_rows()>0) {
            $this->set_response(['status'=>true,'message'=>'Successfully','data'=>$query->user_detail],REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status'=>false,'message'=>'Error occurred, Please after some time'],REST_Controller::HTTP_OK);
        }
    }

    
    
    




}
