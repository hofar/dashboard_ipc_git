<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model 
{
	
	var $table='TM_USERS';

	public function member_konflik($username)
	{
		$data = "USER_NAME = '$username'";
		$this->db->where($data);
		return $this->db->get('TM_USERS')->num_rows();	
	}
	
	public function add($data)
	{
		return $this->db->insert('TM_USERS', $data);
	}
	
	public function all_branch()
	{
		$this->db->where('IS_PUSAT', 0);
		$this->db->order_by('BRANCH_NAME', 'asc');
		return $this->db->get('TR_BRANCH')->result();
	}
	
	public function all_posisi()
	{
		$this->db->where('IS_PUSAT', 0);
		$this->db->order_by('POSITION_ID', 'asc');
		return $this->db->get('TR_POSITION')->result();
	}
	
	public function branch_anak()
	{
		$this->db->where('IS_PUSAT', 2);
		$this->db->order_by('BRANCH_NAME', 'asc');
		return $this->db->get('TR_BRANCH')->result();
	}
	
	public function posisi_anak()
	{
		$this->db->where('IS_PUSAT', 0);
		$this->db->order_by('POSITION_ID', 'asc');
		return $this->db->get('TR_POSITION')->result();
	}
	
	public function branch_pusat()
	{
		$this->db->where('IS_PUSAT', 1);
		$this->db->order_by('BRANCH_NAME', 'asc');
		return $this->db->get('TR_BRANCH')->result();
	}
	
	public function posisi_pusat()
	{
		$this->db->order_by('POSITION_ID', 'asc');
		return $this->db->get('TR_POSITION')->result();
	}
	
	public function all_privilage()
	{
		$this->db->order_by('USER_PRIV_ID', 'asc');
		return $this->db->get('TR_USER_PRIV')->result();
	}
	
	public function all()
	{
		$this->db->select('TM_USERS.*, TR_BRANCH.BRANCH_NAME, TR_POSITION.POSITION_NAME, TR_USER_PRIV.USER_PRIV_NAME');
		$this->db->from('TM_USERS');			
		$this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
		$this->db->join('TR_POSITION', 'TM_USERS.USER_POSITION = TR_POSITION.POSITION_ID');
		$this->db->join('TR_USER_PRIV', 'TM_USERS.USER_PRIV = TR_USER_PRIV.USER_PRIV_ID');
		$this->db->where('TM_USERS.IS_DELETED',0);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function search_username()
	{
		
		$username = $this->input->POST('username');
		$this->db->like('TM_USERS.USER_NAME',$username);
		$this->db->select('TM_USERS.*, TR_BRANCH.BRANCH_NAME, TR_POSITION.POSITION_NAME, TR_USER_PRIV.USER_PRIV_NAME');
		$this->db->from('TM_USERS');			
		$this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
		$this->db->join('TR_POSITION', 'TM_USERS.USER_POSITION = TR_POSITION.POSITION_ID');
		$this->db->join('TR_USER_PRIV', 'TM_USERS.USER_PRIV = TR_USER_PRIV.USER_PRIV_ID');
		$this->db->where('TM_USERS.IS_DELETED',0);
		$this->db->order_by('TM_USERS.USER_NAME', 'asc');
		$query = $this->db->get();
		return $query->result(); 
	}
	
	public function finduser($id)
	{
		$this->db->select('TM_USERS.*, TR_BRANCH.BRANCH_NAME, TR_POSITION.POSITION_NAME, TR_USER_PRIV.USER_PRIV_NAME');
		$this->db->from('TM_USERS');			
		$this->db->join('TR_BRANCH', 'TM_USERS.USER_BRANCH = TR_BRANCH.BRANCH_ID');
		$this->db->join('TR_POSITION', 'TM_USERS.USER_POSITION = TR_POSITION.POSITION_ID');
		$this->db->join('TR_USER_PRIV', 'TM_USERS.USER_PRIV = TR_USER_PRIV.USER_PRIV_ID');
		$this->db->order_by('TM_USERS.USER_NAME', 'asc');
		$this->db->where('TM_USERS.IS_DELETED',0);
		$where = array('TM_USERS.USER_ID' => $id);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function update($id, $data)
	{
		return $this->db->update('TM_USERS', $data, array('TM_USERS.USER_ID' => $id));
	}
	
	public function update_user($id)
	{
		$this->db->set('IS_DELETED','1');
		$this->db->where('USER_ID', $id);
		$this->db->update('TM_USERS');
	}
	
	public function update_is_active($id, $data6)
	{
		return $this->db->update('TM_USERS', $data6, array('USER_ID' => $id));
	}
	
	public function update_pass($id, $data1)
	{
		return $this->db->update('TM_USERS', $data1, array('TM_USERS.USER_ID' => $id));
	}
	
	public function update_pass_user($id, $data1)
	{
		return $this->db->update('TM_USERS', $data1, array('TM_USERS.USER_ID' => $id));
	}
	
	// public function delete($id)
	// {
		// 	return $this->db->update('TM_USERS', array('TM_USERS.IS_DELETED' => 1), array('TM_USERS.USER_ID' => $id));
		// }
		
		
		//delete all data 
		public function delete_by_id($id) {
			// $this->db->where('USER_ID', $id);
			// $this->db->delete($this->table);
			return $this->db->delete('TM_USERS', array('USER_ID' => $id));
		}
		
		
		public function delete($id)
		{
			return $this->db->delete('TM_USERS', array('USER_ID' => $id));
		}
		
		public function select_user($data)
		{
			$this->db->select('TM_USERS.*');
			$this->db->from('TM_USERS');
			$this->db->where($data);
			$query = $this->db->get();
			return $query->row();
		}
		
		
	}
	
	?>