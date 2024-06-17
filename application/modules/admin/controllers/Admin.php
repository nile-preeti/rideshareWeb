<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
*/

class Admin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->library(array('common/Tables','pagination'));
		$this->load->helper(array('common/common','url'));
        $this->config->load('config');
		
	}



/* Testing purpose */
    public function test_mail()
    {
        //$this->testMail2();
		
		$mail = $this->devtest_mail();
		if($mail)
			echo "Mail sent...";
		else
			echo "Mail not sent";
		
		die;
    }
	
	
	public function send_mails(){
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.office365.com';
		$config['smtp_port'] = 587;
		$config['smtp_user']  = 'support@ridesharerates.com';  
		$config['smtp_pass']  = 'RideShareRates@2023';  
		$config['_smtp_auth'] = true;
		$config['smtp_crypto'] = 'tls';
		$config['protocol'] = 'smtp';
		$config['mailtype']  = 'html'; 
		$config['charset']    = 'UTF-8';
		$config['wordwrap']   = TRUE;
		
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");	
		$this->email->from('support@ridesharerates.com', 'Navigator');
		$this->email->to('ramkishor.chauhan@gmail.com');
		$this->email->subject('Send Email Codeigniter');
		$this->email->message('The email send using codeigniter library');
		//$this->email->send();
		//Send mail
		if($this->email->send())
		   echo "mail sent";
		else
		  show_error($this->email->print_debugger());
		

	}
  
  
/* Testing purpose */
    public function test_mail1(){
    // {
    //     $this->load->helper('phpmailer');   
    //     phpmail_send1('customer@rideshare.com','sram004@gmail.com','test','test form rideshare',);
    // }
// $config['protocol'] = 'sendmail';
// $config['smtp_host'] = 'localhost';
// $config['smtp_user'] = '';
// $config['smtp_pass'] = '';
// $config['smtp_port'] = 25;

        
       // $this->load->library('email');   
        $config = array();
        $config['protocol']     = "smtp"; // you can use 'mail' instead of 'sendmail or smtp'
        $config['smtp_host']    = "smtp.office365.com";// you can use 'smtp.googlemail.com' or 'smtp.gmail.com' instead of 'ssl://smtp.googlemail.com'
        $config['smtp_user']    = "support@ridesharerates.com"; // client email gmail id
        $config['smtp_pass']    = "RideShareRates@2023"; // client password
        $config['smtp_port']    =  587;
        $config['smtp_crypto']  = 'tls';
        $config['smtp_timeout'] = "";
        $config['mailtype']     = "html";
        $config['charset']      = "utf-8";
        $config['newline']      = "\r\n";
        $config['wordwrap']     = TRUE;
        $config['validate']     = FALSE;
        $this->load->library('email', $config); // intializing email library, whitch is defiend in system
        $this->email->set_header('Content-Type', 'text/html');
        $this->email->set_newline("\r\n"); // comuplsory line attechment because codeIgniter interacts with the SMTP server with regards to line break
    
        $this->email->set_mailtype("html");
        //Load email library
        $htmlContent = '<h1>Sending email via SMTP server</h1>';
        $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';
        $this->email->from('ramkishor.chauhan@niletechnologies.com');
        $this->email->to('ramkishor.niletechnologies@gmail.com');
        $this->email->subject('Send Email Codeigniter'); 
        $this->load->library('parser');
        $email_data = array(
            'content' => $htmlContent,
        );
        $body = $this->parser->parse('common/email_template/default_email', $email_data, TRUE);
        $this->email->message( 'test message from getdumma');  // we can use html tag also beacause use $config['mailtype'] = 'HTML'
        //Send mail
        if($this->email->send()){
            echo "email sent";
            //$this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");
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
		$data['title'] 			 ='Admin Login '.SITE_TITLE;
		$data['keyword'] 		 ='Admin Login '.SITE_TITLE;
		$data['description'] 	 ='Admin Login '.SITE_TITLE;
		$data['content']		 ='admin/login';
		echo Modules::run('template/login_template',$data);
		

	}

	/* login admin
    The "login()" function typically refers to a function that handles the process of authenticating a user and allowing them to access a protected area of a website or application.
    This function usually takes user input (such as a username and password), validates it, and then either grants the user access or denies them access based on the validity of the credentials.
    */
    
	public function login()
	{
		$this->form_validation->set_rules('email','User email','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run()==false) {
            $data['css_array']       = $this->config->config['login_css'];
            $data['js_array']        = $this->config->config['login_js'];
			$data['title'] 			 ='Admin Login '.SITE_TITLE;
			$data['keyword'] 		 ='Admin Login '.SITE_TITLE;
			$data['description'] 	 ='Admin Login '.SITE_TITLE;
			$data['content']		 ='admin/login';
			echo Modules::run('template/login_template',$data);
		}else{
			$res =$this->Admin_model->getCustomFields(Tables::ADMIN,array('email'=>$this->input->post('email')),'*');
			$flag =1;
			if ($res->num_rows()>0) {
				$row = $res->row();

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
				redirect('admin/riders');
			}else{
				redirect('admin/login');
			}
		}
	}
	
	

    /* forgot form */
    public function forgot_form()
    {
        $this->load->view('admin/forgot-form',NULL);
    }

/* Send new password page for forgot admin password 
forgot_password() is a function that is usually used in a web application or website to allow a user who has got a link for forgotten their password to reset it.
*/
    public function forgot_password()
    {
        
        $query = $this->Admin_model->getCustomFields(Tables::ADMIN,array('email'=>$this->input->post('email')),'username,id');
        if ($query->num_rows()>0) {
            $div = $this->load->view('admin/new-password',array('user_detail'=>$query->row()),true);
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
       
       $affected_row = $this->Admin_model->update(Tables::ADMIN,array('id'=>encrypt_decrypt('decrypt',$this->input->post('id'))),array('password'=>md5($this->input->post('password'))));
      
       if ($affected_row) {
           echo json_encode(array('status'=>true,'message'=>'Password changed successfully'));
       }else{
         echo json_encode(array('status'=>false,'message'=>'Error occurred, Please try after some time'));
       }
    }
    
	/*  map() with two optional parameters $par and $par2.
		The function first calls another function adminAuthentication() which authenticates the administrator user.
		It then checks if the id field is not empty in the session data of the administrator user. 
	*/
	
	 public function map($par = NULL, $par2 = NULL) {
	 	$this->adminAuthentication();
        $session = $this->session->userdata('admin_user');
        if (!empty($session->id)){
            if (!empty($par)) {
               
                $qry = $this->db->query("select u.*,hph.amount as hold_amount,hph.rest_amount,r.ride_id,r.txn_id, r.drop_lat,r.drop_long,r.pickup_lat,r.pickup_long,r.pickup_adress,r.pikup_location as pickup_location,r.waiting_charge_onpickup,r.waiting_charge_ondrop,r.total_waiting_time_onpickup,r.total_waiting_time_ondrop,vd.vehicle_no,vd.color,r.drop_locatoin as drop_location,r.drop_address,r.amount,d.name as driver_name,d.email as driver_email,r.distance,r.driver_id,r.AdminRide_charges,r.user_id,r.ride_created_time,r.ride_complete_time from rides r join users d on r.driver_id = d.user_id join users u on u.user_id=r.user_id join hold_payment_history hph on hph.txn_id=r.txn_id join vehicle_detail as vd on vd.user_id=r.driver_id where ride_id = $par");
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
                $b['stop_data'] = $res = $this->db->get_where(Tables::MIDSTOPS, array("ride_id" => $par))->result();
                //$a['res'] = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($data));
                $b['title']          ='Ride Details '.SITE_TITLE;
                $b['keyword']         ='Ride Details '.SITE_TITLE;
                $b['description']     ='Ride Details '.SITE_TITLE;
                $b['content']		  ='admin/ride_details';
                echo Modules::run('template/admin_template',$b);
            } else {
                
                //$qry = $this->db->query("select users.* from users as u left join vehicle_detail as vd on vd.user_id=u.user_id where utype = 2 AND (is_online=1 OR is_online=2)");
                $qry = $this->db->query("select u.*,vd.vehicle_no,vd.color from users as u left join vehicle_detail as vd on vd.user_id=u.user_id where utype = 2 AND (is_online=1 OR is_online=2) AND is_logged_in=1 ");
                //echo $this->db->last_query();
                $res = $qry->result_array();               
                $str = '[';
                foreach ($res as $val) {
                    $qry1 = $this->db->query("select vehicle_no,color from vehicle_detail where user_id=".$val['user_id']);
					$res1 = $qry1->result_array(); 
                    $this->load->library('firebase_lib');       
					$database = $this->firebase_lib->getDatabase();
					
					//$userRef = $database->getReference('users/' . $userID);
		 
					$fbdata = $database->getReference('driver/'.$val['user_id'])->getValue();
                    
					if($fbdata){
						//$latitude= $fbdata['latitude'];
						//$longitude= $fbdata['longitude'];					

						$str .= "{position:new google.maps.LatLng(" .floatval($fbdata['latitude']) . ", " . floatval($fbdata['longitude']) . ") , avatar:'" . $val['avatar'] . "', name:'" . $val['name'] . "', email:'" . $val['email'] . "', mobile:'" . $val['mobile'] ."', vehicle_no:'" . $val['vehicle_no'] . "', color:'" . $val['color'] . "', user_id:'" . $val['user_id'] . "'},";
					   
					}
                   
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
                echo Modules::run('template/admin_template',$a);
            }
        } else {
            redirect($this->config->base_url());
        }
    }
	
	/* 
    users() is a function that is define for getting the details from user table of all users. 
    */
	public function riders()
	{
		$this->adminAuthentication();
        $data['css_array']       = $this->config->config['user_css'];
        $data['js_array']        = $this->config->config['user_js'];
		$config = array();
        $filter_data = $this->input->get();
        $data['filter_data'] = $filter_data;
        $config["base_url"] = $this->config->base_url() . "admin/riders";
        $config["total_rows"] = $this->Admin_model->get_user_list($filter_data,NULL,NULL)->num_rows();
        $config["base_url"] = $this->config->base_url() . "admin/riders";
        $config["total_rows"] = $this->Admin_model->get_user_list($filter_data,NULL,NULL)->num_rows();
        $config["per_page"]             = (isset($filter_data['per_page']) && !empty($filter_data['per_page']) && is_numeric($filter_data['per_page']))?$filter_data['per_page']:PER_PAGE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page                   = (isset($_GET['page']) && intval($_GET['page'])) ? $_GET['page'] : 0;
        $current_page           = $page;
        $page                   = ($page) ? (($page - 1) * $config["per_page"]) : 0;
        $data["links"] = $this->pagination->create_links();        
        $data['result'] = $this->Admin_model->get_user_list( $filter_data,$config["per_page"],$page)->result();
        $data['title'] 			 ='User List '.SITE_TITLE;
		$data['keyword'] 		 ='User List '.SITE_TITLE;
		$data['description'] 	 ='User List '.SITE_TITLE;
		$data['content']		 ='admin/riders';
		echo Modules::run('template/admin_template',$data);
	}
	
	
	public function riders_ride($riderid=null){
		
		$this->adminAuthentication();
        $rider_id= $riderid;
        
        $config = array();
        $filter_data = $this->input->get();
       // print_r($filter_data);
        $data['filter_data'] = $filter_data;
        $config["base_url"] = $this->config->base_url() . "admin/riders_ride";
        //$config["total_rows"] = $this->Admin_model->get_ride_list($filter_data,NULL,NULL)->num_rows();
        $config["total_rows"] = $this->Admin_model->get_ride_listby_userid($filter_data,NULL,NULL,$rider_id)->num_rows();
        $config["per_page"]   = (isset($filter_data['per_page']) && !empty($filter_data['per_page']) && is_numeric($filter_data['per_page']))?$filter_data['per_page']:PER_PAGE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page                   = (isset($_GET['page']) && intval($_GET['page'])) ? $_GET['page'] : 0;
        $current_page           = $page;
        $page                   = ($page) ? (($page - 1) * $config["per_page"]) : 0;
        $data["links"] = $this->pagination->create_links();         
        $data["result"] = $this->Admin_model->get_ride_listby_userid($filter_data,$config["per_page"],$page,$rider_id)->result();
		
		$data['rider_id'] 			 =$rider_id;
		$data['title'] 			 ='Ride List '.SITE_TITLE;
		$data['keyword'] 		 ='Ride List '.SITE_TITLE;
		$data['description'] 	 ='Ride List '.SITE_TITLE;
		$data['content']		 ='admin/get_riders_rides';
		echo Modules::run('template/admin_template',$data);
		
	}


    public function driver_ride($driver_id){
		
		$this->adminAuthentication();
        $config = array();
        $filter_data = $this->input->get();
        $data['filter_data'] = $filter_data;
        $config["base_url"] = $this->config->base_url() . "admin/riders_ride";
        //$config["total_rows"] = $this->Admin_model->get_ride_list($filter_data,NULL,NULL)->num_rows();
        $config["total_rows"] = $this->Admin_model->get_ride_list($filter_data,NULL,NULL)->num_rows();
        $config["per_page"]   = (isset($filter_data['per_page']) && !empty($filter_data['per_page']) && is_numeric($filter_data['per_page']))?$filter_data['per_page']:PER_PAGE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page                   = (isset($_GET['page']) && intval($_GET['page'])) ? $_GET['page'] : 0;
        $current_page           = $page;
        $page                   = ($page) ? (($page - 1) * $config["per_page"]) : 0;
        $data["links"] = $this->pagination->create_links();         
        $data["result"] = $this->Admin_model->get_ride_listby_driverid($filter_data,$config["per_page"],$page,$driver_id)->result();
		
		$data['driver_id'] 			 =$driver_id;
		$data['title'] 			 ='Ride List '.SITE_TITLE;
		$data['keyword'] 		 ='Ride List '.SITE_TITLE;
		$data['description'] 	 ='Ride List '.SITE_TITLE;
		$data['content']		 ='admin/get_driver_rides';
		echo Modules::run('template/admin_template',$data);
		
	}

    /* 
    The function logout_driver_user($id,$type) logs out a driver user based on the provided $id and $type parameters.
    */
    
     public function logout_driver_user($id,$type)
    
    {
    echo encrypt_decrypt('decrypt',$id);
		
        $device_token='0'; 
        $device_id='0';
        $data=$this->Admin_model->update(Tables::USER,array('user_id'=>encrypt_decrypt('decrypt',$id)),array('device_type'=>$device_id,'device_token'=>$device_token,'is_online'=>3));
        $this->Admin_model->update(Tables::USER,array('user_id'=>encrypt_decrypt('decrypt',$id)),array('is_logged_in'=>2,'is_online'=>3));
        $this->session->set_flashdata('success_msg','Logged Out successfully');
        if($type==1)
            redirect('admin/riders');
        else
            redirect('admin/drivers');
    }

    
    


	/* 
		The update_user() which updates the user data in the database table called 'USER'.
	The function first checks for the admin authentication to make sure that only authorized admins can access it.
	The function gets the user_id from the POST data and stores it in $user_id variable.
	The function gets all other POST data except for the user_id and stores them in $post_data variable.
	*/
    public function update_user()
    {
        $this->adminAuthentication();
        $user_id =$this->input->post('user_id');
        $post_data = $this->input->post();
		//echo $_FILES['verification_id']['name'];
		//echo $user_id;die;

        $query = $this->Admin_model->getCustomFields(Tables::USER,array('user_id'=>$user_id),'mobile');
            $flag=0;
        if($query->num_rows()){
            $data=$query->row();
            //return $data;die;            
            if($this->input->post('mobile')==$data->mobile){
                $flag=1;
            }
            $num   = $this->Admin_model->getSingleRecord(Tables::USER, array('mobile' => $this->input->post('mobile')));
             $total_count=$num->num_rows();
             if ($total_count>$flag){
                echo json_encode(array('status'=>false,'message'=>'This Mobile number has already been registered.'));
             }else{
                unset($post_data['user_id']);
                $affected_row = $this->Admin_model->update(Tables::USER,array('user_id'=>$user_id),$post_data);

                if ($affected_row) {
					
					
					
            //echo $this->db->last_query();
            //if ( $affected) {
                //$id= $this->input->post('user_id');
                if(!empty($_FILES['verification_id']['name'])){    
                    if (!is_dir('uploads/verification_document/'.$user_id)) {
                        mkdir('./uploads/verification_document/'.$user_id, 0777, TRUE);
                    }
                    $_FILES['file']['name'] = $_FILES['verification_id']['name'];
                    $_FILES['file']['type'] = $_FILES['verification_id']['type'];
                    $_FILES['file']['tmp_name'] = $_FILES['verification_id']['tmp_name'];
                    $_FILES['file']['error'] = $_FILES['verification_id']['error'];
                    $_FILES['file']['size'] = $_FILES['verification_id']['size'];             
                    $config['upload_path']   = './uploads/verification_document/'.$user_id; 
                    $config['allowed_types'] = 'jpg|png'; 
                    $config['max_size']      = 10000;                            
                    $config['file_name'] = $_FILES['verification_id']['name'];                 
                    $this->load->library('upload',$config); 
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file')){                                
                        $file_array = $this->upload->data();                                 
                        $this->Admin_model->update(Tables::USER,array('user_id'=>$user_id),array('verification_id'=>$file_array['file_name']));
                    }else{
                        print_r($error = array('error' => $this->upload->display_errors()));
                    }
                }
				/*
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
                        $this->Admin_model->update(Tables::USER,array('user_id'=>$id),array('avatar'=>$file_array['file_name']));
                    }else{
                        print_r($error = array('error' => $this->upload->display_errors()));
                    }
                }
				*/
				
					echo json_encode(array('status'=>true,'message'=>'Record updated successfully'));
                }else{
                    echo json_encode(array('status'=>true,'message'=>'Some error occurred, Please try after some time'));
                }
            }

        }
        
        
    }

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
        $affected_row = $this->Admin_model->update('driver_account_detail',array('user_id'=>$user_id),$post_data);

        if ($affected_row){
            echo json_encode(array('status'=>true,'message'=>'Record updated successfully'));
        }else{
             echo json_encode(array('status'=>true,'message'=>'Some error occurred, Please try after some time'));
        }
    }
	
	
	public function add_bank()
    {
        $this->adminAuthentication();
        //$user_id =$this->input->post('user_id'); 
        $post_data = $this->input->post();
        $post_data['user_id']=$this->input->post('user_id');
        $post_data['account_holder_name']=encrypt_decrypt('encrypt',$this->input->post('account_holder_name'));
        $post_data['bank_name']=encrypt_decrypt('encrypt',$this->input->post('bank_name'));
        $post_data['routing_number']=encrypt_decrypt('encrypt',$this->input->post('routing_number'));
        $post_data['account_number']=encrypt_decrypt('encrypt',$this->input->post('account_number'));
        //print_r($post_data);die;
        
        $affected_row = $this->Admin_model->save('driver_account_detail',$post_data); //('driver_account_detail',array('user_id'=>$user_id),$post_data);

        if ($affected_row){
            echo json_encode(array('status'=>true,'message'=>'Bank details successfully'));
        }else{
             echo json_encode(array('status'=>true,'message'=>'Some error occurred, Please try after some time'));
        }
    }

    /* 
    The viewDriver() retrieves the driver details and vehicle details of the user with the provided user_id parameter.
    
    */
    public function viewDriver() {
       $this->adminAuthentication();
        $res['post'] = $this->Admin_model->getDriverDetail($this->input->post("user_id"));
        
        $res['vehicle'] = $this->Admin_model->get_vehicle_detail($this->input->post("user_id")); 
      
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
            $data['post'] 			 = $this->Admin_model->getCustomFields(Tables::USER,array('user_id'=>$user_id),'*'); 
            $data['vehicle_query'] 	 = $this->Admin_model->getCustomFields(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id),'*'); 
			$data['subcategory'] = $this->db->get_where(Tables::VEHICLE_SUBCATEGORY_TYPE, array("vehicle_type_category_id" => $this->input->post("vehicle_type_category_id")))->row_array();
            $vehicle_services = $this->Admin_model->getCustomFields(Tables::VEHICLE_SERVICE,array('user_id'=>$user_id),'vehicle_type_id'); 
            //print_r($vehicle_services->result());die;
            $vehicle_service=array();
            
            if($vehicle_services->num_rows()>0){
                foreach($vehicle_services->result() as $service_array){
                    array_push( $vehicle_service,$service_array->vehicle_type_id);
                }
            }
            $data['vehicle_service']=$vehicle_service;
            $data['brands']         = $this->Admin_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title');
            $data['types']         = $this->Admin_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title');
            $data['subcategorytypes']= $this->Admin_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('status'=>1),'id,title,rate');
            $data['identification_documents']= $this->Admin_model->getCustomFields(Tables::IDENTIFICATION_DOCUMENT,array('status'=>1),'id,document_name');
			$data['countryCode']= $this->Admin_model->getCustomFields(Tables::TBL_COUNTRY,array('status'=>1),'phone_code');
            $data['title']           ='User List '.SITE_TITLE;
            $data['keyword']         ='User List '.SITE_TITLE;
            $data['description']     ='User List '.SITE_TITLE;
            $data['content']         ='admin/update_driver';
            echo Modules::run('template/admin_template',$data);
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
                'name_title'=>$post_data['name_title'],
                'name'=>$post_data['name'],
                'last_name'=>$post_data['last_name'],
                'country_code'=>$post_data['country_code'], 
                'mobile'=>$post_data['mobile'], 
                'ssn'=>$post_data['ssn'], 
                'email'=>$post_data['email'], 
                'status'=>$post_data['user_status'],                
                'identification_document_id'=>$post_data['identification_document_id'],                
                'verification_id_approval_atatus'=>$post_data['verification_id_approval_status'],                
                'identification_issue_date'=>$post_data['identification_issue_date'],                
                'identification_expiry_date'=>$post_data['identification_expiry_date'],                
                'background_approval_status'=>$post_data['background_approval_status'],                
                
                'updated_date'=>date('Y-m-d H:i:s'),
           );
            $affected = $this->Admin_model->update(Tables::USER,array('user_id'=>$user_id), $user_arr);
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
                        $this->Admin_model->update(Tables::USER,array('user_id'=>$id),array('verification_id'=>$file_array['file_name']));
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
                        $this->Admin_model->update(Tables::USER,array('user_id'=>$id),array('avatar'=>$file_array['file_name']));
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
                    $affected = $this->Admin_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]), $vehicle_arr);
                  
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
                            $this->Admin_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('car_pic'=>$file_array['file_name']));
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
                            $this->Admin_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('insurance'=>$file_array['file_name']));
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
									
                            $this->Admin_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('license'=>$file_array['file_name']));
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
                            $this->Admin_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('car_registration'=>$file_array['file_name']));
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
                            $this->Admin_model->update(Tables::VEHICLE_DETAIL,array('id'=>$post_data['vehicle_id'][$key]),array('inspection_document'=>$file_array['file_name']));
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    
                }
                
              
               
                $query = $this->Admin_model->getCustomFields(Tables::USER,array('user_id'=>$id),'*'); 
                ///$this->sendAdminRegistrationEmail($query->row(),$this->input->post('mobile'));
                $this->session->set_flashdata('success_msg','Record updated successfully');
            /*}else{
                $this->session->set_flashdata('error_msg','Some error occurred, Please try after some time');
            }*/
            redirect('admin/update_driver/'.$user_id);
        }
    }

    /* 
     This funtion retrieve a "vehicle type sheet" based on some parameters.
    */
    public function get_vehicle_type_sheet_get($seat,$vehicle_id='',$user_id='',$model_id)
     {
         
       // $seat = $this->input->post('seat');
        
       // $seat = $this->input->post('seat');
         $query = $this->db->query("SELECT id,title FROM ".Tables::VEHICLE_SUBCATEGORY_TYPE." where status=1 and id = $model_id");

        $this->Admin_model->delete_by_condition(Tables::VEHICLE_SERVICE,array('user_id'=>$user_id));
        $result = array();
        if($query->num_rows()>0)
            foreach ($query->result() as $row) {
                $this->Admin_model->save(Tables::VEHICLE_SERVICE,array('user_id'=>$user_id,'vehicle_id'=>$vehicle_id,'vehicle_type_id'=>$row->id,'created_date'=>date('Y-m-d H:i:s'),'updated_date'=>date('Y-m-d H:i:s')));
            }
        return true;
         
     }

    /*
    The "add_driver()" which appears to be designed to add a new driver to the application.
    */
    public function add_driver()
    {   
        $this->adminAuthentication();        
        $data['css_array']       = $this->config->config['add_driver_css'];
        $data['js_array']        = $this->config->config['add_driver_js'];
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('email','Email','required|valid_email|callback_useremail_check');
        $this->form_validation->set_rules('mobile','Mobile','required|min_length[10]|max_length[15]');
        /*$this->form_validation->set_rules('vehicle_no','Vehicle Number','required');
        $this->form_validation->set_rules('brand','Brand','required');
        $this->form_validation->set_rules('model','Model','required');
        $this->form_validation->set_rules('vehicle_type','Vehicle type','required');
        $this->form_validation->set_rules('rate','Rate','required');
        $this->form_validation->set_rules('vehicle_no','Vehicle no','required');
        $this->form_validation->set_rules('color','Vehical Color','required');
        $this->form_validation->set_rules('year','Vehical Year','required');*/
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        if ($this->form_validation->run()==false) {
            $data['brands']         = $this->Admin_model->getCustomFields(Tables::BRAND,array('status'=>1),'id,brand_name');
            $data['types']         = $this->Admin_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title,rate');
            $data['title']           ='Add Driver '.SITE_TITLE;
            $data['keyword']         ='Add Driver '.SITE_TITLE;
            $data['description']     ='Add Driver '.SITE_TITLE;
            $data['content']         ='admin/add_driver';
            echo Modules::run('template/admin_template',$data);
        }else{
            $post_data = $this->input->post();
            //$post_data['password'] = md5($this->input->post('mobile'));
            //$post_data['status'] = 1;
            //$post_data['utype'] = 2;
            $user_arr = array(
                'name'=>$post_data['name'],
                'email'=>$post_data['email'],
                'mobile'=>$post_data['mobile'],
                'status'=>1,
                'utype'=>2,
                'password'=>md5($post_data['mobile']),
                'created_date'=>date('Y-m-d H:i:s'),
                'updated_date'=>date('Y-m-d H:i:s'),
            );
            $this->db->trans_begin();
            $id = $this->Admin_model->save(Tables::USER,$user_arr);
            if ($id) {
                foreach ($post_data['brand'] as $key => $value) { 
                    $vehicle_arr=array();
                     $car_pic='';
                     $insurance='';
                     $license='';
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
                            $insurance=$file_array['file_name'];
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
                            $license=$file_array['file_name'];
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }                    
                    }
                    if(!empty($_FILES['car_pic']['name'][$key])){
                        if (!is_dir('uploads/car_pic/'.$id)) {
                            mkdir('./uploads/car_pic/'.$id, 0777, TRUE);
                        }
                        $_FILES['file']['name'] = $_FILES['car_pic']['name'][$key];
                        $_FILES['file']['type'] = $_FILES['car_pic']['type'][$key];
                        $_FILES['file']['tmp_name'] = $_FILES['car_pic']['tmp_name'][$key];
                        $_FILES['file']['error'] = $_FILES['car_pic']['error'][$key];
                        $_FILES['file']['size'] = $_FILES['car_pic']['size'][$key];             
                        $config['upload_path']   = './uploads/car_pic/'.$id; 
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG'; 
                        $config['max_size']      = 10000;                            
                        $config['file_name'] = $_FILES['car_pic']['name'][$key];                 
                        $this->load->library('upload',$config); 
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('file')){                                
                            $file_array = $this->upload->data();
                            $car_pic=$file_array['file_name'];
                           // $this->Admin_model->save(Tables::VEHICLE_DETAIL,$vehicle_arr);
                        }else{
                            print_r($error = array('error' => $this->upload->display_errors()));
                        }
                    }
                    $vehicle_arr = array(
                        'user_id'=> $id,
                        'brand_id'=>$post_data['brand'][$key],
                        'model_id'=>$post_data['model'][$key],
                        'vehicle_type_id'=>$post_data['vehicle_type'][$key],
                        'year'=>$post_data['year'][$key],
                        'color'=>$post_data['color'][$key],
                        'vehicle_no'=>$post_data['vehicle_no'][$key], 
                        'car_pic'=> $car_pic, 
                        'insurance'=>$insurance, 
                        'license'=>$license, 
                        'status'=>2,
                        'created_date'=>date('Y-m-d H:i:s'),
                        'updated_date'=>date('Y-m-d H:i:s'),
                    );  
                    $this->Admin_model->save(Tables::VEHICLE_DETAIL,$vehicle_arr);
                    
                }
                //$this->do_upload('insurance_document',$id,'insurance');
                //$this->do_upload('license_document',$id,'license');
                //$this->do_upload('permit_document',$id,'permit');
                //$this->do_upload('car_pic',$id,'car_pic');
                $query = $this->Admin_model->getCustomFields(Tables::USER,array('user_id'=>$id),'*'); 
                ///$this->sendAdminRegistrationEmail($query->row(),$this->input->post('mobile'));
                //$this->session->set_flashdata('success_msg','Registration successfully');
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error_msg','Some error occurred, Please try after some time');
            
            }else{
                $this->db->trans_commit();
                $this->session->set_flashdata('success_msg','Registration successfully');
            }
            redirect('admin/drivers');
        }      
        
    }

    /* 
    The "add_more_vehicle()" that appears to be designed to add more vehicles to the application.
    */
    public function add_more_vehicle($value='')
    {
        $data['brands']         = $this->Admin_model->getCustomFields(Tables::BRAND,array('status'=>1),'id,brand_name');
        $data['types']         = $this->Admin_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title,rate'); 
        $data['post_data'] =    $this->input->get(); 
      $div = $this->load->view('add-vehicle-detail',$data,true);
      echo json_encode(array('status'=>true,'html'=>$div));
    }

    /* 
    The "delete_user()" that appears to be designed to delete a user from an application
    */
	
	public function delete_user(){
		$user_id =$this->input->post('user_id');
		$is_affected = $this->Admin_model->update(Tables::USER,array('user_id'=>$user_id),array('is_deleted'=>'1','status'=>'3','is_online'=>'3','is_logged_in'=>'2'));
		if($is_affected){
			 echo json_encode(array('status'=>true,'message'=>'Account has been deleted successfully'));
			//$this->set_response(['status'=>true,'message'=>'Account has been deleted successfully']);
		}		
	}
	
    public function delete_user_permanent()
    {
        //print_r($_POST);
        $user_id =$this->input->post('user_id');
        $ride_query = $this->Admin_model->getCustomFields(Tables::RIDE,array('user_id'=>$user_id),'ride_id,user_id');
		
		$hold_query = $this->Admin_model->getCustomFields(Tables::HOLD_PAYMENT_HISTORY,array('user_id'=>$user_id),'user_id');
		
		if ($hold_query->num_rows()>0) {
			
            foreach ($ride_query->result() as $ride_row) {
				
				$this->Admin_model->delete_by_condition(Tables::HOLD_PAYMENT_HISTORY,array('user_id'=>$ride_row->user_id));
			}
		}
		
        if ($ride_query->num_rows()>0) {
			
			//$this->Admin_model->delete_by_condition(Tables::HOLD_PAYMENT_HISTORY,array('user_id'=>$user_id));
			
            foreach ($ride_query->result() as $ride_row) {
                $this->Admin_model->delete_by_condition(Tables::FEEDBACK,array('ride_id'=>$ride_row->ride_id));
                $this->Admin_model->delete_by_condition(Tables::CANCELLED_RIDE,array('ride_id'=>$ride_row->ride_id));
				//$this->Admin_model->delete_by_condition(Tables::HOLD_PAYMENT_HISTORY,array('user_id'=>$ride_row->user_id));
                $audio_ride_query = $this->Admin_model->getCustomFields(Tables::RIDE_AUDIO,array('ride_id'=>$ride_row->ride_id),'id,audio_file');
                if ($audio_ride_query->num_rows()) {
                    foreach ($audio_ride_query->result() as $audio_ride_row) {
                        $file_path = 'uploads/audio_capture/'.$audio_ride_row->audio_file;
                        if (file_exists($file_path)) {
                            @unlink($file_path);
                        }
                    $this->Admin_model->delete_by_condition(Tables::RIDE_AUDIO,array('id'=>$audio_ride_row->id));
                    
                    }
                }
                $this->Admin_model->delete_by_condition(Tables::RIDE,array('ride_id'=>$ride_row->ride_id));
            }
        }
        
        
        //$this->Admin_model->delete_by_condition(Tables::FEEDBACK,array('driver_id'=>$user_id));
        //$this->Admin_model->delete_by_condition(Tables::VEHICLE_DETAIL,array('user_id'=>$driver_id));
        
        $this->Admin_model->delete_by_condition(Tables::USER,array('user_id'=>$user_id));
        echo json_encode(array('status'=>true,'message'=>'Record deleted successfully'));
        
    }

    /*
    The "delete_driver()" that appears to be designed to delete a driver from an application.
    */
	public function delete_driver(){
		$driver_id =$this->input->post('user_id');
		$is_affected = $this->Admin_model->update(Tables::USER,array('user_id'=>$driver_id),array('is_deleted'=>'1','status'=>'3','is_online'=>'3','is_logged_in'=>'2'));
		if($is_affected){
			 echo json_encode(array('status'=>true,'message'=>'Account has been deleted successfully'));
			//$this->set_response(['status'=>true,'message'=>'Account has been deleted successfully']);
		}		
	}
	
	
	public function recover_driver_acccount(){		
		$driver_id =$this->input->post('user_id');
		$is_affected = $this->Admin_model->update(Tables::USER,array('user_id'=>$driver_id),array('is_deleted'=>'0','status'=>'1','is_online'=>'3','is_logged_in'=>'2'));
		if($is_affected){
			 echo json_encode(array('status'=>true,'message'=>'Account has been rcovered successfully'));			
		}		
	}
	
	
	public function recover_user(){		
		$driver_id =$this->input->post('user_id');
		$is_affected = $this->Admin_model->update(Tables::USER,array('user_id'=>$driver_id),array('is_deleted'=>'0','status'=>'1','is_online'=>'3','is_logged_in'=>'2'));
		if($is_affected){
			 echo json_encode(array('status'=>true,'message'=>'Account has been rcovered successfully'));			
		}		
	}
	
	/*
    The "delete_driver()" that appears to be designed to delete a driver from an application.
    */
    public function delete_driver_permanet()
    {
        //print_r($_POST);
        $driver_id =$this->input->post('user_id');
        $this->Admin_model->update(Tables::RIDE,array('driver_id'=>$driver_id),array('driver_id'=>NULL));
        $this->Admin_model->delete_by_condition(Tables::FEEDBACK,array('driver_id'=>$driver_id));
        $this->Admin_model->delete_by_condition(Tables::USER_ANSWER,array('user_id'=>$driver_id));
        $this->Admin_model->delete_by_condition(Tables::VEHICLE_SERVICE,array('user_id'=>$driver_id));
        $this->Admin_model->delete_by_condition(Tables::RIDE_AUDIO,array('user_id'=>$driver_id));
        $this->Admin_model->delete_by_condition(Tables::VEHICLE_DETAIL,array('user_id'=>$driver_id));
        $this->Admin_model->delete_by_condition(Tables::CANCELLED_RIDE,array('driver_id'=>$driver_id));
        $this->Admin_model->delete_by_condition(Tables::USER,array('user_id'=>$driver_id));
        echo json_encode(array('status'=>true,'message'=>'Record deleted successfully'));
        
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
        $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG'; 
        $config['max_size']      = 100000000; 
        //$config['max_width']     = 1024; 
        //$config['max_height']    = 768; 
        //$new_name = time().$_FILES[$index]['name'];
        //$config['file_name'] = $new_name; 
        //$config['file_name'] = $_FILES['file']['name'];
        //$path_info = pathinfo($_FILES[$index]['name']);
        ////echo $path_info['extension'];
        $new_name = time().'ridesharerates';
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
            $this->Admin_model->update(Tables::VEHICLE_DETAIL,array('user_id'=>$user_id,'id'=>$vehicle_id),$data);
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
        $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG'; 
        $config['max_size']      = 100000000; 
        //$config['max_width']     = 1024; 
        //$config['max_height']    = 768; 
        //$new_name = time().$_FILES[$index]['name'];
        //$config['file_name'] = $new_name; 
        //$config['file_name'] = $_FILES['file']['name'];
        //$path_info = pathinfo($_FILES[$index]['name']);
        ////echo $path_info['extension'];
        $new_name = 'ridesharerates'.time();
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
            $this->Admin_model->update(Tables::USER,array('user_id'=>$user_id),$data);
            //print_r( $this->upload->data());die;
            //$data = array('upload_data' => $this->upload->data()); 
            return true;
        } 
    } 
      
/* 



The "get_brand_model()" that appears to be designed to retrieve information about the brand and model of a vehicle.
*/


function do_upload_file($path,$file_name)
	{
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';
		$config['max_size']	= '10000';
		$config['max_width']  = '2024';
		$config['max_height']  = '1568';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($file_name))
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			if($this->create_thumbnail_custom($data['upload_data']['file_name']))
			{
				
			}
			return $data;
		}
	}


    public function get_brand_model()
    {
        $query = $this->Admin_model->getCustomFields(Tables::MODEL,array('brand_id'=>$this->input->post('brand_id') ,'status'=>1),'id,brand_id,model_name');
        echo json_encode(array('status'=>true,'data'=>$query->result()));
    }

/*
The "useremail_check()" that appears to be designed to check whether a user's email address already exists in a system or application. 
*/
    public function useremail_check()
    {   
        $query = $this->Admin_model->getCustomFields(Tables::USER,array('email'=>$this->input->post('email')),'user_id,email');
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
        $query = $this->Admin_model->getCustomFields(Tables::USER,array('email'=>$this->input->get('email')),'user_id,email');
            if ($query->num_rows()>0){
                    //$this->form_validation->set_message('useremail_check', 'User exists already');
                echo "false";
            }else{
                echo "true";
            }
    }

	/* 
    The "drivers()" that appears to be designed to retrieve information about drivers.
    */
	public function drivers()
	{
		$this->adminAuthentication();
        $data['css_array']       = $this->config->config['driver_css'];
        $data['js_array']        = $this->config->config['driver_js'];
		$config = array();
        $config["base_url"] = $this->config->base_url() . "admin/drivers";
        //$config["total_rows"] = count($this->db->get_where("users", array("utype" => 2,'status'=>1))->result());
        $filter_data = $this->input->get();
        $data['filter_data'] = $filter_data;       
        $config["total_rows"] = $this->Admin_model->get_driver_list($filter_data,NULL,NULL)->num_rows();;
		
        $config["per_page"]             = (isset($filter_data['per_page']) && !empty($filter_data['per_page']) && is_numeric($filter_data['per_page']))?$filter_data['per_page']:PER_PAGE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page                   = (isset($_GET['page']) && intval($_GET['page'])) ? $_GET['page'] : 0;
        $current_page           = $page;
        $page                   = ($page) ? (($page - 1) * $config["per_page"]) : 0;
        $data["links"] = $this->pagination->create_links();        
        $data["result"] = $this->Admin_model->get_driver_list( $filter_data,$config["per_page"],$page)->result();
		//print_r($data["result"]);
		//die;
		
        //$data["retings"] = $this->db->get_retings(); //employee is a table in the database
        //echo $this->db->last_query();
    	$data['title'] 			 ='Driver List '.SITE_TITLE;
		$data['keyword'] 		 ='Driver List '.SITE_TITLE;
		$data['description'] 	 ='Driver List '.SITE_TITLE;
		$data['content']		 ='admin/drivers';
		echo Modules::run('template/admin_template',$data);
	}

    /*
    The "getDriver()" that appears to be designed to retrieve information about a specific driver.
    */
    public function getDriver() {
       $this->adminAuthentication();        
        $data['post'] = $this->Admin_model->getCustomFields(Tables::USER,array('user_id'=>$this->input->post("user_id")),'*');             
        $data['brands']         = $this->Admin_model->getCustomFields(Tables::BRAND,array('status'=>1),'id,brand_name');
        $data['types']         = $this->Admin_model->getCustomFields(Tables::VEHICLETYPE,array('status'=>1),'id,title,rate');
        $this->load->view('admin/edit_driver', $data);
    }
    
    public function getbankdetails() {
       $this->adminAuthentication();        
        $usrid=$this->input->post("user_id");
        $data['bankdata'] = $this->Admin_model->getbankdetails($usrid);
        $data['usrid'] = $usrid;
		
        $this->load->view('admin/edit_bankdetails', $data);
    }

   
/*  
    The "approve_driver()" that appears to be designed to approve a driver from admin in a system or application.
*/
	function approve_driver() {
        if (!empty($this->input->post('unapproved'))) {
        	$unapproved = $this->input->post('unapproved');
        	for ($i=0; $i <count($this->input->post('unapproved')) ; $i++) { 
        		$affected_row = $this->Admin_model->update(Tables::USER,array('user_id'=>$unapproved[$i]),array('status'=>1));  
        		$this->session->set_flashdata('success_msg', 'Driver approved successfully.');
            	echo json_encode(array('status'=>true,'message'=>'Driver approved successfully.'));
        	} 
        }
    }

	/* 
        The "getrides()" that appears to be designed to retrieve information about rides in a system or application.
    */
	public function getrides()
	{
		$this->adminAuthentication();
        $config = array();
        $filter_data = $this->input->get();
        $data['filter_data'] = $filter_data;
        $config["base_url"] = $this->config->base_url() . "admin/getrides";
        //$config["total_rows"] = $this->Admin_model->get_ride_list($filter_data,NULL,NULL)->num_rows();
        $config["total_rows"] = $this->Admin_model->get_ride_list($filter_data,NULL,NULL)->num_rows();
        $config["per_page"]   = (isset($filter_data['per_page']) && !empty($filter_data['per_page']) && is_numeric($filter_data['per_page']))?$filter_data['per_page']:PER_PAGE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page                   = (isset($_GET['page']) && intval($_GET['page'])) ? $_GET['page'] : 0;
        $current_page           = $page;
        $page                   = ($page) ? (($page - 1) * $config["per_page"]) : 0;
        $data["links"] = $this->pagination->create_links();        
        $data["result"] = $this->Admin_model->get_ride_list( $filter_data,$config["per_page"],$page)->result();
		$data['title'] 			 ='Ride List '.SITE_TITLE;
		$data['keyword'] 		 ='Ride List '.SITE_TITLE;
		$data['description'] 	 ='Ride List '.SITE_TITLE;
		$data['content']		 ='admin/get_rides';
		echo Modules::run('template/admin_template',$data);
	}



   
	public function getPayments()
	{
		$this->adminAuthentication();
        $config = array();
        $filter_data = $this->input->get();
        $data['filter_data'] = $filter_data;
        $config["base_url"] = $this->config->base_url() . "admin/getpayments";
        $config["total_rows"] = $this->Admin_model->payment_history($filter_data,NULL,NULL)->num_rows();
		
       
        //$config["total_rows"] = count($this->db->get("rides")->result());
       
        $config["per_page"] = 100;
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
        
        $data["result"] = $this->Admin_model->payment_history( $filter_data,$config["per_page"],$page);
		//print_r($data["result"]);die;
        if ((isset($filter_data['export']))) {
            $export_obj = Modules::load('admin/export');             
            $export_obj->generatepaymentXls($data["result"]);die;
        }
		$data['title'] 			 ='Payment '.SITE_TITLE;
		$data['keyword'] 		 ='Payment '.SITE_TITLE;
		$data['description'] 	 ='Payment '.SITE_TITLE;
		$data['content']		 ='admin/get_payments';
		echo Modules::run('template/admin_template',$data);
	}
	 
	/* 
	public function getPayments()
	{
		
       
        //$config["total_rows"] = count($this->db->get("rides")->result());
       
       /*  $config["per_page"] = 10;
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
        $config['num_tag_close'] = '</li>'; */
		
       // $data['css_array']       = $this->config->config['driver_css'];
       // $data['js_array']        = $this->config->config['driver_js'];
		
        
               
       
    	
		//echo Modules::run('template/admin_template',$data);
		/* Code change start *
		
		$this->adminAuthentication();
        $config = array();
        $filter_data = $this->input->get();
        $data['filter_data'] = $filter_data;
        
        $config["base_url"] = $this->config->base_url() . "admin/getpayments";
        //$config["total_rows"] = $this->Admin_model->get_ride_list($filter_data,NULL,NULL)->num_rows();
        $config["total_rows"] = $this->Admin_model->payment_history($filter_data,NULL,NULL)->num_rows();
		$config["per_page"]   = (isset($filter_data['per_page']) && !empty($filter_data['per_page']) && is_numeric($filter_data['per_page']))?$filter_data['per_page']:PER_PAGE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page                   = (isset($_GET['page']) && intval($_GET['page'])) ? $_GET['page'] : 0;
        $current_page           = $page;
        $page                   = ($page) ? (($page - 1) * $config["per_page"]) : 0;
        $data["links"] = $this->pagination->create_links();        
        $data["result"] = $this->Admin_model->get_ride_list( $filter_data,$config["per_page"],$page)->result();
		
		/*Code change end*/
		
		
		
		

        //$this->pagination->initialize($config);
        //$data["links"] = $this->pagination->create_links();


        //$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        //!empty($config["per_page"]) ? $this->db->limit($config["per_page"], $page) : '';
       
        //$data['url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        //$data["result"] = $this->Admin_model->payment_history( $filter_data,$config["per_page"],$page);
		//print_r($data["result"]);die;
		/*
        if ((isset($filter_data['export']))) {
            $export_obj = Modules::load('admin/export');             
            $export_obj->generatepaymentXls($data["result"]);die;
        }
		$data['title'] 			 ='Payment '.SITE_TITLE;
		$data['keyword'] 		 ='Payment '.SITE_TITLE;
		$data['description'] 	 ='Payment '.SITE_TITLE;
		$data['content']		 ='admin/get_payments';
		echo Modules::run('template/admin_template',$data);
	}
*/
   /*  
    this function and parameter, "payout" and "$id", it is likely that this function is responsible for processing a payment to a specific recipient identified by the "$id" parameter.
    */
    public function payout($id=''){
       
        $this->adminAuthentication();
        $config = array();
        $filter_data = $this->input->get();
        $driver_id =encrypt_decrypt('decrypt',$id);
        $filter_data['driver_id'] =encrypt_decrypt('decrypt',$id);
        $data['filter_data'] = $filter_data;
       
        !empty($config["per_page"]) ? $this->db->limit($config["per_page"], $page) : ''; 
        $data['url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data["result"] = $this->Admin_model->payout_history( $filter_data,null,null);
        $data['vendorsdata']= $this->Admin_model->payout_historybyweek('rides',$driver_id); 
		//$data['bankdata']= $this->Admin_model->get_bankdata($driver_id); 
		$data['bankdata']= $this->Admin_model->getUserDetail($driver_id); 
		if ((isset($filter_data['export']))) {
            $export_obj = Modules::load('admin/export');
            $export_obj->generatepayouttXls($data["result"]);die;
        }
        $data['driver_id']		 = $driver_id;
        $data['encrypt_driver_id']		 = $id;
        $data['fee_data']        = $this->db->get("admin")->row();
        $data['title']           ='Payout '.SITE_TITLE;
        $data['keyword']         ='Payout '.SITE_TITLE;
        $data['description']     ='Payout '.SITE_TITLE;
        $data['content']         ='admin/payout';
        echo Modules::run('template/admin_template',$data);
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
        $config["total_rows"] = $this->Admin_model->get_driver_list($filter_data,NULL,NULL)->num_rows();
        $config["per_page"]             = (isset($filter_data['per_page']) && !empty($filter_data['per_page']) && is_numeric($filter_data['per_page']))?$filter_data['per_page']:PER_PAGE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page                   = (isset($_GET['page']) && intval($_GET['page'])) ? $_GET['page'] : 0;
        $current_page           = $page;
        $page                   = ($page) ? (($page - 1) * $config["per_page"]) : 0;
        $data["links"] = $this->pagination->create_links();        
        $data["result"] = $this->Admin_model->get_driver_list( $filter_data,$config["per_page"],$page)->result();
        //$data["result"] = $this->db->get_where("users", array("utype" => 2,'status'=>1))->result(); //employee is a table in the database
    	$data['title'] 			 ='Driver List '.SITE_TITLE;
		$data['keyword'] 		 ='Driver List '.SITE_TITLE;
		$data['description'] 	 ='Driver List '.SITE_TITLE;
		$data['content']		 ='admin/payout_driverlist';
		echo Modules::run('template/admin_template',$data);
	}

	


public function settings(){
    $this->adminAuthentication();
	
	//$newpwd = str_replace(' ', '', $_POST['new_password']);
    if (!empty($_POST['new_password']) && !empty($_POST['old_password'])) {   
        $qry = $this->db->query("select * from admin where password = md5('" . $_POST['old_password'] . "')");
        $res = $qry->result();
        if (!empty($res)) {
            $_POST['password'] = md5($_POST['new_password']);
            unset($_POST['new_password']);
            unset($_POST['old_password']);
        } else {
            $this->session->set_userdata(array("msg" => "Wrong password enter", "type" => "error"));
            redirect($this->config->base_url() . 'admin/settings', 'refresh');
        }
    }
	
	
    if (!empty($_POST)) { 
        if(!empty($_POST['FARE']) && !empty($_POST['UNIT'])){
            $this->db->where('name','FARE');
            $this->db->update("settings", array("value"=>$_POST['FARE'])); 
            $this->db->where('name','UNIT');
            $this->db->update("settings", array("value"=>$_POST['UNIT'])); 
            unset($_POST['FARE']);
            unset($_POST['UNIT']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }

    if (!empty($_POST)) { 
        if(!empty($_POST['admin_fee'])){
            $this->db->where('admin_fee','admin_fee');
            $this->db->update("admin", array("value"=>$_POST['admin_fee'])); 
            unset($_POST['admin_fee']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }
	
	
	if (!empty($_POST)) { 
        if(!empty($_POST['free_waiting_time_pickup'])){
            $this->db->where('free_waiting_time_pickup','free_waiting_time_pickup');
            $this->db->update("admin", array("value"=>$_POST['free_waiting_time_pickup'])); 
            unset($_POST['free_waiting_time_pickup']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }
	
	if (!empty($_POST)) { 
        if(!empty($_POST['free_waiting_time_stop'])){
            $this->db->where('free_waiting_time_stop','free_waiting_time_stop');
            $this->db->update("admin", array("value"=>$_POST['free_waiting_time_stop'])); 
            unset($_POST['free_waiting_time_stop']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }
	
	if (!empty($_POST)) { 
        if(!empty($_POST['free_waiting_time_drop'])){
            $this->db->where('free_waiting_time_drop','free_waiting_time_drop');
            $this->db->update("admin", array("value"=>$_POST['free_waiting_time_drop'])); 
            unset($_POST['free_waiting_time_drop']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }
	
	if (!empty($_POST)) { 
        if(!empty($_POST['paid_waiting_time_pickup'])){
            $this->db->where('paid_waiting_time_pickup','paid_waiting_time_pickup');
            $this->db->update("admin", array("value"=>$_POST['paid_waiting_time_pickup'])); 
            unset($_POST['paid_waiting_time_pickup']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }
	
	if (!empty($_POST)) { 
        if(!empty($_POST['paid_waiting_time_stop'])){
            $this->db->where('paid_waiting_time_stop','paid_waiting_time_stop');
            $this->db->update("admin", array("value"=>$_POST['paid_waiting_time_stop'])); 
            unset($_POST['paid_waiting_time_stop']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }
	
	if (!empty($_POST)) { 
        if(!empty($_POST['paid_waiting_time_drop'])){
            $this->db->where('paid_waiting_time_drop','paid_waiting_time_drop');
            $this->db->update("admin", array("value"=>$_POST['paid_waiting_time_drop'])); 
            unset($_POST['paid_waiting_time_drop']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }


    if (!empty($_POST)) { 
        if(!empty($_POST['driver_distance'])){
            $this->db->where('driver_distance','driver_distance');
            $this->db->update("admin", array("value"=>$_POST['driver_distance'])); 
            unset($_POST['driver_distance']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }

    if (!empty($_POST)) { 
        if(!empty($_POST['accept_ride_distance'])){
            $this->db->where('accept_ride_distance','accept_ride_distance');
            $this->db->update("admin", array("value"=>$_POST['accept_ride_distance'])); 
            unset($_POST['accept_ride_distance']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }

    if (!empty($_POST)) { 
        if(!empty($_POST['accept_point_distance'])){
            $this->db->where('accept_point_distance','accept_point_distance');
            $this->db->update("admin", array("value"=>$_POST['accept_point_distance'])); 
            unset($_POST['accept_point_distance']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }

    if (!empty($_POST)) { 
        if(!empty($_POST['drop_point_distance'])){
            $this->db->where('drop_point_distance','drop_point_distance');
            $this->db->update("admin", array("value"=>$_POST['drop_point_distance'])); 
            unset($_POST['drop_point_distance']);
        } 
        $this->db->update("admin", $_POST);
        $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
        redirect($this->config->base_url() . 'admin/settings');
    }
    
    
	
    $data['res'] =          $this->db->get("admin")->row();
    $data['set'] =          $this->db->get("settings")->result();
    $data['rate'] =         $this->db->get(Tables::RATE_CHART)->row();
    $data['title'] 			 = 'Setting '.SITE_TITLE;
    $data['keyword'] 		 = 'Setting '.SITE_TITLE;
    $data['description'] 	 = 'Setting '.SITE_TITLE;
    $data['content']		 = 'admin/settings';
    echo Modules::run('template/admin_template',$data);
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
            echo Modules::run('template/admin_template',$data);
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
            $this->Admin_model->update(Tables::RATE_CHART,array('id'=>1), $arr);
            $this->session->set_userdata(array("msg" => "Record updated successfully ", "type" => "success"));
            redirect($this->config->base_url() . 'admin/settings');
        }
	}

/* 
This function is responsible for ending a user's current session and logging them out of a system or application.
*/
	public function logout() {

        $this->session->sess_destroy();

        redirect($this->config->base_url('/admin'), 'refresh');
    }

    /* 
    This function is responsible for retrieving user information for a particular system or application.
    */
    public function getUser() {
        $this->adminAuthentication();
        $res['identifications'] =$this->Admin_model->getCustomFields(Tables::IDENTIFICATION_DOCUMENT,array('status'=>1),'id,document_name');
        $res['post'] = $this->db->get_where("users", array("user_id" => $this->input->post("user_id")))->row_array();
        $res['countryCode']= $this->Admin_model->getCustomFields(Tables::TBL_COUNTRY,array('status'=>1),'phone_code');
        $this->load->view('admin/edit_user', $res);
    }
	public function getsubCategory() {
		//print_r($this->input->get());
		//die;
        $this->adminAuthentication();
        $res = $this->db->get_where(Tables::VEHICLE_SUBCATEGORY_TYPE, array("vehicle_type_category_id" => $this->input->get("vehicle_type_category_id")))->result();
        echo json_encode(array('status'=>true,'data'=>$res)); die;
       
    }
	
	public function getYear() {
		//print_r($this->input->get());
		//die;
        $this->adminAuthentication();
        $res = $this->db->get_where(Tables::TBL_CATEGORY_YEAR, array("category_id" => $this->input->get("category_id")))->result();
        echo json_encode(array('status'=>true,'data'=>$res)); die;
       
    }

    public function getPassword() {
        $this->adminAuthentication();
        $res['identifications'] =$this->Admin_model->getCustomFields(Tables::IDENTIFICATION_DOCUMENT,array('status'=>1),'id,document_name');
        $res['post'] = $this->db->get_where("users", array("user_id" => $this->input->post("user_id")))->row_array();
        $this->load->view('admin/edit_password', $res);
    }

    public function update_passpord() {       
    
        $this->adminAuthentication();
        $user_id =$this->input->post('user_id');
        $post_data = md5($this->input->post('password'));
        $affected_row = $this->Admin_model->updatepassword($user_id,$post_data);

        if($affected_row){
            $this->session->set_flashdata('success_msg','Password updated successfully');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('success_msg','Some error occurred, Please try after some time !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // if ($affected_row) {
        //     echo json_encode(array('status'=>true,'message'=>'Record updated successfully'));
        // }else{
        //      echo json_encode(array('status'=>true,'message'=>'Some error occurred, Please try after some time'));
        // }
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
            $data['breadcrumb']      = 'Add make ';
            $data['content']         = 'admin/add_brand';
            echo Modules::run('template/admin_template',$data);
        }else{
            $post_data =$this->input->post();
            $post_data['created_date'] = date('Y-m-d H:i:s');
            $post_data['updated_date'] = date('Y-m-d H:i:s');
            $id=$this->Admin_model->save(Tables::BRAND,$post_data);
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
            $data['breadcrumb']      = 'Edit brand ';
            $data['content']         = 'admin/edit_brand';
            $data['brand']           = $this->Admin_model->getCustomFields(Tables::BRAND,array('id'=>$id),'*');
            echo Modules::run('template/admin_template',$data);
        }else{
            $post_data =$this->input->post();   
            unset($post_data['id']) ;       
            $post_data['updated_date'] = date('Y-m-d H:i:s');

            $id=$this->Admin_model->update(Tables::BRAND,array('id'=>$this->input->post('id')),$post_data);
            
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
        $data['brands']          =$this->Admin_model->get_brand_list($filter_data,null,null);
        $data['breadcrumb']      = 'Brand list ';
        $data['title']           = 'Brand List '.SITE_TITLE;
        $data['keyword']         = 'Brand List '.SITE_TITLE;
        $data['description']     = 'Brand List '.SITE_TITLE;
        $data['content']         = 'admin/brand_list';
        echo Modules::run('template/admin_template',$data);
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
        $data['models']          = $this->Admin_model->get_brand_model_list($filter_data,null,null);
        $data['breadcrumb']      = 'Model make list ';
        $data['title']           = 'Brand List '.SITE_TITLE;
        $data['keyword']         = 'Brand List '.SITE_TITLE;
        $data['description']     = 'Brand List '.SITE_TITLE;
        $data['content']         = 'admin/brand_model_list';
        echo Modules::run('template/admin_template',$data);
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
            $data['brands']          =$this->Admin_model->getCustomFields(Tables::BRAND,array('status'=>1),'id,brand_name');
            $data['title']           = 'Add Brand '.SITE_TITLE;
            $data['keyword']         = 'Add Brand '.SITE_TITLE;
            $data['description']     = 'Add Brand '.SITE_TITLE;
            $data['breadcrumb']      = 'Add model make';
            $data['content']         = 'admin/add_model';
            echo Modules::run('template/admin_template',$data);
        }else{

            $post_data =$this->input->post();
            $post_data['created_date'] = date('Y-m-d H:i:s');
            $post_data['updated_date'] = date('Y-m-d H:i:s');
            $id=    $this->Admin_model->save(Tables::MODEL,$post_data);
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
            $data['brands']          =$this->Admin_model->getCustomFields(Tables::BRAND,array('status'=>1),'id,brand_name');
            $data['models']          =$this->Admin_model->getCustomFields(Tables::MODEL,array('id'=>$id),'id,model_name,brand_id,status');
             
            $data['title']           = 'Add Brand '.SITE_TITLE;
            $data['keyword']         = 'Add Brand '.SITE_TITLE;
            $data['description']     = 'Add Brand '.SITE_TITLE;
            $data['breadcrumb']      = 'Edit brand model';
            $data['content']         = 'admin/edit_model';
            echo Modules::run('template/admin_template',$data);
        }else{

            $post_data =$this->input->post();   
            unset($post_data['id']) ;       
            $post_data['updated_date'] = date('Y-m-d H:i:s');

            $id=$this->Admin_model->update(Tables::MODEL,array('id'=>$this->input->post('id')),$post_data);
            
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
        $data['types']           = $this->Admin_model->getCustomFieldsDesc(Tables::VEHICLETYPE,'1=1','id,title,status,created_date,short_description','sequence_label','ASC');
        $data['vhecile']           = $this->Admin_model->getCustomFieldsDesc(Tables::VEHICLE_SUBCATEGORY_TYPE,'1=1','*','sequence_label','ASC');
        $data['title']           = 'Vehicle type List '.SITE_TITLE;
        $data['keyword']         = 'Vehicle type List '.SITE_TITLE;
        $data['description']     = 'Vehicle type List '.SITE_TITLE;
        $data['breadcrumb']      = 'Vehicle type list';
        $data['content']         = 'admin/vehicle_type_list';
        echo Modules::run('template/admin_template',$data);
    }

    /*
    This function is intended to add a vehicle chart to a database or other data storage system, and the $id parameter might refer to the ID of the chart to be added.
    */
    public function add_vehicle_chart($id=null) {
        $this->adminAuthentication(); 
        $this->form_validation->set_rules('title','Vehicle type','required'); 
        if ($this->form_validation->run()==false) {
            $data['types']           = $this->Admin_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('id'=>$id),'id,title,status,created_date,short_description'); 
            $data['title']           = 'Add vehicle Chart '.SITE_TITLE;
            $data['keyword']         = 'Add vehicle Chart '.SITE_TITLE;
            $data['description']     = 'Add vehicle Chart '.SITE_TITLE;
            $data['breadcrumb']      = 'Add vehicle chart';
            $data['content']         = 'admin/add_vehicle_rate_chart';
            echo Modules::run('template/admin_template',$data);
        }else{
            $post_data = $this->input->post();
            unset($post_data['id']);  
            $post_data['updated_date'] = date('Y:m:d H:i:s');
            $affected = $this->Admin_model->update(Tables::VEHICLE_SUBCATEGORY_TYPE,array('id'=>$this->input->post('id')), $post_data);
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

    public function vehicle_subcategorytype_form(){
        $data["result"] = $this->db->query("select * from vehicle_type")->result();
       $this->load->view('admin/add_vehicle_subcategory',$data);  
    }

    /*
    
    This function is intended to add a new vehicle type to a database or other data storage system, likely based on user input from a form or other source.
    */
    public function add_vehicle_type(){   
        
        $post_data['title'] =$this->input->post('title');
        $post_data['short_description'] =$this->input->post('short_description');
        $post_data['created_date'] =date('Y-m-d H:i:s');
        $post_data['updated_date'] =date('Y-m-d H:i:s');
        $post_data['status'] =1;
		
		 $max_value = $this->Admin_model->get_max_value();
		
        if ($max_value !== null) {
            $post_data['sequence_label']=$max_value+1;
        } else {
            $post_data['sequence_label']=0;
        }
        $category_id = $this->Admin_model->save(Tables::VEHICLETYPE,$post_data);
		$start_year=$this->input->post('start_year');
		$end_year=$this->input->post('end_year');
        if($category_id){
			 for ($year = $start_year; $year <= $end_year; $year++) {
				if ($this->Admin_model->insert_year($year,$category_id)) {
					
				} 
			}
			
          echo json_encode(array('status'=>true,'message'=>'Data added successfully.'));
        }else{
             echo json_encode(array('status'=>true,'message'=>'Error occurred, please try after some time'));
        }
    }
	
	
	public function edit_vehicle_category($id=null) {
        //echo $id; die;
		$this->adminAuthentication(); 
         
        if ($this->form_validation->run()==false) {
            $data['category']           = $this->Admin_model->getCustomFields(Tables::VEHICLETYPE,array('id'=>$id),'id,title,short_description,status'); 
            $data['category_year'] = $this->db->get_where(Tables::VEHICLE_YEAR, array('id'=>$id))->result();
			//$data['category']           = $this->Admin_model->getCustomFields(Tables::VEHICLETYPE,'1=1','id,title,status');
			//print_r( $data['category']); die;           
		    $data['title']           = 'Edit vehicle Category '.SITE_TITLE;
            $data['keyword']         = 'Edit vehicle Category '.SITE_TITLE;
            $data['description']     = 'Edit vehicle Category '.SITE_TITLE;
            $data['breadcrumb']      = 'Edit vehicle category'; 
            $data['content']         = 'admin/edit_vehicle_type';
            echo Modules::run('template/admin_template',$data);
        }else{
            $post_data = $this->input->post();
            unset($post_data['id']);  
            $post_data['updated_date'] = date('Y:m:d H:i:s');
            $affected = $this->Admin_model->update(Tables::VEHICLETYPE,array('id'=>$this->input->post('id')), $post_data);
            if ($affected) {
                $this->session->set_flashdata('success_msg','Data updated successfully');
                return redirect('admin/vehicle_type_list');
            }else{
                $this->session->set_flashdata('success_msg','Some error occurred, please try after some time');
				return redirect('admin/vehicle_type_list');
            }
            return redirect('admin/vehicle_type_list');
        } 
    }

    public function add_vehiclesubcategory_type(){   
        
        $post_data = $this->input->post();
        //print_r($post_data);die;
        
        $post_data['created_date'] =date('Y-m-d H:i:s');
        $post_data['updated_date'] =date('Y-m-d H:i:s');
        
        $id = $this->Admin_model->save(Tables::VEHICLE_SUBCATEGORY_TYPE,$post_data);
        
        if ($id){            
            $path = './uploads/vehicle_image';
            if($_FILES){
                $pic_file = $_FILES['car_pic']['name'];
                if ($pic_file != '') {
                    $image_data = $this->doMediaUpload($path, 'car_pic', $pic_file);
                    $uploaded_file = $image_data['upload_data']['file_name'];
                    $postData['car_pic'] = $uploaded_file;
                    $resData=$this->Admin_model->update_vehile_img(Tables::VEHICLE_SUBCATEGORY_TYPE,$id,$postData);
                    //$resData = $this->Auth_model->updatevehcle_img($user_id,$postData);
                    if($resData){
                        $this->session->set_flashdata('success_msg','Data Inserted successfully');
                        redirect('admin/vehicle_type_list');
                    }else{
                        $this->session->set_flashdata('success_msg','Something went Wrong!');
                        redirect('admin/vehicle_type_list');
                    }
                }
            }else{
                $this->session->set_flashdata('success_msg','Something went Wrong!');
                redirect('admin/vehicle_type_list');
            }
        
        }else{
            $this->session->set_flashdata('success_msg','Data Inserted successfully');
            redirect('admin/vehicle_type_list');
        }
    }
	
	
	
	
	public function update_vehicle_category(){
        	
        $post_data['id'] = $this->input->post('id');
        $post_data['title'] = $this->input->post('title');
        $post_data['short_description'] = $this->input->post('short_description');
        $post_data['status'] = $this->input->post('status');
        $post_data['created_date'] =date('Y-m-d H:i:s');
        $post_data['updated_date'] =date('Y-m-d H:i:s');

        $id = $this->Admin_model->update(Tables::VEHICLETYPE,array('id'=>$post_data['id']), $post_data);        
		if($id){
			$start_year = $this->input->post('start_year');
			$end_year = $this->input->post('end_year');
			
			$year_data = $this->Admin_model->vehicle_category_year($post_data['id']);
			$first = reset($year_data);
			$last  = end($year_data);
			if($start_year==$first->category_year && $end_year==$last->category_year){
				$this->session->set_flashdata('success_msg','Data Updated successfully');
				return redirect('admin/vehicle_type_list');
			}else{
				$result = $this->Admin_model->delete_by_condition(Tables::VEHICLE_YEAR,array('category_id'=>$post_data['id']));
				if($result){
					 for ($year = $start_year; $year <= $end_year; $year++) {
						 //print_r($year);
						if ($this->Admin_model->insert_year($year,$post_data['id'])) {
							
						}  
					 }
					 
					
				}
				$this->session->set_flashdata('success_msg','Data Updated successfully');
				return redirect('admin/vehicle_type_list');
			}
			
			
			$this->session->set_flashdata('success_msg','Data Updated successfully');
			return redirect('admin/vehicle_type_list');
		}else{
			$this->session->set_flashdata('success_msg','Something went Wrong!');
			return redirect('admin/vehicle_type_list');
		}
	}

    
	public function delete_vehicle_category()
    {
        //print_r($_POST);
        $vehicle_id =$this->input->post('id');		
        $ride_query = $this->Admin_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('vehicle_type_category_id'=>$vehicle_id),'id');
		//print_r($ride_query->result()); die;
			if ($ride_query->num_rows()>0) {				
				foreach ($ride_query->result() as $ride_row){
					//print_r($ride_row->id); die;
				   $subcategory = $this->Admin_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('id'=>$ride_row->id),'id,car_pic');
					 if ($subcategory->num_rows()) {
						foreach ($subcategory->result() as $subcategory_row) {
							$file_path = 'uploads/vehicle_image/'.$subcategory_row->car_pic;
							if (file_exists($file_path)) {
								@unlink($file_path);
							}
						$this->Admin_model->delete_by_condition(Tables::VEHICLE_SUBCATEGORY_TYPE,array('id'=>$subcategory_row->id));
						
						}
					} 
					
				}
			}
			$this->Admin_model->delete_by_condition(Tables::VEHICLE_YEAR,array('category_id'=>$vehicle_id));
			$this->Admin_model->delete_by_condition(Tables::VEHICLETYPE,array('id'=>$vehicle_id));
		    
			echo json_encode(array('status'=>true,'message'=>'Vehicle Type deleted successfully'));        
    }
	
	public function delete_vehicle_subcategory()
    {
		$subcatgory_id =$this->input->post('id');
		$data=$this->Admin_model->delete_by_condition(Tables::VEHICLE_SUBCATEGORY_TYPE,array('id'=>$subcatgory_id));
		if($data)       
			echo json_encode(array('status'=>true,'message'=>'Vehicle Subcategory deleted successfully'));     
	}    
	
	
	
	
	
	
	public function edit_vehicle_subcategory($id=null) {
        $this->adminAuthentication(); 
        $this->form_validation->set_rules('title','Vehicle type','required'); 
        $this->form_validation->set_rules('rate','Rate','required');  
        if ($this->form_validation->run()==false) {
            $data['types']           = $this->Admin_model->getCustomFields(Tables::VEHICLE_SUBCATEGORY_TYPE,array('id'=>$id),'*'); 
            $data['category']           = $this->Admin_model->getCustomFields(Tables::VEHICLETYPE,'1=1','id,title,status');
            $data['title']           = 'Edit vehicle SubCategory '.SITE_TITLE;
            $data['keyword']         = 'Edit vehicle SubCategory '.SITE_TITLE;
            $data['description']     = 'Edit vehicle SubCategory '.SITE_TITLE;
            $data['breadcrumb']      = 'Edit vehicle subCategory'; 
            $data['content']         = 'admin/edit_vehicle_subcategory';
            echo Modules::run('template/admin_template',$data);
        }else{
            $post_data = $this->input->post();
            unset($post_data['id']);  
            $post_data['updated_date'] = date('Y:m:d H:i:s');
            $affected = $this->Admin_model->update(Tables::VEHICLETYPE,array('id'=>$this->input->post('id')), $post_data);
            if ($affected) {
                $this->session->set_flashdata('success_msg','Data updated successfully');
                return redirect('admin/vehicle_type_list');
            }else{
                $this->session->set_flashdata('success_msg','Some error occurred, please try after some time');
				return redirect('admin/vehicle_type_list');
            }
            return redirect('admin/vehicle_type_list');
        } 
    }


    public function update_vehicle_subcategory(){

        $imgsize = $_FILES['car_pic']['size'];
        $post_data = $this->input->post();
        //print_r($post_data);die;//2000000
       
        $post_data['created_date'] =date('Y-m-d H:i:s');
        $post_data['updated_date'] =date('Y-m-d H:i:s');
		if($imgsize <=2048000){
			//echo "size is max";
			//print_r($_FILES['car_pic']['size']);
			//die;
			$new_image = $_FILES['car_pic']['name'] ? $_FILES['car_pic']['name'] : '';
			
			if($new_image != ''){
				
				$old_image = $this->Admin_model->getoldImage($post_data['id']);
				
				if(isset($old_image)){
					unlink('./uploads/vehicle_image/'.$old_image->car_pic);
				}
			}
			
			//$id = $this->Admin_model->update(Tables::VEHICLE_SUBCATEGORY_TYPE,$post_data);
			$id = $this->Admin_model->update(Tables::VEHICLE_SUBCATEGORY_TYPE,array('id'=>$post_data['id']), $post_data);
			
					
				$path = './uploads/vehicle_image';
				if($new_image != ''){
					$pic_file = $_FILES['car_pic']['name'];
					if ($pic_file != '') {
						$image_data = $this->doMediaUpload($path, 'car_pic', $pic_file);
						$uploaded_file = $image_data['upload_data']['file_name'];
						$postData['car_pic'] = $uploaded_file;
						//print_r($postData);die;
						$resData=$this->Admin_model->update_vehile_img(Tables::VEHICLE_SUBCATEGORY_TYPE,$post_data['id'],$postData);
						//$resData = $this->Auth_model->updatevehcle_img($user_id,$postData);
						if($resData){
							$this->session->set_flashdata('success_msg','Data Updated successfully');
						 return redirect('admin/vehicle_type_list');
						}else{
							$this->session->set_flashdata('success_msg','Something went Wrong!');
						  return redirect('admin/vehicle_type_list');
						}
					}
				}else{             
				
					$this->session->set_flashdata('success_msg','Data Updated successfully!');
					return redirect('admin/vehicle_type_list');
				}
		}else{
			$this->session->set_flashdata('error_msg','image size must be less than 2mb !');
			return redirect('admin/edit_vehicle_subcategory/'.$post_data['id']);
		} 
        
    }

    
    

/*  
This function is intended to handle a file download for a specific $object related to a $vehicle_id. The $object parameter might refer to the type of file or resource being downloaded, while the $vehicle_id parameter might refer to the specific vehicle associated with the file or resource.
*/
    public function download($object,$vehicle_id){
        
        //load download helper
        $this->load->helper('download');
        
        //get file info from database
        $fileInfo = $this->Admin_model->getCustomFields(Tables::VEHICLE_DETAIL,array('id'=>$vehicle_id),'user_id,'.$object);
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
		echo Modules::run('template/admin_template',$data);
    }
    
    public function edit_version($id=null){
        $this->adminAuthentication();
        $data['title']           = 'Edit Version Details '.SITE_TITLE;
        $data['keyword']         = 'Edit Version Details '.SITE_TITLE;
        $data['description']     = 'Edit Version Details '.SITE_TITLE;
        $data['content']         = 'admin/edit_version';
        $data['brand']           = $this->db->query("select * from version where id = $id")->row();
        echo Modules::run('template/admin_template',$data);
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

    function doMediaUpload($path, $fileName, $mediaFile){
        $config['upload_path'] = $path;
        $config['allowed_types'] = '*';
        $config['max_size'] = '20048';
        $new_name = time() . '-' . $mediaFile;
        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($fileName)) {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data;
        }
    }
	
	
	/*************	 Stripe Payout functions	*****************/
	
	public function stripe_authorize($driver_id=null) {
		//echo $this->config->item('stripe_secret'); die;
        $this->adminAuthentication(); 
		if ($driver_id){
			$driver_query = $this->Admin_model->getCustomFields(Tables::USER,array('user_id'=>$driver_id),'*');
			if($driver_query->num_rows()>0){
				//Load stripe library
				$this->load->library('common/stripe_lib');

				$driver = $driver_query->row();
				//echo "<pre>"; print_r($driver ); die;
				if($driver && !empty($driver->stripe_account_id)){
					$accountId = $driver->stripe_account_id;
				}else{
					// To create new connect account 
					$userdata = array(
						'email' => $driver->email,
						'country' => 'US'
					);
					$account = $this->stripe_lib->createConnectAccount($userdata);
					//echo "<pre>"; print_r($account ); die;
					$accountId = $account['id'];
					
					// Update stripe account for drivers
					$this->Admin_model->update(Tables::USER,array('user_id'=>$driver_id),array('stripe_account_id'=>$accountId));
				}
				
				// Create an account link for the user's Stripe account
				$connectData = array(
					'accountId' 	=> $accountId,
					'refresh_url' 	=> $this->config->base_url("admin/stripe_authorize/".$driver_id),
					'return_url'	=> $this->config->base_url("admin/stripe_onboarded/".$driver_id),
				);
				$accountLink = $this->stripe_lib->createConnectAccountLinks($connectData);
				
				if($accountLink['url']){
					redirect($accountLink['url'], 'refresh'); die;
				}else{
					$this->session->set_flashdata('error_msg',$accountLink);
					redirect('admin/payout/'.encrypt_decrypt('encrypt',$driver_id) );
				}
			}else{
				$this->session->set_flashdata('error_msg','Invalid driver to authorize.');
				redirect('admin/payout/'.encrypt_decrypt('encrypt',$driver_id) );
			}			
		}else{
			$this->session->set_flashdata('error_msg','Invalid driver to authorize.');
			redirect('admin/payout_driver');
		}
	}
	
	public function stripe_onboarded($driver_id=null) {
        $this->adminAuthentication(); 
		if ($driver_id){
			$driver_query = $this->Admin_model->getCustomFields(Tables::USER,array('user_id'=>$driver_id),'*');
			if($driver_query->num_rows()>0){
				$driver = $driver_query->row();
				if($driver && !empty($driver->stripe_account_id)){
					//Load stripe library
					$this->load->library('common/stripe_lib');

					$accountId = $driver->stripe_account_id;
					$account = $this->stripe_lib->retrieveAccount($accountId);
					//echo "<pre>"; print_r($account ); die;
					if($account['details_submitted']){
						// Update stripe onboarded or not
						$this->Admin_model->update(Tables::USER,array('user_id'=>$driver_id),array('stripe_onboarding'=>$account['details_submitted']));
						$this->session->set_flashdata('success_msg','Stripe account setup successfully.');
						redirect('admin/payout/'.encrypt_decrypt('encrypt',$driver_id) );
					}else{
						$this->session->set_flashdata('error_msg','Stripe details are pending to submit.');
						redirect('admin/payout/'.encrypt_decrypt('encrypt',$driver_id) );
					}
					
				}else{
					$this->session->set_flashdata('error_msg','Invalid Stripe Account ID.');
					redirect('admin/payout_driver');
				}
				
			}else{
				$this->session->set_flashdata('error_msg','Invalid driver to authorize.');
				redirect('admin/payout_driver');
			}			
		}else{
			$this->session->set_flashdata('error_msg','Invalid driver to authorize.');
			redirect('admin/payout_driver');
		}
	}
	
	public function stripe_payout() {
        $this->adminAuthentication(); 
		
		$post_data = $this->input->post();
		//print_r($post_data); die;
		if (!empty($post_data['driver_id'])){
			$driver_id = $post_data['driver_id'];
			$driver_query = $this->Admin_model->getCustomFields(Tables::USER,array('user_id'=>$driver_id),'*');
			if($driver_query->num_rows()>0){
				$driver = $driver_query->row();
				if($driver && !empty($driver->stripe_account_id)){
					//Load stripe library
					$this->load->library('common/stripe_lib');

					$orderData = array(
						'amount' =>  ($post_data['amount']*100),
						'accountId' => $driver->stripe_account_id
					);
					$payout_data = $this->stripe_lib->createPayout($orderData);
					
					//echo "<pre>".strlen($payout_data['id'])."Ride ID".$post_data['ride_id']; die;
					$id_length=strlen($payout_data['id']);
					//print_r($payout_data ); die;
					if($id_length > 4){
						$url= $_SERVER['HTTP_REFERER'];
        
							//$prefix='TXNID_';
							$unique = $payout_data['id'];
							$reqstatus=1;
							$genratedate = date("d-m-Y H:i:s");
							
							$data=array(
								'driver_id'=>$driver_id,
								'ride_id'=>$post_data['ride_id'],
								'total_payout'=>$post_data['amount'],
								'paid_amount'=>$post_data['amount'],
								'txn_id'=>$unique,
								'genrated_payout_date'=>$genratedate,
								'status'=>$reqstatus,
							);
							 $paid_status['is_payout_completed']='1';
							 //$paid_status['txn_id']=$unique;
							 $paid_status['payout_txn_id']=$unique;
							
							$payout_status = $this->Admin_model->save('payout_status',$data);
							 
							 $affected_row = $this->Admin_model->update(Tables::RIDE,array('ride_id'=>$post_data['ride_id']),$paid_status);
							 if($affected_row){
								 $this->session->set_flashdata('success_msg','Driver payout paid successfully. Reference with transection id: '.$payout_data['id']);
								 
								 redirect('admin/payout/'.encrypt_decrypt('encrypt',$driver_id) );
								
							 }else{
								$this->session->set_flashdata('error_msg','Stripe details are pending to submit.');
								redirect('admin/payout/'.encrypt_decrypt('encrypt',$driver_id) ); 
							 }				
						
						
					}else{
						$this->session->set_flashdata('error_msg','insufficient balance in your stripe account.');
						redirect('admin/payout/'.encrypt_decrypt('encrypt',$driver_id) );
					}
					
				}else{
					$this->session->set_flashdata('error_msg','Invalid Stripe Account ID.');
					redirect('admin/payout_driver');
				}
				
			}else{
				$this->session->set_flashdata('error_msg','Invalid driver to authorize.');
				redirect('admin/payout_driver');
			}			
		}else{
			$this->session->set_flashdata('error_msg','Invalid driver to authorize.');
			redirect('admin/payout_driver');
		}
	}
	
	public function stripe_balance() {       
		
		$this->load->library('common/stripe_lib');
		$balance_check = $this->stripe_lib->checkBalance();
		echo "<pre>";
		print_r($balance_check); die;
	}
	
	
	
	public function customer_stripe_accounts(){     
		
		$this->load->library('common/stripe_lib');
		$all_accounts = $this->stripe_lib->customerAccount();
		echo "<pre>";
		print_r($all_accounts); die;
	}
	
	/* public function customer_stripe_accountsdata() {       
		$alluser = $this->Admin_model->get_driverWithStripeId();
		if($alluser->num_rows()>0){
				$driver = $alluser->result();
			//print_r($driver->stripe_account_id);
			
		 }
		 foreach($driver as $dlist){
			 //echo $dlist->stripe_account_id;
			 //die;
			$this->load->library('common/stripe_lib');
			$customer = $this->stripe_lib->customerbyaccount($dlist->stripe_account_id, []); 
		 }
		
		echo "<pre>";
		print_r($customer['email']); die;

	} */
	
	/*###################
		Function: For reset Stripe account of driver 
		Dev:Ram
	#####################*/
	
	public function reset_stripe_account($id) {       
		 $driver_id =encrypt_decrypt('decrypt',$id);
		 $query = $this->Admin_model->getCustomFields(Tables::USER,array('user_id'=>$driver_id),'stripe_account_id');
			
        if($query->num_rows()){			
			$this->load->library('common/stripe_lib');
			$reset_account = $this->stripe_lib->deleteAccount($query->row()->stripe_account_id);
			if($reset_account){
				$this->Admin_model->update(Tables::USER,array('user_id'=>$driver_id),array('stripe_account_id'=>NULL,'stripe_onboarding'=>NULL));
			}
			
			$this->session->set_flashdata('success_msg','Stripe account reset successfully');
				redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error_msg','account details not found');
            redirect($_SERVER['HTTP_REFERER']);
		}
		
	}
	
	public function firebasedb(){
       // $accountPath = APPPATH . 'config\ridesharerates-403909-b02864c4c7ae.json';
        $this->load->library('firebase_lib');       
         $database = $this->firebase_lib->getDatabase();
		 $userID=590;
		 //$data= $database->getReference('driver'.$userID)->getValue();
		 
            $data['demo']= $database->getReference('driver/'.$userID)->getValue();
			print_r($data['demo']);
			die;
			
            $data['title']           = 'test data '.SITE_TITLE;
            $data['keyword']         = 'test data '.SITE_TITLE;
            $data['description']     = 'test data '.SITE_TITLE;
            $data['breadcrumb']      = 'test data'; 
            $data['content']         = 'admin/demo';
            echo Modules::run('template/admin_template',$data);

    }
	
	public function customer_stripe_token($token) {       
		
		$this->load->library('common/stripe_lib');
		$all_accounts = $this->stripe_lib->getToken($token);
		echo "<pre>";
		print_r($all_accounts); die;
	}
	
	public function deleteCustmerToken() {       
		
		$this->load->library('common/stripe_lib');
		$all_accounts = $this->stripe_lib->deleteToken('cus_QA4BFSZP5eJKTo','card_1PJjzjAyQV9SI7qTCsWfWick',[]);
		echo "<pre>";
		print_r($all_accounts); die;
	}
	
	public function updateToken() {       
		
		$this->load->library('common/stripe_lib');
		$all_accounts = $this->stripe_lib->updateToken('tok_1PJjzjAyQV9SI7qTkMHbZdQz',['status' => 'suspended']);
		echo "<pre>";
		print_r($all_accounts); die;
	}
	
	public function card_listing() {       
		
		$this->load->library('common/stripe_lib');
		$all_accounts = $this->stripe_lib->listcard('card_1PJugvAyQV9SI7qT9H1MnyFO');
		echo "<pre>";
		print_r($all_accounts); die;
	}
	
	

    public function addFirebaseUser(){

        $name= $this->input->post('name');
        $lastname = $this->input->post('last_name');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        
        $postdata=[
            'name'=>$name,
            'last_name'=>$lastname,        
            'latitude'=>$latitude,        
            'longitude'=>$longitude,        
        ];


       // print_r($formData);
        
        $this->load->library('firebase_lib');        
        $database = $this->firebase_lib->getDatabase();
        
           $data = $database->getReference('posts')->push($postdata);
           
           redirect('admin/get_data_from_firebase');

    }

    function custom_log($level, $message) {
		$CI =& get_instance();
		
		// Check if the log directory exists, if not create it
		if (!is_dir($CI->config->item('log_path'))) {
			mkdir($CI->config->item('log_path'),0755, true);
		}
		
		// Generate log file name with current date
		$log_file = $CI->config->item('log_path') . 'custom_' . date('Y-m-d') . '.' . $CI->config->item('log_file_extension');
		
		// Write log message to the file
		$log_message = date('Y-m-d H:i:s') . ' --> ' . strtoupper($level) . ': ' . $message . "\n";
		file_put_contents($log_file, $log_message, FILE_APPEND);
	}

    public function update_menu_order(){

            $posts = $this->Admin_model->get_all();            
            $order_data = $this->input->post('order');
            foreach ($posts as $post){
                foreach ($order_data as $order){
                    if($order['id'] == $post->id){
                        $update_data = array('sequence_label' => $order['position']);                       
                        $this->Admin_model->update_sequence($post->id, $update_data);
                    }
                }                
            }

            echo json_encode(array('status'=>200,'message'=>'Sequence changed successfully'));
    }


    public function update_subcategory_order(){

         $posts = $this->Admin_model->get_allSubcategory();            
         $order_data = $this->input->post('order');
        // $i=0;// Loop through each post
            foreach ($posts as $post) {
                foreach ($order_data as $order){
                    if ($order['id'] == $post->id){
                        $update_data = array('sequence_label' => $order['position']);                       
                        $this->Admin_model->update_subcat_sequence($post->id, $update_data);
                    }
                }
                
            }
            
            echo json_encode(array('status'=>200,'message'=>'Sequence changed successfully'));
    }
    
    
}