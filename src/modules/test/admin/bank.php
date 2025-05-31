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

$table_name = NV_PREFIXLANG . '_' . $module_data . '_bank';

// change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);
    $content = 'NO_' . $id;

    $query = 'SELECT status FROM ' . $table_name . ' WHERE id=' . $id;
    $row = $db->query($query)->fetch();
    if (isset($row['status'])) {
        $status = ($row['status']) ? 0 : 1;
        $query = 'UPDATE ' . $table_name . ' SET status=' . intval($status) . ' WHERE id=' . $id;
        $db->query($query);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

if ($nv_Request->isset_request('ajax_action', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $new_vid = $nv_Request->get_int('new_vid', 'post', 0);
    $content = 'NO_' . $id;

    list($id, $parentid) = $db->query('SELECT id, parentid FROM ' . $table_name . ' WHERE id=' . $id)->fetch(3);

    if ($new_vid > 0) {
        $sql = 'SELECT id FROM ' . $table_name . ' WHERE id!=' . $id . ' AND parentid=' . $parentid . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch()) {
            ++$weight;
            if ($weight == $new_vid) ++$weight;
            $sql = 'UPDATE ' . $table_name . ' SET weight=' . $weight . ' WHERE id=' . $row['id'];
            $db->query($sql);
        }
        $sql = 'UPDATE ' . $table_name . ' SET weight=' . $new_vid . ' WHERE id=' . $id;
        $db->query($sql);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        list($id, $parentid) = $db->query('SELECT id, parentid FROM ' . $table_name . ' WHERE id=' . $id)->fetch(3);

        $weight = 0;
        $sql = 'SELECT title, weight FROM ' . $table_name . ' WHERE id =' . $db->quote($id);
        $result = $db->query($sql);
        list($title, $weight) = $result->fetch(3);

        $db->query('DELETE FROM ' . $table_name . '  WHERE id = ' . $db->quote($id) . ' OR parentid=' . $id);
        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('bank_cat_del') , $title . " (id:#". $id . ")" , $admin_info['userid']);
        if ($weight > 0) {
            $sql = 'SELECT id, weight FROM ' . $table_name . ' WHERE weight >' . $weight;
            $result = $db->query($sql);
            while (list($id, $weight) = $result->fetch(3)) {
                $weight--;
                $db->query('UPDATE ' . $table_name . ' SET weight=' . $weight . ' WHERE id=' . intval($id));
            }
        }

        nv_fix_order($table_name);

        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&parentid=' . $parentid);
        die();
    }
}

$row = array();
$error = array();
$array_parent_info = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
$row['parentid'] = $nv_Request->get_int('parentid', 'get,post', 0);
$row['typeid'] = $nv_Request->get_int('typeid', 'get', 0);
$subjectid = $nv_Request->get_int('subjectid', 'get', 0);
$SUBJECT = array();
if (!empty($subjectid)) {
    $db->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_exam_subject')
    ->where('id =' . $subjectid);
    $SUBJECT= $db->query($db->sql())->fetch(2);
    $db->sqlreset()
    ->select('code')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_exam_subject')
    ->where('id=' . $subjectid);
    list($code) = $db->query($db->sql())->fetch(3);
    if (!empty($code)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=random_question&subjectid=' . $subjectid);
        die();
    }
}

if ($nv_Request->isset_request('submit', 'post')) {
    $row['parentid'] = $nv_Request->get_int('parentid', 'post', 0);
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['description'] = $nv_Request->get_string('description', 'post', '');

    if (empty($row['title'])) {
        $error[] = $nv_Lang->getModule('error_required_title');
    }

    if (empty($error)) {
        try {
            $new_id = 0;
            if (empty($row['id'])) {
                $data_insert = array();
                $_sql = 'INSERT INTO ' . $table_name . ' (parentid, title, description, subid, weight, userid) VALUES (:parentid, :title, :description, 0, :weight, 0)';
                $weight = $db->query('SELECT max(weight) FROM ' . $table_name . '')->fetchColumn();
                $weight = intval($weight) + 1;

                $data_insert['parentid'] = $row['parentid'];
                $data_insert['title'] = $row['title'];
                $data_insert['description'] = $row['description'];
                $data_insert['weight'] = $weight;
                $new_id = $db->insert_id($_sql, 'id', $data_insert);
                nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('bank_cat_add') , $row['title'] . " (id:#". $new_id . ")" , $admin_info['userid']);
            } else {
                $stmt = $db->prepare('UPDATE ' . $table_name . ' SET parentid=:parentid, title = :title, description = :description WHERE id=' . $row['id']);
                $stmt->bindParam(':parentid', $row['parentid'], PDO::PARAM_INT);
                $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR, strlen($row['description']));
                if ($stmt->execute()) {
                    $new_id = $row['id'];
                    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('bank_cat_edit') , $row['title'] . " (id:#". $new_id . ")" , $admin_info['userid']);
                }
            }

            if ($new_id > 0) {
                nv_fix_order($table_name);
                $nv_Cache->delMod($module_name);
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&parentid=' . $row['parentid']);
                die();
            }
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . $table_name . ' WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
} else {
    $row['id'] = 0;
    $row['title'] = '';
    $row['description'] = '';
}

$parent_info = $db->query('SELECT lev FROM ' . NV_PREFIXLANG . '_' . $module_data . '_bank WHERE id=' . $row['parentid'])->fetch();
if ($parent_info && $parent_info['lev'] == 1) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=question-list&typeid=' . $row['parentid'] . (!empty($SUBJECT) ? '&subjectid=' . $SUBJECT['id'] : '' ));
    die();
}

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . (!empty($SUBJECT) ? '&subjectid=' . $SUBJECT['id'] : '' );

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from($table_name)
        ->where('parentid=' . $row['parentid']);

    $sth = $db->prepare($db->sql());

    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('weight ASC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());
    $sth->execute();
}

$sql = 'SELECT id, title, lev FROM ' . $table_name . ' WHERE id !=' . $row['id'] . ' AND status=1 AND lev<1 ORDER BY sort ASC';
$result = $db->query($sql);
$array_cat_list = array();
$array_cat_list[0] = array(
    '0',
    $nv_Lang->getModule('cat_main')
);

while (list($id_i, $title_i, $lev_i) = $result->fetch(3)) {
    $xtitle_i = '';
    if ($lev_i > 0) {
        $xtitle_i .= '&nbsp;';
        for ($i = 1; $i <= $lev_i; $i++) {
            $xtitle_i .= '---';
        }
    }
    $xtitle_i .= $title_i;
    $array_cat_list[] = array(
        $id_i,
        $xtitle_i
    );
}

if (!empty($row['parentid'])) {
    \NukeViet\Core\Language::$lang_module['category'] = $nv_Lang->getModule('question');
    // $base_url .= '&amp;parentid=' . $row['parentid'];
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('MODULE_UPLOAD', $module_upload);

if (!empty($SUBJECT)) {
    $xtpl->assign('SUBJECT', $SUBJECT);
    $xtpl->parse('main.question_subject');
}
if ($show_view) {
    $base_url_cr = !empty($row['parentid']) ? $base_url .  '&amp;parentid=' . $row['parentid'] : $base_url;
    $generate_page = nv_generate_page($base_url_cr, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    while ($view = $sth->fetch()) {
        for ($i = 1; $i <= $num_items; ++$i) {
            $xtpl->assign('WEIGHT', array(
                'key' => $i,
                'title' => $i,
                'selected' => ($i == $view['weight']) ? ' selected="selected"' : ''
            ));
            $xtpl->parse('main.view.loop.weight_loop');
        }
        if ($view['status'] == 1) {
            $check = 'checked';
        } else {
            $check = '';
        }
        $xtpl->assign('CHECK', $check);
        $view['link_view'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;parentid=' . $view['id'];
        $view['link_view'] .= (!empty($SUBJECT) ? '&amp;subjectid=' . $SUBJECT['id'] : '');
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
        if ($row['parentid'] > 0) {
            $rows = $db->query('SELECT COUNT(*) as numsub FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE typeid=' . $view['id'] . ' AND examid=0')->fetch();
            $view['numsub'] = $rows['numsub'];
        }
        $xtpl->assign('VIEW', $view);
        if (!empty($view['num_req'])) {
            $xtpl->parse('main.view.loop.not_verify');
        }
        $xtpl->parse('main.view.loop');
    }
    $xtpl->parse('main.view');
}

foreach ($array_cat_list as $rows_i) {
    $sl = ($rows_i[0] == $row['parentid']) ? ' selected="selected"' : '';
    $xtpl->assign('pid', $rows_i[0]);
    $xtpl->assign('ptitle', $rows_i[1]);
    $xtpl->assign('pselect', $sl);
    $xtpl->parse('main.parent');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('bank');
$array_mod_title[] = array(
    'title' => $page_title,
    'link' => $base_url
);

if (!empty($array_parent_info)) {
    $array_mod_title[] = array(
        'title' => $array_parent_info['title'],
        'link' => $base_url . '&amp;parentid=' . $array_parent_info['parentid']
    );
}

$parentid = $row['parentid'];
while ($parentid > 0) {
    $array_cat_i = $array_test_bank_nstatus[$parentid];
    $array_mod_title[] = [
        'id' => $parentid,
        'title' => $array_cat_i['title'],
        'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=bank&amp;parentid=' . $parentid
    ];
    $parentid = $array_cat_i['parentid'];
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
