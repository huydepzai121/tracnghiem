<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}

if ($NV_IS_ADMIN_MODULE) {
    define('NV_IS_ADMIN_MODULE', true);
}

if ($NV_IS_ADMIN_FULL_MODULE) {
    define('NV_IS_ADMIN_FULL_MODULE', true);
}

define('NV_MIN_MEDIUM_SYSTEM_ROWS', 100000);

$array_viewcat_full = [
    'viewcat_page_new' => $nv_Lang->getModule('viewcat_page_new'),
    'viewcat_page_old' => $nv_Lang->getModule('viewcat_page_old'),
    'viewcat_list_new' => $nv_Lang->getModule('viewcat_list_new'),
    'viewcat_list_old' => $nv_Lang->getModule('viewcat_list_old'),
    'viewcat_grid_new' => $nv_Lang->getModule('viewcat_grid_new'),
    'viewcat_grid_old' => $nv_Lang->getModule('viewcat_grid_old'),
    'viewcat_main_left' => $nv_Lang->getModule('viewcat_main_left'),
    'viewcat_main_right' => $nv_Lang->getModule('viewcat_main_right'),
    'viewcat_main_bottom' => $nv_Lang->getModule('viewcat_main_bottom'),
    'viewcat_two_column' => $nv_Lang->getModule('viewcat_two_column'),
    'viewcat_none' => $nv_Lang->getModule('viewcat_none')
];
$array_viewcat_nosub = [
    'viewcat_page_new' => $nv_Lang->getModule('viewcat_page_new'),
    'viewcat_page_old' => $nv_Lang->getModule('viewcat_page_old'),
    'viewcat_list_new' => $nv_Lang->getModule('viewcat_list_new'),
    'viewcat_list_old' => $nv_Lang->getModule('viewcat_list_old'),
    'viewcat_grid_new' => $nv_Lang->getModule('viewcat_grid_new'),
    'viewcat_grid_old' => $nv_Lang->getModule('viewcat_grid_old')
];

$array_allowed_comm = [
    $nv_Lang->getGlobal('no'),
    $nv_Lang->getGlobal('level6'),
    $nv_Lang->getGlobal('level4')
];

// Xác định layout giao diện của module đang dùng
$selectthemes = (!empty($site_mods[$module_name]['theme'])) ? $site_mods[$module_name]['theme'] : $global_config['site_theme'];
$layout_array = nv_scandir(NV_ROOTDIR . '/themes/' . $selectthemes . '/layout', $global_config['check_op_layout']);

define('NV_IS_FILE_ADMIN', true);
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

// Documents
$array_url_instruction['main'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:news';
$array_url_instruction['cat'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:news#quản_ly_chuyen_mục';
$array_url_instruction['content'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:news#them_bai_viet';
$array_url_instruction['tags'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:news#quản_ly_tags';
$array_url_instruction['groups'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:news#cac_nhom_tin';
$array_url_instruction['topics'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:news#theo_dong_sự_kiện';
$array_url_instruction['sources'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:news#nguồn_tin';
$array_url_instruction['admins'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:news#phan_quyền_quản_ly';
$array_url_instruction['setting'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:news#cấu_hinh_module';

global $global_array_cat;
$global_array_cat = [];
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY sort ASC';
$result = $db_slave->query($sql);
while ($row = $result->fetch()) {
    $global_array_cat[$row['catid']] = $row;
}

/**
 * nv_fix_cat_order()
 *
 * @param int $parentid
 * @param int $order
 * @param int $lev
 */
function nv_fix_cat_order($parentid = 0, $order = 0, $lev = 0)
{
    global $db, $module_data;

    $sql = 'SELECT catid, parentid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE parentid=' . $parentid . ' ORDER BY weight ASC';
    $result = $db->query($sql);
    $array_cat_order = [];
    while ($row = $result->fetch()) {
        $array_cat_order[] = $row['catid'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++$lev;
    } else {
        $lev = 0;
    }
    foreach ($array_cat_order as $catid_i) {
        ++$order;
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET weight=' . $weight . ', sort=' . $order . ', lev=' . $lev . ' WHERE catid=' . (int) $catid_i;
        $db->query($sql);
        $order = nv_fix_cat_order($catid_i, $order, $lev);
    }
    $numsubcat = $weight;
    if ($parentid > 0) {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET numsubcat=' . $numsubcat;
        if ($numsubcat == 0) {
            // Chuyên mục cha không có chuyên mục con
            $sql .= ",subcatid='', viewcat=CASE
            WHEN viewcat='viewcat_main_left' THEN 'viewcat_page_new'
            WHEN viewcat='viewcat_main_right' THEN 'viewcat_page_new'
            WHEN viewcat='viewcat_main_bottom' THEN 'viewcat_page_new'
            WHEN viewcat='viewcat_two_column' THEN 'viewcat_page_new'
            ELSE viewcat END";
        } else {
            $sql .= ",subcatid='" . implode(',', $array_cat_order) . "'";
        }
        $sql .= ' WHERE catid=' . (int) $parentid;
        $db->query($sql);
    }

    return $order;
}

/**
 * nv_fix_topic()
 */
function nv_fix_topic()
{
    global $db, $module_data;
    $sql = 'SELECT topicid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_topics ORDER BY weight ASC';
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_topics SET weight=' . $weight . ' WHERE topicid=' . (int) ($row['topicid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_fix_block_cat()
 */
function nv_fix_block_cat()
{
    global $db, $module_data;
    $sql = 'SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
    $weight = 0;
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat SET weight=' . $weight . ' WHERE bid=' . (int) ($row['bid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_fix_source()
 */
function nv_fix_source()
{
    global $db, $module_data;
    $sql = 'SELECT sourceid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources ORDER BY weight ASC';
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sources SET weight=' . $weight . ' WHERE sourceid=' . (int) ($row['sourceid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_news_fix_block()
 *
 * @param mixed $bid
 * @param bool  $repairtable
 */
function nv_news_fix_block($bid, $repairtable = true)
{
    global $db, $module_data;
    $bid = (int) $bid;
    if ($bid > 0) {
        $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $bid . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch()) {
            ++$weight;
            if ($weight <= 100) {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block SET weight=' . $weight . ' WHERE bid=' . $bid . ' AND id=' . $row['id'];
            } else {
                $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE bid=' . $bid . ' AND id=' . $row['id'];
            }
            $db->query($sql);
        }
        $result->closeCursor();
        if ($repairtable) {
            $db->query('OPTIMIZE TABLE ' . NV_PREFIXLANG . '_' . $module_data . '_block');
        }
    }
}

/**
 * nv_show_cat_list()
 *
 * @param int $parentid
 */
function nv_show_cat_list($parentid = 0)
{
    global $db, $nv_Lang, $nv_Lang, $module_name, $module_data, $array_viewcat_full, $array_viewcat_nosub, $array_cat_admin, $global_array_cat, $admin_id, $global_config, $module_file, $module_config, $global_code_defined;

    $xtpl = new XTemplate('cat_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);

    // Cac chu de co quyen han
    $array_cat_check_content = [];
    foreach ($global_array_cat as $catid_i => $array_value) {
        if (defined('NV_IS_ADMIN_MODULE')) {
            $array_cat_check_content[] = $catid_i;
        } elseif (isset($array_cat_admin[$admin_id][$catid_i])) {
            if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1) {
                $array_cat_check_content[] = $catid_i;
            } elseif ($array_cat_admin[$admin_id][$catid_i]['add_content'] == 1) {
                $array_cat_check_content[] = $catid_i;
            } elseif ($array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1) {
                $array_cat_check_content[] = $catid_i;
            } elseif ($array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
                $array_cat_check_content[] = $catid_i;
            }
        }
    }

    // Cac chu de co quyen han
    if ($parentid > 0) {
        $parentid_i = $parentid;
        $array_cat_title = [];
        $stt = 0;
        while ($parentid_i > 0) {
            $array_cat_title[] = [
                'active' => ($stt++ == 0) ? true : false,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=cat&amp;parentid=' . $parentid_i,
                'title' => $global_array_cat[$parentid_i]['title']
            ];
            $parentid_i = $global_array_cat[$parentid_i]['parentid'];
        }
        $array_cat_title[] = [
            'active' => false,
            'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=cat',
            'title' => $nv_Lang->getModule('cat_parent')
        ];
        krsort($array_cat_title, SORT_NUMERIC);

        foreach ($array_cat_title as $cat) {
            $xtpl->assign('CAT', $cat);
            if ($cat['active']) {
                $xtpl->parse('main.cat_title.active');
            } else {
                $xtpl->parse('main.cat_title.loop');
            }
        }
        $xtpl->parse('main.cat_title');
    }

    $sql = 'SELECT catid, parentid, title, alias, weight, viewcat, numsubcat, numlinks, newday, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE parentid = ' . $parentid . ' ORDER BY weight ASC';
    $rowall = $db->query($sql)->fetchAll(3);
    $num = count($rowall);
    $a = 1;
    $array_status = [
        $nv_Lang->getModule('cat_status_0'),
        $nv_Lang->getModule('cat_status_1'),
        $nv_Lang->getModule('cat_status_2')
    ];
    $is_large_system = (nv_get_mod_countrows() > NV_MIN_MEDIUM_SYSTEM_ROWS);

    $xtpl->assign('MAX_WEIGHT', $num);
    $xtpl->assign('MAX_NUMLINKS', 20);
    $xtpl->assign('MAX_NEWDAY', 10);

    foreach ($rowall as $row) {
        [$catid, $parentid, $title, $alias, $weight, $viewcat, $numsubcat, $numlinks, $newday, $status] = $row;
        if (defined('NV_IS_ADMIN_MODULE')) {
            $check_show = 1;
        } else {
            $array_cat = GetCatidInParent($catid);
            $check_show = array_intersect($array_cat, $array_cat_check_content);
        }

        if (!empty($check_show)) {
            $array_viewcat = ($numsubcat > 0) ? $array_viewcat_full : $array_viewcat_nosub;
            if (!array_key_exists($viewcat, $array_viewcat)) {
                $viewcat = 'viewcat_page_new';
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET viewcat= :viewcat WHERE catid=' . (int) $catid);
                $stmt->bindParam(':viewcat', $viewcat, PDO::PARAM_STR);
                $stmt->execute();
            }

            $admin_funcs = [];
            $weight_disabled = $func_cat_disabled = true;
            if (!empty($module_config[$module_name]['instant_articles_active'])) {
                $admin_funcs[] = '<a title="' . $nv_Lang->getModule('cat_instant_view') . '" href="' . urlRewriteWithDomain(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=instant-rss/' . $alias, NV_MY_DOMAIN) . '" class="btn btn-default btn-xs viewinstantrss" data-toggle="tooltip" data-modaltitle="' . $nv_Lang->getModule('cat_instant_title') . '"><em class="fa fa-rss"></em><span class="visible-xs-inline-block">&nbsp;' . $nv_Lang->getModule('cat_instant_viewsimple') . "</span></a>\n";
            }
            if (defined('NV_IS_ADMIN_MODULE') or (isset($array_cat_admin[$admin_id][$catid]) and $array_cat_admin[$admin_id][$catid]['add_content'] == 1)) {
                $func_cat_disabled = false;
                $admin_funcs[] = '<a title="' . $nv_Lang->getModule('content_add') . '" href="' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&amp;catid=' . $catid . '&amp;parentid=' . $parentid . '" class="btn btn-success btn-xs" data-toggle="tooltip"><em class="fa fa-plus"></em><span class="visible-xs-inline-block">&nbsp;' . $nv_Lang->getModule('content_add') . "</span></a>\n";
            }
            if (defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_cat_admin[$admin_id][$parentid]) and $array_cat_admin[$admin_id][$parentid]['admin'] == 1)) {
                $func_cat_disabled = false;
                $admin_funcs[] = '<a title="' . $nv_Lang->getGlobal('edit') . '" href="' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=cat&amp;catid=' . $catid . '&amp;parentid=' . $parentid . '" class="btn btn-info btn-xs" data-toggle="tooltip"><em class="fa fa-edit"></em><span class="visible-xs-inline-block">&nbsp;' . $nv_Lang->getGlobal('edit') . "</span></a>\n";
            }
            if (defined('NV_IS_ADMIN_MODULE') or ($parentid > 0 and isset($array_cat_admin[$admin_id][$parentid]) and $array_cat_admin[$admin_id][$parentid]['admin'] == 1)) {
                $weight_disabled = false;
                $admin_funcs[] = '<a title="' . $nv_Lang->getGlobal('delete') . '" href="javascript:void(0);" onclick="nv_del_cat(' . $catid . ')" class="btn btn-danger btn-xs" data-toggle="tooltip"><em class="fa fa-trash-o"></em><span class="visible-xs-inline-block">&nbsp;' . $nv_Lang->getGlobal('delete') . '</span></a>';
            }

            $xtpl->assign('ROW', [
                'catid' => $catid,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=cat&amp;parentid=' . $catid,
                'title' => $title,
                'adminfuncs' => implode(' ', $admin_funcs)
            ]);

            $xtpl->assign('STT', $a);
            $xtpl->assign('STATUS', $status > $global_code_defined['cat_locked_status'] ? $nv_Lang->getModule('cat_locked_byparent') : $array_status[$status]);
            $xtpl->assign('STATUS_VAL', $status);
            $xtpl->assign('VIEWCAT', $array_viewcat[$viewcat]);
            $xtpl->assign('VIEWCAT_VAL', $viewcat);
            $xtpl->assign('VIEWCAT_MODE', $numsubcat > 0 ? 'full' : 'nosub');
            $xtpl->assign('NUMLINKS', $numlinks);
            $xtpl->assign('NEWDAY', $newday);

            if ($weight_disabled) {
                $xtpl->parse('main.data.loop.stt');
            } else {
                $xtpl->parse('main.data.loop.weight');
            }

            if ($func_cat_disabled) {
                $xtpl->parse('main.data.loop.disabled_status');
                $xtpl->parse('main.data.loop.disabled_viewcat');
                $xtpl->parse('main.data.loop.title_numlinks');
                $xtpl->parse('main.data.loop.title_newday');
            } else {
                if ($status > $global_code_defined['cat_locked_status']) {
                    $xtpl->assign('STATUS', $nv_Lang->getModule('cat_locked_byparent'));
                    $xtpl->parse('main.data.loop.disabled_status');
                } elseif ($is_large_system and $status == 0) {
                    $xtpl->assign('STATUS', $array_status[$status]);
                    $xtpl->parse('main.data.loop.disabled_status');
                } else {
                    $xtpl->parse('main.data.loop.status');
                }

                $xtpl->parse('main.data.loop.viewcat');
                $xtpl->parse('main.data.loop.numlinks');
                $xtpl->parse('main.data.loop.newday');
            }

            if ($numsubcat) {
                $xtpl->assign('NUMSUBCAT', $numsubcat);
                $xtpl->parse('main.data.loop.numsubcat');
            }

            $xtpl->parse('main.data.loop');
            ++$a;
        }
    }

    if ($num > 0) {
        foreach ($array_viewcat_full as $k => $v) {
            $xtpl->assign('K', $k);
            $xtpl->assign('V', $v);
            $xtpl->parse('main.data.viewcat_full');
        }
        foreach ($array_viewcat_nosub as $k => $v) {
            $xtpl->assign('K', $k);
            $xtpl->assign('V', $v);
            $xtpl->parse('main.data.viewcat_nosub');
        }
        foreach ($array_status as $key => $val) {
            if (!$is_large_system or $key != 0) {
                $xtpl->assign('K', $key);
                $xtpl->assign('V', $val);
                $xtpl->parse('main.data.status');
            }
        }
        $xtpl->parse('main.data');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    return $contents;
}

/**
 * nv_show_topics_list()
 *
 * @param mixed $page
 */
function nv_show_topics_list($page = 1)
{
    global $db_slave, $module_name, $module_data, $module_config, $global_config, $module_file, $module_info;

    $per_page = $module_config[$module_name]['per_page'];
    $db_slave->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_topics');

    $num_items = $db_slave->query($db_slave->sql())->fetchColumn();
    $max_height = $page * $per_page;
    if ($max_height > $num_items) {
        $max_height = $num_items;
    }

    $db_slave->select('*')
        ->order('weight ASC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $_array_topic = $db_slave->query($db_slave->sql())->fetchAll();
    $num = count($_array_topic);

    if ($num > 0) {
        $xtpl = new XTemplate('topics_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
        $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
        $xtpl->assign('TOTAL', $num_items);
        foreach ($_array_topic as $row) {
            $numnews = $db_slave->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows where topicid=' . $row['topicid'])->fetchColumn();

            $xtpl->assign('ROW', [
                'weight' => $row['weight'],
                'topicid' => $row['topicid'],
                'description' => $row['description'],
                'title' => $row['title'],
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=topicsnews&amp;topicid=' . $row['topicid'],
                'linksite' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['topic'] . '/' . $row['alias'],
                'numnews' => $numnews,
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=topics&amp;topicid=' . $row['topicid'] . '#edit'
            ]);

            $xtpl->parse('main.loop');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
        $contents .= nv_generate_page(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=topics', $num_items, $per_page, $page);
    } else {
        $contents = '&nbsp;';
    }

    return $contents;
}

/**
 * nv_show_block_cat_list()
 */
function nv_show_block_cat_list()
{
    global $db_slave, $nv_Lang, $module_name, $module_data, $module_file, $global_config, $module_info;

    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
    $_array_block_cat = $db_slave->query($sql)->fetchAll();
    $num = count($_array_block_cat);

    if ($num > 0) {
        $array_adddefault = [
            $nv_Lang->getGlobal('no'),
            $nv_Lang->getGlobal('yes')
        ];

        $xtpl = new XTemplate('blockcat_lists.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
        $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
        $xtpl->assign('TOTAL', $num);

        foreach ($_array_block_cat as $row) {
            $numnews = $db_slave->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $row['bid'])->fetchColumn();

            $xtpl->assign('ROW', [
                'bid' => $row['bid'],
                'weight' => $row['weight'],
                'title' => $row['title'],
                'numnews' => $numnews,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=block&amp;bid=' . $row['bid'],
                'linksite' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $row['alias'],
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=groups&amp;bid=' . $row['bid'] . '#edit'
            ]);

            foreach ($array_adddefault as $key => $val) {
                $xtpl->assign('ADDDEFAULT', [
                    'key' => $key,
                    'title' => $val,
                    'selected' => $key == $row['adddefault'] ? ' selected="selected"' : ''
                ]);
                $xtpl->parse('main.loop.adddefault');
            }

            for ($i = 1; $i <= 30; ++$i) {
                $xtpl->assign('NUMBER', [
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['numbers'] ? ' selected="selected"' : ''
                ]);
                $xtpl->parse('main.loop.number');
            }

            $xtpl->parse('main.loop');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }

    return $contents;
}

/**
 * nv_show_sources_list()
 */
function nv_show_sources_list()
{
    global $db_slave, $module_name, $module_data, $nv_Request, $module_file, $global_config;

    $num = $db_slave->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources')->fetchColumn();
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=sources';
    $num_items = ($num > 1) ? $num : 1;
    $per_page = 20;
    $page = $nv_Request->get_page('page', 'get', 1);

    $xtpl = new XTemplate('sources_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('TOTAL', $num);

    if ($num > 0) {
        $db_slave->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_sources')
            ->order('weight')
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);

        $result = $db_slave->query($db_slave->sql());
        while ($row = $result->fetch()) {
            $xtpl->assign('ROW', [
                'sourceid' => $row['sourceid'],
                'weight' => $row['weight'],
                'title' => $row['title'],
                'link' => $row['link'],
                'url_edit' => $base_url . '&amp;sourceid=' . $row['sourceid']
            ]);
            $xtpl->parse('main.loop');
        }
        $result->closeCursor();

        $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
        if (!empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.generate_page');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }

    return $contents;
}

/**
 * nv_show_block_list()
 *
 * @param mixed $bid
 */
function nv_show_block_list($bid)
{
    global $db_slave, $nv_Lang, $module_name, $module_data, $op, $global_array_cat, $module_file, $global_config;

    $xtpl = new XTemplate('block_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('BID', $bid);

    $global_array_cat[0] = ['alias' => 'Other'];

    $sql = 'SELECT t1.id, t1.catid, t1.title, t1.alias, t1.publtime, t1.status, t1.hitstotal, t1.hitscm, t2.weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_block t2 ON t1.id = t2.id WHERE t2.bid= ' . $bid . ' AND t1.status=1 ORDER BY t2.weight ASC';
    $array_block = $db_slave->query($sql)->fetchAll();
    $num = count($array_block);
    if ($num > 0) {
        foreach ($array_block as $row) {
            $xtpl->assign('ROW', [
                'publtime' => nv_datetime_format($row['publtime'], 1),
                'status' => $nv_Lang->getModule('status_' . $row['status']),
                'hitstotal' => nv_number_format($row['hitstotal']),
                'hitscm' => nv_number_format($row['hitscm']),
                'id' => $row['id'],
                'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'],
                'title' => $row['title']
            ]);

            for ($i = 1; $i <= $num; ++$i) {
                $xtpl->assign('WEIGHT', [
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ]);
                $xtpl->parse('main.loop.weight');
            }

            $xtpl->parse('main.loop');
        }

        if (defined('NV_IS_SPADMIN')) {
            $xtpl->assign('ORDER_PUBLTIME', md5($bid . NV_CHECK_SESSION));
            $xtpl->parse('main.order_publtime');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }

    return $contents;
}

/**
 * GetCatidInParent()
 *
 * @param mixed $catid
 */
function GetCatidInParent($catid)
{
    global $global_array_cat;
    $array_cat = [];
    $array_cat[] = $catid;
    $subcatid = explode(',', $global_array_cat[$catid]['subcatid']);
    if (!empty($subcatid)) {
        foreach ($subcatid as $id) {
            if ($id > 0) {
                if ($global_array_cat[$id]['numsubcat'] == 0) {
                    $array_cat[] = $id;
                } else {
                    $array_cat_temp = GetCatidInParent($id);
                    foreach ($array_cat_temp as $catid_i) {
                        $array_cat[] = $catid_i;
                    }
                }
            }
        }
    }

    return array_unique($array_cat);
}

/**
 * redriect()
 *
 * @param string $msg1
 * @param string $msg2
 * @param mixed  $nv_redirect
 * @param mixed  $autoSaveKey
 * @param mixed  $go_back
 */
function redriect($msg1, $msg2, $nv_redirect, $autoSaveKey = '', $go_back = '')
{
    global $module_name, $nv_Lang, $op;

    $tpl = new \NukeViet\Template\NVSmarty();
    $tpl->setTemplateDir(get_module_tpl_dir('redriect.tpl'));
    $tpl->assign('LANG', $nv_Lang);
    $tpl->assign('MODULE_NAME', $module_name);
    $tpl->assign('OP', $op);

    if (empty($nv_redirect)) {
        $nv_redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
    }
    $tpl->assign('NV_REDIRECT', $nv_redirect);
    $tpl->assign('MSG1', $msg1);
    $tpl->assign('MSG2', $msg2);
    $tpl->assign('AUTOSAVEKEY', $autoSaveKey);

    if (nv_strlen($msg1) > 255) {
        $tpl->assign('REDRIECT_T1', 20);
        $tpl->assign('REDRIECT_T2', 20000);
    } else {
        $tpl->assign('REDRIECT_T1', 5);
        $tpl->assign('REDRIECT_T2', 5000);
    }
    $tpl->assign('GO_BACK', $go_back ? 1 : 0);

    $contents = $tpl->fetch('redriect.tpl');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

/**
 * get_mod_alias()
 *
 * @param mixed  $title
 * @param string $mod
 * @param int    $id
 */
function get_mod_alias($title, $mod = '', $id = 0)
{
    global $module_data, $module_config, $module_name, $db_slave;

    if (empty($title)) {
        return '';
    }

    $alias = change_alias($title);
    if ($module_config[$module_name]['alias_lower']) {
        $alias = strtolower($alias);
    }
    $id = (int) $id;

    if ($mod == 'cat') {
        $tab = NV_PREFIXLANG . '_' . $module_data . '_cat';
        $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE catid!=' . $id . ' AND alias= :alias');
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        if (!empty($nb)) {
            $nb = $db_slave->query('SELECT MAX(catid) FROM ' . $tab)->fetchColumn();

            $alias .= '-' . ((int) $nb + 1);
        }
    } elseif ($mod == 'topics') {
        $tab = NV_PREFIXLANG . '_' . $module_data . '_topics';
        $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE topicid!=' . $id . ' AND alias= :alias');
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        if (!empty($nb)) {
            $nb = $db_slave->query('SELECT MAX(topicid) FROM ' . $tab)->fetchColumn();

            $alias .= '-' . ((int) $nb + 1);
        }
    } elseif ($mod == 'blockcat') {
        $tab = NV_PREFIXLANG . '_' . $module_data . '_block_cat';
        $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE bid!=' . $id . ' AND alias= :alias');
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        if (!empty($nb)) {
            $nb = $db_slave->query('SELECT MAX(bid) FROM ' . $tab)->fetchColumn();

            $alias .= '-' . ((int) $nb + 1);
        }
    }

    return $alias;
}

/**
 * nv_get_mod_countrows()
 */
function nv_get_mod_countrows()
{
    global $module_data, $nv_Cache, $module_name;
    $sql = 'SELECT COUNT(*) totalnews FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows';
    $list = $nv_Cache->db($sql, '', $module_name);

    return $list[0]['totalnews'];
}

/**
 * nv_get_mod_tags()
 * Tìm tags cho bài viết dựa vào thư viện tags
 *
 * @param mixed $content
 * @return array
 */
function nv_get_mod_tags($content)
{
    global $db, $module_data;

    $content = strip_tags($content);
    $content = nv_unhtmlspecialchars($content);
    $content = strip_punctuation($content);
    $content = trim($content);
    $content = nv_strtolower($content);
    $ts = explode(' ', $content);
    $ts = array_map('trim', $ts);
    $ts = array_filter($ts);
    $ts = array_unique($ts);
    $ts = array_map(function ($t) {
        return preg_replace('/([\W])/u', '\\\\$1', $t);
    }, $ts);
    $ts = implode('|', $ts);

    $db->sqlreset()
        ->select('keywords')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_tags')
        ->where("keywords REGEXP " . $db->quote('^' . $ts . '$')  . " OR keywords REGEXP " . $db->quote('^' . $ts . ',')   . " OR keywords REGEXP " . $db->quote(',' . $ts . ',')   . " OR keywords REGEXP " . $db->quote(',' . $ts . '$'));

    $result = $db->query($db->sql());
    $ts = [];
    while ([$keyword] = $result->fetch(3)) {
        $keyword = array_map('trim', explode(',', $keyword));
        $keyword = array_map('nv_preg_quote', $keyword);
        $ts = array_merge($ts, $keyword);
    }

    $tags = [];
    if (!empty($ts)) {
        $ts = implode('|', $ts);
        unset($matches);
        preg_match_all('/(' . $ts . ')/', $content, $matches);
        if (!empty($matches[1])) {
            $tags = array_unique($matches[1]);
        }
    }

    return !empty($tags) ? array_values($tags) : [];
}

/**
 * setTagAlias()
 *
 * @param mixed $keywords
 * @param int   $tid
 * @param int   $dbexist
 * @return string|null
 * @throws PDOException
 */
function setTagAlias($keywords, $tid = 0, &$dbexist = 0)
{
    global $db, $module_data, $module_config, $module_name;

    $alias = ($module_config[$module_name]['tags_alias']) ? get_mod_alias($keywords) : change_alias_tags($keywords);
    $dbexist = (bool) $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags WHERE alias=' . $db->quote($alias) . ' AND tid!=' . $tid)->fetchColumn();

    return $alias;
}

/**
 * setTagKeywords()
 *
 * @param mixed $keywords
 * @param bool  $isArr
 * @return array|string
 */
function setTagKeywords($keywords, $isArr = false)
{
    $keywords = nv_strtolower($keywords);
    $keywords = explode(',', $keywords);
    $keywords = array_map('trim', $keywords);
    $keywords = array_filter($keywords);
    $keywords = array_unique($keywords);
    sort($keywords);

    if ($isArr) {
        return $keywords;
    }

    return implode(',', $keywords);
}
