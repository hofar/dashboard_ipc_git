<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class addendum_model extends CI_Model {

    public function all_cabang() {
        $this->db->order_by('BRANCH_NAME', 'asc');
        return $this->db->get('TR_BRANCH')->result();
    }

    public function all_jenis_subprogram() {
        $this->db->order_by('SUBPRO_TYPE_NAME', 'asc');
        return $this->db->get('TR_SUBPRO_TYPE')->result();
    }

    public function ambilidrkap($id) {
        $query = $this->db->query("SELECT rkap_subpro_id as idd FROM tx_sub_program_addendum
        WHERE subpro_add_id = $id");
        return $query->row()->IDD;
    }

    public function add($data) {
        return $this->db->insert('TX_SUB_PROGRAM_ADDENDUM', $data);
    }
    
    public function add_max_data_again($persen_max) {
        return $this->db->insert('TX_RKAP_SUB_PROGRAM_MONTHLY', $persen_max);
    }

    public function addmontly($datamontly) {
        $this->db->where('TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID', $datamontly['RKAP_SUBPRO_ID']);
        $this->db->where('TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MONTH', $datamontly['SUBPRO_MONTH']);
        $this->db->select('TX_RKAP_SUB_PROGRAM_MONTHLY.*');
        $this->db->from('TX_RKAP_SUB_PROGRAM_MONTHLY');
        $query = $this->db->get();
        return $this->db->insert('TX_RKAP_SUB_PROGRAM_MONTHLY', $datamontly);
    }

    public function add_history_addendumm($data) {
        return $this->db->insert('TX_SUBPROGRAM_ADDENDUM_HISTORY', $data);
    }

    public function ambil_data($id) {
        $result = $this->db->query("SELECT COUNT(SUBPRO_MONTH) as SUBPRO_MONTH FROM TX_RKAP_SUB_PROGRAM_MONTHLY WHERE RKAP_SUBPRO_ID = '$id'");
        return $result->result_array();
    }

    public function cek_bulan_addendum($bulan_kontrak, $id) {
        $result = $this->db->query("SELECT * FROM TX_RKAP_SUB_PROGRAM_MONTHLY WHERE SUBPRO_MONTH >= '$bulan_kontrak' AND RKAP_SUBPRO_ID = '$id'");
        return $result->row();
    }

    public function all_addmonth($get_tahun, $id, $is_addendum) {
       $result = $this->db->query("SELECT YEARS, SUBPRO_VALUE, RKAP_SUBPRO_ID, SUBPRO_MONTH, SUBPRO_YEARS, CREATED_AT
                FROM
                (SELECT TX_RKAP_SUB_PROGRAM_MONTHLY.*, TO_CHAR(TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_YEARS, 'YYYY-MM') AS YEARS 
                FROM TX_RKAP_SUB_PROGRAM_MONTHLY 
                WHERE RKAP_SUBPRO_ID = '$id' AND IS_ADDENDUM = '$is_addendum')
                WHERE YEARS >= '$get_tahun' ");
        return $result->result();;
    }

    public function cek_is_addendum($id) {
        $this->db->select_max('TX_RKAP_SUB_PROGRAM_MONTHLY.IS_ADDENDUM');
        $this->db->from('TX_RKAP_SUB_PROGRAM_MONTHLY');
        $this->db->order_by('TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MON', 'asc');
        $where = array(
            'TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID' => $id
        );
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row()->IS_ADDENDUM;
    }

    public function get_month_max($id) {
        $result = $this->db->query("select max(SUBPRO_MONTH) as SUBPRO_MONTH from TX_RKAP_SUB_PROGRAM_MONTHLY where RKAP_SUBPRO_ID = '$id'");
        return $result->result_array();
    }

    //yayan
    //jangka
    //--------------------------------------
    public function ambiljangkawaktu($id) {
        $result = $this->db->query("SELECT b.subpro_mon,b.subpro_month,ltrim(TO_CHAR(b.subpro_years,'dd-MONTH-yyyy'),'0') as asubproyear,b.subpro_value,b.subpro_years from (
            SELECT ltrim(TO_CHAR(subpro_years,'MONTH-yyyy'),'0') as sy,max(subpro_mon) as subpro_mon FROM tx_rkap_sub_program_monthly
            where rkap_subpro_id = $id
            group by ltrim(TO_CHAR(subpro_years,'MONTH-yyyy'),'0')) a
        JOIN tx_rkap_sub_program_monthly b ON A.subpro_mon= B.subpro_mon
        order by b.subpro_years desc");
        return $result;
    }

    public function cek_addendum_yyn($id)
    {
        $result = $this->db->query("SELECT count(*) as addv from tx_sub_program_addendum
        where rkap_subpro_id = $id and is_deleted = 0");
        return $result->result()[0]->ADDV;
    }

    public function ambiljangkawaktu2($id) {
        $result = $this->db->query("SELECT 
        distinct(last_day(to_date(td.end_date + 1 - rownum))) as tgl
     from 
        all_objects,
        (SELECT MAX(subpro_years) end_date,MIN(subpro_years) start_date FROM tx_rkap_sub_program_monthly
         where rkap_subpro_id = $id) td
     where   
        trunc(td.end_date + 1 - rownum,'MM') >= trunc(td.start_date,'MM')
     order by tgl desc");
        return $result;
    }

    public function ambilnilai($id) {
        $result = $this->db->query("SELECT subpro_add_value NIL from tx_subprogram_addendum_history
        where rkap_subpro_id = $id AND is_deleted = 0 
        order by history_subpro_add_id desc");
        return $result;
    }

    public function coba()
    {
        $result = $this->db->query("select * from tm_assets");
        return $result->result();   
    }

    public function ambiladendumakhir($id)
    {
        $result = $this->db->query("SELECT * from tx_sub_program_addendum
        where rkap_subpro_id = $id and is_deleted = 0
        order by subpro_add_id desc");
        return $result;   
    }

    //--------------------------------------
     public function last_month($id) {
        $this->db->select('TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MONTH');
        $this->db->from('TX_RKAP_SUB_PROGRAM_MONTHLY');
        $where = array('TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('SUBPRO_MON', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_is_addendum_max($id) {
        $result = $this->db->query("select max(IS_ADDENDUM) as IS_ADDENDUM from TX_RKAP_SUB_PROGRAM_MONTHLY where RKAP_SUBPRO_ID = '$id'");
        return $result->result_array();
    }

    public function get_years_max($id , $max_is_addendum_set) {
        $result = $this->db->query("select min(SUBPRO_YEARS) as SUBPRO_YEARS from TX_RKAP_SUB_PROGRAM_MONTHLY where RKAP_SUBPRO_ID = '$id' and IS_ADDENDUM = '$max_is_addendum_set' ");
        return $result->result_array();
    }

    public function get_years_max_edit($id , $max_is_addendum_set) {
        $result = $this->db->query("select max(SUBPRO_YEARS) as SUBPRO_YEARS from TX_RKAP_SUB_PROGRAM_MONTHLY where RKAP_SUBPRO_ID = '$id' and IS_ADDENDUM = '$max_is_addendum_set' ");
        return $result->result_array();
    }

    public function get_years_max_add($id) {
        $result = $this->db->query("select max(SUBPRO_YEARS) as SUBPRO_YEARS from TX_RKAP_SUB_PROGRAM_MONTHLY where RKAP_SUBPRO_ID = '$id'");
        return $result->result_array();
    }
    
    public function get_persen_max($id) {
        $result = $this->db->query("select * from (SELECT * FROM TX_RKAP_SUB_PROGRAM_MONTHLY WHERE RKAP_SUBPRO_ID = '$id' ORDER BY SUBPRO_VALUE desc) where rownum <= 1");
        return $result->row();
    }
    
    public function cek_duplikat_max($id) {
        $result = $this->db->query("SELECT SUBPRO_MONTH, COUNT(*)SUBPRO_MONTH FROM TX_RKAP_SUB_PROGRAM_MONTHLY WHERE RKAP_SUBPRO_ID = '$id' GROUP BY SUBPRO_MONTH HAVING COUNT(SUBPRO_MONTH) > 1");
        return $result->row();
    }

    public function find_history_max($id) {
        $this->db->select_max('TX_SUBPROGRAM_ADDENDUM_HISTORY.VERSION');
        $this->db->from('TX_SUBPROGRAM_ADDENDUM_HISTORY');
        $this->db->order_by('TX_SUBPROGRAM_ADDENDUM_HISTORY.HISTORY_SUBPRO_ADD_ID', 'asc');
        $where = array(
            'TX_SUBPROGRAM_ADDENDUM_HISTORY.RKAP_SUBPRO_ID' => $id
        );
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row()->VERSION;
    }

    public function all_subprogram($id) {
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function all_addendum($id) {
        $this->db->select('TX_SUB_PROGRAM_ADDENDUM.*, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACTOR, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_SUB_PROGRAM_ADDENDUM');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_SUB_PROGRAM_ADDENDUM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_SUB_PROGRAM_ADDENDUM.IS_DELETED', 0);
        $this->db->order_by('TX_SUB_PROGRAM_ADDENDUM.SUBPRO_ADD_ID', 'desc');
        $where = array('TX_SUB_PROGRAM_ADDENDUM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function find_addendum($id) {
        $this->db->select('TX_SUB_PROGRAM_ADDENDUM.*, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACTOR, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID');
        $this->db->from('TX_SUB_PROGRAM_ADDENDUM');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_SUB_PROGRAM_ADDENDUM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_SUB_PROGRAM_ADDENDUM.IS_DELETED', 0);
        $where = array('TX_SUB_PROGRAM_ADDENDUM.SUBPRO_ADD_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function last_data($id_subpro) {
        $this->db->select('TX_SUBPROGRAM_ADDENDUM_HISTORY.*');
        $this->db->from('TX_SUBPROGRAM_ADDENDUM_HISTORY');
        $where = array('TX_SUBPROGRAM_ADDENDUM_HISTORY.RKAP_SUBPRO_ID' => $id_subpro);
        $this->db->where($where);
        $this->db->where('IS_DELETED', 0);
        $this->db->order_by('HISTORY_SUBPRO_ADD_ID', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function last_data_notselect($id_subpro, $id_history) {
        $this->db->select('TX_SUBPROGRAM_ADDENDUM_HISTORY.*');
        $this->db->from('TX_SUBPROGRAM_ADDENDUM_HISTORY');
        $where = array('TX_SUBPROGRAM_ADDENDUM_HISTORY.RKAP_SUBPRO_ID' => $id_subpro);
        $this->db->where($where);
        $this->db->order_by('HISTORY_SUBPRO_ADD_ID', 'desc');
        $this->db->where_not_in('HISTORY_SUBPRO_ADD_ID', $id_history);
        $this->db->where('IS_DELETED', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function last_data_nonhistory($id_subpro) {
        $this->db->select('TX_SUB_PROGRAM_ADDENDUM.*');
        $this->db->from('TX_SUB_PROGRAM_ADDENDUM');
        $where = array('TX_SUB_PROGRAM_ADDENDUM.RKAP_SUBPRO_ID' => $id_subpro);
        $this->db->where($where);
        $this->db->order_by('SUBPRO_ADD_ID', 'desc');
        $this->db->where('IS_DELETED', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function data_history_before($id_subpro, $id_history) {
        $cek_sebelumnya = $this->db->query("select max(HISTORY_SUBPRO_ADD_ID) as HISTORY_SUBPRO_ADD_ID FROM TX_SUBPROGRAM_ADDENDUM_HISTORY WHERE RKAP_SUBPRO_ID='" . $id_subpro . "' AND HISTORY_SUBPRO_ADD_ID < '" . $id_history . "'");
        $data_sebelumnya = $this->db->query("select * FROM TX_SUBPROGRAM_ADDENDUM_HISTORY WHERE RKAP_SUBPRO_ID='" . $id_subpro . "' AND HISTORY_SUBPRO_ADD_ID < '" . $id_history . "'");

        $id_sebelumnya = "";
        if ($cek_sebelumnya->num_rows() >1) {
            $id_sebelumnya = $cek_sebelumnya->row()->HISTORY_SUBPRO_ADD_ID;
            $this->db->select('TX_SUBPROGRAM_ADDENDUM_HISTORY.*');
            $this->db->from('TX_SUBPROGRAM_ADDENDUM_HISTORY');
            $where = array('TX_SUBPROGRAM_ADDENDUM_HISTORY.HISTORY_SUBPRO_ADD_ID' => $id_sebelumnya);
            $this->db->where($where);
             // $this->db->where('TX_SUBPROGRAM_ADDENDUM_HISTORY.IS_DELETED', 0);
            $query = $this->db->get();
            return $query->row();
        } else {
            // $data = array(
            //     "HISTORY_SUBPRO_ADD_ID" => $data_sebelumnya->row()->HISTORY_SUBPRO_ADD_ID,
            //     "RKAP_SUBPRO_ID" => $data_sebelumnya->row()->RKAP_SUBPRO_ID,
            //     "SUBPRO_ADD_NUM" => $data_sebelumnya->row()->SUBPRO_ADD_NUM,
            //     "SUBPRO_ADD_DATE" => $data_sebelumnya->row()->SUBPRO_ADD_DATE,
            //     "SUBPRO_ADD_VALUE" => $data_sebelumnya->row()->SUBPRO_ADD_VALUE,
            //     "SUBPRO_ADD_PERIODE" => $data_sebelumnya->row()->SUBPRO_ADD_PERIODE,
            //     "SUBPRO_ADD_ENDOF_GUARANTEE" => $data_sebelumnya->row()->SUBPRO_ADD_ENDOF_GUARANTEE,
            //     "SUBPRO_ADD_REAL_BEFORE" => $data_sebelumnya->row()->SUBPRO_ADD_REAL_BEFORE,
            //     "VERSION" => $data_sebelumnya->row()->VERSION
            // );

            $this->db->select('TX_SUBPROGRAM_ADDENDUM_HISTORY.*');
            $this->db->from('TX_SUBPROGRAM_ADDENDUM_HISTORY');
            $this->db->where('TX_SUBPROGRAM_ADDENDUM_HISTORY.RKAP_SUBPRO_ID', $id_subpro);
            $this->db->where('TX_SUBPROGRAM_ADDENDUM_HISTORY.HISTORY_SUBPRO_ADD_ID', $id_history);
             // $this->db->where('TX_SUBPROGRAM_ADDENDUM_HISTORY.IS_DELETED', 0);
            $this->db->order_by('HISTORY_SUBPRO_ADD_ID', 'desc');
            $query = $this->db->get();
            return $query->row();
        }
    }

    public function data_history_by_monthly($id_subpro) {
            $this->db->select('COUNT(RKAP_SUBPRO_ID) as RKAP_SUBPRO_ID');
            $this->db->from('TX_RKAP_SUB_PROGRAM_MONTHLY');
            $this->db->where('RKAP_SUBPRO_ID', $id_subpro);
            $this->db->where('IS_ADDENDUM', 0);
            $query = $this->db->get();
            return $query->row();
    }

    public function data_history_by_years($id_subpro) {
            $this->db->select_max('SUBPRO_YEARS');
            $this->db->from('TX_RKAP_SUB_PROGRAM_MONTHLY');
            $this->db->where('RKAP_SUBPRO_ID', $id_subpro);
            $this->db->where('IS_ADDENDUM', 0);
            $query = $this->db->get();
            return $query->row();
    }

    public function delete_monthly($id_subpro, $last_month)
    {
        return $this->db->delete('TX_RKAP_SUB_PROGRAM_MONTHLY', array('RKAP_SUBPRO_ID' => $id_subpro, 'IS_ADDENDUM' => $last_month));
    }

    public function detail($id) {
        $this->db->select('TX_SUB_PROGRAM_ADDENDUM.*, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACTOR, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_SUB_PROGRAM_ADDENDUM');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_SUB_PROGRAM_ADDENDUM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_SUB_PROGRAM_ADDENDUM.IS_DELETED', 0);
        $where = array('TX_SUB_PROGRAM_ADDENDUM.SUBPRO_ADD_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function search_title() {

        $title = $this->input->POST('title');
        $this->db->like('RKAP_SUBPRO_TITTLE', $title);
        $user = $this->session->userdata('SESS_USER_ID');
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME, TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_USER_ID', $user);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_kode() {

        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_SUBPRO_ID', $kode);
        $user = $this->session->userdata('SESS_USER_ID');
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID,  TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME, TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_USER_ID', $user);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_cabang() {

        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $user = $this->session->userdata('SESS_USER_ID');
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME,  TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_USER_ID', $user);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_title_kode_cabang() {

        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->like('RKAP_SUBPRO_TITTLE', $title);
        $this->db->like('RKAP_SUBPRO_ID', $kode);
        $user = $this->session->userdata('SESS_USER_ID');
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME,  TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_USER_ID', $user);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_title_kode() {

        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_SUBPRO_TITTLE', $title);
        $this->db->like('RKAP_SUBPRO_ID', $kode);
        $user = $this->session->userdata('SESS_USER_ID');
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME,  TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_USER_ID', $user);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_title_cabang() {

        $title = $this->input->POST('title');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->like('RKAP_SUBPRO_TITTLE', $title);
        $user = $this->session->userdata('SESS_USER_ID');
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME,  TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_USER_ID', $user);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
    }

    public function search_kode_cabang() {

        $kode = $this->input->POST('kode');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->like('RKAP_SUBPRO_ID', $kode);
        $user = $this->session->userdata('SESS_USER_ID');
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID,  TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME, TX_RKAP_INVESTATION.RKAP_INVS_USER_ID, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_USER_ID', $user);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        return $this->db->get('TX_RKAP_SUB_PROGRAM')->result();
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

    public function nilai_rkap_notselected_addendum($id_rkap, $id_subpro) {
        $this->db->select('SUM(RKAP_SUBPRO_CONTRACT_VALUE) as RKAP_VAL');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID' => $id_rkap);
        $this->db->where($where);
        $this->db->where_not_in('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id_subpro);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function find_rkap($id) {
        return $this->db->get_where('TX_RKAP_INVESTATION', array('TX_RKAP_INVESTATION.RKAP_INVS_ID' => $id))->row();
    }

    public function find_subprogram($id) {
        return $this->db->get_where('TX_RKAP_SUB_PROGRAM', array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id))->row();
    }

    public function find($id) {
        return $this->db->get_where('TX_SUB_PROGRAM_ADDENDUM', array('TX_SUB_PROGRAM_ADDENDUM.SUBPRO_ADD_ID' => $id))->row();
    }

    public function update($id, $data) {
        return $this->db->update('TX_SUB_PROGRAM_ADDENDUM', $data, array('SUBPRO_ADD_ID' => $id));
    }

     public function update_history($id, $data) {
        return $this->db->update('TX_SUBPROGRAM_ADDENDUM_HISTORY', $data, array('HISTORY_SUBPRO_ADD_ID' => $id));
    }

    public function delete($id, $data) {
        return $this->db->update('TX_SUB_PROGRAM_ADDENDUM', $data, array('SUBPRO_ADD_ID' => $id));
    }

    public function delete_history($id, $data) {
        return $this->db->update('TX_SUBPROGRAM_ADDENDUM_HISTORY', $data, array('HISTORY_SUBPRO_ADD_ID' => $id));
    }

    public function max_realisasi($id) {
        $this->db->select_sum('REAL_SUBPRO_VAL');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->where('IS_DELETED', 0);
        $this->db->where('RKAP_SUBPRO_ID', $id);
        $query = $this->db->get();
        return $query->row();
    }

}

?>