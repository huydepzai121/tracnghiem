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
$install_lang['modules']['about'] = 'À propos';
$install_lang['modules']['about_for_acp'] = '';
$install_lang['modules']['news'] = 'News';
$install_lang['modules']['news_for_acp'] = '';
$install_lang['modules']['users'] = 'Compte d&#039;utilisateur';
$install_lang['modules']['users_for_acp'] = '';
$install_lang['modules']['myapi'] = 'Mes API';
$install_lang['modules']['myapi_for_acp'] = '';
$install_lang['modules']['inform'] = 'Notification';
$install_lang['modules']['inform_for_acp'] = '';
$install_lang['modules']['contact'] = 'Contact';
$install_lang['modules']['contact_for_acp'] = '';
$install_lang['modules']['statistics'] = 'Statistiques';
$install_lang['modules']['statistics_for_acp'] = '';
$install_lang['modules']['voting'] = 'Sondage';
$install_lang['modules']['voting_for_acp'] = '';
$install_lang['modules']['banners'] = 'Publicité';
$install_lang['modules']['banners_for_acp'] = '';
$install_lang['modules']['seek'] = 'Recherche';
$install_lang['modules']['seek_for_acp'] = '';
$install_lang['modules']['menu'] = 'Barre de navigation';
$install_lang['modules']['menu_for_acp'] = '';
$install_lang['modules']['comment'] = 'Comment';
$install_lang['modules']['comment_for_acp'] = '';
$install_lang['modules']['siteterms'] = 'Conditions d’utilisation';
$install_lang['modules']['siteterms_for_acp'] = '';
$install_lang['modules']['feeds'] = 'Rss Feeds';
$install_lang['modules']['Page'] = 'Page';
$install_lang['modules']['Page_for_acp'] = '';
$install_lang['modules']['freecontent'] = 'Introduction';
$install_lang['modules']['freecontent_for_acp'] = '';
$install_lang['modules']['two_step_verification'] = '2-Step Vérification';
$install_lang['modules']['two_step_verification_for_acp'] = '';

$install_lang['modfuncs'] = [];
$install_lang['modfuncs']['users'] = [];
$install_lang['modfuncs']['users']['login'] = 'Se connecter';
$install_lang['modfuncs']['users']['register'] = 'S&#039;inscrire';
$install_lang['modfuncs']['users']['lostpass'] = 'Mot de passe oublié?';
$install_lang['modfuncs']['users']['lostactivelink'] = 'Récupérer le lien d\'activation';
$install_lang['modfuncs']['users']['r2s'] = 'Désactiver la vérification en deux étapes';
$install_lang['modfuncs']['users']['active'] = 'Active';
$install_lang['modfuncs']['users']['editinfo'] = 'Edit User Info';
$install_lang['modfuncs']['users']['memberlist'] = 'Liste des membres';
$install_lang['modfuncs']['users']['logout'] = 'Logout';
$install_lang['modfuncs']['users']['groups'] = 'Groups';

$install_lang['modfuncs']['statistics'] = [];
$install_lang['modfuncs']['statistics']['allreferers'] = 'Par Site';
$install_lang['modfuncs']['statistics']['allcountries'] = 'Par Pays';
$install_lang['modfuncs']['statistics']['allbrowsers'] = 'Par Navigateur';
$install_lang['modfuncs']['statistics']['allos'] = 'Par Système d&#039;exploitation';
$install_lang['modfuncs']['statistics']['allbots'] = 'Par Moteur de recherche';
$install_lang['modfuncs']['statistics']['referer'] = 'Par Site';

$install_lang['blocks_groups'] = [];
$install_lang['blocks_groups']['news'] = [];
$install_lang['blocks_groups']['news']['module.block_newscenter'] = 'Articles récents';
$install_lang['blocks_groups']['news']['global.block_category'] = 'Catégorie';
$install_lang['blocks_groups']['news']['global.block_tophits'] = 'Article Clics';
$install_lang['blocks_groups']['banners'] = [];
$install_lang['blocks_groups']['banners']['global.banners1'] = 'Publicité du centre';
$install_lang['blocks_groups']['banners']['global.banners2'] = 'Publicité à côté';
$install_lang['blocks_groups']['banners']['global.banners3'] = 'Publicité à côté2';
$install_lang['blocks_groups']['statistics'] = [];
$install_lang['blocks_groups']['statistics']['global.counter'] = 'Statistics';
$install_lang['blocks_groups']['about'] = [];
$install_lang['blocks_groups']['about']['global.about'] = 'À propos';
$install_lang['blocks_groups']['voting'] = [];
$install_lang['blocks_groups']['voting']['global.voting_random'] = 'Sondage';
$install_lang['blocks_groups']['inform'] = [];
$install_lang['blocks_groups']['inform']['global.inform'] = 'Notification';
$install_lang['blocks_groups']['users'] = [];
$install_lang['blocks_groups']['users']['global.user_button'] = 'Se connecter';
$install_lang['blocks_groups']['theme'] = [];
$install_lang['blocks_groups']['theme']['global.company_info'] = 'Management Company';
$install_lang['blocks_groups']['theme']['global.menu_footer'] = 'Menu';
$install_lang['blocks_groups']['freecontent'] = [];
$install_lang['blocks_groups']['freecontent']['global.free_content'] = 'Produits';

$install_lang['cron'] = [];
$install_lang['cron']['cron_online_expired_del'] = 'Supprimer les anciens registres du status en ligne dans la base de données';
$install_lang['cron']['cron_dump_autobackup'] = 'Sauvegarder automatique la base de données';
$install_lang['cron']['cron_auto_del_temp_download'] = 'Supprimer les fichiers temporaires du répertoire tmp';
$install_lang['cron']['cron_del_ip_logs'] = 'Supprimer les fichiers ip_logs expirés';
$install_lang['cron']['cron_auto_del_error_log'] = 'Supprimer les fichiers error_log expirés';
$install_lang['cron']['cron_auto_sendmail_error_log'] = 'Envoyer à l’administrateur l’e-mail des notifications d’erreurs';
$install_lang['cron']['cron_ref_expired_del'] = 'Supprimer les referers expirés';
$install_lang['cron']['cron_auto_check_version'] = 'Vérifier la version NukeViet';
$install_lang['cron']['cron_notification_autodel'] = 'Supprimer vieille notification';
$install_lang['cron']['cron_remove_expired_inform'] = 'Supprimer les notifications expirées';
$install_lang['cron']['cron_apilogs_autodel'] = 'Supprimer les journaux d’API expirés';
$install_lang['cron']['cron_expadmin_handling'] = 'Gestion des administrateurs expirés';

$install_lang['groups']['NukeViet-Fans'] = 'Fans de NukeViet';
$install_lang['groups']['NukeViet-Admins'] = 'Admins de NukeViet';
$install_lang['groups']['NukeViet-Programmers'] = 'Programmeurs de NukeViet';

$install_lang['groups']['NukeViet-Fans-desc'] = 'Groupe de ventilateurs du système NukeViet';
$install_lang['groups']['NukeViet-Admins-desc'] = 'Groupe d’administrateurs pour les sites créés par le système NukeViet';
$install_lang['groups']['NukeViet-Programmers-desc'] = 'Groupe de programmeurs de systèmes NukeViet';

$install_lang['vinades_fullname'] = 'Vietnam Open Source Development Joint Stock Company';
$install_lang['vinades_address'] = '6ème étage, bâtiment Song Da, rue Tran Phu n° 131, quartier Van Quan, district de Ha Dong, ville de Hanoï, Vietnam';
$install_lang['nukeviet_description'] = 'Partager le succès, connectez passions';
$install_lang['disable_site_content'] = 'Notre site est fermé temporairement pour la maintenance. Veuillez revenir plus tard. Merci!';

// Ngôn ngữ dữ liệu cho phần mẫu email
use NukeViet\Template\Email\Cat as EmailCat;
use NukeViet\Template\Email\Tpl as EmailTpl;

$install_lang['emailtemplates'] = [];
$install_lang['emailtemplates']['cats'] = [];
$install_lang['emailtemplates']['cats'][EmailCat::CAT_SYSTEM] = 'Messages système';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_USER] = 'Messages utilisateur';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_AUTHOR] = 'Messages Admin';
$install_lang['emailtemplates']['cats'][EmailCat::CAT_MODULE] = 'Messages du module';

$install_lang['emailtemplates']['emails'] = [];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_EMAIL_ACTIVE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Activation du compte par email',
    's' => 'Infos pour l\'activation du compte',
    'c' => '{$greeting_user}<br /><br />Votre compte sur le site Web {$site_name} attend d\'être activé. Pour l\'activer, veuillez cliquer sur le lien suivant:<br /><br />URL: <a href="{$link}">{$link}</a><br /><br />Informations sur le compte:<br /><br />Nom d\'utilisateur: {$username}<br />E-mail: {$email}<br /><br />Activation expirée le {$active_deadline}<br /><br />Ceci est un envoi automatique d\'e-mail du site Web {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_DELETE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification de suppression du compte',
    's' => 'Notification de suppression du compte',
    'c' => '{$greeting_user}<br /><br />Nous sommes désolé de vous informer la suppression de votre compte sur le site {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_2STEP_CODE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Codes de sauvegarde',
    's' => 'Codes de sauvegarde',
    'c' => '{$greeting_user}<br /><br />Code de sauvegarde sur votre compte sur le site {$site_name} a été changé. Voici le nouveau code de sauvegarde:<br /><br />{foreach from=$new_code item=code}{$code}<br />{/foreach}<br />Vous gardez les codes de sauvegarde sécurisés. Si vous perdez votre téléphone et prenez les deux codes de sauvegarde que vous ne serez pas en mesure d\'accéder à votre compte. <br /> <br /> C\'est un message automatique envoyé à votre boîte de réception e-mail à partir du site {$site_name}. Si vous ne comprenez rien au sujet du contenu de cette lettre, supprimer tout simplement.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_INFO] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification que le compte a été créé lorsque le membre s\'inscrit avec succès dans le formulaire',
    's' => 'Votre compte a été créé',
    'c' => '{$greeting_user}<br /><br />Votre compte sur le site Web {$site_name} a été activé. Ci-dessous les informations du compte:<br /><br />Nom d\'utilisateur: {$username}<br />Email: {$email}<br /><br />Veuillez cliquer sur le lien ci-dessous pour vous connecter:<br />URL: <a href="{$link}">{$link}</a><br /><br />Il s\'agit d\'un message automatique envoyé à votre adresse e-mail depuis le site Web {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_NEW_INFOOAUTH] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification indiquant que le compte a été créé lorsque le membre s\'inscrit avec succès via Oauth',
    's' => 'Votre compte a été créé',
    'c' => '{$greeting_user}<br /><br />Votre compte sur le site Web {$site_name} est activé. Pour vous connecter à votre compte, veuillez visiter la page: <a href="{$link}">{$link}</a> et appuyez sur le bouton: Connectez-vous avec {$oauth_name}.<br /><br />Cela est un message automatique qui était envoyé à votre boîte mail à partir du site {$site_name}. Si vous ne comprenez pas le contenu de ce mail, vous pouvez simplement le supprimer.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_LEADER_ADDED] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification de compte créé par le responsable d\'équipe',
    's' => 'Votre compte a été créé',
    'c' => '{$greeting_user}<br /><br />Votre compte Site de {$site_name} été activé. Voici vos informations de connexion:<br /><br />URL: <a href="{$link}">{$link}</a><br />Nom: {$username}<br />Email: {$email}<br /><br />Ceci est un message automatique envoyé à votre boîte de réception e-mail à partir du site {$site_name}. Si vous ne comprenez pas quelque chose sur le contenu de cette lettre, il suffit de le supprimer.'
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
