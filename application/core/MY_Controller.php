<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";
class MY_Controller extends MX_Controller {	
	function __construct() 
	{
		parent::__construct();
		$this->_hmvc_fixes();
	}

	function _hmvc_fixes()
	{		
		//fix callback form_validation		
		//https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
		$this->load->library(array('form_validation', 'email', 'parser'));
		$this->form_validation->CI =& $this;
	}

	public function is_logged_in(){
		if($this->session->userdata('user_detail')['logged_in']){
			return true;
		}else{
			return false;
		}
	}

	//Check Admin authentication
	public function adminAuthentication(){
		$user_group = $this->session->userdata('admin_user');
		if( empty($this->session->userdata('admin_user')) ){
			$this->session->set_flashdata('error_msg','Not logged-in or session expired.');
			redirect('admin/login'); 
		}
	}



	/* verification mail */

	public function verification_mail($userdata)
	{
		$content  = "<p>Hi, " .$userdata->name."</p>";

		$content .= "<p>" . htmlspecialchars("Welcome to the world's only High-end Rideshare!") . "</p>";	

		$content .= "<p>Support Message is : <span><b>".$userdata->otp."</b></span></p>";         

        $content .="<p>For any questions contact customer support at: <a href='mailto:".DEFAULT_EMAIL_MSG."'> Ridesharerates@gmail.com</a>.</p>";        

	    $this->sendEmail($userdata->email, 'Ridesharerates Verification Support Message', $content);
      
	}
	
	
	public function devtest_mail()
	{
		$content  = "<p>Hi, Ram Chauhan</p>";
		$content .= "<p>" . htmlspecialchars("Welcome to the world's only High-end Rideshare!") . "</p>";	
		$content .= "<p>Support Message is : <span><b>2333</b></span></p>";         
        $content .= "<p>For any questions contact customer support at: <a href='mailto:".DEFAULT_EMAIL_MSG."'> Ridesharerates@gmail.com</a>.</p>";        

	    $this->sendEmail('otp@rideshareRates.com', 'Ridaesharerates Verification Support Message', $content);
      
	}



	public function welcome_mail($userdata)	{

		//print_r($userdata);

		$content  = "<p>Hi, " .$userdata->name."</p>";

		$content .= "<p>Welcome to ".DEFAULT_SITE_TITLE."! We are glad to see you here!</p>";	
     
      $content .= "<p>For any questions contact customer support at: <a href='mailto:".DEFAULT_EMAIL_MSG."'> Ridesharerates@gmail.com</a>.</p>";        

      $this->sendEmail($userdata->email, 'Welcome RideShareRates', $content);

	}

	public function ride_complete_mail($userdata){
		//print_r($userdata);
		$content  = "<p>Hi, " .$userdata->user_name."</p>";

		$content .= "<p>Your ride has been completed</p>"; 
        $content .= "<p>For any questions contact customer support at: <a href='mailto:".DEFAULT_EMAIL_MSG."'> Ridesharerates@gmail.com</a>.</p>";  
		$this->sendEmail($userdata->email, 'Welcome', $content);
	}

    /* help section mail */

    public function help_section_mail($userdata){

		$content  = "<p>Hi, " .$userdata->name."</p>";
		$content  .= "<p>Email: " .$userdata->email."</p>";
		$content .= "<p>Question:".$userdata->question."</p>";         
		$content .= "<p>Answer:".$userdata->answer."</p>";         
        $content .= "<p>For any questions contact customer support at: <a href='mailto:".DEFAULT_EMAIL_MSG."'> Ridesharerates@gmail.com</a>.</p>";         
	    $this->sendEmail($userdata->question_email, 'Help section ', $content);

	}



	/* Welcome signup mail */

	/*public function sendRegistrationEmail($userdata)

	{



		//print_r($userdata);



		



		$content   = "<p>Hi, " .$userdata->name."</p>";



	    $content .= "<p>Welcome to ".DEFAULT_SITE_TITLE."! You are the newest member of our community and we're really excited to have you on board.</p>";



	    $content .= "<p>If you have any questions about Club Reward or would like to discuss our service, please contact our Customer Support Team at  <a href='mailto:" . DEFAULT_SITE_EMAIL . "'>" . DEFAULT_SITE_EMAIL . "</a>.</p>";



	    $content .= "<p>We are here to help,</p>";



	    $content .= "<p>The CLUB Reward Team</p>";



		



		$this->sendEmail($userdata->email, DEFAULT_SITE_TITLE.' Sign Up', $content);



		        //echo  $content;die;



	}*/



	/* Welcome signup mail */



	/*public function sendAdminRegistrationEmail($userdata,$password)



	{



		//print_r($userdata);



		



		$content   = "<p>Hi, " .$userdata->name."</p>";



	    $content .= "<p>Welcome to ".DEFAULT_SITE_TITLE."! You are the newest member of our community and we're really excited to have you on board.</p>";



	    $content .= "<p>User name: ".$userdata->email."</p>";



	    $content .= "<p>Password: ".$password."</p>";



	    $content .= "<p>If you have any questions about Club Reward or would like to discuss our service, please contact our Customer Support Team at  <a href='mailto:" . DEFAULT_SITE_EMAIL . "'>" . DEFAULT_SITE_EMAIL . "</a>.</p>";



	    $content .= "<p>We are here to help,</p>";



	    $content .= "<p>The CLUB Reward Team</p>";



		



		$this->sendEmail($userdata->email, DEFAULT_SITE_TITLE.' Sign Up', $content);



		        //echo  $content;die;



	}*/

	/* send mail */

	public function sendEmail11($to, $subject, $content, $attachment = NULL) {

        /* $this->load->helper('phpmailer');

        $email_data = array(

            'content' => $content,

        );

         $from = array(DEFAULT_EMAIL_FROM, DEFAULT_SITE_EMAIL);

        

            $to = $to;

            $subject = $subject;

            $message = $this->parser->parse('common/email_template/default_email', $email_data, TRUE);

            @phpmail_send($from, $to, $subject,$message,$attachment); */

            //$headers = "From: ".DEFAULT_EMAIL_FROM;

            //$headers .= "MIME-Version: ".DEFAULT_SITE_TITLE."\r\n";

            //$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            //$send = mail($to, $subject, $message, $headers);



		$this->load->library('email');   

        $config = array();

        $config['protocol']     = "smtp"; // you can use 'mail' instead of 'sendmail or smtp'
        $config['smtp_host']    = "smtp.office365.com";// you can use 'smtp.googlemail.com' or 'smtp.gmail.com' instead of 'ssl://smtp.googlemail.com'
        $config['smtp_user']    = "otp@ridesharerates.com"; // client email gmail id
        $config['smtp_pass']    = "Gangster31507^"; // client password
        $config['smtp_port']    =  587;
        $config['smtp_crypto']  = 'tls';
        $config['smtp_timeout'] = "";
        $config['mailtype']     = "html";
        $config['charset']      = "ISO 8859-1";
        //$config['charset']      = "utf-8";
        $config['newline']      = "\r\n";		
        $config['wordwrap']     = TRUE;
		$config['validate']     = FALSE;
		 
        $this->load->library('email', $config); // intializing email library, whitch is defiend in system
        $this->email->set_newline("\r\n"); // comuplsory line attechment because codeIgniter interacts with the SMTP server with regards to line break 
		$this->email->set_crlf( "\r\n" ); 		

        //Load email library
        $this->email->from('otp@ridesharerates.com');
        $this->email->to($to);
        $this->email->subject($subject); 
        $this->email->message( $content);  // we can use html tag also beacause use $config['mailtype'] = 'HTML'

        //Send mail

        if($this->email->send()){

            $this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");
            echo "email_sent";
        }
        else{
            echo "email_not_sent";
            echo $this->email->print_debugger();  // If any error come, its run

        }
    }

	public function testMail2()

	{

		$content  = "<p>Hi,</p>";
		//$content .= "<p>Welcome to ".DEFAULT_SITE_TITLE."! We are glad to see you here!</p>"; 

        //$content .= "<p>If you have any questions about ".SITE_TITLE." or would like to discuss our service, please contact our Customer Support Team at <a href='mailto:" . DEFAULT_SITE_EMAIL . "'>" . DEFAULT_SITE_EMAIL . "</a>.</p>";
	    $this->sendEmail('ramkishor.niletechnologies@gmail.com', 'Welcome Ridesharerates', $content);

	}

/*
	public function sendEmail($to, $subject, $content, $attachment = NULL) 
	{

		

		$this->load->library('email');   

        $config = array();

        $config['protocol']     = "smtp"; // you can use 'mail' instead of 'sendmail or smtp'

        $config['smtp_host']    = "smtp.office365.com";// you can use 'smtp.googlemail.com' or 'smtp.gmail.com' instead of 'ssl://smtp.googlemail.com'

        $config['smtp_user']    = "otp@ridesharerates.com"; // client email gmail id

        $config['smtp_pass']    = "RideShareRates@2023"; // client password

        $config['smtp_port']    =  587;

        $config['smtp_crypto']  = 'tls';

        $config['smtp_timeout'] = "";

        $config['mailtype']     = "html";

        $config['charset']      = "utf-8";

        $config['newline']      = "\r\n";


        $this->load->library('email', $config); // intializing email library, whitch is defiend in system

        $this->email->set_header('Content-Type', 'text/html');

        $this->email->set_newline("\r\n"); // comuplsory line attechment because codeIgniter interacts with the SMTP server with regards to line break

    

        $this->email->set_mailtype("html");     

        $this->email->from('otp@ridesharerates.com');

        $this->email->to($to);

        $this->email->subject($subject); 

        $this->load->library('parser');

        $email_data = array(

            'content' => $content,

        );

        $body = $this->parser->parse('common/email_template/default_email', $email_data, TRUE);

        $this->email->message( $body);  // we can use html tag also beacause use $config['mailtype'] = 'HTML'

        

        if($this->email->send()){

            $this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");

			return true;

        }

        else{

            

           $this->email->print_debugger();  // If any error come, its run

		   return false;

        }

    }
	*/


	public function sendEmail($to, $subject, $content, $attachment = NULL){
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.office365.com';
		$config['smtp_port'] = 587;
		$config['smtp_user']  = 'otp@ridesharerates.com';  
		$config['smtp_pass']  = 'Gangster31507^';  
		$config['_smtp_auth'] = true;
		$config['smtp_crypto'] = 'tls';
		//$config['charset'] = 'iso-8859-1';
		$config['protocol'] = 'smtp';
		$config['mailtype']  = 'html'; 
		$config['charset']    = 'utf-8';
		$config['wordwrap']   = TRUE;
		
		//$this->email->set_header('Content-Type', 'text/html');
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");	
		$this->email->set_crlf( "\r\n" ); 
		$this->email->set_mailtype("html");
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->from('otp@ridesharerates.com');
		$this->email->to($to);
		$this->email->subject($subject);
		//$this->email->message($content);
		 $this->load->library('parser');

        $email_data = array(
            'content' => $content,
        );
		
        $body = $this->parser->parse('common/email_template/default_email', $email_data, TRUE);

        $this->email->message( $body);  // we can use html tag also beacause use $config['mailtype'] = 'HTML'
		//$this->email->send();
		//Send mail
		if($this->email->send()){

            $this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");

			return true;
		}

        else{           

           $this->email->print_debugger();  // If any error come, its run

		   return false;

        }
		

	}




   /* public function sendAdminResetPasswordEmail($user_data) {

        $this->load->helper('phpmailer');
        $slug = md5($user_data->id . $user_data->email . date('Ymd'));
        $email_data = array(
            'user_name'  => $user_data->first_name . ' ' . $user_data->last_name,
            'user_email' => $user_data->email,
            'reset_link' => base_url('reset-password-success/' . $user_data->id . '/' . $slug),
            'expire_msg' => 'Note: This reset code will expire after ' . date('j M Y') . '.',
        );
        $subject   = 'Password reset for ' . DEFAULT_SITE_TITLE;
        $email_msg = $this->parser->parse('common/email_template/reset_password_email', $email_data, TRUE);
        echo  $email_msg;die;
        $from = array(DEFAULT_EMAIL_FROM, DEFAULT_SITE_TITLE);
        @phpmail_send($from, $user_data->email, $subject, $email_msg);
    }*/







}







/* End of file MY_Controller.php */



/* Location: ./application/core/MY_Controller.php */



