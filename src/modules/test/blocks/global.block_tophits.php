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

if (!nv_function_exists('nv_test_block_tophits')) {

    function nv_test_config_tophits_blocks($module, $data_block, $lang_block)
    {
        global $nv_Cache, $site_mods;
        $html = '';
        $html .= '<div class="form-group">';
        $html .= '  <label class="control-label col-sm-6">' . $lang_block['number_day'] . '</label>';
        $html .= '  <div class="col-sm-18">';
        $html .= '      <input type="text" name="config_number_day" class="form-control w100" size="5" value="' . $data_block['number_day'] . '"/>';
        $html .= '  </div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '  <label class="control-label col-sm-6">' . $lang_block['numrow'] . '</label>';
        $html .= '  <div class="col-sm-18">';
        $html .= '      <input type="text" name="config_numrow" class="form-control w100" size="5" value="' . $data_block['numrow'] . '"/>';
        $html .= '  </div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '  <label class="control-label col-sm-6">' . $lang_block['nocatid'] . '</label>';
        $html .= '  <div class="col-sm-18">';
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
        $list = $nv_Cache->db($sql, '', $module);
        $html .= '<div style="height: 200px; overflow: auto">';
        if (!is_array($data_block['nocatid'])) {
            $data_block['nocatid'] = explode(',', $data_block['nocatid']);
        }
        foreach ($list as $l) {
            $xtitle_i = '';

            if ($l['lev'] > 0) {
                for ($i = 1; $i <= $l['lev']; ++$i) {
                    $xtitle_i .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            }
            $checked = in_array($l['id'], $data_block['nocatid']) ? ' checked="checked"' : '';
            $html .= $xtitle_i . '<label><input type="checkbox" name="config_nocatid[]" value="' . $l['id'] . '" ' . $checked . ' />' . $l['title'] . '</label><br />';
        }
        $html .= '</div>';
        $html .= '  </div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    function nv_test_config_tophits_blocks_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['number_day'] = $nv_Request->get_int('config_number_day', 'post', 0);
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['nocatid'] = $nv_Request->get_typed_array('config_nocatid', 'post', 'int', array());
        return $return;
    }

    function nv_test_block_tophits($block_config)
    {
        global $array_test_cat, $module_array_cat, $site_mods, $module_info, $db, $module_config, $global_config, $module_data, $array_config;

        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_data = $site_mods[$module]['module_data'];
        $time = NV_CURRENTTIME - $block_config['number_day'] * 86400;

        if ($mod_data != $module_data) {
            $array_config = $module_config[$module];
            $module_name = $module;
            $array_test_cat = $module_array_cat;
            require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
        }

        $array_block_news = array();
        $db->sqlreset()
            ->select('id, catid, title, alias, image, num_question, addtime')
            ->from(NV_PREFIXLANG . '_' . $mod_data . '_exams')
            ->order('hitstotal DESC')
            ->limit($block_config['numrow']);

        if (empty($block_config['nocatid'])) {
            $db->where('status= 1 AND isfull=1 AND addtime > ' . $time);
        } else {
            $db->where('status= 1 AND isfull=1 AND addtime > ' . $time . ' AND catid NOT IN (' . implode(',', $block_config['nocatid']) . ')');
        }

        $result = $db->query($db->sql());
        $array_data = array();
        while ($row = $result->fetch()) {
            if (!empty($data = nv_show_exams($row, $module))) {
                $array_data[$row['id']] = $data;
            }
        }

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $mod_file . '/block_tophits.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('block_tophits.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('TEMPLATE', $block_theme);

        if (!empty($array_data)) {
            foreach ($array_data as $data) {
                $xtpl->assign('ROW', $data);

                if (!empty($data['image'])) {
                    $xtpl->parse('main.loop.avatar_image');
                } else {
                    $xtpl->parse('main.loop.avatar_text');
                }

                if ($data['newday'] >= NV_CURRENTTIME) {
                    $xtpl->parse('main.loop.newday');
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
        $content = nv_test_block_tophits($block_config);
    }
}
