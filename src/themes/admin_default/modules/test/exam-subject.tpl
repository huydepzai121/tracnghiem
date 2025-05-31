<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css">
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery/jquery.timepicker.min.css" rel="stylesheet" />

<div class="alert alert-primary text-center mb-4">
    <h3 class="mb-2">
        <i class="fas fa-graduation-cap me-2"></i>
        <strong>{LANG.examinations}: {EXAMINATION.title}</strong>
    </h3>
    <h4 class="mb-0 text-muted">
        <i class="fas fa-clock me-2"></i>{TIME}
    </h4>
</div>

<!-- BEGIN: msg_error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{msg_error}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: msg_error -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-list-alt me-2"></i>Danh sách môn thi
        </h5>
    </div>
    <div class="card-body p-0">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="">
                        <tr>
                            <th style="width: 50px;" class="text-center">TT</th>
                            <th>
                                <i class="fas fa-book me-1"></i>{LANG.examinations_subject}
                            </th>
                            <th style="width: 120px;" class="text-center">
                                <i class="fas fa-clipboard-list me-1"></i>{LANG.exam_type}
                            </th>
                            <th style="width: 80px;" class="text-center">
                                <i class="fas fa-layer-group me-1"></i>{LANG.ladder}
                            </th>
                            <th style="width: 80px;" class="text-center">
                                <i class="fas fa-clock me-1"></i>{LANG.timer}
                            </th>
                            <th style="width: 100px;" class="text-center">
                                <i class="fas fa-question-circle me-1"></i>{LANG.num_question}
                            </th>
                            <th style="width: 120px;" class="text-center">
                                <i class="fas fa-barcode me-1"></i>{LANG.exams_code}
                            </th>
                            <th style="width: 200px;" class="text-center">
                                <i class="fas fa-cogs me-1"></i>Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: loop -->
                        <tr class="subject-row" data-id="{VIEW.id}">
                            <td rowspan="2" class="text-center fw-bold text-primary">
                                <span class="badge bg-primary fs-6">{VIEW.tt}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="{VIEW.link}" target="_blank" class="fw-bold text-decoration-none mb-1">
                                        <i class="fas fa-external-link-alt me-1"></i>{VIEW.title}
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{VIEW.examp_type_title}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{VIEW.ladder}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">{VIEW.timer} phút</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">{VIEW.num_question}</span>
                            </td>
                            <td class="text-center" id="code_{VIEW.id}">
                                <code class="bg-light p-1 rounded">{VIEW.code}</code>
                            </td>
                            <td rowspan="2" class="text-center">
                                <div class="btn-group-vertical btn-group-sm" role="group">
                                    <a href="{VIEW.link_random_subject}" class="btn btn-outline-primary"
                                       title="{VIEW.random_subject_title}">
                                        <i class="fas fa-plus me-1"></i>
                                        <span class="badge bg-danger ms-1">{VIEW.num_subject}</span>
                                    </a>
                                    {VIEW.feature}
                                    <!-- BEGIN: create_code -->
                                    <button type="button" class="btn btn-success btn-sm"
                                            onclick="create_code({VIEW.exam_id},{VIEW.id},'{VIEW.create_checkss}')">
                                        <i class="fas fa-code me-1"></i>{LANG.create_code}
                                    </button>
                                    <!-- END: create_code -->
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="bg-light">
                                <div class="d-flex flex-wrap gap-3 small text-muted">
                                    <span>
                                        <i class="fas fa-clock me-1"></i>{VIEW.from_to}
                                    </span>
                                    <span>
                                        <i class="fas fa-chart-bar me-1"></i>
                                        <a href="{VIEW.link_report}" class="text-decoration-none">
                                            {LANG.exams_report}
                                        </a>
                                    </span>
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
<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{ERROR}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i>{status_save}
        </h5>
    </div>
    <div class="card-body">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&amp;exam_id={EXAMINATION.id}" method="post">
            <input type="hidden" name="id" value="{ROW.id}" />
            <input type="hidden" name="exam_id" value="{EXAMINATION.id}" />

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-book me-1"></i>{LANG.examinations_subject}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="title" value="{ROW.title}"
                           required="required" placeholder="Nhập tên môn thi..." />
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-link me-1"></i>{LANG.alias}
                </label>
                <div class="col-md-9">
                    <div class="input-group">
                        <input class="form-control" type="text" name="alias" value="{ROW.alias}"
                               id="id_alias" placeholder="Tự động tạo từ tiêu đề..." />
                        <button class="btn btn-outline-secondary" type="button" onclick="nv_get_alias('id_alias');">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-clipboard-list me-1"></i>{LANG.exam_type}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <select class="form-select" name="exam_type">
                        <option value="random_exam" {selected_random_exam}>{LANG.random_exam}</option>
                        <option value="random_question" {selected_random_question}>{LANG.random_question}</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-image me-1"></i>{LANG.image}
                </label>
                <div class="col-md-9">
                    <div class="input-group">
                        <input class="form-control" type="text" name="image" value="{ROW.image}"
                               id="id_image" placeholder="Chọn hình ảnh..." />
                        <button class="btn btn-outline-secondary selectfile" type="button">
                            <i class="fas fa-folder-open"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mb-4" id="begintime">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-clock me-1"></i>{LANG.exams_time}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-success">
                                        <i class="fas fa-play me-1"></i>{LANG.exams_begin_time}
                                    </label>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <input class="form-control datepicker"  required="required" value="{ROW.begindate}" type="text" name="begindate" placeholder="dd/mm/YYYY" autocomplete="off" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">
                                                <em class="fa fa-calendar fa-fix">&nbsp;</em>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <input class="form-control timepicker"  required="required" type="text" name="begintime" value="{ROW.begintime}" placeholder="H:i" autocomplete="off" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">
                                                <em class="fa fa-clock-o fa-fix"> </em>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-24 col-sm-12">
                            <strong>{LANG.exams_end_time}</strong>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <input class="form-control datepicker" required="required" value="{ROW.enddate}" type="text" name="enddate" placeholder="dd/mm/YYYY" autocomplete="off" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">
                                                <em class="fa fa-calendar fa-fix">&nbsp;</em>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <input class="form-control timepicker"  required="required" type="text" name="endtime" value="{ROW.endtime}" placeholder="H:i" autocomplete="off" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">
                                                <em class="fa fa-clock-o fa-fix"> </em>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-layer-group me-1"></i>{LANG.ladder}
                </label>
                <div class="col-md-9">
                    <input type="number" name="ladder" class="form-control" id="ladder"
                           value="{ROW.ladder}" maxlength="4" min="0" required="required"
                           placeholder="Nhập thứ tự ưu tiên..." />
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-stopwatch me-1"></i>{LANG.timer} ({LANG.min})
                </label>
                <div class="col-md-9">
                    <div class="input-group">
                        <input type="number" name="timer" id="timer" class="form-control"
                               value="{ROW.timer}" maxlength="4" min="1" required="required"
                               placeholder="Thời gian làm bài..." />
                        <span class="input-group-text">phút</span>
                    </div>
                </div>
            </div>

            <div class="row mb-3" id="num_question" {ROW.style_num_question}>
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-question-circle me-1"></i>{LANG.num_question}
                </label>
                <div class="col-md-9">
                    <div class="input-group">
                        <input type="number" name="num_question" class="form-control"
                               value="{ROW.num_question}" maxlength="4" min="0"
                               placeholder="Số câu hỏi..." />
                        <span class="input-group-text">câu</span>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-align-left me-1"></i>{LANG.description}
                </label>
                <div class="col-md-9">
                    <textarea class="form-control" rows="4" name="description"
                              placeholder="Nhập mô tả cho môn thi...">{ROW.description}</textarea>
                </div>
            </div>

            <div class="text-center">
                <button class="btn btn-success btn-lg px-5 loading" name="submit" type="submit">
                    <i class="fas fa-save me-2"></i>{LANG.save}
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery/jquery.timepicker.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced file selection
    $(".selectfile").click(function() {
        var area = "id_image";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var currentpath = "{CURENTPATH}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable
                + "=upload&popup=1&area=" + area + "&path="
                + path + "&type=" + type + "&currentpath="
                + currentpath, "NVImg", 850, 420,
                "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    // Enhanced timepicker with better styling
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 30,
        minTime: '06:00',
        maxTime: '23:59',
        defaultTime: 'value',
        startTime: '06:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    // Enhanced datepicker with better styling
    $(".datepicker").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: "focus",
        yearRange: "-90:+10",
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.addClass('shadow-lg border-0');
            }, 0);
        }
    });

    // Enhanced form submission with loading state
    $('form').on('submit', function() {
        var $btn = $(this).find('button[type="submit"]');
        var originalText = $btn.html();

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

        // Allow form to submit normally
        return true;
    });

    // Enhanced alias generation
    $("[name='title']").on('input', function() {
        var title = $(this).val();
        if (title.length > 2) {
            clearTimeout(window.aliasTimeout);
            window.aliasTimeout = setTimeout(function() {
                nv_get_alias('id_alias');
            }, 1000);
        }
    });

    // Enhanced alias generation function
    window.nv_get_alias = function(id) {
        var title = strip_tags($("[name='title']").val());
        if (title != '') {
            var $input = $("#" + id);
            var $btn = $input.next().find('button');
            var originalIcon = $btn.html();

            // Show loading state
            $btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=examinations-content&nocache=' + new Date().getTime(), 'get_alias_title=' + encodeURIComponent(title),
                function(res) {
                    $input.val(strip_tags(res));
                    $btn.html(originalIcon).prop('disabled', false);

                    // Visual feedback
                    $input.addClass('border-success');
                    setTimeout(function() {
                        $input.removeClass('border-success');
                    }, 2000);
                });
        }
        return false;
    };

    // Enhanced create code function with better UX
    window.create_code = function(exam_id, id, create_checkss) {
        if (confirm('{LANG.confirm_create_code}')) {
            var $codeElement = $("#code_" + id);
            var originalContent = $codeElement.html();

            // Show loading state
            $codeElement.html('<i class="fas fa-spinner fa-spin"></i> Đang tạo mã...');

            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exam-subject&exam_id=' + exam_id + '&create_code=1&create_checkss=' + create_checkss,
                data: 'id=' + id,
                dataType: 'json',
                success: function(res) {
                    $codeElement.html('<code class="bg-success text-white p-1 rounded">' + res + '</code>');

                    // Visual feedback
                    $codeElement.addClass('border border-success rounded p-2');
                    setTimeout(function() {
                        $codeElement.removeClass('border border-success rounded p-2');
                    }, 3000);
                },
                error: function() {
                    $codeElement.html(originalContent);
                    alert('Có lỗi xảy ra khi tạo mã đề thi!');
                }
            });
        }
    };

    // Date and time validation
    $('.datepicker, .timepicker').on('change', function() {
        validateDateTime();
    });

    function validateDateTime() {
        var beginDate = $('input[name="begindate"]').val();
        var beginTime = $('input[name="begintime"]').val();
        var endDate = $('input[name="enddate"]').val();
        var endTime = $('input[name="endtime"]').val();

        if (beginDate && beginTime && endDate && endTime) {
            var beginDateTime = new Date(beginDate.split('/').reverse().join('-') + ' ' + beginTime);
            var endDateTime = new Date(endDate.split('/').reverse().join('-') + ' ' + endTime);

            if (beginDateTime >= endDateTime) {
                $('.timepicker, .datepicker').addClass('is-invalid');
                alert('Thời gian kết thúc phải sau thời gian bắt đầu!');
            } else {
                $('.timepicker, .datepicker').removeClass('is-invalid');
            }
        }
    }

    // Initialize tooltips if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
//]]>
</script>
<!-- END: main -->