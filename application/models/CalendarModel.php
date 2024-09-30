<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class CalendarModel extends CI_Model
{
    private $auth;

    function __construct()
    {
        parent::__construct();
        $this->auth = $this->session->userdata('auth_login');
    }

    public function dataCalendar()
    {
        $where = "";

        if ($this->auth['level_id'] == 2) {
            $where = 'AND a.akun_id = ' . $this->auth['id'] . '';
        }

        if ($this->auth['level_id'] == 3) {
            $where = 'AND a.akun_id = ' . $this->auth['id_akun'] . '';
        }

        $result = $this->db->query("SELECT a.*, b.name FROM cash_flow a LEFT JOIN unit b ON a.unit = b.id WHERE a.unit != 0 AND a.tipe = 'masuk' AND a.isDelete = '0' $where")->result();

        $this->formatDataCalendar($result);
        exit;
    }

    private function formatDataCalendar($data)
    {
        $halfday = '';
        $events = [];
        foreach ($data as $row) {
            $is_fullday = stripos($row->keterangan, 'fullday') !== false;
            if ($is_fullday) {
                if ($row->waktu == 'siang') {
                    $title = 'Fullday Siang';
                    $start_time = '12:00:00';
                    $end_time = '11:00:00';
                    $end_date = (new DateTime($row->tanggal))->modify('+1 day')->format('Y-m-d');
                    $class_name = 'bg-danger text-white';
                } elseif ($row->waktu == 'malam') {
                    $title = 'Fullday Malam';
                    $start_time = '20:00:00';
                    $end_time = '19:00:00';
                    $end_date = (new DateTime($row->tanggal))->modify('+1 day')->format('Y-m-d');
                    $class_name = 'bg-danger text-white';
                }
            } else {
                if ($row->waktu == 'siang') {
                    $title = 'Halfday Siang';
                    $start_time = '12:00:00';
                    $end_time = '19:00:00';
                    $class_name = 'bg-warning text-dark';
                } elseif ($row->waktu == 'malam') {
                    $title = 'Halfday Malam';
                    $start_time = '20:00:00';
                    $end_time = '11:00:00';
                    $end_date = (new DateTime($row->tanggal))->modify('+1 day')->format('Y-m-d');
                    $class_name = 'bg-secondary text-white';
                }
            }

            $events[] = [
                'id' => $row->id,
                'title' => $row->name . '-' . $row->keterangan,
                'start' => $row->tanggal . 'T' . $start_time,
                'end' => $is_fullday ? $end_date . 'T' . $end_time : $row->tanggal . 'T' . $end_time,
                'description' => $title . '-' . $row->jumlah . ' (' . $row->waktu . ')',
                'className' => $class_name,
            ];
        }

        echo json_encode($events);
    }

    public function detailDataCalendar($id)
    {
        $event = $this->db->get_where('cash_flow', ['id' => $id])->row();
        
        if ($event) {
            echo json_encode($event);
        } else {
            echo json_encode(['error' => 'Event not found']);
        }
    }
}
