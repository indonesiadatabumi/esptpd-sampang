<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Esptpd extends MY_Controller
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
            $this->template->load('layoutbackend', 'esptpd/esptpd_menu', $data);
        }
    }

    public function billing($wp_wr_detil_id)
    {
        $data['info_wp'] = $this->Mod_esptpd->get_info_wp($wp_wr_detil_id);
        $this->template->load('layoutbackend', 'esptpd/billing_data', $data);
    }


    public function get_nama_wp()
    {
        // $userid = $this->session->userdata('id_user');
        $kodepajak = $this->input->post('kodepajak');
        $jenispajak = $this->input->post('jenispajak');
        $golongan = $this->input->post('gol');
        $noreg = $this->input->post('noreg');
        $kdcamat = $this->input->post('kdcamat');
        $kdlurah = $this->input->post('kdlurah');

        $npwprd = $kodepajak . "." . $golongan . "." . $jenispajak . "." . $noreg . "." . $kdcamat . "." . $kdlurah;

        $nama = $this->Mod_esptpd->get_nama_wp($npwprd);

        echo json_encode(array("nama" => $nama));
    }

    public function save_data_group()
    {
        $npwpd = $this->input->post('npwpd');
        $userid = $this->input->post('userid');
        $noreg = $this->input->post('noreg');

        $arr_noreg = $this->Mod_esptpd->_get_id_npwp($noreg);
        foreach ($arr_noreg as $list) {
            $wp_wr_id = $list->wp_wr_id;
        }

        $save  = array(
            'groupid' => $userid,
            'npwpd' => $npwpd,
            'id_wpwr'  => $wp_wr_id
        );

        $this->Mod_esptpd->inserSPT("data_group", $save);
        echo json_encode(array("status" => TRUE));
    }

    public function billing_hapus()
    {

        $idbilling = $this->input->post('idbilling');

        $where = array('kode_billing' => $idbilling);
        $spt_id = $this->Mod_esptpd->get_sptID($where, 'spt');

        $where2 = array('spt_id' => $spt_id);
        $this->Mod_esptpd->hapus_billing($where2, 'spt');

        $where3 = array('spt_detil_id' => $spt_id);
        $this->Mod_esptpd->hapus_billing($where3, 'spt_detil');

        $msg = [
            'sukses' => 'Billing berhasil dihapus'
        ];
        echo json_encode($msg);
    }

    public function delete_menu()
    {
        $no_id = $this->input->post('noid');

        $where = array('noid' => $no_id);
        $this->Mod_esptpd->hapus_billing($where, 'data_group');

        $msg = [
            'sukses' => 'Menu berhasil dihapus'
        ];
        echo json_encode($msg);
    }


    public function lampiran()
    {
        $billing_id =  $this->uri->segment(3);

        $list = $this->Mod_esptpd->getAll($billing_id);


        foreach ($list as $billing) {
            $data['spt_id'] = $billing->spt_id;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['spt_periode'] = $billing->spt_periode;
            $data['spt_periode_jual1'] = $billing->spt_periode_jual1;
            $data['spt_periode_jual2'] = $billing->spt_periode_jual2;
            $data['spt_pajak'] = $billing->spt_pajak;
            $data['status_bayar'] = $billing->status_bayar;
            $data['lampiran'] = $billing->image;
        }

        $data['billing_id'] = $billing_id;
        // var_dump($data);
        $this->load->view('esptpd/esptpd_lampiran', $data);
    }

    public function register()
    {
        $billing_id =  $this->uri->segment(3);

        $list = $this->Mod_esptpd->getAll($billing_id);
        foreach ($list as $billing) {
            $data['spt_id'] = $billing->spt_id;
            $data['spt_idwpwr'] = $billing->spt_idwpwr;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['spt_periode'] = $billing->spt_periode;
            $data['spt_periode_jual1'] = $billing->spt_periode_jual1;
            $data['spt_periode_jual2'] = $billing->spt_periode_jual2;
            $data['spt_pajak'] = $billing->spt_pajak;
            $data['status_bayar'] = $billing->status_bayar;
            $data['lampiran'] = $billing->image;
        }

        $list2 = $this->Mod_esptpd->getdataPayment($billing_id);
        foreach ($list2 as $wpwr) {
            $data['npwprd'] = $wpwr->npwprd;
            $data['wp_wr_nama'] = $wpwr->wp_wr_nama;
            $data['wp_wr_almt'] = $wpwr->wp_wr_almt;
        }

        $list3 = $this->Mod_esptpd->getdataPelayanan($billing_id);

        if ($list3) {
            foreach ($list3 as $pelayanan) {
                $data['stat_register'] = $pelayanan->stat_register;
                $data['keterangan'] = $pelayanan->keterangan;
                $data['act'] = ($pelayanan->spt_id) ? 'edit' : 'add';
            }
        } else {
            $data['stat_register'] = '';
            $data['keterangan'] = '';
            $data['act'] = 'add';
        }

        $data['billing_id'] = $billing_id;

        $this->template->load('layoutbackend', 'esptpd/esptpd_register', $data);
    }

    public function lihat_lampiran()
    {
        $billing_id =  $this->uri->segment(3);

        $list = $this->Mod_esptpd->getAll($billing_id);
        foreach ($list as $billing) {
            $data['spt_id'] = $billing->spt_id;
            $data['spt_idwpwr'] = $billing->wp_wr_id;
            $data['spt_tgl_entry'] = $billing->tgl_proses;
            $data['spt_periode'] = $billing->tahun_pajak;
            $data['spt_periode_jual1'] = $billing->masa_pajak1;
            $data['spt_periode_jual2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->pajak;
            $data['status_bayar'] = $billing->status_bayar;
            $data['lampiran'] = $billing->image;
        }

        $list2 = $this->Mod_esptpd->getdataPayment($billing_id);
        foreach ($list2 as $wpwr) {
            $data['npwprd'] = $wpwr->npwpd;
            $data['wp_wr_nama'] = $wpwr->nama_wp;
            $data['wp_wr_almt'] = $wpwr->alamat;
        }

        $list3 = $this->Mod_esptpd->getdataPelayanan($billing_id);

        if ($list3) {
            foreach ($list3 as $pelayanan) {
                $data['stat_register'] = $pelayanan->stat_register;
                $data['keterangan'] = $pelayanan->keterangan;
                $data['act'] = ($pelayanan->spt_id) ? 'edit' : 'add';
            }
        } else {
            $data['stat_register'] = '';
            $data['keterangan'] = '';
            $data['act'] = 'add';
        }

        $data['billing_id'] = $billing_id;

        $this->template->load('layoutbackend', 'esptpd/esptpd_lihat_lampiran', $data);
    }


    public function view()
    {
        $billing_id =  $this->uri->segment(3);

        $list = $this->Mod_esptpd->getAll($billing_id);
        foreach ($list as $billing) {
            $data['spt_id'] = $billing->spt_id;
            $data['spt_idwpwr'] = $billing->wp_wr_id;
            $data['spt_tgl_entry'] = $billing->tgl_proses;
            $data['spt_periode'] = $billing->tahun_pajak;
            $data['spt_periode_jual1'] = $billing->masa_pajak1;
            $data['spt_periode_jual2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->pajak;
            $data['status_bayar'] = $billing->status_bayar;
            $data['lampiran'] = $billing->image;
        }

        $list2 = $this->Mod_esptpd->getdataPayment($billing_id);
        foreach ($list2 as $wpwr) {
            $data['npwprd'] = $wpwr->npwprd;
            $data['wp_wr_nama'] = $wpwr->wp_wr_nama;
            $data['wp_wr_almt'] = $wpwr->wp_wr_almt;
        }

        $list3 = $this->Mod_esptpd->getdataPelayanan($billing_id);
        foreach ($list3 as $pelayanan) {
            $data['stat_register'] = $pelayanan->stat_register;
            $data['keterangan'] = $pelayanan->keterangan;
        }

        $data['billing_id'] = $billing_id;
        $this->template->load('layoutbackend', 'esptpd/billing_view', $data);
    }

    public function espt_print()
    {
        error_reporting(~E_NOTICE);

        $spt_id =  $this->uri->segment(3);
        $jenispajak  =  $this->uri->segment(4);


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

    public function espt_print_prt()
    {
        $billing_id =  $this->uri->segment(3);

        $list_bil = $this->Mod_esptpd->getAll($billing_id);
        foreach ($list_bil as $billing2) {
            $data['spt_id'] = $billing2->spt_id;
        }

        $list = $this->Mod_esptpd->getPrint($billing2->spt_id);
        foreach ($list as $billing) {
            $data['spt_nomor'] = $billing->spt_nomor;
            $data['spt_tahun_pajak'] = $billing->tahunpajak;
            $data['spt_idwpwr'] = $billing->spt_idwpwr;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['spt_periode'] = $billing->spt_periode;
            $data['spt_periode_jual1'] = $billing->spt_periode_jual1;
            $data['spt_periode_jual2'] = $billing->spt_periode_jual2;
            $data['spt_pajak'] = $billing->spt_pajak;
            $data['spt_dt_jumlah'] = $billing->spt_dt_jumlah;
            $data['spt_korek_persen_tarif'] = $billing->korek_persen_tarif;
            $data['spt_korek_nama'] = $billing->korek_nama;
            $data['spt_nama'] = $billing->wp_wr_nama;
            $data['billing_id'] = $billing->spt_kode_billing;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['status_bayar'] = $billing->status_bayar;
        }

        $list_npwp = $this->Mod_esptpd->getWPWRD($billing->spt_idwpwr);
        foreach ($list_npwp as $npwprow) {
            $npwpd = $npwprow->npwprd;
        }
        $data_npwpd = explode(".", $npwpd);
        $data['spt_golongan'] = $data_npwpd[1];
        $data['spt_jenispajak'] = $data_npwpd[2];
        $jenispajak = $data_npwpd[2];
        $data['spt_noreg'] = $data_npwpd[3];
        $data['spt_camat'] = $data_npwpd[4];
        $data['spt_lurah'] = $data_npwpd[5];

        $tgljatuhtempo = date('Y-m-d', strtotime('+2 month', strtotime($billing->spt_periode_jual1)));
        if ($billing->status_bayar == 0) {
            $jml_denda = $this->fungsi->denda($tgljatuhtempo, date("Y-m-d"), $billing->spt_pajak);
        } else {
            $tgl_setor = '';
            $list_denda = $this->Mod_esptpd->getDenda($billing->spt_idwpwr, $billing->spt_periode, $billing->spt_nomor);
            foreach ($list_denda as $list_denda) {
                $tgl_setor = $billing->setorpajret_tgl_bayar;
            }

            $jml_denda = $this->fungsi->denda($tgljatuhtempo, $tgl_setor, $billing->spt_pajak);
        }

        if (date('Y-m-d') >= '2025-08-01' && date('Y-m-d') <= '2025-09-30') {
            $jml_denda = 0;
        }

        $bln = date("n", strtotime($billing->spt_periode_jual1));

        if ($billing->spt_pajak < 10) {
            $pajakdibayar = 0;
            $nihil = "[NIHIL]";
        } else {
            $pajakdibayar = $billing->spt_pajak;
            $nihil = "";
        }
        $data['jml_denda'] = $jml_denda;
        $data['pajakdibayar'] = $pajakdibayar;
        $data['nihil'] = $nihil;
        $data['bln_masapajak'] = $this->fungsi->bulan($bln);

        if ($jenispajak == '1') {
            $espt_prt = "esptpd_hotel_prt";
        } elseif ($jenispajak == '2') {
            $espt_prt = "esptpd_resto_prt";
        } elseif ($jenispajak == '4') {
            $espt_prt = "esptpd_hiburan_prt";
        } elseif ($jenispajak == '5') {
            $espt_prt = "esptpd_ppj_prt";
        } elseif ($jenispajak == '11') {
            $espt_prt = "esptpd_parkir_prt";
        }

        $mpdf = new \Mpdf\Mpdf();
        // $this->template->load('layoutbackend', 'esptpd/esptpd_resto_prt', $data);

        $html = $this->load->view('esptpd/' . $espt_prt, $data, TRUE);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }


    public function espt_billing()
    {
        $spt_id =  $this->uri->segment(3);
        $jenispajak  =  $this->uri->segment(4);

        $list = $this->Mod_esptpd->getPrint($spt_id);
        foreach ($list as $billing) {
            $tgljatuhtempo = date('Y-m-d', strtotime('+1 month', strtotime($billing->masa_pajak1)));
            $t_entry = date("Y-m-t", strtotime($tgljatuhtempo));
            $sanksi_lapor = 0;

            if ($billing->pajak_id == '6') {
                $jml_denda = $this->fungsi->denda2($t_entry, date("Y-m-d"), $billing->pajak);
            } else {
                $jml_denda = $this->fungsi->denda($t_entry, date("Y-m-d"), $billing->pajak);
            }

            if (date('Y-m-d') >= '2025-08-01' && date('Y-m-d') <= '2025-09-30') {
                $jml_denda = 0;
            }

            if ($billing->status_bayar == 0) {
                $denda = $jml_denda;
                $total_bayar = $billing->pajak + $jml_denda + $sanksi_lapor;
            } else {
                $denda = 0;
                $total_bayar = $billing->pajak;
            }

            $data['spt_nomor'] = $billing->spt_id;
            $data['spt_tahun_pajak'] = $billing->tahunpajak;
            $data['spt_idwpwr'] = $billing->wp_wr_id;
            $data['spt_tgl_entry'] = $this->fungsi->tanggalindo($billing->tgl_proses);
            $data['spt_periode'] = $billing->tahun_pajak;
            $data['spt_periode_jual1'] = $billing->masa_pajak1;
            $data['spt_periode_jual2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->pajak;
            $data['denda'] = $denda;
            $data['total_bayar'] = $total_bayar;
            $data['spt_dt_jumlah'] = $billing->nilai_terkena_pajak;
            $data['spt_korek_persen_tarif'] = $billing->persen_tarif;
            $data['spt_nama'] = $billing->nama;
            $data['billing_id'] = $billing->kode_billing;
            $data['status_bayar'] = $billing->status_bayar;
            $data['spt_golongan'] = $billing->golongan;
            $data['spt_jenispajak'] = $billing->jenis;
            $data['npwprd'] = $billing->npwprd;
        }

        $bln = date("n", strtotime($billing->masa_pajak1));
        $data['bln_masapajak'] = $this->fungsi->bulan($bln);

        if ($jenispajak == '1') {
            $pajak = "Hotel";
        } elseif ($jenispajak == '2') {
            $pajak = "Restoran";
        } elseif ($jenispajak == '4') {
            $pajak = "Hiburan";
        } elseif ($jenispajak == '6') {
            $pajak = "Minerba";
        } elseif ($jenispajak == '11') {
            $pajak = "Parkir";
        } elseif ($jenispajak == '7') {
            $pajak = "Air Tanah";
        }

        $data['pajak'] = $pajak;

        $kode_pajak = $this->Mod_esptpd->getKodePajak($jenispajak);
        $data['kode_pajak'] = $kode_pajak;


        $mpdf = new \Mpdf\Mpdf();
        // $this->template->load('layoutbackend', 'esptpd/esptpd_resto_prt', $data);

        $html = $this->load->view('esptpd/esptpd_billing_prt', $data, TRUE);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }


    public function espt_billing_prt()
    {
        $billing_id =  $this->uri->segment(3);

        $list_bil = $this->Mod_esptpd->getAll($billing_id);
        foreach ($list_bil as $billing2) {
            $data['spt_id'] = $billing2->spt_id;
        }
        $list = $this->Mod_esptpd->getPrint($billing2->spt_id);
        foreach ($list as $billing) {
            $data['spt_nomor'] = $billing->spt_nomor;
            $data['spt_tahun_pajak'] = $billing->tahunpajak;
            $data['spt_idwpwr'] = $billing->spt_idwpwr;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['spt_periode'] = $billing->spt_periode;
            $data['spt_periode_jual1'] = $billing->spt_periode_jual1;
            $data['spt_periode_jual2'] = $billing->spt_periode_jual2;
            $data['spt_pajak'] = $billing->spt_pajak;
            $data['spt_dt_jumlah'] = $billing->spt_dt_jumlah;
            $data['spt_korek_persen_tarif'] = $billing->korek_persen_tarif;
            $data['spt_korek_nama'] = $billing->korek_nama;
            $data['spt_nama'] = $billing->wp_wr_nama;
            $data['billing_id'] = $billing->spt_kode_billing;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['status_bayar'] = $billing->status_bayar;
        }

        $list_npwp = $this->Mod_esptpd->getWPWRD($billing->spt_idwpwr);
        foreach ($list_npwp as $npwprow) {
            $npwpd = $npwprow->npwprd;
        }
        $data_npwpd = explode(".", $npwpd);
        $data['npwpd'] = $npwpd;
        $data['spt_golongan'] = $data_npwpd[1];
        $data['spt_jenispajak'] = $data_npwpd[2];
        $jenispajak = $data_npwpd[2];
        $data['spt_noreg'] = $data_npwpd[3];
        $data['spt_camat'] = $data_npwpd[4];
        $data['spt_lurah'] = $data_npwpd[5];

        $tgljatuhtempo = date('Y-m-d', strtotime('+2 month', strtotime($billing->spt_periode_jual1)));
        if ($billing->status_bayar == 0) {
            if ($billing->pajak_id == '6') {
                $jml_denda = $this->fungsi->denda2($t_entry, date("Y-m-d"), $billing->pajak);
            } else {
                $jml_denda = $this->fungsi->denda($t_entry, date("Y-m-d"), $billing->pajak);
            }
        } else {
            $tgl_setor = '';
            $list_denda = $this->Mod_esptpd->getDenda($billing->spt_idwpwr, $billing->spt_periode, $billing->spt_nomor);
            foreach ($list_denda as $list_denda) {
                $tgl_setor = $billing->setorpajret_tgl_bayar;
            }

            $jml_denda = $this->fungsi->denda($tgljatuhtempo, $tgl_setor, $billing->spt_pajak);
        }

        if (date('Y-m-d') >= '2025-08-01' && date('Y-m-d') <= '2025-09-30') {
            $jml_denda = 0;
        }

        $bln = date("n", strtotime($billing->spt_periode_jual1));

        if ($billing->spt_pajak < 10) {
            $pajakdibayar = 0;
            $nihil = "[NIHIL]";
        } else {
            $pajakdibayar = $billing->spt_pajak;
            $nihil = "";
        }
        $data['jml_denda'] = $jml_denda;
        $data['pajakdibayar'] = $pajakdibayar;
        $data['nihil'] = $nihil;
        $data['bln_masapajak'] = $this->fungsi->bulan($bln);

        if ($jenispajak == '1') {
            $pajak = "Hotel";
        } elseif ($jenispajak == '2') {
            $pajak = "Restoran";
        } elseif ($jenispajak == '3') {
            $pajak = "Hiburan";
        } elseif ($jenispajak == '5') {
            $pajak = "PPJ / Genset";
        } elseif ($jenispajak == '7') {
            $pajak = "Parkir";
        }

        $data['pajak'] = $pajak;


        //$mpdf = new \Mpdf\Mpdf();
        $this->template->load('layoutbackend', 'esptpd/esptpd_billing_prt', $data);

        //$html = $this->load->view('esptpd/esptpd_billing_prt', $data, TRUE);
        //$mpdf->WriteHTML($html);
        //$mpdf->Output();
    }

    public function espt_group_prt()
    {
        // $billing_id =  $this->uri->segment(3);
        $userid = $this->session->userdata('id_user');
        $periode = $this->input->post('periode');
        $jual1 = $this->input->post('spt_periode_jual1');
        $jual2 = $this->input->post('spt_periode_jual2');
        $data['billing_induk'] = $this->Mod_esptpd->get_group_billing($periode, $jual1, $jual2, $this->session->userdata('id_user'));
        $data['billing_anak'] = $this->Mod_esptpd->get_group_billing_det($periode, $jual1, $jual2, $this->session->userdata('id_user'));

        $mpdf = new \Mpdf\Mpdf();
        // $this->template->load('layoutbackend', 'esptpd/esptpd_group_prt', $data);

        $html = $this->load->view('esptpd/esptpd_group_prt', $data, TRUE);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_esptpd->get_datatables();
        $data = array();
        $no = $_POST['start'];

        $stat_arr = array(
            "0" => "<i class='far fa-times-circle' style='color:red;'></i> <span class='text-danger'>Blm Lunas</span>",
            "1" => "<i class='far fa-check-circle' style='color:green;'></i><span class='text-success'> Lunas</span>",
            "2" => "<span class='text-secondary'> Nihil</span>"
        );

        foreach ($list as $biling) {
            $no++;
            $tgljatuhtempo = date('Y-m-d', strtotime('+1 month', strtotime($biling->masa_pajak1)));
            $explode = explode('-', $biling->masa_pajak1);
            $t_entry = date("Y-m-t", strtotime($tgljatuhtempo));
            $sanksi_lapor = 0;

            $jml_denda = $this->fungsi->denda($t_entry, date("Y-m-d"), $biling->pajak);

            if (date('Y-m-d') >= '2025-08-01' && date('Y-m-d') <= '2025-09-30') {
                $jml_denda = 0;
            }

            if ($biling->status_bayar == 0) {
                $denda = $jml_denda;
                $total_bayar = $biling->pajak + $jml_denda + $sanksi_lapor;
            } else {
                $denda = 0;
                $total_bayar = $biling->pajak;
            }

            $bln_pajak = date("m", strtotime($biling->masa_pajak1));
            $bln_kemarin = date("m", mktime(0, 0, 0, date("m") - 1));

            $thn_pajak = date("Y", strtotime($biling->masa_pajak1));
            //$thn_kemarin = date("Y", mktime(0, 0, 0, date("Y")-1 ));

            $t = date('Y');
            $b = date('m');
            $masa_aktiv =  $b = date('m'); //$t."-".$b;

            $masa_entri = substr($biling->masa_pajak1, 5, 2);
            $thn_entri = substr($biling->masa_pajak1, 0, 4);


            if ($masa_entri == $bln_kemarin and $thn_entri == $t) {
                if ($biling->status_bayar == '0') {
                    if ($biling->pajak < 1) {
                        // $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/editesptpd/' . $biling->spt_id . '/' . $biling->pajak_id) . "><i class=\"fas fa-edit\"></i> Edit</a>
                        // <a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Esptpd</a>
                        // <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\"  data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                        // <a class=\"btn btn-xs btn-outline-warning\" id=\"lampiran\" href=\"javascript:void(0)\" title=\"Lampiran\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-link\"> Lampiran</i></a>
                        // <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"Hapus\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>";
                        $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/edit_generate_billing/' . $biling->spt_id . '/' . $biling->pajak_id) . "><i class=\"fas fa-edit\"></i> Edit</a>
                        <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\"  data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                        <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"Hapus\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>";
                    } else {
                        // $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/editesptpd/' . $biling->spt_id . '/' . $biling->pajak_id) . "><i class=\"fas fa-edit\"></i> Edit</a>
                        // <a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Esptpd</a>
                        // <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                        // <a class=\"btn btn-xs btn-outline-warning\" id=\"lampiran\" href=\"javascript:void(0)\" title=\"Lampiran\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-link\"> Lampiran</i></a>
                        // <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"Hapus\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>
                        // <a class=\"btn btn-xs btn-outline-success\" id=\"bayar\" href=\"https://e-pada.blitarkab.go.id/portal_payment/pdl/tagihan_sptpd.php?kode_billing=" . $biling->kode_billing . "\" title=\"Bayar\" target=\"_blank\"><i class=\"fas fa-money\"> Bayar</i></a>";
                        $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/edit_generate_billing/' . $biling->spt_id . '/' . $biling->pajak_id) . "><i class=\"fas fa-edit\"></i> Edit</a>
                        <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                        <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"Hapus\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>";
                    }
                } else {
                    if ($biling->tgl_lapor == null) {
                        $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/lapor_pajak/' . $biling->spt_id . '/' . $biling->pajak_id . '/' . $biling->kode_billing) . "><i class=\"fas fa-edit\"></i> Lapor Pajak</a>
                            <a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Esptpd</a>
                            <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                            <a class=\"btn btn-xs btn-outline-warning\" id=\"lampiran\" href=\"javascript:void(0)\" title=\"Lampiran\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-link\"></i> Lampiran</a>";
                    } else {
                        $aksi = "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Esptpd</a>
                            <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                            <a class=\"btn btn-xs btn-outline-warning\" id=\"lampiran\" href=\"javascript:void(0)\" title=\"Lampiran\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-link\"> Lampiran</i></a>";
                    }
                }
            } else {
                if ($biling->status_bayar == '0') {
                    if ($biling->pajak < 1) {
                        // $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/editesptpd/' . $biling->spt_id . '/' . $biling->pajak_id) . "><i class=\"fas fa-edit\"></i> Edit</a>
                        // <a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Esptpd</a>
                        // <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>˙
                        // <a class=\"btn btn-xs btn-outline-warning\" id=\"lampiran\" href=\"javascript:void(0)\" title=\"Lampiran\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-link\"> Lampiran</i></a>
                        // <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"Hapus\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>";
                        $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/edit_generate_billing/' . $biling->spt_id . '/' . $biling->pajak_id) . "><i class=\"fas fa-edit\"></i> Edit</a>
                        <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                        <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"Hapus\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>";
                    } else {
                        // $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/editesptpd/' . $biling->spt_id . '/' . $biling->pajak_id) . "><i class=\"fas fa-edit\"></i> Edit</a>
                        // <a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Esptpd</a>
                        // <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>˙
                        // <a class=\"btn btn-xs btn-outline-warning\" id=\"lampiran\" href=\"javascript:void(0)\" title=\"Lampiran\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-link\"> Lampiran</i></a>
                        // <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"Hapus\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>
                        // <a class=\"btn btn-xs btn-outline-success\" id=\"bayar\" href=\"https://e-pada.blitarkab.go.id//portal_payment/pdl/tagihan_sptpd.php?kode_billing=" . $biling->kode_billing . "\" title=\"Bayar\" target=\"_blank\"><i class=\"fas fa-money\"> Bayar</i></a>";
                        $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/edit_generate_billing/' . $biling->spt_id . '/' . $biling->pajak_id) . "><i class=\"fas fa-edit\"></i> Edit</a>
                        <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                        <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"Hapus\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>";
                    }
                } else {
                    if ($biling->tgl_lapor == null) {
                        $aksi = "<a class=\"btn btn-xs btn-outline-primary\" href=" . base_url('esptpd/lapor_pajak/' . $biling->spt_id . '/' . $biling->pajak_id . '/' . $biling->kode_billing) . "><i class=\"fas fa-edit\"></i> Lapor Pajak</a>
                        <a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Esptpd</a>
                        <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                        <a class=\"btn btn-xs btn-outline-warning\" id=\"lampiran\" href=\"javascript:void(0)\" title=\"Lampiran\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-link\"></i> Lampiran</a>";
                    } else {
                        $aksi = "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Esptpd</a>
                        <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Billing</a>
                        <a class=\"btn btn-xs btn-outline-warning\" id=\"lampiran\" href=\"javascript:void(0)\" title=\"Lampiran\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-link\"> Lampiran</i></a>";
                    }
                }
            }

            if ($biling->pajak_id == 7) {
                $aksi = "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" target=\"_blank\" data-href=" . $biling->spt_id . "/" . $biling->pajak_id . "><i class=\"fas fa-print\"></i> Esptpd</a>
                        <a class=\"btn btn-xs btn-outline-warning\" id=\"lampiran\" href=\"javascript:void(0)\" title=\"Lampiran\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-link\"> Lampiran</i></a>";
            }

            if ($biling->tgl_lapor == null) {
                if ($explode[0] <= '2023' && $explode[1] <= '16') {
                    if ($explode_entry[0] >= '2024') {
                        $status_lapor = "<i class='far fa-times-circle' style='color:red;'></i> <span class='text-danger'>Blm Lapor</span>";
                        $tgl_lapor = '-';
                    } else {
                        $status_lapor = "<i class='far fa-check-circle' style='color:green;'></i><span class='text-success'>Sudah Lapor</span>";
                        $tgl_lapor = '-';
                    }
                } else {
                    $status_lapor = "<i class='far fa-times-circle' style='color:red;'></i> <span class='text-danger'>Blm Lapor</span>";
                    $tgl_lapor = '-';
                }
            } else {
                $status_lapor = "<i class='far fa-check-circle' style='color:green;'></i><span class='text-success'>Sudah Lapor</span>";
                $tgl_lapor = $biling->tgl_lapor;
            }

            $row = array();
            $row[] = $biling->spt_id;
            $row[] = $biling->tgl_proses;
            $row[] = $biling->tahun_pajak;
            $row[] = $biling->masa_pajak1 . ' s/d ' . $biling->masa_pajak2;
            $row[] = $t_entry;
            $row[] = number_format($biling->pajak, 0, ',', '.');
            $row[] = number_format($denda, 0, ',', '.');
            $row[] = number_format($sanksi_lapor, 0, ',', '.');
            $row[] = number_format($total_bayar, 0, ',', '.');
            if ($biling->pajak_id == 7) {
                $row[] = null;
            } else {
                $row[] = $biling->kode_billing;
            }
            if ($biling->pajak < 1) {
                $row[] = $stat_arr[1];
            } else {
                $row[] = $stat_arr[$biling->status_bayar];
            }
            $row[] = $status_lapor;
            $row[] = $tgl_lapor;
            $row[] = $aksi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_esptpd->count_all(),
            "recordsFiltered" => $this->Mod_esptpd->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function add($wp_wr_detil_id)
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

        // $list_spt = $this->Mod_esptpd->_get_data_SPPT($apl->npwprd);
        $list_spt = $this->Mod_esptpd->_get_data_SPPT($wp_wr_detil_id);
        $masa_awal = $list_spt->masa_pajak1;
        $masa_akhir = $list_spt->masa_pajak2;

        if (date("m", strtotime($masa_awal)) == '12') {
            $bulan_ke = '1';
            $periode_thn = date('Y');
        } elseif ($masa_awal  == NULL) {
            $periode_thn = date("Y");
            $masa_awal = date('Y-m-d');
            $bulan_ke    = date("m", strtotime($masa_awal)) - 1;
            // var_dump(date($periode_thn . "-" . $bulan_ke . "-01"));
        } else {
            $periode_thn = date("Y", strtotime($masa_awal));
            $bulan_ke    = date("m", strtotime($masa_awal)) + 1;
        }

        $hari_ini =  date($periode_thn . "-" . $bulan_ke . "-01"); //date("Y-m-d");
        $tgl_pertama = date('Y-m-01', strtotime($hari_ini));
        $tgl_terakhir = date('Y-m-t', strtotime($tgl_pertama));

        $jenis_mblb = $this->Mod_esptpd->getJenisMblb();
        $data['jenis_mblb'] = $jenis_mblb;

        $data['masa_awal'] = $tgl_pertama;
        $data['masa_akhir'] = $tgl_terakhir;
        $data['periode_thn'] = $periode_thn;

        if ($apl->pajak_id == 1) {
            $add_form =  "esptpd_hotel";
        } elseif ($apl->pajak_id == 2) {
            $add_form =  "esptpd_resto";
        } elseif ($apl->pajak_id == 4) {
            $add_form =  "esptpd_hiburan";
        } elseif ($apl->pajak_id == 6) {
            $add_form =  "esptpd_minerba";
        } elseif ($apl->pajak_id == 7) {
            $add_form =  "esptpd_abt";
        } elseif ($apl->pajak_id == 11) {
            $add_form =  "esptpd_parkir";
        } else {
            $add_form = " ";
        }

        $this->template->load('layoutbackend', 'esptpd/' . $add_form, $data);
    }

    function create_billing($wp_wr_detil_id)
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

        // $list_spt = $this->Mod_esptpd->_get_data_SPPT($apl->npwprd);
        $list_spt = $this->Mod_esptpd->_get_data_SPPT($wp_wr_detil_id);
        $masa_awal = $list_spt->masa_pajak1;
        $masa_akhir = $list_spt->masa_pajak2;

        if (date("m", strtotime($masa_awal)) == '12') {
            $bulan_ke = '1';
            $periode_thn = date('Y');
        } elseif ($masa_awal  == NULL) {
            $periode_thn = date("Y");
            $masa_awal = date('Y-m-d');
            $bulan_ke    = date("m", strtotime($masa_awal)) - 1;
            // var_dump(date($periode_thn . "-" . $bulan_ke . "-01"));
        } else {
            $periode_thn = date("Y", strtotime($masa_awal));
            $bulan_ke    = date("m", strtotime($masa_awal)) + 1;
        }

        $hari_ini =  date($periode_thn . "-" . $bulan_ke . "-01"); //date("Y-m-d");
        $tgl_pertama = date('Y-m-01', strtotime($hari_ini));
        $tgl_terakhir = date('Y-m-t', strtotime($tgl_pertama));

        $data['masa_awal'] = $tgl_pertama;
        $data['masa_akhir'] = $tgl_terakhir;
        $data['periode_thn'] = $periode_thn;

        $add_form =  "create_billing";

        $this->template->load('layoutbackend', 'esptpd/' . $add_form, $data);
    }

    function get_tarif_dasar()
    {
        $mblb_id = $this->input->post('mblb_id');
        $satuan = $this->input->post('satuan');
        $data = $this->Mod_esptpd->getTarifDasar($mblb_id, $satuan);

        echo json_encode($data);
    }

    function editesptpd()
    {
        // error_reporting(~E_NOTICE);
        $spt_id =  $this->uri->segment(3);
        $jns_pajak =  $this->uri->segment(4);

        if ($jns_pajak == 1) {
            $add_form =  "esptpd_hotel_ed";
        } elseif ($jns_pajak == 6) {
            $add_form =  "esptpd_minerba_ed";
        } elseif ($jns_pajak == 4) {
            $add_form =  "esptpd_hiburan_ed";
        } elseif ($jns_pajak == 11) {
            $add_form =  "esptpd_parkir_ed";
        } elseif ($jns_pajak == 2) {
            $add_form =  "esptpd_resto_ed";
        } elseif ($jns_pajak == 7) {
            $add_form =  "esptpd_abt_ed";
        } else {
            $add_form =  "";
        }

        $spt_id =  $this->uri->segment(3);
        $jenispajak  =  $this->uri->segment(4);

        $list = $this->Mod_esptpd->_get_data_wp($spt_id);
        foreach ($list as $billing) {
            $data['spt_id'] = $billing->spt_id;
            $data['wp_wr_id'] = $billing->wp_wr_id;
            $data['spt_periode'] = $billing->tahun_pajak;
            $data['spt_periode_jual1'] = $billing->masa_pajak1;
            $data['spt_periode_jual2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->pajak;
            $data['nama'] = $billing->nama;
            $data['alamat'] = $billing->alamat;
            $data['kode_billing'] = $billing->kode_billing;
            $data['status_bayar'] = $billing->status_bayar;
            $data['spt_golongan'] = $billing->golongan;
            $data['spt_jenispajak'] = $billing->jenis;
            $data['npwprd'] = $billing->npwprd;
            $data['kelurahan'] = $billing->kelurahan;
            $data['kecamatan'] = $billing->kecamatan;
            $data['kota'] = $billing->kabupaten;
        }

        $data_mblb = $this->Mod_esptpd->_get_data_mblb($spt_id);
        $data_abt = $this->Mod_esptpd->_get_data_abt($spt_id);
        $list_mblb = $this->Mod_esptpd->getJenisMblb();
        $data['list_mblb'] = $list_mblb;
        $data['volume'] = $data_mblb->volume;
        $data['tarif_dasar'] = $data_mblb->tarif_dasar;
        $data['nilai_jual'] = $data_mblb->nilai_jual;
        $data['jenis_mblb'] = $data_mblb->jenis_mblb;
        $data['mblb_id'] = $data_mblb->mblb_id;
        $data['data_abt'] = $data_abt;

        $masa_awal = $billing->masa_pajak1;
        $masa_akhir = $billing->masa_pajak2;

        $data['masa_awal'] = $masa_awal;
        $data['masa_akhir'] = $masa_akhir;
        $data['spt_dt_jumlah'] = $billing->nilai_terkena_pajak;
        $data['spt_dt_persen_tarif'] = $billing->persen_tarif;
        $data['tarif_dasar'] = $billing->tarif_dasar;
        $data['dasar_pengenaan'] = $billing->nilai_terkena_pajak;

        $this->template->load('layoutbackend', 'esptpd/' . $add_form, $data);
    }

    function edit_generate_billing()
    {
        // error_reporting(~E_NOTICE);
        $spt_id =  $this->uri->segment(3);
        $jns_pajak =  $this->uri->segment(4);

        $add_form =  "edit_billing";

        $spt_id =  $this->uri->segment(3);
        $jenispajak  =  $this->uri->segment(4);

        $list = $this->Mod_esptpd->_get_data_wp($spt_id);
        foreach ($list as $billing) {
            $data['spt_id'] = $billing->spt_id;
            $data['wp_wr_id'] = $billing->wp_wr_id;
            $data['spt_periode'] = $billing->tahun_pajak;
            $data['spt_periode_jual1'] = $billing->masa_pajak1;
            $data['spt_periode_jual2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->pajak;
            $data['nama'] = $billing->nama;
            $data['alamat'] = $billing->alamat;
            $data['kode_billing'] = $billing->kode_billing;
            $data['status_bayar'] = $billing->status_bayar;
            $data['spt_golongan'] = $billing->golongan;
            $data['spt_jenispajak'] = $billing->jenis;
            $data['npwprd'] = $billing->npwprd;
            $data['kelurahan'] = $billing->kelurahan;
            $data['kecamatan'] = $billing->kecamatan;
            $data['kota'] = $billing->kabupaten;
        }

        $data_mblb = $this->Mod_esptpd->_get_data_mblb($spt_id);
        $data_abt = $this->Mod_esptpd->_get_data_abt($spt_id);
        $list_mblb = $this->Mod_esptpd->getJenisMblb();
        $data['list_mblb'] = $list_mblb;
        $data['volume'] = $data_mblb->volume;
        $data['tarif_dasar'] = $data_mblb->tarif_dasar;
        $data['nilai_jual'] = $data_mblb->nilai_jual;
        $data['jenis_mblb'] = $data_mblb->jenis_mblb;
        $data['mblb_id'] = $data_mblb->mblb_id;
        $data['data_abt'] = $data_abt;

        $masa_awal = $billing->masa_pajak1;
        $masa_akhir = $billing->masa_pajak2;

        $data['masa_awal'] = $masa_awal;
        $data['masa_akhir'] = $masa_akhir;
        $data['spt_dt_jumlah'] = $billing->nilai_terkena_pajak;
        $data['spt_dt_persen_tarif'] = $billing->persen_tarif;
        $data['tarif_dasar'] = $billing->tarif_dasar;
        $data['dasar_pengenaan'] = $billing->nilai_terkena_pajak;

        $this->template->load('layoutbackend', 'esptpd/' . $add_form, $data);
    }

    function kode_spt($kode_spt, $kd_jns)
    {
        $kode_spt = $this->Mod_esptpd->_get_reg_spt($kode_spt, $kd_jns);
        $next_spt_no_register = $this->fungsi->tambah_nol($kode_spt, 4);

        return $next_spt_no_register;
    }

    function next_spt_no_register()
    {
        $spt_periode  = $this->input->post('periode');
        $kd_jns       = $this->input->post('pajret');
        $kode_spt     = $this->input->post('spt_kode');

        $kode_spt = $this->Mod_esptpd->next_spt_no_register($spt_periode, $kode_spt, $kd_jns);
        $next_spt_no_register = $this->fungsi->tambah_nol($kode_spt, 4);

        echo json_encode(array("nomor" => $next_spt_no_register));
    }

    function get_tarif()
    {
        $korek_id  = $this->input->post('rek_id');
        $tarif = $this->Mod_esptpd->_get_tarif($korek_id);

        echo json_encode(array("nilai" => $tarif));
    }

    function get_korek()
    {
        $korek_id  = $this->input->get('korek');
        $kode_rek = $this->Mod_esptpd->_get_korek($korek_id);
        echo json_encode($kode_rek);
    }

    public function insert()
    {
        // $this->_validate();
        $spt_nilai = $this->input->post('spt_nilai');
        if ($spt_nilai != '') {
            $spt_nilai = str_replace('.', '', $spt_nilai);
            $spt_nilai = substr($spt_nilai, 0, -3);
        }

        $spt_pajak = $this->input->post('spt_pajak');
        if ($spt_pajak != '') {
            $spt_pajak = str_replace('.', '', $spt_pajak);
            $spt_pajak = substr($spt_pajak, 0, -3);
        }

        $spt_id = $this->Mod_esptpd->next_val('spt_spt_id_seq');
        $spt_detil_id = $this->Mod_esptpd->next_val('spt_detil_spt_detil_id_seq');

        $kode_billing = $this->Mod_esptpd->generate_billing('1', $this->input->post('jenput_id')); //101479080320166688

        $pajak_id = $this->input->post('spt_jenis');

        $nomor_spt = $this->Mod_esptpd->generate_spt_number($pajak_id);

        $nama = $kode_billing;
        $config['upload_path']   = './assets/foto/lampiran/';
        $config['allowed_types'] = 'pdf|png|jpg|jpeg'; //mencegah upload backdor
        $config['max_size']      = '1000';
        $config['max_width']     = '2000';
        $config['max_height']    = '1024';
        $config['file_name']     = $nama;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('imagefile')) {
            $gambar = $this->upload->data();

            if ($pajak_id == 7) {
                $save  = array(
                    'spt_id' => $spt_id,
                    'pajak_id' => $pajak_id,
                    'wp_wr_id' => $this->input->post('wp_id'),
                    'wp_wr_detil_id' => $this->input->post('wp_id_detil'),
                    'npwprd' => $this->input->post('npwpd'),
                    'wp_wr_paten' => true,
                    'jenis_spt_id' => '1',
                    'nomor_spt' => $nomor_spt + 1,
                    'tahun_pajak' => $this->input->post('spt_periode'),
                    'masa_pajak1' =>  $this->input->post('spt_periode_jual1'),
                    'masa_pajak2' =>  $this->input->post('spt_periode_jual2'),
                    'jenis_pemungutan_id' => $this->input->post('jenput_id'),
                    'nilai_terkena_pajak' => $spt_nilai,
                    'pajak' => $spt_pajak,
                    'tgl_proses' => date('Y-m-d'),
                    'persen_tarif' => $this->input->post('korek_persen_tarif'),
                    'kode_billing' => $kode_billing,
                    'status_ketetapan' => '0',
                    'status_bayar' => '0',
                    'created_by' => $this->session->userdata('username'),
                    'created_time' => date('Y-m-d H:i:s'),
                    'modified_time' => date('Y-m-d H:i:s'),
                    'image' => $gambar['file_name']
                );
            } else {
                $save  = array(
                    'spt_id' => $spt_id,
                    'pajak_id' => $pajak_id,
                    'wp_wr_id' => $this->input->post('wp_id'),
                    'wp_wr_detil_id' => $this->input->post('wp_id_detil'),
                    'npwprd' => $this->input->post('npwpd'),
                    'wp_wr_paten' => true,
                    'jenis_spt_id' => '8',
                    'nomor_spt' => $nomor_spt + 1,
                    'tahun_pajak' => $this->input->post('spt_periode'),
                    'masa_pajak1' =>  $this->input->post('spt_periode_jual1'),
                    'masa_pajak2' =>  $this->input->post('spt_periode_jual2'),
                    'jenis_pemungutan_id' => $this->input->post('jenput_id'),
                    'nilai_terkena_pajak' => $spt_nilai,
                    'pajak' => $spt_pajak,
                    'tgl_proses' => date('Y-m-d'),
                    'persen_tarif' => $this->input->post('korek_persen_tarif'),
                    'kode_billing' => $kode_billing,
                    'status_ketetapan' => '1',
                    'status_bayar' => '0',
                    'created_by' => $this->session->userdata('username'),
                    'created_time' => date('Y-m-d H:i:s'),
                    'modified_time' => date('Y-m-d H:i:s'),
                    'image' => $gambar['file_name']
                );
            }
        } else { //Apabila tidak ada gambar yang di upload
            if ($pajak_id == 7) {
                $save  = array(
                    'spt_id' => $spt_id,
                    'pajak_id' => $pajak_id,
                    'wp_wr_id' => $this->input->post('wp_id'),
                    'wp_wr_detil_id' => $this->input->post('wp_id_detil'),
                    'npwprd' => $this->input->post('npwpd'),
                    'wp_wr_paten' => true,
                    'jenis_spt_id' => '1',
                    'nomor_spt' => $nomor_spt + 1,
                    'tahun_pajak' => $this->input->post('spt_periode'),
                    'masa_pajak1' =>  $this->input->post('spt_periode_jual1'),
                    'masa_pajak2' =>  $this->input->post('spt_periode_jual2'),
                    'jenis_pemungutan_id' => $this->input->post('jenput_id'),
                    'nilai_terkena_pajak' => $spt_nilai,
                    'pajak' => $spt_pajak,
                    'tgl_proses' => date('Y-m-d'),
                    'persen_tarif' => $this->input->post('korek_persen_tarif'),
                    'kode_billing' => $kode_billing,
                    'status_ketetapan' => '0',
                    'status_bayar' => '0',
                    'created_by' => $this->session->userdata('username'),
                    'created_time' => date('Y-m-d H:i:s'),
                    'modified_time' => date('Y-m-d H:i:s')
                );
            } else {
                $save  = array(
                    'spt_id' => $spt_id,
                    'pajak_id' => $pajak_id,
                    'wp_wr_id' => $this->input->post('wp_id'),
                    'wp_wr_detil_id' => $this->input->post('wp_id_detil'),
                    'npwprd' => $this->input->post('npwpd'),
                    'wp_wr_paten' => true,
                    'jenis_spt_id' => '8',
                    'nomor_spt' => $nomor_spt + 1,
                    'tahun_pajak' => $this->input->post('spt_periode'),
                    'masa_pajak1' =>  $this->input->post('spt_periode_jual1'),
                    'masa_pajak2' =>  $this->input->post('spt_periode_jual2'),
                    'jenis_pemungutan_id' => $this->input->post('jenput_id'),
                    'nilai_terkena_pajak' => $spt_nilai,
                    'pajak' => $spt_pajak,
                    'tgl_proses' => date('Y-m-d'),
                    'persen_tarif' => $this->input->post('korek_persen_tarif'),
                    'kode_billing' => $kode_billing,
                    'status_ketetapan' => '1',
                    'status_bayar' => '0',
                    'created_by' => $this->session->userdata('username'),
                    'created_time' => date('Y-m-d H:i:s'),
                    'modified_time' => date('Y-m-d H:i:s')
                );
            }
        }

        $insert_spt =  $this->Mod_esptpd->inserSPT("spt", $save);

        if ($pajak_id == '6') {
            $spt_detil_mblb_id = $this->Mod_esptpd->next_val('spt_detil_mblb_spt_detil_mblb_id_seq');
            $save = array(
                'spt_detil_mblb_id' => $spt_detil_mblb_id,
                'spt_id' => $spt_id,
                'spt_detil_id' => $spt_detil_id,
                'mblb_id' => $this->input->post('spt_jenis_mblb'),
                'volume' => $this->input->post('spt_volume'),
                'tarif_dasar' => $this->input->post('spt_tarif_dasar'),
                'nilai_jual' => $spt_nilai,
            );

            $this->Mod_esptpd->inserSPT("spt_detil_mblb", $save);
        } elseif ($pajak_id == '7') {
            $get_spt_detil_abt_id = $this->Mod_esptpd->getIdAbt();

            if ($get_spt_detil_abt_id->spt_detil_abt_id == null) {
                $spt_detil_abt_id = 1;
            } else {
                $spt_detil_abt_id = $get_spt_detil_abt_id->spt_detil_abt_id + 1;
            }
            $save = array(
                'spt_detil_abt_id' => $spt_detil_abt_id,
                'spt_id' => $spt_id,
                'spt_detil_id' => $spt_detil_id,
                'ptnjk_meter_hari_ini' => (int)$this->input->post('ptnjk_meter_hari_ini'),
                'ptnjk_meter_bulan_lalu' => (int)$this->input->post('ptnjk_meter_bulan_lalu'),
                'ptnjk_meter_volume' => (int)$this->input->post('ptnjk_meter_volume'),
                'bkn_meter_hari' => (int)$this->input->post('bkn_meter_hari'),
                'bkn_meter_bulan' => (int)$this->input->post('bkn_meter_bulan'),
                'bkn_meter_volume' => (int)$this->input->post('bkn_meter_volume'),
                'harga_satuan' => (int)$this->input->post('harga_satuan'),
                'nilai_jual' => (int)$spt_nilai,
            );

            $this->Mod_esptpd->inserSPT("spt_detil_abt", $save);
        }

        if ($insert_spt > 0) {
            // $volume = ($this->input->post('kegus_id') != '') ? $this->input->post('kegus_id') : 0;

            // $save  = array(
            //     'spt_detil_id' => $spt_detil_id,
            //     'spt_id' => $spt_id,
            //     'kegus_id' => $this->input->post('kegus_id'),
            //     'volume' => $volume,
            //     'nilai_terkena_pajak'  => $spt_nilai,
            //     'tarif_dasar'  => 0,
            //     'persen_tarif' => $this->input->post('korek_persen_tarif'),
            //     'pajak' => $spt_pajak
            // );
            $ptnjk_meter_volume = $this->input->post('ptnjk_meter_volume');
            $bkn_meter_volume = $this->input->post('bkn_meter_volume');
            if ($ptnjk_meter_volume != null) {
                $volume = $ptnjk_meter_volume;
            } elseif ($bkn_meter_volume != null) {
                $volume = $bkn_meter_volume;
            }
            $save = array(
                'spt_detil_id' => $spt_detil_id,
                'spt_id' => $spt_id,
                'kegus_id' => $this->input->post('kegus_id'),
                'volume' => $volume,
                'nilai_terkena_pajak'  => $spt_nilai,
                'tarif_dasar'  => $this->input->post('harga_satuan'),
                'persen_tarif' => $this->input->post('korek_persen_tarif'),
                'pajak' => $spt_pajak
            );
            $insert_spt2 = $this->Mod_esptpd->inserSPT("spt_detil", $save);

            if ($insert_spt2 > 0) {
                echo json_encode(array("status" => TRUE, 'spt_id' => $spt_id));
            } else {
                echo json_encode(array(
                    "error" => True,
                    "msg" => "detil laporan  gagal disimpan!!"
                ));
            }
        } else
            echo json_encode(array(
                "error" => True,
                "msg" => "Pelaporan gagal disimpan!!"
            ));
    }

    public function insert_mamin()
    {
        // $this->_validate();
        $spt_nilai = $this->input->post('spt_nilai');
        if ($spt_nilai != '') {
            $spt_nilai = str_replace('.', '', $spt_nilai);
            $spt_nilai = substr($spt_nilai, 0, -3);
        }

        $spt_pajak = $this->input->post('spt_pajak');
        if ($spt_pajak != '') {
            $spt_pajak = str_replace('.', '', $spt_pajak);
            $spt_pajak = substr($spt_pajak, 0, -3);
        }

        $spt_id = $this->Mod_esptpd->next_val('spt_spt_id_seq');
        $spt_detil_id = $this->Mod_esptpd->next_val('spt_detil_spt_detil_id_seq');

        $kode_billing = $this->Mod_esptpd->generate_billing('1', $this->input->post('jenput_id')); //101479080320166688

        $pajak_id = $this->input->post('spt_jenis');

        $nomor_spt = $this->Mod_esptpd->generate_spt_number($pajak_id);

        $nama = $kode_billing;
        $config['upload_path']   = './assets/foto/lampiran/';
        $config['allowed_types'] = 'pdf|png|jpg|jpeg'; //mencegah upload backdor
        $config['max_size']      = '1000';
        $config['max_width']     = '2000';
        $config['max_height']    = '1024';
        $config['file_name']     = $nama;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('imagefile')) {
            $gambar = $this->upload->data();

            $save  = array(
                'spt_id' => $spt_id,
                'pajak_id' => $pajak_id,
                'wp_wr_id' => $this->input->post('wp_id'),
                'wp_wr_detil_id' => $this->input->post('wp_id_detil'),
                'npwprd' => $this->input->post('npwpd'),
                'wp_wr_paten' => true,
                'jenis_spt_id' => '8',
                'nomor_spt' => $nomor_spt + 1,
                'tahun_pajak' => $this->input->post('spt_periode'),
                'masa_pajak1' =>  $this->input->post('spt_periode_jual1'),
                'masa_pajak2' =>  $this->input->post('spt_periode_jual2'),
                'jenis_pemungutan_id' => $this->input->post('jenput_id'),
                'nilai_terkena_pajak' => $spt_nilai,
                'pajak' => $spt_pajak,
                'tgl_proses' => date('Y-m-d'),
                'persen_tarif' => $this->input->post('korek_persen_tarif'),
                'kode_billing' => $kode_billing,
                'status_ketetapan' => '1',
                'status_bayar' => '0',
                'created_by' => $this->session->userdata('username'),
                'created_time' => date('Y-m-d H:i:s'),
                'modified_time' => date('Y-m-d H:i:s'),
                'keterangan' => $this->input->post('keterangan'),
                'pengguna_catering' => $this->input->post('pengguna_catering'),
                'image' => $gambar['file_name']
            );
        } else { //Apabila tidak ada gambar yang di upload
            $save  = array(
                'spt_id' => $spt_id,
                'pajak_id' => $pajak_id,
                'wp_wr_id' => $this->input->post('wp_id'),
                'wp_wr_detil_id' => $this->input->post('wp_id_detil'),
                'npwprd' => $this->input->post('npwpd'),
                'wp_wr_paten' => true,
                'jenis_spt_id' => '8',
                'nomor_spt' => $nomor_spt + 1,
                'tahun_pajak' => $this->input->post('spt_periode'),
                'masa_pajak1' =>  $this->input->post('spt_periode_jual1'),
                'masa_pajak2' =>  $this->input->post('spt_periode_jual2'),
                'jenis_pemungutan_id' => $this->input->post('jenput_id'),
                'nilai_terkena_pajak' => $spt_nilai,
                'pajak' => $spt_pajak,
                'tgl_proses' => date('Y-m-d'),
                'persen_tarif' => $this->input->post('korek_persen_tarif'),
                'kode_billing' => $kode_billing,
                'status_ketetapan' => '1',
                'status_bayar' => '0',
                'created_by' => $this->session->userdata('username'),
                'created_time' => date('Y-m-d H:i:s'),
                'modified_time' => date('Y-m-d H:i:s'),
                'keterangan' => $this->input->post('keterangan'),
                'pengguna_catering' => $this->input->post('pengguna_catering')
            );
        }

        $insert_spt =  $this->Mod_esptpd->inserSPT("spt", $save);

        if ($pajak_id == '6') {
            $spt_detil_mblb_id = $this->Mod_esptpd->next_val('spt_detil_mblb_spt_detil_mblb_id_seq');
            $save = array(
                'spt_detil_mblb_id' => $spt_detil_mblb_id,
                'spt_id' => $spt_id,
                'spt_detil_id' => $spt_detil_id,
                'mblb_id' => $this->input->post('spt_jenis_mblb'),
                'volume' => $this->input->post('spt_volume'),
                'tarif_dasar' => $this->input->post('spt_tarif_dasar'),
                'nilai_jual' => $spt_nilai,
            );

            $this->Mod_esptpd->inserSPT("spt_detil_mblb", $save);
        } elseif ($pajak_id == '7') {
            $get_spt_detil_abt_id = $this->Mod_esptpd->getIdAbt();

            if ($get_spt_detil_abt_id->spt_detil_abt_id == null) {
                $spt_detil_abt_id = 1;
            } else {
                $spt_detil_abt_id = $get_spt_detil_abt_id->spt_detil_abt_id + 1;
            }
            $save = array(
                'spt_detil_abt_id' => $spt_detil_abt_id,
                'spt_id' => $spt_id,
                'spt_detil_id' => $spt_detil_id,
                'ptnjk_meter_hari_ini' => (int)$this->input->post('ptnjk_meter_hari_ini'),
                'ptnjk_meter_bulan_lalu' => (int)$this->input->post('ptnjk_meter_bulan_lalu'),
                'ptnjk_meter_volume' => (int)$this->input->post('ptnjk_meter_volume'),
                'bkn_meter_hari' => (int)$this->input->post('bkn_meter_hari'),
                'bkn_meter_bulan' => (int)$this->input->post('bkn_meter_bulan'),
                'bkn_meter_volume' => (int)$this->input->post('bkn_meter_volume'),
                'harga_satuan' => (int)$this->input->post('harga_satuan'),
                'nilai_jual' => (int)$spt_nilai,
            );

            $this->Mod_esptpd->inserSPT("spt_detil_abt", $save);
        }

        if ($insert_spt > 0) {
            // $volume = ($this->input->post('kegus_id') != '') ? $this->input->post('kegus_id') : 0;

            // $save  = array(
            //     'spt_detil_id' => $spt_detil_id,
            //     'spt_id' => $spt_id,
            //     'kegus_id' => $this->input->post('kegus_id'),
            //     'volume' => $volume,
            //     'nilai_terkena_pajak'  => $spt_nilai,
            //     'tarif_dasar'  => 0,
            //     'persen_tarif' => $this->input->post('korek_persen_tarif'),
            //     'pajak' => $spt_pajak
            // );
            $ptnjk_meter_volume = $this->input->post('ptnjk_meter_volume');
            $bkn_meter_volume = $this->input->post('bkn_meter_volume');
            if ($ptnjk_meter_volume != null) {
                $volume = $ptnjk_meter_volume;
            } elseif ($bkn_meter_volume != null) {
                $volume = $bkn_meter_volume;
            }
            $save = array(
                'spt_detil_id' => $spt_detil_id,
                'spt_id' => $spt_id,
                'kegus_id' => $this->input->post('kegus_id'),
                'volume' => $volume,
                'nilai_terkena_pajak'  => $spt_nilai,
                'tarif_dasar'  => $this->input->post('harga_satuan'),
                'persen_tarif' => $this->input->post('korek_persen_tarif'),
                'pajak' => $spt_pajak
            );
            $insert_spt2 = $this->Mod_esptpd->inserSPT("spt_detil", $save);

            if ($insert_spt2 > 0) {
                echo json_encode(array("status" => TRUE, 'spt_id' => $spt_id));
            } else {
                echo json_encode(array(
                    "error" => True,
                    "msg" => "detil laporan  gagal disimpan!!"
                ));
            }
        } else
            echo json_encode(array(
                "error" => True,
                "msg" => "Pelaporan gagal disimpan!!"
            ));
    }

    public function update()
    {
        $this->_validate();

        $spt_id    = $this->input->post('spt_id');
        $wp_wr_id    = $this->input->post('wp_id');
        $nama    = $this->input->post('kode_billing');

        $spt_nilai = $this->input->post('spt_nilai');
        if ($spt_nilai != '') {
            $spt_nilai = str_replace('.', '', $spt_nilai);
            $spt_nilai = substr($spt_nilai, 0, -3);
        }

        $spt_pajak = $this->input->post('spt_pajak');
        if ($spt_pajak != '') {
            $spt_pajak = str_replace('.', '', $spt_pajak);
            $spt_pajak = substr($spt_pajak, 0, -3);
        }

        $pajak_id = $this->input->post('spt_jenis');

        if ($pajak_id == '6') {
            $save = array(
                'mblb_id' => $this->input->post('spt_jenis_mblb'),
                'volume' => $this->input->post('spt_volume'),
                'tarif_dasar' => $this->input->post('spt_tarif_dasar'),
                'nilai_jual' => $spt_nilai,
            );

            $update_spt_mblb = $this->Mod_esptpd->updateSPTMblb($spt_id, $save);
        } elseif ($pajak_id == '7') {
            $save = array(
                'ptnjk_meter_hari_ini' => (int)$this->input->post('ptnjk_meter_hari_ini'),
                'ptnjk_meter_bulan_lalu' => (int)$this->input->post('ptnjk_meter_bulan_lalu'),
                'ptnjk_meter_volume' => (int)$this->input->post('ptnjk_meter_volume'),
                'bkn_meter_hari' => (int)$this->input->post('bkn_meter_hari'),
                'bkn_meter_bulan' => (int)$this->input->post('bkn_meter_bulan'),
                'bkn_meter_volume' => (int)$this->input->post('bkn_meter_volume'),
                'harga_satuan' => (int)$this->input->post('harga_satuan'),
                'nilai_jual' => (int)$spt_nilai,
            );

            $update_spt_mblb = $this->Mod_esptpd->updateSPTAbt($spt_id, $save);
        }

        $config['upload_path']   = './assets/foto/lampiran/';
        $config['allowed_types'] = 'pdf|png|jpg|jpeg'; //mencegah upload backdor
        $config['max_size']      = '1000';
        $config['max_width']     = '2000';
        $config['max_height']    = '1024';
        $config['file_name']     = $nama;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('imagefile')) {
            $gambar = $this->upload->data();

            $save  = array(
                'tahun_pajak' => $this->input->post('spt_periode'),
                'masa_pajak1' => $this->input->post('spt_periode_jual1'),
                'masa_pajak2' => $this->input->post('spt_periode_jual2'),
                'nilai_terkena_pajak' => $spt_nilai,
                'pajak' => $spt_pajak,
                'image' => $gambar['file_name']
            );
        } else { //Apabila tidak ada gambar yang di upload

            $save  = array(
                'tahun_pajak' => $this->input->post('spt_periode'),
                'masa_pajak1' => $this->input->post('spt_periode_jual1'),
                'masa_pajak2' => $this->input->post('spt_periode_jual2'),
                'nilai_terkena_pajak' => $spt_nilai,
                'pajak' => $spt_pajak
            );
        }
        $update_spt = $this->Mod_esptpd->updateSPT($spt_id, $save);

        if ($update_spt > 0) {
            $ptnjk_meter_volume = $this->input->post('ptnjk_meter_volume');
            $bkn_meter_volume = $this->input->post('bkn_meter_volume');
            if ($ptnjk_meter_volume != null) {
                $volume = $ptnjk_meter_volume;
            } elseif ($bkn_meter_volume != null) {
                $volume = $bkn_meter_volume;
            }
            $save  = array(
                'volume' => $volume,
                'nilai_terkena_pajak'  => $spt_nilai,
                'tarif_dasar'  => $this->input->post('harga_satuan'),
                'pajak' => $spt_pajak
            );

            $this->Mod_esptpd->updateSPTDetil($spt_id, $save);

            echo json_encode(array("status" => TRUE));
        } else
            echo json_encode(array(
                "error" => True,
                "msg" => "Pelaporan gagal disimpan!!"
            ));
    }

    public function update_billing()
    {
        $spt_id = $this->input->post('spt_id');
        $spt_nilai = $this->input->post('spt_nilai');
        if ($spt_nilai != '') {
            $spt_nilai = str_replace('.', '', $spt_nilai);
            $spt_nilai = substr($spt_nilai, 0, -3);
        }

        $spt_pajak = $this->input->post('spt_pajak');
        if ($spt_pajak != '') {
            $spt_pajak = str_replace('.', '', $spt_pajak);
            $spt_pajak = substr($spt_pajak, 0, -3);
        }

        $save  = array(
            'tahun_pajak' => $this->input->post('spt_periode'),
            'masa_pajak1' => $this->input->post('spt_periode_jual1'),
            'masa_pajak2' => $this->input->post('spt_periode_jual2'),
            'nilai_terkena_pajak' => $spt_nilai,
            'pajak' => $spt_pajak
        );

        $update_spt = $this->Mod_esptpd->updateSPT($spt_id, $save);

        if ($update_spt > 0) {
            $save  = array(
                'nilai_terkena_pajak'  => $spt_nilai,
                'pajak' => $spt_pajak
            );

            $this->Mod_esptpd->updateSPTDetil($spt_id, $save);

            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array(
                "error" => True,
                "msg" => "Pelaporan gagal disimpan!!"
            ));
        }
    }

    public function insert_hp()
    {

        // var_dump($_POST);

        $this->_validate_hp();

        $wp_no_registrasi  = substr($this->input->post('npwpd'), 7, 7);
        $spt_nomor = $this->input->post('kd_spt') . "" . $this->input->post('no_sptpd');
        $spt_nomor = (int) $spt_nomor;

        $spt_nilai = $this->input->post('spt_nilai');
        if ($spt_nilai != '') {
            $spt_nilai = str_replace('.', '', $spt_nilai);
            $spt_nilai = substr($spt_nilai, 0, -3);
        }

        $spt_pajak = $this->input->post('spt_pajak');
        if ($spt_pajak != '') {
            $spt_pajak = str_replace('.', '', $spt_pajak);
            $spt_pajak = substr($spt_pajak, 0, -3);
        }

        if ($spt_pajak < 300000)
            $sts_bayar = 2;
        else
            $sts_bayar = 0;

        $kode_billing = $spt_nomor . date("dmy") . rand(1111, 9999); //101479080320166688

        $cek = $this->Mod_esptpd->_cekSPT_nomor($spt_nomor, $this->input->post('spt_periode'), $this->input->post('spt_jenis'));
        if ($cek  > 0) {
            echo json_encode(array(
                "error" => True,
                "msg" => "Nomor SPT Sudah Ada!!. Silahkan refresh SPTPD lalu klik simpan"
            ));
        } else {
            $nama = $kode_billing;
            $config['upload_path']   = './assets/foto/lampiran/';
            $config['allowed_types'] = 'pdf|png|jpg|jpeg'; //mencegah upload backdor
            $config['max_size']      = '1000';
            $config['max_width']     = '2000';
            $config['max_height']    = '1024';
            $config['file_name']     = $nama;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('imagefile')) {
                $gambar = $this->upload->data();

                $save  = array(
                    'spt_periode' => $this->input->post('spt_periode'),
                    'spt_kode' => $this->input->post('kd_spt'),
                    'spt_no_register'  => $this->input->post('no_sptpd'),
                    'spt_nomor'  => $spt_nomor,
                    'spt_kode_rek' => $this->input->post('kd_rekening'),
                    'spt_periode_jual1' => $this->input->post('spt_periode_jual1'),
                    'spt_periode_jual2' => $this->input->post('spt_periode_jual2'),
                    'spt_status' => $this->input->post('spt_status'),
                    'spt_pajak' => $spt_pajak,
                    'spt_operator' => '0',
                    'spt_jenis_pajakretribusi' => $this->input->post('spt_jenis'),
                    'spt_idwpwr' => $this->input->post('wp_id'),
                    'spt_jenis_pemungutan' => '1',
                    'spt_tgl_proses' => date('Y-m-d'),
                    'spt_tgl_entry' => date('Y-m-d'),
                    'spt_idwp_reklame' => null,
                    'spt_kode_billing' => $kode_billing,
                    'status_bayar' => $sts_bayar,
                    'image' => $gambar['file_name']
                );

                $this->Mod_esptpd->inserSPT("spt", $save);

                $spt_id = $this->Mod_esptpd->_getSPT_id();

                $save  = array(
                    'spt_dt_id_spt' => $spt_id,
                    'spt_dt_korek' => $this->input->post('kode_rekening_id'),
                    'spt_dt_jumlah'  => $spt_nilai,
                    'spt_dt_tarif_dasar'  => 0,
                    'spt_dt_persen_tarif' => $this->input->post('korek_persen_tarif'),
                    'spt_dt_pajak' => $spt_pajak
                );
                $this->Mod_esptpd->inserSPT("spt_detail", $save);

                echo json_encode(array("status" => TRUE));
            } else { //Apabila tidak ada gambar yang di upload
                $save  = array(
                    'spt_periode' => $this->input->post('spt_periode'),
                    'spt_kode' => $this->input->post('kd_spt'),
                    'spt_no_register'  => $this->input->post('no_sptpd'),
                    'spt_nomor'  => $spt_nomor,
                    'spt_kode_rek' => $this->input->post('kd_rekening'),
                    'spt_periode_jual1' => $this->input->post('spt_periode_jual1'),
                    'spt_periode_jual2' => $this->input->post('spt_periode_jual2'),
                    'spt_status' => $this->input->post('spt_status'),
                    'spt_pajak' => $spt_pajak,
                    'spt_operator' => '0',
                    'spt_jenis_pajakretribusi' => $this->input->post('spt_jenis'),
                    'spt_idwpwr' => $this->input->post('wp_id'),
                    'spt_jenis_pemungutan' => '1',
                    'spt_tgl_proses' => date('Y-m-d'),
                    'spt_tgl_entry' => date('Y-m-d'),
                    'spt_idwp_reklame' => null,
                    'spt_kode_billing' => $kode_billing,
                    'status_bayar' => $sts_bayar
                );

                // var_dump($save);

                $this->Mod_esptpd->inserSPT("spt", $save);
                $spt_id = $this->Mod_esptpd->_getSPT_id();
                foreach ($this->input->post('spt_dt_korek') as $key => $value) {

                    if (!empty($value)) {
                        $arr_korek = explode(",", $this->input->post('spt_dt_korek')[$key]);
                        $spt_nilai = str_replace('.', '', $this->input->post('spt_dt_dasar_pengenaan')[$key]);
                        $spt_nilai = substr($spt_nilai, 0, -3);
                        $spt_pajak = str_replace('.', '', $this->input->post('spt_dt_pajak')[$key]);
                        $spt_pajak = substr($spt_pajak, 0, -3);
                        $spt_persen = $this->input->post('spt_dt_persen_tarif')[$key];
                        $save  = array(
                            'spt_dt_id_spt' => $spt_id,
                            'spt_dt_korek' => $arr_korek[0],
                            'spt_dt_jumlah'  => $spt_nilai,
                            'spt_dt_tarif_dasar'  => 0,
                            'spt_dt_persen_tarif' => $spt_persen,
                            'spt_dt_pajak' => $spt_pajak
                        );
                    }
                    $this->Mod_esptpd->inserSPT("spt_detail", $save);
                }


                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function register_insert()
    {
        // var_dump($this->input->post());
        $stat_regis = ($this->input->post('stat_regis') == '') ? 0 : $this->input->post('stat_regis');
        $save  = array(
            'spt_id' => $this->input->post('no_pelayanan'),
            'id_billing' => $this->input->post('id_billing'),
            'masa_awal' => $this->input->post('masa_awal'),
            'masa_akhir' => $this->input->post('masa_akhir'),
            'periode_spt' => $this->input->post('spt_periode'),
            'spt_pajak' =>  str_replace(',', '', $this->input->post('spt_pajak')),
            'keterangan' => $this->input->post('ket_register'),
            'stat_register' =>  $stat_regis,
            'tgl_pelayanan' => date('Y-m-d'),
            'id_perekam' =>    $this->session->userdata('id_user')
        );

        $this->Mod_esptpd->insertPelayanan("tbl_pelayanan", $save);
        echo json_encode(array("status" => TRUE));
    }


    public function register_save()
    {
        // var_dump($this->input->post());

        $stat_regis = ($this->input->post('stat_regis') == '') ? 0 : $this->input->post('stat_regis');
        $act =  $this->input->post('act');
        if ($act == 'edit') {

            $id_billing      = $this->input->post('id_billing');

            $save  = array(
                'keterangan' => $this->input->post('ket_register'),
                'stat_register' =>  $stat_regis,
                'tgl_pelayanan' => date('Y-m-d'),
                'id_perekam' =>    $this->session->userdata('id_user')
            );
            $this->Mod_esptpd->updatePelayanan($id_billing, $save);
            echo json_encode(array("status" => TRUE));
        } else {

            $save  = array(
                'spt_id' => $this->input->post('no_pelayanan'),
                'id_billing' => $this->input->post('id_billing'),
                'masa_awal' => $this->input->post('masa_awal'),
                'masa_akhir' => $this->input->post('masa_akhir'),
                'periode_spt' => $this->input->post('spt_periode'),
                'spt_pajak' =>  str_replace(',', '', $this->input->post('spt_pajak')),
                'keterangan' => $this->input->post('ket_register'),
                'stat_register' =>  $stat_regis,
                'tgl_pelayanan' => date('Y-m-d'),
                'id_perekam' =>    $this->session->userdata('id_user')
            );

            $this->Mod_esptpd->insertPelayanan("tbl_pelayanan", $save);
            echo json_encode(array("status" => TRUE));
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('spt_nilai') == '' || $this->input->post('spt_nilai') <= 0) {
            $data['inputerror'][] = 'spt_nilai';
            $data['error_string'][] = 'Dasar Pengenaan Tidak boleh Null!';
            $data['status'] = FALSE;
        }

        if ($this->input->post('spt_pajak') == '') {
            $data['inputerror'][] = 'spt_pajak';
            $data['error_string'][] = 'Dasar Pengenaan harus diisi!';
            $data['status'] = FALSE;
        }


        if ($this->input->post('korek_persen_tarif') == '') {
            $data['inputerror'][] = 'korek_persen_tarif';
            $data['error_string'][] = 'Golongan untuk Pengisian Tarif';
            $data['status'] = FALSE;
        }



        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_hp()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;


        if ($this->input->post('spt_pajak') == '') {
            $data['inputerror'][] = 'spt_pajak';
            $data['error_string'][] = 'Dasar Pengenaan harus diisi!';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    function saveQRCode()
    {
        $spt_id = $this->input->post('spt_id');
        $qr_id = $this->input->post('qr_id');
        $qr_code = $this->input->post('qr_code');

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = $qr_id . '.png'; //buat name dari qr code sesuai dengan nim

        // $spt_nama . ']-[' . $bln_masapajak . '_' . $spt_tahun_pajak

        $params['data'] = $qr_id; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $this->Mod_esptpd->insertQRCode($spt_id, $qr_id, $qr_code, $image_name); //simpan ke database
        // redirect('mahasiswa'); //redirect ke mahasiswa usai simpan data
    }

    function mamin()
    {
        error_reporting(~E_NOTICE);

        $jenis_pajak = '2';
        $kegus = '8';
        $list_wp = $this->Mod_esptpd->getWp($jenis_pajak, $kegus);
        $data['list_wp'] = $list_wp;

        $add_form = "esptpd_mamin";


        // var_dump($data['jenis_mblb']);


        $this->template->load('layoutbackend', 'esptpd/' . $add_form, $data);
    }

    function get_data_wp()
    {
        $wp_id_detil = $this->input->get('wp_id_detil');
        $detail_wp = $this->Mod_esptpd->getWpDetail($wp_id_detil);

        echo json_encode($detail_wp);
    }

    function sewa_gedung()
    {
        error_reporting(~E_NOTICE);

        $jenis_pajak = '1';
        $list_wp = $this->Mod_esptpd->getWp($jenis_pajak);
        $data['list_wp'] = $list_wp;

        $add_form = "esptpd_sewa_gedung";


        // var_dump($data['jenis_mblb']);


        $this->template->load('layoutbackend', 'esptpd/' . $add_form, $data);
    }
}
