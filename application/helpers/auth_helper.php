<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('cek_login')) {
    function cek_login()
    {
        $ci = get_instance();
        if (!$ci->session->userdata('email')) {
            $ci->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Anda harus login terlebih dahulu!</div>');
            redirect('autentifikasi');
        }
    }
}