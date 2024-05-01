{if not empty($ERROR)}
<div class="alert alert-danger">{"<br />"|implode:$ERROR}</div>
{/if}
{if $SUCCESS}
<div class="alert alert-success">{$LANG->get('test_success')}.</div>
{/if}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="d-flex">
            <div class="flex-grow-1 flex-shrink-1">{$DATA.title}</div>
            <div class="ml-2">
                <a href="{$NV_BASE_ADMINURL}?index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&amp;{$NV_NAME_VARIABLE}={$MODULE_NAME}&amp;{$NV_OP_VARIABLE}=contents&amp;emailid={$DATA.emailid}" class="btn btn-xs btn-default"><i class="fa fa-globe"></i> {$LANG->get('edit_template')}</a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <form method="post" action="{$FORM_ACTION}" autocomplete="off" class="form-horizontal">
            <div class="form-group">
                <label class="col-xs-24 col-sm-6 control-label" for="test_tomail">{$LANG->get('test_tomail')}</label>
                <div class="col-xs-24 col-sm-16 col-lg-12">
                    <textarea rows="3" class="form-control" id="test_tomail" name="test_tomail">{"\n"|implode:$DATA.test_tomail}</textarea>
                    <div class="help-block mb-0 text-muted">{$LANG->get('test_tomail_note')}</div>
                </div>
            </div>
            {if not empty($MERGE_FIELDS)}
            <div class="row">
                <div class="col-xs-24 col-sm-18 col-sm-offset-6">
                    <h3 class="mb-1"><strong>{$LANG->get('test_value_fields')}</strong></h3>
                </div>
            </div>
            {foreach from=$MERGE_FIELDS key=fieldname item=field}
            <div class="form-group">
                <label class="col-xs-24 col-sm-6 control-label" for="f_{$fieldname}">{$field.name}</label>
                <div class="col-xs-24 col-sm-16 col-lg-12">
                    <input type="text" class="form-control" id="f_{$fieldname}" name="f_{$fieldname}" value="{if isset($FIELD_DATA[$fieldname])}{$FIELD_DATA[$fieldname]}{/if}" placeholder="${$fieldname}">
                </div>
            </div>
            {/foreach}
            {/if}
            <div class="row">
                <label class="col-xs-24 col-sm-6 control-label"></label>
                <div class="col-xs-24 col-sm-16 col-lg-12">
                    <input type="hidden" name="tokend" value="{$TOKEND}">
                    <button class="btn btn-space btn-primary" type="submit">{$LANG->get('submit')}</button>
                </div>
            </div>
        </form>
    </div>
</div>
