<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enam_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Users_model','admin/Video_model','admin/Slider_model','admin/Widget_model','admin/Menu_model','Enam_model','admin/Event_model'));
		$this->load->library(array('session','substring','lang_file'));
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

	//public function index(){
          //echo "under construction"; die;
        //}

	public function index(){	
// 		$this->load->library('guzzle');
// 		$client     = new GuzzleHttp\Client();
// 		$url        = 'http://enam.gov.in/NamWebSrv/rest/mobile/getEnrolledMandis';
// 		try {
// 			# guzzle post request example with form parameter
// 			$response = $client->request( 'POST',$url);
// 			#guzzle repose for future use
// 			//echo $response->getStatusCode(); // 200
// 			//echo $response->getReasonPhrase(); // OK
// 			//echo $response->getProtocolVersion(); // 1.1
// 			header("Content-Type: application/json; charset=UTF-8");
// 			$responseBodyAsString = $response->getBody();
// 			$obj = json_decode($responseBodyAsString, true);
// 			foreach($obj['listEnrolledMandis'] as $mandi){
// 				print_r($mandi); die;
// 			}
			
// 		} catch (GuzzleHttp\Exception\BadResponseException $e) {
// 			#guzzle repose for future use
// 			$response = $e->getResponse();
// 			$responseBodyAsString = $response->getBody()->getContents();
// 			print_r($responseBodyAsString);
// 		}
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
//print_r($data['videos']); die;

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
		//$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['slider'] = $this->load->view('pages/comman/slider',$data,TRUE);
		$data['links'] = $this->Enam_model->all_links();
		//$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['main_contant'] = $this->load->view('pages/dashboard',$data,TRUE);
		$this->load->view('comman/index',$data);
	}

	public function layout_page(){
		$data['title'] = 'eNam';
		$data['head'] = $this->load->view('comman/head','',TRUE);

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
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['slider'] = $this->load->view('pages/comman/slider','',TRUE);
		$data['links'] = $this->Enam_model->all_links();
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks',$data,TRUE);
		$data['newses'] = $this->Enam_model->all_news();
		$data['home_notice'] = $this->load->view('comman/home_notice',$data,TRUE);
		$data['events'] = $this->Event_model->home_list_events();
		//print_r($this->session->all_userdata()); die;
		$data['main_contant'] = $this->load->view('pages/layout-page',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	/*Register*/
	public function register()
	{
		$data['title'] = 'Registration';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/register/register',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	/*state_unified_license*/
	public function state_unified_license()
	{
		$data['title'] = 'State Unified License';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		//$data['header'] = $this->load->view('comman/header','',TRUE);
		//$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		//$data['footer'] = $this->load->view('comman/footer','',TRUE);
		//$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		//$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['main_contant'] = $this->load->view('pages/state_licence/state_unified_license',$data,TRUE);
		$this->load->view('comman/index',$data);
	}


	/*About us Section*/
	public function about_us()
	{
		$data['title'] = 'About Us';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/nam/about-nam',$data,TRUE);
		$this->load->view('comman/index',$data);
	}

	public function implementation_progress()
	{
		$data['title'] = 'Implementation Progress';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/nam/implementation-progress',$data,TRUE);
		$this->load->view('comman/index',$data);
	}

	public function key_stakeholders()
	{
		$data['title'] = 'Key Stakeholders';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/nam/key-stakeholders',$data,TRUE);
		$this->load->view('comman/index',$data);
	}

	public function usefull_links()
	{
		$data['title'] = 'Usefull Links';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/nam/usefull-links',$data,TRUE);
		$this->load->view('comman/index',$data);
	}

	/*Farmer */

	public function approved_commodities()
	{
		$data['title'] = 'Approved Commodities';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/farmer/approved-commodities',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	public function commodity_quality_parameters()
	{
		$data['title'] = 'Commodity Quality Parameters';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/farmer/commodity-quality-parameters',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	public function enrolled_mandis()
	{
		$data['title'] = 'Enrolled Mandis';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/farmer/enrolled-mandis',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	
	
	
	public function contact_us()
	{
		$data['title'] = 'CONTACT US';
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
		$data['main_contant'] = $this->load->view('pages/contactus/contact-us',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	

	/*traders*/

	public function commodity_price()
	{
		$data['title'] = 'Commodity Price';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/trader/commodity-price',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	public function manuals_guides()
	{
		$data['title'] = 'Manuals Guides';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/trader/manuals-guides',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	public function unified_license_guidelines()
	{
		$data['title'] = 'Unified License Guidelines';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/trader/unified-license-guidelines',$data,TRUE);
		$this->load->view('comman/index',$data);
	}

	public function event_gallary()
	{
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
		$data['main_contant'] = $this->load->view('pages/event_gallary/gallaries',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	
	public function emandi()
	{
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
		$data['main_contant'] = $this->load->view('pages/mandi/emandi',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	public function event_detail()
	{
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
		$data['main_contant'] = $this->load->view('pages/event_gallary/gallary',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	

	/*elearning*/
	public function elearning()
	{
		$data['title'] = 'eLearning';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/elearning/elearning',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	/*contact us*/
	// public function contact_us()
	// {
		// $data['title'] = 'Contact Us';
		// $data['head'] = $this->load->view('comman/head','',TRUE);
		// $data['header'] = $this->load->view('comman/header','',TRUE);
		// $data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		// $data['footer'] = $this->load->view('comman/footer','',TRUE);
		// $data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		// $data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		// $data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		// $data['main_contant'] = $this->load->view('pages/contactus/contact-us',$data,TRUE);
		// $this->load->view('comman/index',$data);
	// }
	public function feedback()
	{
		$data['title'] = 'Feedback';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/contactus/feedback',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	public function faq()
	{
		$data['title'] = 'FAQ';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/contactus/faq',$data,TRUE);
		$this->load->view('comman/index',$data);
	}

	/*download*/
	public function download()
	{
		$data['title'] = 'Download';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/download/download',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	/*Logistic Details*/
	public function logistic_details()
	{
		$data['title'] = 'Logistic Details';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		//$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/logistic/logistic-details',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	/*Training Calender*/
	public function training_calender()
	{
		$data['title'] = 'Training Calender';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		$data['header'] = $this->load->view('comman/header','',TRUE);
		$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		//$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/training-calender/training-calender',$data,TRUE);
		$this->load->view('comman/index',$data);
	}

	public function training_calender1()
	{
		$data['title'] = 'Training Calender1';
		$data['head'] = $this->load->view('comman/head','',TRUE);
		//$data['header'] = $this->load->view('comman/header','',TRUE);
		//$data['navigation'] = $this->load->view('comman/navigation','',TRUE);
		$data['footer'] = $this->load->view('comman/footer','',TRUE);
		//$data['quickLinks'] = $this->load->view('pages/comman/quickLinks','',TRUE);
		//$data['marqueeSection'] = $this->load->view('pages/comman/marqueeSection','',TRUE);
		$data['banner'] = $this->load->view('pages/comman/banner','',TRUE);
		$data['main_contant'] = $this->load->view('pages/training-calender/training-calender1',$data,TRUE);
		$this->load->view('comman/index',$data);
	}
	
	

	function rahul_test(){
		$file = FCPATH . '/software_files/rahul.txt';
		$json = $this->input->post('t_body');		
		file_put_contents ($file, $json);
	}

		function time_elapsed_string($time) {
		$time_difference = time() - $time;
		if( $time_difference < 1 ) { return 'less than 1 second ago'; }
		$condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
				30 * 24 * 60 * 60       =>  'month',
				24 * 60 * 60            =>  'day',
				60 * 60                 =>  'hour',
				60                      =>  'minute',
				1                       =>  'second'
		);
		
		foreach( $condition as $secs => $str )
		{
			$d = $time_difference / $secs;
			if( $d >= 1 )
			{
				$t = round( $d );
				return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
			}
		}
	}

    function ip(){  
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
        $ip = $_SERVER['REMOTE_ADDR'];
      }

      $json = file_get_contents("http://ipinfo.io/".$ip."/geo");
      $details = json_decode($json, true);
      print_r($details);
    }
}
