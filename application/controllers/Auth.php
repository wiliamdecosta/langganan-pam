<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    function __construct() {
        parent::__construct();
    }

    public function index() {

        if($this->session->userdata('logged_in')) {
            //go to default page
            redirect(base_url().'home');
        }

        $data = array();
        $data['login_url'] = base_url()."auth/login";

        $this->load->view('auth/login', $data);
    }

    public function login() {

        $email = $this->security->xss_clean($this->input->post('email'));
        $password = $this->security->xss_clean($this->input->post('password'));


        /*$group_login = $this->security->xss_clean($this->input->post('group_login'));
        if($group_login != 'admin' and $group_login != 'pelanggan') {
            redirect(base_url().'auth/index');
        }*/


        if(empty($email) or empty($password)) {
            $this->session->set_flashdata('error_message','Email atau password harus diisi');
            redirect(base_url().'auth/index');
        }

        $group_login = '';
        $this->load->model('data_master/user_admin');
        $tAdmin = $this->user_admin;

        $this->load->model('data_master/user_pelanggan');
        $tPelanggan = $this->user_pelanggan;

        if($tAdmin->isEmailExist($email)) {
            $group_login = 'admin';
        }else if($tPelanggan->isEmailExist($email)) {
            $group_login = 'pelanggan';
        }

        if($group_login == 'pelanggan') {
            $sql = "select user_id, no_pelanggan, nama, alamat, hp, email, password, status_aktif
                    from user_pelanggan
                    where email = ?";
        }else {
            $sql = "select admin_id as user_id, lokasi_id, admin_nama as nama, admin_email as email, admin_password as password, status_aktif
                    from user_admin
                    where admin_email = ?";
        }

        $query = $this->db->query($sql, array($email));
        $row = $query->row_array();

        $md5pass = md5(trim($password));

        if(!isset($row['user_id'])) {
            $this->session->set_flashdata('error_message','Maaf, Email atau password Anda salah');
            redirect(base_url().'auth/index');
        }

        if($row['status_aktif'] != 1) {
            $this->session->set_flashdata('error_message','Maaf, User yang bersangkutan sudah tidak aktif. Silahkan hubungi administrator.');
            redirect(base_url().'auth/index');
        }

		if( strcmp($md5pass, trim($row['password'])) != 0 ) {
            $this->session->set_flashdata('error_message','Username atau password Anda salah');
            redirect(base_url().'auth/index');
        }


        $no_pelanggan = isset($row['no_pelanggan']) ? $row['no_pelanggan'] : '';
        $lokasi_id = isset($row['lokasi_id']) ? $row['lokasi_id'] : '';

        $userdata = array(
                        'user_id'           => $row['user_id'],
                        'user_name'         => $row['nama'],
                        'user_email'        => $row['email'],
						'no_pelanggan'      => $no_pelanggan,
                        'group_login'    		=> $group_login,
                        'lokasi_id'    		=> $lokasi_id,
                        'logged_in'         => true
                      );


        $this->session->set_userdata($userdata);
        redirect(base_url().'home');
    }

    public function logout() {

        $userdata = array(
                        'user_id'           => '',
                        'user_name'         => '',
                        'user_email'        => '',
						'no_pelanggan'      => '',
                        'group_login'    		=> '',
                        'lokasi_id'    		=> '',
                        'logged_in'         => true
                      );

        $this->session->unset_userdata($userdata);
        $this->session->sess_destroy();
        redirect(base_url().'auth/index');
    }

    public function profile() {
        check_login();
        $this->load->view('auth/profile');
    }

}
