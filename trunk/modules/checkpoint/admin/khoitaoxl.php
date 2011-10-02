<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */

if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );
$lopid = $nv_Request->get_int ( 'lopid', 'get' );
$manamhoc = $nv_Request->get_int ( 'manamhoc', 'get' );
$mahocky = $nv_Request->get_int ( 'mahocky', 'get');
// Loc ma giao vien
/*
$sql = "SELECT DISTINCT `gvid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop` WHERE `lopid` = '". $lopid ."'";
$result = $db->sql_query( $sql);
$num = mysql_num_rows($result);
if ($num == 1){
	$gvid = mysql_fetch_array($result);
} else {
	$gvid = 0;
}
*/
// Loc danh sach ma hoc sinh trong lop
$dsmahs = array();
$sql = "SELECT DISTINCT `mahs` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE `lopid` = '". $lopid ."'";
$result = $db->sql_query( $sql);
$dsmahs = array();
while ($row = mysql_fetch_array($result))
	{
		$dsmahs[] = $row[0];
	}
// Khoi tao diem cua mon hoc
	For ($i = 0; $i < count($dsmahs); $i ++){
		// Kiem tra ton tai trong CSDL
		$sql = "SELECT DISTINCT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE `mahs` = '". $dsmahs[$i] ."' AND `lopid` = '". $lopid ."' AND `manamhoc` = '". $manamhoc ."' AND `mahocky` = '". $mahocky ."'";
		$result = $db->sql_query( $sql);
		$num2 = mysql_num_rows($result);
		If ($num2 == 0){
			$sql = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` (`id`, `mahs`, `lopid`, `manamhoc`, `mahocky`, `tbm`, `hl`, `hk`, `snncp`, `snnkp`, `danhhieu`, `nxgvcn`) VALUES (NULL, " . $db->dbescape ( $dsmahs[$i] ) . ", " . $db->dbescape ( $lopid ) . ", " . $db->dbescape ( $manamhoc ) . ", " . $db->dbescape ( $mahocky ) . ",'','','','','','','')";
			$result = $db->sql_query( $sql);
		}
	}
	if ($result) {
		echo $lang_module ['khoitaodl_success'];
	} else {
		print_r ( $db->sql_error () );
	}
echo $contents;
?>