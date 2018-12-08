<?php

/**
 * User_pelanggan Model
 *
 */
class User_pelanggan extends Abstract_model {

    public $table           = "user_pelanggan";
    public $pkey            = "user_id";
    public $alias           = "usr";

    public $fields          = array(
                                'user_id'           => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID User'),
                                'no_pelanggan'           => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'No Pelanggan'),

                                'nama'         => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Nama'),
                                'alamat'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Alamat'),
                                'email'        => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Email'),
                                'password'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Password'),
                                'password_visible'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Password Visible'),
                                'status_aktif'       => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Status Aktif')
                            );

    public $selectClause    = "usr.user_id, usr.no_pelanggan, usr.nama, usr.alamat, usr.email, usr.password,
                                    usr.password_visible,
                                        (CASE
                                            WHEN usr.status_aktif = '1' THEN 'Aktif'
                                            WHEN usr.status_aktif = '2' THEN 'Tidak Aktif'
                                        END) as status_aktif_display";
    public $fromClause      = "user_pelanggan usr";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {
        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            //$this->record['created_date'] = date('Y-m-d');
            //$this->record['updated_date'] = date('Y-m-d');

            $this->db->set($this->pkey,"NULL",false);

            if (isset($this->record['password'])){
                if (trim($this->record['password']) == '') throw new Exception('Password Field is Empty');
                if (strlen($this->record['password']) < 6) throw new Exception('Mininum password length is 6 characters');
                $this->record['password'] = md5($this->record['password']);
                $this->record['password_visible'] = $this->record['password'];
            }

        }else {
            //do something
            //example:
            //$this->record['updated_date'] = date('Y-m-d');
            //if false please throw new Exception
            if(empty($this->record['password'])) {
                unset($this->record['password']);
            }else {
                if (strlen($this->record['password']) < 6) throw new Exception('Mininum password length is 6 characters');
                $this->record['password'] = md5($this->record['password']);
                $this->record['password_visible'] = $this->record['password'];
            }

        }
        return true;
    }

}

/* End of file Users.php */