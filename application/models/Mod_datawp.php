<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Mod_datawp extends CI_Model
{
    var $table = 'wp_wr';
    var $column_search = array('CAST(wp_wr_id as varchar)', 'nama', 'alamat', 'kelurahan', 'nama_paret');
    var $column_order = array('wp_wr_id', 'nama', 'alamat', 'kelurahan', 'nama_paret');
    var $order = array('wp_wr_id' => 'asc');
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        // $this->db->from('barang');
        $this->db->select('wp_wr_id, nama, alamat, kelurahan, kecamatan, nama_paret');
        $this->db->from('wp_wr a');
        $this->db->join('bundel_pajak_retribusi b', 'b.bundel_id=a.pajak_id');
        $this->db->where('a.status', 't');
        // $this->db->order_by("wp_wr_no_urut", "asc");
        // return $this->db->get()->result_array();

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
        // $this->db->from('barang');
        $this->db->select('wp_wr_id, nama, alamat, kelurahan, kecamatan, nama_paret');
        $this->db->from('wp_wr a');
        $this->db->join('bundel_pajak_retribusi b', 'b.bundel_id=a.pajak_id');
        $this->db->where('a.status', 't');

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

    function get_wrnama($wp_id)
    {
        $this->db->where('wp_wr_id', $wp_id);
        return $this->db->get('wp_wr')->row();
    }

    function get_spt($wpid)
    {
        $this->db->select("a.spt_id, a.nomor_spt, to_char(a.tgl_proses, 'DD-MM-YYYY') as tgl_proses, a.tahun_pajak, 
                        to_char(a.masa_pajak1, 'DD-MM-YYYY') as masa_pajak1, 
                        to_char(a.masa_pajak2, 'DD-MM-YYYY') as masa_pajak2, a.pajak, a.pajak_id, 
                        a.kode_billing, status_bayar, b.spt_detil_id", False);
        $this->db->from('spt a');
        $this->db->join('spt_detil b', 'a.spt_id=b.spt_id');
        $this->db->where('a.wp_wr_id', $wpid);
        $this->db->order_by('a.spt_id desc');

        $query = $this->db->get();
        return $query->result();
    }
}
