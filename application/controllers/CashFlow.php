<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CashFlow extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('CashFlowModel');
	}

	public function index()
	{
		$data['units'] = $this->CashFlowModel->getUnits();
		$content = $this->load->view('admin/cash_flow', $data, TRUE);
		$this->template->load('', $content);

	}

	function insert()
	{
		return $this->CashFlowModel->insert();
	}

	function detail($id)
	{
		$id = decrypt($id);
		echo $this->CashFlowModel->detail($id);

	}
	function delete($id)
	{
		$id = decrypt($id);
		echo $this->CashFlowModel->delete($id);

	}

	public function datatables()
	{
		$this->load->library('datatables');

		$this->datatables->select('a.*, a.jumlah, a.tanggal, a.id, b.name as name_unit');
		$this->datatables->from('cash_flow a');
		$this->datatables->join('unit b', 'a.unit = b.id', 'left');

		$this->datatables->where("a.isDelete = '0'", NULL, FALSE);
		$this->datatables->edit_column('jumlah', '$1', 'rupiah(jumlah)');
		$this->datatables->edit_column('id', '$1', 'encrypt(id)');
		echo $this->datatables->generate();
		exit;
	}
}
