<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class notifikasi_model extends CI_Model {

    public function get_date_contract($id) {
        $this->db->select_min('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_DATE');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_DATE IS NOT NULL', null);
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_date_guarantee($id) {
        $this->db->select_max('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ENDOF_GUARANTEE');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ENDOF_GUARANTEE IS NOT NULL', null);
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID', $id);
        $query = $this->db->get();
        return $query->result();
    }

     public function get_last($id) {
        $this->db->select('TX_NOTIFICATION.LAST_UPDATE');
        $this->db->from('TX_NOTIFICATION');
        $this->db->where('TX_NOTIFICATION.LAST_UPDATE IS NOT NULL', null);
        $this->db->where('TX_NOTIFICATION.RKAP_INVS_ID', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add($data7) {
        return $this->db->insert('TX_NOTIFICATION', $data7);
    }

    public function get_branch($id) {
        $this->db->select('TM_USERS.USER_BRANCH');
        $this->db->from('TM_USERS');
        $this->db->where('TM_USERS.USER_ID',$this->session->userdata('SESS_USER_ID'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function realisasi_no($cab = '')
    {
        if ($cab != '' && $this->session->userdata('SESS_USER_PRIV') != 1) {
            $ca = 'and c.branch_id = '.$cab;
        }else{
            $ca = '';
        }

        $query = $this->db->query("SELECT a.rkap_subpro_id,a.branch_name,a.rkap_invs_title,a.rkap_subpro_tittle,c.subpro_type_name,b.real_subpro_percent_tot,to_char(b.real_subpro_date,'MONTH-YYYY') real_subpro_date from (
            SELECT c.BRANCH_NAME,a.RKAP_INVS_TITLE,d.rkap_subpro_id,d.rkap_subpro_tittle,d.rkap_subpro_type_id,d.rkap_subpro_end_real,max(e.real_subpro_id) idnn
            FROM TX_RKAP_INVESTATION a
            LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
            LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
            LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.is_deleted = 0 and a.on_use = 'Y' and d.is_deleted = 0 and e.is_deleted = 0 $ca
            group by c.BRANCH_NAME,a.RKAP_INVS_TITLE,d.rkap_subpro_id,d.rkap_subpro_tittle,d.rkap_subpro_type_id,d.rkap_subpro_end_real) a
        JOIN TX_REAL_SUB_PROGRAM b on (a.idnn = b.real_subpro_id)
        JOIN tr_subpro_type c on (a.rkap_subpro_type_id = c.subpro_type_id)
        where TO_CHAR(b.real_subpro_date,'MM-YYYY') < TO_CHAR(ADD_MONTHS(sysdate,-1),'MM-YYYY') and b.real_subpro_percent_tot < 100 and a.rkap_subpro_end_real is not null");
        return $query;
    }

    public function notifintegrasi()
    {
        $qu = $this->db->query("SELECT count(*) JML from  procost_kontrak_dummy where simpan = 'N'");
        return $qu->row();
    }
    public function notifintegrasireal()
    {
        $qu = $this->db->query("SELECT count(*) JML from  procost_realisasi_dummy");
        return $qu->row();
    }

}

?>