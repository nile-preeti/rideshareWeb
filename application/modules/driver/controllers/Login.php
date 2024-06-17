<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
*/

class Login extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->library(array('common/Tables','pagination'));
		$this->load->helper(array('common/common','url'));
        $this->config->load('config');
		
	}

	

/* Testing purpose */
    public function test_mail()
    {
        $this->testMail2();
    }
  
/* Testing purpose */
    public function test_mail1()
    {
        $this->load->library('email');   
        $config = array();
        $config['protocol']     = "smtp"; // you can use 'mail' instead of 'sendmail or smtp'
        $config['smtp_host']    = "ssl://smtp.googlemail.com";// you can use 'smtp.googlemail.com' or 'smtp.gmail.com' instead of 'ssl://smtp.googlemail.com'
        $config['smtp_user']    = "amagaservice@gmail.com"; // client email gmail id
        $config['smtp_pass']    = "Nsjof87g"; // client password
        $config['smtp_port']    =  465;
        $config['smtp_crypto']  = 'ssl';
        $config['smtp_timeout'] = "";
        $config['mailtype']     = "html";
        $config['charset']      = "utf-8";
        $config['newline']      = "\r\n";
       // $config['wordwrap']     = TRUE;
        //$config['validate']     = FALSE;
        $this->load->library('email', $config); // intializing email library, whitch is defiend in system
        ///$this->email->set_header('Content-Type', 'text/html');
        $this->email->set_newline("\r\n"); // comuplsory line attechment because codeIgniter interacts with the SMTP server with regards to line break
    
        $this->email->set_mailtype("html");
        //Load email library
        $htmlContent = '<h1>Sending email via SMTP server</h1>';
        $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';
        $this->email->from('amagaservice@gmail.com');
        $this->email->to('shivendratiwari.567@gmail.com');
        $this->email->subject('Send Email Codeigniter'); 
        $this->load->library('parser');
        $email_data = array(
            'content' => $htmlContent,
        );
        $body = $this->parser->parse('common/email_template/default_email', $email_data, TRUE);
        $this->email->message( $body);  // we can use html tag also beacause use $config['mailtype'] = 'HTML'
        //Send mail
        if($this->email->send()){
            $this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");
           return true;
        }
        else{
            echo "email_not_sent";
            return false;  // If any error come, its run
        }
    }

	public function index()
	{	
        
		$data['css_array']       = $this->config->config['login_css'];
        $data['js_array']        = $this->config->config['login_js'];
		$data['title'] 			 ='Driver Login '.SITE_TITLE;
		$data['keyword'] 		 ='Driver Login '.SITE_TITLE;
		$data['description'] 	 ='Driver Login '.SITE_TITLE;
		$data['content']		 ='driver/login';
		echo Modules::run('template/login_template',$data);
		

	}

	/* login admin
    The "login()" function typically refers to a function that handles the process of authenticating a user and allowing them to access a protected area of a website or application.
    This function usually takes user input (such as a username and password), validates it, and then either grants the user access or denies them access based on the validity of the credentials.
    */
	public function checkuser()
	{
		$this->form_validation->set_rules('username','User name','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run()==false) {
            $data['css_array']       = $this->config->config['login_css'];
            $data['js_array']        = $this->config->config['login_js'];
			$data['title'] 			 ='Driver Login '.SITE_TITLE;
			$data['keyword'] 		 ='Driver Login '.SITE_TITLE;
			$data['description'] 	 ='Driver Login '.SITE_TITLE;
			$data['content']		 ='driver/login';
			echo Modules::run('template/login_template',$data);
		}else{
			$res =$this->User_model->getCustomFields(Tables::USER,array('email'=>$this->input->post('username'),'utype'=>2),'*');
			    $flag =1;
 			if ($res->num_rows()>0) {
				$row = $res->row();
                //print_r($row);die;

				if ($row->password != md5($this->input->post('password'))) {
					$flag =2;
					$this->session->set_flashdata('error_msg','Password is incorrect');
				}else{
					
					$this->session->set_userdata("admin_user", $row);

					$this->session->set_flashdata('success_msg','Login successfully');
				}
			}else{
				$flag =2;
				$this->session->set_flashdata('error_msg','Username is incorrect');
			}
			if ($flag==1) {
				redirect('driver/rides');
			}else{
				redirect('driver/login');
			}
		}
	}

    /* forgot form */
    public function forgot_form()
    {
        $this->load->view('driver/forgot-form',NULL);
    }

/* Send new password page for forgot admin password 
forgot_password() is a function that is usually used in a web application or website to allow a user who has got a link for forgotten their password to reset it.
*/
    public function forgot_password()
    {
        
        $query = $this->User_model->getCustomFields(Tables::USER,array('email'=>$this->input->post('email')),'name_title,user_id');
		//print_r($query); die;
        if ($query->num_rows()>0) {
            $div = $this->load->view('driver/new-password',array('user_detail'=>$query->row()),true);
           echo json_encode(array('status'=>true,'div'=>$div)); 
        }else{
            echo json_encode(array('status'=>false,'message'=>$this->input->post('email').' email is not registered'));
        }
    }


    /* forgot admin password 
    forgot_password() is a function that is usually used in a web application or website to allow a user who has forgotten their password to reset it.
    */
    public function forgot()
    {
       
       $affected_row = $this->User_model->update(Tables::USER,array('user_id'=>encrypt_decrypt('decrypt',$this->input->post('user_id'))),array('password'=>md5($this->input->post('password'))));
      
       if ($affected_row) {
           echo json_encode(array('status'=>true,'message'=>'Password changed successfully'));
       }else{
         echo json_encode(array('status'=>false,'message'=>'Error occurred, Please try after some time'));
       }
    }
    
	/*  map() with two optional parameters $par and $par2.
The function first calls another function adminAuthentication() which authenticates the administrator user.
 It then checks if the id field is not empty in the session data of the administrator user. */
	 public function map($par = NULL, $par2 = NULL) {
	 	$this->adminAuthentication();
        $session = $this->session->userdata('admin_user');
        if (!empty($session->id)) {
            if (!empty($par)) {
               
                $qry = $this->db->query("select u.*,r.drop_lat,r.drop_long,r.pickup_lat,r.pickup_long,r.pickup_adress,r.pikup_location as pickup_location,vd.vehicle_no,vd.color,r.drop_locatoin as drop_location,r.drop_address,r.amount,d.name as driver_name,d.email as driver_email,r.distance,r.driver_id,r.user_id from rides r join users d on r.driver_id = d.user_id join users u on u.user_id=r.user_id join vehicle_detail as vd on vd.user_id=r.driver_id where ride_id = $par");
                $qry1 = $this->db->query("select rd.id,rd.audio_file,rd.ride_id,rd.user_id,u.name,u.email,u.utype from ride_audio as  rd left join users as u on u.user_id=rd.user_id where rd.ride_id = $par");
                //echo $this->db->last_query();
                $res = $qry->result_array();
                $res1 = $qry1->result_array();
               //print_r($res1);
                //$str = '[';
                foreach ($res as $val) {
                    //$str .= "{position:new google.maps.LatLng(" . floatval($val['latitude']) . ", " . floatval($val['longitude']) . ") , avatar:'" . $val['avatar'] . "', name:'" . $val['name'] . "', email:'" . $val['email'] . "', mobile:'" . $val['mobile'] . "'},";
                    $a[] = array("u_lat" => floatval($val['latitude']), "u_lon" => floatval($val['longitude']), "email" => $val['email'], "u_name" => $val['name'], "avatar" => $val['avatar'], "mobile" => $val['mobile'], "vehicle_no" => $val['vehicle_no'], "color" => $val['color'],"driver_id"=>$val['driver_id'],"user_id"=>$val['user_id']);
                }
                // $str = rtrim($str, ',');
                //$str .= ']';
                if (!empty($par2)) {
                    echo json_encode($a);
                    die;
                }
                $z = explode(',',$res[0]['pickup_location']);
               
                $b['res'] = $a;
                $b['detail'] =$qry->row();
                $b['audio_file'] =$res1;
               
                $b['pickup_address'] = $res[0]['pickup_adress'];
                $b['drop_address'] = $res[0]['drop_address'];
                
                $b['pickup_start'] = $z[0];
                $b['pickup_start_lat'] = $res[0]['pickup_lat'];
                $b['pickup_start_long'] = $res[0]['pickup_long'];
                $b['pickup_end'] = $z[1];
                 $z = explode(',',$res[0]['drop_location']);
                 $b['drop_start_lat'] = $res[0]['drop_lat'];
                 $b['drop_start_long'] = $res[0]['drop_long'];
                $b['drop_start'] = $z[0];
                $b['drop_end'] = $z[1];
                //$a['res'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($data));
                $b['title']          ='Map '.SITE_TITLE;
                $b['keyword']         ='Map '.SITE_TITLE;
                $b['description']     ='Map '.SITE_TITLE;
                $b['content']		  ='admin/index_new';
                echo Modules::run('template/driver_template',$b);
            } else {
                
                //$qry = $this->db->query("select users.* from users as u left join vehicle_detail as vd on vd.user_id=u.user_id where utype = 2 AND (is_online=1 OR is_online=2)");
                $qry = $this->db->query("select u.*,vd.vehicle_no,vd.color from users as u left join vehicle_detail as vd on vd.user_id=u.user_id where utype = 2 AND (is_online=1 OR is_online=2)");
                //echo $this->db->last_query();
                $res = $qry->result_array();               
                $str = '[';
                foreach ($res as $val) {
                    $qry1 = $this->db->query("select vehicle_no,color from vehicle_detail where user_id=".$val['user_id']);
                    //echo $this->db->last_query();
                    $res1 = $qry1->result_array(); 
                    //print_r($res1);

                    $str .= "{position:new google.maps.LatLng(" . floatval($val['latitude']) . ", " . floatval($val['longitude']) . ") , avatar:'" . $val['avatar'] . "', name:'" . $val['name'] . "', email:'" . $val['email'] . "', mobile:'" . $val['mobile'] ."', vehicle_no:'" . $val['vehicle_no'] . "', color:'" . $val['color'] . "', user_id:'" . $val['user_id'] . "'},";
                    /*foreach ($res1 as $value) {
                         $str1 .= "{vehicle_detail:'" . $value . "'},";
                    }*/
                }
                $str = rtrim($str, ',');
                $str .= ']';
                //print_r( $str);
                $a['res'] = $str;
                //$a['res'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($data));
                $a['title']           ='Map '.SITE_TITLE;
                $a['keyword']         ='Map '.SITE_TITLE;
                $a['description']     ='Map '.SITE_TITLE;
                $a['content']		 ='admin/index';
                echo Modules::run('template/driver_template',$a);
            }
        } else {
            redirect($this->config->base_url());
        }
    }
	
	/* 
    users() is a function that is define for getting the details from user table of all users. 
    */
	
    /* 
    The function logout_driver_user($id,$type) logs out a driver user based on the provided $id and $type parameters.
    */
   
    
    public function update_bank()
    {
        $this->adminAuthentication();
        $user_id =$this->input->post('user_id'); 
        $post_data = $this->input->post();
        $post_data['account_holder_name']=encrypt_decrypt('encrypt',$this->input->post('account_holder_name'));
        $post_data['bank_name']=encrypt_decrypt('encrypt',$this->input->post('bank_name'));
        $post_data['routing_number']=encrypt_decrypt('encrypt',$this->input->post('routing_number'));
        $post_data['account_number']=encrypt_decrypt('encrypt',$this->input->post('account_number'));
        //print_r($post_data);die;
        unset($post_data['user_id']);
        $affected_row = $this->User_model->update('driver_account_detail',array('user_id'=>$user_id),$post_data);

        if ($affected_row) {
            echo json_encode(array('status'=>true,'message'=>'Record updated successfully'));
        }else{
             echo json_encode(array('status'=>true,'message'=>'Some error occurred, Please try after some time'));
        }
    }

    /* 
    The viewDriver() retrieves the driver details and vehicle details of the user with the provided user_id parameter.
    
    */
    public function viewDriver() {
       $this->adminAuthentication();
        $res['post'] = $this->User_model->getDriverDetail($this->input->post("user_id"));
        
        $res['vehicle'] = $this->User_model->get_vehicle_detail($this->input->post("user_id")); 
      
        $this->load->view('admin/view_driver', $res);
    }

     /* 
         The update_driver() retrieves the driver details and update of the user with the provided user_id parameter.
     */
    function update_driver($user_id=null){
		//$post_data = $this->input->post();
		//  echo"<pre>"; 
		//  print_r($post_data);die;
        $this->adminAuthentication();        
        $data['css_array']       = $this->config->config['add_driver_css'];
        $data['js_array']        = $this->config->config['add_driver_js'];
        $this->form_validation->set_rules('name','Name','required');
        //$this->form_validation->set_rules('email','Email','required|valid_email|callback_useremail_check');
        $this->form_validation->set_rules('mobile','Mobile','required|min_length[10]|max_length[15]');
      
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        if ($this->form_validation->run()==false) {
            $data['css_array']       = $this->config->config['add_driver_css'];
            $data['js_array']        = $this->config->config['add_driver_js'];
            $data['post'] 			 = $this->User_model->getCustomFields(Tables::USER,array('user_id'=>$user_id),'*'); 
            $data['vehicle_query'] 	 = $this->User_model->getCustomFields(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id),'*'); 
			$data['subcategory'] = $this->db->get_where(Tables::VEHICLE_SUBCATEGORY_TYPE, array("vehicle_type_category_id" => $this->input->post("vehicle_type_category_id")))->row_array();
            $vehicle_services = $this->User_model->getCustomFields(Tables::VEHICLE_SERVICE,array('user_id'=>$user_id),'vehicle_type_id'); 
            //print_r($vehicle_services->result());die;
            $vehicle_service=array();
            
            if($vehicle_services->num_rows()>0){
                foreach($vehicle_services->result() as $service_array){
                    array_push( $vehicle_service,$service_array->vehicle_type_id);
                }
            }
            $data['vehicle_service']=$vehicle_service;
            //$data['brands']         = $this->User_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title');
            $data['types']         = $this->User_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title');
            $data['subcategorytypes']         = $this->User_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('status'=>1),'id,title,rate');
            $data['identification_documents']= $this->User_model->getCustomFields(Tables::IDENTIFICATION_DOCUMENT,array('status'=>1),'id,document_name');
			$data['countryCode']= $this->User_model->getCustomFields(Tables::TBL_COUNTRY,array('status'=>1),'phone_code');
            $data['title']           ='User List '.SITE_TITLE;
            $data['keyword']         ='User List '.SITE_TITLE;
            $data['description']     ='User List '.SITE_TITLE;
            $data['content']         ='driver/update_driver';
            echo Modules::run('template/driver_template',$data);
        }else{
            $post_data = $this->input->post();
             //echo"<pre>"; 
             //print_r($post_data);die;
            $user_id = $post_data['user_id'];
            //unset($post_data['user_id']);
            //unset($post_data['email']);
            //print_r($post_data);die;
            //$post_data['password'] = md5($this->input->post('mobile'));
            //$post_data['status'] = 1;
            //$post_data['utype'] = 2;
           $user_arr =array(
                'name'=>$post_data['name'],
                /*'email'=>$post_data['email'],*/
                'mobile'=>$post_data['mobile'], 
                'status'=>$post_data['driver_status'],                
                'identification_document_id'=>$post_data['identification_document_id'],                
                'verification_id_approval_atatus'=>$post_data['verification_id_approval_atatus'],                
                'identification_issue_date'=>$post_data['identification_issue_date'],                
                'identification_expiry_date'=>$post_data['identification_expiry_date'],                
                'background_approval_status'=>$post_data['background_approval_status'],                
                
                'updated_date'=>date('Y-m-d H:i:s'),
           );
            $affected = $this->User_model->update(Tables::USER,array('user_id'=>$user_id), $user_arr);
            //echo $this->db->last_query();
            //if ( $affected) {
                $id= $this->input->post('user_id');
                if(!empty($_FILES['identity_document']['name'])){    
                    if (!is_dir('uploads/verification_document/'.$id)) {
                        mkdir('./uploads/verification_document/'.$id, 0777, TRUE);
                    }
                    $_FILES['file']['name'] = $_FILES['identity_document']['name'];
                    $_FILES['file']['type'] = $_FILES['identity_document']['type'];
                    $_FILES['file']['tmp_name'] = $_FILES['identity_document']['tmp_name'];
                    $_FILES['file']['error'] = $_FILES['identity_document']['error'];
                    $_FILES['file']['size'] = $_FILES['identity_document']['size'];             
                    $config['upload_path']   = './uploads/verification_document/'.$id; 
                    $config['allowed_types'] = 'jpg|png'; 
                    $config['max_size']      = 10000;                            
                    $config['file_name'] = $_FILES['identity_document']['name'];                 
                    $this->load->library('upload',$config); 
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file')){                                
                        $file_array = $this->upload->data();                                 
                        $this->User_model->update(Tables::USER,array('user_id'=>$id),array('verification_id'=>$file_array['file_name']));
                    }else{
                        print_r($error = array('error' => $this->upload->display_errors()));
                    }
                }
				if(!empty($_FILES['avatar']['name'])){    
                    if (!is_dir('uploads/profile_image/'.$id)) {
                        mkdir('./uploads/profile_image/'.$id, 0777, TRUE);
                    }
                    $_FILES['file']['name'] = $_FILES['avatar']['name'];
                    $_FILES['file']['type'] = $_FILES['avatar']['type'];
                    $_FILES['file']['tmp_name'] = $_FILES['avatar']['tmp_name'];
                    $_FILES['file']['error'] = $_FILES['avatar']['error'];
                    $_FILES['file']['size'] = $_FILES['avatar']['size'];             
                    $config['upload_path']   = './uploads/profile_image/'.$id; 
                    $config['allowed_types'] = 'jpg|png'; 
                    $config['max_size']      = 10000;                            
                    $config['file_name'] = $_FILES['avatar']['name'];                 
                    $this->load->library('upload',$config); 
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file')){                                
                        $file_array = $this->upload->data();
					//print_r($file_array); die;						
                        $this->User_model->update(Tables::USER,array('user_id'=>$id),array('avatar'=>$file_array['file_name']));
                    }else{
                        print_r($error = array('error' => $this->upload->display_errors()));
                    }
                }
				
               
                $vehicl_id=$post_data['vehicle_id']['0'];
               //print_r($vehicl_id);die;
                foreach ($post_data['vehicle_id'] as $key => $row) {
                    
                    $vehicle_arr =array(
                        'brand_id'=>$post_data['brand'],
                        'model_id'=>$post_data['model'],
                        
                        'year'=>$post_data['year'][$key],
                        'color'=>$post_data['color'][$key],
                        'vehicle_no'=>$post_data['vehicle_no'][$key],
                        'seat_no'=>$post_data['seat_no'][$key],
                        'license_issue_date'=>$post_data['license_issue_date'][$key],
                        'license_expiry_date'=>$post_data['license_expiry_date'][$key],
                        'insurance_issue_date'=>$post_data['insurance_issue_date'][$key],
                        'insurance_expiry_date'=>$post_data['insurance_expiry_date'][$key],
                        'car_expiry_date'=>$post_data['car_expiry_date'][$key],
                        'car_issue_date'=>$post_data['car_issue_date'][$key],
                        'car_registration'=>$post_data['car_registration'][$key],
                        'car_pic'=>$post_data['car_pic'][$key],
                        'insurance'=>$post_data['insurance'][$key],
                        'license'=>$post_data['license'][$key],
                        'inspection_document'=>$post_data['update_inspection_document'][$key],
                        'license_approve_status'=>$post_data['license_approve_status'][$key],
                        'insurance_approve_status'=>$post_data['insurance_approve_status'][$key],
                        'car_registration_approve_status'=>$post_data['car_registration_approve_status'][$key],
                        'inspection_issue_date'=>$post_data['inspection_issue_date'][$key],                
                        'inspection_expiry_date'=>$post_data['inspection_expiry_date'][$key],                
                        'inspection_approval_status'=>$post_data['inspection_approval_status'][$key],
                        'status'=>$post_data['status'][$key],
                        'updated_date'=>date('Y-m-d H:i:s'),
                    );
                    //print_r($vehicle_arr->vehicle_no);die;
                    $this->get_vehicle_type_sheet_get($post_data['seat_no'],$vehicl_id,$user_id,$post_data['model']);
                    $affected = $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]), $vehicle_arr);
                  
                    if(!empty($_FILES['update_car_pic']['name'][$key])){    
                        if (!is_dir('uploads/car_pic/'.$id)) {
                            mkdir('./uploads/car_pic/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['update_car_pic']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['update_car_pic']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['update_car_pic']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['update_car_pic']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['update_car_pic']['size'][$key];             
                        $config['upload_path']   = './uploads/car_pic/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['update_car_pic']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();                                 
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('car_pic'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }                    
                    if(!empty($_FILES['insurance']['name'][$key])){    
                        if (!is_dir('uploads/insurance_document/'.$id)) {
                            mkdir('./uploads/insurance_document/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['insurance']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['insurance']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['insurance']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['insurance']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['insurance']['size'][$key];             
                        $config['upload_path']   = './uploads/insurance_document/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['insurance']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();                                 
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('insurance'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    if(!empty($_FILES['license']['name'][$key])){    
                        if (!is_dir('uploads/license_document/'.$id)) {
                            mkdir('./uploads/license_document/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['license']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['license']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['license']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['license']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['license']['size'][$key];             
                        $config['upload_path']   = './uploads/license_document/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['license']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();	
									
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('license'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    if(!empty($_FILES['update_car_registration']['name'][$key])){    
                        if (!is_dir('uploads/car_registration/'.$id)) {
                            mkdir('./uploads/car_registration/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['update_car_registration']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['update_car_registration']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['update_car_registration']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['update_car_registration']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['update_car_registration']['size'][$key];             
                        $config['upload_path']   = './uploads/car_registration/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['update_car_registration']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();                              
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('car_registration'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    if(!empty($_FILES['inspection_document']['name'][$key])){    
                        if (!is_dir('uploads/inspection_document/'.$id)) {
                            mkdir('./uploads/inspection_document/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['inspection_document']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['inspection_document']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['inspection_document']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['inspection_document']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['inspection_document']['size'][$key];             
                        $config['upload_path']   = './uploads/inspection_document/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['inspection_document']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();                                 
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('inspection_document'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    
                }               
              
               
                $query = $this->User_model->getCustomFields(Tables::USER,array('user_id'=>$id),'*'); 
                ///$this->sendAdminRegistrationEmail($query->row(),$this->input->post('mobile'));
                $this->session->set_flashdata('success_msg','Record updated successfully');
            /*}else{
                $this->session->set_flashdata('error_msg','Some error occurred, Please try after some time');
            }*/
            redirect('driver/update-profile/'.$user_id);
        }
    }
	
	
	
	function update_driver_admin($user_id=null){
		/* $post_data = $this->input->post();
		echo"<pre>"; 
		print_r($post_data);die; */
        $this->adminAuthentication();        
        $data['css_array']       = $this->config->config['add_driver_css'];
        $data['js_array']        = $this->config->config['add_driver_js'];
        $this->form_validation->set_rules('name','Name','required');
        //$this->form_validation->set_rules('email','Email','required|valid_email|callback_useremail_check');
        $this->form_validation->set_rules('mobile','Mobile','required|min_length[10]|max_length[15]');
     
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        if ($this->form_validation->run()==false) {
            $data['css_array']       = $this->config->config['add_driver_css'];
            $data['js_array']        = $this->config->config['add_driver_js'];
            $data['post'] 			 = $this->User_model->getCustomFields(Tables::USER,array('user_id'=>$user_id),'*'); 
            $data['vehicle_query'] 	 = $this->User_model->getCustomFields(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id),'*'); 
			$data['subcategory'] = $this->db->get_where(Tables::VEHICLE_SUBCATEGORY_TYPE, array("vehicle_type_category_id" => $this->input->post("vehicle_type_category_id")))->row_array();
            $vehicle_services = $this->User_model->getCustomFields(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id),'vehicle_type_id'); 
            //print_r($vehicle_services->result());die;
            $vehicle_service=array();
            
            if($vehicle_services->num_rows()>0){
                foreach($vehicle_services->result() as $service_array){
                    array_push( $vehicle_service,$service_array->vehicle_type_id);
                }
            }
            $data['vehicle_service']=$vehicle_service;
            $data['brands']         = $this->User_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title');
            $data['types']         = $this->User_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title');
            $data['subcategorytypes']= $this->User_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('status'=>1),'id,title,rate');
            $data['identification_documents']= $this->User_model->getCustomFields(Tables::IDENTIFICATION_DOCUMENT,array('status'=>1),'id,document_name');
			$data['countryCode']= $this->User_model->getCustomFields(Tables::TBL_COUNTRY,array('status'=>1),'phone_code');
            $data['title']           ='User List '.SITE_TITLE;
            $data['keyword']         ='User List '.SITE_TITLE;
            $data['description']     ='User List '.SITE_TITLE;
            $data['content']         ='driver/update_driver';
            echo Modules::run('template/driver_template',$data);
        }else{
            $post_data = $this->input->post();
             echo"<pre>"; 
              print_r($post_data);die;
            $user_id = $post_data['user_id'];
            
           $user_arr =array(
                'name'=>$post_data['name'],
                /*'email'=>$post_data['email'],*/
                'mobile'=>$post_data['mobile'], 
                'status'=>$post_data['driver_status'],                
                'identification_document_id'=>$post_data['identification_document_id'],                
                'verification_id_approval_atatus'=>$post_data['verification_id_approval_atatus'],                
                'identification_issue_date'=>$post_data['identification_issue_date'],                
                'identification_expiry_date'=>$post_data['identification_expiry_date'],                
                'background_approval_status'=>$post_data['background_approval_status'],                
                
                'updated_date'=>date('Y-m-d H:i:s'),
           );
            $affected = $this->User_model->update(Tables::USER,array('user_id'=>$user_id), $user_arr);
            //echo $this->db->last_query();
            //if ( $affected) {
                $id= $this->input->post('user_id');
                if(!empty($_FILES['identity_document']['name'])){    
                    if (!is_dir('uploads/verification_document/'.$id)) {
                        mkdir('./uploads/verification_document/'.$id, 0777, TRUE);
                    }
                    $_FILES['file']['name'] = $_FILES['identity_document']['name'];
                    $_FILES['file']['type'] = $_FILES['identity_document']['type'];
                    $_FILES['file']['tmp_name'] = $_FILES['identity_document']['tmp_name'];
                    $_FILES['file']['error'] = $_FILES['identity_document']['error'];
                    $_FILES['file']['size'] = $_FILES['identity_document']['size'];             
                    $config['upload_path']   = './uploads/verification_document/'.$id; 
                    $config['allowed_types'] = 'jpg|png'; 
                    $config['max_size']      = 10000;                            
                    $config['file_name'] = $_FILES['identity_document']['name'];                 
                    $this->load->library('upload',$config); 
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file')){                                
                        $file_array = $this->upload->data();                                 
                        $this->User_model->update(Tables::USER,array('user_id'=>$id),array('verification_id'=>$file_array['file_name']));                    
					}else{
                        print_r($error = array('error' => $this->upload->display_errors()));
                    }
                }
				if(!empty($_FILES['avatar']['name'])){    
                    if (!is_dir('uploads/profile_image/'.$id)) {
                        mkdir('./uploads/profile_image/'.$id, 0777, TRUE);
                    }
                    $_FILES['file']['name'] = $_FILES['avatar']['name'];
                    $_FILES['file']['type'] = $_FILES['avatar']['type'];
                    $_FILES['file']['tmp_name'] = $_FILES['avatar']['tmp_name'];
                    $_FILES['file']['error'] = $_FILES['avatar']['error'];
                    $_FILES['file']['size'] = $_FILES['avatar']['size'];             
                    $config['upload_path']   = './uploads/profile_image/'.$id; 
                    $config['allowed_types'] = 'jpg|png'; 
                    $config['max_size']      = 10000;                            
                    $config['file_name'] = $_FILES['avatar']['name'];                 
                    $this->load->library('upload',$config); 
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file')){                                
                        $file_array = $this->upload->data();
					//print_r($file_array); die;						
                        $this->User_model->update(Tables::USER,array('user_id'=>$id),array('avatar'=>$file_array['file_name']));                    }else{
                        print_r($error = array('error' => $this->upload->display_errors()));
                    }
                }
				
               /* if (!empty($_FILES['insurance']['name'])) {
                    $this->do_upload('insurance_document',$id,'insurance');
                }
                if (!empty($_FILES['license']['name'])) {
                    $this->do_upload('license_document',$id,'license');
                }
                if (!empty($_FILES['permit']['name'])) {
                    $this->do_upload('permit_document',$id,'permit');
                }*/
                $vehicl_id=$post_data['vehicle_id']['0'];
               //print_r($vehicl_id);die;
                foreach ($post_data['vehicle_id'] as $key => $row) {
                    
                    $vehicle_arr =array(
                        'brand_id'=>$post_data['brand'],
                        'model_id'=>$post_data['model'],
                        
                        'year'=>$post_data['year'][$key],
                        'color'=>$post_data['color'][$key],
                        'vehicle_no'=>$post_data['vehicle_no'][$key],
                        'seat_no'=>$post_data['seat_no'][$key],
                        'license_issue_date'=>$post_data['license_issue_date'][$key],
                        'license_expiry_date'=>$post_data['license_expiry_date'][$key],
                        'insurance_issue_date'=>$post_data['insurance_issue_date'][$key],
                        'insurance_expiry_date'=>$post_data['insurance_expiry_date'][$key],
                        'car_expiry_date'=>$post_data['car_expiry_date'][$key],
                        'car_issue_date'=>$post_data['car_issue_date'][$key],
                        'car_registration'=>$post_data['car_registration'][$key],
                        'car_pic'=>$post_data['car_pic'][$key],
                        'insurance'=>$post_data['insurance'][$key],
                        'license'=>$post_data['license'][$key],
                        'inspection_document'=>$post_data['update_inspection_document'][$key],
                        'license_approve_status'=>$post_data['license_approve_status'][$key],
                        'insurance_approve_status'=>$post_data['insurance_approve_status'][$key],
                        'car_registration_approve_status'=>$post_data['car_registration_approve_status'][$key],
                        'inspection_issue_date'=>$post_data['inspection_issue_date'][$key],                
                        'inspection_expiry_date'=>$post_data['inspection_expiry_date'][$key],                
                        'inspection_approval_status'=>$post_data['inspection_approval_status'][$key],
                        'status'=>$post_data['status'][$key],
                        'updated_date'=>date('Y-m-d H:i:s'),
                    );
                    //print_r($vehicle_arr->vehicle_no);die;
                    $this->get_vehicle_type_sheet_get($post_data['seat_no'],$vehicl_id,$user_id,$post_data['model']);
                    $affected = $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]), $vehicle_arr);
                  
                    if(!empty($_FILES['update_car_pic']['name'][$key])){    
                        if (!is_dir('uploads/car_pic/'.$id)) {
                            mkdir('./uploads/car_pic/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['update_car_pic']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['update_car_pic']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['update_car_pic']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['update_car_pic']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['update_car_pic']['size'][$key];             
                        $config['upload_path']   = './uploads/car_pic/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['update_car_pic']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();                                 
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('car_pic'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }                    
                    if(!empty($_FILES['insurance']['name'][$key])){    
                        if (!is_dir('uploads/insurance_document/'.$id)) {
                            mkdir('./uploads/insurance_document/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['insurance']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['insurance']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['insurance']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['insurance']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['insurance']['size'][$key];             
                        $config['upload_path']   = './uploads/insurance_document/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['insurance']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();                                 
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('insurance'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    if(!empty($_FILES['license']['name'][$key])){    
                        if (!is_dir('uploads/license_document/'.$id)) {
                            mkdir('./uploads/license_document/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['license']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['license']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['license']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['license']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['license']['size'][$key];             
                        $config['upload_path']   = './uploads/license_document/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['license']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();	
									
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('license'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    if(!empty($_FILES['update_car_registration']['name'][$key])){    
                        if (!is_dir('uploads/car_registration/'.$id)) {
                            mkdir('./uploads/car_registration/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['update_car_registration']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['update_car_registration']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['update_car_registration']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['update_car_registration']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['update_car_registration']['size'][$key];             
                        $config['upload_path']   = './uploads/car_registration/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['update_car_registration']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();                              
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('car_registration'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    if(!empty($_FILES['inspection_document']['name'][$key])){    
                        if (!is_dir('uploads/inspection_document/'.$id)) {
                            mkdir('./uploads/inspection_document/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['inspection_document']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['inspection_document']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['inspection_document']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['inspection_document']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['inspection_document']['size'][$key];             
                        $config['upload_path']   = './uploads/inspection_document/'.$id; 
                        $config['allowed_types'] = 'jpg|png'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['inspection_document']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();                                 
                            $this->User_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('inspection_document'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    
                }
                
              
               
                $query = $this->User_model->getCustomFields(Tables::USER,array('user_id'=>$id),'*'); 
                ///$this->sendAdminRegistrationEmail($query->row(),$this->input->post('mobile'));
                $this->session->set_flashdata('success_msg','Record updated successfully');
            /*}else{
                $this->session->set_flashdata('error_msg','Some error occurred, Please try after some time');
            }*/
            redirect('driver/update-profile/'.$user_id);
        }
    }


    public function get_vehicle_type_sheet_get($seat,$vehicle_id='',$user_id='',$model_id)
     {
         
       // $seat = $this->input->post('seat');
        
       // $seat = $this->input->post('seat');
         $query = $this->db->query("SELECT id,title FROM ".Tables::VEHICLE_SUBCATEGORY_TYPE." where status=1 and id = $model_id");

        $this->User_model->delete_by_condition(Tables::VEHICLE_SERVICE,array('user_id'=>$user_id));
        $result = array();
        if($query->num_rows()>0)
            foreach ($query->result() as $row) {
                $this->User_model->save(Tables::VEHICLE_SERVICE,array('user_id'=>$user_id,'vehicle_id'=>$vehicle_id,'vehicle_type_id'=>$row->id,'created_date'=>date('Y-m-d H:i:s'),'updated_date'=>date('Y-m-d H:i:s')));
            }
        return true;
         
     }



/*
The "do_upload()" that appears to be designed to upload a file to a system or application. 
$folder_name likely refers to the directory or folder where the uploaded file should be stored.
$user_id likely refers to the user who is uploading the file.
$index is not immediately clear from the function signature alone, but it could potentially be used to identify a specific file upload field if multiple files can be uploaded simultaneously.
$vehicle_id likely refers to the vehicle that the uploaded file is associated with. This could be useful in a system where users are uploading documents or images related to specific vehicles, such as registration documents or photos of the vehicle.
*/
    public function do_upload($folder_name,$user_id,$index,$vehicle_id) { 
        //print_r($_FILES);die;
        if (!is_dir('uploads/'.$folder_name.'/'.$user_id)) {
            mkdir('./uploads/'.$folder_name.'/'.$user_id, 0777, TRUE);
        }
        $config['upload_path']   = './uploads/'.$folder_name.'/'.$user_id; 
        $config['allowed_types'] = 'jpg|png'; 
        $config['max_size']      = 10000; 
        //$config['max_width']     = 1024; 
        //$config['max_height']    = 768; 
        //$new_name = time().$_FILES[$index]['name'];
        //$config['file_name'] = $new_name; 
        //$config['file_name'] = $_FILES['file']['name'];
        //$path_info = pathinfo($_FILES[$index]['name']);
        ////echo $path_info['extension'];
        $new_name = time().'ocory';
        //die;
        $config['file_name'] = $new_name; 
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload($index)) {
            $error = array('error' => $this->upload->display_errors());
            return false;
        }else { 
            $file_array = $this->upload->data();
            $data = array($index=>$file_array['file_name']); 
            $this->User_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id,'id'=>$vehicle_id),$data);
            //print_r( $this->upload->data());die;
            //$data = array('upload_data' => $this->upload->data()); 
            return true;
        } 
    } 

    /* 
    The "do_upload_profile()" that appears to be designed to upload a user's profile picture or avatar to a system or application.
    */
    public function do_upload_profile($folder_name,$user_id,$index) { 
        //print_r($_FILES);die;
        if (!is_dir('uploads/'.$folder_name.'/'.$user_id)) {
            mkdir('./uploads/'.$folder_name.'/'.$user_id, 0777, TRUE);
        }
        $config['upload_path']   = './uploads/'.$folder_name.'/'.$user_id; 
        $config['allowed_types'] = 'jpg|png'; 
        $config['max_size']      = 10000; 
        //$config['max_width']     = 1024; 
        //$config['max_height']    = 768; 
        //$new_name = time().$_FILES[$index]['name'];
        //$config['file_name'] = $new_name; 
        //$config['file_name'] = $_FILES['file']['name'];
        //$path_info = pathinfo($_FILES[$index]['name']);
        ////echo $path_info['extension'];
        $new_name = 'getduma'.time();
        //die;
        $config['file_name'] = $new_name; 
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($index)) {
            $error = array('error' => $this->upload->display_errors());
            return false;
        }else { 
            $file_array = $this->upload->data();
            $data = array($index=>$file_array['file_name']); 
            $this->User_model->update(Tables::USER,array('user_id'=>$user_id),$data);
            //print_r( $this->upload->data());die;
            //$data = array('upload_data' => $this->upload->data()); 
            return true;
        } 
    } 

/*
The "useremail_check()" that appears to be designed to check whether a user's email address already exists in a system or application. 
*/
    public function useremail_check()
    {   
        $query = $this->User_model->getCustomFields(Tables::USER,array('email'=>$this->input->post('email')),'user_id,email');
            if ($query->num_rows()>0)
            {
                    $this->form_validation->set_message('useremail_check', 'User exists already');
                    return FALSE;
            }
            else
            {
                    return TRUE;
            }
    }

    /*
     "useremail_check()" that appears to be designed to check whether a user's email address already exists in a system or application.
    */
    public function remote_useremail_check()
    {   
        $query = $this->User_model->getCustomFields(Tables::USER,array('email'=>$this->input->get('email')),'user_id,email');
            if ($query->num_rows()>0){
                    //$this->form_validation->set_message('useremail_check', 'User exists already');
                echo "false";
            }else{
                echo "true";
            }
    }

	

    /*
    The "getDriver()" that appears to be designed to retrieve information about a specific driver.
    */
    public function getDriver() {
       $this->adminAuthentication();        
        $data['post'] = $this->User_model->getCustomFields(Tables::USER,array('user_id'=>$this->input->post("user_id")),'*');             
        $data['brands']         = $this->User_model->getCustomFields(Tables::BRAND,array('status'=>1),'id,brand_name');
        $data['types']         = $this->User_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title,rate');
        $usrid=$this->input->post("user_id");
        $data['bankdata'] = $this->User_model->getbankdetails($usrid);
        $this->load->view('admin/edit_driver', $data);
    }
    
    public function getbankdetails() {
       $this->adminAuthentication();        
        $usrid=$this->input->post("user_id");
        $data['bankdata'] = $this->User_model->getbankdetails($usrid);
        $this->load->view('admin/edit_bankdetails', $data);
    }
    
    
   


	/* 
        The "getrides()" that appears to be designed to retrieve information about rides in a system or application.
    */
	public function getrides()
	{
		$this->adminAuthentication();
        $session = $this->session->userdata('admin_user');
        $userid= $session->user_id;
        //echo $session->utype;
        $config = array();
        $filter_data = $this->input->get();
        $data['filter_data'] = $filter_data;
        $config["base_url"] = $this->config->base_url() . "driver/rides";
        //$config["total_rows"] = $this->User_model->get_ride_list($filter_data,NULL,NULL,)->num_rows();
        $config["total_rows"] = $this->User_model->get_ride_list($filter_data,NULL,NULL,$userid)->num_rows();
        $config["per_page"]             = (isset($filter_data['per_page']) && !empty($filter_data['per_page']) && is_numeric($filter_data['per_page']))?$filter_data['per_page']:PER_PAGE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page                   = (isset($_GET['page']) && intval($_GET['page'])) ? $_GET['page'] : 0;
        $current_page           = $page;
        $page                   = ($page) ? (($page - 1) * $config["per_page"]) : 0;
        $data["links"] = $this->pagination->create_links();        
        $data["result"] = $this->User_model->get_ride_list( $filter_data,$config["per_page"],$page,$userid)->result();
		$data['title'] 			 ='Ride List '.SITE_TITLE;
		$data['keyword'] 		 ='Ride List '.SITE_TITLE;
		$data['description'] 	 ='Ride List '.SITE_TITLE;
		$data['content']		 ='driver/get_rides';
		echo Modules::run('template/driver_template',$data);
	}


    
	/* 
    This function retrieves payment information from a database.
    */
	public function getPayments()
	{
		$this->adminAuthentication();
        $config = array();
        $filter_data = $this->input->get();
        $data['filter_data'] = $filter_data;
        $config["base_url"] = $this->config->base_url() . "login/getpayments";
        $config["total_rows"] = $this->User_model->payment_history($filter_data,NULL,NULL)->num_rows();

       
        //$config["total_rows"] = count($this->db->get("rides")->result());
       
        $config["per_page"] = 10;
        $config["uri_segment"] = true;
        $config['use_page_numbers'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();


        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        !empty($config["per_page"]) ? $this->db->limit($config["per_page"], $page) : '';
       
        $data['url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $data["result"] = $this->User_model->payment_history( $filter_data,$config["per_page"],$page);
        if ((isset($filter_data['export']))) {
            $export_obj = Modules::load('admin/export');             
            $export_obj->generatepaymentXls($data["result"]);die;
        }
		$data['title'] 			 ='Payment '.SITE_TITLE;
		$data['keyword'] 		 ='Payment '.SITE_TITLE;
		$data['description'] 	 ='Payment '.SITE_TITLE;
		$data['content']		 ='admin/get_payments';
		echo Modules::run('template/driver_template',$data);
	}

    /*  
    this function and parameter, "payout" and "$id", it is likely that this function is responsible for processing a payment to a specific recipient identified by the "$id" parameter.
    */
      public function payout(){
       
        $this->adminAuthentication();
        $session = $this->session->userdata('admin_user');
        $userid= $session->user_id;
        $config = array();
        $filter_data = $this->input->get();
        $filter_data['driver_id'] =encrypt_decrypt('decrypt',$userid);
        $data['filter_data'] = $filter_data;       
        !empty($config["per_page"]) ? $this->db->limit($config["per_page"], $page) : ''; 
        $data['url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data["result"] = $this->User_model->payout_history( $filter_data,null,null);
        $data['vendorsdata']= $this->User_model->payout_historybyweek('rides',$userid); 
        if ((isset($filter_data['export']))) {
            $export_obj = Modules::load('admin/export');
            $export_obj->generatepayouttXls($data["result"]);die;
        }
        $data['driver_id']= $userid;
        $data['fee_data']             = $this->db->get("admin")->row();
        $data['title']           ='Payout '.SITE_TITLE;
        $data['keyword']         ='Payout '.SITE_TITLE;
        $data['description']     ='Payout '.SITE_TITLE;
        $data['content']         ='driver/payout';
        echo Modules::run('template/driver_template',$data);
    }

/*  
This function is responsible for processing a payout to a driver.
*/
    public function payout_driver()
	{
		$this->adminAuthentication();
        $data['css_array']       = $this->config->config['driver_css'];
        $data['js_array']        = $this->config->config['driver_js'];
		$config = array();
        $config["base_url"] = $this->config->base_url() . "admin/payout_driver";
        //$config["total_rows"] = count($this->db->get_where("users", array("utype" => 2,'status'=>1))->result());
        $filter_data = $this->input->get();
        
        $data['filter_data'] = $filter_data;  
        $config["total_rows"] = $this->User_model->get_driver_list($filter_data,NULL,NULL)->num_rows();
        $config["per_page"]             = (isset($filter_data['per_page']) && !empty($filter_data['per_page']) && is_numeric($filter_data['per_page']))?$filter_data['per_page']:PER_PAGE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page                   = (isset($_GET['page']) && intval($_GET['page'])) ? $_GET['page'] : 0;
        $current_page           = $page;
        $page                   = ($page) ? (($page - 1) * $config["per_page"]) : 0;
        $data["links"] = $this->pagination->create_links();        
        $data["result"] = $this->User_model->get_driver_list( $filter_data,$config["per_page"],$page)->result();
        //$data["result"] = $this->db->get_where("users", array("utype" => 2,'status'=>1))->result(); //employee is a table in the database
    	$data['title'] 			 ='Driver List '.SITE_TITLE;
		$data['keyword'] 		 ='Driver List '.SITE_TITLE;
		$data['description'] 	 ='Driver List '.SITE_TITLE;
		$data['content']		 ='admin/payout_driverlist';
		echo Modules::run('template/driver_template',$data);
	}


    public function profile(){
		$this->adminAuthentication();
        $session = $this->session->userdata('admin_user');
        $userid= $session->user_id;
		
        
        $data['res'] =          $this->db->get_where("users",array('user_id =' => $userid))->row();
        $data['vehicle']      = $this->User_model->get_vehicle_detail($userid); 
        $data['title'] 			 = 'Driver Profile '.SITE_TITLE;
		$data['keyword'] 		 = 'Driver Profile '.SITE_TITLE;
		$data['description'] 	 = 'Driver Profile '.SITE_TITLE;
		$data['content']		 = 'driver/profile';
		echo Modules::run('template/driver_template',$data);
	}


	/*   
    This function is responsible for managing and displaying Daywise Percentage Configurator settings for a particular application.
    */
	public function settings(){
		$this->adminAuthentication();
        $session = $this->session->userdata('admin_user');
        $userid= $session->user_id;
		if (!empty($_POST['new_password']) && !empty($_POST['old_password'])) {   
            $qry = $this->db->query("select * from users where user_id= '".$userid."' and  password = md5('" . $_POST['old_password'] . "')");
            $res = $qry->result();
            //print_r($res);die;
            if (!empty($res)) {
                $_POST['password'] = md5($_POST['new_password']);
                unset($_POST['new_password']);
                unset($_POST['old_password']);
            } else {
                $this->session->set_userdata(array("msg" => "Wrong password enter", "type" => "error"));
                redirect($this->config->base_url() . 'driver/settings', 'refresh');
            }
            $this->db->update("users", $_POST);
            $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
            redirect($this->config->base_url() . 'driver/settings');
        }
        
        $data['res'] =          $this->db->get_where("users",array('user_id =' => $userid))->row();
        $data['title'] 			 = 'Setting '.SITE_TITLE;
		$data['keyword'] 		 = 'Setting '.SITE_TITLE;
		$data['description'] 	 = 'Setting '.SITE_TITLE;
		$data['content']		 = 'driver/settings';
		echo Modules::run('template/driver_template',$data);
	}

    /* 
    This function is responsible for managing and displaying Daywise Percentage Configurator settings for a particular application.
    */
	public function rate_chart()
	{       
		$this->adminAuthentication();
		$this->form_validation->set_rules('monday','Monday','required');
        $this->form_validation->set_rules('tuesday','Tuesday','required');
        $this->form_validation->set_rules('wednesday','Wednesday','required');
        $this->form_validation->set_rules('thursday','Thursday','required');
        $this->form_validation->set_rules('friday','Friday','required');
        $this->form_validation->set_rules('saturday','Saturday','required');
        $this->form_validation->set_rules('sunday','Sunday','required');
        if( $this->form_validation->run()==false){
           
            $data['res'] = $this->db->get(Tables::RATE_CHART)->row();
            $data['title'] 			 = 'Daywise Percentage Configurator '.SITE_TITLE;
            $data['keyword'] 		 = 'Daywise Percentage Configurator '.SITE_TITLE;
            $data['description'] 	 = 'Daywise Percentage Configurator '.SITE_TITLE;
            $data['content']		 = 'admin/rate_chart';
            echo Modules::run('template/driver_template',$data);
        }else{
            //Array ( [monday] => 30 [tuesday] => 25 [wednesday] => 25 [thursday] => 25 [friday] => 40 [saturday] => 40 [sunday] => 40 )

            $arr = array(
                'monday'=>$this->input->post('monday'),
                'tuesday'=>$this->input->post('tuesday'),
                'wednesday'=>$this->input->post('wednesday'),
                'thursday'=>$this->input->post('thursday'),
                'friday'=>$this->input->post('friday'),
                'saturday'=>$this->input->post('saturday'),
                'sunday'=>$this->input->post('sunday'),
                'highest_ride_price'=>$this->input->post('highest_ride_price'),
                'total_highest_ride'=>$this->input->post('total_highest_ride'),
                'updated_date'=>date('Y-m-d H:i:s')
               
            );
            $this->User_model->update(Tables::RATE_CHART,array('id'=>1), $arr);
            $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
            redirect($this->config->base_url() . 'admin/settings');
        }
	}

/* 
This function is responsible for ending a user's current session and logging them out of a system or application.
*/
	public function logout() {

        $this->session->sess_destroy();

        redirect($this->config->base_url('driver/login'), 'refresh');
    }

    /* 
    This function is responsible for retrieving user information for a particular system or application.
    */
    public function getUser() {
        $this->adminAuthentication();
        $res['identifications'] =$this->User_model->getCustomFields(Tables::IDENTIFICATION_DOCUMENT,array('status'=>1),'id,document_name');
        $res['post'] = $this->db->get_where("users", array("user_id" => $this->input->post("user_id")))->row_array();
        $this->load->view('admin/edit_user', $res);
    }

    /* 
    This function is responsible for adding a new brand to a system or application.
    */
    public function add_brand()
    {

        $this->adminAuthentication();
       $this->form_validation->set_rules('brand_name','Brand Name','required');
       $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
        if ($this->form_validation->run()==FALSE) {
           
            $data['title']           = 'Add Brand '.SITE_TITLE;
            $data['keyword']         = 'Add Brand '.SITE_TITLE;
            $data['description']     = 'Add Brand '.SITE_TITLE;
            $data['breadcrumb']      = 'Add Make ';
            $data['content']         = 'admin/add_brand';
            echo Modules::run('template/driver_template',$data);
        }else{
            $post_data =$this->input->post();
            $post_data['created_date'] = date('Y-m-d H:i:s');
            $post_data['updated_date'] = date('Y-m-d H:i:s');
            $id=$this->User_model->save(Tables::BRAND,$post_data);
            if ($id) {
                $this->session->set_flashdata('success_msg','Brand added successfully');
            }else{
                $this->session->set_flashdata('error_msg','Some error occurred, Please try after some time');
            }
            redirect('admin/add_brand');
        }
       
    }

    /*
    This function is responsible for editing an existing brand in a system or application.
    */
    public function edit_brand($id=null)
    {

        $this->adminAuthentication();
       $this->form_validation->set_rules('brand_name','Brand Name','required');
       $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
        if ($this->form_validation->run()==FALSE) {
           
            $data['title']           = 'Add Brand '.SITE_TITLE;
            $data['keyword']         = 'Add Brand '.SITE_TITLE;
            $data['description']     = 'Add Brand '.SITE_TITLE;
            $data['breadcrumb']      = 'Edit Brand ';
            $data['content']         = 'admin/edit_brand';
            $data['brand']           = $this->User_model->getCustomFields(Tables::BRAND,array('id'=>$id),'*');
            echo Modules::run('template/driver_template',$data);
        }else{
            $post_data =$this->input->post();   
            unset($post_data['id']) ;       
            $post_data['updated_date'] = date('Y-m-d H:i:s');

            $id=$this->User_model->update(Tables::BRAND,array('id'=>$this->input->post('id')),$post_data);
            
            if ($id) {
                $this->session->set_flashdata('success_msg','Brand updated successfully');
            }else{
                $this->session->set_flashdata('error_msg','Some error occurred, Please try after some time');
            }
            redirect('admin/edit_brand/'.$id);
        }
       
    }

    /* 
    This function is responsible for retrieving a list of brands in a system or application.
    */
    public function brand_list()
    {
        $this->adminAuthentication();
        $data['css_array']       = $this->config->config['brand_css'];
        $data['js_array']        = $this->config->config['brand_js'];
        $filter_data             = $this->input->get();
        $data['filter_data']     = $filter_data;
        $data['brands']          =$this->User_model->get_brand_list($filter_data,null,null);
        $data['breadcrumb']      = 'Brand List ';
        $data['title']           = 'Brand List '.SITE_TITLE;
        $data['keyword']         = 'Brand List '.SITE_TITLE;
        $data['description']     = 'Brand List '.SITE_TITLE;
        $data['content']         = 'admin/brand_list';
        echo Modules::run('template/driver_template',$data);
    }

    /* 
    This function is responsible for retrieving a list of brand in a system or application.
    */

    public function brand_model_list()
    {
        $this->adminAuthentication();
        $data['css_array']       = $this->config->config['brand_css'];
        $data['js_array']        = $this->config->config['brand_js'];
        $filter_data             = $this->input->get();
        $data['filter_data']     = $filter_data;
        $data['models']          = $this->User_model->get_brand_model_list($filter_data,null,null);
        $data['breadcrumb']      = 'Model Make List ';
        $data['title']           = 'Brand List '.SITE_TITLE;
        $data['keyword']         = 'Brand List '.SITE_TITLE;
        $data['description']     = 'Brand List '.SITE_TITLE;
        $data['content']         = 'admin/brand_model_list';
        echo Modules::run('template/driver_template',$data);
    }

    /*
    This function is responsible for adding a new brand model in a system or application.
    */
    public function add_brand_model()
    {

        $this->adminAuthentication();
        $this->form_validation->set_rules('model_name','Model Name','required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
        if ($this->form_validation->run()==FALSE) {
            $data['brands']          =$this->User_model->getCustomFields(Tables::BRAND,array('status'=>1),'id,brand_name');
            $data['title']           = 'Add Brand '.SITE_TITLE;
            $data['keyword']         = 'Add Brand '.SITE_TITLE;
            $data['description']     = 'Add Brand '.SITE_TITLE;
            $data['breadcrumb']      = 'Add Model Make';
            $data['content']         = 'admin/add_model';
            echo Modules::run('template/driver_template',$data);
        }else{

            $post_data =$this->input->post();
            $post_data['created_date'] = date('Y-m-d H:i:s');
            $post_data['updated_date'] = date('Y-m-d H:i:s');
            $id=    $this->User_model->save(Tables::MODEL,$post_data);
            if ($id){
                $this->session->set_flashdata('success_msg','Brand model added successfully');
            }else{
                $this->session->set_flashdata('error_msg','Some error occurred, Please try after some time');
            }
            redirect('admin/add_brand_model');
        }
       
    }


    /*
    This function is intended to edit a brand model in a database or other data storage system.
    */
    public function edit_brand_model($id=null)
    {

        $this->adminAuthentication();
        $this->form_validation->set_rules('model_name','Model Name','required');
        $this->form_validation->set_rules('brand_id','Brand Name','required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
        if ($this->form_validation->run()==FALSE) {
            $data['brands']          =$this->User_model->getCustomFields(Tables::BRAND,array('status'=>1),'id,brand_name');
            $data['models']          =$this->User_model->getCustomFields(Tables::MODEL,array('id'=>$id),'id,model_name,brand_id,status');
             
            $data['title']           = 'Add Brand '.SITE_TITLE;
            $data['keyword']         = 'Add Brand '.SITE_TITLE;
            $data['description']     = 'Add Brand '.SITE_TITLE;
            $data['breadcrumb']      = 'Edit Brand Model';
            $data['content']         = 'admin/edit_model';
            echo Modules::run('template/driver_template',$data);
        }else{

            $post_data =$this->input->post();   
            unset($post_data['id']) ;       
            $post_data['updated_date'] = date('Y-m-d H:i:s');

            $id=$this->User_model->update(Tables::MODEL,array('id'=>$this->input->post('id')),$post_data);
            
            if ($id) {
                $this->session->set_flashdata('success_msg','Brand model updated successfully');
            }else{
                $this->session->set_flashdata('error_msg','Some error occurred, Please try after some time');
            }
            redirect('admin/edit_brand_model/'.$this->input->post('id'));
        }
       
    }

    /*
    This function is intended to retrieve a list of vehicle types from a database or other data storage system.
    */
    public function vehicle_type_list(){
        $this->adminAuthentication();
         $data['css_array']       = $this->config->config['vehicle_type_css'];
        $data['js_array']        = $this->config->config['vehicle_type_js'];
        $filter_data             = $this->input->get();
        $data['filter_data']     = $filter_data;
        $data['types']           = $this->User_model->getCustomFields(Tables::VEHICLETYPE,'1=1','id,title,status,rate,created_date,short_description');
        $data['title']           = 'Vehicle type List '.SITE_TITLE;
        $data['keyword']         = 'Vehicle type List '.SITE_TITLE;
        $data['description']     = 'Vehicle type List '.SITE_TITLE;
        $data['breadcrumb']      = 'Vehicle type list';
        $data['content']         = 'admin/vehicle_type_list';
        echo Modules::run('template/driver_template',$data);
    }

    /*
    This function is intended to add a vehicle chart to a database or other data storage system, and the $id parameter might refer to the ID of the chart to be added.
    */
    public function add_vehicle_chart($id=null) {
        $this->adminAuthentication(); 
        $this->form_validation->set_rules('title','Vehicle type','required'); 
        $this->form_validation->set_rules('rate','Rate','required');  
        if ($this->form_validation->run()==false) {
            $data['types']           = $this->User_model->getCustomFields(Tables::VEHICLETYPE,array('id'=>$id),'id,title,status,rate,created_date,short_description'); 
            $data['title']           = 'Add vehicle Chart '.SITE_TITLE;
            $data['keyword']         = 'Add vehicle Chart '.SITE_TITLE;
            $data['description']     = 'Add vehicle Chart '.SITE_TITLE;
            $data['breadcrumb']      = 'Add vehicle Chart';
            $data['content']         = 'admin/add_vehicle_rate_chart';
            echo Modules::run('template/driver_template',$data);
        }else{
            $post_data = $this->input->post();
            unset($post_data['id']);  
            $post_data['updated_date'] = date('Y:m:d H:i:s');
            $affected = $this->User_model->update(Tables::VEHICLETYPE,array('id'=>$this->input->post('id')), $post_data);
            if ($affected) {
                $this->session->set_flashdata('success_msg','Data updated successfully');
            }else{
                $this->session->set_flashdata('success_msg','Some error occurred, please try after some time');
            }
            redirect('admin/vehicle_type_list');
        } 
    }

    /*
    This function is intended to generate a form for adding or editing a vehicle type, which may then be submitted to a database or other data storage system.
    */
    public function vehicle_type_form(){
       $this->load->view('admin/add_vehicle_type',true);  
    }

    /*
    
    This function is intended to add a new vehicle type to a database or other data storage system, likely based on user input from a form or other source.
    */
    public function add_vehicle_type(){   
        $post_data = $this->input->post();
        $post_data['created_date'] =date('Y-m-d H:i:s');
        $post_data['updated_date'] =date('Y-m-d H:i:s');
        $post_data['status'] =1;
        $id = $this->User_model->save(Tables::VEHICLETYPE,$post_data);
        if ($id) {
           echo json_encode(array('status'=>true,'message'=>'Data added successfully.'));
        }else{
             echo json_encode(array('status'=>true,'message'=>'Error occurred, please try after some time'));
        }
    }

/*  
This function is intended to handle a file download for a specific $object related to a $vehicle_id. The $object parameter might refer to the type of file or resource being downloaded, while the $vehicle_id parameter might refer to the specific vehicle associated with the file or resource.
*/
    public function download($object,$vehicle_id){
        
        //load download helper
        $this->load->helper('download');
        
        //get file info from database
        $fileInfo = $this->User_model->getCustomFields(Tables::VEHICLE_DETAIL,array('id'=>$vehicle_id),'user_id,'.$object);
       //echo $this->db->last_query();
        if ($object=='insurance') {
            //file path
            $filename = $fileInfo->row()->insurance;
            $file = 'uploads/insurance_document/'.$fileInfo->row()->user_id.'/'.$filename;
        }else if($object=='license'){
            //file path
            $filename = $fileInfo->row()->license;
            $file = 'uploads/license_document/'.$fileInfo->row()->user_id.'/'.$filename;
        }else if($object=='permit'){
            //file path
            $filename =$fileInfo->row()->permit;
            $file = 'uploads/'.$folder.'/'.$fileInfo->row()->user_id.'/'.$filename;
        }else if($object=='car_pic'){
            //file path
            $filename =$fileInfo->row()->car_pic;
            $file = 'uploads/car_pic/'.$fileInfo->row()->user_id.'/'.$filename;
        }        
        
        //download file from directory
        force_download($file, NULL);
        
    }
    
    // function for getting the app versions list for rider or driver
    public function version(){
        $this->adminAuthentication();
        $data['css_array']       = $this->config->config['driver_css'];
        $data['js_array']        = $this->config->config['driver_js'];
        $data["result"] = $this->db->query("select * from version")->result();
    	$data['title'] 			 ='Version List '.SITE_TITLE;
		$data['keyword'] 		 ='Version Listt '.SITE_TITLE;
		$data['description'] 	 ='Version List '.SITE_TITLE;
		$data['content']		 ='admin/version';
		echo Modules::run('template/driver_template',$data);
    }
    
    public function edit_version($id=null){
        $this->adminAuthentication();
        $data['title']           = 'Edit Version Details '.SITE_TITLE;
        $data['keyword']         = 'Edit Version Details '.SITE_TITLE;
        $data['description']     = 'Edit Version Details '.SITE_TITLE;
        $data['content']         = 'admin/edit_version';
        $data['brand']           = $this->db->query("select * from version where id = $id")->row();
        echo Modules::run('template/driver_template',$data);
    }
    
    public function update_version(){
        $this->adminAuthentication();
        $title = $this->input->post('version_title');
        $number = $this->input->post('version_number');
        $id = $this->input->post('id');
        $affected = $this->db->query("update version set title = '$title', version_no = '$number' where id = '$id'");
        if ($affected) {
            $this->session->set_flashdata('success_msg','Version updated successfully');
        }else{
            $this->session->set_flashdata('success_msg','Some error occurred, please try after some time');
        }
        redirect('admin/version');
    }
    
}