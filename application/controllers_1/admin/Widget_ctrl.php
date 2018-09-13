<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','ion_auth','form_validation','substring'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Users_model','admin/Widget_model','admin/Slider_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	function index(){
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Language.txt'),true);
		if(count($file_menu)){
			$languages = $file_menu;
		}
		else{
			$languages = $this->Language_model->get_all_language();
			$json = json_encode($languages);
			$file = FCPATH . '/software_files/Language.txt';
			file_put_contents ($file, $json);
		}
		
		foreach($languages as $language){
			if($language['l_id'] == $this->session->userdata('language'))
				$data['language'] = $language;
		}
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Widgets.txt'),true);
		if(count($file_menu)){
			$data['widget'] = $file_menu;
		}
		else{
			$data['widget'] = $this->Widget_model->widget_list();
			$json = json_encode($data['widget']);
			$file = FCPATH . '/software_files/Widgets.txt';
			file_put_contents ($file, $json, FILE_APPEND);
		}
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/master/widget',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function widget_create(){
		if($this->input->post('widget_id') != ''){
			$this->form_validation->set_rules('widget_id', str_replace(':', '', $this->lang->line('widget_widget_content_label')), 'required|trim|integer|is_natural_no_zero');
		}
		$this->form_validation->set_rules('widget_content', str_replace(':', '', $this->lang->line('widget_widget_content_label')), 'required|trim|min_length[3]');
		$this->form_validation->set_rules('widget_title', str_replace(':', '', $this->lang->line('widget_widget_title_label')), 'required|trim|min_length[3]');
		$this->form_validation->set_rules('widget_name', str_replace(':', '', $this->lang->line('widget_widget_name_label')), 'required|trim|min_length[3]');
		
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			echo validation_errors(); 
		}
		else{
			$data['created_at'] = date('d-m-y h:i:s');
			$data['created_by'] = (int)$this->session->userdata('user_id');
			$data['lang_id'] = (int)$this->session->userdata('language');
			$data['ip'] = $this->input->ip_address();
			if($this->input->post('widget_id')){
				$data['widget_id'] = (int)$this->input->post('widget_id'); 
				$data['widget_title'] = $this->input->post('widget_title');
				$data['widget_name'] = $this->input->post('widget_name');
				$data['widget_content'] = $this->input->post('widget_content',false);
				$result = $this->Widget_model->widget_update($data);
				if($result){
					echo json_encode(array('msg'=>'Widget updated successfully.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'Something gonna wrong.','status'=>500));
				}
			}
			else{
				if($this->ion_auth->is_admin()){
					$data['widget_title'] = $this->input->post('widget_title');
					$data['widget_name'] = $this->input->post('widget_name');
					$data['widget_content'] = $this->input->post('widget_content');
					$result = $this->Widget_model->widget_create($data);
					echo json_encode(array('data'=>$result,'msg'=>'Widget created successfully.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'Not authorized for creating widgets.','status'=>500));
				}
			}
		}
	}
	function widget_update(){
		$this->load->view('admin/pages/master/widget');
		echo "rahul"; die;
			$date['updated_at']=date('d-m-y h:i:s');
			$data['widget_content']=$this->input->post('widget_content');
			$data['widget_name']=$this->input->post('widget_name');
			$data['updated_by']=$this->session->userdata('user_id');
			$data['lang_id']=$this->session->userdata('language');
			$data['ip']=$this->input->ip_address();
			if($this->input->post('widget_id') != ''){
				$data['widget_id'] = (int)$this->input->post('widget_id');
				$result = $this->Widget_model->widget_update($data);
				echo json_encode(array('status'=>200));
			}
				
	}
	
	function widget_delete(){
		if($this->ion_auth->is_admin()){
			$data['w_id'] = $this->input->post('w_id');
			$result = $this->Widget_model->widget_delete($data);
			if($result){
				//$this->file_update();
				echo json_encode(array('msg'=>'Operation successfull.','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'Something wrong.','status'=>500));
			}
		}
		else{
			echo json_encode(array('msg'=>'You are not authorized.','status'=>500));
		}
		
	}
	
	function widget_content(){
		$data['widget_id'] = $this->input->post('widget_id');
		$result = $this->Widget_model->widget_content($data);
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function widget_name_check(){
		$data['str'] = $this->input->post('str');
		$result = $this->Widget_model->widget_name_check($data);
		if(count($result) > 0){
			echo json_encode(array('data'=>$result,'status'=>500));
		}
		else{
			echo json_encode(array('msg'=>'No record found','status'=>200));
		}
	}
	
}
