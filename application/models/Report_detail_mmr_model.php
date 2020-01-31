<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_detail_mmr_model extends CI_Model {

    public function get_assets($id){
        $query = $this->db->query("SELECT d.invs_type_id,d.invs_type_code,d.invs_type_name
        FROM TX_RKAP_INVESTATION a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        join tm_investation_type d ON a.rkap_invs_type = d.invs_type_id
        WHERE a.IS_DELETED =0 AND c.branch_id = $id
        GROUP BY c.BRANCH_NAME,d.invs_type_id,d.invs_type_code,d.invs_type_name
        order by d.invs_type_id");

        return $query->result();
    }

    public function get_rkap($id_branch,$aaa, $bbb, $get_tahun){
        // $this->db->select('*');
        // $this->db->from('TX_RKAP_INVESTATION a');
        // $this->db->join('TM_ASSETS b', 'a.RKAP_INVS_ASSETS = b.ASSETS_ID', 'left');
        // $this->db->join('TM_INVESTATION_TYPE c', 'a.RKAP_INVS_TYPE = c.INVS_TYPE_ID', 'left');
        // $this->db->join('TM_POSITION_PROGRAM d', 'a.RKAP_INVS_POS = d.POSPROG_ID', 'left');
        // $this->db->join('TM_USERS e', 'a.RKAP_INVS_USER_ID = e.USER_ID', 'left');
        // $this->db->join('TR_BRANCH f', 'e.USER_BRANCH = f.BRANCH_ID', 'left');
        // $this->db->where('a.IS_DELETED', 0);
        // $this->db->where('BRANCH_ID', $id_branch);
        // $this->db->where('RKAP_INVS_TYPE', $aaa);
        // $this->db->where('ASSETS_ID', $bbb);
        // $this->db->where('RKAP_INVS_YEAR', $get_tahun);
        // $this->db->order_by('ASSETS_NAME', 'ASC');
        // $query = $this->db->get();

        $query = $this->db->query("SELECT a.RKAP_INVS_ID, a.RKAP_INVS_TITLE, (a.RKAP_INVS_COST_REQ / 1000) as RKAP_INVS_COST_REQ, (a.RKAP_INVS_VALUE / 1000) as RKAP_INVS_VALUE, (a.RKAP_INVS_TAKSASI / 1000) as RKAP_INVS_TAKSASI, a.RKAP_INVS_ASSETS , b.ASSETS_COA, b.ASSETS_NAME, d.POSPROG_ID, d.POSPROG_NAME
            FROM TX_RKAP_INVESTATION a 
            LEFT JOIN TM_ASSETS b ON a.RKAP_INVS_ASSETS = b.ASSETS_ID 
            LEFT JOIN TM_INVESTATION_TYPE c ON a.RKAP_INVS_TYPE = c.INVS_TYPE_ID 
            LEFT JOIN TM_POSITION_PROGRAM d ON a.RKAP_INVS_POS = d.POSPROG_ID 
            LEFT JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID 
            LEFT JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID 
        WHERE a.IS_DELETED =0 AND BRANCH_ID = '$id_branch' AND RKAP_INVS_TYPE = '$aaa' AND ASSETS_ID ='$bbb' AND RKAP_INVS_YEAR = '$get_tahun'");

        return $query->result();
    }

    public function get_aktiva($id_branch,$aaa, $bbb){
        $this->db->select('ASSETS_ID, ASSETS_NAME');
        $this->db->from('TX_RKAP_INVESTATION a');
        $this->db->join('TM_ASSETS b', 'a.RKAP_INVS_ASSETS = b.ASSETS_ID', 'left');
        $this->db->join('TM_USERS e', 'a.RKAP_INVS_USER_ID = e.USER_ID', 'left');
        $this->db->join('TR_BRANCH f', 'e.USER_BRANCH = f.BRANCH_ID', 'left');
        $this->db->where('a.IS_DELETED', 0);
        $this->db->where('BRANCH_ID', $id_branch);
        $this->db->where('RKAP_INVS_TYPE', $aaa);
        $this->db->where('RKAP_INVS_YEAR', $bbb);
        $this->db->order_by('ASSETS_NAME', 'ASC');
        $this->db->group_by('ASSETS_ID, ASSETS_NAME');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_constraints($get_bulan){

        $query = $this->db->query("SELECT a.RKAP_SUBPRO_ID, b.REAL_SUBPRO_ID, b.REAL_SUBPRO_DEADLINE, b.CONTRAINTS_ID, b.CONTRAINTS_NAME FROM
            (
                SELECT RKAP_SUBPRO_ID FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
            ) a LEFT JOIN (
                SELECT a.RKAP_SUBPRO_ID, b.REAL_SUBPRO_ID, b.REAL_SUBPRO_DEADLINE, c.CONTRAINTS_ID,c.CONTRAINTS_NAME 
                FROM TX_RKAP_SUB_PROGRAM a
                    LEFT JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    LEFT JOIN TM_CONTRAINTS c ON b.REAL_SUBPRO_CONSTRAINTS = c.CONTRAINTS_ID   
                WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') <= '$get_bulan'
                ORDER BY b.REAL_SUBPRO_ID ASC
            )b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
        ");
        return $query->result();

    }

    public function aktiva_years($id_branch,$aaa, $get_tahun){
        if ($aaa == 1) {
            $where = $this->db->where('RKAP_INVS_YEAR', $get_tahun);
        } else {
            $where = $this->db->group_by('RKAP_INVS_YEAR');
        }

        $this->db->select('a.RKAP_INVS_YEAR');
        $this->db->from('TX_RKAP_INVESTATION a');
        $this->db->join('TM_ASSETS b', 'a.RKAP_INVS_ASSETS = b.ASSETS_ID', 'left');
        $this->db->join('TM_INVESTATION_TYPE c', 'a.RKAP_INVS_TYPE = c.INVS_TYPE_ID', 'left');
        $this->db->join('TM_POSITION_PROGRAM d', 'a.RKAP_INVS_POS = d.POSPROG_ID', 'left');
        $this->db->join('TM_USERS e', 'a.RKAP_INVS_USER_ID = e.USER_ID', 'left');
        $this->db->join('TR_BRANCH f', 'e.USER_BRANCH = f.BRANCH_ID', 'left');
        $this->db->where('a.IS_DELETED', 0);
        $this->db->where('BRANCH_ID', $id_branch);
        $this->db->where('RKAP_INVS_TYPE', $aaa);
        $this->db->group_by('RKAP_INVS_YEAR');
        $this->db->order_by('RKAP_INVS_YEAR', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    // SUBPROGRAM
    public function get_subpro($aaa){
        // $this->db->select('b.RKAP_SUBPRO_ID, b.RKAP_SUBPRO_TITTLE, b.RKAP_SUBPRO_CONTRACT_NO, b.RKAP_SUBPRO_CONTRACT_DATE, b.RKAP_SUBPRO_CONTRACTOR, b.RKAP_SUBPRO_PERIODE, b.RKAP_SUBPRO_CONTRACT_VALUE');
        // $this->db->from('TX_RKAP_INVESTATION a');
        // $this->db->join('TX_RKAP_SUB_PROGRAM b', 'a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID', 'left');
        // $this->db->join('TM_USERS d', 'a.RKAP_INVS_USER_ID = d.USER_ID', 'left');
        // $this->db->join('TR_BRANCH e', 'd.USER_BRANCH = e.BRANCH_ID', 'left');
        // $this->db->where('a.IS_DELETED', 0);
        // $this->db->where('b.IS_DELETED', 0);
        // $this->db->where('RKAP_INVS_ID', $aaa);
        // $this->db->order_by('b.RKAP_SUBPRO_ID', 'ASC');
        // $query = $this->db->get();

        $query = $this->db->query("SELECT b.RKAP_SUBPRO_ID, b.RKAP_SUBPRO_TITTLE, b.RKAP_SUBPRO_CONTRACT_NO, b.RKAP_SUBPRO_CONTRACT_DATE, b.RKAP_SUBPRO_CONTRACTOR, b.RKAP_SUBPRO_PERIODE, (b.RKAP_SUBPRO_CONTRACT_VALUE / 1000) as RKAP_SUBPRO_CONTRACT_VALUE
        FROM TX_RKAP_INVESTATION a 
            LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
            LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
            LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID 
        WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND RKAP_INVS_ID = '$aaa' ORDER BY b.RKAP_SUBPRO_ID ASC");

        return $query->result();
    }

    public function get_assets_name($id_branch, $a, $b, $get_tahun){

        // $this->db->select('d.ASSETS_NAME');
        // $this->db->from('TR_BRANCHa a');
        // $this->db->join('TM_USERS b', 'a.BRANCH_ID = b.USER_BRANCH', 'left');
        // $this->db->join('TX_RKAP_INVESTATION c', 'b.USER_ID = c.RKAP_INVS_USER_ID', 'left');
        // $this->db->join('TM_ASSETS d', 'c.RKAP_INVS_ASSETS = d.ASSETS_ID', 'left');
        // $this->db->where('c.IS_DELETED', 0);
        // $this->db->where('a.BRANCH_ID', $id_branch);
        // $this->db->where('c.RKAP_INVS_ASSETS', $a);
        // $this->db->where('c.RKAP_INVS_TYPE', $b);
        // $this->db->where('RKAP_INVS_YEAR', $get_tahun);
        // $query = $this->db->get();

        $query = $this->db->query("SELECT d.ASSETS_NAME 
        FROM TR_BRANCH a 
            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
            LEFT JOIN TM_ASSETS d ON c.RKAP_INVS_ASSETS = d.ASSETS_ID 
        WHERE c.IS_DELETED =0 AND a.BRANCH_ID = '$id_branch' AND c.RKAP_INVS_ASSETS = '$a' AND c.RKAP_INVS_TYPE = '$b' AND RKAP_INVS_YEAR <= '$get_tahun'");
        return $query->result();
    }

    public function get_value_rkap($id_branch, $a, $b, $get_tahun){

        // $this->db->select_sum('c.RKAP_INVS_COST_REQ');
        // $this->db->select_sum('c.RKAP_INVS_VALUE');
        // $this->db->from('TR_BRANCHa a');
        // $this->db->join('TM_USERS b', 'a.BRANCH_ID = b.USER_BRANCH', 'left');
        // $this->db->join('TX_RKAP_INVESTATION c', 'b.USER_ID = c.RKAP_INVS_USER_ID', 'left');
        // $this->db->where('c.IS_DELETED', 0);
        // $this->db->where('a.BRANCH_ID', $id_branch);
        // $this->db->where('c.RKAP_INVS_ASSETS', $a);
        // $this->db->where('c.RKAP_INVS_TYPE', $b);
        // $this->db->where('RKAP_INVS_YEAR', $get_tahun);
        // $query = $this->db->get();

        $query = $this->db->query("SELECT SUM(c.RKAP_INVS_COST_REQ / 1000) AS RKAP_INVS_COST_REQ, SUM(c.RKAP_INVS_VALUE / 1000) AS RKAP_INVS_VALUE 
        FROM TR_BRANCH a 
            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
        WHERE c.IS_DELETED =0 AND a.BRANCH_ID = '$id_branch' AND c.RKAP_INVS_ASSETS = '$a' AND c.RKAP_INVS_TYPE = '$b' AND RKAP_INVS_YEAR = '$get_tahun'");
        return $query->result();
    }

    public function previous_year($get_tahun) { //realisasi s/d tahun lalu
        $query = $this->db->query("SELECT A.RKAP_SUBPRO_ID, (B.REALISASI / 1000) as REALISASI, B.PERCENT FROM
            (
                SELECT RKAP_SUBPRO_ID FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
            ) A LEFT JOIN 
            (
                SELECT a.RKAP_SUBPRO_ID, SUM(b.REAL_SUBPRO_VAL) AS REALISASI, SUM(b.REAL_SUBPRO_PERCENT) AS PERCENT
                FROM TX_RKAP_SUB_PROGRAM a
                LEFT JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
                WHERE a.IS_DELETED = 0 and b.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR < $get_tahun
                GROUP BY a.RKAP_SUBPRO_ID
            ) B ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID");
        return $query->result();
    }

    public function get_contract($get_tahun) { //kontrak tahun ini
        $query = $this->db->query("SELECT A.RKAP_SUBPRO_ID, (B.NILAI_KONTRAK / 1000) as NILAI_KONTRAK FROM
            (
                SELECT RKAP_SUBPRO_ID FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
            ) A LEFT JOIN 
            (
                SELECT RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                    (
                        SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                            (
                                SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                    (
                                        SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, b.SUBPRO_VALUE, TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(b.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                        (
                                            CASE 
                                                WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                                WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                            ELSE
                                                RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                            END
                                        )   AS PERSENTASE_BEFORE
                                        FROM TX_RKAP_SUB_PROGRAM a 
                                            LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                        WHERE a.IS_DELETED =0 
                                    )
                                WHERE TAHUN = $get_tahun
                                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                            )
                    )
            )B ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID");
        return $query->result();
    }

    public function get_target($get_bulan) {
        $query = $this->db->query("SELECT A.RKAP_SUBPRO_ID, (B.NILAI_KONTRAK / 1000) as NILAI_KONTRAK FROM
            (
                SELECT RKAP_SUBPRO_ID FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
            ) A LEFT JOIN 
            (
                SELECT RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                    (
                        SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                            (
                                SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                    (
                                        SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_CONTRACT_VALUE, b.SUBPRO_VALUE, TO_CHAR(b.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(b.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                        (
                                            CASE 
                                                WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                                WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                            ELSE
                                                RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                            END
                                        )   AS PERSENTASE_BEFORE
                                        FROM TX_RKAP_SUB_PROGRAM a 
                                            LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                        WHERE a.IS_DELETED =0 
                                    )
                                WHERE TANGGAL <= '$get_bulan'
                                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                            )
                    )
            )B ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID");
        return $query->result();
    }

    public function previous_month($get_tahun, $get_bulan) { // change to <=
        $query = $this->db->query("SELECT A.RKAP_SUBPRO_ID, (B.REALISASI / 1000) as REALISASI, B.PERCENT, (B.COST / 1000) as COST, (B.TOTAL / 1000) as TOTAL FROM
            (
                SELECT RKAP_SUBPRO_ID FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
            ) A LEFT JOIN 
            (
                SELECT RKAP_SUBPRO_ID, REALISASI, PERCENT, COST, (REALISASI + COST) AS TOTAL FROM
                (
                    SELECT RKAP_SUBPRO_ID, SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_PERCENT) AS PERCENT, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT a.RKAP_SUBPRO_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_PERCENT, b.REAL_SUBPRO_COST
                        FROM TX_RKAP_SUB_PROGRAM a
                        LEFT JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
                        WHERE a.IS_DELETED = 0 and b.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR = $get_tahun
                    ) 
                    WHERE BULAN < '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID
                )
            ) B ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID");
        return $query->result();
    }

    public function until($get_tahun, $get_bulan) { // change to <=
        $query = $this->db->query("SELECT A.RKAP_SUBPRO_ID, (B.REALISASI / 1000) as REALISASI, B.PERCENT, (B.COST / 1000) as COST, (B.TOTAL / 1000) as TOTAL FROM
            (
                SELECT RKAP_SUBPRO_ID FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
            ) A LEFT JOIN 
            (
                SELECT RKAP_SUBPRO_ID, REALISASI, PERCENT, COST, (REALISASI + COST) AS TOTAL FROM
                (
                    SELECT RKAP_SUBPRO_ID, SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_PERCENT) AS PERCENT, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT a.RKAP_SUBPRO_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_PERCENT, b.REAL_SUBPRO_COST
                        FROM TX_RKAP_SUB_PROGRAM a
                        LEFT JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
                        WHERE a.IS_DELETED = 0 and b.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR = $get_tahun
                    ) 
                    WHERE BULAN <= '$get_bulan'
                    GROUP BY RKAP_SUBPRO_ID
                )
            ) B ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID");
        return $query->result();
    }

    public function this_month($get_bulan) {
        $query = $this->db->query("SELECT A.RKAP_SUBPRO_ID, (B.REALISASI / 1000) as REALISASI, B.PERCENT, (B.COST / 1000) as COST, (B.TOTAL / 1000) as TOTAL FROM
            (
                SELECT RKAP_SUBPRO_ID FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
            ) A LEFT JOIN 
            (
                SELECT RKAP_SUBPRO_ID, REALISASI, PERCENT, COST, (REALISASI + COST) AS TOTAL FROM
                (
                    SELECT RKAP_SUBPRO_ID, (REAL_SUBPRO_VAL) AS REALISASI, (REAL_SUBPRO_PERCENT) AS PERCENT, (REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT a.RKAP_SUBPRO_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_PERCENT, b.REAL_SUBPRO_COST
                        FROM TX_RKAP_SUB_PROGRAM a
                        LEFT JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
                        WHERE a.IS_DELETED = 0 and b.IS_DELETED = 0 
                    ) 
                    WHERE BULAN = '$get_bulan'
                )
            ) B ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID");
        return $query->result();
    }

    public function total_real($get_bulan) {
        $query = $this->db->query("SELECT A.RKAP_SUBPRO_ID, (B.REALISASI / 1000) as REALISASI, B.PERCENT FROM
            (
                SELECT RKAP_SUBPRO_ID FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
            ) A LEFT JOIN 
            (
                SELECT RKAP_SUBPRO_ID, SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_PERCENT) AS PERCENT FROM 
                    (
                        SELECT a.RKAP_SUBPRO_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, b.REAL_SUBPRO_VAL, b.REAL_SUBPRO_PERCENT
                        FROM TX_RKAP_SUB_PROGRAM a
                        LEFT JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
                        WHERE a.IS_DELETED = 0 and b.IS_DELETED = 0 
                    ) 
                WHERE BULAN <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID
            ) B ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID");
        return $query->result();
    }

    public function get_deviasi($get_bulan) {
        $query = $this->db->query("SELECT A.RKAP_SUBPRO_ID, B.DEVIASI FROM
            (
                SELECT RKAP_SUBPRO_ID FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0
            ) A LEFT JOIN 
            (
                SELECT RKAP_SUBPRO_ID, MAX(REAL_SUBPRO_PERCENT_TOT) as DEVIASI FROM
                    (
                    SELECT a.RKAP_SUBPRO_ID, b.REAL_SUBPRO_PERCENT_TOT, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') AS TANGGAL
                    FROM TX_RKAP_SUB_PROGRAM a
                        LEFT JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 
                    ) 
                WHERE TANGGAL <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID
            ) B ON A.RKAP_SUBPRO_ID = B.RKAP_SUBPRO_ID");
        return $query->result();
    }

    public function get_status($id_branch, $get_tahun, $type) { // change to <=
        $query = $this->db->query("SELECT A.BRANCH_ID, A.RKAP_INVS_ID, A.RKAP_INVS_TYPE, B.REAL_SUBPRO_STATUS FROM
                (
                    SELECT c.BRANCH_ID, a.RKAP_INVS_ID,a.RKAP_INVS_TYPE
                    FROM TX_RKAP_INVESTATION a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $id_branch AND a.RKAP_INVS_YEAR <= $get_tahun AND RKAP_INVS_TYPE = $type
                ) A LEFT JOIN
                (
                    SELECT distinct c.BRANCH_ID, a.RKAP_INVS_ID,a.RKAP_INVS_TYPE, e.REAL_SUBPRO_STATUS
                    FROM TX_RKAP_INVESTATION a
                        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                        JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                        JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 AND d.IS_DELETED =0 AND e.IS_DELETED =0 AND c.BRANCH_ID = $id_branch AND e.REAL_SUBPRO_STATUS <> 2 AND a.RKAP_INVS_YEAR <= $get_tahun AND a.RKAP_INVS_TYPE = $type
                ) B ON A.RKAP_INVS_ID = B.RKAP_INVS_ID");
        return $query->result();
    }

    // ADDENDUM
    public function get_addendum($aaa){
        $this->db->select('*');
        $this->db->from('TX_SUB_PROGRAM_ADDENDUM a');
        $this->db->join('TX_RKAP_SUB_PROGRAM b', 'a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID');
        $this->db->where('a.IS_DELETED', 0);
        $this->db->where('a.RKAP_SUBPRO_ID', $aaa);
        $this->db->order_by('a.RKAP_SUBPRO_ID', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    // TOTAL DETAIL MMR
    public function total_contract($id_branch, $a, $b, $get_tahun){ // change to <=

        $query = $this->db->query("SELECT SUM(B.RKAP_SUBPRO_CONTRACT_VALUE / 1000) AS RKAP_SUBPRO_CONTRACT_VALUE FROM
        (
            SELECT c.RKAP_INVS_ID
            FROM TR_BRANCH a
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
            WHERE a.BRANCH_ID = $id_branch AND c.RKAP_INVS_YEAR = $get_tahun AND c.IS_DELETED = 0
        )A LEFT JOIN (
            SELECT c.RKAP_INVS_ID, d.RKAP_SUBPRO_CONTRACT_VALUE
            FROM TR_BRANCH a 
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
                LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID 
            WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_ASSETS = $a AND c.RKAP_INVS_TYPE = $b
        )B ON A.RKAP_INVS_ID = B.RKAP_INVS_ID");
        return $query->result();
    }

    public function total_contact_year($id_branch, $a, $b, $c, $get_tahun) {
        // if ($b == 1) {
        //     $where = "WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_ASSETS = $a AND RKAP_INVS_TYPE = $b AND TO_CHAR(e.SUBPRO_YEARS, 'YYYY') = '$get_tahun'";
        // } else {
        //     $where = "WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_ASSETS = $a AND RKAP_INVS_TYPE = $b AND TO_CHAR(e.SUBPRO_YEARS, 'YYYY') = '$get_tahun'";
        // }

        $query = $this->db->query("SELECT SUM(NILAI_KONTRAK / 1000) AS NILAI_KONTRAK FROM
            (
                SELECT RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                (
                    SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                        (
                            SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                (
                                    SELECT d.RKAP_SUBPRO_ID, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_VALUE, TO_CHAR(e.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(e.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                    (
                                        CASE 
                                            WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                            WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                        ELSE
                                            RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    )   AS PERSENTASE_BEFORE
                                    FROM TR_BRANCH a
                                        LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                        LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                    WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_ASSETS = $a AND RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c
                                )
                            WHERE TAHUN = $get_tahun
                            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                        )
                )
            )");
        return $query->result();
    }

    public function total_target($id_branch, $a, $b, $c, $get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT SUM(NILAI_KONTRAK / 1000) AS NILAI_KONTRAK FROM
            (SELECT RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                (
                    SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                        (
                            SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                (
                                    SELECT d.RKAP_SUBPRO_ID, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_VALUE, TO_CHAR(e.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(e.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                    (
                                        CASE 
                                            WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                            WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                        ELSE
                                            RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    )   AS PERSENTASE_BEFORE
                                    FROM TR_BRANCH a
                                        LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                        LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                    WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_ASSETS = $a AND RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c AND TO_CHAR(e.SUBPRO_YEARS, 'YYYY') <= $get_tahun
                                )
                            WHERE TANGGAL <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                        )
                )
            )");
        return $query->result();
    }

    public function total_previous_year($id_branch, $c, $a, $b, $get_tahun) {
        $query = $this->db->query("SELECT (CASE WHEN SUM(B.REAL_SUBPRO_VAL) IS NULL THEN 0 ELSE SUM(B.REAL_SUBPRO_VAL / 1000) END) AS REALISASI FROM
            (
                SELECT c.RKAP_INVS_ID
                FROM TR_BRANCH a
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                WHERE a.BRANCH_ID = $id_branch AND c.RKAP_INVS_YEAR = $c AND c.IS_DELETED = 0
            )A LEFT JOIN (
                SELECT c.RKAP_INVS_ID, e.REAL_SUBPRO_VAL
                FROM TR_BRANCH a
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                    LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_ASSETS = $a AND c.RKAP_INVS_TYPE = $b AND e.REAL_SUBPRO_YEAR < $get_tahun
            )B ON A.RKAP_INVS_ID = B.RKAP_INVS_ID");
        return $query->result();
    }

    public function total_previous_month($id_branch, $a, $b, $c, $get_tahun, $get_bulan) { // change to <=
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST, e.REAL_SUBPRO_YEAR
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_ASSETS = $a AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c
                    ) 
                    WHERE REAL_SUBPRO_YEAR = $get_tahun AND BULAN < '$get_bulan'
                )");
        return $query->result();
    }

    public function total_this_month($id_branch, $a, $b, $c, $get_tahun, $get_bulan) {
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST, e.REAL_SUBPRO_YEAR
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_ASSETS = $a AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c
                    ) 
                    WHERE REAL_SUBPRO_YEAR = $get_tahun AND BULAN = '$get_bulan'
                )");
        return $query->result();
    }

    public function total_until($id_branch, $a, $b, $c, $get_tahun, $get_bulan) { // change to <=
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST, e.REAL_SUBPRO_YEAR
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_ASSETS = $a AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c
                    ) 
                    WHERE REAL_SUBPRO_YEAR = $get_tahun AND BULAN <= '$get_bulan'
                )");
        return $query->result();
    }

    public function total_value_real($id_branch, $a, $b, $get_bulan, $get_tahun) { // change to <=

        $query = $this->db->query("SELECT SUM(e.REAL_SUBPRO_VAL / 1000) AS REALISASI
                FROM TR_BRANCH a
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                    LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_ASSETS = $a AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $get_tahun AND TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') <= '$get_bulan'");
        return $query->result();
    }

    public function total_tax($id_branch, $a, $b, $get_tahun) { // change to <=
        $query = $this->db->query("SELECT SUM(c.RKAP_INVS_TAKSASI / 1000) AS TAX
            FROM TR_BRANCH a
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
            WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND c.RKAP_INVS_ASSETS = $a AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR <= $get_tahun");
        return $query->result();
    }

    // total investasi
    public function invs_value_rkap($id_branch, $a, $get_tahun){ // change to <=
        
        if ($a == 1) {
            $where = "WHERE c.IS_DELETED =0 AND a.BRANCH_ID = '$id_branch' AND c.RKAP_INVS_TYPE = '$a' AND RKAP_INVS_YEAR = '$get_tahun'";
        } else {
            $where = "WHERE c.IS_DELETED =0 AND a.BRANCH_ID = '$id_branch' AND c.RKAP_INVS_TYPE = '$a' AND RKAP_INVS_YEAR <= '$get_tahun'";
        }

        $query = $this->db->query("SELECT SUM(c.RKAP_INVS_COST_REQ / 1000) AS RKAP_INVS_COST_REQ, SUM(c.RKAP_INVS_VALUE / 1000) AS RKAP_INVS_VALUE 
            FROM TR_BRANCH a 
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
            $where");
        return $query->result();
    }

    public function invs_contract($id_branch, $a, $get_tahun){ // change to <=
        if ($a == 1) {
            $where = "WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_TYPE = $a AND c.RKAP_INVS_YEAR = $get_tahun";
        } else {
            $where = "WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_TYPE = $a AND c.RKAP_INVS_YEAR <= $get_tahun";
        }

        $query = $this->db->query("SELECT SUM(d.RKAP_SUBPRO_CONTRACT_VALUE / 1000) AS RKAP_SUBPRO_CONTRACT_VALUE
            FROM TR_BRANCH a 
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
                LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID 
            $where");
        return $query->result();
    }

    public function invs_contact_year($id_branch, $a, $get_tahun) {
        $query = $this->db->query("SELECT SUM(NILAI_KONTRAK / 1000) AS NILAI_KONTRAK FROM
            (
                SELECT RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                (
                    SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                        (
                            SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                (
                                    SELECT d.RKAP_SUBPRO_ID, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_VALUE, TO_CHAR(e.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(e.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                    (
                                        CASE 
                                            WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                            WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                        ELSE
                                            RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    )   AS PERSENTASE_BEFORE
                                    FROM TR_BRANCH a
                                        LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                        LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                    WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND RKAP_INVS_TYPE = $a
                                )
                            WHERE TAHUN = $get_tahun
                            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                        )
                )
            )");
        return $query->result();
    }

    public function invs_target($id_branch, $a, $get_bulan, $get_tahun) {
        if ($a == 1) {
            $where = "WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND RKAP_INVS_TYPE = $a AND TO_CHAR(e.SUBPRO_YEARS, 'YYYY') = $get_tahun";
        } else {
            $where = "WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND RKAP_INVS_TYPE = $a";
        }

        $query = $this->db->query("SELECT SUM(NILAI_KONTRAK / 1000) AS NILAI_KONTRAK FROM
            (SELECT RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                (
                    SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                        (
                            SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                (
                                    SELECT d.RKAP_SUBPRO_ID, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_VALUE, TO_CHAR(e.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(e.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                    (
                                        CASE 
                                            WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                            WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                        ELSE
                                            RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    )   AS PERSENTASE_BEFORE
                                    FROM TR_BRANCH a
                                        LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                        LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                    $where
                                )
                            WHERE TANGGAL <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                        )
                )
            )");
        return $query->result();
    }

    public function invs_previous_year($id_branch, $a, $b, $get_tahun) {
        if ($a == 1) {
            $where = "WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $a AND c.RKAP_INVS_YEAR = $b AND e.REAL_SUBPRO_YEAR < $get_tahun";
        } else {
            $where = "WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $a AND e.REAL_SUBPRO_YEAR < $get_tahun";
        }
        $query = $this->db->query("SELECT (CASE WHEN SUM(e.REAL_SUBPRO_VAL / 1000) IS NULL THEN 0 ELSE SUM(e.REAL_SUBPRO_VAL / 1000) END) AS REALISASI
                FROM TR_BRANCH a
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                    LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                $where");
        return $query->result();
    }

    public function invs_previous_month($id_branch, $a, $get_tahun, $get_bulan) {  // change to <=
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $a AND e.REAL_SUBPRO_YEAR = $get_tahun
                    ) 
                    WHERE BULAN < '$get_bulan'
                )");
        return $query->result();
    }

    public function invs_this_month($id_branch, $a, $get_tahun, $get_bulan) {
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $a AND e.REAL_SUBPRO_YEAR = $get_tahun
                    ) 
                    WHERE BULAN = '$get_bulan'
                )");
        return $query->result();
    }

    public function invs_until($id_branch, $a, $get_tahun, $get_bulan) {  // change to <=
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $a AND e.REAL_SUBPRO_YEAR = $get_tahun
                    ) 
                    WHERE BULAN <= '$get_bulan'
                )");
        return $query->result();
    }

    public function invs_value_real($id_branch, $a, $get_tahun, $get_bulan) { // change to <=
        if ($a == 1) {
            $where = "WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $a AND c.RKAP_INVS_YEAR = '$get_tahun' AND TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') <= '$get_bulan'";
        } else {
            $where = "WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $a AND c.RKAP_INVS_YEAR <= '$get_tahun' AND TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') <= '$get_bulan'";
        }
        $query = $this->db->query("SELECT SUM(e.REAL_SUBPRO_VAL / 1000) AS REALISASI
            FROM TR_BRANCH a
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            $where");
        return $query->result();
    }

    public function invs_tax($id_branch, $a, $get_tahun) { // change to <=
        $query = $this->db->query("SELECT SUM(c.RKAP_INVS_TAKSASI / 1000) AS TAX
            FROM TR_BRANCH a
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
            WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $a AND c.RKAP_INVS_YEAR <= $get_tahun");
        return $query->result();
    }

    // count
    public function count_subpro($id_branch,$aaa, $bbb, $get_tahun){ // change to <=
        // $this->db->select('*');
        // $this->db->from('TX_RKAP_INVESTATIONa a');
        // $this->db->join('TX_RKAP_SUB_PROGRAM b', 'a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID', 'left');
        // $this->db->join('TM_USERS d', 'a.RKAP_INVS_USER_ID = d.USER_ID', 'left');
        // $this->db->join('TR_BRANCH e', 'd.USER_BRANCH = e.BRANCH_ID', 'left');
        // $this->db->where('a.IS_DELETED', 0);
        // $this->db->where('b.IS_DELETED', 0);
        // $this->db->where('BRANCH_ID', $id_branch);
        // $this->db->where('RKAP_INVS_TYPE', $aaa);
        // $this->db->where('RKAP_INVS_ASSETS', $bbb);
        // $this->db->where('RKAP_INVS_YEAR', $get_tahun);
        // $this->db->order_by('b.RKAP_SUBPRO_ID', 'ASC');
        // $query = $this->db->get();

        $query = $this->db->query("SELECT * 
            FROM TX_RKAP_INVESTATION a 
                LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
                LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID 
            WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND BRANCH_ID = '$id_branch' AND RKAP_INVS_TYPE = '$aaa' AND RKAP_INVS_ASSETS = '$bbb' AND RKAP_INVS_YEAR = '$get_tahun' 
            ORDER BY b.RKAP_SUBPRO_ID ASC");

        return $query->result();
    }

    public function count_addendum($id_branch,$aaa, $bbb, $get_tahun){// change to <=
        // $this->db->select('f.RKAP_SUBPRO_IDa');
        // $this->db->from('TX_RKAP_INVESTATION a');
        // $this->db->join('TX_RKAP_SUB_PROGRAM b', 'a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID', 'left');
        // $this->db->join('TM_USERS d', 'a.RKAP_INVS_USER_ID = d.USER_ID', 'left');
        // $this->db->join('TR_BRANCH e', 'd.USER_BRANCH = e.BRANCH_ID', 'left');
        // $this->db->join('TX_SUB_PROGRAM_ADDENDUM f', 'b.RKAP_SUBPRO_ID = f.RKAP_SUBPRO_ID', 'left');
        // $this->db->where('a.IS_DELETED', 0);
        // $this->db->where('b.IS_DELETED', 0);
        // $this->db->where('f.IS_DELETED', 0);
        // $this->db->where('BRANCH_ID', $id_branch);
        // $this->db->where('RKAP_INVS_TYPE', $aaa);
        // $this->db->where('RKAP_INVS_ASSETS', $bbb);
        // $this->db->where('RKAP_INVS_YEAR', $get_tahun);
        // $this->db->order_by('b.RKAP_SUBPRO_ID', 'ASC');
        // $query = $this->db->get();

        $query = $this->db->query("SELECT f.RKAP_SUBPRO_ID 
            FROM TX_RKAP_INVESTATION a 
                LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                LEFT JOIN TM_USERS d ON a.RKAP_INVS_USER_ID = d.USER_ID 
                LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID 
                LEFT JOIN TX_SUB_PROGRAM_ADDENDUM f ON b.RKAP_SUBPRO_ID = f.RKAP_SUBPRO_ID 
                WHERE a.IS_DELETED =0 AND b.IS_DELETED =0 AND f.IS_DELETED =0 AND BRANCH_ID = '$id_branch' AND RKAP_INVS_TYPE = '$aaa' AND RKAP_INVS_ASSETS = '$bbb' AND RKAP_INVS_YEAR = '$get_tahun' 
            ORDER BY b.RKAP_SUBPRO_ID ASC");

        return $query->result();
    }

    //total cabang

    public function branch_value_rkap($id_branch, $get_tahun){ // change to <=

        $query = $this->db->query("SELECT (A.NILAI_DANA + B.NILAI_DANA) AS RKAP_INVS_COST_REQ, (A.NILAI_RKAP + B.NILAI_RKAP) AS RKAP_INVS_VALUE FROM 
        (   
            SELECT A.BRANCH_ID, ( CASE WHEN B.NILAI_DANA IS NULL THEN 0 ELSE B.NILAI_DANA END) AS NILAI_DANA, ( CASE WHEN NILAI_RKAP IS NULL THEN 0 ELSE B.NILAI_RKAP END) AS NILAI_RKAP FROM
            (
                SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
            ) A LEFT JOIN
            (
                SELECT a.BRANCH_ID, SUM(c.RKAP_INVS_COST_REQ / 1000) AS NILAI_DANA, SUM(c.RKAP_INVS_VALUE / 1000) AS NILAI_RKAP
                FROM TR_BRANCH a 
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
                WHERE c.IS_DELETED =0 AND a.BRANCH_ID = '$id_branch' AND RKAP_INVS_YEAR <= '$get_tahun' AND c.RKAP_INVS_TYPE NOT IN 1
                GROUP BY a.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID
        ) A JOIN
        (
            SELECT A.BRANCH_ID, ( CASE WHEN B.NILAI_DANA IS NULL THEN 0 ELSE B.NILAI_DANA END) AS NILAI_DANA, ( CASE WHEN NILAI_RKAP IS NULL THEN 0 ELSE B.NILAI_RKAP END) AS NILAI_RKAP FROM
            (
                SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
            ) A LEFT JOIN
            (
                SELECT a.BRANCH_ID, SUM(c.RKAP_INVS_COST_REQ / 1000) AS NILAI_DANA, SUM(c.RKAP_INVS_VALUE / 1000) AS NILAI_RKAP 
                FROM TR_BRANCH a 
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
                WHERE c.IS_DELETED =0 AND a.BRANCH_ID = '$id_branch' AND RKAP_INVS_YEAR = '$get_tahun' AND c.RKAP_INVS_TYPE = 1
                GROUP BY a.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID
        ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->row();
    }

    public function branch_contract($id_branch, $get_tahun){ // change to <=

        $query = $this->db->query("SELECT (A.KONTRAK + B.KONTRAK) AS RKAP_SUBPRO_CONTRACT_VALUE FROM
        (   
            SELECT A.BRANCH_ID, (CASE WHEN B.KONTRAK IS NULL THEN 0 ELSE B.KONTRAK END) AS KONTRAK FROM
            (
                SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
            ) A LEFT JOIN
            (
                SELECT a.BRANCH_ID, SUM(d.RKAP_SUBPRO_CONTRACT_VALUE / 1000) AS KONTRAK
                FROM TR_BRANCH a 
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
                    LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID 
                WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_YEAR <= $get_tahun AND c.RKAP_INVS_TYPE NOT IN 1
                GROUP BY a.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID
         ) A JOIN
         (
            SELECT A.BRANCH_ID, (CASE WHEN B.KONTRAK IS NULL THEN 0 ELSE B.KONTRAK END) AS KONTRAK FROM
            (
                SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
            ) A LEFT JOIN
            (
                SELECT a.BRANCH_ID, SUM(d.RKAP_SUBPRO_CONTRACT_VALUE / 1000) AS KONTRAK
                FROM TR_BRANCH a 
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
                    LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID 
                WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_YEAR = $get_tahun AND c.RKAP_INVS_TYPE = 1
                GROUP BY a.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID
        ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->row();
    }

    public function branch_contact_year($id_branch, $get_tahun) {
        $query = $this->db->query("SELECT SUM(NILAI_KONTRAK / 1000) AS NILAI_KONTRAK FROM
            (
                SELECT RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                (
                    SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                        (
                            SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                (
                                    SELECT d.RKAP_SUBPRO_ID, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_VALUE, TO_CHAR(e.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(e.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                    (
                                        CASE 
                                            WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                            WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                        ELSE
                                            RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    )   AS PERSENTASE_BEFORE
                                    FROM TR_BRANCH a
                                        LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                        LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                    WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch 
                                )
                            WHERE TAHUN = $get_tahun
                            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                        )
                )
            )");
        return $query->row();
    }

    public function branch_target($id_branch, $get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT ((CASE WHEN A.NILAI_KONTRAK IS NULL THEN 0 ELSE A.NILAI_KONTRAK END) + (CASE WHEN B.NILAI_KONTRAK IS NULL THEN 0 ELSE B.NILAI_KONTRAK END)) AS NILAI_KONTRAK FROM 
        (   
            SELECT A.BRANCH_ID, B.NILAI_KONTRAK FROM 
            (
                SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
            ) A LEFT JOIN
            (
                SELECT BRANCH_ID, SUM(NILAI_KONTRAK / 1000) AS NILAI_KONTRAK FROM
                (SELECT BRANCH_ID, RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                    (
                        SELECT BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                            (
                                SELECT BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                    (
                                        SELECT A.BRANCH_ID, d.RKAP_SUBPRO_ID, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_VALUE, TO_CHAR(e.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(e.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                        (
                                            CASE 
                                                WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                                WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                            ELSE
                                                RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                            END
                                        )   AS PERSENTASE_BEFORE
                                        FROM TR_BRANCH a
                                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                            LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                        WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND TO_CHAR(e.SUBPRO_YEARS, 'YYYY') <= $get_tahun AND c.RKAP_INVS_TYPE NOT IN 1
                                    )
                                WHERE TANGGAL <= '$get_bulan'
                                GROUP BY BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                            )
                    )
                ) GROUP BY BRANCH_ID
            ) B ON A.BRANCH_ID  = B.BRANCH_ID
        ) A JOIN 
        (
            SELECT A.BRANCH_ID, B.NILAI_KONTRAK FROM
            (
                SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
            ) A LEFT JOIN
            (
                SELECT BRANCH_ID, SUM(NILAI_KONTRAK / 1000) AS NILAI_KONTRAK FROM
                (SELECT BRANCH_ID, RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                    (
                        SELECT BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                            (
                                SELECT BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                    (
                                        SELECT A.BRANCH_ID, d.RKAP_SUBPRO_ID, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_VALUE, TO_CHAR(e.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(e.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                        (
                                            CASE 
                                                WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                                WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                            ELSE
                                                RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                            END
                                        )   AS PERSENTASE_BEFORE
                                        FROM TR_BRANCH a
                                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                            LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                        WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND TO_CHAR(e.SUBPRO_YEARS, 'YYYY') = $get_tahun AND c.RKAP_INVS_TYPE = 1
                                    )
                                WHERE TANGGAL <= '$get_bulan'
                                GROUP BY BRANCH_ID, RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                            )
                    )
                ) GROUP BY BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID
        ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->row();
    }

    public function branch_previous_year($id_branch, $get_tahun) {
        $query = $this->db->query("SELECT (A.REALISASI + B.REALISASI) AS REALISASI FROM
            (
                SELECT A.BRANCH_ID, (CASE WHEN SUM(B.REALISASI / 1000) IS NULL THEN 0 ELSE SUM(B.REALISASI / 1000) END) AS REALISASI FROM
                    (
                        SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
                    ) A LEFT JOIN 
                    (
                        SELECT a.BRANCH_ID, (CASE WHEN SUM(e.REAL_SUBPRO_VAL) IS NULL THEN 0 ELSE SUM(e.REAL_SUBPRO_VAL) END) AS REALISASI
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND e.REAL_SUBPRO_YEAR < $get_tahun AND c.RKAP_INVS_YEAR <= $get_tahun AND c.RKAP_INVS_TYPE NOT IN 1
                        GROUP BY a.BRANCH_ID
                    ) B ON A.BRANCH_ID = B.BRANCH_ID
                GROUP BY A.BRANCH_ID
            ) A FULL JOIN 
            (   
                SELECT A.BRANCH_ID, (CASE WHEN SUM(B.REALISASI) IS NULL THEN 0 ELSE SUM(B.REALISASI) END) AS REALISASI FROM
                    (
                        SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
                    ) A LEFT JOIN 
                    (
                        SELECT a.BRANCH_ID, (CASE WHEN SUM(e.REAL_SUBPRO_VAL / 1000) IS NULL THEN 0 ELSE SUM(e.REAL_SUBPRO_VAL / 1000) END) AS REALISASI
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND e.REAL_SUBPRO_YEAR < $get_tahun AND c.RKAP_INVS_YEAR = $get_tahun AND c.RKAP_INVS_TYPE = 1
                        GROUP BY a.BRANCH_ID
                    ) B ON A.BRANCH_ID = B.BRANCH_ID
                GROUP BY A.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->row();
    }

    public function branch_previous_month($id_branch, $get_tahun, $get_bulan) {  // change to <=
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND e.REAL_SUBPRO_YEAR = $get_tahun
                    ) 
                    WHERE BULAN < '$get_bulan'
                )");
        return $query->row();
    }

    public function branch_this_month($id_branch, $get_tahun, $get_bulan) {
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND e.REAL_SUBPRO_YEAR = $get_tahun
                    ) 
                    WHERE BULAN = '$get_bulan'
                )");
        return $query->row();
    }

    public function branch_until($id_branch, $get_tahun, $get_bulan) {  // change to <=
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND e.REAL_SUBPRO_YEAR = $get_tahun
                    ) 
                    WHERE BULAN <= '$get_bulan'
                )");
        return $query->row();
    }

    public function branch_value_real($id_branch, $get_bulan, $get_tahun) { // change to <=
        $query = $this->db->query("SELECT ((CASE WHEN A.REALISASI IS NULL THEN 0 ELSE A.REALISASI / 1000 END) + (CASE WHEN B.REALISASI IS NULL THEN 0 ELSE B.REALISASI / 1000 END)) AS REALISASI FROM
        (    SELECT A.BRANCH_ID, B.REALISASI FROM
            (
                SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, SUM(e.REAL_SUBPRO_VAL) AS REALISASI
                FROM TR_BRANCH a
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                    LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') <= '$get_bulan' AND c.RKAP_INVS_TYPE NOT IN 1
                GROUP BY A.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID
        ) A JOIN
        (
            SELECT A.BRANCH_ID, B.REALISASI FROM
            (
                SELECT BRANCH_ID FROM TR_BRANCH WHERE BRANCH_ID = $id_branch
            ) A LEFT JOIN 
            (
                SELECT A.BRANCH_ID, SUM(e.REAL_SUBPRO_VAL) AS REALISASI
                FROM TR_BRANCH a
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                    LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') <= '$get_bulan' AND c.RKAP_INVS_TYPE = 1 AND c.RKAP_INVS_YEAR= $get_tahun
                GROUP BY A.BRANCH_ID
            ) B ON A.BRANCH_ID = B.BRANCH_ID
        ) B ON A.BRANCH_ID = B.BRANCH_ID");
        return $query->row();
    }

    public function branch_tax($id_branch, $get_tahun) { // change to <=
        $query = $this->db->query("SELECT SUM(c.RKAP_INVS_TAKSASI / 1000) AS TAX
            FROM TR_BRANCH a
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
            WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND c.RKAP_INVS_YEAR <= $get_tahun");
        return $query->row();
    }

    //total jenis investasi pertahun
    public function value_rkap_y($id_branch, $b, $get_tahun){

        $query = $this->db->query("SELECT SUM(c.RKAP_INVS_COST_REQ / 1000) AS RKAP_INVS_COST_REQ, SUM(c.RKAP_INVS_VALUE / 1000) AS RKAP_INVS_VALUE 
        FROM TR_BRANCH a 
            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
        WHERE c.IS_DELETED =0 AND a.BRANCH_ID = '$id_branch' AND c.RKAP_INVS_TYPE = '$b' AND RKAP_INVS_YEAR = '$get_tahun'");
        return $query->result();
    }

    public function invs_type_contract($id_branch, $b, $get_tahun){ // change to <=

        $query = $this->db->query("SELECT SUM(B.RKAP_SUBPRO_CONTRACT_VALUE / 1000) AS RKAP_SUBPRO_CONTRACT_VALUE FROM
        (
            SELECT c.RKAP_INVS_ID
            FROM TR_BRANCH a
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
            WHERE a.BRANCH_ID = $id_branch AND c.RKAP_INVS_YEAR = $get_tahun AND c.IS_DELETED = 0
        )A LEFT JOIN (
            SELECT c.RKAP_INVS_ID, d.RKAP_SUBPRO_CONTRACT_VALUE
            FROM TR_BRANCH a 
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH 
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID 
                LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID 
            WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND c.RKAP_INVS_TYPE = $b
        )B ON A.RKAP_INVS_ID = B.RKAP_INVS_ID");
        return $query->result();
    }

    public function invs_type_contact_year($id_branch, $b, $c, $get_tahun) {
        // if ($b == 1) {
        //     $where = "WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND RKAP_INVS_TYPE = $b AND TO_CHAR(e.SUBPRO_YEARS, 'YYYY') = '$get_tahun'";
        // } else {
        //     $where = "WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND RKAP_INVS_TYPE = $b AND TO_CHAR(e.SUBPRO_YEARS, 'YYYY') <= '$get_tahun'";
        // }
        $query = $this->db->query("SELECT SUM(NILAI_KONTRAK / 1000) AS NILAI_KONTRAK FROM
            (
                SELECT RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                (
                    SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                        (
                            SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                (
                                    SELECT d.RKAP_SUBPRO_ID, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_VALUE, TO_CHAR(e.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(e.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                    (
                                        CASE 
                                            WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                            WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                        ELSE
                                            RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    )   AS PERSENTASE_BEFORE
                                    FROM TR_BRANCH a
                                        LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                        LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                    WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c
                                )
                            WHERE TAHUN = $get_tahun
                            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                        )
                )
            )");
        return $query->result();
    }

    public function invs_type_target($id_branch, $b, $c, $get_bulan, $get_tahun) {
        $query = $this->db->query("SELECT SUM(NILAI_KONTRAK / 1000) AS NILAI_KONTRAK FROM
            (SELECT RKAP_SUBPRO_ID, (PERCEN_VALUE / 100 * RKAP_SUBPRO_CONTRACT_VALUE) AS NILAI_KONTRAK FROM
                (
                    SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX_VALUE, PERSENTASE_BEFORE, (MAX_VALUE - PERSENTASE_BEFORE) AS PERCEN_VALUE FROM 
                        (
                            SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, MAX(SUBPRO_VALUE) AS MAX_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE FROM 
                                (
                                    SELECT d.RKAP_SUBPRO_ID, d.RKAP_SUBPRO_CONTRACT_VALUE, e.SUBPRO_VALUE, TO_CHAR(e.SUBPRO_YEARS, 'YYYY-MM') AS TANGGAL, TO_CHAR(e.SUBPRO_YEARS, 'YYYY') AS TAHUN, RKAP_SUBPRO_REAL_BEFORE, 
                                    (
                                        CASE 
                                            WHEN RKAP_SUBPRO_CONTRACT_VALUE = 0 THEN 0
                                            WHEN RKAP_SUBPRO_REAL_BEFORE IS NULL THEN 0
                                        ELSE
                                            RKAP_SUBPRO_REAL_BEFORE / RKAP_SUBPRO_CONTRACT_VALUE * 100
                                        END
                                    )   AS PERSENTASE_BEFORE
                                    FROM TR_BRANCH a
                                        LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                                        LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                        LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                    WHERE c.IS_DELETED =0 AND d.IS_DELETED =0 AND a.BRANCH_ID = $id_branch AND RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c AND TO_CHAR(e.SUBPRO_YEARS, 'YYYY') <= $get_tahun
                                )
                            WHERE TANGGAL <= '$get_bulan'
                            GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_CONTRACT_VALUE, PERSENTASE_BEFORE, RKAP_SUBPRO_REAL_BEFORE
                        )
                )
            )");
        return $query->result();
    }

    public function invs_type_previous_year($id_branch, $c, $b, $get_tahun) {
        $query = $this->db->query("SELECT (CASE WHEN SUM(B.REAL_SUBPRO_VAL) IS NULL THEN 0 ELSE SUM(B.REAL_SUBPRO_VAL / 1000) END) AS REALISASI FROM
            (
                SELECT c.RKAP_INVS_ID
                FROM TR_BRANCH a
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                WHERE a.BRANCH_ID = $id_branch AND c.RKAP_INVS_YEAR = $c AND c.IS_DELETED = 0
            )A LEFT JOIN (
                SELECT c.RKAP_INVS_ID, e.REAL_SUBPRO_VAL
                FROM TR_BRANCH a
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                    LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $b AND e.REAL_SUBPRO_YEAR < $get_tahun
            )B ON A.RKAP_INVS_ID = B.RKAP_INVS_ID");
        return $query->result();
    }

    public function invs_type_previous_month($id_branch, $b, $c, $get_tahun, $get_bulan) { // change to <=
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST, e.REAL_SUBPRO_YEAR
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c
                    ) 
                    WHERE REAL_SUBPRO_YEAR = $get_tahun AND BULAN < '$get_bulan'
                )");
        return $query->result();
    }

    public function invs_type_this_month($id_branch, $b, $c, $get_tahun, $get_bulan) {
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST, e.REAL_SUBPRO_YEAR
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c
                    ) 
                    WHERE REAL_SUBPRO_YEAR = $get_tahun AND BULAN = '$get_bulan'
                )");
        return $query->result();
    }

    public function invs_type_until($id_branch, $b, $c, $get_tahun, $get_bulan) { // change to <=
        $query = $this->db->query("SELECT 
            ( CASE WHEN REALISASI IS NULL THEN 0 ELSE REALISASI / 1000 END ) AS REALISASI, 
            ( CASE WHEN COST IS NULL THEN 0 ELSE COST / 1000 END ) AS COST, 
            ( CASE WHEN (REALISASI + COST) IS NULL THEN 0 ELSE (REALISASI / 1000 + COST / 1000) END ) AS TOTAL  
                FROM
                (
                    SELECT SUM(REAL_SUBPRO_VAL) AS REALISASI, SUM(REAL_SUBPRO_COST) AS COST FROM 
                    (
                        SELECT d.RKAP_SUBPRO_ID, TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') as BULAN, e.REAL_SUBPRO_VAL, e.REAL_SUBPRO_PERCENT, e.REAL_SUBPRO_COST, e.REAL_SUBPRO_YEAR
                        FROM TR_BRANCH a
                            LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                            LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID 
                        WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c
                    ) 
                    WHERE REAL_SUBPRO_YEAR = $get_tahun AND BULAN <= '$get_bulan'
                )");
        return $query->result();
    }

    public function invs_type_value_real($id_branch, $c, $b, $get_bulan, $get_tahun) { // change to <=
        
        $query = $this->db->query("SELECT SUM(e.REAL_SUBPRO_VAL/ 1000) AS REALISASI
                FROM TR_BRANCH a
                    LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                    LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
                    LEFT JOIN TX_RKAP_SUB_PROGRAM d ON c.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR = $c AND TO_CHAR(e.REAL_SUBPRO_DATE, 'YYYY-MM') <= '$get_bulan'
                ");
        return $query->result();
    }

    public function invs_type_tax($id_branch, $b, $get_tahun) { // change to <=
        $query = $this->db->query("SELECT SUM(c.RKAP_INVS_TAKSASI / 1000) AS TAX
            FROM TR_BRANCH a
                LEFT JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
                LEFT JOIN TX_RKAP_INVESTATION c ON b.USER_ID = c.RKAP_INVS_USER_ID
            WHERE a.BRANCH_ID = $id_branch AND c.IS_DELETED = 0 AND c.RKAP_INVS_TYPE = $b AND c.RKAP_INVS_YEAR <= $get_tahun");
        return $query->result();
    }

}

?>