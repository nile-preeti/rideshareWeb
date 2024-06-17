<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
/** 
 * Stripe Library for CodeIgniter 3.x 
 * 
 * Library for Stripe payment gateway. It helps to integrate Stripe payment gateway 
 * in CodeIgniter application. 
 * 
 * This library requires the Stripe PHP bindings and it should be placed in the third_party folder. 
 * It also requires Stripe API configuration file and it should be placed in the config directory. 
 * 
 * @package     CodeIgniter 
 * @category    Libraries 
 * @author      Arun Verma 
 * @version     1.0 
 */ 
 
class Stripe_lib{ 
    var $CI; 
    var $api_error; 
     
    function __construct(){ 
        $this->api_error = ''; 
        $this->CI =& get_instance(); 
        //$this->CI->load->config('stripe'); 
         
        // Include the Stripe PHP bindings library 
        //require APPPATH .'third_party/stripe-php/init.php'; 
        require APPPATH .'third_party/stripe-php-master/init.php'; 
        // Set API key 
        \Stripe\Stripe::setApiKey($this->CI->config->item('stripe_secret')); 
		 
    } 
 
    function addCustomer($name, $email, $token){ 
        try { 
            // Add customer to stripe 
            $customer = \Stripe\Customer::create(array( 
                'name' => $name, 
                'email' => $email, 
                'source'  => $token 
            )); 
            return $customer; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    } 
     
    function createPlan($planName, $planPrice, $planInterval){ 
        // Convert price to cents 
        $priceCents = ($planPrice*100); 
        $currency = $this->CI->config->item('stripe_currency'); 
         
        try { 
            // Create a plan 
            $plan = \Stripe\Plan::create(array( 
                "product" => [ 
                    "name" => $planName 
                ], 
                "amount" => $priceCents, 
                "currency" => $currency, 
                "interval" => $planInterval, 
                "interval_count" => 1 
            )); 
            return $plan; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    } 
     
    function createSubscription($customerID, $planID){ 
        try { 
            // Creates a new subscription 
            $subscription = \Stripe\Subscription::create(array( 
                "customer" => $customerID, 
                "items" => array(
                    array( 
                        "plan" => $planID 
                    ), 
                ), 
				"trial_period_days" => 30,
            )); 
             
            // Retrieve charge details 
            $subsData = $subscription->jsonSerialize(); 
            return $subsData; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
			return false; 
        } 
    } 
	
	public function createPayment($card_id, $postData){
		//$currency = $this->CI->config->item('stripe_currency'); 

		try {
         // print_r($this->CI->config->item('stripe_secret')); die;
            if (empty($card_id)) {
				
				
				\Stripe\Stripe::setApiKey($this->CI->config->item('stripe_secret'));
			  
				$paydata = \Stripe\Charge::create ([
						"amount" => $postData['amount'],
						"currency" => "usd",
						"source" => $postData['stripeToken'],
						"description" => $postData['description']
				]);
			}else{
				
				$charge = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
				
				$paydata=$charge->charges->capture($postData['txn_id'],['amount' =>$postData['amount'],]);
				//print_r($paydata); die;
			}				
			// after successfull payment, you can store payment related information into your database
              
			//$data = array('success' => true, 'data'=> $charge);
			$paymentData = $paydata->jsonSerialize(); 
            return $paymentData;
			
			//echo json_encode($data);
		}catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
	}
	
	function cancelSubscription($subscriptionID){ 
		$stripe = new \Stripe\StripeClient( $this->CI->config->item('stripe_api_key') );
		try { 
            // Delete a subscription 
            $prod = $stripe->subscriptions->cancel( $subscriptionID, [] );
			$prod_data = array('status'=>true,'data'=>$prod->jsonSerialize());
            return $prod_data; 
			
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
			$error_data = array('status'=>false,'message'=>$e->getMessage());
            return $error_data; 
        } 
		
		/*
        try { 
            // Cancel subscription 
            $subscription = \Stripe\Subscription::cancel($subscriptionID); 
            $subsData = $subscription->jsonSerialize(); 
            return $subsData; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        }
		*/
    } 
	

	// Functions for connect account
	public function createConnectAccount($postData){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$accountData = $stripe->accounts->create([
			  'type' 		=> 'express',
			  'country' 	=> $postData['country'],
			  'email' 		=> $postData['email'],
			  /*'business_type'=> 'individual',
			  'capabilities' => [
				'card_payments' => ['requested' => true],
				'transfers' => ['requested' => true],
			  ],
			  */
			]);
            return $accountData->jsonSerialize();
		}catch(Exception $e) { 
            return $e->getMessage(); 
        } 
	}
	
	public function createConnectAccountLinks($postData){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$accountData = $stripe->accountLinks->create([
			  'account' 	=> $postData['accountId'],
			  'refresh_url' => $postData['refresh_url'],
			  'return_url' => $postData['return_url'],
			  'type' => 'account_onboarding'
			]);
            return $accountData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
	
	//Retrieve connected account with Stripe
	public function retrieveAccount($stripeAccountID){
		try{
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$accountData = $stripe->accounts->retrieve($stripeAccountID, []);
			return $accountData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        }
	}
	
	//To transfer amount to connected account with Stripe
	public function createPayout($postData){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$transData = $stripe->transfers->create([
			  'amount' => $postData['amount'],
			  'currency' => 'usd',
			  'destination' => $postData['accountId'],
			  //'transfer_group' => 'ORDER_95',
			]);
            return $transData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
	
	//Retrieve connected account balance  with Stripe
	public function checkBalance(){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$transData =$stripe->balance->retrieve([]);
			
            return $transData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
	//Retrieve all connected account with Stripe
	public function customerAccount(){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$transData =$stripe->accounts->all([]);
			
            return $transData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
	
	public function customerbyaccount($account_id){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$transData =$stripe->accounts->retrieve($account_id,[]);
			
            return $transData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
	
	public function deleteAccount($account_id){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$transData =$stripe->accounts->delete($account_id, []);
			
            return $transData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
	
	
	public function getToken($token){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$transData =$stripe->tokens->retrieve($token,[]);
			
            return $transData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
	
	public function deleteToken($account_id,$card_id){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$transData =$stripe->customers->deleteSource($account_id,$card_id,[]);
			
            return $transData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
	
	
	public function updateToken($token,$status){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$transData =$stripe->issuing->tokens->update($token,$status);
			
            return $transData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
	
	public function listcard($card_id){
		try {
			$stripe = new \Stripe\StripeClient($this->CI->config->item('stripe_secret'));
			$transData =$stripe->issuing->tokens->all(['limit' => 1,'card' => $card_id,]);
			
            return $transData->jsonSerialize();
		}catch(Exception $e) { 
			return $e->getMessage();
        } 
	}
//$stripe->issuing->tokens->all(['limit' => 3,'card' => 'ic_1MytUz2eZvKYlo2CZCn5fuvZ',]);
	

	

}