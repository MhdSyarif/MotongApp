<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	// public function index()
	// {
	// 	$this->load->view('welcome_message');
	// }
	var $content = "";
	public function __construct()
	{
		parent::__construct();
		$this->load->library('parser');

	}

	function index()
	{ 
		if($this->session->userdata('id')):
			if($this->content==""):
				$this->content = $this->load->view('content','',true);
				$data = array('header' => $this->load->view('templates/header','', true),
							'navbar-top' => $this->load->view('templates/navbar-top','', true),
							'sidebar' => $this->load->view('templates/sidebar','', true),
							'content' => $this->content,
							'footer' => $this->load->view('templates/footer','', true));
				$this->parser->parse('index', $data);
			endif;
		else : 
			redirect(site_url());
		endif;
	}
}