<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */
if(!defined('NV_IS_FILE_ADMIN'))
{
	die('Stop!!!');
}
$page_title = $lang_module['quanli_nam'];
$contents = "";
$contents .= "test";
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");

?>