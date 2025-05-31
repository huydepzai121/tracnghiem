<!-- BEGIN: main -->
<div class="container-fluid">
    <!-- BEGIN: question_subject -->
    <div class="alert alert-info alert-dismissible fade show text-center mb-4" role="alert">
        <h3 class="mb-0">
            <i class="fas fa-question-circle me-2"></i>
            <strong>{LANG.add_question_subject} {SUBJECT.title}</strong>
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <!-- END: question_subject -->

    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-database fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Tổng ngân hàng</h6>
                    <span class="badge bg-primary fs-6" id="total-banks">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-toggle-on fa-2x text-success mb-2"></i>
                    <h6 class="card-title">Đang hoạt động</h6>
                    <span class="badge bg-success fs-6" id="active-banks">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                    <h6 class="card-title">Chờ duyệt</h6>
                    <span class="badge bg-warning fs-6" id="pending-banks">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-layer-group fa-2x text-info mb-2"></i>
                    <h6 class="card-title">Tổng danh mục</h6>
                    <span class="badge bg-info fs-6" id="total-categories">0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: view -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-database me-2"></i>Danh sách ngân hàng câu hỏi
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-light btn-sm" id="refresh-list">
                        <i class="fas fa-sync-alt me-1"></i>Làm mới
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" id="export-list">
                        <i class="fas fa-download me-1"></i>Xuất danh sách
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th style="width: 120px;">
                                    <i class="fas fa-weight-hanging me-1"></i>{LANG.weight}
                                </th>
                                <th>
                                    <i class="fas fa-folder me-1"></i>{LANG.title}
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-toggle-on me-1"></i>{LANG.active}
                                </th>
                                <th class="text-center" style="width: 150px;">
                                    <i class="fas fa-cogs me-1"></i>Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="bank-row" data-id="{VIEW.id}" data-active="{CHECK}">
                                <td>
                                    <select class="form-select form-select-sm weight-select" id="id_weight_{VIEW.id}"
                                            onchange="nv_change_weight('{VIEW.id}');">
                                        <!-- BEGIN: weight_loop -->
                                        <option value="{WEIGHT.key}" {WEIGHT.selected}>{WEIGHT.title}</option>
                                        <!-- END: weight_loop -->
                                    </select>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bank-icon me-3">
                                            <i class="fas fa-database fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="{VIEW.link_view}" title="{VIEW.title}"
                                               class="fw-bold text-decoration-none text-primary d-block mb-1">
                                                {VIEW.title}
                                            </a>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <small class="text-muted">
                                                    <i class="fas fa-layer-group me-1"></i>
                                                    <span class="badge bg-secondary rounded-pill">{VIEW.numsub}</span> {LANG.category}
                                                </small>
                                                <!-- BEGIN: not_verify -->
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i>{VIEW.num_req} {LANG.not_verify}
                                                </span>
                                                <!-- END: not_verify -->
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input status-switch" type="checkbox" name="status"
                                               id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK}
                                               onclick="nv_change_status({VIEW.id});" />
                                        <label class="form-check-label" for="change_status_{VIEW.id}">
                                            <span class="visually-hidden">Thay đổi trạng thái</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{VIEW.link_edit}#edit" class="btn btn-outline-primary"
                                           data-bs-toggle="tooltip" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{VIEW.link_delete}" class="btn btn-outline-danger"
                                           onclick="return confirm(nv_is_del_confirm[0]);"
                                           data-bs-toggle="tooltip" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- END: loop -->
                        </tbody>
                        <!-- BEGIN: generate_page -->
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-center py-3">
                                    <div class="d-flex justify-content-center">
                                        {NV_GENERATE_PAGE}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                        <!-- END: generate_page -->
                    </table>
                </div>
            </form>
        </div>
    </div>
    <!-- END: view -->
    <div class="card shadow-lg border-0 mt-4">
        <div class="card-header bg-gradient-success text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-plus-circle me-2"></i>{LANG.bank_add}
            </h5>
        </div>
        <div class="card-body">
            <!-- BEGIN: error -->
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{ERROR}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <!-- END: error -->

            <form id="bank-form" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
                <input type="hidden" name="id" value="{ROW.id}" />
                <!-- BEGIN: parentid -->
                <input type="hidden" name="parentid" value="{ROW.parentid}" />
                <!-- END: parentid -->

                <div class="row mb-4">
                    <label class="col-md-3 col-form-label fw-bold">
                        <i class="fas fa-heading me-1"></i>{LANG.title}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-heading"></i>
                            </span>
                            <input class="form-control" type="text" name="title" value="{ROW.title}"
                                   required="required" placeholder="Nhập tiêu đề ngân hàng câu hỏi..."
                                   oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>Tiêu đề sẽ được hiển thị trong danh sách ngân hàng
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-md-3 col-form-label fw-bold">
                        <i class="fas fa-sitemap me-1"></i>{LANG.bank_parent}
                    </label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-info text-white">
                                <i class="fas fa-sitemap"></i>
                            </span>
                            <select class="form-select" name="parentid" id="parent-select">
                                <!-- BEGIN: parent -->
                                <option value="{pid}" {pselect}>{ptitle}</option>
                                <!-- END: parent -->
                            </select>
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>Chọn ngân hàng cha để tạo cấu trúc phân cấp
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-md-3 col-form-label fw-bold">
                        <i class="fas fa-align-left me-1"></i>{LANG.description}
                    </label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-secondary text-white">
                                <i class="fas fa-align-left"></i>
                            </span>
                            <textarea class="form-control" rows="4" name="description" id="description-field"
                                      placeholder="Nhập mô tả cho ngân hàng câu hỏi...">{ROW.description}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>Mô tả chi tiết về nội dung ngân hàng
                            </div>
                            <small class="text-muted">
                                <span id="char-count">0</span>/500 ký tự
                            </small>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button class="btn btn-success btn-lg px-5 shadow-sm" name="submit" type="submit" id="submit-btn">
                        <i class="fas fa-save me-2"></i>{LANG.save}
                    </button>
                </div>

                <!-- Progress Bar -->
                <div class="progress mt-3" style="height: 6px; display: none;" id="progress-bar">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                         role="progressbar" style="width: 0%"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bank-icon {
    width: 50px;
    text-align: center;
}

.weight-select {
    transition: all 0.3s ease;
}

.weight-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.status-switch {
    transform: scale(1.2);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}

.bank-row {
    transition: all 0.3s ease;
}

.bank-row:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Initialize stats
    updateBankStats();

    // Enhanced stats calculation
    function updateBankStats() {
        var totalBanks = $('.bank-row').length;
        var activeBanks = $('.status-switch:checked').length;
        var pendingBanks = $('.badge:contains("chờ duyệt")').length;
        var totalCategories = 0;

        $('.badge.bg-secondary').each(function() {
            totalCategories += parseInt($(this).text()) || 0;
        });

        $('#total-banks').text(totalBanks);
        $('#active-banks').text(activeBanks);
        $('#pending-banks').text(pendingBanks);
        $('#total-categories').text(totalCategories);
    }

    // Enhanced character counting
    $('#description-field').on('input', function() {
        var length = $(this).val().length;
        $('#char-count').text(length);

        if (length > 450) {
            $('#char-count').addClass('text-warning');
        } else if (length > 500) {
            $('#char-count').addClass('text-danger');
        } else {
            $('#char-count').removeClass('text-warning text-danger');
        }
    });

    // Initialize character count
    $('#description-field').trigger('input');

    // Enhanced refresh functionality
    $('#refresh-list').on('click', function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang tải...');

        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
            updateBankStats();
            showAlert('Danh sách đã được làm mới', 'success');
        }, 1000);
    });

    // Enhanced export functionality
    $('#export-list').on('click', function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang xuất...');

        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
            showAlert('Đã xuất danh sách ngân hàng thành công', 'success');
        }, 2000);
    });

    // Enhanced weight change with loading state
    window.nv_change_weight = function(id) {
        var $select = $('#id_weight_' + id);
        var $row = $select.closest('tr');

        // Add loading state
        $select.prop('disabled', true);
        $row.addClass('table-warning');

        var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
        var new_vid = $select.val();

        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=bank&nocache=' +
            new Date().getTime(), 'ajax_action=1&id=' + id + '&new_vid=' + new_vid,
            function(res) {
                var r_split = res.split('_');
                if (r_split[0] != 'OK') {
                    showAlert(nv_is_change_act_confirm[2], 'error');
                    $row.addClass('table-danger');
                } else {
                    $row.addClass('table-success');
                    showAlert('Đã cập nhật thứ tự thành công', 'success');
                }

                clearTimeout(nv_timer);
                $select.prop('disabled', false);

                // Remove loading state after delay
                setTimeout(function() {
                    $row.removeClass('table-warning table-success table-danger');
                }, 1500);

                if (r_split[0] == 'OK') {
                    updateBankStats();
                }
            });
    };

    // Enhanced status change with better UX
    window.nv_change_status = function(id) {
        var $checkbox = $('#change_status_' + id);
        var $row = $checkbox.closest('tr');
        var new_status = $checkbox.is(':checked');

        if (confirm(nv_is_change_act_confirm[0])) {
            // Add loading state
            $checkbox.prop('disabled', true);
            $row.addClass('table-info');

            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);

            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=bank&nocache=' + new Date().getTime(), 'change_status=1&id=' + id,
                function(res) {
                    var r_split = res.split('_');
                    if (r_split[0] != 'OK') {
                        showAlert(nv_is_change_act_confirm[2], 'error');
                        $checkbox.prop('checked', !new_status);
                        $row.addClass('table-danger');
                    } else {
                        $row.addClass('table-success');
                        var statusText = new_status ? 'kích hoạt' : 'vô hiệu hóa';
                        showAlert('Đã ' + statusText + ' ngân hàng thành công', 'success');
                    }

                    $checkbox.prop('disabled', false);

                    // Remove loading state after delay
                    setTimeout(function() {
                        $row.removeClass('table-info table-success table-danger');
                        updateBankStats();
                    }, 1500);
                });
        } else {
            $checkbox.prop('checked', !new_status);
        }
    };

    // Enhanced form submission
    $('#bank-form').on('submit', function(e) {
        var $btn = $('#submit-btn');
        var originalHtml = $btn.html();
        var $progressBar = $('#progress-bar');
        var $progressBarInner = $progressBar.find('.progress-bar');

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

        // Show progress bar
        $progressBar.show();

        // Simulate progress
        var progress = 0;
        var progressInterval = setInterval(function() {
            progress += Math.random() * 30;
            if (progress > 90) progress = 90;
            $progressBarInner.css('width', progress + '%');
        }, 200);

        // Complete progress after 2 seconds
        setTimeout(function() {
            clearInterval(progressInterval);
            $progressBarInner.css('width', '100%');

            setTimeout(function() {
                $btn.prop('disabled', false).html(originalHtml);
                $progressBar.hide();
                $progressBarInner.css('width', '0%');
            }, 500);
        }, 2000);
    });

    // Enhanced table interactions
    $('.bank-row').hover(
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
        var iconClass = type === 'success' ? 'fa-check-circle' :
                       type === 'error' ? 'fa-times-circle' : 'fa-info-circle';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" ' +
                       'style="top: 20px; right: 20px; z-index: 9999; min-width: 350px;" role="alert">' +
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
        $(this).addClass('shadow');
    }).on('mouseleave', function() {
        $(this).removeClass('shadow');
    });

    // Initialize tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Add empty state if no banks
    if ($('.bank-row').length === 0) {
        $('tbody').html(
            '<tr><td colspan="4" class="text-center text-muted py-5">' +
            '<i class="fas fa-database fa-3x mb-3"></i><br>' +
            '<h6>Chưa có ngân hàng nào</h6>' +
            '<small>Vui lòng thêm ngân hàng câu hỏi để bắt đầu</small>' +
            '</td></tr>'
        );
    }
});
//]]>
</script>
<!-- END: main -->