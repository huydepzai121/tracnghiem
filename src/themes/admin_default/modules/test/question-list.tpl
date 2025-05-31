<!-- BEGIN: main -->
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
            <input type="hidden" name="typeid" value="{TYPEID}" />
            <input type="hidden" name="subjectid" value="{SUBJECT.id}" />

            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search me-1"></i>Từ khóa tìm kiếm
                    </label>
                    <input class="form-control" type="text" value="{SEARCH.q}" name="q"
                           maxlength="255" placeholder="{LANG.search_title}" />
                </div>
                <div class="col-md-5">
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
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-search me-1"></i>{LANG.search_submit}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- BEGIN: examinations_title -->
<div class="alert alert-danger" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{LANG.not_delete_question_for_examinations}:</strong> {examinations_title}
</div>
<!-- END: examinations_title -->

<!-- BEGIN: question_subject -->
<div class="text-center mb-4">
    <h2 class="text-primary">
        <i class="fas fa-plus-circle me-2"></i>
        <strong>{LANG.add_question_subject} {SUBJECT.title}</strong>
    </h2>
</div>
<!-- END: question_subject -->
<div class="d-flex flex-wrap gap-2 mb-3">
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

    <div class="btn-group" role="group">
        <a href="{URL_ADD}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i>{LANG.question_add}
        </a>
        <!-- BEGIN: msword -->
        <a href="{IMPORT_URL}" class="btn btn-info">
            <i class="fas fa-file-word me-1"></i>{LANG.importword}
        </a>
        <!-- END: msword -->
        <!-- BEGIN: msexcel -->
        <a href="{IMPORT_EXCEL}" class="btn btn-warning">
            <i class="fas fa-file-excel me-1"></i>{LANG.importexcel}
        </a>
        <!-- END: msexcel -->
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
                        <th style="width: 120px;">
                            <i class="fas fa-database me-1"></i>{LANG.bank_type}
                        </th>
                        <th style="width: 150px;">
                            <i class="fas fa-calendar-plus me-1"></i>{LANG.addtime}
                        </th>
                        <th style="width: 150px;">
                            <i class="fas fa-calendar-edit me-1"></i>{LANG.edittime1}
                        </th>
                        <th style="width: 100px;" class="text-center">
                            <i class="fas fa-chart-bar me-1"></i>{LANG.total_use}
                        </th>
                        <th style="width: 120px;" class="text-center">
                            <i class="fas fa-toggle-on me-1"></i>{LANG.text_post_status}
                        </th>
                        <th style="width: 200px;" class="text-center">
                            <i class="fas fa-cogs me-1"></i>Thao tác
                        </th>
                    </tr>
                </thead>
                <!-- BEGIN: generate_page -->
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="8">
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
                        <td>
                            <div class="fw-bold text-truncate" style="max-width: 300px;" title="{VIEW.title}">
                                {VIEW.title}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{VIEW.bank_type}</span>
                        </td>
                        <td>
                            <small class="text-muted">{VIEW.addtime}</small>
                        </td>
                        <td>
                            <small class="text-muted">{VIEW.edittime}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{VIEW.total_use}</span>
                        </td>
                        <td class="text-center" {class_text_danger}>
                            <span class="badge bg-success">{VIEW.status_title}</span>
                        </td>
                        <td class="text-center">
                            <!-- BEGIN: not_subject -->
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{VIEW.link_edit}" class="btn btn-outline-primary" title="{LANG.edit}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{VIEW.link_delete}" class="btn btn-outline-danger"
                                   onclick="return confirm(nv_is_del_confirm[0]);" title="{LANG.delete}">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <!-- BEGIN: site_child_1 -->
                                <a href="{VIEW.link_send_bank}" class="btn btn-outline-info" title="{LANG.send}">
                                    <i class="fas fa-paper-plane"></i>
                                </a>
                                <!-- END: site_child_1 -->
                                <!-- BEGIN: site_child_2 -->
                                <a href="{VIEW.link_cancel_bank}" class="btn btn-outline-warning" title="{LANG.cancel}">
                                    <i class="fas fa-eraser"></i>
                                </a>
                                <!-- END: site_child_2 -->
                                <!-- BEGIN: site_main -->
                                <a href="{VIEW.link_confirm}" class="btn btn-outline-success" title="{LANG.confirm}">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                                <!-- END: site_main -->
                            </div>
                            <!-- END: not_subject -->
                            <!-- BEGIN: had_subject -->
                            {VIEW.feature}
                            <!-- END: had_subject -->
                        </td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>
    </div>
</form>
<div class="d-flex flex-wrap gap-2 mt-3 justify-content-between align-items-center">
    <div class="input-group" style="max-width: 300px;">
        <select class="form-select" id="action_bottom">
            <!-- BEGIN: action_bottom -->
            <option value="{ACTION.key}">{ACTION.value}</option>
            <!-- END: action_bottom -->
        </select>
        <button class="btn btn-outline-primary"
                onclick="nv_list_action( $('#action_bottom').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
            <i class="fas fa-play me-1"></i>{LANG.perform}
        </button>
    </div>

    <!-- BEGIN: come_back -->
    <a class="btn btn-success" href="{come_back}" target="_self">
        <i class="fas fa-arrow-left me-1"></i>{LANG.come_back}
    </a>
    <!-- END: come_back -->
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced status change function
    function nv_change_status(id) {
        var new_status = $('#change_status_' + id).is(':checked') ? true : false;
        if (confirm(nv_is_change_act_confirm[0])) {
            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);

            // Show loading state
            var $statusElement = $('#change_status_' + id).closest('td');
            $statusElement.append('<div class="spinner-border spinner-border-sm ms-2" role="status"></div>');

            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question&nocache=' + new Date().getTime(),
                   'change_status=1&id=' + id,
                   function(res) {
                var r_split = res.split('_');
                if (r_split[0] != 'OK') {
                    alert(nv_is_change_act_confirm[2]);
                }
                // Remove loading spinner
                $statusElement.find('.spinner-border').remove();
            });
        } else {
            $('#change_status_' + id).prop('checked', new_status ? false : true);
        }
        return;
    }

    // Enhanced label click functionality
    $('.label-click').on('click', function() {
        window.location.href = $(this).find('a').attr('href');
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

    // Initialize Bootstrap tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
//]]>
</script>
<!-- END: main -->