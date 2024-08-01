<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
	}
	public function index()
	{
		$content = $this->load->view('admin/dashboard', [], TRUE);
		$this->template->load('', $content);

	}
}
