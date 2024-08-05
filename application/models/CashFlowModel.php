<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class CashFlowModel extends CI_Model
{
    private $table;
    private $auth;

    function __construct()
    {
        parent::__construct();
        $this->auth = $this->session->userdata('auth_login');
        $this->table = 'cash_flow';
    }

    public function insert()
    {
        $post = $this->input->post();
        $id = $post['id'];

        $data = $this->prepareData($post);

        $this->setUserSpecificData($data);

        if ($id) {
            $this->updateRecord($id, $data);
            $message = 'Data berhasil diubah';
        } else {
            $this->insertRecord($data);
            $message = 'Data berhasil ditambahkan';
        }

        $response = [
            'n' => 'SS',
            'm' => $message
        ];

        exit(json_encode($response));
    }

    private function prepareData($post)
    {
        return [
            'jumlah' => $post['jumlah'],
            'tanggal' => $post['tanggal'],
            'waktu' => $post['waktu'],
            'tipe' => $post['tipe'],
            'unit' => isset($post['unit']) ? $post['unit'] : null,
            'keterangan' => $post['keterangan']
        ];
    }

    private function setUserSpecificData(&$data)
    {
        if ($this->auth['level_id'] == 2) {
            $data['akun_id'] = $this->auth['id'];
        }

        if ($this->auth['level_id'] == 3) {
            $data['akun_id'] = $this->auth['id_akun'];
        }
    }

    private function updateRecord($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    private function insertRecord($data)
    {
        $this->db->insert($this->table, $data);
    }

    function detail($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id))->result_array()[0];
        return json_encode($query);
    }
    function delete($id)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['isDelete'] = '1';
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        $response = [
            'n' => 'SS',
            'm' => 'Data berhasil di hapus!'
        ];

        exit(json_encode($response));
    }
    public function getUnits()
    {
        $this->db->select('*');
        $this->db->from('unit');

        if ($this->auth['level_id'] == 2) {
            $this->db->where('akun_id', $this->auth['id']);
        } elseif ($this->auth['level_id'] == 3) {
            $this->db->where('akun_id', $this->auth['id_akun']);
        }

        $query = $this->db->get();
        return $query->result();
    }

}
