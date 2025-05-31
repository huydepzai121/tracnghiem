<!-- BEGIN: main -->
{PACKAGE_NOTIICE}
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{ERROR}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>{LANG.exams_info}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" id="frm-submit">
                        <input type="hidden" name="id" value="{ROW.id}" />
                        <input type="hidden" name="submit" value="1" />

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-heading me-1"></i>{LANG.exams_title}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="title" id="title"
                                       value="{ROW.title}" required placeholder="Nhập tiêu đề câu hỏi..." />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-link me-1"></i>{LANG.alias}
                            </label>
                            <div class="col-md-8">
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
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-folder me-1"></i>{LANG.cat}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-8">
                                <select name="catid" id="catid" class="form-select select2" required>
                                    <option value="0">--- {LANG.exams_bank_cats_select} ---</option>
                                    <!-- BEGIN: bank_cats -->
                                    <option value="{CAT.id}" {selected}>{CAT.title_level}</option>
                                    <!-- END: bank_cats -->
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-align-left me-1"></i>{LANG.exams_hometext}
                            </label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="hometext" id="hometext"
                                          maxlength="255" rows="3"
                                          placeholder="Nhập mô tả ngắn...">{ROW.hometext}</textarea>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>Tối đa 255 ký tự
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-file-alt me-1"></i>{LANG.exams_description}
                            </label>
                            <div class="col-md-8">
                                <div class="border rounded p-3 bg-light">
                                    {ROW.description}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-success btn-lg px-4" type="submit">
                                        <i class="fas fa-save me-2"></i>{LANG.save}
                                    </button>
                                    <a class="btn btn-secondary btn-lg px-4" href="javascript:history.back()">
                                        <i class="fas fa-times me-2"></i>{LANG.cancel}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/notify.min.js"></script>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
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
                '=exams-content&nocache=' + new Date().getTime(), 'get_alias_title=' + encodeURIComponent(title),
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

    // Enhanced form submission with loading state
    $('#frm-submit').on('submit', function() {
        var $btn = $(this).find('button[type="submit"]');
        var originalText = $btn.html();

        // Validate required fields
        var title = $('input[name="title"]').val().trim();
        var catid = $('select[name="catid"]').val();

        if (!title) {
            $('input[name="title"]').addClass('is-invalid').focus();
            return false;
        }

        if (!catid || catid == '0') {
            $('select[name="catid"]').addClass('is-invalid').focus();
            return false;
        }

        // Remove validation classes
        $('.is-invalid').removeClass('is-invalid');

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

        // Allow form to submit normally
        return true;
    });

    // Enhanced auto alias generation
    $("[name='title']").on('input', function() {
        var title = $(this).val();
        if (title.length > 2) {
            clearTimeout(window.aliasTimeout);
            window.aliasTimeout = setTimeout(function() {
                nv_get_alias('id_alias');
            }, 1000);
        }
    });

    // Character counter for hometext
    $('#hometext').on('input', function() {
        var current = $(this).val().length;
        var max = $(this).attr('maxlength');
        var $counter = $(this).siblings('.form-text');

        if (current > max * 0.8) {
            $counter.removeClass('text-muted').addClass('text-warning');
        } else {
            $counter.removeClass('text-warning').addClass('text-muted');
        }

        $counter.html('<i class="fas fa-info-circle me-1"></i>Đã nhập ' + current + '/' + max + ' ký tự');
    });

    // Enhanced select2 styling if available
    if (typeof $.fn.select2 !== 'undefined') {
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: '--- Chọn danh mục ---',
            allowClear: false
        });
    }

    // Form validation styling
    $('input[required], select[required]').on('blur', function() {
        var $this = $(this);
        if (!$this.val() || ($this.is('select') && $this.val() == '0')) {
            $this.addClass('is-invalid');
        } else {
            $this.removeClass('is-invalid').addClass('is-valid');
        }
    });

    // Initialize tooltips if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});

<!-- BEGIN: auto_get_alias -->
// Auto generate alias when title changes
$("[name='title']").change(function() {
    nv_get_alias('id_alias');
});
<!-- END: auto_get_alias -->
//]]>
</script>
<!-- END: main -->