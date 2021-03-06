<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','ion_auth'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Users_model','admin/Widget_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	function get_all_widgets(){
		$page_id = $this->input->post('page_id');
		
		$this->db->select('*');
		$widgets = $this->db->get_where('widgets',array('status'=>1))->result_array();
		
		if(count($widgets) > 0){
			if($page_id){
				$this->db->select('page_layout');
				$result = $this->db->get_where('pages',array('p_id'=>$page_id,'status'=>1))->result_array();
				if($result[0]['page_layout'] == 2){
					$this->db->select('*');
					$layout = $this->db->get_Where('page_components',array('page_id'=>$page_id,'status'=>1))->result_array();
					if(count($layout) > 0){
						echo json_encode(array('data'=>$widgets,'data2'=>$layout,'status'=>200));
					}
					else{
						echo json_encode(array('data'=>$widgets,'data2'=>$layout,'msg'=>'No component is added in this page.','status'=>200));
					}
				}
				
				if($result[0]['page_layout'] == 1){
					$this->db->select('*');
					$layout = $this->db->get_Where('page_components',array('page_id'=>$page_id,'status'=>1))->result_array();
					if(count($layout) > 0){
						echo json_encode(array('data'=>$widgets,'data2'=>$layout,'status'=>200));
					}
					else{
						echo json_encode(array('data'=>$widgets,'data2'=>$layout,'msg'=>'No component is added in this page.','status'=>200));
					}
				}
				
				if($result[0]['page_layout'] == 3){
					$this->db->select('*');
					$layout = $this->db->get_Where('page_components',array('page_id'=>$page_id,'status'=>1))->result_array();
					if(count($layout) > 0){
						echo json_encode(array('data'=>$widgets,'data2'=>$layout,'status'=>200));
					}
					else{
						echo json_encode(array('data'=>$widgets,'data2'=>$layout,'msg'=>'No component is added in this page.','status'=>200));
					}
				}
			}
			else{
				echo json_encode(array('data'=>$widgets,'msg'=>'All Widgets.','status'=>200));
			}
		}
		else{
			echo json_encode(array('msg'=>'No Record Found.','status'=>500));
		}
	}
	
	
	function get_all_language(){
		$result = $this->Language_model->get_all_language();
		if(count($result) > 0){
			echo json_encode(array('data'=>$result,'msg'=>'All Languages.','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'No Record Found.','status'=>500));
		}
	}
	
	function get_all_apmcs(){
		$s_id = $this->input->post('s_id');
		$this->db->select('*');
		$result = $this->db->get_where('training_apmc',array('state_id'=>$s_id))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function apmc_detail(){
		$data['state_id'] = (int)$this->input->post('s_id');
		$data['apmc_id'] = (int)$this->input->post('apmc_id');
		$data['round'] = (int)$this->input->post('round');
		$this->db->select('*');
		$result = $this->db->get_where('training_data',array('state_id'=>$data['state_id'],'apmc_id'=>$data['apmc_id'],'round'=>$data['round'],'status'=>1))->result_array();
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
}
