<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sendemail  extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        // Konfigurasi email
        // $config = [
        //     'mailtype'  => 'html',
        //     'charset'   => 'utf-8',
        //     'protocol'  => 'smtp',
        //     'smtp_host' => 'smtp.gmail.com',
        //     'smtp_user' => 'tantan.taufiq@gmail.com',  // Email gmail
        //     'smtp_pass'   => 'Dbi@2020',  // Password gmail
        //     'smtp_crypto' => 'ssl',
        //     'smtp_port'   => 465,
        //     'crlf'    => "\r\n",
        //     'newline' => "\r\n"
        // ];

        die('xxxxx');


        $config['protocol']  = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_user'] = 'tantan.taufiq@gmail.com';
        $config['smtp_pass'] = '';
        $config['smtp_port'] = 465;
        $config['charset']   = 'utf-8';
        $config['mailtype']  = 'html';
        $config['newline']   = "\r\n";


        var_dump($config);

        // Load library email dan konfigurasinya
        $this->load->library('email', $config);

        // Email dan nama pengirim
        $this->email->from('tantan.taufiq@gmail.com', 'no-reply@bapenda.bekasi.go.id');

        // Email penerima
        $this->email->to('databumiindonesia@gmail.com'); // Ganti dengan email tujuan

        // Lampiran email, isi dengan url/path file
        // $this->email->attach('https://images.pexels.com/photos/169573/pexels-photo-169573.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');

        // Subject email
        $this->email->subject('Aktivasi User Pelaporan e-SPTPD');

        // Isi email
        $this->email->message("silahkan klik link konfirmasi yang ada dibawah ini .<br><br> Klik <strong><a href='https://masrud.com/kirim-email-codeigniter/' target='_blank' rel='noopener'>disini</a></strong> untuk melakukan aktivasi.");

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            echo 'Sukses! email berhasil dikirim.';
        } else {
            echo 'Error! email tidak dapat dikirim.';
        }
    }
}
