<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	private $currentMonth;
	private $currentYear;

	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		$this->load->model('DashboardModel');
		$this->currentMonth = date('m');
		$this->currentYear = date('Y-m');
	}
	public function index()
	{
		$data['months'] = month();
		$data['current_month'] = $this->currentMonth;
		$data['countData'] = $this->DashboardModel->countUnitsAndCashFlows($this->currentMonth);
		$content = $this->load->view('admin/dashboard', $data, TRUE);
		$this->template->load('', $content);
	}

	public function getChartData()
	{
		return $this->DashboardModel->chartTransaksi($this->currentMonth);
	}
	public function getChartTransaksi()
	{
		return $this->DashboardModel->chartDay($this->currentMonth, $this->currentYear);
	}
}
