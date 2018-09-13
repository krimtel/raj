<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_profile_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','form_validation','ion_auth','upload'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/User_profile_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}

// 	function file_update(){
// 		$data['videos'] = $this->Video_model->Video_list();
// 		$json = json_encode($data['videos']);
// 		$file = FCPATH . '/software_files/Video.txt';
// 		file_put_contents ($file, $json);
// 	}
	
	public function profile($user_id = null){
		if( $_SESSION['user_id']!= null){
			$data['uid'] = $_SESSION['user_id'];
		}
		$data['u_detail']= $this->User_profile_model->user_data($data);
		$data['title'] = 'eNam Admin | User Profile';
		$data['head'] = $this->load->view('admin/comman/head',$data,TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/user_profile/profile_update',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	
	public function change_password($user_id = null){
		if( $_SESSION['user_id']!= null){
			$data['uid'] = $_SESSION['user_id'];
		}
		$data['u_detail']= $this->User_profile_model->user_data($data);
		$data['title'] = 'eNam Admin | User Profile';
		$data['head'] = $this->load->view('admin/comman/head',$data,TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/user_profile/change_password',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function profile_update(){
		
		$data['f_name'] = $this->input->post('f_name');
		$data['l_name'] = $this->input->post('l_name');
		$data['contact'] = $this->input->post('contact');
		$data['email'] = $this->input->post('email');
		$data['uid'] = $this->input->post('uid');
			if(!empty($_FILES['userFiles']['name'])){
				$file_name = $_FILES['userFiles']['name'];
				$f_name = addslashes(preg_replace('/\s+/', '_', $data['f_name']));
				$x = explode('.',$file_name);
				$_FILES['userFile']['name'] = $f_name.'.'.end($x);
				$_FILES['userFile']['type'] = $_FILES['userFiles']['type'];
				$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'];
				$_FILES['userFile']['error'] = $_FILES['userFiles']['error'];
				$_FILES['userFile']['size'] = $_FILES['userFiles']['size'];
		
				$uploadPath = 'User_gallary';
					
				$config['overwrite'] = true;
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPEG';
					
				$this->load->library('image_lib');
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
					
				if($this->upload->do_upload('userFile')){
					$upload_data = $this->upload->data();
					$data['user_image'] = $upload_data['file_name'];	
					
					//print_r($data['user_image']); die;
					$this->session->set_userdata('photo',$data['user_image']);
					
				}
				else{
					$error = array('error' => $this->upload->display_errors());
					print_r($error); die;
				}
		}
		$result = $this->User_profile_model->profile_update($data);
		if($result){
			//$this->file_update();
			echo json_encode(array('msg'=>'Operation successfull.','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'Something wrong.','status'=>500));
		}
	}
			
}