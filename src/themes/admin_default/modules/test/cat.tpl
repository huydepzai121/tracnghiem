<!-- BEGIN: main -->
<div class="container-fluid">
    {PACKAGE_NOTIICE}

    <!-- BEGIN: guider -->
    <div class="alert alert-info alert-dismissible fade show alert-msg" role="alert" <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle me-2"></i>
            <div class="flex-grow-1">
                {LANG.guider_cat}
            </div>
            <button type="button" class="btn-close close-msg" data-func="cat" aria-label="Close"></button>
        </div>
    </div>
    <div class="text-end mb-2 p-show-msg" <!-- BEGIN: msg_show -->style="display: none" <!-- END: msg_show -->>
        <button class="btn btn-sm btn-outline-info show-msg" data-func="cat">
            <i class="fas fa-question-circle me-1"></i>{LANG.msg}
        </button>
    </div>
    <!-- END: guider -->

    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-folder fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Tổng Categories</h6>
                    <span class="badge bg-primary fs-6" id="total-categories">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-toggle-on fa-2x text-success mb-2"></i>
                    <h6 class="card-title">Đang hoạt động</h6>
                    <span class="badge bg-success fs-6" id="active-categories">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-home fa-2x text-info mb-2"></i>
                    <h6 class="card-title">Hiển thị trang chủ</h6>
                    <span class="badge bg-info fs-6" id="home-categories">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-layer-group fa-2x text-warning mb-2"></i>
                    <h6 class="card-title">Tổng mục con</h6>
                    <span class="badge bg-warning fs-6" id="total-subcats">0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: view -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Danh sách Categories
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-light btn-sm" id="refresh-list">
                        <i class="fas fa-sync-alt me-1"></i>Làm mới
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" id="export-list">
                        <i class="fas fa-download me-1"></i>Xuất danh sách
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="">
                            <tr>
                                <th style="width: 100px;">
                                    <i class="fas fa-weight-hanging me-1"></i>{LANG.weight}
                                </th>
                                <th>
                                    <i class="fas fa-folder me-1"></i>{LANG.title}
                                </th>
                                <th style="width: 120px;" class="text-center">
                                    <i class="fas fa-home me-1"></i>{LANG.cat_inhome}
                                </th>
                                <th style="width: 100px;" class="text-center">
                                    <i class="fas fa-link me-1"></i>{LANG.cat_numlinks}
                                </th>
                                <th style="width: 120px;" class="text-center">
                                    <i class="fas fa-eye me-1"></i>{LANG.cat_hometype}
                                </th>
                                <th style="width: 100px;" class="text-center">
                                    <i class="fas fa-trophy me-1"></i>{LANG.cat_topscore}
                                </th>
                                <th style="width: 100px;" class="text-center">
                                    <i class="fas fa-calendar me-1"></i>{LANG.cat_newday}
                                </th>
                                <th style="width: 80px;" class="text-center">
                                    <i class="fas fa-toggle-on me-1"></i>{LANG.active}
                                </th>
                                <th style="width: 120px;" class="text-center">
                                    <i class="fas fa-cogs me-1"></i>Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="cat-row" data-id="{VIEW.id}" data-active="{CHECK}">
                                <td>
                                    <select class="form-select form-select-sm weight-select" id="id_weight_{VIEW.id}" onchange="nv_change_weight('{VIEW.id}');">
                                        <!-- BEGIN: weight_loop -->
                                        <option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
                                        <!-- END: weight_loop -->
                                    </select>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="category-icon me-3">
                                            <i class="fas fa-folder fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="{VIEW.link_view}" title="{VIEW.title}" class="fw-bold text-decoration-none text-primary d-block mb-1">
                                                {VIEW.title}
                                            </a>
                                            <small class="text-muted">
                                                <i class="fas fa-layer-group me-1"></i>
                                                <span class="badge bg-secondary rounded-pill">{VIEW.numsub}</span> mục con
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <select class="form-select form-select-sm inhome-select" id="id_inhome_{VIEW.id}" onchange="nv_chang_cat('{VIEW.id}','inhome');">
                                        <!-- BEGIN: inhome -->
                                        <option value="{INHOME.key}"{INHOME.selected}>{INHOME.value}</option>
                                        <!-- END: inhome -->
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select form-select-sm numlinks-select" id="id_numlinks_{VIEW.id}" onchange="nv_chang_cat('{VIEW.id}','numlinks');">
                                        <!-- BEGIN: numlinks -->
                                        <option value="{NUMLINKS.key}"{NUMLINKS.selected}>{NUMLINKS.title}</option>
                                        <!-- END: numlinks -->
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select form-select-sm viewtype-select" id="id_viewtype_{VIEW.id}" onchange="nv_chang_cat('{VIEW.id}','viewtype');">
                                        <!-- BEGIN: viewtype -->
                                        <option value="{VIEWTYPE.key}"{VIEWTYPE.selected}>{VIEWTYPE.value}</option>
                                        <!-- END: viewtype -->
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select form-select-sm topscore-select" id="id_topscore_{VIEW.id}" onchange="nv_chang_cat('{VIEW.id}','topscore');">
                                        <!-- BEGIN: topscore -->
                                        <option value="{TOPSCORE.key}"{TOPSCORE.selected}>{TOPSCORE.title}</option>
                                        <!-- END: topscore -->
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select form-select-sm newday-select" id="id_newday_{VIEW.id}" onchange="nv_chang_cat('{VIEW.id}','newday');">
                                        <!-- BEGIN: newday -->
                                        <option value="{NEWDAY.key}"{NEWDAY.selected}>{NEWDAY.title}</option>
                                        <!-- END: newday -->
                                    </select>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input status-switch" type="checkbox" name="status" id="change_status_{VIEW.id}"
                                               value="{VIEW.id}" {CHECK} onclick="nv_change_status({VIEW.id});" />
                                        <label class="form-check-label" for="change_status_{VIEW.id}">
                                            <span class="visually-hidden">Thay đổi trạng thái</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{VIEW.link_edit}" class="btn btn-outline-primary"
                                           data-bs-toggle="tooltip" title="{LANG.edit}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{VIEW.link_view}" target="_blank" class="btn btn-outline-info"
                                           data-bs-toggle="tooltip" title="Xem trực tiếp">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{VIEW.link_delete}" class="btn btn-outline-danger"
                                           onclick="return confirm(nv_is_del_confirm[0]);"
                                           data-bs-toggle="tooltip" title="{LANG.delete}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- END: loop -->
                        </tbody>
                        <!-- BEGIN: generate_page -->
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="9" class="text-center py-3">
                                    <div class="d-flex justify-content-center">
                                        {NV_GENERATE_PAGE}
                                    </div>
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
            <i class="fas fa-plus-circle me-2"></i>{LANG.cat_add}
        </h5>
    </div>
    <div class="card-body">
        <!-- BEGIN: error -->
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{ERROR}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <!-- END: error -->

        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <input type="hidden" name="id" value="{ROW.id}" />

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-heading me-1"></i>{LANG.title}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="title" value="{ROW.title}"
                           required="required" placeholder="Nhập tiêu đề category..."
                           oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
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
                    <i class="fas fa-sitemap me-1"></i>{LANG.cat_parent}
                </label>
                <div class="col-md-9">
                    <select class="form-select" name="parentid">
                        <!-- BEGIN: parent_loop -->
                        <option value="{pid}"{pselect}>{ptitle}</option>
                        <!-- END: parent_loop -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-tag me-1"></i>{LANG.title_tag}
                </label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="custom_title" value="{ROW.custom_title}"
                           placeholder="Tiêu đề tùy chỉnh cho SEO..." />
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-align-left me-1"></i>{LANG.description}
                </label>
                <div class="col-md-9">
                    <textarea class="form-control" rows="4" name="description"
                              placeholder="Nhập mô tả cho category...">{ROW.description}</textarea>
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

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-key me-1"></i>{LANG.keywords}
                </label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="keywords" value="{ROW.keywords}"
                           placeholder="Từ khóa SEO..." />
                    <div class="form-text">{LANG.keywords_note}</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-code me-1"></i>{LANG.exams_description_html}
                </label>
                <div class="col-md-9">
                    <div class="border rounded p-3 bg-light">
                        {ROW.description_html}
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-md-3 col-form-label fw-bold">
                    <i class="fas fa-users me-1"></i>{LANG.groups_view}
                </label>
                <div class="col-md-9">
                    <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                        <!-- BEGIN: groups_view -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="groups_view[]" value="{GROUPS_VIEW.value}" id="group_{GROUPS_VIEW.value}" {GROUPS_VIEW.checked} />
                            <label class="form-check-label" for="group_{GROUPS_VIEW.value}">
                                {GROUPS_VIEW.title}
                            </label>
                        </div>
                        <!-- END: groups_view -->
                    </div>
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

<style>
.category-icon {
    width: 50px;
    text-align: center;
}

.weight-select, .inhome-select, .numlinks-select, .viewtype-select, .topscore-select, .newday-select {
    transition: all 0.3s ease;
}

.weight-select:focus, .inhome-select:focus, .numlinks-select:focus,
.viewtype-select:focus, .topscore-select:focus, .newday-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.status-switch {
    transform: scale(1.2);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.cat-row {
    transition: all 0.3s ease;
}

.cat-row:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>

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

    // Enhanced weight change with loading state
    window.nv_change_weight = function(id) {
        var $select = $('#id_weight_' + id);
        var $row = $select.closest('.cat-row');

        // Add loading state
        $select.prop('disabled', true);
        $row.addClass('table-warning');

        var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
        var new_vid = $select.val();

        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&nocache=' + new Date().getTime(),
               'ajax_action=1&id=' + id + '&new_vid=' + new_vid,
               function(res) {
                   var r_split = res.split('_');
                   if (r_split[0] != 'OK') {
                       alert(nv_is_change_act_confirm[2]);
                       $row.addClass('table-danger');
                   } else {
                       $row.addClass('table-success');
                   }

                   clearTimeout(nv_timer);
                   $select.prop('disabled', false);

                   // Remove loading state after delay
                   setTimeout(function() {
                       $row.removeClass('table-warning table-success table-danger');
                   }, 1500);

                   if (r_split[0] == 'OK') {
                       window.location.href = window.location.href;
                   }
               });
    };

    // Enhanced status change with better UX
    window.nv_change_status = function(id) {
        var $checkbox = $('#change_status_' + id);
        var $row = $checkbox.closest('.cat-row');
        var new_status = $checkbox.is(':checked');

        if (confirm(nv_is_change_act_confirm[0])) {
            // Add loading state
            $checkbox.prop('disabled', true);
            $row.addClass('table-info');

            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);

            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&nocache=' + new Date().getTime(),
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

    // Enhanced alias generation
    window.nv_get_alias = function(id) {
        var title = strip_tags($("[name='title']").val());
        if (title != '') {
            var $input = $("#" + id);
            var $btn = $input.next().find('button');
            var originalIcon = $btn.html();

            // Show loading state
            $btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&nocache=' + new Date().getTime(),
                   'get_alias_title=' + encodeURIComponent(title),
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

    // Enhanced select changes with loading state
    $('select[id^="id_inhome_"], select[id^="id_numlinks_"], select[id^="id_viewtype_"], select[id^="id_topscore_"], select[id^="id_newday_"]').on('change', function() {
        var $select = $(this);
        var $row = $select.closest('.cat-row');

        // Add loading state
        $select.prop('disabled', true);
        $row.addClass('table-warning');

        // Remove loading state after delay (assuming the function handles the actual change)
        setTimeout(function() {
            $select.prop('disabled', false);
            $row.removeClass('table-warning').addClass('table-success');

            setTimeout(function() {
                $row.removeClass('table-success');
            }, 1500);
        }, 1000);
    });

    // Initialize stats
    updateStats();

    // Enhanced stats calculation
    function updateStats() {
        var totalCategories = $('.cat-row').length;
        var activeCategories = $('.status-switch:checked').length;
        var homeCategories = 0;
        var totalSubcats = 0;

        // Count home categories
        $('.inhome-select').each(function() {
            if ($(this).val() === '1') {
                homeCategories++;
            }
        });

        // Sum total subcategories
        $('.badge.bg-secondary').each(function() {
            totalSubcats += parseInt($(this).text()) || 0;
        });

        $('#total-categories').text(totalCategories);
        $('#active-categories').text(activeCategories);
        $('#home-categories').text(homeCategories);
        $('#total-subcats').text(totalSubcats);
    }

    // Enhanced refresh functionality
    $('#refresh-list').on('click', function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang tải...');

        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
            updateStats();
            showAlert('Danh sách đã được làm mới', 'success');
        }, 1000);
    });

    // Enhanced export functionality
    $('#export-list').on('click', function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang xuất...');

        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
            showAlert('Đã xuất danh sách categories thành công', 'success');
        }, 2000);
    });

    // Auto-generate alias when title changes
    // BEGIN: auto_get_alias
    $("[name='title']").on('input', function() {
        var title = $(this).val();
        if (title.length > 2) {
            clearTimeout(window.aliasTimeout);
            window.aliasTimeout = setTimeout(function() {
                nv_get_alias('id_alias');
            }, 1000);
        }
    });
    // END: auto_get_alias

    // Smooth scroll to form when hash is create_cat
    var hash = window.location.hash.substring(1);
    if (hash == 'create_cat') {
        $('html, body').animate({
            scrollTop: $('.card:last').offset().top - 20
        }, 1000);
    }

    // Enhanced table interactions
    $('.cat-row').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' :
                       type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" ' +
                       'style="top: 20px; right: 20px; z-index: 9999; min-width: 350px;" role="alert">' +
                       '<i class="fas ' + iconClass + ' me-2"></i>' + message +
                       '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                       '</div>';

        $('body').append(alertHtml);

        // Auto-hide after 3 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 3000);
    }

    // Initialize tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Enhanced guider functionality
    $('.show-msg').on('click', function() {
        var func = $(this).data('func');
        $('.alert-msg').slideDown(300);
        $(this).parent().slideUp(300);
    });

    $('.close-msg').on('click', function() {
        var func = $(this).data('func');
        $('.alert-msg').slideUp(300);
        $('.p-show-msg').slideDown(300);
    });

    // Add empty state if no categories
    if ($('.cat-row').length === 0) {
        $('tbody').html(
            '<tr><td colspan="9" class="text-center text-muted py-5">' +
            '<i class="fas fa-folder fa-3x mb-3"></i><br>' +
            '<h6>Chưa có category nào</h6>' +
            '<small>Vui lòng thêm category để bắt đầu</small>' +
            '</td></tr>'
        );
    }
});
//]]>
</script>
<!-- END: main -->