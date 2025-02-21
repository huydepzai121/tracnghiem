<div class="card">
    <div class="table-responsive-lg table-card pb-1">
        <table class="table table-striped align-middle table-sticky mb-0">
            <thead>
                <tr>
                    <th class="text-nowrap" style="width: 5%;">{$LANG->getModule('voting_id')}</th>
                    <th class="text-nowrap">{$LANG->getModule('voting_title')}</th>
                    <th class="text-nowrap text-center">{$LANG->getModule('voting_stat')}</th>
                    <th class="text-nowrap text-center">{$LANG->getModule('voting_active')}</th>
                    <th class="text-nowrap" style="width: 15%;">{$LANG->getModule('voting_func')}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$DATA key=key item=row}
                <tr>
                    <td>{$row.vid}</td>
                    <td>{$row.question}</td>
                    <td class="text-center">{$row.totalvote|dnumber}</td>
                    <td class="text-center">{$LANG->getModule($row.act == 1 ? 'voting_no' : 'voting_yes')}</td>
                    <td>
                        <div class="hstack gap-1">
                            <div class="text-nowrap">
                                <a href="{$row.url_edit}" class="btn btn-secondary btn-sm"><i class="fa fa-fw fa-edit"></i>{$LANG->getGlobal('edit')}</a>
                            </div>
                            <div class="text-nowrap">
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="nv_del_voting" data-checkss="{$row.checksess}" data-vid="{$row.vid}"><i class="fa-solid fa-trash" data-icon="fa-trash"></i> {$LANG->getGlobal('delete')}
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>
