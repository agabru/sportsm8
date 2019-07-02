<?php

class Notification extends CI_Controller {
	function __construct(){

		parent::__construct();
		$this->load->model('Notification_model');
	}
}