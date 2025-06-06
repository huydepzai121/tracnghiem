<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_PAGE')) {
    exit('Stop!!!');
}

$page_url = $base_url;

if ($page_config['viewtype'] == 2) {
    $canonicalUrl = getCanonicalUrl($page_url, true, true);

    $page_title = $module_info['site_title'];
    $key_words = $module_info['keywords'];
    $contents = '';
} elseif ($id) {
    // Xem theo bài viết
    $page_url .= '&amp;' . NV_OP_VARIABLE . '=' . $rowdetail['alias'] . $global_config['rewrite_exturl'];
    $canonicalUrl = getCanonicalUrl($page_url, true);

    $rowdetail['number_add_time'] = $rowdetail['add_time'];
    $rowdetail['number_edit_time'] = $rowdetail['edit_time'] ?: $rowdetail['add_time'];

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => $schema_types[$rowdetail['schema_type']] ?? 'Article',
        'description' => strip_tags($rowdetail['description']) ?: $rowdetail['title'],
    ];
    $is_webpage = $rowdetail['schema_type'] == 'webpage' ? true : false;
    if ($is_webpage) {
        $schema['name'] = $rowdetail['title'];
        $schema['inLanguage'] = NV_LANG_DATA;
        $schema['about'] = [
            '@type' => 'Thing',
            'name' => $rowdetail['schema_about'] ?: 'Organization',
        ];
        $schema['url'] = $canonicalUrl;
    } else {
        $schema['headline'] = $rowdetail['title'];
        $schema['mainEntityOfPage'] = $canonicalUrl;
        $schema['datePublished'] = date('c', $rowdetail['number_add_time']);
        $schema['dateModified'] = date('c', $rowdetail['number_edit_time']);
    }

    if (!empty($rowdetail['image'])) {
        if (!nv_is_url($rowdetail['image'])) {
            $imagesize = @getimagesize(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $rowdetail['image']);
            $meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rowdetail['image'];
            $meta_property['og:image:url'] = $meta_property['og:image'];
            $meta_property['og:image:type'] = $imagesize['mime'];
            $meta_property['og:image:width'] = $imagesize[0];
            $meta_property['og:image:height'] = $imagesize[1];
            $meta_property['og:image:alt'] = !empty($rowdetail['imagealt']) ? $rowdetail['imagealt'] : $rowdetail['title'];
            !$is_webpage && $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => $meta_property['og:image']
            ];

            $srcset = '';
            if (file_exists(NV_ROOTDIR . '/' . NV_MOBILE_FILES_DIR . '/' . $module_upload . '/' . $rowdetail['image'])) {
                $srcset = NV_BASE_SITEURL . NV_MOBILE_FILES_DIR . '/' . $module_upload . '/' . $rowdetail['image'] . ' ' . NV_MOBILE_MODE_IMG . 'w, ';
                $srcset .= NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rowdetail['image'] . ' ' . $imagesize[0] . 'w';
            }

            $rowdetail['thumb'] = [
                'src' => file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $rowdetail['image']) ? NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $rowdetail['image'] : NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rowdetail['image'],
                'width' => 100
            ];
            $rowdetail['img'] = [
                'src' => NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rowdetail['image'],
                'srcset' => $srcset,
                'width' => $imagesize[0] > 500 ? 500 : $imagesize[0]
            ];
        } else {
            $rowdetail['thumb'] = [
                'src' => $rowdetail['image'],
                'width' => 100
            ];
            $rowdetail['img'] = [
                'src' => $rowdetail['image'],
                'srcset' => '',
                'width' => 500
            ];
            !$is_webpage && $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => $rowdetail['image']
            ];
        }
    }

    $schema_org = [
        '@type' => 'Organization',
        'name' => $global_config['site_name'],
        'url' => NV_MY_DOMAIN,
    ];
    if (!empty($global_config['site_logo'])) {
        $schema_org['logo'] = [
            '@type' => 'ImageObject',
            'url' => NV_MY_DOMAIN . NV_BASE_SITEURL . $global_config['site_logo']
        ];
    }

    $rowdetail['schema_type'] != 'BlogPosting' && $schema['publisher'] = $schema_org;
    !$is_webpage && $schema['author'] = $schema_org;

    $rowdetail['add_time'] = nv_datetime_format($rowdetail['add_time'], 1, 0);
    $rowdetail['edit_time'] = nv_datetime_format($rowdetail['edit_time'], 1, 0);
    $rowdetail['link'] = $canonicalUrl;

    $module_info['layout_funcs'][$op_file] = !empty($rowdetail['layout_func']) ? $rowdetail['layout_func'] : $module_info['layout_funcs'][$op_file];

    if (!empty($rowdetail['keywords'])) {
        $key_words = $rowdetail['keywords'];
    } else {
        $key_words = nv_get_keywords($rowdetail['bodytext']);

        if (empty($key_words)) {
            $key_words = nv_unhtmlspecialchars($rowdetail['title']);
            $key_words = strip_punctuation($key_words);
            $key_words = trim($key_words);
            $key_words = nv_strtolower($key_words);
            $key_words = preg_replace('/[ ]+/', ',', $key_words);
        }
    }

    $page_title = $rowdetail['title'];
    $description = $rowdetail['description'];

    // Hiển thị các bài liên quan mới nhất.
    $other_links = [];

    $related_articles = (int) ($page_config['related_articles']);
    if ($related_articles) {
        $db_slave->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data)
            ->where('status=1 AND id !=' . $id)
            ->order('weight ASC')
            ->limit($related_articles);
        $result = $db_slave->query($db_slave->sql());
        while ($_other = $result->fetch()) {
            $_other['link'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=' . $_other['alias'] . $global_config['rewrite_exturl'];
            $other_links[$_other['id']] = $_other;
        }
    }

    // Bình luận
    if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm'])) {
        define('NV_COMM_ID', $id); //ID bài viết
        define('NV_COMM_AREA', $module_info['funcs'][$op]['func_id']);
        //check allow comemnt
        $allowed = $module_config[$module_name]['allowed_comm']; //tuy vào module để lấy cấu hình. Nếu là module news thì có cấu hình theo bài viết
        if ($allowed == '-1') {
            $allowed = $rowdetail['activecomm'];
        }
        require_once NV_ROOTDIR . '/modules/comment/comment.php';
        $area = (defined('NV_COMM_AREA')) ? NV_COMM_AREA : 0;
        $checkss = md5($module_name . '-' . $area . '-' . NV_COMM_ID . '-' . $allowed . '-' . NV_CACHE_PREFIX);

        $content_comment = nv_comment_module($module_name, $checkss, $area, NV_COMM_ID, $allowed, 1);
    } else {
        $content_comment = '';
    }
    $time_set = $nv_Request->get_int($module_data . '_' . $op . '_' . $id, 'session');
    if (empty($time_set)) {
        $nv_Request->set_Session($module_data . '_' . $op . '_' . $id, NV_CURRENTTIME);
        $query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET hitstotal=hitstotal+1 WHERE id=' . $id;
        $db->query($query);
    }
    [$rowdetail, $other_links, $content_comment] = nv_apply_hook($module_name, 'before_detail_theme', [$rowdetail, $other_links, $content_comment], [$rowdetail, $other_links, $content_comment]);
    $nv_schemas[] = $schema;

    $contents = nv_page_main($rowdetail, $other_links, $content_comment);
} else {
    // Xem theo danh sách
    if ($page > 1) {
        $page_url .= '&amp;' . NV_OP_VARIABLE . '=page-' . $page;
    }

    $canonicalUrl = getCanonicalUrl($page_url, true, true);

    $page_title = $module_info['site_title'];
    $key_words = $module_info['keywords'];
    $per_page = $page_config['per_page'];

    $array_data = [];
    $db_slave->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data)
        ->where('status=1');
    $num_items = $db_slave->query($db_slave->sql())
        ->fetchColumn();

    // Không cho tùy ý đánh số page + xác định trang trước, trang sau
    betweenURLs($page, ceil($num_items / $per_page), $base_url, '/page-', $prevPage, $nextPage);

    $db_slave->select('*')
        ->order('weight')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);

    $result = $db_slave->query($db_slave->sql());
    while ($row = $result->fetch()) {
        empty($row['description']) && $row['description'] = strip_tags(trim($row['bodytext']));
        $row['description'] = nv_clean60($row['description'], 300);
        $row['link'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'] . $global_config['rewrite_exturl'];
        $array_data[$row['id']] = $row;
    }

    $generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);

    if ($page > 1) {
        $page_title .= NV_TITLEBAR_DEFIS . $nv_Lang->getGlobal('page') . ' ' . $page;
    }

    $contents = nv_page_main_list($array_data, $generate_page);
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
