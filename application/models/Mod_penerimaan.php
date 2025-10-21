<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Mod_penerimaan extends CI_Model
{
    var $table = 'spt';
    var $column_search = array('spt_id');
    var $column_order = array('spt_id');
    var $order = array('spt_id' => 'desc');
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    private function _get_datatables_query($jenis)
    {
        $this->db->select('s.status_bayar, tp.*');
        $this->db->from('spt s');
        $this->db->join('transaksi_pajak tp', 's.kode_billing=tp.kode_billing');
        $this->db->where('s.pajak_id ', $jenis);
        $this->db->where('tp.tgl_bayar >=', date('Y-m-d') . ' 01:00:00');
        $this->db->where('tp.tgl_bayar <=', date('Y-m-d') . ' 23:59:00');
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

    function get_datatables($jenis)
    {
        $this->_get_datatables_query($jenis);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($jenis)
    {
        $this->_get_datatables_query($jenis);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all($jenis)
    {
        $this->db->select('s.status_bayar, tp.*');
        $this->db->from('spt s');
        $this->db->join('transaksi_pajak tp', 's.kode_billing=tp.kode_billing');
        $this->db->where('s.pajak_id ', $jenis);
        $this->db->where('tp.tgl_bayar >=', date('Y-m-d') . ' 01:00:00');
        $this->db->where('tp.tgl_bayar <=', date('Y-m-d') . ' 23:59:00');

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
