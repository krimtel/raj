<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training_ctrl extends CI_Controller {

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
		$data['main_contant'] = $this->load->view('admin/pages/training',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
}