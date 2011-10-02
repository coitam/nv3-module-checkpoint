<?php
/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$lopid = $nv_Request->get_int( 'lopid', 'post', 0 );
$new_acgv = $nv_Request->get_int( 'new_acgv', 'post', 0 );
$cnid = $nv_Request->get_int( 'cnid', 'post', 0 );
$khid = $nv_Request->get_int( 'khid', 'post', 0 );

if ($lopid != 0){
	$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_lop` SET `gvid`=". $new_acgv ." WHERE `lopid`=" . $lopid;
	$db->sql_query( $sql ) or die ('Đã có lỗi xảy ra trong câu lệnh truy vấn');
}
if ( $nv_Request->isset_request( 'new_cn', 'post' ) ){
	if ( empty( $cnid ) ) die( "NO" );
    $query = "SELECT `chunhiem` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` WHERE `gvid`=" . $cnid;
    $result = $db->sql_query( $query );
    $numrows = $db->sql_numrows( $result );
    if ( $numrows != 1 ) die( 'NO' );

    list( $new_cn ) = $db->sql_fetchrow( $result );
    $new_cn = $new_cn ? 0 : 1;
    // Cap nhat vao CSDL
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` SET `chunhiem`=". $new_cn ." WHERE `gvid`=" . $cnid;
	$db->sql_query( $sql ) or die ('Đã có lỗi xảy ra trong câu lệnh truy vấn');
}
if ( $nv_Request->isset_request( 'new_kh', 'post' ) ){
	if ( empty( $khid ) ) die( "NO" );
    $query = "SELECT `active` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` WHERE `gvid`=" . $khid;
    $result = $db->sql_query( $query );
    $numrows = $db->sql_numrows( $result );
    if ( $numrows != 1 ) die( 'NO' );

    list( $new_kh ) = $db->sql_fetchrow( $result );
    $new_kh = $new_kh ? 0 : 1;
    // Cap nhat vao CSDL
    $sql1 = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` SET `active`=". $new_kh ." WHERE `gvid`=" . $khid;
	$db->sql_query( $sql1 ) or die ('Đã có lỗi xảy ra trong câu lệnh truy vấn');
}
include ( NV_ROOTDIR . "/includes/header.php" );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>