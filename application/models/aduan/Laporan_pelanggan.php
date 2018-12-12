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
                                'updated_by'              => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                                'status_read_user'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status Read'),
                                'status_read_admin'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status Read')
                            );

    public $selectClause    = "lap.*, lok.lokasi_nama, to_char(laporan_tgl, 'dd Monthyyyy HH24:MI:SS') as tgl_laporan, to_char(updated_date, 'dd Monthyyyy HH24:MI:SS') as tgl_update,
                                        usr.nama, usr.email, usr.hp";
    public $fromClause      = "laporan_pelanggan lap
                                        inner join lokasi lok on lap.lokasi_id = lok.lokasi_id
                                        inner join user_pelanggan usr on lap.user_id = usr.user_id";

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
            $this->db->set('laporan_tgl',"current_timestamp",false);

            $this->db->set('status_read_user',"U",false);
            $this->db->set('status_read_admin',"U",false);

            $this->db->set('creation_date',"current_timestamp",false);
            $this->record['created_by'] = $userdata['user_name'];
            //$this->db->set('updated_date',"current_timestamp",false);
            //$this->record['updated_by'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_seq_id($this->table, $this->pkey);

        }else {
            //do something
            //example:

            $this->db->set('updated_date',"current_timestamp",false);
            $this->record['updated_by'] = $userdata['user_name'];

        }
        return true;
    }


    public function bootgrid_countAll($param){

        $whereCondition = join(" AND ", $param['where']);
        if(!empty($whereCondition)) {
            $whereCondition = " WHERE ".$whereCondition;
        }

        if($param['search'] != null && $param['search'] === 'true'){
            $wh = "UPPER(".$param['search_field'].")";
            switch ($param['search_operator']) {
                case "bw": // begin with
                    $wh .= " LIKE UPPER('".$param['search_str']."%')";
                    break;
                case "ew": // end with
                    $wh .= " LIKE UPPER('%".$param['search_str']."')";
                    break;
                case "cn": // contain %param%
                    $wh .= " LIKE UPPER('%".$param['search_str']."%')";
                    break;
                case "eq": // equal =
                    if(is_numeric($param['search_str'])) {
                        $wh .= " = ".$param['search_str'];
                    } else {
                        $wh .= " = UPPER('".$param['search_str']."')";
                    }
                    break;
                case "ne": // not equal
                    if(is_numeric($param['search_str'])) {
                        $wh .= " <> ".$param['search_str'];
                    } else {
                        $wh .= " <> UPPER('".$param['search_str']."')";
                    }
                    break;
                case "lt":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " < ".$param['search_str'];
                    } else {
                        $wh .= " < '".$param['search_str']."'";
                    }
                    break;
                case "le":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " <= ".$param['search_str'];
                    } else {
                        $wh .= " <= '".$param['search_str']."'";
                    }
                    break;
                case "gt":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " > ".$param['search_str'];
                    } else {
                        $wh .= " > '".$param['search_str']."'";
                    }
                    break;
                case "ge":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " >= ".$param['search_str'];
                    } else {
                        $wh .= " >= '".$param['search_str']."'";
                    }
                    break;
                default :
                    $wh = "";
            }
        }

        if(!empty($wh)) {
            if($whereCondition != "" )
                $whereCondition .= " AND ".$wh;
            else
                $whereCondition = " WHERE ".$wh;
        }

        $sql = "select count(1) totalcount from (".$param['table']." ".$whereCondition.") as foo";
        $query = $this->db->query($sql);
        $row = $query->row_array();

        $query->free_result();
        return $row['totalcount'];
    }


    public function bootgrid_getData($param){

        $param['table'] = str_replace("SELECT","",$param['table']);
        $this->db->select($param['table']);

        $whereCondition = '';
        $whereCondition = join(" AND ", $param['where']);
        if($param['search'] != null && $param['search'] === 'true'){
            $wh = "UPPER(".$param['search_field'].")";
            switch ($param['search_operator']) {
                case "bw": // begin with
                    $wh .= " LIKE UPPER('".$param['search_str']."%')";
                    break;
                case "ew": // end with
                    $wh .= " LIKE UPPER('%".$param['search_str']."')";
                    break;
                case "cn": // contain %param%
                    $wh .= " LIKE UPPER('%".$param['search_str']."%')";
                    break;
                case "eq": // equal =
                    if(is_numeric($param['search_str'])) {
                        $wh .= " = ".$param['search_str'];
                    } else {
                        $wh .= " = UPPER('".$param['search_str']."')";
                    }
                    break;
                case "ne": // not equal
                    if(is_numeric($param['search_str'])) {
                        $wh .= " <> ".$param['search_str'];
                    } else {
                        $wh .= " <> UPPER('".$param['search_str']."')";
                    }
                    break;
                case "lt":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " < ".$param['search_str'];
                    } else {
                        $wh .= " < '".$param['search_str']."'";
                    }
                    break;
                case "le":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " <= ".$param['search_str'];
                    } else {
                        $wh .= " <= '".$param['search_str']."'";
                    }
                    break;
                case "gt":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " > ".$param['search_str'];
                    } else {
                        $wh .= " > '".$param['search_str']."'";
                    }
                    break;
                case "ge":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " >= ".$param['search_str'];
                    } else {
                        $wh .= " >= '".$param['search_str']."'";
                    }
                    break;
                default :
                    $wh = "";
            }
        }

        if(!empty($wh)) {
            if($whereCondition != "" )
                $whereCondition .= " AND ".$wh;
            else
                $whereCondition = $wh;
        }

        if($whereCondition != "")
            $this->db->where($whereCondition, null, false);

        if(!empty($param['sort_by']))
            $this->db->order_by($param['sort_by'], $param['sord']);

        if($param['limit'] != null)
            $this->db->limit($param['limit']['end'], $param['limit']['start']);

        $queryResult = $this->db->get();
        $items = $queryResult->result_array();

        return $items;
    }


    function getItemByNoLaporan($laporan_no) {
        $sql = "SELECT ".$this->selectClause." FROM ".$this->fromClause."
                    WHERE lap.laporan_no = ?";

        $query = $this->db->query($sql, $laporan_no);
        $row = $query->row_array();
        return $row;
    }

    function updateStatusReadUser($status_read, $laporan_no) {
        $sql = "UPDATE laporan_pelanggan
                    SET status_read_user = ?
                    WHERE laporan_no = ?";

        $query = $this->db->query($sql, array($status_read, $laporan_no));
        return true;
    }

    function updateStatusReadAdmin($status_read, $laporan_no) {
        $sql = "UPDATE laporan_pelanggan
                    SET status_read_admin = ?
                    WHERE laporan_no = ?";

        $query = $this->db->query($sql, array($status_read, $laporan_no));
        return true;
    }
}

/* End of file Laporan_pelanggan.php */