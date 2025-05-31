<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-search me-2"></i>Tìm kiếm thẻ tag
            </h5>
        </div>
        <div class="card-body">
            <form action="{NV_BASE_ADMINURL}index.php" method="get" onsubmit="return nv_search_tag();">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">
                            <i class="fas fa-search me-1"></i>Từ khóa tìm kiếm
                        </label>
                        <input class="form-control" type="text" value="{Q}" name="q" id="q"
                               maxlength="64" placeholder="{LANG.search_title}" />
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="fas fa-search me-1"></i>{LANG.search_submit}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- BEGIN: incomplete_link -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        <a class="text-decoration-none" href="{ALL_LINK}">{LANG.tags_all_link}</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <!-- END: incomplete_link -->

    <div id="module_show_list" class="mb-4">{TAGS_LIST}</div>

    <!-- BEGIN: error -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Cảnh báo:</strong> {ERROR}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <!-- END: error -->

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-plus-circle me-2"></i>Thêm/Sửa thẻ tag
            </h5>
        </div>
        <div class="card-body">
            <form action="{NV_BASE_ADMINURL}index.php" method="post">
                <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
                <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
                <input type="hidden" name="tid" value="{tid}" />
                <input name="savecat" type="hidden" value="1" />
                <!-- BEGIN: incomplete -->
                <input name="incomplete" type="hidden" value="1" />
                <!-- END: incomplete -->

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-tag me-1"></i>{LANG.alias} <span class="text-danger">*</span>
                    </label>
                    <input class="form-control" name="alias" id="idalias" type="text" value="{alias}"
                           maxlength="250" required placeholder="Nhập tên thẻ tag..." />
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        {GLANG.length_characters}: <span id="aliaslength" class="text-danger fw-bold">0</span>.
                        {GLANG.title_suggest_max}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-key me-1"></i>{LANG.keywords}
                    </label>
                    <input class="form-control" name="keywords" type="text" value="{keywords}"
                           maxlength="255" placeholder="Nhập từ khóa liên quan..." />
                    <div class="form-text">Các từ khóa giúp tìm kiếm thẻ tag dễ dàng hơn</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-align-left me-1"></i>{LANG.description}
                    </label>
                    <textarea class="form-control" id="description" name="description" rows="5"
                              placeholder="Nhập mô tả cho thẻ tag...">{description}</textarea>
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        {GLANG.length_characters}: <span id="descriptionlength" class="text-danger fw-bold">0</span>.
                        {GLANG.description_suggest_max}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-image me-1"></i>{LANG.image}
                    </label>
                    <div class="input-group">
                        <input class="form-control" type="text" name="image" value="{image}" id="image"
                               placeholder="Chọn hình ảnh đại diện..." />
                        <button class="btn btn-outline-secondary selectfile" type="button">
                            <i class="fas fa-folder-open me-1"></i>Chọn file
                        </button>
                    </div>
                    <div class="form-text">Chọn hình ảnh đại diện cho thẻ tag (định dạng: JPG, PNG, GIF)</div>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary btn-lg px-4 loading" name="submit1" type="submit">
                        <i class="fas fa-save me-2"></i>{LANG.save}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    var CFG = [];

    // Enhanced character counting for alias
    function updateAliasLength() {
        var length = $("#idalias").val().length;
        var $counter = $("#aliaslength");
        $counter.html(length);

        // Color coding based on length
        if (length === 0) {
            $counter.removeClass('text-success text-warning').addClass('text-danger');
        } else if (length < 50) {
            $counter.removeClass('text-danger text-warning').addClass('text-success');
        } else if (length < 200) {
            $counter.removeClass('text-danger text-success').addClass('text-warning');
        } else {
            $counter.removeClass('text-success text-warning').addClass('text-danger');
        }
    }

    // Enhanced character counting for description
    function updateDescriptionLength() {
        var length = $("#description").val().length;
        var $counter = $("#descriptionlength");
        $counter.html(length);

        // Color coding based on length
        if (length === 0) {
            $counter.removeClass('text-success text-warning').addClass('text-danger');
        } else if (length < 100) {
            $counter.removeClass('text-danger text-warning').addClass('text-success');
        } else if (length < 300) {
            $counter.removeClass('text-danger text-success').addClass('text-warning');
        } else {
            $counter.removeClass('text-success text-warning').addClass('text-danger');
        }
    }

    // Initialize character counters
    updateAliasLength();
    updateDescriptionLength();

    // Bind events for real-time counting
    $("#idalias").on("input keyup paste", updateAliasLength);
    $("#description").on("input keyup paste", updateDescriptionLength);

    // Enhanced file selection
    $(".selectfile").on('click', function() {
        var area = "image";
        var path = "{UPLOAD_PATH}";
        var currentpath = "{UPLOAD_CURRENT}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    // Enhanced form validation
    $('form').on('submit', function(e) {
        var alias = $('#idalias').val().trim();

        if (alias === '') {
            e.preventDefault();
            $('#idalias').addClass('is-invalid').focus();
            showAlert('Vui lòng nhập tên thẻ tag!', 'danger');
            return false;
        }

        // Show loading state
        var $btn = $(this).find('button[type="submit"]');
        var originalHtml = $btn.html();
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

        // Restore after 3 seconds (fallback)
        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
        }, 3000);
    });

    // Enhanced search function
    function nv_search_tag() {
        var q = $('#q').val().trim();
        if (q === '') {
            $('#q').addClass('is-invalid').focus();
            showAlert('Vui lòng nhập từ khóa tìm kiếm!', 'warning');
            return false;
        }

        // Show loading state for search
        var $btn = $('form[onsubmit*="nv_search_tag"] button[type="submit"]');
        var originalHtml = $btn.html();
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang tìm...');

        return true;
    }

    // Enhanced input validation
    $('#idalias').on('blur', function() {
        var value = $(this).val().trim();
        if (value === '') {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });

    $('#q').on('input', function() {
        var value = $(this).val().trim();
        if (value.length > 0) {
            $(this).removeClass('is-invalid').addClass('border-success');
        } else {
            $(this).removeClass('border-success is-invalid');
        }
    });

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' :
                       type === 'warning' ? 'fa-exclamation-triangle' : 'fa-times-circle';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" ' +
                       'style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">' +
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
        $(this).addClass('shadow-sm');
    }).on('mouseleave', function() {
        $(this).removeClass('shadow-sm');
    });

    // Make function globally available
    window.nv_search_tag = nv_search_tag;
});
//]]>
</script>
<!-- END: main -->