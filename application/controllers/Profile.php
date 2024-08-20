<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
	private $auth;
	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		$this->load->model('DashboardModel');
		$this->auth = $this->session->userdata('auth_login');
	}
	public function index()
	{
		$data['auth'] = $this->auth;
		$data['countData'] = $this->DashboardModel->countUnitsAndCashFlows();
		$content = $this->load->view('admin/profile', $data, TRUE);
		$this->template->load('', $content);
	}

	public function getChartData()
	{
		return $this->DashboardModel->chartTransaksi();
	}
	public function getChartTransaksi()
	{
		return $this->DashboardModel->chartDay();
	}
}
