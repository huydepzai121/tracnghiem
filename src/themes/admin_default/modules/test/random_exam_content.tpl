<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-search me-2"></i>Tìm kiếm đề thi
            </h5>
        </div>
        <div class="card-body">
            <form action="{NV_BASE_ADMINURL}index.php" method="get">
                <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
                <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
                <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
                <input type="hidden" name="subjectid" value="{SUBJECT.id}" />

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">
                            <i class="fas fa-search me-1"></i>Từ khóa tìm kiếm
                        </label>
                        <input class="form-control" type="text" value="{q}" name="q"
                               maxlength="255" placeholder="{LANG.search_title}" />
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="fas fa-search me-1"></i>{LANG.search_submit}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mb-4">
        <h2 class="text-primary">
            <i class="fas fa-plus-circle me-2"></i>
            <strong>{LANG.add_exams_subject} {SUBJECT.title}</strong>
        </h2>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead">
                    <tr>
                        <th style="width: 60px;" class="text-center">
                            <i class="fas fa-hashtag me-1"></i>TT
                        </th>
                        <th>
                            <a href="{base_url}&order=title" target="_self" class="text-white text-decoration-none">
                                <i class="fas fa-file-alt me-1"></i>{LANG.exams_title}
                                <i class="fas fa-sort ms-1"></i>
                            </a>
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <i class="fas fa-question-circle me-1"></i>{LANG.question_count}
                        </th>
                        <th style="width: 200px;" class="text-center">
                            <a href="{base_url}&order=cat" target="_self" class="text-white text-decoration-none">
                                <i class="fas fa-tags me-1"></i>{LANG.cat}
                                <i class="fas fa-sort ms-1"></i>
                            </a>
                        </th>
                        <th style="width: 200px;" class="text-center">
                            <i class="fas fa-cogs me-1"></i>Thao tác
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
                        <td class="text-center">
                            <span class="badge bg-info">{ROW.num_question}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success">{ROW.title_cat}</span>
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

    <!-- BEGIN: generate_page -->
    <div class="d-flex justify-content-center mt-4 d-print-none">
        {NV_GENERATE_PAGE}
    </div>
    <!-- END: generate_page -->

    <div class="text-end mt-3">
        <a class="btn btn-success" href="{come_back}" target="_self">
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

    // Enhanced search form
    $('form').on('submit', function() {
        var $btn = $(this).find('button[type="submit"]');
        var originalHtml = $btn.html();

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang tìm kiếm...');

        // Restore after 3 seconds (fallback)
        setTimeout(function() {
            $btn.prop('disabled', false).html(originalHtml);
        }, 3000);
    });

    // Enhanced search input
    $('input[name="q"]').on('input', function() {
        var value = $(this).val();
        if (value.length > 0) {
            $(this).addClass('border-success');
        } else {
            $(this).removeClass('border-success');
        }
    });
});
//]]>
</script>
<!-- END: main -->