<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Tagihan_controller
* @version 07/05/2015 12:18:00
*/
class Tagihan_controller {

    function cek_info_tagihan() {

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');


        try {

            $ci = & get_instance();
            $ci->load->model('tagihan/tagihan');
            $table = $ci->tagihan;

            $userdata = $ci->session->userdata;

            $no_pelanggan = $userdata['no_pelanggan'];
            $periode = getVarClean('periode','str','');

            $info_tagihan = $table->getInfoTagihan($no_pelanggan, $periode);
            if(count($info_tagihan) == 0) {
                $data['rows'] = null;
            }else {
                $data['rows'] = $info_tagihan;
            }

            $data['rows'] = $info_tagihan;
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

}

/* End of file Tagihan_controller.php */