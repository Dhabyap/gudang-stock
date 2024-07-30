<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('UnitModel');
	}

	public function index()
	{
		$content = $this->load->view('admin/unit', [], TRUE);
		$this->template->load('', $content);

	}

	function insert()
	{
		return $this->UnitModel->insert();
	}

	function detail($id)
	{
		$id = decrypt($id);
		echo $this->UnitModel->detail($id);

	}
	function delete($id)
	{
		$id = decrypt($id);
		echo $this->UnitModel->delete($id);

	}

	public function datatables()
	{
		$this->load->library('datatables');

		$this->datatables->select('*, id');
		$this->datatables->from('unit');
		$this->datatables->where("isDelete = '0'", NULL, FALSE);

		$this->datatables->edit_column('id', '$1', 'encrypt(id)');
		echo $this->datatables->generate();
		exit;
	}
}
