<?php

/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$page_title = $lang_module['quanli_xl'];
	$lopid = $nv_Request->get_int ( 'lopid', 'post' );
	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post' );
	$mahocky = $nv_Request->get_int ( 'mahocky', 'post' );
	
	if (!empty($lopid) and !empty($manamhoc)){
	// Hien thi hop lua chon
	$contents .= "<div>";
    $contents .= "<form name=\"deltkb\" action=\"\" method=\"post\">";
    $contents .= "<table summary=\"\" class=\"tab1\">\n";
    $contents .= "<td>";
    $contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['quanli_xl_td'] . "</font></b></center>";
    $contents .= "</td>\n";
    $contents .= "</table>";
	$contents .= "</form>";
    $contents .= "</div>";
		// Chon lop
		$contents .= "<form name=\"chon_ds\" method=\"post\">";
		$contents .= "<table summary=\"\" class=\"tab1\">\n";
		$contents .= "<td align = \"center\">";
		$contents .= "<select name = \"lopid\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn lớp</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop`";
		$result = $db->sql_query( $sql);
		while ($dslop = $db->sql_fetchrow($result))
		{
			if ($lopid == $dslop[0]){
				$tenlop = $dslop[1];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= "<option value=\"$dslop[0]\" ". $sel .">&nbsp;$dslop[1]</option>";
		}
		$contents .= "</select>&nbsp;&nbsp;";
		// Chon hoc ki
		$contents .= "<select name = \"mahocky\">";
		$contents .= "<option value=\"0\" size = \"60\">&nbsp;Chọn học kì</option>";
		$hocki = array(1 => 'Học kì I', 2 => 'Học kì II', 3 => 'Cả năm');
		For ($i = 1; $i <= 3; $i ++)
		{
			if ($mahocky == $i){
				$tenhk = $hocki[$i];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= "<option value=\"$i\" ". $sel .">&nbsp;$hocki[$i]</option>";
		}
		$contents .= "</select>&nbsp;&nbsp;";
		
		// Chon nam hoc
		$contents .= "<select name = \"manamhoc\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn năm học</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc`";
		$result = $db->sql_query( $sql);
		while ($namhoc = $db->sql_fetchrow($result))
		{
			if ($manamhoc == $namhoc[0]){
				$tennamhoc = $namhoc[1];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= "<option value=\"$namhoc[0]\" ".$sel.">&nbsp;$namhoc[1]</option>";
		}
		$contents .= "</select>";
		
		$contents .= "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value = \"" . $lang_module['thuchien'] . "\" /></center>";
		$contents .= "</td>\n";
		$contents .= "</table>";
		$contents .= "</form>";
		// Het hop lua chon
		$contents .= "<div>";
	    $contents .= "<form>";
	    $contents .= "<table summary=\"\" class=\"tab1\">\n";
	    $contents .= "<td>";
	    $contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['dsxl_td'] . "".$tenlop."<br />" . $lang_module['namhoc_td'] ."".$tennamhoc."</font></b></center>";
	    $contents .= "</td>\n";
	    $contents .= "</table>";
		$contents .= "</form>";
	    $contents .= "</div>";

		$sql = "SELECT DISTINCT " . NV_PREFIXLANG . "_" . $module_data . "_xeploai.id," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.mahs," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.lopid," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.manamhoc," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.mahocky," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.tbm," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.hl," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.hk," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.snncp," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.snnkp," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.danhhieu," . NV_PREFIXLANG . "_" . $module_data . "_xeploai.nxgvcn," . NV_PREFIXLANG . "_" . $module_data . "_dshs.hoten FROM " . NV_PREFIXLANG . "_" . $module_data . "_xeploai," . NV_PREFIXLANG . "_" . $module_data . "_dshs WHERE " . NV_PREFIXLANG . "_" . $module_data . "_xeploai.lopid = ".$lopid." AND " . NV_PREFIXLANG . "_" . $module_data . "_xeploai.manamhoc = ".$manamhoc." AND " . NV_PREFIXLANG . "_" . $module_data . "_xeploai.mahocky = ".$mahocky." AND " . NV_PREFIXLANG . "_" . $module_data . "_xeploai.mahs = " . NV_PREFIXLANG . "_" . $module_data . "_dshs.mahs ORDER BY " . NV_PREFIXLANG . "_" . $module_data . "_xeploai.mahs ASC";

		//$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE `lopid`=".$lopid." AND `manamhoc`=".$manamhoc."";
		$result = $db->sql_query( $sql);
		$contents .= "<table class=\"tab1\">\n";
		$contents .= "<thead>\n";
		$contents .= "<tr>\n";
		$contents .= "<td align='center' rowspan = '2'>" . $lang_module ['stt'] . "</td>\n";
		$contents .= "<td align='center' rowspan = '2' width = '8%'>Mã học<br /> sinh</td>\n";
		$contents .= "<td align='center' rowspan = '2'>" . $lang_module ['hoten'] . "</td>\n";
		$contents .= "<td align='center' rowspan = '2'>" . $lang_module ['tbm'] . "</td>\n";
		$contents .= "<td align='center' rowspan = '2'>" . $lang_module ['hl'] . "</td>\n";
		$contents .= "<td align='center' rowspan = '2'>" . $lang_module ['hk'] . "</td>\n";
		$contents .= "<td align='center' colspan = '2'>" . $lang_module ['snn'] . "</td>\n";
		$contents .= "<td align='center' rowspan = '2'>" . $lang_module ['danhhieu'] . "</td>\n";
		$contents .= "<td align='center' rowspan = '2'>" . $lang_module ['quanli'] . "</td>\n";
		$contents .= "</tr>\n";
		
		$contents .= "<tr>\n";
		$contents .= "<td align='center' width = '5%'>CP</td>\n";
		$contents .= "<td align='center' width = '5%'>KP</td>\n";
		$contents .= "</tr>\n";
		
		$contents .= "</thead>\n";
		$gtinh = array(0 => 'Nữ', 1 => 'Nam');
		$a = 0;
		while ($dsxl = $db->sql_fetchrow($result))
		{
			$class = ($a % 2) ? " class=\"second\"" : "";
			$contents .= "<tbody" . $class . ">\n";
			$contents .= "<tr>\n";
			$contents .= "<td align=\"center\">" . ++$a . "</td>\n";
			$contents .= "<td align=\"center\">" . $dsxl ['mahs']."</td>\n";
			$contents .= "<td align=\"left\">" . $dsxl ['hoten']."</td>\n";
			$contents .= "<td align=\"center\">" . $dsxl ['tbm']."</td>\n";
			$contents .= "<td align=\"center\">" . $dsxl ['hl']."</td>\n";
			$contents .= "<td align=\"center\">" . $dsxl ['hk']."</td>\n";
			$contents .= "<td align=\"center\">" . $dsxl ['snncp']."</td>\n";
			$contents .= "<td align=\"center\">" . $dsxl ['snnkp']."</td>\n";
			$contents .= "<td align=\"center\">" . $dsxl ['danhhieu']."</td>\n";
			$contents .= "<td align=\"center\">";
			$contents .= "<span class=\"edit_icon\"><a class='edit' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addxl&amp;id=" . $dsxl ['id'] . "\">" . $lang_global ['edit'] . "</a></span>\n";
			$contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a class='del' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=delxl&amp;id=" . $dsxl ['id'] . "\">" . $lang_global ['delete'] . "</a></span></td>\n";
			$contents .= "</tr>\n";
			$contents .= "</tbody>\n";
		}
	$contents .= "<tfoot><tr><td colspan='10'><span class=\"add_icon\"><a class='khoitao' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=khoitaoxl&amp;lopid=" . $lopid . "&amp;manamhoc=" . $manamhoc . "&amp;mahocky=" . $mahocky . "\">" . $lang_module ['khoitao'] . "</a></span></td></tr></tfoot>";
	$contents .= "</table>\n";
	$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";
	// Het hien thi danh sach
	$contents .= "<div id='contentedit'></div><input id='hasfocus' style='width:0px;height:0px'/>";
	$contents .= "
	<script type='text/javascript'>
	$(function(){
	$('a[class=\"add\"]').click(function(event){
		event.preventDefault();
		var href= $(this).attr('href');
		$('#contentedit').load(href,function(){
			$('#hasfocus').focus();
		});

	});
	$('a[class=\"edit\"]').click(function(event){
		event.preventDefault();
		var href= $(this).attr('href');
		$('#contentedit').load(href,function(){
			$('#hasfocus').focus();
		});
	});
	$('a[class=\"del\"]').click(function(event){
		event.preventDefault();
		var href= $(this).attr('href');
		if (confirm('".$lang_module['delxl_del_confirm']."')){
			$.ajax({	
				type: 'POST',
				url: href,
				data: '',
				success: function(data){				
					alert(data);
					window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_xl&lopid='+ lopid +'&mahocky='+ mahocky +'&manamhoc='+ manamhoc +'';
				}
			});
		}
	});
		$('a[class=\"khoitao\"]').click(function(event){
		event.preventDefault();
		var href= $(this).attr('href');
		if (confirm('".$lang_module['khoitaoxl_confirm']."')){
			$.ajax({	
				type: 'POST',
				url: href,
				data: '',
				success: function(data){				
					alert(data);
					window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_xl&lopid='+ lopid +'&mahocky='+ mahocky +'&manamhoc='+ manamhoc +'';
				}
			});
		}
	});	
	});
	</script>
	";

	}else {
	$contents .= "<div>";
    $contents .= "<form name=\"deltkb\" action=\"\" method=\"post\">";
    $contents .= "<table summary=\"\" class=\"tab1\">\n";
    $contents .= "<td>";
    $contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['quanli_xl_td'] . "</font></b></center>";
    $contents .= "</td>\n";
    $contents .= "</table>";
	$contents .= "</form>";
    $contents .= "</div>";
		// Chon lop
		$contents .= "<form name=\"chon_ds\" method=\"post\">";
		$contents .= "<table summary=\"\" class=\"tab1\">\n";
		$contents .= "<td align = \"center\">";
		$contents .= "<select name = \"lopid\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn lớp</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop`";
		$result = $db->sql_query( $sql);
		while ($dslop = $db->sql_fetchrow($result))
		{
			if ($lopid == $dslop[0]){
				$tenlop = $dslop[1];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= "<option value=\"$dslop[0]\" ". $sel .">&nbsp;$dslop[1]</option>";
		}
		$contents .= "</select>&nbsp;&nbsp;";
		// Chon hoc ki
		$contents .= "<select name = \"mahocky\">";
		$contents .= "<option value=\"0\" size = \"60\">&nbsp;Chọn học kì</option>";
		$hocki = array(1 => 'Học kì I', 2 => 'Học kì II', 3 => 'Cả năm');
		For ($i = 1; $i <= 3; $i ++)
		{
			if ($mahocky == $i){
				$tenhk = $hocki[$i];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= "<option value=\"$i\" ". $sel .">&nbsp;$hocki[$i]</option>";
		}
		$contents .= "</select>&nbsp;&nbsp;";

		// Chon nam hoc
		$contents .= "<select name = \"manamhoc\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn năm học</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc`";
		$result = $db->sql_query( $sql);
		while ($namhoc = $db->sql_fetchrow($result))
		{
			if ($manamhoc == $namhoc[0]){
				$tennamhoc = $namhoc[1];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= "<option value=\"$namhoc[0]\" ".$sel.">&nbsp;$namhoc[1]</option>";
		}
		$contents .= "</select>";
		
		$contents .= "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value = \"" . $lang_module['thuchien'] . "\" /></center>";
		$contents .= "</td>\n";
		$contents .= "</table>";
		$contents .= "</form>";
    }
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>