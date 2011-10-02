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

$line=0;
$them=0;
$sua=0;
$error="";

if ($nv_Request->isset_request ( 'import1', 'post' )) 
{
	$lopid = $nv_Request->get_int ( 'lopid', 'post' );
	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post' );
	if ($_FILES['ufile1']['tmp_name'] and $lopid > 0 and $manamhoc > 0)
	{
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
			if( $data->val($i,1)!="")
			{
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
					}else {
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
		}
		$contents .= "</table>";
	}else
	{
		if($lopid ==0)
		$error ="lỗi Chưa Chọn Lớp";
		if($manamhoc==0)
		$error ="lỗi Chưa Chọn Năm Học, Bạn cần điền đầy đủ thông tin năm học, lớp học, file mẫu";
		if(empty($_FILES['ufile1']['tmp_name']))
		$error ="lỗi Chưa Chọn file danh sách học sinh";
		
		
	}
	$contents .="<strong style=font-size:16px>". $error." </strong>   <a style='font-size:16px; color:red' href='".NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=import'>Quay Lại</a>";
}


elseif ($nv_Request->isset_request ( 'import2', 'post' ))
{
	$lopid = $nv_Request->get_int ( 'lopid', 'post' );
	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post' );
	$monid = $nv_Request->get_int ( 'monid', 'post' );
	$mahocky = $nv_Request->get_int ( 'mahocky', 'post' );
	if ( $_FILES['ufile2']['tmp_name'] and $lopid > 0 and $manamhoc > 0 and $monid > 0 and $mahocky > 0)  
	{  
		$data = new Spreadsheet_Excel_Reader($_FILES['ufile2']['tmp_name'],true,"UTF-8"); // Đọc file excel, hỗ trợ Unicode UTF-8
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
			if( $data->val($i,1)!="")
			{
				$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_diem` WHERE `mahs`='" . $data->val($i,1)."' AND `lopid` = '" . $lopid."' AND `monid` = '" . $monid."' AND `manamhoc` = '" . $manamhoc."' AND `mahocky` = '" . $mahocky."'";
				$result = $db->sql_query($sql);
				$numrows = $db->sql_numrows($result);
				if(!$numrows)
				{
					
					$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_diem` (`mahs` ,`lopid`, `manamhoc`, `mahocky`, `monid`, `m_1` ,`m_2` ,`15_1` ,`15_2` ,`15_3` ,`15_4` ,`15_5` ,`45_1` ,`45_2` ,`45_3` ,`45_4` ,`45_5` ,`thi` ,`tbm`) VALUES (
					". $db->dbescape ( $data->val($i,1) ) .", 
					". $db->dbescape ( $lopid ) .", 
					". $db->dbescape ( $manamhoc ) .",
					". $db->dbescape ( $mahocky ) .", 
					". $db->dbescape ( $monid ) .", 
					". $db->dbescape ( $data->val($i,2) ) .", 
					". $db->dbescape ( $data->val($i,3) ) .", 
					". $db->dbescape ( $data->val($i,4) ) .", 
					". $db->dbescape ( $data->val($i,5) ) .", 
					". $db->dbescape ( $data->val($i,6) ) .", 
					". $db->dbescape ( $data->val($i,7) ) .", 
					". $db->dbescape ( $data->val($i,8) ) .", 
					". $db->dbescape ( $data->val($i,9) ) .", 
					". $db->dbescape ( $data->val($i,10) ) .", 
					". $db->dbescape ( $data->val($i,11) ) .", 
					". $db->dbescape ( $data->val($i,12) ) .", 
					". $db->dbescape ( $data->val($i,13) ) .", 
					". $db->dbescape ( $data->val($i,14) ) .",  
					". $db->dbescape ( $data->val($i,15) ) .")";
					$db->sql_query( $query );
					$them=$them+1;
				}else
				{
					$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` SET 
					`m_1`=". $db->dbescape ( $data->val($i,2) ) .", 
					`m_2`=". $db->dbescape ( $data->val($i,3) ) .", 
					`15_1`=". $db->dbescape ( $data->val($i,4) ) .", 
					`15_2`=". $db->dbescape ( $data->val($i,5) ) .", 
					`15_3`=". $db->dbescape ( $data->val($i,6) ) .", 
					`15_4`=". $db->dbescape ( $data->val($i,7) ) .", 
					`15_5`=". $db->dbescape ( $data->val($i,8) ) .", 
					`45_1`=". $db->dbescape ( $data->val($i,9) ) .", 
					`45_2`=". $db->dbescape ( $data->val($i,10) ) .", 
					`45_3`=". $db->dbescape ( $data->val($i,11) ) .", 
					`45_4`=". $db->dbescape ( $data->val($i,12) ) .", 
					`45_5`=". $db->dbescape ( $data->val($i,13) ) .", 
					`thi`=". $db->dbescape ( $data->val($i,14) ) .",  
					`tbm`=". $db->dbescape ( $data->val($i,15) ) ."
					WHERE `mahs`=" . $db->dbescape ( $data->val($i,1) ) ."";
					$db->sql_query($sql);
					$sua=$sua+1;			
				}
			}
		}	
	
		$contents .= "</table>";
	}else
	{
		if ($lopid == 0)  
		$error ="Lỗi Chưa Chọn Lớp";
		if( $manamhoc == 0)
		$error ="Lỗi Chưa Chọn Năm Học";
		if ($monid == 0)
		$error ="Lỗi Chưa Chọn Môn";
		if ( $mahocky == 0)
		$error ="Lỗi Chưa Chọn Học Kỳ";
		if(empty($_FILES['ufile2']['tmp_name']))
		$error ="Lỗi Chưa Chọn file Điểm";
		
		
	}
	$contents .="<strong style=font-size:16px>". $error." Cần Chọn Đầy Đủ Thông Tin</strong>";
		
	    
}


elseif ($nv_Request->isset_request ( 'import3', 'post' ))
{

	$lopid = $nv_Request->get_int ( 'lopid', 'post' );
	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post' );
	$mahocky = $nv_Request->get_int ( 'mahocky', 'post' );
	if ( $_FILES['ufile3']['tmp_name'] and $lopid > 0 and $manamhoc > 0 and $mahocky > 0)  
	{ 
		$data = new Spreadsheet_Excel_Reader($_FILES['ufile3']['tmp_name'],true,"UTF-8"); // Đọc file excel, hỗ trợ Unicode UTF-8
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
			if( $data->val($i,1)!="")
			{
				$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE `mahs`='" . $data->val($i,1)."' AND `lopid` = '" . $lopid."' AND `manamhoc` = '" . $manamhoc."' AND `mahocky` = '" . $mahocky."'";
				$result = $db->sql_query($sql);
				$numrows = $db->sql_numrows($result);
				if(!$numrows)
				{
					
					$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` (`mahs` ,`lopid`, `manamhoc`, `mahocky`, `tbm` ,`hl` ,`hk` ,`snncp` ,`snnkp` ,`danhhieu` ,`nxgvcn`) VALUES (
					". $db->dbescape ( $data->val($i,1) ) .", 
					". $db->dbescape ( $lopid ) .", 
					". $db->dbescape ( $manamhoc ) .",
					". $db->dbescape ( $mahocky ) .", 
					". $db->dbescape ( $data->val($i,2) ) .", 
					". $db->dbescape ( $data->val($i,3) ) .", 
					". $db->dbescape ( $data->val($i,4) ) .", 
					". $db->dbescape ( $data->val($i,5) ) .", 
					". $db->dbescape ( $data->val($i,6) ) .", 
					". $db->dbescape ( $data->val($i,7) ) .", 
					". $db->dbescape ( $data->val($i,8) ) .")";
					$db->sql_query( $query );
					$them=$them+1;
				}else
				{

					$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` SET 
					`tbm`=". $db->dbescape ( $data->val($i,2) ) .", 
					`hl`=". $db->dbescape ( $data->val($i,3) ) .", 
					`hk`=". $db->dbescape ( $data->val($i,4) ) .", 
					`snncp`=". $db->dbescape ( $data->val($i,5) ) .", 
					`snnkp`=". $db->dbescape ( $data->val($i,6) ) .", 
					`danhhieu`=". $db->dbescape ( $data->val($i,7) ) .", 
					`nxgvcn`=". $db->dbescape ( $data->val($i,8) ) ."
					WHERE `mahs`=" . $db->dbescape ( $data->val($i,1) ) ."";
					$db->sql_query($sql);
					$sua=$sua+1;			
				}
			}
		}	
		$contents .= "</table>";
	}else
	{
		if(empty($_FILES['ufile3']['tmp_name']))
		$error ="lỗi Chưa Chọn file Xếp Loại Học Sinh";
		if($lopid == 0)
		$error ="lỗi Chưa Chọn Lớp";
		if($manamhoc == 0)
		$error ="lỗi Chưa Chọn Năm Học";
		if($mahocky == 0)
		$error ="lỗi Chưa Chọn Học Kỳ";
	}
	$contents .="<strong style=font-size:16px>". $error." </strong>";	
	   
}


elseif ($nv_Request->isset_request ( 'import4', 'post' )) {
	if ($_FILES['ufile4']['tmp_name'])
	{
		$data = new Spreadsheet_Excel_Reader($_FILES['ufile4']['tmp_name'],true,"UTF-8"); // Đọc file excel, hỗ trợ Unicode UTF-8
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
			if( $data->val($i,1)!="")
			{
				$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` WHERE `gvid`='" . $data->val($i,1)."'";
				$result = $db->sql_query($sql);
				$numrows = $db->sql_numrows($result);
				if(!$numrows)
				{
					
					$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` (`gvid`, `tengv`, `user`, `log`, `chunhiem`, `active`) VALUES (
					". $db->dbescape ( $data->val($i,1) ) .", 
					". $db->dbescape ( $data->val($i,2) ) .", 
					". $db->dbescape ( $data->val($i,3) ) .",
					". $db->dbescape ( $data->val($i,4) ) .", 
					". $db->dbescape ( $data->val($i,5) ) .", 
					". $db->dbescape ( $data->val($i,6) ) .")";
					$db->sql_query( $query );
					$them=$them+1;
				}else
				{

					$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` SET 
					`tengv`=". $db->dbescape ( $data->val($i,2) ) .", 
					`user`=". $db->dbescape ( $data->val($i,3) ) .", 
					`log`=". $db->dbescape ( $data->val($i,4) ) .", 
					`chunhiem`=". $db->dbescape ( $data->val($i,5) ) .", 
					`active`=". $db->dbescape ( $data->val($i,6) ) ."
					WHERE `gvid`=" . $db->dbescape ( $data->val($i,1) ) ."";
					$db->sql_query($sql);
					$sua=$sua+1;			
				}
			}
		}	
	
		$contents .= "</table>";
	}else
	{
		if(empty($_FILES['ufile4']['tmp_name']))
		$error ="lỗi Chưa Chọn file danh sách Giáo Viên";
		
		
	}
	$contents .="<strong style=font-size:16px>". $error." </strong>";

}


elseif ($nv_Request->isset_request ( 'import5', 'post' )) {
	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post' );
	$mahocky = $nv_Request->get_int ( 'mahocky', 'post' );
	if ( $_FILES['ufile5']['tmp_name'] and $manamhoc > 0 and $mahocky > 0)  
	{
		$data = new Spreadsheet_Excel_Reader($_FILES['ufile5']['tmp_name'],true,"UTF-8"); // Đọc file excel, hỗ trợ Unicode UTF-8
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
			if( $data->val($i,1)!="")
			{
				$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_diem` WHERE `mahs`='" . $data->val($i,1)."' AND `lopid` = '" . $data->val($i,2)."' AND `monid` = '" . $data->val($i,3)."' AND `manamhoc` = '" . $manamhoc."' AND `mahocky` = '" . $mahocky."'";
				$result = $db->sql_query($sql);
				$numrows = $db->sql_numrows($result);
				if(!$numrows)
				{
					
					$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_diem` (`mahs` ,`lopid`, `manamhoc`, `mahocky`, `monid`, `m_1` ,`m_2` ,`15_1` ,`15_2` ,`15_3` ,`15_4` ,`15_5` ,`45_1` ,`45_2` ,`45_3` ,`45_4` ,`45_5` ,`thi` ,`tbm`) VALUES (
					". $db->dbescape ( $data->val($i,1) ) .", 
					". $db->dbescape ( $data->val($i,2) ) .", 
					". $db->dbescape ( $manamhoc ) .",
					". $db->dbescape ( $mahocky ) .", 
					". $db->dbescape ( $data->val($i,3) ) .", 
					". $db->dbescape ( $data->val($i,4) ) .", 
					". $db->dbescape ( $data->val($i,5) ) .", 
					". $db->dbescape ( $data->val($i,6) ) .", 
					". $db->dbescape ( $data->val($i,7) ) .", 
					". $db->dbescape ( $data->val($i,8) ) .", 
					". $db->dbescape ( $data->val($i,9) ) .", 
					". $db->dbescape ( $data->val($i,10) ) .", 
					". $db->dbescape ( $data->val($i,11) ) .", 
					". $db->dbescape ( $data->val($i,12) ) .", 
					". $db->dbescape ( $data->val($i,13) ) .", 
					". $db->dbescape ( $data->val($i,14) ) .", 
					". $db->dbescape ( $data->val($i,15) ) .", 
					". $db->dbescape ( $data->val($i,16) ) .",  
					". $db->dbescape ( $data->val($i,17) ) .")";
					$db->sql_query( $query );
					$them=$them+1;
				}else
				{

					$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_diem` SET 
					`m_1`=". $db->dbescape ( $data->val($i,4) ) .", 
					`m_2`=". $db->dbescape ( $data->val($i,5) ) .", 
					`15_1`=". $db->dbescape ( $data->val($i,6) ) .", 
					`15_2`=". $db->dbescape ( $data->val($i,7) ) .", 
					`15_3`=". $db->dbescape ( $data->val($i,8) ) .", 
					`15_4`=". $db->dbescape ( $data->val($i,9) ) .", 
					`15_5`=". $db->dbescape ( $data->val($i,10) ) .", 
					`45_1`=". $db->dbescape ( $data->val($i,11) ) .", 
					`45_2`=". $db->dbescape ( $data->val($i,12) ) .", 
					`45_3`=". $db->dbescape ( $data->val($i,13) ) .", 
					`45_4`=". $db->dbescape ( $data->val($i,14) ) .", 
					`45_5`=". $db->dbescape ( $data->val($i,15) ) .", 
					`thi`=". $db->dbescape ( $data->val($i,16) ) .",  
					`tbm`=". $db->dbescape ( $data->val($i,17) ) ."
					WHERE `mahs`='" . $data->val($i,1)."' 
					AND `lopid` = '" . $data->val($i,2)."' 
					AND `monid` = '" . $data->val($i,3)."' 
					AND `manamhoc` = '" . $manamhoc."' 
					AND `mahocky` = '" . $mahocky."'";
					$db->sql_query($sql);
					$sua=$sua+1;			
				}
			}
		}	
	
		$contents .= "</table>";
	}else
	{
		if( $manamhoc == 0)
		$error ="Lỗi Chưa Chọn Năm Học";
		if ( $mahocky == 0)
		$error ="Lỗi Chưa Chọn Học Kỳ";
		if(empty($_FILES['ufile5']['tmp_name']))
		$error ="Lỗi Chưa Chọn file Điểm";
		
	}
	$contents .="<strong style=font-size:16px>". $error." Cần Chọn Đầy Đủ Thông Tin</strong>";
	
		
}


elseif ($nv_Request->isset_request ( 'import6', 'post' )) {

	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post' );
	if ( $_FILES['ufile6']['tmp_name'] and $manamhoc > 0)  
	{
		$data = new Spreadsheet_Excel_Reader($_FILES['ufile6']['tmp_name'],true,"UTF-8"); // Đọc file excel, hỗ trợ Unicode UTF-8
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
			if( $data->val($i,1)!="")
			{
				$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_diem` WHERE `mahs`='" . $data->val($i,1)."' AND `lopid` = '" . $data->val($i,2)."' AND `mahocky` = '" . $data->val($i,3)."' AND `monid` = '" . $data->val($i,4)."' AND `manamhoc` = '" . $manamhoc."'" ;
				$result = $db->sql_query($sql);
				$numrows = $db->sql_numrows($result);
				if(!$numrows)
				{
					
					$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_diem` (`mahs` ,`lopid`, `manamhoc`, `mahocky`, `monid`, `m_1` ,`m_2` ,`15_1` ,`15_2` ,`15_3` ,`15_4` ,`15_5` ,`45_1` ,`45_2` ,`45_3` ,`45_4` ,`45_5` ,`thi` ,`tbm`) VALUES (
					". $db->dbescape ( $data->val($i,1) ) .", 
					". $db->dbescape ( $data->val($i,2) ) .", 
					". $db->dbescape ( $manamhoc ) .",
					". $db->dbescape ( $data->val($i,3) ) .",  
					". $db->dbescape ( $data->val($i,4) ) .", 
					". $db->dbescape ( $data->val($i,5) ) .", 
					". $db->dbescape ( $data->val($i,6) ) .", 
					". $db->dbescape ( $data->val($i,7) ) .", 
					". $db->dbescape ( $data->val($i,8) ) .", 
					". $db->dbescape ( $data->val($i,9) ) .", 
					". $db->dbescape ( $data->val($i,10) ) .", 
					". $db->dbescape ( $data->val($i,11) ) .", 
					". $db->dbescape ( $data->val($i,12) ) .", 
					". $db->dbescape ( $data->val($i,13) ) .", 
					". $db->dbescape ( $data->val($i,14) ) .", 
					". $db->dbescape ( $data->val($i,15) ) .", 
					". $db->dbescape ( $data->val($i,16) ) .",  
					". $db->dbescape ( $data->val($i,17) ) .",  
					". $db->dbescape ( $data->val($i,18) ) .")";
					$db->sql_query( $query );
					$them=$them+1;
				}else
				{

					$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_diem` SET 
					`m_1`=". $db->dbescape ( $data->val($i,5) ) .", 
					`m_2`=". $db->dbescape ( $data->val($i,6) ) .", 
					`15_1`=". $db->dbescape ( $data->val($i,7) ) .", 
					`15_2`=". $db->dbescape ( $data->val($i,8) ) .", 
					`15_3`=". $db->dbescape ( $data->val($i,9) ) .", 
					`15_4`=". $db->dbescape ( $data->val($i,10) ) .", 
					`15_5`=". $db->dbescape ( $data->val($i,11) ) .", 
					`45_1`=". $db->dbescape ( $data->val($i,12) ) .", 
					`45_2`=". $db->dbescape ( $data->val($i,13) ) .", 
					`45_3`=". $db->dbescape ( $data->val($i,14) ) .", 
					`45_4`=". $db->dbescape ( $data->val($i,15) ) .", 
					`45_5`=". $db->dbescape ( $data->val($i,16) ) .", 
					`thi`=". $db->dbescape ( $data->val($i,17) ) .",  
					`tbm`=". $db->dbescape ( $data->val($i,18) ) ."
					WHERE `mahs`='" . $data->val($i,1)."' 
					AND `lopid` = '" . $data->val($i,2)."' 
					AND `mahocky` = '" . $data->val($i,3)."' 
					AND `monid` = '" . $data->val($i,4)."' 
					AND `manamhoc` = '" . $manamhoc."'" ;
					$db->sql_query($sql);
					$sua=$sua+1;			
				}
			}
		}	
	
		$contents .= "</table>";
	}else
	{
		if( $manamhoc == 0)
		$error ="Lỗi Chưa Chọn Năm Học";
		if ( $mahocky == 0)
		$error ="Lỗi Chưa Chọn Học Kỳ";
		if(empty($_FILES['ufile6']['tmp_name']))
		$error ="Lỗi Chưa Chọn file Điểm";
		
	}
	$contents .="<strong style=font-size:16px>". $error." Cần Chọn Đầy Đủ Thông Tin</strong>";
	
		
}


elseif ($nv_Request->isset_request ( 'import7', 'post' )) {

	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post' );
	$mahocky = $nv_Request->get_int ( 'mahocky', 'post' );
	if ( $_FILES['ufile7']['tmp_name'] and $manamhoc > 0 and $mahocky > 0)  
	{  
	    $data = new Spreadsheet_Excel_Reader($_FILES['ufile7']['tmp_name'],true,"UTF-8"); // Đọc file excel, hỗ trợ Unicode UTF-8
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
			if( $data->val($i,1)!="")
			{
				$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE `mahs`='" . $data->val($i,1)."' AND `lopid` = '" . $data->val($i,2)."' AND `manamhoc` = '" . $manamhoc."' AND `mahocky` = '" . $mahocky."'";
				$result = $db->sql_query($sql);
				$numrows = $db->sql_numrows($result);
				if(!$numrows)
				{
					
					$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` (`mahs` ,`lopid`, `manamhoc`, `mahocky`, `tbm` ,`hl` ,`hk` ,`snncp` ,`snnkp` ,`danhhieu` ,`nxgvcn`) VALUES (
					". $db->dbescape ( $data->val($i,1) ) .", 
					". $db->dbescape ( $data->val($i,2) ) .", 
					". $db->dbescape ( $manamhoc ) .",
					". $db->dbescape ( $mahocky ) .", 
					". $db->dbescape ( $data->val($i,3) ) .", 
					". $db->dbescape ( $data->val($i,4) ) .", 
					". $db->dbescape ( $data->val($i,5) ) .", 
					". $db->dbescape ( $data->val($i,6) ) .", 
					". $db->dbescape ( $data->val($i,7) ) .", 
					". $db->dbescape ( $data->val($i,8) ) .", 
					". $db->dbescape ( $data->val($i,9) ) .")";
					$db->sql_query( $query );
					$them=$them+1;
				}else
				{

					$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` SET 
					`tbm`=". $db->dbescape ( $data->val($i,3) ) .", 
					`hl`=". $db->dbescape ( $data->val($i,4) ) .", 
					`hk`=". $db->dbescape ( $data->val($i,5) ) .", 
					`snncp`=". $db->dbescape ( $data->val($i,6) ) .", 
					`snnkp`=". $db->dbescape ( $data->val($i,7) ) .", 
					`danhhieu`=". $db->dbescape ( $data->val($i,8) ) .", 
					`nxgvcn`=". $db->dbescape ( $data->val($i,9) ) ."
					WHERE `mahs`=" . $db->dbescape ( $data->val($i,1) ) ."";
					$db->sql_query($sql);
					$sua=$sua+1;			
				}
			}
		}	
		$contents .= "</table>";
	}else
	{
		if(empty($_FILES['ufile7']['tmp_name']))
		$error ="lỗi Chưa Chọn file Xếp Loại Học Sinh";
		if($manamhoc == 0)
		$error ="lỗi Chưa Chọn Năm Học";
		if($mahocky == 0)
		$error ="lỗi Chưa Chọn Học Kỳ";
	}
	$contents .="<strong style=font-size:16px>". $error." </strong>";	
	   
}


elseif ($nv_Request->isset_request ( 'import8', 'post' )) {

	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post' );
	if ( $_FILES['ufile8']['tmp_name'] and $manamhoc > 0)  
	{  
	    $data = new Spreadsheet_Excel_Reader($_FILES['ufile8']['tmp_name'],true,"UTF-8"); // Đọc file excel, hỗ trợ Unicode UTF-8
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
			if( $data->val($i,1)!="")
			{
				$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE `mahs`='" . $data->val($i,1)."' AND `lopid` = '" . $data->val($i,2)."' AND `mahocky` = '" . $data->val($i,3)."'  AND `manamhoc` = '" . $manamhoc."'";
				$result = $db->sql_query($sql);
				$numrows = $db->sql_numrows($result);
				if(!$numrows)
				{
					
					$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` (`mahs` ,`lopid`, `manamhoc`, `mahocky`, `tbm` ,`hl` ,`hk` ,`snncp` ,`snnkp` ,`danhhieu` ,`nxgvcn`) VALUES (
					". $db->dbescape ( $data->val($i,1) ) .", 
					". $db->dbescape ( $data->val($i,2) ) .", 
					". $db->dbescape ( $manamhoc ) .",
					". $db->dbescape ( $data->val($i,3) ) .",
					". $db->dbescape ( $data->val($i,4) ) .", 
					". $db->dbescape ( $data->val($i,5) ) .", 
					". $db->dbescape ( $data->val($i,6) ) .", 
					". $db->dbescape ( $data->val($i,7) ) .", 
					". $db->dbescape ( $data->val($i,8) ) .", 
					". $db->dbescape ( $data->val($i,8) ) .", 
					". $db->dbescape ( $data->val($i,10) ) .")";
					$db->sql_query( $query );
					$them=$them+1;
				}else
				{

					$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` SET 
					`tbm`=". $db->dbescape ( $data->val($i,4) ) .", 
					`hl`=". $db->dbescape ( $data->val($i,5) ) .", 
					`hk`=". $db->dbescape ( $data->val($i,6) ) .", 
					`snncp`=". $db->dbescape ( $data->val($i,7) ) .", 
					`snnkp`=". $db->dbescape ( $data->val($i,8) ) .", 
					`danhhieu`=". $db->dbescape ( $data->val($i,9) ) .", 
					`nxgvcn`=". $db->dbescape ( $data->val($i,10) ) ."
					WHERE `mahs`=" . $db->dbescape ( $data->val($i,1) ) ."";
					$db->sql_query($sql);
					$sua=$sua+1;			
				}
			}
		}	
		$contents .= "</table>";
	}else
	{
		if(empty($_FILES['ufile8']['tmp_name']))
		$error ="lỗi Chưa Chọn file Xếp Loại Học Sinh";
		if($manamhoc == 0)
		$error ="lỗi Chưa Chọn Năm Học";

	}
	$contents .="<strong style=font-size:16px>". $error." </strong>";	
	   
}


else
{


$contents .= "<table summary=\"\" class=\"tab1\">\n";
$contents .= "<td><center><b><font color=blue size=3>" . $lang_module['import_tdds'] . "</font></b></center></td>\n";
$contents .= "</table>";

$contents .= "<div><form action=\"".NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=import\" enctype=\"multipart/form-data\" id=\"form1\" name=\"form1\" method=\"post\">
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
	</form></div>
		
	<div><form enctype=\"multipart/form-data\" id=\"form4\" name=\"form4\" method=\"post\"><center>
	<table class=\"tab1\">
	<tr>
		<td class=\"fr\"  width=\"220\"  align = \"left\">". $lang_module ['impdsgv_title'] . "</td>
		<td class=\"fr1\"  align = \"left\">
		<input type=\"file\" name=\"ufile4\" size = \"35\" id=\"ufile4\"/>
		<input type=\"submit\" name=\"import4\" id=\"import4\" value=\"Import\" /></td>
	</tr>
</table>
</form></div>";
		
	$contents .= "<table summary=\"\" class=\"tab1\">\n";
	$contents .= "<td><center><b><font color=blue size=3>" . $lang_module['import_tddiem'] . "</font></b></center></td>\n";
	$contents .= "</table>";
	
	$contents .= "<div><form enctype=\"multipart/form-data\" id=\"form2\" name=\"form2\" method=\"post\"><center>
	<table class=\"tab1\">
	<tr>
		<td class=\"fr\"  width=\"220\" align = \"left\">". $lang_module ['import_diem'] . "</td>
		<td class=\"fr1\"  align = \"left\">";
		
		// Chon lop
		$contents .= "<select name = \"lopid\">
		<option value=\"0\" size = \"50\">&nbsp;Chọn lớp</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop`";
		$result = $db->sql_query( $sql);
		while ($dslop = $db->sql_fetchrow($result))
		{
			$contents .= "<option value=\"$dslop[0]\">&nbsp;$dslop[1]</option>";
		}
		$contents .= "</select>&nbsp;&nbsp;";
		
		// Chon mon hoc
		$contents .= "<select name = \"monid\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn môn học</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_monhoc`";
		$result = $db->sql_query( $sql);
		while ($monhoc = $db->sql_fetchrow($result))
		{
			$contents .= "<option value=\"$monhoc[0]\">&nbsp;$monhoc[1]</option>";
		}
		$contents .= "</select>&nbsp;&nbsp;";

		// Chon hoc ki
		$contents .= "<select name = \"mahocky\">";
		$contents .= "<option value=\"0\" size = \"60\">&nbsp;Chọn học kì</option>";
		$hocki = array(1 => 'Học kì I', 2 => 'Học kì II');
		For ($i = 1; $i <= 2; $i ++)
		{
			$contents .= "<option value=\"$i\">&nbsp;$hocki[$i]</option>";
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
		<input type=\"file\" name=\"ufile2\" size = \"35\" id=\"ufile2\"/>
		<input type=\"submit\" name=\"import2\" id=\"import2\" value=\"Import\" /></td>
	</tr>
	</table></center>
	</form></div>
	
	<div><form enctype=\"multipart/form-data\" id=\"form5\" name=\"form5\" method=\"post\"><center>
	<table class=\"tab1\">
	<tr>
		<td class=\"fr\"  width=\"220\" align = \"left\">". $lang_module ['import_diem2'] . "</td>
		<td class=\"fr1\"  align = \"left\">";
		// Chon hoc ki
		$contents .= "<select name = \"mahocky\">";
		$contents .= "<option value=\"0\" size = \"60\">&nbsp;Chọn học kì</option>";
		$hocki = array(1 => 'Học kì I', 2 => 'Học kì II');
		For ($i = 1; $i <= 2; $i ++)
		{
			$contents .= "<option value=\"$i\">&nbsp;$hocki[$i]</option>";
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
		<input type=\"file\" name=\"ufile5\" size = \"35\" id=\"ufile5\"/>
		<input type=\"submit\" name=\"import5\" id=\"import5\" value=\"Import\" /></td>
	</tr>
	</table></center>
	</form></div>
	
	<div><form enctype=\"multipart/form-data\" id=\"form6\" name=\"form6\" method=\"post\"><center>
	<table class=\"tab1\">
	<tr>
		<td class=\"fr\"  width=\"220\" align = \"left\">". $lang_module ['import_diem3'] . "</td>
		<td class=\"fr1\"  align = \"left\">";
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
		<input type=\"file\" name=\"ufile6\" size = \"35\" id=\"ufile6\"/>
		<input type=\"submit\" name=\"import6\" id=\"import6\" value=\"Import\" /></td>
	</tr>
	</table></center>
	</form></div>";
		
	$contents .= "<table summary=\"\" class=\"tab1\">\n";
	$contents .= "<td><center><b><font color=blue size=3>" . $lang_module['import_tdxl'] . "</font></b></center></td>\n";
	$contents .= "</table>";

	$contents .= "<div><form enctype=\"multipart/form-data\" id=\"form3\" name=\"form3\" method=\"post\"><center>
	<table class=\"tab1\">
	<tr>
		<td class=\"fr\"  width=\"220\"  align = \"left\">". $lang_module ['import_xeploai_lop'] . "</td>
		<td class=\"fr1\"  align = \"left\">";
		// Chon nam hoc
		$contents .= "<select name = \"lopid\">
		<option value=\"0\" size = \"50\">&nbsp;Chọn lớp</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop`";
		$result = $db->sql_query( $sql);
		while ($dslop = $db->sql_fetchrow($result))
		{
			$contents .= "<option value=\"$dslop[0]\">&nbsp;$dslop[1]</option>";
		}
		$contents .= "</select>&nbsp;&nbsp;";
		// Chon hoc ki
		$contents .= "<select name = \"mahocky\">";
		$contents .= "<option value=\"0\" size = \"60\">&nbsp;Chọn học kì</option>";
		$hocki = array(1 => 'Học kì I', 2 => 'Học kì II', 3 => 'Cả năm');
		For ($i = 1; $i <= 3; $i ++)
		{
			$contents .= "<option value=\"$i\">&nbsp;$hocki[$i]</option>";
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
		<input type=\"file\" name=\"ufile3\" size = \"35\" id=\"ufile3\"/>
		<input type=\"submit\" name=\"import3\" id=\"import3\" value=\"Import\" /></td>
	</tr>
	</table>
	</form></div>
		
	<div><form enctype=\"multipart/form-data\" id=\"form7\" name=\"form7\" method=\"post\"><center>
	<table class=\"tab1\">
	<tr>
		<td class=\"fr\"  width=\"220\"  align = \"left\">". $lang_module ['import_xeploai_hk'] . "</td>
		<td class=\"fr1\"  align = \"left\">";
		// Chon hoc ki
		$contents .= "<select name = \"mahocky\">";
		$contents .= "<option value=\"0\" size = \"60\">&nbsp;Chọn học kì</option>";
		$hocki = array(1 => 'Học kì I', 2 => 'Học kì II', 3 => 'Cả năm');
		For ($i = 1; $i <= 3; $i ++)
		{
			$contents .= "<option value=\"$i\">&nbsp;$hocki[$i]</option>";
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
		<input type=\"file\" name=\"ufile7\" size = \"35\" id=\"ufile7\"/>
		<input type=\"submit\" name=\"import7\" id=\"import7\" value=\"Import\" /></td>
	</tr>
	</table>
	</form></div>
		
	<div><form enctype=\"multipart/form-data\" id=\"form8\" name=\"form8\" method=\"post\"><center>
	<table class=\"tab1\">
	<tr>
		<td class=\"fr\"  width=\"220\"  align = \"left\">". $lang_module ['import_xeploai_nam'] . "</td>
		<td class=\"fr1\"  align = \"left\">";
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
		<input type=\"file\" name=\"ufile8\" size = \"35\" id=\"ufile8\"/>
		<input type=\"submit\" name=\"import8\" id=\"import8\" value=\"Import\" /></td>
	</tr>
</table>
</form></div><br>";
}

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents );
include (NV_ROOTDIR . "/includes/footer.php");
?>
