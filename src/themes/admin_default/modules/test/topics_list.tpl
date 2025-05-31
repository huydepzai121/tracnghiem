<!-- BEGIN: main -->
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>Danh sách chủ đề
        </h5>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 120px;" class="text-center">
                        <i class="fas fa-weight me-1"></i>{LANG.weight}
                    </th>
                    <th>
                        <i class="fas fa-tag me-1"></i>{LANG.title}
                    </th>
                    <th>
                        <i class="fas fa-align-left me-1"></i>{LANG.description}
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
                        <select class="form-select form-select-sm" id="id_weight_{ROW.topicid}"
                                onchange="nv_chang_topic('{ROW.topicid}','weight');">
                            <!-- BEGIN: weight -->
                            <option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
                            <!-- END: weight -->
                        </select>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <a href="{ROW.link}" class="text-decoration-none fw-bold text-primary mb-1">
                                <i class="fas fa-tag me-1"></i>{ROW.title}
                            </a>
                            <small class="text-muted">
                                <a href="{ROW.linksite}" class="text-decoration-none">
                                    <i class="fas fa-newspaper me-1"></i>
                                    <span class="badge bg-info">{ROW.numnews}</span> {LANG.topic_num_news}
                                </a>
                            </small>
                        </div>
                    </td>
                    <td>
                        <div class="text-muted" style="max-width: 300px;">
                            {ROW.description}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{ROW.url_edit}" class="btn btn-outline-primary" title="{GLANG.edit}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-outline-danger" onclick="nv_del_topic({ROW.topicid})"
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
    // Enhanced topic change function
    function nv_chang_topic(topicid, type) {
        var $select = $('#id_weight_' + topicid);
        var new_weight = $select.val();

        // Show loading state
        $select.prop('disabled', true);
        $select.after('<div class="spinner-border spinner-border-sm ms-2" role="status" id="loading_' + topicid + '"></div>');

        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=topics&nocache=' + new Date().getTime(),
               'ajax_action=1&topicid=' + topicid + '&new_weight=' + new_weight + '&type=' + type,
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
            $('#loading_' + topicid).remove();
        });
    }

    // Enhanced delete function
    function nv_del_topic(topicid) {
        if (confirm('Bạn có chắc chắn muốn xóa chủ đề này?')) {
            window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=topics&del_topicid=' + topicid;
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

    // Add visual feedback for empty table
    if ($('.table tbody tr').length === 0) {
        $('.table tbody').append(
            '<tr><td colspan="4" class="text-center text-muted py-4">' +
            '<i class="fas fa-tags fa-2x mb-2"></i><br>' +
            'Chưa có chủ đề nào' +
            '</td></tr>'
        );
    }

    // Make functions globally available
    window.nv_chang_topic = nv_chang_topic;
    window.nv_del_topic = nv_del_topic;
});
//]]>
</script>
<!-- END: main -->