<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_WEBTOOLS')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('get_update');
$set_active_op = 'checkupdate';

$version = trim($nv_Request->get_title('version', 'get', ''));
$package = $nv_Request->get_int('package', 'get', 0);

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->setTemplateDir(get_module_tpl_dir('getupdate.tpl'));
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('OP', $op);

// Bước giải nén
if ($nv_Request->get_title('checksess', 'get', '') == md5('unzip' . $version . $package . NV_CHECK_SESSION)) {
    $filename = NV_TEMPNAM_PREFIX . 'sysupd_' . NV_CHECK_SESSION . '.zip';
    if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename)) {
        $zip = new PclZip(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename);
        $ziplistContent = $zip->listContent();

        $temp_extract_dir = NV_TEMP_DIR . '/' . md5($filename . NV_CHECK_SESSION);

        $no_extract = [];
        $error_create_folder = [];
        $error_move_folder = [];

        if (is_dir(NV_ROOTDIR . '/' . $temp_extract_dir)) {
            nv_deletefile(NV_ROOTDIR . '/' . $temp_extract_dir, true);
        }

        $ftp_check_login = 0;

        if ($sys_info['ftp_support'] and (int) ($global_config['ftp_check_login']) == 1) {
            $ftp_server = nv_unhtmlspecialchars($global_config['ftp_server']);
            $ftp_port = (int) ($global_config['ftp_port']);
            $ftp_user_name = nv_unhtmlspecialchars($global_config['ftp_user_name']);
            $ftp_user_pass = nv_unhtmlspecialchars($global_config['ftp_user_pass']);
            $ftp_path = nv_unhtmlspecialchars($global_config['ftp_path']);
            // set up basic connection
            $conn_id = ftp_connect($ftp_server, $ftp_port, 10);
            // login with username and password
            $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

            if ((!$conn_id) or (!$login_result)) {
                $ftp_check_login = 3;
            } elseif (ftp_chdir($conn_id, $ftp_path)) {
                $ftp_check_login = 1;
            } else {
                $ftp_check_login = 2;
            }
        }

        if ($ftp_check_login == 1) {
            ftp_mkdir($conn_id, $temp_extract_dir);

            if (substr($sys_info['os'], 0, 3) != 'WIN') {
                ftp_chmod($conn_id, 0777, $temp_extract_dir);
            }

            foreach ($ziplistContent as $array_file) {
                if (!empty($array_file['folder']) and !file_exists(NV_ROOTDIR . '/' . $temp_extract_dir . '/' . $array_file['filename'])) {
                    $cp = '';
                    $e = explode('/', $array_file['filename']);

                    foreach ($e as $p) {
                        if (!empty($p) and !is_dir(NV_ROOTDIR . '/' . $temp_extract_dir . '/' . $cp . $p)) {
                            ftp_mkdir($conn_id, $temp_extract_dir . '/' . $cp . $p);
                            if (substr($sys_info['os'], 0, 3) != 'WIN') {
                                ftp_chmod($conn_id, 0777, $temp_extract_dir . '/' . $cp . $p);
                            }
                        }

                        $cp .= $p . '/';
                    }
                }
            }
        }

        $extract = $zip->extract(PCLZIP_OPT_PATH, NV_ROOTDIR . '/' . $temp_extract_dir);

        foreach ($extract as $extract_i) {
            $filename_i = str_replace(NV_ROOTDIR, '', str_replace('\\', '/', $extract_i['filename']));

            if ($extract_i['status'] != 'ok' and $extract_i['status'] != 'already_a_directory') {
                $no_extract[] = $filename_i;
            }
        }

        if (empty($no_extract)) {
            foreach ($ziplistContent as $array_file) {
                $dir_name = '';

                if (!empty($array_file['folder']) and !file_exists(NV_ROOTDIR . '/' . $array_file['filename'])) {
                    $dir_name = $array_file['filename'];
                } elseif (!file_exists(NV_ROOTDIR . '/' . dirname($array_file['filename']))) {
                    $dir_name = dirname($array_file['filename']);
                }

                if (!empty($dir_name)) {
                    $cp = '';
                    $e = explode('/', $dir_name);

                    foreach ($e as $p) {
                        if (!empty($p) and !is_dir(NV_ROOTDIR . '/' . $cp . $p)) {
                            if (!($ftp_check_login == 1 and ftp_mkdir($conn_id, $cp . $p))) {
                                @mkdir(NV_ROOTDIR . '/' . $cp . $p);
                            }
                            if (!is_dir(NV_ROOTDIR . '/' . $cp . $p)) {
                                $error_create_folder[] = $cp . $p;
                                break;
                            }
                        }

                        $cp .= $p . '/';
                    }
                }
            }

            $error_create_folder = array_unique($error_create_folder);

            if (empty($error_create_folder)) {
                foreach ($ziplistContent as $array_file) {
                    if (empty($array_file['folder'])) {
                        if (file_exists(NV_ROOTDIR . '/' . $array_file['filename'])) {
                            if (!($ftp_check_login == 1 and ftp_delete($conn_id, $array_file['filename']))) {
                                nv_deletefile(NV_ROOTDIR . '/' . $array_file['filename']);
                            }
                        }

                        if (!($ftp_check_login == 1 and ftp_rename($conn_id, $temp_extract_dir . '/' . $array_file['filename'], $array_file['filename']))) {
                            @rename(NV_ROOTDIR . '/' . $temp_extract_dir . '/' . $array_file['filename'], NV_ROOTDIR . '/' . $array_file['filename']);
                        }

                        if (file_exists(NV_ROOTDIR . '/' . $temp_extract_dir . '/' . $array_file['filename'])) {
                            $error_move_folder[] = $array_file['filename'];
                        }
                    }
                }

                if (empty($error_move_folder)) {
                    nv_deletefile($filename);
                    nv_deletefile(NV_ROOTDIR . '/' . $temp_extract_dir, true);
                }
            }

            if ($ftp_check_login > 0) {
                ftp_close($conn_id);
            }
        }

        $tpl->assign('NO_EXTRACT', $no_extract);
        $tpl->assign('ERROR_CREATE_FOLDER', $error_create_folder);
        $tpl->assign('ERROR_MOVE_FOLDER', $error_move_folder);

        $contents = $tpl->fetch('getupdate-unzip.tpl');

        include NV_ROOTDIR . '/includes/header.php';
        echo $contents;
        include NV_ROOTDIR . '/includes/footer.php';
    }

    nv_htmlOutput('Unknow error!');
}

// Bước tải gói ứng dụng
if ($nv_Request->get_title('checksess', 'get', '') == md5('download' . $version . $package . NV_CHECK_SESSION)) {
    $NV_Http = new NukeViet\Http\Http($global_config, NV_TEMP_DIR);
    $filename = NV_TEMPNAM_PREFIX . 'sysupd_' . NV_CHECK_SESSION . '.zip';
    $args = [
        'headers' => [
            'Referer' => NUKEVIET_STORE_APIURL,
        ],
        'stream' => true,
        'filename' => NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename,
        'body' => [
            'lang' => NV_LANG_INTERFACE,
            'basever' => $global_config['version'],
            'mode' => 'getsysupd',
            'version' => $version,
            'package' => $package
        ],
        'timeout' => 300
    ];

    // Delete temp file if exists
    if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename)) {
        @nv_deletefile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename);
    }

    $apidata = $NV_Http->post(NUKEVIET_STORE_APIURL, $args);

    if (!empty(NukeViet\Http\Http::$error)) {
        $error = nv_http_get_lang(NukeViet\Http\Http::$error);
    } elseif (empty($apidata['filename']) or !file_exists($apidata['filename'])) {
        $error = $nv_Lang->getModule('get_update_error_file_download');
    }

    if (!empty($error)) {
        $html = nv_theme_alert($page_title, $error, 'danger');
        nv_htmlOutput($html);
    }

    $zip = new PclZip(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename);
    $ziplistContent = $zip->listContent();

    // Not exists (can not download)
    $warning = 2;
    if (!empty($ziplistContent)) {
        // Package ok
        $warning = 0;
        foreach ($ziplistContent as $zipContent) {
            if (!preg_match("/^install\//is", $zipContent['filename'])) {
                // Package invald
                $warning = 1;
            }
        }
    }

    if ($warning == 1) {
        $html = nv_theme_alert($page_title, $nv_Lang->getModule('get_update_warning', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=webtools&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;version=' . $version . '&amp;package=' . $package . '&amp;checksess=' . md5('unzip' . $version . $package . NV_CHECK_SESSION)), 'warning');
        nv_htmlOutput($html);
    }

    if ($warning == 2) {
        $error = $nv_Lang->getModule('get_update_error_file_download');
        $new_version = nv_geVersion(NV_CURRENTTIME);
        if ($new_version !== false and !is_string($new_version)) {
            $manual_link = (string) $new_version->link;
            if (!empty($manual_link)) {
                $error .= ' ' . $nv_Lang->getModule('get_update_error_file_download1', $manual_link);
            }
        }

        $html = nv_theme_alert($page_title, $error, 'danger');
        nv_htmlOutput($html);
    }

    $html = nv_theme_alert($page_title, $nv_Lang->getModule('get_update_ok', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=webtools&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;version=' . $version . '&amp;package=' . $package . '&amp;checksess=' . md5('unzip' . $version . $package . NV_CHECK_SESSION)), 'success');
    nv_htmlOutput($html);
}

// Bước hiển thị trang để ajax các thao tác tiếp theo
if ($nv_Request->get_title('checksess', 'get', '') == md5($version . $package . NV_CHECK_SESSION)) {
    $tpl->assign('VERSION', $version);
    $tpl->assign('PACKAGE', $package);
    $tpl->assign('CHECKSESS', md5('download' . $version . $package . NV_CHECK_SESSION));

    $contents = $tpl->fetch('getupdate.tpl');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

nv_error404();
