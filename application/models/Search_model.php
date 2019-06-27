<?php

class Search_model extends CI_model{
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_suggested_events($user_id)
	{
		$query = $this->db->query("SELECT * FROM `event` JOIN follow_user ON follow_user.following_id=event.event_created_by_uid 
						WHERE follow_user.follower_id=$user_id OR event.event_created_by_uid=$user_id
						GROUP BY event.event_id"
					);
		return $query->result_array();
	}

	function get_search_events($search_str)
	{
		$query= $this->db->query("SELECT * FROM `event` 
				WHERE event.event_name LIKE '$search_str' OR  event.event_desc LIKE '$search_str' OR 
				event.event_location LIKE '$search_str'");
		return $query->result_array();
	}

	function get_friends($user_id,$search_str=""){
		$str="SELECT * FROM `user`
				JOIN `follow_user` ON `user`.`user_id` = `follow_user`.`following_id`
				WHERE `follow_user`.`follower_id` = '$user_id' ";
		if($search_str!=""){
			$str.="AND  (`user`.`user_name` LIKE '$search_str'
				OR  `user`.`user_email` LIKE '$search_str')";
		}
		$query=$this->db->query($str);
		return $query->result_array();
	}

	function get_users($user_id,$search_str=""){
		$str="SELECT u.user_id,u.user_name,(SELECT COUNT(follow_user.follow_user_id) FROM follow_user 
              WHERE follow_user.follower_id=$user_id and follow_user.following_id=u.user_id) as follow_status FROM `user` AS u WHERE 1 ";
        if($search_str!=""){
			$str.="AND (`u`.`user_name` LIKE '$search_str'
				OR `u`.`user_email` LIKE '$search_str')";
		}
		$query=$this->db->query($str);
		return $query->result_array();
	}
}