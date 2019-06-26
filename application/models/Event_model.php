<?php

class Event_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
	}

	function event_create($event_data)
	{
		$this->db->insert('event',$event_data);
		return $this->db->affected_rows();
	}

	function get_event_details($event_id){
		$this->db->where('event_id',$event_id);
		$this->db->from('event');
		$query=$this->db->get();
		return $query->row_array();
	}

	function delete_event_details($event_id){
		$this->db->where('event_id', $event_id);
		$this->db->delete('event');
		return $this->db->affected_rows();
	}

	function edit_event_details($event_id,$evt_data){
		$this->db->where('event_id',$event_id);
		$this->db->update('event',$evt_data);
		return $this->db->affected_rows();
	}

	function like_event($event_data){
		$this->db->insert('like_event',$event_data);
		return $this->db->affected_rows();
	}
	function remove_like_event($user_id,$event_id){
		$this->db->where('user_id', $user_id);
		$this->db->where('event_id', $event_id);
		$this->db->delete('like_event');
		return $this->db->affected_rows();
	}

	function event_req($req_data){
		$this->db->select('event_created_by_uid');
		$query=$this->db->get_where('event',array('event_id'=>$req_data['event_id']));
		$res=$query->row_array();
		if(count($res)>0){
			$req_data['event_created_by_uid']=$res['event_created_by_uid'];
			$this->db->insert('user_event',$req_data);
			return $this->db->affected_rows();
		}
		return 0;		
	}

	function req_accept($req_data){
		$this->db->where('user_id',$req_data['user_id']);
		$this->db->where('event_id',$req_data['event_id']);
		$this->db->update('user_event',$req_data);
		return $this->db->affected_rows();
	}

	function event_comment($comment_data){
		$this->db->insert('event_comment',$comment_data);
		if($this->db->affected_rows())
			return $this->db->insert_id();
		return 0;
	}

	function event_comment_del($comm_id){
		$this->db->where('comment_id',$comm_id);
		$this->db->delete('event_comment');
		return $this->db->affected_rows();
	}

	function get_pending_reqs($user_id){
		$query=$this->db->query("SELECT user_event.*,user.user_id as req_user_id,user.user_name AS req_user_name FROM `user` JOIN `user_event` ON user_event.user_id=user.user_id WHERE user_event.event_created_by_uid=$user_id AND user_event.status='0'");
		return $query->result_array();
	}

	function report_event($event_data){
		$this->db->insert('event_report',$event_data);
		return $this->db->affected_rows();
	}
}
