<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sendmail extends CI_Controller
{

    public function index()
    {

        // untuk kirim data via model 
        // $this->sendmail_m->message();

        //untuk menangkap data yang dikirim dari form contact
        // $fname = $this->input->post('form_name');
        // $femail = $this->input->post('form_email');
        // $fsubject = $this->input->post('form_subject');
        // $fmessage = $this->input->post('form_message');

        //set to_email id ke mana Anda ingin menerima email 
        $to_email1 = 'tantan.taufiq@gmail.com'; //contoh zai@gmail.com
        $recipientArr = array($to_email1);


        //Konfigurasi email 
        $config = array(
            'useragent' => 'CodeIgniter',
            'protocol'  => 'smtp',
            // 'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'tantan.taufiq@gmail.com',
            'smtp_pass' => 'Dbi@2020',
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n"
        );


        //load library email dan konfigurasinya
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        //Kirim email
        //email dan nama pengirim 

        $this->email->from('tantan.taufiq@gmail.com', 'no-reply@bapenda.bekasi.go.id');

        //email penerima 

        $this->email->to($recipientArr);

        // Subject email
        $this->email->subject('Aktivasi User Pelaporan e-SPTPD');

        // Isi email
        $this->email->message("silahkan klik link konfirmasi yang ada dibawah ini .<br><br> Klik <strong><a href='https://masrud.com/kirim-email-codeigniter/' target='_blank' rel='noopener'>disini</a></strong> untuk melakukan aktivasi.");


        $result = $this->email->send();
        if ($this->email->send()) {

            // berhasil
            echo 'berhasil';
        } else {
            // gagal
            echo 'gagal';
        }
    }
}
