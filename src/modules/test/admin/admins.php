<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 27-11-2010 14:43
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

if (!function_exists('nv_array_cat_admin')) {

    function nv_array_cat_admin()
    {
        global $db, $module_data;
        $array_cat_admin = array();
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins ORDER BY userid ASC';
        $result = $db->query($sql);
        while ($row = $result->fetch()) {
            $array_cat_admin[$row['userid']][$row['catid']] = $row;
        }
        return $array_cat_admin;
    }
}

$is_refresh = false;
$array_cat_admin = nv_array_cat_admin();

$module_admin = explode(',', $module_info['admins']);
// Xoa cac dieu hanh vien khong co quyen tai module
foreach ($array_cat_admin as $userid_i => $value) {
    if (!in_array($userid_i, $module_admin)) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins WHERE userid = ' . $userid_i);
        $is_refresh = true;
    }
}

// Het Xoa cac dieu hanh vien khong co quyen tai module

if (empty($module_info['admins'])) {
    // Thong bao khong co nguoi dieu hanh chung
    $url_back = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=authors&amp;' . NV_OP_VARIABLE . '=add';
    $contents = nv_theme_alert($nv_Lang->getModule('admin_no_user_title'), $nv_Lang->getModule('admin_no_user_content'), 'info', $url_back, $nv_Lang->getModule('admin_add'));

    $page_title = $nv_Lang->getModule('admin');
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

foreach ($module_admin as $userid_i) {
    $userid_i = intval($userid_i);
    if ($userid_i > 0 and !isset($array_cat_admin[$userid_i])) {
        // Them nguoi dieu hanh chung, voi quyen han Quan ly module
        $sql = 'SELECT userid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins WHERE userid=' . $userid_i . ' AND catid=0';
        $numrows = $db->query($sql)->fetchColumn();
        if ($numrows == 0) {
            $db->query("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_admins (userid, catid, admin, add_content, edit_content, del_content) VALUES ('" . $userid_i . "', '0', '1', '1', '1', '1')");
            $is_refresh = true;
        }
    }
}
if ($is_refresh) {
    $array_cat_admin = nv_array_cat_admin();
}

if (defined('NV_IS_ADMIN_FULL_MODULE')) {
    $orders = array(
        'userid',
        'username',
        'full_name',
        'email'
    );

    $orderby = $nv_Request->get_string('sortby', 'get', 'userid'); //die($orderby);
    $ordertype = $nv_Request->get_string('sorttype', 'get', 'DESC');
    if ($ordertype != 'ASC') {
        $ordertype = 'DESC';
    }

    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;

    $userid = $nv_Request->get_int('userid', 'get', 0);

    $array_permissions_mod = array(
        $nv_Lang->getModule('admin_cat'),
        $nv_Lang->getModule('admin_module'),
        $nv_Lang->getModule('admin_full_module')
    );

    if ($nv_Request->isset_request('submit', 'post') and $userid > 0) {
        $admin_module = $nv_Request->get_int('admin_module', 'post', 0);
        if ($admin_module == 1 or $admin_module == 2) {
            if (!defined('NV_IS_SPADMIN')) {
                $admin_module = 1;
            }
            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins WHERE userid = ' . $userid);
            $db->query("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_admins (userid, catid, admin, add_content, edit_content, del_content) VALUES ('" . $userid . "', '0', '" . $admin_module . "', '1', '1', '1')");
        } else {
            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins WHERE userid = ' . $userid);
            $array_add_content = $nv_Request->get_typed_array('add_content', 'post', 'int', array());
            $array_edit_content = $nv_Request->get_typed_array('edit_content', 'post', 'int', array());
            $array_del_content = $nv_Request->get_typed_array('del_content', 'post', 'int', array());

            $sql = 'SELECT id, title, subid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY sort ASC';
            $result_cat = $db->query($sql);
            while ($row = $result_cat->fetch()) {
                $admin_i = (in_array($row['id'], $array_admin)) ? 1 : 0;
                if ($admin_i) {
                    $add_content_i = $edit_content_i = $del_content_i = 1;
                    if (!empty($row['subid'])) {
                        $array_subcatid_i = explode(',', $row['subid']);
                        foreach ($array_subcatid_i as $value) {
                            $array_admin[] = $value;
                        }
                    }
                } else {
                    $add_content_i = (in_array($row['id'], $array_add_content)) ? 1 : 0;
                    $edit_content_i = (in_array($row['id'], $array_edit_content)) ? 1 : 0;
                    $del_content_i = (in_array($row['id'], $array_del_content)) ? 1 : 0;
                    if (!empty($row['subid'])) {
                        $array_subcatid_i = explode(',', $row['subid']);
                        foreach ($array_subcatid_i as $value) {
                            if (!empty($add_content_i)) {
                                $array_add_content[] = $value;
                            }
                            if (!empty($edit_content_i)) {
                                $array_edit_content[] = $value;
                            }
                            if (!empty($del_content_i)) {
                                $array_del_content[] = $value;
                            }
                        }
                    }
                }
                $db->query("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_admins (userid, catid, admin, add_content, edit_content, del_content) VALUES ('" . $userid . "', '" . $row['id'] . "', '" . $admin_i . "', '" . $add_content_i . "', '" . $edit_content_i . "', '" . $del_content_i . "')");
            }
        }
        $base_url = str_replace('&amp;', '&', $base_url) . '&userid=' . $userid;
        nv_redirect_location($base_url);
    }
    $users_list = array();
    if (!empty($module_info['admins'])) {
        $sql = 'SELECT * FROM ' . NV_USERS_GLOBALTABLE . ' where userid IN (' . $module_info['admins'] . ')';
        if (!empty($orderby) and in_array($orderby, $orders)) {
            $orderby_sql = $orderby != 'full_name' ? $orderby : ($global_config['name_show'] == 0 ? "concat(first_name,' ',last_name)" : "concat(last_name,' ',first_name)");
            $sql .= ' ORDER BY ' . $orderby_sql . ' ' . $ordertype;
            $base_url .= '&amp;sortby=' . $orderby . '&amp;sorttype=' . $ordertype;
        }
        $result = $db->query($sql);
        while ($row = $result->fetch()) {
            $userid_i = (int) $row['userid'];
            $admin_module = (isset($array_cat_admin[$userid_i][0])) ? intval($array_cat_admin[$userid_i][0]['admin']) : 0;
            $admin_module_cat = $array_permissions_mod[$admin_module];
            $is_edit = true;
            if ($admin_module == 2 and !defined('NV_IS_SPADMIN')) {
                $is_edit = false;
            }
            $users_list[$row['userid']] = array(
                'userid' => $userid_i,
                'username' => (string) $row['username'],
                'full_name' => nv_show_name_user($row['first_name'], $row['last_name'], $row['username']),
                'email' => (string) $row['email'],
                'admin_module_cat' => $admin_module_cat,
                'is_edit' => $is_edit
            );
        }
    }

    if (!empty($users_list)) {
        $head_tds = array();
        $head_tds['userid']['title'] = $nv_Lang->getModule('admin_userid');
        $head_tds['userid']['href'] = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sortby=userid&amp;sorttype=ASC';
        $head_tds['username']['title'] = $nv_Lang->getModule('admin_username');
        $head_tds['username']['href'] = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sortby=username&amp;sorttype=ASC';
        $head_tds['full_name']['title'] = $global_config['name_show'] == 0 ? $nv_Lang->getModule('lastname_firstname') : $nv_Lang->getModule('firstname_lastname');
        $head_tds['full_name']['href'] = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sortby=full_name&amp;sorttype=ASC';
        $head_tds['email']['title'] = $nv_Lang->getModule('admin_email');
        $head_tds['email']['href'] = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sortby=email&amp;sorttype=ASC';

        foreach ($orders as $order) {
            if ($orderby == $order and $ordertype == 'ASC') {
                $head_tds[$order]['href'] = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sortby=' . $order . '&amp;sorttype=DESC';
                $head_tds[$order]['title'] .= ' &darr;';
            } elseif ($orderby == $order and $ordertype == 'DESC') {
                $head_tds[$order]['href'] = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sortby=' . $order . '&amp;sorttype=ASC';
                $head_tds[$order]['title'] .= ' &uarr;';
            }
        }

        $xtpl = new XTemplate('admin.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
        $xtpl->assign('STYLE_MODULE', $admin_module != 0 ? 'style="display: none"' : '');

        foreach ($head_tds as $head_td) {
            $xtpl->assign('HEAD_TD', $head_td);
            $xtpl->parse('main.head_td');
        }

        foreach ($users_list as $u) {
            $xtpl->assign('CONTENT_TD', $u);
            if ($u['is_edit']) {
                $xtpl->assign('EDIT_URL', $base_url . '&amp;userid=' . $u['userid']);
                $xtpl->parse('main.xusers.is_edit');
            }
            $xtpl->parse('main.xusers');
        }

        if ($userid > 0 and $userid != $admin_id) {
            $admin_module = (isset($array_cat_admin[$userid][0])) ? intval($array_cat_admin[$userid][0]['admin']) : 0;
            $is_edit = true;
            if ($admin_module == 2 and !defined('NV_IS_SPADMIN')) {
                $is_edit = false;
            }

            if ($is_edit) {
                if (!defined('NV_IS_SPADMIN')) {
                    unset($array_permissions_mod[2]);
                }

                foreach ($array_permissions_mod as $value => $text) {
                    $u = array(
                        'value' => $value,
                        'text' => $text,
                        'checked' => ($value == $admin_module) ? ' checked="checked"' : ''
                    );
                    $xtpl->assign('ADMIN_MODULE', $u);
                    $xtpl->parse('main.edit.admin_module');
                }

                $sql = 'SELECT id, title, lev FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY sort ASC';
                if ($db->query($sql)->fetchColumn() == 0) {
                    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat');
                }

                $xtpl->assign('ADMINDISPLAY', ($admin_module > 0) ? 'display:none;' : '');
                $result_cat = $db->query($sql);

                while ($row = $result_cat->fetch()) {
                    $xtitle_i = '';
                    if ($row['lev'] > 0) {
                        for ($i = 1; $i <= $row['lev']; $i++) {
                            $xtitle_i .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        }
                    }
                    $u = array();
                    $u['catid'] = $row['id'];
                    $u['title'] = $xtitle_i . $row['title'];
                    $u['checked_admin'] = (isset($array_cat_admin[$userid][$row['id']]) and $array_cat_admin[$userid][$row['id']]['admin'] == 1) ? ' checked="checked"' : '';
                    $u['checked_add_content'] = (isset($array_cat_admin[$userid][$row['id']]) and $array_cat_admin[$userid][$row['id']]['add_content'] == 1) ? ' checked="checked"' : '';
                    $u['checked_edit_content'] = (isset($array_cat_admin[$userid][$row['id']]) and $array_cat_admin[$userid][$row['id']]['edit_content'] == 1) ? ' checked="checked"' : '';
                    $u['checked_del_content'] = (isset($array_cat_admin[$userid][$row['id']]) and $array_cat_admin[$userid][$row['id']]['del_content'] == 1) ? ' checked="checked"' : '';
                    $xtpl->assign('CONTENT', $u);
                    $xtpl->parse('main.edit.catid');
                }

                $xtpl->assign('CAPTION_EDIT', $nv_Lang->getModule('admin_edit_user') . ': ' . $users_list[$userid]['username']);
                $xtpl->parse('main.edit');
            }
        }
        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    }
} elseif (defined('NV_IS_ADMIN_MODULE')) {
    $contents = '<br /><br /><br /><center><b>' . $nv_Lang->getModule('admin_module_for_user') . '</b></center><br /><br /><br />';
} else {
    $sql = 'SELECT id, title, lev FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY sort ASC';

    if ($db->query($sql)->fetchColumn() == 0) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat');
    }

    $xtpl = new XTemplate('admin.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('CAPTION_EDIT', $nv_Lang->getModule('admin_cat_for_user'));

    $result_cat = $db->query($sql);
    while ($row = $result_cat->fetch()) {
        if (isset($array_cat_admin[$admin_id][$row['id']])) {
            $u = array();
            $check_show = false;
            if ($array_cat_admin[$admin_id][$row['id']]['admin'] == 1) {
                $check_show = true;
            } else {
                if ($array_cat_admin[$admin_id][$row['id']]['add_content'] == 1) {
                    $check_show = true;
                } elseif ($array_cat_admin[$admin_id][$row['id']]['edit_content'] == 1) {
                    $check_show = true;
                }
            }
            if ($check_show) {
                $xtitle_i = '';
                if ($row['lev'] > 0) {
                    for ($i = 1; $i <= $row['lev']; $i++) {
                        $xtitle_i .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                }
                $u['catid'] = $row['id'];
                $u['title'] = $xtitle_i . $row['title'];
                $u['checked_admin'] = (isset($array_cat_admin[$admin_id][$row['id']]) and $array_cat_admin[$admin_id][$row['id']]['admin'] == 1) ? 'X' : '';
                $u['checked_add_content'] = (isset($array_cat_admin[$admin_id][$row['id']]) and $array_cat_admin[$admin_id][$row['id']]['add_content'] == 1) ? 'X' : '';
                $u['checked_edit_content'] = (isset($array_cat_admin[$admin_id][$row['id']]) and $array_cat_admin[$admin_id][$row['id']]['edit_content'] == 1) ? 'X' : '';
                $u['checked_del_content'] = (isset($array_cat_admin[$admin_id][$row['id']]) and $array_cat_admin[$admin_id][$row['id']]['del_content'] == 1) ? 'X' : '';
                $xtpl->assign('CONTENT', $u);
                $xtpl->parse('view_user.catid');
            }
        }
    }

    $xtpl->parse('view_user');
    $contents = $xtpl->text('view_user');
}

$page_title = $nv_Lang->getModule('admin');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
