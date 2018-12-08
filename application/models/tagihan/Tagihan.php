<?php

/**
 * Tagihan Model
 *
 */
class Tagihan extends Abstract_model {

    public $table           = "tagihan";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "*";
    public $fromClause      = "tagihan";

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

        }else {
            //do something
            //example:

        }
        return true;
    }


    function getInfoTagihan($no_pelanggan, $periode) {

        $ex_periode = explode('-', $periode);
        $bulan = $ex_periode[0];
        $tahun = $ex_periode[1];

        $sql = "SELECT * FROM tagihan WHERE
                    bulan = ? and
                    tahun = ? and
                    nolang = ?";

        $query = $this->db->query($sql, array($bulan, $tahun, $no_pelanggan));
        $info_tagihan = $query->row_array();

        return $info_tagihan;

    }

}

/* End of file Tagihan.php */