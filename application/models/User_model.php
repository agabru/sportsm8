<?php

class User_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
	}
	
	public function signup($user_data)
	{
		$ins_data = $this->db->insert('user',$user_data);
		if($ins_data){
			return $last_id = $this->db->insert_id();
		}
		else{
			return false;
		}
	}

	public function edit_profile($user_id,$user_data)
	{
		//print_r($user_data);
		$this->db->where('user_id',$user_id);
		$this->db->update('user',$user_data);
		return $this->db->affected_rows();
	}

	public function get_user($user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->from('user');
		$query=$this->db->get();
		return $query->row_array();
	}

	public function delete_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user');
		return $this->db->affected_rows();
	}

	public function upload_user_media($user_data){
		$this->db->insert('user_media',$user_data);
		return $this->db->affected_rows();
	}

	public function  get_user_media($user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->from('user_media');
		$query=$this->db->get();
		return $query->result_array();
	}

	public function  delete_user_media($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_media');
		return $this->db->affected_rows();
	}

	// public function follow_user($status,$user_data)
	// {
	// 	if($status=='1')
	// 		$this->db->insert('follow_user',$user_data);
	// 	else if ($status=='2') {
	// 		$this->db->where('user_id',$user_id);
	// 		$this->db->update('user',$user_data);
	// 		return $this->db->affected_rows();
	// 	}
	// 	return $this->db->affected_rows();
	// }
	
}