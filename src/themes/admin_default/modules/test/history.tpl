<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css">

{PACKAGE_NOTIICE}

<!-- BEGIN: test_message_danger -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    {test_message_danger}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: test_message_danger -->

<!-- BEGIN: guider -->
<div class="card border-info mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <div class="alert alert-info mb-0" <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-info-circle me-2"></i>
                    {alert_warning}
                </div>
            </div>
            <div class="flex-shrink-0">
                <button class="btn btn-outline-info btn-sm show-msg" data-func="history"
                        <!-- BEGIN: msg_show -->style="display: none" <!-- END: msg_show -->>
                    <i class="fas fa-question-circle me-1"></i>{LANG.msg}
                </button>
                <button class="btn btn-outline-secondary btn-sm close-msg" data-func="history"
                        <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END: guider -->

<div class="module-test history">
    <div class="card shadow-sm mb-4 d-print-none">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-search me-2"></i>Tìm kiếm lịch sử thi
            </h5>
        </div>
        <div class="card-body">
            <form action="{NV_BASE_ADMINURL}index.php" method="get">
                <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
                <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
                <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="fas fa-users me-1"></i>Nhóm người dùng
                        </label>
                        <select name="groupid[]" id="groupid" multiple="multiple" class="form-select">
                            <!-- BEGIN: group -->
                            <option value="{GROUP.index}" {GROUP.selected}>{GROUP.title}</option>
                            <!-- END: group -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="fas fa-file-alt me-1"></i>Đề thi
                        </label>
                        <select name="examid" id="examid" class="form-select">
                            <!-- BEGIN: examid -->
                            <option value="{ROW.exam_id}" selected="selected">{ROW.exam_title}</option>
                            <!-- END: examid -->
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-user me-1"></i>Người dùng
                        </label>
                        <select name="userid" id="userid" class="form-select">
                            <!-- BEGIN: user -->
                            <option value="{USER.userid}" selected="selected">{USER.fullname}</option>
                            <!-- END: user -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-star me-1"></i>Xếp loại
                        </label>
                        <select name="rating" class="form-select">
                            <option value="0" selected="selected">{LANG.rating_multi_choice}</option>
                            <!-- BEGIN: rating_option -->
                            <option value="{RATING.value}" {RATING.selected}>{RATING.title}</option>
                            <!-- END: rating_option -->
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar me-1"></i>Từ ngày
                        </label>
                        <div class="input-group">
                            <input class="form-control datepicker" value="{SEARCH.timefrom}" type="text"
                                   name="timefrom" placeholder="{LANG.timefrom}" />
                            <span class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar me-1"></i>Đến ngày
                        </label>
                        <div class="input-group">
                            <input class="form-control datepicker" value="{SEARCH.timeto}" type="text"
                                   name="timeto" placeholder="{LANG.timeto}" />
                            <span class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">
                            <i class="fas fa-list me-1"></i>Số dòng
                        </label>
                        <select class="form-select" name="perpage">
                            <option value="0">--- {LANG.perpage} ---</option>
                            <!-- BEGIN: perpage -->
                            <option value="{PERPAGE.index}"{PERPAGE.selected}>{PERPAGE.index}</option>
                            <!-- END: perpage -->
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3" id="nottest">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="nottest" value="1"
                                   id="nottest_check" {SEARCH.ck_nottest} />
                            <label class="form-check-label" for="nottest_check">
                                <i class="fas fa-user-times me-1"></i>{LANG.search_user_not_test}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary loading" type="submit">
                            <i class="fas fa-search me-1"></i>{LANG.search_submit}
                        </button>
                        <button class="btn btn-secondary" type="button" onclick="nv_formReset(this.form)">
                            <i class="fas fa-undo me-1"></i>{LANG.reset}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Enhanced Action Panel -->
    <div class="card shadow-sm mb-4 d-print-none">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="fas fa-tools me-2"></i>Thao tác với dữ liệu
                </h6>
                <span class="badge bg-light text-dark" id="selected-count">0 mục được chọn</span>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <select class="form-select" id="action-top">
                        <!-- BEGIN: action_top -->
                        <option value="{ACTION.key}">{ACTION.value}</option>
                        <!-- END: action_top -->
                    </select>
                </div>
                <div class="col-md-8">
                    <div class="btn-group w-100" role="group">
                        <button class="btn btn-success" onclick="nv_list_action( $('#action-top').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
                            <i class="fas fa-play me-2"></i>{LANG.perform}
                        </button>
                        <button class="btn btn-info <!-- BEGIN: download_disabled -->disabled<!-- END: download_disabled -->" onclick="nv_download_history();">
                            <i class="fas fa-download me-2"></i>{LANG.download}
                        </button>
                        <!-- <button class="btn btn-primary" onclick="nv_view_statistics('{ROW.exam_id}', '{TITLE_PAGE}'); return false;">
                            <i class="fas fa-chart-pie me-2"></i>{LANG.statistics}
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Enhanced Results Table -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-success text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>Kết quả lịch sử thi
                </h6>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-light btn-sm" id="select-all-btn">
                        <i class="fas fa-check-square me-1"></i>Chọn tất cả
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" id="deselect-all-btn">
                        <i class="fas fa-square me-1"></i>Bỏ chọn
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <form id="history-form">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th class="text-center" style="width: 50px;">
                                    <div class="form-check">
                                        <input name="check_all[]" type="checkbox" value="yes" class="form-check-input" id="checkAll"
                                               onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);">
                                        <label class="form-check-label" for="checkAll">
                                            <span class="visually-hidden">Chọn tất cả</span>
                                        </label>
                                    </div>
                                </th>
                                <th class="text-center" style="width: 60px;">
                                    <i class="fas fa-hashtag me-1"></i>{LANG.number}
                                </th>
                                <!-- BEGIN: field_head -->
                                <th>
                                    <i class="fas fa-user me-1"></i>{FIELD.title}
                                </th>
                                <!-- END: field_head -->
                                <th class="text-center" style="width: 100px;">
                                    <a href="{SORTURL.score}" class="text-white text-decoration-none d-flex align-items-center justify-content-center">
                                        <!-- BEGIN: score_no --><i class="fas fa-sort me-1"></i><!-- END: score_no -->
                                        <!-- BEGIN: score -->
                                            <!-- BEGIN: desc --><i class="fas fa-sort-numeric-down me-1"></i><!-- END: desc -->
                                            <!-- BEGIN: asc --><i class="fas fa-sort-numeric-up me-1"></i><!-- END: asc -->
                                        <!-- END: score -->
                                        <i class="fas fa-star me-1"></i>{LANG.score}
                                    </a>
                                </th>
                                <th class="text-center" style="width: 120px;">
                                    <a href="{SORTURL.test_time}" class="text-white text-decoration-none d-flex align-items-center justify-content-center">
                                        <!-- BEGIN: test_time_no --><i class="fas fa-sort me-1"></i><!-- END: test_time_no -->
                                        <!-- BEGIN: test_time -->
                                            <!-- BEGIN: desc --><i class="fas fa-sort-numeric-down me-1"></i><!-- END: desc -->
                                            <!-- BEGIN: asc --><i class="fas fa-sort-numeric-up me-1"></i><!-- END: asc -->
                                        <!-- END: test_time -->
                                        <i class="fas fa-clock me-1"></i>{LANG.timer}
                                    </a>
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <a href="{SORTURL.count_true}" class="text-white text-decoration-none d-flex align-items-center justify-content-center">
                                        <!-- BEGIN: rating_no --><i class="fas fa-sort me-1"></i><!-- END: rating_no -->
                                        <!-- BEGIN: rating -->
                                            <!-- BEGIN: desc --><i class="fas fa-sort-numeric-down me-1"></i><!-- END: desc -->
                                            <!-- BEGIN: asc --><i class="fas fa-sort-numeric-up me-1"></i><!-- END: asc -->
                                        <!-- END: rating -->
                                        <i class="fas fa-medal me-1"></i>{LANG.rating_multi_choice}
                                    </a>
                                </th>
                                <th class="text-center" style="width: 80px;">
                                    <a href="{SORTURL.count_true}" class="text-white text-decoration-none d-flex align-items-center justify-content-center">
                                        <!-- BEGIN: count_true_no --><i class="fas fa-sort me-1"></i><!-- END: count_true_no -->
                                        <!-- BEGIN: count_true -->
                                            <!-- BEGIN: desc --><i class="fas fa-sort-numeric-down me-1"></i><!-- END: desc -->
                                            <!-- BEGIN: asc --><i class="fas fa-sort-numeric-up me-1"></i><!-- END: asc -->
                                        <!-- END: count_true -->
                                        <i class="fas fa-check me-1"></i>{LANG.tester_info_true}
                                    </a>
                                </th>
                                <th class="text-center" style="width: 80px;">
                                    <a href="{SORTURL.count_false}" class="text-white text-decoration-none d-flex align-items-center justify-content-center">
                                        <!-- BEGIN: count_false_no --><i class="fas fa-sort me-1"></i><!-- END: count_false_no -->
                                        <!-- BEGIN: count_false -->
                                            <!-- BEGIN: desc --><i class="fas fa-sort-numeric-down me-1"></i><!-- END: desc -->
                                            <!-- BEGIN: asc --><i class="fas fa-sort-numeric-up me-1"></i><!-- END: asc -->
                                        <!-- END: count_false -->
                                        <i class="fas fa-times me-1"></i>{LANG.tester_info_false}
                                    </a>
                                </th>
                                <th class="text-center" style="width: 80px;">
                                    <a href="{SORTURL.count_skeep}" class="text-white text-decoration-none d-flex align-items-center justify-content-center">
                                        <!-- BEGIN: count_skeep_no --><i class="fas fa-sort me-1"></i><!-- END: count_skeep_no -->
                                        <!-- BEGIN: count_skeep -->
                                            <!-- BEGIN: desc --><i class="fas fa-sort-numeric-down me-1"></i><!-- END: desc -->
                                            <!-- BEGIN: asc --><i class="fas fa-sort-numeric-up me-1"></i><!-- END: asc -->
                                        <!-- END: count_skeep -->
                                        <i class="fas fa-minus me-1"></i>{LANG.tester_info_skeep}
                                    </a>
                                </th>
                                <th class="text-center" style="width: 120px;">
                                    <i class="fas fa-edit me-1"></i>{LANG.score_constructed_response}
                                </th>
                                <th class="text-center" style="width: 80px;">
                                    <i class="fas fa-cogs me-1"></i>Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="history-row
                                <!-- BEGIN: row_click -->
                                table-hover-pointer
                                <!-- END: row_click -->
                                <!-- BEGIN: let_update -->
                                table-warning
                                <!-- END: let_update -->
                                " data-id="{VIEW.id}"
                                <!-- BEGIN: row_click -->
                                onclick="nv_table_row_click(event, '{VIEW.link_answer}', false);"
                                <!-- END: row_click -->
                                <!-- BEGIN: let_update -->
                                onclick="alert('{LANG.please_update}')"
                                <!-- END: let_update -->
                                >
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input history-checkbox"
                                               onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);"
                                               value="{VIEW.id}" name="idcheck[]" id="check_{VIEW.id}">
                                        <label class="form-check-label" for="check_{VIEW.id}">
                                            <span class="visually-hidden">Chọn mục này</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{VIEW.number}</span>
                                </td>
                                <!-- BEGIN: field_body -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2">
                                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                                        </div>
                                        <div class="user-info">
                                            <div class="fw-bold text-primary">{FIELD.value}</div>
                                            <small class="text-muted">ID: {VIEW.id}</small>
                                        </div>
                                    </div>
                                </td>
                                <!-- END: field_body -->
                                <td class="text-center">
                                    <span class="badge bg-success fs-6">{VIEW.score}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{VIEW.test_time}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning text-dark">{VIEW.rating.title}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success rounded-pill">{VIEW.count_true}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger rounded-pill">{VIEW.count_false}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill">{VIEW.count_skeep}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{VIEW.mark_constructed_response}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- BEGIN: delete -->
                                        <a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);"
                                           class="btn btn-outline-danger" data-bs-toggle="tooltip" title="{LANG.delete}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <!-- END: delete -->
                                        <!-- BEGIN: delete_disabled -->
                                        <button class="btn btn-outline-secondary" disabled="disabled"
                                                data-bs-toggle="tooltip" title="Không thể xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <!-- END: delete_disabled -->
                                        <!-- BEGIN: row_click -->
                                        <a href="{VIEW.link_answer}" class="btn btn-outline-primary" target="_blank"
                                           data-bs-toggle="tooltip" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- END: row_click -->
                                    </div>
                                </td>
                            </tr>
                            <tr class="history-detail-row">
                                <!-- BEGIN: other -->
                                <td colspan="{colspan_item}" class="bg-light">
                                    <div class="d-flex flex-wrap gap-3 align-items-center py-2">
                                        <!-- BEGIN: exams -->
                                        <div class="exam-info">
                                            <i class="fas fa-file-alt text-primary me-1"></i>
                                            <a href="{VIEW.exams.link}" target="_blank" class="text-decoration-none fw-bold">
                                                {VIEW.exams.title}
                                            </a>
                                        </div>
                                        <!-- END: exams -->
                                        <div class="time-info">
                                            <i class="fas fa-clock text-info me-1"></i>
                                            <span class="fw-medium">{VIEW.begin_time} - {VIEW.end_time}</span>
                                            <a href="{SORTURL.begin_time}" class="text-decoration-none ms-2" title="Sắp xếp theo thời gian">
                                                <!-- BEGIN: no --><i class="fas fa-sort text-muted"></i><!-- END: no -->
                                                <!-- BEGIN: desc --><i class="fas fa-sort-numeric-down text-primary"></i><!-- END: desc -->
                                                <!-- BEGIN: asc --><i class="fas fa-sort-numeric-up text-primary"></i><!-- END: asc -->
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <!-- END: other -->
                            </tr>
                            <!-- END: loop -->
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <!-- BEGIN: generate_page -->
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-center">
                {NV_GENERATE_PAGE}
            </div>
        </div>
        <!-- END: generate_page -->
    </div>

    <!-- Bottom Action Panel -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <select class="form-select" id="action-bottom">
                        <!-- BEGIN: action_bottom -->
                        <option value="{ACTION.key}">{ACTION.value}</option>
                        <!-- END: action_bottom -->
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button class="btn btn-success" onclick="nv_list_action( $('#action-bottom').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
                            <i class="fas fa-play me-2"></i>{LANG.perform}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<script>
    $('#groupid').select2({
        language : '{NV_LANG_INTERFACE}',
        placeholder : '{LANG.group_select}',
        closeOnSelect: true,
        tags: true,
    });

    $(".datepicker").datepicker({
        dateFormat : "dd/mm/yy",
        changeMonth : !0,
        changeYear : !0,
        showOtherMonths : !0,
        showOn : "focus",
        yearRange : "-90:+0"
    });
</script>
<script type="text/javascript">
    //<![CDATA[

/* Print functionality removed */

    $(document).ready(function() {
        // Enhanced table interactions
        $('.td-click').click(function() {
            window.location.href = $(this).find('a').attr('href');
        });

        // Enhanced checkbox functionality
        function updateSelectedCount() {
            var count = $('.history-checkbox:checked').length;
            $('#selected-count').text(count + ' mục được chọn');

            // Update button states
            if (count > 0) {
                $('#action-top, #action-bottom').prop('disabled', false);
                $('.btn[onclick*="nv_list_action"]').removeClass('disabled');
            } else {
                $('#action-top, #action-bottom').prop('disabled', true);
                $('.btn[onclick*="nv_list_action"]').addClass('disabled');
            }
        }

        // Select/Deselect all functionality
        $('#select-all-btn').click(function() {
            $('.history-checkbox').prop('checked', true);
            $('#checkAll').prop('checked', true);
            updateSelectedCount();
        });

        $('#deselect-all-btn').click(function() {
            $('.history-checkbox').prop('checked', false);
            $('#checkAll').prop('checked', false);
            updateSelectedCount();
        });

        // Update count when checkboxes change
        $(document).on('change', '.history-checkbox, #checkAll', function() {
            updateSelectedCount();
        });

        // Initialize tooltips
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Enhanced row hover effects
        $('.history-row').hover(
            function() {
                $(this).addClass('table-active');
                $(this).next('.history-detail-row').addClass('table-active');
            },
            function() {
                $(this).removeClass('table-active');
                $(this).next('.history-detail-row').removeClass('table-active');
            }
        );

        // Initialize with current state
        updateSelectedCount();

        $("#userid").select2({
            language : "{NV_LANG_INTERFACE}",
            theme : "bootstrap",
            placeholder : "{LANG.user_select}",
            ajax : {
                url : script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=history&get_user_json=1',
                dataType : 'json',
                delay : 250,
                data : function(params) {
                    return {
                        q : params.term, // search term
                        page : params.page
                    };
                },
                processResults : function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results : data,
                        pagination : {
                            more : (params.page * 30) < data.total_count
                        }
                    };
                },
                cache : true
            },
            escapeMarkup : function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength : 1,
            templateResult : formatRepo, // omitted for brevity, see the source of this page
            templateSelection : formatRepoSelection
        // omitted for brevity, see the source of this page
        });
        $("#examid").select2({
            language : "{NV_LANG_INTERFACE}",
            theme : "bootstrap",
            placeholder : "{LANG.select_exam}",
            ajax : {
                url : script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=history&get_exam_json=1',
                dataType : 'json',
                delay : 250,
                data : function(params) {
                    return {
                        q : params.term
                    };
                },
                processResults : function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results : data,
                    };
                },
                cache : true
            },
            escapeMarkup : function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength : 1,
        });
    });

    function formatRepo(repo) {
        if (repo.loading)
            return repo.text;
        var markup = '<div class="clearfix">' + '<div class="col-sm-19">' + repo.fullname + '</div>' + '<div clas="col-sm-5"><span class="show text-right">' + repo.email + '</span></div>' + '</div>';
        markup += '</div></div>';
        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.fullname || repo.text;
    }

    function nv_change_weight(id) {
        var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
        var new_vid = $('#id_weight_' + id).val();
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-question&nocache=' + new Date().getTime(), 'ajax_action=1&id={ROW.exam_id}&eqid=' + id + '&new_vid=' + new_vid, function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(nv_is_change_act_confirm[2]);
            }
            clearTimeout(nv_timer);
            window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-question&id={ROW.exam_id}';
            return;
        });
        return;
    }

    var page = 1;
    function nv_download_history(){
        $.ajax({
        	type : 'POST',
        	url : '{URL_DOWNLOAD}&nocache=' + new Date().getTime(),
        	data : 'download=1&page=' + page,
        	beforeSend: function(){
        	    if(page == 1){
        	        $('body').append('<div class="ajax-load-qa"></div>');
        	    }
        	},
        	success : function(json) {
        	    if(!json.exit){
        	        setTimeout(function(){
        	            page++;
                	    nv_download_history();
        	        }, 2000);
        	    }else{
        	        $('.ajax-load-qa').remove();
        	        window.open(json.url_download, '_blank');
        	    }
        	}
        });
    }

    //]]>
</script>
<!-- END: main -->