<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Users_model','admin/Video_model','admin/Slider_model','admin/Widget_model','admin/Menu_model','Enam_model','Elearning_model','Event_model'));
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

	public function index($cat	='All'){
		$data['title'] = 'eNam|Events';
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
		
		$data['events_categories'] = $this->Event_model->event_cat_list();	
		$data['events'] = $this->Event_model->event_list($cat);
		
		$data['header'] = $this->load->view('comman/header',$data,TRUE);
		$data['menus'] = $this->Enam_model->all_menus();
		$data['navigation'] = $this->load->view('comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('pages/event_gallary/gallaries',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	function event_search_list(){
		$data['cat'] = $this->input->post('cat');
		$data['text'] = $this->input->post('text');
		$data['event_list'] = $this->Event_model->event_search_list($data);
		if(count($data['event_list'])>0){
			echo json_encode(array('data'=>$data['event_list'],'msg'=>'event list','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'no record found.','status'=>500));
		}
	}
	
	function video_detail($id){
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
		$data['videos'] = $this->Video_model->video_home_page_list();
	
		$v = array();
		foreach($data['videos'] as $ve){
			$temp = array();
			$temp = $ve;
			$temp['created_at'] = $this->time_elapsed_string(strtotime($ve['created_at']));
			$v[] = $temp;
		}
		$data['videos'] = $v;
	
		$data['home_body'] = $this->Widget_model->home_content();
		$data['newses'] = $this->Enam_model->all_news();
		$data['events'] = $this->Event_model->home_list_events();
		$data['links'] = $this->Enam_model->all_links();
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks',$data,TRUE);
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['slider'] = $this->load->view('pages/comman/slider',$data,TRUE);
		$data['links'] = $this->Enam_model->all_links();
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['main_contant'] = $this->load->view('pages/gallary/video_show',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
}
