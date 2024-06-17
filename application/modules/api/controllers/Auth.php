<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Auth extends BD_Controller {

    function __construct()
    {
        // Construct the parent class savaran,95
        parent::__construct();
        
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Auth_model');
        $this->load->library('common/common');
		$this->config->load('config');
    }
    
    /*################################ 
    For Customer Login
	Developer :Ram 	
	##################################*/

    public function login_post(){
        
        $email = $this->post('email'); 
        $password = md5($this->input->post('password')); //Pasword Posted
        $kunci = $this->config->item('thekey');       
		$device_type = $this->config->item('device_type');       
		$device_token = $this->input->post('device_token');        
        $invalidLogin = []; //Respon if login invalid
        $query = $this->Auth_model->getCustomFields(Tables::USER,array('email'=>$email),'*'); //Model to get single data row from database base on username 
            
        if($query->num_rows() == 0){
            $this->response(['status'=>false,'message'=>'Your email is incorrect.'], REST_Controller::HTTP_OK);
        }else{
            $val = $query->row();
    		$match = $val->password;   //Get password for user from database
            if($val->is_deleted == 0){
				if($password == $match){  //Condition if password matched
				    if ($val->utype!=$this->input->post('utype')) {
					   $this->response(['status'=>false,'message'=>'This page is not authorize for you'], REST_Controller::HTTP_OK);
				    }else if ($val->status==0) {
						$this->response(['status'=>false,'message'=>'Please first verify your account'], REST_Controller::HTTP_OK);
					}else{
						if($val->is_logged_in==1){
							$this->response(['status'=>false,'message'=>'It seems you are already logged in into another device. Kindly logout and then Login here or contact us at info@ridesharerates.com.'], REST_Controller::HTTP_OK);
						}
						if (!empty($this->input->post('gcm_token'))) {
							$this->Auth_model->Update(Tables::USER,array('user_id'=>$val->user_id),array("gcm_token" => $this->input->post('gcm_token')));
							}                                                            
							if (!empty($this->input->post('device_type'))) {
								$this->Auth_model->Update(Tables::USER,array('user_id'=>$val->user_id),array("device_type" => $this->input->post('device_type')));
								}                    
							if (!empty($this->input->post('device_token'))) { 
							$this->Auth_model->Update(Tables::USER,array('user_id'=>$val->user_id),array("device_token" => $this->input->post('device_token')));                    }
						
						//echo (strtotime(date('Y-m-d H:i:s'))-strtotime($val->login_time))/3600;
						//if((strtotime('Y-m-d H:i:s')-strtotime($val->login_time))>=12)
                        $this->load->library('firebase_lib');       
                        $database = $this->firebase_lib->getDatabase();
                        $fbdata = $database->getReference('driver/'.$val->user_id)->getValue();                    
                        
                        if($fbdata){                                                     
                            $this->Auth_model->Update(Tables::USER,array('user_id'=>$val->user_id),array('latitude'=>$fbdata['latitude'],'longitude'=>$fbdata['longitude']));
                        }
                        //die;
						if($val->utype==2 && ((((strtotime(date('Y-m-d H:i:s'))-strtotime($val->login_time))/3600)>=17) || empty($val->login_time))){

                            
                            
							$this->Auth_model->Update(Tables::USER,array('user_id'=>$val->user_id),array('login_time'=>date('Y-m-d H:i:s'),'offline_time'=>NULL));
						}
						$is_card = false;
						$check_card = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('user_id'=>$val->user_id),'id');
						if ($check_card->num_rows()) {
							$is_card = true;
						}
						$add_card = false;
						if (($val->country=='United States') || ($val->country=='India')) {
							$add_card=true;
						}
						$val->gcm_token =$this->input->post('gcm_token');
						$val->is_card=$is_card;
						$val->add_card=$add_card;
						$vehicle_query = $this->Auth_model->get_current_active_vehicle($val->user_id);  
								
						if ($vehicle_query->num_rows()>0) {
							$vehicle_detail = $vehicle_query->row();                    
							if(empty($vehicle_detail->license_expiry_date))
								$license_expiry=true;
							else
								$license_expiry=false;
							if(empty($vehicle_detail->insurance_expiry_date))
								$insurance_expiry=true;
							else
								$insurance_expiry=false;
							if(empty($vehicle_detail->car_expiry_date))
								$car_expiry=true; 
							else  
							$car_expiry=false;                                            
						}else{                        
							$license_expiry=true;
							$insurance_expiry=true;
							$car_expiry=true; 
						}
						$val->license_expiry= $license_expiry;
						$val->insurance_expiry=$insurance_expiry;
						$val->car_expiry=$car_expiry;
						$val->current_time=date('Y-m-d H:i:s');
						unset($val->password);
						
						
						//custom_log('error', 'This is an error message.');
						$this->Auth_model->Update(Tables::USER,array('user_id'=>$val->user_id),array("is_logged_in" => 1));
						$this->Auth_model->delete_by_condition(Tables::LOGIN_TOKEN,array('user_id'=>$val->user_id));
						$token['id']         = $val->user_id;  //From here
						$token['name']         = $val->name;  //From here
						$token['email']      = $val->email;
						$token['utype']      = $val->utype;                                        
						$date                = new DateTime();
						$token['iat']        = $date->getTimestamp();
						$token['exp']        = $date->getTimestamp() + 60*60*24*365; //To here is to generate token
						$output['status']    = true;                    
						$output['message']   = 'Login successfully'; 
						$output['data']      = $val; 
						$output['token']     = JWT::encode($token,$kunci ); //This is the output token
						$obj = modules::load('admin');
						$obj->custom_log('info','This is an informational message.');
						$this->Auth_model->save(Tables::LOGIN_TOKEN,array('user_id'=>$val->user_id,"token"=>$output['token'],'created_date'=>date('Y-m-d H:i:s')));
						$this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
					}
				}else{
					$this->set_response(['status'=>false,'message'=>'Your password is incorrect.'], REST_Controller::HTTP_OK); //This is the respon if failed
				}
			}else{
				$this->set_response(['status'=>false,'message'=>'This account does not exist with Ridesharerates.'], REST_Controller::HTTP_OK); //This is the respon if failed
			}
        }
    }
	
   
	/*################################ 
    For Customer registration
	Developer :Ram 		
	##################################*/
	
    public function register_post()
    {
       $dob=$this->input->post('dob');
        $age=$this->ageCalculator($dob);
		
       /* if($this->input->post('utype')==2 && $age<18){
            $message="minimum required age is 18 Years";
            $this->set_response(['status'=>false,'message'=>$message],REST_Controller::HTTP_OK);
            
        }else if($this->input->post('utype')==1 && $age<18){
            $message="minimum required age is 18 Years";
            $this->set_response(['status'=>false,'message'=>$message],REST_Controller::HTTP_OK);
            
        }else{ */
       
        $kunci = $this->config->item('thekey');
        $this->form_validation->set_rules('name','User Name','required');
        $this->form_validation->set_rules('email','Email','required|valid_email|callback_email_check');
		$this->form_validation->set_rules('country_code','Country Code','required');
        $this->form_validation->set_rules('mobile','Mobile','required|min_length[10]|max_length[15]|callback_mobile_check');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('utype','User Type','required');
        $this->form_validation->set_error_delimiters('','');
        if ($this->form_validation->run()==false) {
          
            if (form_error('name')) {
                $message = form_error('name');
            }else if (form_error('email')) {
                $message= form_error('email');					
            }else if (form_error('country_code')) {
                $message= form_error('country_code');
            }else if (form_error('mobile')) {
                $message= form_error('mobile');
            }else if (form_error('password')) {
                $message= form_error('password');
            }else if (form_error('utype')) {
                $message= form_error('utype');
            }

            /*'name'=>form_error('name'),               
            'email'=>form_error('email'),
            'mobile'=>form_error('mobile'),
            'password'=>form_error('password'),
            'utype'=>form_error('utype'),*/
          
           
            $this->set_response(['status'=>false,'message'=>$message],REST_Controller::HTTP_OK);
        }else{
            $obj = modules::load('admin');
          
            $randomString = $this->common->Generate_hash(16);    
            $this->load->helper('string');            
            $otp = random_string('alnum', 3) . random_string('numeric', 3);
            $post_data = $this->input->post();
            //$post_data['status'] = 2;
            //$post_data['created_date'] = date('Y-m-d H:i:s');
            //$post_data['otp'] = $otp;
            ///unset($post_data['password']);
            ///$post_data['password'] = md5($this->input->post('password'));
            $address_detail = $this->getAddressDetail($this->input->post('latitude'),$this->input->post('longitude'));
            $countrycode=$this->input->post('country_code');
            $cfirst=substr($countrycode,0,1);
            if($cfirst=='+'){
                $ctrcode=$countrycode;
            }else{
                $ctrcode='+'.$countrycode;
            }

			$user_arr =array(
                'name'=>ucfirst($this->input->post('name')),
                'email'=>strtolower($this->input->post('email')),
                'name_title'=>strtolower($this->input->post('name_title')),
                'last_name'=>strtolower($this->input->post('last_name')),
				'country_code'=>$ctrcode,
                'mobile'=>$this->input->post('mobile'),
                'password'=>md5($this->input->post('password')),
				'countrycode_mobile'=>$ctrcode.$this->input->post('mobile'),
                'random'=>$randomString,
                'utype'=>$this->input->post('utype'),
                'status'=>($this->input->post('utype')==2)?3:1,
                'gcm_token'=>$this->input->post('gcm_token'),
                'country'=>$address_detail['country'],
                'state'=>$address_detail['state'],
                'city'=>$address_detail['city'],
                'latitude'=>$this->input->post('latitude'),
                'longitude'=>$this->input->post('longitude'),
                'gcm_token'=>$this->input->post('gcm_token'),
                'ssn'=>$this->input->post('ssn'),
                'login_time'=>date('Y-m-d H:i:s'),
                'is_logged_in'=>2,
                'identification_document_id'=>$this->input->post('identification_document_id'),
                'identification_issue_date'=>$this->input->post('identification_issue_date'),
                'identification_expiry_date'=>$this->input->post('identification_expiry_date'),
                'dob'=>date('Y-m-d',strtotime($this->input->post('dob'))),
                'home_address'=>$this->input->post('home_address'),
                'otp'=>$otp,
                'total_working_hour'=>0,
                'is_online'=>3,
                'created_date'=>date('Y-m-d H:i:s'),
                'updated_date'=>date('Y-m-d H:i:s'),                
            );
            //$post_data['status']=1;
            //$post_data['is_online']=1;
            $this->db->trans_begin();
            $user_id =$this->Auth_model->save(Tables::USER,  $user_arr);
            if ($user_id){
                if (!empty($_FILES['avatar']['name'])) {
                    $obj->do_upload_profile('profile_image',$user_id,'avatar');
                    $this->Auth_model->update(Tables::USER,array('user_id'=>$user_id),array('profile_upload_date'=>date('Y-m-d')));
                }
                if (!empty($_FILES['verification_id']['name'])){
                    $obj->do_upload_profile('verification_document',$user_id,'verification_id');
                }

                if ($this->input->post('utype')==2) {
                   $vehicle_arr = array(
                    'user_id'       =>$user_id,
                    'brand_id'      =>$this->input->post('brand'),
                    'model_id'      =>$this->input->post('model'),
                    'year'          =>$this->input->post('year'),
                    'color'         =>$this->input->post('color'),
                    /* 'license_expiry_date'         =>$this->input->post('license_expiry_date'),
                    'license_issue_date'         =>$this->input->post('license_issue_date'),
                    'insurance_issue_date'         =>$this->input->post('insurance_issue_date'),
                    'insurance_expiry_date'         =>$this->input->post('insurance_expiry_date'),
                    'car_issue_date'         =>$this->input->post('car_issue_date'),
                    'car_expiry_date'         =>$this->input->post('car_expiry_date'), */
                    //'seat_no'         =>$this->input->post('seat_no'),
					'seat_no' 				=>2,
                    'premium_facility'  =>$this->input->post('premium_facility'),
                    'vehicle_no'        =>$this->input->post('vehicle_no'),
                    'vehicle_type_id'   =>$this->input->post('model'), 
                    'created_date'      =>date('Y-m-d H:i:s'),
                    'updated_date'      =>date('Y-m-d H:i:s'),
                   );

                   $vehicle_id = $this->Auth_model->save(Tables::VEHICLE_DETAIL,$vehicle_arr);
                   //print_r($vehicle_id->model_id);die;
                   if($vehicle_id) {
                    $this->get_vehicle_type_sheet_get($this->input->post('seat_no'),$vehicle_id,$user_id);
                      
                        //$theCredential = $this->user_data; 
                        //$user_id = $theCredential->id;
                        
                        /* if (!empty($_FILES['insurance']['name'])) {
                            $obj->do_upload('insurance_document',$user_id,'insurance',$vehicle_id);
                        }
                        if (!empty($_FILES['license']['name'])) {   
                            $obj->do_upload('license_document',$user_id,'license',$vehicle_id);
                        } */
                       /*  if (!empty($_FILES['permit']['name'])) {  
                            $obj->do_upload('permit_document',$user_id,'permit',$vehicle_id);
                        } */
                        if (!empty($_FILES['car_pic']['name'])) {
                            $obj->do_upload('car_pic',$user_id,'car_pic',$vehicle_id);
                        }
                        /* if (!empty($_FILES['car_registration']['name'])) {
                            $obj->do_upload('car_registration',$user_id,'car_registration',$vehicle_id);
                        } */
                   }
                }

               /* $rand = random_string('alnum', 8) . random_string('numeric', 8) . random_string('alnum', 8) . random_string('numeric', 8);
                $datakey = array(
                    "user_id"   => $user_id,
                    "key"       => $rand,
                    "user_type" =>$this->input->post('utype'),
                );*/
                //$this->Auth_model->save(Tables::KEY, $datakey);
                ///$this->response(array("status" => true, 'message'=>'Document uploaded successfully',"data" =>''));
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->set_response(['status'=>false,'message'=>'Please try again, Something is wrong.'],REST_Controller::HTTP_OK);
            
            }else{
                
                
                $res = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$user_id),'*');
                $row = $res->row();
                $add_card = false;
                if (($row->country=='United States') || ($row->country=='India')) {
                    $add_card=true;
                }
                $this->welcome_mail($res->row());                
                $this->db->trans_commit();
                ///$this->Auth_model->update(Tables::USER,array('user_id'=>$user_id),array('is_logged_in'=>1));
                $token['id']        = $user_id;  //From here
                $token['email']     = $this->input->post('email');
                $date               = new DateTime();
                $token['iat']       = $date->getTimestamp();
                $token['exp']       = $date->getTimestamp() + 60*60*24; //To here is to generate token
                
                $output['status']   = true; 
                $output['message']  = 'Your registration was successful.'; 
                $output['data']     = array('user_id'=>(string)$user_id,'utype'=>$this->input->post('utype'),'username'=>ucfirst($this->input->post('name')),'email'=>strtolower($this->input->post('email')),'mobile'=>$this->input->post('mobile'),'otp'=>$otp,'status'=>$row->status,'is_card'=>false,'add_card'=>$add_card); 
                $output['token']    = JWT::encode($token,$kunci ); //This is the output token
                $this->set_response($output, REST_Controller::HTTP_OK);
               /*----------------------------------*/
                //$this->set_response(['status'=>true,'message'=>'Otp has been sent to '.$this->input->post('email')],REST_Controller::HTTP_OK);
            }
        }
      //}
    }

    
	 
    /*################################ 
		For getting address details
		Developer :Ram 	
	##################################*/
    function getAddressDetail($lat='',$long='')
    { 

        $url  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=false&key=".GOOGLE_MAP_API_KEY;
        
        $json = file_get_contents($url);
        $data = json_decode($json);
       // print_r($data);
        
        $address_detail = array();
        if($data->status=='OK'){
            $add_array  = $data->results;
            $add_array = $add_array[0];
            $add_array1 = $add_array->address_components;
            $address_detail['city'] = '';
            $address_detail['country'] = '';
            $address_detail['state'] = '';
            foreach ($add_array1 as $key){
                if($key->types[0] == 'administrative_area_level_2')
                {
                    $address_detail['city'] = $key->long_name;
                }
                if($key->types[0] == 'administrative_area_level_3')
                {
                    $address_detail['city'] = $key->long_name;
                }
                if($key->types[0] == 'administrative_area_level_1')
                {
                    $address_detail['state'] = $key->long_name;
                }
                if($key->types[0] == 'country')
                {
                    $address_detail['country'] = $key->long_name;
                }
            }
        }else{
            $address_detail['city'] = '';
            $address_detail['country'] = '';
            $address_detail['state'] = '';
        }
        //print_r($address_detail);
         return $address_detail;// $address = $data->results[0]->formatted_address;
    }
	
	/*################################ 
	Developer :Ram 	
    otp Authentication 
	##################################*/
	
    public function resend_post()
    {
        $res = $this->Auth_model->getCustomFields(Tables::USER,array('email'=>$this->input->post('email')),'*');
        if ($res->num_rows()>0) {
            $this->load->helper('string');            
            $otp = random_string('numeric', 6);
            $this->Auth_model->update(Tables::USER,array('email'=>$this->input->post('email')),array('otp'=>$otp));
            $query = $this->Auth_model->getCustomFields(Tables::USER,array('email'=>$this->input->post('email')),'*');
             $row=$query->row();
            $this->verification_mail($row);
           /* $token['id']        = $row->user_id;  //From here
            $token['email']     = $this->input->post('email');
            $date               = new DateTime();
            $token['iat']       = $date->getTimestamp();
            $token['exp']       = $date->getTimestamp() + 60*60*5; //To here is to generate token
            $output['status']   = true; 
            $output['message']  = 'Otp has been sent to your registered email'; 
            $output['data']     = array('user_id'=>$row->user_id,'utype'=>1,'username'=>ucfirst($row->username),'email'=>strtolower($row->email),'mobile'=>$row->mobile,'otp'=>$otp); 
            $output['token']    = JWT::encode($token,$kunci ); //This is the output token
           
            $this->set_response($output, REST_Controller::HTTP_OK);*/
            $this->set_response(['status'=>true,'message'=>'OTP has been sent to '.$this->input->post('email')],REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status'=>false,'message'=>'Email does not exist'],REST_Controller::HTTP_OK);
        }
    }

    // For verification
    public function verification_success_post()
    {
        
        $res = $this->Auth_model->getCustomFields(Tables::USER,array('email'=>$this->input->post('email'),'status'=>2),'*');
        if ($res->num_rows()>0) {
            $row=$res->row();
            unset($row->password);
            if ((string)$row->otp == (string)$this->input->post('otp')) {
                $kunci = $this->config->item('thekey');
                if ($row->utype==2) {
                    $affected_row = $this->Auth_model->update(Tables::USER ,array('user_id'=>$row->user_id),array('status'=>3));// pending approval from admin
                }else{
                    $affected_row = $this->Auth_model->update(Tables::USER ,array('user_id'=>$row->user_id),array('status'=>1));
                }
               
                if ( $affected_row) {
                    $row->status=1;
                    $this->sendRegistrationEmail($row);
                    $token['id']        = $row->user_id;  //From here
                    $token['email']     = $this->input->post('email');
                    $date               = new DateTime();
                    $token['iat']       = $date->getTimestamp();
                    $token['exp']       = $date->getTimestamp() + 60*60*5; //To here is to generate token
                    $output['status']   = true; 
                    $output['message']  = 'Registration successfully'; 
                    $output['data']     = $row; 
                    $output['token']    = JWT::encode($token,$kunci ); //This is the output token
                    $this->set_response($output, REST_Controller::HTTP_OK);
                }else{
                    $this->set_response(['status'=>false,'message'=>'Please try again, Something is wrong.'],REST_Controller::HTTP_OK);
                }
               
            }else{
                 $this->set_response(['status'=>false,'message'=>"Incorrect OTP"],REST_Controller::HTTP_OK);
            }
        }else{
            $this->set_response(['status'=>false,'message'=>'Please try again, Something is wrong.'],REST_Controller::HTTP_OK);
        }
    }
    /* Check email is exist */
    public function email_check() {        
        $num   = $this->Auth_model->getSingleRecord(Tables::USER, array('email' => strtolower($this->input->post('email'))));
        if ($num->num_rows()) {
           $this->form_validation->set_message('email_check', 'This email has already been registered.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	 /* Check Mobile is exist */
    public function mobile_check() {        
        $num   = $this->Auth_model->getSingleRecord(Tables::USER, array('mobile' => $this->input->post('mobile')));
        if ($num->num_rows()) {
           $this->form_validation->set_message('mobile_check', 'This number is already registered with another RideShareRates account.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* Forgot password */
    public function forgot_password_post()
    {
        $res = $this->Auth_model->getCustomFields(Tables::USER,array('email'=>$this->input->post('email')),'user_id,otp');

            if ($res->num_rows()>0) {
                $row = $res->row();
               
                if ((string) $row->otp == (string) $this->input->post('otp')) {
                    if (!empty($this->input->post('password'))) {
                         $updated = $this->Auth_model->update(Tables::USER,array('user_id'=>$res->row()->user_id),array('password'=>md5($this->input->post('password'))));
                        if ($updated) {
                            $this->set_response(['status'=>true,'message'=>'Password changed successfully'],REST_Controller::HTTP_OK);
                        }
                    }else{
                       $this->set_response(['status'=>false,'message'=>'Password is required'],REST_Controller::HTTP_OK); 
                    }
                   
                }else{
                     $this->set_response(['status'=>false,'message'=>'Incorrect OTP'],REST_Controller::HTTP_OK);
                }
                
            }else{
                $this->set_response(['status'=>false,'message'=>'Please try again, Something is wrong.'],REST_Controller::HTTP_OK);
            }
    }

    /* get model */
    public function getSubcategory_post()
    {
        $query = $this->Auth_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('vehicle_type_category_id'=>$this->input->post('category_id'),'status'=>1),'id,vehicle_type_category_id,title as model_name,seat,rate,short_description');
        if ($query->num_rows()>0) {
           $this->set_response(['status'=>true,'message'=>'','data'=>$query->result()],REST_Controller::HTTP_OK);  
        }
    }
	
	public function get_vehicle_year_post()
    {
        $query = $this->Auth_model->getCustomFields(Tables::VEHICLE_YEAR,array('category_id'=>$this->input->post('category_id'),'status'=>1),'id,category_id,category_year');
        if ($query->num_rows()>0) {
           $this->set_response(['status'=>true,'message'=>'','data'=>$query->result()],REST_Controller::HTTP_OK);  
        }
    }


    /* get Category */
    public function getCategory_get()
    {
        $query = $this->Auth_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'*');
		
			$data = $query->result(); //; die;
			$year_arr=[];
            $cat_arr=[];
				foreach($data as $list){ 
				//echo $id = $list->id;
                
                	if(!empty($list->id)){ 
						
                    $category_year = $this->Auth_model->getCategory_year($list->id);
                    //print_r($category_year);
                    $i=0;
                    foreach($category_year as $yearlist){
                        $year_arr[$i]= array(                            
                            'category_id'=>$yearlist->category_id,
                            'category_year'=>$yearlist->category_year,
                        );
                        $i++;
                    }
                }

                $cat_arr[]=array(
                     'id'=>$list->id,
                    'title'=>$list->title,
                    'status'=>$list->status,
                    'short_description'=>$list->short_description,
                    'created_date'=>$list->created_date,
                    'updated_date'=>$list->updated_date,
                    'year'=>$year_arr
                    
                );
            }
            
           // print_r($year_arr);  die;
        
        if ($query->num_rows()>0) {
           $this->set_response(['status'=>true,'message'=>'','data'=>$cat_arr,],REST_Controller::HTTP_OK);  
        }
    }

    /* get category with year and subcategory for IOS function Start */
    public function getAllCategory_get(){

        $query = $this->Auth_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'*');		
			$data = $query->result(); //; die;
			//print_r(json_encode($data)); die;			
            $cat_arr=[];            
				foreach($data as $list){ 
				$year_arr=[];
				$subCat_arr=[];                
                	if(!empty($list->id)){ 						
                    $category_year = $this->Auth_model->getCategory_year($list->id);
                  
                    foreach($category_year as $yearlist){
						array_push($year_arr,$yearlist->category_year);
						
                    }
					
					$subcategory_list = $this->Auth_model->getSubCategory($list->id);
					
						//array_push($subCat_arr,$subCat_list->title);

						  $i=0;
						foreach($subcategory_list as $subCat_list){
							//print_r($subCat_list); 
							$subCat_arr[$i]= array(                            
								'subcat_id'=>$subCat_list->id,
								'subcat_title'=>$subCat_list->title,
							);
							$i++;
						}
                }
				
                $cat_arr[]=array(
                     'id'=>$list->id,
                    'title'=>$list->title,
                    'status'=>$list->status,
                    'year'=>$year_arr,
                    'Subcategory'=>$subCat_arr,
                    
                );
			}
            
		
        if ($query->num_rows()>0) {
           $this->set_response(['status'=>true,'message'=>'','data'=>$cat_arr,],REST_Controller::HTTP_OK);  
        }
    }
	
	/*#-----
	get category with year and subcategory for IOS function end
	-----#*/
	
     /* get vehicle type */
     public function get_vehicle_type_sheet_get($seat,$vehicle_id='',$user_id='')
     {
         $vehicle_typeid=$this->input->post('model');
       // $seat = $this->input->post('seat');
         $query = $this->db->query("SELECT id,title FROM ".Tables::VEHICLE_SUBCATEGORY_TYPE." where status=1 and id = $vehicle_typeid");
       
        //print_r($query->result());die;
         $result = array();
         $this->Auth_model->delete_by_condition(Tables::VEHICLE_SERVICE,array('user_id'=>$user_id));
        if($query->num_rows()>0)
        foreach ($query->result() as $row){
            
            $this->Auth_model->save(Tables::VEHICLE_SERVICE,array('user_id'=>$user_id,'vehicle_id'=>$vehicle_id,'vehicle_type_id'=>$row->id,'created_date'=>date('Y-m-d H:i:s'),'updated_date'=>date('Y-m-d H:i:s')));
        }
        return true;
         
     }
	 
    /* Get type */

    public function get_vehicle_category_post()
    {
        //$query=$this->Auth_model->getCustomFields(Tables:: VEHICLETYPE,array('status'=>1),'id,title,short_description');
        //$res1=$query->result();
		$query = $this->db->query("SELECT DISTINCT vt.id,vt.title,vt.short_description FROM vehicle_type vt
        INNER JOIN vehicle_subcategory_type vst ON vt.id = vst.vehicle_type_category_id where vt.status =1");

		// Check if there are any results
		if ($query->num_rows() > 0) {
			// Fetch the results as an array
		$categories = $query->result();
		}


        
         $obj = modules::load('admin');
		$i=0;
        foreach($categories as $list){ 
		//print_r($list);
            //echo $id = $list->id;
            if(!empty($list->id)){              
                
				$vehcle_arr[$i] = array(                            
                    'category_id'=>$list->id,
                    'category_name'=>$list->title
                );
				
                $res = $this->Auth_model->getvehicle_byCategory($list->id);
                //print_r($res);
                $post_data = $this->input->post(); 
                //print_r($post_data);
                $flag=0;
                $surge_percentage = 0;
                if (isset($post_data['pickup_lat'])){  
                    $lat1        = $this->input->post('pickup_lat');
                    $long1       = $this->input->post('pickup_long');
                    $lat2        = $this->input->post('drop_lat');
                    $long2       = $this->input->post('drop_long');          
                    //$address_detail = $this->getAddressDetail($lat1,$long1);
                
                    //$get_total_ride=$this->db->query("select count(ride_id) as total_ride from rides where time>='".date('Y-m-d H:i:s',strtotime('- 10 minute'))."' and city='".$address_detail['city']."' group by city");
                
                    //echo $this->db->last_query();
					/* $query=$this->Auth_model->getCustomFields(Tables:: LOCATION,array('pickup_latitude'=>$lat1,'pickup_longitude'=>$long1,'drop_latitude'=>$lat2,'drop_longitude'=>$long2),'*');
					//echo $this->db->last_query();
					$res =$query->result();
					if(!empty($res)){
					print_r($res);	
					}else{
						echo "no data foud!";
					}
					die; */
					
                    //$api_data = $this->get_distance1($lat1,$long1,$lat2,$long2);
                    //print_r($api_data);
					$totaldistance= $this->metersToMiles($this->input->post('distance'));
                    $total_amount=0;
                    if ($totaldistance){
                        //$distance1 = explode(' ',$api_data['distance']); 
                        $distance = $totaldistance; 
                        $time = $this->time_conversion($this->input->post('duration')); 

                        // if($distance1[1]=='ft'){
                        //     $feet = $distance;   
                        //     $distance1 = $feet / 5280; 
                        //     $distance=number_format((float)$distance1, 2, '.', '');
                        
                        //     //$this->response(array("status"=>false,'data'=>$distance, "message"=>"Pickup and drop address is too close. Please Check Again"));
                            
                        // }else{
                        //     $distance = $distance1[0]; 
                        // }
                    	//comment for stastic distance(11-12-2023)END 
						
                        $distancedata=str_replace(',','',$distance);//comment for stastic distance(11-12-2023)END
                      //  $distance=$distanced;

                        $row =array();
                        $surge_amount=0;               
                        foreach ($res as $row_arr) {
                            //print_r($row_arr); 
							$rate=0;
							$base_cahrges=0;
							$surcharge=0;
							$tax=0;
							
							if($row_arr->car_pic){
								$car_image = base_url('uploads/vehicle_image/'). $row_arr->car_pic;
							}else{
								$car_image = base_url('assets/images/avatar/no-vehicle.png');
							}
							$base_cahrges=$row_arr->base_fare_fee;
							$surcharge=$row_arr->surcharge_fee;							
                            $rate_permile= str_replace(',','',$row_arr->rate);//comment for stastic distance(11-12-2023)END 
                            //$rate_permile=$row_arr->rate;
                            $rate = $rate_permile*$distance;
                            
							
							$ride_amount = str_replace(',','',$base_cahrges+$rate+$surcharge);
							$tax=$row_arr->taxes;
                            $parMinuteCharge= $base_cahrges/60;
                            $totalwaitingCharges= $parMinuteCharge*80;
							$taxval = ($tax / 100) * $ride_amount;
							$total_amount=$ride_amount+$taxval;
							$total_amount1=(string)str_replace(',','',$total_amount);
							$holdamt=round($totalwaitingCharges+$total_amount);
							$holdamt1=$holdamt+2;
							$rounded_number = ceil($holdamt1 / 10) * 10;
                            $row[] =array(
                                'vehicle_id'=>$row_arr->vehicle_id,
                                'vehicle_name'=>$row_arr->vehicle_name,
                                'category_id'=>$row_arr->category_id,
                                'base_fare_fee'=>$row_arr->base_fare_fee,
                                'distance'=>bcadd($distancedata,0,2),
                                'time'=>$time,
                                'per_mile_rate'=>$row_arr->rate,
                                'hold_amount'=>(string)$rounded_number,
                                'cancellation_charge'=>$row_arr->cancellation_fee,
                                'category_name'=>$row_arr->category_name,
                                'short_description'=>$row_arr->short_description,
                                'vehicle_image'=>$car_image,
                                //'total_amount'=>sprint('%.2f', $total_amount),                               
                                'total_amount'=>bcadd($total_amount1, 0, 2),                             
                                //'surge_amount'=>bcadd($surge_amount,2)
                            );
                            //array_push($row->amount, $row_arr->rate* $distance);

                            $vehcle_arr[$i]['vehicles'] = $row;
                            //$vehcle_arr[$i]['category_year'] = $category_year;
                        }
                        
                        
                    
                            
                    }else{
                        $this->response(array("status"=>false,"message"=>"Ride is not allowed in this area"));
                    }
                
                }else{
                $distance=0;
                $row =array();
                foreach ($res as $row_arr) {
                    
                    
                    $row[] =array(
                        'vehicle_id'=>$row_arr->id,
                        'vehicle_name'=>$row_arr->title,                        
                        'category_id'=>$row_arr->category_id,
                        'category_name'=>$row_arr->category_name,
                        'rate'=>$row_arr->rate,
                        'short_description'=>$row_arr->short_description,
                        'car_pic'=>$row_arr->car_pic,
                        'total_amount'=>bcadd(($row_arr->rate*str_replace(',', '', $distance)),2),
                    );
                    //array_push($row->amount, $row_arr->rate* $distance);

                    $vehcle_arr[$i]['vehicles'] = $row; 
                    }
                }
				
               

                $i++; 
				
				
            }

        }
        //echo $distance;die;
        
       
        //$result_data = $res->result();

        #---Log Section start--
		
		$obj->custom_log('API',' get_vehicle_category, User Id:  Guest, Mapbox Key: '.MAPBOX_API_KEY);
		#--log End --
        $this->response(array("status" => true, 'message'=>'',"data" => $vehcle_arr,'distance'=> str_replace(',','',bcadd($distancedata,0,2)),'unit'=>'Miles','flag'=>$flag,'surge_percentage'=>$surge_percentage));
    }
	
	
	 public function get_vehicle_categoryOLD_get()
    {
        $query=$this->Auth_model->getCustomFields(Tables:: VEHICLETYPE,array('status'=>1),'id,title,short_description');
        $res=$query->result();
        //print_r($res);die;
        
        
        $i=0;
        foreach($res as $list){ 
            //echo $id = $list->id;
            if(!empty($list->id)){ 
                $vehicle = $this->Auth_model->getvehicle_byCategory($list->id);
                $vehcle_arr[$i] = array(                            
                    'category_id'=>$list->id,
                    'category_name'=>$list->title,
                    'vehicles'=> $vehicle
                );
                //$vehcle_arr[$i] = $vehicle;
                $i++;
            }
            
        }
        
        

        
        if($query->num_rows()>0){
            $this->response(['status'=>true,'message'=>'success','data'=>$vehcle_arr],REST_Controller::HTTP_OK);
            
        }else{
            $this->response(['status'=>false,'message'=>'no data found'],REST_Controller::HTTP_OK) ;
        }
        
    }



    

    /*function distance($lat1, $lon1, $lat2, $lon2, $unit) {
      if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
      }else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
          return ($miles * 1.609344);
        } else if ($unit == "N") {
          return ($miles * 0.8684);
        } else {
          return $miles;
        }
      }
    }*/

    // For testing purpose
    public function test_post($value='')
    {
        echo $this->distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
        echo $this->distance(18.4584776,73.8288571,27.8433315, 79.9178709, "K") . " Kilometers<br>";
        echo $this->distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
    }
    
    // For getting distance between two addresses (commented tis complete on 11-12-2023)
    
	
  
    

	
	
	public function get_distance_static1($lat1,$long1,$lat2,$long2)
    { 
        
                
	 	$dist = "5";
	 	$time = "10";
	 	return array('status'=>true,'distance' => $dist, 'time' => $time);
        
     }

    // For cron job for changing ride
    public function cron_job_for_changing_ride_status_get()
    {
        $query = $this->db->query("SELECT ride_id,user_id,driver_id,status,time,NOW() FROM rides
        WHERE time<= NOW() - INTERVAL 5 MINUTE and status='pending'");
        //print_r($query->result());
    }
   /*  SELECT ride_id,user_id,driver_id,status,time,NOW() FROM rides WHERE time<= NOW() - INTERVAL 3 MINUTE and status='pending' */
    /* Cron job run per day */
    public function get_card_expiry_date_get()
    {
        $query = $this->db->query("SELECT u.gcm_token,cd.expiry_month,cd.expiry_date FROM `card_detail` as cd left JOIN users as u on u.user_id=cd.user_id where cd.expiry_month=".date('m')." and cd.expiry_date=".date('Y'));
       if($query->num_rows()>0){
            foreach($query->result() as $card){
                $expiry_date = $card->expiry_date.'-'.$card->expiry_month;                             
                $month_end = strtotime('last day of this month', time());               
                if((date('d', $month_end)-7)==date('d')) {
                    $load = array();

                    $load['title']  = SITE_TITLE;

                    $load['msg']    = 'No payment method exists. Does not able to start the ride';

                    $load['action'] = 'card_expire';                

                    $token = $card->gcm_token;                

                    $this->common->android_push($token, $load, FCM_KEY);
                }
               
            }
       }
        
    }
    /* user profile pic notification by cron job per day */
    public function send_notification_to_user_get()
    {
        $query = $this->db->query("SELECT gcm_token,profile_upload_date FROM users  where profile_upload_date=NOW() - INTERVAL 3 MONTH and utype=1");
       // echo $this->db->last_query();
       if($query->num_rows()>0){
            foreach($query->result() as $card){                
                    $load = array();
                    $load['title']  = SITE_TITLE;
                    $load['msg']    = 'Please update your profile pic';
                    $load['action'] = 'update_profile';
                    $token = $card->gcm_token;  
                    $this->common->android_push($token, $load, FCM_KEY);
                
               
            }
       }
    }
    /* send notification when profile pic will expired */
    public function send_notification_to_driver_get()
    {
        $query = $this->db->query("SELECT gcm_token,profile_upload_date FROM users  where YEAR(profile_upload_date) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) and utype=2");
        echo $this->db->last_query();
       if($query->num_rows()>0){
            foreach($query->result() as $card){                             
                $load = array();
                $load['title']  = SITE_TITLE;
                $load['msg']    = 'Please update your profile pic';
                $load['action'] = 'update_profile';
                $token = $card->gcm_token;  
                $this->common->android_push($token, $load, FCM_KEY);               
            }
       }
    }
    /* send notification perday*/
    public function send_notification_to_driver_car_expiry_get()
    {
        $query = $this->db->query("SELECT u.name as driver_name,u.gcm_token as driver_fcm_token,vd.id,year,YEAR(now()),(YEAR(now())-year) from vehicle_detail as vd
        left join users as u on u.user_id=vd.user_id
        WHERE  (YEAR(now())-year)>12");
        if($query->num_rows()>0){
            foreach($query->result() as $driver){                
                $load = array();
                $load['title']  = SITE_TITLE;
                $load['msg']    = 'Please change your vehicle';
                $load['action'] = 'update_vehicle';
                $token = $driver->driver_fcm_token;  
                $this->common->android_push($token, $load, FCM_KEY);               
            }
       }
    }
    /* Check document expiration */
    public function get_driver_license_expiry_get()
    {
        $query = $this->db->query("SELECT u.name as driver_name,u.gcm_token as driver_fcm_token,vd.id,year,YEAR(now()),(YEAR(now())-year) from vehicle_detail as vd
        left join users as u on u.user_id=vd.user_id
        WHERE license_expiry_date<DATE(NOW())");
        if($query->num_rows()>0){
            foreach($query->result() as $driver){                
                $load = array();
                $load['title']  = SITE_TITLE;
                $load['msg']    = 'Please Update your License';
                $load['action'] = 'update_vehicle';
                $token = $driver->driver_fcm_token;  
                $this->common->android_push($token, $load, FCM_KEY);               
            }
       }
    }

    /* Check document expiration */
    public function get_driver_car_expiry_get()
    {
        $query = $this->db->query("SELECT u.name as driver_name,u.gcm_token as driver_fcm_token,vd.id,year,YEAR(now()),(YEAR(now())-year) from vehicle_detail as vd
        left join users as u on u.user_id=vd.user_id
        WHERE car_expiry_date<DATE(NOW())");
        if($query->num_rows()>0){
            foreach($query->result() as $driver){                
                $load = array();
                $load['title']  = SITE_TITLE;
                $load['msg']    = 'Please change your vehicle';
                $load['action'] = 'update_vehicle';
                $token = $driver->driver_fcm_token;  
                $this->common->android_push($token, $load, FCM_KEY);               
            }
       }
    }
     /* Check document expiration */
     public function get_driver_insurance_expiry_get()
     {
         $query = $this->db->query("SELECT u.name as driver_name,u.gcm_token as driver_fcm_token,vd.id,year,YEAR(now()),(YEAR(now())-year) from vehicle_detail as vd
         left join users as u on u.user_id=vd.user_id
         WHERE insurance_expiry_date<DATE(NOW())");
         if($query->num_rows()>0){
             foreach($query->result() as $driver){                
                 $load = array();
                 $load['title']  = SITE_TITLE;
                 $load['msg']    = 'Please change your vehicle';
                 $load['action'] = 'update_vehicle';
                 $token = $driver->driver_fcm_token;  
                 $this->common->android_push($token, $load, FCM_KEY);               
             }
        }
     }
     /* Check document expiration */
     public function get_driver_login_time_get()
     {
        $query = $this->db->query("SELECT user_id,gcm_token as driver_fcm_token FROM users WHERE login_time< DATE_ADD('".date('Y-m-d H:i:s')."', INTERVAL -12 HOUR);
         ");
        if($query->num_rows()>0){
            foreach($query->result() as $driver){   
                             
                $load = array();
                $load['title']  = SITE_TITLE;
                $load['msg']    = "You have completed today's 12 hour ride. Kindly rest.";
                $load['action'] = 'complete_twelve_hours';
                $token = $driver->driver_fcm_token;  
                $this->common->android_push($token, $load, FCM_KEY);               
            }
        }
     }
     //document upload
    public function get_documentidentity_get()
    {
        $query=$this->Auth_model->getCustomFields(Tables:: IDENTIFICATION_DOCUMENT,array('status'=>1),'id,document_name');
        if($query->num_rows()>0){
            $this->response(['status'=>true,'data'=>$query->result()],REST_Controller::HTTP_OK);
            
        }else{
            $this->response(['status'=>false,'message'=>'no data found'],REST_Controller::HTTP_OK) ;
        }
        
    }

    public function get_introvideo_get()
    {
        $data=base_url("uploads/intro-videos/intro.mp4");
        $query=array(
            'url' =>$data,
        );
        //print_r($query);die;

        if($query){
            $this->response(['status'=>true,'message'=>'success','data'=>$query],REST_Controller::HTTP_OK);
            
        }else{
            $this->response(['status'=>false,'message'=>'no data found'],REST_Controller::HTTP_OK) ;
        }
        
    }



   
    
    // For getting expired document driver
    public function getDucumentExpiredDriver_get()
    {
        $this->db->query("update users set is_online=3 where user_id in(selectget_driver_login_time user_id from vehicle_detail 
        where status=1 and (date(license_expiry_date)<date(now()) OR date(insurance_expiry_date)<date(now()) OR date(car_expiry_date)<date(now()) OR date(inspection_expiry_date)<date(now())))");
        $this->db->query("update users set is_online=3 where date(identification_expiry_date)<date(now())");
    }
    
    // For get the information of current app version on android or ios
    public function version_post(){
        $id = $this->input->post('id');
        if($id == 1 || $id == 0){
           $data = $this->db->query("select id, title, version_no from version  where is_android = $id"); 
           $this->response(['status' => true, 'message' => 'Data found.', 'data' => $data->result()]);
        }else{
            $this->response(['status' => false, 'message' => 'No data found.']);
        }
        
    }
	
	 public function check_app_version_post(){
        $postData = $this->post();		
		if(empty($postData['device_type'])){
			$this->set_response([ 'status'=>0,'message'=>'Please Enter Device type.'], REST_Controller::HTTP_OK); return false;
		}else if(empty($postData['app_version'])){
			$this->set_response([ 'status'=>0,'message'=>'Please Enter application Version.'], REST_Controller::HTTP_OK); return false;
		}else if(empty($postData['user_type'])){
			$this->set_response([ 'status'=>0,'message'=>'Please Enter User Type.'], REST_Controller::HTTP_OK); return false;
		}else{
            $device_type = $postData['device_type'];
            $app_version = $postData['app_version'];
            $user_type = $postData['user_type'];

        $res = $this->Auth_model->getversiondetails('application_version',$device_type,$app_version,$user_type);
        //print_r($res); die;
            if (!empty($res)) {
                 $this->set_response(['status'=>false,'message'=>'App Version is updated'],REST_Controller::HTTP_OK);
            }else{
                $this->set_response(['status'=>true,'message'=>'please update App Version'],REST_Controller::HTTP_OK);
            }
           
        }
    }

    public function update_app_version_post(){
        $postData = $this->post();		
		if(empty($postData['device_type'])){
			$this->set_response([ 'status'=>0,'message'=>'Please Enter Device type.'], REST_Controller::HTTP_OK); return false;
		}else if(empty($postData['app_version'])){
			$this->set_response([ 'status'=>0,'message'=>'Please Enter application Version.'], REST_Controller::HTTP_OK); return false;
        }else if(empty($postData['user_type'])){
			$this->set_response([ 'status'=>0,'message'=>'Please Enter User Type.'], REST_Controller::HTTP_OK); return false;
		}else{
            $device_type = $postData['device_type'];
            $app_version = $postData['app_version'];
            $user_type   = $postData['user_type'];

            $getvesrion = $this->Auth_model->getAppVersion('application_version',$device_type,$user_type);
            //print_r($getvesrion->app_version);die;
            if($getvesrion->app_version < $app_version){
                $res = $this->Auth_model->updateAppVersion('application_version',$device_type,$app_version,$user_type);
                if (!empty($res)) {
                    $this->set_response(['status'=>True,'message'=>'App Version is updated Succesfully'],REST_Controller::HTTP_OK);
                }else{
                    $this->set_response(['status'=>False,'message'=>'Something went wrong please try Again'],REST_Controller::HTTP_OK);
                }
            }else if($getvesrion->app_version == $app_version){
                    $this->set_response(['status'=>True,'message'=>'App Verison All ready Updated'],REST_Controller::HTTP_OK);
            }else{
                $this->set_response(['status'=>False,'message'=>'Latest Vesion is Available Please update your Application with Latest Vesion'],REST_Controller::HTTP_OK);

            } 
           
        }
    }
	
	
	public function getstripekey_get()
    {
        
        if (STRIPE_KEY) {
           $this->set_response(array('status'=>true,'stripe_pubish_key'=>STRIPE_KEY), REST_Controller::HTTP_OK);
        }else{
            $this->set_response(array('status'=>false,'message'=>'Error occurred, Please try after some time'), REST_Controller::HTTP_OK);
        }
    }
    
    
    function ageCalculator($dob){
        if(!empty($dob)){
            $birthdate = new DateTime($dob);
            $today   = new DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        }else{
            return 0;
        }
    }

    public function get_distance_value_get(){
		$distancedata = $this->Auth_model->getAdminData();
		if($distancedata->num_rows()>0){
			$admindata = $distancedata->row();
		}
		$data=[
		'accept_ride_distance'=>$admindata->accept_ride_distance,
		'accept_point_distance'=>$admindata->accept_point_distance,
		'drop_point_distance'=>$admindata->drop_point_distance,
		];
		$this->set_response(array('status'=>true,'data'=>$data), REST_Controller::HTTP_OK);
	}
	

/*
    function get_distance1($lat1,$long1,$lat2,$long2)
    { 
        try{

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&units=imperial&mode=driving&language=en-GB&key=".GOOGLE_MAP_API_KEY;       
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            //print_r($response);die();
            //echo $response['rows'][0]['elements'][0]['status'];die();
            if ($response['rows'][0]['elements'][0]['status']=='ZERO_RESULTS') {
                return array('status'=>false,'distance' =>0, 'time' => 0);
                //print_r(array('status'=>false,'distance' =>0, 'time' => 0));
                
                #---Log Section start--
                    $obj = modules::load('admin');
                    $obj->custom_log('API',' get_Distance Function IF Case','FUNCTION Rresponse: '.$response);
                #--log End --	
                
            }else{
                
                $dist = $response['rows'][0]['elements'][0]['distance']['text'];
                $time = $response['rows'][0]['elements'][0]['duration']['text'];
                return array('status'=>true,'distance' => $dist, 'time' => $time);
                
                #---Log Section start--
                    $obj = modules::load('admin');
                    $obj->custom_log('API',' get_Distance Function Log Else Case','FUNCTION Rresponse: '.$response);
                #--log End --
            }

            }catch(Exception $e) { 
                $this->api_error = $e->getMessage();
                $this->set_response(['status'=>false,'message'=>$this->api_error], REST_Controller::HTTP_OK);                
            } 
        
       

		
    }
*/
	/*
	function get_distance1($lat1,$long1,$lat2,$long2)
    { 
                
	 	$dist = "5";
		$time = "10";
 	return array('status'=>true,'distance' => $dist, 'time' => $time);
        
    }
*/

	public function get_distance1($lat1,$long1,$lat2,$long2)
	{ 
		// Define the access token and the starting and ending coordinates
		$accessToken = MAPBOX_API_KEY;
		$startCoordinates = "$long1,$lat1";
		$endCoordinates = "$long2,$lat2";

		// Initialize cURL
		$ch = curl_init();

		// Set the URL for the API request
		$url = "https://api.mapbox.com/directions/v5/mapbox/driving/$startCoordinates;$endCoordinates?geometries=geojson&access_token=$accessToken";

		// Set the cURL options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Execute the cURL request
		$response = curl_exec($ch);

		// Close the cURL session
		curl_close($ch);

		// Decode the JSON response
		$data = json_decode($response, true);
		//print_r($data['routes'][0]['distance']);
		//die;

		// Get the distance between the two points
		$distance = $data['routes'][0]['distance'];
		$duration = $data['routes'][0]['duration'];
		
		$durationTime = $this->time_conversion($duration);
	
        if (empty($distance)) {
			//echo "The distance between the one points is: $distance meters";
            return array('status'=>true,'distance' =>0, 'time' => 0); 
            //print_r(array('status'=>false,'distance' =>0, 'time' => 0));
			
        }else{   
			//echo "The distance between the two points is: $distance meters";
			
            return  array('status'=>true,'distance' => $distance * 0.000621371192, 'time' => $durationTime);
			
        } 
    }

	public function time_conversion($seconds){

        $init = round($seconds, 0);
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        //$seconds = $init % 60;

        return "$hours:$minutes";
    }
	
	function metersToMiles($meters) {
		return $meters / 1609.34;
	}
	
	
	

}
