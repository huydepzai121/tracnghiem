<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Cấu hình module Test
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
                        <div class="text-center">
                            <button name="submit" type="submit" class="btn btn-primary btn-lg px-5">
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
    // Enhanced form submission
    $('form').on('submit', function() {
        var $btn = $(this).find('button[type="submit"]');
        var originalHtml = $btn.html();

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...');

        // Restore after 3 seconds (fallback)
        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
        }, 3000);
    });
});
//]]>
</script>
<!-- END: main -->