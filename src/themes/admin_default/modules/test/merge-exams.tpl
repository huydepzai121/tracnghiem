<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css">
{PACKAGE_NOTIICE}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <div class="alert alert-primary border-0" <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-info-circle text-primary me-2 fs-5"></i>
                        <h6 class="mb-0 fw-bold">Hướng dẫn sử dụng</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <span class="badge bg-success me-2">1</span>
                                <div>
                                    <strong class="text-success">{LANG.merge_exams_opt_1}:</strong>
                                    <p class="mb-0 text-muted small">{LANG.info_merge_exams_opt_1}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <span class="badge bg-info me-2">2</span>
                                <div>
                                    <strong class="text-info">{LANG.merge_exams_opt_2}:</strong>
                                    <p class="mb-0 text-muted small">{LANG.info_merge_exams_opt_2}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN: is_free -->
                    <div class="mt-3 p-3 bg-warning bg-opacity-10 rounded">
                        <i class="fas fa-lock text-warning me-2"></i>
                        <em class="text-warning">{LANG.merge_required_is_paid}</em>
                    </div>
                    <!-- END: is_free -->
                </div>
            </div>
            <div class="flex-shrink-0">
                <button class="btn btn-outline-primary btn-sm show-msg" data-func="merge-exams"
                        <!-- BEGIN: msg_show -->style="display: none" <!-- END: msg_show -->>
                    <i class="fas fa-question-circle me-1"></i>{LANG.msg}
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
                <a class="btn btn-primary w-100 py-3" href="{MERGE_OP1}">
                    <i class="fas fa-random me-2"></i>{LANG.merge_exams_opt_1}
                </a>
            </div>
            <div class="col-md-4">
                <a class="btn btn-info w-100 py-3" href="{MERGE_OP2}">
                    <i class="fas fa-puzzle-piece me-2"></i>{LANG.merge_exams_opt_2}
                </a>
            </div>
            <div class="col-md-4">
                <a class="btn btn-success w-100 py-3" href="{MERGE_HISTORY}">
                    <i class="fas fa-history me-2"></i>{LANG.merge_exams_opt_3}
                </a>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN: is_paid -->
<!-- BEGIN: merge_exams_opt_1 -->
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-random me-2"></i>{LANG.merge_exams_opt_1}
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="{MERGE_OP1}" method="post" class="form-merge red-tooltip" onsubmit="return allow_submit_opt_1()">
            <!-- Select Exam Section -->
            <div class="mb-4">
                <label for="exam_id" class="form-label fw-bold text-primary mb-3">
                    <i class="fas fa-file-alt me-2"></i>Chọn đề thi gốc
                </label>
                <div id="exam_tooltip" title="{LANG.error_not_selected_exam}" data-toggle="tooltip" data-trigger="manual" data-placement="auto">
                    <select name="exam_id" id="exam_id" class="form-select form-select-lg">
                        <option value="">-- Chọn đề thi --</option>
                        <!-- BEGIN: loop -->
                        <option value="{exam_id}" {SELECTED}>{TITLE}</option>
                        <!-- END: loop -->
                    </select>
                </div>
            </div>

            <!-- Configuration Section -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="number_question" class="form-label fw-bold text-info mb-3">
                        <i class="fas fa-question-circle me-2"></i>Số câu hỏi mỗi đề
                    </label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-info">
                            <i class="fas fa-hashtag text-info"></i>
                        </span>
                        <input type="number" name="number_question" id="number_question"
                               placeholder="{LANG.number_question}" class="form-control border-info"
                               value="{NUMBER_QUESTION}" min="1"
                               title="{LANG.error_not_input_number_question}"
                               data-toggle="tooltip" data-trigger="manual" data-placement="auto" />
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="number_exam" class="form-label fw-bold text-warning mb-3">
                        <i class="fas fa-copy me-2"></i>Số đề thi cần tạo
                    </label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-warning">
                            <i class="fas fa-layer-group text-warning"></i>
                        </span>
                        <input type="number" name="number_exam" id="number_exam"
                               placeholder="{LANG.number_exam}" class="form-control border-warning"
                               value="{NUMBER_EXAM}" min="1"
                               title="{LANG.error_not_input_number_exam}"
                               data-toggle="tooltip" data-trigger="manual" data-placement="auto" />
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="text-center mt-4">
                <button type="submit" name="create_exam" class="btn btn-success btn-lg px-5 py-3 shadow">
                    <i class="fas fa-magic me-2"></i>{LANG.create_exam}
                    <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<div class="top-content-config">{TOP_CONTENT}</div>
<script>
    function allow_submit_opt_1() {
        var exam_id = $("#exam_id" ).val();
        number_question = $("input[name=number_question" ).val(),
        number_exam = $( "input[name=number_exam" ).val();
        if (!exam_id || exam_id.length == 0) {
            $('#exam_tooltip').tooltip('show');
        } 
        if (number_question == 0) {
            $("input[name=number_question" ).tooltip('show');
        }
        if (number_exam == 0) {
            $("input[name=number_exam" ).tooltip('show');
        }
        return (exam_id > 0) && (number_question > 0) && (number_exam > 0);
    }
    jQuery(document).ready(function($) {
        

        $('#exam_id').select2({
            allowClear: true,
            language : '{NV_LANG_INTERFACE}',
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
        

    })
</script>
<!-- END: merge_exams_opt_1 -->

<!-- BEGIN: merge_exams_opt_2 -->
<div id="merge-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50" style="z-index: 9999; display: none !important;">
    <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- BEGIN: messages_opt_2 -->
<div class="alert alert-dismissible fade show {MESSAGES.class}" role="alert">
    {MESSAGES.message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<!-- END: messages_opt_2 -->

<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-search me-2"></i>Tìm kiếm đề thi
        </h5>
    </div>
    <div class="card-body">
        <form action="{MERGE_OP2}" method="post" class="form-merge form-search">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label for="search-exams" class="form-label fw-bold">
                        <i class="fas fa-search me-1"></i>{LANG.merge_search}
                    </label>
                </div>
                <div class="col-md-7">
                    <select name="examid" id="search-exams" class="form-select form-select-lg"></select>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="submit" class="btn btn-info btn-lg w-100">
                        <i class="fas fa-search me-2"></i>{LANG.merge_search_button}
                    </button>
                    <input type="hidden" name="submit_search" value="1">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <h6 class="card-title mb-0 text-dark">
            <i class="fas fa-list me-2"></i>Danh sách đề thi
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 table-exams">
                <thead class="table-light">
                    <tr>
                        <th class="text-center fw-bold" style="width: 80px;">{LANG.label_num}</th>
                        <th class="fw-bold">{LANG.label_subject}</th>
                        <th class="text-center fw-bold" style="width: 200px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: loop -->
                    <tr>
                        <td class="text-center fw-bold text-muted">{STT}</td>
                        <td class="fw-medium">{EXAMS.title}</td>
                        <td class="text-center">
                        <!-- BEGIN: btn_add_exam -->
                        <button type="button" class="btn btn-outline-success btn-sm btn-add-exam" id="exam_{EXAMS.id}">
                            <i class="fas fa-plus me-1"></i> {LANG.merge_exams_opt_2_button_add}
                        </button>
                        <!-- END: btn_add_exam -->
                        <!-- BEGIN: disable_click -->
                        <button type="button" class="btn btn-success btn-sm disable-click" id="exam_{EXAMS.id}">
                            <i class="fas fa-check me-1"></i> {LANG.merge_exams_opt_2_button_done}
                        </button>
                        <!-- END: disable_click -->
                        </td>
                    </tr>
                    <tr class="d-none" data-exam="exam_{EXAMS.id}">
                        <td class="fw-medium">{EXAMS.title}</td>
                        <td class="text-center">{EXAMS.num_question}</td>
                        <td>
                            <input type="number" name="exams[{EXAMS.id}]" class="form-control form-control-sm text-center number-needer" min="0" max="{EXAMS.count_question}"/>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-outline-danger btn-sm delete-exam-selected">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- BEGIN: generate_page -->
    <div class="card-footer bg-light">
        <div id="exam-paginate" class="d-flex justify-content-center">
            {GENERATE_PAGE}
        </div>
    </div>
    <!-- END: generate_page -->
</div>
<div id="anchor-form-multi"></div>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="card-title mb-0">
            <i class="fas fa-clipboard-list me-2"></i>Đề thi đã chọn
        </h5>
    </div>
    <div class="card-body p-0">
        <form action="{MERGE_OP2}" method="post" class="form-merge form-multi" onsubmit="return allow_submit_opt_2()">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-exams-selected">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-bold">{LANG.label_subject}</th>
                            <th class="text-center fw-bold" style="width: 150px;">{LANG.label_number_question}</th>
                            <th class="text-center fw-bold" style="width: 150px;">{LANG.label_number_needer}</th>
                            <th class="text-center fw-bold" style="width: 100px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: selected_exam -->
                        <tr>
                            <td class="fw-medium">{ROW.title}</td>
                            <td class="text-center">{ROW.num_question}</td>
                            <td class="text-center">
                                <input type="number" name="exams[{ROW.id}]" class="form-control form-control-sm text-center number-needer" min="0" max="{ROW.num_question}" value="{ROW.value}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm delete-exam-selected">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- END: selected_exam -->
                    </tbody>
                </table>
            </div>
    </div>
    <div class="card-footer bg-light">
        <div class="row g-4">
            <div class="col-md-4">
                <label for="total-questions" class="form-label fw-bold text-info">
                    <i class="fas fa-calculator me-2"></i>{LANG.label_number_selected}
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-info">
                        <i class="fas fa-hashtag text-info"></i>
                    </span>
                    <input type="text" class="form-control border-info" disabled id="total-questions"
                           title="{LANG.error_not_input_number_question}"
                           data-toggle="tooltip" data-trigger="manual" data-placement="auto"/>
                    <input type="hidden" name="number_question" id="total-questions-hidden" value="{total_questions}">
                </div>
            </div>
            <div class="col-md-4">
                <label for="number_exam" class="form-label fw-bold text-warning">
                    <i class="fas fa-copy me-2"></i>{LANG.label_number_exams}
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-warning">
                        <i class="fas fa-layer-group text-warning"></i>
                    </span>
                    <input type="number" name="number_exam" id="number_exam" class="form-control border-warning"
                           value="{NUMBER_EXAM}" min="1"
                           title="{LANG.error_not_input_number_exam}"
                           data-toggle="tooltip" data-trigger="manual" data-placement="auto"/>
                </div>
            </div>
            <div class="col-md-4">
                <label for="title_exam" class="form-label fw-bold text-danger">
                    <i class="fas fa-tag me-2"></i>{LANG.label_subject} <span class="text-danger">(*)</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-danger">
                        <i class="fas fa-file-alt text-danger"></i>
                    </span>
                    <input type="text" name="title_exam" id="title_exam" class="form-control border-danger"
                           value="{title_exam_opt_2}"
                           title="{LANG.error_not_input_title_exam}"
                           data-toggle="tooltip" data-trigger="manual" data-placement="auto"/>
                </div>
            </div>
        </div>

        <div class="top-content-config mt-3">{TOP_CONTENT}</div>

        <div class="text-center mt-4">
            <button type="submit" name="create_exam_2" class="btn btn-primary btn-lg px-5 py-3 shadow">
                <i class="fas fa-magic me-2"></i>{LANG.create_exam}
                <i class="fas fa-arrow-right ms-2"></i>
            </button>
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
                        $('#exam_'+id).removeClass('btn-add-exam btn-outline-success').addClass('disable-click btn-success');
                        $('#exam_'+id).html('<i class="fas fa-check me-1"></i> {LANG.merge_exams_opt_2_button_done}');
                    });
                },
                error: function() {}   
            });
        });
        /* Add exam to new table after click button add*/
        
        $('.table-responsive').on('click', '.btn-add-exam',  function(e) {
            e.preventDefault();
            var el_html = $(this).parents('tr').next('.d-none').clone();
            $('.table-exams-selected>tbody').append(el_html);
            $('.table-exams-selected>tbody>tr').removeClass('d-none');
            $(this).removeClass('btn-add-exam btn-outline-success').addClass('disable-click btn-success');
            $(this).html('<i class="fas fa-check me-1"></i> {LANG.merge_exams_opt_2_button_done}');
            list_selected.push($(this).attr('id').substr(5));
            update_number_question();
        });
        $('.table-responsive').on('click', '.disable-click',  function(e) {
            e.preventDefault();
            var examid = $(this).attr('id').substr(5);
            $(this).removeClass('disable-click btn-success').addClass('btn-add-exam btn-outline-success');
            $(this).html('<i class="fas fa-plus me-1"></i> {LANG.merge_exams_opt_2_button_add}');
            $('.table-exams-selected').find('tr[data-exam="exam_' +  examid +'"]').remove();

            var index = list_selected.indexOf(examid);
            list_selected.splice(index, 1);
            update_number_question();
        });
        $('.table-exams-selected').on('click', '.delete-exam-selected', function(e) {
            var examid = $(e.target).closest('tr').attr('data-exam');
            $('.table-responsive').find('#' + examid).removeClass('disable-click btn-success').addClass('btn-add-exam btn-outline-success').html('<i class="fas fa-plus me-1"></i> {LANG.merge_exams_opt_2_button_add}');
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
        /* Live search - Fixed version */
        $('#search-exams').select2({
            allowClear: true,
            placeholder: 'Tìm kiếm đề thi...',
            width: '100%',
            ajax: {
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=merge-exams&merge_opt_2&search_exams=1',
                dataType: 'json',
                delay: 300,
                data: function(params) {
                    return {
                        search_key: params.term || ''
                    };
                },
                processResults: function(data) {
                    if (!data || !Array.isArray(data)) {
                        return { results: [] };
                    }
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.title || item.text || 'Không có tiêu đề'
                            };
                        })
                    };
                },
                error: function(xhr, status, error) {
                    console.error('Select2 AJAX Error:', error);
                    return { results: [] };
                }
            },
            escapeMarkup: function(markup) {
                return $('<div>').text(markup).html();
            },
            templateResult: function(exam) {
                if (exam.loading) {
                    return 'Đang tìm kiếm...';
                }
                return exam.text || '';
            },
            templateSelection: function(exam) {
                return exam.text || 'Tìm kiếm đề thi...';
            },
            minimumInputLength: 1
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