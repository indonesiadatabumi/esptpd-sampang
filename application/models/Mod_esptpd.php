<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_esptpd extends CI_Model
{

    var $table = 'spt';
    var $column_order = array('spt_id', 'tgl_proses', 'masa_pajak1', 'npwprd');
    var $column_search = array('npwprd', 'kode_billing',  'status_bayar');
    var $order = array('spt_id' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function getQRCode()
    {
        $hasil = $this->db->get('tbl_qrcode');
        return $hasil;
    }

    function insertQRCode($spt_id, $qr_id, $image_name, $date)
    {
        $data = array(
            'spt_id'       => $spt_id,
            'qr_id'      => $qr_id,
            'qr_code'     => $image_name,
            'created_date'   => $date
        );
        $this->db->insert('tbl_qrcode', $data);
    }


    function _get_esptpd_menu()
    {

        $this->db->select('a.wp_wr_id, a.npwprd, a.pajak_id, b. wp_wr_detil_id, b.nama');
        $this->db->join('wp_wr_detil b', 'a.wp_wr_id=b.wp_wr_id');
        $this->db->where("a.npwprd", $this->session->userdata('username'));
        if ($this->session->userdata('username') != '220.004.02.02.0001') {
            $this->db->where("b.kegus_id !=", '8');
        }
        $this->db->from('wp_wr a');

        $query = $this->db->get();
        return $query->result();
    }

    function esptpd_add($wp_wr_detil_id)
    {
        $this->db->select('a.*,b.tarif_dasar');
        $this->db->join('ref_kegiatan_usaha b', 'a.kegus_id=b.ref_kegus_id', 'left');
        $this->db->where("a.wp_wr_detil_id", $wp_wr_detil_id);
        $this->db->from('v_objek_pajak a');

        $query = $this->db->get();
        return $query->result();
    }

    function _get_id_npwp($noreg)
    {


        $this->db->select('wp_wr_id, npwprd');
        $this->db->where(" wp_wr_no_urut", $noreg);
        $this->db->from('wp_wr');
        $this->db->order_by('wp_wr_no_urut desc');


        $query = $this->db->get();
        return $query->result();
    }


    function _get_data_wp($no_reg)
    {

        $this->db->select('*');
        $this->db->join('spt', 'spt.wp_wr_id=wp.wp_wr_id');
        $this->db->join('spt_detil', 'spt.spt_id=spt_detil.spt_id');
        $this->db->where("spt.spt_id", $no_reg);
        $this->db->from('wp_wr wp');
        $query = $this->db->get();

        return $query->result();
    }

    function _get_data_mblb($spt_id)
    {

        $this->db->select('*');
        $this->db->join('ref_jenis_mblb', 'ref_jenis_mblb.ref_mblb_id=spt_detil_mblb.mblb_id');
        $this->db->where("spt_id", $spt_id);
        $this->db->from('spt_detil_mblb');
        $query = $this->db->get();

        return $query->row();
    }

    function _get_data_abt($spt_id)
    {

        $this->db->select('*');
        $this->db->where("spt_id", $spt_id);
        $this->db->from('spt_detil_abt');
        $query = $this->db->get();

        return $query->row();
    }

    // function _get_data_SPPT($npwprd)
    // {
    //     $this->db->select('*');
    //     $this->db->where("npwprd", $npwprd);
    //     $this->db->from('spt');
    //     $this->db->order_by('masa_pajak1 desc');
    //     $query = $this->db->get();

    //     if ($query->num_rows() > 0) {
    //         $row = $query->row();
    //     }

    //     return $row;
    // }

    function _get_data_SPPT($wp_wr_detil_id)
    {
        $this->db->select('*');
        $this->db->where("wp_wr_detil_id", $wp_wr_detil_id);
        $this->db->from('spt');
        $this->db->order_by('masa_pajak1 desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
        }

        return $row;
    }

    function generate_spt_number($pajak_id)
    {

        $curr_year = date('Y');

        $this->db->select_max('nomor_spt');
        $this->db->where("EXTRACT(YEAR FROM created_time) = ", $curr_year);
        $this->db->where("pajak_id", $pajak_id);
        $this->db->from("spt");
        $query = $this->db->get();

        $nomor_spt = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $nomor_spt =  $row->nomor_spt;
        }

        // $nomor_spt = $this->db->GetOne("SELECT nomor_spt('" . $seq . "')");
        return $nomor_spt;
    }


    function _cekRegis($billing_id)
    {

        $this->db->select('*');
        $this->db->where("id_billing", $billing_id);
        $this->db->from('tbl_pelayanan');
        $query = $this->db->get();

        $res = '';

        if ($query->num_rows() > 0) {
            $res = '2';
        }
        return $res;
    }

    function _get_rekening($tipe, $kelompok, $jenis, $objek)
    {
        $this->db->where('korek_tipe', $tipe);
        $this->db->where('korek_kelompok', $kelompok);
        $this->db->where('korek_jenis', $jenis);
        $this->db->where('korek_objek', $objek);
        $this->db->where('korek_rincian !=', '00');
        $this->db->from('kode_rekening');
        $this->db->order_by('korek_nama asc');

        $query = $this->db->get();

        return $query->result();
    }

    function _get_tarif($korek_id)
    {
        $this->db->select('korek_persen_tarif');
        $this->db->where("korek_id", $korek_id);
        $this->db->from('kode_rekening');
        $query = $this->db->get();

        $persen_tarif = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $persen_tarif =  $row->korek_persen_tarif;
        }

        return $persen_tarif;
    }

    function _get_korek($kode_rek)
    {
        $this->db->select('*');
        $this->db->where("koderek", $kode_rek);
        $this->db->from('v_kode_rekening_pajak_detail');
        $query = $this->db->get();
        $total = $query->num_rows();

        $result_array = FALSE;
        $result = array();

        // if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $list[] = array(
                "key" => $row->korek_id . "," . $row->korek_persen_tarif . "," . (1 * $row->korek_tarif_dsr),
                "value" => "(" . $row->koderek_titik  . ") " . $row->korek_nama
            );
        }

        $result = array(
            'total' => $total,
            'list' => $list
        );

        return $result;
    }

    function _get_reg_spt($kd_spt, $kd_jns)
    {
        $this->db->select('CASE WHEN MAX(spt_no_register::INT) + 1 IS NULL then 1
				ELSE MAX(spt_no_register::INT) + 1 END as max_spt_no_register ');
        $this->db->where("spt_periode", date("Y"));
        $this->db->where("spt_jenis_pajakretribusi", $kd_jns);
        $this->db->where("spt_kode", $kd_spt);
        $this->db->from('spt');
        $query = $this->db->get();

        $max_urut = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $max_urut =  $row->max_spt_no_register;
        }
        return $max_urut;
    }

    function next_val($seq)
    {

        $this->db->select("nextval('" . $seq . "') as nextval");
        $query = $this->db->get();

        $nextval = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $nextval =  $row->nextval;
        }

        // $nextval = $this->db->GetOne("SELECT nextval('" . $seq . "')");
        return $nextval;
    }

    function generate_billing($doc_type, $collection_type = '')
    {
        $prefix = $doc_type . $collection_type;   // Contoh: "21" atau "2A"
        $stamp1 = date("m");                      // Bulan: 07
        $stamp2 = date("d");                      // Tanggal: 16
        $len = 5 + ($doc_type == '2' ? 1 : 0);     // Panjang kode acak: 5 atau 6

        $code_numeric = date("is") . substr(microtime(), 2, 3); // unik tiap momen
        $unique_part = substr($code_numeric, -$len); // tetap panjang 6

        $billing_code = $prefix . $stamp1 . $unique_part . $stamp2;

        $this->db->select('kode_billing');
        $this->db->where("kode_billing", $billing_code);
        $this->db->from('spt');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Jika kode sudah ada, panggil fungsi lagi untuk menghasilkan kode baru
            return $this->generate_billing($doc_type, $collection_type);
        }

        return $billing_code;
    }

    function next_spt_no_register($spt_periode, $kd_spt, $kd_jns)
    {
        $this->db->select('CASE WHEN MAX(spt_no_register::INT) + 1 IS NULL then 1
				ELSE MAX(spt_no_register::INT) + 1 END as max_spt_no_register ');
        $this->db->where("spt_periode", $spt_periode);
        $this->db->where("spt_jenis_pajakretribusi", $kd_jns);
        $this->db->where("spt_kode", $kd_spt);
        $this->db->from('spt');
        $query = $this->db->get();

        $max_urut = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $max_urut =  $row->max_spt_no_register;
        }
        return $max_urut;
    }

    function _getSPT_id()
    {
        $this->db->select('spt_id');
        $this->db->order_by('spt_id desc');
        $this->db->limit(1);
        $this->db->from('spt');
        $query = $this->db->get();

        $spt_id = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $spt_id =  $row->spt_id;
        }
        return $spt_id;
    }

    function inserSPT($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        return  $this->db->affected_rows();
    }

    function insertPelayanan($tabel, $data)
    {
        $insert = $this->db->insert($tabel, $data);
        return $insert;
    }

    private function _get_datatables_query()
    {
        $year = date('Y');
        $month = date('m');

        $this->db->select('spt_id, wp_wr_id, tgl_proses, tahun_pajak, masa_pajak1, masa_pajak2, pajak, 
				kode_billing, status_bayar, tgl_lapor, wp_wr_id, nilai_terkena_pajak, pajak_id ');
        $this->db->where('masa_pajak1 >=', '2023-01-01');
        // $this->db->where('masa_pajak1 <=', '' . $year . '-' . $month . '-01');
        $this->db->order_by('tgl_proses desc');
        $this->db->from('spt');

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }

            if ($_POST['searchByName']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->where('npwprd', $_POST['searchByName']);
                    $this->db->where('wp_wr_detil_id', $_POST['wp_wr_detil_id']);
                } else {
                    $this->db->where('npwprd', $_POST['searchByName']);
                    $this->db->where('wp_wr_detil_id', $_POST['wp_wr_detil_id']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }

            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('spt');
        // ($wp_id != '') ? $this->db->where("spt_idwpwr", $wp_id) : '';

        return $this->db->count_all_results();
    }

    function view_user($id)
    {
        $this->db->where('user_id', $id);
        return $this->db->get('wp_user');
    }

    function getAll($billing_id)
    {
        $this->db->select('spt_id,  wp_wr_id, tgl_proses, tahun_pajak, masa_pajak1, masa_pajak2, pajak, pajak_id,  
				kode_billing, status_bayar, image ');
        $this->db->where("kode_billing", $billing_id);
        // $this->db->where("spt_periode_jual1 >=", '2016-11-01');
        // $this->db->order_by('spt_id desc');
        $query = $this->db->get('spt');
        return $query->result();
    }

    function getPrint($spt_id)
    {
        $this->db->select('s.spt_id, s.pajak_id, EXTRACT(YEAR FROM s.masa_pajak1) as tahunpajak, s.masa_pajak1, s.masa_pajak2, s.tahun_pajak, s.pajak, sd.nilai_terkena_pajak, 
                        s.persen_tarif,   wp_detil.nama, s.kode_billing, tgl_proses, s.status_bayar, s.wp_wr_id, wp.golongan,wp.jenis, wp.npwprd, 
                        wp_detil.kecamatan_id, wp_detil.kecamatan, wp_detil.kelurahan_id,wp.kelurahan');
        $this->db->join('spt_detil sd', 's.spt_id=sd.spt_id');
        // $this->db->join('kode_rekening k', 'sd.spt_dt_korek=k.korek_id');
        $this->db->join('wp_wr wp', 'wp.wp_wr_id=s.wp_wr_id');
        $this->db->join('wp_wr_detil wp_detil', 'wp_detil.wp_wr_detil_id=s.wp_wr_detil_id');
        $this->db->where("s.spt_id", $spt_id);
        $this->db->from('spt s');
        $query = $this->db->get();
        return $query->result();
    }

    function getDenda($id_wpwr, $spt_periode, $spt_nomor)
    {
        $this->db->select('setorpajret_tgl_bayar');
        $this->db->where("setorpajret_id_wp", $id_wpwr);
        $this->db->where("setorpajret_spt_periode", $spt_periode);
        $this->db->where("setorpajret_no_spt", $spt_nomor);
        $this->db->from('v_setoran_pajak_retribusi');
        $query = $this->db->get();
        return $query->result();
    }

    function getWPWRD($spt_idwpwr)
    {
        $this->db->select('*');
        $this->db->where("wp_wr_id", $spt_idwpwr);
        $query = $this->db->get('wp_wr');
        return $query->result();
    }

    function getdataPayment($billing_id)
    {
        $this->db->select('*');
        $this->db->where("kode_billing", $billing_id);
        $query = $this->db->get('v_penyetoran_sspd');
        return $query->result();
    }

    function getdataPelayanan($billing_id)
    {
        $this->db->select('*');
        $this->db->where("id_billing", $billing_id);
        $query = $this->db->get('tbl_pelayanan');
        return $query->result();
    }

    function cekUsername($username)
    {
        $this->db->where("npwpd", $username);
        return $this->db->get("wp_user");
    }

    function insertUser($tabel, $data)
    {
        $insert = $this->db->insert($tabel, $data);
        return $insert;
    }

    function getUser($id)
    {
        $this->db->where("user_id", $id);
        return $this->db->get("wp_user a")->row();
    }

    function updatePelayanan($id, $data)
    {
        $this->db->where('id_billing', $id);
        $this->db->update('tbl_pelayanan', $data);
    }

    function updateSPT($id, $data)
    {
        $this->db->where('spt_id', $id);
        $this->db->update('spt', $data);
        return  $this->db->affected_rows();
    }


    function updateSPTDetil($id, $data)
    {
        $this->db->where('spt_id', $id);
        $this->db->update('spt_detil', $data);
        return  $this->db->affected_rows();
    }

    function updateSPTMblb($id, $data)
    {
        $this->db->where('spt_id', $id);
        $this->db->update('spt_detil_mblb', $data);
        return  $this->db->affected_rows();
    }

    function updateSPTAbt($id, $data)
    {
        $this->db->where('spt_id', $id);
        $this->db->update('spt_detil_abt', $data);
        return  $this->db->affected_rows();
    }

    function deleteUsers($id, $table)
    {
        $this->db->where('user_id', $id);
        $this->db->delete($table);
    }

    function userlevel()
    {
        return $this->db->order_by('id_level ASC')
            ->get('tbl_userlevel')
            ->result();
    }

    function getImage($id)
    {
        $this->db->select('image');
        $this->db->from('wp_user');
        $this->db->where('user_id', $id);
        return $this->db->get();
    }


    function get_sptID($where, $table)
    {
        $this->db->select('spt_id');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        $spt_id = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $spt_id =  $row->spt_id;
        }
        return $spt_id;
    }


    function get_wp_wr_hotel($where, $table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        // $spt_id = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            // $spt_id =  $row->spt_id;
        }
        return $row;
    }

    function get_ref_gol_hotel($where, $table)
    {
        $this->db->select('golongan');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        $golongan = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $golongan =  $row->golongan;
        }
        return $golongan;
    }


    function get_wp_wr_restoran($where, $table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        // $spt_id = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            // $spt_id =  $row->spt_id;
        }
        return $row;
    }

    function get_minerba_detil($where, $table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        // $spt_id = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            // $spt_id =  $row->spt_id;
        }
        return $row;
    }

    function get_abt_detil($where, $table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        // $spt_id = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            // $spt_id =  $row->spt_id;
        }
        return $row;
    }

    function get_jenis_mblb($where, $table)
    {
        $this->db->select('jenis_mblb');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        $jenis_mblb = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $jenis_mblb =  $row->jenis_mblb;
        }
        return $jenis_mblb;
    }

    function get_ref_jenis_restoran($where, $table)
    {
        $this->db->select('jenis_restoran');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        $jenis_restoran = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $jenis_restoran =  $row->jenis_restoran;
        }
        return $jenis_restoran;
    }

    function hapus_billing($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    function get_group_billing($periode, $jual1, $jual2, $groupid)
    {

        $this->db->select('s.spt_idwpwr, s.spt_periode_jual1, s.spt_periode_jual2, s.spt_pajak, s.spt_kode_billing, wp.npwpd ');
        $this->db->join('wp_user wp ', 's.spt_idwpwr=wp.id_wp_wr');
        $this->db->where("s.spt_periode", $periode);
        $this->db->where("s.spt_periode_jual1", $jual1);
        $this->db->where("s.spt_periode_jual2", $jual2);
        $this->db->where("wp.user_id", $groupid);
        $this->db->from('spt s');
        $query = $this->db->get();
        return $query->result();
    }

    function get_group_billing_det($periode, $jual1, $jual2, $groupid)
    {

        $this->db->select('s.spt_idwpwr, s.spt_periode_jual1, s.spt_periode_jual2, s.spt_pajak, s.spt_kode_billing, g.npwpd ');
        $this->db->join('data_group g ', 's.spt_idwpwr=g.id_wpwr');
        $this->db->where("s.spt_periode", $periode);
        $this->db->where("s.spt_periode_jual1", $jual1);
        $this->db->where("s.spt_periode_jual2", $jual2);
        $this->db->where("g.groupid", $groupid);
        $this->db->from('spt s');
        $query = $this->db->get();
        return $query->result();
    }

    function get_edit_esptpd($spt_id)
    {

        $this->db->select('s.spt_nomor,  s.spt_tgl_proses, s.spt_tgl_entry , s.spt_kode_billing, s.spt_pajak, s.spt_jenis_pemungutan, s.spt_periode_jual1, s.spt_periode_jual2, s.spt_periode, sd.spt_dt_jumlah, sd.spt_dt_pajak, k.korek_nama, k.korek_persen_tarif, k.korek_id, sd.spt_dt_id ');
        $this->db->join('spt_detail sd', 'sd.spt_dt_id_spt=s.spt_id');
        $this->db->join('kode_rekening k', 'sd.spt_dt_korek=k.korek_id');
        $this->db->where("s.spt_id", $spt_id);
        $this->db->from('spt s');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
        }

        return $row;
    }

    function get_edit_esptpd_det($jenis_pajakretribusi, $spt_id)
    {
        $this->db->select('spt_id, spt_periode, spt_kode_billing, spt_dt_pajak, spt_nomor, spt_tgl_proses, spt_tgl_entry, spt_periode, spt_idwpwr, wp_wr_gol, ref_kodus_kode, wp_wr_no_urut, 
                            camat_kode, lurah_kode, wp_wr_nama, wp_wr_almt, wp_wr_lurah, wp_wr_camat, wp_wr_kabupaten, spt_jenis_pemungutan, spt_periode_jual1 ,  spt_periode_jual2, spt_dt_id, spt_dt_korek, koderek, jenis AS korek_rincian, klas AS korek_sub1, korek_nama, spt_dt_jumlah, spt_dt_persen_tarif, spt_pajak, netapajrek_id, setorpajret_id,spt_kode ');
        $this->db->join('spt_detail sptd', 'spt.spt_id = sptd.spt_dt_id_spt', 'left');
        $this->db->join('wp_wr vwp', 'spt.spt_idwpwr=vwp.wp_wr_id');
        $this->db->join('penetapan_pajak_retribusi ppr', 'ppr.netapajrek_id_spt=spt.spt_id', 'left');
        $this->db->join('setoran_pajak_retribusi spr', 'spt.spt_id = spr.setorpajret_id_spt 
                        AND spt.spt_status=spr.setorpajret_jenis_ketetapan
                        AND spt.spt_jenis_pajakretribusi=spr.setorpajret_jenis_pajakretribusi', 'left');
        // $this->db->join('setoran_pajak_retribusi spr', 'spt.spt_status=spr.setorpajret_jenis_ketetapan', 'left');
        // $this->db->join('setoran_pajak_retribusi spr', 'spt.spt_jenis_pajakretribusi=spr.setorpajret_jenis_pajakretribusi', 'left');
        $this->db->join('v_kode_rekening rek', 'sptd.spt_dt_korek = rek.korek_id', 'left');
        $this->db->where("spt.spt_jenis_pajakretribusi", $jenis_pajakretribusi);
        $this->db->where("spt.spt_id", $spt_id);
        $this->db->from('spt');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
        }

        return $row;
    }

    function get_esptpd_detil($spt_id)
    {
        $this->db->select('*');
        $this->db->where("spt_dt_id_spt", $spt_id);
        $this->db->from('spt_detail');
        $this->db->order_by('spt_dt_id asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_v_rekening($koderek)
    {
        $this->db->select('* ');
        $this->db->where("koderek", $koderek);
        $this->db->from(' v_kode_rekening_pajak_detail');
        $query = $this->db->get();
        return $query->result();
    }

    function get_v_rekening_ppj($koderek)
    {
        $this->db->select('* ');
        $this->db->where("koderek", $koderek);
        $this->db->where("jenis <>", '01');
        $this->db->where("klas", '00');
        $this->db->from('v_kode_rekening');
        $query = $this->db->get();
        return $query->result();
    }

    function get_nama_wp($npwprd)
    {
        $this->db->select('wp_wr_nama');
        $this->db->where("npwprd", $npwprd);
        $this->db->from('wp_wr');
        $query = $this->db->get();

        $nama = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $nama =  $row->wp_wr_nama;
        }
        return $nama;
    }

    function getJenisMblb()
    {
        $this->db->select('*');
        $this->db->from('ref_jenis_mblb');
        $query = $this->db->get();
        return $query->result();
    }

    function getTarifDasar($mblb_id, $satuan)
    {
        if ($satuan == 1) {
            $this->db->select('tarif_kubik');
            $this->db->where("ref_mblb_id", $mblb_id);
            $this->db->from('ref_jenis_mblb');
            $query = $this->db->get();
        } else {
            $this->db->select('tarif_ton');
            $this->db->where("ref_mblb_id", $mblb_id);
            $this->db->from('ref_jenis_mblb');
            $query = $this->db->get();
        }
        return $query->row();
    }

    function getKodePajak($jenispajak)
    {
        $this->db->select('rek_bank');
        $this->db->join('tbl_ref_rekening b', 'a.kode_pajak = b.rek_epada', 'left');
        $this->db->where("bundel_id", $jenispajak);
        $this->db->from('bundel_pajak_retribusi a');
        $query = $this->db->get();
        return $query->row();
    }

    function getIdAbt()
    {
        $this->db->select_max('spt_detil_abt_id');
        $this->db->from('spt_detil_abt');
        $query = $this->db->get()->row();

        return $query;
    }

    function getWp($jenis_pajak, $kegus)
    {
        $this->db->select('*');
        $this->db->where("pajak_id", $jenis_pajak);
        $this->db->where("kegus_id", $kegus);
        $this->db->from('wp_wr_detil');
        $query = $this->db->get()->result();

        return $query;
    }

    function getWpDetail($wp_id_detil)
    {
        $this->db->select('a.wp_wr_detil_id,a.wp_wr_id, a.pajak_id, a.kegus_id, d.nama_pemilik, a.nama, d.npwprd, a.alamat, a.no_telepon, b.nama_paret, b.jenis_pemungutan, c.persen_tarif, c.nama_kegus');
        $this->db->join('bundel_pajak_retribusi b', 'a.pajak_id = b.bundel_id', 'left');
        $this->db->join('ref_kegiatan_usaha c', 'a.kegus_id = c.ref_kegus_id', 'left');
        $this->db->join('wp_wr d', 'a.wp_wr_id = d.wp_wr_id', 'left');
        $this->db->where("a.wp_wr_detil_id", $wp_id_detil);
        $this->db->from('wp_wr_detil a');
        $query = $this->db->get()->row();

        return $query;
    }

    function get_info_wp($wp_wr_detil_id)
    {

        $this->db->select('wp_wr_detil_id, nama');
        $this->db->where("wp_wr_detil_id", $wp_wr_detil_id);
        $this->db->from('wp_wr_detil');

        $query = $this->db->get();
        return $query->row();
    }

    function cek_lapor_pajak($pajak_lalu)
    {
        $this->db->select('tgl_proses');
        $this->db->where("masa_pajak1", $pajak_lalu);
        $this->db->from('spt');

        $query = $this->db->get();
        return $query->row();
    }
}
