<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class kurva_model extends CI_Model {

    public function add($data) {

        if ($data['SUBPRO_MON'] != "") {
            
             return $this->db->update('TX_RKAP_SUB_PROGRAM_MONTHLY',array('SUBPRO_VALUE'=>$data['SUBPRO_VALUE']), array('RKAP_SUBPRO_ID' => $data['RKAP_SUBPRO_ID'], 'SUBPRO_MON' => $data['SUBPRO_MON']));
        } else {
            return $this->db->insert('TX_RKAP_SUB_PROGRAM_MONTHLY', $data);
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

    public function all_subprogram_monthly($id) {
        $this->db->select('TX_RKAP_SUB_PROGRAM_MONTHLY.*, TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
        $this->db->from('TX_RKAP_SUB_PROGRAM_MONTHLY');
        $this->db->join('TX_RKAP_SUB_PROGRAM', 'TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID = TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID');
        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
        $this->db->where('TX_RKAP_SUB_PROGRAM_MONTHLY.IS_ADDENDUM', 0);
        $this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED', 0);
        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function find_subprogram($id) {
        return $this->db->get_where('TX_RKAP_SUB_PROGRAM', array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id))->row();
    }

    public function find_subprogram_monthly($id) {
        return $this->db->get_where('TX_RKAP_SUB_PROGRAM_MONTHLY', array('TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID' => $id))->row();
    }



    public function cek_id($id) {
        $result = $this->db->query("select SUBPRO_MON from TX_RKAP_SUB_PROGRAM_MONTHLY where RKAP_SUBPRO_ID = '$id'");
        foreach ($result->result() as $row) {
            $data[] = $row->SUBPRO_MON;
        }
        return $data;

    }

    public function cek_addendum($id) {

        $result = $this->db->query("SELECT * FROM
(SELECT a.SUBPRO_MONTH, SUBPRO_VALUE, IS_ADDENDUM,
(select SUBPRO_VALUE from TX_RKAP_SUB_PROGRAM_MONTHLY b
where a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID AND SUBSTR(a.SUBPRO_YEARS, 4) = SUBSTR(b.SUBPRO_YEARS, 4) AND b.IS_ADDENDUM = '1' ) as VALUE_ADDENDUM,
max(IS_ADDENDUM) over (partition by SUBSTR(SUBPRO_YEARS, 4)) MAX_ADDENDUM
from TX_RKAP_SUB_PROGRAM_MONTHLY a
where RKAP_SUBPRO_ID= '$id'  ORDER BY a.SUBPRO_MON ASC )
WHERE IS_ADDENDUM = MAX_ADDENDUM");

        return $result->result();
    }

    public function find_month($id) {
       
        return $this->db->get_where('TX_RKAP_SUB_PROGRAM_MONTHLY', array('TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID' => $id))->result();
    }

    public function find_all_month($id) {
        $result = $this->db->query("select * from TX_RKAP_SUB_PROGRAM_MONTHLY WHERE RKAP_SUBPRO_ID = '$id' ORDER BY SUBPRO_MON ASC");
        return $result->result();
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

     public function cek_urutan($id) {

        $result = $this->db->query("SELECT TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MONTH from TX_RKAP_SUB_PROGRAM_MONTHLY where RKAP_SUBPRO_ID= '$id' GROUP BY TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MONTH ORDER BY TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MONTH ASC");
        return $result->result();
    }

    public function find_all_month_adden($id) {
        $result = $this->db->query("SELECT * FROM 
(SELECT TX_RKAP_SUB_PROGRAM_MONTHLY.* , max(IS_ADDENDUM) over (partition by SUBSTR(SUBPRO_YEARS, 4)) MAX_ADDENDUM 
FROM TX_RKAP_SUB_PROGRAM_MONTHLY 
WHERE TX_RKAP_SUB_PROGRAM_MONTHLY.RKAP_SUBPRO_ID = '$id' 
ORDER BY TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MON ASC) 
WHERE IS_ADDENDUM = MAX_ADDENDUM");
        return $result->result();
    }

    public function find_all_month_non_adden_group($id)
    {
        $result = $this->db->query("SELECT IS_ADDENDUM, count(*) from TX_RKAP_SUB_PROGRAM_MONTHLY 
            WHERE RKAP_SUBPRO_ID = $id 
            GROUP BY IS_ADDENDUM ORDER BY IS_ADDENDUM ASC");
        return $result->result();
    }

    public function find_all_month_adden1($id)
    {
        $result = $this->db->query("SELECT IS_ADDENDUM, count(*) from TX_RKAP_SUB_PROGRAM_MONTHLY 
            WHERE RKAP_SUBPRO_ID = $id 
            GROUP BY IS_ADDENDUM ORDER BY IS_ADDENDUM ASC");
        $data_group = $result->result();
        $data = array();

        foreach ($data_group as $data_groups) {
            $is_addendum[] = $data_groups->IS_ADDENDUM; 
            $query = $this->db->query("SELECT * FROM (SELECT TX_RKAP_SUB_PROGRAM_MONTHLY.* , 
                                        max(IS_ADDENDUM) over (partition by SUBSTR(SUBPRO_YEARS, 4)) MAX_ADDENDUM
                                        FROM TX_RKAP_SUB_PROGRAM_MONTHLY WHERE IS_ADDENDUM IN (".implode(',', $is_addendum).") AND RKAP_SUBPRO_ID = $id 
                                        ORDER BY TX_RKAP_SUB_PROGRAM_MONTHLY.SUBPRO_MON ASC) WHERE IS_ADDENDUM = MAX_ADDENDUM");
            $data[] = $query->result();
        }

        return $data;
    }

    public function cek_addendum2($id) {

        $result = $this->db->query("SELECT * FROM
(SELECT a.SUBPRO_MONTH, SUBPRO_VALUE, IS_ADDENDUM,
(select SUBPRO_VALUE from TX_RKAP_SUB_PROGRAM_MONTHLY b
where a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID AND SUBSTR(a.SUBPRO_YEARS, 4) = SUBSTR(b.SUBPRO_YEARS, 4) AND b.IS_ADDENDUM = '2' ) as VALUE_ADDENDUM,
max(IS_ADDENDUM) over (partition by SUBSTR(SUBPRO_YEARS, 4)) MAX_ADDENDUM
from TX_RKAP_SUB_PROGRAM_MONTHLY a
where RKAP_SUBPRO_ID= '$id'  ORDER BY a.SUBPRO_MON ASC )
WHERE IS_ADDENDUM = MAX_ADDENDUM");

        return $result->result();
    }

    public function cek_addendum3($id) {

        $result = $this->db->query("SELECT * FROM
(SELECT a.SUBPRO_MONTH, SUBPRO_VALUE, IS_ADDENDUM,
(select SUBPRO_VALUE from TX_RKAP_SUB_PROGRAM_MONTHLY b
where a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID AND SUBSTR(a.SUBPRO_YEARS, 4) = SUBSTR(b.SUBPRO_YEARS, 4) AND b.IS_ADDENDUM = '3' ) as VALUE_ADDENDUM,
max(IS_ADDENDUM) over (partition by SUBSTR(SUBPRO_YEARS, 4)) MAX_ADDENDUM
from TX_RKAP_SUB_PROGRAM_MONTHLY a
where RKAP_SUBPRO_ID= '$id'  ORDER BY a.SUBPRO_MON ASC )
WHERE IS_ADDENDUM = MAX_ADDENDUM");

        return $result->result();
    }

    public function cek_addendum4($id) {

        $result = $this->db->query("SELECT * FROM
(SELECT a.SUBPRO_MONTH, SUBPRO_VALUE, IS_ADDENDUM,
(select SUBPRO_VALUE from TX_RKAP_SUB_PROGRAM_MONTHLY b
where a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID AND SUBSTR(a.SUBPRO_YEARS, 4) = SUBSTR(b.SUBPRO_YEARS, 4) AND b.IS_ADDENDUM = '4' ) as VALUE_ADDENDUM,
max(IS_ADDENDUM) over (partition by SUBSTR(SUBPRO_YEARS, 4)) MAX_ADDENDUM
from TX_RKAP_SUB_PROGRAM_MONTHLY a
where RKAP_SUBPRO_ID= '$id'  ORDER BY a.SUBPRO_MON ASC )
WHERE IS_ADDENDUM = MAX_ADDENDUM");

        return $result->result();
    }

    public function cek_addendum5($id) {

        $result = $this->db->query("SELECT * FROM
(SELECT a.SUBPRO_MONTH, SUBPRO_VALUE, IS_ADDENDUM,
(select SUBPRO_VALUE from TX_RKAP_SUB_PROGRAM_MONTHLY b
where a.RKAP_SUBPRO_ID = b.RKAP_SUBPRO_ID AND SUBSTR(a.SUBPRO_YEARS, 4) = SUBSTR(b.SUBPRO_YEARS, 4) AND b.IS_ADDENDUM = '5' ) as VALUE_ADDENDUM,
max(IS_ADDENDUM) over (partition by SUBSTR(SUBPRO_YEARS, 4)) MAX_ADDENDUM
from TX_RKAP_SUB_PROGRAM_MONTHLY a
where RKAP_SUBPRO_ID= '$id'  ORDER BY a.SUBPRO_MON ASC )
WHERE IS_ADDENDUM = MAX_ADDENDUM");

        return $result->result();
    }

}

?>