<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelayanan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('fungsi');
        $this->load->model('Mod_pelayanan');
    }

    public function index()
    {
        $logged_in = $this->session->userdata('logged_in');
        $user_id = $this->session->userdata('id_user');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect('login');
        } else {
            // $data['menu'] = $this->Mod_pelayanan->_get_table_menu();
            $this->template->load('layoutbackend', 'pelayanan/billing_data');
        }
    }

    public function billing()
    {
        // $wp_id = '';
        // $kodus = '';

        $kodus =   $this->uri->segment(3);
        $wp_id =   $this->uri->segment(4);

        $kb = $this->session->userdata('kriteriabayar');
        if ($kb == 2) {
            $noreg = $wp_id;
            $list = $this->Mod_pelayanan->_get_id_npwp($noreg);
            foreach ($list as $apl) {
                $wp_id = $apl->wp_wr_id;
                $npwprd = $apl->npwprd;
            }
        } else {
            $wp_id = $this->session->userdata('id_wp_wr');
            $npwprd = $_SESSION['npwpd'];
        }

        if ($kb == 1) {
            $noreg =  $this->session->userdata('no_urut');
        } else {
            $noreg = $noreg;
        }

        $espt = $this->Mod_pelayanan->_get_esptpd_menu_group($noreg);
        foreach ($espt as $apl2) {
            $data['bil_npwpd'] = $apl2->npwprd;
            $data['bil_nama'] = $apl2->wp_wr_nama;
        }

        $data['kodus'] = $kodus;
        $data['noreg'] = $wp_id;
        $this->template->load('layoutbackend', 'esptpd/billing_data', $data);
    }

    public function print_billing_group()
    {
        // $wp_id = '';
        // $kodus = '';
        // $kodus =   $this->uri->segment(3);
        // $wp_id =   $this->uri->segment(4);

        $this->template->load('layoutbackend', 'esptpd/print_billing_group');
    }

    public function billing_hapus()
    {

        $idbilling = $this->input->post('idbilling');

        $where = array('kode_billing' => $idbilling);
        $spt_id = $this->Mod_pelayanan->get_sptID($where, 'spt');

        $where2 = array('spt_id' => $spt_id);
        $this->Mod_pelayanan->hapus_billing($where2, 'spt');

        $where3 = array('spt_id ' => $spt_id);
        $this->Mod_pelayanan->hapus_billing($where3, 'spt_detil');

        $msg = [
            'sukses' => 'Billing berhasil dihapus'
        ];
        echo json_encode($msg);
    }


    public function lampiran()
    {
        $billing_id =  $this->uri->segment(3);

        $list = $this->Mod_pelayanan->getAll($billing_id);


        foreach ($list as $billing) {
            $data['spt_id'] = $billing->spt_id;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['spt_periode'] = $billing->spt_periode;
            $data['masa_pajak1'] = $billing->masa_pajak1;
            $data['masa_pajak2'] = $billing->masa_pajak2;
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

        $list = $this->Mod_pelayanan->getAll($billing_id);

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

        $list2 = $this->Mod_pelayanan->getdataPayment($billing_id);
        foreach ($list2 as $wpwr) {
            $data['npwprd'] = $wpwr->npwpd;
            $data['wp_wr_nama'] = $wpwr->nama_wp;
            $data['wp_wr_almt'] = $wpwr->alamat;
        }


        $list3 = $this->Mod_pelayanan->getdataPelayanan($billing_id);

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


    public function view()
    {
        $billing_id =  $this->uri->segment(3);

        $list = $this->Mod_pelayanan->getAll($billing_id);
        foreach ($list as $billing) {
            $data['spt_id'] = $billing->spt_id;
            $data['spt_idwpwr'] = $billing->spt_idwpwr;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['spt_periode'] = $billing->spt_periode;
            $data['masa_pajak1'] = $billing->masa_pajak1;
            $data['masa_pajak2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->spt_pajak;
            $data['status_bayar'] = $billing->status_bayar;
            $data['lampiran'] = $billing->image;
        }

        $list2 = $this->Mod_pelayanan->getdataPayment($billing_id);
        foreach ($list2 as $wpwr) {
            $data['npwprd'] = $wpwr->npwprd;
            $data['wp_wr_nama'] = $wpwr->wp_wr_nama;
            $data['wp_wr_almt'] = $wpwr->wp_wr_almt;
        }

        $list3 = $this->Mod_pelayanan->getdataPelayanan($billing_id);
        foreach ($list3 as $pelayanan) {
            $data['stat_register'] = $pelayanan->stat_register;
            $data['keterangan'] = $pelayanan->keterangan;
        }

        $data['billing_id'] = $billing_id;
        $this->template->load('layoutbackend', 'esptpd/billing_view', $data);
    }

    public function espt_print()
    {
        $spt_id =  $this->uri->segment(3);


        $list = $this->Mod_pelayanan->getPrint($spt_id);
        foreach ($list as $billing) {
            $data['spt_nomor'] = $billing->spt_id;
            $data['jenis_pajak'] = $billing->pajak_id;
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
            $data['keterangan'] = $billing->keterangan;
            $data['pengguna_catering'] = $billing->pengguna_catering;
        }

        if ($billing->pajak_id == '1') {
            $espt_prt = "esptpd_hotel_prt";
            $where = array('wp_wr_detil_id' => $billing->wp_wr_detil_id);
            $row = $this->Mod_pelayanan->get_wp_wr_hotel($where, 'wp_wr_hotel');
            $golongan_hotel =  $row->golongan_hotel;
            $where = array('ref_kode' => $golongan_hotel);
            $golongan = $this->Mod_pelayanan->get_ref_gol_hotel($where, 'ref_gol_hotel');
            $data['golongan'] = $golongan;
            $data['row'] = $row;
        } elseif ($billing->pajak_id == '2') {
            $espt_prt = "esptpd_resto_prt";
            $where = array('wp_wr_detil_id' => $billing->wp_wr_detil_id);
            $row = $this->Mod_pelayanan->get_wp_wr_restoran($where, 'wp_wr_restoran');
            $jenis_restoran =  $row->jenis_restoran;
            $where = array('ref_kode' => $jenis_restoran);
            $golongan = $this->Mod_pelayanan->get_ref_jenis_restoran($where, 'ref_jenis_restoran');
            $data['golongan'] = $golongan;
        } elseif ($billing->pajak_id == '4') {
            $espt_prt = "esptpd_hiburan_prt";
            $golongan = '';
        } elseif ($billing->pajak_id == '6') {
            $espt_prt = "esptpd_minerba_prt";
            $where = array('spt_id' => $billing->spt_id);
            $row = $this->Mod_pelayanan->get_minerba_detil($where, 'spt_detil_mblb');
            $jenis_mblb =  $row->mblb_id;
            $where = array('ref_mblb_id' => $jenis_mblb);
            $jenis_mblb = $this->Mod_pelayanan->get_jenis_mblb($where, 'ref_jenis_mblb');
            $data['jenis_mblb'] = $jenis_mblb;
            $data['row'] = $row;
        } elseif ($billing->pajak_id == '7') {
            $where = array('spt_id' => $billing->spt_id);
            $row = $this->Mod_pelayanan->get_abt_detil($where, 'spt_detil_abt');
            $espt_prt = "esptpd_abt_prt";
            $data['row'] = $row;
        } elseif ($billing->pajak_id == '11') {
            $espt_prt = "esptpd_parkir_prt";
        }

        $kode_pajak = $this->Mod_pelayanan->getKodePajak($billing->pajak_id);
        $data['kode_pajak'] = $kode_pajak;

        $data['golongan'] = $golongan;

        $bln = date("n", strtotime($billing->masa_pajak1));
        $data['bln_masapajak'] = $this->fungsi->bulan($bln);

        $mpdf = new \Mpdf\Mpdf();

        $html = $this->load->view('esptpd/' . $espt_prt, $data, TRUE);
        $mpdf->WriteHTML($html);
        $mpdf->Output();

        //$this->template->load('layoutbackend', 'esptpd/'.$espt_prt, $data);

    }

    public function espt_print_prt()
    {
        $billing_id =  $this->uri->segment(3);

        $list_bil = $this->Mod_pelayanan->getAll($billing_id);
        foreach ($list_bil as $billing2) {
            $data['spt_id'] = $billing2->spt_id;
        }

        $list = $this->Mod_pelayanan->getPrint($billing2->spt_id);
        foreach ($list as $billing) {
            $data['spt_nomor'] = $billing->spt_nomor;
            $data['spt_tahun_pajak'] = $billing->tahunpajak;
            $data['spt_idwpwr'] = $billing->spt_idwpwr;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['spt_periode'] = $billing->spt_periode;
            $data['masa_pajak1'] = $billing->masa_pajak1;
            $data['masa_pajak2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->spt_pajak;
            $data['spt_dt_jumlah'] = $billing->spt_dt_jumlah;
            $data['spt_korek_persen_tarif'] = $billing->korek_persen_tarif;
            $data['spt_korek_nama'] = $billing->korek_nama;
            $data['spt_nama'] = $billing->wp_wr_nama;
            $data['billing_id'] = $billing->spt_kode_billing;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['status_bayar'] = $billing->status_bayar;
        }

        $list_npwp = $this->Mod_pelayanan->getWPWRD($billing->spt_idwpwr);
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

        $tgljatuhtempo = date('Y-m-d', strtotime('+2 month', strtotime($billing->masa_pajak1)));
        if ($billing->status_bayar == 0) {
            $jml_denda = $this->fungsi->denda($tgljatuhtempo, date("Y-m-d"), $billing->spt_pajak);
        } else {
            $tgl_setor = '';
            $list_denda = $this->Mod_pelayanan->getDenda($billing->spt_idwpwr, $billing->spt_periode, $billing->spt_nomor);
            foreach ($list_denda as $list_denda) {
                $tgl_setor = $billing->setorpajret_tgl_bayar;
            }

            $jml_denda = $this->fungsi->denda($tgljatuhtempo, $tgl_setor, $billing->spt_pajak);
        }

        if (date('Y-m-d') >= '2025-08-01' && date('Y-m-d') <= '2025-09-30') {
            $jml_denda = 0;
        }

        $bln = date("n", strtotime($billing->masa_pajak1));

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
        } elseif ($jenispajak == '3') {
            $espt_prt = "esptpd_hiburan_prt";
        } elseif ($jenispajak == '5') {
            $espt_prt = "esptpd_ppj_prt";
        } elseif ($jenispajak == '7' || $jenispajak == '14') {
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
        $list = $this->Mod_pelayanan->getPrint($spt_id);
        foreach ($list as $billing) {

            $data['spt_nomor'] = $billing->spt_id;
            $data['spt_tahun_pajak'] = $billing->tahunpajak;
            $data['spt_idwpwr'] = $billing->wp_wr_id;
            $data['spt_tgl_entry'] = $this->fungsi->tanggalindo($billing->tgl_proses);
            $data['spt_periode'] = $billing->tahun_pajak;
            $data['spt_periode_jual1'] = $billing->masa_pajak1;
            $data['spt_periode_jual2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->pajak;
            $data['total_bayar'] = $billing->pajak;
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

        if ($billing->pajak_id   == '1') {
            $pajak = "Hotel";
        } elseif ($billing->pajak_id     == '2') {
            $pajak = "Restoran";
        } elseif ($billing->pajak_id     == '3') {
            $pajak = "Hiburan";
        } elseif ($billing->pajak_id     == '5') {
            $pajak = "PPJ / Genset";
        } elseif ($billing->pajak_id     == '7') {
            $pajak = "Parkir";
        }

        $kode_pajak = $this->Mod_pelayanan->getKodePajak($billing->pajak_id);
        $data['kode_pajak'] = $kode_pajak;


        $data['pajak'] = $pajak;
        // $html = '<img src="' . base_url() . '/assets/images/logo.png" width=" 55" height="50">';
        $mpdf = new \Mpdf\Mpdf();

        //$this->template->load('layoutbackend', 'esptpd/esptpd_billing_prt', $data);
        //$mpdf->WriteHTML('<img src="/assets/images/logo.png" width="40">');

        $html = $this->load->view('esptpd/esptpd_billing_prt', $data, TRUE);
        $mpdf->WriteHTML($html);
        //$mpdf->debug = true; 
        $mpdf->Output();
    }


    public function espt_billing_prt()
    {
        $billing_id =  $this->uri->segment(3);

        $list_bil = $this->Mod_pelayanan->getAll($billing_id);
        foreach ($list_bil as $billing2) {
            $data['spt_id'] = $billing2->spt_id;
        }
        $list = $this->Mod_pelayanan->getPrint($billing2->spt_id);
        foreach ($list as $billing) {
            $data['spt_nomor'] = $billing->spt_nomor;
            $data['spt_tahun_pajak'] = $billing->tahunpajak;
            $data['spt_idwpwr'] = $billing->spt_idwpwr;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['spt_periode'] = $billing->spt_periode;
            $data['masa_pajak1'] = $billing->masa_pajak1;
            $data['masa_pajak2'] = $billing->masa_pajak2;
            $data['spt_pajak'] = $billing->spt_pajak;
            $data['spt_dt_jumlah'] = $billing->spt_dt_jumlah;
            $data['spt_korek_persen_tarif'] = $billing->korek_persen_tarif;
            $data['spt_korek_nama'] = $billing->korek_nama;
            $data['spt_nama'] = $billing->wp_wr_nama;
            $data['billing_id'] = $billing->spt_kode_billing;
            $data['spt_tgl_entry'] = $billing->spt_tgl_entry;
            $data['status_bayar'] = $billing->status_bayar;
        }

        $list_npwp = $this->Mod_pelayanan->getWPWRD($billing->spt_idwpwr);
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

        $tgljatuhtempo = date('Y-m-d', strtotime('+2 month', strtotime($billing->masa_pajak1)));
        if ($billing->status_bayar == 0) {
            $jml_denda = $this->fungsi->denda($tgljatuhtempo, date("Y-m-d"), $billing->spt_pajak);
        } else {
            $tgl_setor = '';
            $list_denda = $this->Mod_pelayanan->getDenda($billing->spt_idwpwr, $billing->spt_periode, $billing->spt_nomor);
            foreach ($list_denda as $list_denda) {
                $tgl_setor = $billing->setorpajret_tgl_bayar;
            }

            $jml_denda = $this->fungsi->denda($tgljatuhtempo, $tgl_setor, $billing->spt_pajak);
        }

        if (date('Y-m-d') >= '2025-08-01' && date('Y-m-d') <= '2025-09-30') {
            $jml_denda = 0;
        }

        $bln = date("n", strtotime($billing->masa_pajak1));

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


        $mpdf = new \Mpdf\Mpdf();
        // $this->template->load('layoutbackend', 'esptpd/esptpd_resto_prt', $data);

        $html = $this->load->view('esptpd/esptpd_billing_prt', $data, TRUE);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function espt_group_prt()
    {
        // $billing_id =  $this->uri->segment(3);
        $userid = $this->session->userdata('id_user');
        $periode = $this->input->post('periode');
        $jual1 = $this->input->post('masa_pajak1');
        $jual2 = $this->input->post('masa_pajak2');
        $data['billing_induk'] = $this->Mod_pelayanan->get_group_billing($periode, $jual1, $jual2, $this->session->userdata('id_user'));
        $data['billing_anak'] = $this->Mod_pelayanan->get_group_billing_det($periode, $jual1, $jual2, $this->session->userdata('id_user'));

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

        $list = $this->Mod_pelayanan->get_datatables();
        $data = array();
        $no = $_POST['start'];

        $stat_arr = array(
            "0" => "<i class='far fa-times-circle' style='color:red;'></i> <span class='text-danger'>Blm Lunas</span>",
            "1" => "<i class='far fa-check-circle' style='color:green;'></i><span class='text-success'> Lunas</span>",
            "2" => "<span class='text-secondary'> Nihil</span>"
        );

        foreach ($list as $biling) {
            $no++;
            $tgljatuhtempo = date('Y-m-d', strtotime('+2 month', strtotime($biling->masa_pajak1)));
            $b_entryuu = date("m", strtotime($tgljatuhtempo)) - 1;
            $t_entry = date("Y-m-d", strtotime('last day of this month', strtotime($biling->tgl_proses)));

            // if ($biling->status_bayar == 0) {
            //     $jml_denda = $this->fungsi->denda($tgljatuhtempo, date("Y-m-d"), $biling->spt_pajak);
            // } else {
            //     $tgl_setor = '';
            //     $list_denda = $this->Mod_pelayanan->getDenda($biling->spt_idwpwr, $biling->spt_periode, $biling->spt_nomor);
            //     foreach ($list_denda as $list_denda) {
            //         $tgl_setor = $list_denda->setorpajret_tgl_bayar;
            //     }
            //     $jml_denda = $this->fungsi->denda($tgljatuhtempo, $tgl_setor, $biling->spt_pajak);
            // }


            $bln_pajak = date("m", strtotime($biling->masa_pajak1));
            $bln_kemarin = date("m", mktime(0, 0, 0, date("m") - 1));

            $thn_pajak = date("Y", strtotime($biling->masa_pajak1));

            $t = date('Y');
            $b = date('m');
            $masa_aktiv =  $b = date('m'); //$t."-".$b;

            $masa_entri = substr($biling->masa_pajak1, 5, 2);
            $thn_entri = substr($biling->masa_pajak1, 0, 4);

            $nama = $this->Mod_pelayanan->get_nama_wp($biling->wp_wr_id);




            $aksi = "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" data-href=" . $biling->spt_id  . " target=\"_blank\"><i class=\"fas fa-print\"></i> Esptpd</a>
                    <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" data-href=" . $biling->spt_id . " target=\"_blank\"><i class=\"fas fa-print\"></i> Billing</a>
                    <a class=\"btn btn-xs btn-outline-primary\" id=\"edit\" href=\"javascript:void(0)\" title=\"Edit\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-edit\"> Verifikasi</i></a>
                    <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"delete\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>";


            $row = array();
            $row[] = $biling->spt_id;
            $row[] = $biling->tgl_proses;
            $row[] = $nama;
            $row[] = $biling->tahun_pajak;
            $row[] = $biling->masa_pajak1 . ' s/d ' . $biling->masa_pajak2;
            $row[] = $t_entry;
            $row[] = number_format($biling->pajak, 0, ',', '.');
            // $row[] = number_format($jml_denda, 0, ',', '.');
            // $row[] = number_format($biling->spt_pajak + $jml_denda, 0, ',', '.');
            $row[] = $biling->kode_billing;
            $row[] = $stat_arr[$biling->status_bayar];
            $row[] = $aksi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_pelayanan->count_all(),
            "recordsFiltered" => $this->Mod_pelayanan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function add()
    {
        // error_reporting(~E_NOTICE);
        $kodus_id =  $this->uri->segment(3);
        $no_reg =  $this->uri->segment(4);

        if ($kodus_id == 1) {
            $add_form =  "esptpd_hotel";
            $kd_jns = '1';
            $list_rekening = $this->Mod_pelayanan->_get_rekening('4', '1', '1', '01');
            $data['list_rekening'] = $list_rekening;
        } elseif ($kodus_id == 5 || $kodus_id == 12) {
            $add_form =  "esptpd_ppj";
            $kd_jns = '5';
        } elseif ($kodus_id == 11) {
            $add_form =  "esptpd_hiburan";
            $kd_jns = '3';
        } elseif ($kodus_id == 14) {
            $add_form =  "esptpd_parkir";
            $kd_jns = '7';
        } elseif ($kodus_id == 16) {
            $add_form =  "esptpd_resto";
            $kd_jns = '2';
        } else {
            $add_form =  "";
        }
        $apl = '';
        $list = $this->Mod_pelayanan->_get_data_wp($no_reg);
        foreach ($list as $apl) {
            $data['wp_id'] = $apl->wp_wr_id;
            $data['npwprd'] = $apl->npwprd;
            $data['nama'] = $apl->nama;
            $data['alamat'] = $apl->alamat;
            $data['kelurahan'] = $apl->kelurahan;
            $data['kecamatan'] = $apl->kecamatan;
            $data['kota'] = $apl->kota;
            $data['kode_rekening'] = $apl->kode_rekening;
            $data['kode_spt'] = $apl->kode_spt;
        }

        $kode_spt = $this->kode_spt($apl->kode_spt, $kd_jns);
        $data['kd_jns_pajak'] = $kd_jns;
        $data['no_register'] = $kode_spt;
        $list_spt = $this->Mod_pelayanan->_get_data_SPPT($apl->wp_wr_id);
        $masa_awal = $list_spt->masa_pajak1;
        $masa_akhir = $list_spt->masa_pajak2;
        // var_dump($data);

        if (date("m", strtotime($masa_awal)) == '12') {
            $bulan_ke = '1';
            $periode_thn = date('Y');
        } else {
            $periode_thn = date("Y", strtotime($masa_awal));
            $bulan_ke    = date("m", strtotime($masa_awal)) + 1;
        }

        $hari_ini =  date($periode_thn . "-" . $bulan_ke . "-01"); //date("Y-m-d");
        $tgl_pertama = date('Y-m-01', strtotime($hari_ini));
        $tgl_terakhir = date('Y-m-t', strtotime($hari_ini));

        $data['masa_awal'] = $tgl_pertama;
        $data['masa_akhir'] = $tgl_terakhir;
        $this->template->load('layoutbackend', 'esptpd/' . $add_form, $data);
    }

    function editesptpd()
    {
        // error_reporting(~E_NOTICE);
        $spt_id =  $this->uri->segment(3);
        $jns_pajak =  $this->uri->segment(4);
        $no_reg =  $this->uri->segment(5);

        if ($jns_pajak == 1) {
            $add_form =  "esptpd_hotel_ed";
            $list_rekening = $this->Mod_pelayanan->_get_rekening('4', '1', '1', '01');
            $data['list_rekening'] = $list_rekening;
        } elseif ($jns_pajak == 5) {
            $add_form =  "esptpd_ppj_ed";
        } elseif ($jns_pajak == 3) {
            $add_form =  "esptpd_hiburan_ed";
        } elseif ($jns_pajak == 7) {
            $add_form =  "esptpd_parkir_ed";
        } elseif ($jns_pajak == 2) {
            $add_form =  "esptpd_resto_ed";
        } else {
            $add_form =  "";
        }

        $list = $this->Mod_pelayanan->_get_data_wp($no_reg);
        foreach ($list as $apl) {
            $data['wp_id'] = $apl->wp_wr_id;
            $data['npwprd'] = $apl->npwprd;
            $data['nama'] = $apl->nama;
            $data['alamat'] = $apl->alamat;
            $data['kelurahan'] = $apl->kelurahan;
            $data['kecamatan'] = $apl->kecamatan;
            $data['kota'] = $apl->kota;
            $data['kode_rekening'] = $apl->kode_rekening;
            $data['kode_spt'] = $apl->kode_spt;
        }

        $list_spt = $this->Mod_pelayanan->get_edit_esptpd($spt_id);
        $masa_awal = $list_spt->masa_pajak1;
        $masa_akhir = $list_spt->masa_pajak2;

        $data['kd_jns_pajak'] = $jns_pajak;
        $data['no_register'] = $list_spt->spt_nomor;

        $data['masa_awal'] = $masa_awal;
        $data['masa_akhir'] = $masa_akhir;

        $jenis_pemungutan = $list_spt->spt_jenis_pemungutan;
        $spt_tgl_entry = $list_spt->spt_tgl_entry;
        $spt_tgl_proses = $list_spt->spt_tgl_proses;
        $data['periode'] = $list_spt->spt_periode;
        $data['dasar_pengenaan'] = $list_spt->spt_dt_jumlah;
        $data['kode_billing'] = $list_spt->spt_kode_billing;
        $data['spt_pajak'] = $list_spt->spt_dt_pajak;
        $korek_nama = $list_spt->korek_nama;
        $persen_tarif = $list_spt->korek_persen_tarif;
        $kd_rek_id = $list_spt->korek_id;
        $data['spt_dt_id'] = $list_spt->spt_dt_id;
        $data['spt_id'] = $spt_id;


        $this->template->load('layoutbackend', 'esptpd/' . $add_form, $data);
    }

    function kode_spt($kode_spt, $kd_jns)
    {
        $kode_spt = $this->Mod_pelayanan->_get_reg_spt($kode_spt, $kd_jns);
        $next_spt_no_register = $this->fungsi->tambah_nol($kode_spt, 4);

        return $next_spt_no_register;
    }

    function next_spt_no_register()
    {
        $spt_periode  = $this->input->post('periode');
        $kd_jns       = $this->input->post('pajret');
        $kode_spt     = $this->input->post('spt_kode');

        $kode_spt = $this->Mod_pelayanan->next_spt_no_register($spt_periode, $kode_spt, $kd_jns);
        $next_spt_no_register = $this->fungsi->tambah_nol($kode_spt, 4);

        echo json_encode(array("nomor" => $next_spt_no_register));
    }

    function get_tarif()
    {
        $korek_id  = $this->input->post('rek_id');
        $tarif = $this->Mod_pelayanan->_get_tarif($korek_id);

        echo json_encode(array("nilai" => $tarif));
    }

    function get_korek()
    {
        $korek_id  = $this->input->get('korek');
        $kode_rek = $this->Mod_pelayanan->_get_korek($korek_id);
        echo json_encode($kode_rek);
    }

    public function insert()
    {
        $this->_validate();

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

        $cek = $this->Mod_pelayanan->_cekSPT_nomor($spt_nomor, $this->input->post('spt_periode'), $this->input->post('spt_jenis'));
        if ($cek  > 0) {
            echo json_encode(array(
                "error" => True,
                "msg" => "Nomor SPT Sudah Ada!!. Silahkan refresh SPTPD lalu klik simpan"
            ));
        } else {
            $nama = $kode_billing;
            $config['upload_path']   = './assets/foto/lampiran/';
            $config['allowed_types'] = 'pdf'; //mencegah upload backdor
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
                    'masa_pajak1' => $this->input->post('masa_pajak1'),
                    'masa_pajak2' => $this->input->post('masa_pajak2'),
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

                $this->Mod_pelayanan->inserSPT("spt", $save);

                $spt_id = $this->Mod_pelayanan->_getSPT_id();

                $save  = array(
                    'spt_dt_id_spt' => $spt_id,
                    'spt_dt_korek' => $this->input->post('kode_rekening_id'),
                    'spt_dt_jumlah'  => $spt_nilai,
                    'spt_dt_tarif_dasar'  => 0,
                    'spt_dt_persen_tarif' => $this->input->post('korek_persen_tarif'),
                    'spt_dt_pajak' => $spt_pajak
                );
                $this->Mod_pelayanan->inserSPT("spt_detail", $save);

                echo json_encode(array("status" => TRUE));
            } else { //Apabila tidak ada gambar yang di upload
                $save  = array(
                    'spt_periode' => $this->input->post('spt_periode'),
                    'spt_kode' => $this->input->post('kd_spt'),
                    'spt_no_register'  => $this->input->post('no_sptpd'),
                    'spt_nomor'  => $spt_nomor,
                    'spt_kode_rek' => $this->input->post('kd_rekening'),
                    'masa_pajak1' => $this->input->post('masa_pajak1'),
                    'masa_pajak2' => $this->input->post('masa_pajak2'),
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

                $this->Mod_pelayanan->inserSPT("spt", $save);
                $spt_id = $this->Mod_pelayanan->_getSPT_id();

                $save  = array(
                    'spt_dt_id_spt' => $spt_id,
                    'spt_dt_korek' => $this->input->post('kode_rekening_id'),
                    'spt_dt_jumlah'  => $spt_nilai,
                    'spt_dt_tarif_dasar'  => 0,
                    'spt_dt_persen_tarif' => $this->input->post('korek_persen_tarif'),
                    'spt_dt_pajak' => $spt_pajak
                );
                $this->Mod_pelayanan->inserSPT("spt_detil", $save);
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function update()
    {
        $this->_validate();

        $wp_no_registrasi  = substr($this->input->post('npwpd'), 7, 7);
        $spt_nomor = $this->input->post('kd_spt') . "" . $this->input->post('no_sptpd');
        $spt_nomor = (int) $spt_nomor;

        $spt_id    = $this->input->post('spt_id');
        $spt_dt_id    = $this->input->post('spt_dt_id');
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

        $config['upload_path']   = './assets/foto/lampiran/';
        $config['allowed_types'] = 'pdf'; //mencegah upload backdor
        $config['max_size']      = '1000';
        $config['max_width']     = '2000';
        $config['max_height']    = '1024';
        $config['file_name']     = $nama;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('imagefile')) {
            $gambar = $this->upload->data();

            $save  = array(
                'spt_periode' => $this->input->post('spt_periode'),
                'masa_pajak1' => $this->input->post('masa_pajak1'),
                'masa_pajak2' => $this->input->post('masa_pajak2'),
                'spt_status' => $this->input->post('spt_status'),
                'spt_pajak' => $spt_pajak,
                'spt_jenis_pajakretribusi' => $this->input->post('spt_jenis'),
                'spt_idwpwr' => $this->input->post('wp_id'),
                'image' => $gambar['file_name']
            );

            $this->Mod_pelayanan->updateSPT($spt_id, $save);

            $save  = array(
                'spt_dt_korek' => $this->input->post('kode_rekening_id'),
                'spt_dt_jumlah'  => $spt_nilai,
                'spt_dt_tarif_dasar'  => 0,
                'spt_dt_persen_tarif' => $this->input->post('korek_persen_tarif'),
                'spt_dt_pajak' => $spt_pajak
            );
            $this->Mod_pelayanan->updateSPTDetil($spt_dt_id, $save);

            echo json_encode(array("status" => TRUE));
        } else { //Apabila tidak ada gambar yang di upload

            $save  = array(
                'spt_periode' => $this->input->post('spt_periode'),
                'masa_pajak1' => $this->input->post('masa_pajak1'),
                'masa_pajak2' => $this->input->post('masa_pajak2'),
                'spt_status' => $this->input->post('spt_status'),
                'spt_pajak' => $spt_pajak,
                'spt_jenis_pajakretribusi' => $this->input->post('spt_jenis'),
                'spt_idwpwr' => $this->input->post('wp_id')
            );

            $this->Mod_pelayanan->updateSPT($spt_id, $save);

            $save  = array(
                'spt_dt_korek' => $this->input->post('kode_rekening_id'),
                'spt_dt_jumlah'  => $spt_nilai,
                'spt_dt_tarif_dasar'  => 0,
                'spt_dt_persen_tarif' => $this->input->post('korek_persen_tarif'),
                'spt_dt_pajak' => $spt_pajak
            );
            $this->Mod_pelayanan->updateSPTDetil($spt_dt_id, $save);
            echo json_encode(array("status" => TRUE));
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

        $cek = $this->Mod_pelayanan->_cekSPT_nomor($spt_nomor, $this->input->post('spt_periode'), $this->input->post('spt_jenis'));
        if ($cek  > 0) {
            echo json_encode(array(
                "error" => True,
                "msg" => "Nomor SPT Sudah Ada!!. Silahkan refresh SPTPD lalu klik simpan"
            ));
        } else {
            $nama = $kode_billing;
            $config['upload_path']   = './assets/foto/lampiran/';
            $config['allowed_types'] = 'pdf'; //mencegah upload backdor
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
                    'masa_pajak1' => $this->input->post('masa_pajak1'),
                    'masa_pajak2' => $this->input->post('masa_pajak2'),
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

                $this->Mod_pelayanan->inserSPT("spt", $save);

                $spt_id = $this->Mod_pelayanan->_getSPT_id();

                $save  = array(
                    'spt_dt_id_spt' => $spt_id,
                    'spt_dt_korek' => $this->input->post('kode_rekening_id'),
                    'spt_dt_jumlah'  => $spt_nilai,
                    'spt_dt_tarif_dasar'  => 0,
                    'spt_dt_persen_tarif' => $this->input->post('korek_persen_tarif'),
                    'spt_dt_pajak' => $spt_pajak
                );
                $this->Mod_pelayanan->inserSPT("spt_detail", $save);

                echo json_encode(array("status" => TRUE));
            } else { //Apabila tidak ada gambar yang di upload
                $save  = array(
                    'spt_periode' => $this->input->post('spt_periode'),
                    'spt_kode' => $this->input->post('kd_spt'),
                    'spt_no_register'  => $this->input->post('no_sptpd'),
                    'spt_nomor'  => $spt_nomor,
                    'spt_kode_rek' => $this->input->post('kd_rekening'),
                    'masa_pajak1' => $this->input->post('masa_pajak1'),
                    'masa_pajak2' => $this->input->post('masa_pajak2'),
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

                $this->Mod_pelayanan->inserSPT("spt", $save);
                $spt_id = $this->Mod_pelayanan->_getSPT_id();
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
                    $this->Mod_pelayanan->inserSPT("spt_detail", $save);
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

        $this->Mod_pelayanan->insertPelayanan("tbl_pelayanan", $save);
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
            $this->Mod_pelayanan->updatePelayanan($id_billing, $save);
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

            $this->Mod_pelayanan->insertPelayanan("tbl_pelayanan", $save);
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

        if ($this->input->post('nama_rekening') == '') {
            $data['inputerror'][] = 'nama_rekening';
            $data['error_string'][] = 'Pilih Golongan!';
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

    public function daftar_sptpd_skpd()
    {
        $this->template->load('layoutbackend', 'pelayanan/daftar_sptpd_skpd');
    }

    public function list_sptpd_skpd()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $username = $this->session->userdata('username');

        $list = $this->Mod_pelayanan->listSptpdSkpd($username);

        $data = array();
        $no = $_POST['start'];

        $stat_arr = array(
            "0" => "<i class='far fa-times-circle' style='color:red;'></i> <span class='text-danger'>Blm Lunas</span>",
            "1" => "<i class='far fa-check-circle' style='color:green;'></i><span class='text-success'> Lunas</span>",
            "2" => "<span class='text-secondary'> Nihil</span>"
        );

        foreach ($list as $biling) {
            $no++;
            $tgljatuhtempo = date('Y-m-d', strtotime('+2 month', strtotime($biling->masa_pajak1)));
            $b_entryuu = date("m", strtotime($tgljatuhtempo)) - 1;
            $t_entry = date("Y-m-d", strtotime('last day of this month', strtotime($biling->tgl_proses)));

            // if ($biling->status_bayar == 0) {
            //     $jml_denda = $this->fungsi->denda($tgljatuhtempo, date("Y-m-d"), $biling->spt_pajak);
            // } else {
            //     $tgl_setor = '';
            //     $list_denda = $this->Mod_pelayanan->getDenda($biling->spt_idwpwr, $biling->spt_periode, $biling->spt_nomor);
            //     foreach ($list_denda as $list_denda) {
            //         $tgl_setor = $list_denda->setorpajret_tgl_bayar;
            //     }
            //     $jml_denda = $this->fungsi->denda($tgljatuhtempo, $tgl_setor, $biling->spt_pajak);
            // }


            $bln_pajak = date("m", strtotime($biling->masa_pajak1));
            $bln_kemarin = date("m", mktime(0, 0, 0, date("m") - 1));

            $thn_pajak = date("Y", strtotime($biling->masa_pajak1));

            $t = date('Y');
            $b = date('m');
            $masa_aktiv =  $b = date('m'); //$t."-".$b;

            $masa_entri = substr($biling->masa_pajak1, 5, 2);
            $thn_entri = substr($biling->masa_pajak1, 0, 4);

            $nama = $this->Mod_pelayanan->get_nama_wp($biling->wp_wr_id);



            if ($biling->status_bayar == '1') {
                $aksi = "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" data-href=" . $biling->spt_id  . "><i class=\"fas fa-print\"></i> Esptpd</a>
                    <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" data-href=" . $biling->spt_id . "><i class=\"fas fa-print\"></i> Billing</a>";
            } else {
                $aksi = "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" id=\"esptpd\" title=\"esptpd\" data-href=" . $biling->spt_id  . "><i class=\"fas fa-print\"></i> Esptpd</a>
                    <a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" id=\"billing\" title=\"billing\" data-href=" . $biling->spt_id . "><i class=\"fas fa-print\"></i> Billing</a>
                    <a class=\"btn btn-xs btn-outline-danger\" id=\"delete\" href=\"javascript:void(0)\" title=\"delete\" data-href=" . $biling->kode_billing . "><i class=\"fas fa-trash\"> Hapus</i></a>
                    <a class=\"btn btn-xs btn-outline-success\" id=\"bayar\" href=\"http://e-pada.blitarkab.go.id/portal_payment/pdl/tagihan_sptpd.php?kode_billing=" . $biling->kode_billing . "\" title=\"Bayar\" target=\"_blank\"><i class=\"fas fa-money\"> Bayar</i></a>";
            }


            $row = array();
            $row[] = $biling->spt_id;
            $row[] = $biling->tgl_proses;
            $row[] = $nama;
            $row[] = $biling->tahun_pajak;
            $row[] = $biling->masa_pajak1 . ' s/d ' . $biling->masa_pajak2;
            $row[] = number_format($biling->pajak, 0, ',', '.');
            // $row[] = number_format($jml_denda, 0, ',', '.');
            // $row[] = number_format($biling->spt_pajak + $jml_denda, 0, ',', '.');
            $row[] = $biling->kode_billing;
            $row[] = $stat_arr[$biling->status_bayar];
            $row[] = $aksi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_pelayanan->count_all_skpd($username),
            "recordsFiltered" => $this->Mod_pelayanan->count_filtered_skpd($username),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}
