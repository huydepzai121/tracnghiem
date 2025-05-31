<!-- BEGIN: main -->
<div class="hidden-print">
    <style>
        @media print {
            .user_checked {
                border: 1px dashed gray;
                padding: 4px;
            }
        }
    </style>
</div>
<!-- BEGIN: result -->
<div class="col-xs-24 col-sm-16 col-md-16">
    <div class="panel panel-default">
        <div class="panel-heading">{LANG.result}</div>
        <div class="panel-body">
            <div class="row exam-result">
                <div class="col-xs-24 col-sm-12 col-md-12">
                    <ul class="exam-info">
                        <li><label>{LANG.compele_time}</label>: {DATA.time_test}</li>
                        <!-- BEGIN: question_true -->
                        <li><label>{LANG.question_true}</label>: {DATA.true}</li>
                        <!-- END: question_true -->
                        <!-- BEGIN: question_false -->
                        <li><label>{LANG.question_false}</label>: {DATA.false}</li>
                        <!-- END: question_false -->
                        <!-- BEGIN: question_skeep -->
                        <li><label>{LANG.question_skeep}</label>: {DATA.skeep}</li>
                        <!-- END: question_skeep -->
                        <!-- BEGIN: total_question_have_not_mark -->
                        <li><label>{LANG.total_question_have_not_mark}</label>: {DATA.total_question_have_not_mark}</li>
                        <!-- END: total_question_have_not_mark -->
                        <!-- BEGIN: rating -->
                        <li><label>{LANG.rating}</label>: {DATA.rating.title}<!-- BEGIN: note -->, {DATA.rating.note}<!-- END: note --></li>
                        <!-- END: rating -->
                    </ul>
                </div>
                <div class="col-xs-24 col-sm-12 col-md-12 text-center score-box">
                    <!-- BEGIN: score_box -->
                    <p>{score_title}</p>
                    <span class="score">{DATA.score}</span>
                    <!-- END: score_box -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-24 col-sm-8 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">{LANG.share_now}</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 text-center">
                    <ul class="social-network social-circle test-gird">
                        <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={URL_SHARE}" class="icoFacebook {URL_SHARE_DISABLED}" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <!-- BEGIN: zalo_share_button -->
                        <li>
                            <script src="https://sp.zalo.me/plugins/sdk.js"></script> <a class="zalo-share-button pointer" data-href="{URL_SHARE}" data-oaid="{OAID}" data-layout="2" data-color="blue" data-customize=true><i class="zb-logo-zalo"></i></a></li>
                        <!-- END: zalo_share_button -->
                        <li><a target="_blank" href="https://twitter.com/share?text=&url={URL_SHARE}" class="icoTwitter {URL_SHARE_DISABLED}" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                    </ul>
                    <div class="clearfix m-bottom"></div>
                    <!-- BEGIN: share_note -->
                    <span class="text-center text-danger">{LANG.share_note}</span>
                    <!-- END: share_note -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: result -->
<div class="testing m-bottom get_width" id="top">
    <!-- BEGIN: groups_result_note -->
    <div class="alert alert-info text-center">{RESULT_NOTE}</div>
    <!-- END: groups_result_note -->
    <!-- BEGIN: questionlist -->
    <form action="" method="post" id="frm-submit" class="col-xs-24 col-sm-24 col-md-24">
        <input type="hidden" value="1" name="save_test" /> <input type="hidden" value="{DATA.id}" name="exam_id" /> <input type='hidden' id='current_page' /> <input type='hidden' id='show_per_page' />
        <div id="questionlist" data-exam-id="{DATA.id}">
            <!-- BEGIN: question -->
            <div class="question-box" {HIDE}>
                <!-- BEGIN: question_general -->
                <div class="panel panel-default">
                    <div class="panel-body">{question_common}</div>
                </div>
                <!-- END: question_general -->
                <div class="panel panel-default question-item {QUESTION.highlight}" id="question_{QUESTION.number}" data-question-number="{QUESTION.number}">
                    <div class="panel-body">
                        <p class="m-bottom question">
                            <strong class="text-red">{LANG.question} {QUESTION.number}.</strong> {QUESTION.title}
                        </p>
                        <div class="row answer">
                            <div class="flex">
                                <!-- BEGIN: question_type_1 -->
                                <!-- BEGIN: answer -->
                                <div class="answer-item <!-- BEGIN: answer_style_0 -->col-xs-12 col-sm-12 col-md-12<!-- END: answer_style_0 --><!-- BEGIN: answer_style_1 -->pull-left<!-- END: answer_style_1 --><!-- BEGIN: answer_style_2 -->col-xs-24 col-sm-24 col-md-24<!-- END: answer_style_2 -->">
                                    <label class="<!-- BEGIN: is_true_highlight -->istrue<!-- END: is_true_highlight --> <!-- BEGIN: checked -->user_checked<!-- END: checked --> radio_question">
                                        <table>
                                            <tr>
                                                <td class="letter">
                                                    <p>
                                                        <!-- BEGIN: checkbox -->
                                                        <input type="checkbox" name="answer[{QUESTION.id}][]" value="{ANSWER.id}" {DISABLED} {ANSWER.checked} />
                                                        <!-- END: checkbox -->
                                                        <!-- BEGIN: radio --> <input class="hidden-print" type="radio" name="answer[{QUESTION.id}]" value="{ANSWER.id}" {DISABLED} {ANSWER.checked} />
                                                        <!-- END: radio -->
                                                        <strong>{ANSWER.letter}.</strong>
                                                    </p>
                                                </td>
                                                <td >
                                                    {ANSWER.content}
                                                </td>
                                            </tr>
                                        </table>
	                                </label>
                                </div>
                                <!-- END: answer -->
                                <!-- END: question_type_1 -->
                            </div>
                            <!-- BEGIN: question_type_2 -->
                            <!-- BEGIN: answer -->
                            <div class="<!-- BEGIN: answer_style_0 -->col-xs-24 col-sm-12 col-md-12<!-- END: answer_style_0 --><!-- BEGIN: answer_style_1 -->pull-left<!-- END: answer_style_1 --><!-- BEGIN: answer_style_2 -->col-xs-24 col-sm-24 col-md-24<!-- END: answer_style_2 -->">
                                <label>
                                    <table>
                                        <tr>
                                            <td class="letter"><p><strong>{ANSWER.letter}.</strong></p></td>
                                            <td >{ANSWER.content}</td>
                                        </tr>
                                    </table>
                                    <div>
                                        <p class="istrue">{ANSWER.is_true_string}</p> <!-- BEGIN: textbox --> <input type="text" class="form-control" name="answer[{QUESTION.id}][{ANSWER.id}]" value="{ANSWER.is_true_answer}" onchange="nv_check_textbox_answered($(this));" {DISABLED} /> <!-- END: textbox --> <!-- BEGIN: space --> ...... <!-- END: space -->
                                    </div>
                                </label>
                            </div>
                            <!-- END: answer -->
                            <!-- END: question_type_2 -->
                            <!-- BEGIN: question_type_4 -->
                            <div class="col-xs-24 col-sm-24 col-md-24" style="margin-top: 10px">
                                <!-- BEGIN: loop -->
                                <label class="answer-item {OPTION.highlight} <!-- BEGIN: checked -->user_checked<!-- END: checked --> "><input type="radio" name="answer[{QUESTION.id}]" value="{OPTION.index}"{OPTION.disabled} {OPTION.checked}>{OPTION.value}</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <!-- END: loop -->
                            </div>
                            <!-- END: question_type_4 -->
                            <!-- BEGIN: question_type_6 -->
                            <div class="col-xs-24 col-sm-24 col-md-24">
                                <!-- BEGIN: editor -->
                                {ANSWER}
                                <!-- END: editor -->
                                <!-- BEGIN: textarea -->
                                <textarea class="form-control textarea" name="answer[{QUESTION.id}]">{ANSWER}</textarea>
                                <!-- END: textarea -->
                                <!-- BEGIN: label -->
                                {ANSWER}
                                <!-- END: label -->
                                <!-- BEGIN: mark -->
                                <div class="form-inline text-right">
                                    <button class="btn btn-primary btn-agree">{LANG.agree}</button>
                                    <label> <strong>{LANG.do_mark}: </strong>
                                        <input type="number" min="0" max="{QUESTION.mark_max_constructed_response}" class="form-control enable mark" value="{QUESTION.mark}" data-question-number="{QUESTION.number}" name="mark[{QUESTION.id}]" data-question-id="{QUESTION.id}">
                                    </label>
                                </div>
                                <!-- END: mark -->

                            </div>
                            <!-- END: question_type_6 -->
                            <!-- BEGIN: question_type_7 -->
                            <div class="col-xs-24 col-sm-24 col-md-24">
                                <div class="test_record" >
                                    <div class="controls" {HIDE_RECORD}>
                                         <!-- BEGIN: way_record_1 -->
                                         <button id="upload-{QUESTION.id}" class="uploadButton" onclick="uploadAudio({QUESTION.id}, event)" ><i class="fa fa-upload" aria-hidden="true"></i></button>
                                         <!-- END: way_record_1 -->
                                         <!-- BEGIN: way_record_2 -->
                                         <button id="recordButton-{QUESTION.id}" class="recordButton" onclick="recordAudio({QUESTION.id})" ><i class="fa fa-microphone" aria-hidden="true"></i></button>
                                         <button id="stopButton-{QUESTION.id}" class="stopButton" onclick="stopAudio({QUESTION.id}, {QUESTION.number})" disabled><i class="fa fa-stop" aria-hidden="true"></i></button>
                                         <!-- END: way_record_2 -->
                                    </div>
                                    <div id="recording-{QUESTION.id}" class="recording" {style}>
                                        <audio controls id="audio-{QUESTION.id}" style="vertical-align: middle">
                                            <source src="{audio_record_name}" type="audio/wav">
                                        </audio>&nbsp;
                                        <p id="ms-auto-upload-{QUESTION.id}" style="display: none">
                                            <img src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/images/load.gif" alt="uploading..."/> 
                                            <span style="color: red; font-size:12px;  margin-right: 5px">{LANG.auto_upload}</span>
                                        </p>
                                        <input id="audio-answer-{QUESTION.id}" type = "text" style="display: none" name="answer[{QUESTION.id}]" value="{audio_record_name}"/> 
                                        <!-- BEGIN: agree -->
                                        &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary btn-agree">{LANG.agree}</button>
                                        <!-- END: agree -->
                                    </div>
                                    <!-- BEGIN: mark -->
                                    <div class="form-inline text-right">
                                        <label> <strong>{LANG.do_mark}: </strong>
                                            <input type="number" min="0" max="{max}" step="0.01" class="form-control {enable} mark" value="{QUESTION.mark}" data-question-number="{QUESTION.number}" name="mark[{QUESTION.id}]"  data-question-id="{QUESTION.id}">
                                        </label>
                                    </div>
                                    <!-- END: mark -->
                                </div>
                            </div>
                            <!-- END: question_type_7 -->
                        </div>
                        <!-- BEGIN: answer_multiple -->
                        <em class="text-danger"><small>{LANG.answer_multiple}</small></em>
                        <!-- END: answer_multiple -->
                        <!-- BEGIN: groups_result -->
                        <div id="question{QUESTION.id}" class="useguide">
                            <div class="hidden useguide-content">{QUESTION.useguide}</div>
                            <a href="javascript:void(0);" onclick="nv_test_dipslay_userguide($(this), {DATA.type_useguide});" data-title="{LANG.loigiai}" class="text_view_result" data-opened="0"><em class="fa fa-search">&nbsp;</em><span class="text-green">{LANG.loigiai}</span></a>
                        </div>
                        <!-- END: groups_result -->
                        <!-- BEGIN: groups_result1 -->
                        <div id="question{QUESTION.id}" class="useguide">
                            <div class="hidden useguide-content">{QUESTION.useguide}</div>
                            <a href="javascript:void(0);" onclick="nv_test_dipslay_userguide($(this));" data-title="{LANG.loigiai}" class="text_view_result" data-opened="0"><em class="fa fa-search">&nbsp;</em><span class="text-green">{LANG.loigiai}</span></a>
                        </div>
                        <!-- END: groups_result1 -->
                    </div>
                </div>
                <!-- BEGIN: adsblock -->
                [ADSBLOCK_{ADSNUMBER}]
                <!-- END: adsblock -->
            </div>
            <!-- END: question -->
        </div>
    </form>
    <!-- END: questionlist -->
    <!-- BEGIN: nv_save_admin_test -->
    <!-- BEGIN: notbank -->
    <button type="submit" name="submit" class="btn btn-success enable hidden-print" onclick="nv_save_admin_test();">
        <em class="fa fa-floppy-o">&nbsp;</em>{LANG.do_mark}
    </button>
    <!-- END: notbank -->
    <!-- An doan ma script nay trong print-->
    <div class="hidden-print">
        <script type="text/javascript">
            function nv_save_admin_test() {
                var answer_id = $(".exams-answer").data("answer-id");
                var data_marks = {};
                var marks = $("input[name^=mark]");
                for (var i = 0; i < marks.length; i++) {
                    var item = marks[i];
                    data_marks[$(item).data('question-id')] = item.value;
                }
                $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=history-view&id=' + answer_id + '&save_admin_test=1&nocache=' + new Date().getTime(), {
                    data_marks: data_marks
                }, function(res) {
                    if (res == 'OK') {
                        alert('OK');
                        location.reload();
                    } else {
                        alert('{LANG.error_unknow}');
                    }
                });
            }
            $("input.mark").change(function() {
                var max = parseInt($(this).attr('max'));
                var min = parseInt($(this).attr('min'));
                if ($(this).val() > max) {
                    $(this).val(max);
                } else if ($(this).val() < min) {
                    $(this).val(min);
                }
            });
        </script>
    </div>
    <!-- END: nv_save_admin_test -->
    <div class="clearfix"></div>
    <div class="text-center">
        <!-- BEGIN: page -->
        <div class="show m-bottom" id="page_navigation"></div>
        <!-- END: page -->
        <!-- BEGIN: btn_exam_save_bottom -->
        <button type="submit" name="submit" class="btn btn-success" onclick="nv_save_test(0);">
            <em class="fa fa-floppy-o">&nbsp;</em>{LANG.exams_success}
        </button>
        <!-- BEGIN: btn_exit_test -->
        &nbsp; <a href="" class="cancelLink" onclick="nv_exit_test()"> {LANG.exams_exit} </a>
        <!-- END: btn_exit_test -->
        <script type="text/javascript">
            var exams_exit_confirm = '{LANG.exams_exit_confirm}';
            var url_back_module = '{url_back_module}';
        </script>
        <!-- END: btn_exam_save_bottom -->
    </div>
</div>
<!-- BEGIN: disabled_input -->
<script>
    $(".testing input").prop('disabled', true);
</script>
<!-- END: disabled_input -->
<!-- BEGIN: pagejs -->
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/test-detail.js"></script>
<script>
    var show_per_page = '{show_per_page}';
</script>
<!-- END: pagejs -->
<!-- BEGIN: istesting -->
<script>
    $(document).ready(function() {
        $('.text_view_result').click(function() {
            if ($(this).data('opened') == 1) {
                $(this).parent().find('div').slideUp();
                $(this).data('opened', 0);
                $(this).html('<em class="fa fa-search">&nbsp;</em><span class="text-green">{LANG.loigiai}</span>');
            } else {
                $(this).parent().find('div').slideDown();
                $(this).data('opened', 1);
                $(this).html('<em class="fa fa-close">&nbsp;</em><span class="text-red">{LANG.dongloigiai}</span>');
            }
        });

        $('.answer-item').click(function() {
            $(this).parent().find('.answer-item').each(function() {
                if ($(this).find('input').is(':checked')) {
                    $(this).find('label').addClass('selected');
                } else {
                    $(this).find('label').removeClass('selected');
                }
            });
            if ($(this).find('input').is(':checked')) {
                $(this).find('label').addClass('selected');
            } else {
                $(this).find('label').removeClass('selected');
            }
            $(this).closest('.question-item').addClass('answered');

            var questionid = $(this).closest('.question-item').data('question-number');
            var answerid = {};
            $(this).closest('.question-item').find('.answer-item').find('input:checked').each(function(index) {
                answerid[index] = $(this).val();
            });
            nv_test_set_answer(questionid, answerid);
        });
    });

    function nv_check_textbox_answered($_this) {
        var isanswered = 0;
        $_this.closest('.answer').find('input[type="text"]').each(function() {
            if ($(this).val() != '') {
                isanswered = 1;
                return;
            }
        });

        if (isanswered) {
            $_this.closest('.question-item').addClass('answered');
        } else {
            $_this.closest('.question-item').removeClass('answered');
        }
    }

    function nv_save_test(auto) {
        if (auto) {
            $('#frm-submit').submit();
            nv_test_unset_answer();
            nv_test_unset_limit_audio();
            return !1;
        } else {
            // kiểm tra câu hỏi chưa trả lời
            var list = [];
            var submit_confirm = '';
            $('.question-item').each(function() {
                if (!$(this).hasClass('answered')) {
                    list.push($(this).data('question-number'));
                }
            });

            if (list.length > 0) {
                submit_confirm = '{LANG.submit_confirm_answered_1} ' + list.join(", ") + ' {LANG.submit_confirm_answered_2}';
            } else {
                submit_confirm = '{LANG.submit_confirm}';
            }

            if (confirm(submit_confirm)) {
                $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=detail&nocache=' + new Date().getTime(), 'set_end_time=1', function(res) {
                    if (res == 'OK') {
                        $('#frm-submit').submit();
                        nv_test_unset_answer();
                        nv_test_unset_limit_audio();
                    } else {
                        alert('{LANG.error_unknow}');
                    }
                });
                return !1;
            }
        }
    }
</script>
<!-- BEGIN: editor_change_event_js -->
<script>
    for (var instanceName in CKEDITOR.instances) {
        CKEDITOR.instances[instanceName].on('change', function(evt) {
            if (evt.editor.getData() != '') {
                $('textarea[name="' + evt.editor.name.replace('{MODULE_NAME}_', '') + '"]').closest('.question-item').addClass('answered');
            } else {
                $('textarea[name="' + evt.editor.name.replace('{MODULE_NAME}_', '') + '"]').closest('.question-item').removeClass('answered');
            }
        });
    }
</script>
<!-- END: editor_change_event_js -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/recorder.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/app.js"></script>
<!-- END: istesting -->
<!-- END: main -->
