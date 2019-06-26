<?php

use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Search extends REST_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Search_model');
	}

	function suggest_events_get(){
		$user_id=$this->uri->segment(4);
		$get_events=$this->Search_model->get_suggested_events($user_id);
		if(count($get_events)>0)
			response($get_events);
		else
			response(message('events_not_found'));
	}
}