<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 08 May 2016 01:59:39 GMT
 */
if (!defined('NV_IS_FILE_MODULES')) die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_examinations";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exam_subject";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subject_questions";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_answer";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_config";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_question";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_question";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_topics";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags_id";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_cat";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rating";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_admins";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_usersave";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_econtent";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank_type";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sources";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_info_member_answer";
// Ngân hàng đề thi
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_bank";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_bank_cats";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_bank_question";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_history_merge";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_noview_msg";

$result = $db->query("SHOW TABLE STATUS LIKE '" . $db_config['prefix'] . "\_" . $lang . "\_comment'");
$rows = $result->fetchAll();
if (sizeof($rows)) {
    $sql_drop_module[] = "DELETE FROM " . $db_config['prefix'] . "_" . $lang . "_comment WHERE module='" . $module_name . "'";
}

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_examinations(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL COMMENT 'Tên gọi kỳ thi',
  alias varchar(255) NOT NULL,
  image VARCHAR(250) NULL DEFAULt NULL,
  begintime int(11) unsigned NOT NULL COMMENT 'Thời gian mở đề',
  endtime int(11) unsigned NOT NULL COMMENT 'Thời gian đóng đề',
  status TINYINT(1) NOT NULL DEFAULT '0',
  description text NOT NULL COMMENT 'Ghi chú',
  UNIQUE KEY title (title),
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exam_subject(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  alias varchar(255) NOT NULL,
  image VARCHAR(250) NULL DEFAULt NULL,
  code VARCHAR(6) NULL,
  begintime int(11) unsigned NOT NULL COMMENT 'Thời gian mở đề',
  endtime int(11) unsigned NOT NULL COMMENT 'Thời gian đóng đề',
  exam_id mediumint(8) unsigned NOT NULL,
  exam_type enum('random_exam', 'random_question') NOT NULL DEFAULT 'random_exam',
  ladder smallint(4) unsigned NOT NULL DEFAULT '10',
  timer smallint(4) unsigned NOT NULL,
  num_question smallint(4) unsigned NOT NULL,
  description text NOT NULL COMMENT 'Ghi chú',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subject_questions(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  subjectid mediumint(8) NOT NULL,
  questionid 	mediumint(8) NULL DEFAULT NULL,
  examsid 	mediumint(4) NULL DEFAULT NULL,
  UNIQUE KEY questionid (subjectid ,questionid),
  UNIQUE KEY examsid (subjectid ,examsid),
  PRIMARY KEY (id)
) ENGINE=MyISAM";


$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_answer(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  exam_id mediumint(8) unsigned NOT NULL,
  exam_subject SMALLINT(4) unsigned NULL,
  userid int(11) unsigned NOT NULL DEFAULT '0',
  begin_time int(11) unsigned NOT NULL COMMENT 'Thời gian bắt đầu làm bài',
  end_time int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian kết thúc làm bài',
  test_time int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian làm bài',
  count_true smallint(4) unsigned NOT NULL DEFAULT '0',
  count_false smallint(4) unsigned NOT NULL DEFAULT '0',
  count_skeep smallint(4) unsigned NOT NULL DEFAULT '0',
  score double unsigned NOT NULL,
  answer text NOT NULL,
  mark_constructed_response text NULL DEFAULT NULL,
  test_exam_question text NOT NULL,
  test_exam_answer text NOT NULL,
  PRIMARY KEY (id),
  KEY exam_id (exam_id),
  KEY userid (userid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config(
  config_name varchar(30) NOT NULL,
  config_value varchar(255) NOT NULL,
  UNIQUE KEY config_name (config_name)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams(
  id mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  isbank TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  catid smallint(4) unsigned NOT NULL,
  topicid smallint(5) unsigned NOT NULL default '0',
  sourceid smallint(4) NOT NULL default '0',
  title varchar(255) NOT NULL COMMENT 'Tên gọi đợt thi',
  alias varchar(255) NOT NULL,
  code varchar(20) NOT NULL,
  image varchar(255) NOT NULL DEFAULT '',
  image_position tinyint(1) unsigned NOT NULL DEFAULT '0',
  hometext varchar(255) NOT NULL,
  description text NOT NULL COMMENT 'Ghi chú',
  groups varchar(255) NOT NULL COMMENT 'Nhóm được tham gia',
  groups_comment varchar(255) NOT NULL DEFAULT '6' COMMENT 'Nhóm bình luận',
  groups_result varchar(255) NOT NULL DEFAULT '6' COMMENT 'Nhóm xem đáp án',
  begintime int(11) unsigned NOT NULL COMMENT 'Thời gian mở đề',
  endtime int(11) unsigned NOT NULL COMMENT 'Thời gian đóng đề',
  num_question smallint(4) unsigned NOT NULL,
  count_question smallint(4) unsigned NOT NULL DEFAULT '0',
  timer smallint(4) unsigned NOT NULL,
  ladder smallint(4) unsigned NOT NULL DEFAULT '10',
  per_page tinyint(2) unsigned NOT NULL DEFAULT '15',
  type tinyint(1) unsigned NOT NULL DEFAULT '0',
  input_question tinyint(1) unsigned NOT NULL DEFAULT '0',
  exams_config smallint(4) unsigned NOT NULL DEFAULT '0',
  exams_reset_bank tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Làm mới bộ câu hỏi ở mỗi lần thi',
  question_list TEXT NOT NULL,
  addtime int(11) unsigned NOT NULL,
  userid mediumint(8) unsigned NOT NULL DEFAULT '0',
  isfull tinyint(1) unsigned NOT NULL DEFAULT '0',
  random_answer tinyint(1) unsigned NOT NULL DEFAULT '1',
  rating tinyint(1) unsigned NOT NULL DEFAULT '1',
  multiple_test tinyint(1) unsigned NOT NULL DEFAULT '1',
  history_save tinyint(1) unsigned NOT NULL DEFAULT '1',
  save_max_score tinyint(1) unsigned NOT NULL DEFAULT '0',
  print tinyint(1) unsigned NOT NULL DEFAULT '1',
  useguide tinyint(1) unsigned NOT NULL DEFAULT '0',
  type_useguide tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Kiểu hiển thị',
  hitstotal mediumint(8) unsigned NOT NULL default '0',
  hittest mediumint(8) unsigned NOT NULL default '0' COMMENT 'Số lượt làm bài',
  hitscm mediumint(8) unsigned NOT NULL default '0',
  template tinyint(1) unsigned NOT NULL default '9',
  weight mediumint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  test_limit smallint(4) unsigned NOT NULL DEFAULT '0',
  price DOUBLE UNSIGNED NOT NULL DEFAULT '0',
  check_result tinyint(1) unsigned NOT NULL DEFAULT '0',
  view_mark_after_test tinyint(1) unsigned NOT NULL DEFAULT '0',
  view_question_after_test tinyint(1) unsigned NOT NULL DEFAULT '0',
  preview_question_test tinyint(1) unsigned NOT NULL DEFAULT '0',
  mix_question VARCHAR(255) NULL DEFAULT NULL,
  block_copy_paste TINYINT NOT NULL DEFAULT 1,
  way_record varchar(5) NULL DEFAULT NULL,
  exams_max_time int(11) NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY topicid (topicid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_config(
  id mediumint(8) NOT NULL AUTO_INCREMENT,
  isbank TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  title varchar(250) NOT NULL,
  timer int(10) unsigned NOT NULL,
  num_question smallint(4) NOT NULL,
  ladder smallint(4) unsigned NOT NULL COMMENT 'Thang điểm',
  random_question tinyint(1) unsigned NOT NULL DEFAULT '1',
  random_answer tinyint(1) unsigned NOT NULL DEFAULT '1',
  config text NOT NULL,
  addtime int(11) unsigned NOT NULL,
  userid mediumint(8) NOT NULL DEFAULT '0',
  active TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_question(
  examsid mediumint(4) unsigned NOT NULL,
  questionid mediumint(8) unsigned NOT NULL,
  UNIQUE KEY examsid (examsid, questionid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_question(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  idsite mediumint(8) unsigned NOT NULL DEFAULT 0,
  idsq mediumint(8) unsigned NULL DEFAULT NULL,
  status tinyint(2) unsigned NOT NULL DEFAULT 0,
  examid mediumint(8) unsigned NOT NULL DEFAULT 0,
  examinationsid smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT 'Kỳ thi',
  exam_subject SMALLINT(4) UNSIGNED NOT NULL DEFAULT '0',
  typeid smallint(4) unsigned NOT NULL DEFAULT 0,
  bank_type tinyint(1) unsigned NOT NULL DEFAULT 0,
  title text NOT NULL COMMENT 'Nội dung câu hỏi',
  useguide text NOT NULL COMMENT 'Lời giải',
  type tinyint(1) unsigned NOT NULL DEFAULT '1',
  answer text NOT NULL,
  note tinytext NOT NULL COMMENT 'Ghi chú',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  answer_style tinyint(1) unsigned NOT NULL DEFAULT '0',
  count_true tinyint(2) unsigned NOT NULL,
  max_answerid tinyint(2) unsigned NOT NULL DEFAULT '0',
  generaltext text NOT NULL,
  answer_editor tinyint(1) unsigned NOT NULL DEFAULT '0',
  answer_editor_type tinyint(1) unsigned NOT NULL default '0' COMMENT 'Công cụ soạn thảo nội dung trả lời',
  answer_fixed tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Cố định vị trí đáp án',
  point double unsigned NOT NULL DEFAULT '0',
  addtime int(11) unsigned NOT NULL,
  edittime INT(11) UNSIGNED NOT NULL,
  userid mediumint(8) unsigned NOT NULL DEFAULT '0',
  total_use int(11) unsigned NOT NULL DEFAULT '0',
  limit_time_audio tinyint(3) unsigned NOT NULL DEFAULT '0',
  mark_max_constructed_response tinyint(2) unsigned NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  parentid smallint(4) unsigned NOT NULL DEFAULT '0',
  title varchar(250) NOT NULL DEFAULT '',
  alias varchar(250) NOT NULL DEFAULT '',
  custom_title varchar(255) NOT NULL DEFAULT '',
  keywords text NOT NULL,
  description tinytext NOT NULL,
  description_html text NOT NULL,
  groups_view varchar(255) NOT NULL DEFAULT '6',
  image varchar(255) NOT NULL DEFAULT '',
  lev smallint(4) unsigned NOT NULL DEFAULT '0',
  numsub smallint(4) unsigned NOT NULL DEFAULT '0',
  subid varchar(255) NOT NULL DEFAULT '',
  sort smallint(4) unsigned NOT NULL DEFAULT '0',
  inhome tinyint(1) unsigned NOT NULL DEFAULT '1',
  numlinks tinyint(3) unsigned NOT NULL DEFAULT '4',
  topscore tinyint(3) unsigned NOT NULL DEFAULT '0',
  viewtype tinyint(1) unsigned NOT NULL DEFAULT '1',
  newday tinyint(2) unsigned NOT NULL DEFAULT '2',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  PRIMARY KEY (id),
  UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_topics (
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

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags (
 tid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 numnews mediumint(8) NOT NULL DEFAULT '0',
 alias varchar(250) NOT NULL DEFAULT '',
 image varchar(255) DEFAULT '',
 description text,
 keywords varchar(255) DEFAULT '',
 PRIMARY KEY (tid),
 UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags_id (
 id int(11) NOT NULL,
 tid mediumint(9) NOT NULL,
 keyword varchar(65) NOT NULL,
 UNIQUE KEY id_tid (id,tid),
 KEY tid (tid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block (
 bid smallint(5) unsigned NOT NULL,
 id int(11) unsigned NOT NULL,
 weight int(11) unsigned NOT NULL,
 UNIQUE KEY bid (bid,id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_cat(
  bid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL,
  alias varchar(250) NOT NULL,
  description text NOT NULL,
  keywords varchar(255) NOT NULL,
  adddefault tinyint(4) NOT NULL DEFAULT '0',
  numbers smallint(5) NOT NULL DEFAULT '10',
  image varchar(255) DEFAULT '',
  weight smallint(5) NOT NULL DEFAULT '0',
  add_time int(11) NOT NULL DEFAULT '0',
  edit_time int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (bid),
  UNIQUE KEY title (title),
  UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rating(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  color varchar(50) NOT NULL COMMENT 'Màu thống kê',
  operator varchar(20) NOT NULL,
  percent smallint(3) unsigned NOT NULL,
  note text NOT NULL,
  weight smallint(4) unsigned NOT NULL DEFAULT 0,
  status tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rating VALUES (8, 'Trung bình', '#8c4807', '&lt;', 50, '', 2, 1), (3, 'Khá', '#1f282d', '&lt;', 70, '', 3, 1), (4, 'Giỏi', '#dee310', '&lt;', 90, '', 4, 1), (5, 'Xuất sắc', '#fd2a4a', '&lt;&#x3D;', 100, '', 5, 1), (11, 'Yếu', '#339900', '&lt;', 35, '', 1, 1);";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_admins(
 userid mediumint(8) unsigned NOT NULL default '0',
 catid smallint(5) NOT NULL default '0',
 admin tinyint(4) NOT NULL default '0',
 add_content tinyint(4) NOT NULL default '0',
 edit_content tinyint(4) NOT NULL default '0',
 del_content tinyint(4) NOT NULL default '0',
 UNIQUE KEY userid (userid,catid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_usersave(
 userid mediumint(8) unsigned NOT NULL default '0',
 examid mediumint(4) unsigned NOT NULL default '0',
 add_time int(11) NOT NULL DEFAULT '0',
 UNIQUE KEY userid (userid,examid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_econtent(
  action varchar(100) NOT NULL,
  econtent text NOT NULL,
  PRIMARY KEY (action)
) ENGINE=MyISAM";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_econtent (action, econtent) VALUES('helptest', '<h2>Hướng dẫn làm bài thi trắc nghiệm:</h2> 1. Đợi đến khi đến thời gian làm bài<br /> 2. Click vào nút \"Bắt đầu làm bài\" để tiến hành làm bài thi<br /> 3. Ở mỗi câu hỏi, chọn đáp án đúng<br /> 4. Hết thời gian làm bài, hệ thống sẽ tự thu bài. Bạn có thể nộp bài trước khi thời gian kết thúc bằng cách nhấn nút <strong>Nộp bài</strong>')";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  parentid smallint(4) unsigned NOT NULL DEFAULT '0',
  title varchar(250) NOT NULL DEFAULT '',
  description tinytext NOT NULL,
  lev smallint(4) unsigned NOT NULL DEFAULT '0',
  numsub smallint(4) unsigned NOT NULL DEFAULT '0',
  subid varchar(255) NOT NULL DEFAULT '0',
  num_req mediumint(8) unsigned NOT NULL DEFAULT '0',
  sort smallint(4) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  userid mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank_type(
  id tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL DEFAULT '',
  code varchar(10) NOT NULL DEFAULT '',
  weight tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank_type (id, title, code, weight) VALUES(1, 'Dễ (Nhận biết)', 'NB', 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank_type (id, title, code, weight) VALUES(2, 'Vừa (Thông hiểu)', 'TH', 2)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank_type (id, title, code, weight) VALUES(3, 'Khó (Vận dụng)', 'VD', 3)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bank_type (id, title, code, weight) VALUES(4, 'Nâng cao (Vận dụng cao)', 'VC', 4)";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_sources (
 sourceid smallint(4) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL DEFAULT '',
 link varchar(255) NOT NULL DEFAULT '',
 logo varchar(255) DEFAULT '',
 weight mediumint(8) unsigned NOT NULL DEFAULT '0',
 add_time int(11) unsigned NOT NULL,
 edit_time int(11) unsigned NOT NULL,
 PRIMARY KEY (sourceid),
 UNIQUE KEY title (title)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_info_member_answer (
 session_id varchar(50) NOT NULL COMMENT 'Phiên làm việc',
 userid mediumint(8) unsigned NOT NULL default '0' COMMENT 'Người thi',
 examid mediumint(4) unsigned NOT NULL default '0' COMMENT 'ID bài thi',
 delete_time int(11) NOT NULL DEFAULT '0' COMMENT 'Thời gian xóa (Khi thi xong hoặc quá thời gian thi thì sẽ xóa)',
 PRIMARY KEY (session_id)
) ENGINE=MyISAM";


// Ngân hàng đề thi
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_bank (
  id mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  idsite mediumint(8) unsigned NOT NULL DEFAULT '0',
  id_exam mediumint(4) unsigned NOT NULL COMMENT 'id đề thi',
  userid mediumint(8) unsigned NOT NULL DEFAULT '0',
  title varchar(255) NOT NULL COMMENT 'Tên gọi đợt thi',
  alias varchar(255) NOT NULL,
  hometext varchar(255) NOT NULL,
  description text NOT NULL COMMENT 'Ghi chú',
  catid smallint(4) unsigned NOT NULL,
  question_list TEXT NOT NULL,
  num_question smallint(4) unsigned NOT NULL,
  count_question smallint(4) unsigned NOT NULL DEFAULT '0',
  timer smallint(4) unsigned NOT NULL,
  ladder smallint(4) unsigned NOT NULL DEFAULT '10',
  addtime int(11) unsigned NOT NULL,
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  reasonReject varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_bank_cats(
  id tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL DEFAULT '',
  parentid INT NOT NULL DEFAULT '0',
  note varchar(255) NOT NULL,
  keywords TEXT NULL,
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  weight tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_exams_bank_question(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  qsIdSite mediumint(8) unsigned NOT NULL,
  examid mediumint(8) unsigned NOT NULL DEFAULT 0,
  typeid smallint(4) unsigned NOT NULL DEFAULT 0,
  bank_type tinyint(1) unsigned NOT NULL DEFAULT 0,
  title text NOT NULL COMMENT 'Nội dung câu hỏi',
  useguide text NOT NULL COMMENT 'Lời giải',
  type tinyint(1) unsigned NOT NULL DEFAULT '1',
  answer text NOT NULL,
  note tinytext NOT NULL COMMENT 'Ghi chú',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  answer_style tinyint(1) unsigned NOT NULL DEFAULT '0',
  count_true tinyint(2) unsigned NOT NULL,
  max_answerid tinyint(2) unsigned NOT NULL DEFAULT '0',
  generaltext text NOT NULL,
  answer_editor tinyint(1) unsigned NOT NULL DEFAULT '0',
  answer_editor_type tinyint(1) unsigned NOT NULL default '0' COMMENT 'Công cụ soạn thảo nội dung trả lời',
  answer_fixed tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Cố định vị trí đáp án',
  point double unsigned NOT NULL DEFAULT '0',
  addtime int(11) unsigned NOT NULL,
  userid mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_history_merge (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  examid_list text NOT NULL COMMENT 'ID đề thi',
  title varchar(255) NOT NULL DEFAULT '' COMMENT 'Đề thi đã trộn',
  content text NOT NULL COMMENT 'Cấu trúc và kết quả',
  number_exams INT(10) NOT NULL,
  create_time int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian tạo đề, mặc định là thời gian xuất đề thi',
  PRIMARY KEY (id),
  KEY id (id),
  KEY create_time (create_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_noview_msg (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  userid	mediumint(8) unsigned NOT NULL,
  func varchar(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$array_data = array(
    'enable_social' => 1,
    'enable_editor' => 1,
    'question_ads' => 10,
    'tags_alias_lower' => 1,
    'tags_alias' => 0,
    'auto_tags' => 0,
    'tags_remind' => 1,
    'no_image' => '',
    'structure_upload' => 'Ym',
    'indexfile' => 1,
    'st_links' => 5,
    'per_page' => 15,
    'imgposition' => 0,
    'showhometext' => 1,
    'groups_use' => '6',
    'examp_template' => 1,
    'sample_deleted' => 0,
    'auto_postcomm' => 1,
    'allowed_comm' => -1,
    'view_comm' => 6,
    'setcomm' => 4,
    'activecomm' => 1,
    'emailcomm' => 0,
    'adminscomm' => '',
    'sortcomm' => 0,
    'captcha' => 1,
    'perpagecomm' => 5,
    'timeoutcomm' => 360,
    'preview_question' => 0,
    'config_source' => 0,
    'order_exams' => 0,
    'oaid' => '',
    'alert_type' => 0,
    'allow_del_history' => 0,
    'allow_question_point' => 0,
    'block_copy_paste' => 0,
    'allow_question_type' => '1,2,3,4',
    'config_history_user_common' => '0',
    'payment' => ''
);

if (!isset($sample_delete)) {
    foreach ($array_data as $config_name => $config_value) {
        $sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', " . $db->quote($module_name) . ", " . $db->quote($config_name) . ", " . $db->quote($config_value) . ")";
    }
}

// Insert config image exam
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'homewidth', '100')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'homeheight', '150')";