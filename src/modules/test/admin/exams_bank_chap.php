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

//change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
	$id = $nv_Request->get_int('id', 'post, get', 0);
	$content = 'NO_' . $id;

	$query = 'SELECT status FROM ' . tableSystem . '_exams_bank_chap WHERE id=' . $id;
	$row = $db->query($query)->fetch();
	if (isset($row['status'])) {
		$status = ($row['status']) ? 0 : 1;
		$query = 'UPDATE ' . tableSystem . '_exams_bank_chap SET status=' . intval($status) . ' WHERE id=' . $id;
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
		$sql = 'SELECT id FROM ' . tableSystem . '_exams_bank_chap WHERE id!=' . $id . ' ORDER BY weight ASC';
		$result = $db->query($sql);
		$weight = 0;
		while ($row = $result->fetch()) {
			++$weight;
			if ($weight == $new_vid) ++$weight;
			$sql = 'UPDATE ' . tableSystem . '_exams_bank_chap SET weight=' . $weight . ' WHERE id=' . $row['id'];
			$db->query($sql);
		}
		$sql = 'UPDATE ' . tableSystem . '_exams_bank_chap SET weight=' . $new_vid . ' WHERE id=' . $id;
		$db->query($sql);
		$content = 'OK_' . $id;
	}
	$nv_Cache->delMod($module_name);
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}
if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
	$id = $nv_Request->get_int('delete_id', 'get');
	$delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
	if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
		$weight = 0;
		$sql = 'SELECT weight FROM ' . tableSystem . '_exams_bank_chap WHERE id =' . $db->quote($id);
		$result = $db->query($sql);
		list($weight) = $result->fetch(3);

		$db->query('DELETE FROM ' . tableSystem . '_exams_bank_chap  WHERE id = ' . $db->quote($id));
		if ($weight > 0) {
			$sql = 'SELECT id, weight FROM ' . tableSystem . '_exams_bank_chap WHERE weight >' . $weight;
			$result = $db->query($sql);
			while (list($id, $weight) = $result->fetch(3)) {
				$weight--;
				$db->query('UPDATE ' . tableSystem . '_exams_bank_chap SET weight=' . $weight . ' WHERE id=' . intval($id));
			}
		}
		$nv_Cache->delMod($module_name);
		Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
		die();
	}
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
	$row['title'] = $nv_Request->get_title('title', 'post', '');
	$row['note'] = $nv_Request->get_title('note', 'post', '');

	if (empty($row['title'])) {
		$error[] = $nv_Lang->getModule('error_required_title');
	}

	if (empty($error)) {
		try {
			if (empty($row['id'])) {
				$stmt = $db->prepare('INSERT INTO ' . tableSystem . '_exams_bank_chap (title, note, status, weight) VALUES (:title, :note, :status, :weight)');

				$stmt->bindValue(':status', 1, PDO::PARAM_INT);

				$weight = $db->query('SELECT max(weight) FROM ' . tableSystem . '_exams_bank_chap')->fetchColumn();
				$weight = intval($weight) + 1;
				$stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
			} else {
				$stmt = $db->prepare('UPDATE ' . tableSystem . '_exams_bank_chap SET title = :title, note = :note WHERE id=' . $row['id']);
			}
			$stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
			$stmt->bindParam(':note', $row['note'], PDO::PARAM_STR);

			$exc = $stmt->execute();
			if ($exc) {
				$nv_Cache->delMod($module_name);
				Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
				die();
			}
		} catch (PDOException $e) {
			trigger_error($e->getMessage());
			die($e->getMessage()); //Remove this line after checks finished
		}
	}
} elseif ($row['id'] > 0) {
	$row = $db->query('SELECT * FROM ' . tableSystem . '_exams_bank_chap WHERE id=' . $row['id'])->fetch();
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

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
	$show_view = true;
	$per_page = 20;
	$page = $nv_Request->get_int('page', 'post,get', 1);
	$db->sqlreset()
		->select('COUNT(*)')
		->from('' . tableSystem . '_exams_bank_chap');

	if (!empty($q)) {
		$db->where('title LIKE :q_title OR note LIKE :q_note');
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


$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

$xtpl->assign('Q', $q);

if ($show_view) {
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
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
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
		$xtpl->assign('VIEW', $view);
		$xtpl->parse('main.view.loop');
	}
	$xtpl->parse('main.view');
}


if (!empty($error)) {
	$xtpl->assign('ERROR', implode('<br />', $error));
	$xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('exams_bank_chap');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
