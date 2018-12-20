<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->model('mini_model', 'mini');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
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
           // $this->session->set_flashdata('error_message','Email atau password harus diisi');
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
                    where email = ?
                    limit 1";
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
        //if($group_login == 'admin') redirect(base_url().'aduan_pelanggan/index_admin');
        //else redirect(base_url().'home');
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

    public function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() === FALSE)
        {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            // render
            //$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'change_password', $this->data);
            $output['success'] = false;
            $output['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            echo json_encode($output);
        }
        else
        {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $output['success'] = true;
                $output['message'] = 'Change Password Success';
                echo json_encode($output);
            }
            else
            {

                $output['success'] = false;
                $output['message'] = $this->ion_auth->errors();
                echo json_encode($output);
                //redirect('auth/change_password', 'refresh');
            }
        }
    }

    /**
     * Forgot password
     */
    public function forgot_password()
    {
        // setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email')
        {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        }
        else
        {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }

        if ($this->form_validation->run() === FALSE)
        {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'class' => 'form-control',
                'placeholder' => 'Email',
                'type' => 'email',
                'required' => ''
            );

            if ($this->config->item('identity', 'ion_auth') != 'email')
            {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            }
            else
            {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
        }
        else
        {
            $identity_column = 'email';
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity))
            {


                $this->ion_auth->set_error('forgot_password_email_not_found');


                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten)
            {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }

    /**
     * Reset password - final step for forgotten password
     *
     * @param string|null $code The reset code
     */
    public function reset_password($code = NULL)
    {
        if (!$code)
        {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user)
        {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() === FALSE)
            {
                // display the form

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // render
                $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
            }
            else
            {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
                {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));

                }
                else
                {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change)
                    {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/login", 'refresh');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        }
        else
        {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    /**
     * Activate the user
     *
     * @param int         $id   The user ID
     * @param string|bool $code The activation code
     */
    public function activate($id, $code = FALSE)
    {
        if ($code !== FALSE)
        {
            $activation = $this->ion_auth->activate($id, $code);
        }
        else if ($this->ion_auth->is_admin())
        {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation)
        {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("users", 'refresh');
        }
        else
        {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    /**
     * Deactivate the user
     *
     * @param int|string|null $id The user ID
     */
    public function deactivate($id = NULL)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $id = (int)$id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() === FALSE)
        {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();

            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
        }
        else
        {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes')
            {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
                {
                    return show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
                {
                    $this->ion_auth->deactivate($id);
                }
            }

            // redirect them back to the auth page
            redirect('users', 'refresh');
        }
    }

    /**
     * Create a new user
     */
    public function create_user()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = 'username';
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
        if ($identity_column !== 'email')
        {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('referral','referral', 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() === TRUE)
        {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'phone' => $this->input->post('phone'),
                'referral' => $this->input->post('referral'),
            );
        }
        if ($this->form_validation->run() === TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("users", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'class' => 'form-control',
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'class' => 'form-control',
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'class' => 'form-control',
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'class' => 'form-control',
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'class' => 'form-control',
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'class' => 'form-control',
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['referral'] = array(
                'class' => 'form-control',
                'name' => 'referral',
                'id' => 'referral',
                'type' => 'text',
                'value' => $this->form_validation->set_value('referral'),
            );
            $this->data['password'] = array(
                'class' => 'form-control',
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'class' => 'form-control',
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->_render_page('template' . DIRECTORY_SEPARATOR . 'header');
            $this->_render_page('template' . DIRECTORY_SEPARATOR . 'navigation');
            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'create_user', $this->data);
            $this->_render_page('template' . DIRECTORY_SEPARATOR . 'footer');

        }
    }
    /**
     * Redirect a user checking if is admin
     */
    public function redirectUser(){
        if ($this->ion_auth->is_admin()){
            redirect('auth', 'refresh');
        }
        redirect('/', 'refresh');
    }

    /**
     * Edit a user
     *
     * @param int|string $id
     */
    public function edit_user($id)
    {
        $this->data['title'] = $this->lang->line('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('users', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim');
        // $this->form_validation->set_rules('referral','referral', 'trim');

        if (isset($_POST) && !empty($_POST))
        {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                show_error($this->lang->line('error_csrf'));
            }

            // update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE)
            {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                    //'referral' => $this->input->post('referral'),
                );

                // update the password if it was posted
                if ($this->input->post('password'))
                {
                    $data['password'] = $this->input->post('password');
                }

                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin())
                {
                    // Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData))
                    {

                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp)
                        {
                            $this->ion_auth->add_to_group($grp, $id);
                        }

                    }
                }

                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data))
                {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect('users', 'refresh');

                }
                else
                {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('users', 'refresh');

                }

            }
        }

        // display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['first_name'] = array(
            'class' => 'form-control',
            'name'  => 'first_name',
            'id'    => 'first_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'class' => 'form-control',
            'name'  => 'last_name',
            'id'    => 'last_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name'  => 'company',
            'id'    => 'company',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'class' => 'form-control',
            'name'  => 'phone',
            'id'    => 'phone',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'class' => 'form-control',
            'name' => 'password',
            'id'   => 'password',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'class' => 'form-control',
            'name' => 'password_confirm',
            'id'   => 'password_confirm',
            'type' => 'password'
        );
        $this->data['referral'] = array(
            'class' => 'form-control',
            'name' => 'referral',
            'id' => 'referral',
            'type' => 'text',
            'value' => $this->form_validation->set_value('referral', $user->referral)
        );
        $this->_render_page('template' . DIRECTORY_SEPARATOR . 'header');
        $this->_render_page('template' . DIRECTORY_SEPARATOR . 'navigation');
        $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_user', $this->data);
        $this->_render_page('template' . DIRECTORY_SEPARATOR . 'footer');

    }

    /**
     * Create a new group
     */
    public function create_group()
    {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

        if ($this->form_validation->run() === TRUE)
        {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id)
            {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        }
        else
        {
            // display the create group form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = array(
                'name'  => 'group_name',
                'id'    => 'group_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name'  => 'description',
                'id'    => 'description',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('description'),
            );

            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'create_group', $this->data);
        }
    }

    /**
     * Edit a group
     *
     * @param int|string $id
     */
    public function edit_group($id)
    {
        // bail if no group id given
        if (!$id || empty($id))
        {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST))
        {
            if ($this->form_validation->run() === TRUE)
            {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update)
                {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                }
                else
                {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['group'] = $group;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_name'] = array(
            'name'    => 'group_name',
            'id'      => 'group_name',
            'type'    => 'text',
            'value'   => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name'  => 'group_description',
            'id'    => 'group_description',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
    }

    /**
     * @return array A CSRF key-value pair
     */
    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    /**
     * @return bool Whether the posted CSRF token matches
     */
    public function _valid_csrf_nonce(){
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')){
            return TRUE;
        }
        return FALSE;
    }

    /**
     * @param string     $view
     * @param array|null $data
     * @param bool       $returnhtml
     *
     * @return mixed
     */
    public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        // This will return html on 3rd argument being true
        if ($returnhtml)
        {
            return $view_html;
        }
    }

    function ip_details3($ip) {
        // By IPSTACK
        $token = "291ad06a00dc56d8e9bb749344498d59";
        $json = file_get_contents("http://api.ipstack.com/$ip?access_key=$token");
        $details = json_decode($json, true);
        //print_r($details);
        return $details;
    }

    public function register(){
        $this->data['title'] = $this->lang->line('create_user_heading');


        $tables = $this->config->item('tables', 'ion_auth');

        // validate form input
        $this->form_validation->set_rules('nolang', 'Nomor Langganan', 'trim|required');
        $this->form_validation->set_rules('first_name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user_pelanggan.email]');

        $this->form_validation->set_rules('phone','Nomor HP', 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() === TRUE)
        {
           /* $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
                'secret' => '6LcytW0UAAAAAJGUCec1RvS4BaMr3c-yscj55_gH',
                'response' => $this->input->post('g-recaptcha-response')
            );
            $options = array(
                'http' => array (
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success=json_decode($verify);

            if ($captcha_success->success==false) {
                $this->session->set_flashdata('message', '<p class="text-danger"> reCAPTCHA not valid !</p>');
                redirect('auth/register', 'refresh');
            }*/


            $email = strtolower($this->input->post('email'));
            $password = $this->input->post('password');
            $nolang = trim($this->input->post('nolang'));

            $additional_data = array(
                'no_pelanggan' => $nolang,
                'nama' => $this->input->post('first_name'),
                'alamat' => $this->input->post('address'),
                'hp' => $this->input->post('phone'),
                'email' => $email,
                'password' => md5($password),
                'password_visible' => $password,
                'status_aktif' => 1,
            );
        }
        if ($this->form_validation->run())
        {
            // Check nolang
            $this->load->model('data_master/user_pelanggan');
            $checkNOlang = $this->user_pelanggan->cekNolang($nolang);
            $checkValidNolang = $this->user_pelanggan->checkValidNolang($nolang);
            if($checkNOlang){
                $this->session->set_flashdata('error_message','Nomor pelanggan sudah terdaftar, Silahkan hubungi admin');
                redirect('auth/register', 'refresh');
            }
            if(!$checkValidNolang){
                $this->session->set_flashdata('error_message','Nomor pelanggan tidak terdaftar / tidak aktif, Silahkan hubungi admin');
                redirect('auth/register', 'refresh');
            } else{

                $this->mini->add_data('user_pelanggan',$additional_data);

                $message = "Link Activation";
                $this->email->clear();
                $this->email->from($this->config->item('admin_email', 'ion_auth'), 'User Activation');
                $this->email->to($email);
                $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_activation_subject'));
                $this->email->message($message);

                if ($this->email->send() === TRUE)
                {
                    $this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
                    $this->set_message('activation_email_successful');
                }

                $this->session->set_flashdata('success_message','Pendaftaran berhasil, Silahkan cek email Anda untuk verifikasi');
                $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login');
            }

        }
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'register', $this->data);
        }
    }


    public function captcha($response){
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => '6LcytW0UAAAAAJGUCec1RvS4BaMr3c-yscj55_gH',
            'response' => $response
        );
        $options = array(
            'http' => array (
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success=json_decode($verify);

        if ($captcha_success->success==false) {
            //$this->set_message('update_successful');
            $this->ion_auth->set_error('reCAPTCHA not valid !');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function change_pp(){

        if ($_FILES['input_profile']['error'] == 4) {
            $output['success'] = false;
            $output['message'] = 'No file selected';
        }

        $dir = './assets/profile';
        $config['upload_path'] = $dir;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048;
        $config['remove_spaces'] = TRUE;
        $config['file_ext_tolower'] = TRUE;
        $config['file_name'] = time();

        // Check if directory not exist
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('input_profile')) {

            $output['success'] = false;
            $output['message'] = $this->upload->display_errors();
        } else {
            $data_upload = $this->upload->data();

            $data = array(
                'user_pic' => $data_upload['file_name']
            );
            $id = $this->session->userdata('user_id');
            $user = $this->ion_auth->user($id)->row();
            if($user->user_pic != "" or $user->user_pic){
                unlink('assets/profile'."/".$user->user_pic);
            }
            $this->mini->update_data('users', array('id' => $this->session->userdata('user_id')), $data);
            $this->session->set_userdata('user_pic',$data_upload['file_name']);


            $output['success'] = true;
            $output['message'] = 'Upload Success';
            $output['img'] = "<img src='".base_url('assets/profile')."/".$data_upload['file_name']."' class='img-circle' width='150' />";
        }

        echo json_encode($output);
    }

}
