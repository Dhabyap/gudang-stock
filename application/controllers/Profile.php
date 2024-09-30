<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
	private $currentMonth;
	private $auth;
	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		$this->load->model('DashboardModel');
		$this->load->model('AccountModel');
		$this->auth = $this->session->userdata('auth_login');
		$this->currentMonth = date('m');
	}
	public function index()
	{
		$data['auth'] = $this->auth;
		$data['appartement'] = $this->AccountModel->getApparts()[0];
		$data['countData'] = $this->DashboardModel->countUnitsAndCashFlows($this->currentMonth);
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

	public function insert()
	{
		$post = $this->input->post();
		var_dump($post);die;
	}
}
