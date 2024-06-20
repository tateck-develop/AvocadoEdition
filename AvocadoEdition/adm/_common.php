<?php
define('G5_IS_ADMIN', true);
include_once ('../common.php');

if(!defined("_LOGIN_PAGE_") || (defined("_LOGIN_PAGE_") && !_LOGIN_PAGE_)) {
	include_once(G5_ADMIN_PATH.'/admin.lib.php');
}
?>