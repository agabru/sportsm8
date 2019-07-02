<?php

class Notification_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Event_model');
	}

	function get_notifications($user_id){
		// $this->db->where('receiver_id',$user_id);
		// $this->db->from('user_notification');
		// $query=$this->db->get();
		$query=$this->db->query("SELECT user_notification.sender_id,user.user_name AS sender_name,user_notification.type,user_notification.event_id,user_notification.comment_id,IFNULL(event.event_name,'') as event_name 
			FROM user_notification JOIN user ON user_notification.sender_id=user.user_id
			LEFT JOIN event ON event.event_id=user_notification.event_id 
			WHERE user_notification.receiver_id=$user_id");
		return $query->result_array();
	}

	function like_evt_notify($event_data){
		$data=array();
		$event_det=$this->Event_model->get_event_details($event_data['event_id']);
		$data['sender_id']=$event_data['user_id'];
		$data['receiver_id']=$event_det['event_created_by_uid'];
		$data['type']='1';
		$data['event_id']=$event_data['event_id'];
		$this->db->insert('user_notification',$data);
	}

	function remove_like_evt_notify($event_data){
		$this->db->where($event_data);
		$this->db->delete('user_notification');
	}

	function event_req_notify($event_data){
		$data=array();
		$event_det=$this->Event_model->get_event_details($event_data['event_id']);
		$data['sender_id']=$event_data['user_id'];
		$data['receiver_id']=$event_det['event_created_by_uid'];
		$data['type']='2';
		$data['event_id']=$event_data['event_id'];
		$this->db->insert('user_notification',$data);
	}

	function req_accept_notify($event_data){
		$data=array();
		$event_det=$this->Event_model->get_event_details($event_data['event_id']);
		$data['sender_id']=$event_det['event_created_by_uid'];
		$data['receiver_id']=$event_data['user_id'];
		$data['type']='3';
		$data['event_id']=$event_data['event_id'];
		$this->db->insert('user_notification',$data);
	}

	function evt_comment_notify($event_data){
		$data=array();
		$event_det=$this->Event_model->get_event_details($event_data['event_id']);
		$data['sender_id']=$event_data['user_id'];
		$data['receiver_id']=$event_det['event_created_by_uid'];
		$data['type']='8';
		$data['comment_id']=$event_data['comment_id'];
		$data['event_id']=$event_data['event_id'];
		$this->db->insert('user_notification',$data);
	}

	function follow_req_notify($user_data){
		$data=array();
		$data['sender_id']=$user_data['follower_id'];
		$data['receiver_id']=$user_data['following_id'];
		$data['type']='4';
		$this->db->insert('user_notification',$data);
	}

	function follow_accpt_notify($user_data){
		$data=array();
		$data['sender_id']=$user_data['following_id'];
		$data['receiver_id']=$user_data['follower_id'];
		$data['type']='5';
		$this->db->insert('user_notification',$data);
	}
}