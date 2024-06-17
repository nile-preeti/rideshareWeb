<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends MY_Controller{
    
    function  __construct(){
        parent::__construct();
    }
        
        

       
    function send(){
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');
        
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        //$mail = new PHPMailer;
        // SMTP configuration
        $mail->isSMTP();
        $mail->SMTPDebug = 4;
        $mail->Host     = 'sg2plcpnl0193.prod.sin2.secureserver.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'smtp@nileprojects.in';
        $mail->Password = 'smtp@2023##';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        
        $mail->setFrom('smtp@niletechinnovations.com', 'CodexWorld');
        
         //Email Settings
        $mail->isHTML(true);
        $mail->setFrom('smtp@niletechinnovations.com');
	    $mail->AddReplyTo('smtp@niletechinnovations.com');
	    $mail->addAddress('sram004@gmail.com');
        
        // Email subject
        $mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';
      
        
        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $mailContent;
        
        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }
    }
    
}