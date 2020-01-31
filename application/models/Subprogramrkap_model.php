<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class subprogramrkap_model extends CI_Model {

    public function all_cabang() {
        $this->db->order_by('BRANCH_NAME', 'asc');
        return $this->db->get('TR_BRANCH')->result();
    }

    public function all_jenis_subprogram() {
        $this->db->order_by('SUBPRO_TYPE_NAME', 'asc');
        return $this->db->get('TR_SUBPRO_TYPE')->result();
    }

    public function add($data) {
        return $this->db->insert('TX_RKAP_SUB_PROGRAM', $data);
    }
    //yayan
    //-------------------
    public function add2($data) {
        return $this->db->insert('TX_RKAP_SUB_PROGRAM_MONTHLY', $data);
    }
    public function ambilid($id) {
        $this->db->select_max('RKAP_SUBPRO_ID', 'ID');
        $this->db->where('RKAP_SUBPRO_INVS_ID', $id);
        $query = $this->db->get('TX_RKAP_SUB_PROGRAM');
        return $query->row()->ID;
    }

    public function ambiljangka($id) {
        $query = $this->db->query("SELECT count(*) as jml from  tx_rkap_sub_program_monthly
        where rkap_subpro_id = $id and is_addendum <> 0");
        return $query->row()->JML;
    }

    public function ambiladdendum($id) {
        $query = $this->db->query("SELECT count(*) as idd from tx_sub_program_addendum
        WHERE rkap_subpro_id = $id AND is_deleted = 0");
        return $query->row()->IDD;
    }

    public function ifjangka($id) {
        $query = $this->db->query("SELECT history_subpro_add_id,subpro_add_periode as per from tx_subprogram_addendum_history
        where rkap_subpro_id = $id AND is_deleted = 0 AND ROWNUM = 1");
        return $query;
    }

    public function kurvarealisasi($id) {
        $query = $this->db->query("SELECT ab.tgl,TO_CHAR(ab.tgl,'mm-yyyy') as tgll,ac.val from (
            select distinct(last_day(to_date(td.end_date + 1 - rownum))) as tgl
            from all_objects,(SELECT MAX(subpro_years) end_date,MIN(subpro_years) start_date FROM tx_rkap_sub_program_monthly
            where rkap_subpro_id = $id) td
            where trunc(td.end_date + 1 - rownum,'MM') >= trunc(td.start_date,'MM')
            order by 1) ab
        LEFT JOIN (
            SELECT TO_CHAR(real_subpro_date,'mm-yyyy') tgl,real_subpro_percent_tot val from tx_real_sub_program
            WHERE rkap_subpro_id = $id) ac ON TO_CHAR(ab.tgl,'mm-yyyy') = ac.tgl
        order by tgl");
        return $query->result();
    }

    public function kurvaaddendum($id,$d) {
        $query = $this->db->query("SELECT subpro_mon,ab.tgl,TO_CHAR(ab.tgl,'mm-yyyy') as tgll,ac.val from (
            select distinct(last_day(to_date(td.end_date + 1 - rownum))) as tgl
            from all_objects,(SELECT MAX(subpro_years) end_date,MIN(subpro_years) start_date FROM tx_rkap_sub_program_monthly
            where rkap_subpro_id = $id) td
            where trunc(td.end_date + 1 - rownum,'MM') >= trunc(td.start_date,'MM')
            order by 1) ab
        LEFT JOIN (
            SELECT subpro_mon,TO_CHAR(subpro_years,'mm-yyyy') tgl,subpro_value val  FROM tx_rkap_sub_program_monthly
            where rkap_subpro_id = $id AND is_addendum = $d
            ORDER BY subpro_mon) ac ON TO_CHAR(ab.tgl,'mm-yyyy') = ac.tgl
        order by tgl");
        return $query->result();
    }

    public function jumlhdata($id)
    {
        $query = $this->db->query("SELECT distinct(last_day(to_date(td.end_date + 1 - rownum))) as tgl
        from all_objects,(SELECT MAX(subpro_years) end_date,MIN(subpro_years) start_date FROM tx_rkap_sub_program_monthly
        where rkap_subpro_id = $id) td
        where trunc(td.end_date + 1 - rownum,'MM') >= trunc(td.start_date,'MM')
        order by 1");
        return $query->num_rows();
    }
    public function jmladendum($id) {
        $query = $this->db->query("SELECT count(*)+1 as jml from tx_sub_program_addendum
        where rkap_subpro_id = $id and is_deleted = 0");
        return $query->result()[0]->JML;
    }
    //----------------------

    public function all($id) {
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID', 'left');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID', 'left');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_contract($versi) {
        $this->db->select('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_NO');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_NO IS NOT NULL', null);
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_NO', $versi);
        $query = $this->db->get();
        return $query->result();
    }

    public function nilai_rkap($id) {
        $this->db->select('SUM(RKAP_SUBPRO_CONTRACT_VALUE) as RKAP_VAL');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function nilai_rkap_notselected($id_rkap, $id) {
        $this->db->select('SUM(RKAP_SUBPRO_CONTRACT_VALUE) as RKAP_VAL');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID' => $id_rkap);
        $this->db->where($where);
        $this->db->where_not_in('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetRow() {
        $this->db->select('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACTOR');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->group_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACTOR');
        $query = $this->db->get();
        return $query->result();
    }

    public function detail($id) {
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID', 'left');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID', 'left');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function search_title($id) {

        $title = $this->input->POST('title');
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME, TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where("regexp_like(RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID', $id);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_kode($id) {

        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_SUBPRO_ID', $kode);
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID,  TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME, TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID', $id);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_cabang($id) {

        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME,  TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID', $id);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_title_kode_cabang($id) {

        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->like('RKAP_SUBPRO_ID', $kode);
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME,  TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where("regexp_like(RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID', $id);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_title_kode($id) {

        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_SUBPRO_ID', $kode);
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME,  TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where("regexp_like(RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID', $id);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_title_cabang($id) {

        $title = $this->input->POST('title');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME,  TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where("regexp_like(RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID', $id);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_kode_cabang($id) {

        $kode = $this->input->POST('kode');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->like('RKAP_SUBPRO_ID', $kode);
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID,  TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME, TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID', $id);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function find_rkap($id) {
        return $this->db->get_where('TX_RKAP_INVESTATION', array('TX_RKAP_INVESTATION.RKAP_INVS_ID' => $id))->row();
    }

    public function find($id) {
        return $this->db->get_where('TX_RKAP_SUB_PROGRAM', array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id))->row();
    }

    public function update($id, $data) {
        return $this->db->update('TX_RKAP_SUB_PROGRAM', $data, array('RKAP_SUBPRO_ID' => $id));
    }

    public function delete($id, $data) {
        return $this->db->update('TX_RKAP_SUB_PROGRAM', $data, array('RKAP_SUBPRO_ID' => $id));
    }

    //  public function tampilvalue($id) {

    //     $result = $this->db->query("SELECT DISTINCT a.SUBPRO_MONTH,
    //     (select REAL_SUBPRO_PERCENT_TOT from TX_REAL_SUB_PROGRAM b where a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
    //     AND a.SUBPRO_MONTH = b.REAL_SUBPRO_MONTH AND b.IS_DELETED = '0') as REAL_SUBPRO_PERCENT 
    //     from TX_RKAP_SUB_PROGRAM_MONTHLY a where RKAP_SUBPRO_ID= '$id'  ORDER BY a.SUBPRO_MONTH asc");

    //     return $result->result();
    // }

     public function tampilvalue($id) {

        $result = $this->db->query("SELECT * FROM (
                    SELECT DISTINCT a.SUBPRO_MONTH, a.SUBPRO_MON,(
                    select b.REAL_SUBPRO_PERCENT_TOT
                    from TX_REAL_SUB_PROGRAM b 
                    where b.RKAP_SUBPRO_ID = a.RKAP_SUBPRO_ID AND EXTRACT(YEAR FROM TO_DATE(b.REAL_SUBPRO_DATE, 'DD-MON-RR')) = EXTRACT(YEAR FROM TO_DATE(a.SUBPRO_YEARS,'DD-MON-RR')) AND b.REAL_SUBPRO_MONTH = a.SUBPRO_MONTH AND b.IS_DELETED = '0' 
                    ) as REAL_SUBPRO_PERCENT,
                    (select b.REAL_SUBPRO_ID
                    from TX_REAL_SUB_PROGRAM b 
                    where b.RKAP_SUBPRO_ID = a.RKAP_SUBPRO_ID AND EXTRACT(YEAR FROM TO_DATE(b.REAL_SUBPRO_DATE, 'DD-MON-RR')) = EXTRACT(YEAR FROM TO_DATE(a.SUBPRO_YEARS,'DD-MON-RR')) AND b.REAL_SUBPRO_MONTH = a.SUBPRO_MONTH AND b.IS_DELETED = '0' 
                    ) as REAL_SUBPRO_ID
                    from TX_RKAP_SUB_PROGRAM_MONTHLY a where a.RKAP_SUBPRO_ID= '$id' )
                    ORDER BY SUBPRO_MON ASC");

        $result1 = $this->db->query("SELECT REAL_SUBPRO_PERCENT_TOT,REAL_SUBPRO_ID FROM TX_REAL_SUB_PROGRAM
        WHERE RKAP_SUBPRO_ID = '$id' order by REAL_SUBPRO_ID asc");
        $result2 = $this->db->query("SELECT SUBPRO_MONTH,SUBPRO_MON FROM TX_RKAP_SUB_PROGRAM_MONTHLY
        WHERE IS_ADDENDUM = 0 and RKAP_SUBPRO_ID = '$id' order by SUBPRO_MON asc");
        
        // for ($i=0; $i < count($result1->result()); $i++) { 
        //     $data[$i] = (object) array('SUBPRO_MONTH' => $result2->result()[$i]->SUBPRO_MONTH,
        //                       'SUBPRO_MON' => $result2->result()[$i]->SUBPRO_MON,
        //                       'REAL_SUBPRO_PERCENT' => $result1->result()[$i]->REAL_SUBPRO_PERCENT_TOT,
        //                       'REAL_SUBPRO_ID' => $result1->result()[$i]->REAL_SUBPRO_ID);
        // }
        $inc = 0;
        $res123 = $this->db->query("SELECT RKAP_SUBPRO_PERIODE FROM TX_RKAP_SUB_PROGRAM
        where RKAP_SUBPRO_ID = $id");
        foreach ($result->result() as $key => $value) {

            $tempd[$key] = $value->SUBPRO_MONTH;
            if ($tempd[$key] != $tempd[$key-1]) {

            $data2[$inc] = (object) array('SUBPRO_MONTH' => $value->SUBPRO_MONTH,
                              'SUBPRO_MON' => $value->SUBPRO_MON,
                              'REAL_SUBPRO_PERCENT' => $value->REAL_SUBPRO_PERCENT,
                              'REAL_SUBPRO_ID' => $value->REAL_SUBPRO_ID);
             
            $inc = $inc+1;
           }
           
          
        }

        $inc2 = 0;
        for ($i=0; $i < $res123->result()[0]->RKAP_SUBPRO_PERIODE; $i++) { 
            $tempdd[$i] = $data2[$i]->SUBPRO_MONTH;

            if ($tempdd[$i] != $tempdd[$i+1]) {

            $data3[$inc2] = (object) array('SUBPRO_MONTH' => $data2[$i]->SUBPRO_MONTH,
                              'SUBPRO_MON' => $data2[$i]->SUBPRO_MON,
                              'REAL_SUBPRO_PERCENT' => $data2[$i]->REAL_SUBPRO_PERCENT,
                              'REAL_SUBPRO_ID' => $data2[$i]->REAL_SUBPRO_ID);    
            }
            $inc2 = $inc2+1;
        }



        return $data3;
    }

    public function generates2($id)
    {
        $q1 = $this->db->query("SELECT b.RKAP_SUBPRO_ID,a.REAL_SUBPRO_ID,b.RKAP_SUBPRO_CONTRACT_VALUE,a.REAL_SUBPRO_PERCENT,a.REAL_SUBPRO_VAL,a.REAL_SUBPRO_PERCENT_TOT,((b.RKAP_SUBPRO_CONTRACT_VALUE / 100 * a.REAL_SUBPRO_PERCENT)+a.REAL_SUBPRO_COST) as newp,a.REAL_SUBPRO_COST,a.REAL_SUBPRO_MONTH,a.REAL_SUBPRO_DATE,a.REAL_SUBPRO_MONTH_NEW FROM TX_REAL_SUB_PROGRAM a
        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
        WHERE a.RKAP_SUBPRO_ID = $id
        ORDER BY a.REAL_SUBPRO_ID asc");

        $new2 = 0;
        for ($i=0; $i < $q1->num_rows(); $i++) {

            $new[$i] = $q1->result()[$i]->NEWP;
            $new2 = $new2 + $q1->result()[$i]->REAL_SUBPRO_PERCENT;

             $data = array(
                 'REAL_SUBPRO_VAL' => $new[$i],
                 'REAL_SUBPRO_PERCENT_TOT' => $new2           
            );

            //return json_encode($q1->result());

            $this->db->where('REAL_SUBPRO_ID', $q1->result()[$i]->REAL_SUBPRO_ID);
            $this->db->update('TX_REAL_SUB_PROGRAM', $data);
        
        }
    }

    public function generates3($id)
    {
        $q1 = $this->db->query("SELECT ((b.RKAP_SUBPRO_CONTRACT_VALUE / 100 * a.REAL_SUBPRO_PERCENT)+a.REAL_SUBPRO_COST) as newp,((a.REAL_SUBPRO_VAL - a.REAL_SUBPRO_COST) / b.RKAP_SUBPRO_CONTRACT_VALUE*100) as newp2,b.RKAP_SUBPRO_ID,a.REAL_SUBPRO_ID,b.RKAP_SUBPRO_CONTRACT_VALUE,a.REAL_SUBPRO_PERCENT,a.REAL_SUBPRO_VAL,a.REAL_SUBPRO_PERCENT_TOT,a.REAL_SUBPRO_COST,a.REAL_SUBPRO_MONTH,a.REAL_SUBPRO_DATE,a.REAL_SUBPRO_MONTH_NEW FROM TX_REAL_SUB_PROGRAM a
        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
        WHERE a.RKAP_SUBPRO_ID = $id
        ORDER BY a.REAL_SUBPRO_ID asc");

        $new2 = 0;
        for ($i=0; $i < $q1->num_rows(); $i++) {

            $new[$i] = $q1->result()[$i]->NEWP2;
            $new2 = $new2 + $q1->result()[$i]->NEWP2;

             $data = array(
                 'REAL_SUBPRO_PERCENT' => $new[$i],
                 'REAL_SUBPRO_PERCENT_TOT' => $new2           
            );

            //return json_encode($q1->result());

            $this->db->where('REAL_SUBPRO_ID', $q1->result()[$i]->REAL_SUBPRO_ID);
            $this->db->update('TX_REAL_SUB_PROGRAM', $data);
        
        }
    }

    public function generates4($id)
    {
        $q1 = $this->db->query("SELECT b.RKAP_SUBPRO_ID,a.REAL_SUBPRO_ID,b.RKAP_SUBPRO_CONTRACT_VALUE,a.REAL_SUBPRO_PERCENT,a.REAL_SUBPRO_VAL,a.REAL_SUBPRO_PERCENT_TOT,((b.RKAP_SUBPRO_CONTRACT_VALUE / 100 * a.REAL_SUBPRO_PERCENT)+a.REAL_SUBPRO_COST) as newp,a.REAL_SUBPRO_COST,a.REAL_SUBPRO_MONTH,a.REAL_SUBPRO_DATE,a.REAL_SUBPRO_MONTH_NEW FROM TX_REAL_SUB_PROGRAM a
        JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
        WHERE a.RKAP_SUBPRO_ID = $id
        ORDER BY a.REAL_SUBPRO_ID asc");

        $totalp = 0;
        for ($i=0; $i < $q1->num_rows(); $i++) {

            $persen = $q1->result()[$i]->REAL_SUBPRO_VAL / $q1->result()[$i]->RKAP_SUBPRO_CONTRACT_VALUE * 100;
            $totalp = $totalp + $persen;

             $data = array(
                 'REAL_SUBPRO_PERCENT' => $persen,
                 'REAL_SUBPRO_PERCENT_TOT' => $totalp           
            );

            //return json_encode($q1->result());

            $this->db->where('REAL_SUBPRO_ID', $q1->result()[$i]->REAL_SUBPRO_ID);
            $this->db->update('TX_REAL_SUB_PROGRAM', $data);
        
        }
    }

    public function generates($id)
    {
        $q1 = $this->db->query("SELECT * FROM TX_REAL_SUB_PROGRAM
        WHERE RKAP_SUBPRO_ID = $id ORDER BY REAL_SUBPRO_ID asc");
        //1016

        
        for ($i=0; $i < $q1->num_rows(); $i++) { 
            
            $dump1[$i] = $q1->result()[$i]->RKAP_SUBPRO_ID;
            $dump2[$i] = $q1->result()[$i]->REAL_SUBPRO_MONTH;
            $dump3[$i] = $q1->result()[$i]->REAL_SUBPRO_COST;
            $dump4[$i] = $q1->result()[$i]->REAL_SUBPRO_STATUS;
            $dump5[$i] = $q1->result()[$i]->REAL_SUBPRO_CONSTRAINTS;
            $dump6[$i] = $q1->result()[$i]->REAL_SUBPRO_DEADLINE;
            $dump7[$i] = $q1->result()[$i]->REAL_SUBPRO_COMMENT;
            $dump8[$i] = $q1->result()[$i]->CREATED_AT;
            $dump9[$i] = $q1->result()[$i]->REAL_SUBPRO_YEAR;
            $dump10[$i] = $q1->result()[$i]->REAL_SUBPRO_PERCENT;
            $dump11[$i] = $q1->result()[$i]->REAL_SUBPRO_VAL;
            $dump12[$i] = $q1->result()[$i]->IS_DELETED;
            $dump13[$i] = $q1->result()[$i]->REAL_SUBPRO_DATE;
            $dump14[$i] = $q1->result()[$i]->REAL_SUBPRO_PERCENT_TOT;
            $dump15[$i] = $q1->result()[$i]->REAL_SUBPRO_MONTH_NEW;

            //return json_encode();

            if ($i == 0) {
               
            }else {

            $data = array(
                
                    'RKAP_SUBPRO_ID' =>  $dump1[$i-1],
                    'REAL_SUBPRO_MONTH' =>  $dump2[$i-1],
                    'REAL_SUBPRO_COST' =>  $dump3[$i-1],
                    'REAL_SUBPRO_STATUS' =>  $dump4[$i-1],
                    'REAL_SUBPRO_CONSTRAINTS' =>  $dump5[$i-1],
                    'REAL_SUBPRO_DEADLINE' =>  $dump6[$i-1],
                    'REAL_SUBPRO_COMMENT' =>  $dump7[$i-1],
                    'CREATED_AT' =>  $dump8[$i-1],
                    'REAL_SUBPRO_YEAR' =>  $dump9[$i-1],
                    'REAL_SUBPRO_PERCENT' => $dump10[$i-1],
                    'REAL_SUBPRO_VAL' => $dump11[$i-1],
                    'IS_DELETED' => $dump12[$i-1],
                    'REAL_SUBPRO_DATE' => $dump13[$i-1],
                    'REAL_SUBPRO_PERCENT_TOT' => $dump14[$i-1],
                    'REAL_SUBPRO_MONTH_NEW' => $dump15[$i-1]
                    
            );
            
            $this->db->where('REAL_SUBPRO_ID', $q1->result()[$i]->REAL_SUBPRO_ID);
            $this->db->update('TX_REAL_SUB_PROGRAM', $data);
            
            }
            //return json_encode($dump);

        
        }
        
        
    }

    public function find_all_month_non_adden($id) {
        $this->db->select('TX_RKAP_SUB_PROGRAM_MONTHLY.*');
        $this->db->from('TX_RKAP_SUB_PROGRAM_MONTHLY');
        $this->db->where('TX_RKAP_SUB_PROGRAM_MONTHLY.IS_ADDENDUM', 0);
         $where = array('TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MON', 'asc');
         $query = $this->db->get();
        return $query->result();
    }


    public function find_all_month_adden($id) {
        $result = $this->db->query("SELECT * FROM (SELECT TX_RKAP_SUB_PROGRAM_MONTHLY.* , max(IS_ADDENDUM) over (partition by SUBPRO_MONTH) MAX_ADDENDUM
        FROM TX_RKAP_SUB_PROGRAM_MONTHLY WHERE TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID = '$id' ORDER BY TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MONTH ASC) WHERE IS_ADDENDUM = MAX_ADDENDUM");
        return $result->result();
    }

    public function tampilvalue_new($id) {

        $result = $this->db->query("SELECT a.SUBPRO_MONTH, SUBPRO_VALUE, 
        (select REAL_SUBPRO_PERCENT_TOT from TX_REAL_SUB_PROGRAM b where a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID AND a.SUBPRO_MONTH = b.REAL_SUBPRO_MONTH_NEW AND IS_DELETED = '0') as REAL_SUBPRO_PERCENT 
        from TX_RKAP_SUB_PROGRAM_MONTHLY a
        where RKAP_SUBPRO_ID= '$id' ORDER BY a.SUBPRO_MON ASC");

        return $result->result();
    }

    public function deviasi_rencana($id) {
        $this->db->select('SUBPRO_VALUE');
        $this->db->from('TX_RKAP_SUB_PROGRAM_MONTHLY');
        $this->db->join('TX_REAL_SUB_PROGRAM', 'TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MONTH = TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }

    public function deviasi_realisasi($id) {
        $this->db->select('REAL_SUBPRO_PERCENT_TOT');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->join('TX_RKAP_SUB_PROGRAM_MONTHLY', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MONTH');
        $this->db->join('TX_RKAP_SUB_PROGRAM_MONTHLY', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_YEARS');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }

    public function deviasi_realisasi_month($id) {
        $this->db->select('REAL_SUBPRO_MONTH, REAL_SUBPRO_PERCENT_TOT');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function deviasi_rencana_month($id, $realisasi_month) {
        $this->db->select('SUBPRO_MONTH, SUBPRO_VALUE');
        $this->db->from('TX_RKAP_SUB_PROGRAM_MONTHLY');
        $this->db->join('TX_REAL_SUB_PROGRAM', 'TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID = TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->where('TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MONTH', $realisasi_month);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete_monthly_sub($id_subpro)
    {
        return $this->db->delete('TX_RKAP_SUB_PROGRAM_MONTHLY', array('RKAP_SUBPRO_ID' => $id_subpro, 'IS_ADDENDUM' => 0));
    }

}

?>