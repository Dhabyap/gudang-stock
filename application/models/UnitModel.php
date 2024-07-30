<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class UnitModel extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'unit';
    }

    function insert()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $data = [
            'name' => $post['name'],
            'type' => $post['tipe'],
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
}
