<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-search me-2"></i>Tìm kiếm kết quả thi
            </h5>
        </div>
        <div class="card-body">
            <form action="{NV_BASE_ADMINURL}index.php" method="get">
                <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
                <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
                <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">
                            <i class="fas fa-file-alt me-1"></i>Tên đề thi
                        </label>
                        <input class="form-control" type="text" value="{SEARCH.q}" name="q"
                               maxlength="255" placeholder="{LANG.exams}" />
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">
                            <i class="fas fa-users me-1"></i>Nhóm người dùng
                        </label>
                        <select name="groupid" id="groupid" class="form-select">
                            <option value="0" selected>-- {LANG.select_group} --</option>
                            <!-- BEGIN: group -->
                            <option value="{GROUP.index}" {GROUP.selected}>{GROUP.title}</option>
                            <!-- END: group -->
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100 loading" type="submit">
                            <i class="fas fa-search me-1"></i>{LANG.search_submit}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-chart-bar me-2"></i>Kết quả thi
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
                            <i class="fas fa-file-alt me-1"></i>{LANG.exams}
                        </th>
                        <th style="width: 180px;" class="text-center">
                            <i class="fas fa-clock me-1"></i>{LANG.last_exam_time}
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <i class="fas fa-calculator me-1"></i>{LANG.sum_exam_time}
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <i class="fas fa-users me-1"></i>{LANG.sum_user_time}
                        </th>
                        <th style="width: 120px;" class="text-center">
                            <i class="fas fa-star me-1"></i>{LANG.avg}
                        </th>
                        <th style="width: 120px;" class="text-center">
                            <i class="fas fa-cogs me-1"></i>Thao tác
                        </th>
                    </tr>
                </thead>
                <!-- BEGIN: generate_page -->
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="7">
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
                            <span class="badge bg-secondary fs-6">{VIEW.tt}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-primary">{VIEW.title}</div>
                        </td>
                        <td class="text-center">
                            <small class="text-muted">{VIEW.begin_time}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{VIEW.sum}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning text-dark">{VIEW.sum_user}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success fs-6">{VIEW.score}</span>
                        </td>
                        <td class="text-center">
                            <a href="{VIEW.link}" class="btn btn-outline-primary btn-sm" title="Xem chi tiết">
                                <i class="fas fa-eye me-1"></i>{LANG.detail}
                            </a>
                        </td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
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

    // Enhanced table interactions
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Enhanced search input
    $('input[name="q"]').on('input', function() {
        var value = $(this).val();
        if (value.length > 0) {
            $(this).addClass('border-success');
        } else {
            $(this).removeClass('border-success');
        }
    });

    // Enhanced select interaction
    $('#groupid').on('change', function() {
        var value = $(this).val();
        if (value != '0') {
            $(this).addClass('border-success');
            setTimeout(function() {
                $('#groupid').removeClass('border-success');
            }, 1500);
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
});
//]]>
</script>
<!-- END: main -->