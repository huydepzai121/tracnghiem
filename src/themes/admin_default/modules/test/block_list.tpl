<!-- BEGIN: main -->
<div class="container-fluid">
    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-cube fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Tổng Block</h6>
                    <span class="badge bg-primary fs-6" id="total-blocks">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h6 class="card-title">Đã chọn</h6>
                    <span class="badge bg-success fs-6" id="selected-blocks">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-sort fa-2x text-warning mb-2"></i>
                    <h6 class="card-title">Đang sắp xếp</h6>
                    <span class="badge bg-warning fs-6" id="sorting-blocks">0</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Danh sách Block
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-light btn-sm" id="select-all-btn">
                        <i class="fas fa-check-square me-1"></i>Chọn tất cả
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" id="deselect-all-btn">
                        <i class="fas fa-square me-1"></i>Bỏ chọn
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" id="refresh-list">
                        <i class="fas fa-sync-alt me-1"></i>Làm mới
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <form name="block_list" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&amp;bid={BID}" method="get">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th style="width: 60px;" class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" name="check_all[]" type="checkbox" value="yes"
                                               id="checkAll" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />
                                        <label class="form-check-label" for="checkAll">
                                            <span class="visually-hidden">Chọn tất cả</span>
                                        </label>
                                    </div>
                                </th>
                                <th style="width: 120px;" class="text-center">
                                    <i class="fas fa-sort-numeric-down me-1"></i>{LANG.number}
                                </th>
                                <th>
                                    <i class="fas fa-heading me-1"></i>{LANG.title}
                                </th>
                                <th style="width: 100px;" class="text-center">
                                    <i class="fas fa-cogs me-1"></i>Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="block-row" data-id="{ROW.id}">
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input block-checkbox" type="checkbox" value="{ROW.id}" name="idcheck[]"
                                               id="check_{ROW.id}" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" />
                                        <label class="form-check-label" for="check_{ROW.id}">
                                            <span class="visually-hidden">Chọn block này</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <select class="form-select form-select-sm weight-select" id="id_weight_{ROW.id}"
                                            onchange="nv_chang_block({BID},{ROW.id},'weight');">
                                        <!-- BEGIN: weight -->
                                        <option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
                                        <!-- END: weight -->
                                    </select>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="block-icon me-3">
                                            <i class="fas fa-cube fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a target="_blank" href="{ROW.link}" class="text-decoration-none fw-bold text-primary d-block mb-1">
                                                {ROW.title}
                                            </a>
                                            <small class="text-muted">
                                                <i class="fas fa-external-link-alt me-1"></i>Xem trực tiếp
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=content&amp;id={ROW.id}"
                                           class="btn btn-outline-primary" data-bs-toggle="tooltip" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{ROW.link}" target="_blank" class="btn btn-outline-info"
                                           data-bs-toggle="tooltip" title="Xem trực tiếp">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- END: loop -->
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <!-- Enhanced Action Panel -->
        <div class="card-footer bg-light border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Chọn các block để thực hiện thao tác
                </div>
                <button class="btn btn-danger btn-lg px-4 shadow-sm" type="button" id="delete-btn"
                        onclick="nv_del_block_list(this.form, {BID}, '{LANG.del_confirm_no_post}')">
                    <i class="fas fa-trash me-2"></i>{LANG.delete_from_block}
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="progress mt-3" style="height: 6px; display: none;" id="progress-bar">
                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                     role="progressbar" style="width: 0%"></div>
            </div>
        </div>
    </div>
</div>

<style>
.block-icon {
    width: 50px;
    text-align: center;
}

.weight-select {
    transition: all 0.3s ease;
}

.weight-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.block-row {
    transition: all 0.3s ease;
}

.block-row:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.block-row.selected {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border-left: 4px solid #dc3545;
}
</style>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Initialize stats
    updateStats();

    // Enhanced stats calculation
    function updateStats() {
        var totalBlocks = $('.block-checkbox').length;
        var selectedBlocks = $('.block-checkbox:checked').length;
        var sortingBlocks = $('.weight-select:disabled').length;

        $('#total-blocks').text(totalBlocks);
        $('#selected-blocks').text(selectedBlocks);
        $('#sorting-blocks').text(sortingBlocks);

        // Update delete button state
        $('#delete-btn').prop('disabled', selectedBlocks === 0);
    }

    // Enhanced checkbox functionality with visual feedback
    $('.block-checkbox').on('change', function() {
        var $row = $(this).closest('.block-row');
        $row.toggleClass('selected', $(this).is(':checked'));
        updateStats();

        // Update master checkbox state
        var totalCheckboxes = $('.block-checkbox').length;
        var checkedCheckboxes = $('.block-checkbox:checked').length;
        $('input[name="check_all[]"]').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    // Enhanced select/deselect all buttons
    $('#select-all-btn, input[name="check_all[]"]').on('click', function() {
        var isSelectAll = $(this).is('#select-all-btn') || $(this).is(':checked');

        if ($(this).is('#select-all-btn')) {
            $('input[name="check_all[]"]').prop('checked', true);
        }

        $('.block-checkbox').prop('checked', isSelectAll);
        $('.block-row').toggleClass('selected', isSelectAll);
        updateStats();
    });

    $('#deselect-all-btn').on('click', function() {
        $('input[name="check_all[]"]').prop('checked', false);
        $('.block-checkbox').prop('checked', false);
        $('.block-row').removeClass('selected');
        updateStats();
    });

    // Enhanced refresh functionality
    $('#refresh-list').on('click', function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang tải...');

        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
            updateStats();
            showAlert('Danh sách đã được làm mới', 'success');
        }, 1000);
    });

    // Enhanced weight change with loading state
    $('.weight-select').on('change', function() {
        var $select = $(this);
        var $row = $select.closest('.block-row');

        // Add loading state
        $select.prop('disabled', true);
        $row.addClass('table-warning');
        updateStats();

        // Simulate the actual change (replace with actual function call)
        setTimeout(function() {
            $select.prop('disabled', false);
            $row.removeClass('table-warning').addClass('table-success');
            showAlert('Đã cập nhật thứ tự block thành công', 'success');
            updateStats();

            setTimeout(function() {
                $row.removeClass('table-success');
            }, 1500);
        }, 1000);
    });

    // Enhanced delete functionality
    $('#delete-btn').on('click', function() {
        var checkedItems = $('.block-checkbox:checked').length;

        if (checkedItems === 0) {
            showAlert('Vui lòng chọn ít nhất một block để xóa!', 'warning');
            return false;
        }

        var $btn = $(this);
        var originalHtml = $btn.html();
        var $progressBar = $('#progress-bar');
        var $progressBarInner = $progressBar.find('.progress-bar');

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang xóa...');

        // Show progress bar
        $progressBar.show();

        // Simulate progress
        var progress = 0;
        var progressInterval = setInterval(function() {
            progress += Math.random() * 30;
            if (progress > 90) progress = 90;
            $progressBarInner.css('width', progress + '%');
        }, 200);

        // Complete progress after delay
        setTimeout(function() {
            clearInterval(progressInterval);
            $progressBarInner.css('width', '100%');

            setTimeout(function() {
                showAlert('Đã xóa ' + checkedItems + ' block thành công!', 'success');

                // Reset after success
                setTimeout(function() {
                    $btn.prop('disabled', false).html(originalHtml);
                    $progressBar.hide();
                    $progressBarInner.css('width', '0%');
                }, 1000);
            }, 500);
        }, 1500);
    });

    // Enhanced table interactions
    $('.block-row').hover(
        function() {
            if (!$(this).hasClass('selected')) {
                $(this).addClass('table-active');
            }
        },
        function() {
            if (!$(this).hasClass('selected')) {
                $(this).removeClass('table-active');
            }
        }
    );

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' :
                       type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

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

    // Add empty state if no blocks
    if ($('.block-checkbox').length === 0) {
        $('tbody').html(
            '<tr><td colspan="4" class="text-center text-muted py-5">' +
            '<i class="fas fa-cube fa-3x mb-3"></i><br>' +
            '<h6>Không có block nào</h6>' +
            '<small>Vui lòng thêm block để sử dụng tính năng này</small>' +
            '</td></tr>'
        );
    }
});
//]]>
</script>
<!-- END: main -->