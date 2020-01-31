<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ganttchart_model extends CI_Model {

    public function all($id) {
        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_RKAP_SUB_PROGRAM');
        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID' => $id);
        $this->db->where($where);
        $this->db->order_by('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function find_rkap($id) {
        return $this->db->get_where('TX_RKAP_INVESTATION', array('TX_RKAP_INVESTATION.RKAP_INVS_ID' => $id))->row();
    }

    public function find($id) {
        
        return $this->db->query("select RKAP_SUBPRO_ID,RKAP_SUBPRO_INVS_ID,RKAP_SUBPRO_TITTLE,rkap_subpro_start,rkap_subpro_end from TX_RKAP_SUB_PROGRAM where RKAP_SUBPRO_ID = $id")->row();
    }

    public function update($id, $data) {
        return $this->db->update('TX_RKAP_SUB_PROGRAM', $data, array('RKAP_SUBPRO_ID' => $id));
    }

    public function delete($id, $data) {
        return $this->db->update('TX_RKAP_SUB_PROGRAM', $data, array('RKAP_SUBPRO_ID' => $id));
    }

    public function tampilganttchartnew($id) {
        $this->load->database();
        $query = $this->db->query("select RKAP_SUBPRO_ID, RKAP_SUBPRO_INVS_ID, RKAP_SUBPRO_TITTLE, add_months(RKAP_SUBPRO_START, -1)  as RKAP_SUBPRO_START, add_months(RKAP_SUBPRO_END, -1) as RKAP_SUBPRO_END from TX_RKAP_SUB_PROGRAM where RKAP_SUBPRO_INVS_ID = '$id' and IS_DELETED = '0' order by RKAP_SUBPRO_ID ASC");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    public function ganttchartaddendum($id) {
        $this->load->database();

        $query = $this->db->query("select a.RKAP_SUBPRO_ID, add_months(a.SUBPRO_ADD_DATE, -1)  as SUBPRO_ADD_DATE, add_months(a.SUBPRO_ADD_ENDOF_GUARANTEE, -1) as SUBPRO_ADD_ENDOF_GUARANTEE 
from TX_SUB_PROGRAM_ADDENDUM a
LEFT JOIN TX_RKAP_SUB_PROGRAM b ON a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID
where b.RKAP_SUBPRO_INVS_ID = '$id'");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

}

?>