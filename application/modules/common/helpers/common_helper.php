<?php 


defined('BASEPATH') or exist('no direct script access allowed');








if ( ! function_exists('create_slug')){





    function create_slug($string,$table,$field='slug',$key=NULL,$value=NULL)


    {


        $t =& get_instance();


        $slug = url_title($string);


        $slug = strtolower($slug);


        $i = 0;


        $params = array ();


        $params[$field] = $slug;


     


        if($key)$params["$key !="] = $value; 


     


        while ($t->db->where($params)->get($table)->num_rows())


        {   


            if (!preg_match ('/-{1}[0-9]+$/', $slug ))


                $slug .= '-' . ++$i;


            else


                $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );


             


            $params [$field] = $slug;


        }   


        return $slug;   


    }


}











if(! function_exists('encrypt_decrypt')){


    


   function encrypt_decrypt($action, $string) {


        $output = false;


        $encrypt_method = "AES-256-CBC";


        $secret_key = 'This is my secret key';


        $secret_iv = 'This is my secret iv';


        // hash


        $key = hash('sha256', $secret_key);


        


        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning


        $iv = substr(hash('sha256', $secret_iv), 0, 16);


        if ( $action == 'encrypt' ) {


            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);


            $output = base64_encode($output);


        } else if( $action == 'decrypt' ) {


            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);


        }


        return $output;


    }





}





if (!function_exists('get_table_record')) {


    function get_table_record($table,$condition,$field)


    {


        $t =& get_instance();


        $t->db->select($field);


        $t->db->from($table);


        $t->db->where($condition);


        return $t->db->get();


    }


}


if (!function_exists('get_payout_status')) {
    function get_payout_status($driver_id,$paid_amount,$genrated_payout_date){
        $t =& get_instance();
		$t->db->select('*');
		$t->db->from('payout_status');
		$t->db->where('driver_id',$driver_id);
        $t->db->where('paid_amount',$paid_amount);
        $t->db->where('genrated_payout_date',$genrated_payout_date);    
		$query=$t->db->get();
		return $query->row();
	}
}


if (!function_exists('get_payout_amount')) {


    function get_payout_amount()
    {
        $t =& get_instance();
        $t->db->select('*');
        $t->db->from('rate_chart'); 
        $t->db->where(array('id'=>1));   
        return $t->db->get()->row();

    }


}

if (!function_exists('get_payout_list')) {
    function get_payout_list($driver_id,$week,$year){
        $t =& get_instance(); 
        $t->db->select('*,u.name as driver_name,u.email as driver_email,u.mobile as driver_mobile ,ph.date as ride_date,ph.txn_id,w.mobile as user_mobile,w.avatar as user_avatar,w.name as user_name'); //,ps.txn_id as transection_id,ps.genrated_payout_date as payout_date 
        $t->db->from('rides');
        $t->db->join(Tables::PAYMENT_HISTORY.' ph','ph.ride_id=rides.ride_id','inner');
        //$t->db->join(Tables::PAYOUTSTATUS.'ps','ps.ride_id=rides.ride_id','right');
        $t->db->join(Tables::USER.' u','u.user_id=rides.driver_id','left');
        $t->db->join(Tables::USER.' w','rides.user_id=w.user_id', 'left');
        $t->db->where(array('driver_id'=>$driver_id,'week(time)'=>$week,'year(time)'=>$year,));
        $t->db->where('rides.payment_status','COMPLETED');
        $t->db->where('rides.status','COMPLETED');
        $t->db->order_by('rides.ride_id','desc');
        $t->db->group_by('rides.ride_id');
        return $t->db->get()->result();
    }
}

if (!function_exists('get_retings')) {
    function get_retings($driver_id){
        $t =& get_instance();         
		$t->db->select_avg('rating');
       $t->db->from(Tables::FEEDBACK);    
       $t->db->where('driver_id',$driver_id);
       //echo $t->db->last_query();
       return $t->db->get()->result();
       
    }
}
if (!function_exists('get_Rider_retings')) {
    function get_Rider_retings($rider_id){
        $t =& get_instance();         
		$t->db->select_avg('rating');
       $t->db->from(Tables::RIDER_FEEDBACK);    
       $t->db->where('rider_id',$rider_id);
       //echo $t->db->last_query();
       return $t->db->get()->result();
       
    }
}
if (! function_exists('phoneusformat')) {
    function phoneusformat($phone) {
        $cleanStrcontact = preg_replace('/[^A-Za-z0-9]/', '',$phone); 
        $ac = substr($cleanStrcontact, 0, 3);
        $prefix = substr($cleanStrcontact, 3, 3);
        $suffix = substr($cleanStrcontact, 6);

        return "({$ac}) {$prefix}-{$suffix}";
    }
}