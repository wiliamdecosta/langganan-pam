<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Info_rekening extends CI_Controller
{

    function __construct() {
        parent::__construct();
    }

    function index() {
        check_login();
        $this->load->view('info_rekening/cek_tagihan');
    }

    function cek_tagihan() {
        check_login();
        $this->load->view('info_rekening/cek_tagihan');
    }


}