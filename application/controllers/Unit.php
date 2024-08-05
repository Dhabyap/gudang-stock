<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends CI_Controller
{
	private $auth;

	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		$this->load->model('UnitModel');
		$this->auth = $this->session->userdata('auth_login');
	}

	public function index()
	{
		$data['auth'] = $this->auth;
		$content = $this->load->view('admin/unit', $data, TRUE);
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
		$auth_login = $this->session->userdata('auth_login');

		$this->datatables->select('*, id');
		$this->datatables->from('unit');
		$this->datatables->where("isDelete = '0'", NULL, FALSE);

		if ($auth_login['level_id'] == 2) {
			$this->datatables->where("akun_id = " . $auth_login['id'] . "", NULL, FALSE);
		}

		if ($auth_login['level_id'] == 3) {
			$this->datatables->where("akun_id = " . $auth_login['id_akun'] . "", NULL, FALSE);
		}

		$this->datatables->edit_column('id', '$1', 'encrypt(id)');
		echo $this->datatables->generate();
		exit;
	}
}
