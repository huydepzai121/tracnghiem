<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="card-title mb-0">
                <i class="fas fa-sync-alt me-2"></i>Cập nhật danh mục ngân hàng câu hỏi
            </h5>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <button class="btn btn-primary btn-lg px-4" onclick="update_cat()">
                    <i class="fas fa-save me-2"></i>{LANG.save}
                </button>
            </div>

            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Hướng dẫn:</strong> Nhấn nút "Lưu" để bắt đầu quá trình cập nhật danh mục ngân hàng câu hỏi.
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4" id="result-card" style="display: none;">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-chart-bar me-2"></i>{LANG.update_result}
            </h5>
        </div>
        <div class="card-body p-0">
            <div id="result-update"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced update function
    function update_cat() {
        var $btn = $('button[onclick*="update_cat"]');
        var originalHtml = $btn.html();

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật...');

        // Hide result card initially
        $('#result-card').hide();

        // Show progress alert
        showAlert('Đang bắt đầu quá trình cập nhật...', 'info');

        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=update-bank-cat&update_bank_cat=1',
            dataType: 'html',
            success: function(res) {
                console.log('Update result:', res);

                // Show result
                $("#result-update").html(res);
                $('#result-card').fadeIn();

                // Scroll to result
                $('html, body').animate({
                    scrollTop: $('#result-card').offset().top - 20
                }, 500);

                showAlert('Cập nhật hoàn thành thành công!', 'success');
            },
            error: function(xhr, status, error) {
                console.error('Update error:', error);
                showAlert('Có lỗi xảy ra trong quá trình cập nhật: ' + error, 'danger');
            },
            complete: function() {
                // Restore button
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    }

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' :
                       type === 'info' ? 'fa-info-circle' :
                       type === 'warning' ? 'fa-exclamation-triangle' : 'fa-times-circle';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" ' +
                       'style="top: 20px; right: 20px; z-index: 9999; min-width: 350px;" role="alert">' +
                       '<i class="fas ' + iconClass + ' me-2"></i>' + message +
                       '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                       '</div>';

        $('body').append(alertHtml);

        // Auto-hide after 4 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 4000);
    }

    // Enhanced button hover effects
    $('.btn').on('mouseenter', function() {
        $(this).addClass('shadow-sm');
    }).on('mouseleave', function() {
        $(this).removeClass('shadow-sm');
    });

    // Make function globally available
    window.update_cat = update_cat;
});
//]]>
</script>
<!-- END: main -->

<!-- BEGIN: result_update -->
<div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
        <caption class="caption-top text-center fw-bold text-primary fs-5 mb-3">
            <i class="fas fa-chart-line me-2"></i>{caption}
        </caption>
        <thead>
            <tr>
                <th style="width: 60px;" class="text-center">
                    <i class="fas fa-hashtag me-1"></i>TT
                </th>
                <th>
                    <i class="fas fa-file-alt me-1"></i>{LANG.title}
                </th>
                <th>
                    <i class="fas fa-folder me-1"></i>{LANG.cat}
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">
                    <span class="badge bg-secondary">{ROW.tt}</span>
                </td>
                <td>
                    <div class="fw-bold text-primary">{ROW.title}</div>
                </td>
                <td>
                    <span class="badge bg-info">{ROW.cat}</span>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced table interactions for result table
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Add visual feedback for empty table
    if ($('.table tbody tr').length === 0) {
        $('.table tbody').append(
            '<tr><td colspan="3" class="text-center text-muted py-4">' +
            '<i class="fas fa-inbox fa-2x mb-2"></i><br>' +
            'Không có dữ liệu để hiển thị' +
            '</td></tr>'
        );
    }

    // Add success animation to the result card
    $('#result-card').addClass('animate__animated animate__fadeInUp');
});
//]]>
</script>
<!-- END: result_update -->