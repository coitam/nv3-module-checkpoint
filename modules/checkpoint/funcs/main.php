<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */
 
if ( ! defined( 'NV_IS_MOD_CHECKPOINT' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];
//Doc du lieu tu file cau hinh
include (NV_ROOTDIR . "/includes/class/geturl.class.php");
$code = filter_text_input ( 'keywords', 'post,get','', 1);
$hkid = $nv_Request->get_int ( 'hkid', 'post,get' );
$namid = $nv_Request->get_int ( 'namid', 'post,get' );
$findtype= $nv_Request->get_int( 'findtype', 'post,get');
$kqsearch = array(1 => $code, 2 => $hkid, 3 => $namid, 4 => $findtype);
$data = file_get_contents ( NV_ROOTDIR . '/modules/tradiem/config.txt' );
$ext = explode ( '|', $data );
$script ='
	<script type="text/javascript">
	$("#button_submit").click(function(){
		$("#result").html("<img src=\''.NV_BASE_SITEURL.'images/load_bar.gif\'/>");
		var code = $("#keyword").val();
		if (code==""){
			alert("Hãy nhập tên hoặc mã học sinh cần tra cứu");
			$("#keyword").focus();
			return false;
		}
		var hkid = $("#hkid").val();
		if (hkid==0){
			alert("Hãy chọn học kì cần tra");
			$("#hkid").focus();
			return false;
		}
		var namid = $("#namid").val();
		if (namid==0){
			alert("Hãy chọn năm học cần tra");
			$("#namid").focus();
			return false;
		}
		$.ajax({	
			type: "POST",
			url: "' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main",
			data: "code="+ code +"&hkid="+ hkid +"&namid="+ namid +"&findtype="+ findtype
		});
	});
	</script>';
//Loc danh sach nam hoc
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_namhoc ORDER BY manamhoc ASC";
$result = $db->sql_query( $sql );
$namhoc = array();
while ($row = mysql_fetch_array($result))
{
    $namhoc[]=$row;
}
if ($hkid > 0 and $code != ""){
	$content = array();
	if ($findtype == 1){
		$sql = "SELECT DISTINCT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE (`hoten` LIKE '%$code' AND `manamhoc` = '$namid')";
		$result = $db->sql_query( $sql );
	}elseif ($findtype == 2){
		$sql = "SELECT DISTINCT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE (`mahs` LIKE '$code%'  AND `manamhoc` = '$namid')";
		$result = $db->sql_query( $sql );
	}
	$num = mysql_num_rows($result);
	while ($rows = mysql_fetch_row($result))
	{
    	$content[] = $rows;
	}
	// Neu khong co trong danh sach hoc sinh
	if ($num == 0){
		$contents = theme_main( $namhoc, $ext, $script);
	} elseif ($num == 1){
		// Ma hoc sinh
		$mahs = $content[0][1];
		$lopid = $content[0][3];
		$lophoc = array();
		// Loc danh sach cac lop hoc
		$sql = "SELECT DISTINCT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop";
		$result = $db->sql_query( $sql );
		while ($rows = mysql_fetch_row($result))
		{
	    	$lophoc[$rows[0]] = $rows[1];
		}
		// Loc danh sach mon hoc
		$sql = "SELECT DISTINCT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_monhoc`";
		$result = $db->sql_query( $sql );
		$monhoc = array();
		while ($rows = mysql_fetch_row($result))
		{
	    	$monhoc[$rows[0]] = $rows[1];
		}
		// Loc danh sach nam hoc
		$sql = "SELECT DISTINCT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc`";
		$result = $db->sql_query( $sql );
		$namhoc = array();
		while ($rows = mysql_fetch_row($result))
		{
	    	$namhoc[$rows[0]] = $rows[1];
		}
		// Loc xep loai cua hoc sinh
		$sql = "SELECT DISTINCT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE `mahs` = '$mahs' AND `mahocky` = '$hkid'";
		$result = $db->sql_query( $sql );
		$xeploai = array();
		while ($rows = mysql_fetch_row($result))
		{
	    	$xeploai[] = $rows;
		}

		if ($hkid < 3){
		// Loc diem cua hoc sinh
		$diemmh = array();
		$sql = "SELECT DISTINCT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_diem` WHERE `mahs` = '$mahs' AND `manamhoc` = '$namid' AND `mahocky` = '$hkid' AND `lopid` = '$lopid' ORDER BY `monid` ASC";
		$result = $db->sql_query( $sql );
		while ($rows = mysql_fetch_row($result))
		{
	    	$diemmh[] = $rows;
		}
		$contents = viewhk($content, $diemmh, $lophoc, $monhoc, $namhoc, $xeploai, $ext);
		// Neu tra cuu ket qua ca nam
		}elseif ($hkid == 3){
			$diemtb = array();
			// Loc diem trung binh cua cac mon
			$sql = "SELECT `mahocky`,`monid`,`tbm` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_diem` WHERE `mahs` = '$mahs' AND `manamhoc` = '$namid'";
			$result = $db->sql_query( $sql );
			while ($rows = mysql_fetch_row($result))
			{
		    	$diemtb[$rows[0]][$rows[1]] = $rows[2];
			}
			// Loc xep loai cua hoc sinh
			$sql = "SELECT DISTINCT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE `mahs` = '$mahs' AND `manamhoc` = '$namid' ORDER BY `mahocky` ASC";
			$result = $db->sql_query( $sql );
			$xeploaicn = array();
			while ($rows = mysql_fetch_row($result))
			{
		    	$xeploaicn[$rows[4]] = $rows;
			}
			$contents = maincn($content, $diemtb, $xeploaicn, $lophoc, $monhoc, $namhoc, $ext);
		}
	} elseif ($num > 1){
		// Neu nhieu hon mot ket qua tra ve
		// Loc danh sach cac lop hoc
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop";
		$result = $db->sql_query( $sql );
		$lophoc = array();
		while ($rows = mysql_fetch_row($result))
		{
	    	$lophoc[$rows[0]] = $rows[1];
		}
		$contents = mains($content, $lophoc, $namhoc, $ext, $script, $kqsearch);
	}
}else {
	$contents = theme_main( $namhoc, $ext, $script);
}
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>