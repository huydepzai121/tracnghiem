<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('edit_title');
$cid = $nv_Request->get_int('cid', 'get,post');
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE cid=' . $cid;
$row = $db->query($sql)->fetch();

$checkss = md5(NV_CHECK_SESSION . '_' . $module_name . '_' . $admin_info['userid']);
$dir = date('Y_m');
if (!is_dir(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $dir)) {
    $mk = nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $module_upload, $dir);
    if ($mk[0] > 0) {
        try {
            $db->query('INSERT INTO ' . NV_UPLOAD_GLOBALTABLE . "_dir (dirname, time) VALUES ('" . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $dir . "', 0)");
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
        }
    }
}

if ($nv_Request->isset_request('save', 'post')) {
    if ($checkss != $nv_Request->get_title('checkss', 'post') or empty($row) or !isset($site_mod_comm[$row['module']])) {
        nv_jsonOutput(['status' => 'error', 'mess' => $nv_Lang->getGlobal('error_code_11')]);
    }
    $delete = $nv_Request->get_int('delete', 'post', 0);
    if ($delete) {
        if (!empty($row['attach'])) {
            nv_deletefile(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['attach']);
        }
        $count = $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE cid=' . $cid);
    } else {
        $content = nv_editor_nl2br($nv_Request->get_editor('content', '', NV_ALLOWED_HTML_TAGS));
        $active = $nv_Request->get_int('active', 'post', 0);
        $active = ($active == 1) ? 1 : 0;
        $attach = $nv_Request->get_string('attach', 'post', '', true);
        if (!empty($attach)) {
            $attach = substr($attach, strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
        }

        $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET content= :content, attach=:attach, status=' . $active . ' WHERE cid=' . $cid);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':attach', $attach, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();

        // Xóa file đính kèm cũ
        if ($attach != $row['attach'] and !empty($row['attach'])) {
            nv_deletefile(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['attach']);
        }
    }

    if ($count) {
        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('edit_title') . ': ' . $row['module'] . ', id: ' . $row['id'] . ', cid: ' . $row['cid'], $row['content'], $admin_info['userid']);

        if (isset($site_mods[$row['module']])) {
            $mod_info = $site_mods[$row['module']];
            if (file_exists(NV_ROOTDIR . '/modules/' . $mod_info['module_file'] . '/comment.php')) {
                include NV_ROOTDIR . '/modules/' . $mod_info['module_file'] . '/comment.php';
                $nv_Cache->delMod($row['module']);
            }
        }
    }
    nv_jsonOutput(['status' => 'ok', 'mess' => $nv_Lang->getModule('update_success'), 'redirect' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name]);
}

if (empty($row) or !isset($site_mod_comm[$row['module']])) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

nv_status_notification(NV_LANG_DATA, $module_name, 'comment_queue', $cid);

if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}

$row['content'] = nv_htmlspecialchars(nv_editor_br2nl($row['content']));

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $row['content'] = nv_aleditor('content', '100%', '250px', $row['content']);
} else {
    $row['content'] = '<textarea style="width:100%;height:250px" name="content">' . $row['content'] . '</textarea>';
}

if (!empty($row['attach'])) {
    $row['attach'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['attach'];
}

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->setTemplateDir(get_module_tpl_dir('edit.tpl'));
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('OP', $op);
$tpl->assign('CID', $cid);
$tpl->assign('ROW', $row);
$tpl->assign('MODULE_UPLOAD', $module_upload);
$tpl->assign('DIR', $dir);
$tpl->assign('CHECKSS', $checkss);

$contents = $tpl->fetch('edit.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
