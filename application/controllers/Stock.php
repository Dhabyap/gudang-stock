<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$content = $this->load->view('admin/stock', [], TRUE);
		$this->template->load2('', $content);

	}

	public function datatables()
	{
		$this->load->library('datatables');
		$this->datatables->select('*,id ,name');
		$this->datatables->from('stock');
		echo $this->datatables->generate();
		exit;
	}
}
