<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Create By : Aryo
 * Youtube : Aryo Coding
 */
class Penerimaan extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_penerimaan'));
    }

    public function index()
    {
        $this->load->helper('url');
        $this->template->load('layoutbackend', 'penerimaan.php');
    }

    public function dashboard()
    {
        $this->load->helper('url');
        $pajret =  $this->uri->segment(3);

        if ($pajret == 1) {
            $add_form =  "penerimaan_hotel";
        } elseif ($pajret == 2) {
            $add_form =  "penerimaan_restoran";
        } elseif ($pajret == 4) {
            $add_form =  "penerimaan_hiburan";
        } elseif ($pajret == 6) {
            $add_form =  "penerimaan_minerba";
        } elseif ($pajret == 5) {
            $add_form =  "penerimaan_pln";
        } elseif ($pajret == 11) {
            $add_form =  "penerimaan_parkir";
        } elseif ($pajret == 7) {
            $add_form =  "penerimaan_abt";
        } else {
            $add_form =  "";
        }

        $this->template->load('layoutbackend', $add_form);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $jenis = $this->input->post('jenis');
        $list = $this->Mod_penerimaan->get_datatables($jenis);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pel) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pel->npwprd;
            $row[] = $pel->kode_billing;
            $row[] = $pel->tahun_pajak;
            $row[] = number_format($pel->pokok_pajak);
            $row[] = number_format($pel->denda);
            $row[] = number_format($pel->total_bayar);
            $row[] = $pel->tgl_bayar;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_penerimaan->count_all($jenis),
            "recordsFiltered" => $this->Mod_penerimaan->count_filtered($jenis),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        $this->_validate();
        $kode = date('ymsi');
        $save  = array(
            'kdbarang'      => $kode,
            'nama'            => $this->input->post('nama'),
            'harga'          => $this->input->post('harga'),
            'satuan'           => $this->input->post('satuan')
        );
        $this->Mod_penerimaan->insert_barang("barang", $save);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        // $this->_validate();
        $id      = $this->input->post('id');
        $save  = array(
            'status_bayar' => '1'
        );
        $this->Mod_penerimaan->update_bayar($id, $save);
        echo json_encode(array("status" => TRUE));
    }

    public function edit_bayar($id)
    {
        $data = $this->Mod_penerimaan->get_bayar($id);
        echo json_encode($data);
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->Mod_penerimaan->delete_brg($id, 'barang');
        echo json_encode(array("status" => TRUE));
    }
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama') == '') {
            $data['inputerror'][] = 'nama';
            $data['error_string'][] = 'Nama Barang Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('harga') == '') {
            $data['inputerror'][] = 'harga';
            $data['error_string'][] = 'Harga Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('satuan') == '') {
            $data['inputerror'][] = 'satuan';
            $data['error_string'][] = 'Satuan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
