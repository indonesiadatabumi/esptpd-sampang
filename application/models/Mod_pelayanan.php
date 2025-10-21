<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_pelayanan extends CI_Model
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


    function _get_table_menu()
    {

        $this->db->select('g.noid, g.npwpd, wp.wp_wr_nama nama, wp.wp_wr_no_urut, wp.wp_wr_bidang_usaha');
        $this->db->join('v_wp_wr wp', 'g.npwpd=wp.npwprd');
        $this->db->where("g.groupid", $this->session->userdata('id_user'));
        $this->db->from('data_group g');
        $query = $this->db->get();

        return $query->result();
    }

    function _get_id_npwp($noreg)
    {


        $this->db->select('wp_wr_id, npwprd');
        $this->db->where(" wp_wr_no_urut", $noreg);
        $this->db->from('v_wp_wr');
        $this->db->order_by('wp_wr_no_urut desc');


        $query = $this->db->get();
        return $query->result();
    }

    function _get_esptpd_menu_group($noreg)
    {


        // $this->db->select('wp.wp_wr_id, wp.npwprd, wp.wp_wr_nama, wp.wp_wr_almt, wp.wp_wr_lurah, wp.wp_wr_camat, wp.wp_wr_kabupaten, j.kode_rekening, j.kode_spt');
        // $this->db->join('v_wp_wr wp', 'CAST(wp.wp_wr_bidang_usaha as smallint)=CAST(j.ref_kodus_id as smallint)');
        // $this->db->where(" wp_wr_no_urut", $noreg);
        // $this->db->from('ref_jabatan j');

        $this->db->select('a.wp_wr_id, a.wp_wr_tgl_kartu, a.npwprd, a.wp_wr_nama, b.ref_kodus_id, b.ref_kodus_nama');
        $this->db->join('ref_kode_usaha b', 'a.ref_kodus_kode=b.ref_kodus_kode');
        $this->db->where("a.wp_wr_no_urut", $noreg);
        $this->db->from('v_wp_wr a');

        $query = $this->db->get();
        return $query->result();
    }

    function _get_data_wp($no_reg)
    {

        $this->db->select('wp.wp_wr_id, wp.npwprd, wp.wp_wr_nama nama, wp.wp_wr_almt alamat, wp.wp_wr_lurah kelurahan, wp.wp_wr_camat kecamatan, wp.wp_wr_kabupaten kota, j.kode_rekening, j.kode_spt');
        $this->db->join('ref_jabatan j', 'CAST(wp.wp_wr_bidang_usaha as smallint)=CAST(j.ref_kodus_id as smallint)');
        // $this->db->where("wp.wp_wr_no_urut", substr($this->session->userdata('username'), 7, 7));
        $this->db->where("wp.wp_wr_no_urut", $no_reg);
        $this->db->from('v_wp_wr wp');
        $query = $this->db->get();

        return $query->result();
    }

    function _get_data_SPPT($wp_id)
    {
        $this->db->select('*');
        $this->db->where("spt_idwpwr", $wp_id);
        $this->db->from('spt');
        $this->db->order_by('spt_periode_jual1 desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
        }

        return $row;
    }

    function _cekSPT_nomor($npwprd, $spt_periode, $masa_pajak)
    {

        $this->db->select('*');
        $this->db->where("tahun_pajak", $spt_periode);
        $this->db->where("masa_pajak1", $spt_jenis);
        $this->db->where("npwprd", $npwprd);
        $this->db->from('spt');
        $query = $this->db->get();

        $res = '';

        if ($query->num_rows() > 0) {
            $res = '2';
        }
        return $res;
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
        $insert = $this->db->insert($tabel, $data);
        return $insert;
    }

    function insertPelayanan($tabel, $data)
    {
        $insert = $this->db->insert($tabel, $data);
        return $insert;
    }

    function get_nama_wp($npwprd)
    {
        $this->db->select('nama');
        $this->db->where("wp_wr_id", $npwprd);
        $this->db->from('wp_wr');

        $query = $this->db->get();

        $nama = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $nama =  $row->nama;
        }
        return $nama;
    }

    private function _get_datatables_query()
    {

        $this->db->select('spt_id, wp_wr_id, tgl_proses, tahun_pajak, masa_pajak1, masa_pajak2, pajak, 
				kode_billing, status_bayar,wp_wr_id, nilai_terkena_pajak, pajak_id ');
        $this->db->where('tahun_pajak >=', '2023');
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
        $query = $this->db->get('spt');
        return $query->result();
    }

    function getPrint($spt_id)
    {
        $this->db->select('s.spt_id, EXTRACT(YEAR FROM s.masa_pajak1) as tahunpajak, s.masa_pajak1, s.masa_pajak2, s.tahun_pajak, s.pajak,s.pajak_id, sd.nilai_terkena_pajak, 
                        s.persen_tarif,   wp.nama, s.kode_billing, tgl_proses, s.status_bayar, s.wp_wr_id, s.wp_wr_detil_id, wp.golongan,wp.jenis, wp.npwprd, 
                        wp.kecamatan_id, wp.kecamatan, wp.kelurahan_id,wp.kelurahan, s.keterangan, s.pengguna_catering');
        $this->db->join('spt_detil sd', 's.spt_id=sd.spt_id');
        // $this->db->join('kode_rekening k', 'sd.spt_dt_korek=k.korek_id');
        $this->db->join('wp_wr wp', 'wp.wp_wr_id=s.wp_wr_id');
        $this->db->where("s.spt_id", $spt_id);
        $this->db->from('spt s');
        $query = $this->db->get();
        return $query->result();
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
        $query = $this->db->get('v_wp_wr');
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
    }

    function updateSPTDetil($id, $data)
    {
        $this->db->where('spt_dt_id', $id);
        $this->db->update('spt_detail', $data);
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

    function reset_pass($id, $data)
    {
        $this->db->where('user_id', $id);
        $this->db->update('wp_user', $data);
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

        $this->db->select('s.spt_nomor,  s.spt_tgl_proses, s.spt_tgl_entry , s.spt_kode_billing, s.spt_jenis_pemungutan, s.spt_periode_jual1, s.spt_periode_jual2, s.spt_periode, sd.spt_dt_jumlah, sd.spt_dt_pajak, k.korek_nama, k.korek_persen_tarif, k.korek_id, sd.spt_dt_id ');
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

    function listSptpdSkpd($username)
    {
        $this->listSptpdSkpd_query($username);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function listSptpdSkpd_query($username)
    {

        $this->db->select('spt_id, wp_wr_id, tgl_proses, tahun_pajak, masa_pajak1, masa_pajak2, pajak, 
				kode_billing, status_bayar,wp_wr_id, nilai_terkena_pajak, pajak_id ');
        $this->db->where('tahun_pajak >=', '2023');
        $this->db->where('created_by', $username);
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

    public function count_all_skpd($username)
    {
        $this->db->where('created_by', $username);
        $this->db->from('spt');

        return $this->db->count_all_results();
    }

    function count_filtered_skpd($username)
    {
        $this->listSptpdSkpd_query($username);
        $query = $this->db->get();
        return $query->num_rows();
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
}
