<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','form_validation','ion_auth'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/News_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	function file_update(){
		$data['newses'] = $this->News_model->News_list();
		$json = json_encode($data['newses']);
		$file = FCPATH . '/software_files/News.txt';
		file_put_contents ($file, $json);
	}
	public function index(){
		$data['title'] = 'eNam Admin';
		$languages = json_decode(file_get_contents(FCPATH . '/software_files/Language.txt'),true);
		foreach($languages as $language){
			if($language['l_id'] == $this->session->userdata('language'))
			$data['language'] = $language;
		}
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/News.txt'),true);
		if(count($file_menu)){
			$data['newses'] = $file_menu;
		}
		else{
			$data['newses'] = $this->News_model->News_list();
			$json = json_encode($data['newses']);
			$file = FCPATH . '/software_files/News.txt';
			file_put_contents ($file, $json, FILE_APPEND);
		}
		
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/widget/news',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function news_create(){
		$this->form_validation->set_rules('news_desc', str_replace(':', '', $this->lang->line('news_news_desc_label')), 'required');
	
		if($this->input->post('news_id') != ''){
			$this->form_validation->set_rules('news_id','News Id','required|integer|is_natural_no_zero');
		}
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('news_order','News Order','required|is_natural|integer');
		}
		$this->form_validation->set_rules('news_desc','News Contant','required|trim');
		
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message', validation_errors());
			redirect('admin/admin/news', 'refresh');
		}
		else{
			$data['news_contect'] = $this->input->post('news_desc');
			$data['sort'] = (int)$this->input->post('news_order');
			$data['ip'] = $this->input->ip_address();
			$data['created_at'] = date("y-m-d h:i:s");
			$data['user_id'] = (int)$this->session->userdata('user_id');
			$data['lang_id'] = (int)$this->session->userdata('language');
			if($this->input->post('news_id') != ''){
				$data['news_id'] = (int)$this->input->post('news_id');
				$result = $this->News_model->news_update($data);
				if($result){
					$this->file_update();
					echo json_encode(array('msg'=>'operation successfull.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'something wrong.','status'=>500));
				}
			}
			else{
				if($this->ion_auth->is_admin()){
					$result = $this->News_model->news_create($data);
					if(count($result) > 0){
						$this->file_update();
						echo json_encode(array('data'=>$result,'msg'=>'news created successfully.','status'=>200));
					}
					else{
						echo json_encode(array('msg'=>'news not created successfully.','status'=>500));
					}
				}
				else{
					echo json_encode(array('msg'=>'You dont have permission.','status'=>500));
				}
			}
		}
	}
	
	
	function get_news_content(){
		$data['news_id'] = (int) $this->input->post('n_id');
		$data['lang_id'] = (int) $this->session->userdata('language');
		$data['ip'] = $this->input->ip_address();
		$data['updated_at'] = date('d-m-y h:i:s');
		$data['updated_by'] = (int) $this->session->userdata('user_id');
		
		$result = $this->News_model->get_news_content($data);
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'news content.','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'no record found.','status'=>200));
		}
	}
	
	function news_publish(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('n_id', 'News Id', 'required|trim|integer|is_natural_no_zero');
			$this->form_validation->set_rules('status', 'News Status', 'required|trim');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$data['n_id'] = (int)$this->input->post('n_id');
				$data['status'] = $this->input->post('status');
				if($data['status'] == 'true'){
					$data['status'] = 1;
				}
				else{
					$data['status'] = 0;
				}
				
				$result = $this->News_model->news_publish($data);
				if($result){
					$this->file_update();
					echo json_encode(array('msg'=>'operation successfull.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'something wrong.','status'=>500));
				}
			}
		}
		else{
			echo json_encode(array('msg'=>'you are not authorized.','status'=>500));
		}
	}
	
	function news_delete(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('n_id', 'News Id', 'required|trim|integer|is_natural_no_zero');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$data['n_id'] = $this->input->post('n_id');
				$result = $this->News_model->news_delete($data);
				if($result){
					$this->file_update();
					echo json_encode(array('msg'=>'operation successfull.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'something wrong.','status'=>500));
				}
			}
		}
		else{
			echo json_encode(array('msg'=>'you are not authorized.','status'=>500));
		}
	}
}
