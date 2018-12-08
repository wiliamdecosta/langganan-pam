<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data_master extends CI_Controller
{

    function __construct() {
        parent::__construct();
    }

    function lokasi() {
        check_login();
        $this->load->view('data_master/lokasi');
    }

    function user_pelanggan() {
        check_login();
        $this->load->view('data_master/user_pelanggan');
    }

    function user_admin() {
        check_login();
        $this->load->view('data_master/user_admin');
    }


}