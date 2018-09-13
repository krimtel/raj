<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_ctrl extends CI_Controller {

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

	function apmc(){
		$data['title'] = 'eNam';
		$data['keywords'] = 'enam home';
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
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Slider_client.txt'),true);
		if(count($file_menu)){
			$data['sliders'] = $file_menu;
		}
		else{
			$data['sliders'] = $this->Slider_model->slider_list_client();
			$json = json_encode($data['sliders']);
			$file = FCPATH . '/software_files/Slider_client.txt';
			file_put_contents ($file, $json);
		}
		$data['home_body'] = $this->Widget_model->home_content();
		$data['newses'] = $this->Enam_model->all_news();
		$data['events'] = $this->Event_model->home_list_events();
		$data['links'] = $this->Enam_model->all_links();
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks',$data,TRUE);
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['slider'] = $this->load->view('pages/comman/slider',$data,TRUE);
		$data['links'] = $this->Enam_model->all_links();
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['main_contant'] = $this->load->view('pages/apmc/apmc_status',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	function commodity(){
		$data['title'] = 'eNam commodities';
		$data['keywords'] = 'enam commodities';
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
	
	
			
		$this->db->select('*');
		$this->db->group_by('commodity_id');
		$this->db->limit('12',0);
		$data['commodity_list'] = $this->db->get_where('commodity',array('status'=>1))->result_array();
	
		$this->db->select('count(distinct(commodity_id)) as total');
		$data['commodity_count'] = $this->db->get_where('commodity',array('status'=>1))->result_array();
	
		$data['header'] = $this->load->view('comman/header',$data,TRUE);
		$data['menus'] = $this->Enam_model->all_menus();
	
		$data['navigation'] = $this->load->view('comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('pages/commodity/commodity',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	function min_max_modal_prices(){
		$data['title'] = 'eNam';
		$data['keywords'] = 'enam home';
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
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Slider_client.txt'),true);
		if(count($file_menu)){
			$data['sliders'] = $file_menu;
		}
		else{
			$data['sliders'] = $this->Slider_model->slider_list_client();
			$json = json_encode($data['sliders']);
			$file = FCPATH . '/software_files/Slider_client.txt';
			file_put_contents ($file, $json);
		}
		$data['home_body'] = $this->Widget_model->home_content();
		$data['newses'] = $this->Enam_model->all_news();
		$data['events'] = $this->Event_model->home_list_events();
		$data['links'] = $this->Enam_model->all_links();
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks',$data,TRUE);
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['slider'] = $this->load->view('pages/comman/slider',$data,TRUE);
		$data['links'] = $this->Enam_model->all_links();
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['main_contant'] = $this->load->view('pages/min_max_model/min_max_model',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	function stakeholders_data(){
		$data['title'] = 'eNam';
		$data['keywords'] = 'enam home';
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
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		
		$file_menu = json_decode(file_get_contents(FCPATH . '/software_files/Slider_client.txt'),true);
		if(count($file_menu)){
			$data['sliders'] = $file_menu;
		}
		else{
			$data['sliders'] = $this->Slider_model->slider_list_client();
			$json = json_encode($data['sliders']);
			$file = FCPATH . '/software_files/Slider_client.txt';
			file_put_contents ($file, $json);
		}
		$data['home_body'] = $this->Widget_model->home_content();
		$data['newses'] = $this->Enam_model->all_news();
		$data['events'] = $this->Event_model->home_list_events();
		$data['links'] = $this->Enam_model->all_links();
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks',$data,TRUE);
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['slider'] = $this->load->view('pages/comman/slider',$data,TRUE);
		$data['links'] = $this->Enam_model->all_links();
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['main_contant'] = $this->load->view('pages/stack_holder/stack_holder',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	public function emandi(){
		$data['title'] = 'eNam mandis';
		$data['keywords'] = 'enam mandi';
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
		$data['newses'] = $this->Enam_model->all_news();
		$data['events'] = $this->Event_model->home_list_events();
		$data['links'] = $this->Enam_model->all_links();
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks',$data,TRUE);
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['slider'] = $this->load->view('pages/comman/slider',$data,TRUE);
		$data['links'] = $this->Enam_model->all_links();
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['main_contant'] = $this->load->view('pages/mandi/emandi',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	function commodity(){
		$data['title'] = 'eNam commodities';
		$data['keywords'] = 'enam commodities';
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
		
		
		 
		$this->db->select('*');
		$this->db->group_by('commodity_id');
		$this->db->limit('12',0);
		$data['commodity_list'] = $this->db->get_where('commodity',array('status'=>1))->result_array();
		
		$this->db->select('count(distinct(commodity_id)) as total');
		$data['commodity_count'] = $this->db->get_where('commodity',array('status'=>1))->result_array();
		
		$data['header'] = $this->load->view('comman/header',$data,TRUE);
		$data['menus'] = $this->Enam_model->all_menus();
		
		$data['navigation'] = $this->load->view('comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('pages/commodity/commodity',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	function commodity_limit($offset){
		$this->db->select('*');
		$this->db->group_by('commodity_id');
		$this->db->limit('12',$offset);
		return $result = $this->db->get_where('commodity',array('status'=>1))->result_array();
	}
}
