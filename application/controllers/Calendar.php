<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->checkLogin();

	}
	public function index()
	{
		$data['months'] = month();
		$data['current_month'] = date('m');
		$content = $this->load->view('admin/calendar', $data, TRUE);
		$this->template->load('', $content);
	}

}
