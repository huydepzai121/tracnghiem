<!DOCTYPE html>
<html lang="{$smarty.const.NV_LANG_INTERFACE}">
<head>
    <title>{$GCONFIG.site_name}{$smarty.const.NV_TITLEBAR_DEFIS}{$LANG->getGlobal('admin_page')}{$smarty.const.NV_TITLEBAR_DEFIS}{$MODULE_INFO.custom_title}</title>
    <meta name="description" content="{$GCONFIG.site_description ?: {$PAGE_TITLE}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="author" content="{$GCONFIG.site_name} [{$GCONFIG.site_email}]">
    <meta name="generator" content="{$GCONFIG.site_name}">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="content-type" content="text/html; charset={$GCONFIG.site_charset}">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=EmulateIE8; IE=EDGE" />
    <![endif]-->

    <link rel="shortcut icon" href="{$FAVICON}">
    <link rel="stylesheet" href="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/css/nv.style.css">
    {if not empty($CSS_MODULE)}
    <link rel="stylesheet" href="{$CSS_MODULE}" type="text/css">
    {/if}

    <script type="text/javascript">
    var nv_base_siteurl = '{$smarty.const.NV_BASE_SITEURL}',
        nv_assets_dir = '{$smarty.const.NV_ASSETS_DIR}',
        nv_lang_data = '{$smarty.const.NV_LANG_DATA}',
        nv_lang_interface = '{$smarty.const.NV_LANG_INTERFACE}',
        nv_name_variable = '{$smarty.const.NV_NAME_VARIABLE}',
        nv_fc_variable = '{$smarty.const.NV_OP_VARIABLE}',
        nv_lang_variable = '{$smarty.const.NV_LANG_VARIABLE}',
        nv_module_name = '{$MODULE_NAME}',
        nv_func_name = '{$OP}',
        nv_my_ofs = {round($smarty.const.NV_SITE_TIMEZONE_OFFSET / 3600)},
        nv_my_abbr = '{$smarty.const.NV_CURRENTTIME}',
        nv_cookie_prefix = '{$GCONFIG.cookie_prefix}',
        nv_check_pass_mstime = '{($GCONFIG.admin_check_pass_time - 62) * 1000}',
        nv_safemode = {$ADMIN_INFO.safemode},
        nv_area_admin = 1,
        XSSsanitize = {(int) $GCONFIG.admin_XSSsanitize},
        nv_whitelisted_tags = [{if not empty($GCONFIG.allowed_html_tags)}'{implode(', ', $GCONFIG.allowed_html_tags)}'{/if}],
        nv_whitelisted_attr = {$WHITELISTED_ATTR};
    </script>

    <script type="text/javascript" src="{$smarty.const.ASSETS_STATIC_URL}/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="{$smarty.const.ASSETS_LANG_STATIC_URL}/js/language/{$smarty.const.NV_LANG_INTERFACE}{$smarty.const.AUTO_MINIFIED}.js"></script>
    <script type="text/javascript" src="{$smarty.const.ASSETS_STATIC_URL}/js/global{$smarty.const.AUTO_MINIFIED}.js"></script>
    {if $GCONFIG.admin_XSSsanitize}
    <script type="text/javascript" src="{$smarty.const.ASSETS_STATIC_URL}/js/DOMPurify/purify{$IS_IE ? 2 : 3}.js"></script>
    {/if}
    <script type="text/javascript" src="{$smarty.const.ASSETS_STATIC_URL}/js/admin{$smarty.const.AUTO_MINIFIED}.js"></script>
    {if not empty($JS_MODULE)}
    <script type="text/javascript" src="{$JS_MODULE}"></script>
    {/if}
    {if not empty($GCONFIG.passshow_button)}
    <link rel="stylesheet" href="{$smarty.const.ASSETS_STATIC_URL}/js/show-pass-btn/bootstrap3-show-pass.css">
    <script type="text/javascript" src="{$smarty.const.ASSETS_STATIC_URL}/js/show-pass-btn/bootstrap3-show-pass.js"></script>
    {/if}
    <link rel="stylesheet" href="{$smarty.const.ASSETS_STATIC_URL}/js/perfect-scrollbar/style.css">
    <script type="text/javascript" src="{$smarty.const.ASSETS_STATIC_URL}/js/perfect-scrollbar/min.js"></script>
</head>
<body>
