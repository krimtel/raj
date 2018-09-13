<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Static_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','form_validation','ion_auth','upload'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/News_model','admin/Event_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	
	function file_update(){
		$data['events'] = $this->Event_model->Event_list();
		$json = json_encode($data['events']);
		$file = FCPATH . '/software_files/Event.txt';
		file_put_contents ($file, $json);
	}
	
	public function index(){
		$data['title'] = 'eNam Admin | Cms Pages';
		$languages = json_decode(file_get_contents(FCPATH . '/software_files/Language.txt'),true);
		foreach($languages as $language){
			if($language['l_id'] == $this->session->userdata('language'))
			$data['language'] = $language;
		}
		
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/static/static',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	function page_update(){
		$data['sp_id'] = $this->input->post('sp_id');
		$this->db->select('*');
		$result = $this->db->get_where('static_page_item',array('page_id'=>$data['sp_id']))->result_array();
		if(count($result) > 0){
			echo json_encode(array('data'=>$result,'status'=>200));			
		}
		else{
			echo json_encode(array('msg'=>'no record found.','status'=>500));
		}
	}
}
