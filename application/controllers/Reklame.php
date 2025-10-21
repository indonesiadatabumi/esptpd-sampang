<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Reklame extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('fungsi');
        $this->load->model(array('Mod_reklame'));
    }

    public function index()
    {
        $this->template->load('layoutbackend', 'dafreklame.php');
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_reklame->get_datatables();
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
            $row[] = $pel->npwprd;
            $row[] = $pel->spt_periode;
            $row[] = $pel->wp_rek_nama;
            $row[] = $pel->wp_rek_alamat;
            $row[] = $pel->spt_pajak;
            $row[] = $pel->spt_kode_billing;
            $row[] = $stat_arr[$pel->status_bayar];
            $row[] = $pel->spt_idwp_reklame;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_reklame->count_all(),
            "recordsFiltered" => $this->Mod_reklame->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function skpd_print()
    {
        $spt_id =  $this->uri->segment(3);

        $list = $this->Mod_reklame->getPrint($spt_id);

        foreach ($list as $billing) {
            $data['spt_nomor'] = $billing->spt_nomor;
            $data['wp_rek_nama'] = $billing->wp_rek_nama;
            $data['wp_rek_alamat'] = $billing->wp_rek_alamat;
            $data['npwprd'] = $billing->npwprd;
            $data['netapajrek_tgl_jatuh_tempo'] = $billing->netapajrek_tgl_jatuh_tempo;
            $data['spt_kode_billing'] = $billing->spt_kode_billing;
            $data['koderek_titik'] = $billing->koderek_titik;
            $data['korek_nama'] = $billing->korek_nama;
            $data['spt_pajak'] = $billing->spt_pajak;
            $data['spt_periode'] = $billing->spt_periode;
            $data['spt_periode_jual1'] = $billing->spt_periode_jual1;
            $data['spt_no_register'] = $billing->spt_no_register;
            $data['spt_tgl_proses'] = $billing->spt_tgl_proses;
        }
        if ($list) {
            $bln = date("n", strtotime($billing->spt_periode_jual1));
            $data['bln_masapajak'] = $this->fungsi->bulan($bln);
        }


        $mpdf = new \Mpdf\Mpdf();

        // $this->template->load('layoutbackend', 'esptpd/eskpd_reklame', $data);

        $html = $this->load->view('esptpd/eskpd_reklame', $data, TRUE);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
