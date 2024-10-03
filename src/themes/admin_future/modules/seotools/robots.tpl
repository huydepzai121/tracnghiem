<form action="{$smarty.const.NV_BASE_ADMINURL}index.php?{$smarty.const.NV_LANG_VARIABLE}={$smarty.const.NV_LANG_DATA}&amp;{$smarty.const.NV_NAME_VARIABLE}={$MODULE_NAME}&amp;{$smarty.const.NV_OP_VARIABLE}={$OP}" method="post">
    <div class="table-responsive-lg">
        <table class="table table-striped table-bordered table-hover table-sticky">
            <thead>
                <tr class="text-center">
                    <th class="text-nowrap" style="width: 1%;">{$LANG->getModule('robots_number')}</th>
                    <th class="text-nowrap" style="width: 49%;">{$LANG->getModule('robots_filename')}</th>
                    <th class="text-nowrap" style="width: 50%;">{$LANG->getModule('robots_type')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var="stt" value=1 nocache}
                {foreach from=$FILES item=file}
                <tr>
                    <td class="text-center">{$stt++}</td>
                    <td class="text-break">{$file.filename}</td>
                    <td>
                        <select name="filename[{$file.filename}]" class="form-select">
                            {for $type=0 to 2}
                            <option value="{$type}"{if $type eq $file.type} selected{/if}>{$LANG->getModule("robots_type_`$type`")}</option>
                            {/for}
                        </select>
                    </td>
                </tr>
                {/foreach}
                {foreach from=$ROBOTS_OTHER key=file item=value}
                <tr>
                    <td class="text-center">{$stt++}</td>
                    <td><input class="form-control" type="text" value="{$file}" name="fileother[{$stt}]" /></td>
                    <td>
                        <select name="optionother[{$stt}]" class="form-select">
                            {for $type=0 to 2}
                            <option value="{$type}"{if $type eq $value} selected{/if}>{$LANG->getModule("robots_type_`$type`")}</option>
                            {/for}
                        </select>
                    </td>
                </tr>
                {/foreach}
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center" colspan="3">
                        <input type="hidden" name="checkss" value="{$CHECKSS}">
                        <button type="submit" class="btn btn-primary">{$LANG->getGlobal('submit')}</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</form>
