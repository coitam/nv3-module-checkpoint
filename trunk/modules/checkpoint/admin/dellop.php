<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */
 
if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );

$id = $nv_Request->get_int ( 'id', 'get' );
// Kiem tra su ton tai cua lopid tai cac table lien quan, neu co se khong xoa
$sql ="SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_diem` WHERE  `lopid`='".$id."'";
$result = $db->sql_query( $sql);
$num1 = mysql_num_rows($result);

$sql ="SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE  `lopid`='".$id."'";
$result = $db->sql_query( $sql);
$num2 = mysql_num_rows($result);

$sql ="SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE  `lopid`='".$id."'";
$result = $db->sql_query( $sql);
$num3 = mysql_num_rows($result);

if ($num1 == 0 and $num2 == 0 and $num2 == 0){
	$db->sql_query ( "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop` WHERE lopid=$id" );
	echo $lang_module ['dellophoc_del_success'];
}else{
	echo $lang_module ['dellophoc_del_unsuccess'];
}

?>