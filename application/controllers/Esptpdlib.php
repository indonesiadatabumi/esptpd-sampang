<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Esptpdlib extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('fungsi');
        $this->load->model('Mod_esptpd');
    }

    public function index()
    {
        // 
    }

    function get_tarif()
    {
        $korek_id  = $this->input->post('rek_id');
        $tarif = $this->Mod_esptpd->_get_tarif($korek_id);

        echo json_encode(array("nilai" => $tarif));
    }
}
