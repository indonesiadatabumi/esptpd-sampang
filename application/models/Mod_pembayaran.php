<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Mod_pembayaran extends CI_Model
{
    var $table = 'transaksi_pajak';
    var $column_search = array('kode_billing');
    var $column_order = array('kode_billing');
    var $order = array('tgl_bayar' => 'desc');
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    private function _get_datatables_query()
    {
        $this->db->select('s.status_bayar, tp.*, wp.nama');
        $this->db->from('spt s');
        $this->db->join('transaksi_pajak tp', 's.kode_billing=tp.kode_billing');
        $this->db->join('wp_wr_detil wp', 's.wp_wr_detil_id=wp.wp_wr_detil_id');
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
        $this->db->select('s.status_bayar, tp.*');
        $this->db->from('spt s');
        $this->db->join('transaksi_pajak tp', 's.kode_billing=tp.kode_billing');

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


    function update_statpayment($id, $data)
    {
        $this->db->where('spt_kode_billing', $id);
        $this->db->update('spt', $data);
    }

    function update_detpayment($id, $data)
    {
        $this->db->where('kode_billing', $id);
        $this->db->update('payment.pembayaran_sptpd', $data);
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
