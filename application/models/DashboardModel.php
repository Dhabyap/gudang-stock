<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class DashboardModel extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'akun';
    }

    function countUnitsAndCashFlows()
    {
        return $this->db->query(" SELECT
            (SELECT COUNT(*) FROM unit) AS unit_count,
            (SELECT SUM(jumlah) FROM cash_flow WHERE tipe = 'masuk' AND DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')) AS cash_flow_masuk,
            (SELECT SUM(jumlah) FROM cash_flow WHERE tipe = 'keluar' AND DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')) AS cash_flow_keluar"
        )->row();
    }
    
    function chartTransaksi()
    {
        $result = $this->db->query("SELECT COUNT(a.id) as total, b.name FROM cash_flow a LEFT JOIN unit b ON a.unit = b.id WHERE a.unit != 0 AND tipe = 'masuk' AND MONTH(a.tanggal) = MONTH(CURDATE()) GROUP BY a.unit ORDER BY total ASC")->result();

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


}
