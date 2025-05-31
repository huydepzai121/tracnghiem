<!-- BEGIN: main -->
<div <!-- BEGIN: question_content_id -->
    id="question-content"
    <!-- END: question_content_id -->
    class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1">
                    <!-- BEGIN: number -->
                    <h5 class="card-title mb-0">
                        <i class="fas fa-question-circle me-2"></i>{number_question_view_title}
                    </h5>
                    <!-- END: number -->
                    <!-- BEGIN: bank_editor -->
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Chỉnh sửa câu hỏi
                    </h5>
                    <!-- END: bank_editor -->
                </div>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" value="1" name="use_editor"
                               id="use_editor" {CK_EDITOR_TITLE} />
                        <label class="form-check-label" for="use_editor">
                            <i class="fas fa-code me-1"></i>{LANG.question_editor}
                        </label>
                    </div>
                    <small id="limit_export_file" class="text-warning d-block mt-1">
                        <i class="fas fa-exclamation-triangle me-1"></i>({LANG.limit_export_file})
                    </small>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}"
                  method="post" id="frm-question-content" data-editor="{ROW.editor}">
                <input type="hidden" name="bank" value="{BANKEXAM}" id="bankexam" />
                <input type="hidden" name="id" value="{ROW.id}" id="questionid" />
                <input type="hidden" name="examid" value="{ROW.examid}" />
                <input type="hidden" name="number" value="{ROW.number}"/>
                <input type="hidden" name="ajax" value="{ROW.ajax}" />
                <input type="hidden" name="submit" value="1">
                <input type="hidden" name="redirect" value="{ROW.redirect}">
                <!-- BEGIN: bank_type -->
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-database me-1"></i>{LANG.bank_type}
                    </label>
                    <div class="d-flex flex-wrap gap-3">
                        <!-- BEGIN: loop -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bank_type"
                                   value="{BANK_TYPE.index}" id="bank_type_{BANK_TYPE.index}"
                                   {BANK_TYPE.checked}{BANK_TYPE.disabled} />
                            <label class="form-check-label" for="bank_type_{BANK_TYPE.index}">
                                {BANK_TYPE.value}
                            </label>
                        </div>
                        <!-- END: loop -->
                    </div>
                </div>
                <!-- END: bank_type -->

                <!-- BEGIN: typeid -->
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-tags me-1"></i>{LANG.type_input_question_2}
                    </label>
                    <select class="form-select" name="typeid">
                        <option value="0">-- {LANG.select_category} --</option>
                        <!-- BEGIN: bank_option_group -->
                        <optgroup label="{option_group}">
                        <!-- BEGIN: bank_option -->
                        <option value="{OPTION.id}" {OPTION.selected}>{OPTION.title}</option>
                        <!-- END: bank_option -->
                        </optgroup>
                        <!-- END: bank_option_group -->
                    </select>
                </div>
                <!-- END: typeid -->

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-list-alt me-1"></i>{LANG.question_type}
                        <i class="fas fa-question-circle text-info ms-1"
                           data-bs-toggle="tooltip"
                           title="{LANG.question_type_note}"></i>
                    </label>
                    <div class="d-flex flex-wrap gap-3">
                        <!-- BEGIN: question_type -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type"
                                   value="{TYPE.index}" id="type_{TYPE.index}"
                                   {TYPE.checked}{TYPE.disabled} />
                            <label class="form-check-label" for="type_{TYPE.index}">
                                {TYPE.value}
                            </label>
                        </div>
                        <!-- END: question_type -->
                    </div>
                </div>

                <div class="mb-3" id="title">
                    <label class="form-label fw-bold">
                        <i class="fas fa-heading me-1"></i>{lang_title}
                    </label>
                    <div class="p-3 bg-light border rounded">
                        {ROW.title}
                    </div>
                </div>

                <!-- BEGIN: limit_question -->
                <div class="mb-3" id="limit-question">
                    <label class="form-label fw-bold">
                        <i class="fas fa-sliders-h me-1"></i>{LANG.limit}
                    </label>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{LANG.from_question}:</label>
                            <input type="number" class="form-control" name="from_question"
                                   value="{from_question}" placeholder="Từ câu số..." />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{LANG.to_question}:</label>
                            <input type="number" class="form-control" name="to_question"
                                   value="{to_question}" placeholder="Đến câu số..." />
                        </div>
                    </div>
                </div>
                <!-- END: limit_question -->
                <!-- BEGIN: config_advanced -->
                <div class="form-group">
                    <div class="text-right">
                        <a class="text-danger" id="toggle-question-advanced" href="javascript:void(0)">{LANG.config_advanced}</a>
                    </div>
                </div>
                <!-- END: config_advanced -->
                <div id="question-advanced" style="display: none;">
                    <div class="form-group">
                        <label class="col-sm-24 col-md-6">{LANG.limit_time_audio}: </label>
                        <div class="col-sm-24 col-md-18">
                            <input type="number" class="form-control" name="limit_time_audio" value="{ROW.limit_time_audio}" />
                        </div>
                    </div>
                    <!-- BEGIN: show_type_private_mark -->
                    <div class="form-group">
                        <label class="col-sm-24 col-md-6">{LANG.private_mark}: </label>
                        <div class="col-sm-24 col-md-18">
                            <input type="number" class="form-control" name="mark_max_constructed_response" value="{ROW.mark_max_constructed_response}" />
                        </div>
                    </div>
                    <!-- END: show_type_private_mark -->
                    <!-- BEGIN: useguide -->
                    <div class="form-group">
                        <label><strong>{LANG.useguides}</strong></label> {ROW.useguide}
                    </div>
                    <!-- END: useguide -->
                    <!-- BEGIN: point -->
                    <div class="form-group" id="point">
                        <label><strong>{LANG.question_point}</strong></label> <input type="text" class="form-control required" name="point" value="{ROW.point}" />
                    </div>
                    <!-- END: point -->
                    <!-- BEGIN: answer_style -->
                    <div class="form-group">
                        <label><strong>{LANG.answer_style}</strong></label> <select class="form-control" name="answer_style">
                            <!-- BEGIN: loop -->
                            <option value="{ANSWER_STYLE.index}"{ANSWER_STYLE.selected}>{ANSWER_STYLE.value}</option>
                            <!-- END: loop -->
                        </select>
                    </div>
                    <!-- END: answer_style -->
                    <!-- BEGIN: answer_fixed -->
                    <div class="form-group">
                        <label><strong>{LANG.answer_fixed}</strong></label> <label><input type="checkbox" name="answer_fixed" value="1" {ROW.answer_fixed} />{LANG.answer_fixed_note}</label>
                    </div>
                    <!-- END: answer_fixed -->
                    <!-- BEGIN: answer_editor_type -->
                    <div class="form-group">
                        <label class="show"><strong>{LANG.answer_editor_type}</strong></label>
                        <!-- BEGIN: loop -->
                        <label><input type="radio" name="answer_editor_type" value="{ANSWER_EDITOR_TYPE.index}" {ANSWER_EDITOR_TYPE.checked} />{ANSWER_EDITOR_TYPE.value}&nbsp;&nbsp;&nbsp;</label>
                        <!-- END: loop -->
                        <label class="show"><strong>{LANG.mark_max_constructed_response}</strong></label>
                        <input type="number" class="form-control" name="mark_max_constructed_response" value="{ROW.mark_max_constructed_response}" style="width: 100px" />

                    </div>
                    <!-- END: answer_editor_type -->
                </div>
            </div>
        </div>
        <!-- BEGIN: answer_area -->
        <div id="answer-area">{ANSWER}</div>
        <!-- END: answer_area -->
        <div class="text-center mt-4">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-save me-2"></i>{LANG.save}
                <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
            </button>
            <a class="btn btn-secondary ms-2" href="javascript:history.back()">
                <i class="fas fa-arrow-left me-2"></i>{LANG.cancel}
            </a>
            <!-- BEGIN: clone_question -->
            <a class="btn btn-success ms-2" href="{link_clone_question}">
                <i class="fas fa-copy me-2"></i>{LANG.clone}
            </a>
            <!-- END: clone_question -->
        </div>
    </form>
</div>

<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/notify.min.js"></script>
<script>
    $(document).ready(function() {
        $("#toggle-question-advanced").click(function(){
            $("#question-advanced").slideToggle("slow");
        });
        $('#frm-question-content').submit(function(e) {
            e.preventDefault();
            if ($(this).data('editor')) {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            }

            var $submitBtn = $('button[type="submit"]');
            var $spinner = $submitBtn.find('.spinner-border');

            $submitBtn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question-content',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    var className = 'success';
                    if (!res.error) {
                        if (res.bank) {
                            window.location.href = res.redirect;
                            return !1;
                        }
                        var examid = $("input[name=examid]").val();
                        var current_questionid = $('#current_questionid').val();
                        $('#question_number_' + res.number).find('label').replaceWith('<label onclick="nv_question_click(' + res.id + ', ' + res.number + ')" class="question-title text-green">{LANG.question_s} ' + res.number + '</label>');
                        $('#current_questionid').val(res.id);
                        if (current_questionid == 0) {
                            nv_question_click(res.next_id, res.next_number);
                            $(window).scrollTop($('#question-content').offset().top);
                        } else {
                            $('input[type="submit"]').prop('disabled', false);
                        }
                        var elquestion = $("input.post[data-number=" + res.number + "]");
                        if (elquestion.length > 0) {
                            $(elquestion).val(res.id);
                        }
                        $("#question_number_" + res.number + " .bt_question_eraser_" + res.number).replaceWith('<button class="btn btn-default btn-xs bt_question_eraser_' + res.number + '" onclick="nv_question_eraser(' + res.id + ', ' + res.number + '); return !1;" title="{LANG.eraser_question}"><em class="fa fa-eraser"></em></button>');
                        $("#question_number_" + res.number + " .bt_question_delete_" + res.number).replaceWith('<button class="btn btn-default btn-xs bt_question_delete_' + res.number + '" onclick="nv_question_delete(' + res.id + ', ' + examid + ', ' + res.number + '); return !1;" title="{LANG.del_question}"><em class="fa fa-trash-o"></em></button>');
                        $('.qtslist').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question&export_list_question_html=1&exam_id='+ examid + '&question_id='+current_questionid+'&nocache=' + new Date().getTime());
                    } else {
                        var className = 'error';
                        $submitBtn.prop('disabled', false);
                        $spinner.addClass('d-none');
                    }

                    if (res.input) {
                        $('#' + res.input).focus();
                    }

                    $.notify(res.msg, {
                        className: className,
                        position: "right bottom"
                    });
                },
                error: function(xhr) {
                    $submitBtn.prop('disabled', false);
                    $spinner.addClass('d-none');
                }
            });
        });

        $('input[name="type"]').change(function() {
            var user_editor = $("input[name=use_editor]").prop( "checked" );
            $('#question-content').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question-content&ajax=1&id={ROW.id}&typeid={ROW.typeid}&number={ROW.number}&examid={ROW.examid}&user_editor_ajax=' + (user_editor ? 'user_editor' : 'not_editor') + '&type=' + $(this).val());
        });
    });
</script>
<script>
    function show_limit_export_file_text() {
        var user_editor = $("input[name=use_editor]").prop( "checked" );
        if (user_editor) {
            $('#limit_export_file').css('display', 'block');
        } else {
            $('#limit_export_file').css('display', 'none');
        }
    }
    show_limit_export_file_text();
</script>
<!-- BEGIN: in_exam_script -->
<script>
$(document).ready(function() {
	$('#use_editor').change(function(){
        var questionid = $("#questionid").val();
        var number = $("input[name=number]").val();
        var user_editor = $("input[name=use_editor]").prop( "checked" );
        nv_question_load(questionid, number, user_editor ? 'user_editor' : 'not_editor');
	});
});
</script>
<!-- END: in_exam_script -->
<!-- BEGIN: not_exam_script -->
<script>
$(document).ready(function() {
	$('#use_editor').change(function(){
        var questionid = $("#questionid").val();
        var user_editor = $("input[name=use_editor]").prop( "checked" )  ? 'user_editor' : 'not_editor';
        window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question-content&id=' + questionid + '&user_editor_ajax=' + user_editor;
    });
});
</script>
<!-- END: not_exam_script -->

<!-- END: main -->