<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Lokasi_controller
* @version 07/05/2015 12:18:00
*/
class Chat_laporan_aduan_controller {

    function reload_comments() {

        $laporan_no = getVarClean('laporan_no','str','');
        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');
        try {

            $data['success'] = true;
            $data['comments'] = self::getComments($laporan_no);

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function send_comment() {
        $laporan_no = getVarClean('laporan_no','str','');
        $message = getVarClean('message','str','');

        $ci = & get_instance();
        $ci->load->model('aduan/chat_laporan_aduan');
        $table = $ci->chat_laporan_aduan;

        $ci->load->model('aduan/laporan_pelanggan');
        $tLap = $ci->laporan_pelanggan;
        $userdata = $ci->session->userdata;



        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');
        try {
            $record = array();
            $record['laporan_no'] = $laporan_no;
            $record['message'] = substr($message, 0, 500);

            $table->sendMessage($record);
            if($userdata['group_login'] == 'admin') {
                $tLap->updateStatusReadUser('U',$laporan_no);
            }elseif($userdata['group_login'] == 'pelanggan') {
                $tLap->updateStatusReadAdmin('U', $laporan_no);
            }

            $data['success'] = true;
            $data['comments'] = self::getComments($laporan_no);

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        return $data;
    }

    function getComments($laporan_no = '') {

        $sidx = 'send_time';
        $sord = 'desc';

        $ci = & get_instance();
        $ci->load->model('aduan/chat_laporan_aduan');
        $table = $ci->chat_laporan_aduan;

        $table->setCriteria("chat.laporan_no = '".$laporan_no."'");

        $items = $table->getAll(0, -1, $sidx, $sord);
        $output = '';

        $userdata = $ci->session->userdata;
        if($userdata['group_login'] == 'pelanggan') {

            foreach($items as $item) {

                if($item['is_sender_admin'] == 'Y') {
                    $output .= '
                    <div class="d-flex no-block">
                        <div class="comment-text w-100">
                            <h5 class="font-medium">'.$item['sender'].'</h5>
                            <p class="m-b-10">'.$item['message'].'</p>
                            <div class="comment-footer">
                                <span class="text-muted pull-right">'.$item['get_send_time'].'</span>
                            </div>
                        </div>
                    </div>
                    <hr>';
                }else {

                    $output .= '
                    <div class="d-flex no-block">
                        <div class="comment-text w-100">
                            <h5 class="font-medium text-right">'.$item['sender'].'</h5>
                            <p class="m-b-10 text-right">'.$item['message'].'</p>
                            <div class="comment-footer text-right">
                                <span class="text-muted pull-right">'.$item['get_send_time'].'</span>
                            </div>
                        </div>
                    </div>
                    <hr>';
                }
            }

        }else {

            foreach($items as $item) {

                if($item['is_sender_user'] == 'Y') {
                    $output .= '
                        <div class="d-flex no-block">
                            <div class="comment-text w-100">
                                <h5 class="font-medium">'.$item['sender'].'</h5>
                                <p class="m-b-10">'.$item['message'].'</p>
                                <div class="comment-footer">
                                    <span class="text-muted pull-right">'.$item['get_send_time'].'</span>
                                </div>
                            </div>
                        </div>
                        <hr>';
                }else {

                    $output .= '
                        <div class="d-flex no-block">
                            <div class="comment-text w-100">
                                <h5 class="font-medium text-right">'.$item['sender'].'</h5>
                                <p class="m-b-10 text-right">'.$item['message'].'</p>
                                <div class="comment-footer text-right">
                                    <span class="text-muted pull-right">'.$item['get_send_time'].'</span>
                                </div>
                            </div>
                        </div>
                        <hr>';
                }
            }

        }


        return $output;
    }

}

/* End of file Icons_controller.php */