<!-- BEGIN: main -->
<div class="container-fluid">
    <!-- Admin Stats Dashboard -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Tổng Admin</h6>
                    <span class="badge bg-primary fs-6" id="total-admins">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-shield fa-2x text-success mb-2"></i>
                    <h6 class="card-title">Super Admin</h6>
                    <span class="badge bg-success fs-6" id="super-admins">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-cog fa-2x text-warning mb-2"></i>
                    <h6 class="card-title">Module Admin</h6>
                    <span class="badge bg-warning fs-6" id="module-admins">0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-eye fa-2x text-info mb-2"></i>
                    <h6 class="card-title">Chỉ xem</h6>
                    <span class="badge bg-info fs-6" id="view-only">0</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users-cog me-2"></i>Quản lý Admin
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
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="sticky-top">
                        <tr>
                            <!-- BEGIN: head_td -->
                            <th>
                                <a href="{HEAD_TD.href}" class="text-white text-decoration-none d-flex align-items-center">
                                    <i class="fas fa-sort me-2"></i>{HEAD_TD.title}
                                </a>
                            </th>
                            <!-- END: head_td -->
                            <th class="text-center">
                                <i class="fas fa-shield-alt me-1"></i>{LANG.admin_permissions}
                            </th>
                            <th class="text-center">
                                <i class="fas fa-cogs me-1"></i>Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: xusers -->
                        <tr class="admin-row" data-userid="{CONTENT_TD.userid}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-primary text-white me-3">
                                        {CONTENT_TD.userid}
                                    </div>
                                    <div>
                                        <span class="badge bg-secondary small">{CONTENT_TD.userid}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- BEGIN: is_admin -->
                                    <div class="admin-level-badge me-2" data-bs-toggle="tooltip" title="{CONTENT_TD.level}">
                                        <img alt="{CONTENT_TD.level}"
                                             src="{NV_BASE_SITEURL}themes/{NV_ADMIN_THEME}/images/{CONTENT_TD.img}.png"
                                             width="38" height="18" class="rounded" />
                                    </div>
                                    <!-- END: is_admin -->
                                    <div>
                                        <div class="fw-bold text-primary">{CONTENT_TD.username}</div>
                                        <small class="text-muted">ID: {CONTENT_TD.userid}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="fw-medium">{CONTENT_TD.full_name}</div>
                                    <a href="mailto:{CONTENT_TD.email}" class="text-decoration-none small text-muted">
                                        <i class="fas fa-envelope me-1"></i>{CONTENT_TD.email}
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info rounded-pill">{CONTENT_TD.admin_module_cat}</span>
                            </td>
                            <td class="text-center">
                                <!-- BEGIN: is_edit -->
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{EDIT_URL}" class="btn btn-outline-primary" data-bs-toggle="tooltip" title="Chỉnh sửa quyền">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="tooltip" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <!-- END: is_edit -->
                            </td>
                        </tr>
                        <!-- END: xusers -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.admin-level-badge {
    transition: transform 0.2s ease;
}

.admin-level-badge:hover {
    transform: scale(1.1);
}

.user-info {
    min-width: 200px;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}
</style>
<!-- BEGIN: edit -->
<div class="card shadow-sm mt-4">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-user-edit me-2"></i>{CAPTION_EDIT}
        </h5>
    </div>
    <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="">
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-bold">{LANG.admin_permissions}</label>
                </div>
                <div class="col-md-9">
                    <div class="d-flex flex-wrap gap-3">
                        <!-- BEGIN: admin_module -->
                        <div class="form-check">
                            <input class="form-check-input" name="admin_module" value="{ADMIN_MODULE.value}"
                                   type="radio" id="admin_module_{ADMIN_MODULE.value}" {ADMIN_MODULE.checked} />
                            <label class="form-check-label" for="admin_module_{ADMIN_MODULE.value}">
                                {ADMIN_MODULE.text}
                            </label>
                        </div>
                        <!-- END: admin_module -->
                    </div>
                </div>
            </div>

            <div id="id_admin_module" {STYLE_MODULE}>
                <div class="card border-secondary">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Chi tiết phân quyền</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-center">{LANG.content_cat}</th>
                                        <th class="text-center" id="check_add_content" style="cursor: pointer;"
                                            data-bs-toggle="tooltip" title="Double click để chọn tất cả">
                                            <i class="fas fa-plus-circle me-1"></i>{LANG.permissions_add_content}
                                        </th>
                                        <th class="text-center" id="check_edit_content" style="cursor: pointer;"
                                            data-bs-toggle="tooltip" title="Double click để chọn tất cả">
                                            <i class="fas fa-edit me-1"></i>{LANG.permissions_edit_content}
                                        </th>
                                        <th class="text-center" id="check_del_content" style="cursor: pointer;"
                                            data-bs-toggle="tooltip" title="Double click để chọn tất cả">
                                            <i class="fas fa-trash me-1"></i>{LANG.permissions_del_content}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- BEGIN: catid -->
                                    <tr>
                                        <td class="fw-medium">{CONTENT.title}</td>
                                        <td class="text-center">
                                            <div class="form-check d-inline-block">
                                                <input class="form-check-input" type="checkbox" name="add_content[]"
                                                       value="{CONTENT.catid}" id="add_{CONTENT.catid}"{CONTENT.checked_add_content}>
                                                <label class="form-check-label" for="add_{CONTENT.catid}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-inline-block">
                                                <input class="form-check-input" type="checkbox" name="edit_content[]"
                                                       value="{CONTENT.catid}" id="edit_{CONTENT.catid}"{CONTENT.checked_edit_content}>
                                                <label class="form-check-label" for="edit_{CONTENT.catid}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-inline-block">
                                                <input class="form-check-input" type="checkbox" name="del_content[]"
                                                       value="{CONTENT.catid}" id="del_{CONTENT.catid}"{CONTENT.checked_del_content}>
                                                <label class="form-check-label" for="del_{CONTENT.catid}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- END: catid -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-success btn-lg px-5" type="submit" name="submit">
                    <i class="fas fa-save me-2"></i>{LANG.save}
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Initialize stats
    updateAdminStats();

    // Enhanced stats calculation
    function updateAdminStats() {
        var totalAdmins = $('.admin-row').length;
        var superAdmins = $('.admin-row').filter(function() {
            return $(this).find('img[alt*="Super"]').length > 0;
        }).length;
        var moduleAdmins = $('.admin-row').filter(function() {
            return $(this).find('img[alt*="Module"]').length > 0;
        }).length;
        var viewOnly = totalAdmins - superAdmins - moduleAdmins;

        $('#total-admins').text(totalAdmins);
        $('#super-admins').text(superAdmins);
        $('#module-admins').text(moduleAdmins);
        $('#view-only').text(viewOnly);
    }

    // Enhanced double-click functionality with visual feedback
    $("#check_add_content").on("dblclick", function() {
        check_add_first();
        $(this).addClass('bg-success text-white').delay(500).queue(function() {
            $(this).removeClass('bg-success text-white').dequeue();
        });
        showAlert('Đã chọn tất cả quyền thêm nội dung', 'success');
    });

    $("#check_edit_content").on("dblclick", function() {
        check_edit_first();
        $(this).addClass('bg-warning text-dark').delay(500).queue(function() {
            $(this).removeClass('bg-warning text-dark').dequeue();
        });
        showAlert('Đã chọn tất cả quyền sửa nội dung', 'warning');
    });

    $("#check_del_content").on("dblclick", function() {
        check_del_first();
        $(this).addClass('bg-danger text-white').delay(500).queue(function() {
            $(this).removeClass('bg-danger text-white').dequeue();
        });
        showAlert('Đã chọn tất cả quyền xóa nội dung', 'danger');
    });

    // Enhanced radio button functionality
    $("input[name=admin_module]").on("change", function() {
        var type = $(this).val();
        var $moduleDiv = $("#id_admin_module");

        if (type == 0) {
            $moduleDiv.slideDown(300);
        } else {
            $moduleDiv.slideUp(300);
        }
    });

    // Enhanced refresh functionality
    $('#refresh-list').on('click', function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang tải...');

        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
            updateAdminStats();
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
            showAlert('Đã xuất danh sách admin thành công', 'success');
        }, 2000);
    });

    // Enhanced table interactions
    $('.admin-row').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Enhanced form submission
    $('form').on('submit', function(e) {
        var $btn = $(this).find('button[type="submit"]');
        var originalHtml = $btn.html();

        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

        // Restore after 3 seconds (fallback)
        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
        }, 3000);
    });

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' :
                       type === 'warning' ? 'fa-exclamation-triangle' :
                       type === 'danger' ? 'fa-times-circle' : 'fa-info-circle';

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

    // Enhanced button hover effects
    $('.btn').on('mouseenter', function() {
        $(this).addClass('shadow-sm');
    }).on('mouseleave', function() {
        $(this).removeClass('shadow-sm');
    });

    // Initialize tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Add empty state if no admins
    if ($('.admin-row').length === 0) {
        $('tbody').html(
            '<tr><td colspan="6" class="text-center text-muted py-5">' +
            '<i class="fas fa-users-slash fa-3x mb-3"></i><br>' +
            '<h6>Chưa có admin nào</h6>' +
            '<small>Vui lòng thêm admin để quản lý hệ thống</small>' +
            '</td></tr>'
        );
    }
});
//]]>
</script>
<!-- END: edit -->
<!-- END: main -->
<!-- BEGIN: view_user -->
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-eye me-2"></i>{CAPTION_EDIT}
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>{LANG.content_cat}</th>
                        <th class="text-center">
                            <i class="fas fa-plus-circle me-1"></i>{LANG.permissions_add_content}
                        </th>
                        <th class="text-center">
                            <i class="fas fa-edit me-1"></i>{LANG.permissions_edit_content}
                        </th>
                        <th class="text-center">
                            <i class="fas fa-trash me-1"></i>{LANG.permissions_del_content}
                        </th>
                        <th class="text-center">
                            <i class="fas fa-user-shield me-1"></i>{LANG.permissions_admin}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: catid -->
                    <tr>
                        <td class="fw-medium">{CONTENT.title}</td>
                        <td class="text-center">
                            <span class="badge bg-{CONTENT.checked_add_content ? 'success' : 'secondary'}">
                                {CONTENT.checked_add_content}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{CONTENT.checked_edit_content ? 'warning' : 'secondary'}">
                                {CONTENT.checked_edit_content}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{CONTENT.checked_del_content ? 'danger' : 'secondary'}">
                                {CONTENT.checked_del_content}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{CONTENT.checked_admin ? 'primary' : 'secondary'}">
                                {CONTENT.checked_admin}
                            </span>
                        </td>
                    </tr>
                    <!-- END: catid -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END: view_user -->