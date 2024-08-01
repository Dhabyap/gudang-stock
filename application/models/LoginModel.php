<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class LoginModel extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->table = 'akun';
    }

    function check()
    {
        $post = $this->input->post();
        $query = $this->db->get_where($this->table, array('email' => $post['email'], 'password' => $post['password']))->result_array()[0];

        if ($query) {
            $this->session->unset_userdata('auth_login');
            $this->session->set_userdata('auth_login', $query);
            $response = [
                'n' => 'SS',
                'm' => 'Login Berhasil'
            ];
        } else {
            $response = [
                'n' => 'ERR',
                'm' => 'Email dan password salah!'
            ];
        }

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
