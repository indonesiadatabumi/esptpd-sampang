<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_pendaftaranwp extends CI_Model
{
    function Aplikasi()
    {
        return $this->db->get('aplikasi');
    }

    function Auth($username, $password)
    {
        //menggunakan active record . untuk menghindari sql injection
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $this->db->where("is_active", 'Y');
        return $this->db->get("uptd_user");
    }
    function check_db($username)
    {
        return $this->db->get_where('wp_user', array('npwpd' => $username));
        // return $this->db->get_where('tbl_user', array('username' => $username));
    }

    function check_admin($username)
    {
        return $this->db->get_where('uptd_user', array('username' => $username));
        // return $this->db->get_where('tbl_user', array('username' => $username));
    }

    function get_register_user()
    {
        // $this->db->select('COALESCE(MAX(no_reg)::INT,0) + 1 as   max_no_register ');
        $this->db->select('*');
        $this->db->from('wp_user');
        $this->db->order_by('user_id', 'DESC');

        $query = $this->db->get();

        $max_urut = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $max_urut =  (int) $row->no_reg + 1;
        }
        return $max_urut;
    }

    function get_kadis()
    {
        $where = array(
            'pejda_jabatan' => '32',
            'pejda_aktif' => 'TRUE'
        );

        $query = $this->db->get_where('v_pejabat_daerah', $where);
        return $query->row();
    }


    function get_user()
    {
        $this->db->select('COALESCE(MAX(user_id)::INT,0) + 1 as   max_no_register ');
        $this->db->from('wp_user');
        $query = $this->db->get();

        $max_urut = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $max_urut =  $row->max_no_register;
        }
        return $max_urut;
    }

    function get_next_number_wp($jenis = 'p')
    {

        $this->db->select('COALESCE(MAX(wp_wr_no_urut)::INT,0) + 1 as next_nomor_urut');
        $this->db->from('wp_wr');
        $this->db->where('wp_wr_jenis', $jenis);
        $query = $this->db->get();

        $next_nomor_urut = '';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $next_nomor_urut =  $row->next_nomor_urut;
            if (strlen($next_nomor_urut) < 7) {
                $selisih = 7 - strlen($next_nomor_urut);
                for ($i = 1; $i <= $selisih; $i++) {
                    $next_nomor_urut = "0" . $next_nomor_urut;
                }
            }
        }

        return $next_nomor_urut;
    }

    function get_namawp($npwpd)
    {

        $this->db->select('wp_wr_nama');
        $this->db->where("npwprd", $npwpd);
        $this->db->from('v_wp_wr');
        $query = $this->db->get();

        $nama = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $nama =  $row->wp_wr_nama;
        }
        return $nama;
    }

    function get_wp_wr_id($npwpd)
    {

        $this->db->select('wp_wr_id');
        $this->db->where("npwprd", $npwpd);
        $this->db->from('v_wp_wr');
        $query = $this->db->get();

        $nama = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $nama =  $row->wp_wr_id;
        }
        return $nama;
    }

    function get_npwpd($wp_wr_id)
    {

        $this->db->select('npwprd');
        $this->db->where("wp_wr_id", $wp_wr_id);
        $this->db->from('v_wp_wr');
        $query = $this->db->get();

        $nama = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $nama =  $row->npwprd;
        }
        return $nama;
    }


    function get_telp_milik($npwpd)
    {

        $this->db->select('wp_wr_telp_milik');
        $this->db->where("npwprd", $npwpd);
        $this->db->from('v_wp_wr');
        $query = $this->db->get();

        $nama = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $nama =  $row->wp_wr_telp_milik;
        }
        return $nama;
    }

    function get_email($email)
    {

        $this->db->select('wp_wr_email');
        $this->db->where("wp_wr_email", $email);
        $this->db->from('wp_wr');
        $query = $this->db->get();

        $email = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $email =   $row->wp_wr_email;
        }
        return $email;
    }

    function get_nik($nik)
    {

        $this->db->select('wp_wr_nik');
        $this->db->where("wp_wr_nik", $nik);
        $this->db->from('wp_wr');
        $query = $this->db->get();

        $nik = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $nik =  $row->wp_wr_nik;
        }
        return $nik;
    }

    /**
     * get kecamatan
     */
    function get_kecamatan()
    {
        $this->db->select('*');
        $this->db->from('kecamatan');
        $this->db->order_by('camat_kode', 'ASC');

        // if ($this->session->userdata('USER_SPT_CODE') != "10")
        //     $this->db->where('camat_kode', $this->session->userdata('USER_SPT_CODE'));

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * get kelurahan
     */
    function get_kelurahan($id_kecamatan)
    {
        $this->db->select('lurah_id, lurah_kode, lurah_nama');
        $this->db->from('kelurahan');
        $this->db->where(array('lurah_kecamatan' => $id_kecamatan));
        $this->db->order_by('lurah_kode', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * check is exist wp_wr
     * @param unknown_type $nomor_urut
     */
    function is_exist_wp_wr($nomor_urut)
    {
        $this->db->from('wp_wr');
        $this->db->where(array('wp_wr_no_urut' => $nomor_urut));
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? true : false;
    }


    function is_exist_wp_users($npwpd)
    {
        $this->db->from('wp_user');
        $this->db->where(array('npwpd' => $npwpd));
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? true : false;
    }

    /**
     * next value
     * @param unknown_type $seq
     */
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

    /**
     * get record value
     * @param unknown_type $field_name
     * @param unknown_type $table_name
     * @param unknown_type $criteria
     */
    public function get_record_value($field_name, $table_name, $criteria = NULL)
    {
        $sql = "SELECT $field_name FROM $table_name ";
        if ($criteria != NULL)
            $sql .= "WHERE $criteria";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return array_pop($query->row_array());
        }

        return null;
    }

    function history_log($module, $action, $description)
    {
        $case_action = "";
        if (strlen($action) == 1) {
            switch (strtoupper($action)) {
                case "I":
                    $case_action = "INSERT";
                    break;
                case "U":
                    $case_action = "UPDATE";
                    break;
                case "D":
                    $case_action = "DELETE";
                    break;
                case "P":
                    $case_action = "PRINT";
                    break;
                default:
                    $case_action = "";
                    break;
            }
        } else {
            $case_action = $action;
        }

        $hislog = array();
        $hislog["hislog_id"] = uuid();
        $hislog["hislog_ip_address"] = $this->input->ip_address();
        $hislog["hislog_module"] = strtoupper($module);
        $hislog["hislog_action"] = strtoupper($case_action);
        $hislog["hislog_description"] = $description;
        $hislog["hislog_opr_user"] = $this->session->userdata('USER_NAME');
        //	$hislog["hislog_time"] = "NOW()"; 
        $hislog["hislog_time"] = date('Y-m-d H:i:s');
        $this->db->insert('history_log', $hislog);
    }

    /**
     * get bidang usaha
     */
    function get_bidang_usaha()
    {
        $result = array();

        $this->db->from('ref_kode_usaha');
        $this->db->order_by('ref_kodus_kode', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function get_kegiatan_usaha($pajakid)
    {
        $result = array();

        $this->db->from('ref_kegiatan_usaha');
        $this->db->where('pajak_id', $pajakid);
        $this->db->order_by('ref_kegus_id', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_kamar()
    {
        $this->db->from('ref_jenis_kamar');
        // $this->db->where('pajak_id', $pajakid);
        $this->db->order_by('ref_jenmartel_id', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_gol_hotel()
    {
        $this->db->from('ref_gol_hotel');
        // $this->db->where('pajak_id', $pajakid);
        $this->db->order_by('ref_kode', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_jns_restoran()
    {
        $this->db->from('ref_gol_hotel');
        // $this->db->where('pajak_id', $pajakid);
        $this->db->order_by('ref_kode', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function get_hotel_detil_id()
    {
        $this->db->select('CASE WHEN MAX(wp_wr_hotel_id::INT) + 1 IS NULL then 1
				ELSE MAX(wp_wr_hotel_id::INT) + 1 END as wp_wr_hotel_id ');
        $this->db->from('wp_wr_hotel');
        $query = $this->db->get();

        $max_urut = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $max_urut =  $row->wp_wr_hotel_id;
        }
        return $max_urut;
    }

    function get_restoran_detil_id()
    {
        $this->db->select('CASE WHEN MAX(wp_wr_restoran_id::INT) + 1 IS NULL then 1
				ELSE MAX(wp_wr_restoran_id::INT) + 1 END as wp_wr_restoran_id ');
        $this->db->from('wp_wr_restoran');
        $query = $this->db->get();

        $max_urut = '';

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $max_urut =  $row->wp_wr_restoran_id;
        }
        return $max_urut;
    }

    //insert data 
    function insert($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        return  $this->db->affected_rows();
    }

    function insert_register($tabel, $data)
    {
        $insert = $this->db->insert($tabel, $data);
        return $insert;
    }
}

/* End of file Mod_login.php */
