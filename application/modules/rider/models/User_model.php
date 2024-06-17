<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class User_model extends MY_Model
{
	
	function __construct()
	{
		$this->load->database();
	}

	/* 
	This function is intended to retrieve a list of drivers from a database, based on the provided $filter_data. The $limit and $start parameters may indicate how many results to retrieve and from which index to start retrieving them.
	*/
	public function get_user_list($filter_data,$limit,$start)	
	{
		$this->db->select('*');
		$this->db->from(Tables::USER);
		if (empty($filter_data['status'])) {
			$this->db->where(array('status'=>1));
		}else{
			$this->db->where(array('status'=>$filter_data['status']));
		}
		if (isset($filter_data['email']) && !empty($filter_data['email'])) {
			$condition = "(`email` = '".$filter_data['email']."' OR `name` LIKE '%".$filter_data['email']."%')";
			$this->db->where($condition);
		}
		if (isset($filter_data['country']) && !empty($filter_data['country'])) {
			$condition = "(`country` LIKE '%".$filter_data['country']."%')";
			$this->db->where($condition);	
		}
		if (isset($filter_data['state']) && !empty($filter_data['state'])) {
			$condition = "(`state` LIKE '%".$filter_data['state']."%')";
			$this->db->where($condition);
		}
		if (isset($filter_data['city']) && !empty($filter_data['city'])) {
			$condition = "(`city` LIKE '%".$filter_data['city']."%')";
			$this->db->where($condition);
		}
		/* if(isset($filter_data['email']) && !empty($filter_data['email']))
			$this->db->where(array("email"=>$filter_data['email']));
		if(isset($filter_data['name']) && !empty($filter_data['name']))
			$this->db->where(array("name"=>$filter_data['name']));  */  
		/* if(isset($filter_data['mobile']) && !empty($filter_data['mobile']))
			$this->db->where('w1.mobile='.$filter_data['mobile'].' or w.mobile='.$filter_data['mobile']); */
		if (isset($filter_data['from']) && !empty($filter_data['from']))
			$this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(trim($filter_data['from'])))."'",NULL,FALSE);
		if (isset($filter_data['to']) && !empty($filter_data['to']))
			$this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') <= '".date(PHP_DATE_FORMAT,strtotime(trim($filter_data['to'])))."'",NULL,FALSE);
		$this->db->where(array('utype'=>1));
		if (!empty($limit)) {
			$this->db->limit($limit,$start);
		}
		$this->db->order_by('user_id DESC');
		$query = $this->db->get();
		return $query;
	}

	
	/* This function is intended to retrieve detailed information about a driver from a database, based on the provided $user_id. */
	public function getDriverDetail($user_id)
	{
		$this->db->select('u.name,u.email,u.mobile,background_approval_status,(CASE WHEN u.status=1 THEN "Active" WHEN u.status=3 THEN "Pending by Admin" WHEN u.status=4 THEN "Inactive" END) as status');
		$this->db->from(Tables::USER.' u');
		//$this->db->join(Tables::BRAND.' b','b.id=u.brand','left');
		//$this->db->join(Tables::MODEL.' m','m.id=u.model','left');
		//$this->db->join(Tables::VEHICLETYPE.' v','v.id=u.vehicle_type','left');
		$this->db->where(array('u.user_id'=>$user_id));
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->row_array();
	}

	/* 
	This function is intended to retrieve detailed information about a vehicle from a database, based on the provided $user_id.
	 */
	public function get_vehicle_detail($user_id='')
	{
		$this->db->select('vd.color,vd.user_id,vd.year,vd.vehicle_no,vd.car_pic,vd.status,vd.brand_id,vd.model_id,vd.vehicle_type_id,vd.inspection_document,inspection_issue_date,inspection_expiry_date,
			( CASE 
			WHEN vd.status=1 THEN "Active"
			WHEN vd.status=2 THEN "Inactive"
			END
			) as vehicle_status,vd.status,vd.id,vd.user_id,b.brand_name,m.model_name,v.title,v.rate,v.short_description,vd.license,vd.insurance,insurance_expiry_date,insurance_issue_date,car_issue_date,car_expiry_date,license_issue_date,license_expiry_date');
		$this->db->from(Tables::VEHICLE_DETAIL.' vd');
		$this->db->join(Tables::BRAND.' b','b.id=vd.brand_id','left');
		$this->db->join(Tables::MODEL.' m','m.id=vd.model_id','left');
		$this->db->join(Tables::VEHICLETYPE.' v','v.id=vd.vehicle_type_id','left');
		$this->db->where(array('vd.user_id'=>$user_id));
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query;
	}


	/* 
	This function is intended to retrieve a list of rides from a database, based on the provided $filter_data. The $limit and $start parameters may indicate how many results to retrieve and from which index to start retrieving them.
	*/

	public function get_ride_list($filter_data,$limit,$start,$userid)	
	{
		$this->db->select("r.*,u.name as customer,l.name as driver");
        $this->db->from(Tables::RIDE. " r");
        $this->db->join(Tables::USER." u", "u.user_id = r.user_id","left");
        $this->db->join(Tables::USER." l", "l.user_id = r.driver_id","left");
		$this->db->where("r.user_id = $userid");
		$this->db->where("r.status = 'COMPLETED'");
		
        if (!empty($limit)) {
			$this->db->limit($limit,$start);
		}
		if(isset($filter_data)){
			if(!empty($filter_data['status'])){
				$this->db->where(array('r.status'=>$filter_data['status']));
			}
			if (!empty($filter_data['email'])) {
				$condition = "(`l.email` = '".$filter_data['email']."' OR `l.name` LIKE '%".$filter_data['email']."%')";
				$this->db->where($condition);
			}
			if (!empty($filter_data['country'])) {
				$condition = "(`r.country` LIKE '%".$filter_data['country']."%')";
				$this->db->where($condition);	
			}
			if (!empty($filter_data['state'])) {
				$condition = "(`r.state` LIKE '%".$filter_data['state']."%')";
				$this->db->where($condition);
			}
			if (!empty($filter_data['city'])) {
				$condition = "(`r.city` LIKE '%".$filter_data['city']."%')";
				$this->db->where($condition);
			}
		}
	    $this->db->order_by('r.ride_id DESC');
	    $query = $this->db->get();
        //echo $this->db->last_query();
		return $query;
	}

	public function get_audio_list($filter_data,$limit,$start)	
	{
		$this->db->select("r.*,l.name as driver,ra.audio_file");
        $this->db->from(Tables::RIDE. " r");
        $this->db->join(Tables::RIDE_AUDIO." ra", "ra.user_id = r.user_id");
        $this->db->join(Tables::USER." l", "l.user_id = r.driver_id");
        if (!empty($limit)) {
			$this->db->limit($limit,$start);
		}
		if(isset($filter_data)){
			if(!empty($filter_data['status'])){
				$this->db->where(array('r.status'=>$filter_data['status']));
			}
			if (!empty($filter_data['email'])) {
				$condition = "(`l.email` = '".$filter_data['email']."' OR `l.name` LIKE '%".$filter_data['email']."%')";
				$this->db->where($condition);
			}
			if (!empty($filter_data['country'])) {
				$condition = "(`r.country` LIKE '%".$filter_data['country']."%')";
				$this->db->where($condition);	
			}
			if (!empty($filter_data['state'])) {
				$condition = "(`r.state` LIKE '%".$filter_data['state']."%')";
				$this->db->where($condition);
			}
			if (!empty($filter_data['city'])) {
				$condition = "(`r.city` LIKE '%".$filter_data['city']."%')";
				$this->db->where($condition);
			}
		}
	    $this->db->order_by('r.ride_id DESC');
	    $query = $this->db->get();
        //echo $this->db->last_query();
		return $query;
	}








/* 
This function is intended to retrieve a payment history from a database, based on the provided $filter_data. The $limit and $start parameters may indicate how many results to retrieve and from which index to start retrieving them.
*/
	public function payment_history($filter_data='',$limit,$start)
    {
                
        //$wh = ($user_data->utype == 1) ? "r.user_id=$id" : "r.driver_id=$id";   
        //$wh= ' AND r.driver_id NOT IN (select driver_id from '.Tables::CANCELLED_RIDE.' where ride_id=r.ride_id AND driver_id='.$user_data->id.')';     
        $this->db->select('r.*,w.mobile as user_mobile,w.avatar as user_avatar,w1.avatar as driver_avatar,w.name as user_name,w1.mobile as driver_mobile,w1.user_id as driver_id,w1.name as driver_name,ph.txn_id,w1.email as driver_email,ph.date as ride_date');
        $this->db->from(Tables::PAYMENT_HISTORY.' ph');
        $this->db->join(Tables::RIDE.' r','ph.ride_id=r.ride_id','inner');
        $this->db->join(Tables::USER.' w','r.user_id=w.user_id', 'left');
        $this->db->join(Tables::USER.' w1','r.driver_id=w1.user_id', 'left');
        //$this->db->join(Tables::VEHICLETYPE.' vt','vt.id=w1.vehicle_type', 'left');
        //$this->db->where($wh);
        $this->db->where(array('r.payment_status'=>'COMPLETED','r.status'=>'COMPLETED'));
        if(isset($filter_data['email']) && !empty($filter_data['email']))
            $this->db->where(array("w1.email"=>$filter_data['email']));
		if(isset($filter_data['name']) && !empty($filter_data['name']))
            $this->db->where(array("w1.name"=>$filter_data['name']));   
        if(isset($filter_data['mobile']) && !empty($filter_data['mobile']))
            $this->db->where('w1.mobile='.$filter_data['mobile'].' or w.mobile='.$filter_data['mobile']);

        if (isset($filter_data['from']) && !empty($filter_data['from']))
			$this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(trim($filter_data['from'])))."'",NULL,FALSE);

		if (isset($filter_data['to']) && !empty($filter_data['to']))
			$this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') <= '".date(PHP_DATE_FORMAT,strtotime(trim($filter_data['to'])))."'",NULL,FALSE);
        $this->db->order_by('r.ride_id desc');
        if (!empty($limit)) {
			$this->db->limit($limit,$start);
		}
        $res = $this->db->get();
        
        return $res;
    }
	/*19-09-2022 */
    public function payout_history1($filter_data='',$limit,$start)
    { 
        $this->db->select('r.*,w.mobile as user_mobile,w.avatar as user_avatar,w1.avatar as driver_avatar,w.name as user_name,w1.mobile as driver_mobile,w1.user_id as driver_id,w1.name as driver_name,ph.txn_id,w1.email as driver_email,ph.date as ride_date');
        $this->db->from(Tables::PAYMENT_HISTORY.' ph');
        $this->db->join(Tables::RIDE.' r','ph.ride_id=r.ride_id','inner');
        $this->db->join(Tables::USER.' w','r.user_id=w.user_id', 'left');
        $this->db->join(Tables::USER.' w1','r.driver_id=w1.user_id', 'left');
        if (empty($filter_data)) {
        	$this->db->where(array('r.payment_status'=>'COMPLETED1','r.status'=>'COMPLETED'));
        } 
        if(isset($filter_data['name']) && !empty($filter_data['name']))
            $this->db->where("(w1.name LIKE '%".$filter_data['name']."%')");  
		if(isset($filter_data['email']) && !empty($filter_data['email']))
            $this->db->where(array("w1.email"=>$filter_data['email']));  
		if(isset($filter_data['mobile_number']) && !empty($filter_data['mobile_number']))
            $this->db->where(array("w1.mobile"=>$filter_data['mobile_number'])); 
        if (isset($filter_data['from']) && !empty($filter_data['from']))
			$this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(trim($filter_data['from'])))."'",NULL,FALSE);
		if (isset($filter_data['to']) && !empty($filter_data['to']))
			$this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') <= '".date(PHP_DATE_FORMAT,strtotime(trim($filter_data['to'])))."'",NULL,FALSE);
        $this->db->order_by('r.ride_id desc');
        if (!empty($limit)) {
			$this->db->limit($limit,$start);
		}
        $res = $this->db->get();
        //echo $this->db->last_query();
        return $res;
    }
/* 
This function is intended to retrieve a payout history from a database, based on the provided $filter_data. The $limit and $start parameters may indicate how many results to retrieve and from which index to start retrieving them.
*/
	public function payout_history($filter_data='',$limit,$start)
    {   
		$this->db->select('r.*,w.mobile as user_mobile,w.avatar as user_avatar,w1.avatar as driver_avatar,w.name as user_name,w1.mobile as driver_mobile,w1.user_id as driver_id,w1.name as driver_name,ph.txn_id,w1.email as driver_email,ph.date as ride_date');
        $this->db->from(Tables::PAYMENT_HISTORY.' ph');
        $this->db->join(Tables::RIDE.' r','ph.ride_id=r.ride_id','inner');
        $this->db->join(Tables::USER.' w','r.user_id=w.user_id', 'left');
        $this->db->join(Tables::USER.' w1','r.driver_id=w1.user_id', 'left');
        if (empty($filter_data)) {
        	$this->db->where(array('r.payment_status'=>'COMPLETED1','r.status'=>'COMPLETED'));
        } 
		$this->db->where(array('r.driver_id'=>$filter_data['driver_id']));
        if (isset($filter_data['from']) && !empty($filter_data['from']))
			$this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') >= '".date(PHP_DATE_FORMAT,strtotime(trim($filter_data['from'])))."'",NULL,FALSE);
		if (isset($filter_data['to']) && !empty($filter_data['to']))
			$this->db->where("DATE_FORMAT(ph.date,'".SQL_DATE_FORMAT."') <= '".date(PHP_DATE_FORMAT,strtotime(trim($filter_data['to'])))."'",NULL,FALSE);
        $this->db->order_by('r.ride_id desc');
        if (!empty($limit)) {
			$this->db->limit($limit,$start);
		}
        $res = $this->db->get();
        //echo $this->db->last_query();
        return $res;
    }
	
	public function payout_historybyweek($table,$business_id){
       $query = $this->db->query('select year(time) as year, week(time) as week, sum(amount) as total_paid_amount,sum(tip_amount) as total_tip_amount from '.$table.' WHERE driver_id = "'.$business_id.'" and status="COMPLETED" group by year(time), week(time) '); 
        return $query->result();
	}
	public function getbankdetails($userid){
		$this->db->select('*');
		$this->db->from('driver_account_detail');
		$this->db->where('user_id',$userid);
		$res = $this->db->get();
		//echo $this->db->last_query(); die;
		return $res->row_array();
	}
}