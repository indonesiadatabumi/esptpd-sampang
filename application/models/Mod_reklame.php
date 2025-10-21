<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Mod_reklame extends CI_Model
{
    var $table = 'wp';
    var $column_search = array('wp_rek_nama', 'wp_rek_alamat');
    var $column_order = array('wp_rek_nama', 'wp_rek_alamat');
    var $order = array('wp_rek_id' => 'desc');
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    private function _get_datatables_query()
    {
        $this->db->select('wp.*, s.spt_idwp_reklame, s.spt_pajak, s.spt_periode, s.spt_jenis_pajakretribusi, s.spt_kode_billing, s.status_bayar');
        $this->db->from('v_wp_reklame wp');
        $this->db->join('spt s', 'wp.wp_rek_id=s.spt_idwp_reklame');
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

    function count_all()
    {
        $this->db->select('wp.*, s.spt_idwp_reklame, s.spt_pajak, s.spt_periode, s.spt_jenis_pajakretribusi, s.spt_kode_billing, s.status_bayar');
        $this->db->from('v_wp_reklame wp');
        $this->db->join('spt s', 'wp.wp_rek_id=s.spt_idwp_reklame');

        return $this->db->count_all_results();
    }

    function getPrint($spt_id)
    {
        $this->db->select('wp.*, s.spt_nomor, s.spt_pajak, s.spt_periode, s.spt_kode_billing, s.spt_tgl_proses, 
                        s.spt_no_register, s.spt_periode_jual1, np.netapajrek_tgl_jatuh_tempo, vp.koderek_titik, vp.korek_nama ');
        $this->db->join('spt s', 'wp.wp_rek_id=s.spt_idwp_reklame');
        $this->db->join('penetapan_pajak_retribusi np', 's.spt_id=np.netapajrek_id_spt');
        $this->db->join('v_kode_rekening_pajak5_7digit vp ', 's.spt_kode_rek=vp.korek_id');
        $this->db->where("wp.wp_rek_id", $spt_id);
        $this->db->from('v_wp_reklame wp');
        $query = $this->db->get();
        return $query->result();
    }
}
