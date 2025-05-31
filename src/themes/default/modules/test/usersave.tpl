<!-- BEGIN: main -->
<h1 class="m-bottom">{LANG.history}</h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-middle">
        <thead>
        <tr>
            <th width="50" class="text-center">{LANG.number}</th>
            <th>{LANG.exam}</th>
            <th width="130" class="text-center">{LANG.add_time}</th>
            <th width="100" class="text-center"></th>
        </tr>
        </thead>
        <tbody>
        <!-- BEGIN: loop -->
        <tr>
            <td class="text-center">{VIEW.number}</td>
            <td><a href="{VIEW.link}" title="{VIEW.exam.title}" target="_blank"><strong>{VIEW.exam.title}</strong></a></td>
            <td class="text-center">{VIEW.add_time}</td>
            <td class="text-center"><a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_test_delete_usersave({VIEW.examid}, '{OP}');" title="{LANG.delete}"><em class="fa fa-trash-o"></em> {LANG.delete}</a></td>
        </tr>
        <!-- END: loop -->
        </tbody>
    </table>
</div>
<!-- BEGIN: generate_page -->
<div class="text-center">{NV_GENERATE_PAGE}</div>
<!-- END: generate_page -->
<!-- END: main -->