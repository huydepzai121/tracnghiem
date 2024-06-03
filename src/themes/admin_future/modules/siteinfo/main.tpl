{if $PACKAGE_UPDATE}
<div class="card text-bg-primary mb-4" id="notice-update-package">
    <div class="card-body text-center">
        <p class="mb-2">{$LANG->getModule('update_package_detected')}</p>
        <div>
            <a href="{$smarty.const.NV_BASE_SITEURL}install/update.php" class="btn btn-secondary btn-space"><i class="fa-solid fa-arrow-up-from-bracket text-primary"></i> {$LANG->getModule('update_package_do')}</a>
            <a href="#" class="btn btn-secondary btn-space" data-toggle="deleteUpdPkg" data-checksess="{$smarty.const.NV_CHECK_SESSION}"><i class="fa-solid fa-trash text-danger" data-icon="fa-trash"></i> {$LANG->getModule('update_package_delete')}</a>
        </div>
    </div>
</div>
{/if}
{if not empty($WIDGETS)}
<div class="widget-containers">
    <div class="row">
        {foreach from=$TCONFIG.widgets item=widget_id}
        {if isset($WIDGETS[$widget_id])}
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    {$WIDGETS[$widget_id]}
                </div>
            </div>
        </div>
        {/if}
        {/foreach}
    </div>
</div>
{/if}
