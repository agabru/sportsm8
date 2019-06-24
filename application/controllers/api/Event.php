<?php

use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Event extends REST_Controller {
	function __construct(){

		parent::__construct();
		$this->load->model('Event_model');
	}

	public function details_post()
	{
		$user_id=$this->input->post('user_id');
		$event_name=$this->input->post('event_name');
		$event_type=$this->input->post('event_type');
		$event_desc=$this->input->post('event_desc');
		$event_location =$this->input->post('event_location');
		$event_date=$this->input->post('event_date');
		$event_time=$this->input->post('event_time');
		$gender_rqd=$this->input->post('gender_rqd');
		$event_cat =$this->input->post('event_cat');
		$event_data=array('event_name'=>$event_name,
						'event_type'=>$event_type,
						'event_desc'=>$event_desc,
						'event_location'=>$event_location,
						'event_date'=>$event_date,
						'event_time'=>$event_time,
						'gender_rqd'=>$gender_rqd,
						'event_category'=>$event_cat,
						'event_created_by_uid'=>$user_id
					);
	 	$event=$this->Event_model->event_create($event_data);
	 	if ($event>0)
        {
            response(['message'=>message('event_created') ]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message'=>message('event_not_created')                
            ]);
        }
	}

	public function details_get()
	{
		$event_id=$this->uri->segment(4);
	 	$event=$this->Event_model->get_event_details($event_id);
	 	if (!empty($event))
        {
            response(['message'=>$event]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message'=>message('event_not_found')                
            ]);
        }
	}

	public function details_delete()
	{
		$event_id=$this->uri->segment(4);
	 	$evt_del=$this->Event_model->delete_event_details($event_id);
	 	if ($evt_del>0)
        {
            response(['message'=>message('event_deleted')]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message'=>message('event_not_deleted')                
            ]);
        }
	}

	public function details_put(){
		$event_id=$this->uri->segment(4);
        $evt_data=json_decode(file_get_contents("php://input"),true);
        // print_r($user_data);
        // die();
        $status=$this->Event_model->edit_event_details($event_id,$evt_data);
        if ($status>0)
        {
            response(['message'=>message('event_updated') ]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message' =>message('event_not_updated')      
            ]);
        }
	}
}