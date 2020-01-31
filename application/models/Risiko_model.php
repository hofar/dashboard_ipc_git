<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class risiko_model extends CI_Model 
	{


		public function all_jenis_risiko()
		{
			$this->db->order_by('RISK_TYPE_ID', 'asc');
			return $this->db->get('TM_RISK_TYPE')->result();
		}

		public function all_jenis_dampak()
		{
			$this->db->order_by('RISK_IMPACT', 'asc');
			return $this->db->get('TM_RISK_IMPACT')->result();
		}

		public function find_print($id) {
	        $this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_TITLE, TM_POSITION_PROGRAM.POSPROG_NAME, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
	        $this->db->from('TX_RKAP_SUB_PROGRAM');
	        $this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID', 'left');
	        $this->db->join('TM_POSITION_PROGRAM', 'TX_RKAP_INVESTATION.RKAP_INVS_POS = TM_POSITION_PROGRAM.POSPROG_ID', 'left');
	        $this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID', 'left');
	        $where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
	        $this->db->where($where);
	        $query = $this->db->get();
	        return $query->row();
	    }

		public function all_risiko($id)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO.*, TM_RISK_TYPE.RISK_TYPE as tipe, TM_RISK_IMPACT.RISK_IMPACT as dampak');
			$this->db->from('TX_SUB_PROGRAM_RISIKO');			
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');
			$this->db->join('TM_RISK_IMPACT', 'TX_SUB_PROGRAM_RISIKO.RISK_IMPACT = TM_RISK_IMPACT.RISK_IMPACT_ID');
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO.SUBPRO_RISK_ID', 'asc');
			$this->db->where('TX_SUB_PROGRAM_RISIKO.IS_DELETED',0);
			$where = array('TX_SUB_PROGRAM_RISIKO.RKAP_SUBPRO_ID' => $id);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}

		public function all_risiko_history($id, $versi)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO_HISTORY.*, TM_RISK_TYPE.RISK_TYPE as tipe, TM_RISK_IMPACT.RISK_IMPACT as dampak');
			$this->db->from('TX_SUB_PROGRAM_RISIKO_HISTORY');			
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');
			$this->db->join('TM_RISK_IMPACT', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_IMPACT = TM_RISK_IMPACT.RISK_IMPACT_ID');
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_HISTORY_ID', 'asc');
			$this->db->where('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_VERSION', $versi);
			$where = array('TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID' => $id);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}

		public function find_type_max($id)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO_HISTORY.*, TM_RISK_TYPE.RISK_TYPE as tipe, TX_SUB_PROGRAM_RISIKO.SUBPRO_RISK_ID, TM_RISK_IMPACT.RISK_IMPACT as dampak');
			$this->db->from('TX_SUB_PROGRAM_RISIKO_HISTORY');			
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');
			$this->db->join('TM_RISK_IMPACT', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_IMPACT = TM_RISK_IMPACT.RISK_IMPACT_ID');
			$this->db->join('TX_SUB_PROGRAM_RISIKO', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID = TX_SUB_PROGRAM_RISIKO.RKAP_SUBPRO_ID');
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE', 'asc');
			$where = array('TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID' => $id);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}

		public function add($data)
		{	
			return $this->db->insert('TX_SUB_PROGRAM_RISIKO', $data);
		}

		public function add_history($data1)
		{	
			return $this->db->insert('TX_SUB_PROGRAM_RISIKO_HISTORY', $data1);	
		}

		public function all_subprogram($id)
		{
			$this->db->select('TX_RKAP_SUB_PROGRAM.*, TX_RKAP_INVESTATION.RKAP_INVS_ID, TR_SUBPRO_TYPE.SUBPRO_TYPE_NAME');
			$this->db->from('TX_RKAP_SUB_PROGRAM');			
			$this->db->join('TX_RKAP_INVESTATION', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_INVS_ID = TX_RKAP_INVESTATION.RKAP_INVS_ID');
			$this->db->join('TR_SUBPRO_TYPE', 'TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_TYPE_ID = TR_SUBPRO_TYPE.SUBPRO_TYPE_ID');
			$this->db->where('TX_RKAP_SUB_PROGRAM.IS_DELETED',0);
			$where = array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}

		public function find_subprogram($id)
		{
			return  $this->db->get_where('TX_RKAP_SUB_PROGRAM', array('TX_RKAP_SUB_PROGRAM.RKAP_SUBPRO_ID' => $id))->row();
		}

		public function find_subprogram_risiko($id)
		{
			return  $this->db->get_where('TX_SUB_PROGRAM_RISIKO', array('TX_SUB_PROGRAM_RISIKO.RKAP_SUBPRO_ID' => $id))->row();
		}

		public function find_subprogram_risiko_history($id)
		{
			return  $this->db->get_where('TX_SUB_PROGRAM_RISIKO_HISTORY', array('TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID' => $id))->row();
		}

		public function find_risiko($id)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_VERSION');
			$this->db->from('TX_SUB_PROGRAM_RISIKO_HISTORY');
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');			
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE', 'asc');
			$where = array(
							'TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID' => $id
							);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}

		public function find_history_max($id)
		{
			$this->db->select_max('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_VERSION');
			$this->db->from('TX_SUB_PROGRAM_RISIKO_HISTORY');			
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');			
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_HISTORY_ID', 'asc');
			$where = array(
							'TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID' => $id
							);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->row()->RISK_VERSION;
		}

		public function find_serial_max($id)
		{
			$this->db->select_max('TX_SUB_PROGRAM_RISIKO.SERIAL');
			$this->db->from('TX_SUB_PROGRAM_RISIKO');			
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');			
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO.SUBPRO_RISK_ID', 'asc');
			$this->db->where('TX_SUB_PROGRAM_RISIKO.IS_DELETED',0);
			$where = array(
							'TX_SUB_PROGRAM_RISIKO.RKAP_SUBPRO_ID' => $id
							);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->row()->SERIAL;
		}

		public function find_serial($id)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO.SERIAL, TX_SUB_PROGRAM_RISIKO.RISK_IK, TX_SUB_PROGRAM_RISIKO.RISK_ID');
			$this->db->from('TX_SUB_PROGRAM_RISIKO');			
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO.SUBPRO_RISK_ID', 'asc');
			$this->db->where('TX_SUB_PROGRAM_RISIKO.IS_DELETED',0);
			$where = array(
							'TX_SUB_PROGRAM_RISIKO.RKAP_SUBPRO_ID' => $id
							);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}


		public function find_history($id,$versi)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO_HISTORY.*, TM_RISK_TYPE.RISK_TYPE as tipe, TM_RISK_IMPACT.RISK_IMPACT as dampak');
			$this->db->from('TX_SUB_PROGRAM_RISIKO_HISTORY');			
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');
			$this->db->join('TM_RISK_IMPACT', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_IMPACT = TM_RISK_IMPACT.RISK_IMPACT_ID');
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_HISTORY_ID', 'asc');
			$this->db->where('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_VERSION', $versi);
			$where = array(
							'TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID' => $id
							);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}



		public function get_versi($id, $versi)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO_HISTORY.*, TM_RISK_TYPE.RISK_TYPE as tipe, TM_RISK_IMPACT.RISK_IMPACT as dampak, TX_SUB_PROGRAM_RISIKO.SUBPRO_RISK_ID, TX_SUB_PROGRAM_RISIKO.SERIAL');
			$this->db->from('TX_SUB_PROGRAM_RISIKO_HISTORY');			
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');
			$this->db->join('TM_RISK_IMPACT', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_IMPACT = TM_RISK_IMPACT.RISK_IMPACT_ID');	
			$this->db->join('TX_SUB_PROGRAM_RISIKO', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID = TX_SUB_PROGRAM_RISIKO.RKAP_SUBPRO_ID AND TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE = TX_SUB_PROGRAM_RISIKO.RISK_TYPE AND TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_DESC = TX_SUB_PROGRAM_RISIKO.RISK_DESC AND TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_IMPACT = TX_SUB_PROGRAM_RISIKO.RISK_IMPACT AND TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_IK = TX_SUB_PROGRAM_RISIKO.RISK_IK AND TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_ID = TX_SUB_PROGRAM_RISIKO.RISK_ID AND TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_SOLVING = TX_SUB_PROGRAM_RISIKO.RISK_SOLVING');		
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE', 'asc');
			$this->db->where('RISK_VERSION', $versi);
			$where = array(
							'TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID' => $id
							);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}


		public function find_version($id,$versi)
		{
			return  $this->db->get_where('TX_SUB_PROGRAM_RISIKO_HISTORY', array('TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID' => $id, 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_VERSION' => $versi))->result();
		}

		public function get_version($id)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_VERSION');
			$this->db->from('TX_SUB_PROGRAM_RISIKO_HISTORY');	
			$this->db->group_by('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_VERSION');	
			$this->db->order_by('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_VERSION', 'desc');	
			$where = array('TX_SUB_PROGRAM_RISIKO_HISTORY.RKAP_SUBPRO_ID' => $id);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}

		public function updatehistory($id, $data)
		{
			return $this->db->update('TX_SUB_PROGRAM_RISIKO_HISTORY', $data, array('RISK_HISTORY_ID' => $id));
		}

			public function find_id_risiko($id_risk)
		{
			return  $this->db->get_where('TX_SUB_PROGRAM_RISIKO', array('TX_SUB_PROGRAM_RISIKO.SUBPRO_RISK_ID' => $id_risk))->row();
		}

		public function find($id)
		{
			return  $this->db->get_where('TX_SUB_PROGRAM_RISIKO', array('TX_SUB_PROGRAM_RISIKO.SUBPRO_RISK_ID' => $id))->row();
		}

		public function find_risiko_real($id)
		{
			return  $this->db->get_where('TX_SUB_PROGRAM_RISIKO_HISTORY', array('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_HISTORY_ID' => $id))->row();
		}

		public function find_data_risiko($id)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO.*, TM_RISK_TYPE.RISK_TYPE as tipe, TM_RISK_IMPACT.RISK_IMPACT as dampak');
			$this->db->from('TX_SUB_PROGRAM_RISIKO');			
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');
			$this->db->join('TM_RISK_IMPACT', 'TX_SUB_PROGRAM_RISIKO.RISK_IMPACT = TM_RISK_IMPACT.RISK_IMPACT_ID');
			// $this->db->where('TX_SUB_PROGRAM_RISIKO.IS_DELETED',0);
			$where = array('TX_SUB_PROGRAM_RISIKO.SUBPRO_RISK_ID' => $id);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}

		public function find_data_risiko_real($id)
		{
			$this->db->select('TX_SUB_PROGRAM_RISIKO_HISTORY.*, TM_RISK_TYPE.RISK_TYPE as tipe, TM_RISK_IMPACT.RISK_IMPACT as dampak');
			$this->db->from('TX_SUB_PROGRAM_RISIKO_HISTORY');			
			$this->db->join('TM_RISK_TYPE', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_TYPE = TM_RISK_TYPE.RISK_TYPE_ID');
			$this->db->join('TM_RISK_IMPACT', 'TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_IMPACT = TM_RISK_IMPACT.RISK_IMPACT_ID');
			$where = array('TX_SUB_PROGRAM_RISIKO_HISTORY.RISK_HISTORY_ID' => $id);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->result();
		}

		public function update($id, $data)
		{
			return $this->db->update('TX_SUB_PROGRAM_RISIKO', $data, array('SUBPRO_RISK_ID' => $id));
		}

		public function delete($id, $data)
		{
			return $this->db->update('TX_SUB_PROGRAM_RISIKO', $data, array('SUBPRO_RISK_ID' => $id));
		}

		public function delete_risiko($id)
		{
			 $this->db->where('TX_SUB_PROGRAM_RISIKO.IS_DELETED',0);
			return $this->db->delete('TX_SUB_PROGRAM_RISIKO', array('RKAP_SUBPRO_ID' => $id));
		}

	}

?>