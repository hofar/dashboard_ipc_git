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
        $isi = array();
        $no = 0;
        // $id_rkap_selected = $branch_selected[0]->RKAP_INVS_ID;
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
         
         return $isi;
    }

    public function count_data() {
        $cek_user = $this->session->userdata('SESS_USER_BRANCH');
        $branch_selected = $this->rkap_model->all_percabang($cek_user);
        $count = 0;
        // $id_rkap_selected = $branch_selected[0]->RKAP_INVS_ID;
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
         
         return $count;
    }

    public function get_cabang(){
        $this->db->select('TR_BRANCH.*');
        $this->db->from('TR_BRANCH');
        // $this->db->where('BRANCH_ID', 10);
        $query = $this->db->get();
        // print_r($query); exit();

        return $query->result();
    }

    public function detail($id_branch) {
        $this->db->select('TR_BRANCH.*, TR_BRANCH.DISPLAY_NAME AS NAME_DISPLAY');
        $this->db->from('TR_BRANCH');
        $this->db->where('BRANCH_ID', $id_branch);
        $query = $this->db->get();
        return $query->row();

    }

    public function detail_status($id_status, $status) {
        $this->db->select('a.REAL_SUBPRO_VAL, a.REAL_SUBPRO_STATUS, b.STATUS_NAME,  c.CONTRAINTS_NAME, d.RKAP_SUBPRO_TITTLE, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_TYPE_ID, e.SUBPRO_TYPE_NAME, f.RKAP_INVS_TITLE, f.RKAP_INVS_VALUE');
        $this->db->from('TX_REAL_SUB_PROGRAM a');
        $this->db->join('TM_STATUS_PROGRAM b', 'a.REAL_SUBPRO_STATUS = b.STATUS_ID');
        $this->db->join('TM_CONTRAINTS c', 'a.REAL_SUBPRO_CONSTRAINTS = c.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM d', 'a.RKAP_SUBPRO_ID = d.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE e', 'd.RKAP_SUBPRO_TYPE_ID = e.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION f', 'd.RKAP_SUBPRO_INVS_ID = f.RKAP_INVS_ID');
        $this->db->join('TM_USERS g', 'f.RKAP_INVS_USER_ID = g.USER_ID');
        $this->db->join('TR_BRANCH h', 'g.USER_BRANCH = h.BRANCH_ID');
        $this->db->where('h.BRANCH_ID', $id_status);
        $this->db->where('f.IS_DELETED', 0);
        $this->db->where('b.IS_RESULT', $status);
        $this->db->order_by('a.REAL_SUBPRO_ID', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function detail_kendala($id_kendala, $kendala) {
        $this->db->select('a.REAL_SUBPRO_VAL, a.REAL_SUBPRO_STATUS, a.REAL_SUBPRO_CONSTRAINTS, b.STATUS_NAME,  c.CONTRAINTS_NAME, d.RKAP_SUBPRO_TITTLE, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_TYPE_ID, e.SUBPRO_TYPE_NAME, f.RKAP_INVS_TITLE, f.RKAP_INVS_VALUE');
        $this->db->from('TX_REAL_SUB_PROGRAM a');
        $this->db->join('TM_STATUS_PROGRAM b', 'a.REAL_SUBPRO_STATUS = b.STATUS_ID');
        $this->db->join('TM_CONTRAINTS c', 'a.REAL_SUBPRO_CONSTRAINTS = c.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM d', 'a.RKAP_SUBPRO_ID = d.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE e', 'd.RKAP_SUBPRO_TYPE_ID = e.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION f', 'd.RKAP_SUBPRO_INVS_ID = f.RKAP_INVS_ID');
        $this->db->join('TM_USERS g', 'f.RKAP_INVS_USER_ID = g.USER_ID');
        $this->db->join('TR_BRANCH h', 'g.USER_BRANCH = h.BRANCH_ID');
        $this->db->where('h.BRANCH_ID', $id_kendala);
        $this->db->where('f.IS_DELETED', 0);
        $this->db->where('a.REAL_SUBPRO_CONSTRAINTS', $kendala);
        $this->db->order_by('a.REAL_SUBPRO_ID', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function detail_posisi($id_posisi, $posisi) {
        $this->db->select('a.RKAP_INVS_ID, a.RKAP_INVS_TITLE, a.RKAP_INVS_COST_REQ, a.RKAP_INVS_VALUE, c.BRANCH_NAME, d.POSPROG_ID, d.POSPROG_NAME');
        $this->db->from('TX_RKAP_INVESTATION a');
        $this->db->join('TM_USERS b', 'a.RKAP_INVS_USER_ID = b.USER_ID');
        $this->db->join('TR_BRANCH c', 'b.USER_BRANCH = c.BRANCH_ID');
        $this->db->join('TM_POSITION_PROGRAM d', 'a.RKAP_INVS_POS = d.POSPROG_ID');
        $this->db->where('c.BRANCH_ID', $id_posisi);
        $this->db->where('a.IS_DELETED', 0);
        $this->db->where('a.RKAP_INVS_POS', $posisi);
        $query = $this->db->get();
        return $query->result();
    }

    public function detail_kontrak($id_kontrak) {
        $query = $this->db->query("SELECT a.RKAP_INVS_TITLE, a.RKAP_INVS_VALUE, a.RKAP_INVS_COST_REQ, c.REAL_SUBPRO_VAL, e.BRANCH_ID, e.BRANCH_NAME 
            FROM TX_RKAP_INVESTATION a
            LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
            LEFT JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
            LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
            LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND e.BRANCH_ID = '$id_kontrak'");
            return $query->result();
    }
    
    public function realisasi_fisik($id_branch, $get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT A.BRANCH_ID,(A.REAL_SUBPRO_VAL / B.RKAP_INVS_VALUE) AS REALISASI_FISIK FROM 
        (
            SELECT BRANCH_ID, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT BRANCH_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0)
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
            GROUP BY BRANCH_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY BRANCH_ID
        ) A LEFT JOIN
        (
            SELECT BRANCH_ID, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, RKAP_INVS_YEAR
            FROM (SELECT a.*, b.USER_ID, b.USER_BRANCH, c.BRANCH_ID, c.BRANCH_NAME
            FROM TX_RKAP_INVESTATION a
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
            WHERE a.IS_DELETED =0  
            ORDER BY a.RKAP_INVS_ID DESC)
            WHERE RKAP_INVS_YEAR <='$get_tahun'
            GROUP BY BRANCH_ID, RKAP_INVS_YEAR
        ) B ON A.BRANCH_ID = B.BRANCH_ID
        WHERE A.BRANCH_ID = $id_branch");

        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['id_branch' => $id_branch, 'REALISASI_FISIK' => "0"];
            return $data;
        }
    }

    public function kpi_realisasi_program($id_branch) {
        $query = $this->db->query("SELECT A.BRANCH_ID, (A.REAL_SUBPRO_STATUS / B. REAL_SUBPRO_STATUS * 100) AS KPI_REALISASI_PROGRAM FROM   
        (    
            SELECT BRANCH_ID, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS = 1)
            GROUP BY BRANCH_ID
        ) A LEFT JOIN
        (
            SELECT BRANCH_ID, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0)
            GROUP BY BRANCH_ID
        ) B ON A.BRANCH_ID = B.BRANCH_ID
        WHERE A.BRANCH_ID = $id_branch");

        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['id_branch' => $id_branch, 'KPI_REALISASI_PROGRAM' => "0"];
            return $data;
        }
    }

    public function kpi_realisasi_fisik($id_branch, $get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT A.BRANCH_ID, (A.REAL_SUBPRO_VAL / B.TOTAL_NILAI_CONTRACT) AS KPI_REALISASI_FISIK FROM
        (
            SELECT BRANCH_ID, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT BRANCH_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0)
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
            GROUP BY BRANCH_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY BRANCH_ID
        )A LEFT JOIN
        (
            SELECT BRANCH_ID,SUM(RKAP_SUBPRO_CONTRACT_VALUE) AS TOTAL_NILAI_CONTRACT
            FROM (SELECT a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(a.RKAP_SUBPRO_CONTRACT_DATE, 'YYYY') AS RKAP_SUBPRO_CONTRACT_DATE, 
            b.RKAP_INVS_ID, c.USER_ID, d.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_INVESTATION b ON a.RKAP_SUBPRO_INVS_ID = b.RKAP_INVS_ID
            JOIN TM_USERS c ON b.RKAP_INVS_USER_ID = c.USER_ID
            JOIN TR_BRANCH d ON c.USER_BRANCH = d.BRANCH_ID
            WHERE b.IS_DELETED =0)
            WHERE RKAP_SUBPRO_CONTRACT_DATE = '$get_tahun'
            GROUP BY BRANCH_ID 
        ) B ON A.BRANCH_ID = B.BRANCH_ID
        WHERE A.BRANCH_ID = $id_branch");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['id_branch' => $id_branch, 'KPI_REALISASI_FISIK' => "0"];
            return $data;
        }
    }

    public function status_prog_investasi_berjalan($id_branch) {
        $query = $this->db->query("SELECT BRANCH_ID, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS != 2)
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
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS = 2)
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
        FROM TX_RKAP_INVESTATION a 
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
        $query = $this->db->query("SELECT BRANCH_ID,  CONTRAINTS_NAME, COUNT(REAL_SUBPRO_CONSTRAINTS) AS TOTAL_KENDALA, REAL_SUBPRO_CONSTRAINTS
            FROM(SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_CONSTRAINTS, c.CONTRAINTS_NAME, f.BRANCH_ID
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TM_CONTRAINTS c ON b.REAL_SUBPRO_CONSTRAINTS = c.CONTRAINTS_ID
            JOIN TX_RKAP_INVESTATION d ON a.RKAP_SUBPRO_INVS_ID = d.RKAP_INVS_ID
            JOIN TM_USERS e ON d.RKAP_INVS_USER_ID = e.USER_ID
            JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
            WHERE d.IS_DELETED = 0)
            WHERE BRANCH_ID =$id_branch
            GROUP BY BRANCH_ID, CONTRAINTS_NAME, REAL_SUBPRO_CONSTRAINTS
            ORDER BY TOTAL_KENDALA DESC");
        
        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['id_branch' => $id_branch, 'TOTAL_KENDALA' => "0"];
            return $data;
        }
    }

   public function kontrak_kritis($id_branch) {
        $this->db->select_sum('c.REAL_SUBPRO_VAL');
        $this->db->select('a.RKAP_INVS_ID, a.RKAP_INVS_TITLE, a.RKAP_INVS_VALUE, a.RKAP_INVS_COST_REQ, e.BRANCH_ID, e.BRANCH_NAME');
        $this->db->from('TX_RKAP_INVESTATION a');
        $this->db->join('TX_RKAP_SUB_PROGRAM b', 'a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID', 'left');
        $this->db->join('TX_REAL_SUB_PROGRAM c', 'b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID', 'left');
        $this->db->join('TM_USERS d', 'a.RKAP_INVS_USER_ID = d.USER_ID', 'left');
        $this->db->join('TR_BRANCH e', 'd.USER_BRANCH = e.BRANCH_ID', 'left');
        $this->db->where('a.IS_DELETED', 0);
        $where = array('d.USER_BRANCH' => $id_branch);
        $this->db->where($where);
        $this->db->group_by('a.RKAP_INVS_ID, a.RKAP_INVS_TITLE, a.RKAP_INVS_VALUE, a.RKAP_INVS_COST_REQ, e.BRANCH_ID, e.BRANCH_NAME', 'desc');
        $this->db->order_by('a.RKAP_INVS_ID', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function list_prog_investasi_posisi($id_branch, $posisi="", $get_bulan) {
        if ($posisi) {
            $where = "WHERE a.RKAP_INVS_POS LIKE '%$posisi%' AND a.IS_DELETED =0 AND BRANCH_ID = '$id_branch'";
        } else {
           $where = "WHERE a.IS_DELETED =0 AND BRANCH_ID = '$id_branch'";
        };

        $query = $this->db->query(" SELECT SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, COUNT(a.RKAP_INVS_POS) AS RKAP_INVS_POS, a.BRANCH_NAME, a.BRANCH_ID, a.POSPROG_NAME, SUM(b.REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL FROM
        (        
            SELECT a.RKAP_INVS_ID, a.RKAP_INVS_VALUE, a.RKAP_INVS_POS, c.BRANCH_NAME, c.BRANCH_ID, d.POSPROG_NAME
            FROM TX_RKAP_INVESTATION a                                                                 
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TM_POSITION_PROGRAM d ON a.RKAP_INVS_POS = d.POSPROG_ID
            $where
        )A left join
        (    
            SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
            (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
            (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, 
            b.REAL_SUBPRO_VAL 
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            WHERE a.IS_DELETED = 0)
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID)
            GROUP BY RKAP_SUBPRO_INVS_ID
        )B ON A.RKAP_INVS_ID = B.RKAP_SUBPRO_INVS_ID
        GROUP BY a.BRANCH_ID, a.POSPROG_NAME, a.BRANCH_NAME");
        return $query->result();
    }

    
     public function cek_status($id_branch) {
            $this->db->select('a.REAL_SUBPRO_STATUS, d.IS_RESULT');
            $this->db->from('TX_REAL_SUB_PROGRAM a');
            $this->db->join('TX_RKAP_SUB_PROGRAM b', 'a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID');
            $this->db->join('TX_RKAP_INVESTATION c', 'b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID');
            $this->db->join('TM_STATUS_PROGRAM d', 'a.REAL_SUBPRO_STATUS = d.STATUS_ID');
            $this->db->join('TM_USERS e', 'c.RKAP_INVS_USER_ID = e.USER_ID');
            $this->db->join('TR_BRANCH f', 'e.USER_BRANCH = f.BRANCH_ID');
            $this->db->where('a.IS_DELETED', 0);
            $where = array('e.USER_BRANCH' => $id_branch);
            $this->db->where($where);
            $query = $this->db->get();
            return $query->result();
        }

    public function list_prog_investasi_status($id_branch, $status="") {
        if ($status) {
            $where = "WHERE IS_RESULT Like '%$status%' AND a.IS_DELETED = 0 AND BRANCH_ID = '$id_branch'";
        } else {
           $where = "WHERE BRANCH_ID = '$id_branch' AND a.IS_DELETED = 0";
        };
        
        $query = $this->db->query("SELECT BRANCH_ID, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, SUM(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS, BRANCH_NAME
        FROM(SELECT f.BRANCH_ID, a.RKAP_INVS_VALUE, SUM(c.REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, COUNT(c.REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS, f.BRANCH_NAME 
        FROM TX_RKAP_INVESTATION a
        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID
        JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
        JOIN TM_STATUS_PROGRAM d ON c.REAL_SUBPRO_STATUS = d.STATUS_ID
        JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID
        JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
        $where
        GROUP BY f.BRANCH_ID, a.RKAP_INVS_VALUE, f.BRANCH_NAME)
        GROUP BY BRANCH_ID, BRANCH_NAME");
        return $query->result();
    }

    public function list_prog_investasi_kendala($id_branch, $kendala="") {
        if ($kendala) {
            $where = "WHERE REAL_SUBPRO_CONSTRAINTS LIKE '%$kendala%' AND a.IS_DELETED = 0 AND BRANCH_ID = '$id_branch'";
        } else {
           $where = "WHERE BRANCH_ID = '$id_branch' AND a.IS_DELETED = 0";
        };

        $query = $this->db->query("SELECT BRANCH_ID, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, SUM(REAL_SUBPRO_CONSTRAINTS) AS REAL_SUBPRO_CONSTRAINTS, CONTRAINTS_NAME, BRANCH_NAME
        FROM(SELECT a.RKAP_INVS_VALUE, SUM(c.REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, COUNT(c.REAL_SUBPRO_CONSTRAINTS) AS REAL_SUBPRO_CONSTRAINTS, d.CONTRAINTS_NAME, f.BRANCH_NAME, f.BRANCH_ID
        FROM TX_RKAP_INVESTATION a
        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID
        JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
        JOIN TM_CONTRAINTS d ON c.REAL_SUBPRO_CONSTRAINTS = d.CONTRAINTS_ID
        JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID
        JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
        $where
        GROUP BY a.RKAP_INVS_VALUE, d.CONTRAINTS_NAME, f.BRANCH_NAME, f.BRANCH_ID)
        GROUP BY BRANCH_ID, CONTRAINTS_NAME, BRANCH_NAME");
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

        $query = $this->db->query("SELECT A.IS_PUSAT,(A.REAL_SUBPRO_VAL / B.RKAP_INVS_VALUE) AS REALISASI_FISIK FROM 
        (
            SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0)
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY IS_PUSAT
        ) A LEFT JOIN
        (
            SELECT IS_PUSAT, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, RKAP_INVS_YEAR
            FROM (SELECT a.*, b.USER_ID, b.USER_BRANCH, c.IS_PUSAT, c.BRANCH_NAME
            FROM TX_RKAP_INVESTATION a
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
            WHERE a.IS_DELETED =0  
            ORDER BY a.RKAP_INVS_ID DESC)
            WHERE RKAP_INVS_YEAR <='$get_tahun'
            GROUP BY IS_PUSAT, RKAP_INVS_YEAR
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
        $query = $this->db->query("SELECT A.IS_PUSAT, (A.REAL_SUBPRO_STATUS / B. REAL_SUBPRO_STATUS * 100) AS KPI_REALISASI_PROGRAM FROM   
        (    
            SELECT IS_PUSAT, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID,e.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS = 1)
            GROUP BY IS_PUSAT
        ) A LEFT JOIN
        (
            SELECT IS_PUSAT, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID, e.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0)
            GROUP BY IS_PUSAT
        ) B ON A.IS_PUSAT = B.IS_PUSAT
        WHERE A.IS_PUSAT = '$is_pusat'");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'KPI_REALISASI_PROGRAM' => "0"];
            return $data;
        }
    }

    public function pusat_kpi_realisasi_fisik($is_pusat, $get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT A.IS_PUSAT, (A.REAL_SUBPRO_VAL / B.TOTAL_NILAI_CONTRACT) AS KPI_REALISASI_FISIK FROM
        (
            SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0)
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY IS_PUSAT
        )A LEFT JOIN
        (
            SELECT IS_PUSAT,SUM(RKAP_SUBPRO_CONTRACT_VALUE) AS TOTAL_NILAI_CONTRACT
            FROM (SELECT a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(a.RKAP_SUBPRO_CONTRACT_DATE, 'YYYY') AS RKAP_SUBPRO_CONTRACT_DATE, 
            b.RKAP_INVS_ID, c.USER_ID, d.IS_PUSAT
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_INVESTATION b ON a.RKAP_SUBPRO_INVS_ID = b.RKAP_INVS_ID
            JOIN TM_USERS c ON b.RKAP_INVS_USER_ID = c.USER_ID
            JOIN TR_BRANCH d ON c.USER_BRANCH = d.BRANCH_ID
            WHERE b.IS_DELETED =0)
            WHERE RKAP_SUBPRO_CONTRACT_DATE = '$get_tahun'
            GROUP BY IS_PUSAT 
        ) B ON A.IS_PUSAT = B.IS_PUSAT
        WHERE A.IS_PUSAT = '$is_pusat'");
        
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
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS != 2)
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
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS = 2)
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
        FROM TX_RKAP_INVESTATION a 
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
        $query = $this->db->query("SELECT IS_PUSAT,  CONTRAINTS_NAME, COUNT(REAL_SUBPRO_CONSTRAINTS) AS TOTAL_KENDALA, REAL_SUBPRO_CONSTRAINTS
        FROM(SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_CONSTRAINTS, c.CONTRAINTS_NAME, f.IS_PUSAT
        FROM TX_RKAP_SUB_PROGRAM a
        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
        JOIN TM_CONTRAINTS c ON b.REAL_SUBPRO_CONSTRAINTS = c.CONTRAINTS_ID
        JOIN TX_RKAP_INVESTATION d ON a.RKAP_SUBPRO_INVS_ID = d.RKAP_INVS_ID
        JOIN TM_USERS e ON d.RKAP_INVS_USER_ID = e.USER_ID
        JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
        WHERE d.IS_DELETED = 0)
        WHERE IS_PUSAT = '$is_pusat'
        GROUP BY IS_PUSAT, CONTRAINTS_NAME, REAL_SUBPRO_CONSTRAINTS
        ORDER BY TOTAL_KENDALA DESC");
        
        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['IS_PUSAT' => $is_pusat, 'TOTAL_KENDALA' => "0"];
            return $data;
        }
    }

    // KONTRAK BELUM SELESAI
   public function pusat_kontrak_kritis($is_pusat) {
        $query = $this->db->query("SELECT SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, SUM(RKAP_INVS_COST_REQ) AS RKAP_INVS_COST_REQ, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, BRANCH_ID, BRANCH_NAME
            FROM(SELECT a.RKAP_INVS_ID, a.RKAP_INVS_VALUE, a.RKAP_INVS_COST_REQ, SUM(c.REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, e.BRANCH_ID, e.BRANCH_NAME 
            FROM TX_RKAP_INVESTATION a
            LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
            LEFT JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
            LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
            LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND e.IS_PUSAT = '$is_pusat'
            GROUP BY a.RKAP_INVS_ID, a.RKAP_INVS_VALUE, a.RKAP_INVS_COST_REQ, e.BRANCH_ID, e.BRANCH_NAME)
            GROUP BY BRANCH_ID, BRANCH_NAME");
            return $query->result();
    }

    /*belum ditambah where like*/
    public function pusat_list_prog_investasi_posisi($is_pusat, $posisi="", $get_bulan) {
        if ($posisi) {
            $where = "WHERE RKAP_INVS_POS LIKE '%$posisi%' AND a.IS_DELETED =0 AND IS_PUSAT = '$is_pusat'";
        } else {
           $where = "WHERE a.IS_DELETED =0 AND is_pusat = '$is_pusat'";
        };

        $query = $this->db->query("SELECT SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, COUNT(a.RKAP_INVS_POS) AS RKAP_INVS_POS, a.BRANCH_NAME, a.BRANCH_ID, a.IS_PUSAT, a.POSPROG_NAME, SUM(b.REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL FROM
        (        
            SELECT a.RKAP_INVS_ID, a.RKAP_INVS_VALUE, a.RKAP_INVS_POS,c.BRANCH_ID, c.BRANCH_NAME, c.IS_PUSAT, d.POSPROG_NAME
            FROM TX_RKAP_INVESTATION a                                                                 
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TM_POSITION_PROGRAM d ON a.RKAP_INVS_POS = d.POSPROG_ID
            $where
        )A left join
        (    
            SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
            (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
            (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, 
            b.REAL_SUBPRO_VAL 
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            WHERE a.IS_DELETED = 0)
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID)
            GROUP BY RKAP_SUBPRO_INVS_ID
        )B ON A.RKAP_INVS_ID = B.RKAP_SUBPRO_INVS_ID
        GROUP BY a.IS_PUSAT, a.POSPROG_NAME, a.BRANCH_NAME, a.BRANCH_ID");
        return $query->result();
    }

    public function pusat_list_prog_investasi_status($is_pusat, $status="") {
        if ($status) {
            $where = "WHERE IS_RESULT Like '%$status%' AND a.IS_DELETED = 0 AND f.IS_PUSAT = '$is_pusat'";
        } else {
           $where = "WHERE f.IS_PUSAT = '$is_pusat' AND a.IS_DELETED = 0";
        };

        $query = $this->db->query("SELECT BRANCH_ID, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL,SUM(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS, BRANCH_NAME, IS_PUSAT
        FROM(SELECT f.BRANCH_ID, a.RKAP_INVS_VALUE, SUM(c.REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, COUNT(c.REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS, f.BRANCH_NAME, f.IS_PUSAT
        FROM TX_RKAP_INVESTATION a
        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID
        JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
        JOIN TM_STATUS_PROGRAM d ON c.REAL_SUBPRO_STATUS = d.STATUS_ID
        JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID
        JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
        $where
        GROUP BY f.BRANCH_ID, a.RKAP_INVS_VALUE, f.BRANCH_NAME, f.IS_PUSAT)
        GROUP BY BRANCH_ID, BRANCH_NAME, IS_PUSAT");
        return $query->result();
    }

    public function pusat_list_prog_investasi_kendala($is_pusat, $kendala="") {
        if ($kendala) {
            $where = "WHERE REAL_SUBPRO_CONSTRAINTS LIKE '%$kendala%' AND a.IS_DELETED = 0 AND f.IS_PUSAT = '$is_pusat'";
        } else {
           $where = "WHERE f.IS_PUSAT = '$is_pusat' AND a.IS_DELETED = 0";
        };

        $query = $this->db->query("SELECT BRANCH_ID, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, SUM (REAL_SUBPRO_CONSTRAINTS) AS REAL_SUBPRO_CONSTRAINTS, CONTRAINTS_NAME, BRANCH_NAME, IS_PUSAT
        FROM(SELECT f.BRANCH_ID, a.RKAP_INVS_VALUE, SUM(c.REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, COUNT(c.REAL_SUBPRO_CONSTRAINTS) AS REAL_SUBPRO_CONSTRAINTS, d.CONTRAINTS_NAME, f.BRANCH_NAME, f.IS_PUSAT
        FROM TX_RKAP_INVESTATION a
        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID
        JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
        JOIN TM_CONTRAINTS d ON c.REAL_SUBPRO_CONSTRAINTS = d.CONTRAINTS_ID
        JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID
        JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
        $where
        GROUP BY f.BRANCH_ID, a.RKAP_INVS_VALUE, d.CONTRAINTS_NAME, f.BRANCH_NAME, f.IS_PUSAT)
        GROUP BY BRANCH_ID, CONTRAINTS_NAME, BRANCH_NAME, IS_PUSAT");
        return $query->result();
    }

    // gabungan cabang dan anak perusahaan

    public function all_realisasi_fisik($get_bulan, $get_tahun) {

        $query = $this->db->query("SELECT A.COMPANY_CODE,(A.REAL_SUBPRO_VAL / B.RKAP_INVS_VALUE) AS REALISASI_FISIK FROM 
        (
            SELECT COMPANY_CODE, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT COMPANY_CODE, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, COMPANY_CODE
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0)
            WHERE AA = '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, COMPANY_CODE)
            GROUP BY COMPANY_CODE, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY COMPANY_CODE
        ) A LEFT JOIN
        (
            SELECT COMPANY_CODE, SUM(RKAP_INVS_VALUE) AS RKAP_INVS_VALUE, RKAP_INVS_YEAR
            FROM (SELECT a.*, b.USER_ID, b.USER_BRANCH, c.COMPANY_CODE, c.BRANCH_NAME
            FROM TX_RKAP_INVESTATION a
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
            WHERE a.IS_DELETED =0  
            ORDER BY a.RKAP_INVS_ID DESC)
            WHERE RKAP_INVS_YEAR <='$get_tahun'
            GROUP BY COMPANY_CODE, RKAP_INVS_YEAR
        ) B ON A.COMPANY_CODE = B.COMPANY_CODE");
        

        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['COMPANY_CODE' => 01,'REALISASI_FISIK' => "0"];
            return $data;
        }
    }

    public function all_kpi_realisasi_program() {
        $query = $this->db->query("SELECT A.COMPANY_CODE, (A.REAL_SUBPRO_STATUS / B. REAL_SUBPRO_STATUS * 100) AS KPI_REALISASI_PROGRAM FROM   
        (    
            SELECT COMPANY_CODE, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID,e.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS = 1)
            GROUP BY COMPANY_CODE
        ) A LEFT JOIN
        (
            SELECT COMPANY_CODE, COUNT(REAL_SUBPRO_STATUS) AS REAL_SUBPRO_STATUS
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_STATUS,d.USER_ID, e.BRANCH_ID, e.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0)
            GROUP BY COMPANY_CODE
        ) B ON A.COMPANY_CODE = B.COMPANY_CODE");
            
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['COMPANY_CODE' => 01, 'KPI_REALISASI_PROGRAM' => "0"];
            return $data;
        }
    }

    public function all_kpi_realisasi_fisik($get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT A.COMPANY_CODE, (A.REAL_SUBPRO_VAL / B.TOTAL_NILAI_CONTRACT) AS KPI_REALISASI_FISIK FROM
        (
            SELECT COMPANY_CODE, SUM(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL 
            FROM (SELECT COMPANY_CODE, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
            FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, COMPANY_CODE
            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE,d.USER_ID,  e.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0)
            WHERE AA <= '$get_bulan'
            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, COMPANY_CODE)
            GROUP BY COMPANY_CODE, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
            GROUP BY COMPANY_CODE
        )A LEFT JOIN
        (
            SELECT COMPANY_CODE,SUM(RKAP_SUBPRO_CONTRACT_VALUE) AS TOTAL_NILAI_CONTRACT
            FROM (SELECT a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(a.RKAP_SUBPRO_CONTRACT_DATE, 'YYYY') AS RKAP_SUBPRO_CONTRACT_DATE, 
            b.RKAP_INVS_ID, c.USER_ID, d.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_RKAP_INVESTATION b ON a.RKAP_SUBPRO_INVS_ID = b.RKAP_INVS_ID
            JOIN TM_USERS c ON b.RKAP_INVS_USER_ID = c.USER_ID
            JOIN TR_BRANCH d ON c.USER_BRANCH = d.BRANCH_ID
            WHERE b.IS_DELETED =0)
            WHERE RKAP_SUBPRO_CONTRACT_DATE = '$get_tahun'
            GROUP BY COMPANY_CODE 
        ) B ON A.COMPANY_CODE = B.COMPANY_CODE");
        
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
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS != 2)
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
            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
            WHERE c.IS_DELETED = 0 AND REAL_SUBPRO_STATUS = 2)
            GROUP BY COMPANY_CODE");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['COMPANY_CODE' => 01, 'REAL_SUBPRO_STATUS' => "0"];
            return $data;
        }
    }

    public function all_posisi_prog_investasi() {
        $query = $this->db->query("SELECT  COMPANY_CODE, POSISI, COUNT(RKAP_INVS_POS) AS JUMLAH_POSISI, RKAP_INVS_POS
            FROM(SELECT a.RKAP_INVS_POS, c.COMPANY_CODE, d.POSPROG_NAME as POSISI
            FROM TX_RKAP_INVESTATION a 
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN TM_POSITION_PROGRAM d ON a.RKAP_INVS_POS = d.POSPROG_ID
            WHERE a.IS_DELETED =0 
            ORDER BY a.RKAP_INVS_ID DESC)
            GROUP BY COMPANY_CODE, POSISI, RKAP_INVS_POS
            ORDER BY JUMLAH_POSISI DESC");
    
        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['COMPANY_CODE' => 01, 'JUMLAH_POSISI' => "0"];
            return $data;
        }
        
    }

    public function all_kendala_prog_investasi() {
        $query = $this->db->query("SELECT COMPANY_CODE,  CONTRAINTS_NAME, COUNT(REAL_SUBPRO_CONSTRAINTS) AS TOTAL_KENDALA, REAL_SUBPRO_CONSTRAINTS
            FROM(SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID,b.REAL_SUBPRO_CONSTRAINTS, c.CONTRAINTS_NAME, f.COMPANY_CODE
            FROM TX_RKAP_SUB_PROGRAM a
            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TM_CONTRAINTS c ON b.REAL_SUBPRO_CONSTRAINTS = c.CONTRAINTS_ID
            JOIN TX_RKAP_INVESTATION d ON a.RKAP_SUBPRO_INVS_ID = d.RKAP_INVS_ID
            JOIN TM_USERS e ON d.RKAP_INVS_USER_ID = e.USER_ID
            JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
            WHERE d.IS_DELETED = 0)
            GROUP BY COMPANY_CODE, CONTRAINTS_NAME, REAL_SUBPRO_CONSTRAINTS
            ORDER BY TOTAL_KENDALA DESC");
        
        if (count($query->result()) > 0) {
            return $query->result();
        } else {
            $data = ['COMPANY_CODE' => 01, 'TOTAL_KENDALA' => "0"];
            return $data;
        }
        
    }

    //GAUGE KRITIS
    public function gauge_kritis_1($id_branch, $get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT BRANCH_ID, COUNT(AA) AS AA, COUNT(AB) AS AB, COUNT(ABC) AS ABC
        FROM(SELECT BRANCH_ID, AA, AB, ABC
        FROM(SELECT A.BRANCH_ID, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID  
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                        ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE TAHUN = '$get_bulan'
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        WHERE BRANCH_ID = $id_branch AND ABC >= $deviasi_till70 AND AA BETWEEN 0 AND 70)
        GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_2($id_branch, $get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT BRANCH_ID, COUNT(AA) AS AA, COUNT(AB) AS AB, COUNT(ABC) AS ABC
        FROM(SELECT BRANCH_ID, AA, AB, ABC
        FROM(SELECT A.BRANCH_ID, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID  
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                        ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE TAHUN = '$get_bulan'
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        WHERE BRANCH_ID = $id_branch AND ABC >= $deviasi_till100 AND AA BETWEEN 70 AND 100)
        GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT BRANCH_ID, COUNT(AA) AS AA, COUNT(AB) AS AB, COUNT(ABC) AS ABC
        FROM(SELECT BRANCH_ID, AA, AB, ABC, KONTRAK_AKHIR
        FROM(SELECT A.BRANCH_ID, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.KONTRAK_AKHIR, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID, KONTRAK_AKHIR
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, KONTRAK_AKHIR
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, KONTRAK_AKHIR
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA,
                        TO_CHAR(a.RKAP_SUBPRO_ENDOF_GUARANTEE, 'YYYY-MM-DD') AS KONTRAK_AKHIR, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID,KONTRAK_AKHIR)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, KONTRAK_AKHIR)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                        ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE TAHUN = '$get_bulan'
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        WHERE BRANCH_ID = $id_branch AND KONTRAK_AKHIR > '$get_kontrak_end' AND AA = 100)
        GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_1_p($is_pusat, $get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT IS_PUSAT, COUNT(AA) AS AA,COUNT(AB) AS AB, COUNT(ABC)AS ABC
        FROM(SELECT IS_PUSAT, AA, AB, ABC
        FROM(SELECT A.IS_PUSAT, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT  
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                        ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE TAHUN = '$get_bulan'
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        WHERE IS_PUSAT = $is_pusat AND ABC >= $deviasi_till70 AND AA BETWEEN 0 AND 70)
        GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_2_p($is_pusat, $get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT IS_PUSAT, COUNT(AA) AS AA,COUNT(AB) AS AB, COUNT(ABC)AS ABC
        FROM(SELECT IS_PUSAT, AA, AB, ABC
        FROM(SELECT A.IS_PUSAT, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT  
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                        ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE TAHUN = '$get_bulan'
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        WHERE IS_PUSAT = $is_pusat AND ABC >= $deviasi_till100 AND AA BETWEEN 70 AND 100)
        GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

   public function gauge_kritis_3_p($is_pusat, $get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT IS_PUSAT, COUNT(AA) AS AA, COUNT(AB) AS AB, COUNT(ABC) AS ABC
        FROM(SELECT IS_PUSAT, AA, AB, ABC, KONTRAK_AKHIR
        FROM(SELECT A.IS_PUSAT, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.KONTRAK_AKHIR, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT, KONTRAK_AKHIR
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA,
                        TO_CHAR(a.RKAP_SUBPRO_ENDOF_GUARANTEE, 'YYYY-MM-DD') AS KONTRAK_AKHIR, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT,KONTRAK_AKHIR)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                        ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE TAHUN = '$get_bulan'
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        WHERE IS_PUSAT = $is_pusat AND KONTRAK_AKHIR = '$get_kontrak_end' AND AA = 100)
        GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_meter_p($is_pusat) {
        $query = $this->db->query("SELECT IS_PUSAT, AA, AB, ABC
        FROM(SELECT IS_PUSAT, COUNT(AA) AS AA,COUNT(AB) AS AB, COUNT(ABC)AS ABC
        FROM(SELECT A.IS_PUSAT, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT  
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        GROUP BY IS_PUSAT)
        WHERE IS_PUSAT = $is_pusat");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_meter($id_branch) {
        $query = $this->db->query("SELECT BRANCH_ID, AA, AB, ABC
        FROM(SELECT BRANCH_ID, COUNT(AA) AS AA,COUNT(AB) AS AB, COUNT(ABC)AS ABC
        FROM(SELECT A.BRANCH_ID, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID  
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        GROUP BY BRANCH_ID)
        WHERE BRANCH_ID = $id_branch");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_meter_all() {
        $query = $this->db->query("SELECT COUNT(AA) AS AA,COUNT(AB) AS AB, COUNT(ABC)AS ABC
        FROM(SELECT A.BRANCH_ID, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID  
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_1_all($get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT COUNT(AA) AS AA, COUNT(AB) AS AB, COUNT(ABC) AS ABC
        FROM(SELECT BRANCH_ID, AA, AB, ABC
        FROM(SELECT A.BRANCH_ID, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID  
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                        ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE TAHUN = '$get_bulan'
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        WHERE ABC >= $deviasi_till70 AND AA BETWEEN 0 AND 70)");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_2_all($get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT COUNT(AA) AS AA, COUNT(AB) AS AB, COUNT(ABC) AS ABC
        FROM(SELECT BRANCH_ID, AA, AB, ABC
        FROM(SELECT A.BRANCH_ID, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID  
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                        ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE TAHUN = '$get_bulan'
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        WHERE ABC >= $deviasi_till100 AND AA BETWEEN 70 AND 100)");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function gauge_kritis_3_all($get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT IS_PUSAT, COUNT(AA) AS AA, COUNT(AB) AS AB, COUNT(ABC) AS ABC
        FROM(SELECT IS_PUSAT, AA, AB, ABC, KONTRAK_AKHIR
        FROM(SELECT A.IS_PUSAT, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.KONTRAK_AKHIR, A.AA, B.AB, (A.AA - B.AB) AS ABC FROM (
        SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT, KONTRAK_AKHIR
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR
                        FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR
                        FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA,
                        TO_CHAR(a.RKAP_SUBPRO_ENDOF_GUARANTEE, 'YYYY-MM-DD') AS KONTRAK_AKHIR, b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM a
                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT,KONTRAK_AKHIR)
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR)
        ) A
        LEFT JOIN (
        SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                        FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                        FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                        ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                        JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                        WHERE c.IS_DELETED = 0)
                        WHERE TAHUN = '$get_bulan'
                        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
        ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
        WHERE KONTRAK_AKHIR > '$get_kontrak_end' AND AA = 100)
        GROUP BY IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['ABC' => "0"];
            return $data;
        }
        
    }

    public function d_gauge_kritis_1_p($is_pusat, $get_bulan, $deviasi_till70) {
        $query = $this->db->query("SELECT IS_PUSAT, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, RKAP_INVS_VALUE, AA, AB, ABC
            FROM(SELECT A.IS_PUSAT, A.RKAP_INVS_TITLE, A.RKAP_SUBPRO_TITTLE, A.RKAP_SUBPRO_CONTRACT_VALUE, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC 
            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT  
                            FROM (SELECT RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_TITLE, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM a
                            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE AA <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID,RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT)
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT)
            ) A
            LEFT JOIN (
            SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                            ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE TAHUN = '$get_bulan'
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
            WHERE IS_PUSAT = '$is_pusat' AND ABC >= $deviasi_till70 AND AA BETWEEN 0 AND 70");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_2_p($is_pusat, $get_bulan, $deviasi_till100) {
        $query = $this->db->query("SELECT IS_PUSAT, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, RKAP_INVS_VALUE, AA, AB, ABC
            FROM(SELECT A.IS_PUSAT, A.RKAP_INVS_TITLE, A.RKAP_SUBPRO_TITTLE, A.RKAP_SUBPRO_CONTRACT_VALUE, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC 
            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT  
                            FROM (SELECT RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_TITLE, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM a
                            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE AA <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID,RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT)
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT)
            ) A
            LEFT JOIN (
            SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                            ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE TAHUN = '$get_bulan'
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
            WHERE IS_PUSAT = '$is_pusat' AND ABC >= $deviasi_till100 AND AA BETWEEN 70 AND 100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_3_p($is_pusat, $get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT IS_PUSAT, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, RKAP_INVS_VALUE, AA, AB, ABC, KONTRAK_AKHIR
            FROM(SELECT A.IS_PUSAT, A.RKAP_INVS_TITLE, A.RKAP_SUBPRO_TITTLE, A.RKAP_SUBPRO_CONTRACT_VALUE, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC, A.KONTRAK_AKHIR
            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT, KONTRAK_AKHIR
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR  
                            FROM (SELECT RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR
                            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, TO_CHAR(a.RKAP_SUBPRO_ENDOF_GUARANTEE, 'YYYY-MM-DD') AS KONTRAK_AKHIR, b.REAL_SUBPRO_VAL, c.RKAP_INVS_TITLE, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM a
                            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE AA <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID,RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR)
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR)
            ) A
            LEFT JOIN (
            SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                            ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE TAHUN = '$get_bulan'
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
            WHERE IS_PUSAT = '$is_pusat' AND KONTRAK_AKHIR > '$get_kontrak_end' AND AA = 100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_1_all($get_bulan) {
        $query = $this->db->query("SELECT IS_PUSAT, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, RKAP_INVS_VALUE, AA, AB, ABC
            FROM(SELECT A.IS_PUSAT, A.RKAP_INVS_TITLE, A.RKAP_SUBPRO_TITTLE, A.RKAP_SUBPRO_CONTRACT_VALUE, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC 
            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT  
                            FROM (SELECT RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_TITLE, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM a
                            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE AA <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID,RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT)
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT)
            ) A
            LEFT JOIN (
            SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                            ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE TAHUN = '$get_bulan'
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
            WHERE ABC >= -15 AND AA BETWEEN 0 AND 70");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_2_all($get_bulan) {
        $query = $this->db->query("SELECT IS_PUSAT, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, RKAP_INVS_VALUE, AA, AB, ABC
            FROM(SELECT A.IS_PUSAT, A.RKAP_INVS_TITLE, A.RKAP_SUBPRO_TITTLE, A.RKAP_SUBPRO_CONTRACT_VALUE, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC 
            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT  
                            FROM (SELECT RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_TITLE, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM a
                            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE AA <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID,RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT)
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT)
            ) A
            LEFT JOIN (
            SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                            ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE TAHUN = '$get_bulan'
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
            WHERE ABC >= -10 AND AA BETWEEN 70 AND 100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_3_all($get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT IS_PUSAT, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, RKAP_INVS_VALUE, AA, AB, ABC, KONTRAK_AKHIR
            FROM(SELECT A.IS_PUSAT, A.RKAP_INVS_TITLE, A.RKAP_SUBPRO_TITTLE, A.RKAP_SUBPRO_CONTRACT_VALUE, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC, A.KONTRAK_AKHIR
            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, IS_PUSAT, KONTRAK_AKHIR
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR  
                            FROM (SELECT RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR
                            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, TO_CHAR(a.RKAP_SUBPRO_ENDOF_GUARANTEE, 'YYYY-MM-DD') AS KONTRAK_AKHIR, b.REAL_SUBPRO_VAL, c.RKAP_INVS_TITLE, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM a
                            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE AA <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID,RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR)
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, IS_PUSAT, KONTRAK_AKHIR)
            ) A
            LEFT JOIN (
            SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, IS_PUSAT
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, IS_PUSAT
                            FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                            ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.IS_PUSAT
                            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE TAHUN = '$get_bulan'
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT)
            ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
            WHERE KONTRAK_AKHIR > '$get_kontrak_end' AND AA = 100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_1($id_branch, $get_bulan) {
        $query = $this->db->query("SELECT BRANCH_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, RKAP_INVS_VALUE, AA, AB, ABC
            FROM(SELECT A.BRANCH_ID, A.RKAP_INVS_TITLE, A.RKAP_SUBPRO_TITTLE, A.RKAP_SUBPRO_CONTRACT_VALUE, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC 
            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID  
                            FROM (SELECT RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
                            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_TITLE, c.RKAP_INVS_VALUE, e.BRANCH_ID
                            FROM TX_RKAP_SUB_PROGRAM a
                            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE AA <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID,RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, BRANCH_ID)
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, BRANCH_ID)
            ) A
            LEFT JOIN (
            SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                            FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                            ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE TAHUN = '$get_bulan'
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
            ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
            WHERE BRANCH_ID = '$id_branch' AND ABC >= -15 AND AA BETWEEN 0 AND 70");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_2($id_branch, $get_bulan) {
        $query = $this->db->query("SELECT BRANCH_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, RKAP_INVS_VALUE, AA, AB, ABC
            FROM(SELECT A.BRANCH_ID, A.RKAP_INVS_TITLE, A.RKAP_SUBPRO_TITTLE, A.RKAP_SUBPRO_CONTRACT_VALUE, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC 
            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID  
                            FROM (SELECT RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID
                            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, c.RKAP_INVS_TITLE, c.RKAP_INVS_VALUE, e.BRANCH_ID
                            FROM TX_RKAP_SUB_PROGRAM a
                            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE AA <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID,RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, BRANCH_ID)
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, BRANCH_ID)
            ) A
            LEFT JOIN (
            SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                            FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                            ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE TAHUN = '$get_bulan'
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
            ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
            WHERE BRANCH_ID = '$id_branch' AND ABC >= -10 AND AA BETWEEN 70 AND 100");
        
            return $query->result();
        
    }

    public function d_gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end) {
        $query = $this->db->query("SELECT BRANCH_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, RKAP_INVS_VALUE, AA, AB, ABC, KONTRAK_AKHIR
            FROM(SELECT A.BRANCH_ID, A.RKAP_INVS_TITLE, A.RKAP_SUBPRO_TITTLE, A.RKAP_SUBPRO_CONTRACT_VALUE, A.RKAP_SUBPRO_INVS_ID, A.REAL_SUBPRO_VAL, A.RKAP_INVS_VALUE, A.AA, B.AB, (A.AA - B.AB) AS ABC, A.KONTRAK_AKHIR
            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL,RKAP_INVS_VALUE, (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) as AA, BRANCH_ID, KONTRAK_AKHIR
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, KONTRAK_AKHIR  
                            FROM (SELECT RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_CONTRACT_VALUE, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, KONTRAK_AKHIR
                            FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, TO_CHAR(a.RKAP_SUBPRO_ENDOF_GUARANTEE, 'YYYY-MM-DD') AS KONTRAK_AKHIR, b.REAL_SUBPRO_VAL, c.RKAP_INVS_TITLE, c.RKAP_INVS_VALUE, e.BRANCH_ID
                            FROM TX_RKAP_SUB_PROGRAM a
                            JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE AA <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID,RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, BRANCH_ID, KONTRAK_AKHIR)
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_CONTRACT_VALUE, RKAP_INVS_VALUE, BRANCH_ID, KONTRAK_AKHIR)
            ) A
            LEFT JOIN (
            SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (AA / RKAP_INVS_VALUE * 100) AS AB, BRANCH_ID
                            FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE, BRANCH_ID
                            FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') as TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE,
                            ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE, e.BRANCH_ID
                            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                            JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                            JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                            WHERE c.IS_DELETED = 0)
                            WHERE TAHUN = '$get_bulan'
                            GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID)
            ) B ON A.RKAP_SUBPRO_INVS_ID = B.RKAP_SUBPRO_INVS_ID)
            WHERE BRANCH_ID = '$id_branch' AND KONTRAK_AKHIR > '$get_kontrak_end' AND AA = 100");
        
            return $query->result();
        
    }

    public function get_gauge_value() {

        $query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.NILAI_RKAP, B.REALISASI, B.NILAI_GAUGE FROM
            (
                SELECT * FROM TR_BRANCH
            ) A
            LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, NILAI_RKAP, REALISASI, (REALISASI / NILAI_RKAP * 100) AS NILAI_GAUGE
                FROM(SELECT BRANCH_ID, BRANCH_NAME, SUM(RKAP_INVS_VALUE) AS NILAI_RKAP, SUM(REALISASI) AS REALISASI
                FROM(SELECT a.RKAP_INVS_ID, a.RKAP_INVS_VALUE, SUM(c.REAL_SUBPRO_VAL) AS REALISASI, e.BRANCH_ID, e.BRANCH_NAME 
                FROM TX_RKAP_INVESTATION a
                LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                LEFT JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
                LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
                LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                WHERE a.IS_DELETED =0 
                GROUP BY a.RKAP_INVS_ID, a.RKAP_INVS_VALUE, a.RKAP_INVS_COST_REQ, e.BRANCH_ID, e.BRANCH_NAME)
                GROUP BY BRANCH_ID, BRANCH_NAME)
            )B ON A.BRANCH_ID = B.BRANCH_ID");
            return $query->result();
    }

}
