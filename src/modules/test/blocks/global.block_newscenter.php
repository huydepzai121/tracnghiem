<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */
if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (!nv_function_exists('nv_test_block_newscenter')) {
    
    function nv_block_config_test_newscenter($module, $data_block, $lang_block)
    {
        global $nv_Cache, $site_mods;
        
        $html = '<tr>';
        $html .= '	<td>' . $lang_block['numrow'] . '</td>';
        $html .= '	<td><input type="text" name="config_numrow" class="form-control w100 pull-left" size="5" value="' . $data_block['numrow'] . '"/>';
        $html .= '	<span class="text-middle pull-left">&nbsp; ' . $lang_block['width'] . '&nbsp; </span>';
        $html .= '	<input type="width" name="config_width" class="form-control w100 pull-left" value="' . $data_block['width'] . '"/>';
        $html .= '	<span class="text-middle pull-left">&nbsp; ' . $lang_block['height'] . '&nbsp; </span>';
        $html .= '	<input type="height" name="config_height" class="form-control w100 pull-left" value="' . $data_block['height'] . '"/>';
        $html .= '</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '	<td>' . $lang_block['length_title'] . '</td>';
        $html .= '	<td>';
        $html .= '	<input type="text" class="form-control w100 pull-left" name="config_length_title" size="5" value="' . $data_block['length_title'] . '"/>';
        $html .= '	<span class="text-middle pull-left">&nbsp;' . $lang_block['length_hometext'] . '&nbsp;</span><input type="text" class="form-control w100 pull-left" name="config_length_hometext" size="5" value="' . $data_block['length_hometext'] . '"/>';
        $html .= '</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '	<td>' . $lang_block['length_othertitle'] . '</td>';
        $html .= '	<td>';
        $html .= '	<input type="text" class="form-control w100" name="config_length_othertitle" size="5" value="' . $data_block['length_othertitle'] . '"/>';
        $html .= '</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td>' . $lang_block['nocatid'] . '</td>';
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
        $list = $nv_Cache->db($sql, '', $module);
        $html .= '<td>';
        $html .= '<div style="height: 160px; overflow: auto">';
        foreach ($list as $l) {
            $xtitle_i = '';
            if ($l['lev'] > 0) {
                for ($i = 1; $i <= $l['lev']; ++$i) {
                    $xtitle_i .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            }
            $data_block['nocatid'] = !empty($data_block['nocatid']) ? $data_block['nocatid'] : array();
            $html .= $xtitle_i . '<label><input type="checkbox" name="config_nocatid[]" value="' . $l['catid'] . '" ' . ((in_array($l['catid'], $data_block['nocatid'])) ? ' checked="checked"' : '') . '</input>' . $l['title'] . '</label><br />';
        }
        $html .= '</div>';
        $html .= '</td>';
        $html .= '</tr>';
        return $html;
    }
    
    function nv_block_config_test_newscenter_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['length_title'] = $nv_Request->get_int('config_length_title', 'post', 0);
        $return['config']['length_hometext'] = $nv_Request->get_int('config_length_hometext', 'post', 0);
        $return['config']['length_othertitle'] = $nv_Request->get_int('config_length_othertitle', 'post', 0);
        $return['config']['width'] = $nv_Request->get_int('config_width', 'post', '');
        $return['config']['height'] = $nv_Request->get_int('config_height', 'post', '');
        $return['config']['nocatid'] = $nv_Request->get_typed_array('config_nocatid', 'post', 'int', array());
        return $return;
    }
    
    function nv_test_block_newscenter($block_config)
    {
        global $nv_Cache, $module_data, $module_data, $module_file, $module_upload, $module_array_cat, $global_config, $lang_module, $db, $module_config, $module_info, $array_config, $site_mods;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        if ($module_data != $mod_data) {
            $array_config = $module_config[$module];
        }
        
        $db->sqlreset()
            ->select('id, catid, title, alias, hometext, image, num_question, addtime')
            ->from(NV_PREFIXLANG . '_' . $mod_data . '_exams')
            ->order(nv_test_get_order_exams())
            ->limit($block_config['numrow']);
        
        if (empty($block_config['nocatid'])) {
            $db->where('status=1 AND isfull=1');
        } else {
            $db->where('status=1 AND isfull=1 AND catid NOT IN (' . implode(',', $block_config['nocatid']) . ')');
        }
        
        $list = $nv_Cache->db($db->sql(), 'id', $module);
        if (!empty($list)) {
            if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/test/block_groups.tpl')) {
                $block_theme = $global_config['module_theme'];
            } else {
                $block_theme = 'default';
            }
            $xtpl = new XTemplate('block_newscenter.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
            $xtpl->assign('lang', $lang_module);
            $xtpl->assign('TEMPLATE', $global_config['module_theme']);
            
            $_first = true;
            foreach ($list as $row) {
                $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
                $row['titleclean60'] = nv_clean60($row['title'], $block_config['length_title']);
                
                if ($_first) {
                    $_first = false;
                    $width = isset($block_config['width']) ? $block_config['width'] : 400;
                    $height = isset($block_config['height']) ? $block_config['height'] : 268;
                    
                    if ($row['image'] != '' and ($imginfo = nv_is_image(NV_UPLOADS_REAL_DIR . '/' . $mod_upload . '/' . $row['image'])) != array()) {
                        $image = NV_UPLOADS_REAL_DIR . '/' . $mod_upload . '/' . $row['image'];
                        
                        if ($imginfo['width'] <= $width and $imginfo['height'] <= $height) {
                            $row['imgsource'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $row['image'];
                            $row['width'] = $imginfo['width'];
                        } else {
                            $basename = preg_replace('/(.*)(\.[a-z]+)$/i', $module . '_' . $row['id'] . '_\1_' . $width . '-' . $height . '\2', basename($image));
                            if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $basename)) {
                                $imginfo = nv_is_image(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $basename);
                                $row['imgsource'] = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $basename;
                                $row['width'] = $imginfo['width'];
                            } else {
                                $_image = new NukeViet\Files\Image($image, NV_MAX_WIDTH, NV_MAX_HEIGHT);
                                $_image->resizeXY($width, $height);
                                $_image->save(NV_ROOTDIR . '/' . NV_TEMP_DIR, $basename);
                                if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $basename)) {
                                    $row['imgsource'] = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $basename;
                                    $row['width'] = $_image->create_Image_info['width'];
                                }
                            }
                        }
                    } elseif (nv_is_url($row['image'])) {
                        $row['imgsource'] = $row['image'];
                        $row['width'] = $width;
                    } elseif (!empty($array_config['no_image']) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $array_config['no_image'])) {
                        $row['imgsource'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $array_config['no_image'];
                        $row['width'] = $width;
                    } else {
                        $row['imgsource'] = NV_BASE_SITEURL . 'themes/' . $global_config['site_theme'] . '/images/no_image.gif';
                        $row['width'] = $width;
                    }
                    
                    if (!empty($block_config['length_hometext'])) {
                        $row['hometext'] = nv_clean60(strip_tags($row['hometext']), $block_config['length_hometext']);
                    }
                    
                    $xtpl->assign('main', $row);
                } else {
                    if (!empty($row['image']) and file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $mod_upload . '/' . $row['image'])) {
                        $row['imgsource'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $mod_upload . '/' . $row['image'];
                    } elseif (!empty($row['image']) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $row['image'])) {
                        $row['imgsource'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $row['image'];
                    } elseif (!empty($array_config['no_image'])) {
                        if (file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $mod_upload . '/' . $array_config['no_image'])) {
                            $row['imgsource'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $mod_upload . '/' . $array_config['no_image'];
                        } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $array_config['no_image'])) {
                            $row['imgsource'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $array_config['no_image'];
                        } else {
                            $row['imgsource'] = '';
                        }
                    } else {
                        $row['imgsource'] = '';
                    }
                    
                    $row['titleclean60'] = nv_clean60($row['title'], $block_config['length_othertitle']);
                    $xtpl->assign('othernews', $row);
                    
                    if (!empty($row['imgsource'])) {
                        $xtpl->parse('main.othernews.image');
                    }
                    
                    $xtpl->parse('main.othernews');
                }
            }
            
            $xtpl->parse('main');
            return $xtpl->text('main');
        }
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
        $content = nv_test_block_newscenter($block_config);
    }
}
