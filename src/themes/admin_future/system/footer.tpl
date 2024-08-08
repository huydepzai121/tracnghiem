    [THEME_ERROR_INFO]
    <div id="site-modal" class="modal fade" tabindex="-1" aria-labelledby="site-modal-label" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fs-5 modal-title" id="site-modal-label">&nbsp;</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{$LANG->getGlobal('close')}"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center"><i class="fa-solid fa-2x fa-spinner fa-spin-pulse"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div id="site-toasts" class="site-toasts d-none">
        <div class="position-relative toast-lists p-3">
            <div class="toast-items" aria-live="polite" aria-atomic="true">
            </div>
        </div>
    </div>
    {if $IS_IE}
    <div class="nv-offcanvas text-bg-warning p-3 show">
        {$LANG->getGlobal('chromeframe')}
    </div>
    {/if}
    <script type="text/javascript" src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/js/nv.core.js"></script>
    {if not empty($GCONFIG.notification_active) and !($MODULE_NAME eq 'siteinfo' and $OP eq 'notification')}
    <script src="{$smarty.const.ASSETS_STATIC_URL}/js/jquery/jquery.timeago.js"></script>
    <script src="{$smarty.const.ASSETS_STATIC_URL}/js/language/jquery.timeago-{$smarty.const.NV_LANG_INTERFACE}.js"></script>
    <script src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/js/nv.notification.js"></script>
    {/if}
</body>
</html>
