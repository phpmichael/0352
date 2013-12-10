<?php

/**
 * User session check, for registered users
 * 
 * If you don't care about access,
 * please remove or comment following code
 * 
 */

$value = md5('soliter-123'.$_SERVER['REMOTE_ADDR']);

if( @$_COOKIE['T_M_I'] != $value) 
{
	echo 'Access denied, check file '.basename(__FILE__);
	exit();
}