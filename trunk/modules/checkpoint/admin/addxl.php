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
$mahocky = $nv_Request->get_int ( 'mahocky', 'get,post' );

if ($nv_Request->get_int ( 'save', 'post' )) {
	$mahs = filter_text_input ( 'mahs', 'post', '', 1 );
	$hoten = filter_text_input ( 'hoten', 'post','', 1);
	$tbm = filter_text_input( 'tbm', 'post', '', 1);
	$hl = filter_text_input( 'hl', 'post', 0 );
	$hk = filter_text_input( 'hk', 'post', 0 );
	$snncp = filter_text_input( 'snncp', 'post', 0 );
	$snnkp = filter_text_input( 'snnkp', 'post', 0 );
	$danhhieu = filter_text_input( 'danhhieu', 'post', 0 );
	$nxgvcn = filter_text_textarea('nxgvcn','');

	if (! empty ( $id )) {
		$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` SET `tbm`=" . $db->dbescape ( $tbm ). ",`hl`=" . $db->dbescape ( $hl ). ",`hk`=" . $db->dbescape ( $hk ). ",`snncp`=" . $db->dbescape ( $snncp ). ",`snnkp`=" . $db->dbescape ( $snnkp ). ",`danhhieu`=" . $db->dbescape ( $danhhieu ). ",`nxgvcn`=" . $db->dbescape ( $nxgvcn ). " WHERE id=" . $id . "" );
		if ($result) {
			echo $lang_module ['addxl_update_success'];
		} else {
			print_r ( $db->sql_error () );
		}
	} 
} else {
	if (! empty ( $id )) {
		$row = $db->sql_fetchrow ( $db->sql_query ( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE id='$id'" ) );
		$dis = ! empty ( $id )?'disabled':'';
	} else {
		$row ['mahs'] = $row ['hoten'] ='';
	}
	$rowhs = $db->sql_fetchrow ( $db->sql_query ( "SELECT `hoten` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE `mahs`='". $row['mahs'] ."'" ) );

	$contents .= "<table class=\"tab1\" style='width:600px'>\n";
	$contents .= "<thead>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan=\"6\">" . $lang_module ['addxl_title'] . "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</thead>\n";
	
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:100px'>" . $lang_module ['mahs'] . "</td>\n";
	$contents .= "<td style='width:70px'>";
	$contents .= "<input type='text' value='" . $row ['mahs'] . "' name='mahs' style='width:70px' ".$dis.">";
	$contents .= "<input type='hidden' value='" . (isset($row ['lopid'])?$row ['lopid']:$lopid) . "' name='lopid'>";
	$contents .= "<input type='hidden' value='" . (isset($row ['manamhoc'])?$row ['manamhoc']:$manamhoc) . "' name='manamhoc'>";
	$contents .= "<input type='hidden' value='" . (isset($row ['mahocky'])?$row ['mahocky']:$mahocky) . "' name='mahocky'>";
	$contents .= "</td>\n";
	$contents .= "<td style='width:110px'>" . $lang_module ['hoten'] . "</td>\n";
	$contents .= "<td colspan=\"3\">";
	$contents .= "<input type='text' value='" . $rowhs [0] . "' name='hoten' style='width:100%'  ".$dis.">";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	
	$contents .= "<tr>\n";
	$contents .= "<td>" . $lang_module ['tbm'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['tbm'] . "' name='tbm' style='width:70px'>";
	$contents .= "</td>";
	$contents .= "<td>" . $lang_module ['hl'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['hl'] . "' name='hl' style='width:70px'>";
	$contents .= "</td>\n";
	$contents .= "<td style='width:90px'>" . $lang_module ['hk'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['hk'] . "' name='hk' style='width:70px'>";
	$contents .= "</td>\n";	
	$contents .= "</tr>\n";
	
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td>" . $lang_module ['snncp'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['snncp'] . "' name='snncp' style='width:70px'>";
	$contents .= "</td>\n";
	$contents .= "<td>" . $lang_module ['snnkp'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['snnkp'] . "' name='snnkp' style='width:70px'>";
	$contents .= "</td>\n";	
	$contents .= "<td>" . $lang_module ['danhhieu'] . "</td>\n";
	$contents .= "<td colspan = '3'>";
	$contents .= "<input type='text' value='" . $row ['danhhieu'] . "' name='danhhieu' style='width:70px'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";	
	$contents .= "</tbody>\n";

	$contents .= "<tr>\n";
	$contents .= "<td>" . $lang_module ['nxgvcn'] . "</td>\n";
	$contents .= "<td colspan = '5'>";
	$contents .= "<textarea name=\"nxgvcn\" style=\"width:100%; height:50px;\">". $row ['nxgvcn'] ."</textarea>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";	
	$contents .= "</tbody>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan='6' style='padding-left:100px'>";
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
	var tbm = $('input[name=\"tbm\"]').val();
	var hl = $('input[name=\"hl\"]').val();
	var hk = $('input[name=\"hk\"]').val();
	var snncp = $('input[name=\"snncp\"]').val();
	var snnkp = $('input[name=\"snnkp\"]').val();
	var danhhieu = $('input[name=\"danhhieu\"]').val();
	var nxgvcn = $('textarea[name=\"nxgvcn\"]').val();
	
	$('span[name=\"notice\"]').html('<img src=\"../images/load.gif\"> Xin đợi một lát...');
	$.ajax({	
		type: 'POST',
		url: 'index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=addxl',
		data: 'mahs='+ mahs + '&tbm='+ tbm + '&hl='+ hl +'&hk='+ hk + '&snncp='+ snncp +'&snnkp='+ snnkp + '&danhhieu='+ danhhieu +'&nxgvcn='+ nxgvcn +'&save=1" . (! empty ( $id ) ? '&id=' . $id . '' : '') . "',
		success: function(data){				
			$('input[name=\"confirm\"]').removeAttr('disabled');
			$('span[name=\"notice\"]').html(data);
			window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_xl&lopid='+ lopid +'&manamhoc='+ manamhoc +'&mahocky='+ mahocky +'';
		}
	});
});
});
</script>
";
}
echo $contents;
?>