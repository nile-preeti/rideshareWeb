<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Mailtest extends MY_Controller
{

//    $config['mailpath'] = "/usr/sbin/sendmail";
// $config['protocol'] = "sendmail";
// $config['smtp_host'] = "relay-hosting.secureserver.net";

    function send_email(){
    $config = array(
             'mailpath'=>'/usr/sbin/sendmail',
             'protocol' => 'sendmail',
             'smtp_host' => 'smtp.office365.com',
             'smtp_port' => 587,
             'smtp_user' => 'support@ridesharerates.com', // change it to yours
             'smtp_pass' => 'RideShareRates@2023', // change it to yours
             'mailtype' => 'html',
             'charset' => 'UTF-8',
             'wordwrap' => TRUE
          ); 
		    
        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        $this->email->from('support@ridesharerates.com');
        $this->email->to('ramkishor.chauhan@niletechnologies.com');


        $this->email->subject("test");
        $this->email->message("message from RIdesharerates mailtest");

        $result = $this->email->send();


        if ($result) {
            echo  "Success";

        }
        else{
            echo $this->email->print_debugger();
        }
    }
}    