 <?php

use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class User extends REST_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('User_model');
        date_default_timezone_set("Asia/Kuwait");
    }

    function profile_post() {
    	$user_name=$this->input->post('user_name');
    	$user_email=$this->input->post('user_email');
        $user_mobile=$this->input->post('user_mobile');
        $user_dob=$this->input->post('user_dob');
        $user_password=$this->input->post('user_password');
        $user_interest=$this->input->post('user_interest');
        $user_data = array('user_name' => $user_name,
                            'user_email'=>$user_email,
                            'user_mobile'=>$user_mobile,
                            'user_dob'=>$user_dob,
                            'user_password'=>$user_password);

        $user_id=$this->User_model->signup($user_data);

        if (!empty($user_id))
        {
            $user_interest=explode(',', $user_interest);
            $int_arr=array();
            foreach ($user_interest as $key => $value) {
                $int_arr[$key]['user_id']=$user_id;
                $int_arr[$key]['cat_id']=$value;
            }
            $this->User_model->add_interest($int_arr);
            response(['message'=>message('user_created') ]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message'=>message('user_not_created')                
            ]);
        }
    }

    function profile_put(){
        $user_id=$this->uri->segment(4);
        $user_data=json_decode(file_get_contents("php://input"),true);
        if(array_key_exists('user_img', $user_data)){
            $user_data['user_img']=$this->uploadfile($user_data['user_img']);
        }
        if(array_key_exists('user_cover_img', $user_data)){
          $user_data['user_cover_img']=$this->uploadfile($user_data['user_cover_img']);  
        }        
        if(array_key_exists('user_interest', $user_data))
        {
            $user_interest=$user_data['user_interest'];
            unset($user_data['user_interest']);
            $user_interest=explode(',', $user_interest);
            $int_arr=array();
            foreach ($user_interest as $key => $value) {
                $int_arr[$key]['user_id']=$user_id;
                $int_arr[$key]['cat_id']=$value;
            }
            $this->User_model->edit_interest($user_id,$int_arr);
        }
        $status=$this->User_model->edit_profile($user_id,$user_data);
        if (!empty($status))
        {
            response(['message'=>message('user_updated') ]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message' =>message('user_not_updated')      
            ]);
        }
    }

    function profile_get(){
        $user_id=$this->uri->segment(4);
        $user=$this->User_model->get_user($user_id);
        if (!empty($user))
        {
            response($user);
        }
        else
        {
            response([
                    'status' => FALSE,
                    'message' => message('user_not_found')
                ]);
            
        }
    }

    function profile_delete(){
        $user_id=$this->uri->segment(4);
        $result=$this->User_model->delete_user($user_id);
        if (!empty($result))
        {
            response(['message'=>message('user_deleted')]);
        }
        else
        {
            response([
                'status' => FALSE,
                'message' => message('user_not_deleted')
            ]);
        }
    }

    function media_post(){

        $user_media= time();
        $user_id=$this->input->post('user_id');
        $file_type=strstr($_FILES['userfile']['type'],'/',true);
        if($file_type=="image"){
                $status='1';
                $upload_path='./uploads/img';
        }
        else if($file_type=="video"){
            $status='1';
            $upload_path='./uploads/vdo';
        }
        else{
            response([
            'status' => FALSE,
            'message' => message('Please upload only image/video')
            ]);
        }
        $config['upload_path']          =  $upload_path;
        $config['allowed_types']        =  '*';
        $config['file_name']            =  $user_media;
        $config['file_ext_tolower']     =  TRUE;
        
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile'))
        {
            response([
                    'status' => FALSE,
                    'message' => strip_tags($this->upload->display_errors())
                ]);
        }
        else
        {
            
            
            $user_data = array(
                                'user_id'    => $user_id,
                                'media_type' => $status,
                                'media_name' => $this->upload->data('file_name')
                                );
            $result=$this->User_model->upload_user_media($user_data);
            if ($result>0)
            {
                response(['message'=>message('media_uploaded')]);
            }
            else
            {
                response([
                    'status' => FALSE,
                    'message' => message('media_not_uploaded')
                ]);
            }            
        }
    }

    function media_get(){
        $user_id=$this->uri->segment(4);
        $user_media=$this->User_model->get_user_media($user_id);
        // print_r($user_media);
        // die();
        if (!empty($user_media))
        {
            response($user_media);
        }
        else
        {
            response([
                    'status' => FALSE,
                    'message' => message('user_media_not_found')
                ]);
            
        }
    }

    function media_delete(){
        $user_id=$this->uri->segment(4);
        $user_media=$this->User_model->delete_user_media($user_id);
        if (!empty($user_media))
        {
            response($user_media);
        }
        else
        {
            response([
                    'status' => FALSE,
                    'message' => message('user_media_not_found')
                ]);            
        }
    }

    function follow_post(){
        $follower_id    =  $this->input->post('user_id');
        $following_id   =  $this->input->post('follow_id');
        $status         =  $this->input->post('status');

        $user_data = array('follower_id' => $follower_id,
                            'following_id'=> $following_id,
                            'status'  => $status );
        $user_follow=$this->User_model->follow_user($status,$user_data);
        if (!empty($user_follow))
        {
            if($status==1)
                response(['message'=>message('follow_req_success')]);
            else if($status==2)
                response(['message'=>message('follow_req_accept')]);
            else if($status==3)
                response(['message'=>message('follow_req_reject')]);
            else
                response(['message'=>message('wrong_follow_req')]);
        }
        else
        {
            response([
                    'status' => FALSE,
                    'message' => message('follow_req_failure')
                ]);            
        }
    }

    function report_post(){
        $report_by_user    =  $this->input->post('report_by_user');
        $report_to_user    =  $this->input->post('report_to_user');
        $status            =  $this->input->post('status');

        $user_data = array('report_by_user' => $report_by_user,
                            'report_to_user'=> $report_to_user,
                            'status'  => $status );
        $user_report=$this->User_model->report_user($status,$user_data);
        if (!empty($user_report))
        {
            if($status==1)
                response(['message'=>message('user_reported')]);
            else if($status==2)
                response(['message'=>message('user_blocked')]);
            else
                response(['message'=>message('wrong_report_req')]);
        }
        else
        {
            response([
                    'status' => FALSE,
                    'message' => message('report_req_failure')
                ]);            
        }
    }

    function delete_report_post(){
        $report_by_user    =  $this->input->post('report_by_user');
        $report_to_user    =  $this->input->post('report_to_user');
        $user_report=$this->User_model->delete_report_user($report_by_user,$report_to_user);
        if (!empty($user_report))
        {
            if($status==1)
                response(['message'=>message('user_reported')]);
            else if($status==2)
                response(['message'=>message('user_blocked')]);
            else
                response(['message'=>message('wrong_report_req')]);
        }
        else
        {
            response([
                    'status' => FALSE,
                    'message' => message('report_req_failure')
                ]);            
        }
    }

    function frnd_suggest_get(){
        $user_id=$this->uri->segment(4);
        $frnds=$this->User_model->get_frnd_suggest($user_id);
        if (!empty($frnds))
        {
            response($frnds);
        }
        else
        {
            response([
                    'status' => FALSE,
                    'message' => message('frnd_not_found')
                ]);
            
        }
    }

    function uploadfile($img_str){
        $img_arr=explode(',', $img_str);
        $img_ext_part=explode(';',$img_arr[0]);
        $img_ext=substr($img_ext_part[0], strpos($img_ext_part[0],'/')+1);
        $img_name=time().".".$img_ext;
        $full_img=IMG_PATH.$img_name;
        $ifp=fopen($full_img,"wb");
        fwrite($ifp, base64_decode($img_arr[1]));
        fclose($ifp);
        return $img_name;
    }
}
