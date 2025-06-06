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
$array_table = [
    'admins',
    'block',
    'block_cat',
    'bodytext',
    'cat',
    'config_post',
    'rows',
    'row_histories',
    'sources',
    'tags',
    'tags_id',
    'topics',
    'detail',
    'logs',
    'tmp',
    'author',
    'authorlist',
    'voices',
    'report'
];
$table = $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$result = $db->query('SHOW TABLE STATUS LIKE ' . $db->quote($table . '_%'));
while ($item = $result->fetch()) {
    $name = substr($item['name'], strlen($table) + 1);
    if (preg_match('/^' . $db_config['prefix'] . '\_' . $lang . '\_' . $module_data . '\_/', $item['name']) and (preg_match('/^([0-9]+)$/', $name) or in_array($name, $array_table, true) or preg_match('/^bodyhtml\_([0-9]+)$/', $name))) {
        $sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $item['name'];
    }
}

$result = $db->query("SHOW TABLE STATUS LIKE '" . $db_config['prefix'] . "\_" . $lang . "\_comment'");
$rows = $result->fetchAll();
if (count($rows)) {
    $sql_drop_module[] = 'DELETE FROM ' . $db_config['prefix'] . '_' . $lang . "_comment WHERE module='" . $module_name . "'";
}
$sql_create_module = $sql_drop_module;

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_cat (
  catid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  parentid smallint(5) unsigned NOT NULL DEFAULT '0',
  title varchar(250) NOT NULL,
  titlesite varchar(250) DEFAULT '',
  alias varchar(250) NOT NULL DEFAULT '',
  description text,
  descriptionhtml text,
  image varchar(255) DEFAULT '',
  viewdescription tinyint(2) NOT NULL DEFAULT '0',
  weight smallint(5) unsigned NOT NULL DEFAULT '0',
  sort smallint(5) NOT NULL DEFAULT '0',
  lev smallint(5) NOT NULL DEFAULT '0',
  viewcat varchar(50) NOT NULL DEFAULT 'viewcat_page_new',
  numsubcat smallint(5) NOT NULL DEFAULT '0',
  subcatid varchar(255) DEFAULT '',
  numlinks tinyint(2) unsigned NOT NULL DEFAULT '3',
  newday tinyint(2) unsigned NOT NULL DEFAULT '2',
  featured int(11) NOT NULL DEFAULT '0',
  ad_block_cat varchar(255) NOT NULL DEFAULT '',
  layout_func varchar(100) NOT NULL DEFAULT '' COMMENT 'Layout khi xem chuyên mục',
  keywords text,
  admins text,
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  groups_view varchar(255) DEFAULT '',
  status smallint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (catid),
  UNIQUE KEY alias (alias),
  KEY parentid (parentid),
  KEY status (status)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_sources (
  sourceid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL DEFAULT '',
  link varchar(255) DEFAULT '',
  logo varchar(255) DEFAULT '',
  weight mediumint(8) unsigned NOT NULL DEFAULT '0',
  add_time int(11) unsigned NOT NULL,
  edit_time int(11) unsigned NOT NULL,
  PRIMARY KEY (sourceid),
  UNIQUE KEY title (title)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_topics (
  topicid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL DEFAULT '',
  alias varchar(250) NOT NULL DEFAULT '',
  image varchar(255) DEFAULT '',
  description varchar(255) DEFAULT '',
  weight smallint(5) NOT NULL DEFAULT '0',
  keywords text,
  add_time int(11) NOT NULL DEFAULT '0',
  edit_time int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (topicid),
  UNIQUE KEY title (title),
  UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_block_cat (
  bid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  adddefault tinyint(4) NOT NULL DEFAULT '0',
  numbers smallint(5) NOT NULL DEFAULT '10',
  title varchar(250) NOT NULL DEFAULT '',
  alias varchar(250) NOT NULL DEFAULT '',
  image varchar(255) DEFAULT '',
  description varchar(255) DEFAULT '',
  weight smallint(5) NOT NULL DEFAULT '0',
  keywords text,
  add_time int(11) NOT NULL DEFAULT '0',
  edit_time int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (bid),
  UNIQUE KEY title (title),
  UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block (
  bid smallint(5) unsigned NOT NULL,
  id int(11) unsigned NOT NULL,
  weight int(11) unsigned NOT NULL,
  UNIQUE KEY bid (bid,id)
) ENGINE=MyISAM';

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_rows (
  id int(11) unsigned NOT NULL auto_increment,
  catid smallint(5) unsigned NOT NULL default '0',
  listcatid varchar(255) NOT NULL default '',
  topicid smallint(5) unsigned NOT NULL default '0',
  admin_id mediumint(8) unsigned NOT NULL default '0',
  author varchar(250) default '',
  sourceid mediumint(8) NOT NULL default '0',
  addtime int(11) unsigned NOT NULL default '0',
  edittime int(11) unsigned NOT NULL default '0',
  status tinyint(4) NOT NULL default '1',
  weight int(11) unsigned NOT NULL default '0',
  publtime int(11) unsigned NOT NULL default '0',
  exptime int(11) unsigned NOT NULL default '0',
  archive tinyint(1) unsigned NOT NULL default '0',
  title varchar(250) NOT NULL default '',
  alias varchar(250) NOT NULL default '',
  hometext text NOT NULL,
  homeimgfile varchar(255) default '',
  homeimgalt varchar(255) default '',
  homeimgthumb tinyint(4) NOT NULL default '0',
  inhome tinyint(1) unsigned NOT NULL default '0',
  allowed_comm varchar(255) default '',
  allowed_rating tinyint(1) unsigned NOT NULL default '0',
  external_link tinyint(1) unsigned NOT NULL default '0',
  hitstotal mediumint(8) unsigned NOT NULL default '0',
  hitscm mediumint(8) unsigned NOT NULL default '0',
  total_rating int(11) NOT NULL default '0',
  click_rating int(11) NOT NULL default '0',
  instant_active tinyint(1) NOT NULL default '0',
  instant_template varchar(100) NOT NULL default '',
  instant_creatauto tinyint(1) NOT NULL default '0',
  PRIMARY KEY (id),
  KEY catid (catid),
  KEY topicid (topicid),
  KEY admin_id (admin_id),
  KEY author (author),
  KEY title (title),
  KEY addtime (addtime),
  KEY edittime (edittime),
  KEY publtime (publtime),
  KEY exptime (exptime),
  KEY status (status),
  KEY instant_active (instant_active),
  KEY instant_creatauto (instant_creatauto)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_row_histories (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  new_id int(11) unsigned NOT NULL DEFAULT '0',
  historytime int(11) unsigned NOT NULL DEFAULT '0',
  catid smallint(5) unsigned NOT NULL DEFAULT '0',
  listcatid varchar(255) NOT NULL DEFAULT '',
  topicid smallint(5) unsigned NOT NULL DEFAULT '0',
  admin_id mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'ID người đăng',
  author varchar(250) NOT NULL DEFAULT '',
  sourceid mediumint(8) unsigned NOT NULL DEFAULT '0',
  publtime int(11) unsigned NOT NULL DEFAULT '0',
  exptime int(11) unsigned NOT NULL DEFAULT '0',
  archive tinyint(1) unsigned NOT NULL DEFAULT '0',
  title varchar(250) NOT NULL DEFAULT '',
  alias varchar(250) NOT NULL DEFAULT '',
  hometext text NOT NULL,
  homeimgfile varchar(255) DEFAULT '',
  homeimgalt varchar(255) DEFAULT '',
  inhome tinyint(1) unsigned NOT NULL DEFAULT '0',
  allowed_comm varchar(255) DEFAULT '',
  allowed_rating tinyint(1) unsigned NOT NULL DEFAULT '0',
  external_link tinyint(1) unsigned NOT NULL DEFAULT '0',
  instant_active tinyint(1) NOT NULL DEFAULT '0',
  instant_template varchar(100) NOT NULL DEFAULT '',
  instant_creatauto tinyint(1) NOT NULL DEFAULT '0',
  titlesite varchar(255) NOT NULL DEFAULT '',
  description text NOT NULL,
  bodyhtml longtext NOT NULL,
  voicedata text NULL DEFAULT NULL COMMENT 'Data giọng đọc json',
  keywords varchar(255) default '',
  sourcetext varchar(255) default '',
  files TEXT NULL DEFAULT NULL,
  tags TEXT NULL DEFAULT NULL,
  internal_authors VARCHAR(255) NOT NULL DEFAULT '',
  imgposition tinyint(1) NOT NULL default '1',
  layout_func varchar(100) DEFAULT '',
  copyright tinyint(1) NOT NULL default '0',
  allowed_send tinyint(1) NOT NULL default '0',
  allowed_print tinyint(1) NOT NULL default '0',
  allowed_save tinyint(1) NOT NULL default '0',
  auto_nav tinyint(1) NOT NULL default '0',
  group_view VARCHAR(255) NULL DEFAULT '',
  schema_type varchar(20) NOT NULL DEFAULT 'newsarticle' COMMENT 'Loại dữ liệu có cấu trúc',
  changed_fields text NOT NULL COMMENT 'Các field thay đổi',
  PRIMARY KEY (id),
  KEY new_id (new_id),
  KEY historytime (historytime),
  KEY admin_id (admin_id)
) ENGINE=MyISAM COMMENT 'Lịch sử bài viết'";

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_detail (
  id int(11) unsigned NOT NULL,
  titlesite varchar(255) NOT NULL DEFAULT '',
  description text NOT NULL,
  bodyhtml longtext NOT NULL,
  voicedata text NULL DEFAULT NULL COMMENT 'Data giọng đọc json',
  keywords varchar(255) default '',
  sourcetext varchar(255) default '',
  files TEXT NULL,
  imgposition tinyint(1) NOT NULL default '1',
  layout_func varchar(100) DEFAULT '',
  copyright tinyint(1) NOT NULL default '0',
  allowed_send tinyint(1) NOT NULL default '0',
  allowed_print tinyint(1) NOT NULL default '0',
  allowed_save tinyint(1) NOT NULL default '0',
  auto_nav TINYINT(1) NOT NULL DEFAULT '0',
  group_view VARCHAR(255) NULL DEFAULT '',
  localization text NULL DEFAULT NULL COMMENT 'Json url ngôn ngữ khác của bài viết',
  related_ids varchar(255) NOT NULL DEFAULT '' COMMENT 'ID bài đăng liên quan',
  related_pos tinyint(1) NOT NULL DEFAULT '2' COMMENT 'Vị trí bài liên quan: 0 tắt, 1 dưới mô tả ngắn gọn, 2 dưới cùng bài đăng',
  schema_type varchar(20) NOT NULL DEFAULT 'newsarticle' COMMENT 'Loại dữ liệu có cấu trúc',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_logs (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  sid mediumint(8) NOT NULL DEFAULT '0',
  userid mediumint(8) unsigned NOT NULL DEFAULT '0',
  log_key varchar(60) NOT NULL DEFAULT '' COMMENT 'Khóa loại log, tùy vào lập trình',
  status tinyint(4) NOT NULL DEFAULT '0',
  note varchar(255) NOT NULL DEFAULT '',
  set_time int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY sid (sid),
  KEY log_key (log_key),
  KEY status (status),
  KEY userid (userid)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_config_post (
  group_id smallint(5) NOT NULL,
  addcontent tinyint(4) NOT NULL,
  postcontent tinyint(4) NOT NULL,
  editcontent tinyint(4) NOT NULL,
  delcontent tinyint(4) NOT NULL,
  PRIMARY KEY (group_id)
) ENGINE=MyISAM';

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_admins (
  userid mediumint(8) unsigned NOT NULL default '0',
  catid smallint(5) NOT NULL default '0',
  admin tinyint(4) NOT NULL default '0',
  add_content tinyint(4) NOT NULL default '0',
  pub_content tinyint(4) NOT NULL default '0',
  edit_content tinyint(4) NOT NULL default '0',
  del_content tinyint(4) NOT NULL default '0',
  app_content tinyint(4) NOT NULL default '0',
  UNIQUE KEY userid (userid,catid)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_tags (
  tid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  numnews mediumint(8) NOT NULL DEFAULT '0',
  title varchar(250) NOT NULL DEFAULT '',
  alias varchar(250) NOT NULL DEFAULT '',
  image varchar(255) DEFAULT '',
  description text,
  keywords varchar(255) DEFAULT '',
  PRIMARY KEY (tid),
  UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_tags_id (
  id int(11) NOT NULL,
  tid mediumint(9) NOT NULL,
  keyword varchar(65) NOT NULL,
  UNIQUE KEY id_tid (id,tid),
  KEY tid (tid)
) ENGINE=MyISAM';

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_tmp (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  type tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: thao tác sửa bài, 1: bản nháp',
  new_id int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'ID bài viết',
  admin_id int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'ID người thao tác',
  time_edit int(11) NOT NULL DEFAULT '0' COMMENT 'Thời gian thao tác',
  time_late int(11) NOT NULL DEFAULT '0' COMMENT 'Thời gian cuối cùng thao tác',
  ip varchar(40) NOT NULL DEFAULT '' COMMENT 'IP thao tác',
  uuid varchar(36) NOT NULL DEFAULT '' COMMENT 'ID bản nháp nếu soạn bài mới',
  properties mediumtext NULL DEFAULT NULL COMMENT 'Json khác',
  PRIMARY KEY (id),
  KEY tmp_id (new_id, type, admin_id),
  KEY draft_id (admin_id, type),
  KEY uuid (uuid)
) ENGINE=MyISAM COMMENT 'Bản nháp và ghi nhận sửa bài'";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_author (
  id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(11) UNSIGNED NOT NULL,
  alias VARCHAR(100) NOT NULL DEFAULT '',
  pseudonym VARCHAR(100) NOT NULL DEFAULT '',
  image VARCHAR(255) NULL DEFAULT '',
  description TEXT,
  add_time INT(11) UNSIGNED NOT NULL DEFAULT '0',
  edit_time INT(11) UNSIGNED NOT NULL DEFAULT '0',
  active TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  numnews MEDIUMINT(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  UNIQUE KEY uid (uid),
  UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_authorlist (
  id INT(11) NOT NULL,
  aid MEDIUMINT(8) NOT NULL,
  alias VARCHAR(100) NOT NULL DEFAULT '',
  pseudonym VARCHAR(100) NOT NULL DEFAULT '',
  UNIQUE KEY id_aid (id, aid),
  KEY aid (aid),
  KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_voices (
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  voice_key varchar(50) NOT NULL DEFAULT '' COMMENT 'Khóa dùng trong Api sau này',
  title varchar(250) NOT NULL DEFAULT '',
  description text NOT NULL,
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Dừng, 1: Hoạt động',
  PRIMARY KEY (id),
  KEY weight (weight),
  KEY status (status),
  UNIQUE KEY title (title)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_report (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  newsid INT(11) UNSIGNED NOT NULL DEFAULT '0',
  md5content CHAR(32) NOT NULL DEFAULT '',
  post_ip CHAR(50) NOT NULL DEFAULT '',
  post_email VARCHAR(100) NOT NULL DEFAULT '',
  post_time INT(11) NOT NULL DEFAULT '0',
  orig_content VARCHAR(255) NOT NULL DEFAULT '',
  repl_content VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  UNIQUE KEY newsid_md5content_post_ip (newsid, md5content, post_ip)
) ENGINE=MyISAM";

$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES
('" . $lang . "', '" . $module_name . "', 'schema_type', 'newsarticle'),
('" . $lang . "', '" . $module_name . "', 'auto_save', '0'),
('" . $lang . "', '" . $module_name . "', 'indexfile', 'viewcat_main_right'),
('" . $lang . "', '" . $module_name . "', 'mobile_indexfile', 'viewcat_page_new'),
('" . $lang . "', '" . $module_name . "', 'per_page', '20'),
('" . $lang . "', '" . $module_name . "', 'st_links', '10'),
('" . $lang . "', '" . $module_name . "', 'homewidth', '100'),
('" . $lang . "', '" . $module_name . "', 'homeheight', '150'),
('" . $lang . "', '" . $module_name . "', 'blockwidth', '70'),
('" . $lang . "', '" . $module_name . "', 'blockheight', '75'),
('" . $lang . "', '" . $module_name . "', 'imagefull', '460'),
('" . $lang . "', '" . $module_name . "', 'copyright', ''),
('" . $lang . "', '" . $module_name . "', 'showtooltip', '1'),
('" . $lang . "', '" . $module_name . "', 'tooltip_position', 'bottom'),
('" . $lang . "', '" . $module_name . "', 'tooltip_length', '150'),
('" . $lang . "', '" . $module_name . "', 'showhometext', '1'),
('" . $lang . "', '" . $module_name . "', 'timecheckstatus', '0'),
('" . $lang . "', '" . $module_name . "', 'config_source', '0'),
('" . $lang . "', '" . $module_name . "', 'show_no_image', ''),
('" . $lang . "', '" . $module_name . "', 'allowed_rating', '1'),
('" . $lang . "', '" . $module_name . "', 'allowed_rating_point', '1'),
('" . $lang . "', '" . $module_name . "', 'facebookappid', ''),
('" . $lang . "', '" . $module_name . "', 'socialbutton', 'facebook,twitter'),
('" . $lang . "', '" . $module_name . "', 'alias_lower', '1'),
('" . $lang . "', '" . $module_name . "', 'tags_alias', '0'),
('" . $lang . "', '" . $module_name . "', 'auto_tags', '0'),
('" . $lang . "', '" . $module_name . "', 'tags_remind', '1'),
('" . $lang . "', '" . $module_name . "', 'keywords_tag', '1'),
('" . $lang . "', '" . $module_name . "', 'copy_news', '1'),
('" . $lang . "', '" . $module_name . "', 'structure_upload', 'Ym'),
('" . $lang . "', '" . $module_name . "', 'imgposition', '2'),
('" . $lang . "', '" . $module_name . "', 'htmlhometext', '0'),
('" . $lang . "', '" . $module_name . "', 'order_articles', '0'),
('" . $lang . "', '" . $module_name . "', 'identify_cat_change', '0'),
('" . $lang . "', '" . $module_name . "', 'active_history', '0'),
('" . $lang . "', '" . $module_name . "', 'hide_author', '0'),
('" . $lang . "', '" . $module_name . "', 'hide_inauthor', '0'),
('" . $lang . "', '" . $module_name . "', 'elas_use', '0'),
('" . $lang . "', '" . $module_name . "', 'elas_host', ''),
('" . $lang . "', '" . $module_name . "', 'elas_port', '9200'),
('" . $lang . "', '" . $module_name . "', 'elas_index', ''),
('" . $lang . "', '" . $module_name . "', 'instant_articles_active', '0'),
('" . $lang . "', '" . $module_name . "', 'instant_articles_template', 'default'),
('" . $lang . "', '" . $module_name . "', 'instant_articles_httpauth', '0'),
('" . $lang . "', '" . $module_name . "', 'instant_articles_username', ''),
('" . $lang . "', '" . $module_name . "', 'instant_articles_password', ''),
('" . $lang . "', '" . $module_name . "', 'instant_articles_livetime', '60'),
('" . $lang . "', '" . $module_name . "', 'instant_articles_gettime', '120'),
('" . $lang . "', '" . $module_name . "', 'instant_articles_auto', '1'),
('" . $lang . "', '" . $module_name . "', 'frontend_edit_alias', '0'),
('" . $lang . "', '" . $module_name . "', 'frontend_edit_layout', '1'),
('" . $lang . "', '" . $module_name . "', 'captcha_type', 'captcha'),
('" . $lang . "', '" . $module_name . "', 'report_active', '1'),
('" . $lang . "', '" . $module_name . "', 'report_group', '4'),
('" . $lang . "', '" . $module_name . "', 'report_limit', '2')";

// Cấu hình bình luận
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
