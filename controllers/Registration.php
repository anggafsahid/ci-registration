<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {
	public function index($page = 'home')
	{	
		$this->load->helper('url');
		$this->load->database('shared');
		if ( ! file_exists(APPPATH.'views/registration/'.$page.'.php'))
        {
            show_404();
        }
        $this->output->delete_cache();
		$data['title'] = ucfirst($page);
		$this->load->view('registration/templates/header', $data);
		$this->load->view('registration/'.$page, $data);
		$this->load->view('registration/templates/footer', $data);
		$this->load->view('registration/css/kanjiFont');
		//SCRIPT AND CSS
		if ( file_exists(APPPATH.'views/registration/js/'.$page.'_js.php'))
		{
			$this->load->view('registration/js/'.$page.'_js');
		}
		if ( file_exists(APPPATH.'views/registration/css/'.$page.'_css.php'))
		{
			$this->load->view('registration/css/'.$page.'_css');
		}
	}
	public function ajax($page='home')
	{
		$this->load->helper('url');
		$this->load->database('shared');
		$this->load->view('registration/'.$page);
	}
	public function delete()
	{
		$this->load->database('shared');
		$this->load->view('registration/delete');
	}
	public function upload()
	{
		$this->load->helper('url');
		$this->load->database('shared');
		$this->load->view('registration/templates/header');
		$this->load->view('registration/uploadpage');
		$this->load->view('registration/templates/footer');
		$this->load->view('registration/css/kanjiFont');
	}
}
