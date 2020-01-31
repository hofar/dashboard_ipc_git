<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Detail_mmr extends CI_Model {

    public function investasi($cabang,$tahun)
    {
        $query = $this->db->query("SELECT ac.BRANCH_ID,ac.RKAP_INVS_QUARTER_I,ac.RKAP_INVS_QUARTER_II,ac.RKAP_INVS_QUARTER_III,ac.RKAP_INVS_QUARTER_IV,ac.RKAP_INVS_YEAR,ac.RKAP_INVS_TYPE,ac.ASSETS_COA,ac.ASSETS_NAME,ac.RKAP_INVS_TITLE,ac.RKAP_INVS_COST_REQ,ac.RKAP_INVS_VALUE,ac.RKAP_INVS_POS,NVL(ab.posisi,'BELUM BERJALAN') AS posisi,NVL(ab.jalan,'0') AS jalan,ac.RKAP_INVS_ID FROM (
            SELECT distinct c.BRANCH_ID,a.RKAP_INVS_ID,'BERJALAN' AS posisi,'1' as jalan
            FROM (select * from tx_rkap_investation where on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.BRANCH_ID = $cabang AND e.REAL_SUBPRO_STATUS <> 2) ab 
        RIGHT JOIN (
            SELECT a.RKAP_INVS_QUARTER_I,a.RKAP_INVS_QUARTER_II,a.RKAP_INVS_QUARTER_III,a.RKAP_INVS_QUARTER_IV,c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TYPE,d.ASSETS_COA,d.ASSETS_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_COST_REQ,RKAP_INVS_VALUE,a.RKAP_INVS_POS,a.RKAP_INVS_ID
            FROM (select * from tx_rkap_investation where on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TM_ASSETS d ON a.RKAP_INVS_ASSETS = d.ASSETS_ID
            WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $cabang
        ) ac ON ab.RKAP_INVS_ID = ac.RKAP_INVS_ID
        ORDER BY ac.RKAP_INVS_TYPE,ac.RKAP_INVS_YEAR,ac.ASSETS_COA");

        $query2 = $this->db->query("SELECT ac.BRANCH_ID,ac.RKAP_INVS_QUARTER_I,ac.RKAP_INVS_QUARTER_II,ac.RKAP_INVS_QUARTER_III,ac.RKAP_INVS_QUARTER_IV,ac.RKAP_INVS_YEAR,ac.RKAP_INVS_TYPE,ac.ASSETS_COA,ac.ASSETS_NAME,ac.RKAP_INVS_TITLE,ac.RKAP_INVS_COST_REQ,ac.RKAP_INVS_VALUE,ac.RKAP_INVS_POS,NVL(ab.posisi,'BELUM BERJALAN') AS posisi,NVL(ab.jalan,'0') AS jalan,ac.RKAP_INVS_ID FROM (
            SELECT distinct c.BRANCH_ID,a.RKAP_INVS_ID,'BERJALAN' AS posisi,'1' as jalan
            FROM (select * from tx_rkap_investation_v where tahun = '$tahun') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.BRANCH_ID = $cabang AND e.REAL_SUBPRO_STATUS <> 2) ab 
        RIGHT JOIN (
            SELECT a.RKAP_INVS_QUARTER_I,a.RKAP_INVS_QUARTER_II,a.RKAP_INVS_QUARTER_III,a.RKAP_INVS_QUARTER_IV,c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TYPE,d.ASSETS_COA,d.ASSETS_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_COST_REQ,RKAP_INVS_VALUE,a.RKAP_INVS_POS,a.RKAP_INVS_ID
            FROM (select * from tx_rkap_investation_v where tahun = '$tahun') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TM_ASSETS d ON a.RKAP_INVS_ASSETS = d.ASSETS_ID
            WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $cabang
        ) ac ON ab.RKAP_INVS_ID = ac.RKAP_INVS_ID
        ORDER BY ac.RKAP_INVS_TYPE,ac.RKAP_INVS_YEAR,ac.ASSETS_COA");

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($tahun < $tn) {
            return $query2->result();
        }else{
            return $query->result();
        }
        
    }


    public function investasi2($cabang,$tahun)
    {
        $query = $this->db->query("SELECT ac.BRANCH_ID,ac.RKAP_INVS_YEAR,ac.RKAP_INVS_TYPE,ac.ASSETS_COA,ac.ASSETS_NAME,ac.RKAP_INVS_TITLE,ac.RKAP_INVS_COST_REQ,ac.RKAP_INVS_VALUE,ac.RKAP_INVS_POS,NVL(ab.posisi,'BELUM BERJALAN') AS posisi,ac.RKAP_INVS_ID,ac.RKAP_SUBPRO_ID,ac.SUBPRO_ADD_ID FROM (
            SELECT distinct c.BRANCH_ID,a.RKAP_INVS_ID,'BERJALAN' AS posisi
            FROM (select * from tx_rkap_investation where on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.BRANCH_ID = $cabang AND e.REAL_SUBPRO_STATUS <> 2) ab 
        RIGHT JOIN (
            SELECT c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TYPE,d.ASSETS_COA,d.ASSETS_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_COST_REQ,RKAP_INVS_VALUE,a.RKAP_INVS_POS,a.RKAP_INVS_ID,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_CONTRACT_VALUE,s.SUBPRO_ADD_ID
            FROM (select * from tx_rkap_investation where on_use = 'Y') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0 and RKAP_SUBPRO_TITTLE != '-' and RKAP_SUBPRO_CONTRACT_VALUE != 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (SELECT * FROM TX_SUB_PROGRAM_ADDENDUM WHERE IS_DELETED=0) s ON d.RKAP_SUBPRO_ID = s.RKAP_SUBPRO_ID
            JOIN TM_ASSETS d ON a.RKAP_INVS_ASSETS = d.ASSETS_ID
            WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $cabang
        ) ac ON ab.RKAP_INVS_ID = ac.RKAP_INVS_ID
        ORDER BY ac.RKAP_INVS_TYPE,ac.RKAP_INVS_YEAR,ac.ASSETS_COA,ac.RKAP_SUBPRO_ID,ac.SUBPRO_ADD_ID");

        $query2 = $this->db->query("SELECT ac.BRANCH_ID,ac.RKAP_INVS_YEAR,ac.RKAP_INVS_TYPE,ac.ASSETS_COA,ac.ASSETS_NAME,ac.RKAP_INVS_TITLE,ac.RKAP_INVS_COST_REQ,ac.RKAP_INVS_VALUE,ac.RKAP_INVS_POS,NVL(ab.posisi,'BELUM BERJALAN') AS posisi,ac.RKAP_INVS_ID,ac.RKAP_SUBPRO_ID,ac.SUBPRO_ADD_ID FROM (
            SELECT distinct c.BRANCH_ID,a.RKAP_INVS_ID,'BERJALAN' AS posisi
            FROM (select * from tx_rkap_investation_v where tahun = '$tahun') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.BRANCH_ID = $cabang AND e.REAL_SUBPRO_STATUS <> 2) ab 
        RIGHT JOIN (
            SELECT c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TYPE,d.ASSETS_COA,d.ASSETS_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_COST_REQ,RKAP_INVS_VALUE,a.RKAP_INVS_POS,a.RKAP_INVS_ID,d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_CONTRACT_VALUE,s.SUBPRO_ADD_ID
            FROM (select * from tx_rkap_investation_v where tahun = '$tahun') a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0 and RKAP_SUBPRO_TITTLE != '-' and RKAP_SUBPRO_CONTRACT_VALUE != 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN (SELECT * FROM TX_SUB_PROGRAM_ADDENDUM WHERE IS_DELETED=0) s ON d.RKAP_SUBPRO_ID = s.RKAP_SUBPRO_ID
            JOIN TM_ASSETS d ON a.RKAP_INVS_ASSETS = d.ASSETS_ID
            WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $cabang
        ) ac ON ab.RKAP_INVS_ID = ac.RKAP_INVS_ID
        ORDER BY ac.RKAP_INVS_TYPE,ac.RKAP_INVS_YEAR,ac.ASSETS_COA,ac.RKAP_SUBPRO_ID,ac.SUBPRO_ADD_ID");

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($tahun < $tn) {
            return $query2->result();
        }else{
            return $query->result();
        }
    }


    public function subprogramkode($kode)
    {
        $query = $this->db->query("SELECT a.RKAP_INVS_ID,NVL(d.RKAP_SUBPRO_ID,0) as RKAP_SUBPRO_ID,NVL(count(e.SUBPRO_ADD_ID),0) as SUBPRO_ADD_ID
        FROM TX_RKAP_INVESTATION a
        LEFT JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN (SELECT * FROM TX_SUB_PROGRAM_ADDENDUM WHERE IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED = 0 AND a.RKAP_INVS_ID = $kode
        GROUP BY a.RKAP_INVS_ID,d.RKAP_SUBPRO_ID");

        return $query->result();
    }

    public function addendumkode($kode)
    {
        $query = $this->db->query("	SELECT e.SUBPRO_ADD_ID FROM 
        (SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0) d
        LEFT JOIN (SELECT * FROM TX_SUB_PROGRAM_ADDENDUM WHERE IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE d.RKAP_SUBPRO_ID = $kode
        ORDER BY e.SUBPRO_ADD_ID");

        return $query->result();
    }

    public function addendum($add,$sub,$thn)
    {
        $query = $this->db->query("SELECT * FROM (SELECT SUBPRO_ADD_NUM,SUBPRO_ADD_DATE,SUBPRO_ADD_VALUE,SUBPRO_ADD_PERIODE FROM TX_SUB_PROGRAM_ADDENDUM
        WHERE SUBPRO_ADD_ID = $add),(SELECT NVL(sum(REAL_SUBPRO_PERCENT),0) AS real_seb FROM TX_REAL_SUB_PROGRAM 
        WHERE REAL_SUBPRO_YEAR < $thn AND RKAP_SUBPRO_ID = $sub),
        (SELECT NVL(sum(REAL_SUBPRO_PERCENT),0) AS real_ses FROM TX_REAL_SUB_PROGRAM 
         WHERE REAL_SUBPRO_YEAR = $thn AND RKAP_SUBPRO_ID = $sub)");

        return $query->result();
    }


    public function realisasi($id,$thn,$a)
    {
        //REAL_SUBPRO_PERCENT	REAL_SUBPRO_VAL	PER	VAL
        $query = $this->db->query("SELECT NVL(ab.PER,0) per,NVL(ab.COST,0) cost,NVL(ab.VAL,0) val,NVL(ac.PER1,0) per1,NVL(COST1,0) cost1,NVL(ac.VAL1,0) val1 FROM (
            SELECT rkap_subpro_id,NVL(REAL_SUBPRO_PERCENT,0) AS per,NVL(REAL_SUBPRO_COST,0) AS cost,NVL(REAL_SUBPRO_VAL,0) AS val FROM TX_REAL_SUB_PROGRAM 
            WHERE rkap_subpro_id = $id AND REAL_SUBPRO_YEAR = $thn AND REAL_SUBPRO_MONTH = $a AND IS_DELETED = 0) ab FULL JOIN
            (SELECT rkap_subpro_id,sum(REAL_SUBPRO_COST) cost1,sum(REAL_SUBPRO_PERCENT) per1,sum(REAL_SUBPRO_VAL) val1 FROM TX_REAL_SUB_PROGRAM
            WHERE rkap_subpro_id = $id AND REAL_SUBPRO_YEAR = $thn AND REAL_SUBPRO_MONTH BETWEEN 1 AND $a AND IS_DELETED = 0
            GROUP BY rkap_subpro_id) ac ON ab.rkap_subpro_id = ac.rkap_subpro_id");

        if ($query->num_rows() == 0) {
            return $arrayName = array((object)array('PER' => "0",'COST' => "0",'VAL' => "0",'PER1' => "0",'COST1' => "0",'VAL1' => "0" ));;
        }else {
            return $query->result();
        }
        
    }


    public function jumlah($kode,$a,$tahun)
    { //a.RKAP_INVS_TYPE = 1 AND a.RKAP_INVS_YEAR = 2018 AND d.ASSETS_COA = 201
        $query = $this->db->query("SELECT sum(a.RKAP_INVS_COST_REQ) as req,sum(RKAP_INVS_VALUE) as val
        FROM (select * from tx_rkap_investation where on_use = 'Y') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        JOIN TM_ASSETS d ON a.RKAP_INVS_ASSETS = d.ASSETS_ID
        WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $kode $a");

        $query2 = $this->db->query("SELECT sum(a.RKAP_INVS_COST_REQ) as req,sum(RKAP_INVS_VALUE) as val
        FROM (select * from tx_rkap_investation_v where tahun = '$tahun') a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        JOIN TM_ASSETS d ON a.RKAP_INVS_ASSETS = d.ASSETS_ID
        WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $kode $a");

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($tahun < $tn) {
            return $query2->result();
        }else{
            return $query->result();
        }
    }

    public function datakontrak($id,$thn)
    { 
        $query = $this->db->query("SELECT * FROM (
            SELECT distinct d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_CONTRACT_NO,d.RKAP_SUBPRO_CONTRACT_DATE,d.RKAP_SUBPRO_CONTRACTOR,d.RKAP_SUBPRO_PERIODE,NVL(d.RKAP_CONTRACT_VALUE_HISTORY,0) as RKAP_CONTRACT_VALUE_HISTORY
            FROM TX_RKAP_INVESTATION a
            LEFT JOIN (SELECT * FROM TX_RKAP_SUB_PROGRAM WHERE IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            WHERE a.IS_DELETED = 0 AND d.RKAP_SUBPRO_ID = $id),
            (SELECT NVL(sum(REAL_SUBPRO_PERCENT),0) AS real_seb FROM TX_REAL_SUB_PROGRAM 
            WHERE REAL_SUBPRO_YEAR < $thn AND RKAP_SUBPRO_ID = $id),
            (SELECT NVL(sum(REAL_SUBPRO_PERCENT),0) AS real_ses FROM TX_REAL_SUB_PROGRAM 
            WHERE REAL_SUBPRO_YEAR = $thn AND RKAP_SUBPRO_ID = $id)");

        return $query->result();
    }

    public function rel_seb($kode,$a,$b)
    { 
        $query = $this->db->query("SELECT NVL(sum(REAL_SUBPRO_PERCENT),0) AS per_seb,NVL(sum(REAL_SUBPRO_VAL),0) AS val_seb FROM TX_REAL_SUB_PROGRAM 
        WHERE RKAP_SUBPRO_ID = $kode and to_date(to_char(real_subpro_date,'MM-YYYY'),'MM-YYYY') <=  to_date('$a-$b','MM-YYYY')");

        return $query->result();
    }

    public function kendala1($kode)
    { 
        $query = $this->db->query("SELECT ac.real_subpro_id,ac.real_subpro_constraints as satu,ad.contraints_name as dua from (
            SELECT a.RKAP_INVS_ID,max(e.real_subpro_id) as iddd
            FROM TX_RKAP_INVESTATION a
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND a.RKAP_INVS_ID = $kode
            group by a.RKAP_INVS_ID) ab JOIN 
            TX_REAL_SUB_PROGRAM ac on ab.iddd = ac.real_subpro_id
            JOIN tm_contraints ad ON ac.real_subpro_constraints = ad.contraints_id");
        if ($query->num_rows() <= 0 ) {
            return $ar = array((object)array('SATU' => '' , 'DUA' => 'Progress Terlambat'));    
        }else{
            return $query->result();
        }
    }
    public function kendala2($kode)
    { 
        $query = $this->db->query("SELECT * from (
            SELECT ac.real_subpro_id,ac.real_subpro_percent_tot,ac.real_subpro_constraints as satu,ad.contraints_name as dua from (
                        SELECT a.RKAP_INVS_ID,d.RKAP_SUBPRO_ID,max(e.real_subpro_id) as iddd
                        FROM TX_RKAP_INVESTATION a
                        JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                        JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                        WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND a.RKAP_INVS_ID = $kode
                        group by a.RKAP_INVS_ID,d.RKAP_SUBPRO_ID) ab JOIN 
                        TX_REAL_SUB_PROGRAM ac on ab.iddd = ac.real_subpro_id
                        JOIN tm_contraints ad ON ac.real_subpro_constraints = ad.contraints_id
            where ac.real_subpro_constraints <> 1
            order by ac.real_subpro_percent_tot asc)
            where rownum = 1");
        if ($query->num_rows() <= 0 ) {
            return $ar = array((object)array('SATU' => '' , 'DUA' => 'Progress Terlambat'));    
        }else{
            return $query->result();
        }
    }


    public function statpos($kd,$thn,$b)
    { 
        $query = $this->db->query("SELECT sum(e.REAL_SUBPRO_VAL) as val
        FROM TX_RKAP_INVESTATION a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0 AND a.RKAP_INVS_ID = $kd and e.REAL_SUBPRO_MONTH <= $b and e.REAL_SUBPRO_YEAR = $thn");
        if ($query->num_rows() <= 0 ) {
            return $ar = array((object)array('VAL' => 0));    
        }else{
            return $query->result();
        }
    }

    public function target($id,$tgl,$tahun)
    {
        if ($tgl == 1) { $sel = 'RKAP_INVS_QUARTER_I / 3'; }
        else if ($tgl == 2) { $sel = 'RKAP_INVS_QUARTER_I / 3 * 2'; }
        else if ($tgl == 3) { $sel = 'RKAP_INVS_QUARTER_I'; }
        else if ($tgl == 4) { $sel = 'RKAP_INVS_QUARTER_I + ( RKAP_INVS_QUARTER_II / 3 )'; }
        else if ($tgl == 5) { $sel = 'RKAP_INVS_QUARTER_I + ( RKAP_INVS_QUARTER_II / 3 * 2 )'; }
        else if ($tgl == 6) { $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II'; }
        else if ($tgl == 7) { $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + ( RKAP_INVS_QUARTER_III / 3 )'; }
        else if ($tgl == 8) { $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + ( RKAP_INVS_QUARTER_III / 3 * 2 )'; }
        else if ($tgl == 9) { $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III'; }
        else if ($tgl == 10) { $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III + ( RKAP_INVS_QUARTER_IV / 3 )'; }
        else if ($tgl == 11) { $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III + ( RKAP_INVS_QUARTER_IV / 3 * 2 )'; }
        else if ($tgl == 12) { $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III +  RKAP_INVS_QUARTER_IV'; }

        $query = $this->db->query("SELECT rkap_invs_id,( $sel ) as targetz 
        from tx_rkap_investation
        where is_deleted = 0 and rkap_invs_id = $id ");

        $query2 = $this->db->query("SELECT rkap_invs_id,( $sel ) as targetz 
        from (select * from tx_rkap_investation_v where tahun = '$tahun')
        where is_deleted = 0 and rkap_invs_id = $id ");


        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $tn = $date->format('Y');

        if ($tahun < $tn) {
            return $query2->result();
        }else{
            return $query->result();
        }
    }

}