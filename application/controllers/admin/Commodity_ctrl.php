<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commodity_ctrl extends CI_Controller {

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
	
	function index(){
		$this->db->select('*');
		$this->db->group_by('c_id,commodity_name');
		$data['commodities'] = $this->db->get_where('commodity',array('status'=>1))->result_array();
		
		
		$data['title'] = 'eNam Admin';
		$languages = json_decode(file_get_contents(FCPATH . '/software_files/Language.txt'),true);
		foreach($languages as $language){
			if($language['l_id'] == $this->session->userdata('language'))
				$data['language'] = $language;
		}
		
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/commodity/commodity',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function commodity_detail(){
		$l_id = $this->session->userdata('language');
		$c_id = $this->input->post('c_id');
		$this->db->select('*');
		$result = $this->db->get_where('commodity',array('c_id'=>$c_id,'status'=>1))->result_array();
		
		$this->db->select('*');
		$result1 = $this->db->get_where('commodity_parameters',array('comm_id'=>$result[0]['commodity_id'],'lang_id'=>$l_id,'status'=>1))->result_array();
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'data2'=>$result1,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function commodity_update(){
		$l_id = $this->session->userdata('language');
		$data1['comm_id'] = $this->input->post('commodity_id');
		$data['comm_title'] = $this->input->post('commodity_parameter_title');
		$data['comm_desc'] = $this->input->post('commodity_parameter_content');
		$data['comm_name'] = $this->input->post('commodity_name');
		
		if(!empty($_FILES['commodity_image_select']['name'])){
			$file_name = $_FILES['commodity_image_select']['name'];
			$comm_image = addslashes(preg_replace('/\s+/', '_', $data1['comm_id']));
			$x = explode('.',$file_name);
			$_FILES['commodity_image_select']['name'] = $comm_image.'.'.end($x);
			$_FILES['commodity_image_select']['type'] = $_FILES['commodity_image_select']['type'];
			$_FILES['commodity_image_select']['tmp_name'] = $_FILES['commodity_image_select']['tmp_name'];
			$_FILES['commodity_image_select']['error'] = $_FILES['commodity_image_select']['error'];
			$_FILES['commodity_image_select']['size'] = $_FILES['commodity_image_select']['size'];
			
			$uploadPath = 'assest/images/commodity-pro/';
			$config['overwrite'] = true;
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPEG';
			
			$this->load->library('image_lib');
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			if($this->upload->do_upload('commodity_image_select')){
				$upload_data = $this->upload->data();
				$data1['image'] = $upload_data['file_name'];
				
				$this->db->trans_begin();
				
				$this->db->where(array('commodity_id'=>$data1['comm_id'],'status'=>1));
				$this->db->update('commodity',array(
						'image' => $data1['image'] 
				));
				$this->db->select('*');
				$result = $this->db->get_where('commodity_parameters',array('comm_id'=>$data1['comm_id'],'lang_id'=>$l_id))->result_array();
				if(count($result)>0){
					$this->db->where(array('comm_id'=>$data1['comm_id'],'lang_id'=>$l_id));
					$this->db->update('commodity_parameters',$data);
					
					if ($this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
						echo json_encode(array('msg'=>'commodity parameter update un-successfully.','status'=>200));
					}
					else{
						$this->db->trans_commit();
						echo json_encode(array('msg'=>'commodity parameter update successfully.','status'=>200));
					}
				}
				else{
					$this->db->insert('commodity_parameters',array(
							'comm_id' => $data1['comm_id'],
							'comm_title' => $data['comm_title'],
							'comm_desc' => $data['comm_desc'],
							'comm_name' => $data['commodity_name'],
							'lang_id' => $l_id
					));
					
					if ($this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
						echo json_encode(array('msg'=>'commodity parameter insert un-successfully.','status'=>500));
					}
					else{
						$this->db->trans_commit();
						echo json_encode(array('msg'=>'commodity parameter insert successfully.','status'=>200));
					}
				}
			}
			else{
				$error = array('error' => $this->upload->display_errors());
				print_r($error); die;
			}
		}
		else{
			$this->db->select('*');
			$result = $this->db->get_where('commodity_parameters',array('comm_id'=>$data1['comm_id'],'lang_id'=>$l_id))->result_array();
			if(count($result)>0){
				$this->db->where(array('comm_id'=>$data1['comm_id'],'lang_id'=>$l_id));
				$this->db->update('commodity_parameters',$data);
				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					echo json_encode(array('msg'=>'commodity parameter update un-successfully.','status'=>500));
				}
				else{
					$this->db->trans_commit();
					echo json_encode(array('msg'=>'commodity parameter update successfully.','status'=>200));
				}
			}
			else{
				$this->db->insert('commodity_parameters',array(
						'comm_id' => $data1['comm_id'],
						'comm_title' => $data['comm_title'],
						'comm_desc' => $data['comm_desc'],
						'comm_name' => $data['commodity_name'],
						'lang_id' => $l_id
				));
				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					echo json_encode(array('msg'=>'commodity parameter insert un-successfully.','status'=>500));
				}
				else{
					$this->db->trans_commit();
					echo json_encode(array('msg'=>'commodity parameter insert successfully.','status'=>200));
				}
			}
		}
	}
	
}