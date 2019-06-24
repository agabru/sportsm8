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
}