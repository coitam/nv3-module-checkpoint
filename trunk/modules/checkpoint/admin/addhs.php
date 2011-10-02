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
$lopid = $nv_Request->get_int ( 'lopid', 'get,post' );
$manamhoc = $nv_Request->get_int ( 'manamhoc', 'get,post' );

if ($nv_Request->get_int ( 'save', 'post' )) {
	$mahs = filter_text_input ( 'mahs', 'post', '', 1 );
	$hoten = filter_text_input ( 'hoten', 'post','', 1);
	$phai = $nv_Request->get_int ( 'phai', 'post','', 1);
	$ngaysinh = filter_text_input( 'ngaysinh', 'post', '', 1);
	$noisinh = filter_text_input( 'noisinh', 'post', 0 );
	$lopid = filter_text_input( 'lopid', 'post', 0 );
	$manamhoc = filter_text_input( 'manamhoc', 'post', 0 );
	if (! empty ( $ngaysinh ) && preg_match ( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $ngaysinh, $m )) {
		$ngaysinh = mktime ( 0, 0, 0, $m [2], $m [1], $m [3] );
	} else {
		$ngaysinh = NV_CURRENTTIME;
	}
	if (! empty ( $id )) {
		$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` SET `mahs`=" . $db->dbescape ( $mahs ). ",`manamhoc`=" . $db->dbescape ( $manamhoc ). ",`lopid`=" . $db->dbescape ( $lopid ). ",`hoten`=" . $db->dbescape ( $hoten ). ",`phai`=" . $db->dbescape ( $phai ). ",`ngaysinh`=" . $db->dbescape ( $ngaysinh ). ",`noisinh`=" . $db->dbescape ( $noisinh ). " WHERE id=" . $id . "" );
		if ($result) {
			echo $lang_module ['addhs_update_success'];
		} else {
			print_r ( $db->sql_error () );
		}
	} else {
		$alreadymahs = $db->sql_numrows ( $db->sql_query ( "SELECT mahs FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE mahs = " . $db->dbescape ( $mahs ) . "" ) );
		if (! $alreadymahs) {
			$result = $db->sql_query ( "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` (`mahs`,`manamhoc`,`lopid`,`hoten`,`phai`,`ngaysinh`,`noisinh`) VALUES (" . $db->dbescape ( $mahs ) . ", " . $db->dbescape ( $manamhoc ) . ", " . $db->dbescape ( $lopid ) . ", " . $db->dbescape ( $hoten ) . ", " . $db->dbescape ( $phai ) . ", " . $db->dbescape ( $ngaysinh ) . ", " . $db->dbescape ( $noisinh ) . ")" );
			if ($result) {
				echo $lang_module ['addhs_success'];
			} else {
				print_r ( $db->sql_error () );
			}
		} else {
			echo '
	<script type="text/javascript">
		alert("' . $lang_module ['addhs_error_code_exist'] . '");
	</script>
		';
		}
	}
} else {
	if (! empty ( $id )) {
		$row = $db->sql_fetchrow ( $db->sql_query ( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE id='$id'" ) );
		$dis = ! empty ( $id )?'disabled':'';
	} else {
		$row ['mahs'] = $row ['hoten'] ='';
	}
	$contents .= "<table class=\"tab1\" style='width:400px'>\n";
	$contents .= "<thead>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan=\"2\">" . $lang_module ['addhs_title'] . "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</thead>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['mahs'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['mahs'] . "' name='mahs' style='width:150px' ".$dis.">";
	$contents .= "<input type='hidden' value='" . (isset($row ['lopid'])?$row ['lopid']:$lopid) . "' name='lopid'>";
	$contents .= "<input type='hidden' value='" . (isset($row ['manamhoc'])?$row ['manamhoc']:$manamhoc) . "' name='manamhoc'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['hoten'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['hoten'] . "' name='hoten' style='width:250px'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['gtinh'] . "</td>\n";
	$contents .= "<td><select  name='phai' id = 'phai'>";
	$gtinh = array(0 => 'Nữ', 1 => 'Nam');
		For ($i = 0; $i <=1; $i ++) {
	       	$selgt =($i == $row['phai']?'selected':'');
			$contents .= "<option value = \"$i\" ". $selgt .">&nbsp;". $gtinh[$i] ."&nbsp;</option>";
		}
	$contents .= "</select></td>";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['ngsinh'] . "</td>\n";
	$contents .= "<td>";
	/*
	$contents .= "<input type='text' value='" . $row ['ngaysinh'] . "' name='ngaysinh' style='width:250px'>";
	*/
	$contents .= "<input type='text' value='" . (! empty ( $row ['ngaysinh'] ) ? date ( 'd.m.Y', $row ['ngaysinh'] ) : '') . "' id='ngaysinh' name='ngaysinh' style='width:150px'>";
	$contents .= "<img src=\"" . NV_BASE_SITEURL . "images/calendar.jpg\" widht=\"19\" style=\"cursor: pointer; vertical-align: middle;\" onclick=\"popCalendar.show(this, 'ngaysinh', 'dd.mm.yyyy', true);\" alt=\"\" height=\"18\">\n";

	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['noisinh'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['noisinh'] . "' name='noisinh' style='width:250px'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
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
	var mahs = $('input[name=\"mahs\"]').val();
	if (mahs==''){
		alert('" . $lang_module ['addhs_error_code'] . "');
		$('input[name=\"mahs\"]').focus();
		return false;
	}
	var phai = $('#phai').val();
	var hoten = $('input[name=\"hoten\"]').val();
	if (hoten==''){
		alert('" . $lang_module ['addhs_error_name'] . "');
		$('input[name=\"hoten\"]').focus();
		return false;
	}
	var ngaysinh = $('input[name=\"ngaysinh\"]').val();
	if (ngaysinh==''){
		alert('" . $lang_module ['addhs_error_ngaysinh'] . "');
		$('input[name=\"ngaysinh\"]').focus();
		return false;
	}
	var noisinh = $('input[name=\"noisinh\"]').val();
	if (noisinh==''){
		alert('" . $lang_module ['addhs_error_noisinh'] . "');
		$('input[name=\"noisinh\"]').focus();
		return false;
	}
	var lopid = $('input[name=\"lopid\"]').val();
	var manamhoc = $('input[name=\"manamhoc\"]').val();
	$('span[name=\"notice\"]').html('<img src=\"../images/load.gif\"> Xin đợi một lát...');
	$.ajax({	
		type: 'POST',
		url: 'index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=addhs',
		data: 'mahs='+ mahs + '&manamhoc='+ manamhoc + '&lopid='+ lopid +'&hoten='+ hoten + '&phai='+ phai +'&ngaysinh='+ ngaysinh + '&noisinh='+ noisinh +'&save=1" . (! empty ( $id ) ? '&id=' . $id . '' : '') . "',
		success: function(data){				
			$('input[name=\"confirm\"]').removeAttr('disabled');
			$('span[name=\"notice\"]').html(data);
			window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=main&lopid='+ lopid +'&manamhoc='+ manamhoc +'';
		}
	});
});
});
</script>
";
}
echo $contents;
?>