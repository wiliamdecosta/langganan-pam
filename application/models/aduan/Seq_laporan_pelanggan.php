<?php

/**
 * Seq_laporan_pelanggan Model
 *
 */
class Seq_laporan_pelanggan extends Abstract_model {

    public $table           = "seq_laporan_pelanggan";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(

                            );

    public $selectClause    = "*";
    public $fromClause      = "seq_laporan_pelanggan";

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


    function getNoLaporan() {
        $sql = "SELECT * FROM ".$this->table." WHERE periode = '".date('Ym')."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();

        if(count($row) == 0 or $row == null) {
            $updateSeq = "UPDATE ".$this->table."
                              SET periode = '".date('Ym')."',
                                seq_number = 1";

            $this->db->query($updateSeq);
            return date('Ym').str_pad('1',5,'0',STR_PAD_LEFT);
        }else {
            $seq_num = $row['seq_number'];
            $updateSeq = "UPDATE ".$this->table."
                              SET seq_number = seq_number + 1";

            $this->db->query($updateSeq);
            return date('Ym').str_pad($seq_num,5,'0',STR_PAD_LEFT);

        }

    }

}

/* End of file Tagihan.php */