<?php

function jsonDecode($data) {

	if (empty($data)) return array();

    $items = json_decode($data, true);

    if ($items == NULL){
        throw new Exception('JSON items could not be decoded');
    }

    return $items;
}

function isValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
}

function html_spaces($number=1) {
    $result = "";
    for($i = 1; $i <= $number; $i++) {
        $result .= "&nbsp;";
    }
    return $result;
}

function getCurrentLocation() {
    $ci =& get_instance();
    $userdata = $ci->session->userdata;

    $sql = "SELECT lokasi_nama FROM lokasi
                where lokasi_id = ?";
    $query = $ci->db->query($sql, $userdata['lokasi_id']);
    $row = $query->row_array();

    return $row['lokasi_nama'];
}

function getStatusList() {
    return array(
        'Menunggu' => 'Menunggu',
        'Sedang Diproses' => 'Sedang Diproses',
        'Selesai' => 'Selesai',
        'Tidak Valid' => 'Tidak Valid'
    );
}

function getClassStatus($status) {
    $arrStatus = array(
        'Menunggu' => 'label label-warning',
        'Sedang Diproses' => 'label label-info',
        'Selesai' => 'label label-success',
        'Tidak Valid' => 'label label-danger'
    );

    return $arrStatus[$status];
}


function breadCrumbs($menu_id) {

    $ci =& get_instance();
    $sql = "WITH qs(menu_id, parent_id, menu_title) AS
            (
                SELECT menu_id, parent_id, menu_title
                FROM menus m
                WHERE parent_id is null
                UNION ALL
                SELECT child.menu_id, child.parent_id, (qs.menu_title ||'>'|| child.menu_title) as menu_title
                FROM menus child
                INNER JOIN qs
                ON qs.menu_id = child.parent_id
            )
            SELECT *
            FROM qs
            where qs.menu_id = ?";

    $query = $ci->db->query($sql, array($menu_id));
    $item = $query->row_array();

    $crumbsstr = $item['menu_title'];
    $crumbs = explode('>', $crumbsstr);

    $output = '
    <ul class="page-breadcrumb">
    <li>
        <a href="'.base_url().'">Home</a>
        <i class="fa fa-circle"></i>
    </li>';

    for($i = 0; $i < count($crumbs); $i++) {

        if($i == count($crumbs) - 1) {
            $output .= '<li>
                <span>'.$crumbs[$i].'</span>
            </li>';
        }else {
            $output .= '<li>
                <a href="javascript:;">'.$crumbs[$i].'</a>
                <i class="fa fa-circle"></i>
            </li>';
        }
    }

    $output .= '</ul>';

    return $output;
}

/**
 * compareDate
 *
 * Melakukan perbandingan dua tanggal
 *
 * @param string $from_date : batas tanggal awal dalam format yyyy-mm-dd
 * @param string $to_date   : batas tanggal akhir dalam format yyyy-mm-dd
 * @return 1 jika from_date < to_date, 2 jika from_date > to_date, 3 jika from_date = to_date
 */
function compareDate($from_date, $to_date) {
    $from_date = trim($from_date);
    $to_date = trim($to_date);

    if ($from_date == $to_date){
        return 3;
    }

    $waktu_awal = explode("-",$from_date);
    $waktu_akhir = explode("-",$to_date);
    if ($waktu_awal[0] > $waktu_akhir[0]){
        return 2;
    }else if ($waktu_awal[0] == $waktu_akhir[0]){
        if ($waktu_awal[1] > $waktu_akhir[1]){
            return 2;
        }else if ($waktu_awal[1] == $waktu_akhir[1]){
            if ($waktu_awal[2] > $waktu_akhir[2]){
                return 2;
            }
        }
    }
    return 1;
}

function numberFormat($number, $decimals =  2, $dec_point = '.' , $thousands_sep = ','){
    return number_format($number, $decimals, $dec_point, $thousands_sep);
}

function dateToString($date){
    if(empty($date)) return "";

    $monthname = array(0  => '-',
                        1  => 'Januari',
                        2  => 'Februari',
                        3  => 'Maret',
                        4  => 'April',
                        5  => 'Mei',
                        6  => 'Juni',
                        7  => 'Juli',
                        8  => 'Agustus',
                        9  => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember');

    $pieces = explode('-', $date);

    return $pieces[2].' '.$monthname[(int)$pieces[1]].' '.$pieces[0];
}

function getMonthName($num) {
    $monthname = array(0  => '-',
                        1  => 'Januari',
                        2  => 'Februari',
                        3  => 'Maret',
                        4  => 'April',
                        5  => 'Mei',
                        6  => 'Juni',
                        7  => 'Juli',
                        8  => 'Agustus',
                        9  => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember');

    return $monthname[$num];
}
?>