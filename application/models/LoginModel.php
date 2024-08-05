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

    public function check()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = [
                'n' => 'ERR',
                'm' => validation_errors()
            ];
        } else {
            $post = $this->input->post();
            $password = sha1($post['password']);
            $this->db->where('email', $post['email']);
            $this->db->where('password', $password);
            $query = $this->db->get($this->table);

            if ($query->num_rows() == 1) {
                $result = $query->row_array();
                $this->session->unset_userdata('auth_login');
                $this->session->set_userdata('auth_login', $result);
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
        }

        exit(json_encode($response));
    }

}
