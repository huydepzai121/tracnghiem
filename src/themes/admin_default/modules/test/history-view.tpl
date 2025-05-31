<!-- BEGIN: main -->
<div class="d-flex justify-content-end mb-3 d-print-none">
    <div class="btn-group" role="group">
        <a href="{LINK_PRINT}" id="click_print" class="btn btn-primary">
            <i class="fas fa-print me-1"></i>{LANG.print}
        </a>
        <a href="{LINK_DELETE}" class="btn btn-danger" onclick="return confirm(nv_is_del_confirm[0]);">
            <i class="fas fa-trash me-1"></i>{LANG.delete}
        </a>
    </div>
</div>

<div class="exams-answer" id="{ANSWER_INFO.id}" data-answer-id="{ANSWER_INFO.id}">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>{LANG.exams_info}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 180px;" class="fw-bold">
                                        <i class="fas fa-heading me-1"></i>{LANG.exams_title}
                                    </th>
                                    <td class="d-print-none">
                                        <a href="{EXAM_INFO.link}" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-external-link-alt me-1"></i>{EXAM_INFO.title}
                                        </a>
                                    </td>
                                    <td class="d-none d-print-table-cell">{EXAM_INFO.title}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">
                                        <i class="fas fa-clock me-1"></i>{LANG.exams_time}
                                    </th>
                                    <td>
                                        <span class="badge bg-info">{EXAM_INFO.timer} {LANG.min}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">
                                        <i class="fas fa-list-alt me-1"></i>{LANG.exams_type}
                                    </th>
                                    <td>
                                        <span class="badge bg-secondary">{EXAM_INFO.type}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">
                                        <i class="fas fa-question-circle me-1"></i>{LANG.exams_report_total_question}
                                    </th>
                                    <td>
                                        <span class="badge bg-success">{EXAM_INFO.num_question}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>{LANG.tester_info}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <tbody>
                                <tr class="d-none d-print-table-row">
                                    <th style="width: 180px;" class="fw-bold">
                                        <i class="fas fa-user me-1"></i>{LANG.lastname_firstname}
                                    </th>
                                    <td colspan="3">{ANSWER_INFO.fullname}</td>
                                </tr>
                                <tr class="d-none d-print-table-row">
                                    <th class="fw-bold">
                                        <i class="fas fa-birthday-cake me-1"></i>{LANG.tester_info_birthday}
                                    </th>
                                    <td colspan="3">{ANSWER_INFO.birthday}</td>
                                </tr>
                                <tr class="d-none d-print-table-row">
                                    <th class="fw-bold">
                                        <i class="fas fa-envelope me-1"></i>{LANG.admin_email}
                                    </th>
                                    <td colspan="3">{ANSWER_INFO.email}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold">
                                        <i class="fas fa-stopwatch me-1"></i>{LANG.test_time}
                                    </th>
                                    <td>
                                        <span class="badge bg-warning text-dark">{ANSWER_INFO.time_test}</span>
                                    </td>
                                    <th colspan="2"></th>
                                </tr>

                                <!-- BEGIN: exams_type_title_1 -->
                                <tr>
                                    <th colspan="4" class="text-center bg-light fw-bold">
                                        <i class="fas fa-check-circle me-1"></i>{LANG.result_multi_choice}
                                    </th>
                                </tr>
                                <!-- END: exams_type_title_1 -->

                                <!-- BEGIN: exams_type_1 -->
                                <tr>
                                    <th class="fw-bold text-success">
                                        <i class="fas fa-check me-1"></i>{LANG.question_true}
                                    </th>
                                    <td><span class="badge bg-success">{ANSWER_INFO.count_true}</span></td>
                                    <th class="fw-bold text-danger">
                                        <i class="fas fa-times me-1"></i>{LANG.question_false}
                                    </th>
                                    <td><span class="badge bg-danger">{ANSWER_INFO.count_false}</span></td>
                                </tr>
                                <tr>
                                    <th class="fw-bold text-warning">
                                        <i class="fas fa-minus me-1"></i>{LANG.question_skeep}
                                    </th>
                                    <td><span class="badge bg-warning text-dark">{ANSWER_INFO.count_skeep}</span></td>
                                    <th class="fw-bold text-muted">
                                        <i class="fas fa-question me-1"></i>{LANG.total_question_have_not_mark}
                                    </th>
                                    <td><span class="badge bg-secondary">{ANSWER_INFO.total_question_have_not_mark}</span></td>
                                </tr>
                                <!-- END: exams_type_1 -->

                                <!-- BEGIN: exams_score_type_1 -->
                                <tr>
                                    <th class="fw-bold">
                                        <i class="fas fa-star me-1"></i>{LANG.score_multi_choice}
                                    </th>
                                    <td colspan="3">
                                        <span class="badge bg-primary fs-6">{ANSWER_INFO.score_multi_choice}</span>
                                    </td>
                                </tr>
                                <!-- END: exams_score_type_1 -->

                                <!-- BEGIN: exams_type_title_0 -->
                                <tr>
                                    <th colspan="4" class="text-center bg-light fw-bold">
                                        <i class="fas fa-edit me-1"></i>{LANG.result_constructed_response}
                                    </th>
                                </tr>
                                <!-- END: exams_type_title_0 -->

                                <!-- BEGIN: exams_type_0 -->
                                <!-- BEGIN: loop -->
                                <tr>
                                    <th class="fw-bold">{LOOP.title}</th>
                                    <td colspan="3">{LOOP.result}</td>
                                </tr>
                                <!-- END: loop -->
                                <!-- END: exams_type_0 -->

                                <!-- BEGIN: exams_score_type_0 -->
                                <tr>
                                    <th class="fw-bold">
                                        <i class="fas fa-star me-1"></i>{LANG.score_constructed_response}
                                    </th>
                                    <td colspan="3">
                                        <span class="badge bg-info fs-6">{ANSWER_INFO.score_constructed_response}</span>
                                    </td>
                                </tr>
                                <!-- END: exams_score_type_0 -->

                                <tr class="table-primary">
                                    <th class="fw-bold">
                                        <i class="fas fa-trophy me-1"></i>{LANG.score}
                                    </th>
                                    <td>
                                        <span class="badge bg-primary fs-5">{ANSWER_INFO.score}</span>
                                    </td>
                                    <!-- BEGIN: rating -->
                                    <th class="fw-bold">
                                        <i class="fas fa-medal me-1"></i>{LANG.rating}
                                    </th>
                                    <td>
                                        <span class="badge bg-warning text-dark fs-6">{ANSWER_INFO.rating.title}</span>
                                    </td>
                                    <!-- END: rating -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {VIEW_ANSWER}
    </div>
</div>
<script>
//<![CDATA[
$(document).ready(function() {
    <!-- BEGIN: print -->
    // Enhanced print functionality
    setTimeout(function(){
        window.print();
    }, 500);

    window.onafterprint = function(event) {
        window.location.href = '{LINK_PRINT_BACK}';
    };
    <!-- END: print -->

    // Enhanced form element styling for view mode
    $('.exams-answer').find('input, textarea, button, select')
        .attr('disabled', 'disabled')
        .addClass('bg-light border-0');

    // Enable specific elements
    $('.exams-answer').find('.enable').prop("disabled", false);

    // Enhanced button styling
    $('.exams-answer').find('button[type=submit]')
        .removeClass('bg-light')
        .addClass('btn-success');

    $('.exams-answer').find('button.btn-agree')
        .prop("disabled", false)
        .removeClass('bg-light')
        .addClass('btn-info');

    // Enhanced agree button functionality
    $('button.btn-agree').on('click', function(event) {
        event.preventDefault();

        var $btn = $(this);
        var $questionItem = $btn.closest(".question-item");
        var questionNumber = $questionItem.data("question-number");
        var $input = $questionItem.find('input[data-question-number="' + questionNumber + '"]');
        var max = $input.attr("max");

        // Visual feedback
        $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Đang cập nhật...')
            .prop('disabled', true);

        // Set max value
        $input.val(max);

        // Visual feedback for input
        $input.addClass('border-success bg-success bg-opacity-10');

        // Restore button after animation
        setTimeout(function() {
            $btn.html('<i class="fas fa-check me-1"></i>Đồng ý')
                .prop('disabled', false);

            setTimeout(function() {
                $input.removeClass('border-success bg-success bg-opacity-10');
            }, 2000);
        }, 1000);
    });

    // Enhanced print button
    $('#click_print').on('click', function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        $btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Đang chuẩn bị in...')
            .prop('disabled', true);

        setTimeout(function() {
            $btn.html(originalHtml).prop('disabled', false);
        }, 2000);
    });
});
//]]>
</script>
<!-- END: main -->