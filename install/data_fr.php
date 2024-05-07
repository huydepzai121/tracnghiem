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
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_ADMIN_ADDED] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification de compte créé par l\'administrateur',
    's' => 'Votre compte a été créé',
    'c' => '{$greeting_user}<br /><br />Votre compte sur le site {$site_name} a été créé. Voici vos informations de connexion:<br /><br />URL: <a href="{$link}">{$link}</a><br />Nom: {$username}<br />Mot de passe: {$password}<br />{if $pass_reset eq 2}<br />Remarque: Nous vous recommandons de changer votre mot de passe avant d\'utiliser votre compte.<br />{elseif $pass_reset eq 1}<br />Remarque: Vous devez changer votre mot de passe avant d\'utiliser votre compte.<br />{/if}<br />Ceci est un message automatique envoyé. votre boîte de réception e-mail à partir du site web {$site_name}. Si vous ne comprenez rien au sujet du contenu de cette lettre, supprimer tout simplement.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_SAFE_KEY] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Envoyer le code de vérification lorsque l\'utilisateur active/désactive le mode sans échec',
    's' => 'Code de certifier en mode sans échec',
    'c' => '{$greeting_user}<br /><br />Vous avez demandé l\'utilisation du mode sans échec sur le site {$site_name}. En dessous est le code de certifier pour l\'activer ou le désactiver:<br /><br /><strong>{$code}</strong><br /><br />Ce code ne peut être utilisé qu\'une seule fois. Apres la désactivation de ce mode, ce code est inutilisable.<br /><br /> C\'est un courier automatique qui est envoyé à votre email à partir du site {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_SELF_EDIT] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notifier les modifications de compte que l\'utilisateur vient d\'effectuer',
    's' => 'La mise à jour les infos du compte réussite',
    'c' => '{$greeting_user}<br /><br />Votre compte sur le site Web {$site_name} {if $send_newvalue}mis à jour avec le nouveau {$label} <strong>{$newvalue}</strong>{else}le nouveau {$label} a été mis à jour{/if}.<br /><br />C\'est un courier automatique qui est envoyé à votre email à partir du site {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_ADMIN_EDIT] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notifier les modifications de compte qui viennent d\'être apportées par l\'administrateur',
    's' => 'Votre compte a été mis à jour',
    'c' => '{$greeting_user}<br /><br />Votre compte sur le site {$site_name} a été mis à jour. Voici les informations de connexion:<br /><br />URL: <a href="{$link}">{$link}</a><br />Nom: {$username}{if not empty($password)}<br />Mot de passe: {$password}{/if}<br />{if $pass_reset eq 2}<br />Remarque: Nous vous recommandons de changer votre mot de passe avant d\'utiliser votre compte.<br />{elseif $pass_reset eq 1}<br />Remarque: Vous devez changer votre mot de passe avant d\'utiliser votre compte.<br />{/if}<br />Ceci est un message automatique envoyé à votre boîte de réception e-mail à partir du site {$site_name}. Si vous ne comprenez rien au sujet du contenu de cette lettre, supprimer tout simplement.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_VERIFY_EMAIL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'E-mail de confirmation pour changer l\'e-mail du compte',
    's' => 'Infos d\'activation de changement d\'email',
    'c' => '{$greeting_user}<br /><br />Vous avez demandé l\'utilisation du mode sans échec sur le site {$site_name}. Pour valider le changement, vous devez declarer votre nouvel email en saisissant le code de certifier en dessous dans le zone Modification des infos:<br /><br />Code de certifier: <strong>{$code}</strong><br /><br />Ce code est utilisable jusqu\'à {$deadline}.<br /><br />C\'est un courier automatique qui est envoyé à votre email à partir du site {$site_name}. SI vous ne comprenez pas le contenu de ce courrier vous pouvez le supprimer simplement.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_GROUP_JOIN] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Avis demandant de rejoindre le groupe',
    's' => 'Demander à joindre le groupe',
    'c' => 'Bonjour chef <strong>{$group_name}</strong>,<br /><br /><strong>{$full_name}</strong> a envoyé la demande à rejoindre le groupe <strong>{$group_name}</strong> parce que vous gérez. Vous devez approuver cette demande!<br /><br />S\'il vous plaît visitez <a href="{$link}">ce lien</a> d\'approuver l\'adhésion.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_LOST_ACTIVE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Renvoyer les informations d\'activation du compte',
    's' => 'Activer le compte',
    'c' => '{$greeting_user}<br /><br />Votre compte dans le site Web {$site_name} est en attendant d\'être activé. Pour l\'activer, vous cliquez sur le lien au dessous:<br /><br />URL: <a href="{$link}">{$link}</a><br />Les informations nécessaires:<br />Compte: {$username}<br />Email: {$email}<br />Mot de passe: {$password}<br /><br />L\'activation du compte n\'est disponible que jusqu\'à {$active_deadline}<br /><br />Ce mail vous est envoyé automatiquement à partir du site Web {$site_name}. Si vous ne comprenez pas le contenu de ce mail, vous pouvez le supprimer simplement.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_LOST_PASS] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Instructions pour récupérer le mot de passe du membre',
    's' => 'Guide de rechercher le mot de passe',
    'c' => '{$greeting_user}<br /><br />Vous proposez de changer mon mot de passe de connexion sur le site {$site_name}. Pour changer votre mot de passe, vous devrez saisir le code de vérification ci-dessous dans la case correspondante dans la zone de changement de mot de passe.<br /><br />Le code de vérification: <strong>{$code}</strong><br /><br />Ce code n\'est utilisé qu\'une seule fois et avant la date limite de: {$deadline}.<br /><br />Cette lettre est automatiquement envoyée dans votre boîte de réception e-mail depuis le site {$site_name}. Si vous ne comprenez rien au contenu de cette lettre, supprimez-la simplement. Si vous ne comprenez rien au contenu de cette lettre, supprimez-la simplement.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_DELETE] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Notez que le compte administrateur a été supprimé',
    's' => 'Notification du site {$site_name}',
    'c' => 'L\'administrateur du site {$site_name} informe:<br />Votre compte d\'administration sur le site {$site_name} est supprimé au {$time}{if not empty($note)} en raison de: {$note}{/if}.<br />Toute proposition, question... veuillez envoyer un e-mail à <a href="mailto:{$email}">{$email}</a>{if not empty($username)}<br/><br/>{$sig}<br/><br/>{$username}<br/>{$position}<br/>{$email}{/if}'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_SUSPEND] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Avis de suspension de l\'administration du site',
    's' => 'Notification du site {$site_name}',
    'c' => 'L\'administrateur du site {$site_name} informe:<br />Votre compte d\'administration sur le site {$site_name} est suspendu au {$time} en raison: {$note}.<br />Toute proposition, question... veuillez envoyer un e-mail à <a href="mailto:{$email}">{$email}</a>{if not empty($username)}<br/><br/>{$sig}<br/><br/>{$username}<br/>{$position}<br/>{$email}{/if}'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_REACTIVE] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Avis de réactivation de l\'administration du site',
    's' => 'Notification du site {$site_name}',
    'c' => 'L\'administrateur du site {$site_name} informe:<br />Votre compte d\'administration sur le site {$site_name} est rétabli au {$time}.<br />Ce compte avait été suspendu en raison: {$note}{if not empty($username)}<br/><br/>{$sig}<br/><br/>{$username}<br/>{$position}<br/>{$email}{/if}'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTO_ERROR_REPORT] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_SYSTEM,
    't' => 'Erreur de notification automatique par courrier électronique',
    's' => 'Notification du site {$site_name}',
    'c' => 'Le système a reçu des notifications. Veuillez étudier le fichier attaché pour les détails'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_R2S] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notez que l\'authentification en deux étapes a été supprimée avec succès',
    's' => 'La vérification en deux étapes est désactivée',
    'c' => '{$greeting_user}<br /><br />À votre demande, nous avons désactivé la vérification en deux étapes pour votre compte sur le site Web {$site_name}.<br /><br />Il s\'agit d\'un envoi automatique d\'e-mail depuis le site Web {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_R2S_REQUEST] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Instructions pour désactiver l\'authentification en deux étapes lorsque vous oubliez votre code',
    's' => 'Informations sur la désactivation de la vérification en deux étapes',
    'c' => '{$greeting_user}<br /><br />Nous avons reçu une demande de suppression de la vérification en deux étapes pour votre compte sur le site Web {$site_name}. Si vous avez envoyé cette demande vous-même, veuillez utiliser le code de vérification ci-dessous pour procéder à la suppression:<br /><br />Code de vérification: <strong>{$code}</strong><br /><br />Il s\'agit d\'un envoi automatique d\'e-mail depuis le site Web {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_LEADER_ADD] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'La notification oauth est ajoutée au compte par le chef d\'équipe',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Nous vous informons qu\'un compte tiers <strong>{$oauth_name}</strong> vient d\'être connecté à votre compte <strong>{$username}</strong> par le chef d\'équipe.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Gérer les comptes tiers</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_SELF_ADD] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'La notification oauth est ajoutée au compte par l\'utilisateur lui-même',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Le compte tiers <strong>{$oauth_name}</strong> vient d\'être connecté à votre compte <strong>{$username}</strong>. Si ce n\'était pas votre intention, veuillez le supprimer rapidement de votre compte en vous rendant dans la zone de gestion des comptes tiers.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Gérer les comptes tiers</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_LEADER_DEL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'La notification oauth est supprimée du compte par le chef d\'équipe',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Nous vous informons que le compte tiers <strong>{$oauth_name}</strong> vient d\'être déconnecté de votre compte <strong>{$username}</strong> par le chef d\'équipe.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Gérer les comptes tiers</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_SELF_DEL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'La notification oauth est supprimée du compte par l\'utilisateur lui-même',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Le compte tiers <strong>{$oauth_name}</strong> vient d\'être déconnecté de votre compte <strong>{$username}</strong>. Si ce n\'est pas votre intention, veuillez contacter rapidement l\'administrateur du site pour obtenir de l\'aide.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Gérer les comptes tiers</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_VERIFY_EMAIL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Envoyez un code de vérification par e-mail lors de la connexion via Oauth et l\'e-mail correspond à votre compte existant',
    's' => 'Nouvelle vérification par e-mail',
    'c' => 'Bonjour!<br /><br />Vous avez envoyé une demande de vérification de votre adresse e-mail: {$email}. Copiez le code ci-dessous et collez-le dans la case Code de vérification sur le site.<br /><br />Code de vérification: <strong>{$code}</strong><br /><br />Ceci est un e-mail envoyé automatiquement depuis site Web {$site_name}.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_EMAIL_CONFIG_TEST] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_SYSTEM,
    't' => 'Envoyer un e-mail de test pour tester la configuration de l\'envoi d\'e-mails',
    's' => 'Tester l\'e-mail',
    'c' => 'Ceci est un courrier électronique de test pour vérifier la configuration du courrier. Supprimez-le simplement!'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_NEWS_SENDMAIL] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_MODULE,
    't' => 'Envoyer un e-mail présentant l\'article à un ami dans le module d\'actualités',
    's' => 'Message de {$from_name}',
    'c' => 'Bonjour!<br />Votre ami {$from_name} aimerait vous présenter l\'article “{$post_name}” sur le site {$site_name}{if not empty($message)} avec le message:<br />{$message}{/if}.<br/>----------<br/><strong>{$post_name}</strong><br/>{$hometext}<br/><br/>Vous pouvez consulter l\'intégralité de l\'article en cliquant sur le lien ci-dessous:<br /><a href="{$link}" title="{$post_name}">{$link}</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_NEWS_REPORT_THANKS] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_MODULE,
    't' => 'Email remerciant la personne qui a signalé l\'erreur sur les actualités du module',
    's' => 'Merci d\'avoir soumis un rapport d\'erreur',
    'c' => 'Bonjour!<br />L\'administration du site Web de {$site_name} vous remercie beaucoup d\'avoir soumis un rapport d\'erreur dans le contenu de l\'article de notre site Web. Nous avons corrigé l\'erreur que vous avez signalée.<br />Nous espérons recevoir votre prochaine aide à l\'avenir. Je vous souhaite toujours la santé, le bonheur et le succès!'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_ADMIN_ACTIVE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Un e-mail avertit les utilisateurs lorsque l\'administrateur active le compte',
    's' => 'Votre compte a été créé',
    'c' => '{$greeting_user}<br /><br />Votre compte sur le site Web {$site_name} est activé. {if empty($oauth_name)}Les informations de connexion est au dessous:<br /><br />URL: <a href="{$link}">{$link}</a><br />Nom de compte: {$username}<br />{if not empty($password)}Mot de passe: {$password}{/if}{else}Pour vous connecter à votre compte, veuillez visiter la page: <a href="{$link}">{$link}</a> et appuyez sur le bouton: <strong>Connectez-vous avec {$oauth_name}</strong>.{if not empty($password)}<br /><br />Vous pouvez également vous connecter en utilisant la méthode habituelle avec les informations suivantes:<br />Nom de compte: {$username}<br />Mot de passe: {$password}{/if}{/if}{if $pass_reset eq 2}<br />Remarque: Nous vous recommandons de changer votre mot de passe avant d\'utiliser votre compte.{elseif $pass_reset eq 1}<br />Remarque: Vous devez changer votre mot de passe avant d\'utiliser votre compte.{/if}<br /><br />Cela est un message automatique qui était envoyé à votre boîte mail à partir du site {$site_name}. Si vous ne comprenez pas le contenu de ce mail, vous pouvez simplement le supprimer.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_REQUEST_RESET_PASS] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'E-mail demandant à l\'utilisateur de modifier son mot de passe',
    's' => '{if $pass_reset eq 2}Changement de mot de passe de compte recommandé{else}Besoin de changer le mot de passe du compte{/if}',
    'c' => '{$greeting_user}<br /><br />L\'administration du site {$site_name} informe: Pour des raisons de sécurité, {if $pass_reset eq 2}nous vous recommandons de modifier{else}vous devez changer{/if} le mot de passe de votre compte dès que possible. Pour modifier votre mot de passe, vous devez d\'abord vous rendre sur la page <a href="{$link}">Gestion du compte personnel</a>, sélectionner le bouton Paramètres du compte, puis le bouton Mot de passe, et suivre les instructions.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_2STEPOFF_BYADMIN] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Notification aux utilisateurs indiquant que l\'authentification en deux étapes a été désactivée par l\'administrateur',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Votre compte vient de voir l\'authentification en deux étapes désactivée par votre administrateur. Nous vous envoyons cet e-mail pour vous informer.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Gérer l\'authentification en deux étapes</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_ADMIN_DEL] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Avertir les utilisateurs lorsque les administrateurs suppriment leur compte tiers',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Nous vous informons que le compte tiers <strong>{$oauth_name}</strong> vient d\'être déconnecté de votre compte par un administrateur.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Gérer les comptes tiers</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_2STEP_ADD] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Notez qu\'une nouvelle méthode d\'authentification en deux étapes a été ajoutée au compte administrateur',
    's' => 'Configurer la vérification en 2 étapes à l\'aide d\'Oauth terminé',
    'c' => '{$greeting_user}<br /><br />L\'administration du site {$site_name} tient à informer:<br />L\'authentification en deux étapes utilisant Oauth dans le panneau d\'administration a été installée avec succès. Vous pouvez utiliser le compte <strong>{$oauth_id}</strong> du fournisseur <strong>{$oauth_name}</strong> pour l\'authentification lorsque vous vous connectez à la zone d\'administration du site.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_2STEP_TRUNCATE] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Notification indiquant que toutes les méthodes d\'authentification en deux étapes ont été supprimées du compte administrateur',
    's' => 'La configuration de l\'authentification en deux étapes avec Oauth a été annulée',
    'c' => '{$greeting_user}<br /><br />L\'administration du site {$site_name} tient à informer:<br />À votre demande, la validation en deux étapes à l\'aide d\'Oauth a été annulée avec succès. Désormais, vous ne pouvez plus utiliser le fournisseur de comptes <strong>{$oauth_id}</strong> pour vous authentifier dans la zone d\'administration du site.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_AUTHOR_2STEP_DEL] = [
    'pids' => '4',
    'catid' => EmailCat::CAT_AUTHOR,
    't' => 'Notez que l\'authentification en deux étapes a été supprimée du compte administrateur',
    's' => 'La configuration de l\'authentification en deux étapes avec Oauth a été annulée',
    'c' => '{$greeting_user}<br /><br />L\'administration du site {$site_name} tient à informer:<br />À votre demande, la validation en deux étapes à l\'aide d\Oauth a été annulée avec succès. Désormais, vous ne pouvez plus utiliser le compte <strong>{$oauth_id}</strong> du fournisseur <strong>{$oauth_name}</strong> pour vous authentifier dans la zone d\'administration du site.'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_OAUTH_TRUNCATE] = [
    'pids' => '3',
    'catid' => EmailCat::CAT_USER,
    't' => 'Avertir les utilisateurs lorsque les administrateurs suppriment tous leurs comptes tiers',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Nous vous informons que tous les comptes tiers ont été déconnectés de votre compte par un administrateur.<br /><br /><a href="{$link}" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px">Gérer les comptes tiers</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_2STEPON] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_USER,
    't' => 'Avis pour activer l\'authentification en deux étapes pour les comptes membres',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Votre compte sur <a href="{$Home}"><strong>{$site_name}</strong></a> vient d\'activer Two-Factor Authentication. Information:<br /><br />- Temps: <strong>{$time}</strong><br />- IP: <strong>{$ip}</strong><br />- Navigateur: <strong>{$browser}</strong><br /><br />Si c\'est vous, ignorez cet email. Si ce n\'est pas vous, votre compte est très probablement volé. Veuillez contacter l\'administrateur du site pour obtenir de l\'aide'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_2STEPOFF] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_USER,
    't' => 'Avis de désactivation de l\'authentification en deux étapes pour les comptes membres',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Votre compte sur <a href="{$Home}"><strong>{$site_name}</strong></a> vient d\'activer Two-Factor Authentication. Information:<br /><br />- Temps: <strong>{$time}</strong><br />- IP: <strong>{$ip}</strong><br />- Navigateur: <strong>{$browser}</strong><br /><br />Si c\'est vous, ignorez cet email. Si ce n\'est pas vous, veuillez vérifier vos informations personnelles à l\'adresse <a href="{$link}">{$link}</a>'
];
$install_lang['emailtemplates']['emails'][EmailTpl::E_USER_2STEPRENEW] = [
    'pids' => '5',
    'catid' => EmailCat::CAT_USER,
    't' => 'Avis de régénération des codes de sauvegarde d\'authentification en deux étapes pour les comptes membres',
    's' => 'Avis de confidentialité',
    'c' => '{$greeting_user}<br /><br />Votre compte sur <a href="{$Home}"><strong>{$site_name}</strong></a> vient de recréer le code de sauvegarde. Information:<br /><br />- Temps: <strong>{$time}</strong><br />- IP: <strong>{$ip}</strong><br />- Navigateur: <strong>{$browser}</strong><br /><br />Si c\'est vous, ignorez cet email. Si ce n\'est pas vous, veuillez vérifier vos informations personnelles à l\'adresse <a href="{$link}">{$link}</a>'
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
