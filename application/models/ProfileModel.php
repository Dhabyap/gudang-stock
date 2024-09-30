<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class ProfileModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function detailAppartement($data)
    {
        return $this->db->get_where('appartement', array('id' => $data['id_appartement']))->result()[0];
    }

}
