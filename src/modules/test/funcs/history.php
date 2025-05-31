<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2017 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 15 Apr 2017 07:49:06 GMT
 */
if (!defined('NV_IS_MOD_TEST')) {
    die('Stop!!!');
}

if (!defined('NV_IS_USER') && !defined('NV_IS_MODADMIN')) {
    Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($client_info['selfurl']));
    die();
}
if ($global_config['cid'] == 3) {
    $mes = intval(strtotime("2021-01-18")) > intval($global_config['addtime_site']) ? $nv_Lang->getModule('disallow_history_old'): $nv_Lang->getModule('disallow_history_new');
    $contents = "<h2 class=\"disallow-history\">". $mes ."</h2>";
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

if ($nv_Request->isset_request('deletehistory', 'post')) {
    if ($array_config['allow_del_history']) {
        $id = $nv_Request->get_int('id', 'post', 0);
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE userid=' . $user_info['userid'] . ' AND id=' . $id);
        die('OK');
    }
    die('NO');
}

$id = $nv_Request->get_int('id', 'get', 0);
if (!empty($id)) {
    $answer_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE id=' . $id)->fetch();
    if (empty($answer_info)) {
        Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=history');
        die();
    }

    $exams_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $answer_info['exam_id'])->fetch();
    if (empty($exams_info)) {
        Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=history');
        die();
    }

    $exams_info['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exams_info['catid']]['alias'] . '/' . $exams_info['alias'] . '-' . $exams_info['id'] . $global_config['rewrite_exturl'];
    $time_test = $answer_info['end_time'] - $answer_info['begin_time'];
    $answer_info['time_test'] = nv_convertfromSec($time_test);
    $percent = ($answer_info['count_true'] * 100) / $exams_info['num_question'];
    $answer_info['rating'] = nv_get_rating($percent);

    $xtpl = new XTemplate('history-detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('OP', $op);
    $xtpl->assign('ANSWER_INFO', $answer_info);
    $xtpl->assign('EXAM_INFO', $exams_info);
    $xtpl->assign('VIEW_ANSWER', nv_test_history_view_answer($exams_info, $answer_info));

    if ($array_config['allow_del_history']) {
        $xtpl->parse('main.del_history');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    $page_title = $nv_Lang->getModule('history_detail');
    $array_mod_title[] = array(
        'title' => $nv_Lang->getModule('history'),
        'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['history']
    );
    $array_mod_title[] = array(
        'title' => $page_title
    );

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$per_page = 20;
$page = 1;
if (isset($array_op[1]) and substr($array_op[1], 0, 5) == 'page-') {
    $page = intval(substr($array_op[1], 5));
}

$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_answer')
    ->where('userid=' . $user_info['userid']);

$sth = $db->prepare($db->sql());
$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('*')
    ->order('id DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());
$sth->execute();

$xtpl = new XTemplate('history.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$array_exam = array();
$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
while ($view = $sth->fetch()) {
    $view['number'] = $number++;
    $view['mark_constructed_response'] = array_reduce(nv_unserialize($view['mark_constructed_response']), 
        function($item1, $item2) {
            return $item1+$item2;
        }, 0
    );
    $view['score'] += $view['mark_constructed_response'];



    if (!isset($array_exam[$view['exam_id']])) {
        $exam_info = $db->query('SELECT id, title, alias, catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $view['exam_id'])->fetch();
        $view['exam'] = $array_exam[$view['exam_id']] = $exam_info;
    } else {
        $view['exam'] = $array_exam[$view['exam_id']];
    }
    $percent = ($view['count_true'] * 100) / ($view['count_true'] + $view['count_false'] + $view['count_skeep']);
    $view['rating'] = nv_get_rating($percent);
    $view['time_test'] = nv_convertfromSec($view['end_time'] - $view['begin_time']);
    $view['begin_time'] = (empty($view['begin_time'])) ? '' : nv_date('H:i:s d/m/Y', $view['begin_time']);
    $view['end_time'] = (empty($view['end_time'])) ? '' : nv_date('H:i:s d/m/Y', $view['end_time']);
    $view['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$view['exam']['catid']]['alias'] . '/' . $view['exam']['alias'] . '-' . $view['exam']['id'] . $global_config['rewrite_exturl'];
    $view['url_share'] = NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=share&id=' . $view['id'], true);
    $view['link_view'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['history'] . '&amp;id=' . $view['id'], true);
    $xtpl->assign('VIEW', $view);
    if ($array_config['allow_del_history']) {
        $xtpl->parse('main.loop.del_history');
    }
    $xtpl->parse('main.loop');
}

if ($page > 1) {
    $page_title = $page_title . ' - ' . $nv_Lang->getGlobal('page') . ' ' . $page;
}

$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('history');
$array_mod_title[] = array(
    'title' => $page_title,
    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op
);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';