<div class="card card-table card-footer-nav">
    <div class="card-body">
        <form action="{$NV_BASE_ADMINURL}index.php" method="get">
            <input type="hidden" name="{$NV_LANG_VARIABLE}" value="{$NV_LANG_DATA}">
            <input type="hidden" name="{$NV_NAME_VARIABLE}" value="{$MODULE_NAME}">
            <input type="hidden" name="{$NV_OP_VARIABLE}" value="{$OP}">
            <div class="row card-body-search-form">
                <div class="col-12 col-lg-12 col-xl-6 mb-lg-2 mb-xl-0">
                    <div class="row">
                        <div class="col-12 col-lg-5">
                            <label>{$LANG->getModule('keywords')}:</label>
                            <input type="text" class="form-control form-control-xs" name="q" value="{$SEARCH.q}">
                        </div>
                        <div class="col-12 col-lg-7">
                            <div class="row">
                                <div class="col-6">
                                    <label>{$LANG->getModule('from')}:</label>
                                    <input type="text" class="form-control form-control-xs bsdatepicker" name="f" value="{$SEARCH.from}" autocomplete="off">
                                </div>
                                <div class="col-6">
                                    <label>{$LANG->getModule('to')}:</label>
                                    <input type="text" class="form-control form-control-xs bsdatepicker" name="t" value="{$SEARCH.to}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-xl-6">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label>{$LANG->getModule('tpl_incat')}:</label>
                            <select class="form-control form-control-xs select2" name="c">
                                <option value="0">{$LANG->getModule('all')}</option>
                                {foreach from=$CATS item=cat}
                                <option value="{$cat.catid}"{if $cat.catid eq $SEARCH.catid} selected="selected"{/if}>{$cat.title}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label>&nbsp;</label>
                            <div>
                                <button class="btn btn-primary" type="submit">
                                    <i class="icon icon-left fas fa-search"></i> {$LANG->getGlobal('search')}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-nowrap" style="width: 40%;">{$LANG->getModule('tpl_title')}</th>
                        <th class="text-nowrap" style="width: 30%;">{$LANG->getModule('tpl_incat')}</th>
                        <th class="text-nowrap" style="width: 20%;">{$LANG->getModule('add_edit')}</th>
                        <th class="text-nowrap text-right" style="width: 10%;">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$DATA item=row}
                    <tr>
                        <td>
                            <div>
                                {if $row.is_disabled}<i class="text-muted fas fa-times-circle" title="{$LANG->get('tpl_is_disabled')}"></i>{else}<i class="text-success fas fa-check-circle" title="{$LANG->get('tpl_is_active')}"></i>{/if}
                                {if $row.is_disabled}<span class="text-muted">{$row.title}</span> <span class="badge badge-secondary">{$LANG->get('tpl_is_disabled_label')}</span>{else}{$row.title}{/if}{if not $row.is_system} <span class="badge badge-danger">{$LANG->get('tpl_custom_label')}</span>{/if}
                            </div>
                        </td>
                        <td>
                            {if isset($CATS[$row.catid])}
                            <a href="{$NV_BASE_ADMINURL}?index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&amp;{$NV_NAME_VARIABLE}={$MODULE_NAME}&amp;{$NV_OP_VARIABLE}={$OP}&amp;c={$row.catid}">{$CATS[$row.catid].title}</a>
                            {else}
                            #{$row.catid}
                            {/if}
                        </td>
                        <td class="cell-detail">
                            <span>{"H:i d/m/Y"|date:$row.time_add}</span>
                            {if not empty($row.time_update)}<span class="cell-detail-description">{"H:i d/m/Y"|date:$row.time_update}</span>{/if}
                        </td>
                        <td class="text-nowrap text-right">
                            <a href="{$NV_BASE_ADMINURL}?index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&amp;{$NV_NAME_VARIABLE}={$MODULE_NAME}&amp;{$NV_OP_VARIABLE}=test&amp;emailid={$row.emailid}" class="text-muted" title="{$LANG->get('test')}"><i class="fas fa-paper-plane"></i></a>
                            <a href="{$NV_BASE_ADMINURL}?index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&amp;{$NV_NAME_VARIABLE}={$MODULE_NAME}&amp;{$NV_OP_VARIABLE}=contents&amp;copyid={$row.emailid}" class="text-muted ml-1" title="{$LANG->get('copy')}"><i class="fas fa-copy"></i></a>
                            <a href="{$NV_BASE_ADMINURL}?index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&amp;{$NV_NAME_VARIABLE}={$MODULE_NAME}&amp;{$NV_OP_VARIABLE}=contents&amp;emailid={$row.emailid}" class="text-muted ml-1" title="{$LANG->get('edit')}"><i class="fas fa-edit"></i></a>
                            {if not $row.is_system}<a href="#" class="text-danger ml-1" title="{$LANG->get('delete')}" data-toggle="deltpl" data-emailid="{$row.emailid}"><i class="fas fa-trash-alt"></i></a>{/if}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    {if not empty($GENERATE_PAGE)}
    <div class="card-footer">
        {$GENERATE_PAGE}
    </div>
    {/if}
</div>
<link data-offset="0" rel="stylesheet" href="{$NV_BASE_SITEURL}{$NV_ASSETS_DIR}/js/select2/select2.min.css"/>
<link data-offset="0" rel="stylesheet" href="{$NV_BASE_SITEURL}{$NV_ASSETS_DIR}/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="{$NV_BASE_SITEURL}{$NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{$NV_BASE_SITEURL}{$NV_ASSETS_DIR}/js/select2/i18n/{$NV_LANG_INTERFACE}.js"></script>
<script src="{$NV_BASE_SITEURL}{$NV_ASSETS_DIR}/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="{$NV_BASE_SITEURL}{$NV_ASSETS_DIR}/js/bootstrap-datepicker/locales/bootstrap-datepicker.{$NV_LANG_INTERFACE}.min.js"></script>
<script>
$(document).ready(function() {
    $(".bsdatepicker").datepicker({
        autoclose: 1,
        templates: {
            rightArrow: '<i class="fas fa-chevron-right"></i>',
            leftArrow: '<i class="fas fa-chevron-left"></i>'
        },
        language: '{$NV_LANG_INTERFACE}',
        orientation: 'auto bottom',
        todayHighlight: true,
        format: 'dd-mm-yyyy'
    });
});
</script>
