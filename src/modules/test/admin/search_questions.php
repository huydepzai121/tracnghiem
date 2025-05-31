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
function get_bank_by_parentid($parentid = 0) {
    global $db, $module_data;
    $array_bank = array();
    $db->sqlreset()
    ->select('id, title')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_bank')
    ->where('parentid = ' . $parentid)
    ->order('weight ASC');
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        $array_bank[] = $row;
    }
    return $array_bank;
}
$error = '';
$bank = $nv_Request->get_int('bank', 'post,get', 0);
$table_exams = NV_PREFIXLANG . '_' . $module_data . '_exams';
$table_question = NV_PREFIXLANG . '_' . $module_data . '_question';
if($bank){
    $table_exams = tableSystem . '_exams_bank';
    $table_question = tableSystem . '_exams_bank_question';
}
if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        nv_delete_question($table_exams, $table_question, $id);
        $nv_Cache->delMod($module_name);
        if (!empty($redirect)) {
            $url = nv_redirect_decrypt($redirect);
        } else {
            $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;
        }
        Header('Location: ' . $url);
        die();
    }
} elseif ($nv_Request->isset_request('delete_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);

    if (!empty($array_id)) {
        foreach ($array_id as $question_id) {
            nv_delete_question($table_exams, $table_question,$question_id);
        }
        $nv_Cache->delMod($module_name);
        die('OK');
    }
    die('NO');
}
if ($nv_Request->isset_request('get_bank_html', 'get')) {
    $typeid = $nv_Request->get_int('typeid', 'get', 0);
    $html = '';
    $html = '<div class="col-xs-24 col-md-5">';
    $html .= '<div class="form-group">';
    $html .= '<select name="typeid" class="form-control">';
    $html .= '<option value="0" selected="selected">---' . $nv_Lang->getModule('select_category') . '---</option>';
    $html .= '{listoption}';
    $html .= '</select>';
    $html .= '</div>';
    $html .= '</div>';
    if (!empty($typeid)) {
        $listoption = '';
        $list_bank = get_bank_by_parentid($typeid);
        foreach ($list_bank as $row) {
            $listoption .= '<option value="' . $row['id'] .'">' . $row['title'] . '</option>';
        }
        $html = str_replace('{listoption}', $listoption, $html);
    }
    nv_htmlOutput($html);
    die();
}
$where = 'examid = 0 ';
$array_search = array(
    'q' => $nv_Request->get_title('q', 'post,get'),
    'bank_type' => $nv_Request->get_title('bank_type', 'get'),
    'bank_question' =>  $nv_Request->get_int('bank_question', 'get', 0),
    'typeid' =>  $nv_Request->get_int('typeid', 'get', 0),
);
$array_bank = get_bank_by_parentid();

// Fetch Limit
$per_page = $nv_Request->get_int('per_page', 'get', 20);
$page = $nv_Request->get_int('page', 'post,get', 1);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;per_page=' . $per_page;

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND title LIKE "%' . $array_search['q'] . '%"';
}

if (!empty($array_search['bank_type'])) {
    $base_url .= '&bank_type=' . $array_search['bank_type'];
    $where .= ' AND bank_type=' . $array_search['bank_type'];
}
if (!empty($array_search['bank_question']) && empty($array_search['typeid'])) {
    $base_url .= '&bank_question=' . $array_search['bank_question'];
    $ids_cat = get_bank_by_parentid($array_search['bank_question']);
    $ids_cat = array_map(function($item) {
        return $item['id'];
    }, $ids_cat);
    if (!empty($ids_cat)) {
        $where .= ' AND typeid IN (' . implode(',', $ids_cat) . ')';
    }
}

if (!empty($array_search['bank_question']) && !empty($array_search['typeid'])) {
    $base_url .= '&bank_question=' . $array_search['bank_question'];
    $base_url .= '&typeid=' . $array_search['typeid'];
    $where .= ' AND typeid=' . $array_search['typeid'];
}

$db->sqlreset()
    ->select('COUNT(*) ')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_question')
    ->where($where);
$sth = $db->prepare($db->sql());
$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('*')
    ->order('addtime DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());
$sth->execute();

$check_use_editor = false;
$array_question = array();
while ($row = $sth->fetch()) {
    $check_use_editor = $check_use_editor || ($row['answer_editor'] > 0);
    $array_question[] = $row;
}

// Chỉ xuất được file word khi không tồn tại câu hỏi nào có sử dụng editor
if ($nv_Request->isset_request('exportword', 'get') && !$check_use_editor) {
    exportWordforEdit('nganhangcauhoi.docx', null, $array_question);
    exit();
}

// Chỉ xuất được file excel khi không tồn tại câu hỏi nào có sử dụng editor
if ($nv_Request->isset_request('exportexcel', 'get') && !$check_use_editor) {
    exportExcelforEdit('nganhangcauhoi.xlsx', null, $array_question);
    exit();
}

// Cảnh báo khi xuất file word, excel mà tồn tại file sử dụng editor
if (($nv_Request->isset_request('exportword', 'get') || $nv_Request->isset_request('exportexcel', 'get')) && $check_use_editor) {
    $error = $nv_Lang->getModule('error_use_editor');
}


$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('SEARCH', $array_search);
$xtpl->assign('BASE_URL', $base_url);
$xtpl->assign('PAGE', $page);

$xtpl->assign('per_page_selected_10', $per_page == 10 ? 'selected' : '');
$xtpl->assign('per_page_selected_20', $per_page == 20 ? 'selected' : '');
$xtpl->assign('per_page_selected_50', $per_page == 50 ? 'selected' : '');
$xtpl->assign('per_page_selected_100', $per_page == 50 ? 'selected' : '');

$xtpl->assign('PACKAGE_NOTIICE', nv_package_notice(0));

if (!empty($error)) {
    $xtpl->assign('ERROR', $nv_Lang->getModule('error_use_editor'));
    $xtpl->parse('main.error');
}

if (!empty($global_config['guider'])) {
    if ($turn_off_msg) {
        $xtpl->parse('main.guider.msg_none');
    } else {
        $xtpl->parse('main.guider.msg_show');
    }
    $xtpl->parse('main.guider');
}

$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
foreach ($array_question as $view)
{
    if (!empty($error) && ($view['answer_editor'] > 0)) {
        $xtpl->assign('text_danger', 'text-danger');
    }
    $view['bank_type'] = ($view['bank_type'] !=0 ) ? $array_bank_type[$view['bank_type']]['title'] : $view['exam_title'];
    $view['addtime'] = !empty($view['addtime']) ? nv_date('H:i d/m/Y', $view['addtime']) 
        : ( !empty($view['exam_addtime']) ? nv_date('H:i d/m/Y', $view['exam_addtime']) : 'N/A');
    $view['edittime'] = !empty($view['edittime']) ? nv_date('H:i d/m/Y', $view['edittime']) : 'N/A'; 
    $view['title'] = strip_tags($view['title']);
    $view['link_edit'] =NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=question-content&amp;id=' . $view['id'] . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    $xtpl->assign('VIEW', $view);
    $xtpl->parse('main.loop');
}

foreach ($array_bank_type as $bank_type) {
    $bank_type['selected'] = $bank_type['id'] == $array_search['bank_type'] ? 'selected="selected"' : '';
    $xtpl->assign('BANK_TYPE', $bank_type);
    $xtpl->parse('main.bank_type');
}

foreach ($array_bank as $item) {
    $item['selected'] = $item['id'] == $array_search['bank_question'] ? 'selected="selected"' : '';
    $xtpl->assign('BANK_QUESTION', $item);
    $xtpl->parse('main.bank_question');
}
if (!empty($array_search['bank_question'])) {
    $array_bank_child = get_bank_by_parentid($array_search['bank_question']);
    foreach ($array_bank_child as $item) {
        $item['selected'] = $item['id'] == $array_search['typeid'] ? 'selected="selected"' : '';
        $xtpl->assign('TYPEID', $item);
        $xtpl->parse('main.bank_typeid');
    }
}
$array_action = array(
    'delete_list_id' => $nv_Lang->getGlobal('delete')
);
foreach ($array_action as $key => $value) {
    $xtpl->assign('ACTION', array(
        'key' => $key,
        'value' => $value
    ));
    $xtpl->parse('main.action_top');
    $xtpl->parse('main.action_bottom');
}
if ($global_config['import_word']) {
    $xtpl->parse('main.msword');
}
if ($global_config['import_excel']) {
    $xtpl->parse('main.msexcel');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('search_questions');
$set_active_op = 'search_question';

$array_mod_title[] = array(
    'title' => $page_title,
    'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=search_question'
);
krsort($array_mod_title, SORT_NUMERIC);

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';