<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css">

<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{ERROR}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->

{PACKAGE_NOTIICE}

<div class="card border-info mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <div class="alert alert-info mb-0" <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-info-circle me-2"></i>
                    <ul class="mb-0">
                        <li><strong>{LANG.merge_exams_opt_1}:</strong> {LANG.info_merge_exams_opt_1}</li>
                        <li><strong>{LANG.merge_exams_opt_2}:</strong> {LANG.info_merge_exams_opt_2}</li>
                    </ul>
                    <!-- BEGIN: is_free -->
                    <div class="mt-2">
                        <i class="fas fa-lock me-1"></i><em>{LANG.merge_required_is_paid}</em>
                    </div>
                    <!-- END: is_free -->
                </div>
            </div>
            <div class="flex-shrink-0">
                <button class="btn btn-outline-info btn-sm show-msg" data-func="merge-exams"
                        <!-- BEGIN: msg_show -->style="display: none" <!-- END: msg_show -->>
                    <i class="fas fa-question-circle me-1"></i>{LANG.msg}
                </button>
                <button class="btn btn-outline-secondary btn-sm close-msg" data-func="merge-exams"
                        <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-layer-group me-2"></i>{LANG.merge_exams_opts}
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <a class="btn btn-primary w-100" href="{MERGE_OP1}">
                    <i class="fas fa-random me-1"></i>{LANG.merge_exams_opt_1}
                </a>
            </div>
            <div class="col-md-4">
                <a class="btn btn-info w-100" href="{MERGE_OP2}">
                    <i class="fas fa-puzzle-piece me-1"></i>{LANG.merge_exams_opt_2}
                </a>
            </div>
            <div class="col-md-4">
                <a class="btn btn-success w-100" href="{MERGE_HISTORY}">
                    <i class="fas fa-history me-1"></i>{LANG.merge_exams_opt_3}
                </a>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN: is_paid -->
<!-- BEGIN: merge_exams_opt_1 -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-random me-2"></i>{LANG.merge_exams_opt_1}
        </h5>
    </div>
    <div class="card-body">
        <form action="{MERGE_OP1}" method="post" class="form-merge" onsubmit="return allow_submit_opt_1()">
            <div class="row g-3 mb-3">
                <div class="col-12">
                    <label class="form-label fw-bold">
                        <i class="fas fa-file-alt me-1"></i>Chọn đề thi gốc
                    </label>
                    <div id="exam_tooltip" title="{LANG.error_not_selected_exam}">
                        <select name="exam_id" id="exam_id" class="form-select">
                            <!-- BEGIN: loop -->
                            <option value="{exam_id}" selected="selected">{TITLE}</option>
                            <!-- END: loop -->
                        </select>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        <i class="fas fa-question-circle me-1"></i>Số câu hỏi mỗi đề
                    </label>
                    <input type="number" name="number_question" placeholder="{LANG.number_question}"
                           class="form-control" value="{NUMBER_QUESTION}" min="1"
                           title="{LANG.error_not_input_number_question}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        <i class="fas fa-copy me-1"></i>Số đề thi cần tạo
                    </label>
                    <input type="number" name="number_exam" placeholder="{LANG.number_exam}"
                           class="form-control" value="{NUMBER_EXAM}" min="1"
                           title="{LANG.error_not_input_number_exam}" />
                </div>
            </div>

            <div class="text-center">
                <button type="submit" name="create_exam" class="btn btn-success btn-lg px-4">
                    <i class="fas fa-magic me-2"></i>{LANG.create_exam}
                </button>
            </div>
        </form>

        <div class="mt-3">
            {TOP_CONTENT}
        </div>
    </div>
</div>
<script>
//<![CDATA[
$(document).ready(function() {
    // Enhanced form validation for option 1
    function allow_submit_opt_1() {
        var exam_id = $("#exam_id").val();
        var number_question = $("input[name='number_question']").val();
        var number_exam = $("input[name='number_exam']").val();
        var isValid = true;

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');

        if (!exam_id || exam_id.length == 0) {
            $('#exam_id').addClass('is-invalid');
            showAlert('Vui lòng chọn đề thi gốc', 'danger');
            isValid = false;
        }

        if (!number_question || number_question == 0) {
            $("input[name='number_question']").addClass('is-invalid');
            showAlert('Vui lòng nhập số câu hỏi mỗi đề', 'danger');
            isValid = false;
        }

        if (!number_exam || number_exam == 0) {
            $("input[name='number_exam']").addClass('is-invalid');
            showAlert('Vui lòng nhập số đề thi cần tạo', 'danger');
            isValid = false;
        }

        return isValid;
    }

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show mt-2" role="alert">' +
                       '<i class="fas ' + iconClass + ' me-2"></i>' + message +
                       '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                       '</div>';

        // Remove existing alerts
        $('.alert:not(.alert-info)').remove();

        // Add new alert
        $('.card-body').prepend(alertHtml);

        // Auto-hide success alerts
        if (type === 'success') {
            setTimeout(function() {
                $('.alert-success').fadeOut();
            }, 3000);
        }
    }

    // Enhanced input validation
    $(".form-merge").on("input change", 'input[type=number]', function(e) {
        $(this).removeClass('is-invalid');
        var value = parseInt($(this).val());

        if (value > 0) {
            $(this).addClass('border-success');
            setTimeout(function() {
                $('input[type=number]').removeClass('border-success');
            }, 1500);
        }
    });

    // Enhanced Select2 initialization
    $('#exam_id').select2({
        allowClear: true,
        language: '{NV_LANG_INTERFACE}',
        theme: 'bootstrap-5',
        placeholder: '{LANG.select_exam}',
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=merge-exams&merge_opt_2&search_exams=1',
            dataType: 'json',
            delay: 300,
            data: function(params) {
                return {
                    search_key: params.term
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.title,
                            id: item.id,
                            data: item
                        };
                    })
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        minimumInputLength: 1
    });

    // Enhanced form submission
    $('.form-merge').on('submit', function(e) {
        if (!allow_submit_opt_1()) {
            e.preventDefault();
            return false;
        }

        var $submitBtn = $(this).find('button[type="submit"]');
        var originalHtml = $submitBtn.html();

        // Show loading state
        $submitBtn.prop('disabled', true)
                  .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang tạo đề thi...');

        // Restore after 10 seconds (fallback)
        setTimeout(function() {
            $submitBtn.prop('disabled', false).html(originalHtml);
        }, 10000);
    });

    // Clear validation on select change
    $('#exam_id').on('select2:select select2:clear', function(e) {
        $(this).removeClass('is-invalid');
    });

    // Make allow_submit_opt_1 globally available
    window.allow_submit_opt_1 = allow_submit_opt_1;
});
//]]>
</script>
<!-- END: merge_exams_opt_1 -->

<!-- BEGIN: merge_exams_opt_2 -->
<div id="merge-overlay"><div class="loading-icon"></div></div>
<!-- BEGIN: messages_opt_2 -->
<div class="{MESSAGES.class}">{MESSAGES.message}</div>
<!-- END: messages_opt_2 -->
<form action="{MERGE_OP2}" method="post" style="margin-bottom: 20px;" class="form-merge form-search">
    <div class="form-group">
        <div class="row">
            <div class="col-md-2 text-center"><label for="search">{LANG.merge_search}</label></div>
            <div class="col-md-8">
                <select name="examid" id="search-exams" class="form-control"></select>
            </div>
            <div class="col-md-4">
                <input type="submit" name="submit" class="btn btn-info" value="{LANG.merge_search_button}">
                <input type="hidden" name="submit_search" value="1">
            </div>
        </div>
    </div>
</form>
<div class="table-responsive" style="overflow-x: hidden;">
    <table class="table table-striped table-bordered table-hover table-middle table-exams">
        <thead>
            <tr>
                <th class="text-center">{LANG.label_num}</th>
                <th class="text-center" colspan="2">{LANG.label_subject}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="w50 text-center">{STT}</td>
                <td>{EXAMS.title}</td>
                <td class="w300 text-center">
                <!-- BEGIN: btn_add_exam -->
                <a href="#" class="btn btn-default btn-add-exam" id="exam_{EXAMS.id}">
                    <i class="fa fa-plus-circle "></i> {LANG.merge_exams_opt_2_button_add}
                </a>
                <!-- END: btn_add_exam -->
                <!-- BEGIN: disable_click -->
                <a href="#" class="btn btn-default disable-click" id="exam_{EXAMS.id}">
                    <i class="fa fa-check "></i> {LANG.merge_exams_opt_2_button_done}
                </a>
                <!-- END: disable_click -->
                </td>
            </tr>
            <tr class="hidden" data-exam="exam_{EXAMS.id}">
                <td>{EXAMS.title}</td>
                <td class="w300 text-center">{EXAMS.num_question}</td>
                <td class="w300"><input type="number" name="exams[{EXAMS.id}]" class="form-control text-center number-needer" min="0" max="{EXAMS.count_question}"/></td>
                <td class="w300 text-center"><i class="fa fa-remove icon-round-red pointer delete-exam-selected"></i></td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <!-- BEGIN: generate_page -->
    <div id="exam-paginate" class="text-center">
        {GENERATE_PAGE}
    </div>
    <!-- END: generate_page -->
</div>
<div id="anchor-form-multi"></div>
<form action="{MERGE_OP2}" method="post" class="form-merge form-multi" onsubmit="return allow_submit_opt_2()">
    <div class="table-responsive" style="overflow-x: hidden;">
        <table class="table table-striped table-bordered table-hover table-middle table-exams-selected" style="margin-top: 30px;">
            <thead>
                <tr>
                    <th class="text-center" style="width: 25%">{LANG.label_subject}</th>
                    <th class="text-center" style="width: 25%">{LANG.label_number_question}</th>
                    <th class="text-center" style="width: 25%">{LANG.label_number_needer}</th>
                    <th class="text-center"  style="width: 25%"></th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: selected_exam -->
                <tr>
                    <td>{ROW.title}</td>
                    <td class="w300 text-center">{ROW.num_question}</td>
                    <td class="w300 text-center">
                        <input type="number" name="exams[{ROW.id}]" class="form-control text-center number-needer" min="0" max="{ROW.num_question}" value="{ROW.value}">
                    </td>
                    <td class="w300 text-center"><i class="fa fa-remove icon-round-red pointer delete-exam-selected"></i></td>
                </tr>
                <!-- END: selected_exam -->
            </tbody>
        </table>
        <div class="row red-tooltip" style="margin-top: 50px;">
            <div class="col-md-24 col-md-push-8">
                <div class="form-group">
                   <div class="row">
                        <div class="col-md-4"><label for="">{LANG.label_number_selected}</label></div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" disabled id="total-questions" title="{LANG.error_not_input_number_question}" data-toggle="tooltip" data-trigger="manual" data-placement="auto"/>
                            <input type="hidden" name="number_question" id="total-questions-hidden" value="{total_questions}">
                        </div>
                   </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4"><label for="">{LANG.label_number_exams}</label></div>
                        <div class="col-md-4">
                            <input type="number" name="number_exam" class="form-control" value="{NUMBER_EXAM}" min="0" title="{LANG.error_not_input_number_exam}" data-toggle="tooltip" data-trigger="manual" data-placement="auto"/>
                        </div>
                   </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4"><label for="">{LANG.label_subject} <span style="color: red;">(*)</span></label></div>
                        <div class="col-md-4">
                            <input type="text" name="title_exam" class="form-control" value="{title_exam_opt_2}" title="{LANG.error_not_input_title_exam}" data-toggle="tooltip" data-trigger="manual" data-placement="auto"/>
                        </div>
                   </div>
                </div>
                <div class="top-content-config">{TOP_CONTENT}</div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-push-2 col-md-4 text-center">
                            <input type="submit" name="create_exam_2" value="{LANG.create_exam}" class="btn btn-primary"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var list_selected = [{list_selected}];
    function allow_submit_opt_2() {
        var title_exam = $("input[name=title_exam").val(),
        number_question = $("input[name=number_question").val(),
        number_exam = $( "input[name=number_exam").val();
        if (!title_exam || title_exam.length == 0) {
            $('input[name=title_exam').tooltip('show');
        }
        if (number_question == 0) {
            $("#total-questions" ).tooltip('show');
        }
        if (number_exam == 0) {
            $("input[name=number_exam" ).tooltip('show');
        }
        return (title_exam.length > 0) && (number_question > 0) && (number_exam > 0);
    }
    function hide_tooltip() {
        $('input[name=title_exam').tooltip('hide');
        $("#total-questions" ).tooltip('hide');
        $("input[name=number_exam" ).tooltip('hide');
    }
    function update_number_question() {
        /* Act on the event */
        var total = 0;
        $('.number-needer').each(function(index, el) {
            total += +$(this).val();
        });
        $('#total-questions').val(total);
        $('#total-questions-hidden').val(total);
        hide_tooltip();
    }
    jQuery(document).ready(function($) {
        update_number_question();
        $("input[name=title_exam" ).focus(function() {
            hide_tooltip();
        })
        $("input[name=number_exam" ).focus(function() {
            hide_tooltip();
        })
        /* thay đổi trạng thái cho những đề thi đã chọn */
        function status_selected_opt_2() {
            $(".table-exams").find()
        }
        /* Pagination ajax */
        $('#contentmod').on('click', '.pagination a', function(e) {
            e.preventDefault();
            var this_e = $(this);
            // var href = window.location.protocol + window.location.hostname + this_e.attr('href'),
            // url = new URL(href),
            //page = url.searchParams.get('page');
            var page = this_e.text();
            $.ajax({
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=merge-exams&merge_opt_2',
                type: 'POST',
                data: {
                    page: page,
                    paginate: 1
                },
                beforeSend: function(){
                    $("#merge-overlay").show();
                },
                success: function(response){
                    $('.table-exams>tbody').html(response.html);
                    $('#exam-paginate').html(response.paginate);
                    this_e.parent().addClass('active');
                    this_e.parent().siblings().removeClass('active');
                    setInterval(function() {
                        $("#merge-overlay").hide();
                    },500);
                    /* Marked question is selected */
                    list_selected.forEach(function(id){
                        $('#exam_'+id).removeClass('btn-add-exam').addClass('disable-click');
                        $('#exam_'+id).html('<i class="fa fa-check "></i> {LANG.merge_exams_opt_2_button_done}');
                    });
                },
                error: function() {}
            });
        });
        /* Add exam to new table after click button add*/

        $('.table-responsive').on('click', '.btn-add-exam',  function(e) {
            e.preventDefault();
            var el_html = $(this).parents('tr').next('.hidden').clone();
            $('.table-exams-selected>tbody').append(el_html);
            $('.table-exams-selected>tbody>tr').removeClass('hidden');
            $(this).removeClass('btn-add-exam').addClass('disable-click');
            $(this).html('<i class="fa fa-check "></i> {LANG.merge_exams_opt_2_button_done}');
            list_selected.push($(this).attr('id').substr(5));
        });
        $('.table-responsive').on('click', '.disable-click',  function(e) {
            e.preventDefault();
            var examid = $(this).attr('id').substr(5);
            $(this).removeClass('disable-click').addClass('btn-add-exam');
            $(this).html('<i class="fa fa-plus-circle"></i> {LANG.merge_exams_opt_2_button_add}');
            $('.table-exams-selected').find('tr[data-exam="exam_' +  examid +'"]').remove();

            var index = list_selected.indexOf(examid);
            list_selected.splice(index, 1);
            update_number_question();
        });
        $('.table-exams-selected').on('click', '.delete-exam-selected', function(e) {
            var examid = $(e.target).closest('tr').attr('data-exam');
            $('.table-responsive').find('#' + examid).removeClass('disable-click').addClass('btn-add-exam').html('<i class="fa fa-plus-circle"></i> {LANG.merge_exams_opt_2_button_add}');
            $(e.target).closest('tr').remove();

            var index = list_selected.indexOf(examid);
            list_selected.splice(index, 1);

            update_number_question();
        })
        /* Submit create exam */
        $('.form-multi').on('keyup blur change','input', function(e){
            var number_needer = parseInt($(e.target).val());
            var max_needer = parseInt($(e.target).attr('max'));
            if (number_needer > max_needer) {
                alert('{LANG.error_num_question_too_max}');
                $(e.target).val(max_needer);
                return !1;
            }
            update_number_question();
         });
        $('.form-multi').trigger("change");
        /* Live search */
        $('#search-exams').select2({
            allowClear: true,
            language : '{NV_LANG_INTERFACE}',
            theme : 'bootstrap',
            placeholder : '{LANG.select_exam}',
            ajax : {
                url : script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=merge-exams&merge_opt_2&search_exams=1',
                dataType : 'json',
                delay : 250,
                data : function(params) {
                    return {
                        search_key : params.term
                    };
                },
                processResults : function(data, params) {
                    params.page = params.page || 1;
                    return {
                         results: $.map(data, function(item) {
                            return {
                                text: item.title,
                                id: item.id,
                                data: item
                            };
                        })
                    };
                },
                cache : true
            },
            escapeMarkup : function(markup) {
                return markup;
            },
            minimumInputLength : 1
        });

        /* Submit search */
        $('.form-search').submit(function(e) {
            e.preventDefault();
            var form_data = $(this).serialize();
            var examid = $('select[name=examid]').val();
            var selected_examid = list_selected.some(function(id) {
                return examid  ==  id
            });
            form_data += ('&selected_examid=' + (selected_examid ? '1' : '0'));
            $.ajax({
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=merge-exams&merge_opt_2',
                type: 'POST',
                data: form_data,
                beforeSend: function(){
                    $("#merge-overlay").show();
                },
                success: function(response){
                    $('.table-exams>tbody').html(response.html);
                    $('#exam-paginate').html(response.paginate);
                    setInterval(function() {
                        $("#merge-overlay").hide();
                    },500);
                },
                error: function() {}
            });
        });
        var hash = window.location.hash.substring(1);
        if (hash == 'anchor-form-multi') {
             $('html, body').animate({
                scrollTop: 1000
            }, 1000);
            return false;
        }
    });
</script>
<!-- END: merge_exams_opt_2 -->
<!-- BEGIN: history -->
<!-- BEGIN: messages_history --><div class="alert alert-danger">{ERROR}</div><!-- END: messages_history -->
<form action="" method="POST">
    <div class="table-responsive abc">
        <table class="table table-striped table-bordered table-hover table-middle">
            <thead>
                <tr>
                    <th class="text-center">{LANG.merge_history_num}</th>
                    <th class="text-center">{LANG.merge_history_time}</th>
                    <th class="text-center">{LANG.merge_history_title}</th>
                    <th class="text-center">{LANG.merge_history_question}</th>
                    <th class="text-center">{LANG.label_number_exams}</th>
                    <th class="text-center" colspan="2">{LANG.merge_history_question_list}</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="w50 text-center">{HISTORY.stt}</td>
                    <td class="w150">{HISTORY.create_time}</td>
                    <td>{HISTORY.title}</td>
                    <td class="w150 text-center">{HISTORY.sum}</td>
                    <td class="w150 text-center">{HISTORY.number_exams}</td>
                    <td>
                        <ul class="list-exams-selected">
                            <!-- BEGIN: exams -->
                            <li>
                                <span class="exam_title">{EXAMS.title}</span><span class="num_question">{EXAMS.num_question}</span>
                            </li>
                             <!-- END: exams -->
                        </ul>
                    </td>
                    <td class="w150 text-center">
                        <a class="btn btn-primary" href="{HISTORY.download}" title="{LANG.merge_history_reuse}"  data-toggle="tooltip" data-original-title="{LANG.merge_history_reuse}"><i class="fa fa-download"></i></a>&nbsp;&nbsp;
                        <a class="btn btn-primary" href="{HISTORY.link}" title="{LANG.config_history_reuse}" data-toggle="tooltip" data-original-title="{LANG.config_history_reuse}"><i class="fa fa-refresh"></i></a>
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- BEGIN: generate_page -->
<div class="text-center">
    {GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: history -->
<!-- END: is_paid -->
<!-- END: main -->