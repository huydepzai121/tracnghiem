<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
{PACKAGE_NOTIICE}

<!-- BEGIN: guider -->
<div class="card border-info mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <div class="alert alert-info mb-0" <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-info-circle me-2"></i>
                    {LANG.guider_exams}
                </div>
            </div>
            <div class="flex-shrink-0">
                <button class="btn btn-outline-info btn-sm show-msg" data-func="exams"
                        <!-- BEGIN: msg_show -->style="display: none" <!-- END: msg_show -->>
                    <i class="fas fa-question-circle me-1"></i>{LANG.msg}
                </button>
                <button class="btn btn-outline-secondary btn-sm close-msg" data-func="exams"
                        <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END: guider -->

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
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input class="form-control" type="text" value="{SEARCH.q}" name="q"
                               maxlength="255" placeholder="{LANG.search_title}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="catid" class="form-select select2b">
                        <option value="0">--- {LANG.cat_select} ---</option>
                        <!-- BEGIN: cat -->
                        <option value="{CAT.id}"{CAT.selected}>{CAT.space}{CAT.title}</option>
                        <!-- END: cat -->
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="-1">--- {LANG.exams_type_select} ---</option>
                        <!-- BEGIN: type -->
                        <option value="{TYPE.index}"{TYPE.selected}>{TYPE.value}</option>
                        <!-- END: type -->
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-search me-1"></i>{LANG.search_submit}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-cogs me-2"></i>Thao tác và quản lý
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <!-- BEGIN: action_top -->
            <div class="col-md-3">
                <select class="form-select" id="action-top">
                    <!-- BEGIN: loop -->
                    <option value="{ACTION.key}">{ACTION.value}</option>
                    <!-- END: loop -->
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-warning w-100" onclick="nv_list_action( $('#action-top').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
                    <i class="fas fa-play me-1"></i>{LANG.perform}
                </button>
            </div>
            <!-- END: action_top -->
            <div class="col-md-3">
                <a href="{URL_ADD}" class="btn btn-success w-100">
                    <i class="fas fa-plus me-1"></i>{LANG.exams_add}
                </a>
            </div>
            <!-- BEGIN: deldata -->
            <div class="col-md-3">
                <button class="btn btn-danger w-100" id="exams_delete" title="{LANG.exams_delete}">
                    <i class="fas fa-trash me-1"></i>{LANG.exams_delete}
                </button>
            </div>
            <!-- END: deldata -->
        </div>
    </div>
</div>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>Danh sách đề thi
        </h5>
    </div>
    <div class="card-body p-0">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;" class="text-center">
                                <input name="check_all[]" type="checkbox" value="yes"
                                       class="form-check-input"
                                       onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);">
                            </th>
                            <th class="fs-6">
                                <i class="fas fa-file-alt me-2"></i>{LANG.exams_title}
                            </th>
                            <th style="width: 120px;" class="text-center fs-6">
                                <i class="fas fa-list-alt me-1"></i>{LANG.exams_type}
                            </th>
                            <th style="width: 140px;" class="text-center fs-6">
                                <i class="fas fa-question-circle me-1"></i>{LANG.question_count}
                            </th>
                            <th style="width: 120px;" class="text-center fs-6">
                                <i class="fas fa-trophy me-1"></i>{LANG.ladder}
                            </th>
                            <th style="width: 130px;" class="text-center fs-6">
                                <i class="fas fa-clock me-1"></i>{LANG.timer} ({LANG.min})
                            </th>
                            <th style="width: 100px;" class="text-center fs-6">
                                <i class="fas fa-toggle-on me-1"></i>{LANG.active}
                            </th>
                            <th style="width: 220px;" class="text-center fs-6">
                                <i class="fas fa-cogs me-1"></i>Thao tác
                            </th>
                        </tr>
                    </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr class="align-middle">
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{VIEW.id}" name="idcheck[]">
                    </td>
                    <td class="py-3">
                        <div class="d-flex align-items-center">
                            <!-- BEGIN: sort -->
                            <a href="javascript:void(0);" title="{LANG.order_exams_number}: {VIEW.weight}" onclick="nv_sort_content({VIEW.id}, {VIEW.weight})" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fas fa-sort"></i>
                            </a>
                            <!-- END: sort -->
                            <div class="flex-grow-1">
                                <!-- BEGIN: link -->
                                <a href="{VIEW.link_view}" target="_blank" class="text-decoration-none">
                                    <h6 class="mb-1 text-primary fw-bold">{VIEW.title}</h6>
                                </a>
                                <!-- END: link -->
                                <!-- BEGIN: label -->
                                <h6 class="mb-1 text-dark fw-bold">{VIEW.title}</h6>
                                <!-- END: label -->

                                <div class="small text-muted">
                                    <i class="fas fa-clock me-1"></i>{VIEW.addtime}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-user me-1"></i>{VIEW.fullname}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-eye me-1"></i>{VIEW.hitstotal} lượt xem
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-users me-1"></i>{VIEW.hittest} lượt thi
                                </div>

                                <!-- BEGIN: exams_deactive -->
                                <div class="mt-1">
                                    <span class="badge bg-danger">{exams_deactive}</span>
                                </div>
                                <!-- END: exams_deactive -->

                                <!-- BEGIN: exams_of_bank -->
                                <div class="mt-1">
                                    <span class="badge bg-warning text-dark">{LANG.exams_bank}</span>
                                    <small class="text-muted ms-2">{LANG.cat}: {cat_bank}</small>
                                </div>
                                <!-- END: exams_of_bank -->

                                <!-- BEGIN: price -->
                                <div class="mt-1">
                                    <span class="badge bg-success">
                                        <i class="fas fa-credit-card me-1"></i>{VIEW.price} VND
                                    </span>
                                </div>
                                <!-- END: price -->
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-info text-dark">{VIEW.type}</span>
                    </td>
                    <td class="text-center">
                        <div class="fw-bold text-primary">{VIEW.count_question}/{VIEW.num_question}</div>
                        <small class="text-muted">câu hỏi</small>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-warning text-dark">{VIEW.ladder}</span>
                    </td>
                    <td class="text-center">
                        <div class="fw-bold text-success">{VIEW.timer}</div>
                        <small class="text-muted">phút</small>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" name="status" id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK} onclick="nv_change_status({VIEW.id});" />
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a class="btn btn-outline-info btn-sm" href="{URL_MERGE}&exam_id={VIEW.id}"
                               data-bs-toggle="tooltip" title="{LANG.merge_exams}">
                                <i class="fas fa-sync-alt"></i>
                            </a>

                            <!-- BEGIN: addBank -->
                            <button class="btn btn-outline-success btn-sm" title="{LANG.add_bank}"
                                    data-bs-toggle="tooltip" onclick="nv_add_bank({VIEW.id}); return false;">
                                <i class="fas fa-plus"></i>
                            </button>
                            <!-- END: addBank -->

                            <!-- BEGIN: content_view -->
                            <button class="btn btn-outline-primary btn-sm" title="{LANG.content_view}"
                                    onclick="nv_view_content(0, {VIEW.id}, '{VIEW.title}'); return false;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <!-- END: content_view -->

                            <a class="btn btn-outline-secondary btn-sm" title="{LANG.download}"
                               data-bs-toggle="tooltip" href="{link_download_exam}">
                                <i class="fas fa-download"></i>
                            </a>

                            <!-- BEGIN: question_list -->
                            <a href="{VIEW.link_question}" class="btn btn-outline-warning btn-sm"
                               data-bs-toggle="tooltip" title="{LANG.exams_report_total_question}">
                                <i class="fas fa-list"></i>
                                <span class="badge bg-danger ms-1">{VIEW.count_question}</span>
                            </a>
                            <!-- END: question_list -->

                            <!-- BEGIN: clone_exam -->
                            <a class="btn btn-outline-dark btn-sm" href="{link_clone_exam}"
                               data-bs-toggle="tooltip" title="{LANG.clone}">
                                <i class="fas fa-copy"></i>
                            </a>
                            <!-- END: clone_exam -->
                        </div>

                        <div class="mt-2">
                            <a href="{VIEW.link_report}" class="btn btn-sm btn-success">
                                <i class="fas fa-chart-bar me-1"></i>{LANG.exams_report}
                            </a>
                            {VIEW.feature}
                        </div>
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>

<!-- BEGIN: action_bottom -->
<div class="card-footer bg-light">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <select class="form-select me-2" id="action-bottom" style="width: auto;">
                    <!-- BEGIN: loop -->
                    <option value="{ACTION.key}">{ACTION.value}</option>
                    <!-- END: loop -->
                </select>
                <button class="btn btn-primary" onclick="nv_list_action( $('#action-bottom').val(), '{BASE_URL}', '{LANG.error_empty_data}' ); return false;">
                    <i class="fas fa-play me-1"></i>{LANG.perform}
                </button>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <small class="text-muted">Chọn các mục và thực hiện thao tác hàng loạt</small>
        </div>
    </div>
</div>
<!-- END: action_bottom -->
<div class="modal fade modal-fullscreen printable" id="full-sitemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">&nbsp;</h3>
            </div>
            <div class="modal-body">
                <em class="fa fa-spinner fa-spin">&nbsp;</em>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="btn-print">
                    <em class="fa fa-print">&nbsp;</em>{LANG.print}
                </button>
                <!--
                <button type="button" class="btn btn-warning" id="btn-toword">
                    <em class="fa fa-file-word-o">&nbsp;</em>{LANG.toword}
                </button>
                 -->
                <button type="button" class="btn btn-default" data-dismiss="modal">{LANG.close}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-fullscreen " id="view_option_addbank-sitemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">&nbsp;</h3>
            </div>
            <div class="modal-body">
                <em class="fa fa-spinner fa-spin">&nbsp;</em>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="add_bank" data-examid="">
                    <em class="fa fa-plus">&nbsp;</em>{LANG.add_bank}
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{LANG.close}</button>
            </div>
        </div>
    </div>
</div>
<div id="order_exams" title="{LANG.order_exams}">
    <strong id="order_exams_title">{LANG.order_exams}</strong>
    <form method="post" class="form-horizontal">
        <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
        <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
        <input type="hidden" name="order_exams_id" value="0" id="order_exams_id" />
        <div class="form-group">
            <label for="order_exams_number" class="col-sm-12 control-label">{LANG.order_exams_number}</label>
            <div class="col-sm-12">
                <input type="number" class="form-control text-center w100" id="order_exams_number" value="" readonly="readonly">
            </div>
        </div>
        <div class="form-group">
            <label for="order_exams_new" class="col-sm-12 control-label">{LANG.order_exams_new}</label>
            <div class="col-sm-12">
                <input type="number" class="form-control text-center w100" name="order_exams_new" id="order_exams_new" value="" min="1">
            </div>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">{LANG.save}</button>
        </div>
    </form>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
    //<![CDATA[
    function nv_change_status(id) {
        var new_status = $('#change_status_' + id).is(':checked') ? true : false;
        if (confirm(nv_is_change_act_confirm[0])) {
            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams&nocache=' + new Date().getTime(), 'change_status=1&id=' + id, function(res) {
                var r_split = res.split('_');
                if (r_split[0] != 'OK') {
                    alert(nv_is_change_act_confirm[2]);
                }
            });
        } else {
            $('#change_status_' + id).prop('checked', new_status ? false : true);
        }
        return;
    }

    $("#order_exams").dialog({
        autoOpen: false,
        show: {
            effect: "blind",
            duration: 500
        },
        hide: {
            effect: "explode",
            duration: 500
        }
    });

    function nv_add_bank(id) {
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams&nocache=' + new Date().getTime(),
            data: 'view_option_add_bank=1&id=' + id,
            dataType: 'json',
            success: function(data) {
                $("#view_option_addbank-sitemodal").find(".modal-title").html(data.title);
                $("#view_option_addbank-sitemodal").find(".modal-body").html(data.html);
                if (data.status === 0) {
                    $("#view_option_addbank-sitemodal").find("#add_bank").hide();
                } else {
                    $("#view_option_addbank-sitemodal").find("#add_bank").show();
                }
                $("#view_option_addbank-sitemodal").find("#add_bank").attr('data-examid', id);
                $("#view_option_addbank-sitemodal").modal()
            }
        });
    }

    $('#add_bank').click(function() {
        var element = $(this).closest('#view_option_addbank-sitemodal').find('.modal-body .well');
        var catid = element.find("#catid").val();

        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams&nocache=' + new Date().getTime(),
            data: 'nv_add_bank=1&exam_id=' + $(this).attr('data-examid') + '&catid=' + catid,
            beforeSend: function() {

                if (confirm('{LANG.question_add_bank}')) {
                    return true;
                } else {
                    $('#view_option_addbank-sitemodal').modal('toggle');
                    return false;
                }
            },
            success: function(data) {

                var r_split = data.split('_');
                if (r_split[0] == 'OK') {
                    alert(r_split[1]);
                    $('#view_option_addbank-sitemodal').modal('toggle');
                    window.location.reload();
                } else {
                    alert(nv_is_change_act_confirm[2]);
                }
            }
        });
    });

    //]]>
</script>
<!-- END: main -->
<!-- BEGIN: view_add_bank -->
<div class="well" style="padding-bottom: 0; margin-bottom: 0;">
    <form action="{NV_BASE_ADMINURL}index.php" method="get">
        <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
        <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
        <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
        <div class="row">
            <div class="col-md-24">
                <div class="form-group">
                    <pre style="border: 1px solid #d20909;
                    background-color: #fff;">{LANG.alert_exam_upload_server}</pre>
                </div>
                <div class="form-group">
                    <select name="catid" id="catid" class="form-control select2 required">
                        <!-- BEGIN: group_cat -->
                        <optgroup label="{label_group}">
                            <!-- BEGIN: cats -->
                            <option value="{CAT.id}">{CAT.title}</option>
                            <!-- END: cats -->
                        </optgroup>
                        <!-- END: group_cat -->
                        <option value="0" style="font-weight: bold"><strong>{LANG.cat_other}</strong></option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- END: view_add_bank -->