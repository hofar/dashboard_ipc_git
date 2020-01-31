<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class realisasi_model extends CI_Model {

    public function all_cabang() {
        $this->db->order_by('BRANCH_NAME', 'asc');
        return $this->db->get('TR_BRANCH')->result();
    }

    public function all_status() {
        $this->db->order_by('STATUS_NAME', 'asc');
        return $this->db->get('TM_STATUS_PROGRAM')->result();
    }

    public function all_posisi() {
        $this->db->order_by('POSPROG_NAME', 'asc');
        return $this->db->get('TM_POSITION_PROGRAM')->result();
    }

    public function all_kendala() {
        $this->db->order_by('CONTRAINTS_NAME', 'asc');
        return $this->db->get('TM_CONTRAINTS')->result();
    }

    public function all_month() {
        $this->db->order_by('MONTH_ID', 'asc');
        return $this->db->get('TM_MONTH')->result();
    }

    public function all_years() {
        $this->db->order_by('YEARS_NAME', 'asc');
        return $this->db->get('TM_YEARS')->result();
    }

    public function all_jenis_subprogram() {
        $this->db->order_by('SUBPRO_TYPE_NAME', 'asc');
        return $this->db->get('TR_SUBPRO_TYPE')->result();
    }

    public function add($data) {
        return $this->db->insert('TX_REAL_SUB_PROGRAM', $data);
    }

    public function all_realisasi_program($id) {
        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID', 'left');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID', 'left');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID', 'left');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function hitung_realisasi($id) {
        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'asc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function data_sebelumnya($id, $id_subpro) {
        $cek_sebelumnya = $this->db->query("select max(REAL_SUBPRO_ID) as REAL_SUBPRO_ID FROM TX_REAL_SUB_PROGRAM WHERE RKAP_SUBPRO_ID='" . $id_subpro . "' AND REAL_SUBPRO_ID < '" . $id . "'");
        $id_sebelumnya = "";
        if ($cek_sebelumnya->num_rows() > 0) {
            $id_sebelumnya = $cek_sebelumnya->row()->REAL_SUBPRO_ID;
            $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
            $this->db->from('TX_REAL_SUB_PROGRAM');
            $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

            $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
            $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
            $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
            $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
            $where = array('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID' => $id_sebelumnya);
            $this->db->where($where);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            $data = array(
                "REAL_SUBPRO_ID" => '',
                "RKAP_SUBPRO_ID" => '',
                "REAL_SUBPRO_MONTH" => '',
                "REAL_SUBPRO_COST" => '',
                "REAL_SUBPRO_STATUS" => '',
                "REAL_SUBPRO_POS" => '',
                "REAL_SUBPRO_CONSTRAINTS" => '',
                "REAL_SUBPRO_DEADLINE" => '',
                "REAL_SUBPRO_COMMENT" => '',
                "REAL_SUBPRO_YEAR" => '',
                "REAL_SUBPRO_PERCENT" => '',
                "REAL_SUBPRO_VAL" => '',
                "REAL_SUBPRO_DATE" => ''
            );
        }
    }

    public function data_sebelumnya_add($id, $id_subpro) {
        $cek_sebelumnya = $this->db->query("select max(REAL_SUBPRO_ID) as REAL_SUBPRO_ID FROM TX_REAL_SUB_PROGRAM WHERE RKAP_SUBPRO_ID='" . $id . "' AND REAL_SUBPRO_ID <= '" . $id_subpro . "'");
        $id_sebelumnya = "";
        if ($cek_sebelumnya->num_rows() > 0) {
            $id_sebelumnya = $cek_sebelumnya->row()->REAL_SUBPRO_ID;
            $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
            $this->db->from('TX_REAL_SUB_PROGRAM');
            $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

            $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
            $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
            $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
            $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
            $where = array('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID' => $id_sebelumnya);
            $this->db->where($where);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            $data = array(
                "REAL_SUBPRO_ID" => '',
                "RKAP_SUBPRO_ID" => '',
                "REAL_SUBPRO_MONTH" => '',
                "REAL_SUBPRO_COST" => '',
                "REAL_SUBPRO_STATUS" => '',
                "REAL_SUBPRO_POS" => '',
                "REAL_SUBPRO_CONSTRAINTS" => '',
                "REAL_SUBPRO_DEADLINE" => '',
                "REAL_SUBPRO_COMMENT" => '',
                "REAL_SUBPRO_YEAR" => '',
                "REAL_SUBPRO_PERCENT" => '',
                "REAL_SUBPRO_VAL" => '',
                "REAL_SUBPRO_DATE" => ''
            );
        }
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

    public function detail($id) {
        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function search_title($id) {

        $title = $this->input->POST('title');

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis($id) {

        $type = $this->input->POST('type');
        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status($id) {

        $status = $this->input->POST('status');
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_posisi($id) {

        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_kendala($id) {

        $kendala = $this->input->POST('kendala');
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_null($id) {


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_month($id) {

        $month = $this->input->POST('month');
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_years($id) {

        $years = $this->input->POST('years');
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis($id) {

        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status($id) {

        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status($id) {

        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status($id) {

        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_posisi($id) {

        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_posisi($id) {

        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_posisi($id) {

        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_posisi($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_posisi($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_posisi($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_posisi($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_kendala($id) {
        $title = $this->input->POST('title');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_kendala($id) {
        $type = $this->input->POST('type');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_kendala($id) {
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_posisi_kendala($id) {
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_kendala($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_kendala($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_posisi_kendala($id) {
        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_kendala($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_posisi_kendala($id) {
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_posisi_kendala($id) {
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_kendala($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_posisi_kendala($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_posisi_kendala($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_posisi_kendala($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_posisi_kendala($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_month($id) {
        $title = $this->input->POST('title');
        $month = $this->input->POST('month');
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_month($id) {
        $type = $this->input->POST('type');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_month($id) {
        $status = $this->input->POST('status');
        $month = $this->input->POST('month');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_posisi_month($id) {
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_kendala_month($id) {
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_month($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_month($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $month = $this->input->POST('month');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_posisi_month($id) {
        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_kendala_month($id) {
        $title = $this->input->POST('title');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_month($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_posisi_month($id) {
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_kendala_month($id) {
        $type = $this->input->POST('type');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_posisi_month($id) {
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_kendala_month($id) {
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_posisi_kendala_month($id) {
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_month($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_posisi_month($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_kendala_month($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_posisi_month($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_kendala_month($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_posisi_kendala_month($id) {

        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_posisi_month($id) {

        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_kendala_month($id) {

        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_posisi_kendala_month($id) {

        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_posisi_kendala_month($id) {

        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');
        $type = $this->input->POST('type');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_posisi_kendala_month($id) {

        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_posisi_kendala_month($id) {

        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_posisi_kendala_month($id) {

        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_years($id) {
        $title = $this->input->POST('title');
        $years = $this->input->POST('years');

        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_years($id) {
        $type = $this->input->POST('type');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_years($id) {
        $status = $this->input->POST('status');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_posisi_years($id) {
        $posisi = $this->input->POST('posisi');
        $years = $this->input->POST('years');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_kendala_years($id) {
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_month_years($id) {
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_years($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_posisi_years($id) {
        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');
        $years = $this->input->POST('years');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_kendala_years($id) {
        $title = $this->input->POST('title');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_month_years($id) {
        $title = $this->input->POST('title');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_years($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_posisi_years($id) {
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_kendala_years($id) {
        $type = $this->input->POST('type');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_month_years($id) {
        $type = $this->input->POST('type');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_posisi_years($id) {
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_kendala_years($id) {
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_month_years($id) {
        $status = $this->input->POST('status');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_posisi_kendala_years($id) {
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_posisi_month_years($id) {
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_kendala_month_years($id) {
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_posisi_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_kendala_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_month_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_posisi_years($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_kendala_years($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_month_years($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_posisi_kendala_years($id) {
        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_posisi_month_years($id) {
        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_kendala_month_years($id) {
        $title = $this->input->POST('title');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_posisi_years($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);


        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_kendala_years($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_month_years($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_posisi_kendala_years($id) {
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_posisi_month_years($id) {
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_kendala_month_years($id) {
        $type = $this->input->POST('type');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_posisi_kendala_years($id) {
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_posisi_month_years($id) {
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_kendala_month_years($id) {
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_posisi_kendala_month_years($id) {
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_posisi_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_kendala_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_month_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_posisi_kendala_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_posisi_month_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_kendala_month_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_posisi_kendala_years($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_posisi_month_years($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_kendala_month_years($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_posisi_kendala_month_years($id) {
        $title = $this->input->POST('title');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_posisi_kendala_years($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_posisi_month_years($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_kendala_month_years($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_posisi_kendala_month_years($id) {
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_status_posisi_kendala_month_years($id) {
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_posisi_kendala_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_posisi_month_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_kendala_month_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_posisi_kendala_month_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_status_posisi_kendala_month_years($id) {
        $title = $this->input->POST('title');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_jenis_status_posisi_kendala_month_years($id) {
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function search_title_jenis_status_posisi_kendala_month_years($id) {
        $title = $this->input->POST('title');
        $type = $this->input->POST('type');
        $status = $this->input->POST('status');
        $posisi = $this->input->POST('posisi');
        $kendala = $this->input->POST('kendala');
        $month = $this->input->POST('month');
        $years = $this->input->POST('years');

        $this->db->like('TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME', $type);
        $this->db->like('TM_STATUS_PROGRAM.STATUS_NAME', $status);
        $this->db->like('TM_POSITION_PROGRAM.POSPROG_NAME', $posisi);
        $this->db->like('TM_CONTRAINTS.CONTRAINTS_NAME', $kendala);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH', $month);
        $this->db->where('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR', $years);

        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME, TM_MONTH.MONTH_NAME, TM_YEARS.YEARS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TM_USERS', 'TX_RKAP_INVESTATION.RKAP_INVS_USER_ID = TM_USERS.USER_ID');
        $this->db->join('TM_MONTH', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_MONTH = TM_MONTH.MONTH_ID');
        $this->db->join('TM_YEARS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_YEAR = TM_YEARS.YEARS_NAME');
        $this->db->where("regexp_like(TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, '$title', 'i') and TX_REAL_SUB_PROGRAM.IS_DELETED='0' ");

        $this->db->where('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', $id);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        return $this->db->get('TX_REAL_SUB_PROGRAM')->result();
    }

    public function find_rkap($id) {
        return $this->db->get_where('TX_RKAP_INVESTATION', array('TX_RKAP_INVESTATION.RKAP_INVS_ID' => $id))->row();
    }

    public function find_subprogram($id) {
        return $this->db->get_where('TX_RKAP_SUB_PROGRAM', array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id))->row();
    }

    public function jumlah_jangka_waktu($id) {
        return $this->db->select('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_PERIODE')->get_where('TX_RKAP_SUB_PROGRAM', array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id))->row();
    }

    public function find_realisasi($id) {
        $this->db->select('TX_REAL_SUB_PROGRAM.*, TM_STATUS_PROGRAM.STATUS_NAME,  TM_CONTRAINTS.CONTRAINTS_NAME, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TITTLE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_VALUE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_END_REAL, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_CONTRACT_DATE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_PERIODE, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_START, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_END, TR_SUBPRO_TYPE.SUBPRO_TYPE_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');

        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function find($id) {
        return $this->db->get_where('TX_REAL_SUB_PROGRAM', array('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID' => $id))->row();
    }

    public function find_add_sebelum($id) {
        $this->db->select('TX_REAL_SUB_PROGRAM.*');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function find_add($id) {
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        return $this->db->get_where('TX_REAL_SUB_PROGRAM', array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id))->row();
    }

    public function find_id_subpro($id) {
        $this->db->select('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID');
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'desc');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        return $this->db->get_where('TX_REAL_SUB_PROGRAM', array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id))->row();
    }

    public function update($id, $data) {
        return $this->db->update('TX_REAL_SUB_PROGRAM', $data, array('REAL_SUBPRO_ID' => $id));
    }

    public function delete($id, $data) {
        return $this->db->update('TX_REAL_SUB_PROGRAM', $data, array('REAL_SUBPRO_ID' => $id));
    }

    public function persen_notselected($id_subpro) {
        $this->db->select('SUM(REAL_SUBPRO_PERCENT) as PERSEN_TOT');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id_subpro);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function persen_selected($id, $id_subpro) {
        $this->db->select('SUM(REAL_SUBPRO_PERCENT) as PERSEN_TOT');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->where_not_in('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', $id);
        $this->db->where('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID', $id_subpro);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_count_all_row($id) {
        $this->db->select('REAL_SUBPRO_ID, REAL_SUBPRO_PERCENT');
        $this->db->from('TX_REAL_SUB_PROGRAM'); 
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $where = array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'asc');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function update_last_row($data) {
        $tamp = 0;
        for ($i=0; $i < count($data); $i++) { 
            $id = $data[$i]['REAL_SUBPRO_ID'];
            $result = $data[$i]['REAL_SUBPRO_PERCENT'] + $tamp;
            $tamp = $result; 

            $this->db->update('TX_REAL_SUB_PROGRAM', array('REAL_SUBPRO_PERCENT_TOT' => $result), array('REAL_SUBPRO_ID' => $id));
        }
    }

    public function update_percent($percent_update, $id, $id_realisasi) {

        $query="update TX_REAL_SUB_PROGRAM set REAL_SUBPRO_PERCENT='".$percent_update."'  where RKAP_SUBPRO_ID ='".$id."' AND REAL_SUBPRO_ID ='".$id_realisasi."'";
        $this->db->query($query);
    }

    public function update_percent_adendum($percent_update, $subpro_id, $id_realisasi) {

        $query="update TX_REAL_SUB_PROGRAM set REAL_SUBPRO_PERCENT='".$percent_update."'  where RKAP_SUBPRO_ID ='".$subpro_id."' AND REAL_SUBPRO_ID ='".$id_realisasi."'";
        $this->db->query($query);
    }

    public function get_id_real($id) {
        $this->db->select('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');
        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_real_value($id) {
        $this->db->select('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_VAL');
        $this->db->from('TX_REAL_SUB_PROGRAM');
        $this->db->join('TM_STATUS_PROGRAM', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_STATUS = TM_STATUS_PROGRAM.STATUS_ID');
        $this->db->join('TM_CONTRAINTS', 'TX_REAL_SUB_PROGRAM.REAL_SUBPRO_CONSTRAINTS = TM_CONTRAINTS.CONTRAINTS_ID');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_REAL_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_REAL_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_REAL_SUB_PROGRAM.REAL_SUBPRO_ID', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

}

?>