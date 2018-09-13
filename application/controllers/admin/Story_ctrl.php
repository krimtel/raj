<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Story_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','form_validation','ion_auth','upload','substring'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/News_model','admin/Event_model','admin/Story_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	function file_update(){
		$data['stories'] = $this->Story_model->story_list();
		$json = json_encode($data['stories']);
		$file = FCPATH . '/software_files/Stories.txt';
		file_put_contents ($file, $json);
		$this->file_update_client();
	}
	
	function file_update_client(){
		$data['stories'] = $this->Story_model->story_list_client();
		$json = json_encode($data['stories']);
		$file = FCPATH . '/software_files/Stories_client.txt';
		file_put_contents ($file, $json);
	}
	
	public function index(){
		$data['title'] = 'eNam Admin | Success Story';
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
		
		$file_menu = json_decode(file_get_contents(FCPATH .'/software_files/Stories.txt'),true);
		if(count($file_menu)){
			$data['Stories_client'] = $file_menu;
		}
		else{
			$data['Stories_client'] = $this->Story_model->story_list();
			$json = json_encode($data['Stories_client']);
			$file = FCPATH . '/software_files/Stories.txt';
			file_put_contents ($file, $json);
		}
		
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/stories/stories',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function story_create(){
		$this->form_validation->set_rules('story_id', 'Story id', 'trim|integer|is_natural_no_zero');
		$this->form_validation->set_rules('story_title', 'Story Title', 'required|trim|min_length[3]');
		$this->form_validation->set_rules('story_desc', 'Story Desc', 'required|trim|min_length[3]');
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('story_order', 'Story Order', 'required|trim|integer');
		}
	
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			echo validation_errors();
		}
		else{
			$data['sid'] = $this->input->post('story_id');
			$data['story_title'] = $this->input->post('story_title');
			$data['story_desc'] = $this->input->post('story_desc');
			if($this->ion_auth->is_admin()){
				$data['story_order'] = $this->input->post('story_order');
			}
			$data['created_at'] = date('Y-m-d h:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			$data['created_at'] = date('Y-m-d h:i:s');
			$data['created_by'] = $this->session->userdata('user_id');
			
			if($data['sid'] == ''){
				// story create
				if(!empty($_FILES['userFiles']['name'])){
					$file_name = $_FILES['userFiles']['name'];
					 
					$story_file = date('U');
					$x = explode('.',$file_name);
					$_FILES['userFile']['name'] = $story_file.'.'.end($x);
					$_FILES['userFile']['type'] = $_FILES['userFiles']['type'];
					$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'];
					$_FILES['userFile']['error'] = $_FILES['userFiles']['error'];
					$_FILES['userFile']['size'] = $_FILES['userFiles']['size'];
						
	
					if(is_dir('./assest/images/s-story/')){
						$uploadPath = './assest/images/s-story/';
					}
					else{
						mkdir('./assest/images/s-story/');
						$uploadPath = './assest/images/s-story/';
					}
					$config['overwrite'] = true;
					$config['upload_path'] = $uploadPath;
					$config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPEG';
	
					$this->load->library('image_lib');
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
	
					if($this->upload->do_upload('userFile')){
						$upload_data = $this->upload->data();
						$data['story_image'] = $upload_data['file_name'];
						$result = $this->Story_model->story_create($data);
						if($result){
							$this->file_update();
							echo json_encode(array('msg'=>'story created successfully.','status'=>200));
						}
						else{
							delete_files($uploadPath.$data['story_image']);
							echo json_encode(array('msg'=>'Something gone wrong.','status'=>500));
						}
					}
					else{
						$error = array('error' => $this->upload->display_errors());
						print_r($error); die;
					}
				}
			}
			else {
				// story update
				if(!empty($_FILES['userFiles']['name'])){
					$file_name = $_FILES['userFiles']['name'];
					
					$file_name = $_FILES['userFiles']['name'];
					
					$story_file = date('U');
					$x = explode('.',$file_name);
					$_FILES['userFile']['name'] = $story_file.'.'.end($x);
					$_FILES['userFile']['type'] = $_FILES['userFiles']['type'];
					$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'];
					$_FILES['userFile']['error'] = $_FILES['userFiles']['error'];
					$_FILES['userFile']['size'] = $_FILES['userFiles']['size'];
					
					if(is_dir('./assest/images/s-story/')){
						$uploadPath = './assest/images/s-story/';
					}
					else{
						mkdir('./assest/images/s-story/');
						$uploadPath = './assest/images/s-story/';
					}
						
					$config['overwrite'] = true;
					$config['upload_path'] = $uploadPath;
					$config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPEG';
	
					$this->load->library('image_lib');
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
	
					if($this->upload->do_upload('userFile')){
						$upload_data = $this->upload->data();		
						$data['story_image'] = $upload_data['file_name'];
						$result = $this->Story_model->story_update($data);
						if($result){
							$this->file_update();
							echo json_encode(array('msg'=>'Story update successfully.','status'=>200));
						}
						else{
							delete_files($uploadPath.$data['story_image']);
							echo json_encode(array('msg'=>'Something gone wrong.','status'=>500));
						}
					}
					else{
						$error = array('error' => $this->upload->display_errors());
						print_r($error); die;
					}
				}
				else{
					$result = $this->Story_model->story_update($data);
					if($result){
						$this->file_update();
						echo json_encode(array('msg'=>'story updated successfully.','status'=>200));
					}
					else{
						echo json_encode(array('msg'=>'Something gone wrong.','status'=>500));
					}
				}
			}
		}
	}
	
	function get_story_content(){
		$data['story_id'] = (int) $this->input->post('story_id');
		$data['lang_id'] = (int) $this->session->userdata('language');
		$data['ip'] = $this->input->ip_address();
		$data['updated_at'] = date('d-m-y h:i:s');
		$data['updated_by'] = (int) $this->session->userdata('user_id');
	
		$result = $this->Story_model->get_story_content($data);
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'Story content.','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'no record found.','status'=>500));
		}
	}
	
	function story_publish(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('story_id', 'story id', 'required|trim|integer|is_natural_no_zero');
			$this->form_validation->set_rules('status', 'Story Status', 'required|trim');
				
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$data['story_id'] = (int)$this->input->post('story_id');
				$data['status'] = $this->input->post('status');
				if($data['status'] == 'true'){
					$data['status'] = 1;
				}
				else{
					$data['status'] = 0;
				}
	
				$result = $this->Story_model->story_publish($data);
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
	
	function story_delete(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('story_id', 'Story Id', 'required|trim|integer|is_natural_no_zero');
				
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$data['story_id'] = (int)$this->input->post('story_id');
				$result = $this->Story_model->story_delete($data);
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