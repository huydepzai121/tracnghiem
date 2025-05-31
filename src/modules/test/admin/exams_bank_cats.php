<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 13 Dec 2020 05:39:58 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;

if (!(empty($global_config['idsite']) or $global_config['users_special'])) {
	Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams_bank');
	die();
}

//change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
	$id = $nv_Request->get_int('id', 'post, get', 0);
	$content = 'NO_' . $id;

	$query = 'SELECT status FROM ' . tableSystem . '_exams_bank_cats WHERE id=' . $id;
	$row = $db->query($query)->fetch();
	if (isset($row['status'])) {
		$status = ($row['status']) ? 0 : 1;
		$query = 'UPDATE ' . tableSystem . '_exams_bank_cats SET status=' . intval($status) . ' WHERE id=' . $id;
		$db->query($query);
		$content = 'OK_' . $id;
	}
	$nv_Cache->delMod($module_name);
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}

if ($nv_Request->isset_request('ajax_action', 'post')) {
	$id = $nv_Request->get_int('id', 'post', 0);
	$new_vid = $nv_Request->get_int('new_vid', 'post', 0);
	$content = 'NO_' . $id;
	if ($new_vid > 0) {
		$sql = 'SELECT id FROM ' . tableSystem . '_exams_bank_cats WHERE id!=' . $id . ' AND parentid IN (SELECT parentid FROM ' . tableSystem . '_exams_bank_cats WHERE id = "' . $id . '") ORDER BY weight ASC';
		$result = $db->query($sql);
		$weight = 0;
		while ($row = $result->fetch()) {
			++$weight;
			if ($weight == $new_vid) ++$weight;
			$sql = 'UPDATE ' . tableSystem . '_exams_bank_cats SET weight=' . $weight . ' WHERE id=' . $row['id'];
			$db->query($sql);
		}
		$sql = 'UPDATE ' . tableSystem . '_exams_bank_cats SET weight=' . $new_vid . ' WHERE id=' . $id;
		$db->query($sql);
		$content = 'OK_' . $id;
	}
	$nv_Cache->delMod($module_name);
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}
$error = array();
if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
	$id = $nv_Request->get_int('delete_id', 'get');
	$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
	if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
		$weight = 0;
		$sql = 'SELECT weight, parentid FROM ' . tableSystem . '_exams_bank_cats WHERE id =' . $db->quote($id);
		$result = $db->query($sql);
		list($weight, $parentid) = $result->fetch(3);

		$list_childrent_id = get_childrent_cat($array_exams_bank_cats, $id);
		$list_childrent_id[] = $id;

		$db->query('DELETE FROM ' . tableSystem . '_exams_bank_cats  WHERE id IN ( ' . implode(', ', $list_childrent_id) . ')');
		if ($weight > 0) {
			$sql = 'SELECT id, weight FROM ' . tableSystem . '_exams_bank_cats WHERE weight >' . $weight;
			$result = $db->query($sql);
			while (list($id, $weight) = $result->fetch(3)) {
				$weight--;
				$db->query('UPDATE ' . tableSystem . '_exams_bank_cats SET weight=' . $weight . ' WHERE id=' . intval($id));
			}
		}
		$nv_Cache->delMod($module_name);
		Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&parentid=' . $parentid);
		die();
	}
}
$row = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
$parentid = $nv_Request->get_int('parentid', 'get', 0);

if ($nv_Request->isset_request('submit', 'post')) {
	$row['title'] = $nv_Request->get_title('title', 'post', '');
	$row['parentid'] = $nv_Request->get_int('parentid', 'post', 0);
	$row['note'] = $nv_Request->get_title('note', 'post', '');
	$row['keywords'] = $nv_Request->get_title('keywords', 'post', '');
	
	if (empty($row['title'])) {
		$error[] = $nv_Lang->getModule('error_required_title');
	}
	if (!empty($row['id'])) {
		// Kiểm tra khi thay đổi chủ đề cha thì lấy chủ đề con của nó hay không
		list($itsparent) = $db->query('SELECT parentid FROM ' . tableSystem . '_exams_bank_cats WHERE id = "' . $row['id'] . '"')->fetch(3);
		if ( ($itsparent != $row['parentid']) && func_check_duplicate_child($row['id'], $row['parentid'])) {
			$error[] = $nv_Lang->getModule('error_select_itself_child');
		}
	}
	if (empty($error)) {
		try {
			
			if (empty($row['id'])) {
				$stmt = $db->prepare('INSERT INTO ' . tableSystem . '_exams_bank_cats (title, parentid, note, keywords, status, weight) VALUES (:title, :parentid, :note, :keywords, :status, :weight)');

				$stmt->bindValue(':status', 1, PDO::PARAM_INT);
				
				$weight = $db->query('SELECT max(weight) FROM ' . tableSystem . '_exams_bank_cats')->fetchColumn();
				$weight = intval($weight) + 1;
				$stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
			} else {
				$stmt = $db->prepare('UPDATE ' . tableSystem . '_exams_bank_cats SET title = :title, parentid = :parentid, note = :note, keywords = :keywords WHERE id=' . $row['id']);
			}
			$stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
			$stmt->bindParam(':note', $row['note'], PDO::PARAM_STR);
			$stmt->bindParam(':keywords', $row['keywords'], PDO::PARAM_STR);
			$stmt->bindValue(':parentid', $row['parentid'], PDO::PARAM_INT);
			
			$exc = $stmt->execute();
			if ($exc) {
				$nv_Cache->delMod($module_name);
				Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&parentid=' . $row['parentid']);
				die();
			}
		} catch (PDOException $e) {
			trigger_error($e->getMessage());
			die($e->getMessage()); //Remove this line after checks finished
		}
	}
} elseif ($row['id'] > 0) {
	$row = $db->query('SELECT * FROM ' . tableSystem . '_exams_bank_cats WHERE id=' . $row['id'])->fetch();
	if (empty($row)) {
		Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		die();
	}
} else {
	$row['id'] = 0;
	$row['title'] = '';
	$row['note'] = '';
}

$q = $nv_Request->get_title('q', 'post,get');
/**
 * Đến tại vị trí này nếu $row['id'] có giá trị nghĩa là đang ở phần sửa chủ đề
 */
// Fetch Limit
$show_view = false;
if (empty($row['id'])) {
	/**
	 * $row['id'] không có -> đang ở danh sách các chủ đề
	 */
	$show_view = true;
	$per_page = 20;
	$page = $nv_Request->get_int('page', 'post,get', 1);
	$db->sqlreset()
		->select('COUNT(*)')
		->from('' . tableSystem . '_exams_bank_cats');

	if (!empty($q)) {
		$db->where('title LIKE :q_title OR note LIKE :q_note');
	} else {
		$db->where('parentid = "' . $parentid . '"');
	}
	$sth = $db->prepare($db->sql());

	if (!empty($q)) {
		$sth->bindValue(':q_title', '%' . $q . '%');
		$sth->bindValue(':q_note', '%' . $q . '%');
	}
	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select('*')
		->order('weight ASC')
		->limit($per_page)
		->offset(($page - 1) * $per_page);
	$sth = $db->prepare($db->sql());

	if (!empty($q)) {
		$sth->bindValue(':q_title', '%' . $q . '%');
		$sth->bindValue(':q_note', '%' . $q . '%');
	}
	$sth->execute();
} 
// Đếm số lượng đề thi ở các chủ đề
$num_exams_in_subject = array();
$have_num_exams_0 = 0;
if ($parentid > 0) {
	$result = $db->query('SELECT COUNT(catid) AS num, catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_bank  WHERE catid IN (SELECT id FROM '.  NV_PREFIXLANG . '_' . $module_data . '_exams_bank_cats WHERE parentid = ' . $parentid . ') GROUP BY catid');
	while ($row = $result->fetch(2)) {
		$num_exams_in_subject[$row['catid']] = $row['num'];
	}
} else {
	$have_num_exams_0 = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_bank WHERE catid = 0')->fetchColumn();
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

$xtpl->assign('Q', $q);

if ($show_view) {
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;parentid=' . $parentid;
	if (!empty($q)) {
		$base_url .= '&q=' . $q;
	}
	$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
	if (!empty($generate_page)) {
		$xtpl->assign('NV_GENERATE_PAGE', $generate_page);
		$xtpl->parse('main.view.generate_page');
	}
	$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
	while ($view = $sth->fetch()) {
		for ($i = 1; $i <= $num_items; ++$i) {
			$xtpl->assign('WEIGHT', array(
				'key' => $i,
				'title' => $i,
				'selected' => ($i == $view['weight']) ? ' selected="selected"' : ''
			));
			$xtpl->parse('main.view.loop.weight_loop');
		}
		$xtpl->assign('CHECK', $view['status'] == 1 ? 'checked' : '');
		$view['have_num_cat_childrent'] = $parentid == 0 
			? sprintf($nv_Lang->getModule('have_num_cat_childrent'), $array_exams_bank_cats[$view['id']]['num_child']) 
			: sprintf($nv_Lang->getModule('have_num_exams_in_subject'), !empty($num_exams_in_subject[$view['id']]) ? $num_exams_in_subject[$view['id']] : 0  );
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op .  '&amp;parentid=' . $parentid . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
		$view['link'] =  $parentid == 0 
			? NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;parentid=' . $view['id']
			: NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams_bank&amp;cat=' . $view['id']; 
		$xtpl->assign('VIEW', $view);
		$xtpl->parse('main.view.loop');
	}
	$nav_cats = get_nav_child_cat($parentid);
	if (!empty($nav_cats)) {
		foreach ($nav_cats as $nav) {
			$item = array(
				'title' => $nv_Lang->getModule('cat_main'), 
				'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op
			);
			$item['title'] = $nav != 0 ? $array_exams_bank_cats[$nav]['title'] : $item['title'];
			$item['link'] = $nav != 0 ? $item['link'] . '&amp;parentid=' . $nav : $item['link'];
			$xtpl->assign('CAT', $item);
			$xtpl->parse('main.view.nav_cat.loop');
		}
		$xtpl->parse('main.view.nav_cat');
	}
	if ($parentid == 0) {
		$xtpl->assign('link_other', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams_bank&amp;cat=0&had_not_identified=1');
		$xtpl->assign('num_items', $num_items + 1);
		$xtpl->assign('have_num_exams_0', sprintf($nv_Lang->getModule('have_num_exams_in_subject'), $have_num_exams_0));
		$xtpl->parse('main.view.cat_other');
	}

	$xtpl->parse('main.view');
}
/**
 * Nếu đang ở phần sửa chủ đề thì loại bỏ nó và các thằng con của nó trong phần chọn "Thuộc chủ đề"
 */
$array_bank_cats_clone = unserialize(serialize($array_exams_bank_cats));
if (!empty($row['id'])) {
	$array_bank_cats_clone = remove_child_cat($array_bank_cats_clone, $row['id']);
}
foreach ($array_bank_cats_clone as $rows_i) {
	// Xử lý dành cho trường hợp mong muốn chủ để chỉ có 2 tầng
	if ($rows_i['level'] > 0) continue; 
    $xtpl->assign('pid', $rows_i['id']);
    $xtpl->assign('ptitle', $rows_i['title_level']);
	if (empty($row['id'])) {
		$xtpl->assign('pselect', (!empty($parentid) && $rows_i['id'] == $parentid) ? ' selected="selected"' : '');
	} else {
		$xtpl->assign('pselect', (!empty($row['parentid']) && $rows_i['id'] == $row['parentid']) ? ' selected="selected"' : '');
	}
    $xtpl->parse('main.parent');
}
if (!empty($row['keywords'])) {
	$xtpl->assign('keywords',$row['keywords']);
	$keywords = explode(',', $row['keywords']);
	foreach ($keywords as $keyword) {
		$xtpl->assign('keyword', $keyword);
		$xtpl->parse('main.keywords');
		$xtpl->parse('main.push_keyword');
	}
}

if (!empty($error)) {
	$xtpl->assign('ERROR', implode('<br />', $error));
	$xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('exams_bank_cats');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
