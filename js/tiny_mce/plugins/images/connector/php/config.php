<?php
//require_once(dirname(__FILE__).'/../../../../../../../application_cms/settings/config.php');

//if(@$_POST['SID'])define(SID,$_POST['SID']);//this is for swfupload - it send session id in _POST
//session_start();

//Site root dir
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
//define('DIR_ROOT', dirname($_SERVER['SCRIPT_FILENAME']).'/../../../../../..');

define('LOCAL_PATH', '/CI/0352/');

//Images dir (root relative)
define('DIR_IMAGES', LOCAL_PATH.'store');

//Icons of file types
define('DIR_FILETYPES_ICONS', LOCAL_PATH.'images/file_types/');
//Files dir (root relative)
define('DIR_FILES', '/nofolder');//no need anymore ... files can be uploaded to any folder


//Width and height of resized image
define('WIDTH_TO_LINK', 500);
define('HEIGHT_TO_LINK', 500);

//Additional attributes class and rel
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');

?>