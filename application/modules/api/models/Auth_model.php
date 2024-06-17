<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Auth_model extends MY_Model{
    public function __construct(){
        parent::__construct();
    }

    public function find_nearest_user($lat,$long) {
        // $sql = "
        //     SELECT user_id, name, latitude, longitude,
            // (6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance
            // FROM users
            // HAVING distance < 50
            // ORDER BY distance
            // LIMIT 1
        // ";

        $sql = "SELECT * , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - `latitude`) *  pi()/180 / 2), 2) + COS( $lat * pi()/180) * COS(`longitude` * pi()/180) * POWER(SIN(($long - `longitude`) * pi()/180 / 2), 2) ))) as distance  from users  having  distance <= 10 order by distance";

        $query = $this->db->query($sql, array($lat, $long, $lat));
        echo $this->db->last_query();
        return $query->row_array();
    }

    public function get_nearby_driver($dlat,$dlong){ 
        empty($_GET['limit']) ? $limit = 500 : $limit = $_GET['limit'];
    	$this->db->select("u.user_id,u.name,u.email,(((acos(sin((" . $_GET['lat'] . "*pi()/180)) *

        sin(($dlat*pi()/180))+cos((" . $_GET['lat'] . "*pi()/180)) *

        cos(($dlat*pi()/180)) * cos(((" . $_GET['long'] . "-

        $dlong)*pi()/180))))*180/pi())*60*1.1515*1.609344) 

        as distance");
        $this->db->from(Tables::USER.' u');
        //$this->db->join(Tables::VEHICLE_DETAIL.' vd','vd.user_id=u.user_id','left');
        //$this->db->join(Tables::BRAND.' b','vd.model_id=b.id','left');
        //$this->db->from(Tables::USER);
        $this->db->where(array('utype'=>2,'is_online'=>1));
        $this->db->having("distance <". $limit);
        $this->db->order_by("distance asc");
        $query =$this->db->get();
		//echo $this->db->last_query();
        return $query;
    }
	
	public function	getOnlineDriver(){        
        $this->db->from(Tables::USER);        
        $this->db->where(array('utype'=>2,'is_online'=>1));      
        $query =$this->db->get();
		//echo $this->db->last_query();
        return $query;    
	}

    public function getDriverFromUser($lat,$long,$distance,$vehicle_type_id){
        $this->db->select('IFNULL(CONCAT("'.base_url('uploads/profile_image/').'",u.user_id,"/",u.avatar)," ") as profile_pic,IFNULL(CONCAT("'.base_url('uploads/car_pic/').'",u.user_id,"/",vd.car_pic)," ") as car_pic,u.user_id,u.name,u.last_name as rider_last_name,u.email,vd.vehicle_no,u.latitude,u.longitude,(((acos(sin((' . $lat . '*pi()/180)) *sin((`destination_lat`*pi()/180))+cos((' . $lat . '*pi()/180)) *
        cos((`destination_lat`*pi()/180)) * cos(((' .$long . '-`destination_long`)*pi()/180))))*180/pi())*60*1.1515*1.609344) 
        as distance,u.mobile,u.user_id as driver_id, u.last_name as driver_lastname,(select COUNT(driver_id) from '.Tables::RIDE.' where driver_id=u.user_id and status="COMPLETED" group by driver_id limit 1) as total_driver_ride,(select SUM(rating) from '.Tables::FEEDBACK.' where driver_id=u.user_id group by driver_id limit 1) as total_rating,u.destination_lat,u.destination_long,1 as is_destination_ride');
        $this->db->from(Tables::USER.' u');
        $this->db->join(Tables::VEHICLE_DETAIL.' vd','vd.user_id=u.user_id and vd.status=1','inner');
        $this->db->join(Tables::VEHICLE_SERVICE.' vs','vs.vehicle_id=vd.id and vs.status=1 and vs.vehicle_type_id='.$vehicle_type_id,'inner');
        //$this->db->join(Tables::FEEDBACK.' f','f.driver_id =u.user_id','left');
        //$this->db->where(array('u.utype'=>2,'u.is_online'=>1,'vd.status'=>1,'vehicle_type_id'=>$vehicle_type_id));
        $this->db->where(array('u.utype'=>2,'u.is_online'=>1,));
        $this->db->where('(YEAR(now())-vd.year)<99 AND vd.license_expiry_date>=DATE(NOW()) AND vd.car_expiry_date>=DATE(NOW()) AND vd.insurance_expiry_date>=DATE(NOW())',null,false);
        //$this->db->where(array('u.utype'=>2,'u.is_online'=>1));
        //$this->db->having("distance <='". $distance."' OR distance<='".($distance-20)."'");
        $this->db->having("distance <=3000");
        $this->db->order_by("distance asc");
        $this->db->limit(1);
        $query =$this->db->get();
        if ( $query->num_rows()==0){  
            $this->db->select('IFNULL(CONCAT("'.base_url('uploads/profile_image/').'",u.user_id,"/",u.avatar)," ") as profile_pic,IFNULL(CONCAT("'.base_url('uploads/car_pic/').'",u.user_id,"/",vd.car_pic)," ") as car_pic,u.user_id,u.name,u.last_name as rider_last_name,u.email,vd.vehicle_no,u.latitude,u.longitude,(((acos(sin((' . $lat . '*pi()/180)) *sin((`latitude`*pi()/180))+cos((' . $lat . '*pi()/180)) *cos((`latitude`*pi()/180)) * cos(((' .$long . '-`longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) 
            as distance,u.mobile,u.user_id as driver_id,u.last_name as driver_lastname,(select COUNT(driver_id) from '.Tables::RIDE.' where driver_id=u.user_id and status="COMPLETED" group by driver_id limit 1) as total_driver_ride,(select SUM(rating) from '.Tables::FEEDBACK.' where driver_id=u.user_id group by driver_id limit 1) as total_rating,2 as is_destination_ride');
            $this->db->from(Tables::USER.' u');
            $this->db->join(Tables::VEHICLE_DETAIL.' vd','vd.user_id=u.user_id and vd.status=1','inner');
            $this->db->join(Tables::VEHICLE_SERVICE.' vs','vs.vehicle_id=vd.id and vs.status=1 and vs.vehicle_type_id='.$vehicle_type_id,'inner');
            //$this->db->join(Tables::FEEDBACK.' f','f.driver_id =u.user_id','left');
            $this->db->where(array('u.utype'=>2,'u.is_online'=>1));
            $this->db->where('(YEAR(now())-vd.year)<99 AND vd.license_expiry_date>=DATE(NOW()) AND vd.car_expiry_date>=DATE(NOW()) AND vd.insurance_expiry_date>=DATE(NOW())',null,false);
            //$this->db->where(array('u.utype'=>2,'u.is_online'=>1));
            //$this->db->having("distance <='". $distance."'");
            $this->db->having("distance <=300");
            $this->db->order_by("distance asc");
            $this->db->limit(1);
            $query =$this->db->get();
        }
        //echo $this->db->last_query();
        return $query;
    }

    public function get_next_driver($lat,$long,$distance,$ride_id,$vehicle_type_id)
    {
        $this->db->select('IFNULL(CONCAT("'.base_url('uploads/profile_image/').'",u.user_id,"/",u.avatar)," ") as profile_pic,IFNULL(CONCAT("'.base_url('uploads/car_pic/').'",u.user_id,"/",vd.car_pic)," ") as car_pic,u.user_id,u.name,u.email,vd.vehicle_no,u.latitude,u.longitude,(((acos(sin((' . $lat . '*pi()/180)) *
        sin((`latitude`*pi()/180))+cos((' . $lat . '*pi()/180)) *
        cos((`latitude`*pi()/180)) * cos(((' .$long . '-
        `longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) 
        as distance,u.mobile,u.user_id as driver_id,(select COUNT(driver_id) from '.Tables::RIDE.' where driver_id=u.user_id and status="COMPLETED" group by driver_id limit 1) as total_driver_ride,(select SUM(rating) from '.Tables::FEEDBACK.' where driver_id=u.user_id group by driver_id limit 1) as total_rating,');
        $this->db->from(Tables::USER.' u');      
        $this->db->join(Tables::VEHICLE_DETAIL.' vd','vd.user_id=u.user_id and vd.status=1','inner');
        $this->db->join(Tables::VEHICLE_SUBCATEGORY_TYPE.' vs','vs.id=vd.model_id and vs.status=1 and vs.id='.$vehicle_type_id,'inner');
        //$this->db->join(Tables::FEEDBACK.' f','f.driver_id =u.user_id','left');
        $where = 'u.utype=2 AND u.is_online=1 AND (YEAR(now())-vd.year)<99 AND vd.license_expiry_date>=DATE(NOW()) AND vd.car_expiry_date>=DATE(NOW()) AND vd.insurance_expiry_date>=DATE(NOW())AND u.user_id NOT IN (select driver_id from '.Tables::CANCELLED_RIDE.' where ride_id='.$ride_id.')';       

        //$where = 'u.utype=2 AND u.is_online=1 AND u.user_id NOT IN (select driver_id from '.Tables::CANCELLED_RIDE.' where ride_id='.$ride_id.')';    
        $this->db->where($where,null,false);
        $this->db->having("distance <=3000");
        $this->db->order_by("distance asc");
        $this->db->limit(1);
        $query =$this->db->get();
        //echo $this->db->last_query();die;
        return $query;

    }







    /* get rides */

    public function get_total_earning($user_data)

    {

        $id = $user_data->id;

        $status = $this->input->get('status'); 

        $filter_data = $this->input->get(); 

        $wh = ($user_data->utype == 1) ? "r.user_id=$id" : "r.driver_id=$id"; 

        $wh.= ' AND r.driver_id NOT IN (select driver_id from '.Tables::CANCELLED_RIDE.' where ride_id=r.ride_id AND driver_id='.$user_data->id.')';

        $this->db->select('sum(r.amount) as earning_amount,sum(r.waiting_charge_onpickup) as waiting_pickup_charge,sum(r.waiting_charge_ondrop) as waiting_drop_charge,r.is_technical_issue');

        $this->db->from(Tables::RIDE.' r');

        $this->db->join(Tables::USER.' w','r.user_id=w.user_id', 'left');

        $this->db->join(Tables::USER.' w1','r.driver_id=w1.user_id', 'left');

        //$this->db->join(Tables::VEHICLETYPE.' vt','vt.id=w1.vehicle_type', 'left');

        $this->db->where($wh);

        if ($status=='ACCEPTED' || $status=='START_RIDE') { 

            $this->db->where("(r.status='ACCEPTED' or r.status='START_RIDE')");

        }else{

            if ($status=='PENDING') { //Changes on 20-12-2021

                $condition = "(r.status='NOT_CONFIRMED' or r.status='".$status."')";

               $this->db->where($condition,null,false);

            }else{

                $this->db->where(array('r.status'=>$status));

            }

        }

        if ($filter_data){

            if(isset($filter_data['from']) && isset($filter_data['to'])){

                if(!empty($filter_data['from']) && !empty($filter_data['to'])){

                    $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime($filter_data['from']))."'",NULL,FALSE);

                    $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') <= '".date(PHP_DATE_FORMAT,strtotime($filter_data['to']))."'",NULL,FALSE);

                }

            }

        }

            /* else if($date=='yesterday')

                $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(date('Y-m-d',strtotime('-1 day'))))."'",NULL,FALSE);

            else if($date=='week')

                $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(date('Y-m-d',strtotime('-7 day'))))."'",NULL,FALSE);

            else if($date=='month')

                $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(date('Y-m-d',strtotime('-1 month'))))."'",NULL,FALSE); */

        $this->db->order_by('r.ride_id desc');

        //if (!empty($limit)) {



           // $this->db->limit($start,$limit);



        //}

        $res = $this->db->get();

        //echo $this->db->last_query();

        return $res;

    }

    public function getRide($user_data,$limit,$start){

        $id = $user_data->id;

        $status = $this->input->get('status'); 

        $filter_data = $this->input->get(); 

        $wh = ($user_data->utype == 1) ? "r.user_id=$id" : "r.driver_id=$id"; 

        $wh.= ' AND r.driver_id NOT IN (select driver_id from '.Tables::CANCELLED_RIDE.' where ride_id=r.ride_id AND driver_id='.$user_data->id.')';

        $this->db->select('r.*,w.mobile as user_mobile,w.avatar as user_avatar,w1.avatar as driver_avatar,w.name as user_name,w.name_title as user_titlename,w.last_name as user_lastname,w1.mobile as driver_mobile,w1.user_id as driver_id,w1.name as driver_name,w1.name_title as driver_title_name,w1.last_name as driver_lastname,DAYNAME(r.time) as dayname');

        $this->db->from(Tables::RIDE.' r');

        $this->db->join(Tables::USER.' w','r.user_id=w.user_id', 'left');

        $this->db->join(Tables::USER.' w1','r.driver_id=w1.user_id', 'left');

        //$this->db->join(Tables::VEHICLETYPE.' vt','vt.id=w1.vehicle_type', 'left');

        $this->db->where($wh);
        $this->db->where("r.status!='FAILED'");
        //$this->db->where("r.is_technical_issue ='YES'");

        if ($status=='ACCEPTED' || $status=='START_RIDE') { 

            $this->db->where("(r.status='ACCEPTED' or r.status='START_RIDE')");

        }else{

            if ($status=='PENDING') { //Changes on 20-12-2021

                $condition = "(r.status='NOT_CONFIRMED' or r.status='".$status."')";

               $this->db->where($condition,null,false);

            }else{

                $this->db->where(array('r.status'=>$status));

            }

        }

        if ($filter_data){

            if(isset($filter_data['from']) && isset($filter_data['to'])){

                if(!empty($filter_data['from']) && !empty($filter_data['to'])){

                    $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime($filter_data['from']))."'",NULL,FALSE);

                    $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') <= '".date(PHP_DATE_FORMAT,strtotime($filter_data['to']))."'",NULL,FALSE);

                }

            }

        }

            /* else if($date=='yesterday')

                $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(date('Y-m-d',strtotime('-1 day'))))."'",NULL,FALSE);

            else if($date=='week')

                $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(date('Y-m-d',strtotime('-7 day'))))."'",NULL,FALSE);

            else if($date=='month')

                $this->db->where("DATE_FORMAT(r.time,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(date('Y-m-d',strtotime('-1 month'))))."'",NULL,FALSE); */

        $this->db->order_by('r.ride_id desc');

        //if (!empty($limit)) {



            $this->db->limit($start,$limit);



        //}

        $res = $this->db->get();

       // echo $this->db->last_query();

        return $res;



    }







    /* get rejected rides */



    public function getRejectedRide($user_data,$limit,$start)

    {       

        $filter_data = $this->input->get(); 

        $id = $user_data->id;



        $status = $this->input->get('status');        



        //$wh = ($user_data->utype == 1) ? "r.user_id=$id" : "r.driver_id=$id";        



        $wh= 'r.driver_id IN (select driver_id from '.Tables::CANCELLED_RIDE.' where ride_id=r.ride_id AND driver_id='.$id.') OR (r.driver_id='.$id.' and r.status="CANCELLED")'; 

        if ($filter_data){

            if(isset($filter_data['from']) && isset($filter_data['to'])){

                if(!empty($filter_data['from']) && !empty($filter_data['to'])){

                    $wh= 'r.driver_id IN (select driver_id from '.Tables::CANCELLED_RIDE.' where ride_id=r.ride_id AND driver_id='.$id.') OR (r.driver_id='.$id.' and r.status="CANCELLED") AND DATE_FORMAT(r.time,'.SQL_DATE_FORMAT.') >= '.date(PHP_DATE_FORMAT,strtotime($filter_data['from'])).' AND DATE_FORMAT(r.time,'.SQL_DATE_FORMAT.') <= '.date(PHP_DATE_FORMAT,strtotime($filter_data['to'])); 

                    

                }

            }

        }

        ///echo $wh;       



        $this->db->select('r.*,w.mobile as user_mobile,w.avatar as user_avatar,w.name_title as user_titlename,w.last_name as user_lastname,w1.avatar as driver_avatar,w.name as user_name,w1.mobile as driver_mobile,w1.user_id as driver_id,w1.name as driver_name,w1.name_title as driver_title_name,w1.last_name as driver_lastname,DAYNAME(r.time) as dayname');



        $this->db->from(Tables::RIDE.' r');



        $this->db->join(Tables::USER.' w','r.user_id=w.user_id', 'left');



        $this->db->join(Tables::USER.' w1','r.driver_id=w1.user_id', 'left');



        //$this->db->join(Tables::VEHICLETYPE.' vt','vt.id=w1.vehicle_type', 'left');



        $this->db->where($wh);



        /*if ($status=='ACCEPTED' || $status=='START_RIDE') {  



            $this->db->where("(r.status='ACCEPTED' or r.status='START_RIDE')");



        }else{



            $this->db->where(array('r.status'=>$status));



        }*/

        

        $this->db->order_by('r.ride_id desc');



        //$this->db->limit(20);

        if (!empty($start)) {



            $this->db->limit($start,$limit);



        }

        $res = $this->db->get();



        //echo $this->db->last_query();



        return $res;



    }







    /* get profile */



    public function get_profile_detail($user_data)
    {
       $this->db->select('u.user_id,u.name_title,u.last_name,u.name,u.email,u.identification_document_id,id.document_name as identification_document_name,u.identification_issue_date,u.identification_expiry_date,u.verification_id,u.country_code,u.mobile,u.country,u.state,u.city,IFNULL(CONCAT("'.base_url('uploads/profile_image/'.$user_data->id.'/').'",u.avatar)," ") as profile_pic,IFNULL(CONCAT("'.base_url('uploads/verification_document/'.$user_data->id.'/').'",u.verification_id)," ") as verification_id,u.avatar as profile_image,IFNULL(ROUND(avg(f.rating),1),0) as total_rating, IFNULL(ROUND(avg(rf.rating),1),0) as rider_total_rating,(CASE WHEN u.status = 1 THEN "active" ELSE "inactive" END) as user_status');
       $this->db->from(Tables::USER.' u'); 
	   $this->db->join('identification_document as id','id.id = u.identification_document_id','left');
	   $this->db->join('feedback as f','f.driver_id = u.user_id','left');  	   
	   $this->db->join('rider_feedback as rf','rf.rider_id = u.user_id','left');  	   
       $this->db->where(array('u.user_id'=>$user_data->id));
       $query =  $this->db->get();
       if ($query->num_rows()>0) {
           $query->user_detail = $query->row();
		   //$reting= $this->get_retings($user_data->id);
           $vehicle_query = $this->get_vehicle_detail($user_data->id);
           if ($vehicle_query->num_rows()>0) {
               $query->user_detail->vehicle_detail =$vehicle_query->result();
           }else{
            $query->user_detail->vehicle_detail=array();
           }
       }
       return $query;
    }

    /* get vehicle detail */
    public function get_vehicle_detail($user_id='',$vehicle_detail_id='')
    {
        $this->db->select('vd.id as vehicle_detail_id,vd.license_expiry_date,vd.license_issue_date,vd.insurance_issue_date,vd.insurance_expiry_date,vd.car_issue_date,vd.car_expiry_date,(Select GROUP_CONCAT(vt1.title) from vehicle_service left join vehicle_type vt1 on vt1.id=brand_id where vehicle_id=vd.id group by vehicle_id) as vehicle_type,IFNULL(m.title,"") as model_name,IFNULL(m.id,"") as model_id,IFNULL(vd.year,"") as year,IFNULL(vd.color,"") as color,IFNULL(vd.vehicle_no,"") as vehicle_no,IFNULL(vt.id,"") as brand_id,vd.status,vd.seat_no,CONCAT("'.base_url('uploads/license_document/').'",vd.user_id,"/",vd.license) as license_doc,vd.license,CONCAT("'.base_url('uploads/insurance_document/').'",vd.user_id,"/",vd.insurance) as insurance_doc,vd.insurance,CONCAT("'.base_url('uploads/permit_document/').'",vd.user_id,"/",vd.permit) as permit_doc,vd.permit,CONCAT("'.base_url('uploads/car_pic/').'",vd.user_id,"/",vd.car_pic) as car_pic,vd.car_pic as car_pic_doc,CONCAT("'.base_url('uploads/car_registration/').'",vd.user_id,"/",vd.car_registration) as car_registration_doc,vd.car_registration,premium_facility,inspection_expiry_date,inspection_approval_status,inspection_issue_date,CONCAT("'.base_url('uploads/inspection_document/').'",vd.user_id,"/",vd.inspection_document) as inspection_document');
         $this->db->from(Tables::VEHICLE_DETAIL.' vd');
        //$this->db->join(Tables::BRAND.' b','b.id=vd.brand_id','left');
        $this->db->join(Tables::VEHICLE_SUBCATEGORY_TYPE.' m','m.id=vd.model_id','left');
        $this->db->join(Tables::VEHICLETYPE.' vt','vt.id=vd.brand_id','left');
        if (empty($vehicle_detail_id)) { 
            $this->db->where(array('vd.user_id'=>$user_id));
        }else{
            $this->db->where(array('vd.user_id'=>$user_id,'vd.id'=>$vehicle_detail_id));
        }
        $this->db->where('vd.status!=3');
        $query =  $this->db->get();
        //echo $this->db->last_query();
        return $query;
    }

    public function get_current_ride($ride_id=''){
        $this->db->select("d.gcm_token as driver_fcm,d.name as driver_name,u.gcm_token as user_fcm,u.name as user_name,d.count_cancelled_ride,r.pickup_lat,r.user_id as userid,r.pickup_long,r.drop_lat,r.drop_long,r.ride_id,r.distance,r.vehicle_type_id,r.status as ride_status,r.cancelled_count,r.driver_id,r.distance,d.email,r.amount,r.drop_address,r.txn_id,r.card_id,r.pickup_adress,d.mobile,r.payment_status,d.destination_lat,d.destination_long,r.is_destination_ride,confirmation_time,u.cancellation_charge,d.latitude as driver_latitude,d.longitude as driver_longitude,r.is_technical_issue,r.start_waiting_time_onpickup as swtop,r.end_waiting_time_onpickup as ewtop,r.start_waiting_time_ondrop as swtod,r.end_waiting_time_ondrop as ewtod,r.free_waiting_time_pickup,r.free_waiting_time_stop,r.paid_waiting_time_pickup,r.waiting_charge_onpickup,r.total_waiting_time_onpickup,r.waiting_charge_ondrop,r.base_fare_fee as baserate,r.AdminRide_charges as admin_fee,r.surcharge_fee,r.taxes,r.waiting_time_for_ride,r.free_waiting_time_drop,r.paid_waiting_time_stop,r.paid_waiting_time_drop,r.on_location");
        $this->db->from(Tables::RIDE ." r");
        $this->db->join(Tables::USER ." d", "r.driver_id = d.user_id",'left');
        $this->db->join(Tables::USER ." u", "r.user_id = u.user_id",'left');
        $this->db->where("r.ride_id", $ride_id);
        $qry = $this->db->get();
        return $qry;
    }

    public function get_mechanic_detail($id=''){
        $this->db->select('IFNULL(CONCAT("'.base_url('uploads/profile_image/').'",u.user_id,"/",u.avatar)," ") as profile_pic,IFNULL(CONCAT("'.base_url('uploads/car_pic/').'",u.user_id,"/",vd.car_pic)," ") as car_pic,u.user_id,u.name,u.last_name,u.email,vd.vehicle_no,u.latitude,u.longitude,u.mobile,u.user_id as driver_id,(select COUNT(driver_id) from '.Tables::RIDE.' where driver_id=u.user_id and status="COMPLETED" group by driver_id limit 1) as total_driver_ride,(select SUM(rating) from '.Tables::FEEDBACK.' where driver_id=u.user_id group by driver_id limit 1) as total_rating,u.latitude,u.longitude,u.destination_lat,u.destination_long');
        $this->db->from(Tables::USER.' u');
        $this->db->join(Tables::VEHICLE_DETAIL.' vd','vd.user_id=u.user_id','inner');
        //$this->db->join(Tables::FEEDBACK.' f','f.driver_id =u.user_id','left');
        //$this->db->where(array('u.utype'=>2,'u.is_online'=>1,'vd.status'=>1,'vehicle_type_id'=>$vehicle_type_id));
        $this->db->where(array('u.user_id'=>$id));
        //$this->db->having("distance <='". $distance."'");
        //$this->db->having("distance <=3000");
        //$this->db->order_by("distance asc");
        $this->db->limit(1);
        $query =$this->db->get();
        return $query;
    }


    public function payment_history($user_data='',$limit,$start){        
        $filter_data = $this->input->get();
        $id = $user_data->id;
        $status = $this->input->get('status'); 
        $wh = ($user_data->utype == 1) ? "r.user_id=$id" : "r.driver_id=$id"; 
        $wh.= ' AND r.driver_id NOT IN (select driver_id from '.Tables::CANCELLED_RIDE.' where ride_id=r.ride_id AND driver_id='.$user_data->id.')';  
        $this->db->select('r.*,w.mobile as user_mobile,w.last_name as user_lastname,w.avatar as user_avatar,w1.avatar as driver_avatar,w.name as user_name,w1.mobile as driver_mobile,w1.user_id as driver_id,w1.name as driver_name,w1.last_name as driver_lastname,ph.txn_id,ph.date,r.payout_status');

        $this->db->from(Tables::PAYMENT_HISTORY.' ph');

        $this->db->join(Tables::RIDE.' r','ph.ride_id=r.ride_id','inner');

        $this->db->join(Tables::USER.' w','r.user_id=w.user_id', 'left');

        $this->db->join(Tables::USER.' w1','r.driver_id=w1.user_id', 'left');

        /* $this->db->join(Tables::VEHICLETYPE.' vt','vt.id=w1.vehicle_type', 'left'); */

        $this->db->where($wh);

        $this->db->where(array('r.payment_status'=>'COMPLETED','r.status'=>'COMPLETED'));

        if (isset($filter_data['from']) && !empty($filter_data['from']))

            $this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(trim($user_data->from)))."'",NULL,FALSE);

        if (isset($filter_data['to']) && !empty($filter_data['to']))

            $this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') <= '".date(PHP_DATE_FORMAT,strtotime(trim($user_data->to)))."'",NULL,FALSE);  
            $this->db->limit($start,$limit); 
        $this->db->order_by('r.ride_id desc');
        $res = $this->db->get();    
        return $res;
    }







    public function update_vehicle_status($id,$user_id)

    {

        $this->db->set(array('status'=>1));



        $this->db->where_in('vehicle_type_id', $id);        



        $this->db->where('user_id', $user_id);        



        return $this->db->update(Tables::VEHICLE_DETAIL);

    }
	
	public function upddriver_location($id,$latitude,$longitude) {
		$data = array( 
		   'latitude' => $latitude, 
		   'longitude' => $longitude 
		); 
		//print_r($data); die;

		//$this->db->set($data); 
		$this->db->where("user_id",$id); 
		$q=$this->db->update("users", $data);
		$this->db->last_query();
		if($q){
			return true;
		}else{
			return false;
		}
	}







    public function get_last_ride($user_data){
        $this->db->select('r.*,d.name_title as driver_title_name,d.name as driver_name,d.last_name as driver_lastname,IFNULL(CONCAT("'.base_url("uploads/profile_image/").'",r.driver_id,"/",d.avatar)," ") as profile_pic,IFNULL(CONCAT("'.base_url("uploads/profile_image/").'",r.user_id,"/",u.avatar)," ") as user_profile_pic,(select SUM(rating) from '.Tables::FEEDBACK.' where driver_id=d.user_id group by driver_id limit 1) as total_rating,(select COUNT(driver_id) from '.Tables::RIDE.' where driver_id=d.user_id and status="COMPLETED" group by driver_id limit 1) as total_driver_ride,d.latitude,u.name as user_name,u.name_title as user_titlename,u.last_name as user_lastname,d.longitude,d.mobile as driver_mobile,u.mobile,(CASE WHEN f.id >0 THEN true  ELSE false END) as feedback,(CASE WHEN rf.id >0 THEN true  ELSE false END) as rider_feedback,DAYNAME(r.time) as dayname');
        $this->db->from(Tables::RIDE.' r');
        $this->db->join(Tables::USER.' d','r.driver_id=d.user_id','left');
        $this->db->join(Tables::USER.' u','r.user_id=u.user_id','inner');
        $this->db->join(Tables::FEEDBACK.' f','f.ride_id=r.ride_id','left');
        $this->db->join(Tables::RIDER_FEEDBACK.' rf','rf.ride_id=r.ride_id','left');
        if ($user_data->utype==2) {  
            $this->db->where(array('r.driver_id'=>$user_data->id));
        }else{
            $this->db->where(array('r.user_id'=>$user_data->id));
        }
        $this->db->where("r.status!='FAILED'");
        $this->db->order_by('r.ride_id DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query;
    }


	 public function get_current_active_vehicle_image($driver_id)
    {

        $this->db->select('vd.user_id,vd.car_pic');
        $this->db->from(Tables::VEHICLE_DETAIL.' as vd'); 
        $this->db->where(array('vd.user_id'=>$driver_id,'vd.status'=>1));
        $query = $this->db->get(); 
        //echo $this->db->last_query();      
        return $query;
    }
	
    public function get_active_services($user_id,$vehicle_id,$vcategory_id)
    {
        $this->db->select('vs.id as service_id,v.id as category_id, v.title as category_title, vs.user_id,vs.vehicle_type_id,(CASE WHEN vs.status=1 THEN 1 else 0 END) as status,vs.vehicle_id,vt.title as vehicle_type');
        $this->db->from(Tables::VEHICLE_SERVICE.' as vs');
        $this->db->join(Tables::VEHICLE_SUBCATEGORY_TYPE.' as vt','vt.id=vs.vehicle_type_id','left');
		$this->db->join(Tables::VEHICLETYPE.' as v','v.id='.$vcategory_id,'left');
        $this->db->where(array('user_id'=>$user_id,'vehicle_id'=>$vehicle_id));
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query;
    }

    public function get_current_active_vehicle($driver_id)

    {

        $this->db->select('vd.license_issue_date,vd.license_expiry_date,vd.insurance_issue_date,vd.insurance_expiry_date,vd.car_issue_date,vd.car_expiry_date,vd.year,inspection_expiry_date,vd.license_approve_status,vd.insurance_approve_status,vd.car_registration_approve_status,vd.inspection_approval_status,u.verification_id_approval_atatus,u.background_approval_status');
        $this->db->from(Tables::VEHICLE_DETAIL.' as vd'); 
        $this->db->join(Tables::USER.' as u','u.user_id=vd.user_id','left');
        $this->db->where(array('vd.user_id'=>$driver_id,'vd.status'=>1));
        $query = $this->db->get();       
        return $query;
    }
    public function get_question_answer($id)
    {
       $this->db->select('u.name,u.email,ua.answer,q.question,q.email as question_email');
       $this->db->from(Tables::USER_ANSWER.' ua');
       $this->db->join(Tables::QUESTION.' q','q.id=ua.question_id','left');
       $this->db->join(Tables::USER.' u','u.user_id=ua.user_id','left');
       $this->db->where(array('ua.id'=>$id));
       return $this->db->get();
    }
    
    
    public function getdeviceToken($table,$userid){
        
        $this->db->select('device_type,device_token');
        $this->db->from($table);
        $this->db->where('user_id',$userid);
        $query=$this->db->get();
        return $query->result();
    }

    public function getvehicle_byCategory($catid){
        
        $this->db->select('vst.id as vehicle_id,vst.title as vehicle_name,vst.vehicle_type_category_id as category_id,vst.seat,vst.base_fare_fee,vst.hold_amount,vst.surcharge_fee,vst.taxes,vst.rate,vst.cancellation_fee,vst.short_description,vst.status,vt.title as category_name,vst.car_pic,vst.created_date');
        $this->db->from('vehicle_type vt');
        $this->db->join(' vehicle_subcategory_type vst','vt.id=vst.vehicle_type_category_id','right');
        $this->db->where('vehicle_type_category_id',$catid);
		$this->db->where('vst.status',1);
        //echo $this->db->last_query();
        $query=$this->db->get();
        return $query->result();
    }
	
	public function getCategory_year($catid){
        
        $this->db->select('*');
        $this->db->from('vehicle_categor_year');
		$this->db->where('category_id',$catid);
        $query=$this->db->get();
       // echo $this->db->last_query();
        return $query->result();
    }
	public function getSubCategory($catid){
        
        $this->db->select('*');
        $this->db->from('vehicle_subcategory_type');
		$this->db->where('vehicle_type_category_id',$catid);
        $query=$this->db->get();
       // echo $this->db->last_query();
        return $query->result();
    }
    public function getvehicle_byCat(){
        
        $this->db->select('*');
        $this->db->from('vehicle_type');
        $query=$this->db->get();
       // echo $this->db->last_query();
        return $query;
    }
	
	
	
	public function get_mobile($userid){
		$this->db->select('mobile');
		$this->db->from('users');
		$this->db->where('user_id',$userid);
		$res=$this->db->get();
		//echo $this->db->last_query();
		return $res;
		
	}
	
	public function getAdminData(){
		$this->db->select('free_waiting_time_pickup,free_waiting_time_stop,free_waiting_time_drop,paid_waiting_time_pickup,paid_waiting_time_stop,paid_waiting_time_drop');
		$this->db->from('admin');		
		$res=$this->db->get();
		//echo $this->db->last_query();
		return $res;
		
	}
	
	public function add_stop($data) {
        $this->db->insert('rides_midtrip_stops', $data);
    }
	
	
	public function get_hold_payment($amount,$user_id,$days){
		$this->db->select('*');
		$this->db->from('hold_payment_history');
		$this->db->where('user_id =',$user_id);		
		$this->db->where('amount >=',$amount);
		$this->db->where('status =','1');
		$this->db->where('created_date >=',$days);		
		$this->db->order_by("id", "asc");
        $this->db->limit(20);
		$res=$this->db->get();
		//echo $this->db->last_query();
		return $res;
		
	}
	public function get_stops($ride_id){
		$this->db->select('id as stop_id,midstop_address');
		$this->db->where('ride_id',$ride_id);
		$res = $this->db->get('rides_midtrip_stops')->result();
		return $res;
	}
	
	
	
	
    

}