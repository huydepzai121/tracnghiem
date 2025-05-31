<!-- BEGIN: main -->
<script type="text/javascript">
    var arr_repeat_audio = {};
    var arr_audio = {};
    $(document).ready(function() {
        nv_test_get_limit_audio();
    });
</script>
<div class="testing test-gird m-bottom">
    <!-- BEGIN: result -->
    <div class="panel panel-default">
        <div class="panel-heading">{result_title}</div>
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
    <!-- END: result -->
    <!-- BEGIN: groups_result_note -->
    <div class="alert alert-info text-center">{RESULT_NOTE}</div>
    <!-- END: groups_result_note -->
    <!-- BEGIN: questionlist -->
    <form action="" method="post" id="frm-submit">
        <input type="hidden" value="1" name="save_test" /> <input type="hidden" value="{DATA.id}" name="exam_id" /> <input type='hidden' id='current_page' /> <input type='hidden' id='show_per_page' />
        <div id="questionlist" data-exam-id="{DATA.id}" class="m-bottom">
            <!-- BEGIN: question -->
            <script type="text/javascript">
                if (localStorage.getItem("list_question_type") != null) {
                    list_question_type = JSON.parse(localStorage.getItem("list_question_type"));
                } else {
                    list_question_type = {};
                }
                list_question_type[{QUESTION.number}] = {QUESTION.type};
                localStorage.setItem("list_question_type", JSON.stringify(list_question_type));
            </script>
            <div id="question_{QUESTION.number}" class="listquestion question-box"{HIDE}>
                <!-- BEGIN: question_general -->
                <div class="panel panel-default">
                    <div class="panel-body">{question_common}</div>
                </div>
                <!-- END: question_general -->
                <div class="panel panel-default question-item {QUESTION.highlight}" data-question-number="{QUESTION.number}">
                    <div class="panel-body">
                        <p class="question">
                            <strong class="text-red m-bottom">{LANG.question} {QUESTION.number}.</strong> {QUESTION.title}
                        </p>
                        <div class="row answer">
                            <div class="flex">
                                <!-- BEGIN: question_type_1 -->
	                            <!-- BEGIN: answer -->
	                            <div class="answer-item <!-- BEGIN: answer_style_0 -->col-xs-24 col-sm-12 col-md-12<!-- END: answer_style_0 --><!-- BEGIN: answer_style_1 -->pull-left<!-- END: answer_style_1 --><!-- BEGIN: answer_style_2 -->col-xs-24 col-sm-24 col-md-24<!-- END: answer_style_2 -->">
	                                <label class="<!-- BEGIN: is_true_highlight -->istrue<!-- END: is_true_highlight -->">
                                        <table>
                                            <tr>
                                                <td class="letter">
                                                    <p>
                                                        <!-- BEGIN: checkbox -->
                                                        <input type="checkbox" class="checkbox_answer_{QUESTION.number}" name="answer[{QUESTION.id}][]" value="{ANSWER.id}" {DISABLED} {ANSWER.checked} />
                                                        <!-- END: checkbox -->
                                                        <!-- BEGIN: radio -->
                                                        <input class="radio_answer_{QUESTION.number}" type="radio" name="answer[{QUESTION.id}]" value="{ANSWER.id}" {DISABLED} {ANSWER.checked} onclick="autonextquestion()"/>
                                                        <!-- END: radio -->
                                                        <strong>{ANSWER.letter}.</strong>
                                                    </p>
                                                </td>
                                                <td>
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
                                        <p class="istrue">{ANSWER.is_true_string}</p>
                                        <!-- BEGIN: textbox -->
                                        <input class="text_answer" data-answer-id="{ANSWER.id}" type="text" name="answer[{QUESTION.id}][{ANSWER.id}]" value="{ANSWER.is_true_answer}" onchange="nv_check_textbox_answered($(this));" {DISABLED} />
                                        <!-- END: textbox -->
                                        <!-- BEGIN: space -->
                                        ......
                                        <!-- END: space -->
                                     </div>
                                </label>
                            </div>
                            <!-- END: answer -->
                            <!-- END: question_type_2 -->
                            <!-- BEGIN: question_type_4 -->
                            <div class="col-xs-24 col-sm-24 col-md-24" style="margin-top: 10px">
                                <!-- BEGIN: loop -->
                                <label class="answer-item {OPTION.highlight}">
                                    <input class="radio_answer_{QUESTION.number}" type="radio" name="answer[{QUESTION.id}]" value="{OPTION.index}"{OPTION.disabled} {OPTION.checked} onclick="autonextquestion()">{OPTION.value}
                                </label>&nbsp;&nbsp;&nbsp;&nbsp;
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
                            </div>
                            <!-- END: question_type_6 -->
                            <!-- BEGIN: question_type_7 -->
                            <div class="col-xs-24 col-sm-24 col-md-24">
                                <div class="test_record">
                                    <div class="controls">
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
                                    </div>
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
                <!-- BEGIN: limit_time_audio -->
                <script type="text/javascript">
                    arr_audio[{QUESTION.number}] = $("#question_{QUESTION.number} audio");
                    arr_repeat_audio[{QUESTION.number}]=[];
                    for (var i = 0; i < arr_audio[{QUESTION.number}].length; i++) {
                        arr_repeat_audio[{QUESTION.number}][i] = {QUESTION.limit_time_audio};
                        $( "<p>{LANG.limit_time_hear}</p>" ).insertAfter( arr_audio[{QUESTION.number}][i] );
                        $(arr_audio[{QUESTION.number}][i]).siblings("p").children(".limit_time").html(arr_repeat_audio[{QUESTION.number}][i]);
                        arr_audio[{QUESTION.number}][i].onplay = function(i) {
                            if (arr_repeat_audio[{QUESTION.number}][i] <= 0) {
                                arr_audio[{QUESTION.number}][i].pause();
                            }
                        }.bind(this,i);
                        arr_audio[{QUESTION.number}][i].onended  = function(i) {
                            arr_repeat_audio[{QUESTION.number}][i]-=  (arr_repeat_audio[{QUESTION.number}][i]>0) ? 1:0;
                            nv_test_set_limit_audio({QUESTION.number}, i, arr_repeat_audio[{QUESTION.number}][i]);
                            $(arr_audio[{QUESTION.number}][i]).siblings("p").children(".limit_time").html(arr_repeat_audio[{QUESTION.number}][i]);
                        }.bind(this,i);
                    }
                </script>
                <!-- END: limit_time_audio -->
                <!-- BEGIN: adsblock -->
                [ADSBLOCK_{ADSNUMBER}]
                <!-- END: adsblock -->
            </div>
            <!-- END: question -->
            <!-- BEGIN: auto_next_question -->
            <div class="form-check">
                <input type="checkbox"  id="auto_next_question">
                <label for="auto_next_question">{LANG.auto_next_question}</label>
            </div>
            <!-- END: auto_next_question -->
            <div class="text-center clear">
                <button onclick="previous_question();" type="button" class="btn btn-danger item-prev" title="{LANG.previous}">
                    <span>{LANG.previous}</span>
                </button>
                &nbsp;
                <button onclick="next_question();" type="button" class="btn btn-primary item-next" title="{LANG.next}">
                    <span class="btn-label">{LANG.next}</span>
                </button>
            </div>
        </div>
    </form>

    <div class="col-md-24">
        <ul class="slides-vertical-pagination">
            <!-- BEGIN: list_question_number -->
            <li class="question_number {QUESTION.highlight}" id="question_number_{QUESTION.number}" onclick="scrolltoQuestion({QUESTION.number}),ser_process_bar({QUESTION.number}, {total_question})"><span class="pagination-item-name" aria-hidden="true">{LANG.question_number}&nbsp;{QUESTION.number}</span></li>
            <!-- END: list_question_number -->
        </ul>
    </div>
    <!-- END: questionlist -->
    <div class="text-center">
        <!-- BEGIN: page -->
        <div class="show m-bottom" id="page_navigation"></div>
        <!-- END: page -->
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
    var show_per_page = {DATA.per_page};
</script>
<!-- END: pagejs -->
<!-- BEGIN: istesting -->
<script>
    $(document).ready(function() {
        $('.answer-item').click(function(){
            $(this).parent().find('.answer-item').each(function(){
                if($(this).find('input').is(':checked')){
                    $(this).find('label').addClass('selected');
                }else{
                    $(this).find('label').removeClass('selected');
                }
            });
            if($(this).find('input').is(':checked')){
                $(this).find('label').addClass('selected');
            }else{
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

    function nv_check_textbox_answered($_this)
    {
        var isanswered = 0;
        var next_question = true;
        $_this.closest('.answer').find('input[type="text"]').each(function(){
            next_question = next_question && ($(this).val() != '');
            if($(this).val() != ''){
                isanswered = 1;
                return;
            }
        });
        var questionid = $_this.closest('.question-item').data('question-number');
        var answerid = {};
        $_this.closest('.question-item').find('.text_answer').each(function(index) {
            answerid[$(this).data('answer-id')] = $(this).val();
        });
        nv_test_set_answer(questionid, answerid);
        if (next_question) {
            autonextquestion();
        }
        if(isanswered){
            $_this.closest('.question-item').addClass('answered');
        }else{
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
            $('.question-item').each(function(){
                if(! $(this).hasClass('answered')){
                    list.push($(this).data('question-number'));
                }
            });

            if(list.length > 0){
                submit_confirm = '{LANG.submit_confirm_answered_1} ' + list.join(", ") + ' {LANG.submit_confirm_answered_2}';
            }else{
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
        if(evt.editor.getData() != ''){
            $('.question-item textarea[name="' + evt.editor.name.replace('{MODULE_NAME}_', '') + '"]').closest('.question-item').addClass('answered');
        }else{
            $('.question-item textarea[name="' + evt.editor.name.replace('{MODULE_NAME}_', '') + '"]').closest('.question-item').removeClass('answered');
        }
    });
}
</script>
<!-- END: editor_change_event_js -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/recorder.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/app.js"></script>
<!-- END: istesting -->
<script type="text/javascript">
    //phan show cau hoi theo tung cau
    $('.listquestion').hide();
    var quesnumber_current = 1;
    var total_ques = '{total_question}';
    scrolltoQuestion(quesnumber_current);
    ser_process_bar(quesnumber_current, total_ques);
    function autonextquestion()
    {
        var auto_next=$("#auto_next_question").is(":checked");
        if ((quesnumber_current<total_ques) && auto_next) {
            next_question();
        }
    }
</script>
<!-- END: main -->
