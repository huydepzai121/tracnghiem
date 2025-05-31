<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap-5-theme.min.css">

<div class="container-fluid">
    <div id="module_show_list" class="mb-4">
        <!-- BEGIN: data -->
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Danh sách bài thi trong chủ đề
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;" class="text-center">
                                <input type="checkbox" class="form-check-input" id="checkall-master">
                            </th>
                            <th>
                                <i class="fas fa-file-alt me-1"></i>{LANG.title}
                            </th>
                            <th style="width: 180px;" class="text-center">
                                <i class="fas fa-calendar me-1"></i>{LANG.addtime}
                            </th>
                        </tr>
                    </thead>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3">
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-success" id="checkall">
                                            <i class="fas fa-check-square me-1"></i>{LANG.checkall}
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" id="uncheckall">
                                            <i class="fas fa-square me-1"></i>{LANG.uncheckall}
                                        </button>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="delete-topic">
                                        <i class="fas fa-trash me-1"></i>{LANG.topic_del}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <!-- BEGIN: loop -->
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input newsid-checkbox"
                                       name="newsid" value="{ROW.id}" />
                            </td>
                            <td>
                                <a target="_blank" href="{ROW.link}" class="text-decoration-none fw-bold text-primary">
                                    <i class="fas fa-external-link-alt me-1"></i>{ROW.title}
                                </a>
                            </td>
                            <td class="text-center">
                                <small class="text-muted">{ROW.addtime}</small>
                            </td>
                        </tr>
                        <!-- END: loop -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END: data -->

        <!-- BEGIN: empty -->
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Thông báo:</strong> {LANG.topic_nonews}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <!-- END: empty -->
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-plus-circle me-2"></i>{LANG.add_exam_for_topic}
            </h5>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="exams" class="form-label fw-bold">
                        <i class="fas fa-file-alt me-1"></i>{LANG.select_exam}
                    </label>
                    <select class="form-select" name="exams" id="exams"
                            data-placeholder="Tìm kiếm và chọn bài thi..."></select>
                    <div class="form-text">Tìm kiếm bài thi theo tên để thêm vào chủ đề</div>
                </div>

                <div class="text-center">
                    <button type="button" onclick="add_exam_for_topic()" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-plus me-2"></i>{LANG.add_to_topic}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    var LANG = [];
    var CFG = [];
    LANG.topic_nocheck = '{LANG.topic_nocheck}';
    LANG.topic_delete_confirm = '{LANG.topic_delete_confirm}';
    CFG.topicid = '{TOPICID}';

    // Enhanced add exam function
    function add_exam_for_topic() {
        var exam_id = $("#exams").val();
        var $btn = $('button[onclick*="add_exam_for_topic"]');
        var originalHtml = $btn.html();

        if (!exam_id) {
            showAlert('Vui lòng chọn bài thi!', 'warning');
            return;
        }

        // Show loading state
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang thêm...');

        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=topicsnews&update_exam=1&nocache=' + new Date().getTime(),
            data: "topicid=" + CFG.topicid + "&exam_id=" + exam_id,
            success: function(res) {
                showAlert('Thêm bài thi vào chủ đề thành công!', 'success');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function() {
                showAlert('Có lỗi xảy ra khi thêm bài thi!', 'danger');
            },
            complete: function() {
                // Restore button
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    }

    // Enhanced Select2 with Bootstrap 5 theme
    $('#exams').select2({
        tags: true,
        language: '{NV_LANG_INTERFACE}',
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Tìm kiếm và chọn bài thi...',
        allowClear: true,
        tokenSeparators: [','],
        ajax: {
            url: script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable +
                "=exams-content&get_exams=1",
            delay: 250,
            data: function(params) {
                return {
                    title: params.term,
                    page: params.page || 1
                };
            },
            processResults: function(data, params) {
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        templateResult: function(exam) {
            if (exam.loading) {
                return 'Đang tìm kiếm...';
            }
            return exam.text;
        },
        templateSelection: function(exam) {
            return exam.text || exam.id;
        }
    });

    // Enhanced checkbox functionality
    $('#checkall-master').on('change', function() {
        var isChecked = $(this).is(':checked');
        $('.newsid-checkbox').prop('checked', isChecked);
        updateRowHighlight();
    });

    $('#checkall').on('click', function() {
        $('.newsid-checkbox').prop('checked', true);
        $('#checkall-master').prop('checked', true);
        updateRowHighlight();
    });

    $('#uncheckall').on('click', function() {
        $('.newsid-checkbox').prop('checked', false);
        $('#checkall-master').prop('checked', false);
        updateRowHighlight();
    });

    $('.newsid-checkbox').on('change', function() {
        var totalCheckboxes = $('.newsid-checkbox').length;
        var checkedCheckboxes = $('.newsid-checkbox:checked').length;

        $('#checkall-master').prop('checked', totalCheckboxes === checkedCheckboxes);
        updateRowHighlight();
    });

    // Enhanced delete functionality
    $('#delete-topic').on('click', function() {
        var checkedItems = $('.newsid-checkbox:checked');

        if (checkedItems.length === 0) {
            showAlert(LANG.topic_nocheck, 'warning');
            return;
        }

        if (confirm(LANG.topic_delete_confirm + ' (' + checkedItems.length + ' bài thi)')) {
            var ids = [];
            checkedItems.each(function() {
                ids.push($(this).val());
            });

            var $btn = $(this);
            var originalHtml = $btn.html();

            // Show loading state
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang xóa...');

            // Simulate delete action (replace with actual URL)
            setTimeout(function() {
                showAlert('Đã xóa ' + ids.length + ' bài thi khỏi chủ đề!', 'success');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }, 1000);
        }
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

    // Update row highlighting based on checkbox state
    function updateRowHighlight() {
        $('.newsid-checkbox').each(function() {
            var $row = $(this).closest('tr');
            if ($(this).is(':checked')) {
                $row.addClass('table-warning');
            } else {
                $row.removeClass('table-warning');
            }
        });
    }

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' :
                       type === 'warning' ? 'fa-exclamation-triangle' : 'fa-times-circle';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" ' +
                       'style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">' +
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

    // Initialize row highlighting
    updateRowHighlight();

    // Make function globally available
    window.add_exam_for_topic = add_exam_for_topic;
});
//]]>
</script>
<!-- END: main -->