<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rekap_pembayaran extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_rekappembayaran'));
    }

    public function index()
    {
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'rekap_pembayaran');
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $jenis = $this->input->post('jenis');
        $list = $this->Mod_rekappembayaran->get_datatables();
        $stat_arr = array(
            "0" => "<i class='far fa-times-circle' style='color:red;'></i> <span class='text-danger'>Blm Bayar</span>",
            "1" => "<i class='far fa-check-circle' style='color:green;'></i><span class='text-success'> Sudah Bayar</span>",
            "2" => "<span class='text-secondary'> Nihil</span>"
        );
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pel->nama;
            $row[] = $pel->npwprd;
            $row[] = $pel->kode_billing;
            $row[] = $pel->tahun_pajak;
            $row[] = number_format($pel->pokok_pajak);
            $row[] = number_format($pel->denda);
            $row[] = $pel->tgl_bayar;
            $row[] = $stat_arr[$pel->status_bayar];
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_rekappembayaran->count_all(),
            "recordsFiltered" => $this->Mod_rekappembayaran->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function cetakpenerimaan()
    {
        $startdate  = $this->input->get('StartDate');
        $enddate    = $this->input->get('EndDate');

        $data['penerimaan'] = $this->Mod_rekappembayaran->cetakpenerimaan($startdate, $enddate);

        // var_dump($data);

        $this->load->view('cetak_rekap_penerimaan', $data);
    }
}
