    <script type="text/javascript" src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/js/nv.core.js"></script>
    {if not empty($GCONFIG.notification_active)}
    <script src="{$smarty.const.ASSETS_STATIC_URL}/js/jquery/jquery.timeago.js"></script>
    <script src="{$smarty.const.ASSETS_STATIC_URL}/js/language/jquery.timeago-{$smarty.const.NV_LANG_INTERFACE}.js"></script>
    <script src="{$smarty.const.NV_BASE_SITEURL}themes/{$ADMIN_INFO.admin_theme}/js/nv.notification.js"></script>
    {/if}
</body>
</html>
