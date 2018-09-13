<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Links_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','form_validation','ion_auth'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Links_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	function file_update(){
		$data['links'] = $this->Links_model->link_list();
		$json = json_encode($data['links']);
		$file = FCPATH . '/software_files/Links.txt';
		file_put_contents ($file, $json);
	}
	public function index(){
		
		$data['title'] = 'eNam Admin';
		$languages = json_decode(file_get_contents(FCPATH . '/software_files/Language.txt'),true);
		foreach($languages as $language){
			if($language['l_id'] == $this->session->userdata('language'))
			$data['language'] = $language;
		}
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Links.txt'),true);
		if(count($file_menu)){
			$data['links'] = $file_menu;
		}
		else{
			$data['links'] = $this->Links_model->link_list();
			$json = json_encode($data['links']);
			$file = FCPATH . '/software_files/Links.txt';
			file_put_contents ($file, $json);
		}
		
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/widget/link',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function link_create(){
		$this->form_validation->set_rules('link_desc', str_replace(':', '', $this->lang->line('link_link_desc_label')), 'required');
		if($this->input->post('link_id') != ''){
			$this->form_validation->set_rules('link_id','Link Id','required|integer|is_natural_no_zero');
		}
		else{
			$this->form_validation->set_rules('link_order','Link Order','required|integer|is_natural');
		}
		$this->form_validation->set_rules('link_desc','Link Contant','required|trim|min_length[3]');
		
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', validation_errors());
			echo validation_errors(); die;
		}
		else{
			$data['link_contect'] = $this->input->post('link_desc');
			$data['sort'] = (int)$this->input->post('link_order');
			$data['ip'] = $this->input->ip_address();
			$data['created_at'] = date("d-m-y h:i:s");
			$data['user_id'] = (int)$this->session->userdata('user_id');
			$data['lang_id'] = (int)$this->session->userdata('language');
			if($this->input->post('link_id') != ''){
				$data['link_id'] = (int)$this->input->post('link_id');
				$result = $this->Links_model->link_update($data);
				if($result){
					$this->file_update();
					echo json_encode(array('msg'=>'Operation Successfull.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'Something Wrong.','status'=>500));
				}
			}
			else{
				if($this->ion_auth->is_admin())
				{			
					$result = $this->Links_model->link_create($data);
					if(count($result) > 0){
						$this->file_update();
						echo json_encode(array('data'=>$result,'msg'=>'Link Created Successfully.','status'=>200));
					}
					else{
						echo json_encode(array('msg'=>'link not created successfully.','status'=>500));
					}
				}
				else{
					echo json_encode(array('msg'=>'You dont have permission for create links.','status'=>500));
				}
			}
		}
	}
	
	
	function get_link_content(){
		$this->form_validation->set_rules('l_id','Link Id','required|integer|is_natural_no_zero');
		
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', validation_errors());
			echo validation_errors(); die;
		}
		else{
			$data['link_id'] = (int) $this->input->post('l_id');
			$data['lang_id'] = (int) $this->session->userdata('language');
			$data['ip'] = $this->input->ip_address();
			$data['updated_at'] = date('d-m-y h:i:s');
			$data['updated_by'] = (int) $this->session->userdata('user_id');
			
			$result = $this->Links_model->get_link_content($data);
			if(count($result)>0){
				echo json_encode(array('data'=>$result,'msg'=>'link content.','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'No Record Found.','status'=>200));
			}
		}
	}
	
	function link_publish(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('l_id','Link Id','required|integer|is_natural_no_zero');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message', validation_errors());
				echo validation_errors(); die;
			}
			else{
				$data['l_id'] = (int)$this->input->post('l_id');
				$data['status'] = $this->input->post('status');
				if($data['status'] == 'true'){
					$data['status'] = 1;
				}
				else{
					$data['status'] = 0;
				}
				
				$result = $this->Links_model->link_publish($data);
				if($result){
					$this->file_update();
					echo json_encode(array('msg'=>'Operation successfull.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'Something wrong.','status'=>500));
				}
			}
		}
		else{
			echo json_encode(array('msg'=>'You are not authorized.','status'=>500));
		}
	}
	
	function link_delete(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('l_id','Link Id','required|integer|is_natural_no_zero');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message', validation_errors());
				echo validation_errors(); die;
			}
			else{
				$data['l_id'] = (int)$this->input->post('l_id');
				$result = $this->Links_model->link_delete($data);
				if($result){
					$this->file_update();
					echo json_encode(array('msg'=>'Operation successfull.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'Something wrong.','status'=>500));
				}
			}
		}
		else{
			echo json_encode(array('msg'=>'You are not authorized.','status'=>500));
		}
	}
}
