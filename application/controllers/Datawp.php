<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Datawp extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_datawp'));
    }

    public function index()
    {
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'datawp');
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_datawp->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pel->nama;
            $row[] = $pel->alamat . ',' . $pel->kelurahan;
            $row[] = $pel->nama_paret;
            $row[] = $pel->kecamatan;
            $row[] = $pel->wp_wr_id;
            $row[] = $pel->wp_wr_bidang_usaha;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_datawp->count_all(),
            "recordsFiltered" => $this->Mod_datawp->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function lihat()
    {
        // $activ = "wp";
        $wpid = $_GET['wr_id'];
        // $noreg = $_GET['no_urut'];
        // $pajret = $_GET['pajret'];

        $data_wp = $this->Mod_datawp->get_wrnama($wpid);
        $data['wp_wr_nama'] = $data_wp->nama;

        $data['data_spt'] = $this->Mod_datawp->get_spt($wpid);


        $this->template->load('layoutbackend', 'infowp', $data);
    }
}
