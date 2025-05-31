<!-- BEGIN: main -->
<!-- BEGIN: data -->
<form action="" method="post" id="frm-submit">
    <div id="questionlist">
        <!-- BEGIN: question -->
        <div class="question-box">
            <!-- BEGIN: generaltext -->
            <div class="panel panel-default">
                <div class="panel-body">{QUESTION.generaltext}</div>
            </div>
            <!-- END: generaltext -->
            <div class="panel panel-default question-item">
                <div class="panel-body">
                    <div class="m-bottom">
                        <strong><span class="text-red">{LANG.question} {QUESTION.number}.</span>
                        <!-- BEGIN: bank_type -->                        
                        [{bank_type_title}]
                        <!-- END: bank_type -->                        
                        </strong> {QUESTION.question}
                    </div>
                    <div class="answer">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width = "75">&nbsp;</th>
                                        <th>{LANG.content}</th>
                                        <th width = "250">{LANG.answer}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- BEGIN: answer -->
                                    <tr>
                                        <td class="text-center"><p><strong>{ANSWER.letter}</strong></p></td>
                                        <td>{ANSWER.content}</td>
                                        <td class="text-center">
                                            <!-- BEGIN: question_type_1 -->
                                            <input type="checkbox" class="form-control"<!-- BEGIN: is_true_highlight -->checked<!-- END: is_true_highlight --> disabled>
                                            <!-- END: question_type_1 -->
                                            <!-- BEGIN: question_type_2 -->
                                            <input type="text" class="form-control" value="{ANSWER.is_true}" disabled/>
                                            <!-- END: question_type_2 -->
                                        </td>
                                    </tr>
                                    <!-- END: answer -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- BEGIN: useguide -->
                    <div id="question{QUESTION.number}" class="useguide">
                        <hr>
                        <div class="hidden useguide-content">{QUESTION.useguide}</div>
                        <a href="javascript:void(0);" onclick="nv_test_dipslay_userguide($(this));" data-title="{LANG.useguides}" class="text_view_result" data-opened="0"><em class="fa fa-search">&nbsp;</em><span class="text-green">{LANG.useguides}</span></a>
                    </div>
                    <!-- END: useguide -->
                </div>
                <!-- BEGIN: error -->
                <div class="panel-footer red">
                    <em class="fa fa-exclamation-triangle">&nbsp;</em>{ERROR}
                </div>
                <!-- END: error -->
            </div>
        </div>
        <!-- END: question -->
    </div>
    <div class="button_fixed_bottom text-center">
        <input type="hidden" name="examid" value="{examid}" /> 
        <input type="hidden" name="typeid" value="{typeid}" />
         <input type="hidden" name="update_question" value="{update_question}" />
         <input type="hidden" name="submit_word" value="1" />
          <input type="submit" class="btn btn-success" value="{LANG.save}"
        <!-- BEGIN: disabled -->
        disabled="disabled"
        <!-- END: disabled -->
        /> <input type="button" value="{LANG.back}" class="btn btn-danger" onclick="javascript:window.history.back()" />
    </div>
</form>
<!-- END: data -->
<!-- BEGIN: nodata -->
<div class="text-center alert alert-info">
    {LANG.nodata_reading}<br /> <br /> <input type="button" value="Go Back" class="btn btn-primary" onclick="javascript:window.history.back()" />
</div>
<!-- END: nodata -->
<script>
    $('#frm-submit').submit(function(e) {
        e.preventDefault();
        if (confirm('{LANG.fileword_confirm}')) {
            $.ajax({
                type : 'POST',
                url : script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=questionword&nocache=' + new Date().getTime(),
                data : $(this).serialize(),
                success : function(json) {
                    if (json.error) {
                        alert(json.msg);
                    } else {
                        window.location.href = json.redirect;
                    }
                }
            });
        }
    });
</script>
<!-- END: main -->