<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class DashboardModel extends CI_Model
{
    private $auth;
    function __construct()
    {
        parent::__construct();
        $this->auth = $this->session->userdata('auth_login');

    }

    function countUnitsAndCashFlows()
    {
        $where = "";
        if ($this->auth['level_id'] == 2) {
            $where = 'AND akun_id = ' . $this->auth['id'] . '';
        }

        if ($this->auth['level_id'] == 3) {
            $where = 'AND akun_id = ' . $this->auth['id_akun'] . '';
        }

        return $this->db->query(" SELECT
            (SELECT COUNT(*) FROM unit WHERE id IS NOT NULL " . $where . ") AS unit_count,
            (SELECT SUM(jumlah) FROM cash_flow WHERE tipe = 'masuk' " . $where . " AND DATE_FORMAT(tanggal, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m') AND isDelete = '0') AS cash_flow_masuk,
            (SELECT SUM(jumlah) FROM cash_flow WHERE tipe = 'keluar' " . $where . " AND DATE_FORMAT(tanggal, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m') AND isDelete = '0') AS cash_flow_keluar"
        )->row();
    }

    function chartTransaksi()
    {
        $where = "";

        if ($this->auth['level_id'] == 2) {
            $where = 'AND a.akun_id = ' . $this->auth['id'] . '';
        }

        if ($this->auth['level_id'] == 3) {
            $where = 'AND a.akun_id = ' . $this->auth['id_akun'] . '';
        }

        $result = $this->db->query("SELECT COUNT(a.id) as total, b.name FROM cash_flow a LEFT JOIN unit b ON a.unit = b.id WHERE a.unit != 0 " . $where . " AND a.isDelete = '0' AND a.tipe = 'masuk' AND MONTH(a.tanggal) = MONTH(CURDATE()) GROUP BY a.unit ORDER BY total ASC")->result();

        $series = [];
        $categories = [];

        foreach ($result as $row) {
            $series[] = (int) $row->total;
            $categories[] = $row->name;
        }

        $data = [
            'series' => $series,
            'categories' => $categories
        ];
        echo json_encode($data);
    }

    public function chartDay()
    {
        $where = "";
        $currentMonth = date('Y-m');
        $currentYear = date('Y');
        $currentMonthNumber = date('m');

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonthNumber, $currentYear);

        $categories = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $categories[] = sprintf('%02d', $day);
        }

        if ($this->auth['level_id'] == 2) {
            $where = 'AND akun_id = ' . $this->auth['id'] . '';
        }

        if ($this->auth['level_id'] == 3) {
            $where = 'AND akun_id = ' . $this->auth['id_akun'] . '';
        }

        $result = $this->db->query(" SELECT SUM(jumlah) as total, tanggal, 'masuk' as tipe FROM `cash_flow`
            WHERE tipe = 'masuk' " . $where . " AND isDelete = '0' AND DATE_FORMAT(tanggal, '%Y-%m') = '$currentMonth'
            GROUP BY tanggal
            UNION ALL
            SELECT SUM(jumlah) as total, tanggal, 'keluar' as tipe FROM `cash_flow`
            WHERE tipe = 'keluar' " . $where . " AND isDelete = '0' AND DATE_FORMAT(tanggal, '%Y-%m') = '$currentMonth'
            GROUP BY tanggal
        ")->result();

        $seriesMasuk = array_fill(0, $daysInMonth, 0);
        $seriesKeluar = array_fill(0, $daysInMonth, 0);

        foreach ($result as $row) {
            $day = (int) substr($row->tanggal, -2) - 1;
            if ($row->tipe == 'masuk') {
                $seriesMasuk[$day] = (int) $row->total;
            } else {
                $seriesKeluar[$day] = (int) $row->total;
            }
        }

        $data = [
            'series' => [
                [
                    'name' => 'Masuk',
                    'data' => $seriesMasuk
                ],
                [
                    'name' => 'Keluar',
                    'data' => $seriesKeluar
                ]
            ],
            'categories' => $categories
        ];

        echo json_encode($data);
    }

}
