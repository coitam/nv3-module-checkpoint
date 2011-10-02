<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */

if ( ! defined( 'NV_IS_MOD_CHECKPOINT' ) ) die( 'Stop!!!' );

function theme_main( $namhoc, $ext, $script)
{
    global $global_config, $lang_module, $module_info, $module_name, $module_file, $lang_global;
    $xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/".$module_file."/" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'CAUHINH', $ext );
    $xtpl->assign( 'SCRIPT', $script );
    $hocki = array(1 => 'Học kì I', 2 => 'Học kì II', 3 => 'Cả năm');
    for ($i = 1; $i <=3; $i ++){
 	
    $xtpl->assign( 'MAHK', $i );
    $xtpl->assign( 'TENHK', $hocki[$i]);
    $xtpl->parse('main.block_table.loop_hk');
    }
	if ( ! empty( $namhoc) )
    {
       foreach ( $namhoc as $nhoc){
       $xtpl->assign( 'MANAMHOC', $nhoc[0]);
       $xtpl->assign( 'TENNAMHOC', $nhoc[1]);
       $xtpl->parse('main.block_table.loop_nh');
       }
    }
    $xtpl->parse('main.block_table');
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function viewhk($content, $diemmh, $lophoc, $monhoc, $namhoc, $xeploai, $ext)
{
    global $global_config, $lang_module, $module_info, $module_name, $module_file, $lang_global;
    $xtpl = new XTemplate( "view.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/".$module_file."/" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'CAUHINH', $ext );
    if ( ! empty( $content) )
    {
       foreach ( $content as $thongtin){
			$xtpl->assign( 'MAHS', $thongtin[1] );
			$xtpl->assign( 'NAMHOC', $namhoc[$thongtin[2]] );
			$xtpl->assign( 'LOP', $lophoc[$thongtin[3]] );
			$xtpl->assign( 'HOTEN', $thongtin[4] );
			$xtpl->assign( 'NGSINH', date('d/m/Y',$thongtin[6]));
			$xtpl->assign( 'GTINH', ($thongtin[5] == 0)?'Nữ':'Nam');
			$xtpl->assign( 'NOISINH', $thongtin[7] );
	   }
	}
    if ( ! empty( $xeploai) )
    {
       foreach ( $xeploai as $xl){
			$xtpl->assign( 'XEPLOAI', $xl );
			$xtpl->assign( 'KY', $xl[4] );
			$xtpl->assign( 'TONG', intval($xl[8]) + intval($xl[9]) );
	   }
	}
    if ( ! empty( $diemmh) )
    {
       foreach ( $diemmh as $diem){
			$xtpl->assign( 'MON', $monhoc[$diem[5]] );
			$xtpl->assign( 'M_1', $diem[6] );
			$xtpl->assign( 'M_2', $diem[7] );
			$xtpl->assign( '15_1', $diem[8] );
			$xtpl->assign( '15_2', $diem[9] );
			$xtpl->assign( '15_3', $diem[10] );
			$xtpl->assign( '15_4', $diem[11] );
			$xtpl->assign( '15_5', $diem[12] );
			$xtpl->assign( '45_1', $diem[13] );
			$xtpl->assign( '45_2', $diem[14] );
			$xtpl->assign( '45_3', $diem[15] );
			$xtpl->assign( '45_4', $diem[16] );
			$xtpl->assign( '45_5', $diem[17] );
			$xtpl->assign( 'THI', $diem[18] );
			$xtpl->assign( 'TBM', $diem[19] );
			$xtpl->parse('main.loop_diem');
	   }
	}
	
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function maincn($content, $diemtb, $xeploaicn, $lophoc, $monhoc, $namhoc, $ext)
{
    global $global_config, $lang_module, $module_info, $module_name, $module_file, $lang_global;
    $xtpl = new XTemplate( "viewcn.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/".$module_file."/" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'CAUHINH', $ext );
    if ( ! empty( $content) )
    {
       foreach ( $content as $thongtin){
			$xtpl->assign( 'MAHS', $thongtin[1] );
			$xtpl->assign( 'NAMHOC', $namhoc[$thongtin[2]] );
			$xtpl->assign( 'LOP', $lophoc[$thongtin[3]] );
			$xtpl->assign( 'HOTEN', $thongtin[4] );
			$xtpl->assign( 'NGSINH', date('d/m/Y',$thongtin[6]));
			$xtpl->assign( 'GTINH', ($thongtin[5] == 0)?'Nữ':'Nam');
			$xtpl->assign( 'NOISINH', $thongtin[7] );
	   }
	}
    if ( ! empty( $monhoc) AND !empty($diemtb))
    {
       foreach ( $monhoc as $key => $value){
       	   $mon = $key;
       	   //foreach ( $diemtb as $dtb){
       	   	$hk1 = $diemtb[1][$mon];
       	   	$hk2 = $diemtb[2][$mon];
       	   	$hk3 = (intval($hk1) != 0 AND intval($hk2) != 0)?round(($hk1 + $hk2*2)/3, 1):'';
			$xtpl->assign( 'MON', $value );
			$xtpl->assign( 'HKI', $hk1 );
			$xtpl->assign( 'HKII', $hk2 );
			$xtpl->assign( 'HKIII', $hk3 );
			$xtpl->parse('main.loop_diem');
		   //}
	   }
	}
	if ( ! empty( $xeploaicn) )
    {
       foreach ( $xeploaicn as $xloai){
       	   if ($xloai[4] == 1){
       	   		$tbmk1 = $xloai[5] ;
       	   		$hl1 = $xloai[6] ;
       	   		$hak1 = $xloai[7] ;
       	   		$snncp1 = $xloai[8] ;
       	   		$snnkp1 = $xloai[9] ;
       	   		$dh1 = $xloai[10] ;
	   			$xtpl->assign( 'TBMKI', $tbmk1 );
	   			$xtpl->assign( 'HLI', $hl1 );
       	   		$xtpl->assign( 'HAKI', $hak1 );
       	   		$xtpl->assign( 'SNNCP1', $snncp1 + 0);
       	   		$xtpl->assign( 'SNNKP1', $snnkp1 + 0);
       	   		$xtpl->assign( 'SNN1', intval($snncp1) + intval($snnkp1) + 0);
       	   		$xtpl->assign( 'DHI', $dh1 );
       	   }elseif ($xloai[4] == 2){
       	   		$tbmk2 = $xloai[5] ;
       	   		$hl2 = $xloai[6] ;
       	   		$hak2 = $xloai[7] ;
       	   		$snncp2 = $xloai[8] ;
       	   		$snnkp2 = $xloai[9] ;
       	   		$dh2 = $xloai[10] ;
       	   		$xtpl->assign( 'TBMKII', $tbmk2 );
			    $xtpl->assign( 'HLII', $hl2 );
			    $xtpl->assign( 'HAKII', $hak2 );
			    $xtpl->assign( 'SNNCP2', $snncp2 + 0);
			    $xtpl->assign( 'SNNKP2', $snnkp2 + 0);
			    $xtpl->assign( 'SNN2', intval($snncp2) + intval($snnkp2) + 0);
		 	    $xtpl->assign( 'DHII', $dh2 );
       	   }else{
       	   		$tbmk3 = $xloai[5] ;
       	   		$hl3 = $xloai[6] ;
       	   		$hak3 = $xloai[7] ;
       	   		$snncp3 = $xloai[8] ;
       	   		$snnkp3 = $xloai[9] ;
       	   		$dh3 = $xloai[10] ;
       	   		$nxgvcn = $xloai[11] ;
	   			$xtpl->assign( 'TBMKIII', $tbmk3 );
			    $xtpl->assign( 'HLIII', $hl3 );
			    $xtpl->assign( 'HAKIII', $hak3 );
			    $xtpl->assign( 'SNNCP3', $snncp3 + 0);
			    $xtpl->assign( 'SNNKP3', $snnkp3 + 0);
			    $xtpl->assign( 'SNN3', intval($snncp3) + intval($snnkp3) + 0);
       	   		$xtpl->assign( 'DHIII', $dh3 );
       	   		$xtpl->assign( 'NXGVCN', $nxgvcn );
       	   }
	   }
	}
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function mains($content, $lophoc, $namhoc, $ext, $script, $kqsearch)
{
    global $global_config, $lang_module, $module_info, $module_name, $module_file, $lang_global;
    $xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/".$module_file."/" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'CAUHINH', $ext );
    $xtpl->assign( 'SCRIPT', $script );
    $hocki = array(1 => 'Học kì I', 2 => 'Học kì II', 3 => 'Cả năm');
    for ($i = 1; $i <=3; $i ++){
 	
    $xtpl->assign( 'MAHK', $i );
    $xtpl->assign( 'TENHK', $hocki[$i]);
    $xtpl->parse('main.block_table.loop_hk');
    }
	if ( ! empty( $namhoc) )
    {
       foreach ( $namhoc as $nhoc){
       $xtpl->assign( 'MANAMHOC', $nhoc[0]);
       $xtpl->assign( 'TENNAMHOC', $nhoc[1]);
       $xtpl->parse('main.block_table.loop_nh');
       }
    }
    $xtpl->parse('main.block_table');
    $num = count($content);
    $xtpl->assign( 'COUNT', $num );
    $xtpl->assign( 'KEY', $kqsearch[1] );
    $xtpl->assign( 'HKID', $kqsearch[2] );
    $xtpl->assign( 'NAMID', $kqsearch[3] );
    $xtpl->assign( 'FINDTYPE', 2 );
    $links = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=view&keywords";
    $xtpl->assign( 'LINKS', $links );
    if ( ! empty( $content) )
    {
       foreach ( $content as $thongtin){
			$xtpl->assign( 'MAHS', $thongtin[1] );
			$xtpl->assign( 'NAMID', $thongtin[2] );
			//$xtpl->assign( 'LOP', $lophoc[$thongtin[3]] );
			$xtpl->assign( 'HOTEN', $thongtin[4] );
			$xtpl->assign( 'NGSINH', date('d/m/Y',$thongtin[6]));
			$xtpl->assign( 'NOISINH', $thongtin[7] );
			$xtpl->parse('main.block_tablekq.loop_kq');
	   }
	}
	$xtpl->parse('main.block_tablekq');
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

?>