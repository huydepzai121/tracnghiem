<div class="row g-4">
    <div class="col-xl-6 order-xl-2">
        <form method="post" data-toggle="formLinkTags" data-error="{$LANG->getModule('linkTags_rel_val_required')}" action="{$smarty.const.NV_BASE_ADMINURL}index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}&amp;{$smarty.const.NV_NAME_VARIABLE}={$MODULE_NAME}&amp;{$smarty.const.NV_OP_VARIABLE}={$OP}" novalidate>
            <div class="card border-primary border-3 border-bottom-0 border-start-0 border-end-0">
                <div class="card-header fs-5 fw-medium py-2">{$LANG->getModule('linkTags_add')}</div>
                <div class="card-body">
                    <div class="table-card">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">{$LANG->getModule('linkTags_attribute')}</th>
                                    <th style="width: 60%;">{$LANG->getModule('linkTags_value')}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="linktags_attribute[]" value="rel" readonly="readonly"></td>
                                    <td><input type="text" class="form-control required rel-val" name="linktags_value[]" value="" maxlength="255"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" name="linktags_attribute[]" value="" maxlength="100"></td>
                                    <td><input type="text" class="form-control" name="linktags_value[]" value="" maxlength="255"></td>
                                </tr>
                                <tr class="sample d-none">
                                    <td><input type="text" class="form-control" name="linktags_attribute[]" value="" maxlength="100"></td>
                                    <td><input type="text" class="form-control" name="linktags_value[]" value="" maxlength="255"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <input type="hidden" name="key" value="">
                                        <input type="hidden" name="add" value="1">
                                        <input type="hidden" name="checkss" value="{$CHECKSS}">
                                        <button type="button" class="btn btn-secondary" data-toggle="addLinkTagsAttr">{$LANG->getModule('linkTags_add_attribute')}</button>
                                        <button type="submit" class="btn btn-primary">{$LANG->getGlobal('submit')}</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer border-top">
                    <div class="fw-medium">{$LANG->getModule('linkTags_acceptVars')}:</div>
                    {$ACCEPTVARS}
                </div>
            </div>
        </form>
        {if not empty($LINKTAGS)}
        <div class="mt-4">
            <div class="accordion" id="accordionLinkTags">
                {foreach from=$LINKTAGS key=key item=linkData}
                {assign var="tagTitle" value=[] nocache}
                {foreach from=$linkData key=attr item=value}
                {assign var="tagTitle" value=array_merge($tagTitle, [$attr|cat:(not empty($value) ? ('=&quot;'|cat:$value|cat:'&quot;') : '')]) nocache}
                {/foreach}
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLinkTags{$key}" aria-expanded="false" aria-controls="collapseLinkTags{$key}">
                            &lt;link {join($tagTitle, ' ')}/&gt;
                        </button>
                    </div>
                    <div id="collapseLinkTags{$key}" class="accordion-collapse collapse" data-bs-parent="#accordionLinkTags">
                        <div class="accordion-body">
                            <form method="post" data-toggle="formLinkTags" data-error="{$LANG->getModule('linkTags_rel_val_required')}" action="{$smarty.const.NV_BASE_ADMINURL}index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}&amp;{$smarty.const.NV_NAME_VARIABLE}={$MODULE_NAME}&amp;{$smarty.const.NV_OP_VARIABLE}={$OP}" novalidate>
                                <div class="table-accordion">
                                    <table class="table table-striped align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%;">{$LANG->getModule('linkTags_attribute')}</th>
                                                <th style="width: 60%;">{$LANG->getModule('linkTags_value')}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" class="form-control" name="linktags_attribute[]" value="rel" readonly="readonly"></td>
                                                <td><input type="text" class="form-control required rel-val" name="linktags_value[]" value="{$linkData.rel}" maxlength="255"></td>
                                            </tr>
                                            {foreach from=$linkData key=attr item=value}
                                            {if $attr neq 'rel'}
                                            <tr>
                                                <td><input type="text" class="form-control" name="linktags_attribute[]" value="{$attr}" maxlength="100"></td>
                                                <td><input type="text" class="form-control" name="linktags_value[]" value="{$value}" maxlength="255"></td>
                                            </tr>
                                            {/if}
                                            {/foreach}
                                            <tr class="sample d-none">
                                                <td><input type="text" class="form-control" name="linktags_attribute[]" value="" maxlength="100"></td>
                                                <td><input type="text" class="form-control" name="linktags_value[]" value="" maxlength="255"></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="hidden" name="key" value="l-{$key}">
                                                    <input type="hidden" name="add" value="1">
                                                    <input type="hidden" name="checkss" value="{$CHECKSS}">
                                                    <button type="button" class="btn btn-secondary" data-toggle="addLinkTagsAttr">{$LANG->getModule('linkTags_add_attribute')}</button>
                                                    <button type="submit" class="btn btn-primary">{$LANG->getGlobal('submit')}</button>
                                                    <button type="button" class="btn btn-danger" data-toggle="delLinkTagsAttr" data-message="{$LANG->getModule('linkTags_del_confirm')}"><i class="fa-solid fa-trash" data-icon="fa-trash"></i> {$LANG->getGlobal('delete')}</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
        {/if}
    </div>
    <div class="col-xl-6 order-xl-1">
        <form method="post" class="ajax-submit" action="{$smarty.const.NV_BASE_ADMINURL}index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}&amp;{$smarty.const.NV_NAME_VARIABLE}={$MODULE_NAME}&amp;{$smarty.const.NV_OP_VARIABLE}={$OP}" novalidate>
            <div class="card border-primary border-3 border-bottom-0 border-start-0 border-end-0">
                <div class="card-header fs-5 fw-medium py-2">{$LANG->getModule('add_opensearch_link')}</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-primary">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" value="site" name="opensearch_link[site]" id="opensearch_link_site"{if isset($OPENSEARCH_LINK.site)} checked{/if}>
                            <label class="form-check-label fw-medium" for="opensearch_link_site">{$LANG->getModule('add_opensearch_link_all')}</label>
                        </div>
                        <div class="invalid-feedback">{$LANG->getGlobal('required_invalid')}</div>
                    </li>
                    <li class="list-group-item">
                        <div class="mb-3">
                            <label for="shortname_site" class="form-label">{$LANG->getModule('ShortName')}:</label>
                            <input type="text" class="form-control" id="shortname_site" name="shortname[site]" value="{if isset($OPENSEARCH_LINK.site)}{$OPENSEARCH_LINK.site.0}{/if}" maxlength="16" placeholder="{$LANG->getModule('ShortName_note')}">
                        </div>
                        <div class="mb-2">
                            <label for="description_site" class="form-label">{$LANG->getModule('Description')}:</label>
                            <input type="text" class="form-control" id="description_site" name="description[site]" value="{if isset($OPENSEARCH_LINK.site)}{$OPENSEARCH_LINK.site.1}{/if}" maxlength="1024" placeholder="{$LANG->getModule('description_note')}">
                        </div>
                    </li>
                    {foreach from=$SITE_MODS key=mod item=minfo}
                    {if not empty($minfo.is_search)}
                    <li class="list-group-item list-group-item-primary">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" value="{$mod}" name="opensearch_link[{$mod}]" id="opensearch_link_{$mod}"{if isset($OPENSEARCH_LINK[$mod])} checked{/if}>
                            <label class="form-check-label fw-medium" for="opensearch_link_{$mod}">{$minfo.custom_title}</label>
                        </div>
                        <div class="invalid-feedback">{$LANG->getGlobal('required_invalid')}</div>
                    </li>
                    <li class="list-group-item">
                        <div class="mb-3">
                            <label for="shortname_{$mod}" class="form-label">{$LANG->getModule('ShortName')}:</label>
                            <input type="text" class="form-control" id="shortname_{$mod}" name="shortname[{$mod}]" value="{if isset($OPENSEARCH_LINK[$mod])}{$OPENSEARCH_LINK[$mod].0}{/if}" maxlength="16" placeholder="{$LANG->getModule('ShortName_note')}">
                        </div>
                        <div class="mb-2">
                            <label for="description_{$mod}" class="form-label">{$LANG->getModule('Description')}:</label>
                            <input type="text" class="form-control" id="description_{$mod}" name="description[{$mod}]" value="{if isset($OPENSEARCH_LINK[$mod])}{$OPENSEARCH_LINK[$mod].1}{/if}" maxlength="1024" placeholder="{$LANG->getModule('description_note')}">
                        </div>
                    </li>
                    {/if}
                    {/foreach}
                </ul>
                <div class="card-footer border-top">
                    <input type="hidden" name="opensearch" value="1">
                    <input type="hidden" name="checkss" value="{$CHECKSS}">
                    <button type="submit" class="btn btn-primary">{$LANG->getGlobal('submit')}</button>
                </div>
            </div>
        </form>
    </div>
</div>
