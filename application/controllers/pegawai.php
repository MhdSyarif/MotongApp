<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

	var $content = "";
	public function __construct()
	{
		parent::__construct();
		$this->load->library('parser');

	}

	public function index()
	{ 
		if($this->session->userdata('id')):
			if($this->content=="")
				$this->content = $this->load->view('pegawai','',true);
				$data = array('header' => $this->load->view('templates/header','', true),
							'navbar-top' => $this->load->view('templates/navbar-top','', true),
							'sidebar' => $this->load->view('templates/sidebar','', true),
							'content' => $this->content,
							'footer' => $this->load->view('templates/footer','', true));
				$this->parser->parse('index', $data);
		else : 
			redirect(site_url());
		endif;
	}
}
