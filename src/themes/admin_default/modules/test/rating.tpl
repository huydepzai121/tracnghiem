<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-star me-2"></i>Quản lý xếp loại
        </h5>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 120px;">
                        <i class="fas fa-weight me-1"></i>{LANG.weight}
                    </th>
                    <th>
                        <i class="fas fa-tag me-1"></i>{LANG.title}
                    </th>
                    <th style="width: 150px;">
                        <i class="fas fa-percentage me-1"></i>{LANG.rating_condition}
                    </th>
                    <th>
                        <i class="fas fa-sticky-note me-1"></i>{LANG.note}
                    </th>
                    <th style="width: 100px;" class="text-center">
                        <i class="fas fa-toggle-on me-1"></i>{LANG.active}
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
                    <td>
                        <select class="form-select form-select-sm" id="id_weight_{VIEW.id}"
                                onchange="nv_change_weight('{VIEW.id}');">
                            <!-- BEGIN: weight_loop -->
                            <option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
                            <!-- END: weight_loop -->
                        </select>
                    </td>
                    <td>
                        <span class="fw-bold text-primary">{VIEW.title}</span>
                    </td>
                    <td>
                        <span class="badge bg-info">{VIEW.operator} {VIEW.percent}%</span>
                    </td>
                    <td>
                        <small class="text-muted">{VIEW.note}</small>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" name="status"
                                   id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK}
                                   onclick="nv_change_status({VIEW.id});" />
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{VIEW.link_edit}#edit" class="btn btn-outline-primary" title="{LANG.edit}">
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
<!-- END: view -->
<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Lỗi:</strong> {ERROR}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i>Thêm/Sửa xếp loại
        </h5>
    </div>
    <div class="card-body">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <input type="hidden" name="id" value="{ROW.id}" />

            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-cog me-1"></i>{LANG.config}
                </label>
                <div class="row g-2">
                    <div class="col-md-6">
                        <select class="form-select" name="operator">
                            <!-- BEGIN: operator -->
                            <option value="{OPERATOR.index}"{OPERATOR.selected}>{OPERATOR.value}</option>
                            <!-- END: operator -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="number" class="form-control" value="{ROW.percent}"
                                   name="percent" min="0" max="100" />
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-tag me-1"></i>{LANG.title}
                </label>
                <input class="form-control" type="text" name="title" value="{ROW.title}"
                       required placeholder="Nhập tên xếp loại..." />
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-palette me-1"></i>{LANG.color}
                </label>
                <div class="d-flex align-items-center gap-2">
                    <input class="form-control" type="color" name="color" value="{ROW.color}"
                           style="width: 60px; height: 40px;" />
                    <small class="text-muted">Chọn màu hiển thị cho xếp loại này</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-sticky-note me-1"></i>{LANG.note}
                </label>
                <textarea class="form-control" name="note" rows="4"
                          placeholder="Nhập ghi chú cho xếp loại...">{ROW.note}</textarea>
            </div>

            <div class="text-center">
                <button class="btn btn-primary btn-lg px-4" name="submit" type="submit">
                    <i class="fas fa-save me-2"></i>{LANG.save}
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced weight change function
    function nv_change_weight(id) {
        var $select = $('#id_weight_' + id);
        var new_vid = $select.val();

        // Show loading state
        $select.prop('disabled', true);
        $select.after('<div class="spinner-border spinner-border-sm ms-2" role="status" id="loading_' + id + '"></div>');

        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=rating&nocache=' + new Date().getTime(),
               'ajax_action=1&id=' + id + '&new_vid=' + new_vid,
               function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(nv_is_change_act_confirm[2]);
            } else {
                showAlert('Cập nhật thứ tự thành công!', 'success');
                setTimeout(function() {
                    window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=rating';
                }, 1000);
            }
        }).always(function() {
            // Remove loading state
            $select.prop('disabled', false);
            $('#loading_' + id).remove();
        });
    }

    // Enhanced status change function
    function nv_change_status(id) {
        if (confirm(nv_is_change_act_confirm[0])) {
            var $switch = $('#change_status_' + id);

            // Show loading state
            $switch.prop('disabled', true);
            $switch.after('<div class="spinner-border spinner-border-sm ms-2" role="status" id="status_loading_' + id + '"></div>');

            window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=rating&change_status&id=' + id;
        } else {
            // Revert checkbox state
            var $checkbox = $('#change_status_' + id);
            $checkbox.prop('checked', !$checkbox.prop('checked'));
        }
        return false;
    }

    // Enhanced form submission
    $('form').on('submit', function() {
        var $btn = $(this).find('button[type="submit"]');
        var originalHtml = $btn.html();

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

        // Restore after 5 seconds (fallback)
        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
        }, 5000);
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

    // Enhanced form validation
    $('input[type="number"]').on('input', function() {
        var value = parseInt($(this).val());
        var min = parseInt($(this).attr('min')) || 0;
        var max = parseInt($(this).attr('max')) || 100;

        if (value < min || value > max) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Color picker enhancement
    $('input[type="color"]').on('change', function() {
        var color = $(this).val();
        $(this).css('border-color', color);

        // Visual feedback
        $(this).addClass('border-3');
        setTimeout(function() {
            $('input[type="color"]').removeClass('border-3');
        }, 1000);
    });

    // Make functions globally available
    window.nv_change_weight = nv_change_weight;
    window.nv_change_status = nv_change_status;
});
//]]>
</script>
<!-- END: main -->