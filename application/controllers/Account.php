<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{
	private $auth;
	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		$this->load->model('AccountModel');
		$this->auth = $this->session->userdata('auth_login');
	}

	public function index()
	{
		$data['appartements'] = $this->AccountModel->getApparts();
		$data['levels'] = $this->AccountModel->getLevels();
		$content = $this->load->view('admin/account', $data, TRUE);
		$this->template->load('', $content);
	}

	function insert()
	{
		return $this->AccountModel->insert();
	}

	function detail($id)
	{
		$id = decrypt($id);
		echo $this->AccountModel->detail($id);
	}
	function delete($id)
	{
		$id = decrypt($id);
		echo $this->AccountModel->delete($id);
	}

	public function datatables()
	{
		$this->load->library('datatables');

		$this->datatables->select('a.*, a.id');
		$this->datatables->from('akun a');

		$this->datatables->where("a.isDelete", '0');

		$this->applyUserLevelConditions($this->auth);

		$this->datatables->edit_column('id', '$1', 'encrypt(id)');
		echo $this->datatables->generate();
		exit;
	}

	private function applyUserLevelConditions($auth_login)
	{
		if ($auth_login['level_id'] == 2) {
			$this->datatables->where("a.id_akun", $auth_login['id']);
		}
	}
}
