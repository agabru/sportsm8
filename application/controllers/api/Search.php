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
		$user_id=getUserId();
		$get_events=$this->Search_model->get_suggested_events($user_id);
		if(count($get_events)>0)
			response($get_events);
		else
			response(['message'=>message('events_not_found')]);
	}

	function events_post(){
		$search_str=$this->input->post('search_str');
		$str_arr=explode(' ', $search_str);
		foreach ($str_arr as $key => $value) {
			$str_arr[$key]="%".$value."%";
		}
		$str_arr=implode(' ',$str_arr);
		//print_r($str_arr);
		$get_search_res=$this->Search_model->get_search_events($search_str);
		if(count($get_search_res)>0)
			response($get_search_res);
		else
			response(['message'=>message('events_not_found')]);
	}

	function friends_get(){
		$user_id=getUserId();
		$get_frnds=$this->Search_model->get_friends($user_id);
		if(count($get_frnds)>0)
			response($get_frnds);
		else
			response(['message'=>message('no_frnds')]);
	}

	function search_frnds_post(){
		$user_id=getUserId();
		$search_str=$this->input->post('search_str');
		$str_arr=explode(' ', $search_str);
		foreach ($str_arr as $key => $value) {
			$str_arr[$key]="%".$value."%";
		}
		$str_arr=implode(' ',$str_arr);
		$searched_frnds=$this->Search_model->get_friends($user_id,$str_arr);
		if(count($searched_frnds)>0)
			response($searched_frnds);
		else
			response(['message'=>message('no_frnds')]);
	}

	function users_get(){
		$user_id=getUserId();
		$get_users=$this->Search_model->get_users($user_id);
		if(count($get_users)>0)
			response($get_users);
		else
			response(['message'=>message('no_users')]);
	}

	function search_users_post()
	{
		$user_id=getUserId();
		$search_str=$this->input->post('search_str');
		$str_arr=explode(' ', $search_str);
		foreach ($str_arr as $key => $value) {
			$str_arr[$key]="%".$value."%";
		}
		$str_arr=implode(' ',$str_arr);
		$get_users=$this->Search_model->get_users($user_id,$str_arr);
		if(count($get_users)>0)
			response($get_users);
		else
			response(['message'=>message('no_users')]);
	}
}