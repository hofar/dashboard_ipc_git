<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class rkap_model extends CI_Model {

    public function all_cabang() {
        $this->db->order_by('BRANCH_NAME', 'asc');
        return $this->db->get('TR_BRANCH')->result();
    }

    function get_insert_before($data, $id) {
        $this->db->set('TX_RKAP_INVESTATION.PICTURE_BEFORE', $data['PICTURE_BEFORE']);
        $this->db->set('TX_RKAP_INVESTATION.IS_UPLOADED_BEFORE', $data['IS_UPLOADED_BEFORE']);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_ID', $id);
        return $this->db->update('TX_RKAP_INVESTATION');
    }

    function get_insert_after($data, $id) {
        $this->db->set('TX_RKAP_INVESTATION.PICTURE_AFTER', $data['PICTURE_AFTER']);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_ID', $id);
        return $this->db->update('TX_RKAP_INVESTATION');
    }

    public function all_aktiva() {
        $this->db->order_by('ASSETS_NAME', 'asc');
        return $this->db->get('TM_ASSETS')->result();
    }

    public function all_investasi() {
        $this->db->order_by('INVS_TYPE_NAME', 'asc');
        return $this->db->get('TM_INVESTATION_TYPE')->result();
    }

    public function add($data) {
        return $this->db->insert('TX_RKAP_INVESTATION', $data);
    }

    public function all() {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME, TM_POSITION_PROGRAM.POSPROG_NAME');
        $this->db->from('TX_RKAP_INVESTATION');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID', 'left');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID', 'left');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID', 'left');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function all_limit($num, $offset) {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME, TM_POSITION_PROGRAM.POSPROG_NAME');
        $this->db->from('TX_RKAP_INVESTATION');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID', 'left');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID', 'left');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID', 'left');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        $this->db->limit($num, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function all_percabang($branch) {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME, TM_POSITION_PROGRAM.POSPROG_NAME');
        $this->db->from('TX_RKAP_INVESTATION');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID', 'left');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID', 'left');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID', 'left');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function branch_limit($branch, $num, $offset) {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME, TM_POSITION_PROGRAM.POSPROG_NAME');
        $this->db->from('TX_RKAP_INVESTATION');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID', 'left');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID', 'left');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID', 'left');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        $this->db->limit($num, $offset);
        $query = $this->db->get();

        return $query->result();
    }

    public function detail($id) {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_ASSETS.ASSETS_ID, TM_ASSETS.ASSETS_NAME, TM_INVESTATION_TYPE.INVS_TYPE_ID, TM_INVESTATION_TYPE.INVS_TYPE_NAME');
        $this->db->from('TX_RKAP_INVESTATION');
        $this->db->join('TM_ASSETS', 'TX_RKAP_INVESTATION.RKAP_INVS_ASSETS = TM_ASSETS.ASSETS_ID', 'left');
        $this->db->join('TM_INVESTATION_TYPE', 'TX_RKAP_INVESTATION.RKAP_INVS_TYPE = TM_INVESTATION_TYPE.INVS_TYPE_ID', 'left');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TX_RKAP_INVESTATION.RKAP_INVS_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function search_title() {

        $title = $this->input->POST('title');
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TR_BRANCH.BRANCH_ID, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->where("regexp_like(RKAP_INVS_TITLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_kode() {

        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_cabang() {

        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi() {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_cabang() {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_kode() {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_title() {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $title = $this->input->POST('title');
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_kode_cabang() {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_title_cabang() {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $title = $this->input->POST('title');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_title_kode() {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    //----------------------------------------------------------------------------------------

    /**
     * isue 1 searching pagination
     */
    public function searchcustom1($a, $b, $c, $d) {
        $query = $this->db->query("select a.*, b.USER_ID, b.USER_BRANCH, c.POSPROG_NAME, d.BRANCH_ID, d.BRANCH_NAME from tx_rkap_investation a
        join tm_users b on a.rkap_invs_user_id = b.user_id
        join tm_position_program c on a.rkap_invs_pos = c.posprog_id
        join tr_branch d on b.user_branch = d.branch_id
        where c.posprog_name like '$a' or regexp_like(a.RKAP_INVS_TITLE, '$b', 'i') or a.rkap_invs_id like '$c' or d.branch_name like '$d'");
        return $query;
    }

    public function searchcustom2_count($title, $kode, $cabang, $posisi) {
        $query = $this->db->query("SELECT a.*, b.USER_ID, b.USER_BRANCH, c.POSPROG_NAME, d.BRANCH_ID, d.BRANCH_NAME,rownum rown from tx_rkap_investation a
        join tm_users b on a.rkap_invs_user_id = b.user_id
        join tm_position_program c on a.rkap_invs_pos = c.posprog_id
        join tr_branch d on b.user_branch = d.branch_id
        where c.posprog_name like '$posisi' or regexp_like(a.RKAP_INVS_TITLE, '$title', 'i') or a.rkap_invs_id like '$kode' or d.branch_name like '$cabang'");

        return $query->num_rows();
    }

    public function searchcustom2($title, $kode, $cabang, $posisi, $num, $offset) {

        $query = $this->db->query("SELECT * from (select a.*, b.USER_ID, b.USER_BRANCH, c.POSPROG_NAME, d.BRANCH_ID, d.BRANCH_NAME,rownum rown from tx_rkap_investation a
        join tm_users b on a.rkap_invs_user_id = b.user_id
        join tm_position_program c on a.rkap_invs_pos = c.posprog_id
        join tr_branch d on b.user_branch = d.branch_id
        where c.posprog_name like '$posisi' or regexp_like(a.RKAP_INVS_TITLE, '$title', 'i') or a.rkap_invs_id like '$kode' or d.branch_name like '$cabang')
        where rown >= $num and rown <= $offset");

        return $query->result();
    }

    /** sorting */
    public function sortcustom($title, $kode, $cabang, $posisi, $num, $offset, $sort) {
        if ($sort == '1') {
            $q_sort = "order by a.rkap_invs_value asc";
        } else if ($sort == '2') {
            $q_sort = "order by a.rkap_invs_value desc";
        } else if ($sort == '3') {
            $q_sort = "order by a.rkap_invs_cost_req asc";
        } else if ($sort == '4') {
            $q_sort = "order by a.rkap_invs_cost_req desc";
        } else {
            $q_sort = "";
        }
        $query = $this->db->query("SELECT * from (SELECT RKAP_INVS_ID, RKAP_INVS_PROJECT_NUMBER, RKAP_INVS_TITLE, RKAP_INVS_ASSETS, RKAP_INVS_TYPE, RKAP_INVS_YEAR, RKAP_INVS_COST_REQ, RKAP_INVS_VALUE, RKAP_INVS_QUARTER_I, RKAP_INVS_QUARTER_II, RKAP_INVS_QUARTER_III, RKAP_INVS_QUARTER_IV, RKAP_INVS_REAL_BEFORE, RKAP_INVS_TAKSASI, RKAP_INVS_USER_ID, CREATED_AT, IS_DELETED, RKAP_INVS_POS, PICTURE_BEFORE, PICTURE_AFTER, UPLOADED_BEFORE, UPLOADED_AFTER, IS_UPLOADED_BEFORE, ON_USE, USER_ID, USER_BRANCH, POSPROG_NAME, BRANCH_ID, BRANCH_NAME,rownum rown from (
            select a.*, b.USER_ID, b.USER_BRANCH, c.POSPROG_NAME, d.BRANCH_ID, d.BRANCH_NAME,rownum rown from tx_rkap_investation a
                join tm_users b on a.rkap_invs_user_id = b.user_id
                join tm_position_program c on a.rkap_invs_pos = c.posprog_id
                join tr_branch d on b.user_branch = d.branch_id
                WHERE c.posprog_name like '$posisi' or regexp_like(a.RKAP_INVS_TITLE, '$title', 'i') or a.rkap_invs_id like '$kode' or d.branch_name like '$cabang'
                $q_sort)) where rown >= $num and rown <= $offset");

        return $query;
    }

    //-----------------------------------------------------------------------------------------
    public function search_posisi_title_kode_cabang() {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_title_kode_cabang() {

        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where("regexp_like(RKAP_INVS_TITLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_title_kode() {

        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->where("regexp_like(RKAP_INVS_TITLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_title_cabang() {

        $title = $this->input->POST('title');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->where("regexp_like(RKAP_INVS_TITLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_kode_cabang() {

        $kode = $this->input->POST('kode');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_kebutuhan_top() {

        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_COST_REQ', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_kebutuhan_down() {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_COST_REQ', 'asc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_rkap_top() {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_VALUE', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_rkap_down() {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_VALUE', 'asc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_sort_cabang() {
        $sort_cabang = $this->input->POST('sort_cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $sort_cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'asc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_kebutuhan_top_sort_cabang() {
        $sort_cabang = $this->input->POST('sort_cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $sort_cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_COST_REQ', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_kebutuhan_down_sort_cabang() {
        $sort_cabang = $this->input->POST('sort_cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $sort_cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_COST_REQ', 'asc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_rkap_top_sort_cabang() {
        $sort_cabang = $this->input->POST('sort_cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $sort_cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_VALUE', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_rkap_down_sort_cabang() {
        $sort_cabang = $this->input->POST('sort_cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $sort_cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_VALUE', 'asc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_kebutuhan_top_percabang($branch) {

        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_COST_REQ', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_kebutuhan_down_percabang($branch) {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_COST_REQ', 'asc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_rkap_top_percabang($branch) {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_VALUE', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function sort_rkap_down_percabang($branch) {
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->limit(10);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_VALUE', 'asc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_title_percabang($branch) {

        $title = $this->input->POST('title');
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where("regexp_like(RKAP_INVS_TITLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_kode_percabang($branch) {

        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_cabang_percabang($branch) {

        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_percabang($branch) {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_cabang_percabang($branch) {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_kode_percabang($branch) {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_title_percabang($branch) {

        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where("regexp_like(RKAP_INVS_TITLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_kode_cabang_percabang($branch) {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_cabang_title_percabang($branch) {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $title = $this->input->POST('title');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_title_kode_percabang($branch) {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_posisi_title_kode_cabang_percabang($branch) {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_title_kode_cabang_percabang($branch) {

        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->where("regexp_like(RKAP_INVS_TITLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_title_kode_percabang($branch) {

        $title = $this->input->POST('title');
        $kode = $this->input->POST('kode');
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->where("regexp_like(RKAP_INVS_TITLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_title_cabang_percabang($branch) {

        $title = $this->input->POST('title');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->where("regexp_like(RKAP_INVS_TITLE, '$title', 'i') and TX_RKAP_INVESTATION.IS_DELETED='0' ");
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function search_kode_cabang_percabang($branch) {

        $kode = $this->input->POST('kode');
        $cabang = $this->input->POST('cabang');
        $this->db->like('TR_BRANCH.BRANCH_NAME', $cabang);
        $this->db->like('RKAP_INVS_ID', $kode);
        $this->db->select('TX_RKAP_INVESTATION.*, TM_USERS.USER_ID, TM_USERS.USER_BRANCH, TM_POSITION_PROGRAM.POSPROG_NAME, TR_BRANCH.BRANCH_ID, TR_BRANCH.BRANCH_NAME');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID');
        $this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $where = array('TM_USERS.USER_BRANCH' => $branch);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_INVESTATION.RKAP_INVS_ID', 'desc');
        return $this->db->get('TX_RKAP_INVESTATION')->result();
    }

    public function find($id) {
        return $this->db->get_where('TX_RKAP_INVESTATION', array('TX_RKAP_INVESTATION.RKAP_INVS_ID' => $id))->row();
    }

    public function update($id, $data) {
        return $this->db->update('TX_RKAP_INVESTATION', $data, array('RKAP_INVS_ID' => $id));
    }

    public function delete($id, $data) {
        return $this->db->update('TX_RKAP_INVESTATION', $data, array('RKAP_INVS_ID' => $id));
    }

    public function get_contract($versi) {
        $this->db->select('TX_RKAP_INVESTATION.RKAP_INVS_PROJECT_NUMBER');
        $this->db->from('TX_RKAP_INVESTATION');
        $this->db->where('TX_RKAP_INVESTATION.IS_DELETED', 0);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_PROJECT_NUMBER IS NOT NULL', null);
        $this->db->where('TX_RKAP_INVESTATION.RKAP_INVS_PROJECT_NUMBER', $versi);
        $query = $this->db->get();
        return $query->result();
    }

    public function select_id_user($data_user) {
        $this->db->select('TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->where($data_user);
        return $this->db->get('TX_RKAP_INVESTATION')->row();
    }

    public function bulan_sebelumnya($get_bulan) {
        $query = $this->db->query("SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
                (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
                (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, 
                b.REAL_SUBPRO_VAL 
                FROM TX_RKAP_SUB_PROGRAM a 
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
                JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                WHERE c.IS_DELETED = 0 and b.IS_DELETED = 0 and a.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR = EXTRACT(YEAR FROM TO_DATE(current_date, 'DD-MON-RR')))
                WHERE AA < '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID)
                GROUP BY RKAP_SUBPRO_INVS_ID");
        return $query->result();
    }

    public function bulan_ini($get_bulan) {
        $query = $this->db->query("SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM
            (SELECT * FROM 
                (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, 
                b.REAL_SUBPRO_VAL 
                FROM TX_RKAP_SUB_PROGRAM a
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
                JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                WHERE c.IS_DELETED = 0 and b.IS_DELETED = 0 and a.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR = EXTRACT(YEAR FROM TO_DATE(current_date, 'DD-MON-RR')))
                WHERE AA = '$get_bulan')
                GROUP BY RKAP_SUBPRO_INVS_ID");
        return $query->result();
    }

    public function sampai_bulan_ini($get_bulan) {
        $query = $this->db->query("SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
                (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
                (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, 
                b.REAL_SUBPRO_VAL 
                FROM TX_RKAP_SUB_PROGRAM a 
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
                JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                WHERE c.IS_DELETED = 0 and b.IS_DELETED = 0 and a.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR = EXTRACT(YEAR FROM TO_DATE(current_date, 'DD-MON-RR')))
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID)
                GROUP BY RKAP_SUBPRO_INVS_ID");
        return $query->result();
    }

    public function sampai_bulan_ini_subpro($get_bulan) {
        $query = $this->db->query("SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL FROM 
                (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, 
                b.REAL_SUBPRO_VAL 
                FROM TX_RKAP_SUB_PROGRAM a 
                JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
                JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                WHERE c.IS_DELETED = 0 and b.IS_DELETED = 0 and a.IS_DELETED = 0)
                WHERE AA <= '$get_bulan'
                GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID");
        return $query->result();
    }

    public function hasil_sd_bulan_ini($get_bulan) {
        $query = $this->db->query("SELECT RKAP_SUBPRO_INVS_ID, REAL_SUBPRO_VAL,RKAP_INVS_VALUE,(CASE WHEN RKAP_INVS_VALUE > 0 THEN (REAL_SUBPRO_VAL / RKAP_INVS_VALUE * 100) ELSE 0 END) AS AA FROM
        (SELECT RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE  FROM 
        (SELECT RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, SUM(REAL_SUBPRO_VAL) as REAL_SUBPRO_VAL, RKAP_INVS_VALUE FROM 
        (SELECT a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_INVS_ID, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as AA, 
        b.REAL_SUBPRO_VAL, c.RKAP_INVS_VALUE
        FROM TX_RKAP_SUB_PROGRAM a
        JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
        JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
        WHERE c.IS_DELETED = 0)
        WHERE AA <= '$get_bulan'
        GROUP BY RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)
        GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE )");
        return $query->result();
    }

    public function hasil_rencana_sd_bulan_ini($get_bulan) {
        $query = $this->db->query("SELECT RKAP_SUBPRO_INVS_ID, AA, RKAP_INVS_VALUE, (CASE WHEN RKAP_INVS_VALUE > 0 THEN (AA / RKAP_INVS_VALUE * 100) ELSE 0 END) AS AB 
                FROM (SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA, RKAP_INVS_VALUE 
                FROM (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') AS TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA, c.RKAP_INVS_VALUE
                FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
                JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                WHERE c.IS_DELETED = 0)
                WHERE TAHUN = '$get_bulan'
                GROUP BY RKAP_SUBPRO_INVS_ID, RKAP_INVS_VALUE)");
        return $query->result();
    }

    public function hasil_persentase($get_bulan, $get_tahun, $month) {
        if ($month == 01) {
            $sum = "(jan) as TARGET";
        } else if ($month == 02) {
            $sum = "(jan + feb) as TARGET";
        } else if ($month == 03) {
            $sum = "(jan + feb + mar) as TARGET";
        } else if ($month == 04) {
            $sum = "(jan + feb + mar + apr) as TARGET";
        } else if ($month == 05) {
            $sum = "(jan + feb + mar + apr + may) as TARGET";
        } else if ($month == 06) {
            $sum = "(jan + feb + mar + apr + may + jun) as TARGET";
        } else if ($month == 07) {
            $sum = "(jan + feb + mar + apr + may + jun + jul) as TARGET";
        } else if ($month == 08) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug) as TARGET";
        } else if ($month == 09) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep) as TARGET";
        } else if ($month == 10) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct) as TARGET";
        } else if ($month == 11) {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov) as TARGET";
        } else {
            $sum = "(jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec) as TARGET";
        };

        $query = $this->db->query("SELECT RKAP_INVS_ID, REALISASI, TARGET, (REALISASI / TARGET * 100) AS DEVIASI 
            FROM( SELECT RKAP_INVS_ID, BRANCH_ID, BRANCH_NAME, REALISASI, $sum FROM 
                    (
                        SELECT RKAP_INVS_ID, BRANCH_ID, BRANCH_NAME, jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec, SUM(REAL_SUBPRO_VAL) AS REALISASI FROM 
                            (
                                SELECT c.RKAP_INVS_ID, a.RKAP_SUBPRO_ID, a.RKAP_SUBPRO_TITTLE, TO_CHAR(b.REAL_SUBPRO_DATE, 'YYYY-MM') as TANGGAL, b.REAL_SUBPRO_VAL,c.RKAP_INVS_VALUE, e.BRANCH_ID, e.BRANCH_NAME, c.RKAP_INVS_QUARTER_I, c.RKAP_INVS_QUARTER_II, c.RKAP_INVS_QUARTER_III, c.RKAP_INVS_QUARTER_IV, 
                                    (c.RKAP_INVS_QUARTER_I / 3) as jan, (c.RKAP_INVS_QUARTER_I / 3) as feb, (c.RKAP_INVS_QUARTER_I / 3) as mar, 
                                    (c.RKAP_INVS_QUARTER_II / 3) as apr, (c.RKAP_INVS_QUARTER_II / 3) as may, (c.RKAP_INVS_QUARTER_II / 3) as jun, 
                                    (c.RKAP_INVS_QUARTER_III / 3) as jul, (c.RKAP_INVS_QUARTER_III / 3) as aug, (c.RKAP_INVS_QUARTER_III / 3) as sep, 
                                    (c.RKAP_INVS_QUARTER_IV / 3) as oct, (c.RKAP_INVS_QUARTER_IV / 3) as nov, (c.RKAP_INVS_QUARTER_IV / 3) as dec
                                FROM TX_RKAP_SUB_PROGRAM a
                                    LEFT JOIN TX_REAL_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
                                    LEFT JOIN TX_RKAP_INVESTATION c ON a.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
                                    LEFT JOIN TM_USERS d ON c.RKAP_INVS_USER_ID = d.USER_ID
                                    LEFT JOIN TR_BRANCH e ON d.USER_BRANCH = e.BRANCH_ID
                                WHERE a.IS_DELETED = 0 AND b.IS_DELETED= 0 AND c.IS_DELETED = 0 AND b.REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')
                            )
                        WHERE TANGGAL <= '$get_bulan'
                        GROUP BY RKAP_INVS_ID, BRANCH_ID, BRANCH_NAME, jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec
                    )
                )");
        return $query->result();
    }

    public function get_previous_month($get_bulan2) {
        $query = $this->db->query("SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA FROM
            (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_MONTH, a.SUBPRO_VALUE, a.SUBPRO_YEARS, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA
            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a 
            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            WHERE c.IS_DELETED = 0
            AND a.SUBPRO_MONTH = '$get_bulan2')
            GROUP BY RKAP_SUBPRO_INVS_ID");
        return $query->result();
    }

    public function get_month($get_bulan) {
        $query = $this->db->query("SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA FROM
            (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') AS TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA
            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a
            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            WHERE c.IS_DELETED = 0)
            WHERE TAHUN = '$get_bulan'
            GROUP BY RKAP_SUBPRO_INVS_ID");
        return $query->result();
    }

    public function get_until_this_month($get_bulan) {
        $query = $this->db->query("SELECT RKAP_SUBPRO_INVS_ID, SUM(AA) AS AA FROM
            (SELECT a.SUBPRO_MON, a.RKAP_SUBPRO_ID, a.SUBPRO_VALUE, TO_CHAR(a.SUBPRO_YEARS, 'YYYY-MM') AS TAHUN, b.RKAP_SUBPRO_INVS_ID, b.RKAP_SUBPRO_CONTRACT_VALUE, ((a.SUBPRO_VALUE / 100) * b.RKAP_SUBPRO_CONTRACT_VALUE) AS AA
            FROM TX_RKAP_SUB_PROGRAM_MONTHLY a 
            JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID 
            JOIN TX_RKAP_INVESTATION c ON b.RKAP_SUBPRO_INVS_ID = c.RKAP_INVS_ID
            WHERE c.IS_DELETED = 0)
            WHERE TAHUN = '$get_bulan'
            GROUP BY RKAP_SUBPRO_INVS_ID");
        return $query->result();
    }

    public function find_after($id) {
        return $this->db->get_where('TX_RKAP_INVESTATION', array('TX_RKAP_INVESTATION.RKAP_INVS_ID' => $id))->row();
    }

    public function indikator_yyn($branch, $tgl) {
        if ($tgl == 1) {
            $sel = 'RKAP_INVS_QUARTER_I / 3';
        } else if ($tgl == 2) {
            $sel = 'RKAP_INVS_QUARTER_I / 3 * 2';
        } else if ($tgl == 3) {
            $sel = 'RKAP_INVS_QUARTER_I';
        } else if ($tgl == 4) {
            $sel = 'RKAP_INVS_QUARTER_I + ( RKAP_INVS_QUARTER_II / 3 )';
        } else if ($tgl == 5) {
            $sel = 'RKAP_INVS_QUARTER_I + ( RKAP_INVS_QUARTER_II / 3 * 2 )';
        } else if ($tgl == 6) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II';
        } else if ($tgl == 7) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + ( RKAP_INVS_QUARTER_III / 3 )';
        } else if ($tgl == 8) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + ( RKAP_INVS_QUARTER_III / 3 * 2 )';
        } else if ($tgl == 9) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III';
        } else if ($tgl == 10) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III + ( RKAP_INVS_QUARTER_IV / 3 )';
        } else if ($tgl == 11) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III + ( RKAP_INVS_QUARTER_IV / 3 * 2 )';
        } else if ($tgl == 12) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III +  RKAP_INVS_QUARTER_IV';
        }

        $query = $this->db->query("SELECT bb.BRANCH_NAME,aa.rkap_invs_id,aa.targetz,NVL(bb.realisasi,0) as realisasi from (select rkap_invs_id,( $sel ) as targetz 
        from tx_rkap_investation
        where is_deleted = 0) aa join (
        SELECT c.BRANCH_NAME,a.rkap_invs_id,a.RKAP_INVS_TITLE,sum(e.REAL_SUBPRO_VAL) as realisasi
        FROM TX_RKAP_INVESTATION a
        LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
        LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
        LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
        LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0 and REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
        WHERE a.IS_DELETED =0
        group by c.BRANCH_NAME,a.rkap_invs_id,a.RKAP_INVS_TITLE) bb on aa.rkap_invs_id = bb.rkap_invs_id");
        return $query->result();
    }

    public function indikator_yyn2($branch, $tgl) {
        if ($tgl == 1) {
            $sel = 'RKAP_INVS_QUARTER_I / 3';
        } else if ($tgl == 2) {
            $sel = 'RKAP_INVS_QUARTER_I / 3 * 2';
        } else if ($tgl == 3) {
            $sel = 'RKAP_INVS_QUARTER_I';
        } else if ($tgl == 4) {
            $sel = 'RKAP_INVS_QUARTER_I + ( RKAP_INVS_QUARTER_II / 3 )';
        } else if ($tgl == 5) {
            $sel = 'RKAP_INVS_QUARTER_I + ( RKAP_INVS_QUARTER_II / 3 * 2 )';
        } else if ($tgl == 6) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II';
        } else if ($tgl == 7) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + ( RKAP_INVS_QUARTER_III / 3 )';
        } else if ($tgl == 8) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + ( RKAP_INVS_QUARTER_III / 3 * 2 )';
        } else if ($tgl == 9) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III';
        } else if ($tgl == 10) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III + ( RKAP_INVS_QUARTER_IV / 3 )';
        } else if ($tgl == 11) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III + ( RKAP_INVS_QUARTER_IV / 3 * 2 )';
        } else if ($tgl == 12) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III +  RKAP_INVS_QUARTER_IV';
        }

        $query = $this->db->query("SELECT b1.*,b2.real_subpro_status,b2.real_subpro_percent_tot from (
            select a1.BRANCH_NAME, a1.RKAP_INVS_ID, a1.TARGETZ, a1.REALISASI, a1.PERSEN, a2.RKAP_SUBPRO_ID, a2.RKAP_SUBPRO_TITTLE, a2.RKAP_SUBPRO_CONTRACT_VALUE, a3.REAL_SUBPRO_ID from (
            select branch_name,rkap_invs_id,targetz,round(realisasi,1) realisasi,round(persen,1) persen from (
            SELECT bb.BRANCH_NAME,aa.rkap_invs_id,aa.targetz,NVL(bb.realisasi,0) as realisasi,(CASE WHEN aa.targetz > 0 THEN NVL(bb.realisasi,0) / aa.targetz * 100 else 100 end) persen from 
                (select rkap_invs_id,( $sel ) as targetz 
                    from tx_rkap_investation
                    where is_deleted = 0 and on_use = 'Y') aa join (
                    SELECT c.BRANCH_NAME,a.rkap_invs_id,a.RKAP_INVS_TITLE,sum(e.REAL_SUBPRO_VAL) as realisasi
                    FROM TX_RKAP_INVESTATION a
                    LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                    LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                    LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                    LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0 and REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                    WHERE a.IS_DELETED =0 and c.branch_id = $branch
                    group by c.BRANCH_NAME,a.rkap_invs_id,a.RKAP_INVS_TITLE) bb on aa.rkap_invs_id = bb.rkap_invs_id)
            where persen < 50) a1 join (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) a2 ON a1.RKAP_INVS_ID = a2.RKAP_SUBPRO_INVS_ID 
            join (select rkap_subpro_id,max(real_subpro_id) real_subpro_id from TX_REAL_SUB_PROGRAM where IS_DELETED = 0 group by rkap_subpro_id) a3 on a2.RKAP_SUBPRO_ID = a3.RKAP_SUBPRO_ID) b1 join TX_REAL_SUB_PROGRAM b2 on b1.real_subpro_id = b2.real_subpro_id
            where b2.real_subpro_percent_tot < 100  and b1.rkap_subpro_contract_value > 0
            order by b1.rkap_invs_id,b2.real_subpro_percent_tot");
        return $query->result();
    }

    public function indikator_yyn3($branch, $tgl) {
        if ($tgl == 1) {
            $sel = 'RKAP_INVS_QUARTER_I / 3';
        } else if ($tgl == 2) {
            $sel = 'RKAP_INVS_QUARTER_I / 3 * 2';
        } else if ($tgl == 3) {
            $sel = 'RKAP_INVS_QUARTER_I';
        } else if ($tgl == 4) {
            $sel = 'RKAP_INVS_QUARTER_I + ( RKAP_INVS_QUARTER_II / 3 )';
        } else if ($tgl == 5) {
            $sel = 'RKAP_INVS_QUARTER_I + ( RKAP_INVS_QUARTER_II / 3 * 2 )';
        } else if ($tgl == 6) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II';
        } else if ($tgl == 7) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + ( RKAP_INVS_QUARTER_III / 3 )';
        } else if ($tgl == 8) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + ( RKAP_INVS_QUARTER_III / 3 * 2 )';
        } else if ($tgl == 9) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III';
        } else if ($tgl == 10) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III + ( RKAP_INVS_QUARTER_IV / 3 )';
        } else if ($tgl == 11) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III + ( RKAP_INVS_QUARTER_IV / 3 * 2 )';
        } else if ($tgl == 12) {
            $sel = 'RKAP_INVS_QUARTER_I + RKAP_INVS_QUARTER_II + RKAP_INVS_QUARTER_III +  RKAP_INVS_QUARTER_IV';
        }

        $query = $this->db->query("SELECT rkap_invs_id,rkap_invs_title,targetz,realisasi,persen,count(a2.RKAP_SUBPRO_ID) jml from (
            select rkap_invs_id,rkap_invs_title,targetz,realisasi,persen from (
            SELECT aa.rkap_invs_id,bb.rkap_invs_title,aa.targetz,NVL(bb.realisasi,0) as realisasi,(CASE WHEN aa.targetz > 0 THEN NVL(bb.realisasi,0) / aa.targetz * 100 else 100 end) persen from 
                            (select rkap_invs_id,( $sel ) as targetz 
                                from tx_rkap_investation
                                where is_deleted = 0 and on_use = 'Y' and rkap_invs_pos <> 13) aa join (
                                SELECT c.BRANCH_NAME,a.rkap_invs_id,a.RKAP_INVS_TITLE,sum(e.REAL_SUBPRO_VAL) as realisasi
                                FROM TX_RKAP_INVESTATION a
                                LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
                                LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
                                LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
                                LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0 and REAL_SUBPRO_YEAR = TO_CHAR(sysdate,'YYYY')) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
                                WHERE a.IS_DELETED =0 and c.branch_id = $branch
                                group by c.BRANCH_NAME,a.rkap_invs_id,a.RKAP_INVS_TITLE) bb on aa.rkap_invs_id = bb.rkap_invs_id)
                                where persen < 50) a1 left join (
                                    select b1.rkap_subpro_invs_id,b1.rkap_subpro_id,max(b2.real_subpro_percent_tot) 
                                    from TX_RKAP_SUB_PROGRAM b1 join tx_real_sub_program b2 on b1.rkap_subpro_id = b2.rkap_subpro_id  
                                    where b1.IS_DELETED = 0  and b1.RKAP_SUBPRO_CONTRACT_VALUE > 0
                                    group by b1.rkap_subpro_invs_id,b1.rkap_subpro_id
                                    having max(b2.real_subpro_percent_tot) < 100) a2 on (a1.rkap_invs_id = a2.RKAP_SUBPRO_INVS_ID)
            group by rkap_invs_id,rkap_invs_title,targetz,realisasi,persen");
        $datar = [];
        foreach ($query->result() as $key => $v) {
            if ($v->JML > 0) {
                $k = $this->kendala2($v->RKAP_INVS_ID);
                if (count($k) == 0) {
                    $datar[] = array('RKAP_INVS_ID' => $v->RKAP_INVS_ID,
                        'RKAP_INVS_TITLE' => $v->RKAP_INVS_TITLE,
                        'JML' => $v->JML);
                }
            } else {
                $datar[] = array('RKAP_INVS_ID' => $v->RKAP_INVS_ID,
                    'RKAP_INVS_TITLE' => $v->RKAP_INVS_TITLE,
                    'JML' => $v->JML);
            }
        }

        return $datar;
    }

    public function kendala1($kode) {
        $query = $this->db->query("SELECT ac.real_subpro_id,ac.real_subpro_constraints as satu,ad.contraints_name as dua from (
            SELECT a.RKAP_INVS_ID,max(e.real_subpro_id) as iddd
            FROM TX_RKAP_INVESTATION a
            JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
            JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
            WHERE a.IS_DELETED =0  AND d.IS_DELETED = 0 AND e.IS_DELETED = 0 AND a.RKAP_INVS_ID = $kode
            group by a.RKAP_INVS_ID) ab JOIN 
            TX_REAL_SUB_PROGRAM ac on ab.iddd = ac.real_subpro_id
            JOIN tm_contraints ad ON ac.real_subpro_constraints = ad.contraints_id");
        if ($query->num_rows() <= 0) {
            return $ar = array((object) array('SATU' => '-', 'DUA' => 'Progress Terlambat'));
        } else {
            return $query->result();
        }
    }

    public function kendala2($kode) {
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

        return $query->result();
    }

}
