<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC <contact@vinades.vn>';
$lang_translator['createdate'] = '04/03/2010, 15:22';
$lang_translator['copyright'] = '@Copyright (C) 2009-2021 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_global';

$lang_global['locale'] = 'en_US.utf8';
$lang_global['Content_Language'] = 'en';
$lang_global['LanguageName'] = 'english';
$lang_global['site_info'] = 'Notifications from the system';
$lang_global['welcome'] = 'Welcome to visit website of %s';
$lang_global['disable_site_title'] = 'Website suspended';
$lang_global['disable_site_content'] = 'Our site is temporarily closed for maintenance. Please come back later. Thank you!';
$lang_global['closed_site_reopening_time'] = 'Expected re-operation time';
$lang_global['Home'] = 'Home';
$lang_global['go_homepage'] = 'Back to home page';
$lang_global['error_404_title'] = 'Connection Error 404';
$lang_global['error_404_content'] = 'Error 404: The page you tried to access does not exist';
$lang_global['error_login_title'] = 'Login system is interrupted';
$lang_global['error_login_content'] = 'We are unable to log you into the system at this time. Please try closing and reopening your browser first. If that doesn\'t work, try clearing your browser cookies and try again. If the problem persists, please contact support for assistance. We sincerely apologize for the inconvenience!';
$lang_global['error_layout_title'] = 'Interface processing Error';
$lang_global['error_layout_content'] = 'Error: interface does not exist! Please contact the site administrator about this';
$lang_global['logout'] = 'Logout';
$lang_global['admin_logout_title'] = 'Leave Administration';
$lang_global['admin_logout_ok'] = 'All login information was eraser. You\'ve log out adminitrator account';
$lang_global['admin_logout_question'] = 'Are you sure you want to log out of your administrator account';
$lang_global['admin_ipincorrect'] = 'You are logged by IP: %s. We are sorry that this IP is not allowed to enter the site administration!';
$lang_global['ok'] = 'OK';
$lang_global['confirm'] = 'Confirm';
$lang_global['download'] = 'Download';
$lang_global['print'] = 'Print';
$lang_global['manage'] = 'Manage';
$lang_global['cancel'] = 'Cancel';
$lang_global['reset'] = 'Reset';
$lang_global['fail'] = 'Fail';
$lang_global['firewallsystem'] = 'Administrators Section';
$lang_global['firewallincorrect'] = 'The firewall system has blocked your access as an administrator!';
$lang_global['username_empty'] = 'Username has not been declared';
$lang_global['usernamelong'] = 'Username too length. Limit %1$d characters';
$lang_global['usernameadjective'] = 'Username too short. Minimum %1$d characters';
$lang_global['unick_type_1'] = 'Account used only numbers';
$lang_global['unick_type_2'] = 'Account used only numbers and letters';
$lang_global['unick_type_3'] = 'Account used only numbers, letters and following characters between: dash, underline, space';
$lang_global['unick_type_4'] = 'Account used only Unicode, no special characters';
$lang_global['username_rule_limit'] = 'Invalid Username: %1$s and %2$d from to %3$d characters';
$lang_global['username_rule_nolimit'] = 'Username must be between %1$d to %2$d characters';
$lang_global['password_empty'] = 'Password has not been declared';
$lang_global['passwordlong'] = 'Password too length. limit %1$d characters';
$lang_global['passwordadjective'] = 'Password too short. Minimum %1$d characters';
$lang_global['passwordsincorrect'] = 'The two entered passwords are not identical. Please declare again';
$lang_global['re_password_empty'] = 'You do not write your password into the second password box';
$lang_global['upass_type_1'] = 'Password should combin number and letter';
$lang_global['upass_type_2'] = 'Password should combin number and letter, have special characters';
$lang_global['upass_type_3'] = 'Password should combin number and letter, have uppercase letter';
$lang_global['upass_type_4'] = 'Password should combin number and letter, have uppercase letter and special characters';
$lang_global['upass_type_simple'] = 'Password is using easily guessed password, enter the password more complex';
$lang_global['password_rule_limit'] = 'Invalid Password: %1$s and %2$d from to %3$d characters';
$lang_global['password_rule_nolimit'] = 'Password must be between %1$d to %2$d characters';
$lang_global['securitycodeincorrect'] = 'Security Code is invalid';
$lang_global['securitycodeincorrect1'] = 'Unverified i\'m not a robot, please verify again!';
$lang_global['securitycodeincorrect2'] = 'Unverified Verify you are human. Please verify again';
$lang_global['loginincorrect'] = 'No account found matching the information you entered';
$lang_global['admin_loginsuccessfully'] = 'You have successfully logged. The system will transfer you to the site administration area';
$lang_global['incorrect_password'] = 'Password is incorrect';
$lang_global['userlogin_blocked'] = 'You are logged after %s failure, temporarily locking system login to %s';
$lang_global['2teplogin_totppin_label'] = 'Enter the code provided by the authenticator app';
$lang_global['2teplogin_totppin_placeholder'] = 'Enter the 6-digit code';
$lang_global['2teplogin_code_label'] = 'Enter one of the backup codes you received';
$lang_global['2teplogin_code_placeholder'] = 'Enter the 8-digit code';
$lang_global['2teplogin_other_menthod'] = 'Another method';
$lang_global['2teplogin_error_opt'] = 'Confirmation code is incorrect, please re-enter';
$lang_global['2teplogin_error_backup'] = 'Backup codes are incorrect, please re-enter';
$lang_global['2teplogin_require'] = 'You must enable two-factor authentication can login. Click here to activate this function';
$lang_global['2fa_recovery'] = 'Start 2FA account recovery';
$lang_global['2fa_method_app'] = 'Use code from app';
$lang_global['2fa_method_code'] = 'Use backup code';
$lang_global['2fa_method_key'] = 'Use passkey or security key';
$lang_global['2fa_method_key1'] = 'Use passkey or security key';
$lang_global['2fa_method_key2'] = 'When you are ready, click the button below to verify';
$lang_global['2fa_problems'] = 'Having problems? Try some of the options below';
$lang_global['remove2step_info'] = 'Click here to turn off 2-step verification';
$lang_global['memory_time_usage'] = 'Memory: %1$s. Processing time: %2$s seconds';
$lang_global['for_admin'] = 'For Admin';
$lang_global['admin_account'] = 'Admin Account';
$lang_global['admin_view'] = 'Your admin account';
$lang_global['admin_page'] = 'Administration';
$lang_global['admin_module_sector'] = 'Module Management';
$lang_global['adminlogin'] = 'Login to Administration';
$lang_global['module_for_admin'] = 'We are Sorry but this section of our site is for <em>Administrators Only.</em>';
$lang_global['in_groups'] = 'Members Groups';
$lang_global['username'] = 'Username';
$lang_global['username_email'] = 'Login name';
$lang_global['password'] = 'Password';
$lang_global['password2'] = 'Repeat password';
$lang_global['captcharefresh'] = 'Refresh';
$lang_global['securitycode'] = 'Security Code';
$lang_global['securitycode1'] = 'Please verify that you are not a robot';
$lang_global['loginsubmit'] = 'Login';
$lang_global['register'] = 'Register';
$lang_global['lostpass'] = 'Forgot password';
$lang_global['logininfo'] = 'All tools on this site will be available when you\'re logged in';
$lang_global['adminlogininfo'] = 'Please use a valid username and password to login to the Control Panel';
$lang_global['site_rss'] = 'RSS - NEWS';
$lang_global['copyright'] = '&copy; Copyright %s. All right reserved';
$lang_global['phonenumber'] = 'Phone';
$lang_global['address'] = 'Address';
$lang_global['full_name'] = 'Full name';
$lang_global['first_name'] = 'First name';
$lang_global['last_name'] = 'last name';
$lang_global['email'] = 'Email';
$lang_global['email_empty'] = 'Email has not been declared';
$lang_global['email_incorrect'] = 'Email is invalid';
$lang_global['regdate'] = 'Register date';
$lang_global['online'] = 'Online';
$lang_global['hits'] = 'Total';
$lang_global['viewstats'] = 'View counter statistics';
$lang_global['last_login'] = 'Last login';
$lang_global['current_login'] = 'This session';
$lang_global['your_account'] = 'Account';
$lang_global['sec'] = 'second';
$lang_global['min'] = 'Minute';
$lang_global['hour'] = 'Hour';
$lang_global['day'] = 'Days';
$lang_global['month'] = 'Month';
$lang_global['year'] = 'Year';
$lang_global['plural_sec'] = 'second,seconds';
$lang_global['plural_min'] = 'minute,minutes';
$lang_global['plural_hour'] = 'hour,hours';
$lang_global['plural_day'] = 'day,days';
$lang_global['plural_month'] = 'month,months';
$lang_global['plural_year'] = 'year,years';
$lang_global['today'] = 'Today';
$lang_global['current_month'] = 'This month';
$lang_global['nojs'] = 'Your internet browser has disabled JavaScript.<br />Website only work when it enable.<br />To see how to enable JavaScript, Please <a >click here</a>!';
$lang_global['chromeframe'] = 'You are using an <strong>outdated and insecure</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to be able to use the full features of the website.';
$lang_global['sun'] = 'SUN';
$lang_global['mon'] = 'MON';
$lang_global['tue'] = 'TUE';
$lang_global['wed'] = 'WED';
$lang_global['thu'] = 'THU';
$lang_global['fri'] = 'FRI';
$lang_global['sat'] = 'SAT';
$lang_global['sunday'] = 'Sunday';
$lang_global['monday'] = 'Monday';
$lang_global['tuesday'] = 'Tuesday';
$lang_global['wednesday'] = 'Wednesday';
$lang_global['thursday'] = 'Thursday';
$lang_global['friday'] = 'Friday';
$lang_global['saturday'] = 'Saturday';
$lang_global['january'] = 'January';
$lang_global['february'] = 'February';
$lang_global['march'] = 'March';
$lang_global['april'] = 'April';
$lang_global['may'] = 'May';
$lang_global['june'] = 'June';
$lang_global['july'] = 'July';
$lang_global['august'] = 'August';
$lang_global['september'] = 'September';
$lang_global['october'] = 'October';
$lang_global['november'] = 'November';
$lang_global['december'] = 'December';
$lang_global['jan'] = 'Jan';
$lang_global['feb'] = 'Feb';
$lang_global['mar'] = 'Mar';
$lang_global['apr'] = 'Apr';
$lang_global['may2'] = 'May';
$lang_global['jun'] = 'Jun';
$lang_global['jul'] = 'Jul';
$lang_global['aug'] = 'Aug';
$lang_global['sep'] = 'Sep';
$lang_global['oct'] = 'Oct';
$lang_global['nov'] = 'Nov';
$lang_global['dec'] = 'Dec';
$lang_global['lang_vi'] = 'Vietnamese';
$lang_global['lang_en'] = 'English';
$lang_global['option'] = 'Option';
$lang_global['value'] = 'value';
$lang_global['reviews'] = 'Reviews';
$lang_global['add'] = 'Add';
$lang_global['edit'] = 'Edit';
$lang_global['delete'] = 'Delete';
$lang_global['disable'] = 'Disable';
$lang_global['activate'] = 'Activate';
$lang_global['check'] = 'Check';
$lang_global['active'] = 'Active';
$lang_global['save'] = 'Save';
$lang_global['save_success'] = 'The changes have been saved';
$lang_global['submit'] = 'Submit';
$lang_global['empty'] = 'Empty';
$lang_global['recreate'] = 'Reinstall';
$lang_global['error_directory_does_not_exist'] = 'Directory %s does not exist';
$lang_global['error_directory_can_not_write'] = 'Directory %s is not writable';
$lang_global['error_create_directories_name_invalid'] = 'The directory nam %s is not accepted';
$lang_global['error_create_directories_failed'] = 'Unable to create directory %s for unknown reason';
$lang_global['error_create_directories_name_used'] = 'Directory %s already exists';
$lang_global['directory_was_created'] = 'Directory %s was created';
$lang_global['error_non_existent_file'] = 'Does not exist file or directory %s';
$lang_global['error_delete_forbidden'] = 'File or directory %s are forbidden to delete';
$lang_global['error_delete_subdirectories_not_empty'] = 'Directory %s has file or subdirectory.Please delete them first';
$lang_global['error_delete_subdirectories_failed'] = 'System can\'t delete directory %s because some unknown reason';
$lang_global['error_delete_failed'] = 'System can\'t delete file %s by unknown reason';
$lang_global['file_deleted'] = 'File %s deleted';
$lang_global['directory_deleted'] = 'The directory %s was deleted';
$lang_global['error_rename_forbidden'] = 'File or Directory %s can not be renamed';
$lang_global['error_rename_file_exists'] = 'File or Directory %s already exist';
$lang_global['error_rename_directories_invalid'] = 'New directory name %s is invalid';
$lang_global['error_rename_file_invalid'] = 'New file name %s is not accepted';
$lang_global['error_rename_extension_changed'] = 'File extension %1$s does not match old file extension %2$s';
$lang_global['error_rename_failed'] = 'System can\'t rename directory or file %1$s to %2$s';
$lang_global['file_has_been_renamed'] = 'System has renamed directory or file %1$s to %2$s';
$lang_global['yes'] = 'Yes';
$lang_global['no'] = 'No';
$lang_global['unlimited'] = 'unlimited';
$lang_global['status'] = 'Status';
$lang_global['actions'] = 'Action';
$lang_global['select_actions'] = 'Select action';
$lang_global['never'] = 'Never';
$lang_global['page'] = 'Page';
$lang_global['pageprev'] = 'Previous page';
$lang_global['pagenext'] = 'Next page';
$lang_global['langinterface'] = 'Interface language';
$lang_global['langdata'] = 'Data language';
$lang_global['langsite'] = 'Select language';
$lang_global['link'] = 'Link';
$lang_global['theme'] = 'Interface';
$lang_global['selecttheme'] = 'Select interface';
$lang_global['current_theme'] = 'Current interface';
$lang_global['default_theme'] = 'By site default';
$lang_global['detail'] = 'Details';
$lang_global['show_picture'] = 'View picture';
$lang_global['flood_page_title'] = 'please wait...';
$lang_global['flood_info1'] = 'Access denied';
$lang_global['flood_info2'] = 'please wait';
$lang_global['flood_captcha_pass'] = 'You are not a robot? Confirm to continue access';
$lang_global['flood_continue_access'] = 'Continue access';
$lang_global['error_info_caption'] = 'Notifications from the system';
$lang_global['error_error'] = 'Serious error';
$lang_global['error_warning'] = 'Warning';
$lang_global['error_notice'] = 'Attention';
$lang_global['error_sendmail'] = 'Error: system not send mail, Please contact administrator';
$lang_global['error_sendmail_admin'] = 'Error: The system can not send email, please contact the site administrator to reconfigure the mail sending function';
$lang_global['search'] = 'Search';
$lang_global['search_all'] = 'Search the entire site...';
$lang_global['drag_block'] = 'Enable drag and drop block';
$lang_global['no_drag_block'] = 'Disable drag and drop block';
$lang_global['blocks_saved'] = 'Configuration has been saved !';
$lang_global['blocks_saved_error'] = 'Error: Unable to save configuration';
$lang_global['users'] = 'Members';
$lang_global['bots'] = 'Search engine';
$lang_global['guests'] = 'Guest';
$lang_global['total'] = 'Total';
$lang_global['type_email'] = 'Enter your email address...';
$lang_global['add_block'] = 'Add blocks in this area';
$lang_global['edit_block'] = 'Edit';
$lang_global['delete_block'] = 'Delete';
$lang_global['act_block'] = 'Activate. Click to deactivate';
$lang_global['deact_block'] = 'Deactivate. Click to activate';
$lang_global['outgroup_block'] = 'Create similar block whith display area is the current page';
$lang_global['block_delete_confirm'] = 'Note: Deleting this block results in its deletion in all the different display areas. If you just want the block not to display on this page, click on the Create similar block whith display area is the current page, then delete the newly created block. Are you sure to do this?';
$lang_global['block_outgroup_confirm'] = 'If this block is displayed in more than one area, this will result in the removal of the current area from the display areas of the block, and create a new block with the display area as the currently viewed page. Are you sure to do this?';
$lang_global['wellcome'] = 'Wellcome';
$lang_global['changpass'] = 'Change password';
$lang_global['edituser'] = 'Account';
$lang_global['browse_file'] = 'Browse';
$lang_global['browse_image'] = 'Browse';
$lang_global['openid_login'] = 'Login with';
$lang_global['passkey_login'] = 'Sign in with a passkey';
$lang_global['breakcrum'] = 'You are here:';
$lang_global['admin_access_denied1'] = 'Sorry! The system does not allow the connection of the administrators at this time';
$lang_global['admin_access_denied2'] = 'Sorry. The connection of module administrators is not allowed at this time';
$lang_global['error_uploadNameEmpty'] = 'Error: The uploaded file name is not defined';
$lang_global['error_uploadSizeEmpty'] = 'Error: uploaded file size undefined';
$lang_global['error_upload_ini_size'] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
$lang_global['error_upload_form_size'] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
$lang_global['error_upload_partial'] = 'The uploaded file was only partially uploaded';
$lang_global['error_upload_no_file'] = 'No file was uploaded';
$lang_global['error_upload_no_tmp_dir'] = 'Missing a temporary folder';
$lang_global['error_upload_cant_write'] = 'Failed to write file to disk';
$lang_global['error_upload_extension'] = 'Error: The uploaded file is blocked because the extension is not valid';
$lang_global['error_upload_unknown'] = 'Unknown upload error';
$lang_global['error_upload_type_not_allowed'] = 'Files of this type are not allowed';
$lang_global['error_upload_mime_not_recognize'] = 'System does not recognize the mime type of uploaded file';
$lang_global['error_upload_max_user_size'] = 'The file exceeds the maximum size allowed. Maximum size is %s';
$lang_global['error_upload_not_image'] = 'The file is not a known image format';
$lang_global['error_upload_image_failed'] = 'Error: The uploaded image is not valid';
$lang_global['error_upload_image_width'] = 'The image is not allowed because the width is greater than the maximum of %d pixels';
$lang_global['error_upload_image_height'] = 'Error: Image size exceeds the maximum. Maximum height is %d pixels';
$lang_global['error_upload_forbidden'] = 'Error: The folder containing the file upload is not defined';
$lang_global['error_upload_writable'] = 'Directory %s is not writable';
$lang_global['error_upload_urlfile'] = 'The URL is not valid and cannot be loaded';
$lang_global['error_upload_url_notfound'] = 'The url was not found';
$lang_global['error_upload_over_capacity'] = 'Error: Unable to upload because the website has reached the capacity';
$lang_global['error_upload_over_capacity1'] = 'You can\'t work because the website has reached the capacity';
$lang_global['theme_type_r'] = 'Responsive';
$lang_global['theme_type_d'] = 'Desktop';
$lang_global['theme_type_m'] = 'Mobile';
$lang_global['theme_type_chose'] = 'Click to switch to %s mode';
$lang_global['theme_type_chose2'] = 'Switch to Interface';
$lang_global['theme_type_select'] = 'Interface mode';
$lang_global['ftp_err_connect'] = 'Error: Can not connect to FTP server';
$lang_global['ftp_err_login'] = 'Error: Logon failure';
$lang_global['ftp_err_enable'] = 'Error: The server does not support FTP';
$lang_global['ftp_err_passive_on'] = 'Error: Can not activate Passive mode';
$lang_global['ftp_err_rawlist'] = 'Error: Unable to determine the directory list';
$lang_global['ftp_err_list_detail'] = 'Error: Unrecognized parameter files, folders';
$lang_global['ftp_err_fget'] = 'Error: Can not read the text file';
$lang_global['ftp_err_NVbuffet'] = 'Error: Missing class NVbuffer';
$lang_global['groups_view'] = 'Group viewed';
$lang_global['level1'] = 'Super administrator';
$lang_global['level2'] = 'General administrator';
$lang_global['level3'] = 'Module administrator';
$lang_global['level4'] = 'Member';
$lang_global['level5'] = 'Guest';
$lang_global['level6'] = 'All';
$lang_global['level7'] = 'New member';
$lang_global['msgbeforeunload'] = 'Are you sure you go to other sites, if done the data will not be stored';
$lang_global['timeoutsess_nouser'] = 'You did not use the site';
$lang_global['timeoutsess_click'] = 'Click here to remain logged';
$lang_global['timeoutsess_timeout'] = 'Timeout';
$lang_global['unknown'] = 'Unknown';
$lang_global['joinnow'] = 'Join Now';
$lang_global['contactUs'] = 'Contact Us';
$lang_global['company_name'] = 'Company name';
$lang_global['company_sortname'] = 'Sort name';
$lang_global['company_regcode'] = 'Business registration number';
$lang_global['company_regcode2'] = 'BN';
$lang_global['company_regplace'] = 'Place of registration';
$lang_global['company_licensenumber'] = 'License number';
$lang_global['company_responsibility'] = 'Responsibility';
$lang_global['company_address'] = 'Address';
$lang_global['company_phone'] = 'Phone';
$lang_global['company_fax'] = 'Fax';
$lang_global['company_email'] = 'Email';
$lang_global['company_website'] = 'Website';
$lang_global['siteterms'] = 'Terms & Conditions';
$lang_global['siteterms_url'] = 'Terms & Conditions URL';
$lang_global['copyright_by'] = 'Copyright by';
$lang_global['copyright_url'] = 'Copyright by URL';
$lang_global['powered_by'] = 'Powered by';
$lang_global['design_by'] = 'Design by';
$lang_global['design_url'] = 'Design by URL';
$lang_global['signin'] = 'Sign In';
$lang_global['feedback'] = 'Feedback';
$lang_global['required'] = 'Note: You need to declare all the boxes marked with an asterisk <span class="text-danger">(*)</span>.';
$lang_global['required_invalid'] = 'This field is required';
$lang_global['cookie_notice'] = 'We are using cookies to give you the best experience on our website. By continuing to browse, you are agreeing to our <a href="%s">Cookie Policy</a>.';
$lang_global['on'] = 'On';
$lang_global['off'] = 'Off';
$lang_global['close'] = 'Đóng';
$lang_global['system'] = 'Hệ thống';
$lang_global['or'] = 'Or';
$lang_global['limit_user_number'] = 'Your site is limited to %s users. To add a new user, please contact your system administrator';
$lang_global['limit_admin_number'] = 'Your site is limited to %s admins, to add a new admin, please contact your system administrator';
$lang_global['2teplogin'] = 'Two-factor authentication';
$lang_global['indefinitely'] = 'Indefinitely';
$lang_global['all'] = 'All';
$lang_global['unviewed'] = 'Unviewed';
$lang_global['favorite'] = 'Favorite';
$lang_global['viewall'] = 'View all';
$lang_global['view'] = 'View';
$lang_global['mark_read_all'] = 'Mark all as read';
$lang_global['refresh'] = 'Refresh';
$lang_global['inform_notifications'] = 'Notifications';
$lang_global['inform_unread'] = 'Unread notification';
$lang_global['content_ssl'] = 'This page is not encrypted for secure communication. User names, passwords, and any other information will be sent in clear text.';
$lang_global['warning_ssl'] = 'Warning';
$lang_global['error_code_1'] = 'Address is invalid';
$lang_global['error_code_2'] = 'HTTP protocol banned for this query.';
$lang_global['error_code_3'] = 'Folder containing the file will be saved can not be written.';
$lang_global['error_code_4'] = 'No utility that supports HTTP protocol.';
$lang_global['error_code_5'] = 'There were too many redirect.';
$lang_global['error_code_6'] = 'SSL certificate can not be checked.';
$lang_global['error_code_7'] = 'HTTP request failed.';
$lang_global['error_code_8'] = 'Could not save data to a temporary file.';
$lang_global['error_code_9'] = 'Processing functions fopen() failed for file.';
$lang_global['error_code_10'] = 'HTTP request failed with Curl.';
$lang_global['error_code_11'] = 'There was an unknown error occurred.';
$lang_global['error_valid_response'] = 'Data returns nonstandard.';
$lang_global['passkey_error_challenge'] = 'Invalid or expired challenge, please reload the page and try again';
$lang_global['passkey_error_challenge1'] = 'Invalid challenge, please reload the page and try again';
$lang_global['passkey_error_credential'] = 'Invalid credential, please reload the page and try again';
$lang_global['passkey_error_credential1'] = 'Credential cannot be decrypted, please reload the page and try again';
$lang_global['passkey_error_credential2'] = 'Wrong type of credential, please reload the page and try again';
$lang_global['passkey_cannot_login'] = 'Cannot log in with this passkey, try another passkey or log in with a password';
$lang_global['passkey_cannot_auth'] = 'Authentication verification failed, please try other methods or keys';
$lang_global['passkey_only_seckey'] = 'This passkey is only for two-step verification, cannot log in. Try another passkey or log in with a password';
$lang_global['passkey_error_validator'] = 'Credential validation failed, please reload the page and try again';
$lang_global['myapis'] = 'My APIs';
$lang_global['login_name_type_username'] = 'Username';
$lang_global['login_name_type_email'] = 'Email';
$lang_global['login_name_type_email_username'] = 'Username or Email';
$lang_global['general_support'] = 'General support';
$lang_global['data_warning_content'] = 'When submitting data, I implicitly agree to grant the website permission to exploit the personal information that I have declared.';
$lang_global['antispam_warning_content'] = 'When submitting data, I confirm that I have been warned about Anti-Spam Law.';
$lang_global['data_warning_error'] = 'You need to confirm permission for the website to exploit personal information';
$lang_global['antispam_warning_error'] = 'You need to confirm that you have been warned about the Anti-Spam Law';
$lang_global['apply'] = 'Apply';
$lang_global['custom_range'] = 'Other';
$lang_global['copy_to_clipboard'] = 'Copy to clipboard';
$lang_global['copied'] = 'Copied!';
$lang_global['complete'] = 'Complete';
$lang_global['continue'] = 'Continue';
$lang_global['verify'] = 'Verify';
$lang_global['greeting_for_user'] = 'Dear %1$s (Username: %2$s),';
$lang_global['greeting_for_guest'] = 'Dear %s,';
$lang_global['greeting_title'] = 'Mr/Mrs %s';
$lang_global['greeting_title_M'] = 'Mr %s';
$lang_global['greeting_title_F'] = 'Mrs %s';
$lang_global['greeting_user'] = 'User greeting';
$lang_global['site_name'] = 'Website name';
$lang_global['site_phone'] = 'Site\'s phone';
$lang_global['site_email'] = 'Site\'s email';
$lang_global['time'] = 'Time';
$lang_global['note'] = 'Note';
$lang_global['ip'] = 'IP address';
$lang_global['browser'] = 'Browser';
$lang_global['sys_mods'] = 'System modules';
$lang_global['preview'] = 'Preview';
$lang_global['toggle_checkall'] = 'Select/deselect all';
$lang_global['toggle_checksingle'] = 'Select/deselect this row';
$lang_global['keyword'] = 'Keyword';
$lang_global['at'] = 'At';
$lang_global['by'] = 'By';
$lang_global['function'] = 'Function';
$lang_global['wait_page_load'] = 'Page loading, please wait...';
$lang_global['info_level'] = 'Information';
$lang_global['danger_level'] = 'Error';
$lang_global['warning_level'] = 'Warning';
$lang_global['success_level'] = 'Success';
$lang_global['country_AD'] = 'Andorra';
$lang_global['country_AE'] = 'United Arab Emirates';
$lang_global['country_AF'] = 'Afghanistan';
$lang_global['country_AG'] = 'Antigua And Barbuda';
$lang_global['country_AI'] = 'Anguilla';
$lang_global['country_AL'] = 'Albania';
$lang_global['country_AM'] = 'Armenia';
$lang_global['country_AN'] = 'Netherlands Antilles';
$lang_global['country_AO'] = 'Angola';
$lang_global['country_AQ'] = 'Antarctica';
$lang_global['country_AR'] = 'Argentina';
$lang_global['country_AS'] = 'American Samoa';
$lang_global['country_AT'] = 'Austria';
$lang_global['country_AU'] = 'Australia';
$lang_global['country_AW'] = 'Aruba';
$lang_global['country_AZ'] = 'Azerbaijan';
$lang_global['country_BA'] = 'Bosnia And Herzegovina';
$lang_global['country_BB'] = 'Barbados';
$lang_global['country_BD'] = 'Bangladesh';
$lang_global['country_BE'] = 'Belgium';
$lang_global['country_BF'] = 'Burkina Faso';
$lang_global['country_BG'] = 'Bulgaria';
$lang_global['country_BH'] = 'Bahrain';
$lang_global['country_BI'] = 'Burundi';
$lang_global['country_BJ'] = 'Benin';
$lang_global['country_BL'] = 'Saint Barthélemy';
$lang_global['country_BM'] = 'Bermuda';
$lang_global['country_BN'] = 'Brunei Darussalam';
$lang_global['country_BO'] = 'Bolivia';
$lang_global['country_BR'] = 'Brazil';
$lang_global['country_BS'] = 'Bahamas';
$lang_global['country_BT'] = 'Bhutan';
$lang_global['country_BW'] = 'Botswana';
$lang_global['country_BY'] = 'Belarus';
$lang_global['country_BZ'] = 'Belize';
$lang_global['country_CA'] = 'Canada';
$lang_global['country_CC'] = 'Cocos Islands';
$lang_global['country_CD'] = 'The Democratic Republic Of The Congo';
$lang_global['country_CF'] = 'Central African Republic';
$lang_global['country_CG'] = 'Congo';
$lang_global['country_CH'] = 'Switzerland';
$lang_global['country_CI'] = 'Cote Divoire';
$lang_global['country_CK'] = 'Cook Islands';
$lang_global['country_CL'] = 'Chile';
$lang_global['country_CM'] = 'Cameroon';
$lang_global['country_CN'] = 'China';
$lang_global['country_CO'] = 'Colombia';
$lang_global['country_CR'] = 'Costa Rica';
$lang_global['country_CS'] = 'Serbia And Montenegro';
$lang_global['country_CU'] = 'Cuba';
$lang_global['country_CV'] = 'Cape Verde';
$lang_global['country_CW'] = 'Curaçao';
$lang_global['country_CX'] = 'Christmas Island';
$lang_global['country_CY'] = 'Cyprus';
$lang_global['country_CZ'] = 'Czech Republic';
$lang_global['country_DE'] = 'Germany';
$lang_global['country_DJ'] = 'Djibouti';
$lang_global['country_DK'] = 'Denmark';
$lang_global['country_DM'] = 'Dominica';
$lang_global['country_DO'] = 'Dominican Republic';
$lang_global['country_DZ'] = 'Algeria';
$lang_global['country_EC'] = 'Ecuador';
$lang_global['country_EE'] = 'Estonia';
$lang_global['country_EG'] = 'Egypt';
$lang_global['country_EH'] = 'Western Sahara';
$lang_global['country_ER'] = 'Eritrea';
$lang_global['country_ES'] = 'Spain';
$lang_global['country_ET'] = 'Ethiopia';
$lang_global['country_EU'] = 'European Union';
$lang_global['country_FI'] = 'Finland';
$lang_global['country_FJ'] = 'Fiji';
$lang_global['country_FK'] = 'Falkland Islands';
$lang_global['country_FM'] = 'Federated States Of Micronesia';
$lang_global['country_FO'] = 'Faroe Islands';
$lang_global['country_FR'] = 'France';
$lang_global['country_GA'] = 'Gabon';
$lang_global['country_GB'] = 'United Kingdom';
$lang_global['country_GD'] = 'Grenada';
$lang_global['country_GE'] = 'Georgia';
$lang_global['country_GF'] = 'French Guiana';
$lang_global['country_GG'] = 'Bailiwick of Guernsey';
$lang_global['country_GH'] = 'Ghana';
$lang_global['country_GI'] = 'Gibraltar';
$lang_global['country_GL'] = 'Greenland';
$lang_global['country_GM'] = 'Gambia';
$lang_global['country_GN'] = 'Guinea';
$lang_global['country_GP'] = 'Guadeloupe';
$lang_global['country_GQ'] = 'Equatorial Guinea';
$lang_global['country_GR'] = 'Greece';
$lang_global['country_GS'] = 'South Georgia And The South Sandwich Islands';
$lang_global['country_GT'] = 'Guatemala';
$lang_global['country_GU'] = 'Guam';
$lang_global['country_GW'] = 'Guinea-Bissau';
$lang_global['country_GY'] = 'Guyana';
$lang_global['country_HK'] = 'Hong Kong';
$lang_global['country_HN'] = 'Honduras';
$lang_global['country_HR'] = 'Croatia';
$lang_global['country_HT'] = 'Haiti';
$lang_global['country_HU'] = 'Hungary';
$lang_global['country_ID'] = 'Indonesia';
$lang_global['country_IE'] = 'Ireland';
$lang_global['country_IL'] = 'Israel';
$lang_global['country_IM'] = 'Isle of Man';
$lang_global['country_IN'] = 'India';
$lang_global['country_IO'] = 'British Indian Ocean Territory';
$lang_global['country_IQ'] = 'Iraq';
$lang_global['country_IR'] = 'Islamic Republic Of Iran';
$lang_global['country_IS'] = 'Iceland';
$lang_global['country_IT'] = 'Italy';
$lang_global['country_JE'] = 'Jersey';
$lang_global['country_JM'] = 'Jamaica';
$lang_global['country_JO'] = 'Jordan';
$lang_global['country_JP'] = 'Japan';
$lang_global['country_KE'] = 'Kenya';
$lang_global['country_KG'] = 'Kyrgyzstan';
$lang_global['country_KH'] = 'Cambodia';
$lang_global['country_KI'] = 'Kiribati';
$lang_global['country_KM'] = 'Comoros';
$lang_global['country_KN'] = 'Saint Kitts And Nevis';
$lang_global['country_KP'] = 'North Korea';
$lang_global['country_KR'] = 'South Korea';
$lang_global['country_KW'] = 'Kuwait';
$lang_global['country_KY'] = 'Cayman Islands';
$lang_global['country_KZ'] = 'Kazakhstan';
$lang_global['country_LA'] = 'Lao Peoples Democratic Republic';
$lang_global['country_LB'] = 'Lebanon';
$lang_global['country_LC'] = 'Saint Lucia';
$lang_global['country_LI'] = 'Liechtenstein';
$lang_global['country_LK'] = 'Sri Lanka';
$lang_global['country_LR'] = 'Liberia';
$lang_global['country_LS'] = 'Lesotho';
$lang_global['country_LT'] = 'Lithuania';
$lang_global['country_LU'] = 'Luxembourg';
$lang_global['country_LV'] = 'Latvia';
$lang_global['country_LY'] = 'Libyan Arab Jamahiriya';
$lang_global['country_MA'] = 'Morocco';
$lang_global['country_MC'] = 'Monaco';
$lang_global['country_MD'] = 'Republic Of Moldova';
$lang_global['country_ME'] = 'Montenegro';
$lang_global['country_MF'] = 'Saint Martin';
$lang_global['country_MG'] = 'Madagascar';
$lang_global['country_MH'] = 'Marshall Islands';
$lang_global['country_MK'] = 'The Former Yugoslav Republic Of Macedonia';
$lang_global['country_ML'] = 'Mali';
$lang_global['country_MM'] = 'Myanmar';
$lang_global['country_MN'] = 'Mongolia';
$lang_global['country_MO'] = 'Macao';
$lang_global['country_MP'] = 'Northern Mariana Islands';
$lang_global['country_MQ'] = 'Martinique';
$lang_global['country_MR'] = 'Mauritania';
$lang_global['country_MS'] = 'Montserrat';
$lang_global['country_MT'] = 'Malta';
$lang_global['country_MU'] = 'Mauritius';
$lang_global['country_MV'] = 'Maldives';
$lang_global['country_MW'] = 'Malawi';
$lang_global['country_MX'] = 'Mexico';
$lang_global['country_MY'] = 'Malaysia';
$lang_global['country_MZ'] = 'Mozambique';
$lang_global['country_NA'] = 'Namibia';
$lang_global['country_NC'] = 'New Caledonia';
$lang_global['country_NE'] = 'Niger';
$lang_global['country_NF'] = 'Norfolk Island';
$lang_global['country_NG'] = 'Nigeria';
$lang_global['country_NI'] = 'Nicaragua';
$lang_global['country_NL'] = 'Netherlands';
$lang_global['country_NO'] = 'Norway';
$lang_global['country_NP'] = 'Nepal';
$lang_global['country_NR'] = 'Nauru';
$lang_global['country_NU'] = 'Niue';
$lang_global['country_NZ'] = 'New Zealand';
$lang_global['country_OM'] = 'Oman';
$lang_global['country_PA'] = 'Panama';
$lang_global['country_PE'] = 'Peru';
$lang_global['country_PF'] = 'French Polynesia';
$lang_global['country_PG'] = 'Papua New Guinea';
$lang_global['country_PH'] = 'Philippines';
$lang_global['country_PK'] = 'Pakistan';
$lang_global['country_PL'] = 'Poland';
$lang_global['country_PM'] = 'Saint Pierre and Miquelon';
$lang_global['country_PN'] = 'Pitcairn Islands';
$lang_global['country_PR'] = 'Puerto Rico';
$lang_global['country_PS'] = 'Palestinian Territory';
$lang_global['country_PT'] = 'Portugal';
$lang_global['country_PW'] = 'Palau';
$lang_global['country_PY'] = 'Paraguay';
$lang_global['country_QA'] = 'Qatar';
$lang_global['country_RE'] = 'Reunion';
$lang_global['country_RO'] = 'Romania';
$lang_global['country_RS'] = 'Serbia';
$lang_global['country_RU'] = 'Russian Federation';
$lang_global['country_RW'] = 'Rwanda';
$lang_global['country_SA'] = 'Saudi Arabia';
$lang_global['country_SB'] = 'Solomon Islands';
$lang_global['country_SC'] = 'Seychelles';
$lang_global['country_SD'] = 'Sudan';
$lang_global['country_SE'] = 'Sweden';
$lang_global['country_SG'] = 'Singapore';
$lang_global['country_SH'] = 'Saint Helena, Ascension and Tristan da Cunha';
$lang_global['country_SI'] = 'Slovenia';
$lang_global['country_SJ'] = 'Svalbard and Jan Mayen';
$lang_global['country_SK'] = 'Slovakia';
$lang_global['country_SL'] = 'Sierra Leone';
$lang_global['country_SM'] = 'San Marino';
$lang_global['country_SN'] = 'Senegal';
$lang_global['country_SO'] = 'Somalia';
$lang_global['country_SR'] = 'Suriname';
$lang_global['country_SS'] = 'South Sudan';
$lang_global['country_ST'] = 'Sao Tome And Principe';
$lang_global['country_SV'] = 'El Salvador';
$lang_global['country_SX'] = 'Sint Maarten';
$lang_global['country_SY'] = 'Syrian Arab Republic';
$lang_global['country_SZ'] = 'Swaziland';
$lang_global['country_TC'] = 'Turks and Caicos Islands';
$lang_global['country_TD'] = 'Chad';
$lang_global['country_TF'] = 'French Southern Territories';
$lang_global['country_TG'] = 'Togo';
$lang_global['country_TH'] = 'Thailand';
$lang_global['country_TJ'] = 'Tajikistan';
$lang_global['country_TK'] = 'Tokelau';
$lang_global['country_TL'] = 'Timor-Leste';
$lang_global['country_TM'] = 'Turkmenistan';
$lang_global['country_TN'] = 'Tunisia';
$lang_global['country_TO'] = 'Tonga';
$lang_global['country_TR'] = 'Turkey';
$lang_global['country_TT'] = 'Trinidad And Tobago';
$lang_global['country_TV'] = 'Tuvalu';
$lang_global['country_TW'] = 'Taiwan';
$lang_global['country_TZ'] = 'United Republic Of Tanzania';
$lang_global['country_UA'] = 'Ukraine';
$lang_global['country_UG'] = 'Uganda';
$lang_global['country_US'] = 'United States';
$lang_global['country_UY'] = 'Uruguay';
$lang_global['country_UZ'] = 'Uzbekistan';
$lang_global['country_VA'] = 'Vatican City';
$lang_global['country_VC'] = 'Saint Vincent And The Grenadines';
$lang_global['country_VE'] = 'Venezuela';
$lang_global['country_VG'] = 'Virgin Islands';
$lang_global['country_VI'] = 'Virgin Islands';
$lang_global['country_VN'] = 'Viet Nam';
$lang_global['country_VU'] = 'Vanuatu';
$lang_global['country_WF'] = 'Wallis and Futuna';
$lang_global['country_WS'] = 'Samoa';
$lang_global['country_XK'] = 'Kosovo';
$lang_global['country_YE'] = 'Yemen';
$lang_global['country_YT'] = 'Mayotte';
$lang_global['country_YU'] = 'Serbia And Montenegro (Formally Yugoslavia)';
$lang_global['country_ZA'] = 'South Africa';
$lang_global['country_ZM'] = 'Zambia';
$lang_global['country_ZW'] = 'Zimbabwe';
