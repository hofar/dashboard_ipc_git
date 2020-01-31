<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projectcosting_model extends CI_Model {

    public function contoh($cabang)
    {
        // $query = $this->db->query("SELECT ac.BRANCH_ID,ac.RKAP_INVS_QUARTER_I,ac.RKAP_INVS_QUARTER_II,ac.RKAP_INVS_QUARTER_III,ac.RKAP_INVS_QUARTER_IV,ac.RKAP_INVS_YEAR,ac.RKAP_INVS_TYPE,ac.ASSETS_COA,ac.ASSETS_NAME,ac.RKAP_INVS_TITLE,ac.RKAP_INVS_COST_REQ,ac.RKAP_INVS_VALUE,ac.RKAP_INVS_POS,NVL(ab.posisi,'BELUM BERJALAN') AS posisi,NVL(ab.jalan,'0') AS jalan,ac.RKAP_INVS_ID FROM (
        //     SELECT distinct c.BRANCH_ID,a.RKAP_INVS_ID,'BERJALAN' AS posisi,'1' as jalan
        //     FROM TX_RKAP_INVESTATION a
        //     LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        //     LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        //     JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        //     JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        //     WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND c.BRANCH_ID = $cabang AND e.REAL_SUBPRO_STATUS <> 2) ab 
        // RIGHT JOIN (
        //     SELECT a.RKAP_INVS_QUARTER_I,a.RKAP_INVS_QUARTER_II,a.RKAP_INVS_QUARTER_III,a.RKAP_INVS_QUARTER_IV,c.BRANCH_ID,a.RKAP_INVS_YEAR,a.RKAP_INVS_TYPE,d.ASSETS_COA,d.ASSETS_NAME,a.RKAP_INVS_TITLE,a.RKAP_INVS_COST_REQ,RKAP_INVS_VALUE,a.RKAP_INVS_POS,a.RKAP_INVS_ID
        //     FROM TX_RKAP_INVESTATION a
        //     LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        //     LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        //     JOIN TM_ASSETS d ON a.RKAP_INVS_ASSETS = d.ASSETS_ID
        //     WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $cabang
        // ) ac ON ab.RKAP_INVS_ID = ac.RKAP_INVS_ID
        // ORDER BY ac.RKAP_INVS_TYPE,ac.RKAP_INVS_YEAR,ac.ASSETS_COA");

        // return $query->result();
    }

    public function inv_procost_1($cab,$bulan,$tahun)
    {
         $query = $this->db->query("SELECT KODE_CABANG,NAMA_CABANG,PROJECT_NUMBER,JUDUL_INVESTASI,NOMOR_KONTRAK,JUDUL_SUB_PROGRAM,PERIOD_RKAP,AMT_RCP_BLNLALU,ADENDUM from tabel_coba_complite
         where kode_cabang = $cab and period_rkap = '$bulan-$tahun'");
         return $query;
    }

    public function inv_dashboard_1($cabang)
    {
         $query = $this->db->query("SELECT c.branch_name,a.rkap_invs_project_number,a.rkap_invs_title,d.rkap_subpro_contract_no,d.rkap_subpro_tittle
         FROM TX_RKAP_INVESTATION a
         LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
         LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
         LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
         WHERE a.IS_DELETED =0 and d.is_deleted = 0 and c.branch_id = $cabang and d.rkap_subpro_tittle <> '-'
         ORDER BY d.CREATED_AT desc");
         return $query;
    }

    public function binddata($cab,$bulan,$tahun)
    {
         $query = $this->db->query("SELECT * from (
            SELECT c.branch_name,a.rkap_invs_project_number,a.rkap_invs_title,d.rkap_subpro_contract_no,d.rkap_subpro_tittle
            FROM TX_RKAP_INVESTATION a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            WHERE a.IS_DELETED =0 and d.is_deleted = 0 and c.branch_id = $cab  and d.rkap_subpro_tittle <> '-'
            ORDER BY d.CREATED_AT desc) A
            JOIN 
            (SELECT KODE_CABANG,NAMA_CABANG,PROJECT_NUMBER,JUDUL_INVESTASI,NOMOR_KONTRAK,JUDUL_SUB_PROGRAM,PERIOD_RKAP,AMT_RCP_BLNLALU,ADENDUM from tabel_coba_complite
            where kode_cabang = 000 and period_rkap = '$bulan-$tahun') B
            ON(A.rkap_invs_project_number = B.PROJECT_NUMBER or A.rkap_invs_title = B.JUDUL_INVESTASI or A.rkap_subpro_contract_no = B.NOMOR_KONTRAK or A.rkap_subpro_tittle = B.JUDUL_SUB_PROGRAM)");
         return $query;
    }

    public function invout($cab,$bulan,$tahun)
    {
         $query = $this->db->query("SELECT * from (
            SELECT c.branch_name,a.rkap_invs_project_number,a.rkap_invs_title,d.rkap_subpro_contract_no,d.rkap_subpro_tittle
            FROM TX_RKAP_INVESTATION a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            WHERE a.IS_DELETED =0 and d.is_deleted = 0 and c.branch_id = $cab  and d.rkap_subpro_tittle <> '-'
            ORDER BY d.CREATED_AT desc) A
            FULL OUTER JOIN 
            (SELECT KODE_CABANG,NAMA_CABANG,PROJECT_NUMBER,JUDUL_INVESTASI,NOMOR_KONTRAK,JUDUL_SUB_PROGRAM,PERIOD_RKAP,AMT_RCP_BLNLALU,ADENDUM from tabel_coba_complite
            where kode_cabang = 000 and period_rkap = '$bulan-$tahun') B
            ON(A.rkap_subpro_contract_no = B.NOMOR_KONTRAK or A.rkap_subpro_tittle = B.JUDUL_SUB_PROGRAM)
            where A.BRANCH_NAME is null or B.NAMA_CABANG is null");
         return $query;
    }
     // proses hapus--------------------------------------------------------------------------------------------------------------------
    public function datainv($tabel)
    {
          $query = $this->db->query("SELECT distinct a.RKAP_INVS_ID as id
          FROM TX_RKAP_INVESTATION a
          LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
          LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
          LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
          LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
          WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $tabel");
          return $query->result();
    }

    public function datasub($tabel)
    {
          $query = $this->db->query("SELECT distinct d.rkap_subpro_id as id
          FROM TX_RKAP_INVESTATION a
          LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
          LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
          LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
          LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
          WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $tabel AND d.rkap_subpro_id IS not null");
         return $query->result();
    }

    public function datareal($tabel)
    {
          $query = $this->db->query("SELECT distinct d.rkap_subpro_id as id
          FROM TX_RKAP_INVESTATION a
          LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
          LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
          JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
          JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
          WHERE a.IS_DELETED =0 AND c.BRANCH_ID = $tabel AND d.rkap_subpro_id IS not null");
          return $query->result();
    }
    
    public function hapus($tabel,$colom,$id)
    {
         $this->db->query("DELETE FROM $tabel
         WHERE $colom = $id");
    }
    // proses hapus------------------------------------------------------------------------------------------------------------------



    // proses tambah------------------------------------------------------------------------------------------------------------------
    public function poc_inv($cabang)
    {
         $query = $this->db->query("SELECT PROJECT_NUMBER,NVL(JUDUL_INVESTASI,'kosong') AS JUDUL_INVESTASI,NVL(KEBUTUHAN_DANA,0) AS KEBUTUHAN_DANA,sum(NILAI_RKAP) as NILAI_RKAP,JENIS_AKTIVA,substr(JENIS_INVESTASI,11) as JENIS_INVESTASI,TAHUN_INVESTASI,REALISAS_SD_TAHUN_SEBELUMNYA FROM TABEL_COBA_COMPLITE
         WHERE KODE_CABANG= 000
         GROUP BY PROJECT_NUMBER,JUDUL_INVESTASI,KEBUTUHAN_DANA,JENIS_AKTIVA,JENIS_INVESTASI,TAHUN_INVESTASI,REALISAS_SD_TAHUN_SEBELUMNYA");
         return $query->result();
    }

    public function poc_sub($cabang)
    {
         $query = $this->db->query("SELECT B.RKAP_INVS_ID,A.PROJECT_NUMBER,A.NOMOR_KONTRAK,A.JUDUL_SUB_PROGRAM,A.KEBUTUHAN_DANA_PO, A.KONTRAKTOR_PELAKSANA,A.REALISAS_SD_TAHUN_SEBELUMNYA FROM ( 
          SELECT distinct PROJECT_NUMBER,NOMOR_KONTRAK,nvl(JUDUL_SUB_PROGRAM,'KOSONG') AS JUDUL_SUB_PROGRAM,KEBUTUHAN_DANA_PO, KONTRAKTOR_PELAKSANA,REALISAS_SD_TAHUN_SEBELUMNYA FROM TABEL_COBA_COMPLITE
          WHERE KODE_CABANG = $cabang AND NOMOR_KONTRAK IS NOT NULL) A
          JOIN TX_RKAP_INVESTATION B ON A.PROJECT_NUMBER = B.RKAP_INVS_PROJECT_NUMBER");
         return $query->result();
    }

    public function poc_real($cabang)
    {
         $query = $this->db->query("SELECT A.RKAP_SUBPRO_ID,B.PERIOD_RKAP,A.NOK,TO_CHAR(B.PERIOD_RKAP,'MM') AS bulan,TO_CHAR(B.PERIOD_RKAP,'YYYY') AS tahun,A.VAL,(B.AMT_RCP_BLNLALU / A.VAL * 100) AS persen,B.AMT_RCP_BLNLALU FROM (
          SELECT d.RKAP_SUBPRO_ID,d.RKAP_SUBPRO_CONTRACT_NO NOK,d.RKAP_SUBPRO_CONTRACT_VALUE VAL
          FROM TX_RKAP_INVESTATION a
          LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
          JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
          JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
          WHERE a.IS_DELETED =0 AND d.IS_DELETED = 0 AND c.BRANCH_ID = $cabang) A
          JOIN (SELECT distinct PROJECT_NUMBER,NOMOR_KONTRAK,to_date(PERIOD_RKAP,'MON-YY','NLS_DATE_LANGUAGE = American') AS PERIOD_RKAP,AMT_RCP_BLNLALU FROM TABEL_COBA_COMPLITE
          WHERE KODE_CABANG = $cabang AND NOMOR_KONTRAK IS NOT NULL) B ON A.NOK = B.NOMOR_KONTRAK
          ORDER BY A.NOK,B.PERIOD_RKAP");
         return $query->result();
    }

    //------------------------------------------------------------------------------------------------------------------------------
    //dari view yang baru
    public function procosinv()
    {
         $query = $this->db->query("SELECT * FROM PROCOST_INVESTASTI");
         return $query->result();
    }
    public function procoskon()
    {
         $query = $this->db->query("SELECT PROJECT_ID,PO_DESC,concat(PROJECT_ID,PO_NUMBER) AS PO_NUMBER,NO_KONTRAK,PO_AMT,VENDOR_ID,TO_CHAR(PO_DATE,'YYYY-MM-DD') PO_DATE FROM PROCOST_KONTRAK");
         return $query->result();
    }
    public function procosreal()
    {
         $query = $this->db->query("SELECT PO_NUMBER,sum(PO_AMT) PO_AMT,sum(RCV_AMT) RCV_AMT,TO_CHAR(TO_DATE(RCV_DATE,'YYYY-MM'),'YYYY-MM-DD') tgl,TO_NUMBER(TO_CHAR(TO_DATE(RCV_DATE,'YYYY-MM'),'MM')) bulan,TO_CHAR(TO_DATE(RCV_DATE,'YYYY-MM'),'YYYY') tahun,(sum(RCV_AMT)/sum(PO_AMT)*100) persen FROM (
          SELECT PO_NUMBER,PO_AMT,RCV_AMT,RCV_DATE FROM (
          SELECT TO_NUMBER(concat(PROJECT_ID,PO_NUMBER)) AS PO_NUMBER,PO_AMT,RCV_AMT,TO_CHAR(RCV_DATE,'YYYY-MM') RCV_DATE FROM PROCOST_REALISASI))
          GROUP BY PO_NUMBER,RCV_DATE
          ORDER BY PO_NUMBER,TO_DATE(RCV_DATE,'YYYY-MM')");
         return $query->result();
    }


    //-------------------------------------------------------------------------------------------------------------------------------

    public function tambah_poc_inv($RKAP_INVS_ID,$RKAP_INVS_PROJECT_NUMBER,$RKAP_INVS_TITLE,$RKAP_INVS_ASSETS,$RKAP_INVS_TYPE,$RKAP_INVS_YEAR,$RKAP_INVS_COST_REQ,$RKAP_INVS_VALUE,$RKAP_INVS_QUARTER_I,$RKAP_INVS_QUARTER_II,$RKAP_INVS_QUARTER_III,$RKAP_INVS_QUARTER_IV,$RKAP_INVS_USER_ID,$RKAP_INVS_POS)
    {
         $this->db->query("INSERT INTO INV_DASH.TX_RKAP_INVESTATION 
         (RKAP_INVS_ID, RKAP_INVS_PROJECT_NUMBER,RKAP_INVS_TITLE ,RKAP_INVS_ASSETS ,RKAP_INVS_TYPE,RKAP_INVS_YEAR,RKAP_INVS_COST_REQ,RKAP_INVS_VALUE ,RKAP_INVS_QUARTER_I,RKAP_INVS_QUARTER_II,RKAP_INVS_QUARTER_III,RKAP_INVS_QUARTER_IV ,RKAP_INVS_USER_ID,CREATED_AT,IS_DELETED,RKAP_INVS_POS, PICTURE_BEFORE,PICTURE_AFTER,IS_UPLOADED_BEFORE,ON_USE) 
         VALUES ('$RKAP_INVS_ID','$RKAP_INVS_PROJECT_NUMBER','$RKAP_INVS_TITLE','$RKAP_INVS_ASSETS','$RKAP_INVS_TYPE', '$RKAP_INVS_YEAR','$RKAP_INVS_COST_REQ','$RKAP_INVS_VALUE','$RKAP_INVS_QUARTER_I','$RKAP_INVS_QUARTER_II','$RKAP_INVS_QUARTER_III','$RKAP_INVS_QUARTER_IV','$RKAP_INVS_USER_ID',CURRENT_TIMESTAMP,'0','$RKAP_INVS_POS','no_image.jpg','no_image.jpg','0','Y')");
    }

    public function tambah_poc_sub($RKAP_SUBPRO_ID,$RKAP_SUBPRO_INVS_ID,$RKAP_SUBPRO_TITTLE,$RKAP_SUBPRO_CONTRACT_NO,$PO_DATE,$RKAP_SUBPRO_CONTRACT_VALUE,$RKAP_SUBPRO_CONTRACTOR,$RKAP_CONTRACT_VALUE_HISTORY)
    {
     $this->db->query("INSERT INTO INV_DASH.TX_RKAP_SUB_PROGRAM 
          (RKAP_SUBPRO_ID,RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_TITTLE,RKAP_SUBPRO_CONTRACT_NO,RKAP_SUBPRO_CONTRACT_DATE,RKAP_SUBPRO_CONTRACT_VALUE,RKAP_SUBPRO_PERIODE,RKAP_SUBPRO_REAL_BEFORE,RKAP_SUBPRO_CONTRACTOR,IS_DELETED,RKAP_SUBPRO_START,IS_GANTTCHART,RKAP_CONTRACT_VALUE_HISTORY) 
          VALUES ('$RKAP_SUBPRO_ID','$RKAP_SUBPRO_INVS_ID','$RKAP_SUBPRO_TITTLE','$RKAP_SUBPRO_CONTRACT_NO',to_date('$PO_DATE','YYYY-MM-DD'),'$RKAP_SUBPRO_CONTRACT_VALUE','1','0','$RKAP_SUBPRO_CONTRACTOR','0',to_date('$PO_DATE','YYYY-MM-DD'),'0','$RKAP_CONTRACT_VALUE_HISTORY')");
    }

    public function tambah_poc_real($RKAP_SUBPRO_ID,$REAL_SUBPRO_MONTH,$REAL_SUBPRO_YEAR,$REAL_SUBPRO_PERCENT,$REAL_SUBPRO_VAL,$REAL_SUBPRO_DATE,$REAL_SUBPRO_MONTH_NEW)
    {
         $this->db->query("INSERT INTO INV_DASH.TX_REAL_SUB_PROGRAM 
         (RKAP_SUBPRO_ID,REAL_SUBPRO_MONTH,REAL_SUBPRO_COST,REAL_SUBPRO_STATUS,REAL_SUBPRO_CONSTRAINTS,REAL_SUBPRO_COMMENT,REAL_SUBPRO_YEAR,REAL_SUBPRO_PERCENT,REAL_SUBPRO_VAL,IS_DELETED,REAL_SUBPRO_DATE,REAL_SUBPRO_PERCENT_TOT,REAL_SUBPRO_MONTH_NEW) 
         VALUES ('$RKAP_SUBPRO_ID','$REAL_SUBPRO_MONTH','0','1','1','-', '$REAL_SUBPRO_YEAR','$REAL_SUBPRO_PERCENT', '$REAL_SUBPRO_VAL','0', to_date('$REAL_SUBPRO_DATE','YYYY-MM-DD'),'0','$REAL_SUBPRO_MONTH_NEW')");
    }

    // proses tambah------------------------------------------------------------------------------------------------------------------
    // proses procost 

    public function proses_rkap_ins($RKIID,$RKIPR,$RKITI,$RKIAS,$RKITY,$RKIYE,$RKICO,$RKIVA,$RKIQ1,$RKIQ2,$RKIQ3,$RKIQ4,$RKIRE,$RKITA,$RKIUS,$RKIPO)
    {
         $this->db->query("CALL INSERTRKAP ($RKIID,'$RKIPR','$RKITI','$RKIAS','$RKITY','$RKIYE','$RKICO','$RKIVA','$RKIQ1','$RKIQ2','$RKIQ3','$RKIQ4','$RKIRE','$RKITA','$RKIUS','$RKIPO')");
    }

    public function proses_kontrak_ins($RKSID,$RKSIN,$RKSTI,$RKSTY,$RKSCN,$RKSCD,$RKSCV,$RKSPE,$RKSFG,$RKSRB,$RKSCR,$ISDEL,$ISGAN,$RKERL,$RKTLY,$RKCRW)
    {
         $this->db->query("CALL INSERTKONTRAK ('$RKSID','$RKSIN','$RKSTI','$RKSTY','$RKSCN','$RKSCD','$RKSCV','$RKSPE','$RKSFG','$RKSRB','$RKSCR','$ISDEL','$ISGAN','$RKERL','$RKTLY','$RKCRW')");
    }
    
    public function proses_realisasi_ins($RKSID,$RLSMN,$RLSCT,$RLSSS,$RLSCS,$RLSCM,$RLSYR,$RLSPT,$RLSVL,$ISDTD,$RLSDT,$RLSPR,$RLSMO)
    {
          $this->db->query("CALL INSERTREALISASI('$RKSID','$RLSMN','$RLSCT','$RLSSS','$RLSCS','$RLSCM','$RLSYR','$RLSPT','$RLSVL','$ISDTD','$RLSDT','$RLSPR','$RLSMO')");
    }
    public function proses_addendum_ins($RKSID,$SBRAN,$SBRAD,$SBRAV,$SBRAP,$SBRAE,$ISDEL,$SBRDR)
    {
         $this->db->query("CALL INSERTADDENDUM($RKSID,'$SBRAN','$SBRAD','$SBRAV','$SBRAP','$SBRAE','$ISDEL','$SBRDR')");
    }
    public function proses_addendum_ins2($RKSID,$SBRAN,$SBRAD,$SBRAV,$SBRAP,$SBRAE,$ISDEL,$SBRDR)
    {
         $query = $this->db->query("select rkap_subpro_contract_value from tx_rkap_sub_program where rkap_subpro_id = $RKSID");
         $jumlah = $query->row()->RKAP_SUBPRO_CONTRACT_VALUE + $SBRAV;
         $this->db->query("UPDATE tx_rkap_sub_program SET rkap_subpro_contract_value = $jumlah where rkap_subpro_id = $RKSID");
         $this->db->query("CALL INSERTADDENDUM($RKSID,'$SBRAN','$SBRAD','$SBRAV','$SBRAP','$SBRAE','$ISDEL','$SBRDR')");
    }
    public function find_subprogram($id) {
          return $this->db->get_where('TX_RKAP_SUB_PROGRAM', array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id))->row();
    }
    public function add_history_addendumm($data) {
          return $this->db->insert('TX_SUBPROGRAM_ADDENDUM_HISTORY', $data);
    }
    public function cek_addendum_yyn($id)
    {
        $result = $this->db->query("SELECT count(*) as addv from tx_sub_program_addendum
        where rkap_subpro_id = $id and is_deleted = 0");
        return $result->result()[0]->ADDV;
    }
    public function proses_update_k($id,$value)
    {
         $this->db->query("UPDATE tx_rkap_sub_program SET rkap_subpro_contract_value = $value where rkap_subpro_id = $id");
    }

    public function add2($data) {
          return $this->db->insert('TX_RKAP_SUB_PROGRAM_MONTHLY', $data);
    }

    public function deletereal($id)
    {
         $this->db->query("DELETE FROM tx_real_sub_program WHERE rkap_subpro_id = $id");
    }
    public function deletekontrak($id)
    {
         $this->db->query("DELETE FROM tx_rkap_sub_program WHERE rkap_subpro_id = $id");
    }


    public function selectidinvest($id)
    {
         $query = $this->db->query("SELECT a.RKAP_INVS_ID,count(b.rkap_subpro_id) jml from tx_rkap_investation a join tx_rkap_sub_program b on a.rkap_invs_id = b.rkap_subpro_invs_id where a.rkap_invs_user_id = $id group by a.RKAP_INVS_ID");
         return $query->result();
    }
    public function selectidinvestall($id)
    {
         $query = $this->db->query("SELECT RKAP_INVS_ID from tx_rkap_investation where rkap_invs_user_id = $id");
         return $query->result();
    }
    public function selectidinvest2($id,$id2)
    {
         $query = $this->db->query("SELECT RKAP_INVS_ID from tx_rkap_investation
         where rkap_invs_user_id = $id and RKAP_INVS_ID = $id2");
         return $query->result();
    }

    public function add_history($cabang,$jumlah,$jenis)
    {
         $this->db->query("INSERT INTO INV_DASH.HISTORY_INTEGRASI (ID_HISTORY, CABANG, DATA_MASUK, TANGGAL, JENIS) VALUES ((select count(*) + 1 from HISTORY_INTEGRASI), '$cabang', $jumlah,CURRENT_TIMESTAMP,'$jenis')");
    }

    public function tabel_h($jenis)
    {
     $query = $this->db->query("SELECT cabang,data_masuk,to_char(tanggal,'DD-MM-YYY HH24:MI:SS') tgl from HISTORY_INTEGRASI
     where jenis = '$jenis'
     order by id_history desc");
     return $query->result();
    }

    
    public function c($cabang)
    {
         $query = $this->db->query("");
         return $query->result();
    }

    //------------notifikasi kontrak----------------------------------------------------------------

    public function insertkontrakdum($table,$data)
    {
     $this->db->insert($table, $data);
    }

    public function getdatadumm()
    {
         $query = $this->db->query("SELECT a.rkap_invs_id,a.rkap_invs_project_number,a.rkap_invs_title,b.po_number,b.po_desc,b.no_kontrak,b.po_date,b.po_amt from tx_rkap_investation a join procost_kontrak_dummy b on a.rkap_invs_id = b.project_id
         where b.simpan = 'N' order by a.rkap_invs_id,b.po_date");
         return $query->result();
    }

    public function dump($id)
    {
         $query = $this->db->query("SELECT * FROM procost_kontrak_dummy WHERE po_number = '$id'");
         return $query->row();
    }

    public function updatedump($id)
    {
         $this->db->query("UPDATE procost_kontrak_dummy SET simpan = 'Y' where po_number = '$id'");
    }

    public function inserttointeg($id1,$id2)
    {
         $this->db->query("INSERT INTO PROCOST_INTEGRASI_REALISASI (ID_KONTRAK, ID_REF) VALUES ('$id1', '$id2')");
    }

    public function updaterealintegrasi($id,$val)
    {
         $this->db->query("UPDATE TX_REAL_SUB_PROGRAM SET REAL_SUBPRO_VAL = '$val' where  REAL_SUBPRO_ID = $id");
    }
    public function getsama($id,$date)
    {
          $query = $this->db->query("SELECT REAL_SUBPRO_ID,REAL_SUBPRO_VAL from TX_REAL_SUB_PROGRAM where RKAP_SUBPRO_ID  = $id and TO_CHAR(REAL_SUBPRO_DATE,'YYYY-MM') = TO_CHAR(TO_DATE('$date','YYYY-MM-DD'),'YYYY-MM')");
          return $query->row();
    }
    public function getref($id)
    {
         $query = $this->db->query("select id_ref from procost_integrasi_realisasi where id_kontrak = $id");
         return $query->row();
    }

    public function insertrealdumpp($dt1,$dt2,$dt3)
    {
         $this->db->query("INSERT INTO PROCOST_REALISASI_DUMMY (PO_NUMBER, RCV_DATE, RCV_AMT) VALUES ('$dt1', '$dt2', '$dt3')");
    }

    public function cleanreal($id)
    {
         $q1 = $this->db->query("SELECT real_subpro_id from tx_real_sub_program where rkap_subpro_id = $id order by real_subpro_id asc");
         $q2 = $this->db->query("SELECT * from tx_real_sub_program where rkap_subpro_id = $id order by real_subpro_date asc");

         foreach ($q2->result() as $key => $v) {
              $id2 = $q1->result()[$key]->REAL_SUBPRO_ID;
              $this->db->query("UPDATE TX_REAL_SUB_PROGRAM SET REAL_SUBPRO_MONTH = '$v->REAL_SUBPRO_MONTH', REAL_SUBPRO_YEAR = '$v->REAL_SUBPRO_YEAR', REAL_SUBPRO_PERCENT = '$v->REAL_SUBPRO_PERCENT', REAL_SUBPRO_VAL = '$v->REAL_SUBPRO_VAL', REAL_SUBPRO_DATE = TO_DATE('$v->REAL_SUBPRO_DATE','DD-MON-YY'), REAL_SUBPRO_PERCENT_TOT = '$v->REAL_SUBPRO_PERCENT_TOT', REAL_SUBPRO_MONTH_NEW = '$v->REAL_SUBPRO_MONTH_NEW' WHERE REAL_SUBPRO_ID = $id2");
         }
    }

    public function ambildatadttable($id)
    {
         $query = $this->db->query("select a.rkap_invs_title,b.rkap_subpro_id,b.rkap_subpro_tittle,b.rkap_subpro_contract_no,round(b.rkap_subpro_contract_value,0) as rkap_subpro_contract_value from tx_rkap_investation a join tx_rkap_sub_program b on a.rkap_invs_id = b.rkap_subpro_invs_id
         where a.rkap_invs_id = $id");
         return $query->result();
    }

    public function cekdatamontly($id,$addno)
    {
         $query = $this->db->query("SELECT *  from  TX_RKAP_SUB_PROGRAM_MONTHLY
         where rkap_subpro_id = $id and is_addendum = $addno");
         return $query->num_rows();
    }

    public function updatedataaddendum($id,$date,$val)
    {
         $this->db->query("UPDATE TX_SUB_PROGRAM_ADDENDUM SET subpro_add_value = subpro_add_value + $val
         WHERE RKAP_SUBPRO_ID = $id and TO_CHAR(SUBPRO_ADD_DATE,'YYYY-MM') = TO_CHAR(TO_DATE('$date','YYYY-MM-DD'),'YYYY-MM')");
    }

    public function ambildatarealdummy()
    {
         $query = $this->db->query("select * from procost_realisasi_dummy order by po_number,rcv_date");
         return $query->result();
    }
    public function hapusdatarealdummy($id,$date)
    {
          $this->db->query("DELETE FROM procost_realisasi_dummy WHERE po_number = $id and rcv_date = '$date'");
    }

    
}