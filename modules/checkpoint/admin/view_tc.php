<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */

if(!defined('NV_IS_DSCB_ADMIN'))
{
	die('Stop!!!');
}
	$page_title = $lang_module['view_tc'];
	$tcid = $nv_Request->get_int ( 'tcid', 'post' );
	$delid = $nv_Request->get_int ( 'delid', 'get' );
	$num = 0;
	if($delid !=0){
		//Xoa danh sach to chuc
		$db->sql_query("DELETE FROM`" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `gvid`='".$delid."'");
	}//End IF
	if ($tcid > 0){
    $sql = "SELECT DISTINCT `gvid`, `hoten`, `ngsinh`, `active`,`sorttc` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `tcid`= '". $tcid ."' ORDER BY `sorttc` ASC";
	$result = $db->sql_query( $sql ) or die ('Đã có lỗi xảy ra trong lệnh truy vấn CSDL.<br />');
    $num = $db->sql_numrows($result);
	}
	if($num > 0){
		$contents .= "<br /><table summary=\"\" class=\"tab1\">\n";
		$contents .= "<td><center><b><font color=blue size=3>" . $lang_module['ds_tc'] . "</font></b></center></td>\n";
		$contents .= "</table>";
		// Hien thi hop chon lua
		$contents .= "<form name=\"chon_tc\" method=\"post\">";
		$contents .= "<table summary=\"\" class=\"tab1\">\n";
		$contents .= "<td align = \"center\">";
		$contents .= "". $lang_module['ch_tc'] . "&nbsp;&nbsp;";
		$contents .= "<select name = \"tcid\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn tổ cần xem</option>";
		$sqltc = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_tc`";
		$resulttc = $db->sql_query( $sqltc);
		while ($dstc = $db->sql_fetchrow($resulttc))
		{
			if ($tcid==$dstc[0]){
				$tentc = $dstc[1];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= "<option value=\"$dstc[0]\" ". $sel .">&nbsp;$dstc[1]</option>";
		}
		$contents .= "</select>";
		$contents .= "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submitedit\" value = \"" . $lang_module['thuchien'] . "\" /></center>";
		$contents .= "</td>\n";
		$contents .= "</table>";
		$contents .= "</form>";
	    if ($delid != 0){
	       $contents .= "<div class=\"quote\" style=\"width:780px;\">\n";
	       $contents .= "<blockquote class=\"error\"><span>" . $lang_module['del_tb'] . "</span></blockquote>\n";
	       $contents .= "</div>\n";
	       $contents .= "<div class=\"clear\"></div>\n";
	    }
		// Hien thi danh sach giao vien
		$contents .= "<table class=\"tab1\">\n";
	    $contents .= "<thead>\n";
	    $contents .= "<tr>\n";
	    $contents .= "<td align=\"center\">" . $lang_module['stt'] . "</td>\n";
	    $contents .= "<td align=\"center\">" . $lang_module['gvid'] . "</td>\n";
	    $contents .= "<td align=\"center\">" . $lang_module['hoten'] . "</td>\n";
	    $contents .= "<td align=\"center\">" . $lang_module['ngsinh'] . "</td>\n";
	    $contents .= "<td align=\"center\">" . $lang_module['thuoctc'] . "</td>\n";
	    $contents .= "<td align=\"center\">" . $lang_module['trangthai'] . "</td>\n";
	    $contents .= "<td align=\"center\">" . $lang_module['sort'] . "</td>\n";
	    $contents .= "<td align=\"center\">" . $lang_module['quanli'] . "</td>\n";
	    $contents .= "</tr>\n";
	    $contents .= "</thead>\n";

	    $a=1;
	    $trangthai = array("Ngưng kích hoạt","Kích hoạt");
	    while ( $row = $db->sql_fetchrow( $result ) )
	    {
	        $contents .= "<tr>\n";
	        $contents .= "<td align=\"center\">" . $a. "</td>\n";
	        $contents .= "<td align=\"center\">" . $row[0] . "</td>\n";
	        $contents .= "<td>" . $row[1] . "</td>\n";
	        $contents .= "<td align=\"center\">" . $row[2] . "</td>\n";
	        $contents .= "<td align=\"center\">" . $tentc . "</td>\n";
	        // Hien thi trang thai da kich hoat hay chua
  	        $contents .= "<td align=\"center\">
        	<select name = \"trangthai\" id=\"change_kh_" . $row['gvid'] . "\" onchange=\"nv_chang_kh('" . $row['gvid'] . "');\">";
        		For ($i = 0; $i <= 1; $i++){
       			$selkh =(($i == $row[3])?'selected':'');
       			$contents .= "<option value =\"$i\" ". $selkh .">&nbsp;". $trangthai[$i] ."&nbsp;</option>";
       		}
	        $contents .= "</select></td>\n";
	        //$contents .= "<td align=\"center\">" . $trangthai[$row[3]] . "</td>\n";
	        $contents .= "<td align=\"center\">
	        	<select name = \"sort\" id=\"change_sort_" . $row['gvid'] . "\" onchange=\"nv_chang_sort('" . $row['gvid'] . "');\">";
	        		For ($i = 1; $i <= $num; $i++){
	        			$seltt =(($i == $row[4])?'selected':'');
	        			$contents .= "<option value =\"$i\" ". $seltt .">&nbsp;$i&nbsp;</option>";
	        		}
	        $contents .= "</select></td>\n";
	        $contents .= "<td align=\"center\"><span class=\"edit_icon\"><a href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=edit_ds&amp;gvid=" . $row[0] . "\">" . $lang_global['edit'] . "</a></span>\n";
	        $contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=view_tc&amp;delid=" . $row[0] . "\">" . $lang_global['delete'] . "</a></span></td>\n";
	        $contents .= "</tr>\n";
	        $contents .= "</tbody>\n";
	        $a ++;
	    }
	    $contents .= "</table>\n";	
	} else {

		$contents .= "<br /><table summary=\"\" class=\"tab1\">\n";
		$contents .= "<td><center><b><font color=blue size=3>" . $lang_module['ds_tc'] . "</font></b></center></td>\n";
		$contents .= "</table>";
		// Hien thi hop chon lua
		$contents .= "<form name=\"chon_tc\" method=\"post\">";
		$contents .= "<table summary=\"\" class=\"tab1\">\n";
		$contents .= "<td align = \"center\">";
		$contents .= "". $lang_module['ch_tc'] . "&nbsp;&nbsp;";
		$contents .= "<select name = \"tcid\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn tổ chức cần xem</option>";
		$sqltc = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_tc`";
		$resulttc = $db->sql_query( $sqltc);
		while ($dstc = $db->sql_fetchrow($resulttc))
		{
			$contents .= "<option value=\"$dstc[0]\">&nbsp;$dstc[1]</option>";
		}
		$contents .= "</select>";
		$contents .= "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submitedit\" value = \"" . $lang_module['thuchien'] . "\" /></center>";
		$contents .= "</td>\n";
		$contents .= "</table>";
		$contents .= "</form>";

	}
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");

?>