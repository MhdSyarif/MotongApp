<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Login_act extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function login($login)
	{
		$query="SELECT id,nama,email FROM users WHERE email=".$this->db->escape($login['email'])." AND password=".$this->db->escape($login['password'])." ";

		$data=$this->db->query($query);
		if($data->num_rows() > 0):
			$datases = $data->row_array();
			$this->session->set_userdata($datases);
			return 1; 
		else :
			return 0; 
		endif;
		
	}
}