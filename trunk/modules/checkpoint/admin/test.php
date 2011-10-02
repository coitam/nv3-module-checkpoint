<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */

if (! defined ( 'NV_IS_FILE_ADMIN' ))die ( 'Stop!!!' );

$contents="";
$contents.="test";
//require_once ( NV_ROOTDIR . "/excel_reader2_patch_applied.php" );// nhung thu vien xu ly ma nguon mo 
	
//require_once ( NV_ROOTDIR . "/includes/excel.php" );
require_once ( NV_ROOTDIR . "/includes/mau.php" );
$data = new Spreadsheet_Excel_Reader("".NV_ROOTDIR."/tradiem_xlnh1.xls");
$contents.= $data->dump(9,5);


include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents );
include (NV_ROOTDIR . "/includes/footer.php");
?>