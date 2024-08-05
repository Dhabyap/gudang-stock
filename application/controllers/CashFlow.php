<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CashFlow extends CI_Controller
{
	private $auth;

	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		$this->load->model('CashFlowModel');
		$this->auth = $this->session->userdata('auth_login');
	}

	public function index()
	{
		$data['auth'] = $this->auth;
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
		$auth_login = $this->session->userdata('auth_login');

		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$tipe = $this->input->get('tipe_filter');
		$waktu = $this->input->get('waktu_filter');
		$unit = $this->input->get('unit_filter');

		$this->datatables->select('a.*, a.jumlah, a.tanggal, a.id, b.name as name_unit');
		$this->datatables->from('cash_flow a');
		$this->datatables->join('unit b', 'a.unit = b.id', 'left');

		$this->datatables->where("a.isDelete = '0'", NULL, FALSE);

		if (!empty($start_date) && !empty($end_date)) {
			$this->datatables->where("DATE(a.tanggal) BETWEEN '$start_date' AND '$end_date'", NULL, FALSE);
		}
		if (!empty($tipe)) {
			$this->datatables->where("a.tipe = '$tipe'", NULL, FALSE);
		}
		if (!empty($waktu)) {
			$this->datatables->where("a.waktu = '$waktu'", NULL, FALSE);
		}
		if (!empty($unit)) {
			$this->datatables->where("a.unit = '$unit'", NULL, FALSE);
		}

		if ($auth_login['level_id'] == 2) {
			$this->datatables->where("a.akun_id = " . $auth_login['id'] . "", NULL, FALSE);
		}

		if ($auth_login['level_id'] == 3) {
			$this->datatables->where("a.akun_id = " . $auth_login['id_akun'] . "", NULL, FALSE);
		}

		$this->datatables->edit_column('id', '$1', 'encrypt(id)');

		echo $this->datatables->generate();
		exit;
	}
}
