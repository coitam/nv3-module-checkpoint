<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */

if (! defined ( 'NV_SYSTEM' ))die ( 'Stop!!!' );

define ( 'NV_IS_MOD_CHECKPOINT', true );
function creat_config($str) {
	if (! file_exists ( NV_ROOTDIR . '/' . NV_DATADIR . '/tradiem/' . $str . ".txt" )) {
		$f = fopen ( NV_ROOTDIR . '/' . NV_DATADIR . '/tradiem/' . $str . ".txt", "w" );
		if ($str == 'config') {
			fwrite ( $f, 'Hệ thống tra điểm của trường THPT Vinh Lộc|20/08/2010|7h00|13h00' );
		}
		fclose ( $f );
	}
}
function is_admin($nickname) {
	global $module_data, $db;
	$sql = "SELECT a.userid FROM " . NV_USERS_GLOBALTABLE . " a INNER JOIN " . NV_AUTHORS_GLOBALTABLE . " b ON a.userid=b.admin_id WHERE a.username=" . $db->dbescape ( $nickname ) . "";
	list ( $userid ) = $db->sql_fetchrow ( $db->sql_query ( $sql ) );
	return ($userid) ? 1 : 0;
}
?>