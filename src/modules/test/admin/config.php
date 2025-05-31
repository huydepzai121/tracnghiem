<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $nv_Lang->getModule('config');
$groups_list = nv_test_groups_list();

// Khởi tạo config mặc định nếu chưa có
$default_config = array(
    'enable_social' => 1,
    'enable_editor' => 1,
    'homewidth' => 400,
    'homeheight' => 300,
    'tags_alias_lower' => 0,
    'tags_alias' => 0,
    'auto_tags' => 0,
    'tags_remind' => 0,
    'structure_upload' => 'Ym',
    'indexfile' => 0,
    'st_links' => 5,
    'per_page' => 15,
    'imgposition' => 0,
    'showhometext' => 0,
    'examp_template' => 0,
    'sample_deleted' => 0,
    'preview_question' => 0,
    'config_source' => 0,
    'order_exams' => 0,
    'oaid' => '',
    'alert_type' => 0,
    'allow_del_history' => 0,
    'allow_question_point' => 0,
    'config_history_user_common' => 0,
    'block_copy_paste' => 0,
    'payment' => '',
    'top_content_exam' => '',
    'allow_question_type' => '1,2,3,4',
    'groups_use' => '',
    'no_image' => ''
);

// Merge với config hiện tại, ưu tiên config đã có
foreach ($default_config as $key => $default_value) {
    if (!isset($array_config[$key])) {
        $array_config[$key] = $default_value;
    }
}

$data = array();
if ($nv_Request->isset_request('savesetting', 'post')) {
    $data['enable_social'] = $nv_Request->get_int('enable_social', 'post');
    $data['enable_editor'] = $nv_Request->get_int('enable_editor', 'post');
    $data['homewidth'] = $nv_Request->get_int('homewidth', 'post', 0);
    $data['homeheight'] = $nv_Request->get_int('homeheight', 'post', 0);
    $data['tags_alias_lower'] = $nv_Request->get_int('tags_alias_lower', 'post', 0);
    $data['tags_alias'] = $nv_Request->get_int('tags_alias', 'post', 0);
    $data['auto_tags'] = $nv_Request->get_int('auto_tags', 'post', 0);
    $data['tags_remind'] = $nv_Request->get_int('tags_remind', 'post', 0);
    $data['structure_upload'] = $nv_Request->get_title('structure_upload', 'post', 'Ym');
    $data['indexfile'] = $nv_Request->get_int('indexfile', 'post', 0);
    $data['st_links'] = $nv_Request->get_int('st_links', 'post', 5);
    $data['per_page'] = $nv_Request->get_int('per_page', 'post', 15);
    $data['per_page'] = $data['per_page'] > 0 ? $data['per_page'] : 1;
    $data['imgposition'] = $nv_Request->get_int('imgposition', 'post', 0);
    $data['showhometext'] = $nv_Request->get_int('showhometext', 'post', 0);
    $data['examp_template'] = $nv_Request->get_int('examp_template', 'post', 0);
    $data['sample_deleted'] = $nv_Request->get_int('sample_deleted', 'post', 0);
    $data['preview_question'] = $nv_Request->get_int('preview_question', 'post', 0);
    $data['config_source'] = $nv_Request->get_int('config_source', 'post', 0);
    $data['order_exams'] = $nv_Request->get_int('order_exams', 'post', 0);
    $data['oaid'] = $nv_Request->get_title('oaid', 'post', '');
    $data['alert_type'] = $nv_Request->get_int('alert_type', 'post', 0);
    $data['allow_del_history'] = $nv_Request->get_int('allow_del_history', 'post', 0);
    $data['allow_question_point'] = $nv_Request->get_int('allow_question_point', 'post', 0);
    $data['config_history_user_common'] = $nv_Request->get_int('config_history_user_common', 'post', 0);
    $data['block_copy_paste'] = $nv_Request->get_int('block_copy_paste', 'post', 0);
    $data['payment'] = $nv_Request->get_title('payment', 'post', '');

    $data['top_content_exam'] = $nv_Request->get_editor('top_content_exam', '', NV_ALLOWED_HTML_TAGS);
    $data['allow_question_type'] = $nv_Request->get_typed_array('allow_question_type', 'post', 'int');
    array_push($data['allow_question_type'], 1); // mặc định phải có loại câu hỏi trắc nghiệm lựa chọn
    $data['allow_question_type'] = implode(',', $data['allow_question_type']);

    $_groups_post = $nv_Request->get_array('groups_use', 'post', array());
    $data['groups_use'] = !empty($_groups_post) ? implode(',', nv_groups_post(array_intersect($_groups_post, array_keys($groups_list)))) : '';

    $data['no_image'] = $nv_Request->get_title('no_image', 'post', '');
    if (is_file(NV_DOCUMENT_ROOT . $data['no_image'])) {
        $data['no_image'] = substr($data['no_image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
    } else {
        $data['no_image'] = '';
    }

    $replace_sql = "REPLACE INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . NV_LANG_DATA . "', :module_name, :config_name, :config_value)";
    $replace_sth = $db->prepare($replace_sql);
    $replace_sth->bindParam(':module_name', $module_name, PDO::PARAM_STR);

    foreach ($data as $config_name => $config_value) {
        $replace_sth->bindParam(':config_name', $config_name, PDO::PARAM_STR);
        $replace_sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $replace_sth->execute();
    }

    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('config'), "Config", $admin_info['userid']);
    $nv_Cache->delMod('settings');

    nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . '=' . $op);
}

$array_config['ck_enable_social'] = $array_config['enable_social'] ? 'checked="checked"' : '';
$array_config['ck_enable_editor'] = $array_config['enable_editor'] ? 'checked="checked"' : '';
$array_config['ck_tags_alias_lower'] = $array_config['tags_alias_lower'] ? 'checked="checked"' : '';
$array_config['ck_tags_alias'] = $array_config['tags_alias'] ? 'checked="checked"' : '';
$array_config['ck_auto_tags'] = $array_config['auto_tags'] ? 'checked="checked"' : '';
$array_config['ck_tags_remind'] = $array_config['tags_remind'] ? 'checked="checked"' : '';
$array_config['ck_showhometext'] = $array_config['showhometext'] ? 'checked="checked"' : '';
$array_config['ck_preview_question'] = $array_config['preview_question'] ? 'checked="checked"' : '';
$array_config['ck_allow_del_history'] = $array_config['allow_del_history'] ? 'checked="checked"' : '';
$array_config['ck_allow_question_point'] = $array_config['allow_question_point'] ? 'checked="checked"' : '';
$array_config['ck_block_copy_paste'] = $array_config['block_copy_paste'] ? 'checked="checked"' : '';
$array_config['ck_config_history_user_common'] = $array_config['config_history_user_common'] ? 'checked="checked"' : '';

// Khởi tạo giá trị mặc định nếu chưa có
if (!isset($array_config['top_content_exam'])) {
    $array_config['top_content_exam'] = '';
}

$array_config['no_image_currentpath'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload;
if (!empty($array_config['no_image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $array_config['no_image'])) {
    $array_config['no_image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array_config['no_image'];
    $array_config['no_image_currentpath'] = dirname($array_config['no_image']);
}

// Khởi tạo biến cho editor
$username_alias = change_alias($admin_info['username']);
$upload_user_path = nv_upload_user_path($username_alias);
$currentpath = $upload_user_path['currentpath'];
$uploads_dir_user = $upload_user_path['uploads_dir_user'];

if (defined('NV_EDITOR')) require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $array_config['top_content_exam'] = nv_aleditor('top_content_exam', '100%', '100px', $array_config['top_content_exam'], '', $uploads_dir_user, $currentpath);
} else {
    $array_config['top_content_exam'] = '<textarea class="form-control" style="width:100%;height:100px" name="top_content_exam">' . htmlspecialchars($array_config['top_content_exam']) . '</textarea>';
}

$xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('DATA', $array_config);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('top_content_exam', $array_config['top_content_exam']);

$array_structure_image = array();
$array_structure_image[''] = NV_UPLOADS_DIR . '/' . $module_upload;
$array_structure_image['Y'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y');
$array_structure_image['Ym'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y_m');
$array_structure_image['Y_m'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y/m');
$array_structure_image['Ym_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y_m/d');
$array_structure_image['Y_m_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y/m/d');
$array_structure_image['username'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username';
$array_structure_image['username_Y'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username/' . date('Y');
$array_structure_image['username_Ym'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username/' . date('Y_m');
$array_structure_image['username_Y_m'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username/' . date('Y/m');
$array_structure_image['username_Ym_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username/' . date('Y_m/d');
$array_structure_image['username_Y_m_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username/' . date('Y/m/d');
$structure_image_upload = isset($array_config['structure_upload']) ? $array_config['structure_upload'] : "Ym";

foreach ($array_structure_image as $type => $dir) {
    $xtpl->assign('STRUCTURE_UPLOAD', array(
        'key' => $type,
        'title' => $dir,
        'selected' => $type == $structure_image_upload ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.structure_upload');
}

$array_indexfile = array(
    1 => $nv_Lang->getModule('config_indexfile_1'),
    2 => $nv_Lang->getModule('config_indexfile_2'),
    3 => $nv_Lang->getModule('config_indexfile_3'),
    4 => $nv_Lang->getModule('config_indexfile_4'),
    5 => $nv_Lang->getModule('config_indexfile_5'),
    0 => $nv_Lang->getModule('config_indexfile_0')
);
foreach ($array_indexfile as $index => $value) {
    $sl = $index == $array_config['indexfile'] ? 'selected="selected"' : '';
    $xtpl->assign('INDEXFILE', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.indexfile');
}

$array_examp_template = array(
    0 => $nv_Lang->getModule('examp_template_list'),
    1 => $nv_Lang->getModule('examp_template_each_question')
);
foreach ($array_examp_template as $index => $value) {
    $sl = $index == $array_config['examp_template'] ? 'selected="selected"' : '';
    $xtpl->assign('EXAMP_TEMPLATE', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.examp_template');
}

$array_imgposition = array(
    0 => $nv_Lang->getModule('config_imgposition_0'),
    1 => $nv_Lang->getModule('config_imgposition_1'),
    2 => $nv_Lang->getModule('config_imgposition_2')
);
foreach ($array_imgposition as $index => $value) {
    $sl = $index == $array_config['imgposition'] ? 'selected="selected"' : '';
    $xtpl->assign('IMGPOS', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.imgposition');
}

$array_alert_type = array(
    0 => $nv_Lang->getModule('config_alert_type_0'),
    1 => $nv_Lang->getModule('config_alert_type_1')
);
foreach ($array_alert_type as $index => $value) {
    $sl = $index == $array_config['alert_type'] ? 'checked="checked"' : '';
    $xtpl->assign('ALERT_TYPE', array(
        'index' => $index,
        'value' => $value,
        'checked' => $sl
    ));
    $xtpl->parse('main.alert_type');
}

$groups_view = explode(',', $array_config['groups_use']);
foreach ($groups_list as $group_id => $grtl) {
    $_groups_view = array(
        'value' => $group_id,
        'checked' => in_array($group_id, $groups_view) ? ' checked="checked"' : '',
        'title' => $grtl
    );
    $xtpl->assign('GROUPS_USE', $_groups_view);
    $xtpl->parse('main.groups_use');
}

$array_config_source = array(
    0 => $nv_Lang->getModule('config_source_title'),
    3 => $nv_Lang->getModule('config_source_link'),
    1 => $nv_Lang->getModule('config_source_link_nofollow'),
    2 => $nv_Lang->getModule('config_source_logo')
);
foreach ($array_config_source as $key => $val) {
    $xtpl->assign('CONFIG_SOURCE', array(
        'key' => $key,
        'title' => $val,
        'selected' => $key == $module_config[$module_name]['config_source'] ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.config_source');
}

for ($i = 0; $i < 2; $i++) {
    $xtpl->assign('ORDER_EXAMS', array(
        'key' => $i,
        'title' => $nv_Lang->getModule('config_order_exams_' . $i),
        'selected' => $i == $array_config['order_exams'] ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.order_exams');
}

if (defined('NV_IS_GODADMIN')) {
    $xtpl->parse('main.allow_question_point');
}

if (isset($global_config['allow_config_history_user_common']) && $global_config['allow_config_history_user_common']) {
    $xtpl->parse('main.allow_config_history_user_common');
}

$array_config['allow_question_type'] = !empty($array_config['allow_question_type']) ? explode(',', $array_config['allow_question_type']) : array();

// mặc định phải có loại câu hỏi trắc nghiệm lựa chọn
array_push($array_config['allow_question_type'], 1);

foreach ($array_question_type as $index => $value) {
    $xtpl->assign('QUESTION_TYPE', array(
        'index' => $index,
        'value' => $value,
        'checked' => in_array($index, $array_config['allow_question_type']) ? 'checked="checked"' : '',
        'disabled' => $index == 1 ? 'disabled="disabled"' : ''
    ));
    $xtpl->parse('main.question_type');
}

if ((defined('NV_IS_GODADMIN') or defined('NV_IS_SPADMIN')) && $global_config['require_once_wallet']) {
    $array_payment = array();
    if (isset($site_mods['wallet'])) {
        $array_payment = array(
            'wallet' => $site_mods['wallet']['custom_title']
        );
    }
    if (!empty($array_payment)) {
        foreach ($array_payment as $index => $value) {
            $sl = $index == $array_config['payment'] ? 'selected="selected"' : '';
            $xtpl->assign('PAYMENT', array(
                'index' => $index,
                'value' => $value,
                'selected' => $sl
            ));
            $xtpl->parse('main.payment.loop');
        }
    }
    $xtpl->parse('main.payment');
}



$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
