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
		$this->db->select('*');
		$data['states'] = $this->db->get_where('training_state',array('status'=>1))->result_array();
		
		$data['head'] = $this->load->view('admin/comman/head',$data,TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/training',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function training_data_update(){
		$data['training_data_id'] = $this->input->post('training_data_id');
		$data['vendor_name'] = $this->input->post('vendor_name');
		$data['t_p_date'] = $this->input->post('t_p_date');
		$data['t_date'] = $this->input->post('t_date');
		$data['n_o_f_p'] = $this->input->post('n_o_f_p');
		$data['n_o_t_p'] = $this->input->post('n_o_t_p');
		$data['n_o_ca_p'] = $this->input->post('n_o_ca_p');
		$data['a_t_p'] = $this->input->post('a_t_p');
		$data['o_p'] = $this->input->post('o_p');
		$data['t_p'] = $this->input->post('t_p');
		$data['f_s'] = $this->input->post('f_s');
		
		$this->db->where('data_id',$data['training_data_id']);
		$this->db->update('training_data',array(
			'vendor' => $data['vendor_name'],
			'training_plan_date' => $data['t_p_date'],
			'training_date' => $data['t_date'],
			'no_of_farmer_participated' => $data['n_o_f_p'],
			'no_of_traders_participated' => $data['n_o_t_p'],
			'no_of_ca_participated' => $data['n_o_ca_p'],
			'apmc_staff_participated' => $data['a_t_p'],
			'other_participants' => $data['o_p'],
			'total_participants' => $data['t_p'],
			'feedback_score' => $data['f_s']
		));
                echo json_encode(array('status'=>200));
	}
} 