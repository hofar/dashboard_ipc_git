<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class setting_model extends CI_Model {

	public function add($data)
	{
		return $this->db->insert('TS_CRITICAL_INDICATOR', $data);
	}

	public function find($id)
	{
		return  $this->db->get_where('TS_CRITICAL_INDICATOR', array('CRITIC_ID' => $id))->row();
	}

	public function all()
	{
		return $this->db->get('TS_CRITICAL_INDICATOR')->result();
	}

	public function update($id, $data)
	{
		return $this->db->update('TS_CRITICAL_INDICATOR', $data, array('CRITIC_ID' => $id));
	}

	public function delete($id)
	{
		return $this->db->delete('TS_CRITICAL_INDICATOR', array('CRITIC_ID' => $id));
	}

	public function find_setting()
		{
			$this->db->select('TS_CRITICAL_INDICATOR.*');
			$this->db->from('TS_CRITICAL_INDICATOR');			
			$this->db->order_by('TS_CRITICAL_INDICATOR.CRITIC_ID', 'asc');
			$this->db->where('TS_CRITICAL_INDICATOR.STATUS',1);
			$query = $this->db->get();
			return $query->row();
		}

	public function is_active()
		{
			$this->db->select('COUNT(TS_CRITICAL_INDICATOR.STATUS) AS COUNT_STATUS');
			$this->db->from('TS_CRITICAL_INDICATOR');			
			$this->db->order_by('TS_CRITICAL_INDICATOR.CRITIC_ID', 'asc');
			$this->db->where('TS_CRITICAL_INDICATOR.STATUS',1);
			$query = $this->db->get();
			return $query->row();
		}

		public function get_ews_data()
	{
		return $this->db->get('TS_EARLY_WARNING')->result();
	}

	public function update_ews_data($id, $data)
	{
		return $this->db->update('TS_EARLY_WARNING', array('DATA_REMINDER' => $data), array('WARNING_ID' => $id));	
	}

	public function update_real_prev_year($id, $data)
	{
		return $this->db->update('TX_RKAP_INVESTATION', array('RKAP_INVS_REAL_BEFORE' => $data), array('RKAP_INVS_ID' => $id));	
	}

	public function update_real_prev_year_subpro($id, $data)
	{
		return $this->db->update('TX_RKAP_SUB_PROGRAM', array('RKAP_SUBPRO_REAL_BEFORE' => $data), array('RKAP_SUBPRO_ID' => $id));	
	}

	public function get_data_reminder_kon_krit()
	{
		$this->db->select('TS_EARLY_WARNING.*');
		$this->db->from('TS_EARLY_WARNING');			
		$this->db->where('TS_EARLY_WARNING.WARNING_ID',1);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_data_reminder_kontrak_b_a()
	{
		$this->db->select('TS_EARLY_WARNING.*');
		$this->db->from('TS_EARLY_WARNING');			
		$this->db->where('TS_EARLY_WARNING.WARNING_ID',2);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function dtemail()
	{
		$query = $this->db->query("SELECT a.BRANCH_ID,a.BRANCH_NAME,b.USER_EMAIL FROM TR_BRANCH a JOIN TM_USERS b ON a.BRANCH_ID = b.USER_BRANCH
		WHERE b.USER_POSITION = 2 AND IS_PUSAT = 0
		ORDER BY BRANCH_ID");
		return $query->result();
	}

	/**
	 * pengubah persen
	 *
	 * @param [type] $id
	 * @return void
	 */
	public function ubahpersen($id)
	{
		$q1 = $this->db->query("SELECT bb.real_subpro_id,aa.rkap_subpro_id,aa.real_subpro_date,aa.re,(aa.rkap_subpro_contract_value / 100 * aa.re) val from (
			select a.rkap_subpro_id,a.pp,a.real_subpro_date,b.makr,c.tambah,(case when a.real_subpro_date = b.makr then a.pp + c.tambah else a.pp end) as re,d.rkap_subpro_contract_value from (
			select rkap_subpro_id,round(real_subpro_percent,5) pp,real_subpro_date from tx_real_sub_program
			where rkap_subpro_id = $id) a join (
			select rkap_subpro_id,max(real_subpro_date) makr from tx_real_sub_program
			where rkap_subpro_id = $id
			group by rkap_subpro_id) b on (a.rkap_subpro_id = b.rkap_subpro_id)
			join (
			select rkap_subpro_id,100 - sum(pp) as tambah from (
			select rkap_subpro_id,round(real_subpro_val,5),round(real_subpro_percent,5) pp,round(real_subpro_percent_tot,5),real_subpro_date from tx_real_sub_program
			where rkap_subpro_id = $id)
			group by rkap_subpro_id) c on (a.rkap_subpro_id = c. rkap_subpro_id)
			join (
			select rkap_subpro_id,rkap_subpro_contract_value from tx_rkap_sub_program where rkap_subpro_id = $id) d
			on (a.rkap_subpro_id = d.rkap_subpro_id)) aa join tx_real_sub_program bb on (aa.rkap_subpro_id = bb.rkap_subpro_id and aa.real_subpro_date = bb.real_subpro_date)
			order by aa.real_subpro_date");
		
		$new2 = 0;
        foreach ($q1->result() as $key => $value) {

            $new[$key] = $q1->result()[$key]->RE;
            $new2 = $new2 + $q1->result()[$key]->RE;

             $data = array(
                 'REAL_SUBPRO_PERCENT' => $new[$key],
				 'REAL_SUBPRO_PERCENT_TOT' => $new2,
				 'REAL_SUBPRO_VAL' => $q1->result()[$key]->VAL          
            );

            //return json_encode($q1->result());
			// echo var_dump($data);
			// echo "<br><br>";
            $this->db->where('REAL_SUBPRO_ID', $q1->result()[$key]->REAL_SUBPRO_ID);
            $this->db->update('TX_REAL_SUB_PROGRAM', $data);
        
        }
	}
}

/* End of file ex_model.php */
/* Location: ./application/modules/laporan/models/ex_model.php */