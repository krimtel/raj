<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','form_validation','ion_auth','upload'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/News_model','admin/Event_model','admin/Video_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}

	function file_update(){
		$data['videos'] = $this->Video_model->Video_list();
		$json = json_encode($data['videos']);
		$file = FCPATH . '/software_files/Video.txt';
		file_put_contents ($file, $json);
	}

	public function index(){
		$data['title'] = 'eNam Admin | Videos';
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
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Video.txt'),true);
		if(count($file_menu)){
			$data['videos'] = $file_menu;
		}
		else{
			$data['videos'] = $this->Video_model->Video_list();
			$json = json_encode($data['videos']);
			$file = FCPATH . '/software_files/Video.txt';
			file_put_contents ($file, $json);
		}
		$data['p_categories'] = $this->Video_model->get_cat_list();
		$data['head'] = $this->load->view('admin/comman/head',$data,TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/master/video',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function video_create(){
		$this->form_validation->set_rules('v_url', 'video url', 'required|trim');
		$this->form_validation->set_rules('v_title', 'video title', 'required|trim|min_length[3]');
		$this->form_validation->set_rules('v_desc', 'video desc', 'required|trim|min_length[3]');
		$this->form_validation->set_rules('v_order', 'video order', 'required|trim|integer|is_natural');
		$this->form_validation->set_rules('v_category', 'video category', 'required|integer|is_natural_no_zero');
		
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			echo validation_errors();
		}
		else{
		    $data['v_url'] = $this->input->post('v_url');
		    $data['v_title'] = $this->input->post('v_title');
		    $data['v_desc'] = $this->input->post('v_desc');
		    $data['v_id'] = (int)$this->input->post('v_id');
		    $data['v_order'] = (int)$this->input->post('v_order');
		    $data['category_id'] = $this->input->post('v_category');

		    $data['created_at'] = date("Y-m-d h:i:s");
		    $data['created_by'] = $this->session->userdata('user_id');
    		$result = $this->Video_model->video_create($data);
			if($result){
				$this->file_update();
				echo json_encode(array('msg'=>'Operation successfull.','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'Something wrong.','status'=>500));
			}
		}
	}



	function video_publish(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('v_id', 'video id', 'required|trim|integer|is_natural');
			$this->form_validation->set_rules('status', 'video status', 'required|trim');
			 
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$data['v_id'] = (int)$this->input->post('v_id');
				$data['status']= $this->input->post('status');
					
				if($data['status'] == 'true'){
					$data['status'] = 1;
				}
				else{
					$data['status'] = 0;
				}
				$result = $this->Video_model->video_publish($data);
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

	function video_delete(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('v_id', 'video id', 'required|trim|integer|is_natural');
			// $this->form_validation->set_rules('status', 'video status', 'required|trim');
			 
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$data['v_id'] = $this->input->post('v_id');
				$result = $this->Video_model->video_delete($data);
				if($result){
					$this->file_update();
					echo json_encode(array('msg'=>'Operation successfull.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'Something wrong.','status'=>500));
				}
			}
		}
	}
	function get_video_data(){
		$this->form_validation->set_rules('v_id', 'video id', 'required|trim|integer|is_natural');
		// $this->form_validation->set_rules('status', 'video status', 'required|trim');
	  
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			echo validation_errors();
		}
		else{
			$data['v_id'] = (int) $this->input->post('v_id');
			$data['lang_id'] = (int) $this->session->userdata('language');
			$data['ip'] = $this->input->ip_address();
			$data['updated_at'] = date('d-m-y h:i:s');
			$data['updated_by'] = (int) $this->session->userdata('user_id');
			$result = $this->Video_model->get_video_data($data);
			if(count($result)>0){
			 echo json_encode(array('data'=>$result,'msg'=>'News content.','status'=>200));
			}
			else{
			 echo json_encode(array('msg'=>'No record found.','status'=>500));
			}
		}
	}
	function update_video(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('v_id', 'video id', 'required|trim|integer|is_natural');
			$this->form_validation->set_rules('v_url', 'video url', 'required|trim');
			$this->form_validation->set_rules('v_title', 'video title', 'required|trim|min_length[3]');
			$this->form_validation->set_rules('v_desc', 'video desc', 'required|trim');
			$this->form_validation->set_rules('v_sort', 'video order', 'required|trim|integer|is_natural');
			$this->form_validation->set_rules('v_category', 'video category', 'required|integer|is_natural_no_zero');
		}
		else{
			$this->form_validation->set_rules('v_id', 'video id', 'required|trim|integer|is_natural');
			$this->form_validation->set_rules('v_title', 'video title', 'required|trim|min_length[3]');
			$this->form_validation->set_rules('v_desc', 'video desc', 'required|trim');
		}
	  
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			echo validation_errors();
		}
		else{
			$data['v_id'] = (int)$this->input->post('v_id');
			$data['lang_id'] = (int) $this->session->userdata('language');
			$data['updated_at'] = date('d-m-y h:i:s');
			$data['updated_by'] = (int) $this->session->userdata('user_id');
			$data['ip'] = $this->input->ip_address();
			$data['v_content'] = $this->input->post('v_desc');
			$data['sort'] = $this->input->post('v_sort');
			$data['v_url'] = $this->input->post('v_url');
			$data['v_title'] = $this->input->post('v_title');
			$data['category_id'] = $this->input->post('v_category');

			$result=$this->Video_model->video_update($data);
			if($result){
				$this->file_update();
				echo json_encode(array('msg'=>'Operation successfull.','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'Something wrong.','status'=>500));
			}
		}
	}

	function video_is_home(){
		$this->form_validation->set_rules('v_id', 'video id', 'required|trim|integer|is_natural');
		$this->form_validation->set_rules('status1', 'video status', 'required|trim');
	  
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			echo validation_errors();
		}
		else{
			$data['v_id'] =  (int)$this->input->post('v_id');
			$data['status1'] =      $this->input->post('status1');
			if($data['status1'] ==  'true'){
				$data['status1'] =   1;
			}
			else{
				$data['status1'] =  0;
			}
			$result=$this->Video_model->video_is_home($data);
			if($result){
				$this->file_update();
				echo json_encode(array('msg'=>'Operation successfull.','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'Something wrong.','status'=>500));
			}
		}
	}
	//////////////////////////////////////////////////////video category//////////////////////////////////////////////////////////////////////////
	function video_cat(){
		$data['title'] = 'eNam Admin';
		$data['p_categories'] = $this->Video_model->get_p_cat_list();
		$data['categories'] = $this->Video_model->category_list();

		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/master/video_cat',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}

	function category_create(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('v_category_name', 'Category name', 'required|trim|min_length[3]');
			$this->form_validation->set_rules('v_cat_id', 'Category id', 'trim|integer|is_natural');
			$this->form_validation->set_rules('v_category_parent_drop_down', 'Category parent category', 'required|trim|integer|is_natural');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$data['cat_id'] = $this->input->post('v_cat_id');
				if($data['cat_id'] == ''){
					///   new category create
					$data['category_name'] = $this->input->post('v_category_name');
					$data['p_id'] = $this->input->post('v_category_parent_drop_down');
					$data['created_at'] = date('y-m-d h:i:s');
					$data['created_by'] = $this->session->userdata('user_id');
					$data['ip'] = $this->input->ip_address();
					$result = $this->Video_model->category_create($data);
					if($result){
						echo json_encode(array('msg'=>'Video category created successfully.','status'=>200));
					}
					else{
						echo json_encode(array('msg'=>'Viedo category not created.','status'=>500));
					}
				}
				else{
					///  category update
					$data['category_name'] = $this->input->post('v_category_name');
					$data['p_id'] = $this->input->post('v_category_parent_drop_down');
					$data['updated_at'] = date('y-m-d h:i:s');
					$data['updated_by'] = $this->session->userdata('user_id');
					$data['ip'] = $this->input->ip_address();
					$result = $this->Video_model->category_update($data);
					if($result){
						echo json_encode(array('msg'=>'Video category updated successfully.','status'=>200));
					}
					else{
						echo json_encode(array('msg'=>'Viedo category not updated.','status'=>500));
					}
				}
			}
		}
		else{
			echo json_encode(array('msg'=>'You are not Authorized.','status'=>500));
		}
	}


	function category_detail(){
		$this->form_validation->set_rules('vc_id', 'category id', 'required|trim|integer|is_natural');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			echo validation_errors();
		}
		else{
			$data['v_id'] = $this->input->post('vc_id');
			$result = $this->Video_model->category_detail($data);
			if(count($result)>0){
			 echo json_encode(array('data'=>$result,'status'=>200));
			}
			else{
			 echo json_encode(array('status'=>500));
			}
		}
	}
}