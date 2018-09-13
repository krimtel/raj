<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stories_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Users_model','admin/Video_model','admin/Slider_model','admin/Widget_model','admin/Menu_model','Enam_model','admin/Event_model'));
		$this->load->library(array('session','substring'));
		if(!$this->session->userdata('client_language')){
			$newdata = array(
					'client_language'  => '1',
					'lang_folder' => 'english'
			);
			$this->session->set_userdata($newdata);
		}
		//////////////temp/////////////////////////
		if($this->session->userdata('client_language') == 1)
			$this->lang->load('client_lang', 'english');
			else
				$this->lang->load('client_lang', 'hindi');
	}
	
	public function index(){
		$l_id = $this->session->userdata('language');

		$this->db->select('*');
		$this->db->join('success_story_item ssi','ssi.	success_id = ss.s_id');
		$data['stories'] = $this->db->get_where('success_story ss',array('ss.status'=>1,'ssi.lang_id'=>$l_id,'ss.publish'=>1))->result_array();
		
		$data['title'] = 'Success Stories';
		$data['keywords'] = 'Success Stories';
		$data['head'] = $this->load->view('comman/head',$data,TRUE);
		
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
		
		$data['header'] = $this->load->view('comman/header',$data,TRUE);
		$data['menus'] = $this->Enam_model->all_menus();
		
		$data['navigation'] = $this->load->view('comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['home_body'] = $this->Widget_model->home_content();
		$data['slider'] = $this->load->view('pages/comman/slider',$data,TRUE);
		$data['links'] = $this->Enam_model->all_links();
		$data['main_contant'] = $this->load->view('pages/stories/stories',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
}
