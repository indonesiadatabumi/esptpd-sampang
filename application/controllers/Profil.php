<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('fungsi');
        $this->load->library('user_agent');
        $this->load->helper('myfunction_helper');
        $this->load->model('Mod_profil');
        // backButtonHandle();
    }

    function index()
    {
        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect('login');
        } else {
            $this->template->load('layoutbackend', 'profil/home');
        }
    }

    function editprofil()
    {
        $this->template->load('layoutbackend', 'profil/editprofil');
    }

    function updateprofil()
    {
        // generate nama file
        $nama = date('Ymd') . rand(0, 999);
        $config['upload_path']   = './assets/foto/user/';
        $config['allowed_types'] = 'jpeg|jpg|png'; //mencegah upload backdor
        $config['max_size']      = '1000';
        $config['max_width']     = '2000';
        $config['max_height']    = '1024';
        $config['file_name']     = $nama;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $gambar = $this->upload->data();

            $image_lama = $this->input->post('image_lama');
            if ($image_lama != null) {
                unlink('./assets/foto/user/' . $image_lama);
            }

            $id_user = $this->input->post('id');
            $data = [
                'image' => $gambar['file_name']
            ];

            $this->Mod_profil->updateProfil($id_user, $data);
        }

        return redirect()->to('/profil');
    }

    function changepassword()
    {
        $this->template->load('layoutbackend', 'profil/changepassword');
    }

    function updatepassword()
    {
        $new_password = $this->input->post('new_password1');
        $id_user = $this->input->post('id');

        $data = [
            'password' => md5($new_password)
        ];

        $this->Mod_profil->updateProfil($id_user, $data);
        return redirect()->to('/profil');
    }
}
/* End of file Controllername.php */
