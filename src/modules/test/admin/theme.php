<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */
if (!defined('NV_IS_MOD_TEST')) {
    die('Stop!!!');
}

/**
 * nv_theme_test_main()
 *
 * @param mixed $indexfile
 * @param mixed $array_data
 * @param mixed $page
 * @return
 *
 */
function nv_theme_test_main($indexfile, $array_data, $page)
{
    global $module_file, $lang_module, $module_info, $op;
    
    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    
    if ($indexfile == 1) {
        $xtpl->assign('DATA', nv_theme_test_main_viewlist($array_data));
        if (!empty($page)) {
            $xtpl->assign('PAGE', $page);
            $xtpl->parse('main.page');
        }
    } elseif ($indexfile == 2 or $indexfile == 3 or $indexfile == 4 or $indexfile == 5) {
        $xtpl->assign('DATA', nv_theme_test_viewhome_cat($array_data, $indexfile));
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_test_viewlist()
 *
 * @param mixed $array_data
 * @return
 *
 */
function nv_theme_test_main_viewlist($array_data)
{
    global $module_file, $lang_module, $module_info, $client_info, $module_config, $array_test_cat, $module_name;
    
    $xtpl = new XTemplate('main_viewlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);
    
    if (!empty($array_data)) {
        foreach ($array_data as $data) {
            $xtpl->assign('DATA', $data);

            $array_cat_title = array();
            $parentid_i = !empty($array_test_cat[$data['catid']]) ? $array_test_cat[$data['catid']]['id'] : 0;

            while ($parentid_i > 0 && !empty($array_test_cat[$parentid_i])) {
                $array_cat_title[] = $array_test_cat[$parentid_i];
                $parentid_i = $array_test_cat[$parentid_i]['parentid'];
            }
            if ($parentid_i > 0) continue;

            if (!empty($array_cat_title)) {
                $i = 0;
                krsort($array_cat_title, SORT_NUMERIC);
                foreach ($array_cat_title as $cat) {
                    $xtpl->assign('CAT', $cat);

                    if ($i < count($array_cat_title) - 1) {
                        $xtpl->parse('main.loop.cat.anchor');
                    }

                    $xtpl->parse('main.loop.cat');
                    $i++;
                }
            }

            if (defined('NV_IS_ADMIN')) {
                $xtpl->assign('ADMIN', nv_admin_content($data['id'], nv_redirect_encrypt($client_info['selfurl'])));
                $xtpl->parse('main.loop.admin');
            }

            if (!empty($data['image'])) {
                $xtpl->parse('main.loop.image');
            }

            if (!empty($data['hometext'])) {
                $xtpl->parse('main.loop.hometext');
            }

            if ($data['newday'] >= NV_CURRENTTIME || $data['type'] == 1) {
                $xtpl->parse('main.loop.newday');
            }

            $xtpl->parse('main.loop');
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_test_viewlist()
 *
 * @param mixed $array_data
 * @return
 *
 */
function nv_theme_test_viewlist($array_data)
{
    global $module_file, $lang_module, $module_info, $client_info, $array_test_cat, $module_config, $module_name;

    $xtpl = new XTemplate('viewlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);

    if (!empty($array_data)) {
        foreach ($array_data as $data) {
            $xtpl->assign('DATA', $data);

            $array_cat_title = array();
            $parentid_i = $array_test_cat[$data['catid']]['id'];
            while ($parentid_i > 0) {
                $array_cat_title[] = $array_test_cat[$parentid_i];
                $parentid_i = $array_test_cat[$parentid_i]['parentid'];
            }

            if (!empty($array_cat_title)) {
                $i = 0;
                krsort($array_cat_title, SORT_NUMERIC);
                foreach ($array_cat_title as $cat) {
                    $xtpl->assign('CAT', $cat);

                    if ($i < count($array_cat_title) - 1) {
                        $xtpl->parse('main.loop.cat.anchor');
                    }

                    $xtpl->parse('main.loop.cat');
                    $i++;
                }
            }

            if (defined('NV_IS_ADMIN')) {
                $xtpl->assign('ADMIN', nv_admin_content($data['id'], nv_redirect_encrypt($client_info['selfurl'])));
                $xtpl->parse('main.loop.admin');
            }

            if (!empty($data['image'])) {
                $xtpl->parse('main.loop.image');
            }

            if (!empty($data['hometext'])) {
                $xtpl->parse('main.loop.hometext');
            }

            if ($data['newday'] >= NV_CURRENTTIME || $data['type'] == 1) {
                $xtpl->parse('main.loop.newday');
            }

            $xtpl->parse('main.loop');
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_test_viewhome_cat()
 *
 * @param mixed $array_data
 * @param mixed $indexfile
 * @return
 *
 */
function nv_theme_test_viewhome_cat($array_data, $indexfile)
{
    global $module_name, $module_file, $lang_module, $module_info, $array_config, $module_data, $db, $module_config;

    $xtpl = new XTemplate('viewhome_cat.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('IMGWIDTH1', $module_config[$module_name]['homewidth']);

    if (!empty($array_data)) {
        foreach ($array_data as $cat) {
            if ($indexfile == 2 or $indexfile == 3 or $indexfile == 4) {
                $array_cattitle = array();
                $_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE status=1 AND parentid=' . $cat['id'] . ' ORDER BY weight DESC';
                $_query = $db->query($_sql);
                while ($_row = $_query->fetch()) {
                    $array_cattitle[$_row['id']] = $_row;
                }
                $xtpl->assign('BUTTON_ID', $cat['id']);
                if (!empty($array_cattitle)) {
                    $xtpl->parse('main.indexfile_' . $indexfile . '.cat.link_pullright.button_drop');
                }

                foreach ($array_cattitle as $cat_panel) {
                    $cat_panel['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $cat_panel['alias'];
                    $xtpl->assign('DATA_PANEL', $cat_panel);
                    $xtpl->parse('main.indexfile_' . $indexfile . '.cat.link_pullright.loop');
                    $xtpl->parse('main.indexfile_' . $indexfile . '.cat.link_pullright.loop_mobile');
                }
                $xtpl->parse('main.indexfile_' . $indexfile . '.cat.link_pullright');

                $xtpl->assign('CAT', $cat);

                if ($module_info['rss']) {
                    $xtpl->parse('main.indexfile_' . $indexfile . '.cat.rss');
                }

                if (!empty($cat['data'])) {
                    $i = 0;
                    if ($indexfile == 2 or $indexfile == 3 or $indexfile == 4) {
                        foreach ($cat['data'] as $data) {
                            ++$i;
                            $xtpl->assign('DATA', $data);
                            if ($i == 1) {
                                if (!empty($data['image'])) {
                                    $xtpl->parse('main.indexfile_' . $indexfile . '.cat.first.image');
                                }

                                if (!empty($data['hometext'])) {
                                    $xtpl->parse('main.indexfile_' . $indexfile . '.cat.first.hometext');
                                }

                                if ($data['newday'] >= NV_CURRENTTIME || $data['type'] == 1) {
                                    $xtpl->parse('main.indexfile_' . $indexfile . '.cat.first.newday');
                                }

                                $xtpl->parse('main.indexfile_' . $indexfile . '.cat.first');
                            } else {
                                if ($data['newday'] >= NV_CURRENTTIME || $data['type'] == 1) {
                                    $xtpl->parse('main.indexfile_' . $indexfile . '.cat.related.loop.newday');
                                }
                                $xtpl->parse('main.indexfile_' . $indexfile . '.cat.related.loop');
                            }

                            if ($i == $array_config['st_links'] + 1) {
                                break;
                            }
                        }

                        if ($i > 1) {
                            $xtpl->parse('main.indexfile_' . $indexfile . '.cat.related');
                        }
                    }
                }
                $xtpl->parse('main.indexfile_' . $indexfile . '.cat');
            } elseif ($indexfile == 5) {
                if (empty($cat['parentid'])) {
                    $xtpl->assign('CAT', $cat);
                    $array_subcat = nv_GetCatidInParent($cat['id'], false);
                    if (!empty($array_subcat)) {
                        foreach ($array_subcat as $catid) {
                            $cat = $array_data[$catid];
                            $xtpl->assign('SUBCAT', $cat);
                            if (!empty($cat['image'])) {
                                $xtpl->parse('main.indexfile_' . $indexfile . '.cat.subcat.image');
                            }
                            $xtpl->parse('main.indexfile_' . $indexfile . '.cat.subcat');
                        }
                    }
                    if ($module_info['rss']) {
                        $xtpl->parse('main.indexfile_' . $indexfile . '.cat.rss');
                    }
                    $xtpl->parse('main.indexfile_' . $indexfile . '.cat');
                }
            }
        }
        $xtpl->parse('main.indexfile_' . $indexfile);
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_test_detail()
 *
 * @param mixed $exam_info
 * @param mixed $array_data
 * @param mixed $array_saved_data
 * @param mixed $base_url
 * @param mixed $content_comment
 * @param mixed $array_keyword
 * @param mixed $related_new_array
 * @param mixed $related_array
 * @param mixed $topic_array
 * @return
 *
 */
function nv_theme_test_detail($exam_info, $array_data, $array_saved_data, $tester_answer, $base_url, $content_comment, $array_keyword, $array_other, $related_new_array, $related_array, $topic_array, $array_listcat_menu, $examinations_subject)
{
    global $module_name, $module_file, $lang_module, $module_info, $op, $array_config, $client_info, $array_test_cat;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('DATA', $exam_info);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('SELFURL', $client_info['selfurl']);
    $xtpl->assign('TEMPLATE', $module_info['template']);
    $xtpl->assign('PRINT_URL', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['print'] . '/' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'], true));

    if (!empty($array_listcat_menu)) {
        $xtpl->assign('CAT_PARENT', $exam_info['parentid']);
        foreach ($array_listcat_menu as $value) {
            $xtpl->assign('LISTCAT', $value);
            $xtpl->parse('main.listcat_menu.loop');
        }
        $xtpl->parse('main.listcat_menu');
    }

    if (!empty($array_saved_data) && !empty($array_saved_data['begintime'])) {
        $xtpl->assign('TESTING', nv_theme_test_testing(0, $exam_info, $array_data, $array_saved_data, $tester_answer, $base_url, 1, 0, 0));

        if ($exam_info['isdone']) {
            if ($exam_info['print'] and $exam_info['history_save']) {
                $xtpl->parse('main.print');
            }
            $xtpl->parse('main.time_test');
        } else {
            $time_left = $array_saved_data['duetime'] - NV_CURRENTTIME;
            $time_danger = ($exam_info['timer'] / 10) * 60; //khi còn $time_danger giây sẽ cảnh báo 
            $xtpl->assign('TIMER', $time_left);
            $xtpl->assign('TIMER_DANGER', ($time_left - $time_danger) * 1000); //n giây trước khi hết giờ
            $xtpl->parse('main.countdown');
            if (empty($exam_info['type'])) {
                $xtpl->parse('main.btn_exam_save_bottom.btn_exit_test');
            }
            $xtpl->parse('main.btn_exam_save_bottom');
            $xtpl->parse('main.button_resize_font');
            //$xtpl->parse('main.alert_close_browser');
        }
        $xtpl->parse('main.nondiv');
        $xtpl->parse('main.nondiv2');
    } else {
        $xtpl->parse('main.div');
        $xtpl->parse('main.div2');

        if (!empty($exam_info['price'])) {
            $xtpl->parse('main.price');
        }

        if ($exam_info['type'] == 0) {
            if (!$exam_info['isdone'] && (!$exam_info['isdone'] && $exam_info['preview_question_test'])) {
                $xtpl->assign('TESTING', nv_theme_test_testing(0, $exam_info, $array_data, $array_saved_data, $tester_answer, $base_url, 0, 0, 0));
            }
            $xtpl->parse('main.save_test');
        } elseif ($exam_info['type'] == 1) {
            $xtpl->parse('main.btn_start.begintime');
        }

        if (defined('NV_IS_ADMIN')) {
            $xtpl->assign('ADMIN', nv_admin_content($exam_info['id'], nv_redirect_encrypt($client_info['selfurl'])));
            $xtpl->parse('main.admin');
        }

        if ($array_config['enable_social']) {
            if (!empty($array_config['oaid'])) {
                $xtpl->assign('OAID', $array_config['oaid']);
                $xtpl->parse('main.social.zalo_share_button');
            }
            $xtpl->parse('main.social');
        }

        if ($array_config['showhometext']) {
            $xtpl->parse('main.description.showhometext');
        }

        if ($exam_info['image_position'] == 1) {
            $xtpl->parse('main.description.imgposition_left');
        } elseif ($exam_info['image_position'] == 2) {
            $xtpl->parse('main.description.imgposition_bottom');
        }

        if (!empty($array_keyword)) {
            $t = sizeof($array_keyword) - 1;
            foreach ($array_keyword as $i => $value) {
                $xtpl->assign('KEYWORD', $value['keyword']);
                $xtpl->assign('LINK_KEYWORDS', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=tag/' . urlencode($value['alias']));
                $xtpl->assign('SLASH', ($t == $i) ? '' : ', ');
                $xtpl->parse('main.keywords.loop');
            }
            $xtpl->parse('main.keywords');
        }

        if ($exam_info['btn_start_disabled']) {
            $xtpl->parse('main.btn_start.btn_start_disabled');
        } elseif ((($exam_info['type'] == 1)  || !empty($examinations_subject)) && !empty($exam_info['code'])) {
            $xtpl->parse('main.btn_start.code');
            $xtpl->parse('main.btn_start.btn_start_disabled');
        }

        if (!empty($exam_info['alert_permission'])) {
            $xtpl->parse('main.btn_start.alert_permission');
        }
        if (!empty($examinations_subject)) {
            $xtpl->assign('exam_subject_id', $examinations_subject['id']);
            $xtpl->parse('main.btn_start.exam_subject_id');
        }
        if (!empty($exam_info['alert_payment'])) {
            $xtpl->parse('main.btn_start.alert_payment');
        }

        if (!empty($exam_info['test_limit_note'])) {
            $xtpl->parse('main.btn_start.test_limit_note');
        }

        if (!empty($exam_info['help_content'])) {
            $xtpl->parse('main.help_content');
        }

        if (!empty($exam_info['source'])) {
            $xtpl->parse('main.source');
        }

        $xtpl->parse('main.btn_start');
        $xtpl->parse('main.description');
    }

    if (!empty($related_new_array) or !empty($related_array) or !empty($topic_array) or !empty($array_other)) {
        if (!empty($related_new_array)) {
            foreach ($related_new_array as $key => $related_new_array_i) {
                $xtpl->assign('RELATED_NEW', $related_new_array_i);
                if ($related_new_array_i['newday'] >= NV_CURRENTTIME) {
                    $xtpl->parse('main.others.related_new.loop.newday');
                }
                $xtpl->parse('main.others.related_new.loop');
            }
            unset($key);
            $xtpl->parse('main.others.related_new');
        }

        if (!empty($related_array)) {
            foreach ($related_array as $related_array_i) {
                $xtpl->assign('RELATED', $related_array_i);
                if ($related_array_i['newday'] >= NV_CURRENTTIME) {
                    $xtpl->parse('main.others.related.loop.newday');
                }
                $xtpl->parse('main.others.related.loop');
            }
            $xtpl->parse('main.others.related');
        }

        if (!empty($topic_array)) {
            foreach ($topic_array as $key => $topic_array_i) {
                $xtpl->assign('TOPIC', $topic_array_i);
                if ($topic_array_i['newday'] >= NV_CURRENTTIME) {
                    $xtpl->parse('main.others.topic.loop.newday');
                }
                $xtpl->parse('main.others.topic.loop');
            }
            $xtpl->parse('main.others.topic');
        }

        if (!empty($array_other)) {
            foreach ($array_other as $key => $other_array_i) {
                $xtpl->assign('OTHER', $other_array_i);
                if ($other_array_i['newday'] >= NV_CURRENTTIME) {
                    $xtpl->parse('main.others.other.loop.newday');
                }
                $xtpl->parse('main.others.other.loop');
            }
            $xtpl->parse('main.others.other');
        }

        $xtpl->parse('main.others');
    }

    if (!empty($content_comment)) {
        $xtpl->assign('COMMENT', $content_comment);
        $xtpl->parse('main.comment');
    }

    if ($exam_info['alert']) {
        $xtpl->parse('main.alert');
    }

    if ($exam_info['block_copy_paste']) {
        $xtpl->parse('main.block_copy_paste');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_test_topic()
 *
 * @param mixed $topic_info
 * @param mixed $array_data
 * @param mixed $page
 * @return
 *
 */
function nv_theme_test_topic($topic_info, $array_data, $page)
{
    global $global_config, $module_data, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_config, $userid;

    $xtpl = new XTemplate('topic.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('TOPIC', $topic_info);
    $xtpl->assign('DATA', nv_theme_test_viewlist($array_data));

    if (!empty($page)) {
        $xtpl->assign('PAGE', $page);
        $xtpl->parse('main.page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_test_viewcat()
 *
 * @param mixed $topic_info
 * @param mixed $array_data
 * @param mixed $page
 * @return
 *
 */
function nv_theme_test_viewcat($cat_info, $array_data, $page)
{
    global $global_config, $module_data, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_config, $userid, $array_top_score, $array_test_cat;

    $xtpl = new XTemplate('viewcat.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('CAT', $cat_info);
    $xtpl->assign('DATA', nv_theme_test_viewlist($array_data));

    $list_cat_info = explode(",", $cat_info['subid']);
    if (!empty($cat_info['subid'])) {
        foreach ($list_cat_info as $value) {
            $xtpl->assign('LISTCAT', $array_test_cat[$value]);
            $xtpl->parse('main.empty.listcat');
        }
        $xtpl->parse('main.empty');
    }

    if (!empty($cat_info['description_html'])) {
        $xtpl->parse('main.description_html');
    }

    if (!empty($array_top_score)) {
        foreach ($array_top_score as $topscore) {
            $topscore['begin_time'] = nv_date('H:i d/m/Y', $topscore['begin_time']);
            $xtpl->assign('TOPSCORE', $topscore);
            $xtpl->parse('main.topscore.loop');
        }
        $xtpl->parse('main.topscore');
    }

    if (!empty($page)) {
        $xtpl->assign('PAGE', $page);
        $xtpl->parse('main.page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function nv_admin_content($examid, $redirect = '')
{
    global $lang_module, $module_name, $client_info;

    $html = '<em class="fa fa-edit">&nbsp;</em><a href="' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams-content&amp;id=' . $examid . '&amp;redirect=' . $redirect . '">' . $nv_Lang->getModule('edit') . '</a> - ';
    $html .= '<em class="fa fa-trash-o">&nbsp;</em><a onclick="return confirm(\'' . $nv_Lang->getModule('delete_confirm') . '\');" href="' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams&amp;delete_id=' . $examid . '&amp;delete_checkss=' . md5($examid . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;redirect=' . $redirect . '">' . $nv_Lang->getModule('delete') . '</a>';

    return $html;
}

/**
 * nv_theme_test_detail()
 *
 * @param mixed $exam_info
 * @param mixed $array_data
 * @param mixed $array_saved_data
 * @param mixed $base_url
 * @param mixed $content_comment
 * @param mixed $array_keyword
 * @param mixed $related_new_array
 * @param mixed $related_array
 * @param mixed $topic_array
 * @return
 *
 */
function nv_theme_test_detail2($exam_info, $array_data, $array_saved_data, $tester_answer, $base_url, $content_comment, $array_keyword, $array_other, $related_new_array, $related_array, $topic_array, $array_listcat_menu, $examinations_subject)
{
    global $module_name, $module_file, $lang_module, $module_info, $op, $array_config, $client_info, $user_info, $array_test_cat, $array_field_config, $custom_fields;

    $xtpl = new XTemplate('detail2.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('DATA', $exam_info);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('SELFURL', $client_info['selfurl']);
    $xtpl->assign('TEMPLATE', $module_info['template']);
    $xtpl->assign('url_back_module', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true));
    $xtpl->assign('PRINT_URL', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['print'] . '/' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'], true));

    if (!empty($array_listcat_menu)) {
        $xtpl->assign('CAT_PARENT', $array_test_cat[$exam_info['parentid']]);
        foreach ($array_listcat_menu as $value) {
            $xtpl->assign('LISTCAT', $value);
            $xtpl->parse('main.listcat_menu.loop');
        }
        $xtpl->parse('main.listcat_menu');
    }

    if (defined('NV_IS_USER')) {
        $xtpl->assign('USER_INFO', $user_info);
        $array_fields = nv_test_custom_fileds_render($array_field_config, $custom_fields, 1);
        if (!empty($array_fields)) {
            foreach ($array_fields as $row) {
                if ($row['field'] == 'last_name' || $row['field'] == 'first_name') continue;
                $xtpl->assign('FIELD', $row);
                $xtpl->parse('main.user_info.loop');
            }
        }
        $xtpl->parse('main.user_info');
    }
    if (!empty($array_saved_data) && !empty($array_saved_data['begintime'])) {
        $xtpl->assign('TESTING', nv_theme_test_testing_2($exam_info, $array_data, $array_saved_data, $tester_answer, $base_url));
        if ($exam_info['isdone']) {
            $xtpl->assign('URL_SHARE', $exam_info['url_share']);
            if ($exam_info['print'] and $exam_info['history_save']) {
                $xtpl->parse('main.time_test.print');
            }
            $xtpl->parse('main.time_test');
        } else {
            $time_left = $array_saved_data['duetime'] - NV_CURRENTTIME;
            $time_danger = ($exam_info['timer'] / 10) * 60; //khi còn $time_danger giây sẽ cảnh báo 
            $xtpl->assign('TIMER', $time_left);
            $xtpl->assign('TIMER_DANGER', ($time_left - $time_danger) * 1000); //n giây trước khi hết giờ
            $xtpl->parse('main.countdown');
            if (empty($exam_info['type'])) {
                $xtpl->parse('main.button_test.btn_exit_test');
            }
            $xtpl->parse('main.button_test');
            $xtpl->parse('main.button_resize_font');
        }
    } else {
        if ($exam_info['type'] == 0) {
            if (!$exam_info['isdone'] && (!$exam_info['isdone'] && $exam_info['preview_question_test'])) {
                $xtpl->assign('TESTING', nv_theme_test_testing_2($exam_info, $array_data, $array_saved_data, $tester_answer, $base_url, 0));
            }
            $xtpl->parse('main.save_test');
        } elseif ($exam_info['type'] == 1) {
            $xtpl->parse('main.btn_start.begintime');
        }

        if (defined('NV_IS_ADMIN')) {
            $xtpl->assign('ADMIN', nv_admin_content($exam_info['id'], nv_redirect_encrypt($client_info['selfurl'])));
            $xtpl->parse('main.admin');
        }

        if (!empty($array_keyword)) {
            $t = sizeof($array_keyword) - 1;
            foreach ($array_keyword as $i => $value) {
                $xtpl->assign('KEYWORD', $value['keyword']);
                $xtpl->assign('LINK_KEYWORDS', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=tag/' . urlencode($value['alias']));
                $xtpl->assign('SLASH', ($t == $i) ? '' : ', ');
                $xtpl->parse('main.keywords.loop');
            }
            $xtpl->parse('main.keywords');
        }
        if ($exam_info['btn_start_disabled']) {
            $xtpl->parse('main.btn_start.btn_start_disabled');
        } elseif ((($exam_info['type'] == 1)  || !empty($examinations_subject)) && !empty($exam_info['code'])) {
            $xtpl->parse('main.btn_start.code');
            $xtpl->parse('main.btn_start.btn_start_disabled');
        }

        if (!empty($examinations_subject)) {
            $xtpl->assign('exam_subject_id', $examinations_subject['id']);
            $xtpl->parse('main.btn_start.exam_subject_id');
        }

        if (!empty($exam_info['alert_permission'])) {
            $xtpl->parse('main.btn_start.alert_permission');
        }

        if (!empty($exam_info['alert_payment'])) {
            $xtpl->parse('main.btn_start.alert_payment');
        }

        if (!empty($exam_info['test_limit_note'])) {
            $xtpl->parse('main.btn_start.test_limit_note');
        }

        if ($array_config['enable_social']) {
            if ($exam_info['type'] == 0) {
                $xtpl->assign('URL_SHARE', $client_info['selfurl']);
                if (!empty($array_config['oaid'])) {
                    $xtpl->assign('OAID', $array_config['oaid']);
                    $xtpl->parse('main.share_now.zalo_share_button');
                }
                $xtpl->parse('main.share_now');
            }
        }

        $xtpl->parse('main.btn_start');

        if (!empty($exam_info['description'])) {
            if ($array_config['showhometext']) {
                $xtpl->parse('main.description.hometext');
            }
            $xtpl->parse('main.description');
        }

        if (!empty($exam_info['help_content'])) {
            $xtpl->parse('main.help_content');
        }

        if (!empty($exam_info['source'])) {
            $xtpl->parse('main.source');
        }

        if (!empty($exam_info['price'])) {
            $xtpl->parse('main.price');
        }
    }

    if (empty($array_saved_data) or !empty($array_saved_data['endtime'])) {
        if (!empty($related_new_array) or !empty($related_array) or !empty($topic_array) or !empty($array_other)) {
            if (!empty($related_new_array)) {
                foreach ($related_new_array as $key => $related_new_array_i) {
                    $xtpl->assign('RELATED_NEW', $related_new_array_i);
                    if ($related_new_array_i['newday'] >= NV_CURRENTTIME) {
                        $xtpl->parse('main.others.related_new.loop.newday');
                    }
                    $xtpl->parse('main.others.related_new.loop');
                }
                unset($key);
                $xtpl->parse('main.others.related_new');
            }

            if (!empty($related_array)) {
                foreach ($related_array as $related_array_i) {
                    $xtpl->assign('RELATED', $related_array_i);
                    if ($related_array_i['newday'] >= NV_CURRENTTIME) {
                        $xtpl->parse('main.others.related.loop.newday');
                    }
                    $xtpl->parse('main.others.related.loop');
                }
                $xtpl->parse('main.others.related');
            }

            if (!empty($topic_array)) {
                foreach ($topic_array as $key => $topic_array_i) {
                    $xtpl->assign('TOPIC', $topic_array_i);
                    if ($topic_array_i['newday'] >= NV_CURRENTTIME) {
                        $xtpl->parse('main.others.topic.loop.newday');
                    }
                    $xtpl->parse('main.others.topic.loop');
                }
                $xtpl->parse('main.others.topic');
            }

            if (!empty($array_other)) {
                foreach ($array_other as $key => $other_array_i) {
                    $xtpl->assign('OTHER', $other_array_i);
                    if ($other_array_i['newday'] >= NV_CURRENTTIME) {
                        $xtpl->parse('main.others.other.loop.newday');
                    }
                    $xtpl->parse('main.others.other.loop');
                }
                $xtpl->parse('main.others.other');
            }

            $xtpl->parse('main.others');
        }
    }

    if (!empty($content_comment)) {
        $xtpl->assign('COMMENT', $content_comment);
        $xtpl->parse('main.comment');
    }

    if ($exam_info['alert']) {
        $xtpl->parse('main.alert');
    }

    if ($exam_info['block_copy_paste']) {
        $xtpl->parse('main.block_copy_paste');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_test_detail()
 *
 * @param mixed $exam_info
 * @param mixed $array_data
 * @param mixed $array_saved_data
 * @param mixed $base_url
 * @param mixed $content_comment
 * @param mixed $array_keyword
 * @param mixed $related_new_array
 * @param mixed $related_array
 * @param mixed $topic_array
 * @return
 *
 */
function nv_theme_test_testing_2($exam_info, $array_data, $array_saved_data, $tester_answer, $base_url, $istest = 1)
{
    global $module_name, $module_file, $lang_module, $module_info, $op, $array_question_type_4_option, $user_info;
    $xtpl = new XTemplate('test_gird.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('DATA', $exam_info);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('BASE_URL', $base_url);
    $xtpl->assign('TEMPLATE', $module_info['template']);
    if ($exam_info['isdone']) {
        $xtpl->assign('DISABLED', 'disabled="disabled"');
        if (!$exam_info['view_answer']) {
            $array_group = array();
            $array_groupid = nv_user_groups($exam_info['groups_result']);
            $array_groups_list = nv_test_groups_list();
            if (!empty($array_groupid)) {
                foreach ($array_groupid as $groupid) {
                    $array_group[] = $array_groups_list[$groupid];
                }
            }
            $xtpl->assign('RESULT_NOTE', sprintf($nv_Lang->getModule('groups_result_note'), implode(', ', $array_group)));
            $xtpl->assign('RESULT_NOTE', $nv_Lang->getModule('groups_result_note'));
            $xtpl->parse('main.groups_result_note');
        }
    }
    $isprint = 1;
    $editor_change_event_js = 0;
    $check_group_view = nv_user_in_groups($exam_info['groups_result']);
    if (!empty($array_data)) {
        $i = $z = 1;
        foreach ($array_data as $data) {
            $data['number'] = $i;
            $total_question = count($array_data);
            $xtpl->assign('total_question', $total_question);

            $data['title'] = preg_replace('/\xC2\xA0/', ' ', $data['title']); //xóa bỏ các ký tự &nbsp;

            $xtpl->assign('QUESTION', $data);

            //in danh sach cau hoi
            $xtpl->parse('main.questionlist.list_question_number');
            if (($istest && $exam_info['type'] == 0 || $exam_info['type'] == 1 && $check_group_view) && !empty($data['useguide'])) {

                if ($exam_info['useguide'] == 3 && (!$exam_info['isdone'] || $exam_info['isdone'])) {
                    $xtpl->parse('main.questionlist.question.groups_result');
                }

                if ($exam_info['useguide'] == 2 && $exam_info['isdone']) {
                    $xtpl->parse('main.questionlist.question.groups_result1');
                }
            }

            if (!empty($exam_info['group_question_point'][$i-1])) {
                $xtpl->assign('question_common', $exam_info['group_question'][$exam_info['group_question_point'][$i-1]]['title']);
                $xtpl->parse('main.questionlist.question.question_general');
            }
            if (in_array($data['type'], array(1,2,5))) {
                $array_letters = range('A', 'Z');
                $k = 0;
                foreach ($data['answer'] as $answer) {
                    $answer['letter'] = $array_letters[$k];
                    // $answer['content'] = str_replace('&nbsp;', ' ', $answer['content']);
                    $answer['content'] = preg_replace('/\xC2\xA0/', ' ', $answer['content']); //xóa bỏ các ký tự &nbsp;

                    $xtpl->assign('ANSWER', $answer);

                    if ($data['type'] == 1 || $data['type'] == 3 || $data['type'] == 5) {
                        if ($istest) {
                            if ($data['count_true'] > 1) {
                                $xtpl->parse('main.questionlist.question.question_type_1.answer.checkbox');
                            } else {
                                $xtpl->parse('main.questionlist.question.question_type_1.answer.radio');
                            }

                            if (isset($answer['is_true_highlight']) && $answer['is_true_highlight']) {
                                $xtpl->parse('main.questionlist.question.question_type_1.answer.is_true_highlight');
                            }

                            if ($data['count_true'] > 1) {
                                $xtpl->parse('main.questionlist.question.question_type_1.answer_multiple');
                            }
                        }

                        $xtpl->parse('main.questionlist.question.question_type_1.answer.answer_style_' . $data['answer_style']);
                        $xtpl->parse('main.questionlist.question.question_type_1.answer');

                        $xtpl->parse('main.questionlist.question.question_type_1');
                    } elseif ($data['type'] == 2) {
                        if ($istest) {
                            if (isset($answer['is_true_highlight']) && $answer['is_true_highlight']) {
                                $xtpl->parse('main.questionlist.question.question_type_2.answer.is_true_highlight');
                            }
                            $xtpl->parse('main.questionlist.question.question_type_2.answer.textbox');
                        } else {
                            $xtpl->parse('main.questionlist.question.question_type_2.answer.space');
                        }
                        $xtpl->parse('main.questionlist.question.question_type_2.answer.answer_style_' . $data['answer_style']);
                        $xtpl->parse('main.questionlist.question.question_type_2.answer');
                        $xtpl->parse('main.questionlist.question.question_type_2');
                    }
                    $k++;
                }
            }
            else if (in_array($data['type'], array(4))) {
                $check = $exam_info['isdone'] ? !($exam_info['isdone']) : $istest;
                foreach ($array_question_type_4_option as $index => $value) {
                    $xtpl->assign('OPTION', array(
                        'index' => $index,
                        'value' => $value,
                        'checked' => $data['answer']['checked'] == $index ? 'checked="checked"' : '',
                        'disabled' => $check ? '' : 'disabled="disabled"',
                        'highlight' => $data['answer']['highlight'] == $index ? 'istrue' : ''
                    ));
                    $xtpl->parse('main.questionlist.question.question_type_4.loop');
                }

                $xtpl->parse('main.questionlist.question.question_type_4');
            } 
             
            elseif ($data['type'] == 6) {
                $answer['content'] = isset($tester_answer[$data['id']]) ? $tester_answer[$data['id']] : '';
                if ($data['answer_editor_type'] == 0) {
                    if ($exam_info['istesting'] && empty($exam_info['isdone'])) {
                        $answer['content'] = htmlspecialchars(nv_editor_br2nl($answer['content']));
                        if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
                            $editor_change_event_js = 1;
                            $answer['content'] = nv_aleditor('answer[' . $data['id'] . ']', '100%', '200px', $answer['content'], 'Basic');
                        } else {
                            $answer['content'] = '<textarea style="width:100%;height:300px" name="answer[' . $data['id'] . ']">' . $answer['content'] . '</textarea>';
                        }
                        $xtpl->assign('ANSWER', $answer['content']);
                        $xtpl->parse('main.questionlist.question.question_type_6.editor');
                    } else {
                        $xtpl->assign('ANSWER', $answer['content']);
                        $xtpl->parse('main.questionlist.question.question_type_6.label');
                    }
                } elseif ($data['answer_editor_type'] == 1) {
                    $xtpl->assign('ANSWER', nv_nl2br($answer['content']));
                    if ($exam_info['istesting'] && empty($exam_info['isdone'])) {
                        $xtpl->parse('main.questionlist.question.question_type_6.textarea');
                    } else {
                        $xtpl->parse('main.questionlist.question.question_type_6.label');
                    }
                }
                $xtpl->parse('main.questionlist.question.question_type_6');
            }elseif ($data['type'] == 7) { 
                if (strpos($exam_info['way_record'], '1') !== false) {
                    $xtpl->parse('main.questionlist.question.question_type_7.way_record_1');
                }
                if (strpos($exam_info['way_record'], '2') !== false) {
                    $xtpl->parse('main.questionlist.question.question_type_7.way_record_2');
                }
                if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/test_' . $user_info['userid'] . '_' . $exam_info['id'] . '_' . $data['id'] . '.wav' )) {
                    $xtpl->assign('audio_record_name', NV_BASE_SITEURL . NV_TEMP_DIR . '/test_' . $user_info['userid'] . '_' . $exam_info['id'] . '_' . $data['id'] . '.wav');
                } else if(isset($tester_answer[$data['id']])) {
                    $xtpl->assign('audio_record_name',  NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $tester_answer[$data['id']]);
                } else {
                    $xtpl->assign('audio_record_name',  '');
                }; 
                $xtpl->parse('main.questionlist.question.question_type_7');
            }

            if ($data['number'] > 1) {
                $xtpl->assign('HIDE', 'style="display: none"');
            }
            if ($data['limit_time_audio'] > 0) {
                $xtpl->parse('main.questionlist.question.limit_time_audio');
            }

            $xtpl->parse('main.questionlist.question');
            $i++;
            $z++;
        }
    }

    if (empty($array_saved_data)) {
        $xtpl->parse('main.questionlist');
    } else {
        if (!$exam_info['isdone']) {
            $xtpl->parse('main.questionlist.btn_exam_save_top');
            $xtpl->parse('main.btn_exam_save_bottom');
            $xtpl->parse('main.questionlist.auto_next_question');
        }
        if (!$exam_info['isdone'] || ($exam_info['view_question_after_test'])) {
            $xtpl->parse('main.questionlist');
        }

        if ($exam_info['isdone'] && $exam_info['exams_type'] > 0) {
            if ($exam_info['rating']) {
                if (!empty($exam_info['rating']['note'])) {
                    $xtpl->parse('main.result.rating.note');
                }
                $xtpl->parse('main.result.rating');
            }
            if ($exam_info['view_mark_after_test']) {
                $xtpl->assign('score_title', $exam_info['exams_type'] == 1 ? $nv_Lang->getModule('score') : $nv_Lang->getModule('score_multiple_choice'));
                $xtpl->assign('result_title', $exam_info['exams_type'] == 2 ? $nv_Lang->getModule('result_multiple_choice') : $nv_Lang->getModule('result'));
                $xtpl->parse('main.result.question_true');
                $xtpl->parse('main.result.question_false');
                $xtpl->parse('main.result.question_skeep');
                $xtpl->parse('main.result.total_question_have_not_mark');
                $xtpl->parse('main.result.score_box');
            }
            $xtpl->parse('main.result');
        } else {
            if ($editor_change_event_js) {
                $xtpl->parse('main.istesting.editor_change_event_js');
            }
            $xtpl->parse('main.istesting');
        }
    }

    if (!$isprint and $exam_info['per_page'] > 0 and count($array_data) > $exam_info['per_page']) {
        $xtpl->parse('main.page');
        $xtpl->parse('main.pagejs');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}
/**
 * nv_theme_test_examinations()
 * @return string
 *
 */
function nv_theme_test_examinations($array_data, $generate_page)
{
    global $module_name, $module_file, $lang_module, $module_info, $op;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('TEMPLATE', $module_info['template']);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    foreach ($array_data as $row) {
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.examinations');
    }
    if (!empty($generate_page)) {
        $xtpl->assign('PAGE', $generate_page);
        $xtpl->parse('main.page');
    }
    $xtpl->parse('main');
    return $xtpl->text('main');
}
function nv_theme_test_examinations_subject($array_data, $generate_page)
{
    global $module_name, $module_file, $lang_module, $module_info, $op;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    foreach ($array_data as $row) {
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.examinations_subject');
    }
    if (!empty($generate_page)) {
        $xtpl->assign('PAGE', $generate_page);
        $xtpl->parse('main.page');
    }
    $xtpl->parse('main');
    return $xtpl->text('main');
}
