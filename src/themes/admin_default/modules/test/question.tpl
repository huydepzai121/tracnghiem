<!-- BEGIN: question -->
<div class="col-12 question_number mb-2" id="question_number_{QUESTION.number}">
    <!-- BEGIN: common_question -->
    <div class="card border-info">
        <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="form-check-input me-2 post"
                           onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);"
                           value="{QUESTION.id}" data-number="{QUESTION.number}" name="idcheck[]">
                    <label onclick="nv_question_click({QUESTION.id}, {QUESTION.number})"
                           class="pointer question-title text-primary fw-bold mb-0"
                           data-id="{QUESTION.id}" data-number="{QUESTION.number}">
                        <i class="fas fa-layer-group me-1"></i>{LANG.question_type_3} ({from_question} - {to_question})
                    </label>
                </div>
                <button class="btn btn-outline-danger btn-sm bt_question_delete_{QUESTION.number}"
                        onclick="nv_question_delete({QUESTION.id}, {EXAMID}, {QUESTION.number}); return !1;"
                        title="{LANG.del_question}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- END: common_question -->

    <!-- BEGIN: really_question -->
    <div class="card <!-- BEGIN: info -->border-primary bg-light<!-- END: info -->">
        <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="form-check-input me-2 post"
                           onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);"
                           value="{QUESTION.id}" data-number="{QUESTION.number}" name="idcheck[]">
                    <label onclick="nv_question_click({QUESTION.id}, {QUESTION.number})"
                           class="pointer question-title mb-0 <!-- BEGIN: danger -->text-danger<!-- END: danger --> <!-- BEGIN: success -->text-success<!-- END: success -->"
                           data-id="{QUESTION.id}" data-number="{QUESTION.number}">
                        <i class="fas fa-question-circle me-1"></i>{LANG.question_s} {QUESTION.number_question_view}
                    </label>
                </div>
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-outline-warning bt_question_eraser_{QUESTION.number}"
                            onclick="nv_question_eraser({QUESTION.id}, {QUESTION.number}); return !1;"
                            title="{LANG.eraser_question}">
                        <i class="fas fa-eraser"></i>
                    </button>
                    <button class="btn btn-outline-danger bt_question_delete_{QUESTION.number}"
                            onclick="nv_question_delete({QUESTION.id}, {EXAMID}, {QUESTION.number}); return !1;"
                            title="{LANG.del_question}">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sort" {disabled}
                            onclick="nv_question_sort_asc({QUESTION.id}, {EXAMID}, {QUESTION.number}); return !1;"
                            title="{LANG.down}">
                        <i class="fas fa-arrow-down"></i>
                    </button>
                    <button class="btn btn-outline-info btn-sort" {disabled}
                            onclick="nv_question_sort_view({QUESTION.id}, {EXAMID}, {QUESTION.number}); return !1;"
                            title="{LANG.change_order}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sort" {disabled}
                            onclick="nv_question_sort_desc({QUESTION.id}, {EXAMID}, {QUESTION.number}); return !1;"
                            title="{LANG.up}">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: really_question -->
</div>
<!-- END: question -->
<!-- BEGIN: main -->
{PACKAGE_NOTIICE}
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

<div class="row g-3">
    <div class="col-lg-12" id="question-content"></div>
    <div class="col-lg-6">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs me-1"></i>Thao tác đề thi
                </h6>
            </div>
            <div class="card-body p-2">
                <div class="d-grid gap-2">
                    <a href="{SEARCH_EXAM}" target="_blank" onclick="check_is_full(event,$(this))"
                       class="btn btn-outline-info btn-sm">
                        <i class="fas fa-search me-1"></i>{LANG.content_view}
                    </a>
                    <a href="{ADD_EXAM}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-plus-circle me-1"></i>{LANG.add}
                    </a>
                    <a href="{EDIT_EXAM}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>{LANG.edit}
                    </a>
                    <a href="{DELETE_EXAM}" class="btn btn-outline-danger btn-sm"
                       onclick="return confirm(nv_is_del_confirm[0]);">
                        <i class="fas fa-trash me-1"></i>{LANG.delete}
                    </a>
                </div>
            </div>
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <small>{LANG.note_question_note}</small>
        </div>
        <div id="question-list">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-list me-1"></i>{LANG.question_list}
                        </h6>
                        <div class="dropdown">
                            <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-download me-1"></i>Import
                            </button>
                            <ul class="dropdown-menu">
                                <!-- BEGIN: msword -->
                                <li>
                                    <a class="dropdown-item"
                                       <!-- BEGIN: alert_notice_update --> onclick="notice_update()"<!-- END: alert_notice_update -->
                                       href="{URL_IMPORT}">
                                        <i class="fas fa-file-word me-1"></i>{LANG.type_input_question_1}
                                    </a>
                                </li>
                                <!-- END: msword -->
                                <!-- BEGIN: msexcel -->
                                <li>
                                    <a class="dropdown-item"
                                       <!-- BEGIN: alert_notice_update --> onclick="notice_update()"<!-- END: alert_notice_update -->
                                       href="{URL_IMPORT_EXCEL}">
                                        <i class="fas fa-file-excel me-1"></i>{LANG.importexcel}
                                    </a>
                                </li>
                                <!-- END: msexcel -->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
                        <input type="hidden" id="current_questionid" value="{FIRTSID}">
                        <div style="max-height: 650px; overflow-y: auto; overflow-x: hidden;" class="mb-2">
                            <div class="row qtslist g-1">
                                {LIST_QUESTIONS}
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="form-check">
                                <input name="check_all[]" type="checkbox" value="yes"
                                       class="form-check-input" id="check_all"
                                       onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);">
                                <label class="form-check-label" for="check_all">
                                    {LANG.select_all}
                                </label>
                            </div>

                            <div class="d-flex gap-2 align-items-center">
                                <select class="form-select form-select-sm" id="action_bottom" onchange="nv_add();" style="min-width: 150px;">
                                    <!-- BEGIN: action_bottom -->
                                    <option value="{ACTION.key}">{ACTION.value}</option>
                                    <!-- END: action_bottom -->
                                </select>
                                <input class="form-control form-control-sm add_question d-none"
                                       id="add_question" type="number" name="number_ques" min="1"
                                       placeholder="Số câu" style="width: 80px;">
                                <button class="btn btn-primary btn-sm"
                                        onclick="nv_list_question_delete('{BASE_URL}', '{LANG.exams_question_action_empty}', '{LANG.eraser_question_note}', {EXAMID}); return false;">
                                    <i class="fas fa-play me-1"></i>{LANG.perform}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap 5 Modal for order questions -->
<div class="modal fade" id="order_questions" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-sort-numeric-down me-2"></i>{LANG.order_questions}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="order_questions_form">
                    <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
                    <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
                    <input type="hidden" name="question_order" value="1" />
                    <input type="hidden" name="question_id" value="0" id="question_id" />
                    <input type="hidden" name="exam_id" value="0" id="exam_id" />

                    <div class="mb-3">
                        <label for="order_questions_number" class="form-label fw-bold">
                            <i class="fas fa-hashtag me-1"></i>{LANG.order_exams_number}
                        </label>
                        <input type="number" class="form-control text-center" id="order_questions_number"
                               value="" readonly style="background-color: #f8f9fa;">
                    </div>

                    <div class="mb-3">
                        <label for="order_questions_new" class="form-label fw-bold">
                            <i class="fas fa-edit me-1"></i>{LANG.order_exams_new}
                        </label>
                        <input type="number" class="form-control text-center" name="order_new"
                               id="order_questions_new" value="" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Hủy
                </button>
                <button type="submit" form="order_questions_form" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>{LANG.save}
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/jquery.sticky.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script>
//<![CDATA[
$(document).ready(function() {
    // Enhanced question list functionality
    var add_success = '{LANG.add_success}';
    var confirm_error = '{LANG.confirm_error}';

    // Bootstrap 5 Modal for order questions
    var orderModal = new bootstrap.Modal(document.getElementById('order_questions'));

    // Enhanced form submission for order questions
    $("#order_questions_form").on('submit', function(e) {
        e.preventDefault();
        var question_id = $("#question_id").val();
        var exam_id = $("#exam_id").val();
        var order_new = $("#order_questions_new").val();

        if (!order_new || order_new < 1) {
            $("#order_questions_new").addClass('is-invalid');
            return false;
        }

        $("#order_questions_new").removeClass('is-invalid');
        nv_question_sort(question_id, exam_id, order_new);
    });

    // Enhanced add question functionality
    window.nv_add = function() {
        var action_key = $('#action_bottom option:selected').val();
        var $addInput = $("#add_question");

        if (action_key == 'question_add') {
            $addInput.removeClass('d-none').focus();
        } else {
            $addInput.addClass('d-none');
        }
    };

    // Enhanced question sort view function
    window.nv_question_sort_view = function(question_id, exam_id, current_number) {
        $("#question_id").val(question_id);
        $("#exam_id").val(exam_id);
        $("#order_questions_number").val(current_number);
        $("#order_questions_new").val(current_number);
        orderModal.show();
    };
});
    // Enhanced question sort function
    function nv_question_sort(question_id, exam_id, order_new) {
        // Show loading state
        var $submitBtn = $('#order_questions_form button[type="submit"]');
        var originalHtml = $submitBtn.html();
        $submitBtn.prop('disabled', true)
                  .html('<i class="fas fa-spinner fa-spin me-1"></i>Đang cập nhật...');

        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question&question_order=1&nocache=' + new Date().getTime(),
            data: 'exam_id=' + exam_id + '&question_id=' + question_id + '&order_new=' + order_new,
            dataType: 'html',
            success: function(res) {
                if (res == 'error_range') {
                    alert('{LANG.error_range}');
                } else if (res == 'NO') {
                    alert(nv_is_change_act_confirm[2]);
                } else {
                    $(".qtslist").html(res);
                    nv_question_load(question_id, order_new);

                    // Close Bootstrap 5 modal
                    var orderModal = bootstrap.Modal.getInstance(document.getElementById('order_questions'));
                    orderModal.hide();

                    // Show success message
                    showAlert('Cập nhật thứ tự câu hỏi thành công!', 'success');
                }
            },
            complete: function() {
                // Restore button
                $submitBtn.prop('disabled', false).html(originalHtml);
            }
        });
    }

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

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
    function nv_question_sort_desc(question_id, exam_id, order_old) {
        nv_question_sort(question_id, exam_id, order_old - 1);
    }

    function nv_question_sort_asc(question_id, exam_id, order_old) {
        nv_question_sort(question_id, exam_id, order_old + 1);
    }
    function nv_add() {
        var action_key = $('#action_bottom option:selected').val();

        if (action_key == 'question_add') {
            $("#add_question").show().focus();
        } else {
            $("#add_question").hide();
        }
        return;
    }

    function nv_question_click(id, number) {
        if ($('#question_number_' + number).find('label.question-title').hasClass('pointer')) {
            $('.question_number').each(function() {
                $(this).find('tr').removeClass('info');
                $(this).find('label.question-title').addClass('pointer');
                $('.qtslist button.btn-sort').prop('disabled', true);
                $('#question_number_' + number + ' button.btn-sort').prop('disabled', false);
            });
            $('#question_number_' + number).find('label.question-title').closest('tr').addClass('info');
            $('#question_number_' + number).find('label.question-title').removeClass('pointer');
            $('#current_questionid').val(id);
            nv_question_load(id, number);
        } else {
            /**
            * Xử lý trường hợp nhập câu hỏi cuối cùng trong đề thi, khi đó câu hỏi tiếp theo thì không có
            * mà các thông tin về câu hỏi hiện tại (cuối cùng) cũng không có, chương trình vẫn xem nó là câu hỏi mới.
            * Nên nếu người sử dụng bấm cập nhật n lần nữa thì sẽ có n câu hỏi mới được thêm vào.
            */
            window.location.href = window.location.href;
        }
    }

    nv_question_load($('#current_questionid').val(), 1);
    /**
    *  đối số user_editor_ajax không pass qua thì nó sẽ lấy giá trị 'saved' nghĩa là nó sẽ lấy giá trị đã lưu trong CSDL
    *  user_editor_ajax = 'user_editor' nghĩa là sử dụng
    *  user_editor_ajax = 'not_editor' nghĩa là không sử dụng
    */
    function nv_question_load(id, number, user_editor_ajax = 'saved') {
        $.ajax({
            type: 'GET',
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question-content&id=' + id + '&number=' + number + '&user_editor_ajax=' + user_editor_ajax + '&examid={DATA.id}&ajax=1&bank={BANKEXAM}',
                dataType: 'html',
                success: function(res) {
                    $('#question-content').html(res);
                    /**
                    * Xử lý trường hợp mạng chậm hoặc người sử dụng bấm nút "Cập nhật" nhiều lần.
                    * Khi người dùng bấm cập nhật sẽ disable nút "Cập nhật" lại. Nút đó ở file question-content.tpl
                    * Đợi đến khi cập nhật lại dữ liệu xong ở đây thì enable nó lại
                    */

                    $('input[type="submit"]').prop('disabled', false);
                },
                error: function(xhr) {
                    $('input[type="submit"]').prop('disabled', false);
                }
        });
    }

    var nv_is_eraser_confirm = new Array('{LANG.eraser_question_note}', '{LANG.eraser_succesfully}', '{LANG.eraser_faile}');

    function nv_question_eraser(id, number) {
        if (confirm(nv_is_eraser_confirm[0])) {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question',
                data: 'eraser=1&id=' + id + '&number=' + number,
                success: function(res) {
                    if (res == 'OK') {
                        $('#question_number_' + number).find('label').replaceWith('<label onclick="nv_question_click(0, ' + number + ')" class="pointer question-title text-red">{LANG.question_s} ' + number + '</label>');
                        if ($('#current_questionid').val() == id) {
                            nv_question_load(id, number);
                        }
                    }
                }
            });
        }
    }

    function nv_question_delete(id, examid, number) {
        if (confirm(nv_is_del_confirm[0])) {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question',
                data: 'delete=1&id=' + id + '&examid=' + examid + '&number=' + number,
                success: function(res) {
                    if (res == 'OK') {
                        $('#question_number_' + number).remove();
                        $("#question-list").load(" #question-list");
                        nv_question_load(0, number);
                    }
                }
            });
        }
    }

    function check_is_full(event, $_this) {
        event.preventDefault();
        var url = $_this[0].href;
        $.ajax({
            type: 'GET',
            url: url,
            data: 'check_is_full=1&nocache=' + new Date().getTime(),
            success: function(res) {
                if (res == 'OK') {
                    window.open(url, '_blank ');
                } else {
                    alert('{LANG.not_view_exam}');
                }
            }
        });
    }
</script>
<!-- BEGIN: load_question -->
<script>
$(document).ready(function() {
    var cr_question = '{cr_question}';
    var cr_number = '{cr_number}';
    setTimeout(function() {
        nv_question_click(cr_question, cr_number);
    }, 500);
});
</script>
<!-- END: load_question -->
<!-- END: main -->