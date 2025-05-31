<!-- BEGIN: main -->
{PACKAGE_NOTIICE}

<!-- BEGIN: guider -->
<div class="card border-info mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <div class="alert alert-info mb-0" <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-info-circle me-2"></i>
                    {LANG.guider_search_questions}
                </div>
            </div>
            <div class="flex-shrink-0">
                <button class="btn btn-outline-info btn-sm show-msg" data-func="search_questions"
                        <!-- BEGIN: msg_show -->style="display: none" <!-- END: msg_show -->>
                    <i class="fas fa-question-circle me-1"></i>{LANG.msg}
                </button>
                <button class="btn btn-outline-secondary btn-sm close-msg" data-func="search_questions"
                        <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END: guider -->

<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-search me-2"></i>Tìm kiếm câu hỏi
        </h5>
    </div>
    <div class="card-body">
        <form action="{NV_BASE_ADMINURL}index.php" method="get">
            <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search me-1"></i>Từ khóa
                    </label>
                    <input class="form-control" type="text" value="{SEARCH.q}" name="q"
                           maxlength="255" placeholder="{LANG.search_title}" />
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="fas fa-database me-1"></i>Loại ngân hàng
                    </label>
                    <select name="bank_type" class="form-select">
                        <option value="0">--- {LANG.bank_type} ---</option>
                        <!-- BEGIN: bank_type -->
                        <option value="{BANK_TYPE.id}" {BANK_TYPE.selected}>{BANK_TYPE.title}</option>
                        <!-- END: bank_type -->
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="fas fa-tags me-1"></i>Ngân hàng câu hỏi
                    </label>
                    <select name="bank_question" class="form-select" onchange="change_bank_question(event)">
                        <option value="0">--- {LANG.type_input_question_2} ---</option>
                        <!-- BEGIN: bank_question -->
                        <option value="{BANK_QUESTION.id}" {BANK_QUESTION.selected}>{BANK_QUESTION.title}</option>
                        <!-- END: bank_question -->
                    </select>
                </div>
                <div id="typeid" class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="fas fa-folder me-1"></i>Danh mục
                    </label>
                    <select name="typeid" class="form-select">
                        <option value="0">--- {LANG.select_category} ---</option>
                        <!-- BEGIN: bank_typeid -->
                        <option value="{TYPEID.id}" {TYPEID.selected}>{TYPEID.title}</option>
                        <!-- END: bank_typeid -->
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="fas fa-list me-1"></i>Số dòng
                    </label>
                    <select name="per_page" class="form-select">
                        <option value="20" {per_page_selected_20}>--- {LANG.exams_per_page} ---</option>
                        <option value="10" {per_page_selected_10}>10</option>
                        <option value="20" {per_page_selected_20}>20</option>
                        <option value="50" {per_page_selected_50}>50</option>
                        <option value="100" {per_page_selected_100}>100</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-search me-1"></i>{LANG.search_submit}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Lỗi:</strong> {ERROR}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->

<div class="d-flex flex-wrap gap-2 mb-4 justify-content-between align-items-center">
    <div class="input-group" style="max-width: 300px;">
        <select class="form-select" id="action_bottom">
            <!-- BEGIN: action_top -->
            <option value="{ACTION.key}">{ACTION.value}</option>
            <!-- END: action_top -->
        </select>
        <button class="btn btn-outline-primary"
                onclick="nv_list_action( $('#action_bottom').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
            <i class="fas fa-play me-1"></i>{LANG.perform}
        </button>
    </div>

    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group me-2" role="group">
            <a class="btn btn-outline-success"
               href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=bank">
                <i class="fas fa-folder me-1"></i>{LANG.admin_cat}
            </a>
            <a class="btn btn-success"
               href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=question-content">
                <i class="fas fa-plus-circle me-1"></i>{LANG.question_add}
            </a>
        </div>

        <div class="btn-group me-2" role="group">
            <!-- BEGIN: msword -->
            <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=questionword"
               class="btn btn-outline-info">
                <i class="fas fa-file-word me-1"></i>{LANG.importword}
            </a>
            <!-- END: msword -->
            <!-- BEGIN: msexcel -->
            <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=questionexcel"
               class="btn btn-outline-warning">
                <i class="fas fa-file-excel me-1"></i>{LANG.importexcel}
            </a>
            <!-- END: msexcel -->
        </div>

        <div class="btn-group" role="group">
            <a href="{BASE_URL}&exportword=1&page={PAGE}" class="btn btn-outline-primary">
                <i class="fas fa-download me-1"></i>{LANG.export_word}
            </a>
            <a href="{BASE_URL}&exportexcel=1&page={PAGE}" class="btn btn-outline-secondary">
                <i class="fas fa-download me-1"></i>{LANG.export_excel}
            </a>
        </div>
    </div>
</div>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">
                            <input name="check_all[]" type="checkbox" value="yes" class="form-check-input"
                                   onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);">
                        </th>
                        <th>
                            <i class="fas fa-question-circle me-1"></i>{LANG.question_content}
                        </th>
                        <th style="width: 200px;">
                            <i class="fas fa-database me-1"></i>{LANG.bank_type}
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <i class="fas fa-calendar-plus me-1"></i>{LANG.addtime}
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <i class="fas fa-calendar-edit me-1"></i>{LANG.edittime1}
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <i class="fas fa-cogs me-1"></i>Thao tác
                        </th>
                    </tr>
                </thead>
                <!-- BEGIN: generate_page -->
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="6">
                            <div class="d-flex justify-content-center">
                                {NV_GENERATE_PAGE}
                            </div>
                        </td>
                    </tr>
                </tfoot>
                <!-- END: generate_page -->
                <tbody>
                    <!-- BEGIN: loop -->
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="form-check-input post"
                                   onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);"
                                   value="{VIEW.id}" name="idcheck[]">
                        </td>
                        <td class="{text_danger}">
                            <div class="fw-bold text-truncate" style="max-width: 400px;" title="{VIEW.title}">
                                {VIEW.title}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{VIEW.bank_type}</span>
                        </td>
                        <td class="text-center">
                            <small class="text-muted">{VIEW.addtime}</small>
                        </td>
                        <td class="text-center">
                            <small class="text-muted">{VIEW.edittime}</small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{VIEW.link_edit}" class="btn btn-outline-primary" title="{LANG.edit}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{VIEW.link_delete}" class="btn btn-outline-danger"
                                   onclick="return confirm(nv_is_del_confirm[0]);" title="{LANG.delete}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>
    </div>
</form>

<div class="d-flex gap-2 mt-3">
    <div class="input-group" style="max-width: 300px;">
        <select class="form-select" id="action_bottom_2">
            <!-- BEGIN: action_bottom -->
            <option value="{ACTION.key}">{ACTION.value}</option>
            <!-- END: action_bottom -->
        </select>
        <button class="btn btn-outline-primary"
                onclick="nv_list_action( $('#action_bottom_2').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
            <i class="fas fa-play me-1"></i>{LANG.perform}
        </button>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced label click functionality
    $('.label-click').on('click', function() {
        window.location.href = $(this).find('a').attr('href');
    });

    // Enhanced bank question change function
    function change_bank_question(event) {
        var $typeid = $('#typeid');
        var value = event.target.value;

        // Show loading state
        $typeid.html('<div class="col-md-2"><div class="text-center"><div class="spinner-border spinner-border-sm" role="status"></div></div></div>');

        // Load new content
        $typeid.load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=search_questions&get_bank_html=1&typeid=' + value, function() {
            // Apply Bootstrap 5 classes to loaded content
            $typeid.find('select').addClass('form-select').removeClass('form-control');
            $typeid.find('.form-group').removeClass('form-group').addClass('mb-3');
        });
    }

    // Enhanced search form
    $('form').on('submit', function() {
        var $btn = $(this).find('button[type="submit"]');
        var originalHtml = $btn.html();

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang tìm kiếm...');

        // Restore after 3 seconds (fallback)
        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
        }, 3000);
    });

    // Enhanced table interactions
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Enhanced checkbox interactions
    $('.form-check-input').on('change', function() {
        var $row = $(this).closest('tr');
        if ($(this).is(':checked')) {
            $row.addClass('table-warning');
        } else {
            $row.removeClass('table-warning');
        }
    });

    // Enhanced search input
    $('input[name="q"]').on('input', function() {
        var value = $(this).val();
        if (value.length > 0) {
            $(this).addClass('border-success');
        } else {
            $(this).removeClass('border-success');
        }
    });

    // Enhanced select interactions
    $('.form-select').on('change', function() {
        var value = $(this).val();
        if (value != '0' && value != '') {
            $(this).addClass('border-success');
            setTimeout(function() {
                $('.form-select').removeClass('border-success');
            }, 1500);
        }
    });

    // Enhanced button hover effects
    $('.btn').on('mouseenter', function() {
        $(this).addClass('shadow-sm');
    }).on('mouseleave', function() {
        $(this).removeClass('shadow-sm');
    });

    // Initialize Bootstrap tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Make function globally available
    window.change_bank_question = change_bank_question;
});
//]]>
</script>
<!-- END: main -->