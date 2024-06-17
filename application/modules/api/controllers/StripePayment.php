<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'third_party/stripe-php-master/init.php'; 



class StripePayment extends BD_Controller {

    function __construct()

    {

        // Construct the parent class

        parent::__construct();

        $this->auth();

        $this->load->library(array('common/common','session','common/tables','form_validation'));

        $this->load->model(array('api/Auth_model'));

        $this->load->helper(array('url','common/common'));

        Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

    } 

    
    // For make default
    public function make_default_post($value='')

    {

       $this->Auth_model->update(TABLES::CARD_DETAIL,array('user_id'=>$this->user_data->id),array('is_default'=>2));

       $affected =$this->Auth_model->update(TABLES::CARD_DETAIL,array('id'=>$this->input->post('card_id')),array('is_default'=>$this->input->post('is_default')));

       if( $affected){

           $this->set_response(['status'=>true,'message'=>"Successfully"], REST_Controller::HTTP_OK);

       }else{

            $this->set_response(['status'=>true,'message'=>"Error occured, Please try after some time"], REST_Controller::HTTP_OK);

       }

    }

    // For getting cards list
    public function card_list_get($value='')
    {
        $query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('user_id'=>$this->user_data->id),'*');
        $result =array();
        if ($query->num_rows()>0) {
            foreach ($query->result() as  $row) {
                $result[]= array( 
                    'id'=>$row->id,                   
                    'card_number'=>substr_replace(encrypt_decrypt('decrypt',$row->card_number), str_repeat("*", 10), 2, 10),
                    'expiry_month'=>$row->expiry_month,
                    'expiry_date'=>$row->expiry_date,
                    'card_holder_name'=>encrypt_decrypt('decrypt',$row->card_holder_name),
                    'customer_id'=>$row->customer_id,
                    'is_default'=>$row->is_default,
                    'card_type '=>encrypt_decrypt('decrypt',$row->card_type),
                    'bank_name '=>'',

                );   

            }

        }

        $this->set_response(['status'=>true,'message'=>"",'data'=>$result], REST_Controller::HTTP_OK);

    }

    // For deleting card
    public function delete_card_post()
    {          
       $result_query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('id'=>$this->input->post('card_id')),'*');
       
       
       if ($result_query->num_rows()>0) {
           $row =  $result_query->row();  
                  
           try {               
                $customer = \Stripe\Customer::retrieve($row->customer_id);
                $cut = $customer->delete();                
                if ($cut->deleted==1) {
                    $this->Auth_model->delete_by_condition(TABLES::CARD_DETAIL,array('id'=>$this->input->post('card_id')));
                    $query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('user_id'=>$this->user_data->id),'*');
                    $result =array();
                    if ($query->num_rows()>0) {
                        foreach ($query->result() as  $row) {
                            $result[]= array(
                                'id'=>$row->id, 
                                'card_number'=>encrypt_decrypt('decrypt',substr_replace($row->card_number, str_repeat("X", 8), 4, 8)),
                                'expiry_month'=>encrypt_decrypt('decrypt',$row->expiry_month),
                                'expiry_date'=>encrypt_decrypt('decrypt',$row->expiry_date),
                                'card_holder_name'=>encrypt_decrypt('decrypt',$row->card_holder_name),
                                'customer_id'=>$row->customer_id,
                                'is_default'=>$row->is_default,
                                'card_type '=>encrypt_decrypt('decrypt',$row->card_type),
                                'bank_name '=>encrypt_decrypt('decrypt',$row->bank_name),
                            );
                        }
                    }
                    $this->set_response(['status'=>true,'message'=>"Deleted successfully",'data'=>$result], REST_Controller::HTTP_OK);
                } 
            }catch(Exception $e) { 
                $this->api_error = $e->getMessage();
                $this->set_response(['status'=>false,'message'=>$this->api_error], REST_Controller::HTTP_OK);                
            } 
       }else{
            $this->set_response(['status'=>false,'message'=>"Error occured, Please try after some time",], REST_Controller::HTTP_OK);
       }
    }

    // For add customer
    public function add_customer_post()
    {
        //print_r($this->user_data);die;
        /*$detail = \Stripe\Customer::retrieve(
          'cus_KGDb2t68JmTDfz',['email'=>'shivendra121@hotmail.com']    
        );
        echo '<pre>';
        print_r($detail);die();*/
        $is_query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('user_id'=>$this->user_data->id,'card_number'=>encrypt_decrypt('encrypt',$this->input->post('card_number'))),'*');
        //echo $this->db->last_query();
        if ($is_query->num_rows()>0) {
             $this->set_response(['status'=>false,'message'=>"Card is Saved already"], REST_Controller::HTTP_OK); 
        }else{
            try {
                $customer = \Stripe\Customer::create(array( 
                    'email'=>$this->user_data->email,
                    'source'  => $this->input->post('stripeToken') 
                    ));
                    ///print_r($_POST);die;$var = substr_replace($this->input->post('card_number'), str_repeat("X", 8), 4, 8)
                //print_r($customer);die;
                $arr = array(
                    'user_id'=>$this->user_data->id,
                    'card_number'=>encrypt_decrypt('encrypt',$this->input->post('card_number')),
                    'expiry_month'=>$this->input->post('expiry_month'),
                    'expiry_date'=>$this->input->post('expiry_date'),
                    'card_holder_name'=>encrypt_decrypt('encrypt',$this->input->post('card_holder_name')),
                    'default_source'=>$customer->default_source,
                    'is_default'=>2,
                    'customer_id'=>$customer->id,
                    'billing_address'=>$this->input->post('billing_address'),
                    //'card_type '=>encrypt_decrypt('encrypt',$customer->sources->data[0]['brand']),
                    'card_type '=>encrypt_decrypt('encrypt',$this->input->post('card_type')),
                    /*'bank_name '=>encrypt_decrypt('encrypt',$this->input->post('bank_name')),*/
                    'date'=>date('Y-m-d H:i:s'),
                    //print_r($customer->sources->data[0]['brand']);
                    //print_r($customer->sources->data[0]['funding']);
                );
                $id = $this->Auth_model->save(TABLES::CARD_DETAIL,$arr);
                if($id){
                    $query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('user_id'=>$this->user_data->id),'*');
                    $result =array();
                    if ($query->num_rows()>0) {
                        foreach ($query->result() as  $row) {
                            $result[]= array(
                                'id'=>$row->id,   
                                'card_number'=>encrypt_decrypt('decrypt',substr_replace($row->card_number, str_repeat("X", 8), 4, 8)),
                                'expiry_month'=>encrypt_decrypt('decrypt',$row->expiry_month),
                                'expiry_date'=>encrypt_decrypt('decrypt',$row->expiry_date),
                                'card_holder_name'=>encrypt_decrypt('decrypt',$row->card_holder_name),
                                'customer_id'=>$row->customer_id,
                                'is_default'=>$row->is_default,
                                'card_type '=>encrypt_decrypt('decrypt',$row->card_type),
                                'bank_name '=>encrypt_decrypt('decrypt',$row->bank_name),
                            ); 
                        }
                    }
                    $this->set_response(['status'=>true,'message'=>"Saved successfully",'data'=>$result], REST_Controller::HTTP_OK);
                    //$this->set_response(['status'=>true,'message'=>"Saved successfully"], REST_Controller::HTTP_OK);
                }else{
                    $this->set_response(['status'=>false,'message'=>'Error occured, Please try after some time'], REST_Controller::HTTP_OK); 
                } 
            }catch(\Stripe\Exception\CardException $e) {
                $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
                //echo 'Param is:' . $e->getError()->param . '\n';
                //$this->set_response(['status'=>fale,'message'=> $e->getError()->message],REST_Controller::HTTP_OK);
              } catch (\Stripe\Exception\RateLimitException $e) {
                $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
              } catch (\Stripe\Exception\InvalidRequestException $e) {
                $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
              } catch (\Stripe\Exception\AuthenticationException $e) {
                $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
              } catch (\Stripe\Exception\ApiConnectionException $e) {
                $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
              } catch (\Stripe\Exception\ApiErrorException $e) {
                $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
              } catch (Exception $e) {
                $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
              }
           
        }
    }
    
    // For oay tip amount
    public function pay_tip_amoount_post()
    {
       
        try{
            if (empty($this->input->post('card_id'))) {
                $payment = \Stripe\Charge::create ([
                    "amount" => 100 * $this->input->post('tip_amount'),
                    "currency" => "usd",
                    "source" => $this->input->post('stripeToken'),
                    "description" => "RideShareRates Tip Payment" 
                    ]);
            }else{
                $query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('id'=>$this->input->post('card_id')),'*');
                $row = $query->row();
                $payment = \Stripe\Charge::create ([
                    "amount" => 100 * $this->input->post('tip_amount'),
                    "currency" => "usd",
                    "customer" => $row->customer_id,
                    "description" => "RideShareRates Tip Payment" 
                ]);
            } 

            $affected= $this->Auth_model->update(TABLES::RIDE,array('ride_id'=>$this->input->post('ride_id')),array('tip_amount'=>$this->input->post('tip_amount')));
            $getdriverid = $this->Auth_model->getCustomFields(Tables::RIDE,array('ride_id'=>$this->input->post('ride_id')),'driver_id');
            $dr_id=$getdriverid->row();
            
              $drivergcm = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$dr_id->driver_id),'gcm_token');
              $val = $drivergcm->row(); 
              $load = array();
              $load['title']  = SITE_TITLE;
              $load['msg']    = 'You have received a Tip amount of'.' '.'$'.$this->input->post('tip_amount').'.';
              $load['action'] = 'Tip Amount Recived';                
              $token = $val->gcm_token;                
              $this->common->android_push($token, $load, FCM_KEY);
            $this->set_response(['status'=>true,'message'=>'Tip amount has been paid successfully']);
        } catch(\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            //echo 'Status is:' . $e->getHttpStatus() . '\n';
            //echo 'Type is:' . $e->getError()->type . '\n';
            //echo 'Code is:' . $e->getError()->code . '\n';
            // param is '' in this case
            //echo 'Param is:' . $e->getError()->param . '\n';
            $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
          } catch (\Stripe\Exception\RateLimitException $e){
            // Too many requests made to the API too quickly
            $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
          } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
          } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
          } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
          } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
          } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $this->set_response(['status'=>false,'message'=>$e->getError()->message], REST_Controller::HTTP_OK);
          }
    }
    
    // For payment
    public function payment_old_post()
    {
        $amount =0;
        $cancellation_charge = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'cancellation_charge');
        $ride_id = $this->input->post('ride_id');
        $ride_amount = $this->input->post('amount');
        $amount=$ride_amount;
        
        if($cancellation_charge->row()->cancellation_charge)
            $amount+=$cancellation_charge->row()->cancellation_charge;
          
        try {
          
              if (empty($this->input->post('card_id'))) {
                  $payment = \Stripe\Charge::create ([
                      "amount" => 100 * $amount,
                      "currency" => "usd",
                      "source" => $this->input->post('stripeToken'),
                      "description" => "RideShareRates Payment" 
                      ]);
              }else{
                  $query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('id'=>$this->input->post('card_id')),'*');
                  $row = $query->row();
                  $payment = \Stripe\Charge::create ([
                      "amount" => 100 * $amount,
                      "currency" => "usd",
                      "customer" => $row->customer_id,
                      "description" => "RideshareRates Payment" 
                  ]);
              } 
              $id = $this->Auth_model->save(TABLES::PAYMENT_HISTORY,array('ride_id'=>$ride_id,'amount'=>$ride_amount,'txn_id'=>$payment->balance_transaction,'date'=>date('Y-m-d H:i:s'),'cancellation_charge'=>$amount-$ride_amount));
			  

              if ($id) {
                  $affected= $this->Auth_model->update(TABLES::USER,array('user_id'=>$this->user_data->id),array('cancellation_charge'=>0));
				  
                  $affected= $this->Auth_model->update(TABLES::RIDE,array('ride_id'=>$ride_id),array('payment_status'=>'COMPLETED','payment_mode'=>'ONLINE'));
				  
                // $user_query=$this->Auth_model->getCustomFields(TABLES::USER,array('user_id'=>$this->user_data->id),'gcm_token');

                  $load = array();

                /* $load['title']  = SITE_TITLE;

                  $load['msg']    = 'Payment has been paid Successfully';

                  $load['action'] = 'FEEDBACK';                

                  $token =  $user_query->row()->gcm_token;                

                  $this->common->android_push($token, $load, FCM_KEY);*/



                  $user_query = $this->Auth_model->get_current_ride($ride_id);

                  $load = array();

                  $load['title']  = SITE_TITLE;

                  $load['msg']    = 'Payment has been paid Successfully';

                  $load['action'] = 'FEEDBACK';                

                  $token =  $user_query->row()->user_fcm;                

                  $this->common->android_push($token, $load, FCM_KEY);



                  $load['title']  = SITE_TITLE;

                  $load['msg']    = 'Payment has been received successfully.';

                  $load['action'] = 'FEEDBACK';                

                  $token =  $user_query->row()->driver_fcm;

                  $this->common->android_push($token, $load, FCM_KEY);

                if ($affected) {

                    $this->set_response(['status'=>true,'message'=>"Payment has been paid successfully"], REST_Controller::HTTP_OK);

                }else{

                      $this->set_response(['status'=>false,'message'=>"Error occured, Please try after some time"], REST_Controller::HTTP_OK);

                }                // code...

              }

                //return $customer; 

            }catch(Exception $e) { 

                $this->api_error = $e->getMessage(); 

               $this->set_response(['status'=>false,'message'=> $this->api_error], REST_Controller::HTTP_OK);

                //return false; 

            } 

    } 
	
	/*
	Add pre-authorized payment
	Developer: Ram
	*/
	public function add_payment_post() 
    {			
        $amount =0;
        
        $userid = $this->user_data->id;
        //$userid = 31;
        $hold_amount = $this->input->post('amount');
        $rideId = $this->input->post('ride_id');
        $amount=$hold_amount;
		
		
          
        try {
          
				if (empty($this->input->post('card_id'))) {
                	  
					return $this->set_response(['status'=>false,'message'=>"please add your card first",'userid'=>$userid,], REST_Controller::HTTP_OK);	  
				}else{
					//$get_txnid = $this->Auth_model->get_hold_payment(TABLES::HOLD_PAYMENT_HISTORY,array('user_id'=>$userid,'status'=>'1','amount >=',$amount),'*');
					$days= date('Y-m-d', strtotime(' - 6 days')); 
					$get_txnid = $this->Auth_model->get_hold_payment($amount,$userid,$days);
				    $get_txn_id = $get_txnid->row();
					
					if(!empty($get_txn_id)){						
						$now = time(); // or your date as well
						$your_date = strtotime($get_txn_id->created_date);
						$datediff = $now - $your_date;

						$days=round($datediff / (60 * 60 * 24));
					  //print_r($days); die;
						if( $days >6){
							$update_last_TXNID= $this->Auth_model->update(TABLES::HOLD_PAYMENT_HISTORY,array('txn_id'=>$get_txn_id->txn_id),array('status'=>'0'));
							
							$query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('id'=>$this->input->post('card_id')),'*');
							$row = $query->row();
							$payment = \Stripe\Charge::create ([
							  "amount" => 100 * $amount,
							  "currency" => "usd",
							  "customer" => $row->customer_id,
							  "description" => "RideshareRates Payment",
							  "capture" => false,					  
							]);
							
						}
						
						if($amount > $get_txn_id->amount){							
							$query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('id'=>$this->input->post('card_id')),'*');
							$row = $query->row();
							$payment = \Stripe\Charge::create ([
							  "amount" => 100 * $amount,
							  "currency" => "usd",
							  "customer" => $row->customer_id,
							  "description" => "RideshareRates Payment",
							  "capture" => false,					  
							]);
								  
						}else{
							
							//$this->Auth_model->update(TABLES::RIDE,array('ride_id'=>$rideId),array('hold_amount_status'=>"paid",'txn_id'=>$get_txn_id->txn_id));
							
							return $this->set_response(['status'=>true,'message'=>"Amount is available",'txn_id'=>$get_txn_id->txn_id,], REST_Controller::HTTP_OK);
						}
						
					}else{
						$query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('id'=>$this->input->post('card_id')),'*');
							$row = $query->row();
							$payment = \Stripe\Charge::create ([
							  "amount" => 100 * $amount,
							  "currency" => "usd",
							  "customer" => $row->customer_id,
							  "description" => "RideshareRates Payment",
							  "capture" => false,					  
							]);
					}				
				  
						//print_r($payment); die;
						$id = $this->Auth_model->save(TABLES::HOLD_PAYMENT_HISTORY,array('user_id'=>$userid,'amount'=>$amount,'txn_id'=>$payment->id,'created_date'=>date('Y-m-d H:i:s')));

						if($id){
							$affected= $this->Auth_model->update(TABLES::USER,array('user_id'=>$this->user_data->id),array('cancellation_charge'=>0));
							//$hold_txn_id=$this->Auth_model->getCustomFields(TABLES::HOLD_PAYMENT_HISTORY,array('txn_id'=>$payment->id),'gcm_token');
							
							 //$this->Auth_model->update(TABLES::RIDE,array('ride_id'=>$rideId),array('hold_amount_status'=>"paid",'txn_id'=>$payment->id));
							
							$user_query=$this->Auth_model->getCustomFields(TABLES::USER,array('user_id'=>$this->user_data->id),'gcm_token');
							$load = array();

							$load['title']  = SITE_TITLE;							
							$load['msg']    = 'The pre-authorized amount of $'.$amount.' has been added successfully.';
							$load['action'] = 'FEEDBACK';
							$token =  $user_query->row()->gcm_token;               
							$this->common->android_push($token, $load, FCM_KEY);

							if ($affected){
								/* $load['title']  = SITE_TITLE;
								$load['msg']    = 'The rider has confirmed the ride; proceed to pick up the rider.';
								$load['action'] = 'HOLDAMOUNT';
								//$load['ride_id'] = $ride_id;
								//$load['driver_id'] = $qry->row()->driver_id;
								$token = $driver_data->row()->gcm_token; 
								$this->common->android_push($token, $load, FCM_KEY); */
								
								$this->set_response(['status'=>true,'message'=>"Payment has been captured successfully","txn_id"=>$payment->id], REST_Controller::HTTP_OK);
								
								
							}else{					
								$this->set_response(['status'=>false,'message'=>"Error occured, Please try after some time"], REST_Controller::HTTP_OK);

							}  

						}
					
				  
				  
				  
				}
			  
			}catch(Exception $e) { 
			
				$err_msg = "Oops Boss! ".$e->getMessage(). "on this Credit/Debit Card. Try your other card.";

                $this->api_error = $err_msg; 

               $this->set_response(['status'=>false,'message'=>$this->api_error], REST_Controller::HTTP_OK);

                //return false; 
            } 

    }
    // For payment
    public function payment_post()
    {
        $amount =0;
        $cancellation_charge = $this->Auth_model->getCustomFields(Tables::USER,array('user_id'=>$this->user_data->id),'cancellation_charge');
        $ride_id = $this->input->post('ride_id');
        $ride_amount = $this->input->post('amount');
        $txn_id = $this->input->post('txn_id');        
        $amount =$ride_amount;
        
        if($cancellation_charge->row()->cancellation_charge)
            $amount+=$cancellation_charge->row()->cancellation_charge;
          
        try {
          
              if (empty($this->input->post('card_id'))) {
                  $payment = \Stripe\Charge::create ([
                      "amount" => 100 * $amount,
                      "currency" => "usd",
                      "source" => $this->input->post('stripeToken'),
                      "description" => "RideShareRates Payment" 
                      ]);
              }else{ 
					$query = $this->Auth_model->getCustomFields(TABLES::CARD_DETAIL,array('id'=>$this->input->post('card_id')),'*');
					$row = $query->row();
					$payment = new \Stripe\StripeClient(STRIPE_SECRET);
				
					$payment->charges->capture($txn_id,[
					 
						"amount" => 100 * $amount
					 
					]);
				  } 
			 // print_r($payment); die;
              $id = $this->Auth_model->save(TABLES::PAYMENT_HISTORY,array('ride_id'=>$ride_id,'amount'=>$ride_amount,'txn_id'=>$txn_id,'date'=>date('Y-m-d H:i:s'),'cancellation_charge'=>$amount-$ride_amount));
              if ($id){
                  $affected= $this->Auth_model->update(TABLES::USER,array('user_id'=>$this->user_data->id),array('cancellation_charge'=>0));

                  $affected= $this->Auth_model->update(TABLES::RIDE,array('ride_id'=>$ride_id),array('payment_status'=>'COMPLETED','payment_mode'=>'ONLINE'));
				  $queryamt = $this->Auth_model->getCustomFields(TABLES::HOLD_PAYMENT_HISTORY,array('txn_id'=>$txn_id),'*');
				  $rowamt = $queryamt->row();
				  $rest_amt= $rowamt->amount-$amount;
                  $affected= $this->Auth_model->update(TABLES::HOLD_PAYMENT_HISTORY,array('txn_id'=>$txn_id),array('status'=>'0','charge_amount'=>$amount,'rest_amount'=>$rest_amt));
				  

                  $user_query = $this->Auth_model->get_current_ride($ride_id);

                  $load = array();

                  $load['title']  = SITE_TITLE;

                  $load['msg']    = 'Payment has been paid Successfully';

                  $load['action'] = 'FEEDBACK';                

                  $token =  $user_query->row()->user_fcm;                

                  $this->common->android_push($token, $load, FCM_KEY);



                  $load['title']  = SITE_TITLE;

                  $load['msg']    = 'Payment has been received successfully.';

                  $load['action'] = 'FEEDBACK';                

                  $token =  $user_query->row()->driver_fcm;

                  $this->common->android_push($token, $load, FCM_KEY);

                if ($affected) {

                    $this->set_response(['status'=>true,'message'=>"Payment has been paid successfully"], REST_Controller::HTTP_OK);

                }else{

                      $this->set_response(['status'=>false,'message'=>"Error occured, Please try after some time"], REST_Controller::HTTP_OK);

                } 

              }

                //return $customer; 

            }catch(Exception $e) { 

                $this->api_error = $e->getMessage(); 

               $this->set_response(['status'=>false,'message'=> $this->api_error], REST_Controller::HTTP_OK);

                //return false; 

            } 

    }
	
	
    // For add account
    public function add_account_post()

    {

        /*$card_token = \Stripe\Token::create([

          'card' => [

            'number' => '4242424242424242',

            'exp_month' => 10,

            'exp_year' => 2022,

            'cvc' => '314',

          ],

        ]);

        $payment = \Stripe\Charge::create ([

                    "amount" => 20*100,

                    "currency" => "inr",

                    "source" => $card_token->id,

                    "description" => "OCORY Payment" 

                    ]);

        print_r( $payment);die;*/

        /*$account = \Stripe\Account::create([

          'country' => 'US',

          'type' => 'custom',

          'capabilities' => [

            'card_payments' => [

              'requested' => true,

            ],

            'transfers' => [

              'requested' => true,

            ],

          ],

        ]);

        print_r($account);die;*/

       /*$token_detail = \Stripe\Token::create([

          'bank_account' => [

            'country' => 'US',

            'currency' => 'usd',

            'account_holder_name' => 'Jenny Rosen',

            'account_holder_type' => 'individual',

            'routing_number' => '110000000',

            'account_number' => '000123456789',

          ],

        ]); */

        

       /* $external_account = \Stripe\Account::createExternalAccount(

              'acct_1JglzYKftTksgWvW',//acct_1JfQPASIMdyczcfq

              [

                'external_account' => $token_detail->id,

              ]

            );*/

        /*\stripe\Transfer::create([

          'amount' => 400,

          'currency' => 'usd',

          'destination' => 'acct_1JfhzgFiV2SPTasu',

          'transfer_group' => 'ORDER_95',

        ]);

        print_r($external_account);//die();*/

       /* $payout=\Stripe\Payout::create(array(

          "amount" => 400,

          "currency" => "usd",

          "destination"=>$external_account->id,/// ID of customer bank account ba_1CIZEOCHXaXPEwZByNehIJrY 

          "source_type"=>'bank_account'

        ));*/

       // print_r($payout);die;

        /*$account = \Stripe\Account::create([

          'country' => 'US',

          'type' => 'express',

        ]);

        print_r($account);die;*/

        /* $account_detail=\Stripe\Account::create([

              'type' => 'custom',

              'country' => 'US',

              'email' => 'shivendrtiwari.567@gmail.com',

              'capabilities' => [

                'card_payments' => ['requested' => true],

                'transfers' => ['requested' => true],

              ],

            ]);

        print_r($account_detail);

        die();*/

        $this->form_validation->set_rules('account_holder_name','Account Holder Name','required');

        $this->form_validation->set_rules('bank_name','Bank Name','required');

        $this->form_validation->set_rules('routing_number','Routing Number','required');

       // $this->form_validation->set_rules('account_number','Account Number','required');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run()==false) {            

            $error = array(

                'account_holder_name'=>form_error('account_holder_name'),

                'bank_name'=>form_error('bank_name'),

                'routing_number'=>form_error('routing_number'),

                //'account_number'=>form_error('account_number'),                

            );

            

            $this->set_response(['status'=>false,'message'=>$error,'error'=>validation_errors()]);

        }else{
			$query = $this->Auth_model->getCustomFields(Tables::DRIVER_ACCOUNT_DETAIL,array('user_id'=>$this->user_data->id),'*');
			
			if($query->num_rows()>0){
				
					$account_holder_name = encrypt_decrypt('encrypt',$this->input->post('account_holder_name'));				

					$account_arr = array(
						'user_id'=>$this->user_data->id,
						'account_holder_name'=>$this->input->post('account_holder_name'),

						'bank_name'=>$this->input->post('bank_name'),

						'routing_number'=>$this->input->post('routing_number'),

						'account_number'=>$this->input->post('account_number'),

						'status'=>1, 

					);               
					//$this->Auth_model->save(TABLES::DRIVER_ACCOUNT_DETAIL,$arr);
					$updateid = $this->Auth_model->update(Tables::DRIVER_ACCOUNT_DETAIL,array('user_id'=>$this->user_data->id),array('account_holder_name'=>$account_holder_name));
				
				 if ($updateid) {

					   $this->set_response(['status'=>true,'message'=>'Account has been Updated successfully','data'=>$account_arr]);

					}else{

						$this->set_response(['status'=>true,'message'=>'Error occured, Please try after some time']);

					}
				
			}else{
				
				

				$arr = array(
					'user_id'=>$this->user_data->id,
					'account_holder_name'=>encrypt_decrypt('encrypt',$this->input->post('account_holder_name')),

					'bank_name'=>encrypt_decrypt('encrypt',$this->input->post('bank_name')),

					'routing_number'=>encrypt_decrypt('encrypt',$this->input->post('routing_number')),

					'account_number'=>encrypt_decrypt('encrypt',$this->input->post('account_number')),

					'status'=>1,

					'date'=>date('Y-m-d H:i:s')

				);

				$account_arr = array(

					'account_holder_name'=>$this->input->post('account_holder_name'),

					'bank_name'=>$this->input->post('bank_name'),

					'routing_number'=>$this->input->post('routing_number'),

					'account_number'=>$this->input->post('account_number'),

					'status'=>1, 

				);               

				$id = $this->Auth_model->save(TABLES::DRIVER_ACCOUNT_DETAIL,$arr);
				 if ($id) {

				   $this->set_response(['status'=>true,'message'=>'Account detail has been updated successfully','data'=>$account_arr]);

				}else{

					$this->set_response(['status'=>true,'message'=>'Error occured, Please try after some time']);

				}
				
			}

           

        }

    }



    
    // For handling payment
    public function handlePayment()

    {

        

       //print_r($this->input->post('stripeToken'));die;

        

        /*\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

         $detail = \Stripe\Customer::All(['limit'=>100]);

        echo '<pre>';

        print_r($detail);die();



        $detail = \Stripe\Customer::retrieve(

          'cus_KFCVfFiFspVmv7',[]          

        );

        echo '<pre>';

        print_r($detail);die();*/

        try { 

            // Add customer to stripe 

            print_r($_POST);die;

            $customer = \Stripe\Customer::create(array( 

                'email' => 'shivendra121@hotmail.com', 

                'source'  => $this->input->post('stripeToken') 

            )); 

            echo '<pre>';

            print_r($customer);die;

            return $customer; 

        }catch(Exception $e) { 

            $this->api_error = $e->getMessage(); 

            return false; 

        } 

     

        $payment = \Stripe\Charge::create ([

                "amount" => 100 * 120,

                "currency" => "inr",

                "source" => $this->input->post('stripeToken'),

                "description" => "Dummy stripe payment." 

        ]);

        print_r($payment);die;

            

        $this->session->set_flashdata('success', 'Payment has been successful.');

             

        redirect('api/StripePayment', 'refresh');

    }

}