<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

if ($nv_Request->isset_request('ajax_action', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $new_vid = $nv_Request->get_int('new_vid', 'post', 0);
    $content = 'NO_' . $id;
    if ($new_vid > 0) {
        $sql = 'SELECT sourceid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE sourceid!=' . $id . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch()) {
            ++$weight;
            if ($weight == $new_vid) ++$weight;
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sources SET weight=' . $weight . ' WHERE sourceid=' . $row['sourceid'];
            $db->query($sql);
        }
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sources SET weight=' . $new_vid . ' WHERE sourceid=' . $id;
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
    $sourceid = $nv_Request->get_int('delete_id', 'get', 0);
    list ($sourceid, $title, $logo_old) = $db->query('SELECT sourceid, title, logo FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE sourceid=' . $sourceid)->fetch(3);
    if ($sourceid > 0) {
        nv_insert_logs(NV_LANG_DATA, $module_name, 'log_del_source', $title, $admin_info['userid']);

        $count = $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE sourceid=' . $sourceid);
        if ($count) {
            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET sourceid=0 WHERE sourceid=' . $sourceid);
        }

        if (!empty($logo_old)) {
            $_count = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE sourceid != ' . $sourceid . ' AND logo =' . $db->quote(basename($logo_old)))
                ->fetchColumn();
            if (empty($_count)) {
                @unlink(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $logo_old);
                @unlink(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $logo_old);

                $_did = $db->query('SELECT did FROM ' . NV_UPLOAD_GLOBALTABLE . '_dir WHERE dirname=' . $db->quote(dirname(NV_UPLOADS_DIR . '/' . $module_upload . '/' . $logo_old)))
                    ->fetchColumn();
                $db->query('DELETE FROM ' . NV_UPLOAD_GLOBALTABLE . '_file WHERE did = ' . $_did . ' AND title=' . $db->quote(basename($logo_old)));
            }
        }
        nv_fix_source();
        $nv_Cache->delMod($module_name);
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
}

$username_alias = change_alias($admin_info['username']);
$upload_user_path = nv_upload_user_path($username_alias);
$currentpath = $upload_user_path['currentpath'];
$uploads_dir_user = $upload_user_path['uploads_dir_user'];

list ($row['sourceid'], $row['title'], $row['link'], $row['logo']) = array(
    $nv_Request->get_int('sourceid', 'get', 0),
    '',
    '',
    ''
);

if ($nv_Request->isset_request('savecat', 'post')) {
    $row['sourceid'] = $nv_Request->get_int('sourceid', 'post', 0);
    $row['title'] = $nv_Request->get_title('title', 'post', '', 1);
    $row['link'] = strtolower($nv_Request->get_title('link', 'post', ''));

    $url_info = @parse_url($row['link']);
    if (isset($url_info['scheme']) and isset($url_info['host'])) {
        $row['link'] = $url_info['scheme'] . '://' . $url_info['host'];
    } else {
        $row['link'] = '';
    }

    if (empty($row['title'])) {
        nv_jsonOutput(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_required_title'),
            'input' => 'title'
        ));
    }

    $row['logo'] = $nv_Request->get_title('logo', 'post', '');
    if (is_file(NV_DOCUMENT_ROOT . $row['logo'])) {
        $row['logo'] = substr($row['logo'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
    } else {
        $row['logo'] = '';
    }

    if (empty($row['sourceid'])) {
        $weight = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources')->fetchColumn();
        $weight = intval($weight) + 1;
        $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_sources (title, link, logo, weight, add_time, edit_time) VALUES ( :title, :link, :logo, :weight, ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . ')';
        $data_insert = array();
        $data_insert['title'] = $row['title'];
        $data_insert['link'] = $row['link'];
        $data_insert['logo'] = $row['logo'];
        $data_insert['weight'] = $weight;

        if ($db->insert_id($sql, 'sourceid', $data_insert)) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_add_source', ' ', $admin_info['userid']);
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            nv_jsonOutput(array(
                'error' => 0
            ));
        } else {
            nv_jsonOutput(array(
                'error' => 1,
                'msg' => $nv_Lang->getModule('errorsave')
            ));
        }
    } else {
        $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sources SET title= :title, link = :link, logo= :logo, edit_time=' . NV_CURRENTTIME . ' WHERE sourceid =' . $row['sourceid']);
        $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
        $stmt->bindParam(':link', $row['link'], PDO::PARAM_STR);
        $stmt->bindParam(':logo', $row['logo'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_edit_source', 'sourceid ' . $row['sourceid'], $admin_info['userid']);
            nv_jsonOutput(array(
                'error' => 0
            ));
        } else {
            nv_jsonOutput(array(
                'error' => 1,
                'msg' => $nv_Lang->getModule('errorsave')
            ));
        }
    }
} elseif ($row['sourceid'] > 0) {
    list ($row['sourceid'], $row['title'], $row['link'], $row['logo']) = $db->query('SELECT sourceid, title, link, logo FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources where sourceid=' . $row['sourceid'])->fetch(3);
    $page_title = $nv_Lang->getModule('edit_topic');

    if (!empty($row['logo']) and file_exists(NV_UPLOADS_REAL_DIR)) {
        $currentpath = NV_UPLOADS_DIR . '/' . $module_upload . '/' . dirname($row['logo']);
    }
}

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$per_page = 20;
$page = $nv_Request->get_int('page', 'get', 1);

$show_view = false;
if (!$nv_Request->isset_request('sourceid', 'post,get')) {
    $show_view = true;
    $per_page = $array_config['per_page'];
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_sources');

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

if (!empty($row['logo']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['logo'])) {
    $row['logo'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['logo'];
}

$xtpl = new XTemplate('sources.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('CURENTPATH', $currentpath);

if ($show_view) {
    while ($view = $sth->fetch()) {
        $xtpl->assign('VIEW', array(
            'sourceid' => $view['sourceid'],
            'title' => $view['title'],
            'link' => $view['link'],
            'url_edit' => $base_url . '&amp;sourceid=' . $view['sourceid'],
            'url_delete' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['sourceid'] . '&amp;delete_checkss=' . md5($view['sourceid'] . NV_CACHE_PREFIX . $client_info['session_id'])
        ));

        for ($i = 1; $i <= $num_items; ++$i) {
            $xtpl->assign('WEIGHT', array(
                'key' => $i,
                'title' => $i,
                'selected' => ($i == $view['weight']) ? ' selected="selected"' : ''
            ));
            $xtpl->parse('main.view.loop.weight_loop');
        }

        $xtpl->parse('main.view.loop');
    }

    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }

    $xtpl->parse('main.view');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('sources');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';