<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>Danh sách nguồn
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
                        <i class="fas fa-link me-1"></i>{LANG.source_link}
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
                        <select class="form-select form-select-sm" id="id_weight_{VIEW.sourceid}"
                                onchange="nv_change_weight('{VIEW.sourceid}');">
                            <!-- BEGIN: weight_loop -->
                            <option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
                            <!-- END: weight_loop -->
                        </select>
                    </td>
                    <td>
                        <span class="fw-bold text-primary">{VIEW.title}</span>
                    </td>
                    <td>
                        <a href="{VIEW.link}" target="_blank" class="text-decoration-none">
                            <i class="fas fa-external-link-alt me-1"></i>{VIEW.link}
                        </a>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{VIEW.url_edit}" class="btn btn-outline-primary" title="{GLANG.edit}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{VIEW.url_delete}" class="btn btn-outline-danger"
                               onclick="return confirm(nv_is_del_confirm[0]);" title="{GLANG.delete}">
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
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i>Thêm/Sửa nguồn
        </h5>
    </div>
    <div class="card-body">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}"
              method="post" id="frm-submit" enctype="multipart/form-data">
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
            <input type="hidden" name="sourceid" value="{ROW.sourceid}" />
            <input name="savecat" type="hidden" value="1" />
            <input type="hidden" name="id" value="{ROW.id}" />
            <input type="hidden" name="redirect" value="{ROW.redirect}" />

            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-tag me-1"></i>{LANG.title} <span class="text-danger">*</span>
                </label>
                <input class="form-control required" name="title" type="text" value="{ROW.title}"
                       maxlength="250" id="title" required placeholder="Nhập tên nguồn..." />
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-link me-1"></i>{LANG.source_link}
                </label>
                <input class="form-control" name="link" type="url" value="{ROW.link}"
                       maxlength="255" placeholder="https://example.com" />
                <div class="form-text">Nhập URL đầy đủ bao gồm http:// hoặc https://</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="fas fa-image me-1"></i>{LANG.source_logo}
                </label>
                <div class="input-group">
                    <input class="form-control" type="text" name="logo" value="{ROW.logo}"
                           id="logo" placeholder="Chọn logo cho nguồn..." />
                    <button class="btn btn-outline-secondary selectfile" type="button">
                        <i class="fas fa-folder-open me-1"></i>Chọn file
                    </button>
                </div>
                <div class="form-text">Chọn hình ảnh logo cho nguồn (định dạng: JPG, PNG, GIF)</div>
            </div>

            <div class="text-center">
                <button class="btn btn-primary btn-lg px-4" name="submit1" type="submit">
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

        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sources&nocache=' + new Date().getTime(),
               'ajax_action=1&id=' + id + '&new_vid=' + new_vid,
               function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(nv_is_change_act_confirm[2]);
            } else {
                showAlert('Cập nhật thứ tự thành công!', 'success');
                setTimeout(function() {
                    window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sources';
                }, 1000);
            }
        }).always(function() {
            // Remove loading state
            $select.prop('disabled', false);
            $('#loading_' + id).remove();
        });
    }

    // Enhanced file selection
    $(".selectfile").on('click', function() {
        var area = "logo";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var currentpath = "{CURENTPATH}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    // Enhanced form submission
    $('#frm-submit').on('submit', function(e) {
        e.preventDefault();

        var $btn = $(this).find('button[type="submit"]');
        var originalHtml = $btn.html();

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sources&nocache=' + new Date().getTime(),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(json) {
                if (json.error) {
                    showAlert(json.msg, 'danger');
                    $('#' + json.input).focus().addClass('is-invalid');
                    return false;
                } else {
                    showAlert('Lưu thành công!', 'success');
                    setTimeout(function() {
                        window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sources';
                    }, 1000);
                }
            },
            error: function() {
                showAlert('Có lỗi xảy ra khi lưu dữ liệu!', 'danger');
            },
            complete: function() {
                // Restore button
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
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

    // Enhanced form validation
    $('input[required]').on('blur', function() {
        var value = $(this).val().trim();
        if (value === '') {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });

    $('input[type="url"]').on('blur', function() {
        var value = $(this).val().trim();
        var urlPattern = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;

        if (value !== '' && !urlPattern.test(value)) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
            if (value !== '') {
                $(this).addClass('is-valid');
            }
        }
    });

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

    // Make function globally available
    window.nv_change_weight = nv_change_weight;
});
//]]>
</script>
<!-- END: main -->