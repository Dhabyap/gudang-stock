<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class CashFlowModel extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'cash_flow';
    }

    function insert()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $data = [
            'jumlah' => $post['jumlah'],
            'tanggal' => $post['tanggal'],
            'waktu' => $post['waktu'],
            'tipe' => $post['tipe'],
            'unit' => $post['unit'],
            'keterangan' => $post['keterangan'],
        ];

        if ($id) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            $this->db->update($this->table, $data);
            $message = 'Data berhasil diubah';
        } else {
            $this->db->insert($this->table, $data);
            $message = 'Data berhasil ditambahkan';
        }

        $response = [
            'n' => 'SS',
            'm' => $message
        ];

        exit(json_encode($response));
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
        return $this->db->get('unit')->result();
    }
}
