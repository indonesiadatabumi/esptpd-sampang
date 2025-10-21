<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Loginadmin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_loginadmin'));
    }

    public function index()
    {
        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in == TRUE) {
            redirect('dashboard');
        } else {
            $aplikasi['aplikasi'] = $this->Mod_loginadmin->Aplikasi()->row();
            $this->load->view('admin/login_admin', $aplikasi);
        }
    } //end function index

    function login()
    {
        var_dump($this->input->post());
        // $this->_validate();
        //cek username database
        // $user = $this->input->post('username');
        // $username = anti_injection($this->input->post('username'));
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->load->driver('cache');
        $this->cache->clean();
        ob_clean();
        redirect('loginadmin');
    }

    private function _validate()
    {

        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('username') == '') {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Username is required';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Loginadmin.php */
