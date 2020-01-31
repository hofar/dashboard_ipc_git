<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Monitoring_m extends CI_Model 
	{
		public function monit()
		{ 
			$query = $this->db->query("SELECT c.BRANCH_NAME,a.RKAP_INVS_TITLE, d.RKAP_SUBPRO_TITTLE,CONCAT(concat(e.REAL_SUBPRO_MONTH,'-'),e.REAL_SUBPRO_YEAR) AS m,e.CREATED_AT,e.IS_DELETED
			FROM TX_RKAP_INVESTATION a
			LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
			LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
			LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
			LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
			WHERE a.IS_DELETED =0 AND e.CREATED_AT IS NOT NULL AND c.BRANCH_ID <> 000 AND e.CREATED_AT > TO_DATE(concat('15-',TO_CHAR(ADD_MONTHS(sysdate, -1),'mm-YYYY')),'dd-mm-yyyy')
			ORDER BY e.CREATED_AT desc");
			return $query->result();
		}

		public function jumlah()
		{ 
			$query = $this->db->query("SELECT ac.branch_id,ac.branch_name,NVL(ab.ma,0) ma from (select BRANCH_NAME,count(RKAP_INVS_TITLE) ma from (SELECT c.BRANCH_NAME,a.RKAP_INVS_TITLE, d.RKAP_SUBPRO_TITTLE,CONCAT(concat(e.REAL_SUBPRO_MONTH,'-'),e.REAL_SUBPRO_YEAR) AS m,e.CREATED_AT,e.IS_DELETED
			FROM TX_RKAP_INVESTATION a
			LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
			LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
			LEFT JOIN TX_RKAP_SUB_PROGRAM d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
			LEFT JOIN TX_REAL_SUB_PROGRAM e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
			WHERE a.IS_DELETED =0 AND e.CREATED_AT IS NOT NULL AND c.BRANCH_ID <> 000 AND e.CREATED_AT > TO_DATE(concat('15-',TO_CHAR(ADD_MONTHS(sysdate, -1),'mm-YYYY')),'dd-mm-yyyy')
			ORDER BY e.CREATED_AT desc)
			group by BRANCH_NAME) ab right join tr_branch ac on ab.branch_name = ac.branch_name
			where ac.is_pusat = 0 and ac.company_code = 1
			ORDER BY ac.branch_id");
			return $query->result();
		}

		public function real()
		{ 
			$query = $this->db->query("SELECT aa.rkap_invs_id,NVL(bb.realisasi,0) as realisasi from (
				select * from TX_RKAP_INVESTATION
				where is_deleted = 0) aa left join 
				(select BRANCH_NAME,RKAP_INVS_ID,NVL(sum(realisasi),0) as realisasi from (
				SELECT c.BRANCH_NAME,a.RKAP_INVS_ID,substr(a.RKAP_INVS_TITLE,1,20),e.real_subpro_id,e.real_subpro_val - e.real_subpro_cost  as realisasi
				FROM TX_RKAP_INVESTATION a
				LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
				LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
				LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
				JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
				WHERE a.IS_DELETED =0 and e.REAL_SUBPRO_YEAR < 2019
				ORDER BY d.CREATED_AT desc)
				group by BRANCH_NAME,RKAP_INVS_ID) bb on aa.rkap_invs_id = bb.rkap_invs_id");
			return $query->result();
		}

		public function real2()
		{ 
			$query = $this->db->query("SELECT BRANCH_NAME,RKAP_INVS_ID,RKAP_SUBPRO_ID,NVL(sum(realisasi),0) as realisasi from (
				SELECT c.BRANCH_NAME,a.RKAP_INVS_ID,substr(a.RKAP_INVS_TITLE,1,20),d.RKAP_SUBPRO_ID,e.real_subpro_id,e.real_subpro_val - e.real_subpro_cost  as realisasi
				FROM TX_RKAP_INVESTATION a
				LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
				LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
				LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where IS_DELETED = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
				JOIN (select * from TX_REAL_SUB_PROGRAM where IS_DELETED = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
				WHERE a.IS_DELETED =0 and e.REAL_SUBPRO_YEAR < 2019
				ORDER BY d.CREATED_AT desc)
				group by BRANCH_NAME,RKAP_INVS_ID,RKAP_SUBPRO_ID");
			return $query->result();
		}
		
		public function update($a,$b)
		{
			//$this->db->query("UPDATE TX_RKAP_INVESTATION SET RKAP_INVS_REAL_BEFORE = '$b' where RKAP_INVS_ID = $a");
			$this->db->set('RKAP_INVS_REAL_BEFORE',$b);
			$this->db->where('RKAP_INVS_ID', $a);
			$this->db->update('TX_RKAP_INVESTATION');
		}

		public function update2($a,$b)
		{
			//$this->db->query("UPDATE TX_RKAP_INVESTATION SET RKAP_INVS_REAL_BEFORE = '$b' where RKAP_INVS_ID = $a");
			$this->db->set('RKAP_SUBPRO_REAL_BEFORE',$b);
			$this->db->where('RKAP_SUBPRO_ID', $a);
			$this->db->update('TX_RKAP_SUB_PROGRAM');
		}

	}