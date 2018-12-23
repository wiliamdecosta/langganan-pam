<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Aduan_pelanggan_controller
* @version 07/05/2015 12:18:00
*/
class Aduan_pelanggan_controller {

    function pelanggan_aduan_list() {

        $ci =& get_instance();
        $userinfo = $ci->session->userdata;
        $ci->load->model('aduan/laporan_pelanggan');
        $table = $ci->laporan_pelanggan;

        $page = intval($ci->input->post('page')) ;
        $limit = $ci->input->post('limit');
        $sort = 'updated_date';
        $dir = 'desc';

        /* search parameter */
        $searchPhrase      = $ci->input->post('searchPhrase');

        $sql = "SELECT ".$table->selectClause." FROM ".$table->fromClause;

        $req_param = array (
            "table" => $sql,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
            "search" => ''
        );
        $req_param['where'] = array();

        $req_param['where'][] = "lap.user_id = ".$userinfo['user_id'];
        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(
                                                upper(subyek_aduan) LIKE upper('%".$searchPhrase."%') OR
                                                upper(laporan_no) LIKE upper('%".$searchPhrase."%')
                                            )";
        }

        $count = $table->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 1;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $start = $limit*$page - ($limit); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $items = $table->bootgrid_getData($req_param);
        $data = array();

        $data['total'] = $count;
        $data['contents'] = self::getAduanList($items);

        echo json_encode($data);
        exit;
    }


    function admin_aduan_list() {

        $ci =& get_instance();
        //$userinfo = $ci->session->userdata;
        $ci->load->model('aduan/laporan_pelanggan');
        $table = $ci->laporan_pelanggan;

        $page = intval($ci->input->post('page')) ;
        $limit = $ci->input->post('limit');
        $lokasi_id = $ci->input->post('lokasi_id');
        $sort = 'updated_date';
        $dir = 'desc';

        /* search parameter */
        $searchPhrase      = $ci->input->post('searchPhrase');

        $sql = "SELECT ".$table->selectClause." FROM ".$table->fromClause;

        $req_param = array (
            "table" => $sql,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
            "search" => ''
        );
        $req_param['where'] = array();

        if($lokasi_id != 999)
            $req_param['where'][] = "lap.lokasi_id = ".$lokasi_id;

        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(subyek_aduan) LIKE upper('%".$searchPhrase."%'))";
        }

        $count = $table->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 1;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $start = $limit*$page - ($limit); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $items = $table->bootgrid_getData($req_param);
        $data = array();

        $data['total'] = $count;
        $data['contents'] = self::getAduanListAdmin($items);

        echo json_encode($data);
        exit;
    }

    function getAduanList($items) {

        $result = '';
        foreach($items as $item) {
            $status_read = 'unread';
            if($item['status_read_user'] == 'R') {
                $status_read = 'read';
            }else {
                $status_read = 'unread';
            }

            $link_action = '<a href="#" title="Delete Aduan" onclick="deleteAduan(\''.$item['laporan_id'].'\',\''.$item['laporan_no'].'\')"><i class="fas fa-times-circle red bigger-120"></i></a>';
            if($item['status_laporan'] != 'Menunggu') {
                $link_action = '';
            }

            $result .= '<tr class="'.$status_read.'">';
            $result .= '<td><a class="btn btn-xs btn-primary" href="'.site_url('aduan_pelanggan/detil/'.$item['laporan_no']).'">'.$item['laporan_no'].'</a></td>';
            $result .= '<td class="hidden-xs-down">'.$item['lokasi_nama'].'</td>';
            $result .= '<td class="max-texts">'.$item['subyek_aduan'].'</td>';
            $result .= '<td class="text-center"> <span class="'.getClassStatus($item['status_laporan']).'">'.$item['status_laporan'].'</span> </td>';
            $result .= '<td class="text-center">'.$item['tgl_laporan'].'</td>';
            $result .= '<td class="text-center" style="width:40px">'.$link_action.'</td>';

            $result .= '</tr>';
        }

        return $result;
    }


    function getAduanListAdmin($items) {

        $result = '';
        foreach($items as $item) {
            $status_read = 'unread';
            if($item['status_read_admin'] == 'R') {
                $status_read = 'read';
            }else {
                $status_read = 'unread';
            }

            $link_action = '<a href="#" title="Delete Aduan" onclick="deleteAduan(\''.$item['laporan_id'].'\',\''.$item['laporan_no'].'\')"><i class="fas fa-times-circle red bigger-120"></i></a>';
            if($item['status_laporan'] != 'Menunggu') {
                $link_action = '';
            }

            $result .= '<tr class="'.$status_read.'">';
            $result .= '<td><a class="btn btn-xs btn-primary" href="'.site_url('aduan_pelanggan/detil_admin/'.$item['laporan_no']).'">'.$item['laporan_no'].'</a></td>';
            $result .= '<td class="hidden-xs-down">'.$item['nama'].' / '.$item['email'].'<br> (HP : '.$item['hp'].') | '.$item['no_pelanggan'].'</td>';
            $result .= '<td class="text-center">'.$item['tgl_laporan'].'</td>';
            $result .= '<td class="hidden-xs-down">'.$item['lokasi_nama'].'</td>';
            $result .= '<td class="max-texts">'.$item['subyek_aduan'].'</td>';
            $result .= '<td class="text-center"> <span class="'.getClassStatus($item['status_laporan']).'">'.$item['status_laporan'].'</span> </td>';
            $result .= '<td class="text-center">'.$item['tgl_update'].'</td>';
            $result .= '<td class="text-center">'.$link_action.'</td>';
            $result .= '</tr>';
        }

        return $result;
    }


    function download_excel_per_lokasi() {


            $ci = & get_instance();
            $lokasi_id = $ci->session->userdata('lokasi_id');

            $ci->load->model('aduan/laporan_pelanggan');
            $table = $ci->laporan_pelanggan;

            $ci->load->model('data_master/lokasi');
            $tLokasi = $ci->lokasi;
            $itemLokasi = $tLokasi->get($lokasi_id);

            if($lokasi_id != 999)
            $table->setCriteria('lap.lokasi_id = '.$lokasi_id);
            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            $lokasi = $itemLokasi['lokasi_nama'];
            if($lokasi_id == 999) {
                $lokasi = 'Semua Lokasi';
            }

            startExcel("lap_".strtolower(str_replace(' ','_',$lokasi)).".xls");

            $output = '<h2>Laporan Aduan Lokasi : '.$lokasi.'</h2>';
            $output .='<table  border="1">';
            $output.='<tr>';
            $output.='    <th>No</th>
                             <th>No Laporan</th>
                             <th>Tgl Laporan</th>
                             <th>Pelapor</th>
                             <th>No Pelanggan</th>
                             <th>Subyek Aduan</th>
                             <th>Alamat Aduan</th>
                             <th>Lokasi Aduan</th>
                             <th>Status</th>
                             <th>Isi Aduan</th>
                             <th>Updated Date</th>
                        ';
            $output.='</tr>';
            if($count < 1)  {
                $output .= '</table>';
                echo $output;
                exit;
            }

            $no = 1;
            foreach($items as $item) {

                $output .= '<tr valign="top">';
                    $output .= '<td>'.$no++.'</td>';
                    $output .= '<td>&nbsp;'.$item['laporan_no'].'</td>';
                    $output .= '<td>&nbsp;'.$item['tgl_laporan'].'</td>';
                    $output .= '<td>'.$item['nama'].' / '.$item['email'].' ('.$item['hp'].')</td>';
                    $output .= '<td>&nbsp;'.$item['no_pelanggan'].'</td>';
                    $output .= '<td>'.$item['subyek_aduan'].'</td>';
                    $output .= '<td>'.$item['alamat_aduan'].'</td>';
                    $output .= '<td>'.$item['lokasi_nama'].'</td>';
                    $output .= '<td>'.$item['status_laporan'].'</td>';
                    $output .= '<td>'.$item['isi_aduan'].'</td>';
                    $output .= '<td>&nbsp;'.$item['tgl_update'].'</td>';
                $output .= '</tr>';
            }

            $output .= '</table>';
            echo $output;
            exit;

    }

    function delete_aduan() {

            $ci = & get_instance();

            $ci->load->model('aduan/laporan_pelanggan');
            $table = $ci->laporan_pelanggan;

            $laporan_id = getVarClean('laporan_id', 'int', 0);
            $row = $table->get($laporan_id);

            if(isset($row['laporan_id'])) {
                if($row['status_laporan'] == 'Menunggu') {
                    $table->remove($laporan_id);
                    $ci->session->set_flashdata('success_message', 'Data berhasil dihapus');
                    redirect(base_url().'aduan_pelanggan/index');
                }
            }else {
                $ci->session->set_flashdata('error_message', 'Invalid Laporan ID');
                redirect(base_url().'aduan_pelanggan/index');
            }
    }

    function delete_aduan_admin() {

            $ci = & get_instance();

            $ci->load->model('aduan/laporan_pelanggan');
            $table = $ci->laporan_pelanggan;

            $laporan_id = getVarClean('laporan_id', 'int', 0);
            $row = $table->get($laporan_id);

            if(isset($row['laporan_id'])) {
                if($row['status_laporan'] == 'Menunggu') {
                    $table->remove($laporan_id);
                    $ci->session->set_flashdata('success_message', 'Data berhasil dihapus');
                    redirect(base_url().'aduan_pelanggan/index_admin');
                }
            }else {
                $ci->session->set_flashdata('error_message', 'Invalid Laporan ID');
                redirect(base_url().'aduan_pelanggan/index_admin');
            }
    }


    function download_laporan_aduan_admin() {

            $ci = & get_instance();
            $lokasi_id = getVarClean('lokasi_id', 'str', '');
            $tanggal_laporan = getVarClean('tanggal_laporan', 'str', 0);

            $ci->load->model('aduan/laporan_pelanggan');
            $table = $ci->laporan_pelanggan;

            $arrtgl = explode(' - ', $tanggal_laporan);
            $itemLokasi = array();

            if($lokasi_id != 'all') {
                $table->setCriteria('lap.lokasi_id = '.$lokasi_id);
                $ci->load->model('data_master/lokasi');
                $tLokasi = $ci->lokasi;
                $itemLokasi = $tLokasi->get($lokasi_id);
            }else {
                $itemLokasi['lokasi_nama'] = 'All';
            }

            $table->setCriteria("(lap.laporan_tgl::date between to_date('".$arrtgl[0]."','YYYY/MM/DD') and to_date('".$arrtgl[1]."','YYYY/MM/DD') )");


            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            startExcel("lap_per_tgl_".strtolower(str_replace(' ','_',$itemLokasi['lokasi_nama'])).".xls");

            $output = '<h2>Laporan Aduan Lokasi '.$itemLokasi['lokasi_nama'].'</h2>';
            $output .= 'Tanggal : '.$tanggal_laporan;
            $output .='<table  border="1">';
            $output.='<tr>';
            $output.='    <th>No</th>
                             <th>No Laporan</th>
                             <th>Tgl Laporan</th>
                             <th>Pelapor</th>
                             <th>Subyek Aduan</th>
                             <th>Alamat Aduan</th>
                             <th>Lokasi</th>
                             <th>Status</th>
                             <th>Isi Aduan</th>
                             <th>Updated Date</th>
                        ';
            $output.='</tr>';
            if($count < 1)  {
                $output .= '</table>';
                echo $output;
                exit;
            }

            $no = 1;
            foreach($items as $item) {

                $output .= '<tr valign="top">';
                    $output .= '<td>'.$no++.'</td>';
                    $output .= '<td>&nbsp;'.$item['laporan_no'].'</td>';
                    $output .= '<td>&nbsp;'.$item['tgl_laporan'].'</td>';
                    $output .= '<td>'.$item['nama'].' / '.$item['email'].' ('.$item['hp'].')</td>';
                    $output .= '<td>'.$item['subyek_aduan'].'</td>';
                    $output .= '<td>'.$item['alamat_aduan'].'</td>';
                    $output .= '<td>'.$item['lokasi_nama'].'</td>';
                    $output .= '<td>'.$item['status_laporan'].'</td>';
                    $output .= '<td>'.$item['isi_aduan'].'</td>';
                    $output .= '<td>&nbsp;'.$item['tgl_update'].'</td>';
                $output .= '</tr>';
            }

            $output .= '</table>';
            echo $output;
            exit;

    }
}

/* End of file Aduan_pelanggan_controller.php */