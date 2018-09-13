<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','ion_auth','form_validation'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Users_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	public function index(){
		$data['title'] = 'eNam Admin';
		$data['users_lang'] = $this->Users_model->get_all_lang_users();
		$data['users'] = $this->Users_model->get_all_users();

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
		$data['main_contant'] = $this->load->view('admin/pages/master/users',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function get_user_language(){
		$u_id = $this->input->post('id');
		$result = $this->Users_model->get_user_language($u_id);
		if(count($result) > 0){
			echo json_encode(array('data'=>$result,'msg'=>'Record found.','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}
	
	function user_language_update(){
		$data['u_id'] = (int) $this->input->post('u_id');
		$data['lang_id'] = (int) $this->input->post('l_id');
		$data['updated_at'] = date('d-m-y h:i:s');
		$data['ip'] = $this->input->ip_address();
		$data['user_id'] = (int) $this->session->userdata('user_id');
		$result = $this->Users_model->user_language_update($data);
		if($result){
			if($this->lang->line('user_update_success')){
				$msg  = $this->lang->line('user_update_success');
			}
			else{
				$msg = 'User update successfully.';
			}
			echo json_encode(array('data'=>$result,'msg'=>$msg,'status'=>200));
		}
		else{
			if($this->lang->line('user_update_failed')){
				$msg  = $this->lang->line('user_update_failed');
			}
			else{
				$msg = 'User update failed.';
			}
			echo json_encode(array('msg'=>$msg,'status'=>500));
		}
	}
	
	function user_language_delete(){
		$data['user_id'] = $this->input->post('u_id');
		$data['updated_at'] = date('d-m-y h:i:s');
		$data['ip'] = $this->input->ip_address();
		$data['updated_by'] = (int) $this->session->userdata('user_id');
		$result = $this->Users_model->user_language_delete($data);
		if($result){
			if($this->lang->line('user_delete_success')){
				$msg  = $this->lang->line('user_delete_success');
			}
			else{
				$msg = 'User created failed.';
			}
			echo json_encode(array('data'=>$result,'msg'=>$msg,'status'=>200));
		}
		else{
			if($this->lang->line('user_delete_failed')){
				$msg  = $this->lang->line('user_delete_failed');
			}
			else{
				$msg = 'User created failed.';
			}
			echo json_encode(array('msg'=>$msg,'status'=>500));
		}
	}
	
	function user_language_create(){
		$data['user_id'] = (int) $this->input->post('u_id');
		$data['lang_id'] = (int) $this->input->post('l_id');
		$data['created_at'] = date('d-m-y h:i:s');
		$data['ip'] = $this->input->ip_address();
		$data['updated_by'] = (int) $this->session->userdata('user_id');
		$result = $this->Users_model->user_language_create($data);
		if(count($result) == 1){
			if($this->lang->line('user_create_success')){
				$msg  = $this->lang->line('user_create_success');
			}
			else{
				$msg = 'User created successfully.';
			}
			echo json_encode(array('data'=>$result,'msg'=>$msg,'status'=>200));
		}
		else{
			if($this->lang->line('user_create_failed')){
				$msg  = $this->lang->line('user_create_failed');
			}
			else{
				$msg = 'User created failed.';
			}
			echo json_encode(array('msg'=>$msg,'status'=>500));			
		}
	}
	
	function create_user(){
		if($this->ion_auth->is_admin()){
			$identity = $this->input->post('email');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$additional_data = array(
					'first_name' => $this->input->post('fname'),
					'last_name' => $this->input->post('lname'),
					'phone' => $this->input->post('u_contact'),
					'language' => $this->input->post('u_lang')
			);
			
			$result = $this->ion_auth->register($identity, $password, $email, $additional_data);
			if($result){
				echo json_encode(array('msg'=>'User created successfully.','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'Error occured.','status'=>500));
			}	
		}
		else{
			echo json_encode(array('msg'=>'You are not authorized.','status'=>500));
		}
	}
	
	function user_detail(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('u_id', 'User id', 'required|trim|integer|is_natural_no_zero');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$user_id = $this->input->post('u_id');
				$this->db->select('id,first_name,last_name,email,phone,language');
				$result = $this->db->get_where('users',array('active'=>1,'id'=>$user_id))->result_array();
				if(count($result)>0){
					echo json_encode(array('data'=>$result,'msg'=>'user detail.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'No record found.','status'=>500));
				}
			}
		}
		else{
			echo json_encode(array('msg'=>'You are not authorized.','status'=>500));
		}
	}
	
	function update_user(){
		if($this->ion_auth->is_admin()){
			$this->form_validation->set_rules('u_id', 'user id', 'required|trim|integer|is_natural_no_zero');
			$this->form_validation->set_rules('u_lang', 'user language', 'required|trim|integer|is_natural_no_zero');
			$this->form_validation->set_rules('fname', 'First Name', 'required|trim|min_length[3]');
			$this->form_validation->set_rules('lname', 'Last Name', 'required|trim|min_length[3]');
			$this->form_validation->set_rules('u_contact', 'contact number', 'required|trim|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('email', 'Email id', 'required|trim|valid_email');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('message',validation_errors());
				echo validation_errors();
			}
			else{
				$id = (int)$this->input->post('u_id');
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$email = $this->input->post('email');
				$phone = $this->input->post('u_contact');
				$language = (int)$this->input->post('u_lang');
					
				$this->db->where('id',$id);
				$this->db->update('users',array(
						'first_name' => $fname,
						'last_name' => $lname,
						'phone' => $phone,
						'email' => $email,
						'language' => $language
				));
					
				//////////update log table
				$this->db->insert('logg',array(
						'user_id' => $this->session->userdata('user_id'),
						'event_id' => 7,
						'created_at' => date('y-m-d h:i:s'),
						'remark' => $id
				));
					
				if($this->db->affected_rows()){
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						return false;
					}
					else {
						$this->db->trans_commit();
						$file = FCPATH . '/software_files/Logg.txt';
						$msg = date('d-m-y h:i:s').' || user '.$this->session->userdata('identity').' Update user detail user id => '.$id.PHP_EOL;
						file_put_contents ($file, $msg,FILE_APPEND);
						
						echo json_encode(array('msg'=>'User updated successfully.','status'=>200));
					}
				}
				else{
					echo json_encode(array('msg'=>'You are not authorized.','status'=>500));
				}
			}
		}
	}
	
	function mail_sent(){
		$this->load->library('email');
		$this->email->from('sinha.rahulsinha.sinha@gmail.com', 'rahul');
		$this->email->to($this->input->post('mail_id'));
		$this->email->subject('Email subject');
		$this->email->message($this->input->post('mail_body'));
		 
		//Send mail
		if($this->email->send())
			echo "sent";
		else
			echo "failed";
			
	}
	
	function get_notification(){
		$result = $this->Users_model->get_notification();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'User notinications.','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}
	
	function notification_show(){
		$data['act_id'] = $this->input->post('act_id');
		$data['u_id'] = $this->session->userdata('user_id');
		$result = $this->Users_model->notification_show($data);
		
	}
}
