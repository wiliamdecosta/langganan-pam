<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aduan_pelanggan extends CI_Controller
{

    function __construct() {
        parent::__construct();
    }

    function index() {
        check_login();
        if( $this->session->userdata('group_login') != 'pelanggan' ) {
            redirect(base_url().'home');
        }
        $this->load->view('aduan_pelanggan/index');
    }

    function index_admin() {
        check_login();
        if( $this->session->userdata('group_login') != 'admin' ) {
            redirect(base_url().'home');
        }
        $this->load->view('aduan_pelanggan/index_admin');
    }

    function tulis_aduan() {
        check_login();
        $this->load->view('aduan_pelanggan/tulis_aduan');
    }

    function laporan_aduan_per_tgl() {
        check_login();
        if( $this->session->userdata('group_login') != 'admin' ) {
            redirect(base_url().'home');
        }

        $this->load->view('aduan_pelanggan/laporan_aduan_per_tgl');
    }


    function kirim_aduan() {
        check_login();

        $lokasi_id = getVarClean('lokasi_id','str','');
        $alamat_aduan = getVarClean('alamat_aduan','str','');
        $subyek_aduan = getVarClean('subyek_aduan','str','');
        $isi_aduan = getVarClean('isi_aduan','str','');

        $this->load->model('aduan/seq_laporan_pelanggan');
        $tSeq = $this->seq_laporan_pelanggan;

        $no_laporan = $lokasi_id.$tSeq->getNoLaporan();

        $config = array(
            'upload_path'   => 'upload/aduan_evidences/',
            'allowed_types' => 'jpg|gif|png',
            'overwrite'     => 1,
            'max_size' => 1024
        );

        $this->load->library('upload', $config);

        $images = array();
        $filesCount = count($_FILES['uploadgambars']['name']);

        $no = 1;
        for($i = 0; $i < $filesCount; $i++){
            if(!isset($_FILES['uploadgambars']['name'][$i]) or empty($_FILES['uploadgambars']['name'][$i]))
                continue;

            $_FILES['uploadgambar']['name']     = $_FILES['uploadgambars']['name'][$i];
            $_FILES['uploadgambar']['type']     = $_FILES['uploadgambars']['type'][$i];
            $_FILES['uploadgambar']['tmp_name'] = $_FILES['uploadgambars']['tmp_name'][$i];
            $_FILES['uploadgambar']['error']     = $_FILES['uploadgambars']['error'][$i];
            $_FILES['uploadgambar']['size']     = $_FILES['uploadgambars']['size'][$i];

            $file_ext = pathinfo($_FILES['uploadgambar']['name'],PATHINFO_EXTENSION);
            $fileName = $no_laporan.'_'.$no.".".$file_ext;

            $images[] = $fileName;

            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            if($this->upload->do_upload('uploadgambar')){

            }else {
                $this->session->set_flashdata('error_message', $this->upload->display_errors());
                redirect(base_url().'aduan_pelanggan/tulis_aduan');
            }
            $no++;
        }

         try{

            $record = array();
            $record['lokasi_id'] = $lokasi_id;
            $record['user_id'] = $this->session->userdata('user_id');
            $record['laporan_no'] = $no_laporan;

            $record['subyek_aduan'] = $subyek_aduan;
            $record['alamat_aduan'] = $alamat_aduan;
            $record['isi_aduan'] = $isi_aduan;

            $record['status_laporan'] = 'Menunggu';
            for($i = 0; $i < count($images); $i++) {
                $record['upload_gambar'.($i+1)] = $images[$i];
            }

            $this->load->model('aduan/laporan_pelanggan');
            $table = $this->laporan_pelanggan;
            $table->actionType = 'CREATE';

            $table->db->trans_begin(); //Begin Trans

                $table->setRecord($record);
                $table->create();

            $table->db->trans_commit(); //Commit Trans
            redirect(base_url().'aduan_pelanggan/');

        }catch (Exception $e) {

        }
    }

    function detil($laporan_no) {
        check_login();
        if( $this->session->userdata('group_login') != 'pelanggan' ) {
            redirect(base_url().'aduan_pelanggan');
        }

        $this->load->model('aduan/laporan_pelanggan');
        $table = $this->laporan_pelanggan;

        $item = $table->getItemByNoLaporan($laporan_no);
        $item['lampiran'] = array();
        if(!empty($item['upload_gambar1'])) {
            $item['lampiran'][] = $item['upload_gambar1'];
        }
        if(!empty($item['upload_gambar2'])) {
            $item['lampiran'][] = $item['upload_gambar2'];
        }
        if(!empty($item['upload_gambar3'])) {
            $item['lampiran'][] = $item['upload_gambar3'];
        }

        $table->updateStatusReadUser('R',$laporan_no);
        $this->load->view('aduan_pelanggan/detil', $item);
    }

    function detil_admin($laporan_no) {
        check_login();
        if( $this->session->userdata('group_login') != 'admin' ) {
            redirect(base_url().'aduan_pelanggan/index_admin');
        }

        $this->load->model('aduan/laporan_pelanggan');
        $table = $this->laporan_pelanggan;

        $item = $table->getItemByNoLaporan($laporan_no);
        $item['lampiran'] = array();
        if(!empty($item['upload_gambar1'])) {
            $item['lampiran'][] = $item['upload_gambar1'];
        }
        if(!empty($item['upload_gambar2'])) {
            $item['lampiran'][] = $item['upload_gambar2'];
        }
        if(!empty($item['upload_gambar3'])) {
            $item['lampiran'][] = $item['upload_gambar3'];
        }

        $table->updateStatusReadAdmin('R',$laporan_no);
        $this->load->view('aduan_pelanggan/detil_admin', $item);
    }



    function update_aduan_admin() {
        check_login();

        $status_laporan = getVarClean('status_laporan','str','');
        $laporan_no = getVarClean('laporan_no','str','');
        $current_status = getVarClean('current_status','str','');

        $config = array(
            'upload_path'   => 'upload/file_pekerjaan/',
            'allowed_types' => 'jpg|gif|png|xls|xlsx|doc|docx',
            'overwrite'     => 1,
            'max_size' => 3072
        );

        $this->load->library('upload', $config);

        $fileName = '';

        if(isset($_FILES['file_pekerjaan']['name']) and !empty($_FILES['file_pekerjaan']['name'])) {
            $file_ext = pathinfo($_FILES['file_pekerjaan']['name'],PATHINFO_EXTENSION);
            $fileName = "lap_".$laporan_no.".".$file_ext;
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            if($this->upload->do_upload('file_pekerjaan')){

            }else {
                $this->session->set_flashdata('error_message', $this->upload->display_errors());
                redirect(base_url().'aduan_pelanggan/detil_admin/'.$laporan_no);
            }
        }

        try{


            $record = array(
                'status_laporan' => $status_laporan
            );
            if(!empty($fileName)) {
                $record['upload_file_pekerjaan'] = $fileName;
            }

            $this->load->model('aduan/laporan_pelanggan');
            $table = $this->laporan_pelanggan;
            $table->actionType = 'UPDATE';

            if($current_status != $status_laporan) {
                $table->db->set('status_read_user',"'U'",false);
            }

            $table->db->set('updated_date',"current_timestamp",false);
            $table->db->set('updated_by',"'".$this->session->userdata('user_email')."'",false);
            $table->db->where('laporan_no', $laporan_no);
            $table->db->update('laporan_pelanggan', $record);

            redirect(base_url().'aduan_pelanggan/detil_admin/'.$laporan_no);

        }catch (Exception $e) {

        }
    }


}