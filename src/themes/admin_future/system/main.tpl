{include file='header.tpl'}
<header class="header-outer border-bottom">
    <div class="header-inner d-flex">
        <div class="site-brand text-center">
            <a class="logo" href="{$smarty.const.NV_BASE_SITEURL}{$smarty.const.NV_ADMINDIR}/index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}">
                <img src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/images/logo.png" alt="{$GCOMFIG.site_name}">
            </a>
            <a class="logo-sm d-none" href="{$smarty.const.NV_BASE_SITEURL}{$smarty.const.NV_ADMINDIR}/index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}">
                <img src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/images/logo-sm.png" alt="{$GCOMFIG.site_name}">
            </a>
        </div>
        <div class="site-header flex-grow-1 flex-shrink-1 d-flex align-items-center justify-content-between px-4">
            <div class="header-left">
                <a href="#" class="left-sidebar-toggle fs-4"><i class="fas fa-bars icon-vertical-center"></i></a>
            </div>
            <div class="header-right d-flex">
                <nav class="main-icons">
                    <ul class="d-flex list-unstyled my-0 ms-0 me-3">
                        <li>
                            <a title="{$LANG->getGlobal('go_clientsector')}" href="{$smarty.const.NV_BASE_SITEURL}index.php?{$smarty.const.NV_LANG_VARIABLE}={if empty($SITE_MODS)}{$smarty.const.NV_LANG_DATA}{else}{$GCONFIG.site_lang}{/if}" class="fs-3"><i class="fas fa-home icon-vertical-center"></i></a>
                        </li>
                        <li>
                            <a href="#" class="fs-3"><i class="fas fa-bell icon-vertical-center"></i></a>
                        </li>
                        <li>
                            <a href="#" class="fs-3"><i class="fas fa-th icon-vertical-center"></i></a>
                        </li>
                        <li>
                            <a href="#" class="fs-3"><i class="fas fa-cog icon-vertical-center"></i></a>
                        </li>
                    </ul>
                </nav>
                <div class="admin-info">
                    <a href="#" class="admin-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" data-bs-offset="12,10">
                        {if not empty($ADMIN_INFO.avata)}
                        <img alt="{$ADMIN_INFO.full_name}" src="{$ADMIN_INFO.avata}">
                        {elseif not empty($ADMIN_INFO.photo)}
                        <img alt="{$ADMIN_INFO.full_name}" src="{$smarty.const.NV_BASE_SITEURL}{$ADMIN_INFO.photo}">
                        {else}
                        <i class="fa-solid fa-circle-user icon-vertical-center"></i>
                        {/if}
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
<nav class="left-sidebar border-end"></nav>
<div class="body">
    <section class="main-content px-4">
        {$MODULE_CONTENT}
    </section>
</div>
<aside class="right-sidebar border-start">RIGHT</aside>
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
