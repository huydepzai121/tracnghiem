<!-- BEGIN: main -->
<h1 class="m-bottom pull-left">{LANG.history_detail}</h1>
<ul class="list-inline pull-right">
    <li><a href="{EXAM_INFO.link}" class="btn btn-default btn-xs"><em class="fa fa-refresh">&nbsp;</em>{LANG.retest}</a></li>
    <!-- BEGIN: del_history -->
    <li><a href="" class="btn btn-danger btn-xs" onclick="nv_test_delete_history({ANSWER_INFO.id}, '{OP}');"><em class="fa fa-trash-o">&nbsp;</em>{LANG.delete}</a></li>
    <!-- END: del_history -->
</ul>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">{LANG.exams_info}</div>
            <table class="table">
                <tr>
                    <th width="180">{LANG.exam}</th>
                    <td><a href="{EXAM_INFO.link}" target="_blank">{EXAM_INFO.title}</a></td>
                </tr>
                <tr>
                    <th>{LANG.time_test}</th>
                    <td>{EXAM_INFO.timer} {LANG.min}</td>
                </tr>
                <tr>
                    <th>{LANG.exams_type}</th>
                    <td>{EXAM_INFO.type}</td>
                </tr>
                <tr>
                    <th>{LANG.exams_report_total_question}</th>
                    <td>{EXAM_INFO.num_question}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">{LANG.tester_info}</div>
            <table class="table">
                <tr>
                    <th width="180">{LANG.time_testting}</th>
                    <td>{ANSWER_INFO.time_test}</td>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th>{LANG.question_true}</th>
                    <td>{ANSWER_INFO.count_true}</td>
                    <th width="100">{LANG.question_false}</th>
                    <td>{ANSWER_INFO.count_false}</td>
                </tr>
                <tr>
                    <th>{LANG.question_skeep}</th>
                    <td>{ANSWER_INFO.count_skeep}</td>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th>{LANG.score}</th>
                    <td>{ANSWER_INFO.score}</td>
                    <th>{LANG.rating}</th>
                    <td>{ANSWER_INFO.rating.title}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="row">{VIEW_ANSWER}</div>
<!-- END: main -->