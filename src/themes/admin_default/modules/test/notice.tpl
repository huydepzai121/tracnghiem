<!-- BEGIN: main -->
<!-- BEGIN: notice -->
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
        <div class="flex-grow-1">
            <h6 class="alert-heading mb-1">
                <i class="fas fa-bell me-1"></i>Thông báo quan trọng!
            </h6>
            <div>{PACKAGE_NOTIICE}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<!-- END: notice -->

<!-- BEGIN: alert_notice -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-circle me-3 fs-4"></i>
        <div class="flex-grow-1">
            <h6 class="alert-heading mb-1">
                <i class="fas fa-warning me-1"></i>Cảnh báo hệ thống!
            </h6>
            <div>{ALERT_NOTIICE}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<!-- END: alert_notice -->

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Enhanced alert animations
    $('.alert').each(function(index) {
        var $alert = $(this);

        // Stagger animation for multiple alerts
        setTimeout(function() {
            $alert.addClass('show');
        }, index * 200);
    });

    // Auto-hide alerts after 10 seconds (optional)
    $('.alert[data-auto-hide="true"]').each(function() {
        var $alert = $(this);
        setTimeout(function() {
            $alert.fadeOut(500, function() {
                $(this).remove();
            });
        }, 10000);
    });

    // Enhanced close button functionality
    $('.alert .btn-close').on('click', function() {
        var $alert = $(this).closest('.alert');
        $alert.fadeOut(300, function() {
            $(this).remove();
        });
    });
});
//]]>
</script>
<!-- END: main -->