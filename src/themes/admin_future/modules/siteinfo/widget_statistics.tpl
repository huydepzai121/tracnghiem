<div class="card-body d-flex flex-column{if not empty($STATS)} pb-0{/if}">
    <h5 class="card-title">{$LANG->getModule('moduleInfo')}</h5>
    {if empty($STATS)}
    <div class="alert alert-info mb-0" role="alert">{$LANG->getModule('pendingInfo')}</div>
    {else}
    <div class="flex-grow-1 flex-shrink-1 table-card table-card-widget">
        <div class="widget-scroller" data-nv-toggle="scroll">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        {foreach from=$STATS item=modinfo}
                        {foreach from=$modinfo.field item=st}
                        <tr>
                            <td style="width: 30%;">{$modinfo.caption}</td>
                            <td style="width: 45%;">
                                {if not empty($st.link)}
                                <a href="{$st.link}" title="{$st.key}">{$st.key}</a>
                                {else}
                                {$st.key}
                                {/if}
                            </td>
                            <td style="width: 25%;" class="text-end">{$st.value}</td>
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
