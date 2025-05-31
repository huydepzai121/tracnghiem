<!-- BEGIN: main -->
<div class="container-fluid">
    <div class="text-center mb-4">
        <h2 class="text-primary">
            <i class="fas fa-file-alt me-2"></i>
            <strong>{LANG.list_exam_subject} {SUBJECT.title}</strong>
        </h2>
    </div>

    <!-- BEGIN: examinations_title -->
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Cảnh báo:</strong> {LANG.not_del_examinations}
    </div>
    <!-- END: examinations_title -->

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>Danh sách đề thi
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
                            <i class="fas fa-file-alt me-1"></i>{LANG.exams_title}
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <i class="fas fa-question-circle me-1"></i>{LANG.question_count}
                        </th>
                        <th style="width: 200px;" class="text-center">
                            <i class="fas fa-tags me-1"></i>{LANG.cat}
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

    <div class="d-flex justify-content-end gap-2 mt-3">
        <!-- BEGIN: add_exams -->
        <a class="btn btn-success" href="{link_add_exams}" target="_self">
            <i class="fas fa-plus me-1"></i>{LANG.add_exams}
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

    // Enhanced button interactions with ripple effect
    $('.btn').on('click', function(e) {
        var $btn = $(this);
        var $ripple = $('<span class="ripple"></span>');

        $btn.append($ripple);

        var btnOffset = $btn.offset();
        var xPos = e.pageX - btnOffset.left;
        var yPos = e.pageY - btnOffset.top;

        $ripple.css({
            top: yPos,
            left: xPos
        }).addClass('ripple-effect');

        setTimeout(function() {
            $ripple.remove();
        }, 600);
    });

    // Enhanced hover effects
    $('.btn').on('mouseenter', function() {
        $(this).addClass('shadow');
    }).on('mouseleave', function() {
        $(this).removeClass('shadow');
    });
});
//]]>
</script>

<style>
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.btn {
    position: relative;
    overflow: hidden;
}
</style>
<!-- END: main -->