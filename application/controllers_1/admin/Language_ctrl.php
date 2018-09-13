<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file','form'));
		$this->load->library(array('session','ion_auth','form_validation'));
		$this->load->database();
		$this->load->model(array('admin/Language_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	function file_update(){
		$data['languages'] = $this->Language_model->get_all_language();
		$json = json_encode($data['languages']);
		$file = FCPATH . '/software_files/Language.txt';
		file_put_contents ($file, $json);
	}
	
	public function index(){
		$data['title'] = 'eNam Admin';		
		
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Language.txt'),true);
		if(count($file_menu)){
			$data['languages'] = $file_menu;
		}
		else{
			$data['languages'] = $this->Language_model->get_all_language();
			$json = json_encode($data['languages']);
			$file = FCPATH . '/software_files/Language.txt';
			file_put_contents ($file, $json);
		}
		
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/master/language',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function language_edit(){
		
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('name', 'language name', 'required|trim|min_length[3]');
			$this->form_validation->set_rules('id', 'language id', 'required|trim|integer|is_natural_no_zero');
			$data['name'] = $this->input->post('name');
			$data['l_eng'] = $this->input->post('l_eng');
			$data['id'] = (int)$this->input->post('id');
			$data['updated_at'] = date('d-m-y h:i:s');
			$data['ip'] = $this->input->ip_address();
			$data['user_id'] = $this->session->userdata('user_id');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$result = $this->Language_model->language_edit($data);
				if($result){
					$this->file_update();
					if($this->lang->line('language_update_success')){
						$msg  = $this->lang->line('language_update_success');
					}
					else{
						$msg = 'Language updated successfully.';
					}
					echo json_encode(array('msg'=>$msg,'status'=>200));
				}
				else{
					if($this->lang->line('language_update_failed')){
						$msg  = $this->lang->line('language_update_failed');
					}
					else{
						$msg = 'Language updated failed.';
					}
					echo json_encode(array('msg'=>$msg,'status'=>500));
				}
			}
		}
		else{
			echo json_encode(array('msg'=>'You are not Authorized.','status'=>500));
		}
	}
	
	function language_create(){
		if($this->ion_auth->is_admin()){
			$data['l_name'] = $this->input->post('name');
			$data['l_eng'] = $this->input->post('l_eng');
			$data['created_at'] = date('d-m-y h:i:s');
			$data['ip'] = $this->input->ip_address();
			$data['last_update_by'] = $this->session->userdata('user_id');
			
			$result = $this->Language_model->language_create($data);
			if(count($result) > 0){
				if($this->lang->line('language_create_success')){
					$msg  = $this->lang->line('language_create_success');
				}
				else{
					$msg = 'Language Creation Successfully.';
				}
				
				if(!is_dir(APPPATH.'/language/'.$this->input->post('l_eng'))){
					
					mkdir(APPPATH.'/language/'.$this->input->post('l_eng'));
					copy(APPPATH.'/language/english/client_lang.php',APPPATH.'/language/'.$this->input->post('l_eng').'/client_lang.php');
				}
				
				echo json_encode(array('data'=>$result,'msg'=>$msg,'status'=>200));
			}
			else{
				if($this->lang->line('language_create_failed')){
					$msg  = $this->lang->line('language_create_failed');
				}
				else{
					$msg = 'Language Creation Failed.';
				}
				echo json_encode(array('msg'=>$msg,'status'=>500));
			}
		}
		else{
			echo json_encode(array('msg'=>'You Are Not Authorized.','status'=>500));
		}
	
	}
	
	function language_delete(){ 
		if ($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('id', 'language id', 'required|trim|integer|is_natural_no_zero');
			
			$data['id'] = $this->input->post('id');
			$data['updated_at'] = date('d-m-y h:i:s');
			$data['ip'] = $this->input->ip_address();
			$data['user_id'] = $this->session->userdata('user_id');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$result = $this->Language_model->language_delete($data);
				if($result){
					
					if($this->lang->line('language_delete_success')){
						$msg  = $this->lang->line('language_delete_success');
					}
					else{
						$msg = 'Language Delete Successfully.';
					}
					echo json_encode(array('msg'=>$msg,'status'=>200));
				}
				else{
					if($this->lang->line('language_delete_failed')){
						$msg  = $this->lang->line('language_delete_failed');
					}
					else{
						$msg = 'Language Delete Failed.';
					}
					echo json_encode(array('msg'=>$msg,'status'=>500));
				}
			}
		}
		else{
			echo json_encode(array('msg'=>'You are not authorized.','status'=>500));
		}
	}
	
	function language_check(){ 
		$language = $this->input->post('language');
		$result = $this->db->get_where('languages',array('l_name'=>$language,'status'=>1))->result_array();
		if(count($result) > 0){
			echo json_encode(array('msg'=>'This language already exist.','status'=>500));
		}
		else{
			echo json_encode(array('msg'=>'Congretes.','status'=>200));
		}
	}
	
	function language_check_eng(){
		$language_name_eng = $this->input->post('language_name_eng');
		$result = $this->db->get_where('languages',array('l_eng'=>$language_name_eng,'status'=>1))->result_array();
		if(count($result) > 0){
			echo json_encode(array('msg'=>'This language already exist.','status'=>500));
		}
		else{
			echo json_encode(array('msg'=>'Congretes.','status'=>200));
		}
	}
	
}
