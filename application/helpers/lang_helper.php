<?php
/**

Created by Abbas Gabru on 19th June,2019

*/
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('message'))
{
	/**
	 * @param string $lang_key  message key that needs to be fetched
	 *
	 * @return string SQL command
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
	 * @return string SQL command
	 */

	function response($resp)
	{
		$CI =& get_instance();
		return $CI->set_response($resp);
	}
}

if( ! function_exists('varprintf')){
	/**
	 * @param string $resp  Response that needs to be shown
	 *
	 * @return string SQL command
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
