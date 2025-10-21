<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Mod_bayar extends CI_Model
{
    var $table = 'spt';
    var $column_search = array('CAST(spt_id as varchar)', 'CAST(nomor_spt as varchar)', 'CAST(tgl_proses as varchar)', 'CAST(tahun_pajak as varchar)');
    var $column_order = array('spt_id', 'nomor_spt', 'tgl_proses', 'tahun_pajak');
    var $order = array('spt_id' => 'desc');
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    private function _get_datatables_query()
    {

        $this->db->from('spt a');
        $this->db->join('wp_wr_detil b ', 'a.wp_wr_detil_id=b.wp_wr_detil_id');
        $this->db->where('a.kode_billing <>', NULL);
        $this->db->where('a.masa_pajak1 >=', '2019-01-01');
        $this->db->where('a.status_bayar', '0');
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
        $this->db->from('spt');
        $this->db->where('kode_billing <>', NULL);
        $this->db->where('masa_pajak1 >=', '2019-01-01');
        $this->db->where('status_bayar', '0');
        return $this->db->count_all_results();
    }

    function insert_bayar($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        return $insert;
    }

    function update_bayar($id, $data)
    {
        $this->db->where('spt_id', $id);
        $this->db->update('spt', $data);
    }

    function get_bayar($id)
    {
        $this->db->where('spt_id', $id);
        return $this->db->get('spt')->row();
    }

    function delete_bayar($id, $table)
    {
        $this->db->where('spt_id', $id);
        $this->db->delete($table);
    }
}
