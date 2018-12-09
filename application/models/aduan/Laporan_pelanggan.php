<?php

/**
 * Laporan_pelanggan Model
 *
 */
class Laporan_pelanggan extends Abstract_model {

    public $table           = "laporan_pelanggan";
    public $pkey            = "laporan_id";
    public $alias           = "lap";

    public $fields          = array(
                                'laporan_id'      => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID Laporan'),

                                'user_id'          => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'User ID'),
                                'lokasi_id'        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Lokasi ID'),

                                'laporan_no'               => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'No Laporan'),
                                'laporan_tgl'            => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Tgl Laporan'),

                                'subyek_aduan'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Subyek Aduan'),
                                'alamat_aduan'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Alamat Aduan'),
                                'isi_aduan'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Isi Aduan'),

                                'upload_gambar1'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Upload Gambar 1'),
                                'upload_gambar2'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Upload Gambar 2'),
                                'upload_gambar3'         => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Upload Gambar 3'),

                                'status_laporan'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status Laporan'),
                                'upload_file_pekerjaan'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'File Pekerjaan'),

                                'reply_admin_message'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Reply Message'),

                                'creation_date'            => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'created_by'               => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'            => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'              => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
                            );

    public $selectClause    = "lap.*";
    public $fromClause      = "laporan_pelanggan lap";

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
            $this->db->set('laporan_tgl',"now()",false);

            $this->db->set('creation_date',"now()",false);
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('updated_date',"now()",false);
            $this->record['updated_by'] = $userdata['user_name'];


        }else {
            //do something
            //example:

            $this->db->set('updated_date',"now()",false);
            $this->record['updated_by'] = $userdata['user_name'];

        }
        return true;
    }

}

/* End of file Activity.php */