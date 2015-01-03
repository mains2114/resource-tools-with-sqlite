<?php
/**
 * Created by PhpStorm.
 * User: mains2114
 * Date: 14-12-28
 * Time: 下午9:14
 */

class Input
{
	// this function is used to get params from $_GET
	// if pass a array of fields, then return these fields in the form of array
	// else if pass a string, return this field only
	//
	static function get($fields)
	{
		if ( is_array($fields) && !empty($fields) ) {
			$result = array();
			foreach ($fields as $i) {
				$result[$i] = self::get($i);
			}
			return $result;
		}
		elseif ( is_string($fields) ) {
			if ( isset($_GET[$fields]) ) {
				return $_GET[$fields];
			}
			else {
				return FALSE;
			}
		}
		else {
			return FALSE;
		}
	}

	// just like get(), but get fields form $_POST
	static function post($fields)
	{
		if ( is_array($fields) && !empty($fields) ) {
			$result = array();
			foreach ($fields as $i) {
				$result[$i] = self::post($i);
			}
			return $result;
		}
		elseif ( is_string($fields) ) {
			if ( isset($_POST[$fields]) ) {
				return $_POST[$fields];
			}
			else {
				return FALSE;
			}
		}
		else {
			return FALSE;
		}
	}
}