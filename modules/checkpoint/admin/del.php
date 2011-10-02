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
	$submit=$nv_Request->isset_request ( 'save', 'post' );
	$submit_cat=$nv_Request->isset_request ( 'save_cat', 'post' );
	$submit_to=$nv_Request->isset_request ( 'save_to', 'post' );
	if ($submit=="1") {
        $query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "";
        if ( $db->sql_query( $query ) )
        {
            $db->sql_freeresult();
            $msg = $lang_module['del_success'];
        }
        else
        {
            $msg = $lang_module['del_error'];
        }
        if ( $msg != '' )
        {
            $contents .= "<div class=\"quote\" style=\"width:780px;\">\n";
            $contents .= "<blockquote class=\"error\"><span>" . $msg . "</span></blockquote>\n";
            $contents .= "</div>\n";
            $contents .= "<div class=\"clear\"></div>\n";
        }
	}else if ($submit_cat=="2") {
        $query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_cat`";
        if ( $db->sql_query( $query ) )
        {
            $db->sql_freeresult();
            $msg_cat = $lang_module['del_success_cat'];
        }
        else
        {
            $msg_cat = $lang_module['del_error_cat'];
        }
        if ( $msg_cat != '' )
        {
            $contents .= "<div class=\"quote\" style=\"width:780px;\">\n";
            $contents .= "<blockquote class=\"error\"><span>" . $msg_cat . "</span></blockquote>\n";
            $contents .= "</div>\n";
            $contents .= "<div class=\"clear\"></div>\n";
        }
	}else if ($submit_to=="3") {
        $query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_to`";
        if ( $db->sql_query( $query ) )
        {
            $db->sql_freeresult();
            $msg_to = $lang_module['del_success_to'];
        }
        else
        {
            $msg_to = $lang_module['del_error_to'];
        }
        if ( $msg_to != '' )
        {
            $contents .= "<div class=\"quote\" style=\"width:780px;\">\n";
            $contents .= "<blockquote class=\"error\"><span>" . $msg_to . "</span></blockquote>\n";
            $contents .= "</div>\n";
            $contents .= "<div class=\"clear\"></div>\n";
        }
	}
	else
	{
	$contents .= "<div>";
	$contents .= "<form>";
	$contents .= "<table class=\"tab1\">\n";
	$contents .= "<td>";
	$contents .= "<center><b><font color=red>" . $lang_module['canhbaodel'] . "</font></b></center>";
	$contents .= "</td>\n";
	$contents .= "</table>";
	$contents .= "</form></div><br>";

	$contents .= "<div><form id=\"form1\" name=\"form1\" method=\"post\"><center>
	<table class=\"tab1\">
		<tr>
			<td class=\"fr\" width=\"170\" align = \"left\">". $lang_module ['del_gv'] . "</td>
			<td class=\"fr1\" align = \"left\"><input type=\"hidden\" value=\"1\" name=\"save\" size = 35 id=\"save\"/>
			<input type=\"submit\" name=\"import\" id=\"import1\" value=\"".$lang_module ['delyes']."\" />
		</tr>
		</table></center>
	</form></div>
	
	<div><form id=\"form2\" name=\"form2\" method=\"post\"><center>
	<table class=\"tab1\">
		<tr>
			<td class=\"fr\" align = \"left\" width=\"170\">". $lang_module ['del_cat'] . "</td>
			<td class=\"fr1\" align = \"left\"><input type=\"hidden\" value=\"2\" name=\"save_cat\" size = 35 id=\"save_cat\"/>
			<input type=\"submit\" name=\"import\" id=\"import2\" value=\"".$lang_module ['delyes']."\" />
		</tr>
	</table></center>
	</form></div>
	
	<div><form id=\"form3\" name=\"form3\" method=\"post\"><center>
	<table class=\"tab1\">
		<tr>
			<td class=\"fr\" align = \"left\" width=\"170\">". $lang_module ['del_to'] . "</td>
			<td class=\"fr1\" align = \"left\"><input type=\"hidden\" value=\"3\" name=\"save_to\" size = 35 id=\"save_to\"/>
			<input type=\"submit\" name=\"import\" id=\"import3\" value=\"".$lang_module ['delyes']."\" />
		</tr>
	</table></center>
	</form></div><br>";
	}
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents );
include (NV_ROOTDIR . "/includes/footer.php");
?>
