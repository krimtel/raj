<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->model(array('admin/Menu_model','admin/Page_model'));
		$this->load->library(array('session','ion_auth','form_validation','MY_form_validation'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	function file_update(){ 
		$data['menus'] = $this->Menu_model->menu_list();
		$json = json_encode($data['menus']);
		$file = FCPATH . '/software_files/Menu.txt';
		file_put_contents ($file, $json);
	}
	
	public function index($m_id = null){
		if($m_id != null){
			$data['title'] = 'Menu Edit';
		}
		else{
			$data['title'] = 'Menu';
		}
		
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Menu.txt'),true);
		if(count($file_menu)){
			$data['menus'] = $file_menu;
		}
		else{
			$data['menus'] = $this->Menu_model->menu_list();
			$json = json_encode($data['menus']);
			$file = FCPATH . '/software_files/Menu.txt';
			file_put_contents ($file, $json);
		}
		
		$data['cms_pages'] = $this->Page_model->get_all_pages();
		$data['parent_menus'] = $result = $this->Menu_model->get_all_parents_menu(0);
		$data['head'] = $this->load->view('admin/comman/head',$data,TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/layout/nav_menu',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function get_all_parents_menu($p_id = 0){
			$p_id = $this->input->post('mid');
			$result = $this->Menu_model->get_all_parents_menu($p_id);
			if(count($result)>0){
				echo json_encode(array('data'=>$result,'status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'No record found.','status'=>200));
			}
	}	
	
	function menu_create(){
		if($this->input->post('menu_id') == ''){
			$this->form_validation->set_rules('menu_name','menu_name','required',
				array(
					'required'      => $this->lang->line('menu_name_error_required'),
					'is_unique'     => $this->lang->line('menu_name_error_isunique')
				));
		}
		else{
			$this->form_validation->set_rules('menu_name','menu_name','required',
					array(
							'required'      => $this->lang->line('menu_name_error_required')
					));
		}
// 		$this->form_validation->set_rules('menu_url_text','slf','valid_url',
// 				array(
// 						'required'      => 'required',
// 						'valid_url'     => 'its working'
// 				));
		
		if ($this->form_validation->run() == FALSE){
			echo validation_errors(); die;
		}
		else{
			$data['title'] = $this->input->post('menu_name');
			$data['menu_slug'] = $this->input->post('menu_name');
			$data['p_id'] = (int)$this->input->post('menu_parent_dropdown');
			
			$data['external_link'] = (int)$this->input->post('menu_external_link');
			$data['cms_url'] = $this->input->post('menu_url_text');
			
			$page_id = $this->input->post('menu_cems_link_select');
			if($page_id != 0){
				$data['page_id'] = $page_id;	
			}
			else {
				$data['page_id'] = null;
			}
			
			$data['sort'] = (int)$this->input->post('menu_sort_order');
			$data['created_at'] = date('d-m-y h:i:s');
			$data['created_by'] = (int)$this->session->userdata('user_id');
			$data['ip'] = $this->input->ip_address();
			
			if($this->input->post('menu_id') != ''){
				$data['menu_id'] = (int)$this->input->post('menu_id');
				$data['title']  =  $this->input->post('menu_name');
				//print_r($this->input->post()); die;
				$result = $this->Menu_model->menu_update($data);
				if($result){
					$this->file_update();
					echo json_encode(array('msg'=>'Menu Updated Successfully.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'some error found.','status'=>500));
				}
			}
			else {
				$result = $this->Menu_model->menu_create($data);
				if($result){
					$this->file_update();
					echo json_encode(array('msg'=>'Menu created susseccfully.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'some error found.','status'=>500));
				}
			}
		}
	}
	
	function menu_content(){
		//if ($this->ion_auth->is_admin()){
			$data['m_id'] = (int)$this->input->post('m_id');
			$data['lang_id'] = $this->session->userdata('language');
			$result = $this->Menu_model->menu_content($data);
			if(count($result) == 1){
				$this->file_update();
				echo json_encode(array('data'=>$result,'msg'=>'','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'','status'=>500));
			}
		//}
	}
	
	function menu_delete(){
		if ($this->ion_auth->is_admin()){
			$data['m_id'] = (int)$this->input->post('m_id');
			$result = $this->Menu_model->menu_delete($data);
			if($result){
				$this->file_update();
				echo json_encode(array('msg'=>'Menu deleted successfully.','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'Something gone wrong.','status'=>500));
			}
		}
		else{
			$data['m_id'] = (int)$this->input->post('m_id');
			$data['lang_id'] = (int)$this->session->userdata('language');
			$result = $this->Menu_model->menu_delete($data);
			if($result){
				$this->file_update();
				echo json_encode(array('msg'=>'Menu deleted successfully.','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'You are not authorized.','status'=>500));
			}
		}
	}
}
