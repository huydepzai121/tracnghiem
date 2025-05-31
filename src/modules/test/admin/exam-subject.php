<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 02 Jun 2015 07:53:31 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;

if ($nv_Request->isset_request('get_alias_title', 'post')) {
    $alias = $nv_Request->get_title('get_alias_title', 'post', '');
    $alias = change_alias($alias);
    if ($array_config['tags_alias_lower']) {
        $alias = strtolower($alias);
    }
    die($alias);
}
$exam_id = $nv_Request->get_int('exam_id', 'get', 0);
$id = $nv_Request->get_int('id', 'get', 0);
$exam_subject = array(
    'id' => 0,
    'title' => '',
    'alias' => '',
    'image' => '',
    'begintime' => NV_CURRENTTIME,
    'endtime' => 0,
    'exam_id' => $exam_id,
    'exam_type' => 'random_exam',
    'ladder' => 10,
    'timer' => 90,
    'num_question' => 0,
    'description' => '',
);

$db->sqlreset()
->select('*')
->from(NV_PREFIXLANG . '_' . $module_data . '_examinations')
->where('id =' . $exam_id);
$examinations= $db->query($db->sql())->fetch(2);
if (empty($examinations)) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=examinations' );
    die();
}
$error = '';
if ($nv_Request->isset_request('submit', 'post')) {

    $exam_subject['begintime'] = 0;
    $exam_subject['endtime'] = 0;
    $exam_subject['id'] = $nv_Request->get_int('id', 'post', 0);
    $exam_subject['title'] = $nv_Request->get_title('title', 'post', '');
    $exam_subject['alias'] = $nv_Request->get_title('alias', 'post', '');
    $exam_subject['image'] = $nv_Request->get_title('image', 'post', '');
    $exam_subject['exam_id'] = $nv_Request->get_int('exam_id', 'post', '');
    $exam_subject['exam_type'] = $nv_Request->get_title('exam_type', 'post', '');
    $exam_subject['ladder'] = $nv_Request->get_int('ladder', 'post', '');
    $exam_subject['timer'] = $nv_Request->get_int('timer', 'post', '');
    $exam_subject['num_question'] = $nv_Request->get_int('num_question', 'post', '');
    $exam_subject['description'] = $nv_Request->get_title('description', 'post', '');

    list($code) = $db->query('SELECT code FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject WHERE id = ' . $exam_subject['id'])->fetch(3);
    if (!empty($code)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&exam_id='.  $exam_id . '&msg_error=error_not_update_exam_subject');
        die();
    }

    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('begindate', 'post'), $m)) {
        $begintime = $nv_Request->get_string('begintime', 'post');
        $begintime = !empty($begintime) ? explode(':', $begintime) : array(
            0,
            0
        );
        $exam_subject['begintime'] = mktime($begintime[0], $begintime[1], 0, $m[2], $m[1], $m[3]);
    }

    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('enddate', 'post'), $m)) {
        $endtime = $nv_Request->get_string('endtime', 'post');
        $endtime = !empty($endtime) ? explode(':', $endtime) : array(
            23,
            59
        );
        $exam_subject['endtime'] = mktime($endtime[0], $endtime[1], 0, $m[2], $m[1], $m[3]);
    }

    if (empty($exam_subject['alias'])) {
        $exam_subject['alias'] = $exam_subject['title'];
    }
    $exam_subject['alias'] = change_alias($exam_subject['alias']);


    if (empty($exam_subject['title'])) {
        $error=$nv_Lang->getModule('error_required_title');
    }
    elseif (empty($exam_subject['ladder'])) {
        $error=$nv_Lang->getModule('error_required_ladder');
    }
    elseif (empty($exam_subject['timer'])) {
        $error=$nv_Lang->getModule('error_required_timer');
    }
    elseif (empty($exam_subject['begintime']) || empty($exam_subject['endtime']) || ($exam_subject['endtime'] <= NV_CURRENTTIME) || ($exam_subject['endtime'] <= $exam_subject['begintime'])) {
        $error=$nv_Lang->getModule('error_time_examinations');
    }
    else {
        if (empty($exam_subject['id'])) {

            $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject (title, alias, image,  begintime, endtime, exam_id, exam_type, ladder, timer, num_question, description) VALUES (:title, :alias, :image, :begintime, :endtime, :exam_id, :exam_type, :ladder, :timer, :num_question, :description)';

            $data_insert = array();
            $data_insert['title'] = $exam_subject['title'];
            $data_insert['alias'] = $exam_subject['alias'];
            $data_insert['image'] = $exam_subject['image'];
            $data_insert['begintime'] = $exam_subject['begintime'];
            $data_insert['endtime'] = $exam_subject['endtime'];
            $data_insert['exam_id'] = $exam_subject['exam_id'];
            $data_insert['exam_type'] = $exam_subject['exam_type'];
            $data_insert['ladder'] = $exam_subject['ladder'];
            $data_insert['timer'] = $exam_subject['timer'];
            $data_insert['num_question'] = $exam_subject['num_question'];
            $data_insert['description'] = $exam_subject['description'];
            $new_id = $db->insert_id($_sql, 'id', $data_insert);
            nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('examinations_subject_add') , $exam_subject['title'] . "(#". $new_id . ")" , $admin_info['userid']);
        }
        else {
            $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject SET title = :title, alias = :alias, image = :image, begintime = :begintime, endtime = :endtime, exam_id = :exam_id, exam_type = :exam_type, ladder = :ladder, timer = :timer, num_question = :num_question, description = :description WHERE id=' . $exam_subject['id']);
            $stmt->bindParam(':title', $exam_subject['title'], PDO::PARAM_STR);
            $stmt->bindParam(':alias', $exam_subject['alias'], PDO::PARAM_STR);
            $stmt->bindParam(':image', $exam_subject['image'], PDO::PARAM_STR);
            $stmt->bindParam(':begintime', $exam_subject['begintime'], PDO::PARAM_INT);
            $stmt->bindParam(':endtime', $exam_subject['endtime'], PDO::PARAM_INT);
            $stmt->bindParam(':exam_id', $exam_subject['exam_id'], PDO::PARAM_INT);
            $stmt->bindParam(':exam_type', $exam_subject['exam_type'], PDO::PARAM_STR);
            $stmt->bindParam(':ladder', $exam_subject['ladder'], PDO::PARAM_INT);
            $stmt->bindParam(':timer', $exam_subject['timer'], PDO::PARAM_INT);
            $stmt->bindParam(':num_question', $exam_subject['num_question'], PDO::PARAM_INT);
            $stmt->bindParam(':description', $exam_subject['description'], PDO::PARAM_STR);
            if ($stmt->execute()) {
                $new_id = $exam_subject['id'];
                nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('examinations_subject_edit') , $exam_subject['title'] . "(#". $new_id . ")" , $admin_info['userid']);
            }
        }
        if ($new_id > 0) {
            $nv_Cache->delMod($module_name);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exam-subject' . '&exam_id=' . $exam_subject['exam_id']);
            die();
        }
    }

}

if ($nv_Request->isset_request('create_code', 'get') and $nv_Request->isset_request('create_checkss', 'get')) {
    $id = $nv_Request->get_int('id', 'get, post',0);
    $create_checkss = $nv_Request->get_string('create_checkss', 'get');

    if ($id > 0 and $create_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        list($old_code) = $db->query('SELECT code FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject WHERE id=' . $id )->fetch(3);
        $code = nv_genpass(6,3);
        $db->query('UPDATE ' .  NV_PREFIXLANG . '_' . $module_data . '_exam_subject SET code = "' . $code . '" WHERE id = ' . $id);
        $questionids = get_exam_subject_question($id);

        if (!empty($questionids) && empty($old_code)) {
            $db->query('UPDATE ' .  NV_PREFIXLANG . '_' . $module_data . '_question SET exam_subject = "' . $id . '" WHERE id IN( ' . implode(',', $questionids) . ')');
        }
        nv_jsonOutput($code);
        exit();
    }
}
if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get', '');
    list($code) = $db->query('SELECT code FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject  WHERE id = ' . $id)->fetch(3);
    if (!empty($code)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&exam_id='.  $exam_id . '&msg_error=error_not_del_exam_subject');
        die();
    }

    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject_questions WHERE subjectid = ' . $id);
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject WHERE id = ' . $id);
        $nv_Cache->delMod($module_name);
        if (!empty($redirect)) {
            Header('Location: ' . nv_redirect_decrypt($redirect));
            die();
        }
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&exam_id=' . $exam_id);
        die();
    }
}
$db->sqlreset()
->select('*')
->from(NV_PREFIXLANG . '_' . $module_data . '_exam_subject')
->where('exam_id = ' . $exam_id);
$result = $db->query($db->sql());
$data = array();
$subjectids = array();
while ( $row = $result->fetch(2)) {
    if ($row['id'] == $id) {
        $exam_subject = $row;
    }
    $row['link_random_subject'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['exam_type'] . '&amp;subjectid=' . $row['id'];
    $row['random_subject_title'] = $nv_Lang->getModule($row['exam_type']);
    $row['num_subject'] = 0;
    $row['begin_time_str'] = date('H:i d/m/Y', $row['begintime']);
    $row['end_time_str'] = date('H:i d/m/Y', $row['endtime']);
    $row['link_report'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=history&amp;exam_subject=' . $row['id'];
    $row['create_checkss'] = md5($row['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
    $subjectids[] = $row['id'];
    $data[$row['id']] = $row;
}

if (!empty($subjectids)) {
    $db->sqlreset()
    ->select('subjectid, count(subjectid) AS num ')
    ->from( NV_PREFIXLANG . '_' . $module_data . '_subject_questions')
    ->group('subjectid')
    ->where('subjectid IN (' . implode(',', $subjectids). ')');
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        $data[$row['subjectid']]['num_subject'] = $row['num'];
    }
}
$msg_error = $nv_Request->get_string('msg_error', 'post,get', '');

$exam_subject['begindate'] = !empty($exam_subject['begintime']) ? date('d/m/Y', $exam_subject['begintime']) : '';
$exam_subject['begintime'] = !empty($exam_subject['begintime']) ? date('H:i', $exam_subject['begintime']) : '';
$exam_subject['enddate'] = !empty($exam_subject['endtime']) ? date('d/m/Y', $exam_subject['endtime']) : '';
$exam_subject['endtime'] = !empty($exam_subject['endtime']) ? date('H:i', $exam_subject['endtime']) : '';
$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('NV_LANG_INTERFACE', NV_LANG_INTERFACE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('EXAMINATION', $examinations);
$xtpl->assign('ROW', $exam_subject);
$xtpl->assign('selected_random_exam', $exam_subject['exam_type']=='random_exam' ? 'selected' : '');
$xtpl->assign('selected_random_question',  $exam_subject['exam_type']=='random_question' ? 'selected' : '');
$xtpl->assign('status_save', !empty($exam_subject['id']) ? $nv_Lang->getModule('examinations_subject_edit') : $nv_Lang->getModule('examinations_subject_add'));
$xtpl->assign('TIME', sprintf($nv_Lang->getModule('time_begin_end'), date('d/m/Y', $examinations['begintime']), date('d/m/Y', $examinations['endtime'])));
$xtpl->assign('OP', $op);
if (!empty($msg_error)) {
    $xtpl->assign('msg_error', $nv_Lang->getModule($msg_error));
    $xtpl->parse('main.msg_error');
}
$tt=0;
foreach ($data as $view) {
    $view['tt'] = ++$tt;
    $view['examp_type_title'] = $nv_Lang->getModule($view['exam_type']);
    $admin_funcs = array();
    $admin_funcs[] = "<a class=\"btn btn-default btn-xs btn_edit\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE  . '=' . $op ."&amp;exam_id=" . $exam_id . "&amp;id=" . $view['id'] . "\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getGlobal('edit') . "\"><em class=\"fa fa-edit\"></em>" . $nv_Lang->getGlobal('edit') . "</a>";

    $admin_funcs[] = "<a class=\"btn btn-danger btn-xs\" href=\"" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op  ."&amp;exam_id=" . $exam_id . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']) . "\" onclick=\"return confirm(nv_is_del_confirm[0]);\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getGlobal('delete') . "\"><em class=\"fa fa-trash-o\"></em>" . $nv_Lang->getGlobal('delete') . "</a>";

    $view['feature'] = implode('&nbsp;', $admin_funcs);
    $view['link'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $examinations['alias'] .'/' . $view['alias'], true);
    $view['from_to'] = sprintf($nv_Lang->getModule('time_begin_end'), $view['begin_time_str'], $view['end_time_str']);
    $xtpl->assign('VIEW', $view);
    if (($view['num_subject'] != 0) || ($view['num_question'] != 0)) {
        $xtpl->parse('main.loop.create_code');
    }
    $xtpl->parse('main.loop');
}
if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');
$page_title = $nv_Lang->getModule('examinations_subject');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';