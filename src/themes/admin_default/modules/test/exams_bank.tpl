<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/css/perfect-scrollbar.css" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/perfect-scrollbar.min.js"></script>

<!-- BEGIN: not_allow_use -->
<!-- BEGIN: test_message_danger -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Thông báo!</strong> {test_message_danger}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: test_message_danger -->

<div class="card border-warning mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <div class="alert alert-warning mb-0" <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-info-circle me-2"></i>
                    {LANG.guider_exams_bank}
                </div>
            </div>
            <div class="flex-shrink-0">
                <button class="btn btn-outline-info btn-sm show-msg" data-func="exams_bank"
                        <!-- BEGIN: msg_show -->style="display: none" <!-- END: msg_show -->>
                    <i class="fas fa-question-circle me-1"></i>{LANG.msg}
                </button>
                <button class="btn btn-outline-secondary btn-sm close-msg" data-func="exams_bank"
                        <!-- BEGIN: msg_none -->style="display: none" <!-- END: msg_none -->>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END: not_allow_use -->

<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-search me-2"></i>Tìm kiếm ngân hàng đề thi
        </h5>
    </div>
    <div class="card-body">
        <form action="{NV_BASE_ADMINURL}index.php" method="get">
            <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
            <input type="hidden" name="cat" value="{catid}"/>
            <input type="hidden" name="had_not_identified" value="{had_not_identified}" />

            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input class="form-control" type="text" value="{SEARCH.q}" name="q" maxlength="255"
                               placeholder="{LANG.search_exam_title}" />
                    </div>
                </div>

                <div class="col-md-2">
                    <select class="form-select" name="userPush" id="userPush">
                        <option value="0">{LANG.userid_upload}</option>
                        <!-- BEGIN: userPush -->
                        <option value="{USERPUSH.key}" {USERPUSH.selected}>{USERPUSH.title}</option>
                        <!-- END: userPush -->
                    </select>
                </div>

                <div class="col-md-2">
                    <select class="form-select" name="idsite" id="idsite">
                        <option value="0">{LANG.site_up_exams}</option>
                        <!-- BEGIN: idsite -->
                        <option value="{SITE.key}" selected>{SITE.title}</option>
                        <!-- END: idsite -->
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="dropdown my-dropdown">
                        <button type="button" class="btn btn-outline-secondary w-100 text-start bt-toggle dropdown-toggle"
                                data-bs-toggle="dropdown">
                            <span id="cat_title_select">{cats_select_title}</span>
                        </button>
                        <div class="dropdown-menu w-100 my-dropdown-menu">
                            <div class="accordion" id="list-cat">
                                <div class="accordion-item border-0">
                                    <button class="accordion-button collapsed action-collapse" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse-999999">
                                        <i class="fas fa-globe me-2"></i><strong>{LANG.cat_all}</strong>
                                    </button>
                                </div>
                                <!-- BEGIN: main_cat -->
                                <div class="accordion-item border-0">
                                    <button class="accordion-button collapsed action-collapse" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse-{CAT.id}">
                                        <i class="fas fa-folder me-2"></i><strong>{CAT.title}</strong>
                                    </button>
                                    <div id="collapse-{CAT.id}" class="accordion-collapse collapse ps-container"
                                         style="max-height: 300px; overflow-y: auto;">
                                        <div class="accordion-body">
                                            <div class="cat-content"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: main_cat -->
                                <div class="accordion-item border-0">
                                    <button class="accordion-button collapsed action-collapse" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse-0">
                                        <i class="fas fa-folder-open me-2"></i><strong>{LANG.cat_other}</strong>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-search me-1"></i>{LANG.search_submit}
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <!-- BEGIN: update_bank_cat-->
                    <div class="alert alert-info py-2">
                        <i class="fas fa-sync-alt me-2"></i>
                        <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=update-bank-cat"
                           class="text-decoration-none fw-bold">{LANG.update_bank_cat}</a>
                    </div>
                    <!-- END: update_bank_cat-->
                </div>
            </div>
        </form>
    </div>
</div>
<!-- BEGIN: view_bt_cats-->
<div class="mb-3">
    <a class="btn btn-success"
        href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=exams_bank_cats">
        <i class="fas fa-cogs me-1"></i>{LANG.manage_bank_cats}
    </a>
</div>
<!-- END: view_bt_cats-->
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-database me-2"></i>Ngân hàng đề thi
        </h5>
    </div>
    <div class="card-body p-0">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <!-- BEGIN: thead -->
                    <thead class="">
                        <tr>
                            <th style="width: 60px;" class="text-center">
                                <i class="fas fa-hashtag me-1"></i>{LANG.number}
                            </th>
                            <th style="width: 150px;">
                                <i class="fas fa-globe me-1"></i>{LANG.idsite_upload}
                            </th>
                            <th style="width: 150px;">
                                <i class="fas fa-user me-1"></i>{LANG.userid_upload}
                            </th>
                            <th>
                                <i class="fas fa-file-alt me-1"></i>{LANG.title}
                            </th>
                            <th style="width: 150px;">
                                <i class="fas fa-folder me-1"></i>{LANG.category_capitalize}
                            </th>
                            <th style="width: 250px;" class="text-center">
                                <i class="fas fa-cogs me-1"></i>{LANG.functions}
                            </th>
                        </tr>
                    </thead>
                    <!-- END: thead -->
                    <tbody id="dataList">
                        <!-- BEGIN: loop -->
                        <tr data-tr="{VIEW.id}" class="exam-row">
                            <td class="text-center">
                                <span class="badge bg-primary">{VIEW.number}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{NV_SERVER_PROTOCOL}://{VIEW.domain}" target="_blank"
                                       class="text-decoration-none me-2">
                                        <i class="fas fa-external-link-alt me-1"></i>{VIEW.site_title}
                                    </a>
                                    <a href="{VIEW.filter}" class="btn btn-outline-secondary btn-sm" title="Lọc">
                                        <i class="fas fa-filter"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle text-primary me-2"></i>
                                    <strong>{VIEW.userid}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="exam-info">
                                    <h6 class="mb-1">
                                        <a href="{VIEW.examBank_url}" class="text-decoration-none">
                                            <i class="fas fa-file-alt me-1"></i>{VIEW.title}
                                        </a>
                                    </h6>
                                    <div class="small text-muted">
                                        <div class="mb-1">
                                            <i class="fas fa-question-circle me-1"></i>
                                            <strong>{LANG.num_question}:</strong>
                                            <span class="badge bg-info">{VIEW.num_question}</span>
                                        </div>
                                        <div class="mb-1">
                                            <i class="fas fa-clock me-1"></i>
                                            <strong>{LANG.addtime}:</strong> {VIEW.addtime}
                                        </div>
                                        <div class="text-truncate" style="max-width: 300px;">
                                            {VIEW.description}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{VIEW.catid}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group-vertical btn-group-sm" role="group">
                                    <!-- BEGIN: useExam -->
                                    <a class="btn btn-info btn-sm" href="{VIEW.link_use}"
                                       onclick="return confirm('Bạn có muốn lấy đề thi này xuống không?');"
                                       title="{LANG.bank_exam_use}">
                                        <i class="fas fa-cloud-download-alt me-1"></i>Sử dụng
                                    </a>
                                    <!-- END: useExam -->

                                    <a class="btn btn-outline-primary btn-sm" href="javascript:void(0)"
                                       title="{LANG.content_view}"
                                       onclick="nv_view_content(1, '{VIEW.id}', '{VIEW.title}'); return false;">
                                        <i class="fas fa-eye me-1"></i>Xem
                                    </a>

                                    <!-- BEGIN: funcsAcceptReject -->
                                    <a class="btn btn-success btn-sm" href="javascript:void(0)"
                                       onclick="bank_exam_status('{VIEW.id}', 2); return false;"
                                       title="{LANG.bank_exam_accept}">
                                        <i class="fas fa-check me-1"></i>Duyệt
                                    </a>
                                    <a class="btn btn-warning btn-sm" href="javascript:void(0)"
                                       onclick="bank_exam_status('{VIEW.id}', 3); return false;"
                                       title="{LANG.bank_exam_reject}">
                                        <i class="fas fa-times me-1"></i>Từ chối
                                    </a>
                                    <!-- END: funcsAcceptReject -->

                                    <a href="{VIEW.link_question}" class="btn btn-outline-secondary btn-sm"
                                       title="{LANG.question}">
                                        <i class="fas fa-list me-1"></i>
                                        <span class="badge bg-danger">{VIEW.count_question}</span>
                                    </a>

                                    <!-- BEGIN: main_site -->
                                    <a class="btn btn-outline-primary btn-sm" href="{VIEW.examBank_url}"
                                       title="{LANG.edit}">
                                        <i class="fas fa-edit me-1"></i>Sửa
                                    </a>
                                    <!-- END: main_site -->

                                    <!-- BEGIN: delete -->
                                    <a class="btn btn-danger btn-sm" href="{VIEW.link_delete}"
                                       onclick="return confirm(nv_is_del_confirm[0]);" title="{LANG.delete}">
                                        <i class="fas fa-trash me-1"></i>Xóa
                                    </a>
                                    <!-- END: delete -->
                                </div>
                            </td>
                        </tr>
                        <!-- END: loop -->
                    </tbody>
                    <!-- BEGIN: generate_page -->
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-center bg-light py-3">
                                {NV_GENERATE_PAGE}
                            </td>
                        </tr>
                    </tfoot>
                    <!-- END: generate_page -->
                </table>
            </div>
        </form>
    </div>
</div>

<!-- Enhanced Modal for Bootstrap 5 -->
<div class="modal fade" id="full-sitemodal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title" id="modalLabel">
                    <i class="fas fa-file-alt me-2"></i>Chi tiết đề thi
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <div class="mt-2">Đang tải nội dung...</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>{LANG.close}
                </button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print me-1"></i>In
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>

<!-- BEGIN: perfect_scrollbar_cat -->
<script type="text/javascript">
    new PerfectScrollbar('#collapse-{CAT.id}', {
        suppressScrollY: false
    });
</script>
<!-- END: perfect_scrollbar_cat -->
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function() {
        var cat_other_title = '{LANG.cat_other}';
        var cat_all_title = '{LANG.cat_all}';

        // Enhanced dropdown handling for Bootstrap 5
        $(document).mouseup(function(e) {
            var container = $(".my-dropdown");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.find('.dropdown-menu').removeClass('show');
            }
        });

        $(".my-dropdown .bt-toggle").click(function() {
            $(this).next('.dropdown-menu').toggleClass('show');
        });

        $(".action-collapse").click(function() {
            var target = $(this).attr('data-bs-target');
            var cat_id = target ? target.match(/\d+$/)[0] : null;

            if (cat_id) {
                cat_id = parseInt(cat_id);
                if (cat_id == 999999) {
                    select_catid(0, cat_all_title, 0);
                } else if (cat_id > 0) {
                    var $content = $(target + ' .cat-content');
                    if ($content.length && $content.text().trim().length == 0) {
                        $content.html('<div class="text-center py-2"><div class="spinner-border spinner-border-sm" role="status"></div></div>');
                        $content.load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                        '=exams_bank&main_cat_id=' + cat_id + '&ajax=1');
                    }
                } else {
                    // Trường hợp chọn "Chủ đề khác"
                    select_catid(0, cat_other_title, 1);
                }
            }
        })

        $("#userPush").select2({
            language: "{NV_LANG_INTERFACE}",
            theme: "bootstrap",
            ajax: {
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' +
                    nv_fc_variable + '=exams_bank&get_user_json=1',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection
            // omitted for brevity, see the source of this page
        });

        $("#idsite").select2({
            language: "{NV_LANG_INTERFACE}",
            theme: "bootstrap",
            ajax: {
                url: script_name + '?' + nv_name_variable + '=site&get_list_site_select2=1',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                    };
                },
                processResults: function(data, params) {
                    return {
                        results: data,
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
        });

    });

    function formatRepo(repo) {
        if (repo.loading)
            return repo.text;
        var markup = '<div class="clearfix">' + '<div class="col-sm-19">' + repo.fullname + '</div>' +
            '<div clas="col-sm-5"><span class="show text-right">' + repo.username + '</span></div>' + '</div>';
        markup += '</div></div>';
        return markup;
    }

    function formatRepoSelection(repo) {
        $("#id").html(repo.id);
        $("#fullname").html(repo.fullname);
        $("#username").html(repo.username);
        return repo.fullname || repo.text;
    }

    function bank_exam_status(id, status) {
        var reasonReject = status == 3 ? prompt("{LANG.bank_exam_status_confirm_reject}", "") : "";
        if (status == 2 ? confirm('{LANG.bank_exam_status_confirm_accept}') : reasonReject) {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                    '=exams_bank&nocache=' + new Date().getTime(),
                data: 'bank_exam_accept=1&id=' + id + '&status=' + status + '&reasonReject=' + reasonReject,
                success: function(data) {
                    location.reload();
                }
            });
        }
    }
    // Enhanced select category function
    window.select_catid = function(catid, title, had_not_identified) {
        had_not_identified = had_not_identified || 0;
        $("input[name=cat]").val(catid);
        $("input[name=had_not_identified]").val(had_not_identified);
        $("#cat_title_select").text(title);
        $(".my-dropdown .dropdown-menu").removeClass("show");

        // Visual feedback
        $("#cat_title_select").addClass('text-success');
        setTimeout(function() {
            $("#cat_title_select").removeClass('text-success');
        }, 1000);
    };

    // Enhanced view content function
    window.nv_view_content = function(type, id, title) {
        var modal = new bootstrap.Modal(document.getElementById('full-sitemodal'));
        $('#modalLabel').html('<i class="fas fa-file-alt me-2"></i>' + title);
        $('.modal-body').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Đang tải...</span></div><div class="mt-2">Đang tải nội dung...</div></div>');
        modal.show();

        // Load content via AJAX
        $('.modal-body').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=view-content&id=' + id + '&type=' + type);
    };

    //]]>
</script>
<!-- END: main -->

<!-- BEGIN: list_cat -->
<div class="list-group">
    <!-- BEGIN: cat -->
    <a href="javascript:void(0)" class="list-group-item list-group-item-action"
       onclick="select_catid('{CAT.id}', '{CAT.title}')">
        <i class="fas fa-folder me-2"></i>{CAT.title}
    </a>
    <!-- END: cat -->
</div>
<!-- END: list_cat -->