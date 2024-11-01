<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class AccountModel extends CI_Model
{
    private $table;
    private $auth;

    function __construct()
    {
        parent::__construct();
        $this->auth = $this->session->userdata('auth_login');
        $this->table = 'akun';
    }

    public function insert()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $email = $post['email'];

        if ($this->isEmailDuplicate($email, $id)) {
            $response = [
                'n' => 'ERR',
                'm' => 'Email sudah digunakan'
            ];
            exit(json_encode($response));
        }

        $data = $this->prepareData($post);

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

    private function isEmailDuplicate($email, $id = null)
    {
        $this->db->where('email', $email);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

    private function prepareData($post)
    {
        $data = [
            'name' => $post['name'],
            'email' => $post['email'],
            'level_id' => $post['level'],
            'id_appartement' => $this->auth['id_appartement']
        ];

        if ($this->auth['level_id'] == 2) {
            $data['id_akun'] = $this->auth['id'];
        }

        return $data;
    }

    private function updateRecord($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    private function insertRecord($data)
    {
        $data['password'] = '7c4a8d09ca3762af61e59520943dc26494f8941b';
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

    public function getApparts()
    {
        $this->db->select('*');
        $this->db->from('appartement');

        if ($this->auth['level_id'] == 2) {
            $this->db->where('id', $this->auth['id_appartement']);
        }

        $query = $this->db->get();
        return $query->result();
    }
    public function getLevels()
    {
        $this->db->select('*');
        $this->db->from('level_akun');

        if ($this->auth['level_id'] == 2) {
            $this->db->where('id', 3);
        }

        $query = $this->db->get();
        return $query->result();
    }
    public function update($post)
    {
        $data['name'] = $post['name'];
        $data['password'] = sha1($post['password']);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', decrypt($post['id']));
        $this->db->update($this->table, $data);

        $response = [
            'n' => 'SS',
            'm' => 'Data berhasil di update!'
        ];

        exit(json_encode($response));
    }
}

