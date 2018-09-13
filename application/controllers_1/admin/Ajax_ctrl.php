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
	
	// function menu_url_check(){
		// $text = $this->input->post('text');
		// $result = $this->db->get_where('menu',array('status'=>1,'cms_url'=>$text))->result_array();
		// if(count($result)>0){
			// echo json_encode(array('status'=>500));
		// }
		// else{
			// echo json_encode(array('status'=>200));
		// }
	// }
	
	// function Check_page_name(){
		// $text = $this->input->post('text');
		
		// $this->db->select('*');
		// $result = $this->db->get_where('pages',array('page_name'=>$text,'status'=>1))->result_array();
		// if(count($result) > 0){
			// echo json_encode(array('msg'=>'Page is alread exsist.','status'=>500));
		// }
		// else{
			// echo json_encode(array('msg'=>'Congatualtions.','status'=>200));
		// }
	// }
}
