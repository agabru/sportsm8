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
		$idiom = isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])?$_SERVER['HTTP_ACCEPT_LANGUAGE']:'english';
		$CI->lang->load('message', $idiom);
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
