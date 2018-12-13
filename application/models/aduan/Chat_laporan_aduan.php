<?php

/**
 * Chat_laporan_aduan Model
 *
 */
class Chat_laporan_aduan extends Abstract_model {

    public $table           = "chat_laporan_aduan";
    public $pkey            = "chat_id";
    public $alias           = "chat";

    public $fields          = array(

                            );

    public $selectClause    = "chat.*, to_char(send_time, 'dd Monthyyyy HH24:MI:SS') as get_send_time";
    public $fromClause      = "chat_laporan_aduan chat";

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

    function sendMessage($record) {
        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($userdata['group_login'] == 'admin') {
            $record['is_sender_admin'] = 'Y';
        }elseif($userdata['group_login'] == 'pelanggan') {
            $record['is_sender_user'] = 'Y';
        }

        $record['sender'] = $userdata['user_name'];
        $this->db->set('send_time',"current_timestamp",false);
        $this->db->insert($this->table, $record);
    }

}

/* End of file Activity.php */