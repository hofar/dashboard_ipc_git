<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function get_branch($id_branch){
        $this->db->select('TR_BRANCH.*');
        $this->db->from('TR_BRANCH');
        $this->db->where('BRANCH_ID', $id_branch);
        $query = $this->db->get();

        return $query->result();
    }

    public function rkap_sipil($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
    	$query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.RKAP_INVS_VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN
            (	
            	SELECT c.BRANCH_ID, c.BRANCH_NAME ,SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE 
    			FROM $whq a 
				JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
				JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
				WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')
				GROUP BY BRANCH_ID, BRANCH_NAME
			) B ON A.BRANCH_ID = B.BRANCH_ID");

    	return $query->result();
    }

    public function rkap_peralatan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

    	$query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.RKAP_INVS_VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN
            (	
            	SELECT c.BRANCH_ID, c.BRANCH_NAME ,SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE 
    			FROM $whq a 
				JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
				JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
				WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')
				GROUP BY BRANCH_ID, BRANCH_NAME
			) B ON A.BRANCH_ID = B.BRANCH_ID");

    	return $query->result();
    }

    public function rkap_non_fisik($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
    	$query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.RKAP_INVS_VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN
            (	
            	SELECT c.BRANCH_ID, c.BRANCH_NAME ,SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE 
    			FROM $whq a 
				JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
				JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
				WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8 
				GROUP BY BRANCH_ID, BRANCH_NAME
			) B ON A.BRANCH_ID = B.BRANCH_ID");

    	return $query->result();
    }

    public function jumlah_rkap($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

    	$query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.RKAP_INVS_VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN
            (	
            	SELECT c.BRANCH_ID, c.BRANCH_NAME ,SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE 
    			FROM $whq a 
				JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
				JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
				WHERE a.IS_DELETED =0
				GROUP BY BRANCH_ID, BRANCH_NAME
			) B ON A.BRANCH_ID = B.BRANCH_ID");

    	return $query->result();
    }

    public function jumlah_rkap_sipil($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query = $this->db->query("SELECT SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE FROM $whq a JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID  JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN('1', '3', '9', '7') AND IS_PUSAT IN('0', '1')");
	        
	        
	        return $query->result();
    }

    public function jumlah_rkap_peralatan($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
	        $query = $this->db->query("SELECT SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE FROM $whq a 
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN('2', '4', '5', '6', '10') AND IS_PUSAT IN('0', '1')");
	        return $query->result();
    }

    public function jumlah_rkap_non_fisik($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
    		
	        $query = $this->db->query("SELECT SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE 
            FROM $whq a 
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8 AND IS_PUSAT IN('0', '1')");
	        return $query->result();
    }

    public function total_rkap($get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
    		
	        $query = $this->db->query("SELECT SUM(a.RKAP_INVS_VALUE) AS RKAP_INVS_VALUE 
            FROM $whq a 
            JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID 
            JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
            WHERE a.IS_DELETED =0 AND IS_PUSAT IN('0', '1')");
	        return $query->result();
    }

    public function backup() {
	        $this->db->select('c.BRANCH_ID, c.BRANCH_NAME ,a.RKAP_INVS_VALUE');
	        $this->db->from('TX_RKAP_INVESTATION a');
	        $this->db->join('TM_USERS b', 'a.RKAP_INVS_USER_ID = b.USER_ID');
	        $this->db->join('TR_BRANCH c', 'b.USER_BRANCH = c.BRANCH_ID');
	        $this->db->where('a.IS_DELETED', 0);
	        $this->db->where_in('a.RKAP_INVS_ASSETS', array('1', '3', '9', '7'));
	        $query = $this->db->get();
	        return $query->result();
    	
    }

    //Realisasi

    public function realisasi_sipil($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_REALISASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI FROM 
                    (
                        SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE FROM 
                            (
                                SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME FROM 
                                    (
                                        SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS, c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                                        FROM TX_RKAP_SUB_PROGRAM a
                                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                        JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                                        WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')
                                    )
                                WHERE AA <= '$get_bulan'
                                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                            )
                        GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE
                    )
                GROUP BY BRANCH_ID, BRANCH_NAME
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_peralatan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_REALISASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI FROM 
                    (
                        SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE FROM 
                            (
                                SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME FROM 
                                    (
                                        SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS, c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                                        FROM TX_RKAP_SUB_PROGRAM a
                                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                        JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                                        WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')
                                    )
                                WHERE AA <= '$get_bulan'
                                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                            )
                        GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE
                    )
                GROUP BY BRANCH_ID, BRANCH_NAME
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_non_fisik($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_REALISASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI FROM 
                    (
                        SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE FROM 
                            (
                                SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME FROM 
                                    (
                                        SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS, c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                                        FROM TX_RKAP_SUB_PROGRAM a
                                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                        JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                                        WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8
                                    )
                                WHERE AA <= '$get_bulan'
                                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                            )
                        GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE
                    )
                GROUP BY BRANCH_ID, BRANCH_NAME
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_total($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
        $query = $this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_REALISASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI FROM 
                    (
                        SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE FROM 
                            (
                                SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME FROM 
                                    (
                                        SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS, c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                                        FROM TX_RKAP_SUB_PROGRAM a
                                        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                        JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                                        JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                                        JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                                        WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun'
                                    )
                                WHERE AA <= '$get_bulan'
                                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                            )
                        GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE
                    )
                GROUP BY BRANCH_ID, BRANCH_NAME
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function jumlah_realisasi_sipil($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI FROM 
            (
                SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE FROM 
                    (
                        SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME FROM 
                            (
                                SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS, c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                                FROM TX_RKAP_SUB_PROGRAM a
                                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT IN ('1', '0')
                            )
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    )
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE
            )");
        return $query->result();
    }

    public function jumlah_realisasi_peralatan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI FROM 
            (
                SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE FROM 
                    (
                        SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME FROM 
                            (
                                SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS, c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                                FROM TX_RKAP_SUB_PROGRAM a
                                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT IN ('1', '0')
                            )
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    )
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE
            )");
        return $query->result();
    }

    public function jumlah_realisasi_non_fisik($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI FROM 
            (
                SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE FROM 
                    (
                        SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME FROM 
                            (
                                SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS, c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                                FROM TX_RKAP_SUB_PROGRAM a
                                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8 AND IS_PUSAT IN ('1', '0')
                            )
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    )
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE
            )");
        return $query->result();
    }

    public function jumlah_realisasi_total($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
        $query =$this->db->query("SELECT SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI FROM 
            (
                SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE FROM 
                    (
                        SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME FROM 
                            (
                                SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS, c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                                FROM TX_RKAP_SUB_PROGRAM a
                                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                                JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                                JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND IS_PUSAT IN ('1', '0')
                            )
                        WHERE AA <= '$get_bulan'
                        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    )
                GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE
            )");
        return $query->result();
    }

    //TARGET

    public function target_sipil($month, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_TARGET FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                    (
                        SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                            (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                            (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                            (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                            (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                        FROM $whq a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')
                    )
                ) GROUP BY BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function target_peralatan($month, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_TARGET FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                    (
                        SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                            (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                            (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                            (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                            (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                        FROM $whq a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')
                    )
                ) GROUP BY BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function target_non_fisik($month, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_TARGET FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                    (
                        SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                            (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                            (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                            (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                            (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                        FROM $whq a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8
                    )
                ) GROUP BY BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function target_total($month, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.TOTAL_TARGET FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                    (
                        SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                            (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                            (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                            (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                            (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                        FROM $whq a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        WHERE a.IS_DELETED =0
                    )
                ) GROUP BY BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function jumlah_target_sipil($month, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("
            SELECT SUM(VALUE) as TOTAL_TARGET FROM 
                (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                    (
                        SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                            (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                            (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                            (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                            (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                        FROM $whq a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT IN ('0', '1')
                    )
                )
            ");
        return $query->result();
    }

    public function jumlah_target_peralatan($month, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("
            SELECT SUM(VALUE) as TOTAL_TARGET FROM 
                (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                    (
                        SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                            (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                            (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                            (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                            (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                        FROM $whq a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT IN ('0', '1')
                    )
                )
            ");
        return $query->result();
    }

    public function jumlah_target_non_fisik($month, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("
            SELECT SUM(VALUE) as TOTAL_TARGET FROM 
                (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                    (
                        SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                            (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                            (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                            (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                            (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                        FROM $whq a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8 AND IS_PUSAT IN ('0', '1')
                    )
                )
            ");
        return $query->result();
    }

    public function jumlah_target_total($month, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("
            SELECT SUM(VALUE) as TOTAL_TARGET FROM 
                (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                    (
                        SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                            (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                            (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                            (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                            (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                        FROM $whq a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        WHERE a.IS_DELETED =0 AND IS_PUSAT IN ('0', '1')
                    )
                )
            ");
        return $query->result();
    }
    
    //REALISASI TERHADAP TARGET

    public function realisasi_target_sipil($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
        
        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_TARGET, (CASE WHEN  B.TOTAL_TARGET > 0 THEN A.TOTAL_REALISASI / B.TOTAL_TARGET * 100 ELSE 0 END) AS VALUE FROM
               ( 
                    select a.BRANCH_ID,a.BRANCH_NAME,NVL(b.TOTAL_REALISASI,0) as TOTAL_REALISASI from  TR_BRANCH a left join
                    (SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME) b on a.BRANCH_ID = b.BRANCH_ID
                ) A LEFT JOIN 
                (
                    SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')
                        )
                    ) GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_target_peralatan($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_TARGET, (CASE WHEN  B.TOTAL_TARGET > 0 THEN A.TOTAL_REALISASI / B.TOTAL_TARGET * 100 ELSE 0 END) AS VALUE FROM
               ( 
                    select a.BRANCH_ID,a.BRANCH_NAME,NVL(b.TOTAL_REALISASI,0) as TOTAL_REALISASI from  TR_BRANCH a left join
                    (SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME) b on a.BRANCH_ID = b.BRANCH_ID
                ) A LEFT JOIN 
                (
                    SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')
                        )
                    ) GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_target_non_fisik($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_TARGET, (CASE WHEN  B.TOTAL_TARGET > 0 THEN A.TOTAL_REALISASI / B.TOTAL_TARGET * 100 ELSE 0 END) AS VALUE FROM
               ( 
                    select a.BRANCH_ID,a.BRANCH_NAME,NVL(b.TOTAL_REALISASI,0) as TOTAL_REALISASI from  TR_BRANCH a left join
                    (SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8)
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME) b on a.BRANCH_ID = b.BRANCH_ID
                ) A LEFT JOIN 
                (
                    SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8
                        )
                    ) GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function total_realisasi_target($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_TARGET, (CASE WHEN  B.TOTAL_TARGET > 0 THEN A.TOTAL_REALISASI / B.TOTAL_TARGET * 100 ELSE 0 END) AS VALUE FROM
               ( 
                    select a.BRANCH_ID,a.BRANCH_NAME,NVL(b.TOTAL_REALISASI,0) as TOTAL_REALISASI from  TR_BRANCH a left join
                    (SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun')
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME) b on a.BRANCH_ID = b.BRANCH_ID
                ) A LEFT JOIN 
                (
                    SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0
                        )
                    ) GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function jumlah_realisasi_target_sipil($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }


        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT (REALISASI / TARGET * 100) AS VALUE FROM 
            (
            SELECT SUM(A.TOTAL_REALISASI) AS REALISASI, SUM(B.TOTAL_TARGET) AS TARGET FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')  AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT IS_PUSAT, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT IN ('0', '1')
                        ) 
                    ) GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT
            )");
        return $query->result();
    }

    public function jumlah_realisasi_target_peralatan($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT (REALISASI / TARGET * 100) AS VALUE FROM 
            (
            SELECT SUM(A.TOTAL_REALISASI) AS REALISASI, SUM(B.TOTAL_TARGET) AS TARGET FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')  AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT IS_PUSAT, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT IN ('0', '1')
                        ) 
                    ) GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT
            )");
        return $query->result();
    }

    public function jumlah_realisasi_target_non_fisik($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT (REALISASI / TARGET * 100) AS VALUE FROM 
            (
            SELECT SUM(A.TOTAL_REALISASI) AS REALISASI, SUM(B.TOTAL_TARGET) AS TARGET FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8  AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT IS_PUSAT, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8 AND IS_PUSAT IN ('0', '1')
                        ) 
                    ) GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT
            )");
        return $query->result();
    }

    public function jumlah_realisasi_target_total($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT (REALISASI / TARGET * 100) AS value FROM 
            (
            SELECT SUM(A.TOTAL_REALISASI) AS REALISASI, SUM(B.TOTAL_TARGET) AS TARGET FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT IS_PUSAT, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND IS_PUSAT IN ('0', '1')
                        ) 
                    ) GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT
            )");
        return $query->result();
    }

    //REALISASI TERHADAP RKAP
    public function realisasi_rkap_sipil($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_RKAP, (A.TOTAL_REALISASI / B.TOTAL_RKAP * 100) AS VALUE FROM
               ( 
                    SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME
                ) A LEFT JOIN 
                (
                    SELECT c.BRANCH_ID, c.BRANCH_NAME ,SUM(a.RKAP_INVS_VALUE) AS TOTAL_RKAP 
                    FROM $whq a 
                    JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
                    WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')
                    GROUP BY BRANCH_ID, BRANCH_NAME
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_rkap_peralatan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_RKAP, (A.TOTAL_REALISASI / B.TOTAL_RKAP * 100) AS VALUE FROM
               ( 
                    SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME
                ) A LEFT JOIN 
                (
                    SELECT c.BRANCH_ID, c.BRANCH_NAME ,SUM(a.RKAP_INVS_VALUE) AS TOTAL_RKAP 
                    FROM $whq a 
                    JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
                    WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')
                    GROUP BY BRANCH_ID, BRANCH_NAME
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function realisasi_rkap_non($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_RKAP, (A.TOTAL_REALISASI / B.TOTAL_RKAP * 100) AS VALUE FROM
               ( 
                    SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8)
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME
                ) A LEFT JOIN 
                (
                    SELECT c.BRANCH_ID, c.BRANCH_NAME ,SUM(a.RKAP_INVS_VALUE) AS TOTAL_RKAP 
                    FROM $whq a 
                    JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
                    WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8
                    GROUP BY BRANCH_ID, BRANCH_NAME
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function total_realisasi_rkap($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.VALUE FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_RKAP, (A.TOTAL_REALISASI / B.TOTAL_RKAP * 100) AS VALUE FROM
               ( 
                    SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' )
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME
                ) A LEFT JOIN 
                (
                    SELECT c.BRANCH_ID, c.BRANCH_NAME ,SUM(a.RKAP_INVS_VALUE) AS TOTAL_RKAP 
                    FROM $whq a 
                    JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
                    WHERE a.IS_DELETED =0
                    GROUP BY BRANCH_ID, BRANCH_NAME
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");

            return $query->result();
    }

    public function jumlah_realisasi_rkap_sipil($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT A.IS_PUSAT, A.TOTAL_REALISASI, B.TOTAL_RKAP, (A.TOTAL_REALISASI / B.TOTAL_RKAP * 100) AS VALUE FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT c.IS_PUSAT, SUM(a.RKAP_INVS_VALUE) AS TOTAL_RKAP 
                    FROM $whq a 
                    JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
                    WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND  IS_PUSAT IN ('1','0')
                    GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT");
        if (count($query->row()) > 0) {
            return $query->result();
        } else {
            $data = array((object)array('VALUE' => 0));
            return $data;
        }
    }

    public function jumlah_realisasi_rkap_peralatan($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT A.IS_PUSAT, A.TOTAL_REALISASI, B.TOTAL_RKAP, (A.TOTAL_REALISASI / B.TOTAL_RKAP * 100) AS VALUE FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT c.IS_PUSAT, SUM(a.RKAP_INVS_VALUE) AS TOTAL_RKAP 
                    FROM $whq a 
                    JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
                    WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND  IS_PUSAT IN ('1','0')
                    GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT");

                if (count($query->row()) > 0) {
                    return $query->result();
                } else {
                    $data = array((object)array('VALUE' => 0));
                    return $data;
                }
    }

    public function jumlah_realisasi_rkap_non($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        $query =$this->db->query("SELECT A.IS_PUSAT, A.TOTAL_REALISASI, B.TOTAL_RKAP, (A.TOTAL_REALISASI / B.TOTAL_RKAP * 100) AS  VALUE FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = $get_tahun AND c.RKAP_INVS_ASSETS = 8 AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT c.IS_PUSAT, SUM(a.RKAP_INVS_VALUE) AS TOTAL_RKAP 
                    FROM $whq a 
                    JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
                    WHERE a.IS_DELETED =0  AND a.RKAP_INVS_ASSETS = 8 AND  IS_PUSAT IN ('1','0')
                    GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT");
        
        if (count($query->row()) > 0) {
            return $query->result();
        } else {
            $data = array((object)array('VALUE' => 0));
            return $data;
        }
    }

    public function jumlah_realisasi_rkap_total($get_bulan, $get_tahun) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }
        $query =$this->db->query("SELECT A.IS_PUSAT, A.TOTAL_REALISASI, B.TOTAL_RKAP, (A.TOTAL_REALISASI / B.TOTAL_RKAP * 100) AS VALUE FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun'AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT c.IS_PUSAT, SUM(a.RKAP_INVS_VALUE) AS TOTAL_RKAP 
                    FROM $whq a 
                    JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID 
                    WHERE a.IS_DELETED =0 AND  IS_PUSAT IN ('1','0')
                    GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT");
        if (count($query->row()) > 0) {
            return $query->result();
        } else {
            $data = array((object)array('VALUE' => 0));
            return $data;
        }
    }

    //REALISASI TERHADAP TARGET

    public function deviasi_sipil($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.DEVIASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_TARGET, (A.TOTAL_REALISASI - B.TOTAL_TARGET) AS DEVIASI FROM
               ( 
                    select a.BRANCH_ID,a.BRANCH_NAME,NVL(b.TOTAL_REALISASI,0) as TOTAL_REALISASI from  TR_BRANCH a left join
                    (SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME) b on a.BRANCH_ID = b.BRANCH_ID
                ) A LEFT JOIN 
                (
                    SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')
                        )
                    ) GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function deviasi_peralatan($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.DEVIASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_TARGET, (A.TOTAL_REALISASI - B.TOTAL_TARGET) AS DEVIASI FROM
               ( 
                    select a.BRANCH_ID,a.BRANCH_NAME,NVL(b.TOTAL_REALISASI,0) as TOTAL_REALISASI from  TR_BRANCH a left join
                    (SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME) b on a.BRANCH_ID = b.BRANCH_ID
                ) A LEFT JOIN 
                (
                    SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')
                        )
                    ) GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function deviasi_non_fisik($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.DEVIASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_TARGET, (A.TOTAL_REALISASI - B.TOTAL_TARGET) AS DEVIASI FROM
               ( 
                select a.BRANCH_ID,a.BRANCH_NAME,NVL(b.TOTAL_REALISASI,0) as TOTAL_REALISASI from  TR_BRANCH a left join
                    (SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8)
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME) b on a.BRANCH_ID = b.BRANCH_ID
                ) A LEFT JOIN 
                (
                    SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8
                        )
                    ) GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function total_deviasi($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT A.BRANCH_ID, A.BRANCH_NAME, B.DEVIASI FROM
            ( 
                SELECT * FROM TR_BRANCH
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, A.BRANCH_NAME, A.TOTAL_REALISASI, B.TOTAL_TARGET, (A.TOTAL_REALISASI - B.TOTAL_TARGET) AS DEVIASI FROM
               ( 
                select a.BRANCH_ID,a.BRANCH_NAME,NVL(b.TOTAL_REALISASI,0) as TOTAL_REALISASI from  TR_BRANCH a left join
                    (SELECT BRANCH_ID, BRANCH_NAME, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.BRANCH_ID, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun')
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, BRANCH_ID, BRANCH_NAME)
                    GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY BRANCH_ID, BRANCH_NAME) b on a.BRANCH_ID = b.BRANCH_ID
                ) A LEFT JOIN 
                (
                    SELECT BRANCH_ID, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT BRANCH_ID, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT BRANCH_ID, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0
                        )
                    ) GROUP BY BRANCH_ID
                ) B ON A.BRANCH_ID = B.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->result();
    }

    public function jumlah_deviasi_sipil($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT (REALISASI - TARGET) AS DEVIASI FROM 
            (
            SELECT SUM(A.TOTAL_REALISASI) AS REALISASI, SUM(B.TOTAL_TARGET) AS TARGET FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('1', '3', '9', '7')  AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT IS_PUSAT, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('1', '3', '9', '7') AND IS_PUSAT IN ('0', '1')
                        ) 
                    ) GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT
            )");
        return $query->result();
    }

    public function jumlah_deviasi_peralatan($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT (REALISASI - TARGET) AS DEVIASI FROM 
            (
            SELECT SUM(nvl(A.TOTAL_REALISASI,0)) AS REALISASI, SUM(B.TOTAL_TARGET) AS TARGET FROM
               ( 
                    SELECT IS_PUSAT, SUM(NVL(REAL_SUBPRO_VAL,0)) AS TOTAL_REALISASI
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10')  AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A full JOIN 
                (
                    SELECT IS_PUSAT, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS IN ('2', '4', '5', '6', '10') AND IS_PUSAT IN ('0', '1')
                        ) 
                    ) GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT
            )");
        return $query->result();
    }

    public function jumlah_deviasi_non_fisik($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT (REALISASI - TARGET) AS DEVIASI FROM 
            (
                SELECT SUM(nvl(A.TOTAL_REALISASI,0)) AS REALISASI, SUM(B.TOTAL_TARGET) AS TARGET FROM
               ( 
                    SELECT IS_PUSAT, SUM(NVL(REAL_SUBPRO_VAL,0)) AS TOTAL_REALISASI
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND c.RKAP_INVS_ASSETS = 8  AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A full JOIN 
                (
                    SELECT IS_PUSAT, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ASSETS = 8 AND IS_PUSAT IN ('0', '1')
                        ) 
                    ) GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT
            )");
        return $query->result();
    }

    public function jumlah_deviasi_total($get_bulan, $get_tahun, $month) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($get_tahun < $tn) {
            $whq = "(select * from tx_rkap_investation_v where tahun = '".$get_tahun."')";
        }else{
            $whq = "(select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y')";
        }

        if ($month == 01) {
            $sum = "(jan) as VALUE";
        } else if ($month == 02) {
            $sum = "(jan + feb) as VALUE";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as VALUE";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as VALUE";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as VALUE";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as VALUE";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as VALUE";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as VALUE";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as VALUE";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as VALUE";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as VALUE";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as VALUE";
        };

        $query =$this->db->query("SELECT (REALISASI - TARGET) AS DEVIASI FROM 
            (
            SELECT SUM(A.TOTAL_REALISASI) AS REALISASI, SUM(B.TOTAL_TARGET) AS TARGET FROM
               ( 
                    SELECT IS_PUSAT, SUM(REAL_SUBPRO_VAL) AS TOTAL_REALISASI 
                    FROM (SELECT IS_PUSAT, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE 
                    FROM (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME
                    FROM (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_STATUS,
                    c.RKAP_INVS_VALUE, c.RKAP_INVS_ASSETS, d.USER_ID,  e.IS_PUSAT, e.BRANCH_NAME
                    FROM TX_RKAP_SUB_PROGRAM a
                    JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    JOIN $whq c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                    JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                    JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_STATUS != 2 AND b.REAL_SUBPRO_YEAR = '$get_tahun' AND IS_PUSAT IN ('1', '0'))
                    WHERE AA <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE, IS_PUSAT, BRANCH_NAME)
                    GROUP BY IS_PUSAT, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
                    GROUP BY IS_PUSAT
                ) A LEFT JOIN 
                (
                    SELECT IS_PUSAT, SUM(VALUE) as TOTAL_TARGET FROM 
                    (   SELECT IS_PUSAT, RKAP_INVS_ID, $sum FROM
                        (
                            SELECT IS_PUSAT, a.RKAP_INVS_ID, a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, 
                                (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, 
                                (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, 
                                (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, 
                                (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
                            FROM $whq a
                            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                            WHERE a.IS_DELETED =0 AND IS_PUSAT IN ('0', '1')
                        ) 
                    ) GROUP BY IS_PUSAT
                ) B ON A.IS_PUSAT = B.IS_PUSAT
            )");
        return $query->result();
    }

}

?>