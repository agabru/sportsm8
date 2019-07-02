<?php

class Notification_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Event_model');
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
}