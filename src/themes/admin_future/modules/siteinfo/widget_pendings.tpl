<div class="card-body d-flex flex-column{if not empty($PENDINGS)} pb-0{/if}">
    <h5 class="card-title">{$LANG->getModule('pendingInfo')}</h5>
    {if empty($PENDINGS)}
    <div class="alert alert-info mb-0" role="alert">{$LANG->getModule('pendingInfo')}</div>
    {else}
    <div class="flex-grow-1 flex-shrink-1 table-card table-card-widget">
        <div class="widget-scroller" data-nv-toggle="scroll">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        {foreach from=$PENDINGS item=modinfo}
                        {foreach from=$modinfo.field item=pd}
                        <tr>
                            <td style="width: 30%;">{$modinfo.caption}</td>
                            <td style="width: 45%;">
                                {if not empty($pd.link)}
                                <a href="{$pd.link}" title="{$pd.key}">{$pd.key}</a>
                                {else}
                                {$pd.key}
                                {/if}
                            </td>
                            <td style="width: 25%;" class="text-end">{$pd.value}</td>
                        </tr>
                        {/foreach}
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {/if}
</div>
