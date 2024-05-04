<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$install_lang['modules'] = [];
$install_lang['modules']['about'] = 'Giới thiệu';
$install_lang['modules']['about_for_acp'] = '';
$install_lang['modules']['news'] = 'Tin Tức';
$install_lang['modules']['news_for_acp'] = '';
$install_lang['modules']['users'] = 'Tài khoản người dùng';
$install_lang['modules']['users_for_acp'] = 'Tài khoản';
$install_lang['modules']['myapi'] = 'API của tôi';
$install_lang['modules']['myapi_for_acp'] = '';
$install_lang['modules']['inform'] = 'Thông báo';
$install_lang['modules']['inform_for_acp'] = '';
$install_lang['modules']['contact'] = 'Liên hệ';
$install_lang['modules']['contact_for_acp'] = '';
$install_lang['modules']['statistics'] = 'Thống kê';
$install_lang['modules']['statistics_for_acp'] = '';
$install_lang['modules']['voting'] = 'Thăm dò ý kiến';
$install_lang['modules']['voting_for_acp'] = '';
$install_lang['modules']['banners'] = 'Quảng cáo';
$install_lang['modules']['banners_for_acp'] = '';
$install_lang['modules']['seek'] = 'Tìm kiếm';
$install_lang['modules']['seek_for_acp'] = '';
$install_lang['modules']['menu'] = 'Menu Site';
$install_lang['modules']['menu_for_acp'] = '';
$install_lang['modules']['comment'] = 'Bình luận';
$install_lang['modules']['comment_for_acp'] = 'Quản lý bình luận';
$install_lang['modules']['siteterms'] = 'Điều khoản sử dụng';
$install_lang['modules']['siteterms_for_acp'] = '';
$install_lang['modules']['feeds'] = 'RSS-feeds';
$install_lang['modules']['Page'] = 'Page';
$install_lang['modules']['Page_for_acp'] = '';
$install_lang['modules']['freecontent'] = 'Giới thiệu sản phẩm';
$install_lang['modules']['freecontent_for_acp'] = '';
$install_lang['modules']['two_step_verification'] = 'Xác thực hai bước';
$install_lang['modules']['two_step_verification_for_acp'] = '';

$install_lang['modfuncs'] = [];
$install_lang['modfuncs']['users'] = [];
$install_lang['modfuncs']['users']['login'] = 'Đăng nhập';
$install_lang['modfuncs']['users']['register'] = 'Đăng ký';
$install_lang['modfuncs']['users']['lostpass'] = 'Khôi phục mật khẩu';
$install_lang['modfuncs']['users']['lostactivelink'] = 'Lấy lại link kích hoạt';
$install_lang['modfuncs']['users']['r2s'] = 'Tắt xác thực 2 bước';
$install_lang['modfuncs']['users']['active'] = 'Kích hoạt tài khoản';
$install_lang['modfuncs']['users']['editinfo'] = 'Thiết lập tài khoản';
$install_lang['modfuncs']['users']['memberlist'] = 'Danh sách người dùng';
$install_lang['modfuncs']['users']['logout'] = 'Thoát';
$install_lang['modfuncs']['users']['groups'] = 'Quản lý nhóm';

$install_lang['modfuncs']['statistics'] = [];
$install_lang['modfuncs']['statistics']['allreferers'] = 'Theo đường dẫn đến site';
$install_lang['modfuncs']['statistics']['allcountries'] = 'Theo quốc gia';
$install_lang['modfuncs']['statistics']['allbrowsers'] = 'Theo trình duyệt';
$install_lang['modfuncs']['statistics']['allos'] = 'Theo hệ điều hành';
$install_lang['modfuncs']['statistics']['allbots'] = 'Theo máy chủ tìm kiếm';
$install_lang['modfuncs']['statistics']['referer'] = 'Đường dẫn đến site theo tháng';

$install_lang['blocks_groups'] = [];
$install_lang['blocks_groups']['news'] = [];
$install_lang['blocks_groups']['news']['module.block_newscenter'] = 'Tin mới nhất';
$install_lang['blocks_groups']['news']['global.block_category'] = 'Chủ đề';
$install_lang['blocks_groups']['news']['global.block_tophits'] = 'Tin xem nhiều';
$install_lang['blocks_groups']['banners'] = [];
$install_lang['blocks_groups']['banners']['global.banners1'] = 'Quảng cáo giữa trang';
$install_lang['blocks_groups']['banners']['global.banners2'] = 'Quảng cáo cột trái';
$install_lang['blocks_groups']['banners']['global.banners3'] = 'Quảng cáo cột phải';
$install_lang['blocks_groups']['statistics'] = [];
$install_lang['blocks_groups']['statistics']['global.counter'] = 'Thống kê';
$install_lang['blocks_groups']['about'] = [];
$install_lang['blocks_groups']['about']['global.about'] = 'Giới thiệu';
$install_lang['blocks_groups']['voting'] = [];
$install_lang['blocks_groups']['voting']['global.voting_random'] = 'Thăm dò ý kiến';
$install_lang['blocks_groups']['inform'] = [];
$install_lang['blocks_groups']['inform']['global.inform'] = 'Thông báo';
$install_lang['blocks_groups']['users'] = [];
$install_lang['blocks_groups']['users']['global.user_button'] = 'Đăng nhập người dùng';
$install_lang['blocks_groups']['theme'] = [];
$install_lang['blocks_groups']['theme']['global.company_info'] = 'Công ty chủ quản';
$install_lang['blocks_groups']['theme']['global.menu_footer'] = 'Các chuyên mục chính';
$install_lang['blocks_groups']['freecontent'] = [];
$install_lang['blocks_groups']['freecontent']['global.free_content'] = 'Sản phẩm';

$install_lang['cron'] = [];
$install_lang['cron']['cron_online_expired_del'] = 'Xóa các dòng ghi trạng thái online đã cũ trong CSDL';
$install_lang['cron']['cron_dump_autobackup'] = 'Tự động lưu CSDL';
$install_lang['cron']['cron_auto_del_temp_download'] = 'Xóa các file tạm trong thư mục tmp';
$install_lang['cron']['cron_del_ip_logs'] = 'Xóa IP log files, Xóa các file nhật ký truy cập';
$install_lang['cron']['cron_auto_del_error_log'] = 'Xóa các file error_log quá hạn';
$install_lang['cron']['cron_auto_sendmail_error_log'] = 'Gửi email các thông báo lỗi cho admin';
$install_lang['cron']['cron_ref_expired_del'] = 'Xóa các referer quá hạn';
$install_lang['cron']['cron_auto_check_version'] = 'Kiểm tra phiên bản NukeViet';
$install_lang['cron']['cron_notification_autodel'] = 'Xóa thông báo cũ';
$install_lang['cron']['cron_remove_expired_inform'] = 'Xóa thông báo quá hạn';
$install_lang['cron']['cron_apilogs_autodel'] = 'Xóa các API-log hết hạn';
$install_lang['cron']['cron_expadmin_handling'] = 'Xử lý admin quá hạn';

$install_lang['groups']['NukeViet-Fans'] = 'Người hâm mộ';
$install_lang['groups']['NukeViet-Admins'] = 'Người quản lý';
$install_lang['groups']['NukeViet-Programmers'] = 'Lập trình viên';

$install_lang['groups']['NukeViet-Fans-desc'] = 'Nhóm những người hâm mộ hệ thống NukeViet';
$install_lang['groups']['NukeViet-Admins-desc'] = 'Nhóm những người quản lý website xây dựng bằng hệ thống NukeViet';
$install_lang['groups']['NukeViet-Programmers-desc'] = 'Nhóm Lập trình viên hệ thống NukeViet';

$install_lang['vinades_fullname'] = 'Công ty cổ phần phát triển nguồn mở Việt Nam';
$install_lang['vinades_address'] = 'Tầng 6, tòa nhà Sông Đà, 131 Trần Phú, Văn Quán, Hà Đông, Hà Nội';
$install_lang['nukeviet_description'] = 'Chia sẻ thành công, kết nối đam mê';
$install_lang['disable_site_content'] = 'Vì lý do kỹ thuật website tạm ngưng hoạt động. Thành thật xin lỗi các bạn vì sự bất tiện này!';

// Ngôn ngữ dữ liệu cho phần mẫu email
use NukeViet\Template\Email\Cat as EmailCat;
use NukeViet\Template\Email\Tpl as EmailTpl;

$install_lang['emailtemplates'] = [];
$install_lang['emailtemplates']['cats'] = [];
$install_lang['emailtemplates']['cats'][EmailCat::CAT_SYSTEM] = 'Email của hệ thống';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_USER] = 'Email về tài khoản';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_AUTHOR] = 'Email về quản trị';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_MODULE] = 'Email của các module';

$install_lang['emailtemplates']['emails'] = [];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_EMAIL_ACTIVE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Kích hoạt tài khoản qua email',
    's' => 'Thông tin kích hoạt tài khoản',
    'c' => '{$greeting_user}<br /><br />Tài khoản của bạn tại website {$site_name} đang chờ kích hoạt. Để kích hoạt, bạn hãy click vào link dưới đây:<br /><br />URL: <a href="{$link}">{$link}</a><br /><br />Các thông tin cần thiết:<br /><br />Tài khoản: {$username}<br />Email: {$email}<br /><br />Việc kích hoạt tài khoản chỉ có hiệu lực đến {$active_deadline}<br /><br />Đây là thư tự động được gửi đến hòm thư điện tử của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_DELETE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thư thông báo xóa tài khoản',
    's' => 'Thư thông báo xóa tài khoản',
    'c' => '{$greeting_user}<br /><br />Chúng tôi rất lấy làm tiếc thông báo về việc tài khoản của bạn đã bị xóa khỏi website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_2STEP_CODE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Gửi mã dự phòng mới',
    's' => 'Mã dự phòng mới',
    'c' => '{$greeting_user}<br /><br />Mã dự phòng cho tài khoản của bạn tại website {$site_name} đã được thay đổi. Dưới đây là mã dự phòng mới:<br /><br />{foreach from=$new_code item=code}{$code}<br />{/foreach}<br />Bạn chú ý giữ mã dự phòng an toàn. Nếu mất điện thoại và mất cả mã dự phòng bạn sẽ không thể truy cập vào tài khoản của mình được nữa.<br /><br />Đây là thư tự động được gửi đến hòm thư điện tử của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_INFO] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo tài khoản đã được tạo khi thành viên đăng kí thành công tại form',
    's' => 'Tài khoản của bạn đã được tạo',
    'c' => '{$greeting_user}<br /><br />Tài khoản của bạn tại website {$site_name} đã được kích hoạt. Dưới đây là thông tin tài khoản:<br /><br />Bí danh: {$username}<br />Email: {$email}<br /><br />Vui lòng bấm vào đường dẫn dưới đây để đăng nhập:<br />URL: <a href="{$link}">{$link}</a><br /><br />Đây là thư tự động được gửi đến email của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_INFOOAUTH] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo tài khoản đã được tạo khi thành viên đăng kí thành công qua Oauth',
    's' => 'Tài khoản của bạn đã được tạo',
    'c' => '{$greeting_user}<br /><br />Tài khoản của bạn tại website {$site_name} đã được kích hoạt. Để đăng nhập vui lòng truy cập vào trang: <a href="{$link}">{$link}</a> và click vào nút: Đăng nhập bằng {$oauth_name}.<br /><br />Đây là thư tự động được gửi đến email của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_LEADER_ADDED] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo tài khoản được trưởng nhóm khởi tạo',
    's' => 'Tài khoản của bạn đã được tạo',
    'c' => '{$greeting_user}<br /><br />Tài khoản của bạn tại website {$site_name} đã được kích hoạt. Dưới đây là thông tin đăng nhập:<br /><br />URL: <a href="{$link}">{$link}</a><br />Bí danh: {$username}<br />Email: {$email}<br /><br />Đây là thư tự động được gửi đến email của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_ADMIN_ADDED] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo tài khoản được quản trị khởi tạo',
    's' => 'Tài khoản của bạn đã được tạo',
    'c' => '{$greeting_user}<br /><br />Tài khoản của bạn tại website {$site_name} đã được khởi tạo. Dưới đây là thông tin đăng nhập:<br /><br />URL: <a href="{$link}">{$link}</a><br />Bí danh: {$username}<br />Mật khẩu: {$password}<br />{if $pass_reset eq 2}<br />Chú ý: Chúng tôi khuyến cáo bạn nên thay đổi mật khẩu trước khi sử dụng tài khoản.<br />{elseif $pass_reset eq 1}<br />Lưu ý: Bạn cần đổi mật khẩu trước khi sử dụng tài khoản.<br />{/if}<br />Đây là thư tự động được gửi đến hòm thư điện tử của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_SAFE_KEY] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Gửi mã xác minh khi người dùng bật/ tắt chế độ an toàn',
    's' => 'Mã xác minh chế độ an toàn',
    'c' => '{$greeting_user}<br /><br />Bạn đã gửi yêu cầu sử dụng chế độ an toàn tại website {$site_name}. Dưới đây là mã xác minh dùng cho việc kích hoạt hoặc tắt chế độ an toàn:<br /><br /><strong>{$code}</strong><br /><br />Mã xác minh này chỉ có tác dụng bật-tắt chế độ an toàn một lần duy nhất. Sau khi bạn tắt chế độ an toàn, mã xác minh này sẽ vô giá trị.<br /><br />Đây là thư tự động được gửi đến email của bạn từ website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_SELF_EDIT] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo các thay đổi về tài khoản vừa được người dùng thực hiện',
    's' => 'Hồ sơ của bạn đã được cập nhật',
    'c' => '{$greeting_user}<br /><br />Tài khoản của bạn tại website {$site_name} đã được cập nhật {if $send_newvalue}với {$label} mới là <strong>{$newvalue}</strong>{else}{$label} mới{/if}.<br /><br />Đây là thư tự động được gửi đến email của bạn từ website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_ADMIN_EDIT] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo các thay đổi về tài khoản vừa được quản trị thực hiện',
    's' => 'Tài khoản của bạn đã được cập nhật',
    'c' => '{$greeting_user}<br /><br />Tài khoản của bạn tại website {$site_name} đã được cập nhật. Dưới đây là thông tin đăng nhập:<br /><br />URL: <a href="{$link}">{$link}</a><br />Bí danh: {$username}{if not empty($password)}<br />Mật khẩu: {$password}{/if}<br />{if $pass_reset eq 2}<br />Chú ý: Chúng tôi khuyến cáo bạn nên thay đổi mật khẩu trước khi sử dụng tài khoản.<br />{elseif $pass_reset eq 1}<br />Lưu ý: Bạn cần đổi mật khẩu trước khi sử dụng tài khoản.<br />{/if}<br />Đây là thư tự động được gửi đến hòm thư điện tử của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_VERIFY_EMAIL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thư xác nhận thay đổi email tài khoản',
    's' => 'Thông tin kích hoạt thay đổi email',
    'c' => '{$greeting_user}<br /><br />Bạn đã gửi đề nghị thay đổi email của tài khoản người dùng trên website {$site_name}. Để hoàn tất thay đổi này, bạn cần xác nhận email mới bằng cách nhập Mã xác minh dưới đây vào ô tương ứng tại khu vực Sửa thông tin tài khoản:<br /><br />Mã xác minh: <strong>{$code}</strong><br /><br />Mã này hết hạn vào {$deadline}.<br /><br />Đây là thư tự động được gửi đến email của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_GROUP_JOIN] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo có yêu cầu tham gia nhóm',
    's' => 'Yêu cầu tham gia nhóm',
    'c' => 'Xin chào trưởng nhóm <strong>{$group_name}</strong>,<br /><br /><strong>{$full_name}</strong> đã gửi yêu cầu tham gia nhóm <strong>{$group_name}</strong> do bạn đang quản lý. Vui lòng xét duyệt yêu cầu bằng cách nhấn vào <a href="{$link}">liên kết này</a>.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_LOST_ACTIVE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Gửi lại thông tin kích hoạt tài khoản',
    's' => 'Thông tin kích hoạt tài khoản',
    'c' => '{$greeting_user}<br /><br />Tài khoản của bạn tại website {$site_name} đang chờ kích hoạt. Để kích hoạt, bạn hãy click vào link dưới đây:<br /><br />URL: <a href="{$link}">{$link}</a><br />Các thông tin cần thiết:<br />Bí danh: {$username}<br />Email: {$email}<br />Mật khẩu: {$password}<br /><br />Việc kích hoạt tài khoản chỉ có hiệu lực đến {$active_deadline}<br /><br />Đây là thư tự động được gửi đến email của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_LOST_PASS] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Hướng dẫn lấy lại mật khẩu thành viên',
    's' => 'Hướng dẫn tạo lại mật khẩu',
    'c' => '{$greeting_user}<br /><br />Bạn vừa gửi đề nghị thay đổi mật khẩu tài khoản người dùng tại website {$site_name}. Để thay đổi mật khẩu, bạn cần nhập mã xác minh dưới đây vào ô tương ứng tại khu vực thay đổi mật khẩu.<br /><br />Mã xác minh: <strong>{$code}</strong><br /><br />Mã này chỉ được sử dụng một lần và trước thời hạn: {$deadline}.<br /><br />Đây là thư tự động được gửi đến email của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_DELETE] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Thông báo tài khoản quản trị đã bị xóa',
    's' => 'Thông báo từ website {$site_name}',
    'c' => 'Ban quản trị website {$site_name} xin thông báo:<br />Tài khoản quản trị của bạn tại website {$site_name} đã bị xóa vào {$time}{if not empty($note)} vì lý do: {$note}{/if}.<br />Mọi đề nghị, thắc mắc... xin gửi email đến địa chỉ <a href="mailto:{$email}">{$email}</a>{if not empty($username)}<br/><br/>{$sig}<br/><br/>{$username}<br/>{$position}<br/>{$email}{/if}'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_SUSPEND] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Thông báo đình chỉ quản trị site',
    's' => 'Thông báo từ website {$site_name}',
    'c' => 'Ban quản trị website {$site_name} xin thông báo:<br />Tài khoản quản trị của bạn tại website {$site_name} đã bị đình chỉ hoạt động vào {$time} vì lý do: {$note}.<br />Mọi đề nghị, thắc mắc... xin gửi email đến địa chỉ <a href="mailto:{$email}">{$email}</a>{if not empty($username)}<br/><br/>{$sig}<br/><br/>{$username}<br/>{$position}<br/>{$email}{/if}'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_REACTIVE] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Thông báo kích hoạt lại quản trị site',
    's' => 'Thông báo từ website {$site_name}',
    'c' => 'Ban quản trị website {$site_name} xin thông báo:<br />Tài khoản quản trị của bạn tại website {$site_name} đã hoạt động trở lại vào {$time}.<br />Trước đó tài khoản này đã bị đình chỉ hoạt động vì lý do: {$note}{if not empty($username)}<br/><br/>{$sig}<br/><br/>{$username}<br/>{$position}<br/>{$email}{/if}'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTO_ERROR_REPORT] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_SYSTEM,
    't' => 'Email tự động thông báo lỗi',
    's' => 'Cảnh báo từ website {$site_name}',
    'c' => 'Hệ thống đã nhận được một số thông báo. Bạn hãy mở file đính kèm để xem chi tiết'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_R2S] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo xác thực hai bước đã gỡ thành công',
    's' => 'Xác thực 2 bước đã tắt',
    'c' => '{$greeting_user}<br /><br />Theo yêu cầu của bạn, chúng tôi đã tắt tính năng Xác thực 2 bước cho tài khoản của bạn tại website {$site_name}.<br /><br />Đây là thư tự động được gửi đến hòm thư điện tử của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_R2S_REQUEST] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Hướng dẫn tắt xác thực hai bước khi quên mã',
    's' => 'Thông tin tắt xác thực 2 bước',
    'c' => '{$greeting_user}<br /><br />Chúng tôi vừa nhận được yêu cầu tắt xác thực 2 bước cho tài khoản của bạn tại website {$site_name}. Nếu bạn là người gửi yêu cầu này, hãy sử dụng Mã xác minh dưới đây để tiến hành tắt:<br /><br />Mã xác minh: <strong>{$code}</strong><br /><br />Đây là thư tự động được gửi đến hòm thư điện tử của bạn từ website {$site_name}. Nếu bạn không hiểu gì về nội dung bức thư này, đơn giản hãy xóa nó đi.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_LEADER_ADD] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo oauth được thêm vào tài khoản bởi trưởng nhóm',
    's' => 'Thông báo bảo mật',
    'c' => '{$greeting_user}<br /><br />Chúng tôi thông tin đến bạn là tài khoản bên thứ ba <strong>{$oauth_name}</strong> vừa được kết nối với tài khoản <strong>{$username}</strong> của bạn bởi trưởng nhóm.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Quản lý tài khoản bên thứ ba</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_SELF_ADD] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo oauth được thêm vào tài khoản bởi chính người dùng',
    's' => 'Thông báo bảo mật',
    'c' => '{$greeting_user}<br /><br />Tài khoản bên thứ ba <strong>{$oauth_name}</strong> vừa được kết nối với tài khoản <strong>{$username}</strong> của bạn. Nếu đây không phải là chủ ý của bạn, vui lòng nhanh chóng xóa nó khỏi tài khoản của mình bằng cách truy cập vào khu vực quản lý tài khoản bên thứ ba.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Quản lý tài khoản bên thứ ba</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_LEADER_DEL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo oauth được xóa khỏi tài khoản bởi trưởng nhóm',
    's' => 'Thông báo bảo mật',
    'c' => '{$greeting_user}<br /><br />Chúng tôi thông tin đến bạn là tài khoản bên thứ ba <strong>{$oauth_name}</strong> vừa được ngắt kết nối khỏi tài khoản <strong>{$username}</strong> của bạn bởi trưởng nhóm.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Quản lý tài khoản bên thứ ba</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_SELF_DEL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Thông báo oauth được xóa khỏi tài khoản bởi chính người dùng',
    's' => 'Thông báo bảo mật',
    'c' => '{$greeting_user}<br /><br />Tài khoản bên thứ ba <strong>{$oauth_name}</strong> vừa được ngắt kết nối khỏi tài khoản <strong>{$username}</strong> của bạn. Nếu đây không phải là chủ ý của bạn, vui lòng nhanh chóng liên hệ với quản trị site để được giúp đỡ.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Quản lý tài khoản bên thứ ba</a>'
];

$menu_rows_lev0['about'] = [
    'title' => $install_lang['modules']['about'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=about',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['news'] = [
    'title' => $install_lang['modules']['news'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=news',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['users'] = [
    'title' => $install_lang['modules']['users'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['statistics'] = [
    'title' => $install_lang['modules']['statistics'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=statistics',
    'groups_view' => '2',
    'op' => ''
];
$menu_rows_lev0['voting'] = [
    'title' => $install_lang['modules']['voting'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=voting',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['seek'] = [
    'title' => $install_lang['modules']['seek'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=seek',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['contact'] = [
    'title' => $install_lang['modules']['contact'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=contact',
    'groups_view' => '6',
    'op' => ''
];

$menu_rows_lev1['about'] = [];
$menu_rows_lev1['about'][] = [
    'title' => 'Giới thiệu về NukeViet',
    'link' => NV_BASE_SITEURL . 'index.php?language=vi&nv=about&op=gioi-thieu-ve-nukeviet' . $global_config['rewrite_exturl'],
    'groups_view' => '6',
    'op' => 'gioi-thieu-ve-nukeviet'
];
$menu_rows_lev1['about'][] = [
    'title' => 'Giới thiệu về NukeViet CMS',
    'link' => NV_BASE_SITEURL . 'index.php?language=vi&nv=about&op=gioi-thieu-ve-nukeviet-cms' . $global_config['rewrite_exturl'],
    'groups_view' => '6',
    'op' => 'gioi-thieu-ve-nukeviet-cms'
];
$menu_rows_lev1['about'][] = [
    'title' => 'Logo và tên gọi NukeViet',
    'link' => NV_BASE_SITEURL . 'index.php?language=vi&nv=about&op=logo-va-ten-goi-nukeviet' . $global_config['rewrite_exturl'],
    'groups_view' => '6',
    'op' => 'logo-va-ten-goi-nukeviet'
];
$menu_rows_lev1['about'][] = [
    'title' => 'Giấy phép sử dụng NukeViet',
    'link' => NV_BASE_SITEURL . 'index.php?language=vi&nv=about&op=giay-phep-su-dung-nukeviet' . $global_config['rewrite_exturl'],
    'groups_view' => '6,7',
    'op' => 'giay-phep-su-dung-nukeviet'
];
$menu_rows_lev1['about'][] = [
    'title' => 'Những tính năng của NukeViet CMS 4.0',
    'link' => NV_BASE_SITEURL . 'index.php?language=vi&nv=about&op=nhung-tinh-nang-cua-nukeviet-cms-4-0' . $global_config['rewrite_exturl'],
    'groups_view' => '6',
    'op' => 'nhung-tinh-nang-cua-nukeviet-cms-4-0'
];
$menu_rows_lev1['about'][] = [
    'title' => 'Yêu cầu sử dụng NukeViet 4',
    'link' => NV_BASE_SITEURL . 'index.php?language=vi&nv=about&op=Yeu-cau-su-dung-NukeViet-4' . $global_config['rewrite_exturl'],
    'groups_view' => '6',
    'op' => 'Yeu-cau-su-dung-NukeViet-4'
];
$menu_rows_lev1['about'][] = [
    'title' => 'Giới thiệu về Công ty cổ phần phát triển nguồn mở Việt Nam',
    'link' => NV_BASE_SITEURL . 'index.php?language=vi&nv=about&op=gioi-thieu-ve-cong-ty-co-phan-phat-trien-nguon-mo-viet-nam' . $global_config['rewrite_exturl'],
    'groups_view' => '6',
    'op' => 'gioi-thieu-ve-cong-ty-co-phan-phat-trien-nguon-mo-viet-nam'
];
$menu_rows_lev1['about'][] = [
    'title' => 'Ủng hộ, hỗ trợ và tham gia phát triển NukeViet',
    'link' => NV_BASE_SITEURL . 'index.php?language=vi&nv=about&op=ung-ho-ho-tro-va-tham-gia-phat-trien-nukeviet' . $global_config['rewrite_exturl'],
    'groups_view' => '6',
    'op' => 'ung-ho-ho-tro-va-tham-gia-phat-trien-nukeviet'
];

$menu_rows_lev1['news'] = [];
$menu_rows_lev1['news'][] = [
    'title' => 'Đối tác',
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=news&op=Doi-tac',
    'groups_view' => '6',
    'op' => 'Doi-tac'
];
$menu_rows_lev1['news'][] = [
    'title' => 'Tuyển dụng',
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=news&op=Tuyen-dung',
    'groups_view' => '6',
    'op' => 'Tuyen-dung'
];
$menu_rows_lev1['news'][] = [
    'title' => 'Rss',
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=news&op=rss',
    'groups_view' => '6',
    'op' => 'rss'
];
$menu_rows_lev1['news'][] = [
    'title' => 'Quản lý bài viết',
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=news&op=content',
    'groups_view' => '6',
    'op' => 'content'
];
$menu_rows_lev1['news'][] = [
    'title' => 'Tìm kiếm',
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=news&op=search',
    'groups_view' => '6',
    'op' => 'search'
];
$menu_rows_lev1['news'][] = [
    'title' => 'Tin tức',
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=news&op=Tin-tuc',
    'groups_view' => '6',
    'op' => 'Tin-tuc'
];
$menu_rows_lev1['news'][] = [
    'title' => 'Sản phẩm',
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=news&op=San-pham',
    'groups_view' => '6',
    'op' => 'San-pham'
];
