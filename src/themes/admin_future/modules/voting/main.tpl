<div class="card">
    <div class="table-responsive-lg table-card pb-1">
        <table class="table table-striped align-middle table-sticky mb-0 list">
            <thead>
                <tr>
                    <th class="w100">{$LANG->getModule('voting_id')}</th>
                    <th>{$LANG->getModule('voting_title')}</th>
                    <th class="w200 text-center">{$LANG->getModule('voting_stat')}</th>
                    <th class="w100 text-center">{$LANG->getModule('voting_active')}</th>
                    <th class="text-nowrap" style="width: 20%;">{$LANG->getModule('voting_func')}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$ROW key=key item=row}
                <tr>
                    <td>{$row.vid}</td>
                    <td>{$row.question}</td>
                    <td class="text-center">{$row.totalvote}</td>
                    <td class="text-center">{$row.status}</td>
                    <td>
                        <div class="row g-1 flex-nowrap">
                            <div class="col-auto text-center">
                                <a href="{$row.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-fw fa-edit"></i>{$LANG->getGlobal('edit')}</a>
                            </div>
                            <div class="col-auto text-center">
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
