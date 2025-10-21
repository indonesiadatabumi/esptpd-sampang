<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Mod_rekapwp extends CI_Model
{
    var $table = 'wp_user';
    var $column_search = array('CAST(npwpd as varchar)', 'nama', 'email', 'nama_kecamatan');
    var $column_order = array('npwpd', 'nama', 'email', 'nama_kecamatan');
    var $order = array('user_id' => 'desc');
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->select('a.user_id, a.npwpd, a.nama, a.email, a.is_active, b.kode_kecamatan,b.nama_kecamatan');
        $this->db->from('wp_user a');
        $this->db->join('ref_kecamatan b', 'b.kode_kecamatan=substring(a.npwpd,5,3)');
        $this->db->where('a.id_level', '4');
        $this->db->where('a.is_active', 'Y');

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
                    $this->db->where('b.kode_kecamatan', $_POST['searchByName']);
                } else {
                    $this->db->where('b.kode_kecamatan', $_POST['searchByName']);
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

    function count_all()
    {
        // $this->db->from('barang');
        $this->db->select('a.user_id, a.npwpd, a.nama, a.email, a.is_active ,b.kode_kecamatan,b.nama_kecamatan');
        $this->db->from('wp_user a');
        $this->db->join('ref_kecamatan b', 'b.kode_kecamatan=substring(a.npwpd,5,3)');
        $this->db->where('a.id_level', '4');
        $this->db->where('a.is_active', 'Y');

        return $this->db->count_all_results();
    }

    function insert_barang($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        return $insert;
    }

    function update_barang($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('barang', $data);
    }

    function get_brg($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('barang')->row();
    }

    function delete_brg($id, $table)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

    function get_wrnama($noreg)
    {
        $this->db->where('wp_wr_no_urut', $noreg);
        return $this->db->get('wp_wr')->row();
    }

    function get_spt($wpid)
    {
        $this->db->select("a.spt_id, a.spt_nomor, to_char(a.spt_tgl_entry, 'DD-MM-YYYY') as spt_tgl_entri, a.spt_periode, 
                        to_char(a.spt_periode_jual1, 'DD-MM-YYYY') as spt_periode_jual1, 
                        to_char(a.spt_periode_jual2, 'DD-MM-YYYY') as spt_periode_jual2, a.spt_pajak, a.spt_jenis_pajakretribusi, 
                        a.spt_kode_billing, status_bayar, b.spt_dt_id", False);
        $this->db->from('spt a');
        $this->db->join('spt_detail b', 'a.spt_id=b.spt_dt_id_spt');
        $this->db->where('a.spt_idwpwr', $wpid);
        $this->db->order_by('a.spt_id desc');

        $query = $this->db->get();
        return $query->result();
    }

    function cetakdatauser($kec)
    {
        $this->db->select('a.user_id, a.npwpd, a.nama, a.email, a.status, a.pj_wp, b.camat_kode,b.camat_nama');
        $this->db->from('wp_user a');
        $this->db->join('kecamatan b', 'b.camat_kode=substring(a.npwpd,16,2)');
        $this->db->where('a.level', NULL);
        $this->db->where('a.status', '1');
        if ($kec) {
            $this->db->where('b.camat_kode', $kec);
        }
        $this->db->order_by('a.tgl_daftar desc');

        $query = $this->db->get();
        return $query->result();
    }
}
