<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{ERROR}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->

<!-- BEGIN: view -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-search me-2"></i>Tìm kiếm danh mục ngân hàng câu hỏi
        </h5>
    </div>
    <div class="card-body">
        <form action="{NV_BASE_ADMINURL}index.php" method="get">
            <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input class="form-control" type="text" value="{Q}" name="q"
                               maxlength="255" placeholder="{LANG.search_title}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-search me-1"></i>{LANG.search_submit}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- BEGIN: nav_cat -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <!-- BEGIN: loop -->
        <li class="breadcrumb-item">
            <a href="{CAT.link}" class="text-decoration-none">
                <i class="fas fa-folder me-1"></i>{CAT.title}
            </a>
        </li>
        <!-- END: loop -->
    </ol>
</nav>
<!-- END: nav_cat -->

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-folder-tree me-2"></i>Danh sách danh mục ngân hàng câu hỏi
        </h5>
    </div>
    <div class="card-body p-0">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="">
                        <tr>
                            <th style="width: 120px;">
                                <i class="fas fa-sort me-1"></i>{LANG.weight}
                            </th>
                            <th>
                                <i class="fas fa-folder me-1"></i>{LANG.title}
                            </th>
                            <th>
                                <i class="fas fa-sticky-note me-1"></i>{LANG.note}
                            </th>
                            <th style="width: 100px;" class="text-center">
                                <i class="fas fa-toggle-on me-1"></i>{LANG.active}
                            </th>
                            <th style="width: 150px;" class="text-center">
                                <i class="fas fa-cogs me-1"></i>Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: loop -->
                        <tr class="category-row" data-id="{VIEW.id}">
                            <td>
                                <select class="form-select form-select-sm" id="id_weight_{VIEW.id}"
                                        onchange="nv_change_weight('{VIEW.id}');">
                                    <!-- BEGIN: weight_loop -->
                                    <option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
                                    <!-- END: weight_loop -->
                                </select>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-folder text-warning me-2"></i>
                                    <div>
                                        <a href="{VIEW.link}" class="fw-bold text-decoration-none">
                                            {VIEW.title}
                                        </a>
                                        <span class="badge bg-danger ms-2">
                                            <i class="fas fa-layer-group me-1"></i>{VIEW.have_num_cat_childrent}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{VIEW.note}</span>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" name="status"
                                           id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK}
                                           onclick="nv_change_status({VIEW.id});" />
                                    <label class="form-check-label" for="change_status_{VIEW.id}"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{VIEW.link_edit}#edit" class="btn btn-outline-primary"
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{VIEW.link_delete}" class="btn btn-outline-danger"
                                       onclick="return confirm(nv_is_del_confirm[0]);" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- END: loop -->
                        <!-- BEGIN: cat_other -->
                        <tr class="table-info">
                            <td>
                                <select class="form-select form-select-sm" disabled>
                                    <option>{num_items}</option>
                                </select>
                            </td>
                            <td colspan="4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-folder-open text-info me-2"></i>
                                    <div>
                                        <a href="{link_other}" class="fw-bold text-decoration-none">
                                            {LANG.cat_other}
                                        </a>
                                        <span class="badge bg-info ms-2">
                                            <i class="fas fa-question-circle me-1"></i>{have_num_exams_0}
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!-- END: cat_other -->
                    </tbody>
                    <!-- BEGIN: generate_page -->
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-center bg-light py-3">
                                {NV_GENERATE_PAGE}
                            </td>
                        </tr>
                    </tfoot>
                    <!-- END: generate_page -->
                </table>
            </div>
        </form>
    </div>
</div>
<!-- END: view -->


<div class="card shadow-sm mt-4">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus-circle me-2"></i>Thêm/Sửa danh mục ngân hàng câu hỏi
        </h5>
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
                           required="required" placeholder="Nhập tên danh mục..."
                           oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-sitemap me-1"></i>{LANG.bank_parent}
                </label>
                <div class="col-md-9">
                    <select class="form-select" name="parentid">
                        <option value="0" selected="selected">--- {LANG.cat_main} ---</option>
                        <!-- BEGIN: parent -->
                        <option value="{pid}" {pselect}>{ptitle}</option>
                        <!-- END: parent -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-tags me-1"></i>{LANG.keywords}
                </label>
                <div class="col-md-9">
                    <div class="mb-2">
                        <div id="list-keyworks" class="d-flex flex-wrap gap-2">
                            <!-- BEGIN: keywords -->
                            <span class="badge bg-primary keyword-tag" data-value="{keyword}"
                                  style="cursor: pointer;" title="Click để xóa">
                                {keyword} <i class="fas fa-times ms-1"></i>
                            </span>
                            <!-- END: keywords -->
                        </div>
                        <input type="hidden" name="keywords" value="{keywords}" />
                    </div>
                    <div class="input-group">
                        <input class="form-control" type="text" name="input-keyword" value=""
                               placeholder="Nhập từ khóa và nhấn Enter hoặc dấu phẩy..." />
                        <span class="input-group-text">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Nhấn Enter hoặc dấu phẩy (,) để thêm từ khóa. Click vào tag để xóa.
                    </small>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-sticky-note me-1"></i>{LANG.note}
                </label>
                <div class="col-md-9">
                    <textarea class="form-control" name="note" rows="3"
                              placeholder="Nhập ghi chú cho danh mục...">{ROW.note}</textarea>
                </div>
            </div>

            <div class="text-center">
                <button class="btn btn-success btn-lg px-5" name="submit" type="submit">
                    <i class="fas fa-save me-2"></i>{LANG.save}
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[
var keyword_bankcat = [];
//]]>
</script>
<!-- BEGIN: push_keyword -->
<script type="text/javascript">
//<![CDATA[
keyword_bankcat.push('{keyword}');
//]]>
</script>
<!-- END: push_keyword -->

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced keyword management
    function export_chips_html() {
        var chips_html = '';
        keyword_bankcat.forEach(function(keyword) {
            chips_html += '<span class="badge bg-primary keyword-tag" data-value="' + keyword + '" ' +
                         'style="cursor: pointer;" title="Click để xóa">' +
                         keyword + ' <i class="fas fa-times ms-1"></i></span>';
        });
        return chips_html;
    }

    // Enhanced keyword input with better UX
    $("input[name=input-keyword]").on('keypress', function(ev) {
        var keycode = (ev.keyCode ? ev.keyCode : ev.which);
        if ((keycode == 13) || (keycode == 44)) {
            ev.preventDefault();
            var keyword = $(this).val().trim();

            if (keyword && !keyword_bankcat.includes(keyword)) {
                keyword_bankcat.push(keyword);
                var chips_html = export_chips_html();
                $("#list-keyworks").html(chips_html);

                // Visual feedback
                $(this).addClass('border-success');
                setTimeout(() => {
                    $(this).removeClass('border-success');
                }, 1000);
            } else if (keyword_bankcat.includes(keyword)) {
                // Show warning for duplicate
                $(this).addClass('border-warning');
                setTimeout(() => {
                    $(this).removeClass('border-warning');
                }, 1000);
            }

            $(this).val('');
            $("input[name=keywords]").val(keyword_bankcat.join(','));
        }
    });

    // Enhanced keyword removal with animation
    $("#list-keyworks").on('click', '.keyword-tag', function(e) {
        var $tag = $(this);
        var keyword = $tag.data('value');

        // Animation before removal
        $tag.addClass('bg-danger').fadeOut(300, function() {
            keyword_bankcat.splice(keyword_bankcat.indexOf(keyword), 1);
            var chips_html = export_chips_html();
            $("#list-keyworks").html(chips_html);
            $("input[name=keywords]").val(keyword_bankcat.join(','));
        });
    });

    // Enhanced weight change with better UX
    window.nv_change_weight = function(id) {
        var $select = $('#id_weight_' + id);
        var $row = $select.closest('.category-row');
        var new_vid = $select.val();

        // Add loading state
        $select.prop('disabled', true);
        $row.addClass('table-info');

        var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);

        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams_bank_cats&nocache=' + new Date().getTime(),
               'ajax_action=1&id=' + id + '&new_vid=' + new_vid,
               function(res) {
                   var r_split = res.split('_');
                   if (r_split[0] != 'OK') {
                       alert(nv_is_change_act_confirm[2]);
                       $row.addClass('table-danger');
                   } else {
                       $row.addClass('table-success');
                   }

                   $select.prop('disabled', false);

                   // Remove loading state after delay
                   setTimeout(function() {
                       $row.removeClass('table-info table-success table-danger');
                       window.location.href = window.location.href;
                   }, 1500);
               });
    };

    // Enhanced status change with better UX
    window.nv_change_status = function(id) {
        var $checkbox = $('#change_status_' + id);
        var $row = $checkbox.closest('.category-row');
        var new_status = $checkbox.is(':checked');

        if (confirm(nv_is_change_act_confirm[0])) {
            // Add loading state
            $checkbox.prop('disabled', true);
            $row.addClass('table-info');

            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);

            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams_bank_cats&nocache=' + new Date().getTime(),
                   'change_status=1&id=' + id,
                   function(res) {
                       var r_split = res.split('_');
                       if (r_split[0] != 'OK') {
                           alert(nv_is_change_act_confirm[2]);
                           $checkbox.prop('checked', !new_status);
                           $row.addClass('table-danger');
                       } else {
                           $row.addClass('table-success');
                       }

                       $checkbox.prop('disabled', false);

                       // Remove loading state after delay
                       setTimeout(function() {
                           $row.removeClass('table-info table-success table-danger');
                       }, 1500);
                   });
        } else {
            $checkbox.prop('checked', !new_status);
        }
    };

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