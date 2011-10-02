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
if (isset($id)){
	$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_diem` SET `m_1`='',`m_2`='',`15_1`='',`15_2`='',`15_3`='',`15_4`='',`15_5`='',`45_1`='',`45_2`='',`45_3`='',`45_4`='',`45_5`='',`thi`='',`tbm`='' WHERE `id`=" . $id . "" );
	echo $lang_module ['deldiem_del_success'];
}else{
	echo $lang_module ['deldiem_del_unsuccess'];
}

?>