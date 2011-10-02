<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */
if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );
$save = $nv_Request->get_int ( 'save', 'post' );
$impdsgv = filter_text_input ( 'impdsgv', 'post','', 1);
if ($save == 1 and isset($impdsgv)){
	$data = array();  
	$contents .= "". $_FILES['impdsgv']['tmp_name'] ."Chua nap duoc du lieu".$impdsgv;

	if ( $_FILES['impdsgv']['tmp_name'])  
	{  
		$contents .= $_FILES['impdsgv']['tmp_name'] ."OK, thế là xong ".$impdsgv;

	    $dom = DOMDocument::load( $_FILES['impdsgv']['tmp_name'] );  
	    $rows = $dom->getElementsByTagName( 'Row' );  
		$tde=array();
		$line=0;
		$them=0;
		$sua=0;
		foreach ($rows as $row){ 
		$cells = $row->getElementsByTagName( 'Cell' );  
		$datarow = array();  
			foreach ($cells as $cell){  
	     		if ($line==0){
	        		$tde[]=$cell->nodeValue;
	     		}else{
	     			$datarow []= $cell->nodeValue;
	     		} 
		 	}  
		$data []= $datarow;  
		$line=$line+1;      
		}
//
	foreach( $data as $row ) {  
		$dscb=array();
		$i=0;
		if (isset($row[0])){
		foreach( $row as $item ) {
		//chen vo CSDL
			$dscb[$i]=$item;
			$i=$i+1;	
		} 
		
	   if( $dscb[0]!="" and $dscb[1]!="") {
	   	$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` WHERE `gvid`='" . $dscb[0]."'";
		$result = $db->sql_query($sql);
		$numrows = $db->sql_numrows($result);
		if(!$numrows) {
	   	$sql1 = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` (`gvid`, `tengv`, `user`, `log`, `chunhiem`, `active`) VALUES ('".$dscb[0]."', '".$dscb[1]."', '".$dscb[2]."', '".$dscb[3]."', '".$dscb[4]."', '".$dscb[5]."')";
			$result = $db->sql_query($sql1) or die ('Đã có lỗi xảy ra trong quá trình thêm danh sách giáo viên.<br />');
			$them=$them+1;
		}else{
		$sql2 = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` SET `tengv`='".$dscb[1]."', `user`='".$dscb[2]."', `log`='".$dscb[3]."', `chunhiem`='".$dscb[4]."' , `active`='".$dscb[5]."' WHERE `gvid`='".$dscb[0]."'";
		$db->sql_query($sql2) or die ('Đã có lỗi xảy ra trong quá trình cập nhật danh sách giáo viên.<br />');
		$sua=$sua+1;
		}
		}
		}  
	}
	$line=$line-1;
	//Hien thi thong bao sau khi import
	$contents .= "<div class=\"quote\" style=\"width:780px;\">\n";
    $contents .= "<blockquote class=\"error\"><span>" . $lang_module['import_success'] . "</span></blockquote>\n";
    $contents .= "</div><br>";
    $contents .= "<div class=\"clear\"></div>\n";
    $contents .= "<div id=\"list_mods\"
	<form id=\"form\" name=\"form\" method=\"post\">
	<table class=\"tab1\">
	<tr>
		<td class=\"fr\">" . $lang_module['line'] . "" . $line. "<br></td>
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

}else {
	$contents .= "<form action=\"importgv.php\" enctype=\"multipart/form-data\" method=\"post\">";
	$contents .= "<table class=\"tab1\" style='width:500px'>\n";
	$contents .= "<thead>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan=\"2\">" . $lang_module ['impdsgv_title'] . "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</thead>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['impdsgv_xml'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type=\"file\" name=\"impdsgv\" size = \"35\" id=\"impdsgv\"/>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan='2' style='padding-left:100px'>";
	$contents .= "<span name='notice' style='float:right;padding-right:50px;color:red;font-weight:bold'></span>";
	$contents .= "<input type='button' name='confirm' value='" . $lang_module ['thuchien'] . "'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	
	$contents .= "</table>\n";
	$contents .= "</form>";
	$contents .= "
		<script type='text/javascript'>
		$(function(){
		$('input[name=\"confirm\"]').click(function(){
			var impdsgv = $('input[name=\"impdsgv\"]').val();
			if (impdsgv==''){
				alert('" . $lang_module ['impdsgv_error_code'] . "');
				$('input[name=\"impdsgv\"]').focus();
				return false;
			}
			$('span[name=\"notice\"]').html('<img src=\"../images/load.gif\"> Xin đợi một lát...');
			$.ajax({	
				type: 'POST',
				url: 'index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=importgv',
				data: 'impdsgv='+ impdsgv + '&save=1',
				success: function(data){				
					$('input[name=\"confirm\"]').removeAttr('disabled');
					$('span[name=\"notice\"]').html(data);
					window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_dsgv';
				}
			});
		});
		});
		</script>";
}
echo $contents;
?>
