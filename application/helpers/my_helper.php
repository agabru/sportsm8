<?php
/**
 * @author   Abbas Gabru <agabru@vavisa-kw.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('message'))
{
	/**
	 * @param string $lang_key  message key that needs to be fetched
	 *
	 * @return string
	 */

	function message($lang_key)
	{
		$CI =& get_instance();
		$CI->lang->load('message',LANG);
		return $CI->lang->line($lang_key);
	}
}

if ( ! function_exists('response'))
{
	/**
	 * @param string $resp  Response that needs to be shown
	 *
	 * @return string
	 */

	function response($resp)
	{
		$CI =& get_instance();
		return $CI->set_response($resp);
	}
}

if( ! function_exists('varprintf')){
	/**
	 * @param string $vals  multiple arguments
	 *
	 * @return string
	 */

	function varprintf(...$vals)
	{
		$get_args=func_get_args(func_num_args());
		if(LANG=="arabic"){
			$message=array_shift($get_args);
			$get_args=array_reverse($get_args);
			array_unshift($get_args,$message);
		}	
		return call_user_func_array("sprintf", $get_args);
	}
}

if ( ! function_exists('getUserId'))
{
	/**
	 * @param no params
	 *
	 * @return number user_id
	 */
	function getUserId()
	{
		$CI =& get_instance();
		if(AUTH_TOKEN!=""){
			$CI->db->where('token_id',AUTH_TOKEN);
			$CI->db->from('user_authentication');
			$query=$CI->db->get();
			return $query->row_array()['user_id'];
		}
		return 0;
	}
}

if(!function_exists('uploadfile'))
{
	function uploadfile1($img_str){
        $img_arr=explode(',', $img_str);
        $img_ext_part=explode(';',$img_arr[0]);
        $img_ext=substr($img_ext_part[0], strpos($img_ext_part[0],'/')+1);
        $img_name=time().".".$img_ext;
        $full_img=RE_IMG_PATH.$img_name;
        $ifp=fopen($full_img,"wb");
        fwrite($ifp, base64_decode($img_arr[1]));
        fclose($ifp);
        return $img_name;
    }

    function uploadfile($img_str){
        $img_arr=explode(',', $img_str);
        $type_ext=$img_arr[0];
        $base64en_string=$img_arr[1];
        $media_type_ext=substr(strstr($type_ext,';',true),strpos($type_ext,':')+1);
        $media_type_ext_arr=explode('/', $media_type_ext);
        $type=$media_type_ext_arr[0];
        $ext=$media_type_ext_arr[1];
        $img_name=time().".".$ext;
        $full_img=REL_IMG_PATH.$img_name;
        $ifp=fopen($full_img,"wb");
        fwrite($ifp, base64_decode($img_arr[1]));
        fclose($ifp);
        $img_data=array('name'=>$img_name,'type'=>$type);
        return $img_data;
    }
}