<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
	private $auth;

	function __construct()
	{
		parent::__construct();
		$this->checkLogin();
		$this->auth = $this->session->userdata('auth_login');
	}

	public function index()
	{
		$data['months'] = month();
		$data['current_month'] = date('m');
		$data['auth'] = $this->auth;
		$content = $this->load->view('admin/report', $data, TRUE);
		$this->template->load('', $content);
	}

	public function detail($id)
	{
		$id = decrypt($id);

		$month_filter = $this->input->get('month_filter');
		if (isset($month_filter)) {
			$month = $month_filter;
		} else {
			$month = date('m');
		}

		$year_filter = $this->input->get('year_filter');
		if (isset($year_filter)) {
			$year = $year_filter;
		} else {
			$year = date('Y');
		}

		$yearMonth = "$year-$month";

		$where = '';
		if ($this->auth['level_id'] == 2) {
			$where = "AND a.akun_id = {$this->auth['id']} ";
		} elseif ($this->auth['level_id'] == 3) {
			$where = "AND a.akun_id = {$this->auth['id_akun']} ";
		}

		$baseQuery = "SELECT a.*, b.name FROM cash_flow a
                  LEFT JOIN unit b ON a.unit = b.id
                  WHERE a.isDelete = '0' $where";

		if ($id != 0) {
			$query = "$baseQuery AND a.unit = $id AND a.tanggal LIKE '%$yearMonth%' ORDER BY a.tanggal ASC";
		} else {
			$query = "$baseQuery AND a.unit = 0 AND a.tanggal LIKE '%$yearMonth%'ORDER BY a.tanggal ASC";
		}

		$data['reports'] = $this->db->query($query)->result();

		$content = $this->load->view('admin/detail_report', $data, TRUE);
		$this->template->load('', $content);
	}


	public function datatables()
	{
		$this->load->library('datatables');
		$auth_login = $this->auth;

		$month_filter = $this->input->get('month_filter');
		if (isset($month_filter)) {
			$month = $month_filter;
		} else {
			$month = date('m');
		}

		$year_filter = $this->input->get('year_filter');
		if (isset($year_filter)) {
			$year = $year_filter;
		} else {
			$year = date('Y');
		}

		$yearMonth = $year . '-' . $month;

		$this->datatables->select("b.name, b.type, b.id as id_unit,
        SUM(CASE WHEN a.tipe = 'masuk' THEN a.jumlah ELSE 0 END) AS total_masuk,
        SUM(CASE WHEN a.tipe = 'keluar' THEN a.jumlah ELSE 0 END) AS total_keluar");
		$this->datatables->from('cash_flow a');
		$this->datatables->join('unit b', 'a.unit = b.id', 'left');

		$this->datatables->where("a.isDelete = '0'", NULL, FALSE);

		if ($auth_login['level_id'] == 2) {
			$this->datatables->where("a.akun_id", $auth_login['id']);
		}
		if ($auth_login['level_id'] == 3) {
			$this->datatables->where("a.akun_id", $auth_login['id_akun']);
		}

		$this->datatables->where("a.tanggal LIKE '%" . $yearMonth . "%' ", NULL, FALSE);

		$this->db->group_by('a.unit');

		$this->datatables->edit_column('id_unit', '$1', 'encrypt(id_unit)');

		echo $this->datatables->generate();
		exit;
	}
}
