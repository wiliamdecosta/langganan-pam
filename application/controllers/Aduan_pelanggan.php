<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aduan_pelanggan extends CI_Controller
{

    function __construct() {
        parent::__construct();
    }

    function index() {
        check_login();
        $this->load->view('aduan_pelanggan/index');
    }

    function tulis_aduan() {
        check_login();
        $this->load->view('aduan_pelanggan/tulis_aduan');
    }

	 function edit() {
        check_login();
        $this->load->view('aduan_pelanggan/edit');
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
        );

        $this->load->library('upload', $config);

        $images = array();
        $filesCount = count($_FILES['uploadgambars']['name']);
        $no = 1;
        for($i = 0; $i < $filesCount; $i++){
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


}