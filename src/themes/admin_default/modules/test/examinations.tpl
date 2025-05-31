<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

{PACKAGE_NOTIICE}

<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-search me-2"></i>Tìm kiếm kỳ thi
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

                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <input name="begintime" id="begintime" title="{LANG.begintime}" class="form-control"
                               value="{SEARCH.begintime}" maxlength="10" type="text" autocomplete="off"
                               placeholder="{LANG.begintime}" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-calendar-minus"></i>
                        </span>
                        <input name="endtime" id="endtime" title="{LANG.endtime}" class="form-control"
                               value="{SEARCH.endtime}" maxlength="10" type="text" autocomplete="off"
                               placeholder="{LANG.endtime}" />
                    </div>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-search me-1"></i>{LANG.search_submit}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{URL_ADD}" class="btn btn-success">
        <i class="fas fa-plus me-1"></i>{LANG.examinations_add}
    </a>

    <!-- BEGIN: deldata -->
    <button type="button" class="btn btn-danger" id="exams_delete">
        <i class="fas fa-trash me-1"></i>{LANG.exams_delete}
    </button>
    <!-- END: deldata -->
</div>

<!-- BEGIN: msg -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{msg}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: msg -->
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-graduation-cap me-2"></i>Danh sách kỳ thi
        </h5>
    </div>
    <div class="card-body p-0">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead >
                        <tr>
                            <th style="width: 60px;" class="text-center">
                                <div class="form-check">
                                    <input class="form-check-input" name="check_all[]" type="checkbox" value="yes"
                                           id="checkAll" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th>
                                <i class="fas fa-graduation-cap me-1"></i>{LANG.examinations_title}
                            </th>
                            <th style="width: 150px;" class="text-center">
                                <i class="fas fa-calendar-plus me-1"></i>{LANG.begintime}
                            </th>
                            <th style="width: 150px;" class="text-center">
                                <i class="fas fa-calendar-minus me-1"></i>{LANG.endtime}
                            </th>
                            <th style="width: 100px;" class="text-center">
                                <i class="fas fa-toggle-on me-1"></i>{LANG.active}
                            </th>
                            <th style="width: 200px;" class="text-center">
                                <i class="fas fa-cogs me-1"></i>Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: loop -->
                        <tr class="exam-row" data-id="{VIEW.id}">
                            <td class="text-center">
                                <div class="form-check">
                                    <input class="form-check-input post" type="checkbox" value="{VIEW.id}" name="idcheck[]"
                                           id="check_{VIEW.id}" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" />
                                    <label class="form-check-label" for="check_{VIEW.id}"></label>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="{VIEW.link}" target="_blank" class="fw-bold text-decoration-none mb-1">
                                        <i class="fas fa-external-link-alt me-1"></i>{VIEW.title}
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">
                                    <i class="fas fa-calendar me-1"></i>{VIEW.begintime}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-calendar me-1"></i>{VIEW.endtime}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" name="status" id="change_status_{VIEW.id}"
                                           value="{VIEW.id}" {CHECK} onclick="nv_change_status({VIEW.id});" />
                                    <label class="form-check-label" for="change_status_{VIEW.id}"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    {VIEW.feature}
                                </div>
                            </td>
                        </tr>
                        <!-- END: loop -->
                    </tbody>
                    <!-- BEGIN: generate_page -->
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-center bg-light py-3">
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
<!-- BEGIN: action_bottom -->
<div class="d-flex gap-2 mt-3">
    <div class="input-group" style="width: auto;">
        <select class="form-select" id="action-bottom">
            <!-- BEGIN: loop -->
            <option value="{ACTION.key}">{ACTION.value}</option>
            <!-- END: loop -->
        </select>
        <button class="btn btn-outline-primary" onclick="nv_list_action( $('#action-bottom').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
            <i class="fas fa-play me-1"></i>{LANG.perform}
        </button>
    </div>
</div>
<!-- END: action_bottom -->

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced datepicker with better styling
    $("#begintime, #endtime").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: "focus",
        yearRange: "-90:+10",
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.addClass('shadow-lg border-0');
            }, 0);
        }
    });

    // Enhanced checkbox functionality with visual feedback
    $('input[name="idcheck[]"]').on('change', function() {
        var $row = $(this).closest('.exam-row');
        if ($(this).is(':checked')) {
            $row.addClass('table-active');
        } else {
            $row.removeClass('table-active');
        }

        // Update check all state
        var totalCheckboxes = $('input[name="idcheck[]"]').length;
        var checkedCheckboxes = $('input[name="idcheck[]"]:checked').length;
        $('input[name="check_all[]"]').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    // Enhanced check all functionality
    $('input[name="check_all[]"]').on('change', function() {
        var isChecked = $(this).is(':checked');
        $('input[name="idcheck[]"]').prop('checked', isChecked);

        if (isChecked) {
            $('.exam-row').addClass('table-active');
        } else {
            $('.exam-row').removeClass('table-active');
        }
    });

    // Enhanced status change with better UX
    window.nv_change_status = function(id) {
        var $checkbox = $('#change_status_' + id);
        var $row = $checkbox.closest('.exam-row');
        var new_status = $checkbox.is(':checked');

        if (confirm(nv_is_change_act_confirm[0])) {
            // Add loading state
            $checkbox.prop('disabled', true);
            $row.addClass('table-info');

            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);

            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=examinations&nocache=' + new Date().getTime(),
                   'change_status=1&id=' + id,
                   function(res) {
                       var r_split = res.split('_');
                       if (r_split[0] != 'OK') {
                           alert(nv_is_change_act_confirm[2]);
                           $checkbox.prop('checked', !new_status);
                           $row.addClass('table-danger');
                       } else {
                           $row.addClass('table-success');
                       }

                       $checkbox.prop('disabled', false);

                       // Remove loading state after delay
                       setTimeout(function() {
                           $row.removeClass('table-info table-success table-danger');
                       }, 1500);
                   });
        } else {
            $checkbox.prop('checked', !new_status);
        }
    };

    // Date validation for search form
    $('#begintime, #endtime').on('change', function() {
        var beginDate = $('#begintime').datepicker('getDate');
        var endDate = $('#endtime').datepicker('getDate');

        if (beginDate && endDate && beginDate >= endDate) {
            $(this).addClass('is-invalid');
        } else {
            $('#begintime, #endtime').removeClass('is-invalid');
        }
    });

    // Initialize tooltips if available
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