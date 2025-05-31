<!-- BEGIN: main -->
<div class="container-fluid">
    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-database fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Tổng ngân hàng</h6>
                    <span class="badge bg-primary fs-6" id="total-banks">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-folder-open fa-2x text-success mb-2"></i>
                    <h6 class="card-title">Ngân hàng chính</h6>
                    <span class="badge bg-success fs-6" id="main-banks">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-info mb-2"></i>
                    <h6 class="card-title">Đã chọn</h6>
                    <span class="badge bg-info fs-6" id="selected-bank">Chưa chọn</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list-alt me-2"></i>
                    <strong>{LANG.select_topic}:</strong> {TITLE}
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-light btn-sm" id="clear-selection">
                        <i class="fas fa-times me-1"></i>Bỏ chọn
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" id="refresh-list">
                        <i class="fas fa-sync-alt me-1"></i>Làm mới
                    </button>
                </div>
            </div>
        </div>

        <!-- BEGIN: view -->
        <div class="card-body p-0">
            <form id="frm-bank-list" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
                <input type="hidden" name="send_bank_id" value="{send_bank_id}"/>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th style="width: 100px;" class="text-center">
                                    <i class="fas fa-weight-hanging me-1"></i>{LANG.weight}
                                </th>
                                <th>
                                    <i class="fas fa-folder me-1"></i>{LANG.title}
                                </th>
                                <th style="width: 120px;" class="text-center">
                                    <i class="fas fa-check-circle me-1"></i>{LANG.cat_select}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="bank-row" data-id="{VIEW.id}" data-title="{VIEW.title}">
                                <td class="text-center">
                                    <div class="weight-badge">
                                        <span class="badge bg-secondary fs-6">{VIEW.weight}</span>
                                    </div>
                                </td>
                                <td>
                                    <!-- BEGIN: main_bank -->
                                    <div class="d-flex align-items-center">
                                        <div class="bank-icon me-3">
                                            <i class="fas fa-folder-open fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="{VIEW.link_view}" title="{VIEW.title}"
                                               class="fw-bold text-decoration-none text-primary mb-1 d-block">
                                                {VIEW.title}
                                            </a>
                                            <div class="d-flex align-items-center gap-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-layer-group me-1"></i>
                                                    <span class="badge bg-info rounded-pill">{VIEW.numsub}</span> {LANG.category}
                                                </small>
                                                <span class="badge bg-success">Ngân hàng chính</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END: main_bank -->
                                    <!-- BEGIN: bank -->
                                    <div class="d-flex align-items-center">
                                        <div class="bank-icon me-3">
                                            <i class="fas fa-file-alt fa-2x text-secondary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium text-dark">{VIEW.title}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-folder me-1"></i>Ngân hàng con
                                            </small>
                                        </div>
                                    </div>
                                    <!-- END: bank -->
                                </td>
                                <td class="text-center">
                                    <!-- BEGIN: able_select -->
                                    <div class="form-check d-inline-block">
                                        <input class="form-check-input bank-radio" type="radio" name="typeid_main"
                                               value="{VIEW.id}" id="radio_{VIEW.id}">
                                        <label class="form-check-label" for="radio_{VIEW.id}">
                                            <span class="visually-hidden">Chọn ngân hàng này</span>
                                        </label>
                                    </div>
                                    <!-- END: able_select -->
                                </td>
                            </tr>
                            <!-- END: loop -->
                        </tbody>
                        <!-- BEGIN: generate_page -->
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-center py-3">
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

        <!-- Action Panel -->
        <div class="card-footer bg-light border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Chọn một ngân hàng để tiếp tục
                </div>
                <button class="btn btn-success btn-lg px-5 shadow-sm" type="submit" form="frm-bank-list" name="submit" id="submit-btn">
                    <i class="fas fa-paper-plane me-2"></i>{LANG.send_bank}
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="progress mt-3" style="height: 6px; display: none;" id="progress-bar">
                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                     role="progressbar" style="width: 0%"></div>
            </div>
        </div>
        <!-- END: view -->
    </div>
</div>

<style>
.bank-icon {
    width: 50px;
    text-align: center;
}

.weight-badge {
    transition: transform 0.2s ease;
}

.weight-badge:hover {
    transform: scale(1.1);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.bank-row {
    transition: all 0.3s ease;
}

.bank-row:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.bank-row.selected {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-left: 4px solid #28a745;
}
</style>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/notify.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Initialize stats
    updateBankStats();

    // Enhanced stats calculation
    function updateBankStats() {
        var totalBanks = $('.bank-row').length;
        var mainBanks = $('.bank-row').filter(function() {
            return $(this).find('.badge:contains("Ngân hàng chính")').length > 0;
        }).length;
        var selectedBank = $('input[name="typeid_main"]:checked').closest('.bank-row').data('title') || 'Chưa chọn';

        $('#total-banks').text(totalBanks);
        $('#main-banks').text(mainBanks);
        $('#selected-bank').text(selectedBank);

        // Update submit button state
        $('#submit-btn').prop('disabled', !$('input[name="typeid_main"]:checked').length);
    }

    // Enhanced row selection with visual feedback
    $('.bank-radio').on('change', function() {
        $('.bank-row').removeClass('table-active selected');
        var $selectedRow = $(this).closest('.bank-row');
        $selectedRow.addClass('table-active selected');
        updateBankStats();
    });

    // Clear selection functionality
    $('#clear-selection').on('click', function() {
        $('.bank-radio').prop('checked', false);
        $('.bank-row').removeClass('table-active selected');
        updateBankStats();
        showAlert('Đã bỏ chọn tất cả ngân hàng', 'info');
    });

    // Refresh functionality
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

    // Enhanced form submission with progress bar
    $('#frm-bank-list').submit(function(e) {
        e.preventDefault();

        var $form = $(this);
        var $submitBtn = $('#submit-btn');
        var originalText = $submitBtn.html();
        var typeid_main = $("input[name=typeid_main]:checked").val();
        var $progressBar = $('#progress-bar');
        var $progressBarInner = $progressBar.find('.progress-bar');

        // Validation
        if(!typeid_main || typeid_main == 0 || typeid_main == "") {
            showAlert('{LANG.error_select_typeid}', 'error');

            // Highlight form for better UX
            $('input[name="typeid_main"]').closest('td').addClass('border border-danger');
            setTimeout(function() {
                $('input[name="typeid_main"]').closest('td').removeClass('border border-danger');
            }, 3000);
            return false;
        }

        // Show loading state
        $submitBtn.prop('disabled', true)
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

        // AJAX submission
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=bank_list&submit=1',
            data: $form.serialize(),
            dataType: 'json',
            success: function(res) {
                clearInterval(progressInterval);
                $progressBarInner.css('width', '100%');

                setTimeout(function() {
                    var className = !res.error ? 'success' : 'error';
                    showAlert(res.msg, className);

                    if (!res.error) {
                        // Success feedback
                        $submitBtn.html('<i class="fas fa-check me-2"></i>Thành công!');
                        $('.bank-row.selected').addClass('table-success');

                        // Redirect after delay
                        setTimeout(function() {
                            window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question-list&typeid=' + res.typeid;
                        }, 2000);
                    } else {
                        // Error feedback
                        $submitBtn.prop('disabled', false).html(originalText);
                        $('.bank-row.selected').addClass('table-danger');
                        setTimeout(function() {
                            $('.bank-row').removeClass('table-danger');
                        }, 3000);
                    }

                    // Hide progress bar
                    setTimeout(function() {
                        $progressBar.hide();
                        $progressBarInner.css('width', '0%');
                    }, 1000);
                }, 500);
            },
            error: function() {
                clearInterval(progressInterval);
                $submitBtn.prop('disabled', false).html(originalText);
                $progressBar.hide();
                $progressBarInner.css('width', '0%');
                showAlert('Có lỗi xảy ra, vui lòng thử lại!', 'error');
            }
        });
    });

    // Enhanced table interactions
    $('.bank-row').hover(
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
                       type === 'error' ? 'fa-times-circle' :
                       type === 'info' ? 'fa-info-circle' : 'fa-exclamation-triangle';

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

    // Add empty state if no banks
    if ($('.bank-row').length === 0) {
        $('tbody').html(
            '<tr><td colspan="3" class="text-center text-muted py-5">' +
            '<i class="fas fa-database fa-3x mb-3"></i><br>' +
            '<h6>Không có ngân hàng nào</h6>' +
            '<small>Vui lòng thêm ngân hàng câu hỏi để sử dụng tính năng này</small>' +
            '</td></tr>'
        );
    }
});
//]]>
</script>
<!-- END: main -->