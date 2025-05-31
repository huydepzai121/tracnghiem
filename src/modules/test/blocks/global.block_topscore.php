<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC.
 * All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */
if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (!nv_function_exists('nv_test_config_topscore')) {

    function nv_test_config_topscore_blocks($module, $data_block, $lang_block)
    {
        global $nv_Cache, $site_mods;
        $html = '';

        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['topicid'] . ':</label>';

        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_exams ORDER BY weight ASC';
        $list = $nv_Cache->db($sql, '', $module);
        $html .= '<div class="col-sm-9">';
        $html .= '<select name="config_topicid" class="form-control">';

        $html .= '<option value="0" >' . $lang_block['all'] . '</option>';
        foreach ($list as $l) {
            $selected = $l['id'] == $data_block['topicid'] ? ' selected="selected"' : '';
            $html .= '<option value="' . $l['id'] . '" ' . $selected . '>' . $l['title'] . '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['number_day'] . ':</label>';
        $html .= '<div class="col-sm-18"><input type="text" name="config_number_day" class="form-control w100" size="5" value="' . $data_block['number_day'] . '"/></div>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['numrow'] . ':</label>';
        $html .= '<div class="col-sm-18"><input type="text" name="config_numrow" class="form-control w100" size="5" value="' . $data_block['numrow'] . '"/></div>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['numtop'] . ':</label>';
        $html .= '<div class="col-sm-18"><input type="text" name="config_numtop" class="form-control w100" size="5" value="' . $data_block['numtop'] . '"/></div>';
        $html .= '</div>';
        return $html;
    }

    function nv_test_config_topscore_blocks_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['number_day'] = $nv_Request->get_int('config_number_day', 'post', 0);
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['numtop'] = $nv_Request->get_int('config_numtop', 'post', 0);
        $return['config']['topicid'] = $nv_Request->get_int('config_topicid', 'post', 0);

        return $return;
    }

    function nv_test_config_topscore($block_config)
    {
        global $array_test_cat, $module_array_cat, $site_mods, $my_head, $db, $module_config, $global_config, $module_name, $array_config, $id, $lang_module;

        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_data = $site_mods[$module]['module_data'];
        $time = NV_CURRENTTIME - $block_config['number_day'] * 86400;

        if ($module != $module_name) {
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }

        $array_field_config = array();
        $result_field = $db->query('SELECT * FROM ' . NV_USERS_GLOBALTABLE . '_field WHERE show_profile=1 AND is_system != 1 ORDER BY weight ASC');
        while ($row_field = $result_field->fetch()) {
            $language = unserialize($row_field['language']);
            $row_field['title'] = (isset($language[NV_LANG_DATA])) ? $language[NV_LANG_DATA][0] : $row['field'];
            $row_field['description'] = (isset($language[NV_LANG_DATA])) ? nv_htmlspecialchars($language[NV_LANG_DATA][1]) : '';
            if (!empty($row_field['field_choices'])) {
                $row_field['field_choices'] = unserialize($row_field['field_choices']);
            } elseif (!empty($row_field['sql_choices'])) {
                $row_field['sql_choices'] = explode('|', $row_field['sql_choices']);
                $query = 'SELECT ' . $row_field['sql_choices'][2] . ', ' . $row_field['sql_choices'][3] . ' FROM ' . $row_field['sql_choices'][1];
                $result = $db->query($query);
                $weight = 0;
                while (list ($key, $val) = $result->fetch(3)) {
                    $row_field['field_choices'][$key] = $val;
                }
            }
            $array_field_config[] = $row_field;
        }

        $where = '';
        $array_block_news = array();

        if ($id > 0) {
            $where = 'exam_id = ' . $id . '  AND end_time >' . $time;
        } else {
            $where = 'end_time > ' . $time;
        }

        if (!empty($block_config['topicid'])) {
            $where .= ' AND exam_id = ' . $block_config['topicid'];
        }

        $db->sqlreset()
            ->select('t1.id,t1.exam_id,t1.userid,t1.score,t1.end_time, t1.count_true, t2.username, t2.first_name,t2.last_name, t2.photo, t3.ladder, t3.title, t3.alias, t3.catid')
            ->from(NV_PREFIXLANG . '_' . $mod_data . '_answer AS t1')
            ->join('INNER JOIN ' . NV_USERS_GLOBALTABLE . ' AS t2 ON t1.userid=t2.userid INNER JOIN ' . NV_PREFIXLANG . '_' . $mod_data . '_exams AS t3 ON t1.exam_id=t3.id')
            ->order('t1.score DESC, ' . nv_test_get_order_exams('t3.'))
            ->limit($block_config['numrow'])
            ->where($where);

        $result = $db->query($db->sql());

        $array_users = $array_data = array();
        while ($row = $result->fetch()) {
            $row['custom_field'] = array();
            if (!isset($array_users[$row['userid']])) {
                $_result = $db->query('SELECT * FROM ' . NV_USERS_GLOBALTABLE . '_info WHERE userid=' . $row['userid'])->fetch();
                if ($_result) {
                    $array_users[$row['userid']] = $row['custom_field'] = $_result;
                }
            } else {
                $row['custom_field'] = $array_users[$row['userid']];
            }
            $array_data[] = $row;
        }

        if (empty($array_data)) {
            return '';
        }

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $mod_file . '/block_topscore.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        if ($module != $module_name) {
            $array_config = $module_config[$module];
            $array_test_cat = $module_array_cat;
            require_once NV_ROOTDIR . '/modules/test/language/' . NV_LANG_INTERFACE . '.php';
            $my_head .= '<link rel="stylesheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/' . $mod_file . '.css' . '" type="text/css" />';
        }

        if (!isset($block_config['numtop'])) $block_config['numtop'] = 3;

        $xtpl = new XTemplate('block_topscore.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('BLOCKCONFIG', $block_config);

        if (!empty($array_data)) {
            foreach ($array_data as $key => $data) {

                $data['full_name'] = nv_show_name_user($data['first_name'], $data['last_name'], $data['username']);

                if (empty($id)) {
                    $data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$data['catid']]['alias'] . '/' . $data['alias'] . '-' . $data['exam_id'] . $global_config['rewrite_exturl'];
                }

                if ($key < $block_config['numtop']) {
                    $data['medal_icon'] = NV_BASE_SITEURL . 'themes/' . $block_theme . '/images/' . $mod_file . '/medal_' . $key . '.png';
                    $data['class'] = 'top3';
                }

                $xtpl->assign('ROW', $data);

                if ($key < 3) {
                    $xtpl->parse('main.loop.medal_icon');
                }

                if (empty($id)) {
                    $xtpl->parse('main.loop.exam');
                }

                if (!empty($array_field_config)) {
                    foreach ($array_field_config as $row) {
                        $question_type = $row['field_type'];
                        if ($question_type == 'checkbox') {
                            $result = explode(',', $data['custom_field'][$row['field']]);
                            $value = '';
                            foreach ($result as $item) {
                                $value .= $row['field_choices'][$item] . '<br />';
                            }
                        } elseif ($question_type == 'multiselect' or $question_type == 'select' or $question_type == 'radio') {
                            $value = isset($row['field_choices'][$data['custom_field'][$row['field']]]) ? $row['field_choices'][$data['custom_field'][$row['field']]] : '';
                        } else {
                            $value = isset($data['custom_field'][$row['field']]) ? $data['custom_field'][$row['field']] : '';
                        }
                        if (empty($value)) continue;
                        $xtpl->assign('FIELD', array(
                            'title' => $row['title'],
                            'value' => $value
                        ));
                        $xtpl->parse('main.loop.field.loop');
                    }
                    $xtpl->parse('main.loop.field');
                }

                $xtpl->parse('main.loop');
            }
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $module_name, $array_test_cat, $module_array_cat, $nv_Cache, $db;

    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $array_test_cat;
            unset($module_array_cat[0]);
        } else {
            $module_array_cat = array();
            $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
            $list = $nv_Cache->db($sql, 'id', $module);
            if (!empty($list)) {
                foreach ($list as $l) {
                    $module_array_cat[$l['id']] = $l;
                    $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
                }
            }
        }
        $content = nv_test_config_topscore($block_config);
    }
}