<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

namespace NukeViet\Template\Email;

/**
 * @author VINADES.,JSC <contact@vinades.vn>
 */
class Tpl
{
    /**
     * @var integer Gửi thông tin kích hoạt khi đăng kí hoặc quản trị gửi lại
     */
    public const E_USER_EMAIL_ACTIVE = 1;

    /**
     * @var integer Trưởng nhóm xóa tài khoản, quản trị xóa tài khoản
     */
    public const E_USER_DELETE = 2;

    /**
     * @var integer Gửi mã xác thực mới cho user khi quản trị tạo lại
     */
    public const E_USER_NEW_2STEP_CODE = 3;

    /**
     * @var integer Đăng kí thủ công qua form thành công
     */
    public const E_USER_NEW_INFO = 4;

    /**
     * @var integer Đăng kí thành công qua Oauth
     */
    public const E_USER_NEW_INFOOAUTH = 5;

    /**
     * @var integer Trưởng nhóm kích hoạt tài khoản thành viên
     */
    public const E_USER_LEADER_ADDED = 6;

    /**
     * @var integer Quản trị tạo tài khoản thành viên
     */
    public const E_USER_ADMIN_ADDED = 7;

    /**
     * @var integer Gửi mã xác nhận khi bật tắt chế độ an toàn
     */
    public const E_USER_SAFE_KEY = 8;

    /**
     * @var integer Thành viên tự chỉnh sửa thông tin như username, email, mật khẩu
     */
    public const E_USER_SELF_EDIT = 9;

    /**
     * @var integer Gửi lại thông tin cho thành viên khi quản trị sửa
     */
    public const E_USER_ADMIN_EDIT = 10;

    /**
     * @var integer Gửi mã xác minh khi người dùng đổi email
     */
    public const E_USER_VERIFY_EMAIL = 11;

    /**
     * @var integer Gửi thông báo cho trưởng nhóm khi người dùng yêu cầu tham gia nhóm
     */
    public const E_USER_GROUP_JOIN = 12;

    /**
     * @var integer Gửi mã xác minh khi người dùng lấy lại link kích hoạt
     */
    public const E_USER_LOST_ACTIVE = 13;

    /**
     * @var integer Gửi mã xác minh khi người dùng quên mật khẩu
     */
    public const E_USER_LOST_PASS = 14;

    /**
     * @var integer Thông báo gỡ xác thực hai bước khi quên ứng dụng và mã dự phòng
     */
    public const E_USER_R2S = 15;

    /**
     * @var integer Gửi mã xác minh gỡ xác thực hai bước khi quên ứng dụng và mã dự phòng
     */
    public const E_USER_R2S_REQUEST = 16;

    /**
     * @var integer Thông báo oauth được thêm vào tài khoản bởi trưởng nhóm
     */
    public const E_USER_OAUTH_LEADER_ADD = 17;

    /**
     * @var integer Thông báo oauth được thêm vào tài khoản bởi chính người dùng
     */
    public const E_USER_OAUTH_SELF_ADD = 18;

    /**
     * @var integer Thông báo oauth được xóa khỏi tài khoản bởi trưởng nhóm
     */
    public const E_USER_OAUTH_LEADER_DEL = 19;

    /**
     * @var integer Thông báo oauth được xóa khỏi tài khoản bởi quản trị
     */
    public const E_USER_OAUTH_ADMIN_DEL = 20;

    /**
     * @var integer Thông báo oauth được xóa khỏi tài khoản bởi chính người dùng
     */
    public const E_USER_OAUTH_SELF_DEL = 21;

    /**
     * @var integer Gửi mã xác minh email khi đăng nhập qua Oauth mà email trùng với tài khoản đã có
     */
    public const E_USER_OAUTH_VERIFY_EMAIL = 22;

    /**
     * @var integer Thông báo đến người dùng khi quản trị xóa tất cả Oauth của họ
     */
    public const E_USER_OAUTH_TRUNCATE = 23;

    /**
     * @var integer Email thông báo cho người dùng khi quản trị kích hoạt tài khoản
     */
    public const E_USER_ADMIN_ACTIVE = 24;

    /**
     * @var integer Email yêu cầu người dùng thay đổi mật khẩu
     */
    public const E_USER_REQUEST_RESET_PASS = 25;

    /**
     * @var integer Thông báo đến người dùng xác thực hai bước đã được quản trị tắt
     */
    public const E_USER_2STEPOFF_BYADMIN = 26;

    /**
     * @var integer Thông báo bật xác thực hai bước cho tài khoản thành viên
     */
    public const E_USER_2STEPON = 27;

    /**
     * @var integer Thông báo tắt xác thực hai bước cho tài khoản thành viên
     */
    public const E_USER_2STEPOFF = 28;

    /**
     * @var integer Thông báo tạo lại mã dự phòng xác thực hai bước cho tài khoản thành viên
     */
    public const E_USER_2STEPRENEW = 29;

    /**
     * @var integer Thông báo xóa tài khoản quản trị
     */
    public const E_AUTHOR_DELETE = 30;

    /**
     * @var integer Thông báo đình chỉ tài khoản quản trị
     */
    public const E_AUTHOR_SUSPEND = 31;

    /**
     * @var integer Thông báo kích hoạt lại tài khoản quản trị
     */
    public const E_AUTHOR_REACTIVE = 32;

    /**
     * @var integer Thông báo kích hoạt lại tài khoản quản trị
     */
    public const E_AUTHOR_2STEP_ADD = 33;

    /**
     * @var integer Thông báo kích hoạt lại tài khoản quản trị
     */
    public const E_AUTHOR_2STEP_TRUNCATE = 34;

    /**
     * @var integer Thông báo kích hoạt lại tài khoản quản trị
     */
    public const E_AUTHOR_2STEP_DEL = 35;

    /**
     * @var integer Gửi email thông báo lỗi tự động cho webmaster
     */
    public const E_AUTO_ERROR_REPORT = 36;

    /**
     * @var integer Email gửi thử nghiệm để kiểm tra cấu hình gửi mail
     */
    public const E_EMAIL_CONFIG_TEST = 37;

    /**
     * @var integer ID mẫu email lớn nhất của hệ thống
     */
    public const MAX_SYS_TPL = 37;
}
