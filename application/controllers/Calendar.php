<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		$this->load->model('CalendarModel');

	}
	public function index()
	{
		$data['months'] = month();
		$data['current_month'] = date('m');
		$content = $this->load->view('admin/calendar', $data, TRUE);
		$this->template->load('', $content);
	}

	function dataCalendar()
	{
		return $this->CalendarModel->dataCalendar();
	}

	public function getEventDetails()
	{
		$id = $this->input->post('id');
		return $this->CalendarModel->detailDataCalendar($id);
	}


}
