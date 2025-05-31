<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2022 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 15 Jan 2022 01:14:29 GMT
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

use NukeViet\Api\DoApi;

if (defined('API_CRM_URL') and defined('NV_IS_USER')) {
    $sql = 'SELECT * FROM ' . $db_config['prefix'] . '_crm_track_dotest WHERE userid=' . $user_info['userid'];
    $track_dotest = $db->query($sql)->fetch();

    if (empty($track_dotest)) {
        // Lấy các thông tin tùy biến của thành viên
        $sql = 'SELECT * FROM ' . NV_USERS_GLOBALTABLE . '_info WHERE userid=' . $user_info['userid'];
        $user_otherinfo = $db->query($sql)->fetch();
        if (empty($user_otherinfo)) {
            // False to empty array
            $user_otherinfo = [];
        }

        /*
         * Tìm kiếm cơ hội
         * - Nếu có cơ hội cập nhật vào lịch sử
         * - Nếu không có cơ hội tìm lead cập nhật vào lịch sử
         * - Nếu không có lead luôn thì tạo mới lead và cập nhật vào lịch sử
         */

        $where_api = [];

        // Tìm email
        $where_api['OR'][] = [
            '=' => [
                'email' => $user_info['email']
            ]
        ];
        $where_api['OR'][] = [
            'FIND_IN_SET' => [
                'sub_email' => $user_info['email']
            ]
        ];
        // Tìm điện thoại
        if (!empty($user_otherinfo['phone'])) {
            $where_api['OR'][] = [
                '=' => [
                    'phone' => $user_otherinfo['phone']
                ]
            ];
            $where_api['OR'][] = [
                'FIND_IN_SET' => [
                    'sub_phone' => $user_otherinfo['phone']
                ]
            ];
        }
        // Tìm mã số thuế
        if (!empty($user_otherinfo['mst'])) {
            $where_api['OR'][] = [
                '=' => [
                    'tax' => $user_otherinfo['mst']
                ]
            ];
        }
        $array_order = [
            'last_comment' => 'DESC',
            'updatetime' => 'DESC'
        ];
        $params = [
            'page' => 1,
            'perpage' => 1,
            'where' => $where_api,
            'order' => $array_order
        ];

        $api = new DoApi(API_CRM_URL, API_CRM_KEY, API_CRM_SECRET);
        $api->setModule('crmbidding')
        ->setLang('vi')
        ->setAction('ListAllOpportunities')
        ->setData($params);

        $ListAllOpportunities = $api->execute();
        $apierror = $api->getError();

        $error = '';
        if (!empty($apierror)) {
            $error = $apierror;
        } elseif ($ListAllOpportunities['status'] != 'success') {
            $error = $ListAllOpportunities['message'];
        }

        $opportunities = [];
        if (empty($error) and $ListAllOpportunities['code'] != 4000) {
            $opportunities = array_values($ListAllOpportunities['data'])[0];
        }

        $leads = [];
        $leads_id = 0;

        // Tìm lead nếu không có cơ hội
        if (empty($opportunities) and empty($error)) {
            $where_api = [];
            $where_api['AND'][] = [
                '=' => [
                    'active' => 1
                ]
            ];

            $where_api['OR'][] = [
                '=' => [
                    'email' => $user_info['email']
                ]
            ];
            $where_api['OR'][] = [
                'FIND_IN_SET' => [
                    'sub_email' => $user_info['email']
                ]
            ];

            // Tìm điện thoại
            if (!empty($user_otherinfo['phone'])) {
                $where_api['OR'][] = [
                    '=' => [
                        'phone' => $user_otherinfo['phone']
                    ]
                ];
                $where_api['OR'][] = [
                    'FIND_IN_SET' => [
                        'sub_phone' => $user_otherinfo['phone']
                    ]
                ];
            }
            // Tìm mã số thuế
            if (!empty($user_otherinfo['mst'])) {
                $where_api['OR'][] = [
                    '=' => [
                        'tax' => $user_otherinfo['mst']
                    ]
                ];
            }

            $array_order = [];
            $array_order['last_comment'] = 'DESC';
            $array_order['updatetime'] = 'DESC';
            $params = [
                'where' => $where_api,
                'order' => $array_order,
                'page' => 1,
                'perpage' => 1
            ];

            $api = new DoApi(API_CRM_URL, API_CRM_KEY, API_CRM_SECRET);
            $api->setModule('crmbidding')
            ->setLang('vi')
            ->setAction('ListAllLeads')
            ->setData($params);

            $ListAllLeads = $api->execute();
            $apierror = $api->getError();

            if (!empty($apierror)) {
                $error = $apierror;
            } elseif ($ListAllLeads['status'] != 'success') {
                $error = $ListAllLeads['message'];
            }

            if (empty($error) and $ListAllLeads['code'] != 4000) {
                $leads = array_values($ListAllLeads['data'])[0];
            }
        }

        // Tạo mới lead nếu chưa có cả cơ hội lẫn lead
        if (empty($error) and empty($leads) and empty($opportunities)) {
            // Lấy thông tin người giới thiệu
            $sql = 'SELECT pri_uid FROM ' . $db_config['prefix'] . '_elink_affiliate_set WHERE pre_uid=' . $user_info['userid'];
            $affilacate_id = $db->query($sql)->fetchColumn();
            if (!$affilacate_id) {
                $affilacate_id = 0;
            }

            $otherdata = [];
            $otherdata['user_id'] = $user_info['userid'];
            if (!empty($user_otherinfo['mst'])) {
                $otherdata['tax'] = $user_otherinfo['mst'];
            }
            $otherdata['affilacate_id'] = $affilacate_id;
            $otherdata['caregiver_id'] = $affilacate_id;

            // Gọi API tạo lead
            try {
                $api = new DoApi(API_CRM_URL, API_CRM_KEY, API_CRM_SECRET);
                $api->setModule('crmbidding')
                ->setLang('vi')
                ->setAction('CreateLeads')
                ->setData([
                    'source_leads' => 13, // Nguồn thi trắc nghiệm
                    'name' => $user_info['full_name'],
                    'phone' => empty($user_otherinfo['phone']) ? '' : $user_otherinfo['phone'],
                    'email' => $user_info['email'],
                    'siteid' => 3, // tracnghiem.dauthau.asia
                    'admin_id' => $affilacate_id,
                    'otherdata' => $otherdata
                ]);
                $result = $api->execute();
                $apierror = $api->getError();
                if (!empty($apierror)) {
                    $error = $apierror;
                } elseif ($result['status'] != 'success') {
                    $error = $result['message'];
                } else {
                    $leads_id = $result['leadsid'];
                }
            } catch (Exception $e) {
                $error = print_r($e, true);
            }
        }

        // Cập nhật lịch sử chăm sóc lead/cơ hội
        if (empty($error)) {
            $url = NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'], true);
            $note = 'Tham gia thi chứng chỉ nghiệp vụ đấu thầu <a target="_blank" href="' . $url . '">' . $exam_info['title'] . '</a>';

            $params = [
                'note' => $note
            ];
            if ($leads_id) {
                $params['source'] = 1;
                $params['sourceid'] = $leads_id;
            } elseif (!empty($leads)) {
                $params['source'] = 1;
                $params['sourceid'] = $leads['id'];
            } else {
                $params['source'] = 2;
                $params['sourceid'] = $opportunities['id'];
            }

            $api = new DoApi(API_CRM_URL, API_CRM_KEY, API_CRM_SECRET);
            $api->setModule('crmbidding')
            ->setLang('vi')
            ->setAction('CreateComment')
            ->setData($params);

            $result_api = $api->execute();
            $apierror = $api->getError();

            if (!empty($apierror)) {
                $error = $apierror;
            } elseif ($result_api['status'] != 'success') {
                $error = $result_api['message'];
            }
        }

        // Cập nhật lịch sử lead/cơ hội
        /*
        if (empty($error)) {
            $log_data = [
                'Tham gia thi chứng chỉ nghiệp vụ đấu thầu'
            ];
            $log_data[] = [
                'type' => 'directlink',
                'text' => $exam_info['title'],
                'link' => NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'], true)
            ];

            $params = [
                'userid' => 0,
                'log_area' => 0,
                'log_time' => NV_CURRENTTIME,
                'log_data' => $log_data
            ];
            if ($leads_id) {
                $params['log_key'] = 'LOG_LEAD_DOTEST';
                $params['leads_id'] = $leads_id;
            } elseif (!empty($leads)) {
                $params['log_key'] = 'LOG_LEAD_DOTEST';
                $params['leads_id'] = $leads['id'];
            } else {
                $params['log_key'] = 'LOG_OPPORTUNITIES_DOTEST';
                $params['oppotunities_id'] = $opportunities['id'];
            }

            $api = new DoApi(API_CRM_URL, API_CRM_KEY, API_CRM_SECRET);
            $api->setModule('crmbidding')
            ->setLang('vi')
            ->setAction('CreateAllLogs')
            ->setData($params);

            $result_api = $api->execute();
            $apierror = $api->getError();

            if (!empty($apierror)) {
                $error = $apierror;
            } elseif ($result_api['status'] != 'success') {
                $error = $result_api['message'];
            }
        }
        */

        if (!empty($error)) {
            trigger_error($error);
        } else {
            // Ghi vào lịch sử tham gia thi
            $sql = 'INSERT INTO ' . $db_config['prefix'] . '_crm_track_dotest (
                userid, test_id, test_time, from_ip
            ) VALUES (
                ' . $user_info['userid'] . ', ' . $exam_info['id'] . ',
                ' . NV_CURRENTTIME . ', ' . $db->quote(NV_CLIENT_IP) . '
            )';
            $db->query($sql);
        }
    }
}
