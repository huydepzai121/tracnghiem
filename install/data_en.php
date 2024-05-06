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
$install_lang['modules']['about'] = 'About';
$install_lang['modules']['about_for_acp'] = '';
$install_lang['modules']['news'] = 'News';
$install_lang['modules']['news_for_acp'] = '';
$install_lang['modules']['users'] = 'Users';
$install_lang['modules']['users_for_acp'] = 'Users';
$install_lang['modules']['myapi'] = 'My APIs';
$install_lang['modules']['myapi_for_acp'] = '';
$install_lang['modules']['inform'] = 'Notification';
$install_lang['modules']['inform_for_acp'] = '';
$install_lang['modules']['contact'] = 'Contact';
$install_lang['modules']['contact_for_acp'] = '';
$install_lang['modules']['statistics'] = 'Statistics';
$install_lang['modules']['statistics_for_acp'] = '';
$install_lang['modules']['voting'] = 'Voting';
$install_lang['modules']['voting_for_acp'] = '';
$install_lang['modules']['banners'] = 'Banners';
$install_lang['modules']['banners_for_acp'] = '';
$install_lang['modules']['seek'] = 'Search';
$install_lang['modules']['seek_for_acp'] = '';
$install_lang['modules']['menu'] = 'Navigation Bar';
$install_lang['modules']['menu_for_acp'] = '';
$install_lang['modules']['comment'] = 'Comment';
$install_lang['modules']['comment_for_acp'] = '';
$install_lang['modules']['siteterms'] = 'Terms & Conditions';
$install_lang['modules']['siteterms_for_acp'] = '';
$install_lang['modules']['feeds'] = 'RSS-feeds';
$install_lang['modules']['Page'] = 'Page';
$install_lang['modules']['Page_for_acp'] = '';
$install_lang['modules']['freecontent'] = 'Introduction';
$install_lang['modules']['freecontent_for_acp'] = '';
$install_lang['modules']['two_step_verification'] = '2-Step Verification';
$install_lang['modules']['two_step_verification_for_acp'] = '';

$install_lang['modfuncs'] = [];
$install_lang['modfuncs']['users'] = [];
$install_lang['modfuncs']['users']['login'] = 'Login';
$install_lang['modfuncs']['users']['register'] = 'Register';
$install_lang['modfuncs']['users']['lostpass'] = 'Password recovery';
$install_lang['modfuncs']['users']['lostactivelink'] = 'Retrieve activation link';
$install_lang['modfuncs']['users']['r2s'] = 'Turn off 2-step authentication';
$install_lang['modfuncs']['users']['active'] = 'Active account';
$install_lang['modfuncs']['users']['editinfo'] = 'Account Settings';
$install_lang['modfuncs']['users']['memberlist'] = 'Members list';
$install_lang['modfuncs']['users']['logout'] = 'Logout';
$install_lang['modfuncs']['users']['groups'] = 'Group management';

$install_lang['modfuncs']['statistics'] = [];
$install_lang['modfuncs']['statistics']['allreferers'] = 'By referrers';
$install_lang['modfuncs']['statistics']['allcountries'] = 'By countries';
$install_lang['modfuncs']['statistics']['allbrowsers'] = 'By browsers ';
$install_lang['modfuncs']['statistics']['allos'] = 'By operating system';
$install_lang['modfuncs']['statistics']['allbots'] = 'By search engines';
$install_lang['modfuncs']['statistics']['referer'] = 'By month';

$install_lang['blocks_groups'] = [];
$install_lang['blocks_groups']['news'] = [];
$install_lang['blocks_groups']['news']['module.block_newscenter'] = 'Breaking news';
$install_lang['blocks_groups']['news']['global.block_category'] = 'Category';
$install_lang['blocks_groups']['news']['global.block_tophits'] = 'Top Hits';
$install_lang['blocks_groups']['banners'] = [];
$install_lang['blocks_groups']['banners']['global.banners1'] = 'Center Banner';
$install_lang['blocks_groups']['banners']['global.banners2'] = 'Left Banner';
$install_lang['blocks_groups']['banners']['global.banners3'] = 'Right Banner';
$install_lang['blocks_groups']['statistics'] = [];
$install_lang['blocks_groups']['statistics']['global.counter'] = 'Statistics';
$install_lang['blocks_groups']['about'] = [];
$install_lang['blocks_groups']['about']['global.about'] = 'About';
$install_lang['blocks_groups']['voting'] = [];
$install_lang['blocks_groups']['voting']['global.voting_random'] = 'Voting';
$install_lang['blocks_groups']['inform'] = [];
$install_lang['blocks_groups']['inform']['global.inform'] = 'Notification';
$install_lang['blocks_groups']['users'] = [];
$install_lang['blocks_groups']['users']['global.user_button'] = 'Member login';
$install_lang['blocks_groups']['theme'] = [];
$install_lang['blocks_groups']['theme']['global.company_info'] = 'Managing company';
$install_lang['blocks_groups']['theme']['global.menu_footer'] = 'Main categories';
$install_lang['blocks_groups']['freecontent'] = [];
$install_lang['blocks_groups']['freecontent']['global.free_content'] = 'Introduction';

$install_lang['cron'] = [];
$install_lang['cron']['cron_online_expired_del'] = 'Delete expired online status';
$install_lang['cron']['cron_dump_autobackup'] = 'Automatic backup database';
$install_lang['cron']['cron_auto_del_temp_download'] = 'Empty temporary files';
$install_lang['cron']['cron_del_ip_logs'] = 'Delete IP log files';
$install_lang['cron']['cron_auto_del_error_log'] = 'Delete expired error_log log files';
$install_lang['cron']['cron_auto_sendmail_error_log'] = 'Send error logs to admin';
$install_lang['cron']['cron_ref_expired_del'] = 'Delete expired referer';
$install_lang['cron']['cron_auto_check_version'] = 'Check NukeViet version';
$install_lang['cron']['cron_notification_autodel'] = 'Delete old notification';
$install_lang['cron']['cron_remove_expired_inform'] = 'Remove expired notifications';
$install_lang['cron']['cron_apilogs_autodel'] = 'Remove expired API-logs';
$install_lang['cron']['cron_expadmin_handling'] = 'Handling expired admins';

$install_lang['groups']['NukeViet-Fans'] = 'NukeViet-Fans';
$install_lang['groups']['NukeViet-Admins'] = 'NukeViet-Admins';
$install_lang['groups']['NukeViet-Programmers'] = 'NukeViet-Programmers';

$install_lang['groups']['NukeViet-Fans-desc'] = 'NukeViet System Fans Group';
$install_lang['groups']['NukeViet-Admins-desc'] = 'Group of administrators for sites built by the NukeViet system';
$install_lang['groups']['NukeViet-Programmers-desc'] = 'NukeViet System Programmers Group';

$install_lang['vinades_fullname'] = 'Vietnam Open Source Development Joint Stock Company';
$install_lang['vinades_address'] = '6th floor, Song Da building, No. 131 Tran Phu street, Van Quan ward, Ha Dong district, Hanoi city, Vietnam';
$install_lang['nukeviet_description'] = 'Sharing success, connect passions';
$install_lang['disable_site_content'] = 'For technical reasons Web site temporary not available. we are very sorry for that inconvenience!';

// Ngôn ngữ dữ liệu cho phần mẫu email
use NukeViet\Template\Email\Cat as EmailCat;
use NukeViet\Template\Email\Tpl as EmailTpl;

$install_lang['emailtemplates'] = [];
$install_lang['emailtemplates']['cats'] = [];
$install_lang['emailtemplates']['cats'][EmailCat::CAT_SYSTEM] = 'System Messages';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_USER] = 'User Messages';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_AUTHOR] = 'Admin Messages';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_MODULE] = 'Module Messages';

$install_lang['emailtemplates']['emails'] = [];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_EMAIL_ACTIVE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Account activation via email',
    's' => 'Activate information',
    'c' => '{$greeting_user}<br /><br />Your account at website {$site_name} waitting to activate. To activate, please click link follow:<br /><br />URL: <a href="{$link}">{$link}</a><br /><br />Account information:<br /><br />Username: {$username}<br />Email: {$email}<br /><br />Activate expired on {$active_deadline}<br /><br />This is email automatic sending from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_DELETE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Email notification to delete account',
    's' => 'Email notification to delete account',
    'c' => '{$greeting_user}<br /><br />We are so sorry to delete your account at website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_2STEP_CODE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Send new backup code',
    's' => 'New backup code',
    'c' => '{$greeting_user}<br /><br /> backup code to your account at the website {$site_name} has been changed. Here is a new backup code: <br /><br />{foreach from=$new_code item=code}{$code}<br />{/foreach}<br />You keep your backup safe. If you lose your phone and lose your backup code, you will no longer be able to access your account.<br /><br />This is an automated message sent to your e-mail from website {$site_name}. If you do not understand the content of this letter, simply delete it.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_INFO] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification that the account has been created when the member successfully registers in the form',
    's' => 'Your account was created',
    'c' => '{$greeting_user}<br /><br />Your account at website {$site_name} activated. Your login information:<br /><br />Username: {$username}<br />Email: {$email}<br /><br />Please click the link below to log in:<br />URL: <a href="{$link}">{$link}</a><br /><br />This is email automatic sending from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_INFOOAUTH] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification that the account has been created when the member successfully registers via Oauth',
    's' => 'Your account was created',
    'c' => '{$greeting_user}<br /><br />Your account at website {$site_name} activated. To log into your account please visit the page: <a href="{$link}">{$link}</a> and press the button: Sign in with {$oauth_name}.<br /><br />This is email automatic sending from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_LEADER_ADDED] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification of account created by group leader',
    's' => 'Your account was created',
    'c' => '{$greeting_user}<br /><br />Your account at website {$site_name} activated. Your login information:<br /><br />URL: <a href="{$link}">{$link}</a><br />Username: {$username}<br />Email: {$email}<br /><br />This is email automatic sending from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_ADMIN_ADDED] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification of account created by administrator',
    's' => 'Your account was created',
    'c' => '{$greeting_user}<br /><br />Your account at website {$site_name} has been created. Here are the logins:<br /><br />URL: <a href="{$link}">{$link}</a><br />Username: {$username}<br />Password: {$password}<br />{if $pass_reset eq 2}<br />Note: We recommend that you change your password before using your account.<br />{elseif $pass_reset eq 1}<br />Note: You need to change your password before using your account.<br />{/if}<br />This is an automated message sent to Your email box from website {$site_name}. If you do not understand the content of this letter, simply delete it.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_SAFE_KEY] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Send verification code when user turns on/ off safe mode',
    's' => 'Safe mode verification code',
    'c' => '{$greeting_user}<br /><br />You sent a request using safe mode in website {$site_name}. Below is a verifykey  for activating or off safe mode:<br /><br /><strong>{$code}</strong><br /><br />This verifykey only works on-off safe mode once only. After you turn off safe mode, this verification code will be worthless.<br /><br />These are automatic messages sent to your e-mail inbox from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_SELF_EDIT] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notify account changes just made by the user',
    's' => 'Update account infomation success',
    'c' => '{$greeting_user}<br /><br />Your account on the website {$site_name} has been updated {if $send_newvalue}with new {$label}: <strong>{$newvalue}</strong>{else}new {$label}{/if}.<br /><br />These are automatic messages sent to your e-mail inbox from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_ADMIN_EDIT] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notify account changes just made by the administrator',
    's' => 'Your account has been updated',
    'c' => '{$greeting_user}<br /><br />Your account at website {$site_name} has been updated. Here are the login information:<br /><br />URL: <a href="{$link}">{$link}</a><br />Username: {$username}{if not empty($password)}<br />Password: {$password}{/if}<br />{if $pass_reset eq 2}<br />Note: We recommend that you change your password before using your account.<br />{elseif $pass_reset eq 1}<br />Note: You need to change your password before using your account.<br />{/if}<br />This is an automated message sent to your email from {$site_name}. If you do not understand the content of this letter, simply delete it.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_VERIFY_EMAIL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Confirmation email to change account email',
    's' => 'Activation information for changing email',
    'c' => '{$greeting_user}<br /><br />You sent a request to change the email address of the personal Account on the website {$site_name}. To complete this change, you must confirm your new email address by entering the verifykey below in the appropriate fields in the area Edit Account Information:<br /><br />Verifykey: <strong>{$code}</strong><br /><br />This key expires on {$deadline}.<br /><br />These are automatic messages sent to your e-mail inbox from website {$site_name}. If you do not understand anything about the contents of this letter, simply delete it.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_GROUP_JOIN] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notice asking to join the group',
    's' => 'Request to join group',
    'c' => 'Hello leader <strong>{$group_name}</strong>,<br /><br /><strong>{$full_name}</strong> has sent the request to join the group <strong>{$group_name}</strong> you are managing. You need to approve this request!<br /><br />Please <a href="{$link}"> visit this link </a> to approve membership.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_LOST_ACTIVE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Resend account activation information',
    's' => 'Activate account',
    'c' => '{$greeting_user}<br /><br />Your account at website {$site_name} waitting to activate. To activate, please click link follow:<br /><br />URL: <a href="{$link}">{$link}</a><br />Account information:<br />Account: {$username}<br />Email: {$email}<br />Password: {$password}<br /><br />Activate expired on {$active_deadline}<br /><br />This is email automatic sending from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_LOST_PASS] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Instructions for retrieving member password',
    's' => 'Guide password recovery',
    'c' => '{$greeting_user}<br /><br />You propose to change my login password at the website {$site_name}. To change your password, you will need to enter the verification code below in the corresponding box at the password change area.<br /><br />Verification code: <strong>{$code}</strong><br /><br />This code is only used once and before the deadline of {$deadline}.<br /><br />This letter is automatically sent to your email inbox from site {$site_name}. If you do not know anything about the contents of this letter, just delete it.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_DELETE] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Notice that the administrator account has been deleted',
    's' => 'Information from {$site_name} website',
    'c' => 'Administrator {$site_name} website notify:<br />Your administrator account in {$site_name} website deleted at {$time}{if not empty($note)}. Reason: {$note}{/if}.<br />If you have any questions... please email <a href="mailto:{$email}">{$email}</a>{if not empty($username)}<br/><br/>{$sig}<br/><br/>{$username}<br/>{$position}<br/>{$email}{/if}'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_SUSPEND] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Notice of suspension of site administration',
    's' => 'Information from {$site_name} website',
    'c' => 'Information from {$site_name} aministrators:<br />Your administrator account in {$site_name} is suspended at {$time} reason: {$note}.<br />If you have any questions... please email <a href="mailto:{$email}">{$email}</a>{if not empty($username)}<br/><br/>{$sig}<br/><br/>{$username}<br/>{$position}<br/>{$email}{/if}'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_REACTIVE] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Notice of reactivation of site administration',
    's' => 'Information from {$site_name} website',
    'c' => 'Information from {$site_name} aministrators:<br />Your administrator account in {$site_name} is reactive at {$time}.<br />Your account has been suspended before because: {$note}{if not empty($username)}<br/><br/>{$sig}<br/><br/>{$username}<br/>{$position}<br/>{$email}{/if}'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTO_ERROR_REPORT] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_SYSTEM,
    't' => 'Email auto-notification error',
    's' => 'Error report from website {$site_name}',
    'c' => 'The system received some error messages. Please open the attached file for details.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_R2S] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notice that two-step authentication has been successfully removed',
    's' => '2-Step Verification is turned off',
    'c' => '{$greeting_user}<br /><br />At your request, we have turned off 2-Step Verification for your account at the {$site_name} website.<br /><br />This is email automatic sending from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_R2S_REQUEST] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Instructions for turning off two-step authentication when forgetting code',
    's' => 'Information about turning off 2-step verification',
    'c' => '{$greeting_user}<br /><br />We have received a request to turn off 2-step verification for your account at the {$site_name} website. If you sent this request yourself, please use the Verification Code below to proceed:<br /><br />Verification Code: <strong>{$code}</strong><br /><br />This is email automatic sending from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_LEADER_ADD] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification oauth is added to the account by the team leader',
    's' => 'Privacy Notice',
    'c' => '{$greeting_user}<br /><br />We are informing you that a third party account <strong>{$oauth_name}</strong> has just been connected to your <strong>{$username}</strong> account by the group leader.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Third-party accounts Management</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_SELF_ADD] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification oauth is added to the account by the user themselves',
    's' => 'Privacy Notice',
    'c' => '{$greeting_user}<br /><br />The third party account <strong>{$oauth_name}</strong> has just been connected to your <strong>{$username}</strong> account. If this was not your intention, please quickly remove it from your account by visiting the third party account management area.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Third-party accounts Management</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_LEADER_DEL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification oauth is removed to the account by the team leader',
    's' => 'Privacy Notice',
    'c' => '{$greeting_user}<br /><br />We are informing you that the third party account <strong>{$oauth_name}</strong> has just been disconnected from your <strong>{$username}</strong> account by the group leader.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Third-party accounts Management</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_SELF_DEL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification oauth is removed to the account by the user themselves',
    's' => 'Privacy Notice',
    'c' => '{$greeting_user}<br /><br />The third-party account <strong>{$oauth_name}</strong> has just been disconnected from your <strong>{$username}</strong> account. If this is not your intention, please quickly contact the site administrator for help.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Third-party accounts Management</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_VERIFY_EMAIL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Send email verification code when logging in via Oauth and the email matches your existing account',
    's' => 'New e-mail verification',
    'c' => 'Hello!<br /><br />You have sent a request to verify your email address: {$email}. Copy the code below and paste it into the Verification code box on the site.<br /><br />Verification code: <strong>{$code}</strong><br /><br />This is email automatic sending from website {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_EMAIL_CONFIG_TEST] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_SYSTEM,
    't' => 'Send test email to test email sending configuration',
    's' => 'Test email',
    'c' => 'This is a test email to check the mail configuration. Simply delete it!'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_NEWS_SENDMAIL] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_MODULE,
    't' => 'Send an email introducing the article to friend at the news module',
    's' => 'Message from {$from_name}',
    'c' => 'Hello!<br />Your friend {$from_name} would like to introduce to you the article “{$post_name}” on website {$site_name}{if not empty($message)} with the message:<br />{$message}{/if}.<br/>----------<br/><strong>{$post_name}</strong><br/>{$hometext}<br/><br/>You can view the full article by clicking on the link below:<br /><a href="{$link}" title="{$post_name}">{$link}</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_NEWS_REPORT_THANKS] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_MODULE,
    't' => 'Email thanking the person who reported the error at module news',
    's' => 'Thank you for submitting an error report',
    'c' => 'Hello!<br />{$site_name} website administration thank you very much for submitting an error report in the content of the article of our website. We fixed the error you reported.<br />Hope to receive your next help in the future. Wish you always healthy, happy and successful!'
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
$menu_rows_lev0['voting'] = [
    'title' => $install_lang['modules']['voting'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=voting',
    'groups_view' => '6',
    'op' => ''
];
$menu_rows_lev0['contact'] = [
    'title' => $install_lang['modules']['contact'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=contact',
    'groups_view' => '6',
    'op' => ''
];

$menu_rows_lev1['users'] = [];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['login'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=login',
    'groups_view' => '5',
    'op' => 'login'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['register'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=register',
    'groups_view' => '5',
    'op' => 'register'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['lostpass'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=lostpass',
    'groups_view' => '5',
    'op' => 'lostpass'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['editinfo'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=editinfo',
    'groups_view' => '4,7',
    'op' => 'editinfo'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['memberlist'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=memberlist',
    'groups_view' => '4,7',
    'op' => 'memberlist'
];
$menu_rows_lev1['users'][] = [
    'title' => $install_lang['modfuncs']['users']['logout'],
    'link' => NV_BASE_SITEURL . 'index.php?language=' . $lang_data . '&nv=users&op=logout',
    'groups_view' => '4,7',
    'op' => 'logout'
];
