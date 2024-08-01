<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('LoginModel');
	}

	public function index()
	{
		$this->load->view('admin/login', [], );
	}

	function insert()
	{
		return $this->LoginModel->check();
	}

	public function logout()
	{
		$this->checkLogin();
		$this->session->sess_destroy();
		redirect('login');
	}


	function detail($id)
	{
		$id = decrypt($id);
		echo $this->LoginModel->detail($id);

	}
	function delete($id)
	{
		$id = decrypt($id);
		echo $this->LoginModel->delete($id);

	}

}
