<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','form_validation','ion_auth','upload'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/News_model','admin/Page_model','admin/Users_model','admin/Event_model','admin/Video_model','admin/Slider_model'));
		$this->lang->load('admin_lang', 'english');
		if (!$this->ion_auth->logged_in()){
			redirect('admin/admin');
		}
	}
	public function index(){
		$data['title'] = 'eNam Admin';
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/login',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	function dashboard(){
		$data['title'] = 'eNam Admin';
		$l_id = $this->session->userdata('language'); 
		 
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
			if($language['l_id'] == $l_id){
				$data['language'] = $language; 
			}
		}
		
		
		$videos = json_decode(file_get_contents(FCPATH . '/software_files/Video_client.txt'),true);
		if(count($videos)){
			$data['videos'] = $videos;
		}
		else{
			$data['videos'] = $this->Video_model->video_home_page_list();
			$json = json_encode($data['videos']);
			$file = FCPATH . '/software_files/Video_client.txt';
			file_put_contents ($file, $json);
		}
		
		
		
		$slider = json_decode(file_get_contents(FCPATH . '/software_files/Slider_client.txt'),true);
		if(count($slider)){
			$data['sliders'] = $slider;
		}
		else{
			$data['sliders'] = $this->Slider_model->slider_list_client();
			$json = json_encode($data['sliders']);
			$file = FCPATH . '/software_files/Slider_client.txt';
			file_put_contents ($file, $json);
		}
		
		$news = json_decode(file_get_contents(FCPATH . '/software_files/News.txt'),true);
		if(count($news)){
			$data['newses'] = $news;
		}
		else{
			$data['newses'] = $this->News_model->news_list_dashboard();
			$json = json_encode($data['newses']);
			$file = FCPATH . '/software_files/News.txt';
			file_put_contents ($file, $json);
		}
		$data['pages'] = $this->Page_model->get_all_pages_dashboard();
		
		$events = json_decode(file_get_contents(FCPATH . '/software_files/Event.txt'),true);
		if(count($events)){
			$data['events'] = $events;
		}
		else{
			$data['events'] = $this->Event_model->event_list_dashboard();
			$json = json_encode($data['events']);
			$file = FCPATH . '/software_files/Event.txt';
			file_put_contents ($file, $json);
		}
		
		$languages = json_decode(file_get_contents(FCPATH . '/software_files/Language.txt'),true);
		if(count($languages)){
			$data['languages'] = $languages;
		}
		else{
			$data['languages'] = $this->Language_model->get_all_language();
			$json = json_encode($data['languages']);
			$file = FCPATH . '/software_files/Language.txt';
			file_put_contents ($file, $json);
		}
		
		$data['users'] = $result = $this->Users_model->get_all_users_dashboard();
		
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation',$data,TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/dashboard',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
	public function all_page()
	{
		$data['title'] = 'eNam Admin';
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/page/all-page',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	/*public function edit_page()
	{
		$data['title'] = 'eNam Admin';
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/page/edit',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}*/
	
	
	
	public function home_page()
	{
		$data['title'] = 'eNam Admin';
		$data['head'] = $this->load->view('admin/comman/head','',TRUE);
		$data['header'] = $this->load->view('admin/comman/header','',TRUE);
		$data['navigation'] = $this->load->view('admin/comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('admin/comman/footer','',TRUE);
		$data['main_contant'] = $this->load->view('admin/pages/layout/home_page',$data,TRUE);
		$this->load->view('admin/comman/index',$data);
	}
	
}
