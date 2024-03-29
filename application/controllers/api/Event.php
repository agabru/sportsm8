<?php

use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Event extends REST_Controller {
	function __construct(){

		parent::__construct();
		$this->load->model('Event_model');
        $this->load->model('Notification_model');
	}

	public function details_post()
	{
		$user_id=getUserId();
		$event_name=$this->input->post('event_name');
		$event_type=$this->input->post('event_type');
		$event_desc=$this->input->post('event_desc');
		$event_location =$this->input->post('event_location');
		$event_date=$this->input->post('event_date');
		$event_time=$this->input->post('event_time');
		$gender_rqd=$this->input->post('gender_rqd');
		$event_cat =$this->input->post('event_cat');
        $event_photo=uploadfile($this->input->post('event_photo'))['name'];
		$event_data=array('event_name'=>$event_name,
						'event_type'=>$event_type,
						'event_desc'=>$event_desc,
						'event_location'=>$event_location,
						'event_date'=>$event_date,
						'event_time'=>$event_time,
						'gender_rqd'=>$gender_rqd,
						'event_category'=>$event_cat,
						'event_created_by_uid'=>$user_id,
                        'event_photo'=>$event_photo
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
            if($event['event_photo']!="")
                $event['event_photo']=IMG_PATH.$event['event_photo'];
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
        if(isset($evt_data['event_photo']))
        {
            $evt=$this->Event_model->get_event_details($event_id);
            if($evt['event_photo']!=""){
                $event_photo=REL_IMG_PATH.$evt['event_photo'];
                @unlink($event_photo);
            }            
            $evt_data['event_photo']=uploadfile($evt_data['event_photo'])['name'];
        }
        $status=$this->Event_model->edit_event_details($event_id,$evt_data);
        if ($status>0)  
        {
            response(['message'=>message('event_updated')]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message' =>message('event_not_updated')      
            ]);
        }
	}

    public function like_post(){
        $user_id =getUserId();
        $event_id=$this->input->post('event_id');
        $status  =$this->input->post('status');
        $event_data=array('user_id'=>$user_id,
                          'event_id'=>$event_id,
                          'status'=>$status);
        $event_status=$this->Event_model->like_event($event_data);
        if($event_status>0){
            if($status>0){
                $event_status=$this->Notification_model->like_evt_notify($event_data);
                response(['message'=>message('event_liked')]);
            }
            else
                response(['message'=>message('event_not_liked')]);
        }
        else
            response(['message'=>message('wrong_req')]);
    }

    public function remove_like_post(){
        $user_id =getUserId();
        $event_id=$this->input->post('event_id');
        $event_status=$this->Event_model->remove_like_event($user_id,$event_id);
        if($event_status>0)
        {
            $event_data=array('sender_id'=>$user_id,'event_id'=>$event_id,'type'=>'1');
            $this->Notification_model->remove_like_evt_notify($event_data);
            response(['message'=>message('like_removed')]);
        }
        else
            response(['message'=>message('wrong_like_remove')]);
    }

    public function event_req_post(){
        $user_id =getUserId();
        $event_id=$this->input->post('event_id');
        $req_data=array('user_id'=>$user_id,
                        'event_id'=>$event_id,
                        'status'=>'0');
        $req_status=$this->Event_model->event_req($req_data);
        if($req_status>0){
            $this->Notification_model->event_req_notify($req_data);
            response(['message'=>message('event_requested')]);
        }
        else
            response(['message'=>message('event_not_requested')]);
    }

    public function req_accept_post(){
        $user_id =getUserId();
        $event_id=$this->input->post('event_id');
        $status=$this->input->post('status');
        $req_data=array('user_id'=>$user_id,
                        'event_id'=>$event_id,
                        'status'=>$status);
        $req_status=$this->Event_model->req_accept($req_data);
        if($req_status>0){
            $this->Notification_model->req_accept_notify($req_data);
            if($status=='1')
                response(['message'=>message('event_req_accept')]);
            elseif ($status=='2')
                response(['message'=>message('event_req_reject')]);
        }
        else
            response(['message'=>message('wrong_event_req')]);
    }

    public function event_comment_post(){
        $user_id =getUserId();
        $event_id=$this->input->post('event_id');
        $comment=$this->input->post('comment');
        $comment_data=array('user_id'=>$user_id,
                        'event_id'=>$event_id,
                        'comment'=>$comment);
        $comm_id=$this->Event_model->event_comment($comment_data);
        if($comm_id>0){
            $comment_data['comment_id']=$comm_id;
            $this->Notification_model->evt_comment_notify($comment_data);
            response(['message'=>message('event_commented')]);
        }
        else
            response(['message'=>message('event_not_commented')]);
	}
	
	public function delete_comment_delete(){
		$comm_id =$this->uri->segment(4);
        $comm_status=$this->Event_model->event_comment_del($comm_id);
        if($comm_status>0){
                response(['message'=>message('comment_delete')]);
        }
        else
            response(['message'=>message('comment_not_delete')]);
	}

    public function pending_req_get(){
        $user_id =getUserId();
        $reqs=$this->Event_model->get_pending_reqs($user_id);
        if(count($reqs)>0){
            response(['message'=>$reqs]);
        }
        else
            response(['message'=>message('no_pending_reqs')]);
    }

    public function report_post(){
        $event_id    =  $this->input->post('event_id');
        $user_id     =  getUserId();
        $report      =  $this->input->post('report');

        $event_data = array('event_id' => $event_id,
                            'user_id'=> $user_id,
                            'report'  => $report );
        $evt_report=$this->Event_model->report_event($event_data);
        if (!empty($evt_report))
        {
            response(['message'=>message('event_reported')]);
        }
        else
        {
            response([
                    'status' => FALSE,
                    'message' => message('event_not_reported')
                ]);            
        }
    }

    public function incShareCount_get()
    {
        $event_id=$this->uri->segment(4);
        $counted=$this->Event_model->incShareCount($event_id);
        if (!empty($counted))
        {
            response(['message'=>message('share_done')]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message'=>message('share_not_done')                
            ]);
        }
    }

    public function allEvents_get()
    {
        $user_id=getUserId();
        $events=$this->Event_model->get_allEvents($user_id);
        if (!empty($events))
        {
            response(['message'=>$events]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message'=>message('events_not_found')                
            ]);
        }
    }

    public function eventMembers_post(){
        $event_id=$this->input->post('event_id');
        $user_id=getUserId();
        $members=$this->Event_model->getEventMembers($user_id,$event_id);
        if (!empty($members))
        {
            response(['message'=>$members]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message'=>message('no_event_members')                
            ]);
        }
    }

}
