<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



function phpmail_send($from, $to, $subject, $message, $attachment_path = NULL, $cc = NULL, $bcc = NULL){

	$ci=&get_instance();

	$ci->load->library('email');   

	$config = array();

	$config['protocol']     = "smtp"; // you can use 'mail' instead of 'sendmail or smtp'

	$config['smtp_host']    = "ssl://smtp.googlemail.com";// you can use 'smtp.googlemail.com' or 'smtp.gmail.com' instead of 'ssl://smtp.googlemail.com'

	$config['smtp_user']    = "amagaservice@gmail.com"; // client email gmail id

	$config['smtp_pass']    = "Nsjof87g"; // client password

	$config['smtp_port']    =  465;

	$config['smtp_crypto']  = 'ssl';

	$config['smtp_timeout'] = "";

	$config['mailtype']     = "html";

	$config['charset']      = "iso-8859-1";

	$config['newline']      = "\r\n";

	$config['wordwrap']     = TRUE;

	$config['validate']     = FALSE;
	//$mail->SMTPDebug = 1;
	$ci->load->library('email', $config); // intializing email library, whitch is defiend in system



	$ci->email->set_newline("\r\n"); // comuplsory line attechment because codeIgniter interacts with the SMTP server with regards to line break



	

	//Load email library

	if (is_array($from)){

		// This array should be address, name

		$ci->email->from($from[0], $from[1]);

	}else{

		// This is just an address

		$ci->email->from($from);

	}

	$ci->email->from('amagaservice@gmail.com');

	$ci->email->to($to);

	$ci->email->subject($subject); 

	$ci->email->message($message);  // we can use html tag also beacause use $config['mailtype'] = 'HTML'

	//Send mail

	if($ci->email->send()){

		$ci->session->set_flashdata('msg', 'The email has been sent');

		@unlink($attachment_path);

		return TRUE;

	}

	else{

		

		$ci->session->set_flashdata('msg', $ci->email->print_debugger());

		@unlink($attachment_path);

		return FALSE;

	}

}

function phpmail_send1($from, $to, $subject, $message, $attachment_path = NULL, $cc = NULL, $bcc = NULL){

	require_once(APPPATH . 'helpers/phpmailer/class.phpmailer.php');

	
	$ci=&get_instance();	



	// Create the basic mailer object



	$mail			 = new PHPMailer();

// 	 $config['protocol'] = 'sendmail';
// $config['smtp_host'] = 'localhost';
// $config['smtp_user'] = '';
// $config['smtp_pass'] = '';
// $config['smtp_port'] = 25;
   $mail = new PHPMailer();
   $mail->isSMTP();                                      
   
   $mail->SMTPAuth = false;
   $mail->SMTPSecure = 'none';
   $mail->Host = "localhost"; 
   $mail->Port = 25;
    
//$this->load->library('email', $config);

	//$mail->IsSMTP();                                     // Set mailer to use SMTP	
	//$mail->protocol='sendmail';
	//$mail->Host = 'localhost';              //ssl://smtp.googlemail.com   // Specify main and backup server
	//$mail->Port = 587;                                    // Set the SMTP port
	//$mail->SMTPAuth = false;                               // Enable SMTP authentication
	$mail->Username = 'customer@getduma.com';                // SMTP username
	$mail->Password = '^oehwoDYEKG2';                  // SMTP password
	//$mail->SMTPSecure = 'tls';
	$mail->SMTPDebug  = 1;	
	$mail->IsHtml(true);
	$mail->Subject	 = $subject;
	$mail->Body		 = $message;

	if (is_array($from)){

		// This array should be address, name

		$mail->SetFrom($from[0], $from[1]);

	}else{

		// This is just an address

		$mail->SetFrom($from);

	}

	// Allow multiple recipients delimited by comma or semicolon

	$to = (strpos($to, ',')) ? explode(',', $to) : explode(';', $to);

	// Add the addresses

	foreach ($to as $address){

		$mail->AddAddress($address);

	}

	if ($cc){

		// Allow multiple CC's delimited by comma or semicolon

		$cc = (strpos($cc, ',')) ? explode(',', $cc) : explode(';', $cc);

		// Add the CC's

		foreach ($cc as $address){

			$mail->AddCC($address);

		}

	}

	if ($bcc){

		// Allow multiple BCC's delimited by comma or semicolon

		$bcc = (strpos($bcc, ',')) ? explode(',', $bcc) : explode(';', $bcc);

		// Add the BCC's

		foreach ($bcc as $address){

			$mail->AddBCC($address);

		}

	}

	// Add the attachment if supplied

	if ($attachment_path){

		$mail->AddAttachment($attachment_path);

	}

	// And away it goes...

	if ($mail->Send()){

		$ci->session->set_flashdata('msg', 'The email has been sent');

		@unlink($attachment_path);

		return TRUE;

	}else{

		// Or not...

		$ci->session->set_flashdata('msg', $mail->ErrorInfo);

		@unlink($attachment_path);

		return FALSE;

	}

}





?>