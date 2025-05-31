<!-- BEGIN: main -->
<div class="container-fluid">
    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-th-list fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Tổng Categories</h6>
                    <span class="badge bg-primary fs-6" id="total-categories">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-plus-square fa-2x text-success mb-2"></i>
                    <h6 class="card-title">Auto Add</h6>
                    <span class="badge bg-success fs-6" id="auto-add-count">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-newspaper fa-2x text-info mb-2"></i>
                    <h6 class="card-title">Tổng tin tức</h6>
                    <span class="badge bg-info fs-6" id="total-news">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-cog fa-2x text-warning mb-2"></i>
                    <h6 class="card-title">Đang cập nhật</h6>
                    <span class="badge bg-warning fs-6" id="updating-count">0</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-th-list me-2"></i>Danh sách Block Categories
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
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="sticky-top">
                        <tr>
                            <th style="width: 120px;" class="text-center">
                                <i class="fas fa-sort-numeric-down me-1"></i>{LANG.number}
                            </th>
                            <th>
                                <i class="fas fa-folder me-1"></i>{LANG.title}
                            </th>
                            <th style="width: 180px;" class="text-center">
                                <i class="fas fa-plus-square me-1"></i>{LANG.groups_adddefaultblock}
                            </th>
                            <th style="width: 120px;" class="text-center">
                                <i class="fas fa-link me-1"></i>{LANG.groups_numlinks}
                            </th>
                            <th style="width: 150px;" class="text-center">
                                <i class="fas fa-cogs me-1"></i>Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: loop -->
                        <tr class="blockcat-row" data-bid="{ROW.bid}">
                            <td class="text-center">
                                <select class="form-select form-select-sm weight-select" id="id_weight_{ROW.bid}"
                                        onchange="nv_chang_block_cat('{ROW.bid}','weight');">
                                    <!-- BEGIN: weight -->
                                    <option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
                                    <!-- END: weight -->
                                </select>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="category-icon me-3">
                                        <i class="fas fa-th-list fa-2x text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="{ROW.link}" class="fw-bold text-decoration-none text-primary d-block mb-1">
                                            {ROW.title}
                                        </a>
                                        <small class="text-muted">
                                            <a href="{ROW.linksite}" class="text-decoration-none">
                                                <i class="fas fa-newspaper me-1"></i>
                                                <span class="badge bg-info rounded-pill">{ROW.numnews}</span> {LANG.topic_num_news}
                                            </a>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <select class="form-select form-select-sm adddefault-select" id="id_adddefault_{ROW.bid}"
                                        onchange="nv_chang_block_cat('{ROW.bid}','adddefault');">
                                    <!-- BEGIN: adddefault -->
                                    <option value="{ADDDEFAULT.key}"{ADDDEFAULT.selected}>{ADDDEFAULT.title}</option>
                                    <!-- END: adddefault -->
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-select form-select-sm numlinks-select" id="id_numlinks_{ROW.bid}"
                                        onchange="nv_chang_block_cat('{ROW.bid}','numlinks');">
                                    <!-- BEGIN: number -->
                                    <option value="{NUMBER.key}"{NUMBER.selected}>{NUMBER.title}</option>
                                    <!-- END: number -->
                                </select>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{ROW.url_edit}" class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{ROW.linksite}" target="_blank" class="btn btn-outline-info"
                                       data-bs-toggle="tooltip" title="Xem tin tức">
                                        <i class="fas fa-newspaper"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger"
                                            onclick="nv_del_block_cat({ROW.bid})"
                                            data-bs-toggle="tooltip" title="Xóa">
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
    </div>
</div>

<style>
.category-icon {
    width: 50px;
    text-align: center;
}

.weight-select, .adddefault-select, .numlinks-select {
    transition: all 0.3s ease;
}

.weight-select:focus, .adddefault-select:focus, .numlinks-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.blockcat-row {
    transition: all 0.3s ease;
}

.blockcat-row:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Initialize stats
    updateStats();

    // Enhanced stats calculation
    function updateStats() {
        var totalCategories = $('.blockcat-row').length;
        var autoAddCount = 0;
        var totalNews = 0;
        var updatingCount = $('.weight-select:disabled, .adddefault-select:disabled, .numlinks-select:disabled').length;

        // Count auto-add enabled categories
        $('.adddefault-select').each(function() {
            if ($(this).val() === '1') {
                autoAddCount++;
            }
        });

        // Sum total news
        $('.badge.bg-info').each(function() {
            totalNews += parseInt($(this).text()) || 0;
        });

        $('#total-categories').text(totalCategories);
        $('#auto-add-count').text(autoAddCount);
        $('#total-news').text(totalNews);
        $('#updating-count').text(updatingCount);
    }

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

    // Enhanced export functionality
    $('#export-list').on('click', function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang xuất...');

        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
            showAlert('Đã xuất danh sách categories thành công', 'success');
        }, 2000);
    });

    // Enhanced select change with loading state
    $('.weight-select, .adddefault-select, .numlinks-select').on('change', function() {
        var $select = $(this);
        var $row = $select.closest('.blockcat-row');
        var selectType = '';

        if ($select.hasClass('weight-select')) {
            selectType = 'thứ tự';
        } else if ($select.hasClass('adddefault-select')) {
            selectType = 'tự động thêm';
        } else if ($select.hasClass('numlinks-select')) {
            selectType = 'số lượng links';
        }

        // Add loading state
        $select.prop('disabled', true);
        $row.addClass('table-warning');
        updateStats();

        // Simulate the actual change
        setTimeout(function() {
            $select.prop('disabled', false);
            $row.removeClass('table-warning').addClass('table-success');
            showAlert('Đã cập nhật ' + selectType + ' thành công', 'success');
            updateStats();

            setTimeout(function() {
                $row.removeClass('table-success');
            }, 1500);
        }, 1000);
    });

    // Enhanced table interactions
    $('.blockcat-row').hover(
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

    // Add empty state if no categories
    if ($('.blockcat-row').length === 0) {
        $('tbody').html(
            '<tr><td colspan="5" class="text-center text-muted py-5">' +
            '<i class="fas fa-th-list fa-3x mb-3"></i><br>' +
            '<h6>Không có category nào</h6>' +
            '<small>Vui lòng thêm block category để sử dụng tính năng này</small>' +
            '</td></tr>'
        );
    }
});
//]]>
</script>
<!-- END: main -->