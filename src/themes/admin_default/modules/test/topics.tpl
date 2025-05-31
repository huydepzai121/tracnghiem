<!-- BEGIN: main -->
<div class="container-fluid">
    <div id="module_show_list" class="mb-4">{TOPIC_LIST}</div>

    <a id="edit"></a>
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
                <i class="fas fa-plus-circle me-2"></i>{LANG.add_topic}
            </h5>
        </div>
        <div class="card-body">
            <form action="{NV_BASE_ADMINURL}index.php" method="post">
                <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
                <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
                <input type="hidden" name="topicid" value="{DATA.topicid}" />
                <input name="savecat" type="hidden" value="1" />

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-tag me-1"></i>{LANG.title} <span class="text-danger">*</span>
                    </label>
                    <input class="form-control" name="title" id="idtitle" type="text" value="{DATA.title}"
                           maxlength="255" required placeholder="Nhập tiêu đề chủ đề..." />
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-link me-1"></i>{LANG.alias}
                    </label>
                    <div class="input-group">
                        <input class="form-control" name="alias" id="idalias" type="text" value="{DATA.alias}"
                               maxlength="255" placeholder="Đường dẫn tĩnh (tự động tạo)" />
                        <button class="btn btn-outline-secondary" type="button" onclick="nv_get_alias('idalias');">
                            <i class="fas fa-sync-alt me-1"></i>Tạo lại
                        </button>
                    </div>
                    <div class="form-text">Đường dẫn tĩnh sẽ được tạo tự động từ tiêu đề</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-image me-1"></i>{LANG.image}
                    </label>
                    <div class="input-group">
                        <input class="form-control" type="text" name="homeimg" value="{DATA.image}"
                               id="homeimg" placeholder="Chọn hình ảnh đại diện..." />
                        <button id="select-img-topic" class="btn btn-outline-secondary selectfile"
                                type="button" name="selectimg">
                            <i class="fas fa-folder-open me-1"></i>Chọn file
                        </button>
                    </div>
                    <div class="form-text">Chọn hình ảnh đại diện cho chủ đề (định dạng: JPG, PNG, GIF)</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-key me-1"></i>{LANG.keywords}
                    </label>
                    <input class="form-control" name="keywords" type="text" value="{DATA.keywords}"
                           maxlength="255" placeholder="Nhập từ khóa SEO..." />
                    <div class="form-text">Các từ khóa giúp tối ưu SEO cho chủ đề</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-align-left me-1"></i>{LANG.description}
                    </label>
                    <textarea class="form-control" name="description" rows="5"
                              placeholder="Nhập mô tả cho chủ đề...">{DATA.description}</textarea>
                    <div class="form-text">Mô tả ngắn gọn về nội dung chủ đề</div>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary btn-lg px-4" name="submit1" type="submit">
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
    CFG.upload_dir = '{UPLOADS_DIR}';

    // Enhanced alias generation function
    function nv_get_alias(id) {
        var title = strip_tags($("[name='title']").val());
        var $input = $("#" + id);
        var $btn = $('button[onclick*="nv_get_alias"]');

        if (title != '') {
            // Show loading state
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang tạo...');

            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=topics&nocache=' + new Date().getTime(),
                   'get_alias_title=' + encodeURIComponent(title) + '&id={DATA.topicid}',
                   function(res) {
                $input.val(strip_tags(res));
                $input.addClass('border-success');
                showAlert('Đã tạo đường dẫn tĩnh thành công!', 'success');

                // Remove success border after 2 seconds
                setTimeout(function() {
                    $input.removeClass('border-success');
                }, 2000);
            }).always(function() {
                // Restore button
                $btn.prop('disabled', false)
                    .html('<i class="fas fa-sync-alt me-1"></i>Tạo lại');
            });
        } else {
            showAlert('Vui lòng nhập tiêu đề trước!', 'warning');
            $('#idtitle').focus();
        }
        return false;
    }

    // Enhanced file selection
    $(".selectfile").on('click', function() {
        var area = "homeimg";
        var path = CFG.upload_dir;
        var currentpath = "";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    // Enhanced form validation
    $('form').on('submit', function(e) {
        var title = $('#idtitle').val().trim();

        if (title === '') {
            e.preventDefault();
            $('#idtitle').addClass('is-invalid').focus();
            showAlert('Vui lòng nhập tiêu đề chủ đề!', 'danger');
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

    // Enhanced input validation
    $('#idtitle').on('blur', function() {
        var value = $(this).val().trim();
        if (value === '') {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });

    $('#idtitle').on('input', function() {
        var value = $(this).val().trim();
        if (value.length > 0) {
            $(this).removeClass('is-invalid');
        }
    });

    // Auto-generate alias when title changes
    <!-- BEGIN: getalias -->
    $("#idtitle").on('change', function() {
        var alias = $('#idalias').val().trim();
        if (alias === '' || confirm('Bạn có muốn tạo lại đường dẫn tĩnh từ tiêu đề mới?')) {
            nv_get_alias('idalias');
        }
    });
    <!-- END: getalias -->

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
    window.nv_get_alias = nv_get_alias;
});
//]]>
</script>
<!-- END: main -->