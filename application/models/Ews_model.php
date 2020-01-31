<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ews_model extends CI_Model {

    public function target_tes() {
        $query =$this->db->query("SELECT a.RKAP_INVS_QUARTER_I, a.RKAP_INVS_QUARTER_II, a.RKAP_INVS_QUARTER_III, a.RKAP_INVS_QUARTER_IV, (a.RKAP_INVS_QUARTER_I / 3) as jan, (a.RKAP_INVS_QUARTER_I / 3) as feb, (a.RKAP_INVS_QUARTER_I / 3) as mar, (a.RKAP_INVS_QUARTER_II / 3) as apr, (a.RKAP_INVS_QUARTER_II / 3) as may, (a.RKAP_INVS_QUARTER_II / 3) as jun, (a.RKAP_INVS_QUARTER_III / 3) as jul, (a.RKAP_INVS_QUARTER_III / 3) as aug, (a.RKAP_INVS_QUARTER_III / 3) as sep, (a.RKAP_INVS_QUARTER_IV / 3) as oct, (a.RKAP_INVS_QUARTER_IV / 3) as nov, (a.RKAP_INVS_QUARTER_IV / 3) as dec
            FROM tx_rkap_investation a
            WHERE a.RKAP_INVS_ID = 869");
        return $query->row();
    }

    public function total_kontrak_kritis($id_branch, $get_bulan, $reminderKontrakKritis) {
        $query = $this->db->query("SELECT BRANCH_ID, COUNT(DEVIASI) AS KETERLAMBATAN FROM 
            (
                SELECT BRANCH_ID, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, REALISASI, TARGET, (REALISASI - TARGET) AS DEVIASI FROM 
                    (
                        SELECT BRANCH_ID, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, MAX(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, MAX(REAL_SUBPRO_PERCENT_TOT) AS REALISASI, MAX(SUBPRO_VALUE) AS TARGET FROM
                            (
                                SELECT f.BRANCH_ID, f.BRANCH_NAME, B.RKAP_SUBPRO_ID, a.RKAP_INVS_TITLE, a.RKAP_INVS_VALUE, b.RKAP_SUBPRO_TITTLE, b.RKAP_SUBPRO_CONTRACT_VALUE, c.REAL_SUBPRO_VAL, TO_CHAR(c.REAL_SUBPRO_DATE, 'YYYY-MM') AS TGL_REALISASI, TO_CHAR(d.SUBPRO_YEARS, 'YYYY-MM') AS TGL_TARGET, c.REAL_SUBPRO_PERCENT_TOT, d.SUBPRO_VALUE
                                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                                    LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                                    LEFT JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
                                    LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY d ON b.RKAP_SUBPRO_ID = d.RKAP_SUBPRO_ID
                                    LEFT JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID 
                                    LEFT JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
                                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0
                            )
                        WHERE TGL_REALISASI <= '$get_bulan' AND TGL_TARGET <= '$get_bulan' 
                        GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE
                    )
                -- WHERE REALISASI BETWEEN 0 AND 70
            ) 
            WHERE DEVIASI < $reminderKontrakKritis AND BRANCH_ID = $id_branch
            GROUP BY BRANCH_ID");
        
        if (count($query->row()) > 0) {
            return $query->row();
        } else {
            $data = ['KETERLAMBATAN' => "0"];
            return $data;
        }
        
    }

    public function detail_kontrak_kritis($id_branch, $get_bulan, $reminderKontrakKritis) {
        $query = $this->db->query("SELECT * FROM 
            (
                SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, REAL_SUBPRO_VAL, REALISASI, TARGET, (REALISASI - TARGET) AS DEVIASI FROM 
                    (
                        SELECT BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE, MAX(REAL_SUBPRO_VAL) AS REAL_SUBPRO_VAL, MAX(REAL_SUBPRO_PERCENT_TOT) AS REALISASI, MAX(SUBPRO_VALUE) AS TARGET FROM
                            (
                                SELECT f.BRANCH_ID, f.BRANCH_NAME, b.RKAP_SUBPRO_ID, a.RKAP_INVS_TITLE, a.RKAP_INVS_VALUE, b.RKAP_SUBPRO_TITTLE, b.RKAP_SUBPRO_CONTRACT_VALUE, c.REAL_SUBPRO_VAL, TO_CHAR(c.REAL_SUBPRO_DATE, 'YYYY-MM') AS TGL_REALISASI, TO_CHAR(d.SUBPRO_YEARS, 'YYYY-MM') AS TGL_TARGET, c.REAL_SUBPRO_PERCENT_TOT, d.SUBPRO_VALUE
                                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
                                    LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_INVS_ID = b.RKAP_SUBPRO_INVS_ID 
                                    LEFT JOIN TX_REAL_SUB_PROGRAM c ON b.RKAP_SUBPRO_ID = c.RKAP_SUBPRO_ID
                                    LEFT JOIN TX_RKAP_SUB_PROGRAM_MONTHLY d ON b.RKAP_SUBPRO_ID = d.RKAP_SUBPRO_ID
                                    LEFT JOIN TM_USERS e ON a.RKAP_INVS_USER_ID = e.USER_ID 
                                    LEFT JOIN TR_BRANCH f ON e.USER_BRANCH = f.BRANCH_ID
                                    WHERE a.IS_DELETED = 0 AND b.IS_DELETED = 0 AND c.IS_DELETED = 0
                            )
                        WHERE TGL_REALISASI <= '$get_bulan' AND TGL_TARGET <= '$get_bulan' 
                        GROUP BY BRANCH_ID, BRANCH_NAME, RKAP_SUBPRO_ID, RKAP_INVS_TITLE, RKAP_SUBPRO_TITTLE, RKAP_INVS_VALUE, RKAP_SUBPRO_CONTRACT_VALUE
                    )
                -- WHERE REALISASI BETWEEN 0 AND 100
            ) 
            WHERE DEVIASI < $reminderKontrakKritis AND BRANCH_ID = $id_branch");
        
            return $query->result();
        
    }

    public function total_start_sub_program($id_branch)
    {
        $this->db->select('COUNT(*) AS START_SUB_PROGRAM');
        $this->db->from('TX_RKAP_INVESTATION A');
        $this->db->join('TX_RKAP_SUB_PROGRAM B', 'A.RKAP_INVS_ID = B.RKAP_SUBPRO_INVS_ID');
        $this->db->join('TM_USERS C', 'A.RKAP_INVS_USER_ID = C.USER_ID');
        $this->db->join('TR_BRANCH D', 'C.USER_BRANCH = D.BRANCH_ID');
        $this->db->join('TR_SUBPRO_TYPE E', 'B.RKAP_SUBPRO_TYPE_ID = E.SUBPRO_TYPE_ID'); 
        $this->db->where("(B.RKAP_SUBPRO_START IS NULL OR B.RKAP_SUBPRO_END IS NULL)");
        $this->db->where('D.BRANCH_ID', $id_branch);
        $query = $this->db->get();
        
        return $query->row(); 
    }

    public function detail_start_sub_program($id_branch)
    {
        $this->db->select('B.RKAP_SUBPRO_INVS_ID, B.RKAP_SUBPRO_TITTLE, E.SUBPRO_TYPE_NAME, C.USER_EMAIL, D.BRANCH_NAME');
        $this->db->from('TX_RKAP_INVESTATION A');
        $this->db->join('TX_RKAP_SUB_PROGRAM B', 'A.RKAP_INVS_ID = B.RKAP_SUBPRO_INVS_ID');
        $this->db->join('TM_USERS C', 'A.RKAP_INVS_USER_ID = C.USER_ID');
        $this->db->join('TR_BRANCH D', 'C.USER_BRANCH = D.BRANCH_ID');
        $this->db->join('TR_SUBPRO_TYPE E', 'B.RKAP_SUBPRO_TYPE_ID = E.SUBPRO_TYPE_ID');
        $this->db->join('TR_POSITION F', 'C.USER_POSITION = F.POSITION_ID'); 
        $this->db->where("(B.RKAP_SUBPRO_START IS NULL OR B.RKAP_SUBPRO_END IS NULL)");
        $this->db->where('D.BRANCH_ID', $id_branch);
        $query = $this->db->get();
        
        return $query->result(); 
    }

    public function get_rkap_id_not_current_date_realisasi_pelaporan($id_branch)
    {
        $query = $this->db->query(
            "SELECT A.REAL_SUBPRO_ID, D.RKAP_SUBPRO_ID, A.REAL_SUBPRO_DATE, D.RKAP_SUBPRO_TITTLE
                FROM TX_REAL_SUB_PROGRAM A 
                    JOIN TM_STATUS_PROGRAM B ON A.REAL_SUBPRO_STATUS = B.STATUS_ID 
                    JOIN TM_CONTRAINTS C ON A.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID 
                    JOIN TX_RKAP_SUB_PROGRAM D ON A.RKAP_SUBPRO_ID = D.RKAP_SUBPRO_ID 
                    JOIN TR_SUBPRO_TYPE E ON D.RKAP_SUBPRO_TYPE_ID = E.SUBPRO_TYPE_ID 
                    JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') F ON D.RKAP_SUBPRO_INVS_ID = F.RKAP_INVS_ID 
                    JOIN TM_USERS G ON F.RKAP_INVS_USER_ID = G.USER_ID 
                    JOIN TR_BRANCH H ON G.USER_BRANCH = H.BRANCH_ID
                WHERE A.IS_DELETED = 0  
                    AND H.BRANCH_ID = $id_branch 
                    AND to_char(A.REAL_SUBPRO_DATE, 'MON-YY') = to_char(SYSDATE, 'MON-YY')"
        );

        return $query->result();
    }

    public function get_id_rkap_duplicate_realisasi_pelaporan($id_branch, $id_rkap)
    {
        $query = $this->db->query(
            "SELECT A.REAL_SUBPRO_ID, D.RKAP_SUBPRO_ID, A.REAL_SUBPRO_DATE, D.RKAP_SUBPRO_TITTLE
                FROM TX_REAL_SUB_PROGRAM A 
                    JOIN TM_STATUS_PROGRAM B ON A.REAL_SUBPRO_STATUS = B.STATUS_ID 
                    JOIN TM_CONTRAINTS C ON A.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID 
                    JOIN TX_RKAP_SUB_PROGRAM D ON A.RKAP_SUBPRO_ID = D.RKAP_SUBPRO_ID 
                    JOIN TR_SUBPRO_TYPE E ON D.RKAP_SUBPRO_TYPE_ID = E.SUBPRO_TYPE_ID 
                    JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') F ON D.RKAP_SUBPRO_INVS_ID = F.RKAP_INVS_ID 
                    JOIN TM_USERS G ON F.RKAP_INVS_USER_ID = G.USER_ID 
                    JOIN TR_BRANCH H ON G.USER_BRANCH = H.BRANCH_ID
                WHERE A.IS_DELETED = 0  
                    AND H.BRANCH_ID = $id_branch 
                    AND D.RKAP_SUBPRO_ID NOT IN ($id_rkap) ORDER BY REAL_SUBPRO_ID ASC"
        );

        return $query->result();
    }

    public function total_realisasi_pelaporan($id_branch, $id_real)
    {
        $query = $this->db->query(
            "SELECT COUNT(*) AS REALISASI_PELAPORAN
                FROM TX_REAL_SUB_PROGRAM A 
                    JOIN TM_STATUS_PROGRAM B ON A.REAL_SUBPRO_STATUS = B.STATUS_ID 
                    JOIN TM_CONTRAINTS C ON A.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID 
                    JOIN TX_RKAP_SUB_PROGRAM D ON A.RKAP_SUBPRO_ID = D.RKAP_SUBPRO_ID 
                    JOIN TR_SUBPRO_TYPE E ON D.RKAP_SUBPRO_TYPE_ID = E.SUBPRO_TYPE_ID 
                    JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') F ON D.RKAP_SUBPRO_INVS_ID = F.RKAP_INVS_ID 
                    JOIN TM_USERS G ON F.RKAP_INVS_USER_ID = G.USER_ID 
                    JOIN TR_BRANCH H ON G.USER_BRANCH = H.BRANCH_ID
                WHERE A.IS_DELETED = 0  
                    AND H.BRANCH_ID = $id_branch 
                    AND A.REAL_SUBPRO_ID IN ($id_real)"
        );

        return $query->row();
    }

    public function detail_realisasi_pelaporan($id_branch, $id_real)
    {
        $query = $this->db->query(
            "SELECT A.REAL_SUBPRO_DATE, D.RKAP_SUBPRO_TITTLE, D.RKAP_SUBPRO_ID, F.RKAP_INVS_TITLE, G.USER_EMAIL, H.BRANCH_NAME
                FROM TX_REAL_SUB_PROGRAM A 
                    JOIN TM_STATUS_PROGRAM B ON A.REAL_SUBPRO_STATUS = B.STATUS_ID 
                    JOIN TM_CONTRAINTS C ON A.REAL_SUBPRO_CONSTRAINTS = C.CONTRAINTS_ID 
                    JOIN TX_RKAP_SUB_PROGRAM D ON A.RKAP_SUBPRO_ID = D.RKAP_SUBPRO_ID 
                    JOIN TR_SUBPRO_TYPE E ON D.RKAP_SUBPRO_TYPE_ID = E.SUBPRO_TYPE_ID 
                    JOIN (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') F ON D.RKAP_SUBPRO_INVS_ID = F.RKAP_INVS_ID 
                    JOIN TM_USERS G ON F.RKAP_INVS_USER_ID = G.USER_ID 
                    JOIN TR_BRANCH H ON G.USER_BRANCH = H.BRANCH_ID
                    JOIN TR_POSITION I ON G.USER_POSITION = I.POSITION_ID
                WHERE A.IS_DELETED = 0  
                    AND H.BRANCH_ID = $id_branch 
                    AND A.REAL_SUBPRO_ID IN ($id_real)"
        );

        return $query->result();
    }

    public function total_kontrak_b_a($id_branch, $reminderKontrakBA)
    {
        $query = $this->db->query(
            "SELECT COUNT(*) AS KONTRAK_B_A
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') A
                    JOIN TX_RKAP_SUB_PROGRAM B ON A.RKAP_INVS_ID = B.RKAP_SUBPRO_INVS_ID
                    JOIN TM_USERS C ON A.RKAP_INVS_USER_ID = C.USER_ID
                    JOIN TR_BRANCH D ON C.USER_BRANCH = D.BRANCH_ID
                WHERE D.BRANCH_ID = $id_branch AND 
                    ( B.RKAP_SUBPRO_END_REAL - NUMTODSINTERVAL( $reminderKontrakBA, 'DAY' ) <= CURRENT_DATE 
                    AND TO_DATE(CURRENT_DATE, 'DD-MON-YY') <= TO_DATE(B.RKAP_SUBPRO_END_REAL, 'DD-MON-YY')
                    )"
        );
        
        return $query->row(); 
    }

    public function detail_kontrak_b_a($id_branch, $reminderKontrakBA)
    {
        $query = $this->db->query(
            "SELECT RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_ID, RKAP_SUBPRO_END_REAL, RKAP_INVS_TITLE, USER_EMAIL, BRANCH_NAME
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') A
                    JOIN TX_RKAP_SUB_PROGRAM B ON A.RKAP_INVS_ID = B.RKAP_SUBPRO_INVS_ID
                    JOIN TM_USERS C ON A.RKAP_INVS_USER_ID = C.USER_ID
                    JOIN TR_BRANCH D ON C.USER_BRANCH = D.BRANCH_ID
                    JOIN TR_POSITION E ON C.USER_POSITION = E.POSITION_ID
                WHERE D.BRANCH_ID = $id_branch AND 
                    ( B.RKAP_SUBPRO_END_REAL - NUMTODSINTERVAL( $reminderKontrakBA, 'DAY' ) <= CURRENT_DATE 
                    AND TO_DATE(CURRENT_DATE, 'DD-MON-YY') <= TO_DATE(B.RKAP_SUBPRO_END_REAL, 'DD-MON-YY')
                    )"
        );
        
        return $query->result(); 
    }

    public function total_start_sub_program_fix($id_branch, $reminderKontrakBA)
    {
        $query = $this->db->query(
            "SELECT COUNT(*) AS START_SUB_PROGRAM
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') A
                    JOIN TX_RKAP_SUB_PROGRAM B ON A.RKAP_INVS_ID = B.RKAP_SUBPRO_INVS_ID
                    JOIN TM_USERS C ON A.RKAP_INVS_USER_ID = C.USER_ID
                    JOIN TR_BRANCH D ON C.USER_BRANCH = D.BRANCH_ID
                WHERE D.BRANCH_ID = $id_branch AND A.IS_DELETED = 0 AND B.IS_DELETED = 0 AND
                    ( B.RKAP_SUBPRO_START - NUMTODSINTERVAL( $reminderKontrakBA, 'DAY' ) <= CURRENT_DATE 
                    AND TO_DATE(CURRENT_DATE, 'DD-MON-YY') <= TO_DATE(B.RKAP_SUBPRO_START, 'DD-MON-YY')
                    )"
        );
        
        return $query->row(); 
    }

    public function detail_start_sub_program_fix($id_branch, $reminderKontrakBA)
    {
        $query = $this->db->query(
            "SELECT RKAP_SUBPRO_TITTLE, RKAP_SUBPRO_ID, RKAP_SUBPRO_START, RKAP_INVS_TITLE, USER_EMAIL, BRANCH_NAME
                FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') A
                    JOIN TX_RKAP_SUB_PROGRAM B ON A.RKAP_INVS_ID = B.RKAP_SUBPRO_INVS_ID
                    JOIN TM_USERS C ON A.RKAP_INVS_USER_ID = C.USER_ID
                    JOIN TR_BRANCH D ON C.USER_BRANCH = D.BRANCH_ID
                    JOIN TR_POSITION E ON C.USER_POSITION = E.POSITION_ID
                WHERE D.BRANCH_ID = $id_branch AND A.IS_DELETED = 0 AND B.IS_DELETED = 0 AND
                    ( B.RKAP_SUBPRO_START - NUMTODSINTERVAL( $reminderKontrakBA, 'DAY' ) <= CURRENT_DATE 
                    AND TO_DATE(CURRENT_DATE, 'DD-MON-YY') <= TO_DATE(B.RKAP_SUBPRO_START, 'DD-MON-YY')
                    )"
        );
        
        return $query->result(); 
    }

    public function email_realisasi($id,$tgl)
    {
        $query = $this->db->query("SELECT aa.BRANCH_NAME,aa.RKAP_INVS_TITLE,aa.RKAP_SUBPRO_TITTLE,aa.rkap_subpro_id,aa.rkap_subpro_contract_value,aa.ide,aa.tot,to_char(aa.tgl,'MON-yyyy') tgl from (
            SELECT c.BRANCH_NAME,a.RKAP_INVS_TITLE, d.RKAP_SUBPRO_TITTLE,d.rkap_subpro_id, d.rkap_subpro_contract_value,max(e.real_subpro_id) ide,max(e.real_subpro_percent_tot) tot,max(e.real_subpro_date) tgl
            FROM TX_RKAP_INVESTATION a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0 and c.branch_id = $id and d.is_deleted = 0 and d.rkap_contract_value_history > 0 and e.is_deleted = 0
            group by c.BRANCH_NAME,a.RKAP_INVS_TITLE, d.RKAP_SUBPRO_TITTLE,d.rkap_subpro_id, d.rkap_subpro_contract_value
            having max(e.real_subpro_percent_tot) <> 100 and max(e.real_subpro_date) < to_date('$tgl','dd-mm-yyyy')) aa
        join TX_REAL_SUB_PROGRAM ab on aa.ide = ab.real_subpro_id
        where ab.real_subpro_status <> 5");

        return $query;
    }


}
