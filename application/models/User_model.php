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

	function insert_access_token($auth_arr){
		$this->db->insert('user_authentication',$auth_arr);
		return $this->db->affected_rows();
	}

	public function add_interest($int_arr)
	{
		$this->db->insert_batch('user_category',$int_arr);
	}
	public function edit_profile($user_id,$user_data)
	{
		//print_r($user_data);
		$this->db->where('user_id',$user_id);
		$this->db->update('user',$user_data);
		return $this->db->affected_rows();
	}

	public function edit_interest($user_id,$int_arr)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_category');
		$this->db->insert_batch('user_category',$int_arr);
	}
	public function get_user($user_id)
	{
		// $this->db->where('user_id',$user_id);
		// $this->db->from('user');
		// $query=$this->db->get();
		$query=$this->db->query("SELECT *,(SELECT COUNT(*) FROM follow_user WHERE follow_user.following_id=$user_id AND follow_user.status='2')as nooffollowers,(SELECT COUNT(*) FROM event WHERE event.event_created_by_uid=$user_id)as noofeventscreated FROM `user` WHERE user_id=$user_id");
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

	public function follow_user($status,$user_data)
	{
		if($status=='1')
			$this->db->insert('follow_user',$user_data);
		else if ($status=='2'||$status=='3') {
			$this->db->where('follower_id',$user_data['follower_id']);
			$this->db->where('following_id',$user_data['following_id']);
			$this->db->update('follow_user',$user_data);
		}
		return $this->db->affected_rows();
	}

	public function report_user($status,$user_data)
	{
		$this->db->insert('report_user',$user_data);
		return $this->db->affected_rows();
	}

	public function delete_report_user($report_by_user,$report_to_user){
		$this->db->where('report_by_user', $report_by_user);
		$this->db->where('report_to_user', $report_to_user);
		$this->db->delete('report_user');
		return $this->db->affected_rows();
	}

	public function get_frnd_suggest($user_id)
	{
		$query=$this->db->query("SELECT DISTINCT user.user_id,user.user_name 
				FROM `follow_user` AS f1 
				JOIN user JOIN `follow_user` AS f2 
				ON f2.follower_id=f1.following_id AND f2.following_id=user.user_id 
				WHERE f1.follower_id=$user_id AND user.user_id!=$user_id");
		return $query->result_array();
	}
	
}