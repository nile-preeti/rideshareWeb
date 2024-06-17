<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH .'third_party/stripe-php-master/init.php'; 

class StripeWeb extends MY_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();       
        
        $this->load->library(array('common/common','session'));
        $this->load->helper('url');
        Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
    }    

    public function index()
    {
        $this->load->view('checkout');
    }

    
    

    
    public function handlePayment()
    {
        
       //print_r($this->input->post('stripeToken'));die;
        
        /*\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
         $detail = \Stripe\Customer::All(['limit'=>100]);
        echo '<pre>';
        print_r($detail);die();*/

        /*$detail = \Stripe\Customer::retrieve(
          'cus_KGaOHT4lcJM9q3',[]          
        );
        echo '<pre>';
        print_r($detail);die();*/
        try { 
            // Add customer to stripe 
            //print_r($_POST);die;
            $customer = \Stripe\Customer::create(array( 
                'email' => 'shivendra121@hotmail.com', 
                'source'  => $this->input->post('stripeToken') 
            )); 
            echo '<pre>';
            //print_r($customer->sources->data[0]['brand']);
            //print_r($customer->sources->data[0]['funding']);
            print_r($customer);//die;//cus_KGaOHT4lcJM9q3
            //return $customer; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
        //die;
     
        $payment = \Stripe\Charge::create ([
                "amount" => 100 * 120,
                "currency" => "usd",
                /*"source" => $this->input->post('stripeToken'),*/
                "customer" => $customer->customer_id,
                "description" => "Dummy stripe payment." 
        ]);
        echo '<pre>';
        echo $payment->balance_transaction;
        echo $payment->amount/100;
        print_r($payment);die;
            
        $this->session->set_flashdata('success', 'Payment has been successful.');
             
        redirect('api/StripePayment', 'refresh');
    }
}