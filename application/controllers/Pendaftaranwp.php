<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendaftaranwp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('fungsi');
        $this->load->model(array('Mod_pendaftaranwp'));
    }

    public function index()
    {
        $data['no_register'] =  $this->get_next_number_wprd();

        $data['list_kecamatan'] = $this->get_kecamatan();
        // $data['kegiatan_usaha'] = $this->Mod_pendaftaranwp->get_kegiatan_usaha();
        $data['jenis_kamar'] = $this->Mod_pendaftaranwp->get_kamar();
        $data['golongan_hotel'] = $this->Mod_pendaftaranwp->get_gol_hotel();

        $this->load->view('admin/pendaftaran_wp', $data);
    }

    public function pendaftaranuser()
    {
        $data['no_register'] =  $this->get_next_number_wprd();


        $this->load->view('admin/pendaftaran_user', $data);
    }

    function get_next_number_wprd()
    {
        $result = $this->Mod_pendaftaranwp->get_next_number_wp();
        return $result;
        // echo json_encode($result);
    }

    function get_next_number_wp()
    {
        $result = $this->Mod_pendaftaranwp->get_next_number_wp();
        // return $result;
        echo json_encode($result);
    }

    function get_kegus()
    {
        $pajakid = '';
        $pajakid = $this->input->post('pajakid');

        // var_dump($pajakid);
        if ($pajakid) {
            $result = $this->Mod_pendaftaranwp->get_kegiatan_usaha($pajakid);
            foreach ($result as $row) {
                echo '<option value="' . $row->ref_kegus_id . '"> ' . $row->nama_kegus . '</option>';
            }
        } else {
            echo '<option value=""> - Silakan Pilih Jenis Usaha - </option>';
        }
        // echo json_encode($result);
    }

    function get_kecamatan()
    {
        $result = $this->Mod_pendaftaranwp->get_kecamatan();
        // echo json_encode($result);
        return $result;
    }

    function get_namawp()
    {
        $npwp = $this->input->post('npwpd');

        $result = $this->Mod_pendaftaranwp->get_namawp($npwp);
        $result = ($result != '') ? $result : 'NPWPD salah /Tidak Terdaftar';
        echo json_encode($result);
    }

    function get_email()
    {
        $email = $this->input->post('email');

        $result = $this->Mod_pendaftaranwp->get_email($email);
        // $result = ($result != '') ? $result : 'Email salah/Tidak Terdaftar!';
        $result = ($result != '') ? '1' : '0';
        echo json_encode($result);
    }

    function get_nik()
    {
        $nik = $this->input->post('nik');

        $result = $this->Mod_pendaftaranwp->get_nik($nik);
        // $result = ($result != '') ? $result : 'NIK diinput salah/Tidak Terdaftar';
        $result = ($result != '') ? '1' : '0';

        echo json_encode($result);
    }

    function register_user()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        $npwpd = $this->input->post('npwpd');
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $kriteria_byr = $this->input->post('kriteria_byr');

        $user_id = $this->Mod_pendaftaranwp->get_user();
        $no_reg = $this->Mod_pendaftaranwp->get_register_user();
        $no_register = $this->fungsi->tambah_nol($no_reg, 7);

        $id_wp_wr = $this->Mod_pendaftaranwp->get_wp_wr_id($npwpd);
        $no_hp  = $this->Mod_pendaftaranwp->get_telp_milik($npwpd);

        if ($this->Mod_pendaftaranwp->is_exist_wp_users($npwpd) == true) {
            echo json_encode(array(
                "error" => True,
                "msg" => "NPWPD  sudah terdaftar!!. Silahkan hubungi admin"
            ));
        } else {

            $arr_save = array(
                'user_id' => $user_id,
                'no_reg' => $no_register,
                'tgl_daftar' => date('Y-m-d'),
                'npwpd' => $npwpd,
                'nama' => $nama,
                'email' => $email,
                'password' => md5($password),
                'status' => '1',
                'id_wp_wr' => $id_wp_wr,
                'pj_wp' => 'Register online',
                'alamat' => $no_hp,
                'kriteria_byr' => $kriteria_byr,
                'id_level' => '4', //wajib pajak
                'is_active' => 'Y'
            );

            // var_dump($arr_save);
            $this->Mod_pendaftaranwp->insert_register('wp_user', $arr_save);
            echo json_encode(array("status" => TRUE));
        }
    }

    /**
     * get kelurahan controller
     */
    function get_kelurahan2()
    {
        $kecamatan = $this->input->get('_value');
        $arr_kecamatan =  explode("|", $kecamatan);
        if (count($arr_kecamatan) > 0)
            $id_kecamatan = $arr_kecamatan[0];
        else
            $id_kecamatan = $kecamatan;

        if (empty($id_kecamatan)) return false;

        $rs_kelurahan = $this->Mod_pendaftaranwp->get_kelurahan($id_kecamatan);

        $arr_data = array();
        $arr_data[] = array("" => "--");
        if (count($rs_kelurahan) > 0) {
            foreach ($rs_kelurahan as $row) {
                $arr_data[] = array($row->lurah_id . '|' . $row->lurah_nama => $row->lurah_kode . ' | ' . $row->lurah_nama);
            }
        }

        if (!empty($arr_data)) {
            echo json_encode($arr_data);
        }
    }

    function get_kelurahan()
    {
        $kecamatan = $this->input->post('kdkec');

        $arr_kecamatan =  explode("|", $kecamatan);
        if (count($arr_kecamatan) > 0)
            $id_kecamatan = $arr_kecamatan[0];
        else
            $id_kecamatan = $kecamatan;


        if (empty($id_kecamatan)) return false;

        $rs_kelurahan = $this->Mod_pendaftaranwp->get_kelurahan($id_kecamatan);

        foreach ($rs_kelurahan as $row) {
            echo '<option value=' . $row->lurah_id . '|' . $row->lurah_kode . '> ' . $row->lurah_kode . ' | ' . $row->lurah_nama . '</option>';
        }
    }

    /**
     * get kelurahan controller
     */
    function get_kelurahan_id()
    {
        $kecamatan = $this->input->get('_value');
        $arr_kecamatan =  explode("|", $kecamatan);
        if (count($arr_kecamatan) > 0)
            $id_kecamatan = $arr_kecamatan[0];
        else
            $id_kecamatan = $kecamatan;

        if (empty($id_kecamatan)) return false;

        $rs_kelurahan = $this->Mod_pendaftaranwp->get_kelurahan($id_kecamatan);

        $arr_data = array();
        $arr_data[] = array("" => "--");
        if (count($rs_kelurahan) > 0) {
            foreach ($rs_kelurahan as $row) {
                $arr_data[] = array($row->lurah_id => $row->lurah_kode . ' | ' . $row->lurah_nama);
            }
        }

        if (!empty($arr_data)) {
            echo json_encode($arr_data);
        }
    }

    function insert_data()
    {
        error_reporting(E_ALL & ~E_NOTICE);

        $result = array();

        list($wp_wr_kd_camat, $wp_wr_camat) =  explode("|", $this->input->post('input-kecamatan'));

        $wp_wr_kd_lurah = '';
        $wp_wr_lurah = '';
        if ($this->input->post('input-kelurahan') != '') {
            list($wp_wr_kd_lurah, $wp_wr_lurah) =  explode("|", $this->input->post('input-kelurahan'));
        }
        $wp_wr_no_urut = $this->input->post('no_register');

        if ($this->Mod_pendaftaranwp->is_exist_wp_wr($wp_wr_no_urut)) {
            echo json_encode(array(
                "error" => True,
                "msg" => "Nomor registrasi sudah terdaftar!!. Silahkan Tekan refresh   lalu klik simpan"
            ));
        } else {
            $wp_wr_tgl_tb = (!empty($_POST['wp_wr_tgl_tb']) ? $this->input->post('wp_wr_tgl_tb') : NULL);
            $wp_wr_tgl_kk = (!empty($_POST['wp_wr_tgl_kk']) ? $this->input->post('wp_wr_tgl_kk') : NULL);
            $next_val = $this->Mod_pendaftaranwp->next_val('wp_wr_wp_wr_id_seq');
            $jns_wajib_pajak = $this->input->post('input-jns_wajib_pajak');
            $jns_pajak = $this->input->post('input-jns_pajak');

            if ($jns_pajak == '1') {
                $bidus = '1';
            } else if ($jns_pajak == '2') {
                $bidus = '16';
            } else if ($jns_pajak == '3') {
                $bidus = '11';
            } else if ($jns_pajak == '4') {
                $bidus = '5';
            } else if ($jns_pajak == '2') {
                $bidus = '16';
            } else if ($jns_pajak == '5') {
                $bidus = '12';
            } else if ($jns_pajak == '6') {
                $bidus = '17';
            } else if ($jns_pajak == '7') {
                $bidus = '14';
            } else if ($jns_pajak == '8') {
                $bidus = '18';
            }

            $config['upload_path']   = './assets/foto/pendaftaran/';
            $config['allowed_types'] = 'pdf'; //mencegah upload backdor
            $config['max_size']      = '1000';
            $config['max_width']     = '2000';
            $config['max_height']    = '1024';
            $config['file_name']     = $next_val;


            $this->upload->initialize($config);

            if ($this->upload->do_upload('imagefile')) {
                $gambar = $this->upload->data();

                $data = array(
                    'wp_wr_id' => $next_val,
                    'wp_wr_no_form' => $jns_wajib_pajak . $wp_wr_no_urut,
                    'wp_wr_no_urut' => $wp_wr_no_urut,
                    'wp_wr_gol' => $jns_wajib_pajak,
                    'wp_wr_jenis' => 'p',
                    'wp_wr_nama' => addslashes(strtoupper($this->input->post('input-nama'))),
                    'wp_wr_almt' => htmlspecialchars(strip_tags(strtoupper($this->input->post('input-alamat'))), ENT_QUOTES),
                    'wp_wr_lurah' => $wp_wr_lurah,
                    'wp_wr_camat' => $wp_wr_camat,
                    'wp_wr_kd_lurah' => $wp_wr_kd_lurah,
                    'wp_wr_kd_camat' => $wp_wr_kd_camat,
                    'wp_wr_kabupaten' => strtoupper($this->input->post('input-kota')),
                    'wp_wr_telp' => $this->input->post('input-no_telepon'),
                    'wp_wr_kodepos' => $this->input->post('input-kode_pos'),

                    'wp_wr_nama_milik' => addslashes(strtoupper($this->input->post('input-nama_pemilik'))),
                    'wp_wr_almt_milik' => htmlspecialchars(strip_tags(strtoupper($this->input->post('input-alamat_pemilik'))), ENT_QUOTES),
                    'wp_wr_lurah_milik' => strtoupper($this->input->post('input-kelurahan_pemilik')),
                    'wp_wr_camat_milik' => strtoupper($this->input->post('input-kecamatan_pemilik')),
                    'wp_wr_kabupaten_milik' => strtoupper($this->input->post('input-kota_pemilik')),
                    'wp_wr_telp_milik' => $this->input->post('input-no_hp'),
                    'wp_wr_nik' => $this->input->post('input-nik_pemilik'),
                    'wp_wr_email' => $this->input->post('input-email_pemilik'),

                    'wp_wr_bidang_usaha' => $bidus,
                    'wp_wr_tgl_kartu' => $this->input->post('input-tgl_daftar'),
                    'wp_wr_tgl_terima_form' => $this->input->post('input-tgl_form_kembali'),
                    'wp_wr_tgl_bts_kirim' => $this->input->post('input-tgl_bts_kirim'),
                    'wp_wr_jns_pemungutan' => $jns_wajib_pajak,
                    'wp_wr_pejabat' => '1',
                    'wp_wr_kegus_id' => $this->input->post('input-kegus'),
                    'wp_wr_lamp' => $gambar['file_name'],
                );
            } else {

                $data = array(
                    'wp_wr_id' => $next_val,
                    'wp_wr_no_form' => $jns_wajib_pajak . $wp_wr_no_urut,
                    'wp_wr_no_urut' => $wp_wr_no_urut,
                    'wp_wr_gol' => $jns_wajib_pajak,
                    'wp_wr_jenis' => 'p',
                    'wp_wr_nama' => addslashes(strtoupper($this->input->post('input-nama'))),
                    'wp_wr_almt' => htmlspecialchars(strip_tags(strtoupper($this->input->post('input-alamat'))), ENT_QUOTES),
                    'wp_wr_lurah' => $wp_wr_lurah,
                    'wp_wr_camat' => $wp_wr_camat,
                    'wp_wr_kd_lurah' => $wp_wr_kd_lurah,
                    'wp_wr_kd_camat' => $wp_wr_kd_camat,
                    'wp_wr_kabupaten' => strtoupper($this->input->post('input-kota')),
                    'wp_wr_telp' => $this->input->post('input-no_telepon'),
                    'wp_wr_kodepos' => $this->input->post('input-kode_pos'),

                    'wp_wr_nama_milik' => addslashes(strtoupper($this->input->post('input-nama_pemilik'))),
                    'wp_wr_almt_milik' => htmlspecialchars(strip_tags(strtoupper($this->input->post('input-alamat_pemilik'))), ENT_QUOTES),
                    'wp_wr_lurah_milik' => strtoupper($this->input->post('input-kelurahan_pemilik')),
                    'wp_wr_camat_milik' => strtoupper($this->input->post('input-kecamatan_pemilik')),
                    'wp_wr_kabupaten_milik' => strtoupper($this->input->post('input-kota_pemilik')),
                    'wp_wr_telp_milik' => $this->input->post('input-no_hp'),
                    'wp_wr_nik' => $this->input->post('input-nik_pemilik'),
                    'wp_wr_email' => $this->input->post('input-email_pemilik'),

                    'wp_wr_bidang_usaha' => $bidus,
                    'wp_wr_tgl_kartu' => $this->input->post('input-tgl_daftar'),
                    'wp_wr_tgl_terima_form' => $this->input->post('input-tgl_form_kembali'),
                    'wp_wr_tgl_bts_kirim' => $this->input->post('input-tgl_bts_kirim'),
                    'wp_wr_jns_pemungutan' => $jns_wajib_pajak,
                    'wp_wr_pejabat' => '1',
                    'wp_wr_kegus_id' => $this->input->post('input-kegus')
                );
            }

            var_dump($data);
            echo json_encode(array("status" => TRUE, "wp_wr_id" => $next_val));


            // $insert_pendaftaran = $this->Mod_pendaftaranwp->insert("wp_wr", $data);

            // $arr_gol_kamar = $this->input->post('golongan_kamar');
            // $arr_jml_kamar = $this->input->post('jumlah_kamar');
            // $arr_tarif_kamar = $this->input->post('tarif_kamar');
            // $total_jml_kamar = $this->input->post('totaljumlahkamar');
            // $gol_hotel = $this->input->post('input-golongan_hotel');

            // $jenis_restoran = $this->input->post('input-jns_restoran');
            // $jml_meja = $this->input->post('jml_meja');
            // $jml_kursi = $this->input->post('jml_kursi');
            // $kapasitas_pengunjung = $this->input->post('kapasitas_pengunjung');
            // $jml_karyawan = $this->input->post('jml_karyawan');

            // $jumlah_standar = ($arr_jml_kamar[0] != '') ? $arr_jml_kamar[0] : '0';
            // $tarif_standar = ($arr_tarif_kamar[0] != '') ? $arr_tarif_kamar[0] : '0';
            // $jumlah_standar_ac = ($arr_jml_kamar[1] != '') ? $arr_jml_kamar[1] : '0';
            // $tarif_standar_ac = ($arr_tarif_kamar[1] != '') ? $arr_tarif_kamar[1] : '0';
            // $jumlah_double = ($arr_jml_kamar[2] != '') ? $arr_jml_kamar[2] : '0';
            // $tarif_double = ($arr_tarif_kamar[2] != '') ? $arr_tarif_kamar[2] : '0';
            // $jumlah_superior = ($arr_jml_kamar[3] != '') ? $arr_jml_kamar[3] : '0';
            // $tarif_superior = ($arr_tarif_kamar[3] != '') ? $arr_tarif_kamar[3] : '0';
            // $jumlah_delux = ($arr_jml_kamar[4] != '') ? $arr_jml_kamar[4] : '0';
            // $tarif_delux = ($arr_tarif_kamar[4] != '') ? $arr_tarif_kamar[4] : '0';
            // $jumlah_executive_suite = ($arr_jml_kamar[5] != '') ? $arr_jml_kamar[5] : '0';
            // $tarif_executive_suite = ($arr_tarif_kamar[5] != '') ? $arr_tarif_kamar[5] : '0';
            // $jumlah_club_room = ($arr_jml_kamar[6] != '') ? $arr_jml_kamar[6] : '0';
            // $tarif_club_room = ($arr_tarif_kamar[6] != '') ? $arr_tarif_kamar[6] : '0';
            // $jumlah_apartment = ($arr_jml_kamar[7] != '') ? $arr_jml_kamar[7] : '0';
            // $tarif_apartment = ($arr_tarif_kamar[7] != '') ? $arr_tarif_kamar[7] : '0';

            // if ($insert_pendaftaran > 0) {
            //     if ($jns_pajak == '1') {
            //         $wp_wr_hotel_id = $this->Mod_pendaftaranwp->get_hotel_detil_id();

            //         $arr_save = array(
            //             'wp_wr_hotel_id' => $wp_wr_hotel_id,
            //             'wp_wr_id' => $next_val,
            //             'wp_wr_detil_id' => $next_val,
            //             'golongan_hotel' => $gol_hotel,
            //             'jumlah_kamar' => $total_jml_kamar,
            //             'jumlah_standar' => $jumlah_standar,
            //             'tarif_standar' => $tarif_standar,
            //             'jumlah_standar_ac' => $jumlah_standar_ac,
            //             'tarif_standar_ac' => $tarif_standar_ac,
            //             'jumlah_double' => $jumlah_double,
            //             'tarif_double' => $tarif_double,
            //             'jumlah_superior' => $jumlah_superior,
            //             'tarif_superior' => $tarif_superior,
            //             'jumlah_delux' => $jumlah_delux,
            //             'tarif_delux' => $tarif_delux,
            //             'jumlah_executive_suite' => $jumlah_executive_suite,
            //             'tarif_executive_suite' => $tarif_executive_suite,
            //             'jumlah_club_room' => $jumlah_club_room,
            //             'tarif_club_room' => $tarif_club_room,
            //             'jumlah_apartment' => $jumlah_apartment,
            //             'tarif_apartment' => $tarif_apartment
            //         );

            //         $table = 'wp_wr_hotel';
            //     } else if ($jns_pajak == '2') {
            //         $wp_wr_hotel_id = $this->Mod_pendaftaranwp->get_restoran_detil_id();

            //         $arr_save = array(
            //             'wp_wr_restoran_id' => $wp_wr_hotel_id,
            //             'wp_wr_id' => $next_val,
            //             'wp_wr_detil_id' => $next_val,
            //             'jenis_restoran' => $jenis_restoran,
            //             'jumlah_meja' => $jml_meja,
            //             'jumlah_kursi' => $jml_kursi,
            //             'kapasitas_pengunjung' => $kapasitas_pengunjung,
            //             'jumlah_karyawan' => $jml_karyawan
            //         );
            //         $table = 'wp_wr_restoran';
            //     }
            //     $insert_detil = $this->Mod_pendaftaranwp->insert($table, $arr_save);

            //     // $npwprd = $this->Mod_pendaftaranwp->get_record_value('npwprd', 'v_wp_wr', "wp_wr_id='" . $next_val . "'");
            //     //insert history log ($module, $action, $description)
            //     // $this->Mod_pendaftaranwp->history_log("pendaftaran", "i", "Insert WP Badan Usaha id " . $next_val . " | $npwprd" . " | " . strtoupper($this->input->post('input-nama')));
            //     echo json_encode(array("status" => TRUE));
            // } else
            //     echo json_encode(array(
            //         "error" => True,
            //         "msg" => "Pendaftaran gagal disimpan!!"
            //     ));
        }
    }

    public function cetak_npwpd()
    {

        $wp_wr_id =  $this->uri->segment(3);

        $npwprd = $this->Mod_pendaftaranwp->get_npwpd($wp_wr_id);
        $nama   = $this->Mod_pendaftaranwp->get_namawp($npwprd);

        $data['wp_wr_id']   = $wp_wr_id;
        $data['npwprd']     = $npwprd;
        $data['nama']       = $nama;
        $this->load->view('admin/cetak_npwpd', $data);
    }
}
