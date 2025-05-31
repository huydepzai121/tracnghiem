<!-- BEGIN: main -->
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 120px;" class="text-center">
                        <i class="fas fa-weight me-1"></i>{LANG.weight}
                    </th>
                    <th>
                        <i class="fas fa-tag me-1"></i>{LANG.name}
                    </th>
                    <th>
                        <i class="fas fa-link me-1"></i>{LANG.link}
                    </th>
                    <th style="width: 150px;" class="text-center">
                        <i class="fas fa-cogs me-1"></i>Thao tác
                    </th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td colspan="4" class="text-center">
                        <div class="d-flex justify-content-center">
                            {GENERATE_PAGE}
                        </div>
                    </td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">
                        <select class="form-select form-select-sm" id="id_weight_{ROW.sourceid}"
                                onchange="nv_chang_sources('{ROW.sourceid}','weight');">
                            <!-- BEGIN: weight -->
                            <option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
                            <!-- END: weight -->
                        </select>
                    </td>
                    <td>
                        <span class="fw-bold text-primary">{ROW.title}</span>
                    </td>
                    <td>
                        <a href="{ROW.link}" target="_blank" class="text-decoration-none">
                            <i class="fas fa-external-link-alt me-1"></i>{ROW.link}
                        </a>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{ROW.url_edit}" class="btn btn-outline-primary" title="{GLANG.edit}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-outline-danger" onclick="nv_del_source({ROW.sourceid})"
                                    title="{GLANG.delete}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced weight change function
    function nv_chang_sources(sourceid, type) {
        var $select = $('#id_weight_' + sourceid);
        var new_weight = $select.val();

        // Show loading state
        $select.prop('disabled', true);
        $select.after('<div class="spinner-border spinner-border-sm ms-2" role="status" id="loading_' + sourceid + '"></div>');

        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sources&nocache=' + new Date().getTime(),
               'ajax_action=1&sourceid=' + sourceid + '&new_weight=' + new_weight + '&type=' + type,
               function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert('Có lỗi xảy ra khi cập nhật!');
            } else {
                showAlert('Cập nhật thứ tự thành công!', 'success');
            }
        }).always(function() {
            // Remove loading state
            $select.prop('disabled', false);
            $('#loading_' + sourceid).remove();
        });
    }

    // Enhanced delete function
    function nv_del_source(sourceid) {
        if (confirm('Bạn có chắc chắn muốn xóa nguồn này?')) {
            window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sources&del_sourceid=' + sourceid;
        }
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

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" ' +
                       'style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">' +
                       '<i class="fas ' + iconClass + ' me-2"></i>' + message +
                       '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                       '</div>';

        $('body').append(alertHtml);

        // Auto-hide after 3 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 3000);
    }

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

    // Make functions globally available
    window.nv_chang_sources = nv_chang_sources;
    window.nv_del_source = nv_del_source;
});
//]]>
</script>
<!-- END: main -->