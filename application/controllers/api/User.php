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

    function index_post() {
    	$user_name=$this->input->post('user_name');
    	$user_email=$this->input->post('user_email');
        $user_mobile=$this->input->post('user_mobile');
        $user_password=$this->input->post('user_password');

        $user_data = array('user_name' => $user_name,
                            'user_email'=>$user_email,
                            'user_mobile'=>$user_mobile,
                            'user_password'=>$user_password);

        $user=$this->User_model->signup($user_data);
        if (!empty($user))
        {
            response($user);
        }
        else
        {
            response([
                'status' => FALSE,
                'message'=>message('user_not_created')                
            ]);
        }
    }

    function index_put(){
        $user_id=$this->uri->segment(3);
        $user_data=json_decode(file_get_contents("php://input"),true);
        // print_r($user_data);
        // die();
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

    function index_get(){
        $user_id=$this->uri->segment(3);
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

    function index_delete(){
        $user_id=$this->uri->segment(3);
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
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload_form', $error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

            $this->load->view('upload_success', $data);
        }
    }
}
