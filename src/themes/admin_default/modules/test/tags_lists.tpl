<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-tags me-2"></i>Quản lý thẻ tag
            </h5>
        </div>
        <div class="table-responsive">
            <form action="{NV_BASE_ADMINURL}index.php" method="post">
                <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
                <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;" class="text-center">
                                <input name="check_all[]" type="checkbox" value="yes" class="form-check-input"
                                       onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />
                            </th>
                            <th>
                                <i class="fas fa-tag me-1"></i>{LANG.alias}
                            </th>
                            <th>
                                <i class="fas fa-key me-1"></i>{LANG.keywords}
                            </th>
                            <th style="width: 120px;" class="text-center">
                                <i class="fas fa-link me-1"></i>{LANG.numlinks}
                            </th>
                            <th style="width: 150px;" class="text-center">
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
                                       value="{ROW.tid}" name="idcheck[]" />
                            </td>
                            <td>
                                <a href="{ROW.link}" class="text-decoration-none fw-bold text-primary">
                                    <i class="fas fa-tag me-1"></i>{ROW.alias}
                                </a>
                            </td>
                            <td>
                                <span class="text-muted">{ROW.keywords}</span>
                                <!-- BEGIN: incomplete -->
                                <i class="fas fa-exclamation-triangle text-danger ms-2 tags-tip"
                                   data-bs-toggle="tooltip" data-bs-placement="top"
                                   title="{LANG.tags_no_description}"></i>
                                <!-- END: incomplete -->
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{ROW.numnews}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{ROW.url_edit}" class="btn btn-outline-primary" title="{GLANG.edit}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" onclick="nv_del_tags({ROW.tid})"
                                            title="{GLANG.delete}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- END: loop -->
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-danger btn-sm" name="submit_dell" type="button"
                                        onclick="nv_del_check_tags(this.form, '{NV_CHECK_SESSION}', '{LANG.error_empty_data}')">
                                    <i class="fas fa-trash me-1"></i>{GLANG.delete}
                                </button>
                            </td>
                            <td colspan="3" class="text-muted">
                                <!-- BEGIN: other -->
                                <i class="fas fa-info-circle me-1"></i>{LANG.alias_search}
                                <!-- END: other -->
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Initialize Bootstrap 5 tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('.tags-tip'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

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

    // Enhanced delete function
    function nv_del_tags(tid) {
        if (confirm('Bạn có chắc chắn muốn xóa thẻ tag này?')) {
            window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=tags&del_tid=' + tid;
        }
    }

    // Enhanced bulk delete function
    function nv_del_check_tags(form, session, error_msg) {
        var checked = false;
        var checkboxes = form.querySelectorAll('input[name="idcheck[]"]:checked');

        if (checkboxes.length === 0) {
            alert(error_msg);
            return false;
        }

        if (confirm('Bạn có chắc chắn muốn xóa ' + checkboxes.length + ' thẻ tag đã chọn?')) {
            var $btn = $(form).find('button[name="submit_dell"]');
            var originalHtml = $btn.html();

            // Show loading state
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang xóa...');

            // Submit form
            form.submit();
        }
    }

    // Enhanced button hover effects
    $('.btn').on('mouseenter', function() {
        $(this).addClass('shadow-sm');
    }).on('mouseleave', function() {
        $(this).removeClass('shadow-sm');
    });

    // Add visual feedback for empty table
    if ($('.table tbody tr').length === 0) {
        $('.table tbody').append(
            '<tr><td colspan="5" class="text-center text-muted py-4">' +
            '<i class="fas fa-tags fa-2x mb-2"></i><br>' +
            'Chưa có thẻ tag nào' +
            '</td></tr>'
        );
    }

    // Make functions globally available
    window.nv_del_tags = nv_del_tags;
    window.nv_del_check_tags = nv_del_check_tags;
});
//]]>
</script>
<!-- END: main -->