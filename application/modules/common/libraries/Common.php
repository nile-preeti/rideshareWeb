<?php

/**
 * Format class
 *
 * Help convert between various formats such as XML, JSON, CSV, etc.
 *
 * @author  	Phil Sturgeon
 * @license		http://philsturgeon.co.uk/code/dbad-license
 */
class Common {

    public function android_push1($token, $load, $key) {

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => $token,
            'data' => $load
        );
        $headers = array(
            'Authorization: key=' . $key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields, true));
        $result = curl_exec($ch);
        //echo $result; die;
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }

	/*###########################
		Push notification for driver and rider function
	#######################*/
	
    function android_push($token, $load, $key) {
           
        $msg = array(
           
            'body'  => $load['msg'],
            'title' => SITE_TITLE,
            'icon'  => 'myicon',//Default Icon
            'sound' => ($load['action']=='PENDING')?'example.caf':'default',

            );

        
        $api_key = 'AAAAaWt0uw0:APA91bH9u_6FPW6oRQZMCn0evZ6DZYO5vcojD1Pg3vkzF8YLtPhIMYQIAqElIAK4V9CdvIbbCtaneBjLHSwuWQe-B7-27mEowUuOHYNBNgKNjYz-pWqOYdYSykcpgMIgtv2m0cKLGUnL';
        $test_fcm = 'f7VZEI1iRw4:APA91bFEczBGB67c8FaXXjm9nfYGxfMDDJr2AcXWVJqxPxe2s4uyDD9tYLdFSKwtGIXUv9tI-X-4gRQ0EiaV6c9f_EvNyGUXlepyLehaE6pC-9mq9T6xqHSWPhJEnep6pTHDAL3fKq5J';         
                             
                $fields = array('to'=>$token,'notification'=>$msg,'data'=>$load,"priority"=> "high");
                $headers = array
                    (
                    'Authorization: key='. FCM_KEY,              
                     'Content-Type: application/json'
                    );

            #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec ($ch);               
                curl_close ( $ch ); 
               
    }

    public function Generate_hash($length) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' . rand(0, 99999);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
   

}



?>