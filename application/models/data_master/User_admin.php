<?php

/**
 * User_admin Model
 *
 */
class User_admin extends Abstract_model {

    public $table           = "user_admin";
    public $pkey            = "admin_id";
    public $alias           = "adm";

    public $fields          = array(
                                'admin_id'           => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID User'),
                                'lokasi_id'           => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'ID Lokasi'),

                                'admin_nama'         => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Nama'),
                                'admin_email'        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Email'),
                                'admin_password'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Password'),
                                'status_aktif'       => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Status Aktif')
                            );

    public $selectClause    = "adm.admin_id, adm.lokasi_id, adm.admin_nama, adm.admin_email, adm.admin_password, adm.status_aktif,
                                        lok.lokasi_nama, lok.lokasi_keterangan,
                                        (CASE
                                            WHEN adm.status_aktif = '1' THEN 'Aktif'
                                            WHEN adm.status_aktif = '2' THEN 'Tidak Aktif'
                                        END) as status_aktif_display";
    public $fromClause      = "user_admin adm
                                        left join lokasi lok on adm.lokasi_id = lok.lokasi_id";

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


            if (isset($this->record['admin_password'])){
                if (trim($this->record['admin_password']) == '') throw new Exception('Password Field is Empty');
                if (strlen($this->record['admin_password']) < 6) throw new Exception('Mininum password length is 6 characters');
                $this->record['admin_password'] = md5($this->record['admin_password']);
            }

            $this->record[$this->pkey] = $this->generate_seq_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            //$this->record['updated_date'] = date('Y-m-d');
            //if false please throw new Exception
            if(empty($this->record['admin_password'])) {
                unset($this->record['admin_password']);
            }else {
                if (strlen($this->record['admin_password']) < 6) throw new Exception('Mininum password length is 6 characters');
                $this->record['admin_password'] = md5($this->record['admin_password']);
            }


        }
        return true;
    }

}

/* End of file Users.php */