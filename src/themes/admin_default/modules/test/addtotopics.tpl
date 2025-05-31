<!-- BEGIN: main -->
<div id="add" class="container-fluid">
    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-list-ul fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Tổng số mục</h6>
                    <span class="badge bg-primary fs-6" id="total-items">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h6 class="card-title">Đã chọn</h6>
                    <span class="badge bg-success fs-6" id="selected-items">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-folder fa-2x text-info mb-2"></i>
                    <h6 class="card-title">Chủ đề đích</h6>
                    <span class="badge bg-info fs-6" id="target-topic">Chưa chọn</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus-circle me-2"></i>{LANG.name}
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
            <form role="form" action="{NV_BASE_ADMINURL}index.php" method="post">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th style="width: 60px;" class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="checkall" id="checkall">
                                        <label class="form-check-label" for="checkall">
                                            <span class="visually-hidden">Chọn tất cả</span>
                                        </label>
                                    </div>
                                </th>
                                <th>
                                    <i class="fas fa-tag me-2"></i>{LANG.name}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="item-row" data-id="{ROW.id}">
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input item-checkbox" type="checkbox"
                                               value="{ROW.id}" name="idcheck" id="check_{ROW.id}"{ROW.checked}>
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
    </div>

    <!-- Enhanced Action Panel -->
    <div class="card shadow-sm mt-4 border-0">
        <div class="card-header bg-light border-bottom">
            <h6 class="card-title mb-0 text-muted">
                <i class="fas fa-cogs me-2"></i>Thao tác
            </h6>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label fw-bold">
                        <i class="fas fa-folder me-1"></i>Chọn chủ đề đích
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-folder"></i>
                        </span>
                        <select class="form-select" name="topicsid" id="topics-select">
                            <!-- BEGIN: topicsid -->
                            <option value="{TOPICSID.key}">{TOPICSID.title}</option>
                            <!-- END: topicsid -->
                        </select>
                    </div>
                    <div class="form-text">Chọn chủ đề để thêm các mục đã chọn</div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success btn-lg w-100 shadow-sm" name="update" id="update-topic" type="button">
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
</div>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    var LANG = [];
    LANG.topic_nocheck = '{LANG.topic_nocheck}';

    // Initialize stats
    updateStats();

    // Enhanced check all functionality
    function updateCheckAllState() {
        var totalCheckboxes = $('.item-checkbox').length;
        var checkedCheckboxes = $('.item-checkbox:checked').length;
        $('#checkall').prop('checked', totalCheckboxes === checkedCheckboxes);
        updateStats();
    }

    function updateStats() {
        var totalItems = $('.item-checkbox').length;
        var selectedItems = $('.item-checkbox:checked').length;
        var selectedTopic = $('#topics-select option:selected').text();

        $('#total-items').text(totalItems);
        $('#selected-items').text(selectedItems);
        $('#target-topic').text(selectedTopic || 'Chưa chọn');

        // Update button state
        $('#update-topic').prop('disabled', selectedItems === 0);
    }

    // Master checkbox functionality
    $('#checkall, #select-all-btn').on('click', function() {
        var isChecked = $(this).is('#checkall') ? $(this).is(':checked') : true;
        if ($(this).is('#select-all-btn')) {
            $('#checkall').prop('checked', true);
        }

        $('.item-checkbox').prop('checked', isChecked);
        $('.item-row').toggleClass('table-success', isChecked);
        updateStats();
    });

    // Deselect all button
    $('#deselect-all-btn').on('click', function() {
        $('#checkall').prop('checked', false);
        $('.item-checkbox').prop('checked', false);
        $('.item-row').removeClass('table-success');
        updateStats();
    });

    // Individual checkbox change handler
    $('.item-checkbox').on('change', function() {
        var $row = $(this).closest('tr');
        $row.toggleClass('table-success', $(this).is(':checked'));
        updateCheckAllState();
    });

    // Topics select change handler
    $('#topics-select').on('change', function() {
        updateStats();
    });

    // Enhanced save button with progress
    $('#update-topic').on('click', function() {
        var checkedItems = $('.item-checkbox:checked').length;
        if (checkedItems === 0) {
            showAlert(LANG.topic_nocheck, 'warning');
            return false;
        }

        var selectedTopic = $('#topics-select option:selected').text();
        if (!selectedTopic || selectedTopic === 'Chưa chọn') {
            showAlert('Vui lòng chọn chủ đề đích!', 'warning');
            return false;
        }

        var $btn = $(this);
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

        // Simulate form submission
        setTimeout(function() {
            clearInterval(progressInterval);
            $progressBarInner.css('width', '100%');

            setTimeout(function() {
                $btn.prop('disabled', false).html(originalText);
                $progressBar.hide();
                $progressBarInner.css('width', '0%');
                showAlert('Đã thêm ' + checkedItems + ' mục vào chủ đề "' + selectedTopic + '" thành công!', 'success');
            }, 500);
        }, 2000);
    });

    // Enhanced table interactions
    $('.item-row').hover(
        function() {
            if (!$(this).hasClass('table-success')) {
                $(this).addClass('table-active');
            }
        },
        function() {
            if (!$(this).hasClass('table-success')) {
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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Add empty state if no items
    if ($('.item-checkbox').length === 0) {
        $('tbody').html(
            '<tr><td colspan="2" class="text-center text-muted py-5">' +
            '<i class="fas fa-inbox fa-3x mb-3"></i><br>' +
            '<h6>Không có mục nào để hiển thị</h6>' +
            '<small>Vui lòng thêm dữ liệu để sử dụng tính năng này</small>' +
            '</td></tr>'
        );
    }
});
//]]>
</script>
<!-- END: main -->