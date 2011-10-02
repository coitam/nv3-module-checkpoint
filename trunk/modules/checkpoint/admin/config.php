<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */
if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );
$page_title = $lang_module ['config_title'];

include (NV_ROOTDIR . "/includes/class/geturl.class.php");
$data = file_get_contents ( NV_ROOTDIR . '/modules/tradiem/config.txt' );
$ex = explode ( '|', $data );
if ($nv_Request->isset_request ( 'do', 'post' )) {
	$str = trim ( $nv_Request->get_string ( 'tieude', 'post', 'Tiêu đề hệ thống tra cứu' ) ) . '|' . trim ( $nv_Request->get_string ( 'huongdan', 'post', 'Tra theo mã học sinh, mã lớp hoặc họ tên. Ví dụ: 10A01 hoặc 10A0109 hoặc Dung.' ) );
	@chmod( NV_ROOTDIR . '/modules/tradiem/config.txt', 0777 );
	$f = fopen (NV_ROOTDIR . '/modules/tradiem/config.txt', "w" );
	fwrite ( $f, $str );
	fclose ( $f );
	@chmod( NV_ROOTDIR . '/modules/tradiem/config.txt', 0604 );
	$contents .= "<div class=\"quote\" style=\"width:780px;\">\n";
    $contents .= "<blockquote class=\"error\"><span>" . $lang_module['add_cf_success'] . "</span></blockquote>\n";
    $contents .= "</div>\n";
    $contents .= "<div class=\"clear\"></div>\n";
}else{
	// Hien thi tieu de
    $contents .= "<table summary=\"\" class=\"tab1\">\n";
    $contents .= "<td align='center'><b><font color=blue size=3>" . $lang_module['tdconfig'] . "</font></b></td>\n";
  	$contents .= "</thead>\n";
	
$contents .= '<div id=\"list_mods\">
<form id="form1" name="form1" method="post" action="">
<table class="tab1">
	<tbody class="second">
	<tr>
		<td>Tiêu đề hệ thống tra cứu</td>
		<td><input name="tieude" type="text" id="tieude" size="75" value="' . $ex [0] . '" style="width:100%;"/> </td>
	</tr>
	</tbody>
	<tr>
		<td>Tiêu đề hướng dẫn tra cứu</td>
		<td><input name="huongdan" type="text" id="huongdan" size="75" value="' . $ex [1] . '" style="width:100%;"/> </td>
	</tr>
	<tbody class="second">
	<tr>
		<td colspan="2" align="center" class="fr2"><input type="submit" name="do" id="do" value="Lưu lại" /></td>
	</tr>
	</tbody>
</table></div>
</form>';
}
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents );
include (NV_ROOTDIR . "/includes/footer.php");
?>
