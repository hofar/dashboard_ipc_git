<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class login_model extends CI_Model {

    public function cek_user($data) {
        return $this->db->get_where('TM_USERS', $data)->num_rows();
    }

    public function select_user($data) {
        $this->db->select('TM_USERS.*, ');
        $this->db->from('TM_USERS');
        $this->db->where($data);
        $query = $this->db->get();
        return $query->row();
    }

    public function find($id) {
        $this->db->select('TM_USERS.*');
        $this->db->from('TM_USERS');
        $where = array('USER_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }

}

?>