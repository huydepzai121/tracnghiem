{include file='header.tpl'}
<header class="header-outer border-bottom">
    <div class="header-inner d-flex">
        <div class="site-brand text-center">
            <a class="logo" href="{$smarty.const.NV_BASE_SITEURL}{$smarty.const.NV_ADMINDIR}/index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}">
                <img src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/images/logo.png" alt="{$GCONFIG.site_name}">
            </a>
            <a class="logo-sm" href="{$smarty.const.NV_BASE_SITEURL}{$smarty.const.NV_ADMINDIR}/index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}">
                <img src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/images/logo-sm.png" alt="{$GCONFIG.site_name}">
            </a>
        </div>
        <div class="site-header flex-grow-1 flex-shrink-1 d-flex align-items-center justify-content-between px-4">
            <div class="header-left">
                <a href="#" class="left-sidebar-toggle fs-4" data-toggle="left-sidebar"><i class="fas fa-bars icon-vertical-center"></i></a>
            </div>
            <div class="header-right d-flex position-relative">
                <nav class="main-icons">
                    <ul class="d-flex list-unstyled my-0 ms-0 me-3">
                        <li>
                            <a title="{$LANG->getGlobal('go_clientsector')}" href="{$smarty.const.NV_BASE_SITEURL}index.php?{$smarty.const.NV_LANG_VARIABLE}={if empty($SITE_MODS)}{$smarty.const.NV_LANG_DATA}{else}{$GCONFIG.site_lang}{/if}" class="fs-3"><i class="fas fa-home icon-vertical-center"></i></a>
                        </li>
                        {if not empty($GCONFIG.notification_active)}
                        <li class="dropdown-center site-noti" id="main-notifications">
                            <a title="{$LANG->getGlobal('site_info')}" href="#" class="fs-3" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" data-bs-offset="0,11"><i class="fas fa-bell icon-vertical-center"></i></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="noti-heading text-center border-bottom pb-2 fw-medium">
                                    {$LANG->getGlobal('inform_notifications')} <span class="badge rounded-pill text-bg-info">0</span>
                                </div>
                                <div class="noti-body p-1">
                                    <div class="position-relative noti-lists">
                                        <div class="noti-lists-inner"></div>
                                    </div>
                                </div>
                                <div class="noti-footer text-center border-top pt-2">
                                    <a href="{$smarty.const.NV_BASE_SITEURL}{$smarty.const.NV_ADMINDIR}/index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}&amp;{$smarty.const.NV_NAME_VARIABLE}=siteinfo&amp;{$smarty.const.NV_OP_VARIABLE}=notification">{$LANG->getGlobal('view_all')}</a>
                                </div>
                            </div>
                        </li>
                        {/if}
                        <li class="menu-sys" id="menu-sys">
                            <a title="{$LANG->getGlobal('sys_mods')}" href="#" class="fs-3" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" data-bs-display="static"><i class="fas fa-th icon-vertical-center"></i></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="menu-sys-inner position-relative">
                                    <div class="menu-sys-items">
                                        <div class="row">
                                            {foreach from=$ADMIN_MODS key=mname item=mvalue}
                                            {if not empty($mvalue.custom_title)}
                                            {assign var=submenu value=submenu($mname) nocache}
                                            <div class="col-md-3 col-sm-6">
                                                <ul class="list-unstyled mb-4">
                                                    <li class="fs-3 fw-medium mb-2 border-bottom pb-1"><a href="{$smarty.const.NV_BASE_SITEURL}{$smarty.const.NV_ADMINDIR}/index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}&amp;{$smarty.const.NV_NAME_VARIABLE}={$mname}">{$mvalue.custom_title}</a></li>
                                                    {foreach from=$submenu key=mop item=mopname}
                                                    <li class="mb-1"><a href="{$smarty.const.NV_BASE_SITEURL}{$smarty.const.NV_ADMINDIR}/index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}&amp;{$smarty.const.NV_NAME_VARIABLE}={$mname}&amp;{$smarty.const.NV_OP_VARIABLE}={$mop}">{$mopname}</a></li>
                                                    {/foreach}
                                                </ul>
                                            </div>
                                            {/if}
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        {if not empty($LANG_ADMIN)}
                        <li>
                            <a title="{$LANG->getGlobal('langsite')}" href="#" class="fs-3" data-toggle="right-sidebar"><i class="fas fa-cog icon-vertical-center"></i></a title="{$LANG->getGlobal('sys_mods')}">
                        </li>
                        {/if}
                    </ul>
                </nav>
                <div class="admin-info">
                    <a title="{$LANG->getGlobal('admin_account')}" href="#" class="admin-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" data-bs-display="static">
                        <span>
                            {if not empty($ADMIN_INFO.avata)}
                            <img alt="{$ADMIN_INFO.full_name}" src="{$ADMIN_INFO.avata}">
                            {elseif not empty($ADMIN_INFO.photo)}
                            <img alt="{$ADMIN_INFO.full_name}" src="{$smarty.const.NV_BASE_SITEURL}{$ADMIN_INFO.photo}">
                            {else}
                            <i class="fa-solid fa-circle-user icon-vertical-center"></i>
                            {/if}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <li class="px-2">
                            <div class="fw-medium fs-3 mb-2">{$ADMIN_INFO.full_name}</div>
                            <img alt="{$ADMIN_INFO.username}" src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/images/admin{$ADMIN_INFO.level}.png"> {$ADMIN_INFO.username}
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="px-2">
                            <i class="fa fa-caret-right fa-fw"></i> {$LANG->getGlobal('hello_admin2', date('H:i d/m/Y', $ADMIN_INFO.current_login), $ADMIN_INFO.current_ip)}
                        </li>
                        {if not empty($GCONFIG.admin_login_duration)}
                        <li><hr class="dropdown-divider"></li>
                        <li class="px-2">
                            <i class="fa fa-globe fa-spin fa-fw"></i> {$LANG->getGlobal('login_session_expire')} <span id="countdown" data-duration="{($ADMIN_INFO.current_login + $GCONFIG.admin_login_duration - $smarty.const.NV_CURRENTTIME) * 1000}"></span>
                        </li>
                        {/if}
                        {if not empty($ADMIN_INFO.last_login)}
                        <li><hr class="dropdown-divider"></li>
                        <li class="px-2">
                            <i class="fa fa-caret-right fa-fw"></i> {$LANG->getGlobal('hello_admin1', date('H:i d/m/Y', $ADMIN_INFO.last_login), $ADMIN_INFO.last_ip)}
                        </li>
                        {/if}
                        <li><hr class="dropdown-divider"></li>
                        <li class="px-2">
                            <a href="{$smarty.const.NV_BASE_SITEURL}index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}&amp;{$smarty.const.NV_NAME_VARIABLE}=users">
                                <i class="fa fa-arrow-circle-right fa-fw"></i> {$LANG->getGlobal('account_settings')}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="px-2">
                            <a href="{$smarty.const.NV_BASE_ADMINURL}index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}&amp;{$smarty.const.NV_NAME_VARIABLE}=authors&amp;id={$ADMIN_INFO.admin_id}">
                                <i class="fa fa-arrow-circle-right fa-fw"></i> {$LANG->getGlobal('your_admin_account')}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="px-2">
                            <a href="#" data-toggle="admin-logout">
                                <i class="fa fa-power-off text-danger"></i> {$LANG->getGlobal('admin_logout_title')}
                            </a>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<nav class="left-sidebar border-end" id="left-sidebar">
    <div class="left-sidebar-wrapper">
        <a href="#" class="left-sidebar-toggle">{$PAGE_TITLE}</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                        {if !empty($SELECT_OPTIONS)}
                        <li class="parent open">
                            <a href="#"><i class="fas fa-hand-pointer icon" title="{$LANG->get('please_select')}"></i><span>{$LANG->get('please_select')}</span><span class="toggle"><i class="fas"></i></span></a>
                            <ul class="sub-menu">
                                <li class="title">{$LANG->get('please_select')}</li>
                                <li class="nav-items">
                                    <div class="nv-left-sidebar-scroller">
                                        <div class="content">
                                            <ul>
                                                {foreach from=$SELECT_OPTIONS key=seloptlink item=selopttitle}
                                                <li><a href="{$seloptlink}"><span>{$selopttitle}</span></a></li>
                                                {/foreach}
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        <li>
                        {/if}
                        {if !empty($MOD_CURRENT)}
                        <li class="divider">{$LANG->get('interface_current_menu')}</li>
                        <li class="{if !empty($MOD_CURRENT['subs'])}parent {/if}active{if empty($CONFIG_THEME['collapsed_leftsidebar'])} open{/if}">
                            <a href="{$MOD_CURRENT.link}"><i class="{$MOD_CURRENT.icon} icon" title="{$MOD_CURRENT.title}"></i><span>{$MOD_CURRENT.title}</span>{if !empty($MOD_CURRENT['subs'])}<span class="toggle"><i class="fas"></i></span>{/if}</a>
                            {if !empty($MOD_CURRENT['subs'])}
                            <ul class="sub-menu">
                                <li class="title">{$MOD_CURRENT.title}</li>
                                <li class="nav-items">
                                    <div class="nv-left-sidebar-scroller">
                                        <div class="content">
                                            <ul>
                                                <li class="f-link{if $MOD_CURRENT['active']} active{/if}"><a href="{$MOD_CURRENT.link}">{$LANG->get('Home')}</a></li>
                                                {foreach from=$MOD_CURRENT['subs'] item=crrsub}
                                                {if not empty($crrsub['subs'])}
                                                <li class="parent{if $crrsub['active']} active{/if}{if $crrsub['open']} open{/if}">
                                                    <a href="{$crrsub.link}"><span>{$crrsub.title}</span><span class="toggle"><i class="fas"></i></span></a>
                                                    <ul class="sub-menu">
                                                        {foreach from=$crrsub['subs'] item=crrsublv2}
                                                        <li{if $crrsublv2['active']} class="active"{/if}><a href="{$crrsublv2.link}"><span>{$crrsublv2.title}</span></a></li>
                                                        {/foreach}
                                                    </ul>
                                                </li>
                                                {else}
                                                <li{if $crrsub['active']} class="active"{/if}><a href="{$crrsub.link}"><span>{$crrsub.title}</span></a></li>
                                                {/if}
                                                {/foreach}
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            {/if}
                        </li>
                        {/if}
                        {if !empty($MOD_MENU)}
                        <li class="divider">{$LANG->get('interface_other_menu')}</li>
                        {foreach from=$MOD_MENU item=rowmenu}
                        <li{if !empty($rowmenu['subs'])} class="parent"{/if}>
                            <a href="{$rowmenu.link}"><i class="{$rowmenu.icon} icon" title="{$rowmenu.title}"></i><span>{$rowmenu.title}</span>{if !empty($rowmenu['subs'])}<span class="toggle"><i class="fas"></i></span>{/if}</a>
                            {if !empty($rowmenu['subs'])}
                            <ul class="sub-menu">
                                <li class="title">{$rowmenu.title}</li>
                                <li class="nav-items">
                                    <div class="nv-left-sidebar-scroller">
                                        <div class="content">
                                            <ul>
                                                <li class="f-link"><a href="{$rowmenu.link}">{$LANG->get('Home')}</a></li>
                                                {foreach from=$rowmenu['subs'] item=smenutitle key=smenukey}
                                                {if is_array($smenutitle)}
                                                <li class="parent">
                                                    <a href="{$NV_BASE_ADMINURL}index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&amp;{$NV_NAME_VARIABLE}={$rowmenu.name}&amp;{$NV_OP_VARIABLE}={$smenukey}"><span>{$smenutitle.title}</span><span class="toggle"><i class="fas"></i></span></a>
                                                    <ul class="sub-menu">
                                                        {foreach from=$smenutitle.submenu item=sublv2 key=keysublv2}
                                                        <li><a href="{$NV_BASE_ADMINURL}index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&amp;{$NV_NAME_VARIABLE}={$rowmenu.name}&amp;{$NV_OP_VARIABLE}={$keysublv2}"><span>{$sublv2}</span></a></li>
                                                        {/foreach}
                                                    </ul>
                                                </li>
                                                {else}
                                                <li><a href="{$NV_BASE_ADMINURL}index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&amp;{$NV_NAME_VARIABLE}={$rowmenu.name}&amp;{$NV_OP_VARIABLE}={$smenukey}">{$smenutitle}</a></li>
                                                {/if}
                                                {/foreach}
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            {/if}
                        </li>
                        {/foreach}
                        {/if}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="body">
    <section class="main-content px-4">
        [THEME_ERROR_INFO]
        {$MODULE_CONTENT}
    </section>
</div>
{if not empty($LANG_ADMIN)}
<aside class="right-sidebar border-start" id="right-sidebar">
    <div class="right-sidebar-inner">
        <div class="px-3">
            <div class="mb-4">
                <div class="fw-medium border-bottom pb-2 mb-2">{$LANG->getGlobal('langinterface')}</div>
                {foreach from=$LANG_ADMIN key=lang item=langname}
                <div class="form-check mb-1">
                    <input class="form-check-input" type="radio" id="langinterface-{$lang}" value="{$lang}" name="gsitelanginterface"{if $lang eq $smarty.const.NV_LANG_INTERFACE} checked="checked"{/if}>
                    <label class="form-check-label" for="langinterface-{$lang}">{$langname}</label>
                </div>
                {/foreach}
            </div>
            <div class="fw-medium border-bottom pb-2 mb-3">{$LANG->getGlobal('langdata')}</div>
            {foreach from=$LANG_ADMIN key=lang item=langname}
            <div class="form-check mb-1">
                <input class="form-check-input" type="radio" id="langdata-{$lang}" value="{$lang}" name="gsitelangdata"{if $lang eq $smarty.const.NV_LANG_DATA} checked="checked"{/if}>
                <label class="form-check-label" for="langdata-{$lang}">{$langname}</label>
            </div>
            {/foreach}
        </div>
    </div>
</aside>
{/if}
<footer class="site-footer border-top px-4 d-flex align-items-center justify-content-between">
    <div class="site-copyright">
        {if $smarty.const.NV_IS_SPADMIN and $ADMIN_INFO.level eq 1}
        <div class="memory-time-usage text-truncate">[MEMORY_TIME_USAGE]</div>
        {/if}
        <div class="text-truncate fw-medium">{$LANG->getGlobal('copyright', $GCONFIG.site_name)}</div>
    </div>
    <div class="img-stat">
        <a title="NUKEVIET CMS" href="https://nukeviet.vn" target="_blank"><img alt="NUKEVIET CMS" src="{$smarty.const.NV_BASE_SITEURL}{$smarty.const.NV_ASSETS_DIR}/images/banner_nukeviet_88x15.jpg" width="88" height="15" class="imgstatnkv"></a>
    </div>
</footer>
{include file='footer.tpl'}
