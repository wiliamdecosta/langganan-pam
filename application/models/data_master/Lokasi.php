<?php

/**
 * Lokasi Model
 *
 */
class Lokasi extends Abstract_model {

    public $table           = "lokasi";
    public $pkey            = "lokasi_id";
    public $alias           = "lok";

    public $fields          = array(
                                'lokasi_id'                => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Lokasi'),
                                'lokasi_nama'              => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Nama Lokasi'),
                                'lokasi_keterangan'           => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Keterangan')
                            );

    public $selectClause    = "lok.*";
    public $fromClause      = "lokasi lok";

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
            $this->db->set($this->pkey,"NULL",false);


        }else {
            //do something
            //example:

        }
        return true;
    }

}

/* End of file Activity.php */