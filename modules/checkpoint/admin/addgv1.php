<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */

if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );

$id = $nv_Request->get_int ( 'id', 'get,post' );

if ($nv_Request->get_int ( 'save', 'post' )) {
	$gvid = filter_text_input ( 'gvid', 'post', '', 1 );
	$tengv = filter_text_input ( 'tengv', 'post','', 1);
	$user = filter_text_input ( 'user', 'post','', 1);
	$chunhiem = $nv_Request->get_int( 'chunhiem', 'post', 0 );
	$active = $nv_Request->get_int( 'active', 'post', 0 );
	
	if (! empty ( $id )) {
		$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` SET `tengv`=" . $db->dbescape ( $tengv ). ",`user`=" . $db->dbescape ( $user ). " WHERE gvid=" . $id . "" );
		//$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` SET `tengv`=" . $db->dbescape ( $tengv ). ",`user`=" . $db->dbescape ( $user ). ",`chunhiem`=" . $db->dbescape ( $chunhiem ) . ",`active`=" . $db->dbescape ( $active ) . " WHERE gvid=" . $id . "" );
		
		if ($result) {
			echo $lang_module ['addgv_update_success'];
		} else {
			print_r ( $db->sql_error () );
		}
	} else {
		$alreadygvid = $db->sql_numrows ( $db->sql_query ( "SELECT gvid FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` WHERE gvid = " . $db->dbescape ( $gvid ) . "" ) );
		if (! $alreadygvid) {
			$result = $db->sql_query ( "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` (`gvid`,`tengv`,`user`)VALUES (" . $db->dbescape ( $gvid ) . ", " . $db->dbescape ( $tengv ) . ", " . $db->dbescape ( $user ) . ")" );
			//$result = $db->sql_query ( "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` (`gvid`,`tengv`,`user`,`chunhiem`,`active`)VALUES (" . $db->dbescape ( $gvid ) . ", " . $db->dbescape ( $tengv ) . ", " . $db->dbescape ( $user ) . ", " . $db->dbescape ( $chunhiem ) . ", " . $db->dbescape ( $active ) . ")" );
			
			if ($result) {
				echo $lang_module ['addgv_success'];
			} else {
				print_r ( $db->sql_error () );
			}
		} else {
			echo '
	<script type="text/javascript">
		alert("' . $lang_module ['addgv_error_code_exist'] . '");
	</script>
		';
		}
	}
} else {
	if (! empty ( $id )) {
		$row = $db->sql_fetchrow ( $db->sql_query ( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` WHERE gvid='$id'" ) );
		$dis = ! empty ( $id )?'disabled':'';
	} else {
		$row ['gvid'] = $row ['tengv'] ='';
	}
	$ch_cn = ($row['chunhiem'] == 1?'checked':'');
	$ch_kh = ($row['active'] == 1?'checked':'');	
	$contents .= "<table class=\"tab1\" style='width:400px'>\n";
	$contents .= "<thead>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan=\"2\">" . $lang_module ['addgv_title'] . "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</thead>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['magv'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['gvid'] . "' name='gvid' style='width:150px' ".$dis.">";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['tengv'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['tengv'] . "' name='tengv' style='width:250px'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['user'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['user'] . "' name='user' style='width:250px'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	/*
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['cn'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type=\"checkbox\" name=\"chunhiem\" value=\"1\" ". $ch_cn ."/>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['active'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type=\"checkbox\" name=\"active\" value=\"1\" ". $ch_kh ."/>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	*/
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan='2' style='padding-left:100px'>";
	$contents .= "<span name='notice' style='float:right;padding-right:50px;color:red;font-weight:bold'></span>";
	$contents .= "<input type='button' name='confirm' value='" . $lang_module ['thuchien'] . "'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "</table>\n";
	$contents .= "
<script type='text/javascript'>
$(function(){
$('input[name=\"confirm\"]').click(function(){
	var gvid = $('input[name=\"gvid\"]').val();
	if (gvid==''){
		alert('" . $lang_module ['addgv_error_code'] . "');
		$('input[name=\"gvid\"]').focus();
		return false;
	}
	var tengv = $('input[name=\"tengv\"]').val();
	if (tengv==''){
		alert('" . $lang_module ['addgv_error_name'] . "');
		$('input[name=\"tengv\"]').focus();
		return false;
	}
	
	var user = $('input[name=\"user\"]').val();
	$('span[name=\"notice\"]').html('<img src=\"../images/load.gif\"> please wait...');
	$.ajax({	
		type: 'POST',
		url: 'index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=addgv',
		data: 'gvid='+ gvid + '&tengv='+ tengv + '&user='+ user +'&save=1" . (! empty ( $id ) ? '&id=' . $id . '' : '') . "',
		success: function(data){
			$('input[name=\"confirm\"]').removeAttr('disabled');
			$('span[name=\"notice\"]').html(data);
			window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_dsgv';
		}
	});
});
});
</script>
";
}
echo $contents;
?>