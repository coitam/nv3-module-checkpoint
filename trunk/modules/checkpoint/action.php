<?php

/**
 * @Project NUKEVIET 3.2
 * @Author Đặng Đình Tứ (dlinhvan@gmail.com)
 * @Copyright (C) 2011 tinhoccanban.net All rights reserved
 * @Createdate Monday, 12 Oct 2011 11:00:00 GMT
 */

if ( ! defined( 'NV_IS_FILE_MODULES' ) ) die( 'Stop!!!' );

$sql_drop_module = array();

$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_diem`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_dshs`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_lop`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_monhoc`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_namhoc`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_xeploai`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_dsgv`";

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_diem` (
   `id` mediumint(9) NOT NULL auto_increment,
   `mahs` varchar(7) NOT NULL,
   `lopid` tinyint(3) NOT NULL,
   `manamhoc` tinyint(2) NOT NULL,
   `mahocky` tinyint(1) NOT NULL,
   `monid` tinyint(2) NOT NULL,
   `m_1` varchar(3),
   `m_2` varchar(3),
   `15_1` varchar(3),
   `15_2` varchar(3),
   `15_3` varchar(3),
   `15_4` varchar(3),
   `15_5` varchar(3),
   `45_1` varchar(3),
   `45_2` varchar(3),
   `45_3` varchar(3),
   `45_4` varchar(3),
   `45_5` varchar(3),
   `thi` varchar(3),
   `tbm` varchar(3),
   `gvid` mediumint(3) DEFAULT '0' NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_dshs` (
   `id` int(9) NOT NULL auto_increment,
   `mahs` varchar(7) NOT NULL,
   `manamhoc` tinyint(2) NOT NULL,
   `lopid` tinyint(3) NOT NULL,
   `hoten` varchar(40) NOT NULL,
   `phai` tinyint(1) DEFAULT '1' NOT NULL,
   `ngaysinh` int(11) NOT NULL,
   `noisinh` varchar(40) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_lop` (
   `lopid` tinyint(3) NOT NULL,
   `tenlop` varchar(50) NOT NULL,
   `gvid` mediumint(3) DEFAULT '0' NOT NULL,
   PRIMARY KEY (`lopid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_monhoc` (
   `monid` tinyint(2) NOT NULL,
   `tenmon` varchar(50) NOT NULL,
   PRIMARY KEY (`monid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_namhoc` (
   `manamhoc` tinyint(2) NOT NULL,
   `tennamhoc` varchar(9) NOT NULL,
   PRIMARY KEY (`manamhoc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_xeploai` (
   `id` int(11) NOT NULL auto_increment,
   `mahs` varchar(7) NOT NULL,
   `lopid` tinyint(3) NOT NULL,
   `manamhoc` tinyint(2) NOT NULL,
   `mahocky` tinyint(1) NOT NULL,
   `tbm` varchar(3) NOT NULL,
   `hl` varchar(11) NOT NULL,
   `hk` varchar(11) NOT NULL,
   `snncp` varchar(2),
   `snnkp` varchar(2),
   `danhhieu` varchar(11),
   `nxgvcn` varchar(255),
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_dsgv` (
   `gvid` mediumint(3) NOT NULL auto_increment,
   `tengv` varchar(40) NOT NULL,
   `user` varchar(40),
   `log` text,
   `chunhiem` tinyint(1) DEFAULT '0' NOT NULL,
   `active` tinyint(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (`gvid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

?>