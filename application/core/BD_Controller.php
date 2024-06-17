<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;

class BD_Controller extends REST_Controller
{
	private $user_credential;
    function __construct()
    {   
        parent::__construct();    
        $this->load->model(array('api/Auth_model'));
        $this->load->library(array('common/common'));       
    }
    public function auth()
    {
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        //JWT Auth middleware
        $headers = $this->input->get_request_header('Authorization');

        $kunci = $this->config->item('thekey'); //secret key for encode and decode
        $token= "token";
       	if (!empty($headers)) {

        	if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
            $token = $matches[1];

        	}
    	}
        try {

           $decoded = JWT::decode($token, $kunci, array('HS256'));
           $this->user_data = $decoded;//e10adc3949ba59abbe56e057f20f883e
           /* $query = $this->Auth_model->getCustomFields(Tables::LOGIN_TOKEN,array('user_id'=>$this->user_data->id),'token');
           if($query->num_rows()>0){
                $query_data = JWT::decode($query->row()->token, $kunci, array('HS256'));
                if($this->user_data->iat!=$query_data->iat){
                    $this->response(['status'=>false,'message'=>'Logged-out successfully']);
                }
            } */
           
        } catch (Exception $e) {
            $invalid = ['status' => $e->getMessage()]; //Respon if credential invalid
            $this->response(['status'=>false,'message'=>$e->getMessage()], 401);//401
        }
    }
}