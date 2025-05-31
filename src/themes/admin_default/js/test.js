/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */

var anyString = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

function notice_update(notice) {
    $.ajax({
        type: 'POST',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(),
        data: 'alert_notice=1',
        success: function(html) {
            modalShow('Thông báo!', html);
            $('#sitemodal .modal-content').css('width', '600px');
        }
    });
}

$(document).ready(function() {

    $.fn.reindex = function() {
        $(this).each(function(index) {
            $(this).text(anyString.charAt(index));
        });
    };

    $('#btn-print').click(function() {
        $('.printMe').printElem();
    });

    $('#btn-toword').click(function() {
        window.open(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=detail&toword=1&id=' + $(this).data('examid'), "_blank");
    });

    $('#exams_delete').click(function(e) {
        e.preventDefault();
        if (confirm(nv_is_del_confirm[0])) {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams&nocache=' + new Date().getTime(),
                data: 'delete_data=1',
                success: function(res) {
                    var r_split = res.split('_');
                    alert(r_split[1]);
                    if (r_split[0] == 'OK') {
                        location.reload();
                    }
                }
            });
        }
    });
    $(".config-list-bank, #table-exams-config").on('change', 'input', function() {
        var questions = $(this).val();
        var max = $(this).data('max');

        if (questions > max) {
            alert(error_lang + max);
            $(this).val(0);
        }

        // tổng theo hàng
        var sum = 0;
        var _this = $(this).closest('tr');
        $(_this.find('td .input')).each(function() {
            var value = $(this).val();
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        _this.find('td.num_question').text(sum);

        // tổng theo cột
        var sum = 0;
        var _this = $(this).closest('table');
        var bank_type = $(this).data('bank-type');
        _this.find('td input.bank_type_' + bank_type).each(function() {
            var value = $(this).val();
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        _this.find('td#bank_type_' + bank_type).text(sum);

        // tổng câu hỏi
        var sum = 0;
        _this.find('td input').each(function() {
            var value = $(this).val();
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        _this.find('td#num_question').text(sum);
        $('#num_question').val(sum);
    });

    $('#frm-exam').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.error) {
                    alert(res.msg);
                    $('.ajax-load-qa').remove();
                    if (res.input != '') {
                        $('#' + res.input).focus();
                    }
                } else if (res.redirect != '') {
                    window.location.href = res.redirect;
                } else {
                    window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-config';
                }
            }
        });
    });

    $('#exams_config_refresh').click(function() {
        if (confirm($(this).data('confirm'))) {
            $('#table-exams-config').find('input').val(0);
            $('#table-exams-config').find('.num_question').text(0);
        }
    });
});

jQuery.fn.extend({
    printElem: function() {
        var cloned = this.clone();
        var printSection = $('#printSection');
        if (printSection.length == 0) {
            printSection = $('<div id="printSection"></div>')
            $('body').append(printSection);
        }
        printSection.append(cloned);
        var toggleBody = $('body *:visible');
        toggleBody.hide();
        $('#printSection, #printSection *').show();
        window.print();
        printSection.remove();
        toggleBody.show();
    }
});

function nv_list_action(action, url_action, del_confirm_no_post) {
    var listall = [];
    $('input.post:checked').each(function() {
        listall.push($(this).val());
    });
    if (listall.length < 1) {
        alert(del_confirm_no_post);
        return false;
    }
    if (action == 'delete_list_id') {
        if (confirm(nv_is_del_confirm[0])) {
            $.ajax({
                type: 'POST',
                url: url_action,
                data: 'delete_list=1&listall=' + listall,
                success: function(data) {
                    var r_split = data.split('_');
                    if (r_split[0] == 'OK') {
                        window.location.href = window.location.href;
                    } else {
                        alert(nv_is_del_confirm[2]);
                    }
                }
            });
        }
    } else {
        window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + action + '&listid=' + listall;
    }

    return false;
}

function nv_remove_answer(index) {
    $('#row-' + index).remove();
    $('.answer_index').reindex();
    return !1;
}

function nv_exam_question_action(action, url_action, del_confirm_no_post) {
    var listall = [];
    $('input.post:checked').each(function() {
        listall.push($(this).val());
    });

    if (listall.length < 1) {
        alert(del_confirm_no_post);
        return false;
    }

    if (action == 'delete') {
        if (confirm(nv_is_del_confirm[0])) {
            $.ajax({
                type: 'POST',
                url: url_action,
                data: 'delete_list=1&listall=' + listall,
                success: function(data) {
                    var r_split = data.split('_');
                    if (r_split[0] == 'OK') {
                        window.location.href = window.location.href;
                    } else {
                        alert(nv_is_del_confirm[2]);
                    }
                }
            });
        }
    }

    return false;
}

function nv_question_action(action, url_action, del_confirm_no_post) {
    var listall = [];
    $('input.post:checked').each(function() {
        listall.push($(this).val());
    });

    if (listall.length < 1) {
        alert(del_confirm_no_post);
        return false;
    }

    if (action == 'delete') {
        if (confirm(nv_is_del_confirm[0])) {
            $.ajax({
                type: 'POST',
                url: url_action,
                data: 'delete_list=1&listall=' + listall,
                success: function(data) {
                    var r_split = data.split('_');
                    if (r_split[0] == 'OK') {
                        window.location.href = window.location.href;
                    } else {
                        alert(nv_is_del_confirm[2]);
                    }
                }
            });
        }
    } else if (action == 'exam_add') {
        var exam_id = $('#exam_id').val();
        if (exam_id > 0) {
            $.ajax({
                type: 'POST',
                url: url_action,
                data: 'exam_add=1&listall=' + listall + '&exam_id=' + exam_id,
                success: function(data) {
                    var r_split = data.split('_');
                    if (r_split[0] == 'OK') {
                        alert($('#exam_id').data('exam-add-success'));
                        window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-question&id=' + exam_id;
                    } else {
                        alert(nv_is_change_act_confirm[2]);
                    }
                }
            });
        } else {
            $('#exam_id').focus();
            alert($('#exam_id').data('add-exam-empty'));
        }
    }

    return false;
}

function nv_list_question_delete(url_action, del_confirm_no_post, eraser_confirm, examid) {
    var action_key = $('#action_bottom option:selected').val();

    if (action_key == 'question_add') {
        var add_question = $('#add_question').val();

        if (add_question < 1) {
            alert(confirm_error);
            $("#add_question").focus();
            return false;
        }
        $.ajax({
            type: 'POST',
            url: url_action,
            data: 'examid=' + examid + '&add_question=' + add_question,
            success: function(data) {
                alert(add_success);
                location.reload();
            }
        });
    } else {
        var listall = [];
        var listnumber = [];
        $('input.post:checked').each(function() {
            listall.push($(this).val());
            listnumber.push($(this).data('number'));
        });

        if (listall.length < 1) {
            alert(del_confirm_no_post);
            return false;
        }

        if (action_key == 'question_eraser') {
            if (confirm(eraser_confirm)) {
                $.ajax({
                    type: 'POST',
                    url: url_action,
                    data: 'eraser_list=1&listall=' + listall + '&id=' + listall,
                    success: function(data) {
                        var r_split = data.split('_');
                        if (r_split[0] == 'OK') {
                            var id = $('#questionid').val();
                            var number = $("input[name=number]").val();
                            $('#question-content').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question-content&id=' + id + '&number=' + number + '&examid={DATA.id}&ajax=1');
                            $.each(listnumber, function(index, value) {
                                $('#question_number_' + value).find('label').removeClass('text-green').addClass('text-red');
                            });
                        }
                    }
                });
            }
        } else if (action_key == 'question_delete') {
            if (confirm(nv_is_del_confirm[0])) {
                $.ajax({
                    type: 'POST',
                    url: url_action,
                    data: 'delete_list=1&listall=' + listall + '&examid=' + examid,
                    success: function(data) {
                        var r_split = data.split('_');
                        if (r_split[0] == 'OK') {
                            location.reload();
                        }
                    }
                });
            }
        }
    }

    return false;
}

var items = ''; // fields.tpl
function nv_choice_fields_additem() {
    items++;
    var newitem = '<tr class="text-center">';
    newitem += '	<td>' + items + '</td>';
    newitem += '	<td><input class="form-control w100 validalphanumeric" type="text" value="" name="field_choice[' + items + ']"></td>';
    newitem += '	<td><input class="form-control" clas="w350" type="text" value="" name="field_choice_text[' + items + ']"></td>';
    newitem += '	<td><input type="radio" value="' + items + '" name="default_value_choice"></td>';
    newitem += '	</tr>';
    $('#choiceitems').append(newitem);
}

function nv_show_list_field() {
    $('#module_show_list').html('<center><img alt="" src="' + nv_base_siteurl + 'assets/images/load_bar.gif"></center>').load(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=fields&qlist=1&nocache=' + new Date().getTime());
    return;
}

function nv_chang_field(fid) {
    var nv_timer = nv_settimeout_disable('id_weight_' + fid, 5000);
    var new_vid = $('#id_weight_' + fid).val();
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=fields&nocache=' + new Date().getTime(), 'changeweight=1&fid=' + fid + '&new_vid=' + new_vid, function(res) {
        if (res != 'OK') {
            alert(nv_is_change_act_confirm[2]);
        }
        clearTimeout(nv_timer);
        nv_show_list_field();
    });
    return;
}

function nv_change_status(fid, field) {
    var new_status = $('#change_status_' + field + '_' + fid).is(':checked') ? true : false;
    if (confirm(nv_is_change_act_confirm[0])) {
        var nv_timer = nv_settimeout_disable('change_status_' + field + '_' + fid, 5000);
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=fields&nocache=' + new Date().getTime(), 'changestatus=1&fid=' + fid + '&field=' + field, function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(nv_is_change_act_confirm[2]);
            }
        });
    } else {
        $('#change_status_' + field + '_' + fid).prop('checked', new_status ? false : true);
    }
    return;
}

function nv_del_field(fid) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=fields&nocache=' + new Date().getTime(), 'del=1&fid=' + fid, function(res) {
            if (res == 'OK') {
                nv_show_list_field();
            } else {
                alert(nv_is_del_confirm[2]);
            }
        });
    }
    return false;
}

function nv_edit_field(fid) {
    window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=fields&fid=' + fid;
}

function nv_load_current_date() {
    if ($("input[name=current_date]:checked").val() == 1) {
        $("input[name=default_date]").attr('disabled', 'disabled');
        $("input[name=default_date]").datepicker("destroy");
    } else {
        $("input[name=default_date]").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
        });
        $("input[name=default_date]").removeAttr("disabled");
        $("input[name=default_date]").focus();
    }
}

function nv_users_check_choicetypes(elemnet) {
    var choicetypes_val = $(elemnet).val();
    if (choicetypes_val == "field_choicetypes_text") {
        $("#choiceitems").show();
        $("#choicesql").hide();
    } else {
        $("#choiceitems").hide();
        $("#choicesql").show();
        nv_load_sqlchoice('module', '');
    }
}

$(document).ready(function() {
    $('.loading').click(function() {
        var valid = $(this).closest('form').find('input:invalid').length;
        if (valid == 0) {
            $('body').append('<div class="ajax-load-qa"></div>');
        }
    });

    // Topic
    $('#delete-topic').click(function() {
        var list = [];
        $('input[name=newsid]:checked').each(function() {
            list.push($(this).val());
        });
        if (list.length < 1) {
            alert(LANG.topic_nocheck);
            return false;
        }
        if (confirm(LANG.topic_delete_confirm)) {
            $.ajax({
                type: 'POST',
                url: 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=topicdelnews',
                data: 'list=' + list,
                success: function(data) {
                    alert(data);
                    window.location = 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=topicsnews&topicid=' + CFG.topicid;
                }
            });
        }
        return false;
    });

    // Topics
    $("#select-img-topic").click(function() {
        var area = "homeimg";
        var path = CFG.upload_dir;
        var currentpath = CFG.upload_dir;
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    // Tags
    $("#select-img-tag").click(function() {
        var area = "image";
        var path = CFG.upload_path;
        var currentpath = CFG.upload_current;
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    $(".guider").on("click", ".alert-msg .close-msg", function(e) {
        var func = $(e.target).data('func');
        turn_on_off_msg('off', func);
    })
    $(".guider").on("click", ".show-msg", function(e) {
        var func = $(e.target).data('func');
        turn_on_off_msg('on', func);
    });
});

function turn_on_off_msg(status, func) {
    $.ajax({
        type: 'POST',
        url: 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&turn_on_off_msg=1',
        data: 'status=' + status + '&func=' + func,
        success: function(res) {
            if (res == 'on') {
                console.log('vao');
                $(".p-show-msg").hide();
                $(".alert-msg").fadeIn();
            } else {
                $(".alert-msg").hide();
                $(".p-show-msg").fadeIn();
            }
        }
    });
}

function nv_formReset(a) {
    $(a)[0].reset();
    if ($.isFunction($.fn.select2)) {
        $(a).find("select").val(0).trigger("change");
    }
}

function nv_chang_topic(topicid, mod) {
    var nv_timer = nv_settimeout_disable('id_' + mod + '_' + topicid, 5000);
    var new_vid = $('#id_' + mod + '_' + topicid).val();
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_topic&nocache=' + new Date().getTime(), 'topicid=' + topicid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
        var r_split = res.split('_');
        if (r_split[0] != 'OK') {
            alert(nv_is_change_act_confirm[2]);
        }
        clearTimeout(nv_timer);
        nv_show_list_topic();
    });
    return;
}

function nv_show_list_topic() {
    if (document.getElementById('module_show_list')) {
        $('#module_show_list').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_topic&nocache=' + new Date().getTime());
    }
    return;
}

function nv_del_topic(topicid) {
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del_topic&nocache=' + new Date().getTime(), 'topicid=' + topicid, function(res) {
        nv_del_topic_result(res);
    });
}

function nv_del_topic_result(res) {
    var r_split = res.split('_');
    if (r_split[0] == 'OK') {
        nv_show_list_topic();
    } else if (r_split[0] == 'ERR') {
        if (r_split[1] == 'ROWS') {
            if (confirm(r_split[4])) {
                var topicid = r_split[2];
                var checkss = r_split[3];
                $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del_topic&nocache=' + new Date().getTime(), 'topicid=' + topicid + '&checkss=' + checkss, function(res) {
                    nv_del_topic_result(res);
                });
            }
        } else {
            alert(r_split[1]);
        }
    } else {
        alert(nv_is_del_confirm[2]);
    }
    return false;
}

function formatRepo(repo) {
    if (repo.loading)
        return repo.text;
    return repo.title;
}

function formatRepoSelection(repo) {
    return repo.title || repo.text;
}

function nv_del_block_cat(bid) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=groups&nocache=' + new Date().getTime(), 'del_block_cat=1&bid=' + bid, function(res) {
            var r_split = res.split('_');
            if (r_split[0] == 'OK') {
                nv_show_list_block_cat();
            } else if (r_split[0] == 'ERR') {
                alert(r_split[1]);
            } else {
                alert(nv_is_del_confirm[2]);
            }
        });
    }
    return false;
}

function nv_chang_block_cat(bid, mod) {
    var nv_timer = nv_settimeout_disable('id_' + mod + '_' + bid, 5000);
    var new_vid = $('#id_' + mod + '_' + bid).val();
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=chang_block_cat&nocache=' + new Date().getTime(), 'bid=' + bid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
        var r_split = res.split('_');
        if (r_split[0] != 'OK') {
            alert(nv_is_change_act_confirm[2]);
        }
        clearTimeout(nv_timer);
        nv_show_list_block_cat();
    });
    return;
}

function nv_show_list_block_cat() {
    if (document.getElementById('module_show_list')) {
        $('#module_show_list').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_block_cat&nocache=' + new Date().getTime());
    }
    return;
}

function nv_chang_block(bid, id, mod) {
    if (mod == 'delete' && !confirm(nv_is_del_confirm[0])) {
        return false;
    }
    var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
    var new_vid = $('#id_weight_' + id).val();
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_block&nocache=' + new Date().getTime(), 'id=' + id + '&bid=' + bid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
        nv_chang_block_result(res);
    });
    return;
}

function nv_chang_block_result(res) {
    var r_split = res.split('_');
    if (r_split[0] != 'OK') {
        alert(nv_is_change_act_confirm[2]);
    }
    var bid = parseInt(r_split[1]);
    nv_show_list_block(bid);
    return;
}

function nv_show_list_block(bid) {
    if (document.getElementById('module_show_list')) {
        $('#module_show_list').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_block&bid=' + bid + '&nocache=' + new Date().getTime());
    }
    return;
}

function nv_del_block_list(oForm, bid, del_confirm_no_post) {
    var del_list = '';
    var fa = oForm['idcheck[]'];
    if (fa.length) {
        for (var i = 0; i < fa.length; i++) {
            if (fa[i].checked) {
                del_list = del_list + ',' + fa[i].value;
            }
        }
    } else {
        if (fa.checked) {
            del_list = del_list + ',' + fa.value;
        }
    }

    if (del_list != '') {
        if (confirm(nv_is_del_confirm[0])) {
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_block&nocache=' + new Date().getTime(), 'del_list=' + del_list + '&bid=' + bid, function(res) {
                nv_chang_block_result(res);
            });
        }
    } else {
        alert(del_confirm_no_post);
    }
}

function nv_chang_cat(catid, mod) {
    var nv_timer = nv_settimeout_disable('id_' + mod + '_' + catid, 5000);
    var new_vid = $('#id_' + mod + '_' + catid).val();
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_cat&nocache=' + new Date().getTime(), 'catid=' + catid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
        var r_split = res.split('_');
        if (r_split[0] != 'OK') {
            alert(nv_is_change_act_confirm[2]);
        }
        clearTimeout(nv_timer);
        return;
    });
    return;
}

function nv_search_tag(tid) {
    $("#module_show_list").html('<p class="text-center"><img src="' + nv_base_siteurl + 'assets/images/load_bar.gif" alt="Waiting..."/></p>').load(script_name + "?" + nv_lang_variable + "=" + nv_lang_data + "&" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=tags&q=" + rawurlencode($("#q").val()) + "&num=" + nv_randomPassword(10));
    return false;
}

function nv_del_tags(tid) {
    if (confirm(nv_is_del_confirm[0])) {
        $("#module_show_list").html('<p class="text-center"><img src="' + nv_base_siteurl + 'assets/images/load_bar.gif" alt="Waiting..."/></p>').load(script_name + "?" + nv_lang_variable + "=" + nv_lang_data + "&" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=tags&del_tid=" + tid + "&num=" + nv_randomPassword(10));
    }
    return false;
}

function nv_del_check_tags(oForm, checkss, msgnocheck) {
    var fa = oForm['idcheck[]'];
    var listid = '';
    if (fa.length) {
        for (var i = 0; i < fa.length; i++) {
            if (fa[i].checked) {
                listid = listid + fa[i].value + ',';
            }
        }
    } else {
        if (fa.checked) {
            listid = listid + fa.value + ',';
        }
    }

    if (listid != '') {
        if (confirm(nv_is_del_confirm[0])) {
            $("#module_show_list").html('<p class="text-center"><img src="' + nv_base_siteurl + 'assets/images/load_bar.gif" alt="Waiting..."/></p>').load(script_name + "?" + nv_lang_variable + "=" + nv_lang_data + "&" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=tags&q=" + rawurlencode($("#q").val()) + "&del_listid=" + listid + "&checkss=" + checkss + "&num=" + nv_randomPassword(10));
        }
    } else {
        alert(msgnocheck);
    }
    return false;
}

function check_add_first() {
    $(this).one("dblclick", check_add_second);
    $("input[name='add_content[]']:checkbox").prop("checked", true);
}

function check_add_second() {
    $(this).one("dblclick", check_add_first);
    $("input[name='add_content[]']:checkbox").prop("checked", false);
}

function check_app_first() {
    $(this).one("dblclick", check_app_second);
    $("input[name='app_content[]']:checkbox").prop("checked", true);
}

function check_app_second() {
    $(this).one("dblclick", check_app_first);
    $("input[name='app_content[]']:checkbox").prop("checked", false);
}

function check_pub_first() {
    $(this).one("dblclick", check_pub_second);
    $("input[name='pub_content[]']:checkbox").prop("checked", true);
}

function check_pub_second() {
    $(this).one("dblclick", check_pub_first);
    $("input[name='pub_content[]']:checkbox").prop("checked", false);
}

function check_edit_first() {
    $(this).one("dblclick", check_edit_second);
    $("input[name='edit_content[]']:checkbox").prop("checked", true);
}

function check_edit_second() {
    $(this).one("dblclick", check_edit_first);
    $("input[name='edit_content[]']:checkbox").prop("checked", false);
}

function check_del_first() {
    $(this).one("dblclick", check_del_second);
    $("input[name='del_content[]']:checkbox").prop("checked", true);
}

function check_del_second() {
    $(this).one("dblclick", check_del_first);
    $("input[name='del_content[]']:checkbox").prop("checked", false);
}

function nv_table_row_click(e, t, n) {
    var r = e.target.tagName.toLowerCase(),
        i = e.target.parentNode.tagName.toLowerCase(),
        a = e.target.parentNode.parentNode.parentNode;
    return void("button" != r && "a" != r && "button" != i && "a" != i && "td" != i && (n ? window.open(t) : window.location.href = t))
}

function nv_view_content(bank, id, title) {
    $.ajax({
        type: 'POST',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=detail&nocache=' + new Date().getTime(),
        data: 'view_content=1&id=' + id + '&bank=' + bank,
        dataType: 'html',
        success: function(html) {
            nv_fullModalShow(title, html);
            $('#btn-toword').attr('data-examid', id);
        }
    });
}

function nv_view_statistics(id, title) {
    // Create Bootstrap modal if not exists
    if (!$('#statisticsModal').length) {
        $('body').append(`
            <div class="modal fade" id="statisticsModal" tabindex="-1" aria-labelledby="statisticsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="statisticsModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0"></div>
                    </div>
                </div>
            </div>
        `);
    }

    const modal = new bootstrap.Modal(document.getElementById('statisticsModal'));

    $.ajax({
        type: 'POST',
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=history&nocache=' + new Date().getTime(),
        data: 'view_statistics=1&id=' + id,
        dataType: 'html',
        beforeSend: function() {
            // Show loading content
            $('#statisticsModalLabel').text(title);
            $('#statisticsModal .modal-body').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Đang tải...</span></div><div class="mt-3">Đang tải dữ liệu thống kê...</div></div>');
            modal.show();
        },
        success: function(html) {
            $('#statisticsModalLabel').text(title);
            $('#statisticsModal .modal-body').html(html);
        },
        error: function() {
            $('#statisticsModalLabel').text('Lỗi');
            $('#statisticsModal .modal-body').html('<div class="alert alert-danger m-3"><i class="fas fa-exclamation-triangle me-2"></i>Không thể tải dữ liệu thống kê. Vui lòng thử lại sau.</div>');
        }
    });
}

function nv_test_dipslay_userguide(_this) {
    var content = _this.closest('.useguide').find('.useguide-content').html();
    modalShow(_this.data('title'), content);
    $('#sitemodal .modal-dialog').css('padding-top', 100);
}

function nv_fullModalShow(a, b) {
    "" == a && (a = "&nbsp;");
    $("#full-sitemodal").find(".modal-title").html(a);
    $("#full-sitemodal").find(".modal-body").html(b);
    $("#full-sitemodal").modal()
}

function nv_sort_content(id, w) {
    $("#order_exams").dialog("open");
    $("#order_exams_title").text($("#id_" + id).attr("title"));
    $("#order_exams_id").val(id, w);
    $("#order_exams_number").val(w);
    $("#order_exams_new").val(w);
    return false;
}

function nv_question_sort_view(id, examid, w) {
    $("#order_questions").dialog("open");
    $("#order_questions_title").text($("#id_" + id).attr("title"));
    $("#question_id").val(id);
    $("#exam_id").val(examid);
    $("#order_questions_number").val(w);
    $("#order_questions_new").val(w);
    return false;
}

function isEmpty(obj) {
    return obj === null || obj === undefined || obj === "" || (Array.isArray(obj) && obj.length === 0) || (typeof obj === 'object' && Object.keys(obj).length === 0);
}