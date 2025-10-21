<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Rekapdatawp extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_rekapwp'));
    }

    public function index()
    {
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'rekapwp');
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $stat_arr = array(
            "Y" => "<i class='fas fa-circle' style='color:green;'></i>",
            "N" => "<i class='fas fa-circle' style='color:red;'></i>"
        );

        $list = $this->Mod_rekapwp->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pel->npwpd;
            $row[] = $pel->nama;
            $row[] = $pel->email;
            $row[] = $pel->nama_kecamatan;
            $row[] = $stat_arr[$pel->is_active];
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_rekapwp->count_all(),
            "recordsFiltered" => $this->Mod_rekapwp->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function lihat()
    {
        $activ = "wp";
        $wpid = $_GET['wr_id'];
        $noreg = $_GET['no_urut'];
        $pajret = $_GET['pajret'];

        $data_wp = $this->Mod_rekapwp->get_wrnama($noreg);
        $data['wp_wr_nama'] = $data_wp->wp_wr_nama;

        $data['data_spt'] = $this->Mod_rekapwp->get_spt($wpid);
        // var_dump($data_spt);


        $this->template->load('layoutbackend', 'infowp', $data);
    }

    public function cetakdatauser()
    {
        $kec  = $this->input->get('search');

        $data['data_user'] = $this->Mod_rekapwp->cetakdatauser($kec);

        $this->load->view('cetak_rekap_user', $data);
    }
}
