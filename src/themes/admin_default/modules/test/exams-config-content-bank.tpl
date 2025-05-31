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
                          method="post" id="frm-exam-bank">
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
                            <tbody class="config-list-bank">
                                <!-- BEGIN: class -->
                                {CONFIG_LIST_BANK}
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
                    <div class="p-3 text-end border-top">
                        <button class="btn btn-success" onclick="add_bank_type(event)">
                            <i class="fas fa-plus me-1"></i>{LANG.add}
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <div class="btn-group" role="group">
                    <button class="btn btn-primary btn-lg px-5 loading" type="button" onclick="frm_exam_bank_submit(event)">
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

    // Enhanced select2 event handling
    $(".config-list-bank").on('select2:select', function (e) {
        var data = e.params.data;
        var class_id = $(e.target).attr("id").split("_");
        $("#" + class_id[1]).find("input[type=text]").attr("data-" + class_id[0] + "-id", data.id);

        // Visual feedback
        $(e.target).addClass('border-success');
        setTimeout(function() {
            $(e.target).removeClass('border-success');
        }, 1500);
    });

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
});
// Enhanced form submission function
window.frm_exam_bank_submit = function(event) {
    event.preventDefault();

    var $btn = $(event.target);
    var originalHtml = $btn.html();

    // Show loading state
    $btn.prop('disabled', true)
        .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

    var config = {};
    var list_config = $(".config-list-bank").find("input[name^=config]");

    for (var i = 0; i < list_config.length; i++) {
        var class_id = $(list_config[i]).attr("data-class-id");
        var cat_id = $(list_config[i]).attr("data-cat-id");
        var type_id = $(list_config[i]).attr("data-bank-type-id");
        var value = $(list_config[i]).val();

        if (class_id != 0 && cat_id != 0 && type_id != 0 && value != 0) {
            if (isEmpty(config[class_id])) config[class_id] = {};
            if (isEmpty(config[class_id][cat_id])) config[class_id][cat_id] = {};
            config[class_id][cat_id][type_id] = value;
        }
    }

    if (isEmpty(config)) {
        $btn.prop('disabled', false).html(originalHtml);
        alert('Vui lòng cấu hình ít nhất một câu hỏi!');
        return false;
    }

    var id = $("input[name=id]").val();
    var title = $("input[name=title]").val();
    var timer = $("input[name=timer]").val();
    var random_question = $("input[name=random_question]").prop("checked");
    var random_answer = $("input[name=random_answer]").prop("checked");

    // Validation
    if (!title.trim()) {
        $btn.prop('disabled', false).html(originalHtml);
        $('#title').addClass('is-invalid').focus();
        alert('Vui lòng nhập tiêu đề!');
        return false;
    }

    if (!timer || timer < 1) {
        $btn.prop('disabled', false).html(originalHtml);
        $('#timer').addClass('is-invalid').focus();
        alert('Vui lòng nhập thời gian hợp lệ!');
        return false;
    }

    // Remove validation classes
    $('.is-invalid').removeClass('is-invalid');

    $.ajax({
        type: 'POST',
        url: $("#frm-exam-bank").attr('action'),
        data: {
            id: id,
            title: title,
            timer: timer,
            random_question: random_question,
            random_answer: random_answer,
            config: config,
            isbank: 1,
            submit: 1
        },
        dataType: 'json',
        success: function(res) {
            if (res.error) {
                $btn.prop('disabled', false).html(originalHtml);
                alert(res.msg);
                if (res.input != '') {
                    $('#' + res.input).addClass('is-invalid').focus();
                }
            } else if (res.redirect != '') {
                window.location.href = res.redirect;
            } else {
                window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-config';
            }
        },
        error: function() {
            $btn.prop('disabled', false).html(originalHtml);
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        }
    });
};
// Enhanced add bank type function
window.add_bank_type = function(event) {
    event.preventDefault();

    var $btn = $(event.target);
    var originalHtml = $btn.html();

    // Show loading state
    $btn.prop('disabled', true)
        .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang thêm...');

    $.ajax({
        type: 'POST',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-config-content-bank&list_template_bank_type=1',
        dataType: "html",
        success: function(res) {
            $("#table-exams-config tbody").append(res);

            // Re-initialize Select2 for new elements
            $('.select2').select2({
                theme: 'bootstrap-5',
                language: '{NV_LANG_INTERFACE}',
                placeholder: 'Chọn...',
                allowClear: true
            });

            $btn.prop('disabled', false).html(originalHtml);

            // Visual feedback
            var $newRow = $("#table-exams-config tbody tr:last");
            $newRow.addClass('table-success');
            setTimeout(function() {
                $newRow.removeClass('table-success');
            }, 2000);
        },
        error: function() {
            $btn.prop('disabled', false).html(originalHtml);
            alert('Có lỗi xảy ra khi thêm loại ngân hàng!');
        }
    });
};

// Enhanced change category function
window.change_cat = function(id, typeid) {
    $.ajax({
        type: 'POST',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-config-content-bank&total_question_bank_type=1',
        dataType: "json",
        data: 'typeid=' + typeid,
        success: function(res) {
            if (isEmpty(res)) return false;

            res.forEach(function(item) {
                $("#not-" + id + "-" + item.bank_type).hide();
                var $input = $("input[name=config-" + id + "-" + item.bank_type + "]");
                $input.show();
                $input.attr('title', '{LANG.tooltip_sllquestion} ' + item.sum);
                $input.attr('data-bs-original-title', '{LANG.tooltip_sllquestion} ' + item.sum);
                $input.data('max', item.sum);

                // Add visual feedback
                $input.addClass('border-info');
                setTimeout(function() {
                    $input.removeClass('border-info');
                }, 1500);
            });
        },
        error: function() {
            console.error('Lỗi khi tải thông tin câu hỏi');
        }
    });
};

//]]>
</script>
<!-- END: main -->