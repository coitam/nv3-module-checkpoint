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
	$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` SET `tbm`='',`hl`='',`hk`='',`snncp`='',`snnkp`='',`danhhieu`='',`nxgvcn`='' WHERE `id`=" . $id . "" );
	echo $lang_module ['delxl_del_success'];
}else{
	echo $lang_module ['delxl_del_unsuccess'];
}

?>