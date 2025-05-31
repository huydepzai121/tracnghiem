<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/colpick.css">

<div class="mb-4" id="module_show_list">{BLOCK_GROUPS_LIST}</div>

<a id="edit"></a>

<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{ERROR}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>{LANG.groups_info}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{NV_BASE_ADMINURL}index.php" method="post">
                        <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
                        <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
                        <input type="hidden" name="bid" value="{ROW.bid}" />
                        <input name="savecat" type="hidden" value="1" />

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-bold">
                                <i class="fas fa-heading me-1"></i>{LANG.title}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" name="title" id="idtitle" type="text"
                                       value="{ROW.title}" maxlength="255" required
                                       placeholder="Nhập tên nhóm..." />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-bold">
                                <i class="fas fa-link me-1"></i>{LANG.alias}
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="alias" value="{ROW.alias}"
                                           id="id_alias" placeholder="Đường dẫn tĩnh..." />
                                    <button class="btn btn-outline-secondary" type="button" onclick="nv_get_alias('id_alias');">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-bold">
                                <i class="fas fa-tags me-1"></i>{LANG.keywords}
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" name="keywords" type="text" value="{ROW.keywords}"
                                       maxlength="255" placeholder="Từ khóa SEO..." />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-bold">
                                <i class="fas fa-file-alt me-1"></i>{LANG.description}
                            </label>
                            <div class="col-md-9">
                                <div class="card border-light">
                                    <div class="card-body p-2">
                                        {ROW.description}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-bold">
                                <i class="fas fa-image me-1"></i>{LANG.image}
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="image" value="{ROW.image}"
                                           id="id_image" placeholder="Đường dẫn hình ảnh..." />
                                    <button class="btn btn-outline-secondary selectfile" type="button">
                                        <i class="fas fa-folder-open"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-primary btn-lg px-5" name="submit1" type="submit">
                                <i class="fas fa-save me-2"></i>{LANG.save}
                            </button>
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
    // Enhanced file selection
    $(".selectfile").click(function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin"></i>');

        var area = "id_image";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var currentpath = "{CURRENTPATH}";
        var type = "image";

        nv_open_browse(
            script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath,
            "NVImg",
            850,
            420,
            "resizable=no,scrollbars=no,toolbar=no,location=no,status=no"
        );

        // Restore button after 2 seconds
        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
        }, 2000);

        return false;
    });

    // Enhanced alias generation
    window.nv_get_alias = function(id) {
        var title = strip_tags($("[name='title']").val());
        if (title != '') {
            var $input = $("#" + id);
            var $btn = $input.next().find('button');
            var originalHtml = $btn.html();

            // Show loading state
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i>');

            $.post(
                script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=groups&nocache=' + new Date().getTime(),
                'get_alias_title=' + encodeURIComponent(title),
                function(res) {
                    $input.val(strip_tags(res));

                    // Visual feedback
                    $input.addClass('border-success');
                    setTimeout(function() {
                        $input.removeClass('border-success');
                    }, 2000);

                    $btn.prop('disabled', false).html(originalHtml);
                }
            ).fail(function() {
                $btn.prop('disabled', false).html(originalHtml);
                alert('Có lỗi xảy ra khi tạo alias!');
            });
        } else {
            alert('Vui lòng nhập tiêu đề trước!');
        }
        return false;
    };

    // Enhanced form validation
    $('form').on('submit', function(e) {
        var title = $('[name="title"]').val().trim();

        if (!title) {
            e.preventDefault();
            $('[name="title"]').addClass('is-invalid').focus();
            alert('Vui lòng nhập tên nhóm!');
            return false;
        }

        // Remove validation classes
        $('.is-invalid').removeClass('is-invalid');

        // Show loading state on submit button
        var $btn = $(this).find('button[type="submit"]');
        var originalHtml = $btn.html();
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');
    });
});
//]]>
</script>

<!-- BEGIN: auto_get_alias -->
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    $("[name='title']").on('input', function() {
        var title = $(this).val().trim();
        if (title.length > 2) {
            // Auto-generate alias after user stops typing for 1 second
            clearTimeout(window.aliasTimeout);
            window.aliasTimeout = setTimeout(function() {
                nv_get_alias('id_alias');
            }, 1000);
        }
    });
});
//]]>
</script>
<!-- END: auto_get_alias -->
<!-- END: main -->