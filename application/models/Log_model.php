<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class log_model extends CI_Model 
	{

		public function add($data)
		{	
			return $this->db->insert('TL_LOG_ACTIVITY', $data);
		}

		public function add_ews($data)
		{	
			return $this->db->insert('TL_LOG_EWS', $data);
		}

	}

?>