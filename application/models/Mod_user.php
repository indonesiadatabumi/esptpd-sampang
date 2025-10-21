<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Mod_user extends CI_Model
{

    var $table = 'wp_user';
    var $column_order = array('username', 'npwpd', 'nama', 'id_level', 'image', 'is_active');
    var $column_search = array('username', 'npwpd', 'nama',  'is_active');
    var $order = array('user_id' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->select('a.*,b.nama_level');
        $this->db->join('tbl_userlevel b', 'a.id_level=b.id_level');
        $this->db->from('wp_user a');

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

        $this->db->from('wp_user');
        return $this->db->count_all_results();
    }

    function view_user($id)
    {
        $this->db->where('user_id', $id);
        return $this->db->get('wp_user');
    }

    function getAll()
    {
        $this->db->select('a.*,b.nama_level');
        $this->db->join('tbl_userlevel b', 'a.id_level = b.id_level');
        $this->db->order_by('a.user_id desc');
        return $this->db->get('wp_user a');
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

    function get_wp_wr($id)
    {
        $this->db->where("npwprd", $id);
        return $this->db->get("wp_wr")->row();
    }

    function get_namawp($npwpd)
    {

        $this->db->select('nama');
        $this->db->where("npwprd", $npwpd);
        $this->db->from('wp_wr');
        $query = $this->db->get();

        $nama = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $nama =  $row->nama;
        }
        return $nama;
    }

    function get_userid()
    {

        $this->db->select('COALESCE(MAX(user_id)::INT,0) + 1  as user_id');
        $this->db->from('wp_user');
        $query = $this->db->get();

        $nama = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $nama =  $row->user_id;
        }
        return $nama;
    }

    function updateUser($id, $data)
    {
        $this->db->where('user_id', $id);
        $this->db->update('wp_user', $data);
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
}
