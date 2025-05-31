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

function nv_examinations_delete($id) {
    global $module_data, $db;
    $db->sqlreset()
    ->select('COUNT(*)')
    ->from( NV_PREFIXLANG . '_' . $module_data . '_exam_subject')
    ->where('exam_id=' . $id);
    $numrows = $db->query($db->sql())->fetchColumn();
    if (empty($numrows)) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_examinations WHERE id = ' . $id);
    } else {
        return 'you_need_delete_subject';
    }
    return 'OK';
}
/*
* Lấy tất cả câu hỏi được sử dụng trong kỳ thi ở tất cả các môn
*/
function nv_examinations_question($id) {
    global $db, $module_data;
    $questionids = array();
    $examsid = array();
    $db->sqlreset()
    ->select('t3.*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_examinations AS t1')
    ->join('INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject AS t2 ON t1.id = t2.exam_id ' .
    'INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_subject_questions AS t3 ON t2.id = t3.subjectid ' 
    )
    ->where('t1.id=' . $id);
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        if (!empty($row['questionid'])) {
            $questionids[$row['questionid']] = true;
        }
        if (!empty($row['examsid'])) {
            $examsid[] = $row['examsid'];
        }
    }
    if (!empty($examsid)) {
        $db->sqlreset()
        ->select('questionid')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_exams_question')
        ->where('examsid IN (' . implode(',', $examsid) . ')');
        $result = $db->query($db->sql());
        while ($row = $result->fetch(2)) {
            if (!empty($row['questionid'])) {
                $questionids[$row['questionid']] = true;
            }
        }
        $db->sqlreset()
        ->select('id')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_question')
        ->where('examid IN (' . implode(',', $examsid) . ')');
        $result = $db->query($db->sql());
        while ($row = $result->fetch(2)) {
            if (!empty($row['id'])) {
                $questionids[$row['id']] = true;
            }
        }
    }
    return array_keys($questionids);
}
if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get', '');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $msg = nv_examinations_delete($id);
        $nv_Cache->delMod($module_name);
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op .  ( ($msg !== 'OK') ? '&msg=' . $msg: '' ));
        die();
    }
} elseif ($nv_Request->isset_request('delete_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);

    if (!empty($array_id)) {
        foreach ($array_id as $id) {
            nv_examinations_delete($id);
        }
        $nv_Cache->delMod($module_name);
        die('OK');
    }
    die('NO');
}
// change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);

    if (!$id) die('NO');

    $query = 'SELECT status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_examinations WHERE id=' . $id;
    $result = $db->query($query);
    $numrows = $result->rowCount();
    if ($numrows > 0) {
        $active = 1;
        foreach ($result as $row) {
            if ($row['status'] == 1) {
                $active = 0;
            } else {
                $active = 1;
            }
        }
        $query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_examinations SET
				status=' . $db->quote($active) . '
				WHERE id=' . $id;
        $db->query($query);
    }
    $nv_Cache->delMod($module_name);
    die('OK');
}
$per_page = $array_config['per_page'];
$msg = $nv_Request->get_title('msg', 'post,get', 0);
$page = $nv_Request->get_int('page', 'post,get', 1);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$array_search = array(
    'q' => $nv_Request->get_title('q', 'post,get',''),
    'begintime' => $nv_Request->get_title('begintime', 'post,get', ''),
    'endtime' => $nv_Request->get_title('endtime', 'post,get', '')
);
$where = '1 = 1';
$db->sqlreset()
    ->select('COUNT(*)')
    ->from('' . NV_PREFIXLANG . '_' . $module_data . '_examinations');

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND title LIKE :q_title';
}
if (!empty($array_search['begintime'])) {
    $begintime = strtotime(date_format(date_create_from_format("j/n/Y", $array_search['begintime']), "Y-m-d"));
    $base_url .= '&begintime=' . $array_search['begintime'];
    $where .= ' AND begintime >= ' . $begintime;
}
if (!empty($array_search['endtime'])) {
    $endtime = strtotime(date_format(date_create_from_format("j/n/Y", $array_search['endtime']), "Y-m-d"));
    $base_url .= '&endtime=' . $array_search['endtime'];
    $where .= ' AND begintime <= ' . $endtime;
}
$db->where($where);
$sth = $db->prepare($db->sql());
if (!empty($array_search['q'])) {
    $sth->bindValue(':q_title', '%' . $array_search['q'] . '%');
}
$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('*')
    ->order('id DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());

if (!empty($array_search['q'])) {
    $sth->bindValue(':q_title', '%' . $array_search['q'] . '%');
}
$sth->execute();

$array_data = array();
$examinationids = array();
while ($view = $sth->fetch()) {
    $view['begintime'] = date('d/m/Y', $view['begintime']);
    $view['endtime'] = date('d/m/Y', $view['endtime']);
    $view['num_subject'] = 0;
    $array_data[$view['id']] = $view;
    $examinationids[] = $view['id'];

}

if (!empty($examinationids)) {
    $db->sqlreset()
    ->select('exam_id, count(exam_id) AS num ')
    ->from( NV_PREFIXLANG . '_' . $module_data . '_exam_subject')
    ->group('exam_id')
    ->where('exam_id IN (' . implode(',', $examinationids). ')');
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        $array_data[$row['exam_id']]['num_subject'] = $row['num'];
    }
}

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
$xtpl->assign('OP', $op);
$xtpl->assign('SEARCH', $array_search);
$xtpl->assign('URL_ADD', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=examinations-content');
$xtpl->assign('URL_DELETE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=modules');
$xtpl->assign('BASE_URL', $base_url);
if (!empty($msg)) {
    $xtpl->assign('msg', $lang_module[$msg]);
    $xtpl->parse('main.msg');
}
foreach ($array_data as $view) {
    $admin_funcs = array();
    $admin_funcs[] = "<a href=\"". NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exam-subject&amp;exam_id=' . $view['id'] ."\" class=\"btn btn-default btn-xs\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getModule('examinations_subject') . "\"><em class=\"fa fa-bars\">&nbsp;</em> <span class=\"text-danger hidden-xs\">(" . $view['num_subject'] .")</span></a>";
    if (empty($view['num_subject'])) {
        $admin_funcs[] = "<a class=\"btn btn-default btn-xs btn_edit\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=examinations-content&amp;id=" . $view['id'] . "&amp;redirect=" . nv_redirect_encrypt($client_info['selfurl']) . "\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getGlobal('edit') . "\"><em class=\"fa fa-edit\"></em>" . $nv_Lang->getGlobal('edit') . "</a>";
        $admin_funcs[] = "<a class=\"btn btn-danger btn-xs\" href=\"" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']) . "\" onclick=\"return confirm(nv_is_del_confirm[0]);\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getGlobal('delete') . "\"><em class=\"fa fa-trash-o\"></em>". $nv_Lang->getGlobal('delete') . "</a>";
    }
    $view['feature'] = implode('&nbsp;', $admin_funcs);
    $view['link'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=examinations-subject/' . $view['alias'], true);
    $xtpl->assign('VIEW', $view);
    $xtpl->assign('CHECK', !empty($view['status']) ? 'checked' : '');
    $xtpl->parse('main.loop');
}
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
$array_action = array();

if (defined('NV_IS_ADMIN_MODULE') || isset($_permission_action['delete_list_id'])) {
    $array_action['delete_list_id'] = $nv_Lang->getGlobal('delete');
}

if (!empty($array_action)) {
    foreach ($array_action as $key => $value) {
        $action_assign = array(
            'key' => $key,
            'value' => $value
        );
        $xtpl->assign('ACTION', $action_assign);
        $xtpl->parse('main.action_top.loop');
        $xtpl->parse('main.action_bottom.loop');
    }
    $xtpl->parse('main.action_top');
    $xtpl->parse('main.action_bottom');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('examinations');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';