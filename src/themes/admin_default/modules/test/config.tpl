<!-- BEGIN: main -->
<form action="" method="post">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-palette me-2"></i>{LANG.config_template}
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-file-code me-1"></i>{LANG.config_indexfile}
                </label>
                <div class="col-md-8">
                    <select name="indexfile" class="form-select">
                        <!-- BEGIN: indexfile -->
                        <option value="{INDEXFILE.index}"{INDEXFILE.selected}>{INDEXFILE.value}</option>
                        <!-- END: indexfile -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-clipboard-list me-1"></i>{LANG.examp_template}
                </label>
                <div class="col-md-8">
                    <select name="examp_template" class="form-select">
                        <!-- BEGIN: examp_template -->
                        <option value="{EXAMP_TEMPLATE.index}"{EXAMP_TEMPLATE.selected}>{EXAMP_TEMPLATE.value}</option>
                        <!-- END: examp_template -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-expand-arrows-alt me-1"></i>{LANG.exams_image}
                </label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input class="form-control" type="number" value="{DATA.homewidth}" name="homewidth"
                               placeholder="Chiều rộng" min="1" />
                        <span class="input-group-text">×</span>
                        <input class="form-control" type="number" value="{DATA.homeheight}" name="homeheight"
                               placeholder="Chiều cao" min="1" />
                        <span class="input-group-text">px</span>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-home me-1"></i>{LANG.config_showhometext}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="showhometext" value="1"
                               id="showhometext" {DATA.ck_showhometext} />
                        <label class="form-check-label" for="showhometext">
                            {LANG.config_showhometext_note}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-share-alt me-1"></i>{LANG.config_enable_social}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="enable_social" value="1"
                               id="enable_social" {DATA.ck_enable_social} />
                        <label class="form-check-label" for="enable_social">
                            {LANG.config_enable_social_note}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-image me-1"></i>{LANG.config_no_image}
                </label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input class="form-control" type="text" name="no_image" value="{DATA.no_image}"
                               id="id_image" placeholder="Đường dẫn hình ảnh mặc định..." />
                        <button class="btn btn-outline-secondary selectfile" type="button">
                            <i class="fas fa-folder-open"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-link me-1"></i>{LANG.config_st_links}
                </label>
                <div class="col-md-8">
                    <input type="number" name="st_links" value="{DATA.st_links}" class="form-control"
                           min="1" placeholder="Số lượng liên kết..." />
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-list-ol me-1"></i>{LANG.config_per_page}
                </label>
                <div class="col-md-8">
                    <input type="number" name="per_page" value="{DATA.per_page}" class="form-control"
                           min="1" placeholder="Số mục trên mỗi trang..." />
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-align-center me-1"></i>{LANG.config_imgposition}
                </label>
                <div class="col-md-8">
                    <select name="imgposition" class="form-select">
                        <!-- BEGIN: imgposition -->
                        <option value="{IMGPOS.index}"{IMGPOS.selected}>{IMGPOS.value}</option>
                        <!-- END: imgposition -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-sort me-1"></i>{LANG.config_order_exams}
                </label>
                <div class="col-md-8">
                    <select class="form-select" name="order_exams">
                        <!-- BEGIN: order_exams -->
                        <option value="{ORDER_EXAMS.key}"{ORDER_EXAMS.selected}>{ORDER_EXAMS.title}</option>
                        <!-- END: order_exams -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-id-card me-1"></i>{LANG.config_oaid}
                </label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="oaid" value="{DATA.oaid}"
                           placeholder="Open App ID..." />
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-cogs me-2"></i>{LANG.config_system}
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-users me-1"></i>{LANG.config_groups_use}
                </label>
                <div class="col-md-8">
                    <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                        <!-- BEGIN: groups_use -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="groups_use[]"
                                   value="{GROUPS_USE.value}" id="group_use_{GROUPS_USE.value}" {GROUPS_USE.checked} />
                            <label class="form-check-label" for="group_use_{GROUPS_USE.value}">
                                {GROUPS_USE.title}
                            </label>
                        </div>
                        <!-- END: groups_use -->
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-question-circle me-1"></i>{LANG.config_allow_question_type}
                </label>
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-3">
                        <!-- BEGIN: question_type -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allow_question_type[]"
                                   value="{QUESTION_TYPE.index}" id="qtype_{QUESTION_TYPE.index}"
                                   {QUESTION_TYPE.checked} {QUESTION_TYPE.disabled} />
                            <label class="form-check-label" for="qtype_{QUESTION_TYPE.index}">
                                {QUESTION_TYPE.value}
                            </label>
                        </div>
                        <!-- END: question_type -->
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-edit me-1"></i>{LANG.config_enable_editor}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="enable_editor" value="1"
                               id="enable_editor" {DATA.ck_enable_editor} />
                        <label class="form-check-label" for="enable_editor">
                            {LANG.config_enable_editor_note}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-upload me-1"></i>{LANG.config_structure_upload}
                </label>
                <div class="col-md-8">
                    <select name="structure_upload" class="form-select">
                        <!-- BEGIN: structure_upload -->
                        <option value="{STRUCTURE_UPLOAD.key}"{STRUCTURE_UPLOAD.selected}>{STRUCTURE_UPLOAD.title}</option>
                        <!-- END: structure_upload -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-source-branch me-1"></i>{LANG.config_source}
                </label>
                <div class="col-md-8">
                    <select class="form-select" name="config_source">
                        <!-- BEGIN: config_source -->
                        <option value="{CONFIG_SOURCE.key}"{CONFIG_SOURCE.selected}>{CONFIG_SOURCE.title}</option>
                        <!-- END: config_source -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-bell me-1"></i>{LANG.config_alert_type}
                </label>
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-3">
                        <!-- BEGIN: alert_type -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="alert_type"
                                   value="{ALERT_TYPE.index}" id="alert_{ALERT_TYPE.index}" {ALERT_TYPE.checked} />
                            <label class="form-check-label" for="alert_{ALERT_TYPE.index}">
                                {ALERT_TYPE.value}
                            </label>
                        </div>
                        <!-- END: alert_type -->
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-trash-alt me-1"></i>{LANG.config_allow_del_history}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="allow_del_history" value="1"
                               id="allow_del_history" {DATA.ck_allow_del_history} />
                        <label class="form-check-label" for="allow_del_history">
                            Cho phép xóa lịch sử
                        </label>
                    </div>
                </div>
            </div>

            <!-- BEGIN: allow_question_point -->
            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-star me-1"></i>{LANG.config_allow_question_point}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="allow_question_point" value="1"
                               id="allow_question_point" {DATA.ck_allow_question_point} />
                        <label class="form-check-label" for="allow_question_point">
                            Cho phép điểm câu hỏi
                        </label>
                    </div>
                </div>
            </div>
            <!-- END: allow_question_point -->

            <!-- BEGIN: allow_config_history_user_common -->
            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-history me-1"></i>{LANG.config_history_user_common}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="config_history_user_common" value="1"
                               id="config_history_user_common" {DATA.ck_config_history_user_common} />
                        <label class="form-check-label" for="config_history_user_common">
                            Lịch sử người dùng chung
                        </label>
                    </div>
                </div>
            </div>
            <!-- END: allow_config_history_user_common -->

            <!-- BEGIN: payment -->
            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-credit-card me-1"></i>{LANG.config_payment}
                </label>
                <div class="col-md-8">
                    <select class="form-select" name="payment">
                        <option value="">---{LANG.config_payment_select}---</option>
                        <!-- BEGIN: loop -->
                        <option value="{PAYMENT.index}"{PAYMENT.selected}>{PAYMENT.value}</option>
                        <!-- END: loop -->
                    </select>
                </div>
            </div>
            <!-- END: payment -->
        </div>
    </div>
    <div class="card shadow-sm mb-4" id="top-content-exam">
        <div class="card-header bg-warning text-dark">
            <h5 class="card-title mb-0">
                <i class="fas fa-trophy me-2"></i>{LANG.top_content_exam}
            </h5>
        </div>
        <div class="card-body">
            <div class="border rounded p-3 bg-light">
                {top_content_exam}
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-tags me-2"></i>{LANG.keywords}
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-text-lowercase me-1"></i>{LANG.tags_alias_lower}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" value="1" name="tags_alias_lower"
                               id="tags_alias_lower" {DATA.ck_tags_alias_lower} />
                        <label class="form-check-label" for="tags_alias_lower">
                            {LANG.tags_alias_lower_note}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-link me-1"></i>{LANG.tags_alias}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" value="1" name="tags_alias"
                               id="tags_alias" {DATA.ck_tags_alias} />
                        <label class="form-check-label" for="tags_alias">
                            {LANG.tags_alias_note}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-magic me-1"></i>{LANG.auto_tags}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" value="1" name="auto_tags"
                               id="auto_tags" {DATA.ck_auto_tags} />
                        <label class="form-check-label" for="auto_tags">
                            {LANG.auto_tags_note}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label fw-bold">
                    <i class="fas fa-bell me-1"></i>{LANG.tags_remind}
                </label>
                <div class="col-md-8">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" value="1" name="tags_remind"
                               id="tags_remind" {DATA.ck_tags_remind} />
                        <label class="form-check-label" for="tags_remind">
                            {LANG.tags_remind_note}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <button type="submit" class="btn btn-primary btn-lg px-5" name="savesetting">
            <i class="fas fa-save me-2"></i>{LANG.save}
        </button>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
    // Enhanced file selection
    $(".selectfile").click(function() {
        var area = "id_image";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var currentpath = "{DATA.no_image_currentpath}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
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

    // Enhanced switch toggles with visual feedback
    $('.form-check-input[type="checkbox"]').on('change', function() {
        var $switch = $(this);
        var $card = $switch.closest('.card');

        // Add visual feedback
        $card.addClass('border-primary');
        setTimeout(function() {
            $card.removeClass('border-primary');
        }, 1000);
    });

    // Enhanced number inputs validation
    $('input[type="number"]').on('input', function() {
        var $input = $(this);
        var value = parseInt($input.val());
        var min = parseInt($input.attr('min')) || 1;

        if (value < min) {
            $input.addClass('is-invalid');
        } else {
            $input.removeClass('is-invalid');
        }
    });

    // Enhanced hash navigation
    var hash = window.location.hash.substring(1);
    if (hash == 'top-content-exam') {
        $('html, body').animate({
            scrollTop: $('#top-content-exam').offset().top - 20
        }, 1000);
    }

    // Initialize tooltips if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>
<!-- END: main -->
