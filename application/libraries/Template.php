<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template
{
    function load($setting = '', $konten = '')
    {
        $ci = &get_instance();
        $data['auth'] = $ci->session->userdata('auth_login');

        $temp['head'] = $ci->load->view('layout/head', $data, TRUE);
        $temp['footer'] = $ci->load->view('layout/footer', $data, TRUE);
        $temp['sidebar'] = $ci->load->view('layout/sidebar', $data, TRUE);
        $temp['navbar'] = $ci->load->view('layout/navbar', $data, TRUE);
        $temp['script'] = $ci->load->view('layout/script', $data, TRUE);
        $temp['content'] = $konten;

        /* MAIN CONTAINER */
        $ci->load->view('layout/container', $temp);
    }
}
