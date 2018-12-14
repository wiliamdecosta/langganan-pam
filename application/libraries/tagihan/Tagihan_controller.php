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

            //$no_pelanggan = $userdata['no_pelanggan'];
            $no_pelanggan = getVarClean('no_pelanggan','str','');
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



    function send_email_tagihan() {

        $ci = & get_instance();
        $ci->load->model('tagihan/tagihan');
        $table = $ci->tagihan;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');
        $userdata = $ci->session->userdata;

        $no_pelanggan = getVarClean('no_pelanggan','str','');
        $periode = getVarClean('periode','str','');

        $info_tagihan = $table->getInfoTagihan($no_pelanggan, $periode);

        try{
            $table->db->trans_begin(); //Begin Trans

                /*execute send email query here */
                if(count($info_tagihan) == 0) {
                    throw new Exception('Data tagihan tidak ditemukan');
                }else {
                    $ci->load->model('email_sender');
                    $email_sender = $ci->email_sender;

                    $message = '
                        <h2>Informasi Tagihan Anda </h2>
                        <table>
                            <tr>
                                <td>ID Pelanggan</td>
                                <td>:</td>
                                <td>'.$info_tagihan['nolang'].'</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>'.$info_tagihan['nama'].'</td>
                            </tr>
                            <tr>
                                <td>Bulan/Tahun</td>
                                <td>:</td>
                                <td>'.$info_tagihan['periode_tagihan'].'</td>
                            </tr>
                            <tr>
                                <td>Stand Meter</td>
                                <td>:</td>
                                <td>'.$info_tagihan['stand_awal'].' - '.$info_tagihan['stan_akhir'].'</td>
                            </tr>
                            <tr>
                                <td>Pemakaian</td>
                                <td>:</td>
                                <td>'.$info_tagihan['pemakaian'].'</td>
                            </tr>
                            <tr>
                                <td><b>Total Tagihan</b></td>
                                <td>:</td>
                                <td><b>Rp.'.numberFormat($info_tagihan['tagihan']).'</b></td>
                            </tr>
                        </table>
                    ';

                    $email_sender->email()->clear();
                    $email_sender->email()->set_newline("\r\n");
                    $email_sender->email()->from($email_sender->get_config('smtp_user'),'Humas PDAM Tirtawening');
                    $email_sender->email()->to( trim(strtolower($userdata['user_email'])) );
                    $email_sender->email()->subject('Info Tagihan '.$info_tagihan['periode_tagihan']);
                    $email_sender->email()->message( html_entity_decode($message) );

                    if(! $email_sender->email()->send() ) {
                        throw new Exception($email_sender->email()->print_debugger());
                    }
                }
                $data['message'] = 'Info Tagihan berhasil dikirim ke email Anda';
                $data['success'] = true;

            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
        }

        return $data;

    }

}

/* End of file Tagihan_controller.php */