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
		redirect(base_url().'home');
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
		
        if(empty($username) or empty($password)) {
            $this->session->set_flashdata('error_message','Username atau password harus diisi');
            redirect(base_url().'auth/index');
        }

        $sql = "select a.user_id, a.user_name, a.user_status, a.role, a.user_password,
				b.pelanggan_no, b.pelanggan_nama, b.email
				from tblm_user a
				left join tblm_pelanggan b on a.pelanggan_id = b.pelanggan_id
				where a.user_name = ?";

        $query = $this->db->query($sql, array($username));
        $row = $query->row_array();
		
        $md5pass = md5(trim($password));

        if(!isset($row['user_id'])) {
            $this->session->set_flashdata('error_message','Maaf, Username atau password Anda salah');
            redirect(base_url().'auth/index');
        }

        if($row['user_status'] != 1) {
            $this->session->set_flashdata('error_message','Maaf, User yang bersangkutan sudah tidak aktif. Silahkan hubungi administrator.');
            redirect(base_url().'auth/index');
        }
		
		if( strcmp($md5pass, trim($row['user_password'])) != 0 ) {
            $this->session->set_flashdata('error_message','Username atau password Anda salah');
            redirect(base_url().'auth/index');
        }       

        $userdata = array(
                        'user_id'           => $row['user_id'],
                        'user_name'         => $row['user_name'],
                        'user_email'        => $row['email'],
						'pelanggan_no'      => $row['pelanggan_no'],
						'pelanggan_nama'    => $row['pelanggan_nama'],
						'user_role'    		=> $row['role'],
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
						'pelanggan_no'      => '',
						'pelanggan_nama'    => '',
						'user_role'    		=> '',
                        'logged_in'         => false
                      );

        $this->session->unset_userdata($userdata);
        $this->session->sess_destroy();
        redirect(base_url().'auth/index');
    }

}
