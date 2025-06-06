<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];

$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . ';';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_config;';

$sql_create_module = $sql_drop_module;

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . " (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL,
 alias varchar(250) NOT NULL,
 image varchar(255) DEFAULT '',
 imagealt varchar(255) DEFAULT '',
 imageposition tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
 description text,
 bodytext mediumtext NOT NULL,
 keywords text,
 socialbutton tinyint(4) NOT NULL DEFAULT '0',
 activecomm varchar(255) DEFAULT '',
 layout_func varchar(100) DEFAULT '',
 weight smallint(4) NOT NULL DEFAULT '0',
 admin_id mediumint(8) unsigned NOT NULL DEFAULT '0',
 add_time int(11) NOT NULL DEFAULT '0',
 edit_time int(11) NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 hitstotal MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
 hot_post TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
 schema_type varchar(20) NOT NULL DEFAULT 'article' COMMENT 'Dữ liệu có cấu trúc của bài viết',
 schema_about varchar(50) NOT NULL DEFAULT 'Organization' COMMENT 'Trang viết về gì nếu dữ liệu có cấu trúc là WebPage',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_config (
 config_name varchar(30) NOT NULL,
 config_value varchar(255) NOT NULL,
 UNIQUE KEY config_name (config_name)
)ENGINE=MyISAM';

$sql_create_module[] = 'INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_config VALUES
('schema_type', 'article'),
('schema_about', 'organization'),
('viewtype', '0'),
('facebookapi', ''),
('per_page', '20'),
('news_first', '0'),
('related_articles', '5'),
('copy_page', '0'),
('alias_lower', 1),
('socialbutton', 'facebook,twitter')
";

// Comments
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES
('" . $lang . "', '" . $module_name . "', 'auto_postcomm', '1'),
('" . $lang . "', '" . $module_name . "', 'allowed_comm', '-1'),
('" . $lang . "', '" . $module_name . "', 'view_comm', '6'),
('" . $lang . "', '" . $module_name . "', 'setcomm', '4'),
('" . $lang . "', '" . $module_name . "', 'activecomm', '1'),
('" . $lang . "', '" . $module_name . "', 'emailcomm', '0'),
('" . $lang . "', '" . $module_name . "', 'adminscomm', ''),
('" . $lang . "', '" . $module_name . "', 'sortcomm', '0'),
('" . $lang . "', '" . $module_name . "', 'captcha_area_comm', '1'),
('" . $lang . "', '" . $module_name . "', 'perpagecomm', '5'),
('" . $lang . "', '" . $module_name . "', 'timeoutcomm', '360'),
('" . $lang . "', '" . $module_name . "', 'allowattachcomm', '0'),
('" . $lang . "', '" . $module_name . "', 'alloweditorcomm', '0')";
