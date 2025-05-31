<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="text-center mb-4">
        <h2 class="text-primary">
            <i class="fas fa-list-alt me-2"></i>
            <strong>{LANG.list_question_subject} {SUBJECT.title}</strong>
        </h2>
    </div>

    <!-- BEGIN: examinations_title -->
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Cảnh báo:</strong> {LANG.not_del_examinations}
    </div>
    <!-- END: examinations_title -->

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-question-circle me-2"></i>Danh sách câu hỏi
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;" class="text-center">
                            <i class="fas fa-hashtag me-1"></i>TT
                        </th>
                        <th>
                            <i class="fas fa-question-circle me-1"></i>{LANG.question_content}
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <i class="fas fa-database me-1"></i>{LANG.bank_type}
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <i class="fas fa-cogs me-1"></i>Thao tác
                        </th>
                    </tr>
                </thead>
                <!-- BEGIN: generate_page -->
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="4">
                            <div class="d-flex justify-content-center">
                                {NV_GENERATE_PAGE}
                            </div>
                        </td>
                    </tr>
                </tfoot>
                <!-- END: generate_page -->
                <tbody>
                    <!-- BEGIN: loop -->
                    <tr>
                        <td class="text-center">
                            <span class="badge bg-secondary">{ROW.tt}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-truncate" style="max-width: 400px;" title="{ROW.title}">
                                {ROW.title}
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{ROW.bank_type_title}</span>
                        </td>
                        <td class="text-center">
                            {ROW.feature}
                        </td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <!-- BEGIN: add_exams -->
        <a class="btn btn-success" href="{link_add_question}" target="_self">
            <i class="fas fa-plus me-1"></i>{LANG.question_add}
        </a>
        <!-- END: add_exams -->
        <a class="btn btn-primary" href="{link_come_back}" target="_self">
            <i class="fas fa-arrow-left me-1"></i>{LANG.come_back}
        </a>
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

    // Enhanced button interactions
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
});
//]]>
</script>
<!-- END: main -->