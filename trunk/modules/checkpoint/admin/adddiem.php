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
$monid = filter_text_input ( 'monid', 'post','', 1);
$mahocky = filter_text_input ( 'mahocky', 'get,post');

if ($nv_Request->get_int ( 'save', 'post' )) {
	$m_1 = filter_text_input ( 'm_1', 'post','', 1);
	$m_2 = filter_text_input ( 'm_2', 'post','', 1);
	$d15_1 = filter_text_input ( 'd15_1', 'post','', 1);
	$d15_2 = filter_text_input ( 'd15_2', 'post','', 1);
	$d15_3 = filter_text_input ( 'd15_3', 'post','', 1);
	$d15_4 = filter_text_input ( 'd15_4', 'post','', 1);
	$d15_5 = filter_text_input ( 'd15_5', 'post','', 1);
	$d45_1 = filter_text_input ( 'd45_1', 'post','', 1);
	$d45_2 = filter_text_input ( 'd45_2', 'post','', 1);
	$d45_3 = filter_text_input ( 'd45_3', 'post','', 1);
	$d45_4 = filter_text_input ( 'd45_4', 'post','', 1);
	$d45_5 = filter_text_input ( 'd45_5', 'post','', 1);
	$thi = filter_text_input ( 'thi', 'post','', 1);
	$tbm = filter_text_input ( 'tbm', 'post','', 1);
	$id = $nv_Request->get_int ( 'id', 'post' );

	if (! empty ( $id )) {
		$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_diem` SET `m_1`=" . $db->dbescape ( $m_1 ). ",`m_2`=" . $db->dbescape ( $m_2 ). ",`15_1`=" . $db->dbescape ( $d15_1 ). ",`15_2`=" . $db->dbescape ( $d15_2 ). ",`15_3`=" . $db->dbescape ( $d15_3 ). ",`15_4`=" . $db->dbescape ( $d15_4 ). ",`15_5`=" . $db->dbescape ( $d15_5 ). ",`45_1`=" . $db->dbescape ( $d45_1 ). ",`45_2`=" . $db->dbescape ( $d45_2 ). ",`45_3`=" . $db->dbescape ( $d45_3 ). ",`45_4`=" . $db->dbescape ( $d45_4 ). ",`45_5`=" . $db->dbescape ( $d45_5 ). ",`thi`=" . $db->dbescape ( $thi ). ",`tbm`=" . $db->dbescape ( $tbm ). " WHERE `id`=" . $id . "" );
		if ($result) {
			echo $lang_module ['adddiem_update_success'];
		} else {
			print_r ( $db->sql_error () );
		}
	} 
} else {
	if (! empty ( $id )) {
		$row = $db->sql_fetchrow ( $db->sql_query ( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_diem` WHERE id='$id'" ) );
		$dis = ! empty ( $id )?'disabled':'';
	} else {
		$row ['mahs'] = $row ['hoten'] ='';
	}
	$rowten = $db->sql_fetchrow ( $db->sql_query ( "SELECT hoten FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE mahs='".$row ['mahs']."'" ) );
	$contents .= "<table class=\"tab1\" style='width:400px'>\n";
	$contents .= "<thead>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan=\"2\">" . $lang_module ['adddiem_title'] . "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</thead>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['mahs'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['mahs'] . "' name='mahs' style='width:70px' ".$dis.">";
	$contents .= "<input type='hidden' value='" . (isset($row ['lopid'])?$row ['lopid']:$lopid) . "' name='lopid'>";
	$contents .= "<input type='hidden' value='" . (isset($row ['manamhoc'])?$row ['manamhoc']:$manamhoc) . "' name='manamhoc'>";
	$contents .= "<input type='hidden' value='" . (isset($row ['mahocky'])?$row ['mahocky']:$mahocky) . "' name='mahocky'>";
	$contents .= "<input type='hidden' value='" . (isset($row ['monid'])?$row ['monid']:$monid) . "' name='monid'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['hoten'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $rowten [0] . "' name='hoten' style='width:250px'  ".$dis.">";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['dmieng'] . "</td>\n";
	$contents .= "<td><input type='text' value='" . $row ['m_1'] . "' name='m_1' style='width:40px'>
				<input type='text' value='" . $row ['m_2'] . "' name='m_2' style='width:40px'></td>";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['d15ph'] . "</td>\n";
	$contents .= "<td><input type='text' value='" . $row ['15_1'] . "' name='d15_1' style='width:40px'>
				<input type='text' value='" . $row ['15_2'] . "' name='d15_2' style='width:40px'>
				<input type='text' value='" . $row ['15_3'] . "' name='d15_3' style='width:40px'>
				<input type='text' value='" . $row ['15_4'] . "' name='d15_4' style='width:40px'>
				<input type='text' value='" . $row ['15_5'] . "' name='d15_5' style='width:40px'></td>";
	$contents .= "</tr>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['dhs2'] . "</td>\n";
	$contents .= "<td><input type='text' value='" . $row ['45_1'] . "' name='d45_1' style='width:40px'>
				<input type='text' value='" . $row ['45_2'] . "' name='d45_2' style='width:40px'>
				<input type='text' value='" . $row ['45_3'] . "' name='d45_3' style='width:40px'>
				<input type='text' value='" . $row ['45_4'] . "' name='d45_4' style='width:40px'>
				<input type='text' value='" . $row ['45_5'] . "' name='d45_5' style='width:40px'></td>";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['dthi'] . "</td>\n";
	$contents .= "<td><input type='text' value='" . $row ['thi'] . "' name='thi' style='width:40px'></td>";
	$contents .= "</tr>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['tbm'] . "</td>\n";
	$contents .= "<td><input type='text' value='" . $row ['tbm'] . "' name='tbm' style='width:40px'></td>";
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
	var m_1 = $('input[name=\"m_1\"]').val();
	var m_2 = $('input[name=\"m_2\"]').val();
	var d15_1 = $('input[name=\"d15_1\"]').val();
	var d15_2 = $('input[name=\"d15_2\"]').val();
	var d15_3 = $('input[name=\"d15_3\"]').val();
	var d15_4 = $('input[name=\"d15_4\"]').val();
	var d15_5 = $('input[name=\"d15_5\"]').val();
	var d45_1 = $('input[name=\"d45_1\"]').val();
	var d45_2 = $('input[name=\"d45_2\"]').val();
	var d45_3 = $('input[name=\"d45_3\"]').val();
	var d45_4 = $('input[name=\"d45_4\"]').val();
	var d45_5 = $('input[name=\"d45_5\"]').val();
	var thi = $('input[name=\"thi\"]').val();
	var tbm = $('input[name=\"tbm\"]').val();
	var monid = $('input[name=\"monid\"]').val();
	var lopid = $('input[name=\"lopid\"]').val();
	var mahocky = $('input[name=\"mahocky\"]').val();
	var manamhoc = $('input[name=\"manamhoc\"]').val();
	$('span[name=\"notice\"]').html('<img src=\"../images/load.gif\"> Xin đợi một lát...');
	$.ajax({	
		type: 'POST',
		url: 'index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=adddiem',
		data: 'm_1='+ m_1 + '&m_2='+ m_2 + '&d15_1='+ d15_1 +'&d15_2='+ d15_2 + '&d15_3='+ d15_3 +'&d15_4='+ d15_4 + '&d15_5='+ d15_5 +'&d45_1='+ d45_1 +'&d45_2='+ d45_2 + '&d45_3='+ d45_3 +'&d45_4='+ d45_4 + '&d45_5='+ d45_5 +'&thi='+ thi + '&tbm='+ tbm +'&save=1&id=". $id ."',
		success: function(data){				
			$('input[name=\"confirm\"]').removeAttr('disabled');
			$('span[name=\"notice\"]').html(data);
			window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_diem&monid='+ monid +'&lopid='+ lopid +'&mahocky='+ mahocky +'&manamhoc='+ manamhoc +'';
		}
	});
});
});
</script>
";
}
echo $contents;
?>