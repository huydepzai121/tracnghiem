<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="card-title mb-0">
                <i class="fas fa-chart-line me-2"></i>Thống kê bài thi
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;" class="text-center">
                            <i class="fas fa-hashtag me-1"></i>{LANG.number}
                        </th>
                        <th>
                            <i class="fas fa-user me-1"></i>{LANG.userid}
                        </th>
                        <th>
                            <i class="fas fa-file-alt me-1"></i>{LANG.examid}
                        </th>
                        <th style="width: 180px;" class="text-center">
                            <i class="fas fa-clock me-1"></i>{LANG.delete_time}
                        </th>
                        <th style="width: 120px;" class="text-center">
                            <i class="fas fa-cogs me-1"></i>{LANG.actions}
                        </th>
                    </tr>
                </thead>
                <!-- BEGIN: generate_page -->
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="5">
                            <div class="d-flex justify-content-center">
                                {NV_GENERATE_PAGE}
                            </div>
                        </td>
                    </tr>
                </tfoot>
                <!-- END: generate_page -->
                <tbody>
                    <!-- BEGIN: loop -->
                    <tr {VIEW.red}>
                        <td class="text-center">
                            <span class="badge bg-secondary">{VIEW.number}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-primary">{VIEW.user}</div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 300px;" title="{VIEW.title}">
                                {VIEW.title}
                            </div>
                        </td>
                        <td class="text-center">
                            <small class="text-muted">{VIEW.delete_time}</small>
                        </td>
                        <td class="text-center">
                            <!-- BEGIN: delete -->
                            <a href="{VIEW.link_delete}" class="btn btn-outline-danger btn-sm"
                               onclick="return confirm(nv_is_del_confirm[0]);" title="{LANG.delete}">
                                <i class="fas fa-trash me-1"></i>{LANG.delete}
                            </a>
                            <!-- END: delete -->
                        </td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="alert alert-info mt-4" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Thông tin:</strong> {STATUS_SL}
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced table interactions
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Enhanced delete confirmation
    $('a[onclick*="confirm"]').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var $btn = $(this);

        // Custom confirmation modal
        if (confirm('Bạn có chắc chắn muốn xóa bản ghi này?')) {
            // Show loading state
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang xóa...');

            // Navigate to delete URL
            window.location.href = href;
        }
    });

    // Enhanced button hover effects
    $('.btn').on('mouseenter', function() {
        $(this).addClass('shadow-sm');
    }).on('mouseleave', function() {
        $(this).removeClass('shadow-sm');
    });

    // Initialize Bootstrap tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Enhanced row highlighting for special cases
    $('tr[class*="red"], tr[style*="color"]').addClass('table-danger');

    // Add visual feedback for empty table
    if ($('.table tbody tr').length === 0) {
        $('.table tbody').append(
            '<tr><td colspan="5" class="text-center text-muted py-4">' +
            '<i class="fas fa-inbox fa-2x mb-2"></i><br>' +
            'Không có dữ liệu để hiển thị' +
            '</td></tr>'
        );
    }
});
//]]>
</script>
<!-- END: main -->