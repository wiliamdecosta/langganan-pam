<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aduan_pelanggan extends CI_Controller
{

    function __construct() {
        parent::__construct();
    }

    function index() {
        //check_login();
        $this->load->view('aduan_pelanggan/index');
    }

    function add() {
        //check_login();
        $this->load->view('aduan_pelanggan/add');
    }
	
	 function edit() {
        //check_login();
        $this->load->view('aduan_pelanggan/edit');
    }


}