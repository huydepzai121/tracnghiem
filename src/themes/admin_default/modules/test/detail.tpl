<!-- BEGIN: main -->
<ul class="list-inline pull-right">
    <li><a class="btn btn-default btn-xs" href="#" title="{LANG.content_view}" onclick="nv_view_content(0, {ROW.id}, '{ROW.title}'); return !1;"><em class="fa fa-search">&nbsp;</em>{LANG.content_view}</a></li>
    <li><a class="btn btn-default btn-xs" href="{EDIT_LINK}" title="{LANG.edit}"><i class="fa fa-edit">&nbsp;</i>{LANG.edit}</a></li>
    <li><a class="btn btn-warning btn-xs" href="{BACK_LINK}"><em class="fa fa-reply">&nbsp;</em>{LANG.back}</a></li>
</ul>
<div class="clearfix"></div>
<div class="panel panel-default">
    <div class="panel-heading">{LANG.exams_info}</div>
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr></tr>
            <tr>
                <th>{LANG.title}</th>
                <td>{ROW.title}</td>
                <th>{LANG.cat}</th>
                <td>{ROW.catid}</td>
            </tr>
            <tr>
                <th>{LANG.topics}</th>
                <td colspan='3'>{ROW.topicid}</td>
            </tr>
            <tr>
                <th>{LANG.exams_hometext}</th>
                <td colspan='3'>{ROW.hometext}</td>
            </tr>
            <tr>
                <th>{LANG.exams_description}</th>
                <td colspan='3'>{ROW.description}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{LANG.exams_config}</div>
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr></tr>
            <tr>
                <th>{LANG.exams_type}</th>
                <td>{ROW.type}</td>
                <th>{LANG.ladder}</th>
                <td>{ROW.ladder}</td>
            </tr>
            <tr>
                <th>{LANG.num_question}</th>
                <td>{ROW.num_question}</td>
                <th>{LANG.exams_per_page}</th>
                <td>{ROW.per_page}</td>
            </tr>
            <tr>
                <th>{LANG.timer}</th>
                <td colspan='3'>{ROW.hometext}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal fade modal-fullscreen printable" id="full-sitemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">&nbsp;</h3>
            </div>
            <div class="modal-body">
                <em class="fa fa-spinner fa-spin">&nbsp;</em>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="btn-print">
                    <em class="fa fa-print">&nbsp;</em>{LANG.print}
                </button>
                <!-- <a href="{ROW.link_toword}" target="_blank" class="btn btn-primary" id="toword"><em class="fa fa-file-word-o">&nbsp;</em>{LANG.toword}</a> -->
                <button type="button" class="btn btn-default" data-dismiss="modal">{LANG.close}</button>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN: modal -->
<div class="printMe">
    <!-- BEGIN: loop -->
    <div class="question-border">
        <p class="m-bottom">
            <strong>{LANG.question_s} {DATA.stt}: {DATA.title}</strong>
        </p>
        <div class="row">
            <!-- BEGIN: answer -->
            <div class="col-xs-24 col-sm-12 col-md-12">
                <label> <strong class="">{ANSWER.letter}.</strong> {ANSWER.content}
                </label>
            </div>
            <!-- END: answer -->
        </div>
    </div>
    <!-- END: loop -->
</div>
<script>
    $('#btn-print').click(function() {
        $('.printMe').printElem();
    });
</script>
<!-- END: modal -->
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/nvtest_notify.min.js"></script>
<!-- END: main -->