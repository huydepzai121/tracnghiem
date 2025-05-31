<!-- BEGIN: main -->
{PACKAGE_NOTIICE}
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css">

<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{ERROR}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>{LANG.exams_config}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}"
                          method="post" id="frm-exam">
                        <input type="hidden" name="num_question" id="num_question" value="{ROW.num_question}" />
                        <input type="hidden" name="id" value="{ROW.id}" />
                        <input type="hidden" name="submit" value="1" />

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-bold">
                                <i class="fas fa-heading me-1"></i>{LANG.title}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="title" id="title"
                                       value="{ROW.title}" required placeholder="Nhập tiêu đề đề thi..." />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-bold">
                                <i class="fas fa-clock me-1"></i>{LANG.timer}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input class="form-control" type="number" name="timer" id="timer"
                                           value="{ROW.timer}" min="1" required placeholder="Thời gian làm bài..." />
                                    <span class="input-group-text">phút</span>
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>{LANG.time_note}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list-alt me-2"></i>{LANG.question_config}
                    </h5>
                    <button type="button" class="btn btn-outline-light btn-sm" id="exams_config_refresh"
                            data-confirm="{LANG.exams_config_refresh_confirm}"
                            title="{LANG.exams_config_refresh}">
                        <i class="fas fa-sync-alt me-1"></i>Làm mới
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0" id="table-exams-config">
                            <thead>
                                <tr>
                                    <th>
                                        <i class="fas fa-graduation-cap me-1"></i>{LANG.class}
                                    </th>
                                    <th>
                                        <i class="fas fa-folder me-1"></i>{LANG.category}
                                    </th>
                                    <!-- BEGIN: bank_type_header -->
                                    <th class="text-center">
                                        <i class="fas fa-database me-1"></i>{BANK_TYPE.title}
                                    </th>
                                    <!-- END: bank_type_header -->
                                    <th class="text-center">
                                        <i class="fas fa-question-circle me-1"></i>{LANG.question_count}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- BEGIN: class -->
                                <tr class="table-secondary">
                                    <td rowspan="{ROWSPAN}" class="fw-bold text-primary align-middle">
                                        <i class="fas fa-school me-2"></i>{CLASS.title}
                                    </td>
                                </tr>
                                <!-- BEGIN: sub_0 -->
                                <tr>
                                    <td class="fw-semibold">
                                        <i class="fas fa-folder-open me-2 text-warning"></i>{CAT.title}
                                    </td>
                                    <!-- BEGIN: bank_type -->
                                    <td class="text-center">
                                        <!-- BEGIN: no_ques -->
                                        <div class="text-muted" title="Bạn cần cập nhật thêm câu hỏi">
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                            <small>Chưa có câu hỏi</small>
                                        </div>
                                        <!-- END: no_ques -->
                                        <!-- BEGIN: had_ques -->
                                        <input class="form-control form-control-sm text-center bank_type_{BANK_TYPE.id}"
                                               data-max="{COUNT_MAX}"
                                               data-bank-type="{BANK_TYPE.id}"
                                               type="number"
                                               name="config[{CLASS.id}][{CAT.id}][{BANK_TYPE.id}]"
                                               value="{BANK_TYPE.value}"
                                               min="0"
                                               max="{COUNT_MAX}"
                                               title="{LANG.tooltip_sllquestion} {COUNT_MAX}"
                                               style="width: 80px; margin: 0 auto;" />
                                        <!-- END: had_ques -->
                                    </td>
                                    <!-- END: bank_type -->
                                    <td class="text-center">
                                        <span class="badge bg-info fs-6 num_question">{TOTAL}</span>
                                    </td>
                                </tr>
                                <!-- END: sub_0 -->
                                <!-- END: class -->
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr class="fw-bold">
                                    <td colspan="2" class="text-end">
                                        <i class="fas fa-calculator me-2"></i>
                                        <strong>{LANG.exams_report_total_question}</strong>
                                    </td>
                                    <!-- BEGIN: bank_type_foter -->
                                    <td class="num_question text-center" id="bank_type_{BANK_TYPE.id}">
                                        <span class="badge bg-info fs-6">{BANK_TYPE.sum}</span>
                                    </td>
                                    <!-- END: bank_type_foter -->
                                    <td class="num_question text-center" id="num_question">
                                        <span class="badge bg-primary fs-6">{NUM_QUESTION}</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <div class="btn-group" role="group">
                    <button class="btn btn-primary btn-lg px-5 loading" type="submit">
                        <i class="fas fa-save me-2"></i>{LANG.save}
                    </button>
                    <a class="btn btn-secondary btn-lg px-4" href="javascript:history.back()">
                        <i class="fas fa-times me-2"></i>{LANG.cancel}
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>{LANG.option}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" name="random_question"
                               id="random_question" {ROW.ck_random_question} />
                        <label class="form-check-label" for="random_question">
                            <i class="fas fa-random me-1"></i>{LANG.exams_random_question}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="random_answer"
                               id="random_answer" {ROW.ck_random_answer} />
                        <label class="form-check-label" for="random_answer">
                            <i class="fas fa-shuffle me-1"></i>{LANG.exams_random_answer}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced Select2 with Bootstrap 5 theme
    $('.select2').select2({
        theme: 'bootstrap-5',
        language: '{NV_LANG_INTERFACE}',
        placeholder: 'Chọn...',
        allowClear: true
    });

    var error_lang = '{LANG.error_lang}';

    // Initialize tooltips for Bootstrap 5
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Enhanced refresh button
    $('#exams_config_refresh').on('click', function() {
        var confirmMsg = $(this).data('confirm');
        if (confirm(confirmMsg)) {
            var $btn = $(this);
            var originalHtml = $btn.html();

            // Show loading state
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang làm mới...');

            // Simulate refresh (replace with actual refresh logic)
            setTimeout(function() {
                $btn.prop('disabled', false).html(originalHtml);
                location.reload();
            }, 1000);
        }
    });

    // Enhanced form submission with validation
    $('#frm-exam').on('submit', function(e) {
        var $btn = $(this).find('button[type="submit"]');
        var originalHtml = $btn.html();

        // Validate required fields
        var title = $('input[name="title"]').val().trim();
        var timer = $('input[name="timer"]').val();

        if (!title) {
            e.preventDefault();
            $('input[name="title"]').addClass('is-invalid').focus();
            alert('Vui lòng nhập tiêu đề!');
            return false;
        }

        if (!timer || timer < 1) {
            e.preventDefault();
            $('input[name="timer"]').addClass('is-invalid').focus();
            alert('Vui lòng nhập thời gian hợp lệ!');
            return false;
        }

        // Check if at least one question is configured
        var hasQuestions = false;
        $('input[name^="config"]').each(function() {
            if ($(this).val() && parseInt($(this).val()) > 0) {
                hasQuestions = true;
                return false;
            }
        });

        if (!hasQuestions) {
            e.preventDefault();
            alert('Vui lòng cấu hình ít nhất một câu hỏi!');
            return false;
        }

        // Remove validation classes
        $('.is-invalid').removeClass('is-invalid');

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');
    });

    // Enhanced input validation for question numbers
    $('input[name^="config"]').on('input', function() {
        var $input = $(this);
        var max = parseInt($input.data('max')) || 0;
        var value = parseInt($input.val()) || 0;

        if (value > max) {
            $input.addClass('is-invalid');
            $input.val(max);
        } else if (value < 0) {
            $input.addClass('is-invalid');
            $input.val(0);
        } else {
            $input.removeClass('is-invalid');
        }

        // Update totals (if needed)
        updateTotals();
    });

    // Function to update totals
    function updateTotals() {
        // Calculate row totals
        $('tr').each(function() {
            var $row = $(this);
            var total = 0;
            $row.find('input[name^="config"]').each(function() {
                total += parseInt($(this).val()) || 0;
            });
            $row.find('.num_question').text(total);
        });

        // Calculate column totals
        $('.bank_type_1, .bank_type_2, .bank_type_3').each(function() {
            var bankType = $(this).data('bank-type');
            var total = 0;
            $('input.bank_type_' + bankType).each(function() {
                total += parseInt($(this).val()) || 0;
            });
            $('#bank_type_' + bankType + ' .badge').text(total);
        });

        // Calculate grand total
        var grandTotal = 0;
        $('input[name^="config"]').each(function() {
            grandTotal += parseInt($(this).val()) || 0;
        });
        $('#num_question .badge').text(grandTotal);
        $('input[name="num_question"]').val(grandTotal);
    }
});
//]]>
</script>
<!-- END: main -->