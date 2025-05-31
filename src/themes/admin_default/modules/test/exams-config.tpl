<!-- BEGIN: main -->
{PACKAGE_NOTIICE}

<!-- BEGIN: guider -->
<div class="card border-info mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <div class="alert alert-info mb-0" <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-info-circle me-2"></i>
                    {LANG.guider_exams_config}
                </div>
            </div>
            <div class="flex-shrink-0">
                <button class="btn btn-outline-info btn-sm show-msg" data-func="exams-config"
                        <!-- BEGIN: msg_show -->style="display: none" <!-- END: msg_show -->>
                    <i class="fas fa-question-circle me-1"></i>{LANG.msg}
                </button>
                <button class="btn btn-outline-secondary btn-sm close-msg" data-func="exams-config"
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
            <i class="fas fa-search me-2"></i>Tìm kiếm cấu hình đề thi
        </h5>
    </div>
    <div class="card-body">
        <form action="{NV_BASE_ADMINURL}index.php" method="get">
            <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input class="form-control" type="text" value="{SEARCH.q}" name="q"
                               maxlength="255" placeholder="{LANG.search_title}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="active" class="form-select">
                        <option value="-1">--- {LANG.active_select} ---</option>
                        <!-- BEGIN: status -->
                        <option value="{STATUS.index}"{STATUS.selected}>{STATUS.value}</option>
                        <!-- END: status -->
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100 loading" type="submit">
                        <i class="fas fa-search me-1"></i>{LANG.search_submit}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-cogs me-2"></i>Thao tác và quản lý
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <select class="form-select" id="action_top">
                    <!-- BEGIN: action_top -->
                    <option value="{ACTION.key}">{ACTION.value}</option>
                    <!-- END: action_top -->
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-warning w-100" onclick="nv_list_action( $('#action_top').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
                    <i class="fas fa-play me-1"></i>{LANG.perform}
                </button>
            </div>
            <div class="col-md-3">
                <a class="btn btn-primary w-100 loading" href="{URL_ADD_PRIVATE}">
                    <i class="fas fa-plus me-1"></i>{LANG.exams_config_add_private}
                </a>
            </div>
            <!-- BEGIN: allow_exams_config_content_bank -->
            <div class="col-md-4">
                <a class="btn btn-success w-100 loading" href="{URL_ADD_COMMON}">
                    <i class="fas fa-database me-1"></i>{LANG.exams_config_add_commont}
                </a>
            </div>
            <!-- END: allow_exams_config_content_bank -->
        </div>
    </div>
</div>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>Danh sách cấu hình đề thi
        </h5>
    </div>
    <div class="card-body p-0">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead >
                        <tr>
                            <th style="width: 50px;" class="text-center">
                                <input name="check_all[]" type="checkbox" value="yes"
                                       class="form-check-input"
                                       onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);">
                            </th>
                            <th>
                                <i class="fas fa-heading me-1"></i>{LANG.title}
                            </th>
                            <th style="width: 100px;" class="text-center">
                                <i class="fas fa-database me-1"></i>{LANG.bank}
                            </th>
                            <th style="width: 170px;" class="text-center">
                                <i class="fas fa-clock me-1"></i>{LANG.timer} ({LANG.min})
                            </th>
                            <th style="width: 150px;" class="text-center">
                                <i class="fas fa-question-circle me-1"></i>{LANG.num_question}
                            </th>
                            <th style="width: 100px;" class="text-center">
                                <i class="fas fa-toggle-on me-1"></i>{LANG.active}
                            </th>
                            <th style="width: 120px;" class="text-center">
                                <i class="fas fa-cogs me-1"></i>Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: loop -->
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input"
                                       onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);"
                                       value="{VIEW.id}" name="idcheck[]">
                            </td>
                            <td>
                                <div class="fw-semibold text-primary">{VIEW.title}</div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox" {BANK_CHECK} disabled />
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info fs-6">{VIEW.timer}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success fs-6">{VIEW.num_question}</span>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox"
                                           id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK}
                                           onclick="nv_change_status({VIEW.id});" />
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{VIEW.link_edit}" class="btn btn-outline-primary"
                                       title="{LANG.edit}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{VIEW.link_delete}" class="btn btn-outline-danger"
                                       onclick="return confirm(nv_is_del_confirm[0]);"
                                       title="{LANG.delete}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- END: loop -->
                    </tbody>
                    <!-- BEGIN: generate_page -->
                    <tfoot>
                        <tr>
                            <td colspan="7" class="text-center bg-light py-3">
                                {NV_GENERATE_PAGE}
                            </td>
                        </tr>
                    </tfoot>
                    <!-- END: generate_page -->
                </table>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <select class="form-select" id="action_bottom">
                    <!-- BEGIN: action_bottom -->
                    <option value="{ACTION.key}">{ACTION.value}</option>
                    <!-- END: action_bottom -->
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-warning w-100" onclick="nv_list_action( $('#action_bottom').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
                    <i class="fas fa-play me-1"></i>{LANG.perform}
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced status change function
    window.nv_change_status = function(id) {
        var $switch = $('#change_status_' + id);
        var new_status = $switch.is(':checked');

        if (confirm(nv_is_change_act_confirm[0])) {
            // Show loading state
            $switch.prop('disabled', true);

            // Add loading spinner
            var $td = $switch.closest('td');
            var originalHtml = $td.html();
            $td.append('<div class="spinner-border spinner-border-sm ms-2" role="status"></div>');

            $.post(
                script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-config&nocache=' + new Date().getTime(),
                'change_status=1&id=' + id,
                function(res) {
                    var r_split = res.split('_');
                    if (r_split[0] != 'OK') {
                        alert(nv_is_change_act_confirm[2]);
                        // Revert switch state
                        $switch.prop('checked', !new_status);
                    }

                    // Remove loading state
                    $switch.prop('disabled', false);
                    $td.find('.spinner-border').remove();
                }
            ).fail(function() {
                alert('Có lỗi xảy ra, vui lòng thử lại!');
                $switch.prop('checked', !new_status);
                $switch.prop('disabled', false);
                $td.find('.spinner-border').remove();
            });
        } else {
            // Revert switch state if user cancels
            $switch.prop('checked', !new_status);
        }
    };

    // Enhanced tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Enhanced loading states for buttons
    $('.loading').on('click', function() {
        var $btn = $(this);
        if (!$btn.hasClass('disabled')) {
            var originalHtml = $btn.html();
            $btn.addClass('disabled')
                .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang tải...');

            // Restore after 3 seconds (fallback)
            setTimeout(function() {
                $btn.removeClass('disabled').html(originalHtml);
            }, 3000);
        }
    });

    // Guide message functionality
    $('.show-msg').on('click', function() {
        var func = $(this).data('func');
        $('.alert-msg').show();
        $(this).hide();
        $('.close-msg[data-func="' + func + '"]').show();
    });

    $('.close-msg').on('click', function() {
        var func = $(this).data('func');
        $('.alert-msg').hide();
        $(this).hide();
        $('.show-msg[data-func="' + func + '"]').show();
    });
});
//]]>
</script>
<!-- END: main -->