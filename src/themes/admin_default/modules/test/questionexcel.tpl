<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- BEGIN: error -->
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Lỗi:</strong> {ERROR}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <!-- END: error -->

            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Hướng dẫn:</strong> {LANG.note_importexcel}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-excel me-2"></i>Import câu hỏi từ Excel
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{FORM_ACTION}" method="post" name="levelnone" id="levelnone" enctype="multipart/form-data">
                        <input type="hidden" name="examid" value="{EXAMID}" />

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="update_question"
                                       name="update_question" value="1" />
                                <label class="form-check-label fw-bold" for="update_question">
                                    <i class="fas fa-sync-alt me-1"></i>{LANG.update_question}
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Bật tùy chọn này để cập nhật câu hỏi đã tồn tại
                            </small>
                        </div>

                        <!-- BEGIN: typeid -->
                        <div class="mb-3" id="typeid_container">
                            <label class="form-label fw-bold">
                                <i class="fas fa-tags me-1"></i>{LANG.type_input_question_2}
                            </label>
                            <select class="form-select" name="typeid">
                                <option value="0">-- {LANG.select_category} --</option>
                                <!-- BEGIN: bank_option_group -->
                                <optgroup label="{option_group}">
                                <!-- BEGIN: bank_option -->
                                <option value="{OPTION.id}" {OPTION.selected}>{OPTION.title}</option>
                                <!-- END: bank_option -->
                                </optgroup>
                                <!-- END: bank_option_group -->
                            </select>
                        </div>
                        <!-- END: typeid -->

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-paperclip me-1"></i>{LANG.atach}
                            </label>
                            <input type="file" name="import_file" class="form-control"
                                   accept=".xlsx,.xls" required />
                            <div class="form-text">
                                <i class="fas fa-file-excel me-1"></i>Chỉ chấp nhận file Excel (.xlsx, .xls)
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-primary" type="submit" name="submit" disabled>
                                <i class="fas fa-upload me-1"></i>{LANG.save}
                            </button>
                            <a href="{DOWNLOAD}" class="btn btn-info">
                                <i class="fas fa-download me-1"></i>{LANG.down_file_import}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced form validation
    function check_able() {
        var examid = $('input[name="examid"]').val();
        var typeid = $('select[name="typeid"]').val();
        var update_question = $('input[name="update_question"]')[0].checked;
        var file = $('input[name="import_file"]').val();
        return ((typeid > 0) || (examid > 0) || update_question) && (file.length > 0);
    }

    // Enhanced update question toggle
    $('input[name="update_question"]').on('change', function(e) {
        var update_question = $(this)[0].checked;
        var $container = $('#typeid_container');

        if (update_question) {
            $container.fadeOut(300, function() {
                $(this).addClass('d-none');
            });
        } else {
            $container.removeClass('d-none').hide().fadeIn(300);
        }

        // Update submit button state
        updateSubmitButton();
    });

    // Enhanced typeid change handler
    $('select[name="typeid"]').on('change', function(e) {
        updateSubmitButton();

        // Visual feedback for selection
        if ($(this).val() > 0) {
            $(this).addClass('border-success');
            setTimeout(function() {
                $('select[name="typeid"]').removeClass('border-success');
            }, 1500);
        }
    });

    // Enhanced file input handler
    $('input[name="import_file"]').on('change', function(e) {
        var file = e.target.files[0];

        if (file) {
            // Validate file type
            var allowedTypes = ['.xlsx', '.xls'];
            var fileName = file.name.toLowerCase();
            var isValidType = allowedTypes.some(type => fileName.endsWith(type));

            if (!isValidType) {
                $(this).addClass('is-invalid');
                showAlert('Vui lòng chọn file Excel (.xlsx hoặc .xls)', 'danger');
                $(this).val('');
                updateSubmitButton();
                return;
            }

            // Validate file size (max 10MB)
            if (file.size > 10 * 1024 * 1024) {
                $(this).addClass('is-invalid');
                showAlert('File quá lớn. Vui lòng chọn file nhỏ hơn 10MB', 'danger');
                $(this).val('');
                updateSubmitButton();
                return;
            }

            // File is valid
            $(this).removeClass('is-invalid').addClass('is-valid');
            showAlert('File đã được chọn: ' + file.name, 'success');
        }

        updateSubmitButton();
    });

    // Enhanced submit button update
    function updateSubmitButton() {
        var $submitBtn = $('button[name="submit"]');
        var isAble = check_able();

        $submitBtn.prop('disabled', !isAble);

        if (isAble) {
            $submitBtn.removeClass('btn-secondary').addClass('btn-primary');
        } else {
            $submitBtn.removeClass('btn-primary').addClass('btn-secondary');
        }
    }

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show mt-2" role="alert">' +
                       '<i class="fas ' + iconClass + ' me-2"></i>' + message +
                       '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                       '</div>';

        // Remove existing alerts
        $('.alert:not(.alert-info)').remove();

        // Add new alert
        $('.card-body').prepend(alertHtml);

        // Auto-hide success alerts
        if (type === 'success') {
            setTimeout(function() {
                $('.alert-success').fadeOut();
            }, 3000);
        }
    }

    // Enhanced form submission
    $('#levelnone').on('submit', function(e) {
        var $submitBtn = $('button[name="submit"]');
        var originalHtml = $submitBtn.html();

        // Show loading state
        $submitBtn.prop('disabled', true)
                  .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang xử lý...');

        // Restore after 10 seconds (fallback)
        setTimeout(function() {
            $submitBtn.prop('disabled', false).html(originalHtml);
        }, 10000);
    });

    // Initialize tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Initial state
    updateSubmitButton();
});
//]]>
</script>
<!-- END: main -->