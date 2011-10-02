<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */
if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );
$page_title = $lang_module ['import'];
$contents="";
if ($nv_Request->isset_request ( 'import1', 'post' )) {
	$lopid = $nv_Request->get_int ( 'lopid', 'post' );
	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post' );
	
if (isset( $_FILES['ufile1']['tmp_name']) )
{
	$line=0;
	$them=0;
	$sua=0;
	$data = new Spreadsheet_Excel_Reader($_FILES['ufile1']['tmp_name'],true,"UTF-8"); // Đọc file excel, hỗ trợ Unicode UTF-8
	$rowsnum = $data->rowcount($sheet_index=0); // Số hàng của sheet
	$colsnum =  $data->colcount($sheet_index=0);  //Số cột của sheet
	$contents .="<br>Số dòng: " . $rowsnum;
	$contents .="<br>Số cột: "  .$colsnum."<br>" ;
	$contents .="<b>Đọc dữ liệu từ Excel lên </b><br> ";
	$contents .= "<table border=1 cellspacing=1 cellpadding=0>";
	$contents .= "<tr bgcolor='#999999'> <td>STT</td>";
	for($t=1; $t<=$colsnum; $t++)
	$contents .="<td>".$data->val(1,$t)."</td> ";
	$contents .="</tr>";
	for ($i=2;$i<=$rowsnum;$i++) // Duyệt từng hàng, bắt đầu lấy dữ liệu từ hàng 2
	{

		$j=$i-1;
		$contents .= "<tr>";
		$contents .= 	"<td>" .$j ."</td>";
		for($k=1; $k<=$colsnum; $k++)
		$contents .="<td>".$data->val($i,$k)."</td>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE `mahs`='" . $data->val($i,1)."'";
		$result = $db->sql_query($sql);
		$numrows = $db->sql_numrows($result);
		if(!$numrows)
		{
			$time = $data->val($i,3);
			if (! empty ( $time ) && preg_match ( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $time , $m )) {
				$ngaysinh = mktime ( 0, 0, 0, $m [2], $m [1], $m [3] );
			} else {
				$ngaysinh = NV_CURRENTTIME;
			}
			$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` (`mahs`, `manamhoc`, `lopid`, `hoten`, `phai`, `ngaysinh`, `noisinh`) VALUES (
			". $db->dbescape ( $data->val($i,1) ) .", 
			". $db->dbescape ( $manamhoc ) .", 
			". $db->dbescape ( $lopid ) .", 
			". $db->dbescape ( $data->val($i,2) ) .", 
			". $db->dbescape ( $data->val($i,3) ) .", 
			". $db->dbescape ( $ngaysinh ).", 
			". $db->dbescape ( $data->val($i,5) ) .")";
			$db->sql_query( $query );
			$them=$them+1;
		}else
		{
			if (! empty ( $time ) && preg_match ( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $time, $m )) {
				$ngaysinh = mktime ( 0, 0, 0, $m [2], $m [1], $m [3] );
			} else {
				$ngaysinh = NV_CURRENTTIME;
			}
			$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` SET 
			`hoten`=". $db->dbescape ( $data->val($i,2) ) .", 
			`phai`=". $db->dbescape ( $data->val($i,3) ) .", 
			`ngaysinh`=". $db->dbescape ( $ngaysinh ) .", 
			`noisinh`=". $db->dbescape ( $data->val($i,5) ) ." 
			WHERE `mahs`=" . $db->dbescape ( $data->val($i,1) ) ."";
			$db->sql_query($sql);
			$sua=$sua+1;			
		}
	}
	$contents .= "</table>";
}
	//Hien thi thong bao sau khi import
	$contents .= "<div class=\"quote\" style=\"width:780px;\">\n";
    $contents .= "<blockquote class=\"error\"><span>" . $lang_module['import_success'] . "</span></blockquote>\n";
    $contents .= "</div><br>";
    $contents .= "<div class=\"clear\"></div>\n";
    $contents .= "<div id=\"list_mods\"
	<form id=\"form\" name=\"form\" method=\"post\">
	<table class=\"tab1\">
	<tr>
		<td class=\"fr\">" . $lang_module['line'] . "" . ($rowsnum-1). "<br></td>
	</tr>
	<tr>
		<td class=\"fr\">" . $lang_module['them'] . "" . $them. "<br></td>
	</tr>
	<tr>
		<td class=\"fr\">" . $lang_module['sua'] . "" . $sua. "<br></td>
	</tr>
	</table>
	</form></div>";
}
else
{
$contents .= "<table summary=\"\" class=\"tab1\">\n";
$contents .= "<td><center><b><font color=blue size=3>" . $lang_module['import_tdds'] . "</font></b></center></td>\n";
$contents .= "</table>";

$contents .= "<div><form enctype=\"multipart/form-data\" id=\"form1\" name=\"form1\" method=\"post\">
<table class=\"tab1\">
	<tr>
		<td class=\"fr\" width=\"220\">". $lang_module ['import_dshs'] . "</td>
		<td class=\"fr1\">";
		// Chon lop hoc
		$contents .= "<select name = \"lopid\">
		<option value=\"0\" size = \"50\">&nbsp;Chọn lớp</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop`";
		$result = $db->sql_query( $sql);
		while ($dslop = $db->sql_fetchrow($result))
		{
			$contents .= "<option value=\"$dslop[0]\">&nbsp;$dslop[1]</option>";
		}
		$contents .= "</select>&nbsp;&nbsp;";
		// Chon nam hoc
		$contents .= "<select name = \"manamhoc\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn năm học</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc`";
		$result = $db->sql_query( $sql);
		while ($namhoc = $db->sql_fetchrow($result))
		{
			$contents .= "<option value=\"$namhoc[0]\">&nbsp;$namhoc[1]</option>";
		}
		$contents .= "</select><br />
		<input type=\"file\" name=\"ufile1\" size = \"35\" id=\"ufile1\"/>
		<input type=\"submit\" name=\"import1\" id=\"import1\" value=\"Import\" /></td>
	</tr>
	</table></center>
	</form></div>";
		

}
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents );
include (NV_ROOTDIR . "/includes/footer.php");
?>
