<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Announcement_model extends CI_Model {

    // public function create($data)
    // {
    // 	return $this->db->insert('nama_tabel', $data);
    // }

    public function find($id) {
        return $this->db->get_where('TX_ANNOUNCEMENT', array('ANNOUNCEMENT_ID' => $id))->row();
    }

    public function all() {
        $id = $this->session->userdata('SESS_USER_ID');
        $query = $this->db->query("SELECT d.announcement_id,d.announcement_name,to_char(d.uploaded_at, 'DD-MON-YYYY HH24:MI:SS') as UPLOADED_AT,d.notif,NVL(e.baca,0) baca from (select a.announcement_id,b.id_user,b.baca from tx_announcement a
	   JOIN tx_announcement_user b on a.announcement_id = b.id_announcement
	   where b.id_user = $id) e right join tx_announcement d on e.announcement_id = d.announcement_id
	   order by d.uploaded_at desc");
        return $query->result();
    }

    function insert_file($data) {
        $this->db->set('TX_ANNOUNCEMENT.ANNOUNCEMENT_NAME', $data['ANNOUNCEMENT_NAME']);
        return $this->db->insert('TX_ANNOUNCEMENT');
    }

    public function insertbaca($data) {
        $this->db->insert('TX_ANNOUNCEMENT_USER', $data);
    }

    public function updatehorn($id, $data) {
        $this->db->set('NOTIF', $data);
        $this->db->where('ANNOUNCEMENT_ID', $id);
        $this->db->update('TX_ANNOUNCEMENT');
    }

    // public function update($id, $data)
    // {
    // 	return $this->db->update('nama_tabel', $data, array('id' => $id));
    // }

    public function delete($id) {
        return $this->db->delete('TX_ANNOUNCEMENT', array('ANNOUNCEMENT_ID' => $id));
    }

    public function cek_notif() {
        $id = $this->session->userdata('SESS_USER_ID');
        $query = $this->db->query("SELECT d.announcement_id,d.announcement_name,d.notif,NVL(e.baca,0) baca from (select a.announcement_id,b.id_user,b.baca from tx_announcement a
	   JOIN tx_announcement_user b on a.announcement_id = b.id_announcement
	   where b.id_user = $id) e right join tx_announcement d on e.announcement_id = d.announcement_id
	   where d.notif = 1 and baca is null");
        return $query->num_rows();
    }

    public function delete_notif() {
        // $data = array('NOTIF' => 0 );
        // $where = array('NOTIF' => 1);
        // $this->db->where($where);
        // return $this->db->update('TX_ANNOUNCEMENT', $data);
    }

    //---------------------------------------yayan
    public function CekSudahBaca($aktif, $id) {
        $query = $this->db->query("SELECT d.announcement_id,d.announcement_name,d.notif,NVL(e.baca,0) baca from (select a.announcement_id,b.id_user,b.baca from tx_announcement a
	   JOIN tx_announcement_user b on a.announcement_id = b.id_announcement
	   where b.id_user = $id) e right join tx_announcement d on e.announcement_id = d.announcement_id
	   where d.notif = $aktif and baca = 1");
        return $query->result();
    }

    public function CekBelumBaca($aktif, $id) {
        $query = $this->db->query("SELECT d.announcement_id,d.announcement_name,d.notif,NVL(e.baca,0) baca from (select a.announcement_id,b.id_user,b.baca from tx_announcement a
	   JOIN tx_announcement_user b on a.announcement_id = b.id_announcement
	   where b.id_user = $id) e right join tx_announcement d on e.announcement_id = d.announcement_id
	   where d.notif = $aktif and baca is null");
        return $query->result();
    }

    public function CekAll() {
        $query = $this->db->query("");
        return $query->result();
    }

}

/* End of file ex_model.php */
/* Location: ./application/modules/laporan/models/ex_model.php */