<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template
{

    function load($setting = '', $konten = '')
    {
        $ci = &get_instance();
        
        $temp['head'] = $ci->load->view('layout/head', [], TRUE);
        $temp['footer'] = $ci->load->view('layout/footer', isset($setting['footer']) ? $setting['footer'] : '', TRUE);
        $temp['sidebar'] = $ci->load->view('layout/sidebar', [], TRUE);
        $temp['navbar'] = $ci->load->view('layout/navbar', [], TRUE);
        $temp['script'] = $ci->load->view('layout/script', [], TRUE);
        $temp['content'] = $konten;

        /* MAIN CONTAINER */
        $ci->load->view('layout/container', $temp);
    }
    function load2($setting = '', $konten = '')
    {
        $ci = &get_instance();
        
        $temp['head'] = $ci->load->view('layout/head2', [], TRUE);
        $temp['footer'] = $ci->load->view('layout/footer', isset($setting['footer']) ? $setting['footer'] : '', TRUE);
        $temp['sidebar'] = $ci->load->view('layout/sidebar', [], TRUE);
        $temp['navbar'] = $ci->load->view('layout/navbar', [], TRUE);
        $temp['script'] = $ci->load->view('layout/script', [], TRUE);
        $temp['content'] = $konten;

        /* MAIN CONTAINER */
        $ci->load->view('layout/container2', $temp);
    }
}
