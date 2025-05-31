<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 02 Jun 2015 07:53:31 GMT
 * Hổ trợ trong việc đưa các bài ngẫu nhiên vào các môn thi trong một kỳ thi
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;
$subjectid = $nv_Request->get_int('subjectid', 'get,post', 0);
$db->sqlreset()
->select('*')
->from(NV_PREFIXLANG . '_' . $module_data . '_exam_subject')
->where('id =' . $subjectid);
$SUBJECT= $db->query($db->sql())->fetch(2);
if (empty($SUBJECT)) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=examinations' );
    die();
}

$db->sqlreset()
->select('code')
->from(NV_PREFIXLANG . '_' . $module_data . '_exam_subject')
->where('id=' . $subjectid);
list($code) = $db->query($db->sql())->fetch(3);
if (!empty($code)) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=random_exam&subjectid=' . $subjectid );
    die();
}
if ($nv_Request->isset_request('add_examid', 'get') and $nv_Request->isset_request('exam_checkss', 'get')) {
    
    $id = $nv_Request->get_int('add_examid', 'get');
    $exam_checkss = $nv_Request->get_string('exam_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get', '');
    if ($id > 0 and $exam_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_subject_questions (subjectid, examsid) VALUES (:subjectid, :examsid)';
        $data_insert = array();
        $data_insert['subjectid'] = $subjectid;
        $data_insert['examsid'] = $id;
        $new_id = $db->insert_id($_sql, 'id', $data_insert);
        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('add_exams_subject') , "(#". $id . ")" , $admin_info['userid']);
        $nv_Cache->delMod($module_name);
        Header('Location: ' . nv_redirect_decrypt($redirect));
        die();
    }
}
$page = $nv_Request->get_int('page', 'post,get', 1);
$per_page = $nv_Request->get_int('per_page', 'post,get', 30);
$order = $nv_Request->get_title('order', 'post,get', '');
$q = $nv_Request->get_title('q', 'post,get','');
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;subjectid=' . $subjectid ;
$base_url = (!empty($q)) ? $base_url . '&amp;q=' . $q : $base_url; 

$db->sqlreset()
->select('COUNT(*)')
->from(NV_PREFIXLANG . '_' . $module_data . '_exams AS t1')
->join('INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_cat AS t2 ON t1.catid = t2.id' 
//.' LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_subject_questions AS t3 ON t1.id = t3.examsid'
);


if (!empty($q)) {
    $db->where('t1.title LIKE "%' . $q . '%"');
}

$sth = $db->prepare($db->sql());
$sth->execute();
$num_items = $sth->fetchColumn();

$data = array();
$db->select('t1.id, t1.title, t1.num_question, t2.title as title_cat')
->limit($per_page)
->offset(($page - 1) * $per_page);
if (!empty($order)) {
    $base_url .= '&amp;order=' . $order;
    if ($order == 'cat') {
        $db->order('t1.catid ASC');
    }elseif ($order == 'title') {
        $db->order('t1.title ASC');
    }
}
$result = $db->query($db->sql());
$examsids = array();
while ($row = $result->fetch(2)) {
    $data[$row['id']] = $row;
}
$db->sqlreset()
->select('*')
->from(NV_PREFIXLANG . '_' . $module_data . '_subject_questions')
->where('subjectid = ' . $subjectid . ' AND examsid IN (' . implode(',', array_keys($data) ) . ')' );
$result = $db->query($db->sql());
while ($row = $result->fetch(2)) {
    $data[$row['examsid']]['subjectid'] = $row['subjectid'];
}
$page_title = $nv_Lang->getModule('add_exams');
$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('NV_LANG_INTERFACE', NV_LANG_INTERFACE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('q', $q);
$xtpl->assign('OP', $op);
$xtpl->assign('SUBJECT', $SUBJECT);
$xtpl->assign('come_back', NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=random_exam' . '&amp;subjectid=' . $subjectid);
$xtpl->assign('base_url', NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;subjectid=' . $subjectid);
$tt = 0;
foreach ($data as $row) {
    $row['tt'] = ++$tt;
    $row['feature'] = ($row['subjectid'] != $subjectid) ? "<a class=\"btn btn-success btn-xs\" href=\"" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;subjectid=' . $subjectid . '&amp;add_examid=' . $row['id'] . '&amp;exam_checkss=' . md5($row['id'] . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']) . "\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getGlobal('add') . "\"><em class=\"fa fa-plus\">  ". $nv_Lang->getGlobal('add') . "</em></a>" : '<strong>' . $nv_Lang->getModule('had_add') . '</strong>';
    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}

$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';