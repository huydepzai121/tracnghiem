<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 02 Jun 2015 07:53:31 GMT
 * Hổ trợ trong việc đưa các câu hỏi ngẫu nhiên vào các môn thi trong một kỳ thi
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;


$subjectid = $nv_Request->get_int('subjectid', 'get', 0);
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

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get', '');
    if (!empty($code)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=random_question&subjectid=' . $subjectid . '&not_del_examinations=1' );
        die();
    }
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject_questions WHERE id = ' . $id);
        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('del_question_subject') , "(#". $id . ")" , $admin_info['userid']);
        $nv_Cache->delMod($module_name);
        Header('Location: ' . nv_redirect_decrypt($redirect));
        die();
    }
}
$page = $nv_Request->get_int('page', 'post,get', 1);
$per_page = $nv_Request->get_int('per_page', 'post,get', 30);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;subjectid=' . $subjectid ;

$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_subject_questions AS t1')
    ->join('INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_question AS t2 ON t1.questionid = t2.id ')
    ->where('t1.subjectid = ' . $subjectid );

$sth = $db->prepare($db->sql());
$sth->execute();
$num_items = $sth->fetchColumn();
$data = array();
$db->select('t1.id, t2.title, t2.bank_type')
    ->order('t1.id DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());
$sth->execute();
$tt = 0;
while ($row = $sth->fetch(2)) {
    $row['tt'] = ++$tt;
    $row['bank_type_title'] = $array_bank_type[$row['bank_type']]['title'];
    $data[] = $row;
}
$not_del_examinations = $nv_Request->get_int('not_del_examinations', 'post,get', 0);
$page_title = $nv_Lang->getModule('random_exam');
$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('SUBJECT', $SUBJECT);
$xtpl->assign('link_come_back', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exam-subject&amp;exam_id=' . $SUBJECT['exam_id']);
$xtpl->assign('link_add_question', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=bank&amp;subjectid=' . $subjectid);
if (!empty($not_del_examinations)) {
    $xtpl->parse('main.examinations_title');
}
$tt = 0;
foreach ($data as $row) {
    $row['tt'] = ++$tt;
    $row['feature'] = "<a class=\"btn btn-danger btn-xs\" href=\"" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $row['id'] . '&amp;subjectid=' . $subjectid . '&amp;delete_checkss=' . md5($row['id'] . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']) . "\" onclick=\"return confirm(nv_is_del_confirm[0]);\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getGlobal('delete') . "\"><em class=\"fa fa-trash-o\">". $nv_Lang->getGlobal('delete') . "</em></a>";
    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
if (empty($code)) {
    $xtpl->parse('main.add_exams');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';