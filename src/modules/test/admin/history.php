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

if ($nv_Request->isset_request('view_statistics', 'post,get')) {
    $id = $nv_Request->get_int('id', 'post,get', 0);

    $content = nv_view_statistics($id);
    die($content);
}

if ($nv_Request->isset_request('get_user_json', 'post, get')) {
    $q = $nv_Request->get_title('q', 'post, get', '');
    $db->sqlreset()
        ->select('userid, first_name, last_name, username, email')
        ->from(NV_USERS_GLOBALTABLE)
        ->where('(first_name LIKE "%' . $q . '%"
            OR last_name LIKE "%' . $q . '%"
            OR username LIKE "%' . $q . '%"
            OR email LIKE "%' . $q . '%")')
        ->order('first_name ASC')
        ->limit(20);
    $sth = $db->prepare($db->sql());
    $sth->execute();
    $array_data = array();
    while (list ($userid, $first_name, $last_name, $username, $email) = $sth->fetch(3)) {
        $array_data[] = array(
            'id' => $userid,
            'fullname' => nv_show_name_user($first_name, $last_name, $username),
            'email' => $email
        );
    }
    header('Cache-Control: no-cache, must-revalidate');
    header('Content-type: application/json');
    ob_start('ob_gzhandler');
    echo json_encode($array_data);
    exit();
}
if ($nv_Request->isset_request('get_exam_json', 'post, get')) {
    $q = $nv_Request->get_title('q', 'post, get', '');
    $db->sqlreset()
    ->select('id, title as text')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
    ->where('title LIKE "%' . $q . '%"')
    ->order('title ASC')
    ->limit(15);
    $result = $db->query($db->sql());
    $array_data = array();
    while ($row = $result->fetch(2)) {
        $array_data[] = $row;
    }
    nv_jsonOutput($array_data);
}
if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get', '');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        nv_delete_exams_answer($id);
        $nv_Cache->delMod($module_name);
        if (!empty($redirect)) {
            Header('Location: ' . nv_redirect_decrypt($redirect));
            die();
        }
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&examid=' . $row['exam_id']);
        die();
    }
} elseif ($nv_Request->isset_request('delete_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);

    if (!empty($array_id)) {
        foreach ($array_id as $id) {
            nv_delete_exams_answer($id);
        }
        $nv_Cache->delMod($module_name);
        die('OK');
    }
    die('NO');
}

$page_title = $nv_Lang->getModule('history');
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;
$per_page = $array_config['per_page'];
$page = $nv_Request->get_int('page', 'post,get', 1);
$true = $nv_Request->get_int('true', 'post,get', 0);

$print_list = $nv_Request->get_int('print_list', 'get', 0);
$download = $nv_Request->get_int('download', 'post,get', 0);
$max_row = $nv_Request->get_int('max_row', 'post,get', 1000);

$row = array();
$join1 = $join2 = $join3 = '';
$where1 = $where2 = $where3 = ' 1 = 1 ';
$row['exam_id'] = $nv_Request->get_int('examid', 'post,get', 0);
$exams_info = array(
    'title' => $nv_Lang->getModule('history_total_data')
);
$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rating WHERE status=1 ORDER BY weight';
$array_rating = $nv_Cache->db($_sql, 'id', $module_name);
/**
 * Sắp xếp $array_rating đề phòng trường hợp sắp xếp không đúng gây ra lỗi.
 * Cấu hình xếp loại cần sửa chữa lại vì cấu hình hiện tại không hợp lý.
 * Vì cấu hình "Nếu bé hơn/Nếu bé hơn hoặc bằng" thì giả sử chọn loại giỏi "Nếu bé hơn/Nếu bé hơn hoặc bằng" 100% thì trường hợp nào cũng loại giỏi cả
 * Do đó khi cần xếp loại thì cần lấy tất cả cấu hình xếp loại để so sánh chứ 1 cái thì không thể thao tác được
 * Sẽ thấy được sự không hợp lý khi thực hiện thao tác tìm kiếm bên dưới (Key: Tìm kiếm theo rating)
 * */
uasort($array_rating, function ($item1, $item2) {
    return ($item1['percent']<$item2['percent'])?-1:1;
});
$array_rating = array_values($array_rating);
if ($download) {
    if ($nv_Request->isset_request('complete', 'post,get')) {
        if (!empty($_SESSION[$module_data]['download_file']['excel'])) {
            $file_src = $_SESSION[$module_data]['download_file']['excel'];
        } else {
            foreach ($_SESSION[$module_data]['download_file']['temp'] as $file) {
                nv_deletefile($file);
            }
            $file_src = $_SESSION[$module_data]['download_file']['zip'];
        }
        $download = new NukeViet\Files\Download($file_src, NV_ROOTDIR . NV_BASE_SITEURL . NV_TEMP_DIR);
        unset($_SESSION[$module_data]['download_file']);
        $download->download_file();
        die();
    }
    $per_page = $max_row;
}

if ($row['exam_id'] > 0) {
    $base_url .= '&examid=' . $row['exam_id'];
    $exams_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $row['exam_id'])->fetch();
    if (empty($exams_info)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams');
        die();
    }
    $row['exam_title'] = $exams_info['title'];
    $page_title = sprintf($nv_Lang->getModule('exams_report_title'), $exams_info['title']);
    $where1 .= ' AND t1.exam_id=' . $row['exam_id'];
}

$array_field_config = array();
$result_field = $db->query('SELECT * FROM ' . NV_USERS_GLOBALTABLE . '_field WHERE show_profile=1 ORDER BY weight ASC');
while ($row_field = $result_field->fetch()) {
    $language = unserialize($row_field['language']);
    $row_field['title'] = (isset($language[NV_LANG_DATA])) ? $language[NV_LANG_DATA][0] : $row['field'];
    $row_field['description'] = (isset($language[NV_LANG_DATA])) ? nv_htmlspecialchars($language[NV_LANG_DATA][1]) : '';
    if (!empty($row_field['field_choices'])) {
        $row_field['field_choices'] = unserialize($row_field['field_choices']);
    } elseif (!empty($row_field['sql_choices'])) {
        $row_field['sql_choices'] = explode('|', $row_field['sql_choices']);
        $query = 'SELECT ' . $row_field['sql_choices'][2] . ', ' . $row_field['sql_choices'][3] . ' FROM ' . $row_field['sql_choices'][1];
        $result = $db->query($query);
        $weight = 0;
        while (list ($key, $val) = $result->fetch(3)) {
            $row_field['field_choices'][$key] = $val;
        }
    }
    $array_field_config[$row_field['field']] = $row_field;
}
$array_search = array(
    'exam_subject' => $nv_Request->get_int('exam_subject', 'get', 0),
    'groupid' => $nv_Request->get_typed_array('groupid', 'get', 'int'),
    'userid' => $nv_Request->get_int('userid', 'get', 0),
    'rating' => $nv_Request->get_int('rating', 'get', 0),
    'nottest' => $nv_Request->get_int('nottest', 'get', 0),
    'timefrom' => $nv_Request->get_title('timefrom', 'get', ''),
    'timeto' => $nv_Request->get_title('timeto', 'get', ''),
    'ordername' => $nv_Request->get_title('ordername', 'get', 'begin_time'),
    'ordertype' => $nv_Request->get_title('ordertype', 'get', 'desc'),
    'perpage' => $nv_Request->get_int('perpage', 'get', $per_page)
);

if (!empty($array_search['unitid'])) {
    $base_url .= '&unitid=' . $array_search['unitid'];
    $array_unitid = GetUnitIdInParent($array_search['unitid']);
    $where1 .= ' AND t1.unit IN (' . implode(',', $array_unitid) . ')';
}

if (!empty($array_search['timefrom']) and preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $array_search['timefrom'], $m)) {
    $base_url .= '&timefrom=' . $array_search['timefrom'];
    $where1 .= ' AND t1.end_time >= ' . mktime(0, 0, 0, $m[2], $m[1], $m[3]);
}

if (!empty($array_search['timeto']) and preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $array_search['timeto'], $m)) {
    $base_url .= '&timeto=' . $array_search['timeto'];
    $where1 .= ' AND t1.end_time <= ' . mktime(23, 59, 59, $m[2], $m[1], $m[3]);
}

if (!empty($array_search['perpage']) and $array_search['perpage'] != $per_page) {
    $base_url .= '&perpage=' . $array_search['perpage'];
    $per_page = $array_search['perpage'];
}

if (!empty($array_search['userid'])) {
    $base_url .= '&userid=' . $array_search['userid'];
    $where1 .= ' AND t1.userid=' . $array_search['userid'];
}
// Tìm kiếm theo rating
if (!empty($array_search['rating'])) {
    $base_url .= '&rating=' . $array_search['rating'];
    for ($i = 0; $i < count($array_rating); $i++) {
        if ($array_rating[$i]['percent'] == $array_search['rating']) break;
    }
    $where1 .= ' AND t1.count_true /(t1.count_true + t1.count_false + t1.count_skeep) * 100 '
     . ($array_rating[$i]['operator'] == '&lt' ? '<' : '<=' ) .  $array_rating[$i]['percent']
     . ' AND t1.count_true /(t1.count_true + t1.count_false + t1.count_skeep) * 100 ';
    if ($i > 0 ) {
        $where1 .=  ($array_rating[$i-1]['operator'] == '&lt' ? '>=' : '>') .  $array_rating[$i-1]['percent'];
    } else {
        $where1 .= ' > 0';
    }
}
$join1 .= ' INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_answer AS t1 ON t1.userid=t3.userid';

if (!empty($array_search['nottest'])) {
    $base_url .= '&nottest=' . $array_search['nottest'];
    $join1 = '';
    $where1 = 't3.userid NOT IN (SELECT userid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer '
    . (!empty($row['exam_id']) ? ' WHERE exam_id = ' . $row['exam_id'] : '') . ') ';
}

if (!empty($array_search['groupid'])) {
    foreach ($array_search['groupid'] as $groupid) {
        $base_url .= '&groupid[]=' . $groupid;
    }
    $join2 .= ' INNER JOIN ' . NV_USERS_GLOBALTABLE . '_groups_users t2 ON t3.userid=t2.userid';
    $where2 .= ' AND t2.group_id IN (' . implode(',', $array_search['groupid']) . ')';
}

$array_search['ck_nottest'] = !empty($array_search['nottest']) ? 'checked="checked"' : '';


if (!empty($array_search['exam_subject'])) {
    $base_url .= '&exam_subject=' . $array_search['exam_subject'];
    $join3 .= ' INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject t4 ON t4.id=t1.exam_subject';
    $where3 .= ' AND t1.exam_subject = ' . $array_search['exam_subject'];
}

$db->sqlreset()
->select('COUNT(*)')
->from(NV_USERS_GLOBALTABLE . ' AS t3')
->join($join1 . $join2 . $join3)
->where($where1 . ' AND ' . $where2 . (!empty($array_idsite) ? ' AND ( t3.idsite IN (' . implode(',' , $array_idsite)  . ') OR t3.idsite = 0)' : '')   . ' AND ' . $where3);
$sth = $db->prepare($db->sql());
$sth->execute();
$num_items = $sth->fetchColumn();
$db->select((empty($array_search['nottest']) ? 't1.*, ' : ''  )  . 't3.userid user_id, t3.username, t3.first_name, t3.last_name, t3.gender, t3.birthday, t3.sig, t3.question, t3.answer');

if (!empty($array_search['nottest'])) {
    // Nếu lọc theo danh sách thí sinh chưa làm bài thi thì chỉ có sắp xếp theo tên
    $db->order('t3.first_name' . ' ' . $array_search['ordertype']);
} else {
    $db->order(($array_search['ordername'] == 'first_name' ? 't3.' : 't1.') . $array_search['ordername'] . ' ' . $array_search['ordertype']);
}

$base_url_sort = '&ordername=' . $array_search['ordername'] . '&ordertype=' . $array_search['ordertype'];

if (empty($print_list)) {
    $db->limit($per_page);
    $db->offset(($page - 1) * $per_page);
}
$sth = $db->prepare($db->sql());
$sth->execute();

$row['total_answer'] = $num_items;
$caption_answer = $true ? $nv_Lang->getModule('exams_report_caption_answer_true') : $nv_Lang->getModule('exams_report_caption_answer');

$i = 1;
$array_data = $array_examid = $array_users = $array_header = array();
while ($view = $sth->fetch()) {
    $view['number'] = $i++;
    $view['mark_constructed_response'] = array_reduce(nv_unserialize($view['mark_constructed_response']),
        function($item1, $item2) {
            return $item1+$item2;
        }, 0
    );
    $view['score'] += $view['mark_constructed_response'];
    if (empty($array_search['nottest'])) {
        $view['test_time'] = nv_convertfromSec($view['test_time']);
        $view['begin_time'] = !empty($view['begin_time']) ? nv_date('H:i d/m/Y', $view['begin_time']) : '';
        $view['end_time'] = nv_date('H:i d/m/Y', $view['end_time']);
        $percent = ($view['count_true'] * 100) / ($view['count_true'] + $view['count_false'] + $view['count_skeep']);
        $view['rating'] = nv_get_rating($percent);
        $view['rating'] = $view['rating']['title'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $row['exam_id'] . '&amp;examid=' . $row['exam_id'] . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
        $view['link_answer'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=history-view&amp;id=' . $view['id'];

        if (empty($row['exam_id'])) {
            $array_examid[$view['id']] = $view['exam_id'];
        }
    }

    if (!isset($array_users[$view['user_id']])) {
        $users = $db->query('SELECT ' . implode(',', $array_basic_key) . ' FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $view['user_id'])->fetch();
        if ($users) {
            $users['birthday'] = !empty($users['birthday']) ? nv_date('d/m/Y', $users['birthday']) : '';
            $sql = 'SELECT * FROM ' . NV_USERS_GLOBALTABLE . '_info WHERE userid=' . $view['user_id'];
            $result = $db->query($sql)->fetch();
            if ($result) {
                $custom_fields = $result;
            } else {
                $custom_fields = array();
            }
            $custom_fields = array_merge($custom_fields, $users);
            $view['custom_field'] = $users = nv_test_custom_fileds_render($array_field_config, $custom_fields, 1, 1);
            $array_users[$view['user_id']] = $users;

            if (empty($array_header)) {
                $array_header = array_keys($view['custom_field']);
            }
        }
    } else {
        $view['custom_field'] = $array_users[$view['user_id']];
    }

    if ($array_search['nottest']) {
        $array_data[] = $view;
    } else {
        $array_data[$view['id']] = $view;
    }
}
if (!empty($array_examid)) {
    $array_exams = array();
    $result = $db->query('SELECT id, title, alias, catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id IN (' . implode(',', array_unique(array_values($array_examid))) . ')');
    while ($_row = $result->fetch()) {
        $_row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$_row['catid']]['alias'] . '/' . $_row['alias'] . '-' . $_row['id'] . $global_config['rewrite_exturl'];
        $array_exams[$_row['id']] = $_row;
    }

    foreach ($array_examid as $answerid => $examid) {
        if (isset($array_exams[$examid])) {
            $array_data[$answerid]['exams'] = $array_exams[$examid];
        } else {
            $array_data[$answerid]['exams'] = array();
        }
    }
    unset($array_exams);
}

if ($download) {
    $total_pages = ceil($num_items / $per_page);
    $file_name = change_alias(strtolower($exams_info['title']));

    // tạo file
    if (!isset($_SESSION[$module_data]['download_file'])) {
        $_SESSION[$module_data]['download_file'] = array(
            'temp' => array(),
            'zip' => '',
            'excel' => ''
        );
    }

    // nếu số bản ghi có thể ghi vào 1 file excel thì không cần nén, xuất ra excel luôn
    if ($total_pages > 1) {
        $_SESSION[$module_data]['download_file']['temp'][] = nv_exams_report_download($file_name . '-' . $page, $exams_info, $array_data);
    } else {
        $_SESSION[$module_data]['download_file']['excel'] = nv_exams_report_download($file_name, $exams_info, $array_data);
    }

    if ($page < $total_pages) {
        nv_jsonOutput(array(
            'exit' => 0
        ));
    } else {
        if ($total_pages > 1) {
            $file_src = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $file_name . '.zip';
            $zip = new PclZip($file_src);
            $zip->create($_SESSION[$module_data]['download_file']['temp'], PCLZIP_OPT_REMOVE_PATH, NV_ROOTDIR . "/" . NV_TEMP_DIR);
            $_SESSION[$module_data]['download_file']['zip'] = $file_src;
        }
        nv_jsonOutput(array(
            'url_download' => $base_url . $base_url_sort . '&download=1&&complete=1',
            'exit' => 1
        ));
    }
}


$ordertype = $array_search['ordertype'] == 'asc' ? 'desc' : 'asc';
$array_sort_url = array(
    'begin_time' => $base_url . '&ordername=begin_time&ordertype=' . $ordertype,
    'first_name' => $base_url . '&ordername=first_name&ordertype=' . $ordertype,
    'count_true' => $base_url . '&ordername=count_true&ordertype=' . $ordertype,
    'count_false' => $base_url . '&ordername=count_false&ordertype=' . $ordertype,
    'count_skeep' => $base_url . '&ordername=count_skeep&ordertype=' . $ordertype,
    'score' => $base_url . '&ordername=score&ordertype=' . $ordertype,
    'test_time' => $base_url . '&ordername=test_time&ordertype=' . $ordertype
);
$base_url .= $base_url_sort;
$array_groups = nv_test_groups_list();

$user = array();
if ($array_search['userid'] > 0) {
    $user = $db->query('SELECT userid, first_name, last_name, username FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $array_search['userid'])->fetch();
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('CAPTION_ANSWER', $caption_answer);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('ROW', $row);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('SEARCH', $array_search);
$xtpl->assign('SORTURL', $array_sort_url);
$xtpl->assign('URL_QUESTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams-question&amp;id=' . $row['exam_id']);
$xtpl->assign('URL_ANSWER', $base_url);
$xtpl->assign('URL_ANSWER_TRUE', $base_url . '&true=1');
$xtpl->assign('URL_DOWNLOAD', $base_url . '&download=1');
$xtpl->assign('colspan_item', 8 + count($array_field_config));
$xtpl->parse('main.statistics');
$xtpl->assign('LINK_PRINT', $base_url . '&print_list=1');
$xtpl->assign('LINK_PRINT_BACK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&examid=' . $row['exam_id']);
$xtpl->assign('PACKAGE_NOTIICE', nv_package_notice(0));

$xtpl->assign('alert_warning', !empty($global_config['guider']) ? $nv_Lang->getModule('guider_history') : $nv_Lang->getModule('alert_warning_history'));
if ($turn_off_msg) {
    $xtpl->parse('main.msg_none');
} else {
    $xtpl->parse('main.msg_show');
}
if ($global_config['unallow_history']) {
    $xtpl->assign('test_message_danger', $nv_Lang->getModule('let_update_history'));
    $xtpl->parse('main.test_message_danger');
}

if ($row['exam_id'] > 0) {
    $xtpl->parse('main.examid');
}

if (!empty($print_list)) {
    $xtpl->parse('main.print');
}

if (!empty($array_field_config)) {
    foreach ($array_field_config as $field_info) {
        if (in_array($field_info['field'], $array_header)) {
            if ($field_info['field'] == 'first_name') {
                $status_sort_first_name = $array_search['ordername'] != 'first_name' ?  '<em class="fa fa-sort">&nbsp;</em>' :
                    ( $ordertype == 'asc' ? '<em class="fa fa-sort-numeric-desc">&nbsp;</em>' : '<em class="fa fa-sort-numeric-asc">&nbsp;</em>'  );
                $field_info['title'] = $status_sort_first_name .  '<a href="' . $array_sort_url['first_name'] .'" title="sort_first_name">' . $field_info['title'] . '</a>';
            };
            $xtpl->assign('FIELD', $field_info);
            $xtpl->parse('main.field_head');
        }
    }
}

$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
if (!empty($array_data)) {
    foreach ($array_data as $view) {
        $xtpl->assign('VIEW', $view);

        if (!empty($array_field_config)) {
            foreach ($array_field_config as $field => $field_info) {
                if (in_array($field, $array_header)) {
                    $xtpl->assign('FIELD', isset($view['custom_field'][$field]) && !$global_config['unallow_history'] ? $view['custom_field'][$field] : $nv_Lang->getModule('had_not_update'));
                    $xtpl->parse('main.loop.field_body');
                }
            }
        }

        if (!empty($array_search['nottest'])) {
            $xtpl->parse('main.loop.delete_disabled');
        } else {
            if (!$global_config['unallow_history']) {
                $xtpl->parse('main.loop.row_click');
                $xtpl->parse('main.loop.delete');
            } else {
                $xtpl->parse('main.loop.let_update');
            }

            if (isset($view['exams']) && !empty($view['exams'])) {
                $xtpl->parse('main.loop.other.exams');
            }
            $xtpl->parse('main.loop.other.' . (
                ($array_search['ordername'] != 'begin_time') ? 'no' : ($array_search['ordertype'] == 'asc' ? 'asc' : 'desc')
            ));
            $xtpl->parse('main.loop.other');
        }

        $xtpl->parse('main.loop');
    }
}
foreach ($array_groups as $groupid => $title) {
    if ($groupid == 5 || $groupid == 6) continue;
    $xtpl->assign('GROUP', array(
        'index' => $groupid,
        'title' => $title,
        'selected' => in_array($groupid, $array_search['groupid']) ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.group');
}

foreach ($array_rating as $rating) {
    $xtpl->assign('RATING', array(
        'value' => $rating['percent'],
        'title' => $rating['title'],
        'selected' => $rating['percent'] == $array_search['rating'] ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.rating_option');
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

if ($array_search['ordername'] == 'count_true') {
    $xtpl->parse('main.count_true.' . ($array_search['ordertype'] == 'desc' ? 'desc' : 'asc'));
    $xtpl->parse('main.count_true');
    $xtpl->parse('main.rating.' . ($array_search['ordertype'] == 'desc' ? 'desc' : 'asc'));
    $xtpl->parse('main.rating');
} else {
    $xtpl->parse('main.rating_no');
    $xtpl->parse('main.count_true_no');
}

if ($array_search['ordername'] == 'count_false') {
    $xtpl->parse('main.count_false.' . ($array_search['ordertype'] == 'desc' ? 'desc' : 'asc'));
    $xtpl->parse('main.count_false');
} else {
    $xtpl->parse('main.count_false_no');
}

if ($array_search['ordername'] == 'count_skeep') {
    $xtpl->parse('main.count_skeep.' . ($array_search['ordertype'] == 'desc' ? 'desc' : 'asc'));
    $xtpl->parse('main.count_skeep');
} else {
    $xtpl->parse('main.count_skeep_no');
}

if ($array_search['ordername'] == 'score') {
    $xtpl->parse('main.score.' . ($array_search['ordertype'] == 'desc' ? 'desc' : 'asc'));
    $xtpl->parse('main.score');
} else {
    $xtpl->parse('main.score_no');
}

if ($array_search['ordername'] == 'test_time') {
    $xtpl->parse('main.test_time.' . ($array_search['ordertype'] == 'desc' ? 'desc' : 'asc'));
    $xtpl->parse('main.test_time');
} else {
    $xtpl->parse('main.test_time_no');
}

for ($i = 10; $i <= 100; $i += 10) {
    $sl = $i == $array_search['perpage'] ? 'selected="selected"' : '';
    $xtpl->assign('PERPAGE', array(
        'index' => $i,
        'selected' => $sl
    ));
    $xtpl->parse('main.perpage');
}

if ($true) {
    $xtpl->parse('main.answer_list');
} else {
    $xtpl->parse('main.answer_true_list');
}

if (!empty($user)) {
    $user['fullname'] = nv_show_name_user($user['first_name'], $user['last_name']);
    $xtpl->assign('USER', $user);
    $xtpl->parse('main.user');
}

if (empty($array_data)) {
    $xtpl->parse('main.download_disabled');
}

if (empty($array_search['groupid'])) {
    $xtpl->parse('main.nottest');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$set_active_op = 'history';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents, !$print_list);
include NV_ROOTDIR . '/includes/footer.php';
