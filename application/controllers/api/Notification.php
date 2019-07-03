<?php

use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Notification extends REST_Controller {
	function __construct(){

		parent::__construct();
		$this->load->model('Notification_model');
	}

	function notifications_list_get(){
		$user_id=getUserId();
		$notifications=$this->Notification_model->get_notifications($user_id);
		if(count($notifications)>0){
			foreach ($notifications as $key => $value) {
				//:like_event,2:join_event,3:accept_event,4:follow_user_req,5:follow_user_accpt,6:comment_profile,7:comment_media,8:comment_event
				switch ($value['type']) {
					case '1':
						$notifications[$key]['message']=varprintf(message('like_event_notify'),$value['sender_name'],$value['event_name']);
						break;
					case '2':
						$notifications[$key]['message']=varprintf(message('join_evt_req_notify'),$value['sender_name'],$value['event_name']);
					case '3':
						$notifications[$key]['message']=varprintf(message('join_evt_req_acc'),$value['sender_name'],$value['event_name']);
						break;
					case '4':
						$notifications[$key]['message']=varprintf(message('follow_usr_req_notify'),$value['sender_name']);
						break;
					case '5':
						$notifications[$key]['message']=varprintf(message('follow_usr_req_acc'),$value['sender_name']);
						break;
					case '6':
						$notifications[$key]['message']=varprintf(message('comm_prof_notify'),$value['sender_name']);
						break;
					case '7':
						$notifications[$key]['message']=varprintf(message('comm_med_notify'),$value['sender_name']);
						break;
					case '8':
						$notifications[$key]['message']=varprintf(message('comm_evt_notify'),$value['sender_name'],$value['event_name']);
						break;
					default:
						$notifications[$key]['message']='';
						break;
				}
			}
			response(['message'=>$notifications]);
		}
		else
			response([
                'status' => FALSE,
                'message'=>message('notify_not_found')                
            ]);
	}

	function read_notification_put(){
		$notify_id=$this->uri->segment(4);
		$notify_data=array("read_status"=>'1');
		$read_status=$this->Notification_model->update_read_status($notify_id,$notify_data);
		if($read_status>0)
			response(['message'=>message('read_done')]);
		else
			response([
				'status'=>FALSE,
				'message'=>'read_not_done'
			]);
	}

	// function tocheckmyprintf_get(){
	// 	$val=varprintf(message('like_event_notify'),"abc","salsa");
	// 	echo $val;
	// }
}