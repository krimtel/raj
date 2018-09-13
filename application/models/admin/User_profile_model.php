<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_profile_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
	}
	
	function user_data($data){
		$data['uid'] = $data['uid'];
		$this->db->select('*');
		$this->db->where('id',$data['uid']);
		$result = $this->db->get('users')->result_array();
		//print_r($this->db->last_query()); die;
		return $result;
	}
	
	function profile_update($data){
		$val['f_name'] = $data['f_name'];
		$val['l_name'] = $data['l_name'];
		$val['contact'] = $data['contact'];
		$val['email'] = $data['email'];
		$val['uid'] = $data['uid'];
		
		$this->db->trans_begin();
		if(isset($data['user_image']))
		{
			$this->db->where('id',$data['uid']);
			$this->db->update('users',array(
				'first_name' =>  	$data['f_name'],
				'last_name' =>    $val['l_name'],
				'email'  =>    $val['email'],
				'phone'  =>    $data['contact'],
				'photo'  =>    $data['user_image']
			));
		}
		else{
			$this->db->where('id',$data['uid']);
			$this->db->update('users',array(
					'first_name' =>  	$data['f_name'],
					'last_name' =>    $val['l_name'],
					'email'  =>    $val['email'],
					'phone'  =>    $data['contact']
					));
		}
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else {
			$this->db->trans_commit();
			
			return true;
		}
		//print_r($this->db->last_query()); die;
		return true;
	}
	
}
?>