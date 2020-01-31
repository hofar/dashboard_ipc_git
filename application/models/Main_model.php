<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class main_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->model('login_model');
        $this->load->model('rkap_model');
        $this->load->model('notifikasi_model');
        $this->load->model('realisasi_model');
        $this->load->model('ganttchart_model');

    }

    public function get_notification() {
        $cek_user = $this->session->userdata('SESS_USER_BRANCH');
        $branch_selected = $this->rkap_model->all_percabang($cek_user);
        $branch_pusat = $this->rkap_model->all();
        $user_priv = $this->session->userdata('SESS_USER_PRIV');
        $isi = array();
        $no = 0;
        // print_r($user_priv); exit();
        // $id_rkap_selected = $branch_selected[0]->RKAP_INVS_ID;
        if ($user_priv != 1) {
            foreach ($branch_selected as $val) {
                    $id = $val->RKAP_INVS_ID;
                    $judul = $val->RKAP_INVS_TITLE;
                    $start_date = $this->notifikasi_model->get_date_contract($id)[0]->RKAP_SUBPRO_CONTRACT_DATE;
                    $start_date_format = date('M-y', strtotime($start_date));
                    //print_r($start_date);
                    $end_date = $this->notifikasi_model->get_date_guarantee($id)[0]->RKAP_SUBPRO_ENDOF_GUARANTEE;
                    $end_date_format = date('M-y', strtotime($end_date));
                     //print_r($end_date);
                    $date_now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                    $date_now_format = strtoupper($date_now->format('M-y'));
                    // print_r($date_now_format);

                    $d1 = strtotime($start_date);
                    $d2 = strtotime($end_date);
                    $min_date = min($d1, $d2);
                    $max_date = max($d1, $d2);
                    $i = 0;

                    while (($d1 = strtotime("+1 MONTH", $d1)) <= $d2) {
                        $i++;
                    }
                    //echo $i;
                    
                    $between_date = array();

                    for($a=0;$a<=$i;$a++){
                        $between_date[] = strtoupper(date('M-y', strtotime("+$a months", strtotime($end_date_format))));
                    }
                    //print_r($between_date);
                    // $last_update = $this->notifikasi_model->get_last($id, $date_now_format);
                    $last_update = $this->notifikasi_model->get_last($id);
                    $updated_date = array();
                    foreach ($last_update as $value) {
                        $updated_date[] =  strtoupper(date('M-y', strtotime($value['LAST_UPDATE'])));
                    }
                    $cek="tanggal tidak termasuk $id";
                    $cek_include = 0;
                    foreach ($between_date as $value) {
                        //echo $value;
                                //echo $value;
                        if($value==$date_now_format){
                            $cek_include++;
                            $cek="notif";
                        }
                    }
                    if($cek_include > 0 ){
                        foreach ($between_date as $value) {
                            if($value==$date_now_format){
                                foreach ($updated_date as $value2) {
                                    if($value2==$date_now_format){
                                        $cek="tidak notif";
                                    }
                                }
                            }
                        }
                    }

                    if($cek=="notif"){

                        $isi[$no]['url'] = base_url()."rkapinvestasi/update/$id";
                       $isi[$no]['judul'] = "Data posisi RKAP Investasi <b><i>".$judul."</i></b> belum di ubah";
                       
                       $no++;
                    }
                 
            };
        } else {
            foreach ($branch_pusat as $val) {
                    $id = $val->RKAP_INVS_ID;
                    $judul = $val->RKAP_INVS_TITLE;
                    $start_date = $this->notifikasi_model->get_date_contract($id)[0]->RKAP_SUBPRO_CONTRACT_DATE;
                    $start_date_format = date('M-y', strtotime($start_date));
                    //print_r($start_date);
                    $end_date = $this->notifikasi_model->get_date_guarantee($id)[0]->RKAP_SUBPRO_ENDOF_GUARANTEE;
                    $end_date_format = date('M-y', strtotime($end_date));
                     //print_r($end_date);
                    $date_now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                    $date_now_format = strtoupper($date_now->format('M-y'));
                    // print_r($date_now_format);

                    $d1 = strtotime($start_date);
                    $d2 = strtotime($end_date);
                    $min_date = min($d1, $d2);
                    $max_date = max($d1, $d2);
                    $i = 0;

                    while (($d1 = strtotime("+1 MONTH", $d1)) <= $d2) {
                        $i++;
                    }
                    //echo $i;
                    
                    $between_date = array();

                    for($a=0;$a<=$i;$a++){
                        $between_date[] = strtoupper(date('M-y', strtotime("+$a months", strtotime($end_date_format))));
                    }
                    //print_r($between_date);
                    // $last_update = $this->notifikasi_model->get_last($id, $date_now_format);
                    $last_update = $this->notifikasi_model->get_last($id);
                    $updated_date = array();
                    foreach ($last_update as $value) {
                        $updated_date[] =  strtoupper(date('M-y', strtotime($value['LAST_UPDATE'])));
                    }
                    $cek="tanggal tidak termasuk $id";
                    $cek_include = 0;
                    foreach ($between_date as $value) {
                        //echo $value;
                                //echo $value;
                        if($value==$date_now_format){
                            $cek_include++;
                            $cek="notif";
                        }
                    }
                    if($cek_include > 0 ){
                        foreach ($between_date as $value) {
                            if($value==$date_now_format){
                                foreach ($updated_date as $value2) {
                                    if($value2==$date_now_format){
                                        $cek="tidak notif";
                                    }
                                }
                            }
                        }
                    }

                    if($cek=="notif"){

                        $isi[$no]['url'] = base_url()."rkapinvestasi/update/$id";
                       $isi[$no]['judul'] = "Data posisi RKAP Investasi <b><i>".$judul."</i></b> belum di ubah";
                       
                       $no++;
                    }
                 
            };
        }
         
         return $isi;
    }

    public function count_data() {
        $cek_user = $this->session->userdata('SESS_USER_BRANCH');
        $user_priv = $this->session->userdata('SESS_USER_PRIV');
        // print_r($cek_user); exit();
        $branch_selected = $this->rkap_model->all_percabang($cek_user);
        $branch_pusat = $this->rkap_model->all();
        $count = 0;
        // $id_rkap_selected = $branch_selected[0]->RKAP_INVS_ID;
        if ($user_priv != 1) {

            foreach ($branch_selected as $val) {
                    $id = $val->RKAP_INVS_ID;
                    $judul = $val->RKAP_INVS_TITLE;
                    $start_date = $this->notifikasi_model->get_date_contract($id)[0]->RKAP_SUBPRO_CONTRACT_DATE;
                    $start_date_format = date('M-y', strtotime($start_date));
                    //print_r($start_date);
                    $end_date = $this->notifikasi_model->get_date_guarantee($id)[0]->RKAP_SUBPRO_ENDOF_GUARANTEE;
                    $end_date_format = date('M-y', strtotime($end_date));
                     //print_r($end_date);
                    $date_now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                    $date_now_format = strtoupper($date_now->format('M-y'));
                    // print_r($date_now_format);

                    $d1 = strtotime($start_date);
                    $d2 = strtotime($end_date);
                    $min_date = min($d1, $d2);
                    $max_date = max($d1, $d2);
                    $i = 0;

                    while (($d1 = strtotime("+1 MONTH", $d1)) <= $d2) {
                        $i++;
                    }
                    //echo $i;
                    
                    $between_date = array();

                    for($a=0;$a<=$i;$a++){
                        $between_date[] = strtoupper(date('M-y', strtotime("+$a months", strtotime($end_date_format))));
                    }
                    //print_r($between_date);
                    // $last_update = $this->notifikasi_model->get_last($id, $date_now_format);
                    $last_update = $this->notifikasi_model->get_last($id);
                    $updated_date = array();
                    foreach ($last_update as $value) {
                        $updated_date[] =  strtoupper(date('M-y', strtotime($value['LAST_UPDATE'])));
                    }
                    $cek="tanggal tidak termasuk $id";
                    $cek_include = 0;
                    foreach ($between_date as $value) {
                        //echo $value;
                                //echo $value;
                        if($value==$date_now_format){
                            $cek_include++;
                            $cek="notif";
                        }
                    }
                    if($cek_include > 0 ){
                        foreach ($between_date as $value) {
                            if($value==$date_now_format){
                                foreach ($updated_date as $value2) {
                                    if($value2==$date_now_format){
                                        $cek="tidak notif";
                                    }
                                }
                            }
                        }
                    }

                    if($cek=="notif"){
                        $count++;

                    }
                 
            };
        } else {
            foreach ($branch_pusat as $val) {
                    $id = $val->RKAP_INVS_ID;
                    $judul = $val->RKAP_INVS_TITLE;
                    $start_date = $this->notifikasi_model->get_date_contract($id)[0]->RKAP_SUBPRO_CONTRACT_DATE;
                    $start_date_format = date('M-y', strtotime($start_date));
                    //print_r($start_date);
                    $end_date = $this->notifikasi_model->get_date_guarantee($id)[0]->RKAP_SUBPRO_ENDOF_GUARANTEE;
                    $end_date_format = date('M-y', strtotime($end_date));
                     //print_r($end_date);
                    $date_now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                    $date_now_format = strtoupper($date_now->format('M-y'));
                    // print_r($date_now_format);

                    $d1 = strtotime($start_date);
                    $d2 = strtotime($end_date);
                    $min_date = min($d1, $d2);
                    $max_date = max($d1, $d2);
                    $i = 0;

                    while (($d1 = strtotime("+1 MONTH", $d1)) <= $d2) {
                        $i++;
                    }
                    //echo $i;
                    
                    $between_date = array();

                    for($a=0;$a<=$i;$a++){
                        $between_date[] = strtoupper(date('M-y', strtotime("+$a months", strtotime($end_date_format))));
                    }
                    //print_r($between_date);
                    // $last_update = $this->notifikasi_model->get_last($id, $date_now_format);
                    $last_update = $this->notifikasi_model->get_last($id);
                    $updated_date = array();
                    foreach ($last_update as $value) {
                        $updated_date[] =  strtoupper(date('M-y', strtotime($value['LAST_UPDATE'])));
                    }
                    $cek="tanggal tidak termasuk $id";
                    $cek_include = 0;
                    foreach ($between_date as $value) {
                        //echo $value;
                                //echo $value;
                        if($value==$date_now_format){
                            $cek_include++;
                            $cek="notif";
                        }
                    }
                    if($cek_include > 0 ){
                        foreach ($between_date as $value) {
                            if($value==$date_now_format){
                                foreach ($updated_date as $value2) {
                                    if($value2==$date_now_format){
                                        $cek="tidak notif";
                                    }
                                }
                            }
                        }
                    }

                    if($cek=="notif"){
                        $count++;

                    }
                 
            };
        }
         
         return $count;
    }

    public function get_cabang(){
        $this->db->select('TR_BRANCH.*');
        $this->db->from('TR_BRANCH');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_branch(){
        $this->db->select('TR_BRANCH.*');
        $this->db->from('TR_BRANCH');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_cabang_2(){
        $this->db->select('TR_BRANCH.*');
        $this->db->from('TR_BRANCH');
        $this->db->where_in('IS_PUSAT', array('0','1'));
        $query = $this->db->get();

        return $query->result();
    }

    public function get_anak_perusahaan(){
        $this->db->select('TR_BRANCH.*');
        $this->db->from('TR_BRANCH');
        $this->db->where_in('IS_PUSAT', 2);
        $this->db->order_by('BRANCH_NAME', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function detail($id_branch) {
        $this->db->select('TR_BRANCH.*, TR_BRANCH.DISPLAY_NAME AS NAME_DISPLAY');
        $this->db->from('TR_BRANCH');
        $this->db->where('BRANCH_ID', $id_branch);
        $query = $this->db->get();
        return $query->row();

    }

    public function get_value_realisasi() {
        $this->db->select('a.RKAP_SUBPRO_ID');
        $this->db->select_sum('b.REAL_SUBPRO_VAL');
        $this->db->from('TX_RKAP_SUB_PROGRAM a');
        $this->db->join('TX_REAL_SUB_PROGRAM b', 'a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID');
        $this->db->where('a.IS_DELETED', 0);
        $this->db->where('b.IS_DELETED', 0);
        $this->db->group_by('a.RKAP_SUBPRO_ID');
        $query = $this->db->get();
        return $query->result();
    }

    public function detail_status($id_status, $status) {
        if ($status == 1) {
            $stat = "Berjalan";
            $in = "IN";
        }
        else {
            $stat = "Belum Berjalan";
            $in = "NOT IN";
        }
        $query =  $this->db->query("SELECT cc.BRANCH_NAME,aa.RKAP_INVS_YEAR,aa.RKAP_INVS_TITLE,aa.RKAP_INVS_COST_REQ,aa.RKAP_INVS_VALUE,sum(NVL(ee.REAL_SUBPRO_VAL,0)) as realisasi,'$stat' as STAT FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') aa
            LEFT JOIN TM_USERS bb ON aa.RKAP_INVS_USER_ID = bb.USER_ID
            LEFT JOIN TR_BRANCH cc ON bb.USER_BRANCH = cc.BRANCH_ID
            LEFT JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) dd ON aa.RKAP_INVS_ID = dd.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (SELECT * FROM tx_real_sub_program where IS_DELETED = 0 AND real_subpro_year = TO_CHAR(sysdate,'YYYY')) ee ON dd.RKAP_SUBPRO_ID = ee.RKAP_SUBPRO_ID
            where aa.RKAP_INVS_ID $in(
                SELECT distinct a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.BRANCH_ID = $id_status AND e.REAL_SUBPRO_STATUS <> 2) 
            AND cc.BRANCH_ID = $id_status AND aa.IS_DELETED = 0 AND NVL(dd.IS_DELETED,0) <> 1
            GROUP BY cc.BRANCH_NAME,aa.RKAP_INVS_YEAR,aa.RKAP_INVS_TITLE,aa.RKAP_INVS_COST_REQ,aa.RKAP_INVS_VALUE");

        return $query->result();
    }

    public function detail_kendala($id_kendala, $kendala) {
        $query =  $this->db->query("SELECT A.BRANCH_NAME,A.RKAP_INVS_YEAR,A.RKAP_INVS_TITLE,A.rkap_invs_value,A.RKAP_SUBPRO_TITTLE,C.CONTRAINTS_NAME,total from 
        (
        SELECT c.BRANCH_NAME,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.rkap_invs_value,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID,sum(e.real_subpro_val) as total,max(e.REAL_SUBPRO_ID) as idnn
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE is_deleted = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        JOIN (SELECT * FROM TX_REAL_SUB_PROGRAM WHERE is_deleted = 0  and REAL_SUBPRO_YEAR = to_char(sysdate,'YYYY')) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0  AND c.BRANCH_ID = $id_kendala
        group by c.BRANCH_NAME,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.rkap_invs_value,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID
        ) A 
        LEFT JOIN TX_REAL_SUB_PROGRAM B ON A.idnn = B.REAL_SUBPRO_ID
        LEFT JOIN TM_CONTRAINTS C ON B.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID
        where C.CONTRAINTS_ID = $kendala");
        return $query->result();
    }

    public function detail_posisi($id_posisi, $posisi) {
        
        $query = $this->db->query("SELECT a.RKAP_INVS_ID, a.RKAP_INVS_TITLE, a.RKAP_INVS_COST_REQ, a.RKAP_INVS_VALUE, c.BRANCH_NAME, d.POSPROG_ID, d.POSPROG_NAME, c.BRANCH_NAME 
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a 
        JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
        JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
        JOIN TM_POSITION_PROGRAM d ON a.RKAP_INVS_POS = d.POSPROG_ID 
        WHERE c.BRANCH_ID = $id_posisi AND a.IS_DELETED = 0 AND a.RKAP_INVS_POS = $posisi ");
        return $query->result();    
    }

    public function detail_kontrak($id_kontrak) {
        $query = $this->db->query("SELECT a.BRANCH_ID, a.BRANCH_NAME, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE, SUM(e.REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL
            FROM TR_BRANCH a
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
                LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                LEFT JOIN (
                    SELECT * FROM TX_REAL_SUB_PROGRAM WHERE IS_DELETED = 0
                ) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND a.BRANCH_ID = $id_kontrak
            GROUP BY a.BRANCH_ID, a.BRANCH_NAME, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE");
            return $query->result();
    }
    
    public function realisasi_fisik($id_branch, $get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT A.BRANCH_ID,A.REAL_SUBPRO_VAL as RE,(A.REAL_SUBPRO_VAL / B.RKAP_INVS_VALUE * 100) AS REALISASI_FISIK FROM 
        (
            SELECT BRANCH_ID, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT BRANCH_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID, e.BRANCH_ID
            FROM (select * from TX_RKAP_SUB_PROGRAM where is_deleted = 0) a
            JOIN (select * from TX_REAL_SUB_PROGRAM where is_deleted = 0) b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE b.REAL_SUBPRO_YEAR = '$get_tahun')
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
            GROUP BY BRANCH_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY BRANCH_ID
        ) A LEFT JOIN
        (
            SELECT BRANCH_ID, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE
            FROM (SELECT BRANCH_ID, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, RKAP_INVS_YEAR
            FROM (SELECT a.*, b.USER_ID, b.USER_BRANCH, c.BRANCH_ID, c.BRANCH_NAME
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
            WHERE a.IS_DELETED =0  
            ORDER BY a.RKAP_INVS_ID DESC)
            -- WHERE RKAP_INVS_YEAR ='$get_tahun'
            GROUP BY BRANCH_ID, RKAP_INVS_YEAR)
            GROUP BY BRANCH_ID
        ) B ON A.BRANCH_ID = B.BRANCH_ID
        WHERE A.BRANCH_ID = $id_branch");

        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = (object)['id_branch' => $id_branch,'RE' => 0, 'REALISASI_FISIK' => 0];
            return $data;
        }
    }

    public function kpi_realisasi_program($id_branch) {
        $query = $this->db->query("SELECT bi2 as BRANCH_ID, jml1,jml2,(jml2 - jml1) AS belumberjalan, (jml1 / jml2 * 100) AS KPI_REALISASI_PROGRAM FROM   
        (    
            select BRANCH_ID as bi1, count(RKAP_INVS_ID) as jml1 from (SELECT distinct c.BRANCH_ID,a.RKAP_INVS_ID
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.BRANCH_ID = $id_branch AND e.REAL_SUBPRO_STATUS <> 2)
            group by BRANCH_ID
        ) A right JOIN
        (
           SELECT c.BRANCH_ID as bi2,count(a.RKAP_INVS_TITLE) as jml2
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            WHERE a.IS_DELETED =0 AND  c.BRANCH_ID = $id_branch
            GROUP BY c.BRANCH_ID
        ) B ON bi1=bi2");

        if (count($query->row()) > 0) {
            if ($query->result()[0]->JML1 == NULL) {
                 $belumberjalan = $query->result()[0]->JML2 - 0;
                 $data = ['id_branch' => $id_branch, 'KPI_REALISASI_PROGRAM' => "0",'JML1'=>"0",'JML2'=>$query->result()[0]->JML2];
            return $data;
            }else{
                return $query->row();
            }
        } else {
            $data = ['id_branch' => $id_branch, 'KPI_REALISASI_PROGRAM' => "0",'JML1'=>"0",'JML2'=>"0"];
            return $data;
        }
    }

    public function kpi_realisasi_fisik($id_branch, $get_bulan, $get_tahun) {

        // if (condition) {
        //     $contract_value = "";
        // } else {
        //     $contract_value = "";
        // }

        $query = $this->db->query("SELECT BRANCH_ID,sum(trealisasi) as RE,(sum(trealisasi) / SUM(kontrak) * 100) as KPI_REALISASI_FISIK from (
        SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(A.RKAP_SUBPRO_CONTRACT_VALUE - NVL(B.trealisasi,0)) as kontrak,A.trealisasi FROM ( 
            SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $id_branch AND e.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')
            GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) A
        LEFT JOIN (
            SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $id_branch AND e.REAL_SUBPRO_YEAR < TO_CHAR(sysdate,'YYYY')
            GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
        ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
        GROUP BY BRANCH_ID");
        
        if (count($query->row('KPI_REALISASI_FISIK')) == null) {
            $data = ['id_branch' => $id_branch,'RE' => 0, 'KPI_REALISASI_FISIK' => "0"];
            return $data;
        } else {
            return $query->row();
        }
    }

    public function Murni($id_kontrak) {
        // Murni
        $query = $this->db->query("SELECT BRANCH_ID,SUM(NILAI_KONTRAK) AS TOTAL_NILAI_KONTRAK
            FROM (SELECT a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE as NILAI_KONTRAK, TO_CHAR(a.RKAP_SUBPRO_CONTRACT_DATE, 'YYYY') AS RKAP_SUBPRO_CONTRACT_DATE, 
            b.RKAP_INVS_ID, c.USER_ID, d.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') b ON a.RKAP_SUBPRO_INVS_ID = b.RKAP_INVS_ID
            JOIN TM_USERS c ON b.RKAP_INVS_USER_ID = c.USER_ID
            JOIN TR_BRANCH d ON c.USER_BRANCH = d.BRANCH_ID
            WHERE a.IS_DELETED =0 AND b.IS_DELETED =0)
            WHERE RKAP_SUBPRO_CONTRACT_DATE = '$get_tahun'
            GROUP BY BRANCH_ID ");
            return $query->result();
    }

    public function status_prog_investasi_berjalan($id_branch) {
        $query = $this->db->query("SELECT BRANCH_ID, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND c.IS_DELETED =0 AND REAL_SUBPRO_STATUS != 2)
            WHERE BRANCH_ID = $id_branch
            GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['id_branch' => $id_branch, 'REAL_SUBPRO_STATUS' => "0"];
            return $data;
        }
    }

    public function status_prog_investasi_belum_berjalan($id_branch) {
        $query = $this->db->query("SELECT BRANCH_ID, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND c.IS_DELETED =0 AND REAL_SUBPRO_STATUS = 2)
            WHERE BRANCH_ID = $id_branch
            GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['id_branch' => $id_branch, 'REAL_SUBPRO_STATUS' => "0"];
            return $data;
        }
    }

    public function posisi_prog_investasi($id_branch) {
        $query = $this->db->query("SELECT  BRANCH_ID, POSISI, COUNT(RKAP_INVS_POS) AS JUMLAH_POSISI, RKAP_INVS_POS
        FROM(SELECT a.RKAP_INVS_POS, c.BRANCH_ID, d.POSPROG_NAME as POSISI
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a 
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TM_POSITION_PROGRAM d ON a.RKAP_INVS_POS = d.POSPROG_ID
        WHERE a.IS_DELETED =0 AND c.BRANCH_ID= '$id_branch')
        GROUP BY BRANCH_ID, POSISI, RKAP_INVS_POS
        ORDER BY JUMLAH_POSISI DESC");

        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['id_branch' => $id_branch, 'JUMLAH_POSISI' => "0"];
            return $data;
        }
    }

    public function kendala_prog_investasi($id_branch) {
        $query = $this->db->query("SELECT BRANCH_NAME,count(BRANCH_NAME) as TOTAL_KENDALA,CONTRAINTS_NAME from (
            SELECT A.BRANCH_NAME,A.RKAP_INVS_YEAR,A.RKAP_INVS_TITLE,A.rkap_invs_value,A.RKAP_SUBPRO_TITTLE,C.CONTRAINTS_NAME,total from 
                        (
                        SELECT c.BRANCH_NAME,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.rkap_invs_value,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID,sum(e.real_subpro_val) as total,max(e.REAL_SUBPRO_ID) as idnn
                        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE is_deleted = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                        JOIN (SELECT * FROM TX_REAL_SUB_PROGRAM WHERE is_deleted = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                        WHERE a.IS_DELETED =0  AND c.BRANCH_ID = $id_branch
                        group by c.BRANCH_NAME,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.rkap_invs_value,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID
                        ) A 
                        LEFT JOIN TX_REAL_SUB_PROGRAM B ON A.idnn = B.REAL_SUBPRO_ID
                        LEFT JOIN TM_CONTRAINTS C ON B.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID
                        )
        GROUP by BRANCH_NAME,CONTRAINTS_NAME
        order by TOTAL_KENDALA desc");
        
        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['id_branch' => $id_branch, 'TOTAL_KENDALA' => "0"];
            return $data;
        }
    }

   public function kontrak_kritis($id_branch) {
        $query = $this->db->query("SELECT A.BRANCH_ID,A.BRANCH_NAME, A.RKAP_INVS_ID, A.RKAP_INVS_TITLE, A.RKAP_INVS_COST_REQ, NVL(A.RKAP_INVS_VALUE,0) as RKAP_INVS_VALUE, NVL(B.REAL_SUBPRO_VAL,0) as REAL_SUBPRO_VAL from (
        select a.BRANCH_ID,a.BRANCH_NAME, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ,c.RKAP_INVS_VALUE FROM TR_BRANCH a
                        LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                        LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
                        where a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0) A
        LEFT JOIN
        (
        SELECT a.BRANCH_ID, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE, SUM(NVL(e.REAL_SUBPRO_VAL,0)) AS REAL_SUBPRO_VAL
                    FROM TR_BRANCH a
                        LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                        LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
                        LEFT JOIN ( 
                            SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
                        ) d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                        LEFT JOIN (
                            SELECT * FROM TX_REAL_SUB_PROGRAM WHERE IS_DELETED = 0
                        ) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE c.IS_DELETED = 0 AND a.BRANCH_ID = $id_branch AND e.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')
                    GROUP BY a.BRANCH_ID, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE) B
        ON A.RKAP_INVS_ID = B.RKAP_INVS_ID");
        return $query->result();
    }

    public function realisasi_program () {
        $this->db->select('a.RKAP_SUBPRO_INVS_ID');
        $this->db->select_sum('b.REAL_SUBPRO_VAL');
        $this->db->from('TX_RKAP_SUB_PROGRAM a');
        $this->db->join('TX_REAL_SUB_PROGRAM b', 'a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID', 'left');
        $this->db->where('a.IS_DELETED', 0);
        $this->db->where('b.IS_DELETED', 0);
        $this->db->group_by('a.RKAP_SUBPRO_INVS_ID');
        $this->db->order_by('a.RKAP_SUBPRO_INVS_ID', 'desc');

        $query = $this->db->get();
        return $query->result();
    }

    public function total_realisasi_program ($id_branch) {
        $this->db->select('e.BRANCH_ID, e.BRANCH_NAME');
        $this->db->select_sum('c.REAL_SUBPRO_VAL');
        $this->db->from("TX_RKAP_INVESTATION_Y a");
        $this->db->join('TX_RKAP_SUB_PROGRAM b', 'a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID');
        $this->db->join('TX_REAL_SUB_PROGRAM c', 'b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID');
        $this->db->join('TM_USERS d', 'a.RKAP_INVS_USER_ID = d.USER_ID');
        $this->db->join('TR_BRANCH e', 'd.USER_BRANCH = e.BRANCH_ID');
        $this->db->where('a.IS_DELETED', 0);
        $this->db->where('b.IS_DELETED', 0);
        $this->db->where('c.IS_DELETED', 0);
        $this->db->where('d.USER_BRANCH', $id_branch);
        $this->db->group_by('e.BRANCH_ID, e.BRANCH_NAME');

        $query = $this->db->get();
        return $query->row();
    }

    public function kontrak_kritis_f ($id_branch) {
        $query = $this->db->query("SELECT sum(RKAP_INVS_COST_REQ) as TDANA,sum(RKAP_INVS_VALUE) as TRKAP,sum(REAL_SUBPRO_VAL) as TREALISASI from (
        SELECT A.BRANCH_ID, A.RKAP_INVS_ID, A.RKAP_INVS_TITLE, A.RKAP_INVS_COST_REQ, NVL(A.RKAP_INVS_VALUE,0) as RKAP_INVS_VALUE, NVL(B.REAL_SUBPRO_VAL,0) as REAL_SUBPRO_VAL from (
                select a.BRANCH_ID, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ,c.RKAP_INVS_VALUE FROM TR_BRANCH a
                                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                where a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0) A
                LEFT JOIN
                (
                SELECT a.BRANCH_ID, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE, SUM(NVL(e.REAL_SUBPRO_VAL,0)) AS REAL_SUBPRO_VAL
                            FROM TR_BRANCH a
                                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                LEFT JOIN ( 
                                    SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
                                ) d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                LEFT JOIN (
                                    SELECT * FROM TX_REAL_SUB_PROGRAM WHERE IS_DELETED = 0
                                ) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                            WHERE c.IS_DELETED = 0 AND a.BRANCH_ID = $id_branch AND e.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')
                            GROUP BY a.BRANCH_ID, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE) B
                ON A.RKAP_INVS_ID = B.RKAP_INVS_ID)");
        return $query->result();
    }

    public function list_prog_investasi_posisi($id_branch, $posisi="", $get_bulan) {
        if ($posisi) {
           $where = "WHERE a.IS_DELETED =0 and c.branch_id =  $id_branch  AND a.rkap_invs_pos = $posisi";
        } else {
           $where = "WHERE a.IS_DELETED =0 and c.branch_id =  $id_branch AND ROWNUM <=1";
        };

        $query = $this->db->query("SELECT branch_id,BRANCH_NAME,sum(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,count(rkap_invs_pos) as RKAP_INVS_POS,sum(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL from (
            SELECT c.BRANCH_NAME,c.branch_id,a.RKAP_INVS_VALUE,a.rkap_invs_id,a.rkap_invs_pos,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where is_deleted = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where is_deleted = 0 AND REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            $where
            group BY c.BRANCH_NAME,c.branch_id,a.RKAP_INVS_VALUE,a.rkap_invs_pos,a.rkap_invs_id)
        group by branch_id,BRANCH_NAME");
        return $query->result();
    }

    
     public function cek_status($id_branch) {
            $this->db->select('a.REAL_SUBPRO_STATUS, d.IS_RESULT');
            $this->db->from('TX_REAL_SUB_PROGRAM a');
            $this->db->join('TX_RKAP_SUB_PROGRAM b', 'a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID');
            $this->db->join("(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c", 'b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID');
            $this->db->join('TM_STATUS_PROGRAM d', 'a.REAL_SUBPRO_STATUS = d.STATUS_ID');
            $this->db->join('TM_USERS e', 'c.RKAP_INVS_USER_ID = e.USER_ID');
            $this->db->join('TR_BRANCH f', 'e.USER_BRANCH = f.BRANCH_ID');
            $this->db->where('a.IS_DELETED', 0);
            $this->db->where('b.IS_DELETED', 0);
            $this->db->where('c.IS_DELETED', 0);
            $where = array('e.USER_BRANCH' => $id_branch);
            $this->db->where($where);
            $query = $this->db->get();
            return $query->result();
        }

    public function list_prog_investasi_status($id_branch, $status="") {
        if ($status) {
            $where = "WHERE IS_RESULT = $status AND a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND BRANCH_ID = '$id_branch'";
        } else {
           $where = "WHERE BRANCH_ID = '$id_branch' AND a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0";
        };

        if ($status == 1) {
            $in = "IN";
        }
        else {
            $in = "NOT IN";
        }
        
        $query = $this->db->query("SELECT BRANCH_NAME,BRANCH_ID,count(RKAP_INVS_YEAR) as REAL_SUBPRO_STATUS,sum(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,sum(realisasi) as REAL_SUBPRO_VAL from (SELECT cc.BRANCH_NAME,cc.BRANCH_ID,aa.RKAP_INVS_YEAR,aa.RKAP_INVS_TITLE,aa.RKAP_INVS_COST_REQ,aa.RKAP_INVS_VALUE,sum(NVL(ee.REAL_SUBPRO_VAL,0)) as realisasi FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') aa
            LEFT JOIN TM_USERS bb ON aa.RKAP_INVS_USER_ID = bb.USER_ID
            LEFT JOIN TR_BRANCH cc ON bb.USER_BRANCH = cc.BRANCH_ID
            LEFT JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) dd ON aa.RKAP_INVS_ID = dd.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (SELECT * FROM tx_real_sub_program where IS_DELETED = 0 AND real_subpro_year = TO_CHAR(sysdate,'YYYY')) ee ON dd.RKAP_SUBPRO_ID = ee.RKAP_SUBPRO_ID
            where aa.RKAP_INVS_ID $in(
                SELECT distinct a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.BRANCH_ID = $id_branch AND e.REAL_SUBPRO_STATUS <> 2) 
            AND cc.BRANCH_ID = $id_branch AND aa.IS_DELETED = 0 AND NVL(dd.IS_DELETED,0) <> 1
            GROUP BY cc.BRANCH_NAME,aa.RKAP_INVS_YEAR,aa.RKAP_INVS_TITLE,aa.RKAP_INVS_COST_REQ,aa.RKAP_INVS_VALUE,cc.BRANCH_ID)
            group by BRANCH_NAME,BRANCH_ID");
        return $query->result();
    }

    public function list_prog_investasi_kendala($id_branch, $kendala="") {
        if ($kendala) {
            $where = "WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0  AND c.BRANCH_ID = $id_branch AND b.IS_DELETED = 0 AND e.REAL_SUBPRO_CONSTRAINTS = $kendala";
            $kendala = $kendala;
        } else {
           $where = "WHERE BRANCH_ID = '$id_branch' AND a.IS_DELETED = 0 AND b.IS_DELETED = 0 ";
           $kendala = 0;
        };

        $query = $this->db->query("SELECT BRANCH_NAME,BRANCH_ID,count(RKAP_INVS_TITLE)  as REAL_SUBPRO_CONSTRAINTS ,sum(RKAP_INVS_VALUE)  as RKAP_INVS_VALUE,sum(jml) as REAL_SUBPRO_VAL,('asdasd') as CONSTRANT_NAME from (
        SELECT AA.BRANCH_NAME,AA.BRANCH_ID,AA.RKAP_INVS_VALUE,AA.RKAP_INVS_TITLE,BB.RKAP_SUBPRO_TITTLE,SUM(CC.REAL_SUBPRO_VAL) as jml from (
        SELECT A.BRANCH_NAME,A.BRANCH_ID,A.RKAP_INVS_YEAR,A.RKAP_INVS_VALUE,A.RKAP_INVS_TITLE,A.RKAP_SUBPRO_ID,CONCAT(B.REAL_SUBPRO_PERCENT_TOT,'%') as total,C.CONTRAINTS_NAME from 
                    (
                    SELECT c.BRANCH_NAME,c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID,max(e.REAL_SUBPRO_ID) as idnn
                    FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0  AND c.BRANCH_ID = $id_branch
                    group by c.BRANCH_NAME,c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID
                    ) A 
                    JOIN TX_REAL_SUB_PROGRAM B ON A.idnn = B.REAL_SUBPRO_ID
                    JOIN TM_CONTRAINTS C ON B.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID
                    where C.CONTRAINTS_ID = $kendala) AA
        JOIN TX_RKAP_SUB_PROGRAM BB on AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID JOIN TX_REAL_SUB_PROGRAM CC ON BB.RKAP_SUBPRO_ID = CC.RKAP_SUBPRO_ID
        where cc.real_subpro_year = to_char(CURRENT_DATE,'YYYY')
        group by AA.RKAP_INVS_TITLE,BB.RKAP_SUBPRO_TITTLE,AA.BRANCH_NAME,AA.RKAP_INVS_VALUE,AA.BRANCH_ID)
        group BY BRANCH_NAME,BRANCH_ID");
        return $query->result();
    }

    /*dropdown*/
    public function d_status() {
        $this->db->select('*');
        $this->db->from('TM_STATUS_PROGRAM');
         $this->db->where('TM_STATUS_PROGRAM.IS_SEARCH', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function d_kendala() {
        $this->db->select('*');
        $this->db->from('TM_CONTRAINTS');
        $query = $this->db->get();
        return $query->result();
    }

    public function d_posisi() {
        $this->db->select('*');
        $this->db->from('TM_POSITION_PROGRAM');
        $query = $this->db->get();
        return $query->result();
    }

    /*USER PUSAT*/
    // pusat_realisasi_fisik date belum di set

    public function pusat_realisasi_fisik($is_pusat, $get_bulan, $get_tahun) {

        $query = $this->db->query("SELECT A.IS_PUSAT,A.REAL_SUBPRO_VAL as RE,(A.REAL_SUBPRO_VAL / B.RKAP_INVS_VALUE * 100) AS REALISASI_FISIK FROM 
        (
            SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID, e.IS_PUSAT
            FROM (select * from TX_RKAP_SUB_PROGRAM where is_deleted = 0) a
            JOIN (select * from TX_REAL_SUB_PROGRAM where is_deleted = 0) b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE b.REAL_SUBPRO_YEAR = '$get_tahun')
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY IS_PUSAT
        ) A LEFT JOIN
        (
            SELECT IS_PUSAT, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE
            FROM (SELECT IS_PUSAT, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, RKAP_INVS_YEAR
            FROM (SELECT a.*, b.USER_ID, b.USER_BRANCH, c.IS_PUSAT, c.BRANCH_NAME
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
            WHERE a.IS_DELETED =0  
            ORDER BY a.RKAP_INVS_ID DESC)
            -- WHERE RKAP_INVS_YEAR ='$get_tahun'
            GROUP BY IS_PUSAT, RKAP_INVS_YEAR)
            GROUP BY IS_PUSAT
        ) B ON A.IS_PUSAT = B.IS_PUSAT
        WHERE A.IS_PUSAT = '$is_pusat'");
        // return count($query->row());

        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'REALISASI_FISIK' => "0"];
            return $data;
        }
    }

    public function pusat_kpi_realisasi_program($is_pusat) {

        // if ($is_pusat == 0) {
        //     $where = "WHERE A.IS_PUSAT in ('0', '1')";
        // } else {
        //     $where = "WHERE A.IS_PUSAT = '$is_pusat'";
        // };

        $query = $this->db->query("SELECT bi2 as IS_PUSAT, jml1,jml2,(jml2 - jml1) AS belumberjalan, (jml1 / jml2 * 100) AS KPI_REALISASI_PROGRAM FROM   
        (    
            select IS_PUSAT as bi1, count(RKAP_INVS_ID) as jml1 from (SELECT distinct c.IS_PUSAT,a.RKAP_INVS_ID
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND  c.IS_PUSAT = $is_pusat AND e.REAL_SUBPRO_STATUS <> 2)
            group by IS_PUSAT
        ) A right JOIN
        (
           SELECT c.IS_PUSAT as bi2,count(a.RKAP_INVS_TITLE) as jml2
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            WHERE a.IS_DELETED =0 AND  c.IS_PUSAT = $is_pusat
            GROUP BY c.IS_PUSAT
        ) B ON bi1=bi2");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'KPI_REALISASI_PROGRAM' => "0"];
            return $data;
        }
    }

    public function pusat_kpi_realisasi_fisik($is_pusat, $get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT IS_PUSAT,(sum(trealisasi) / SUM(kontrak) * 100) as KPI_REALISASI_FISIK from (
        SELECT A.IS_PUSAT,A.RKAP_INVS_ID,(A.RKAP_SUBPRO_CONTRACT_VALUE - NVL(B.trealisasi,0)) as kontrak,A.trealisasi FROM ( 
            SELECT c.IS_PUSAT,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0 AND c.IS_PUSAT = $is_pusat AND e.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')
            GROUP BY c.IS_PUSAT,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) A
        LEFT JOIN (
            SELECT c.IS_PUSAT,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) as trealisasi
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0 AND c.IS_PUSAT = $is_pusat AND e.REAL_SUBPRO_YEAR < TO_CHAR(sysdate,'YYYY')
            GROUP BY c.IS_PUSAT,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
        ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
        GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'KPI_REALISASI_FISIK' => "0"];
            return $data;
        }
    }

    public function pusat_status_prog_investasi_berjalan($is_pusat) {
        $query = $this->db->query("SELECT IS_PUSAT, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS != 2)
            WHERE IS_PUSAT = '$is_pusat'
            GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'REAL_SUBPRO_STATUS' => "0"];
            return $data;
        }
    }

    public function pusat_status_prog_investasi_belum_berjalan($is_pusat) {
        $query = $this->db->query("SELECT IS_PUSAT, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS = 2)
            WHERE IS_PUSAT = '$is_pusat'
            GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'REAL_SUBPRO_STATUS' => "0"];
            return $data;
        }
    }

    public function pusat_posisi_prog_investasi($is_pusat) {
        $query = $this->db->query("SELECT IS_PUSAT, POSISI, COUNT(RKAP_INVS_POS) AS JUMLAH_POSISI, RKAP_INVS_POS
        FROM(SELECT a.RKAP_INVS_POS, c.IS_PUSAT, d.POSPROG_NAME as POSISI
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a 
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TM_POSITION_PROGRAM d ON a.RKAP_INVS_POS = d.POSPROG_ID
        WHERE a.IS_DELETED =0 AND c.IS_PUSAT= '$is_pusat')
        GROUP BY IS_PUSAT, POSISI, RKAP_INVS_POS
        ORDER BY JUMLAH_POSISI DESC");
        
        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'JUMLAH_POSISI' => "0"];
            return $data;
        }
    }

    public function pusat_kendala_prog_investasi($is_pusat) {
        $query = $this->db->query("SELECT IS_PUSAT,count(IS_PUSAT) as TOTAL_KENDALA,CONTRAINTS_NAME from (
            SELECT A.IS_PUSAT,A.RKAP_INVS_YEAR,A.RKAP_INVS_TITLE,A.rkap_invs_value,A.RKAP_SUBPRO_TITTLE,C.CONTRAINTS_NAME,total from 
                        (
                        SELECT c.IS_PUSAT,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.rkap_invs_value,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID,sum(e.real_subpro_val) as total,max(e.REAL_SUBPRO_ID) as idnn
                        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE is_deleted = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                        JOIN (SELECT * FROM TX_REAL_SUB_PROGRAM WHERE is_deleted = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                        WHERE a.IS_DELETED =0 AND c.IS_PUSAT = $is_pusat
                        group by c.IS_PUSAT,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.rkap_invs_value,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID
                        ) A 
                        LEFT JOIN TX_REAL_SUB_PROGRAM B ON A.idnn = B.REAL_SUBPRO_ID
                        LEFT JOIN TM_CONTRAINTS C ON B.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID
                        )
        GROUP by IS_PUSAT,CONTRAINTS_NAME
        order by TOTAL_KENDALA desc");
        
        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'TOTAL_KENDALA' => "0"];
            return $data;
        }
    }

    // KONTRAK BELUM SELESAI
   public function pusat_kontrak_kritis($is_pusat) {
        $query = $this->db->query("SELECT BRANCH_ID,BRANCH_NAME,sum(RKAP_INVS_COST_REQ) as RKAP_INVS_COST_REQ,sum(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,sum(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM (
        SELECT A.BRANCH_ID,A.BRANCH_NAME, A.RKAP_INVS_ID, A.RKAP_INVS_TITLE, A.RKAP_INVS_COST_REQ, NVL(A.RKAP_INVS_VALUE,0) as RKAP_INVS_VALUE, NVL(B.REAL_SUBPRO_VAL,0) as REAL_SUBPRO_VAL from (
                select a.BRANCH_ID,a.BRANCH_NAME, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ,c.RKAP_INVS_VALUE FROM TR_BRANCH a
                                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                where c.IS_DELETED = 0 AND a.IS_PUSAT = $is_pusat) A
                LEFT JOIN
                (
                SELECT a.BRANCH_ID, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE, SUM(NVL(e.REAL_SUBPRO_VAL,0)) AS REAL_SUBPRO_VAL
                            FROM TR_BRANCH a
                                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                LEFT JOIN ( 
                                    SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
                                ) d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                LEFT JOIN (
                                    SELECT * FROM TX_REAL_SUB_PROGRAM WHERE IS_DELETED = 0
                                ) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                            WHERE c.IS_DELETED = 0 AND a.IS_PUSAT = $is_pusat AND e.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')
                            GROUP BY a.BRANCH_ID, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE) B
                ON A.RKAP_INVS_ID = B.RKAP_INVS_ID)
        GROUP BY BRANCH_ID,BRANCH_NAME
        ORDER BY BRANCH_ID asc");
            return $query->result();
    }

    public function total_realisasi_program_pusat ($is_pusat) {
        $this->db->select('e.IS_PUSAT');
        $this->db->select_sum('c.REAL_SUBPRO_VAL');
        $this->db->from("TX_RKAP_INVESTATION_Y a");
        $this->db->join('TX_RKAP_SUB_PROGRAM b', 'a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID');
        $this->db->join('TX_REAL_SUB_PROGRAM c', 'b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID');
        $this->db->join('TM_USERS d', 'a.RKAP_INVS_USER_ID = d.USER_ID');
        $this->db->join('TR_BRANCH e', 'd.USER_BRANCH = e.BRANCH_ID');
        $this->db->where('a.IS_DELETED', 0);
        $this->db->where('b.IS_DELETED', 0);
        $this->db->where('c.IS_DELETED', 0);
        $this->db->where('e.IS_PUSAT', $is_pusat);
        $this->db->group_by('e.IS_PUSAT');

        $query = $this->db->get();
        return $query->row();
    }

    public function pusat_kontrak_kritis_f ($is_pusat) {
        $query = $this->db->query("SELECT sum(RKAP_INVS_COST_REQ) as RKAP_INVS_COST_REQ,sum(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,sum(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM (
        SELECT BRANCH_ID,BRANCH_NAME,sum(RKAP_INVS_COST_REQ) as RKAP_INVS_COST_REQ,sum(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,sum(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM (
        SELECT A.BRANCH_ID,A.BRANCH_NAME, A.RKAP_INVS_ID, A.RKAP_INVS_TITLE, A.RKAP_INVS_COST_REQ, NVL(A.RKAP_INVS_VALUE,0) as RKAP_INVS_VALUE, NVL(B.REAL_SUBPRO_VAL,0) as REAL_SUBPRO_VAL from (
                select a.BRANCH_ID,a.BRANCH_NAME, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ,c.RKAP_INVS_VALUE FROM TR_BRANCH a
                                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                where c.IS_DELETED = 0 AND a.IS_PUSAT = $is_pusat) A
                LEFT JOIN
                (
                SELECT a.BRANCH_ID, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE, SUM(NVL(e.REAL_SUBPRO_VAL,0)) AS REAL_SUBPRO_VAL
                            FROM TR_BRANCH a
                                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                LEFT JOIN ( 
                                    SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
                                ) d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                LEFT JOIN (
                                    SELECT * FROM TX_REAL_SUB_PROGRAM WHERE IS_DELETED = 0
                                ) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                            WHERE c.IS_DELETED = 0 AND a.IS_PUSAT = $is_pusat AND e.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')
                            GROUP BY a.BRANCH_ID, c.RKAP_INVS_ID, c.RKAP_INVS_TITLE, c.RKAP_INVS_COST_REQ, c.RKAP_INVS_VALUE) B
                ON A.RKAP_INVS_ID = B.RKAP_INVS_ID)
        GROUP BY BRANCH_ID,BRANCH_NAME)");
            return $query->result();
    }

    public function pusat_list_prog_investasi_posisi($is_pusat, $posisi="", $get_bulan) {
        if ($posisi) {
            $where = "WHERE a.IS_DELETED =0  AND a.rkap_invs_pos = $posisi and c.is_pusat = $is_pusat";
        } else {
           $where = "WHERE a.IS_DELETED =0 AND c.is_pusat = '$is_pusat'";
        };

        $query = $this->db->query("SELECT branch_id,BRANCH_NAME,sum(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,count(rkap_invs_pos) as RKAP_INVS_POS,NVL(sum(REAL_SUBPRO_VAL),0) as REAL_SUBPRO_VAL from (
            SELECT c.BRANCH_NAME,c.branch_id,a.RKAP_INVS_VALUE,a.rkap_invs_id,a.rkap_invs_pos,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where is_deleted = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where is_deleted = 0 AND REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            $where
            group BY c.BRANCH_NAME,c.branch_id,a.RKAP_INVS_VALUE,a.rkap_invs_pos,a.rkap_invs_id)
        group by branch_id,BRANCH_NAME");
        return $query->result();
    }

    public function pusat_list_prog_investasi_posisi_f($is_pusat, $posisi="", $get_bulan) {
        if ($posisi) {
            $where = "WHERE RKAP_INVS_POS = $posisi AND a.IS_DELETED =0 AND IS_PUSAT = '$is_pusat'";
        } else {
           $where = "WHERE a.IS_DELETED =0 AND is_pusat = '$is_pusat'";
        };

        $query = $this->db->query("SELECT SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, COUNT(a.RKAP_INVS_POS) AS RKAP_INVS_POS, a.IS_PUSAT, a.POSPROG_NAME, SUM(b.REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL FROM
        (        
            SELECT a.RKAP_INVS_ID, a.RKAP_INVS_VALUE, a.RKAP_INVS_POS,c.BRANCH_ID, c.BRANCH_NAME, c.IS_PUSAT, d.POSPROG_NAME
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a                                                                 
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TM_POSITION_PROGRAM d ON a.RKAP_INVS_POS = d.POSPROG_ID
            $where
        )A left join
        (    
            SELECT BRANCH_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
            (SELECT BRANCH_ID, RKAP_SUBPRO_ID, RKAP_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
            (SELECT e.BRANCH_ID, a.RKAP_INVS_ID, b.RKAP_SUBPRO_ID, TO_CHAR(c.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, c.REAL_SUBPRO_VAL 
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID 
            JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND IS_PUSAT = '0')
            WHERE AA <= '$get_bulan'
            GROUP BY BRANCH_ID, RKAP_SUBPRO_ID, RKAP_INVS_ID)
            GROUP BY BRANCH_ID
        )B ON A.BRANCH_ID = B.BRANCH_ID
        GROUP BY a.IS_PUSAT, a.POSPROG_NAME");
        return $query->result();
    }

    public function pusat_list_prog_investasi_status($is_pusat, $status="") {
        if ($status) {
            $where = "WHERE IS_RESULT = $status AND a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND f.IS_PUSAT = '$is_pusat'";
        } else {
           $where = "WHERE f.IS_PUSAT = '$is_pusat' AND a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0";
        };

        if ($status == 1) {
            $in = "IN";
        }
        else {
            $in = "NOT IN";
        }

        $query = $this->db->query("SELECT BRANCH_NAME,BRANCH_ID,count(RKAP_INVS_YEAR) as REAL_SUBPRO_STATUS,sum(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,sum(realisasi) as REAL_SUBPRO_VAL from 
        (SELECT cc.BRANCH_NAME,cc.is_pusat,cc.BRANCH_ID,aa.RKAP_INVS_YEAR,aa.RKAP_INVS_TITLE,aa.RKAP_INVS_COST_REQ,aa.RKAP_INVS_VALUE,sum(NVL(ee.REAL_SUBPRO_VAL,0)) as realisasi FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') aa
                LEFT JOIN TM_USERS bb ON aa.RKAP_INVS_USER_ID = bb.USER_ID
                LEFT JOIN TR_BRANCH cc ON bb.USER_BRANCH = cc.BRANCH_ID
                LEFT JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) dd ON aa.RKAP_INVS_ID = dd.RKAP_SUBPRO_INVS_ID
                LEFT JOIN (SELECT * FROM tx_real_sub_program where IS_DELETED = 0 AND real_subpro_year = TO_CHAR(sysdate,'YYYY')) ee ON dd.RKAP_SUBPRO_ID = ee.RKAP_SUBPRO_ID
                where aa.RKAP_INVS_ID $in(
                    SELECT distinct a.RKAP_INVS_ID
                    FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2) 
                AND aa.IS_DELETED = 0 AND NVL(dd.IS_DELETED,0) <> 1 AND cc.is_pusat = $is_pusat
                GROUP BY cc.BRANCH_NAME,aa.RKAP_INVS_YEAR,aa.RKAP_INVS_TITLE,aa.RKAP_INVS_COST_REQ,aa.RKAP_INVS_VALUE,cc.BRANCH_ID,cc.is_pusat)
                group by BRANCH_NAME,BRANCH_ID");
        return $query->result();
    }

    public function pusat_list_prog_investasi_status_f($is_pusat, $status="") {
        if ($status) {
            $where = "WHERE IS_RESULT = $status AND a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND f.IS_PUSAT = '$is_pusat'";
        } else {
           $where = "WHERE f.IS_PUSAT = '$is_pusat' AND a.IS_DELETED = 0";
        };

        if ($status == 1) {
            $in = "IN";
        }
        else {
            $in = "NOT IN";
        }

        $query = $this->db->query("SELECT SUM(REAL_SUBPRO_STATUS) as REAL_SUBPRO_STATUS,SUM(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM (
        SELECT BRANCH_NAME,IS_PUSAT,BRANCH_ID,count(RKAP_INVS_YEAR) as REAL_SUBPRO_STATUS,sum(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,sum(realisasi) as REAL_SUBPRO_VAL from (
        SELECT cc.BRANCH_NAME,cc.IS_PUSAT,cc.BRANCH_ID,aa.RKAP_INVS_YEAR,aa.RKAP_INVS_TITLE,aa.RKAP_INVS_COST_REQ,aa.RKAP_INVS_VALUE,sum(NVL(ee.REAL_SUBPRO_VAL,0)) as realisasi FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') aa
                    LEFT JOIN TM_USERS bb ON aa.RKAP_INVS_USER_ID = bb.USER_ID
                    LEFT JOIN TR_BRANCH cc ON bb.USER_BRANCH = cc.BRANCH_ID
                    LEFT JOIN TX_RKAP_SUB_PROGRAM dd ON aa.RKAP_INVS_ID = dd.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN TX_REAL_SUB_PROGRAM ee ON dd.RKAP_SUBPRO_ID = ee.RKAP_SUBPRO_ID
                    where aa.RKAP_INVS_ID $in (
                        SELECT distinct a.RKAP_INVS_ID
                        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                        JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                        WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.IS_PUSAT = $is_pusat AND e.REAL_SUBPRO_STATUS <> 2) 
                    AND cc.IS_PUSAT = $is_pusat AND aa.IS_DELETED = 0 AND NVL(dd.IS_DELETED,0) <> 1 AND ee.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')
                    GROUP BY cc.BRANCH_NAME,cc.IS_PUSAT,aa.RKAP_INVS_YEAR,aa.RKAP_INVS_TITLE,aa.RKAP_INVS_COST_REQ,aa.RKAP_INVS_VALUE,cc.BRANCH_ID)
        group by BRANCH_NAME,BRANCH_ID,IS_PUSAT)");
        return $query->result();
    }

    public function pusat_list_prog_investasi_kendala($is_pusat, $kendala="") {
        if ($kendala) {
            $where = "where C.CONTRAINTS_ID = $kendala";
        } else {
           $where = "where C.CONTRAINTS_ID = 0";
        };

        $query = $this->db->query("SELECT BRANCH_NAME,BRANCH_ID,count(RKAP_INVS_TITLE)  as REAL_SUBPRO_CONSTRAINTS ,sum(RKAP_INVS_VALUE)  as RKAP_INVS_VALUE,sum(jml) as REAL_SUBPRO_VAL,('asdasd') as CONSTRANT_NAME from (
        SELECT AA.BRANCH_NAME,AA.BRANCH_ID,AA.RKAP_INVS_VALUE,AA.RKAP_INVS_TITLE,BB.RKAP_SUBPRO_TITTLE,SUM(CC.REAL_SUBPRO_VAL) as jml from (
        SELECT A.BRANCH_NAME,A.BRANCH_ID,A.RKAP_INVS_YEAR,A.RKAP_INVS_VALUE,A.RKAP_INVS_TITLE,A.RKAP_SUBPRO_ID,CONCAT(B.REAL_SUBPRO_PERCENT_TOT,'%') as total,C.CONTRAINTS_NAME from 
                    (
                    SELECT c.BRANCH_NAME,c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID,max(e.REAL_SUBPRO_ID) as idnn
                    FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.is_pusat = $is_pusat
                    group by c.BRANCH_NAME,c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID
                    ) A 
                    JOIN TX_REAL_SUB_PROGRAM B ON A.idnn = B.REAL_SUBPRO_ID
                    JOIN TM_CONTRAINTS C ON B.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID
                    $where) AA
        JOIN TX_RKAP_SUB_PROGRAM BB on AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID JOIN TX_REAL_SUB_PROGRAM CC ON BB.RKAP_SUBPRO_ID = CC.RKAP_SUBPRO_ID
        group by AA.RKAP_INVS_TITLE,BB.RKAP_SUBPRO_TITTLE,AA.BRANCH_NAME,AA.RKAP_INVS_VALUE,AA.BRANCH_ID)
        group BY BRANCH_NAME,BRANCH_ID");
        return $query->result();
    }

    public function pusat_list_prog_investasi_kendala_f($is_pusat, $kendala="") {
         if ($kendala) {
            $where = "where C.CONTRAINTS_ID = $kendala";
        } else {
           $where = "where C.CONTRAINTS_ID = 0";
        };

        $query = $this->db->query("SELECT sum(REAL_SUBPRO_CONSTRAINTS) as REAL_SUBPRO_CONSTRAINTS ,sum(RKAP_INVS_VALUE) as RKAP_INVS_VALUE,sum(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL from (
            SELECT IS_PUSAT,BRANCH_ID,count(RKAP_INVS_TITLE)  as REAL_SUBPRO_CONSTRAINTS ,sum(RKAP_INVS_VALUE)  as RKAP_INVS_VALUE,sum(jml) as REAL_SUBPRO_VAL from (
                    SELECT AA.IS_PUSAT,AA.BRANCH_ID,AA.RKAP_INVS_VALUE,AA.RKAP_INVS_TITLE,BB.RKAP_SUBPRO_TITTLE,SUM(CC.REAL_SUBPRO_VAL) as jml from (
                    SELECT A.IS_PUSAT,A.BRANCH_ID,A.RKAP_INVS_YEAR,A.RKAP_INVS_VALUE,A.RKAP_INVS_TITLE,A.RKAP_SUBPRO_ID,CONCAT(B.REAL_SUBPRO_PERCENT_TOT,'%') as total,C.CONTRAINTS_NAME from 
                                (
                                SELECT c.IS_PUSAT,c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID,max(e.REAL_SUBPRO_ID) as idnn
                                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.is_pusat = $is_pusat
                                group by c.IS_PUSAT,c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID
                                ) A 
                                JOIN TX_REAL_SUB_PROGRAM B ON A.idnn = B.REAL_SUBPRO_ID
                                JOIN TM_CONTRAINTS C ON B.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID
                                $where) AA
                    JOIN TX_RKAP_SUB_PROGRAM BB on AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID JOIN TX_REAL_SUB_PROGRAM CC ON BB.RKAP_SUBPRO_ID = CC.RKAP_SUBPRO_ID
                    group by AA.RKAP_INVS_TITLE,BB.RKAP_SUBPRO_TITTLE,AA.IS_PUSAT,AA.RKAP_INVS_VALUE,AA.BRANCH_ID)
                    group BY IS_PUSAT,BRANCH_ID)
            group by IS_PUSAT");
        return $query->result();
    }

    // gabungan cabang dan anak perusahaan

    public function all_realisasi_fisik($get_bulan, $get_tahun) {

        $query = $this->db->query("SELECT A.COMPANY_CODE,A.REAL_SUBPRO_VAL as RE,(A.REAL_SUBPRO_VAL / B.RKAP_INVS_VALUE * 100) AS REALISASI_FISIK FROM 
        (
            SELECT COMPANY_CODE, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT COMPANY_CODE, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, COMPANY_CODE
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID, e.COMPANY_CODE
            FROM (select * from TX_RKAP_SUB_PROGRAM where is_deleted = 0) a
            JOIN (select * from TX_REAL_SUB_PROGRAM where is_deleted = 0) b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE b.REAL_SUBPRO_YEAR = '$get_tahun')
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, COMPANY_CODE)
            GROUP BY COMPANY_CODE, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY COMPANY_CODE
        ) A LEFT JOIN
        (
            SELECT COMPANY_CODE, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE
            FROM (SELECT COMPANY_CODE, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, RKAP_INVS_YEAR
            FROM (SELECT a.*, b.USER_ID, b.USER_BRANCH, c.COMPANY_CODE, c.BRANCH_NAME
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
            WHERE a.IS_DELETED =0  
            ORDER BY a.RKAP_INVS_ID DESC)
            -- WHERE RKAP_INVS_YEAR ='$get_tahun'
            GROUP BY COMPANY_CODE, RKAP_INVS_YEAR)
            GROUP BY COMPANY_CODE
        ) B ON A.COMPANY_CODE = B.COMPANY_CODE");
        

        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['COMPANY_CODE' => 01,'REALISASI_FISIK' => "0"];
            return $data;
        }
    }

    public function all_kpi_realisasi_program() {
        $query = $this->db->query("SELECT  sum(jml1) as jml1,sum(jml2) as jml2,(sum(jml2) - sum(jml1)) AS belumberjalan, (sum(jml1) / sum(jml2) * 100) AS KPI_REALISASI_PROGRAM FROM   
        (    
            select BRANCH_ID as bi1, count(RKAP_INVS_ID) as jml1 from (SELECT distinct c.BRANCH_ID,a.RKAP_INVS_ID
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2)
            group by BRANCH_ID
        ) A right JOIN
        (
           SELECT c.COMPANY_CODE,c.BRANCH_ID as bi2,count(a.RKAP_INVS_TITLE) as jml2
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            WHERE a.IS_DELETED =0
            GROUP BY c.BRANCH_ID,c.COMPANY_CODE
        ) B ON bi1=bi2");
            
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['COMPANY_CODE' => 01, 'KPI_REALISASI_PROGRAM' => "0"];
            return $data;
        }
    }

    public function all_kpi_realisasi_fisik($get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT (sum(trealisasi) / SUM(kontrak) * 100) as KPI_REALISASI_FISIK from (
        SELECT A.RKAP_INVS_ID,(A.RKAP_SUBPRO_CONTRACT_VALUE - NVL(B.trealisasi,0)) as kontrak,A.trealisasi FROM ( 
            SELECT a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')
            GROUP BY a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) A
        LEFT JOIN (
            SELECT a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) as trealisasi
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < TO_CHAR(sysdate,'YYYY')
            GROUP BY a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
        ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['COMPANY_CODE' => 01,'KPI_REALISASI_FISIK' => "0"];
            return $data;
        }
        
    }

    public function all_status_prog_investasi_berjalan() {
        $query = $this->db->query("SELECT COMPANY_CODE, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS != 2)
            GROUP BY COMPANY_CODE");
            
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['COMPANY_CODE' => 01, 'REAL_SUBPRO_STATUS' => "0"];
            return $data;
        }
    }

    public function all_status_prog_investasi_belum_berjalan() {
        $query = $this->db->query("SELECT COMPANY_CODE, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS = 2)
            GROUP BY COMPANY_CODE");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['COMPANY_CODE' => 01, 'REAL_SUBPRO_STATUS' => "0"];
            return $data;
        }
    }

    public function all_posisi_prog_investasi() {
        $query = $this->db->query("SELECT  COMPANY_CODE, count(COMPANY_CODE) CO, POSISI, COUNT(RKAP_INVS_POS) AS JUMLAH_POSISI, RKAP_INVS_POS, POSPROG_ID
            FROM(SELECT a.RKAP_INVS_POS, c.COMPANY_CODE, d.POSPROG_NAME as POSISI, d.POSPROG_ID
            FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a 
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN TM_POSITION_PROGRAM d ON a.RKAP_INVS_POS = d.POSPROG_ID
            WHERE a.IS_DELETED =0 
            ORDER BY a.RKAP_INVS_ID DESC)
            GROUP BY COMPANY_CODE, POSISI, RKAP_INVS_POS, POSPROG_ID
            ORDER BY JUMLAH_POSISI DESC");
    
        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['COMPANY_CODE' => 01, 'JUMLAH_POSISI' => "0"];
            return $data;
        }
        
    }

    public function all_kendala_prog_investasi() {
        $query = $this->db->query("SELECT company_code,count(company_code) as TOTAL_KENDALA,CONTRAINTS_NAME from (
            SELECT A.company_code,A.RKAP_INVS_YEAR,A.RKAP_INVS_TITLE,A.rkap_invs_value,A.RKAP_SUBPRO_TITTLE,C.CONTRAINTS_NAME,total from 
                        (
                        SELECT c.company_code,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.rkap_invs_value,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID,sum(e.real_subpro_val) as total,max(e.REAL_SUBPRO_ID) as idnn
                        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE is_deleted = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                        JOIN (SELECT * FROM TX_REAL_SUB_PROGRAM WHERE is_deleted = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                        WHERE a.IS_DELETED =0
                        group by c.company_code,a.RKAP_INVS_YEAR,a.RKAP_INVS_TITLE,a.rkap_invs_value,d.RKAP_SUBPRO_TITTLE,e.RKAP_SUBPRO_ID
                        ) A 
                        LEFT JOIN TX_REAL_SUB_PROGRAM B ON A.idnn = B.REAL_SUBPRO_ID
                        LEFT JOIN TM_CONTRAINTS C ON B.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID
                        )
        GROUP by company_code,CONTRAINTS_NAME
        order by TOTAL_KENDALA desc");
        
        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['COMPANY_CODE' => 01, 'TOTAL_KENDALA' => "0"];
            return $data;
        }
        
    }

    //GAUGE KRITIS
    public function gauge_kritis_1($id_branch, $get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT BRANCH_ID,count(BRANCH_NAME) as DEVIASI FROM (  
        SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.BRANCH_ID = $id_branch
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 0 AND 70 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till70)
        GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = (object)['DEVIASI' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_2($id_branch, $get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT BRANCH_ID,count(BRANCH_NAME) as DEVIASI FROM (  
        SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.BRANCH_ID = $id_branch
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 71 AND 100 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till100)
        GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = (object)['DEVIASI' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT BRANCH_ID,count(BRANCH_NAME) as DEVIASI FROM (  
        SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.BRANCH_ID = $id_branch
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') < TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE AA.REAL_SUBPRO_PERCENT < 100)
        GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = (object)['DEVIASI' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_1_p($is_pusat, $get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT BRANCH_ID,count(BRANCH_NAME) as DEVIASI FROM (  
        SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI FROM (
        SELECT c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.IS_PUSAT = $is_pusat
        GROUP BY c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 0 AND 70 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till70)
        GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['DEVIASI' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_2_p($is_pusat, $get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT BRANCH_ID,count(BRANCH_NAME) as DEVIASI FROM (  
        SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI FROM (
        SELECT c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.IS_PUSAT = $is_pusat
        GROUP BY c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 71 AND 100 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till100)
        GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['DEVIASI' => "0"];
            return $data;
        }
        
    }

   public function gauge_kritis_3_p($is_pusat, $get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT IS_PUSAT,count(IS_PUSAT) as DEVIASI FROM (  
        SELECT AA.BRANCH_ID,AA.IS_PUSAT,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI FROM (
        SELECT c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.IS_PUSAT = $is_pusat
        GROUP BY c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') < TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE AA.REAL_SUBPRO_PERCENT < 100)
        GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['DEVIASI' => "0"];
            return $data;
        }
        
    }

    public function gauge_meter_p($is_pusat, $get_bulan) {
        // $query = $this->db->query("SELECT IS_PUSAT, COUNT(DEVIASI) AS ABC FROM 
        //     (
        //         SELECT IS_PUSAT, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, REALISASI, TARGET, (REALISASI - TARGET) AS DEVIASI FROM 
        //             (
        //                 SELECT IS_PUSAT, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, MAX(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, MAX(REAL_SUBPRO_PERCENT_TOT) AS REALISASI, MAX(SUBPRO_VALUE) AS TARGET FROM
        //                     (
        //                         SELECT f.IS_PUSAT, f.BRANCH_NAME, B.RKAP_SUBPRO_ID, a.RKAP_INVS_TITLE, a.RKAP_INVS_VALUE, b.RKAP_SUBPRO_TITTLE, b.RKAP_SUBPRO_CONTRACT_VALUE, c.REAL_SUBPRO_VAL, TO_CHAR(c.REAL_SUBPRO_DATE, 'YYYY-MM') AS TGL_REALISASI, TO_CHAR(d.SUBPRO_YEARS, 'YYYY-MM') AS TGL_TARGET, c.REAL_SUBPRO_PERCENT_TOT, d.SUBPRO_VALUE
        //                         FROM TX_RKAP_INVESTATION a
        //                             LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
        //                             LEFT JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
        //                             LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY d ON b.RKAP_SUBPRO_ID = d.RKAP_SUBPRO_ID
        //                             LEFT JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID 
        //                             LEFT JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
        //                             WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0
        //                     )
        //                 WHERE TGL_REALISASI <= '$get_bulan' AND TGL_TARGET <= '$get_bulan' 
        //                 GROUP BY IS_PUSAT, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE
        //             )
        //         -- WHERE REALISASI BETWEEN 0 AND 70
        //     ) 
        //     WHERE IS_PUSAT = $is_pusat
        //     GROUP BY IS_PUSAT");

        $query = $this->db->query("SELECT COUNT(d.RKAP_SUBPRO_ID) AS ABC
            FROM TR_BRANCH a
            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
            LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON b.USER_ID = c.RKAP_INVS_USER_ID
            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            WHERE c.IS_DELETED= 0 and d.IS_DELETED = 0 and a.IS_PUSAT = $is_pusat");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "9"];
            return $data;
        }
        
    }

    public function gauge_meter($id_branch, $get_bulan) {
        // $query = $this->db->query("SELECT BRANCH_ID, COUNT(DEVIASI) AS ABC FROM 
        //     (
        //         SELECT BRANCH_ID, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, REALISASI, TARGET, (REALISASI - TARGET) AS DEVIASI FROM 
        //             (
        //                 SELECT BRANCH_ID, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, MAX(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, MAX(REAL_SUBPRO_PERCENT_TOT) AS REALISASI, MAX(SUBPRO_VALUE) AS TARGET FROM
        //                     (
        //                         SELECT f.BRANCH_ID, f.BRANCH_NAME, B.RKAP_SUBPRO_ID, a.RKAP_INVS_TITLE, a.RKAP_INVS_VALUE, b.RKAP_SUBPRO_TITTLE, b.RKAP_SUBPRO_CONTRACT_VALUE, c.REAL_SUBPRO_VAL, TO_CHAR(c.REAL_SUBPRO_DATE, 'YYYY-MM') AS TGL_REALISASI, TO_CHAR(d.SUBPRO_YEARS, 'YYYY-MM') AS TGL_TARGET, c.REAL_SUBPRO_PERCENT_TOT, d.SUBPRO_VALUE
        //                         FROM TX_RKAP_INVESTATION a
        //                             LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
        //                             LEFT JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
        //                             LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY d ON b.RKAP_SUBPRO_ID = d.RKAP_SUBPRO_ID
        //                             LEFT JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID 
        //                             LEFT JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
        //                             WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0
        //                     )
        //                 WHERE TGL_REALISASI <= '$get_bulan' AND TGL_TARGET <= '$get_bulan' 
        //                 GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE
        //             )
        //         -- WHERE REALISASI BETWEEN 0 AND 70
        //     ) 
        //     WHERE BRANCH_ID = $id_branch
        //     GROUP BY BRANCH_ID");

        $query = $this->db->query("SELECT a.USER_BRANCH AS BRANCH_ID, COUNT(c.RKAP_SUBPRO_ID) AS ABC 
            FROM TM_USERS a
            LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') b ON a.USER_ID = b.RKAP_INVS_USER_ID
            LEFT JOIN TX_RKAP_SUB_PROGRAM c ON b.RKAP_INVS_ID = c.RKAP_SUBPRO_INVS_ID
            WHERE b.IS_DELETED= 0 and c.IS_DELETED = 0 and a.USER_BRANCH = $id_branch
            GROUP BY a.USER_BRANCH");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_meter_all($get_bulan) {
        // $query = $this->db->query("SELECT COMPANY_CODE, COUNT(DEVIASI) AS ABC FROM 
        //     (
        //         SELECT COMPANY_CODE, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, REALISASI, TARGET, (REALISASI - TARGET) AS DEVIASI FROM 
        //             (
        //                 SELECT COMPANY_CODE, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, MAX(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, MAX(REAL_SUBPRO_PERCENT_TOT) AS REALISASI, MAX(SUBPRO_VALUE) AS TARGET FROM
        //                     (
        //                         SELECT f.COMPANY_CODE, f.BRANCH_NAME, B.RKAP_SUBPRO_ID, a.RKAP_INVS_TITLE, a.RKAP_INVS_VALUE, b.RKAP_SUBPRO_TITTLE, b.RKAP_SUBPRO_CONTRACT_VALUE, c.REAL_SUBPRO_VAL, TO_CHAR(c.REAL_SUBPRO_DATE, 'YYYY-MM') AS TGL_REALISASI, TO_CHAR(d.SUBPRO_YEARS, 'YYYY-MM') AS TGL_TARGET, c.REAL_SUBPRO_PERCENT_TOT, d.SUBPRO_VALUE
        //                         FROM TX_RKAP_INVESTATION a
        //                             LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
        //                             LEFT JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
        //                             LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY d ON b.RKAP_SUBPRO_ID = d.RKAP_SUBPRO_ID
        //                             LEFT JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID 
        //                             LEFT JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
        //                             WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0
        //                     )
        //                 WHERE TGL_REALISASI <= '$get_bulan' AND TGL_TARGET <= '$get_bulan' 
        //                 GROUP BY COMPANY_CODE, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE
        //             )
        //         -- WHERE REALISASI BETWEEN 0 AND 70
        //     ) 
        //     -- WHERE COMPANY_CODE = 1
        //     GROUP BY COMPANY_CODE");

        $query = $this->db->query("SELECT COUNT(c.RKAP_SUBPRO_ID) AS ABC 
            FROM TM_USERS a
            LEFT JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') b ON a.USER_ID = b.RKAP_INVS_USER_ID
            LEFT JOIN TX_RKAP_SUB_PROGRAM c ON b.RKAP_INVS_ID = c.RKAP_SUBPRO_INVS_ID
            WHERE b.IS_DELETED= 0 and c.IS_DELETED = 0 ");
        
        if (count($query->row()) > 0 ) {
            return $query->row();
        } else {
            $data = ['ABC' => "9"];
            return $data;
        }
        
    }

    public function gauge_kritis_1_all($get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT count(*) as DEVIASI FROM (  
        SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 0 AND 70 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till70)");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['DEVIASI' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_2_all($get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT count(*) as DEVIASI FROM (  
        SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 71 AND 100 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till100)");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['DEVIASI' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_3_all($get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT count(*) as DEVIASI FROM (  
        SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') < TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE AA.REAL_SUBPRO_PERCENT < 100)");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['DEVIASI' => "0"];
            return $data;
        }
        
    }

    public function d_gauge_kritis_1_p($is_pusat, $get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI, AA.RKAP_SUBPRO_ID FROM (
        SELECT c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.IS_PUSAT = $is_pusat
        GROUP BY c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 0 AND 70 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till70");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_2_p($is_pusat, $get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI, AA.RKAP_SUBPRO_ID FROM (
        SELECT c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.IS_PUSAT = $is_pusat
        GROUP BY c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 71 AND 100 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_3_p($is_pusat, $get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI, AA.RKAP_SUBPRO_ID FROM (
        SELECT c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.IS_PUSAT = $is_pusat
        GROUP BY c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') < TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE AA.REAL_SUBPRO_PERCENT < 100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_1_all($get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI, AA.RKAP_SUBPRO_ID FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 0 AND 70 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till70");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_2_all($get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI, AA.RKAP_SUBPRO_ID FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 71 AND 100 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_3_all($get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI, AA.RKAP_SUBPRO_ID FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') < TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE AA.REAL_SUBPRO_PERCENT < 100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_1($id_branch, $get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI, AA.RKAP_SUBPRO_ID FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.BRANCH_ID = $id_branch
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 0 AND 70 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till70");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_2($id_branch, $get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI, AA.RKAP_SUBPRO_ID FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.BRANCH_ID = $id_branch
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') >= TO_CHAR(CURRENT_DATE, 'YYYY-MM') AND TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') <= TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE BB.SUBPRO_VALUE BETWEEN 71 AND 100 AND (AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) <= $deviasi_till100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,AA.RKAP_INVS_TITLE,AA.RKAP_SUBPRO_TITTLE,AA.RKAP_INVS_VALUE,AA.RKAP_SUBPRO_CONTRACT_VALUE,AA.REAL_SUBPRO_PERCENT,AA.REAL_SUBPRO_VAL,BB.SUBPRO_VALUE,(AA.REAL_SUBPRO_PERCENT - BB.SUBPRO_VALUE) as DEVIASI, AA.RKAP_SUBPRO_ID FROM (
        SELECT c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,max(e.REAL_SUBPRO_PERCENT_TOT) as REAL_SUBPRO_PERCENT,sum(e.REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL
        FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.BRANCH_ID = $id_branch
        GROUP BY c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_VALUE, d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_END_REAL,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) AA
        JOIN (
            SELECT A.RKAP_SUBPRO_ID,B.SUBPRO_MON,B.SUBPRO_VALUE FROM (  
            SELECT a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL,max(b.SUBPRO_MON) as IDS FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            WHERE TO_CHAR(a.RKAP_SUBPRO_END_REAL, 'YYYY-MM') < TO_CHAR(CURRENT_DATE, 'YYYY-MM')
            GROUP BY a.RKAP_SUBPRO_ID,a.RKAP_SUBPRO_END_REAL) A
            JOIN TX_RKAP_SUB_PROGRAM_MONTHLY B
        ON A.IDS = B.SUBPRO_MON) BB
        ON AA.RKAP_SUBPRO_ID = BB.RKAP_SUBPRO_ID
        WHERE AA.REAL_SUBPRO_PERCENT < 100");
        
            return $query->result();
        
    }

    public function get_gauge_value($get_tahun) {

        $query = $this->db->query("SELECT A.BRANCH_ID,  B.NILAI_GAUGE FROM
            (
                SELECT * FROM TR_BRANCH
            ) A
            LEFT JOIN 
            (
                SELECT A.BRANCH_ID,(A.REAL_SUBPRO_VAL / B.RKAP_INVS_VALUE * 100) AS NILAI_GAUGE FROM 
                (
                    SELECT BRANCH_ID, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
                    FROM (SELECT BRANCH_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID, e.BRANCH_ID
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND c.IS_DELETED =0 AND b.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY'))
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
                    GROUP BY BRANCH_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID
                ) A LEFT JOIN
                (
                    SELECT BRANCH_ID, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE
                    FROM (SELECT BRANCH_ID, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, RKAP_INVS_YEAR
                    FROM (SELECT a.*, b.USER_ID, b.USER_BRANCH, c.BRANCH_ID, c.BRANCH_NAME
                    FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                    JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
                    JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
                    WHERE a.IS_DELETED =0  
                    ORDER BY a.RKAP_INVS_ID DESC)
                    -- WHERE RKAP_INVS_YEAR ='$get_tahun'
                    GROUP BY BRANCH_ID, RKAP_INVS_YEAR)
                    GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            )B ON A.BRANCH_ID = B.BRANCH_ID");
            return $query->result();
    }

    //backup gauge value
    public function backup_gauge_value($get_tahun) {

        $query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.NILAI_RKAP, B.REALISASI, B.NILAI_GAUGE FROM
            (
                SELECT * FROM TR_BRANCH
            ) A
            LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, NILAI_RKAP, REALISASI, (REALISASI / NILAI_RKAP * 100) AS NILAI_GAUGE
                FROM(SELECT BRANCH_ID, BRANCH_NAME, SUM(RKAP_INVS_VALUE) AS NILAI_RKAP, SUM(REALISASI) AS REALISASI
                FROM(SELECT a.RKAP_INVS_ID, a.RKAP_INVS_VALUE, SUM(c.REAL_SUBPRO_VAL) AS REALISASI, e.BRANCH_ID, e.BRANCH_NAME 
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                LEFT JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
                LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
                LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 and c.REAL_SUBPRO_YEAR = $get_tahun
                GROUP BY a.RKAP_INVS_ID, a.RKAP_INVS_VALUE, a.RKAP_INVS_COST_REQ, e.BRANCH_ID, e.BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME)
            )B ON A.BRANCH_ID = B.BRANCH_ID");
            return $query->result();
    }

    // report kpi realisasi program
    public function sipil_rkap() {

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_PROGRAM FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (SELECT c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0  AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC");
        return $query->result();
    }

    public function sipil_berjalan() {

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_PROGRAM FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (select BRANCH_ID,BRANCH_NAME, count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2  AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7'))
                group by BRANCH_ID,BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC");
        return $query->result();
    }

    public function peralatan_rkap() {

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_PROGRAM FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (SELECT c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0  AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC");
        return $query->result();
    }

    public function peralatan_berjalan() {

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_PROGRAM FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (select BRANCH_ID,BRANCH_NAME, count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2  AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10'))
                group by BRANCH_ID,BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC");
        return $query->result();
    }

    public function non_fisik_rkap() {

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_PROGRAM FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (SELECT c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0  AND a.RKAP_INVS_ASSETS = 8
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC");
        return $query->result();
    }

    public function non_fisik_berjalan() {

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_PROGRAM FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (select BRANCH_ID,BRANCH_NAME, count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2  AND a.RKAP_INVS_ASSETS = 8)
                group by BRANCH_ID,BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC");
        return $query->result();
    }

    public function total_report_rkap() {
        $query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_PROGRAM FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (SELECT c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC");
        return $query->result();
    }

    public function total_report_berjalan() {
        $query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_PROGRAM FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (select BRANCH_ID,BRANCH_NAME, count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2)
                group by BRANCH_ID,BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC");
        return $query->result();
    }

    public function jumlah_sipil_rkap() {
        $query =$this->db->query("SELECT sum(TOTAL_PROGRAM) as TOTAL_PROGRAM FROM (SELECT c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT IN ('1', '0')
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME)");
        return $query->result();
    }

    public function jumlah_sipil_berjalan() {
        $query =$this->db->query("SELECT sum(TOTAL_PROGRAM) as TOTAL_PROGRAM from (select count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT IN ('1', '0'))
                group by BRANCH_ID,BRANCH_NAME)");
        return $query->result();
    }

    public function jumlah_peralatan_rkap() {
        $query =$this->db->query("SELECT sum(TOTAL_PROGRAM) as TOTAL_PROGRAM FROM (SELECT c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT IN ('1', '0')
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME)");
        return $query->result();
    }

    public function jumlah_peralatan_berjalan() {
        $query =$this->db->query("SELECT sum(TOTAL_PROGRAM) as TOTAL_PROGRAM from (select count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT IN ('1', '0'))
                group by BRANCH_ID,BRANCH_NAME)");
        return $query->result();
    }

    public function jumlah_non_sipil_rkap() {
        $query =$this->db->query("SELECT sum(TOTAL_PROGRAM) as TOTAL_PROGRAM FROM (SELECT c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8 AND IS_PUSAT IN ('1', '0')
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME)");
        return $query->result();
    }

    public function jumlah_non_sipil_berjalan() {
        $query =$this->db->query("SELECT sum(TOTAL_PROGRAM) as TOTAL_PROGRAM from (select count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2 AND a.RKAP_INVS_ASSETS = 8 AND IS_PUSAT IN ('1', '0'))
                group by BRANCH_ID,BRANCH_NAME)");
        return $query->result();
    }

    public function jumlah_total_rkap() {
        $query = $this->db->query("SELECT sum(TOTAL_PROGRAM) as TOTAL_PROGRAM FROM (SELECT c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0 AND IS_PUSAT IN ('1', '0')
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME)");
        return $query->result();
    }

    public function jumlah_total_berjalan() {
        $query = $this->db->query("SELECT sum(TOTAL_PROGRAM) as TOTAL_PROGRAM from (select count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2 AND IS_PUSAT IN ('1', '0'))
                group by BRANCH_ID,BRANCH_NAME)");
        return $query->result();
    }

    public function persentase_berjalan() {
        $query = $this->db->query("SELECT R1.BRANCH_ID,R2.BRANCH_NAME,(NVL(R1.jml1, 0)/R2.jml2*100) as PERSENTASE_BERJALAN from (SELECT A.BRANCH_ID, B.TOTAL_PROGRAM as jml1 FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (select BRANCH_ID,BRANCH_NAME, count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2 AND IS_PUSAT IN ('1', '0'))
                group by BRANCH_ID,BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC) R1 
join 
(SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_PROGRAM as jml2 FROM
                (SELECT g.BRANCH_ID,g.BRANCH_NAME FROM TR_BRANCH g)A 
                LEFT JOIN 
                (SELECT c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0 
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME) B
                ON A.BRANCH_ID = B.BRANCH_ID
                ORDER BY A.BRANCH_ID ASC) R2 on R1.BRANCH_ID = R2.BRANCH_ID");
        return $query->result();
    }

    public function persentase_berjalan_footer() {
        $query = $this->db->query("SELECT (R1.Tm1 /R2.Tm2*100) as persentase_berjalan from (SELECT IS_PUSAT as ip1,sum(TOTAL_PROGRAM) as Tm1 from (select IS_PUSAT,count(RKAP_INVS_ID) as TOTAL_PROGRAM from (SELECT distinct c.BRANCH_ID,c.IS_PUSAT,c.BRANCH_NAME,a.RKAP_INVS_ID
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND e.REAL_SUBPRO_STATUS <> 2 AND IS_PUSAT IN ('1', '0'))
                group by BRANCH_ID,BRANCH_NAME,IS_PUSAT)
                group by IS_PUSAT) R1 

                join 

                (SELECT IS_PUSAT as ip2,sum(TOTAL_PROGRAM) as Tm2 FROM (SELECT c.IS_PUSAT,c.BRANCH_ID,count(a.RKAP_INVS_TITLE) as TOTAL_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                WHERE a.IS_DELETED =0 AND IS_PUSAT IN ('1', '0')
                GROUP BY c.BRANCH_ID,c.BRANCH_NAME,c.IS_PUSAT)group by IS_PUSAT) R2 on R1.ip1 = R2.ip2");
        return $query->result();
    }

    // REKAPITULASI KPI REALISASI FISIK

    public function realisasi_sipil_berjalan($get_bulan, $get_tahun) {

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_REALISASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7'))
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                GROUP BY BRANCH_ID, BRANCH_NAME
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_peralatan_berjalan($get_bulan, $get_tahun) {

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_REALISASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10'))
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                GROUP BY BRANCH_ID, BRANCH_NAME
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_non_fisik_berjalan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_REALISASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8)
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                GROUP BY BRANCH_ID, BRANCH_NAME
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_total_report_berjalan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_REALISASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun')
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                GROUP BY BRANCH_ID, BRANCH_NAME
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function jumlah_realisasi_sipil_berjalan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT IN ('1', '0'))
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)");
        return $query->result();
    }

    public function jumlah_realisasi_peralatan_berjalan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT IN ('1', '0'))
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)");
        return $query->result();
    }

    public function jumlah_realisasi_non_fisik_berjalan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8 AND IS_PUSAT IN ('1', '0'))
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)");
        return $query->result();
    }

    public function jumlah_realisasi_total_report_berjalan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query = $this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND IS_PUSAT IN ('1', '0'))
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)");
        return $query->result();
    }

    public function kontrak_sipil_berjalan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,BB.TOTAL_NILAI_CONTRACT FROM TR_BRANCH AA 
        LEFT JOIN (
            SELECT BRANCH_ID,SUM(kontrak) as TOTAL_NILAI_CONTRACT from (
                SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak FROM ( 
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')) A
                LEFT JOIN (
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')
                    GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
                GROUP BY BRANCH_ID) BB
        ON AA.BRANCH_ID = BB.BRANCH_ID");
        return $query->result();
    }

    public function kontrak_peralatan_berjalan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,BB.TOTAL_NILAI_CONTRACT FROM TR_BRANCH AA 
        LEFT JOIN (
            SELECT BRANCH_ID,SUM(kontrak) as TOTAL_NILAI_CONTRACT from (
                SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak FROM ( 
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')) A
                LEFT JOIN (
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')
                    GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
                GROUP BY BRANCH_ID) BB
        ON AA.BRANCH_ID = BB.BRANCH_ID");
        return $query->result();
    }

    public function kontrak_non_fisik_berjalan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,BB.TOTAL_NILAI_CONTRACT FROM TR_BRANCH AA 
        LEFT JOIN (
            SELECT BRANCH_ID,SUM(kontrak) as TOTAL_NILAI_CONTRACT from (
                SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak FROM ( 
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8) A
                LEFT JOIN (
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun AND a.RKAP_INVS_ASSETS = 8
                    GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
                GROUP BY BRANCH_ID) BB
        ON AA.BRANCH_ID = BB.BRANCH_ID");
        return $query->result();
    }

    public function kontrak_total_report_berjalan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,BB.TOTAL_NILAI_CONTRACT FROM TR_BRANCH AA 
        LEFT JOIN (
            SELECT BRANCH_ID,SUM(kontrak) as TOTAL_NILAI_CONTRACT from (
                SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak FROM ( 
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    WHERE a.IS_DELETED =0) A
                LEFT JOIN (
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun
                    GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
                GROUP BY BRANCH_ID) BB
        ON AA.BRANCH_ID = BB.BRANCH_ID");
        return $query->result();
    }

    public function jumlah_kontrak_sipil_berjalan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT sum(TOTAL_NILAI_CONTRACT) as TOTAL_NILAI_CONTRACT from(
            SELECT BRANCH_ID,SUM(kontrak) as TOTAL_NILAI_CONTRACT from (
                        SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak FROM ( 
                            SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                            FROM ($whq) a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND c.IS_PUSAT IN ('1', '0')) A
                        LEFT JOIN (
                            SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                            FROM ($whq) a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                            WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND c.IS_PUSAT IN ('1', '0')
                            GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                        ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
                        GROUP BY BRANCH_ID)");
        return $query->result();
    }

    public function jumlah_kontrak_peralatan_berjalan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT sum(TOTAL_NILAI_CONTRACT) as TOTAL_NILAI_CONTRACT from(
            SELECT BRANCH_ID,SUM(kontrak) as TOTAL_NILAI_CONTRACT from (
                        SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak FROM ( 
                            SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                            FROM ($whq) a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND c.IS_PUSAT IN ('1', '0')) A
                        LEFT JOIN (
                            SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                            FROM ($whq) a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                            WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND c.IS_PUSAT IN ('1', '0')
                            GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                        ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
                        GROUP BY BRANCH_ID)");
        return $query->result();
    }

    public function jumlah_kontrak_non_fisik_berjalan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT sum(TOTAL_NILAI_CONTRACT) as TOTAL_NILAI_CONTRACT from(
    SELECT BRANCH_ID,SUM(kontrak) as TOTAL_NILAI_CONTRACT from (
                SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak FROM ( 
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8 AND c.IS_PUSAT IN ('1', '0')) A
                LEFT JOIN (
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun AND a.RKAP_INVS_ASSETS = 8 AND c.IS_PUSAT IN ('1', '0')
                    GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
                GROUP BY BRANCH_ID)");
        return $query->result();
    }

    public function jumlah_kontrak_total_report_berjalan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query = $this->db->query("SELECT sum(TOTAL_NILAI_CONTRACT) as TOTAL_NILAI_CONTRACT from(
            SELECT BRANCH_ID,SUM(kontrak) as TOTAL_NILAI_CONTRACT from (
                        SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak FROM ( 
                            SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                            FROM ($whq) a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            WHERE a.IS_DELETED =0 AND c.IS_PUSAT IN ('1', '0')) A
                        LEFT JOIN (
                            SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                            FROM ($whq) a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                            WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun and c.IS_PUSAT IN ('1', '0')
                            GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                        ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID)
                        GROUP BY BRANCH_ID)");
        return $query->result();
    }

    public function fisik_persentase_berjalan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query = $this->db->query("SELECT AA.BRANCH_ID,AA.BRANCH_NAME,BB.PERSENTASE FROM TR_BRANCH AA 
        LEFT JOIN (
            SELECT BRANCH_ID,(sum(trealisasi) / SUM(kontrak)) * 100 as PERSENTASE from (
                SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak,NVL(C.trealisasi2,0) as trealisasi FROM ( 
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    WHERE a.IS_DELETED =0) A
                LEFT JOIN (
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun
                    GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID
                LEFT JOIN (
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi2
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR = $get_tahun and e.REAL_SUBPRO_MONTH <= $get_bulan
                    GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) C
                ON A.RKAP_SUBPRO_ID = C.RKAP_SUBPRO_ID)
                GROUP BY BRANCH_ID
                having sum(kontrak) > 0) BB
        ON AA.BRANCH_ID = BB.BRANCH_ID");
        return $query->result();
    }

    public function fisik_persentase_berjalan_footer($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query = $this->db->query("SELECT (sum(tr) / sum(ko)) * 100 as PERSENTASE FROM TR_BRANCH AA 
        LEFT JOIN (
            SELECT BRANCH_ID,sum(trealisasi) tr, SUM(kontrak) ko from (
                SELECT A.BRANCH_ID,A.RKAP_INVS_ID,(NVL(A.RKAP_SUBPRO_CONTRACT_VALUE,0) - NVL(B.trealisasi,0)) as kontrak,NVL(C.trealisasi2,0) as trealisasi FROM ( 
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    WHERE a.IS_DELETED =0) A
                LEFT JOIN (
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR < $get_tahun
                    GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) B
                ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID
                LEFT JOIN (
                    SELECT c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE,sum(NVL(e.REAL_SUBPRO_VAL,0)) - sum(NVL(e.REAL_SUBPRO_COST,0)) as trealisasi2
                    FROM ($whq) a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND e.REAL_SUBPRO_YEAR = $get_tahun and e.REAL_SUBPRO_MONTH <= $get_bulan
                    GROUP BY c.BRANCH_ID,a.RKAP_INVS_ID, d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_VALUE) C
                ON A.RKAP_SUBPRO_ID = C.RKAP_SUBPRO_ID
                )
                GROUP BY BRANCH_ID) BB
        ON AA.BRANCH_ID = BB.BRANCH_ID");
        return $query->result();
    }

    // footer anak perusahaan excel
    public function jumlah_realisasi_sipil_berjalan_2($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT = 2)
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)");
        return $query->result();
    }

    public function jumlah_realisasi_peralatan_berjalan_2($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT = 2)
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)");
        return $query->result();
    }

    public function jumlah_realisasi_non_fisik_berjalan_2($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8 AND IS_PUSAT = 2)
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)");
        return $query->result();
    }

    public function jumlah_realisasi_total_report_berjalan_2($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query = $this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND IS_PUSAT = 2)
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)");
        return $query->result();
    }

    public function jumlah_kontrak_sipil_berjalan_2($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT SUM(NILAI_KONTRAK) AS TOTAL_NILAI_CONTRACT
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, PERCEN_VALUE, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                FROM (SELECT e.IS_PUSAT ,a.RKAP_INVS_ID, b.RKAP_SUBPRO_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, c.SUBPRO_VALUE, TO_CHAR(c.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(c.SUBPRO_YEARS, 'YYYY') AS TAHUN, 
                RKAP_SUBPRO_REAL_BEFORE, (CASE 
                                        WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                        ELSE
                                        RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    ) AS PERSENTASE_BEFORE
                FROM ($whq) a
                LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
                LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
                LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID 
                WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND c.IS_ADDENDUM = 0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT = 2)
                WHERE TAHUN = $get_tahun
                GROUP BY IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE)))");
        return $query->result();
    }

    public function jumlah_kontrak_peralatan_berjalan_2($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query =$this->db->query("SELECT SUM(NILAI_KONTRAK) AS TOTAL_NILAI_CONTRACT
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, PERCEN_VALUE, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                FROM (SELECT e.IS_PUSAT ,a.RKAP_INVS_ID, b.RKAP_SUBPRO_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, c.SUBPRO_VALUE, TO_CHAR(c.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(c.SUBPRO_YEARS, 'YYYY') AS TAHUN, 
                RKAP_SUBPRO_REAL_BEFORE, (CASE 
                                        WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                        ELSE
                                        RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    ) AS PERSENTASE_BEFORE
                FROM ($whq) a
                LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
                LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
                LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID 
                WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND c.IS_ADDENDUM = 0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT = 2)
                WHERE TAHUN = $get_tahun
                GROUP BY IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE)))");
        return $query->result();
    }

    public function jumlah_kontrak_non_fisik_berjalan_2($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq

        $query =$this->db->query("SELECT SUM(NILAI_KONTRAK) AS TOTAL_NILAI_CONTRACT
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, PERCEN_VALUE, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                FROM (SELECT e.IS_PUSAT ,a.RKAP_INVS_ID, b.RKAP_SUBPRO_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, c.SUBPRO_VALUE, TO_CHAR(c.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(c.SUBPRO_YEARS, 'YYYY') AS TAHUN, 
                RKAP_SUBPRO_REAL_BEFORE, (CASE 
                                        WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                        ELSE
                                        RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    ) AS PERSENTASE_BEFORE
                FROM ($whq) a
                LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
                LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
                LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID 
                WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND c.IS_ADDENDUM = 0 AND a.RKAP_INVS_ASSETS = 8 AND IS_PUSAT = 2)
                WHERE TAHUN = $get_tahun
                GROUP BY IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE)))");
        return $query->result();
    }

    public function jumlah_kontrak_total_report_berjalan_2($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query = $this->db->query("SELECT SUM(NILAI_KONTRAK) AS TOTAL_NILAI_CONTRACT
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, PERCEN_VALUE, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE
                FROM (SELECT IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                FROM (SELECT e.IS_PUSAT ,a.RKAP_INVS_ID, b.RKAP_SUBPRO_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, c.SUBPRO_VALUE, TO_CHAR(c.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(c.SUBPRO_YEARS, 'YYYY') AS TAHUN, 
                RKAP_SUBPRO_REAL_BEFORE, (CASE 
                                        WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                        ELSE
                                        RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    ) AS PERSENTASE_BEFORE
                FROM ($whq) a
                LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
                LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
                LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID 
                WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND c.IS_ADDENDUM = 0 AND IS_PUSAT = 2)
                WHERE TAHUN = $get_tahun
                GROUP BY IS_PUSAT, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE)))");
        return $query->result();
    }

    public function fisik_persentase_berjalan_footer_2($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "select * from tx_rkap_investation_v where tahun = '".$get_tahun."'";
        }else{
            $whq = "select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y'";
        }
        //$whq
        $query = $this->db->query("SELECT (TOTAL_1 / TOTAL_2 * 100) AS PERSENTASE
        FROM(SELECT SUM(A.TOTAL_REALISASI) AS TOTAL_1, SUM(B.TOTAL_NILAI_CONTRACT) AS TOTAL_2 FROM
                ( 
                    SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN ($whq) c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND IS_PUSAT = 2)
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME 
                ) A LEFT JOIN 
                (
                    SELECT BRANCH_ID, SUM(NILAI_KONTRAK) AS TOTAL_NILAI_CONTRACT
                    FROM (SELECT BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, PERCEN_VALUE, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK
                    FROM (SELECT BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE
                    FROM (SELECT BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                    FROM (SELECT e.BRANCH_ID ,a.RKAP_INVS_ID, b.RKAP_SUBPRO_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, c.SUBPRO_VALUE, TO_CHAR(c.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(c.SUBPRO_YEARS, 'YYYY') AS TAHUN, 
                    RKAP_SUBPRO_REAL_BEFORE, (CASE 
                                        WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                        ELSE
                                        RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    ) AS PERSENTASE_BEFORE
                    FROM ($whq) a
                    LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                    LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
                    LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
                    LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID 
                    WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND c.IS_ADDENDUM = 0 AND IS_PUSAT = 2)
                    WHERE TAHUN = $get_tahun
                    GROUP BY BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE)))
                    GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID)");
        return $query->result();
    }

   // value modal
    public function value_fisik($get_bulan, $id_branch) {
        $query = $this->db->query("SELECT BRANCH_ID, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT BRANCH_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0)
            WHERE AA <= '$get_bulan' and branch_id = '$id_branch'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
            GROUP BY BRANCH_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY BRANCH_ID");

        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['id_branch' => $id_branch, 'REAL_SUBPRO_VAL' => "0"];
            return $data;
        }
    }

    public function value_fisik_p($get_bulan, $IS_PUSAT) {
        $query = $this->db->query("SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0)
            WHERE AA <= '$get_bulan' AND IS_PUSAT = '$IS_PUSAT'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['IS_PUSAT' => $IS_PUSAT, 'REAL_SUBPRO_VAL' => "0"];
            return $data;
        }
    }

    public function value_fisik_all($get_bulan) {
        $query = $this->db->query("SELECT COMPANY_CODE, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT COMPANY_CODE, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, COMPANY_CODE
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0)
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, COMPANY_CODE)
            GROUP BY COMPANY_CODE, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY COMPANY_CODE");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['REAL_SUBPRO_VAL' => "0"];
            return $data;
        }
    }

    public function value_program($id_branch) {
        $query = $this->db->query("SELECT BRANCH_ID, COUNT(REAL_SUBPRO_STATUS) AS TOTAL_PROGRAM
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND BRANCH_ID = '$id_branch' AND b.REAL_SUBPRO_STATUS != 2)
            GROUP BY BRANCH_ID");

        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['id_branch' => $id_branch, 'TOTAL_PROGRAM' => "0"];
            return $data;
        }
    }

    public function value_program_p($is_pusat) {
        $query = $this->db->query("SELECT IS_PUSAT, COUNT(REAL_SUBPRO_STATUS) AS TOTAL_PROGRAM
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID, e.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND IS_PUSAT = '$is_pusat' AND b.REAL_SUBPRO_STATUS != 2)
            GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'TOTAL_PROGRAM' => "0"];
            return $data;
        }
    }

    public function value_program_all() {
        $query = $this->db->query("SELECT COMPANY_CODE, COUNT(REAL_SUBPRO_STATUS) AS TOTAL_PROGRAM
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID, e.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2)
            GROUP BY COMPANY_CODE");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['TOTAL_PROGRAM' => "0"];
            return $data;
        }
    }

    public function value_realisasi($get_bulan, $id_branch, $get_tahun) {
        $query = $this->db->query("SELECT BRANCH_ID, SUM(REAL_SUBPRO_VAL) AS VALUE_REALISASI 
            FROM (SELECT BRANCH_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR = '$get_tahun')
            WHERE AA <= '$get_bulan' AND BRANCH_ID = '$id_branch'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
            GROUP BY BRANCH_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['id_branch' => $id_branch, 'VALUE_REALISASI' => "0"];
            return $data;
        }
    }

    public function value_realisasi_p($get_bulan, $is_pusat, $get_tahun) {
        $query = $this->db->query("SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS VALUE_REALISASI 
            FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR = '$get_tahun')
            WHERE AA <= '$get_bulan' AND IS_PUSAT = '$is_pusat'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'VALUE_REALISASI' => "0"];
            return $data;
        }
    }

    public function value_realisasi_all($get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT COMPANY_CODE, SUM(REAL_SUBPRO_VAL) AS VALUE_REALISASI 
            FROM (SELECT COMPANY_CODE, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, COMPANY_CODE
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR = '$get_tahun')
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, COMPANY_CODE)
            GROUP BY COMPANY_CODE, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY COMPANY_CODE");

        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['VALUE_REALISASI' => "0"];
            return $data;
        }
    }

}
