<!-- BEGIN: main -->
<div class="container-fluid">
    <div id="module_show_list" class="mb-4">{BLOCK_LIST}</div>

    <!-- BEGIN: news -->
    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-list fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Tổng nội dung</h6>
                    <span class="badge bg-primary fs-6" id="total-items">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h6 class="card-title">Đã chọn</h6>
                    <span class="badge bg-success fs-6" id="selected-items">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-cube fa-2x text-info mb-2"></i>
                    <h6 class="card-title">Block đích</h6>
                    <span class="badge bg-info fs-6" id="target-block">Chưa chọn</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Thêm vào Block
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-light btn-sm" id="select-all-btn">
                        <i class="fas fa-check-square me-1"></i>Chọn tất cả
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" id="deselect-all-btn">
                        <i class="fas fa-square me-1"></i>Bỏ chọn
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <form role="form" action="{NV_BASE_ADMINURL}index.php" method="post" id="block-form">
                <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
                <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
                <input type="hidden" name="checkss" value="{CHECKSESS}" />

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th style="width: 60px;" class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" name="check_all[]" type="checkbox" value="yes"
                                               id="checkAllTop" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />
                                        <label class="form-check-label" for="checkAllTop">
                                            <span class="visually-hidden">Chọn tất cả</span>
                                        </label>
                                    </div>
                                </th>
                                <th>
                                    <i class="fas fa-heading me-1"></i>{LANG.title}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="content-row" data-id="{ROW.id}">
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input item-checkbox" type="checkbox" value="{ROW.id}" name="idcheck[]"
                                               id="check_{ROW.id}" {ROW.checked}
                                               onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" />
                                        <label class="form-check-label" for="check_{ROW.id}">
                                            <span class="visually-hidden">Chọn mục này</span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-alt text-muted me-2"></i>
                                        <span class="fw-medium">{ROW.title}</span>
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
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" name="check_all[]" type="checkbox" value="yes"
                               id="checkAllBottom" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />
                        <label class="form-check-label fw-bold" for="checkAllBottom">
                            <i class="fas fa-check-square me-1"></i>Chọn tất cả
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        <i class="fas fa-cube me-1"></i>Chọn Block đích
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-cube"></i>
                        </span>
                        <select class="form-select" name="bid" id="block-select">
                            <!-- BEGIN: bid -->
                            <option value="{BID.key}"{BID.selected}>{BID.title}</option>
                            <!-- END: bid -->
                        </select>
                    </div>
                    <div class="form-text">Chọn block để thêm các mục đã chọn</div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success btn-lg w-100 shadow-sm" name="submit1" type="submit" form="block-form" id="submit-btn">
                        <i class="fas fa-save me-2"></i>{LANG.save}
                    </button>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="progress mt-3" style="height: 6px; display: none;" id="progress-bar">
                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                     role="progressbar" style="width: 0%"></div>
            </div>
        </div>
    </div>
    <!-- END: news -->
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.content-row {
    transition: all 0.3s ease;
}

.content-row:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.content-row.selected {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-left: 4px solid #28a745;
}
</style>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Initialize stats
    updateStats();

    // Enhanced stats calculation
    function updateStats() {
        var totalItems = $('.item-checkbox').length;
        var selectedItems = $('.item-checkbox:checked').length;
        var selectedBlock = $('#block-select option:selected').text();

        $('#total-items').text(totalItems);
        $('#selected-items').text(selectedItems);
        $('#target-block').text(selectedBlock || 'Chưa chọn');

        // Update button state
        $('#submit-btn').prop('disabled', selectedItems === 0);
    }

    // Enhanced checkbox functionality with visual feedback
    $('.item-checkbox').on('change', function() {
        var $row = $(this).closest('.content-row');
        $row.toggleClass('selected', $(this).is(':checked'));
        updateStats();

        // Update master checkbox state
        var totalCheckboxes = $('.item-checkbox').length;
        var checkedCheckboxes = $('.item-checkbox:checked').length;
        $('input[name="check_all[]"]').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    // Enhanced select/deselect all buttons
    $('#select-all-btn, input[name="check_all[]"]').on('click', function() {
        var isSelectAll = $(this).is('#select-all-btn') || $(this).is(':checked');

        if ($(this).is('#select-all-btn')) {
            $('input[name="check_all[]"]').prop('checked', true);
        }

        $('.item-checkbox').prop('checked', isSelectAll);
        $('.content-row').toggleClass('selected', isSelectAll);
        updateStats();
    });

    $('#deselect-all-btn').on('click', function() {
        $('input[name="check_all[]"]').prop('checked', false);
        $('.item-checkbox').prop('checked', false);
        $('.content-row').removeClass('selected');
        updateStats();
    });

    // Block select change handler
    $('#block-select').on('change', function() {
        updateStats();
    });

    // Enhanced form submission with progress bar
    $('#block-form').on('submit', function(e) {
        var checkedItems = $('.item-checkbox:checked').length;
        var selectedBlock = $('#block-select option:selected').text();

        if (checkedItems === 0) {
            showAlert('Vui lòng chọn ít nhất một mục để thêm vào block!', 'warning');
            return false;
        }

        if (!selectedBlock || selectedBlock === 'Chưa chọn') {
            showAlert('Vui lòng chọn block đích!', 'warning');
            return false;
        }

        var $btn = $('#submit-btn');
        var originalText = $btn.html();
        var $progressBar = $('#progress-bar');
        var $progressBarInner = $progressBar.find('.progress-bar');

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...');

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
                showAlert('Đã thêm ' + checkedItems + ' mục vào block "' + selectedBlock + '" thành công!', 'success');

                // Reset form after success
                setTimeout(function() {
                    $btn.prop('disabled', false).html(originalText);
                    $progressBar.hide();
                    $progressBarInner.css('width', '0%');
                }, 1000);
            }, 500);
        }, 1500);

        // Allow form to submit normally
        return true;
    });

    // Enhanced table interactions
    $('.content-row').hover(
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

        // Auto-hide after 4 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 4000);
    }

    // Enhanced button hover effects
    $('.btn').on('mouseenter', function() {
        $(this).addClass('shadow');
    }).on('mouseleave', function() {
        $(this).removeClass('shadow');
    });

    // Initialize tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Add empty state if no items
    if ($('.item-checkbox').length === 0) {
        $('tbody').html(
            '<tr><td colspan="2" class="text-center text-muted py-5">' +
            '<i class="fas fa-inbox fa-3x mb-3"></i><br>' +
            '<h6>Không có nội dung nào</h6>' +
            '<small>Vui lòng thêm nội dung để sử dụng tính năng này</small>' +
            '</td></tr>'
        );
    }
});
//]]>
</script>
<!-- END: news -->
<!-- END: main -->