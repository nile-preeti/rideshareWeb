<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array('common/Tables'));
	}

	public function save($table,$data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function update($table,$where, $data){
		return $this->db->update($table, $data, $where);
	}

	public function getResultsByCondtion($table,$condition){
		$this->db->where($condition);
		$query = $this->db->get($table);
		return $query;
	}

	public function getSingleRecord($table,$condition){
		$this->db->where($condition);
		$query = $this->db->get($table);
		return $query;
	}

	public function delete_by_condition($table,$where){
		$this->db->where($where);
		$query = $this->db->delete($table);
		return  $query;
	}

	public function query($sql){
		$query = $this->db->query($sql);
		return $query;
	}

	public function getCustomFields($table,$condition,$fields){
		$this->db->select($fields);
		$this->db->where($condition);
		$query = $this->db->get($table);
		//echo $this->db->last_query();		
		return $query;
	}
	public function getCustomFieldsDesc($table,$condition,$fields,$orderby,$ordertype){
		$this->db->select($fields);
		$this->db->where($condition);
		$this->db->order_by($orderby,$ordertype);
		$query = $this->db->get($table);
		//echo $this->db->last_query();		
		return $query;
	}

}