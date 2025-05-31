<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<!-- BEGIN: examinations_title -->
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{LANG.not_update_examinations}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: examinations_title -->

<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{ERROR}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white py-3">
        <h3 class="card-title mb-0 fw-bold">
            <i class="fas fa-edit me-3"></i>THÔNG TIN KỲ THI
        </h3>
    </div>
    <div class="card-body">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <input type="hidden" name="id" value="{ROW.id}" />

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-heading me-1"></i>{LANG.title}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="title" value="{ROW.title}"
                           required="required" placeholder="Nhập tiêu đề kỳ thi..." />
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
                    <i class="fas fa-calendar-plus me-1"></i>{LANG.begintime}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <div class="input-group">
                        <input name="begintime" id="begintime" title="{LANG.begintime}" class="form-control"
                               value="{ROW.begintime}" maxlength="10" type="text" autocomplete="off"
                               placeholder="{LANG.begintime}" required="required" />
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-calendar-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-calendar-minus me-1"></i>{LANG.endtime}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <div class="input-group">
                        <input name="endtime" id="endtime" title="{LANG.endtime}" class="form-control"
                               value="{ROW.endtime}" maxlength="10" type="text" autocomplete="off"
                               placeholder="{LANG.endtime}" required="required" />
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-calendar-alt"></i>
                        </button>
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
                               id="id_image" placeholder="Chọn hình ảnh..." />
                        <button class="btn btn-outline-secondary selectfile" type="button">
                            <i class="fas fa-folder-open"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-align-left me-1"></i>{LANG.description}
                </label>
                <div class="col-md-9">
                    <textarea class="form-control" rows="4" name="description"
                              placeholder="Nhập mô tả cho kỳ thi...">{ROW.description}</textarea>
                </div>
            </div>

            <div class="text-center">
                <button class="btn btn-primary btn-lg px-5" name="submit" type="submit">
                    <i class="fas fa-save me-2"></i>{LANG.save}
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[
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
        $("#begintime").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: !0,
            changeYear: !0,
            showOtherMonths: !0,
            showOn: "focus",
            yearRange: "-90:+0",
        });
        $("#endtime").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: !0,
            changeYear: !0,
            showOtherMonths: !0,
            showOn: "focus",
            yearRange: "-90:+0"
        });
        $("[name='title']").change(function() {
            nv_get_alias('id_alias');
        });
        function nv_get_alias(id) {
            var title = strip_tags($("[name='title']").val());
            if (title != '') {
                $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                    '=examinations-content&nocache=' + new Date().getTime(), 'get_alias_title=' + encodeURIComponent(title),
                    function(res) {
                        $("#" + id).val(strip_tags(res));
                    });
            }
            return false;
        }
    //]]>
</script>
<!-- END: main -->