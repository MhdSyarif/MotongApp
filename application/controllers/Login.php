<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('parser');

	}

	public function auth()
	{
		if($this->session->userdata('id')):
			$this->content = $this->load->view('content','',true);
			$data = array('header' => $this->load->view('templates/header','', true),
						'navbar-top' => $this->load->view('templates/navbar-top','', true),
						'sidebar' => $this->load->view('templates/sidebar','', true),
						'content' => $this->content,
						'footer' => $this->load->view('templates/footer','', true));
			$this->parser->parse('index', $data);
		else:
			$data = array('header' => $this->load->view('templates/header','', true),
						'footer' => $this->load->view('templates/footer','', true));
			$this->parser->parse('login', $data);	
		endif;
	}

	public function user_login()
	{ 
		$login = array(
			'email'=>$this->input->post('email'),
			'password'=>md5($this->input->post('password'))
		);
		$this->load->model('login_act');
		$result = $this->login_act->login($login);
		if($result):
			echo 1;
		else :
			echo 0;
		endif;
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url());
	}
}