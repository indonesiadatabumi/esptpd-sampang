<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Mod_rekappembayaran extends CI_Model
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
        $this->db->where('s.tahun_pajak::integer', 'tp.tahun_pajak::integer', false);
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

            if ($_POST['searchStartDate'] && $_POST['searchEndDate']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->where('tp.tgl_bayar >=', $_POST['searchStartDate']);
                    $this->db->where('tp.tgl_bayar <=', $_POST['searchEndDate']);
                } else {
                    $this->db->where('tp.tgl_bayar >=', $_POST['searchStartDate']);
                    $this->db->where('tp.tgl_bayar <=', $_POST['searchEndDate']);
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
            // $this->db->limit($_POST['length'], 1000);
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
        $this->db->where('s.tahun_pajak::integer', 'tp.tahun_pajak::integer', false);

        return $this->db->count_all_results();
    }

    function insert_bayar($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        return $insert;
    }

    function cetakpenerimaan($startdate, $enddate)
    {
        $this->db->select('s.status_bayar, p.*');
        $this->db->from('spt s');
        $this->db->join('payment.pembayaran_sptpd p', 's.spt_kode_billing=p.kode_billing');
        $this->db->where('s.spt_periode::integer', 'p.tahun_pajak::integer', false);
        if ($startdate && $enddate) {
            $this->db->where('p.tgl_pembayaran >=', $startdate);
            $this->db->where('p.tgl_pembayaran <=', $enddate);
        }
        $this->db->order_by('p.tgl_pembayaran desc');

        $query = $this->db->get();
        return $query->result();
    }
}
