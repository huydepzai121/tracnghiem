<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 02 Jun 2015 07:53:31 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

global $nv_Lang;
$bank = $nv_Request->get_int('bank', 'post,get', 0);
$table_exams = NV_PREFIXLANG . '_' . $module_data . '_exams';
$table_question = NV_PREFIXLANG . '_' . $module_data . '_question';
// Kiểm tra điều kiện đề thi phải >= 10 câu hỏi.
function check_conditions_exam($id)
{
    global $db, $module_data;
    $db->sqlreset()
    ->select('num_question, count_question')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
    ->where('id = ' . $id);
    list($num_question, $count_question) = $db->query($db->sql())->fetch(3);
    return ($num_question == $count_question) && ($num_question >= 10);
}
if ($bank) {
    $table_exams = tableSystem . '_exams_bank';
    $table_question = tableSystem . '_exams_bank_question';
}
$table_system = $db_config['dbsystem'] . '.' . NV_PREFIXLANG . '_' . $module_data;
if ($nv_Request->isset_request('view_option_add_bank', 'post,get')) {
    $id = $nv_Request->get_int('id', 'post,get', 0);
    // $id = 0;
    $data = array();

    // check đề ko tồn tại
    if (!$id) {
        $data = [
            'status' => 0,
            'title' => 'Lỗi!: Đề thi không tồn tại',
            'html' => 'Vui lòng kiểm tra lại.'
        ];
        echo json_encode($data);
        exit();
    }

    // Kiểm tra đề thi có thỏa mãn yêu cầu là > 10 câu hỏi.
    if (!(check_conditions_exam($id))) {
        $data = [
            'status' => 0,
            'title' => $nv_Lang->getModule('error_exams_not_allow'),
            'html' => 'Vui lòng kiểm tra lại.'
        ];
        echo json_encode($data);
        exit();
    }


    list($tbBankTt, $bank_catid) = $db->query('SELECT title, catid FROM ' . $table_system . '_exams_bank WHERE idsite=' . $global_config['idsite'] . ' and id_exam=' . $id)->fetch(3);
    $tbExamTt = $db->query('SELECT title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $id)->fetchColumn();

    $html = nv_view_option($bank_catid);
    $data = [
        'status' => $id,
        'title' => sprintf($tbBankTt ? $nv_Lang->getModule('title_show_modal_update_bank') : $nv_Lang->getModule('title_show_modal_add_bank'), ($tbBankTt ? $tbBankTt : $tbExamTt)),
        'html' => $html
    ];
    echo json_encode($data);
    exit();
}

if ($nv_Request->isset_request('nv_add_bank', 'post,get')) {
    $exam_id = $nv_Request->get_int('exam_id', 'post,get', 0);
    $catid = $nv_Request->get_int('catid', 'post,get', 0);

    if (!$exam_id) {
        die('NO_' . $nv_Lang->getModule('error_unknow'));
    }
    // Kiểm tra điều kiện đề thi cần phải >= 10 câu hỏi.
    if (!check_conditions_exam($exam_id)) {
        die('NO_' . $nv_Lang->getModule('error_unknow'));
    }

    $rows = $db->query('SELECT id FROM ' . $table_system . '_exams_bank WHERE idsite=' . $global_config['idsite'] . ' and id_exam=' . $exam_id)->fetchColumn();
    if (empty($rows)) {
        $_sql = 'INSERT INTO ' . $table_system . '_exams_bank (idsite, id_exam, userid, title, alias, catid, hometext, description, question_list, num_question, count_question, timer, ladder, addtime, status) SELECT ' . $global_config['idsite'] . ', id, ' . $admin_info['userid'] . ', title, alias, ' . $catid . ', hometext, description, question_list, num_question, count_question, timer, ladder, ' . NV_CURRENTTIME . ', 2 FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams where id=' . $exam_id;
        $add_exam = $db->insert_id($_sql, 'id');

        if ($add_exam) {
            $sth = $db->prepare('INSERT INTO ' . $table_system . '_exams_bank_question (qsIdSite, examid, typeid, bank_type, title, useguide, type, answer, note, weight, answer_style, count_true, max_answerid, generaltext, answer_editor, answer_editor_type, answer_fixed, point, addtime, userid) VALUES (:qsIdSite, :examid, :typeid, :bank_type, :title, :useguide, :type, :answer, :note, :weight, :answer_style, :count_true, :max_answerid, :generaltext, :answer_editor, :answer_editor_type, :answer_fixed, :point, :addtime, :userid)');

            $result = $db->query('SELECT id, examid, typeid, bank_type, title, useguide, type, answer, note, weight, answer_style, count_true, max_answerid, generaltext, answer_editor, answer_editor_type, answer_fixed, point, addtime, userid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question where examid=' . $exam_id);
            while ($item_question = $result->fetch(2)) {
                $answer = nv_unserialize($item_question['answer']);
                foreach ($answer as $k => $ans) {
                    $answer[$k]['content'] = move_file_and_change_content($answer[$k]['content']);
                }
                $item_question['answer'] = serialize($answer);
                $item_question['title'] = move_file_and_change_content($item_question['title']);
                $sth->bindValue(':qsIdSite', $item_question['id'], PDO::PARAM_INT);
                $sth->bindValue(':examid', $add_exam, PDO::PARAM_INT);
                $sth->bindValue(':typeid', $item_question['typeid'], PDO::PARAM_INT);
                $sth->bindValue(':bank_type', $item_question['bank_type'], PDO::PARAM_INT);
                $sth->bindValue(':title', $item_question['title']);
                $sth->bindValue(':useguide', $item_question['useguide']);
                $sth->bindValue(':type', $item_question['type'], PDO::PARAM_INT);
                $sth->bindValue(':answer', $item_question['answer']);
                $sth->bindValue(':note', $item_question['note']);
                $sth->bindValue(':weight', $item_question['weight'], PDO::PARAM_INT);
                $sth->bindValue(':answer_style', $item_question['answer_style']);
                $sth->bindValue(':count_true', $item_question['count_true']);
                $sth->bindValue(':max_answerid', $item_question['max_answerid']);
                $sth->bindValue(':generaltext', $item_question['generaltext']);
                $sth->bindValue(':answer_editor', $item_question['answer_editor']);
                $sth->bindValue(':answer_editor_type', $item_question['answer_editor_type']);
                $sth->bindValue(':answer_fixed', $item_question['answer_fixed']);
                $sth->bindValue(':point', $item_question['point'], PDO::PARAM_INT);
                $sth->bindValue(':addtime', $item_question['addtime'], PDO::PARAM_INT);
                $sth->bindValue(':userid', $item_question['userid'], PDO::PARAM_INT);
                $sth->execute();
            }
        }
    } else {
        die('NO_');
    }

    die('OK_' . $nv_Lang->getModule('exam_add_bank_success'));
}

if ($nv_Request->isset_request('delete_data', 'post, get')) {
    if (nv_delete_sample_data()) {
        die('OK_' . $nv_Lang->getModule('exams_delete_success'));
    }
    die('NO_' . $nv_Lang->getModule('error_unknow'));
}

// change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);

    if (!$id) {
        die('NO');
    }

    $query = 'SELECT status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $id;
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
        $query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET
                status=' . $db->quote($active) . '
                WHERE id=' . $id;
        $db->query($query);
    }
    $nv_Cache->delMod($module_name);
    die('OK');
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get', '');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        nv_exams_delete($table_exams, $table_question, $id);
        $nv_Cache->delMod($module_name);

        if (!empty($redirect)) {
            Header('Location: ' . nv_redirect_decrypt($redirect));
            die();
        }

        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
} elseif ($nv_Request->isset_request('delete_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);

    if (!empty($array_id)) {
        foreach ($array_id as $id) {
            nv_exams_delete($table_exams, $table_question, $id);
        }
        $nv_Cache->delMod($module_name);
        die('OK');
    }
    die('NO');
}

$where = '';
$array_search = array(
    'q' => $nv_Request->get_title('q', 'post,get'),
    'catid' => $nv_Request->get_int('catid', 'post,get', 0),
    'type' => $nv_Request->get_int('type', 'post,get', -1)
);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;

$order_exams = 0;
if ($array_config['order_exams'] and empty($array_search['q'])) {
    $order_exams = 1;
    $_weight_new = $nv_Request->get_int('order_exams_new', 'post', 0);
    $_id = $nv_Request->get_int('order_exams_id', 'post', 0);
    if ($_id > 0 and $_weight_new > 0) {
        $sql = 'SELECT weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $_id;
        $_row1 = $db->query($sql)->fetch();
        if (!empty($_row1)) {
            $_weight1 = min($_weight_new, $_row1['weight']);
            $_weight2 = max($_weight_new, $_row1['weight']);
            if ($_weight_new > $_row1['weight']) {
                // Kiểm tra không cho set weight lơn hơn maxweight
                $maxweight = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams')->fetchColumn();
                if ($_weight_new > $maxweight) {
                    $_weight_new = $maxweight;
                }
            }

            $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE weight BETWEEN ' . $_weight1 . '  AND ' . $_weight2 . ' AND id!=' . $_id . ' ORDER BY weight ASC, addtime ASC';
            $result = $db->query($sql);
            $weight = $_weight1;
            while ($_row2 = $result->fetch()) {
                if ($weight == $_weight_new) {
                    ++$weight;
                }
                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET weight=' . $weight . ' WHERE id=' . $_row2['id']);
                ++$weight;
            }
            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET weight=' . $_weight_new . ' WHERE id=' . $_id);
            $nv_Cache->delMod($module_name);
        }
    }
}

$ordername = ($module_config[$module_name]['order_exams'] == 1) ? 'weight' : 'addtime';
$ordername = $nv_Request->get_string('ordername', 'get', $ordername);

// Fetch Limit
$per_page = $array_config['per_page'];
$page = $nv_Request->get_int('page', 'post,get', 1);
$db->sqlreset()
    ->select('COUNT(*)')
    ->from('' . NV_PREFIXLANG . '_' . $module_data . '_exams');

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (title LIKE :q_title)';
}

if (!empty($array_search['catid'])) {
    $base_url .= '&catid=' . $array_search['catid'];
    $where .= ' AND catid=' . $array_search['catid'];
}

if ($array_search['type'] >= 0) {
    $base_url .= '&type=' . $array_search['type'];
    $where .= ' AND type=' . $array_search['type'];
}

$array_cat_view = array();
foreach ($array_test_cat as $catid_i => $array_value) {
    $lev_i = $array_value['lev'];
    $check_cat = false;
    if (defined('NV_IS_ADMIN_MODULE')) {
        $check_cat = true;
    } elseif (isset($array_cat_admin[$admin_id][$catid_i])) {
        $_cat_admin_i = $array_cat_admin[$admin_id][$catid_i];
        if ($_cat_admin_i['admin'] == 1) {
            $array_cat_view[] = $catid_i;
            $check_cat = true;
        } elseif ($_cat_admin_i['add_content'] == 1) {
            $check_cat = true;
        } elseif ($_cat_admin_i['edit_content'] == 1) {
            $check_cat = true;
        } elseif ($_cat_admin_i['del_content'] == 1) {
            $check_cat = true;
        }
    }

    if ($check_cat) {
        $xtitle_i = '';
        if ($lev_i > 0) {
            $xtitle_i .= '&nbsp;&nbsp;&nbsp;|';
            for ($i = 1; $i <= $lev_i; ++$i) {
                $xtitle_i .= '---';
            }
            $xtitle_i .= '>&nbsp;';
        }
        $xtitle_i .= $array_value['title'];
        $sl = ($catid_i == $array_search['catid']) ? ' selected="selected"' : '';
        $val_cat_content[] = array(
            'id' => $catid_i,
            'selected' => $sl,
            'title' => $xtitle_i
        );
        $array_cat_view[] = $catid_i;
    }
}

if (!defined('NV_IS_ADMIN_MODULE') and $array_search['catid'] > 0 and !in_array($array_search['catid'], $array_cat_view)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

if (!empty($array_cat_view)) {
    if (defined('NV_IS_ADMIN_FULL_MODULE')) {
        // nếu toàn quyền module thì thấy hết
    } elseif (defined('NV_IS_ADMIN_MODULE')) {
        //
    } else {
        // nếu là quản lý chuyên mục thì chỉ thấy đề của chủ đề đc cấp phép
        $where .= ' AND catid IN(' . implode(',', $array_cat_view) . ') AND userid=' . $admin_info['userid'];
    }
} elseif (!defined('NV_IS_SPADMIN')) {
    $where .= ' AND userid=' . $admin_info['userid'];
}

$db->where('1=1' . $where);
$sth = $db->prepare($db->sql());

if (!empty($array_search['q'])) {
    $sth->bindValue(':q_title', '%' . $array_search['q'] . '%');
}
$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('*')
    ->order($ordername . ' DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());

if (!empty($array_search['q'])) {
    $sth->bindValue(':q_title', '%' . $array_search['q'] . '%');
}
$sth->execute();

$array_data = array();
while ($view = $sth->fetch()) {
    $array_data[$view['id']] = $view;
}

// Kiểm tra đề thi có ở ngân hàng đề thi chưa.
$array_exams_of_bank = array();
if (!empty($array_data)) {
    $db->sqlreset()
    ->select('id, catid, id_exam, status, reasonReject')
    ->from($table_system . '_exams_bank')
    ->where('id_exam IN (' . implode(',', array_keys($array_data)) . ') AND idsite ="' . $global_config['idsite'] . '"');
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        $array_exams_of_bank[$row['id_exam']] = $row;
    }
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('SEARCH', $array_search);
$xtpl->assign('URL_ADD', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams-content');
$xtpl->assign('URL_DELETE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=modules');
$xtpl->assign('BASE_URL', $base_url);
$xtpl->assign('PACKAGE_NOTIICE', nv_package_notice(0));
$xtpl->assign('URL_MERGE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=merge-exams&merge_opt_1');

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
$_permission_action = $array_user = array();
foreach ($array_data as $view) {
    if ($view['status'] == 1) {
        $check = 'checked';
    } else {
        $check = '';
    }
    $xtpl->assign('CHECK', $check);

    if (!isset($array_user[$view['userid']])) {
        $user = $db->query('SELECT first_name, last_name, username FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $view['userid'])->fetch();
        $view['fullname'] = nv_show_name_user($user['first_name'], $user['last_name'], $user['username']);
        $array_user[$view['userid']] = $view['fullname'];
    } else {
        $view['fullname'] = $array_user[$view['userid']];
    }

    $check_permission_edit = $check_permission_delete = false;

    if (defined('NV_IS_ADMIN_MODULE')) {
        $check_permission_edit = $check_permission_delete = true;
    } else {
        $check_edit = $check_del = 0;

        if (isset($array_cat_admin[$admin_id][$view['catid']])) {
            if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1) {
                ++$check_edit;
                ++$check_del;
            } else {
                if ($array_cat_admin[$admin_id][$view['catid']]['edit_content'] == 1) {
                    ++$check_edit;
                }

                if ($array_cat_admin[$admin_id][$view['catid']]['del_content'] == 1) {
                    ++$check_del;
                } elseif ($view['status'] == 0 and $view['userid'] == $admin_id) {
                    ++$check_del;
                }
            }
        }

        if ($check_edit > 0) {
            $check_permission_edit = true;
        }

        if ($check_del > 0) {
            $check_permission_delete = true;
        }
    }

    $admin_funcs = array();
    if ($check_permission_edit) {
        $admin_funcs[] = nv_link_edit_page($view['id']);
    }
    if ($check_permission_delete) {
        $admin_funcs[] = nv_link_delete_page($view['id']);
        $_permission_action['delete_list_id'] = true;
    }
    $xtpl->assign('link_download_exam', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams-content&amp;download_word=' . $view['id']);

    if (!empty($view['id']) &&  ($view['input_question'] != 4)) {
        // chỉ clone các đề thi không lấy đề từ ngân hàng
        $xtpl->assign('link_clone_exam', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams-content&amp;clone_id=' . $view['id']);
        $xtpl->parse('main.loop.clone_exam');
    }
    $admin_funcs[] =
    $view['feature'] = implode('&nbsp;', $admin_funcs);
    $view['status'] = $nv_Lang->getModule('text_post_status_' . $view['status']);
    $view['type'] = $array_exam_type[$view['type']];
    $view['addtime'] = nv_date('H:i d/m/Y', $view['addtime']);

    if (defined('NV_TEST_PAYMENT') && $view['price'] > 0) {
        $view['price'] = nv_test_number_format($view['price']);
    } else {
        $view['price'] = 0;
    }

    $view['link_detail'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=detail&id=' . $view['id'];
    $view['link_question'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=question&amp;examid=' . $view['id'];
    $view['link_report'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=history&amp;examid=' . $view['id'];
    $view['link_view'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$view['catid']]['alias'] . '/' . $view['alias'] . '-' . $view['id'] . $global_config['rewrite_exturl'];

    $xtpl->assign('VIEW', $view);
    if ($view['isfull'] != 1) {
        $xtpl->assign('exams_deactive', $view['isfull'] == 0 ? $nv_Lang->getModule('exams_deactive0') : $nv_Lang->getModule('exams_deactive_1'));
        $xtpl->parse('main.loop.exams_deactive');
        $xtpl->parse('main.loop.label');
    } else {
        $xtpl->parse('main.loop.link');
        if (empty($array_exams_of_bank[$view['id']]) && $view['input_question'] != 4) {
            $xtpl->parse('main.loop.addBank');
        }
    }

    // nếu đề tạo từ ngân hàng câu hỏi thì không cho quản lý danh sách câu hỏi
    if ($view['input_question'] != 2) {
        $xtpl->parse('main.loop.question_list');
    }

    if (empty($view['exams_reset_bank']) and ($view['count_question'] == $view['num_question'])) {
        $xtpl->parse('main.loop.content_view');
    }

    if ($order_exams) {
        $xtpl->parse('main.loop.sort');
    }

    if (!empty($view['price'])) {
        $xtpl->parse('main.loop.price');
    }
    if (!empty($array_exams_of_bank[$view['id']])) {
        $cat_bank = !empty($array_exams_bank_cats[$array_exams_of_bank[$view['id']]['catid']])
            ? $array_exams_bank_cats[$array_exams_of_bank[$view['id']]['catid']]['title']
            : $nv_Lang->getModule('had_not_identified');
        $xtpl->assign('cat_bank', $cat_bank);
        $status_reponse_bank = $array_exams_of_bank[$view['id']]['status'] == 3 ?
            '<span class="text-danger">'. $array_exams_of_bank[$view['id']]['reasonreject'] . '</span>' :
            ($array_exams_of_bank[$view['id']]['status'] == 2 ?
            '<span class="text-success"><strong>' . $nv_Lang->getModule('bank_exam_status_' . $array_exams_of_bank[$view['id']]['status']) . '</strong></span>' :
            '<span class="text-primary">' . $nv_Lang->getModule('bank_exam_status_' . $array_exams_of_bank[$view['id']]['status']) . '</span>');

        $xtpl->assign('status_reponse_bank', $status_reponse_bank);
        $xtpl->parse('main.loop.exams_of_bank');
    }

    $xtpl->parse('main.loop');
}

if (!empty($val_cat_content)) {
    foreach ($val_cat_content as $catid => $value) {
        $xtpl->assign('CAT', $value);
        $xtpl->parse('main.cat');
    }
}
if (!empty($array_exam_type)) {
    foreach ($array_exam_type as $index => $value) {
        $sl = $index == $array_search['type'] ? 'selected="selected"' : '';
        $xtpl->assign('TYPE', array(
            'index' => $index,
            'value' => $value,
            'selected' => $sl
        ));
        $xtpl->parse('main.type');
    }
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

$page_title = $nv_Lang->getModule('exams');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
