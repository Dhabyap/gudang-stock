<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		$this->load->model('DashboardModel');

	}
	public function index()
	{
		$data['countData'] = $this->DashboardModel->countUnitsAndCashFlows();
		$content = $this->load->view('admin/dashboard', $data, TRUE);
		$this->template->load('', $content);
	}

	public function getChartData()
	{
		return $this->DashboardModel->chartTransaksi();
	}


}
