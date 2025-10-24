<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lapor_pajak extends MY_Controller
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
        $logged_in = $this->session->userdata('logged_in');
        $user_id = $this->session->userdata('id_user');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect('login');
        } else {
            $data['esptpd'] = $this->Mod_esptpd->_get_esptpd_menu();
            $this->template->load('layoutbackend', 'esptpd/lapor_menu', $data);
        }
    }

    public function create_lapor($wp_wr_detil_id)
    {
        error_reporting(~E_NOTICE);
        $listdata = $this->Mod_esptpd->esptpd_add($wp_wr_detil_id);
        foreach ($listdata as $apl) {
            $data['wp_id'] = $apl->wp_wr_id;
            $data['wp_id_detil'] = $apl->wp_wr_detil_id;
            $data['npwprd'] = $apl->npwprd;
            $data['jns_pajak'] = $apl->pajak_id;
            $data['nama'] = $apl->nama_wp;
            $data['alamat'] = $apl->alamat;
            $data['kelurahan'] = $apl->kelurahan;
            $data['kecamatan'] = $apl->kecamatan;
            $data['kota'] = $apl->kabupaten;
            $data['kode_rekening'] = $apl->kode_rekening;
            $data['kode_spt'] = $apl->kode_spt;
            $data['persen_tarif'] = $apl->persen_tarif;
            $data['nama_kegus'] = $apl->nama_kegus;
            $data['jenput_id'] = $apl->jenput_id;
            $data['kegus_id'] = $apl->kegus_id;
        }

        $add_form =  "create_lapor";

        $this->template->load('layoutbackend', 'esptpd/' . $add_form, $data);
    }

    function get_total_bulanan()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $wp_id_detil = $this->input->post('wp_id_detil');

        $data_bulanan = $this->Mod_esptpd->get_daftar_bulanan($bulan, $tahun, $wp_id_detil);
        $total_bulanan = $this->Mod_esptpd->get_total_bulanan($bulan, $tahun, $wp_id_detil);

        $response = [
            'status' => true,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'wp_id_detil' => $wp_id_detil,
            'data' => $data_bulanan,
            'total_pajak' => $total_bulanan->total_pajak ?? 0
        ];

        echo json_encode($response);
    }

    public function insert()
    {
        $masa_pajak = $this->input->post('masa_pajak');
        $spt_periode = $this->input->post('spt_periode');
        $wp_id_detil = $this->input->post('wp_id_detil');

        $save = [
            'tgl_lapor' => date('Y-m-d')
        ];

        // proses update status lapor pada tabel spt
        $this->Mod_esptpd->update_lapor_spt($masa_pajak, $spt_periode, $wp_id_detil, $save);
        echo json_encode(array("status" => TRUE));
    }

    public function daftar_lapor($wp_wr_detil_id)
    {
        $data['info_wp'] = $this->Mod_esptpd->get_info_wp($wp_wr_detil_id);
        $this->template->load('layoutbackend', 'esptpd/lapor_data', $data);
    }

    public function ajax_list()
    {
        // Ambil parameter dari DataTables
        $wp_wr_detil_id   = $this->input->post('wp_wr_detil_id');

        // Ambil data dari model
        $list = $this->Mod_esptpd->get_data_lapor($wp_wr_detil_id);
        $data = [];
        $data_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $no = 1;

        foreach ($list as $row) {
            $aksi = "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $wp_wr_detil_id . "/" . $row->bulan_pajak . "/" . $row->tahun_pajak . "><i class=\"fas fa-print\"></i> Esptpd</a>";

            $data[] = [
                $no++,
                $row->tahun_pajak,
                $data_bulan[$row->bulan_pajak],
                number_format($row->total_pajak),
                date("d-m-Y", strtotime($row->tgl_lapor)),
                $aksi
            ];
        }

        // Kirim ke DataTables
        $output = [
            "data" => $data
        ];

        echo json_encode($output);
    }

    public function esptd_print()
    {
        error_reporting(~E_NOTICE);

        $wp_wr_detil_id =  $this->uri->segment(3);
        $bulan_pajak  =  $this->uri->segment(4);
        $tahun_pajak  =  $this->uri->segment(5);
        echo "Dalam Pengembangan";
        die;

        $list = $this->Mod_esptpd->getPrint($spt_id);
        foreach ($list as $billing) {
            $data['spt_nomor'] = $billing->spt_id;
            $data['spt_tahun_pajak'] = $billing->tahunpajak;
            $data['spt_idwpwr'] = $billing->wp_wr_id;
            $data['spt_tgl_entry'] = $this->fungsi->tanggalindo($billing->tgl_proses);
            $data['spt_periode'] = $billing->tahun_pajak;
            $data['spt_periode_jual1'] = $billing->masa_pajak1;
            $data['spt_periode_jual2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->pajak;
            $data['spt_dt_jumlah'] = $billing->nilai_terkena_pajak;
            $data['spt_korek_persen_tarif'] = $billing->persen_tarif;
            $data['spt_nama'] = $billing->nama;
            $data['billing_id'] = $billing->kode_billing;
            $data['status_bayar'] = $billing->status_bayar;
            $data['spt_golongan'] = $billing->golongan;
            $data['spt_jenispajak'] = $billing->jenis;
            $data['npwprd'] = $billing->npwprd;
        }

        if ($jenispajak == '1') {
            $espt_prt = "esptpd_hotel_prt";
            $where = array('wp_wr_detil_id' => $billing->wp_wr_detil_id);
            $row = $this->Mod_esptpd->get_wp_wr_hotel($where, 'wp_wr_hotel');
            $golongan_hotel =  $row->golongan_hotel;
            $where = array('ref_kode' => $golongan_hotel);
            $golongan = $this->Mod_esptpd->get_ref_gol_hotel($where, 'ref_gol_hotel');
            $data['golongan'] = $golongan;
            $data['row'] = $row;
        } elseif ($jenispajak == '2') {
            $espt_prt = "esptpd_resto_prt";
            $where = array('wp_wr_detil_id' => $billing->wp_wr_detil_id);
            $row = $this->Mod_esptpd->get_wp_wr_restoran($where, 'wp_wr_restoran');
            $jenis_restoran =  $row->jenis_restoran;
            $where = array('ref_kode' => $jenis_restoran);
            $golongan = $this->Mod_esptpd->get_ref_jenis_restoran($where, 'ref_jenis_restoran');
            $data['golongan'] = $golongan;
        } elseif ($jenispajak == '4') {
            $espt_prt = "esptpd_hiburan_prt";
            $golongan = '';
        } elseif ($jenispajak == '6') {
            $espt_prt = "esptpd_minerba_prt";
            $where = array('spt_id' => $billing->spt_id);
            $row = $this->Mod_esptpd->get_minerba_detil($where, 'spt_detil_mblb');
            $jenis_mblb =  $row->mblb_id;
            $where = array('ref_mblb_id' => $jenis_mblb);
            $jenis_mblb = $this->Mod_esptpd->get_jenis_mblb($where, 'ref_jenis_mblb');
            $data['jenis_mblb'] = $jenis_mblb;
            $data['row'] = $row;
        } elseif ($jenispajak == '7') {
            $where = array('spt_id' => $billing->spt_id);
            $row = $this->Mod_esptpd->get_abt_detil($where, 'spt_detil_abt');
            $espt_prt = "esptpd_abt_prt";
            $data['row'] = $row;
        } elseif ($jenispajak == '11') {
            $espt_prt = "esptpd_parkir_prt";
        }

        $kode_pajak = $this->Mod_esptpd->getKodePajak($jenispajak);
        $data['kode_pajak'] = $kode_pajak;



        // $tgljatuhtempo = date('Y-m-d', strtotime('+2 month', strtotime($billing->spt_periode_jual1)));
        // if ($billing->status_bayar == 0) {
        //     $jml_denda = $this->fungsi->denda($tgljatuhtempo, date("Y-m-d"), $billing->spt_pajak);
        // } else {
        //     $tgl_setor = '';
        //     $list_denda = $this->Mod_esptpd->getDenda($billing->spt_idwpwr, $billing->spt_periode, $billing->spt_nomor);
        //     foreach ($list_denda as $list_denda) {
        //         $tgl_setor = $billing->setorpajret_tgl_bayar;
        //     }

        //     $jml_denda = $this->fungsi->denda($tgljatuhtempo, $tgl_setor, $billing->spt_pajak);
        // }

        $bln = date("n", strtotime($billing->masa_pajak1));

        // if ($billing->spt_pajak < 10) {
        //     $pajakdibayar = 0;
        //     $nihil = "[NIHIL]";
        // } else {
        //     $pajakdibayar = $billing->spt_pajak;
        //     $nihil = "";
        // }
        // $data['jml_denda'] = $jml_denda;
        // $data['pajakdibayar'] = $pajakdibayar;
        // $data['nihil'] = $nihil;
        $data['bln_masapajak'] = $this->fungsi->bulan($bln);

        // var_dump($data);
        // die();
        $mpdf = new \Mpdf\Mpdf();
        // $this->template->load('layoutbackend', 'esptpd/esptpd_resto_prt', $data);

        $html = $this->load->view('esptpd/' . $espt_prt, $data, TRUE);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
