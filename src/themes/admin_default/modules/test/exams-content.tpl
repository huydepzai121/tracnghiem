<!-- BEGIN: main -->
{PACKAGE_NOTIICE}
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css">
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery/jquery.timepicker.min.css" rel="stylesheet" />

<!-- BEGIN: error -->
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>{ERROR}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<!-- END: error -->

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>{LANG.exams_info}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-heading me-1"></i>{LANG.exams_title}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-8">
                                <input class="form-control required" type="text" name="title" id="title"
                                       value="{ROW.title}" required placeholder="Nhập tiêu đề đề thi..." />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-link me-1"></i>{LANG.alias}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="alias" value="{ROW.alias}"
                                           id="id_alias" placeholder="Đường dẫn tĩnh..." />
                                    <button class="btn btn-outline-secondary" type="button" onclick="nv_get_alias('id_alias');">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-folder me-1"></i>{LANG.cat}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-8">
                                <select name="catid" id="catid" class="form-select required select2">
                                    <option value="">--- {LANG.cat_select} ---</option>
                                    <!-- BEGIN: cat -->
                                    <option value="{CAT.id}" {CAT.selected}>{CAT.space}{CAT.title}</option>
                                    <!-- END: cat -->
                                </select>
                                <!-- BEGIN: guider_1 -->
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>{link_test_cat}
                                </div>
                                <!-- END: guider_1 -->
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-tags me-1"></i>{LANG.topics}
                            </label>
                            <div class="col-md-8">
                                <select class="form-select" name="topicid" id="topicid">
                                    <!-- BEGIN: rowstopic -->
                                    <option value="{topicid}" {sl}>{topic_title}</option>
                                    <!-- END: rowstopic -->
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-image me-1"></i>{LANG.image}
                            </label>
                            <div class="col-md-8">
                                <div class="row g-2">
                                    <div class="col-8">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="image" value="{ROW.image}"
                                                   id="id_image" placeholder="Đường dẫn hình ảnh..." />
                                            <button class="btn btn-outline-secondary selectfile" type="button">
                                                <i class="fas fa-folder-open"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <select name="image_position" class="form-select">
                                            <!-- BEGIN: imgposition -->
                                            <option value="{IMGPOS.index}" {IMGPOS.selected}>{IMGPOS.value}</option>
                                            <!-- END: imgposition -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN: exams_hometext -->
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-align-left me-1"></i>{LANG.exams_hometext}
                            </label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="hometext" id="hometext"
                                          maxlength="255" rows="3" placeholder="Mô tả ngắn về đề thi...">{ROW.hometext}</textarea>
                            </div>
                        </div>
                        <!-- END: exams_hometext -->

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-file-alt me-1"></i>Mô tả chi tiết
                            </label>
                            <div class="col-md-8">
                                <div class="card border-light">
                                    <div class="card-body p-2">
                                        {ROW.description}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-book me-1"></i>{LANG.sources}
                            </label>
                            <div class="col-md-8">
                                <select class="form-select" name="sourcetext" id="sourcetext">
                                    <!-- BEGIN: source -->
                                    <option value="{SOURCE.sourceid}" selected="selected">{SOURCE.title}</option>
                                    <!-- END: source -->
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-question-circle me-2"></i>{LANG.type_input_question}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-list-ul me-1"></i>{LANG.type_input_question_select}
                        </label>
                        <div class="col-md-8">
                            <div class="d-flex flex-column gap-2">
                                <!-- BEGIN: input_question -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="input_question"
                                           value="{INPUT_QUES.index}" id="input_question_{INPUT_QUES.index}"
                                           {INPUT_QUES.checked}{INPUT_QUES.disabled} />
                                    <label class="form-check-label" for="input_question_{INPUT_QUES.index}">
                                        {INPUT_QUES.value}
                                    </label>
                                </div>
                                <!-- END: input_question -->
                            </div>

                            <div class="mt-2">
                                <div id="unallow_input_question_1" class="alert alert-warning py-2 let_upgrade_input_question" style="display: none">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{LANG.let_upgrade_input_question_1}
                                </div>
                                <div id="unallow_input_question_3" class="alert alert-warning py-2 let_upgrade_input_question" style="display: none">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{LANG.let_upgrade_input_question_3}
                                </div>
                                <div id="unallow_input_question_4" class="alert alert-warning py-2 let_upgrade_input_question" style="display: none">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{LANG.let_upgrade_input_question_4}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="exams_config" {ROW.style_exams_config}>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label fw-bold">
                                <i class="fas fa-cog me-1"></i>Cấu hình đề thi
                            </label>
                            <div class="col-md-8">
                                <select name="exams_config" class="form-select required select2" {DISABLED}>
                                    <option value="0">--- {LANG.exams_config_select} ---</option>
                                    <!-- BEGIN: exams_config -->
                                    <option value="{CONFIG.id}" {CONFIG.selected}>{CONFIG.title}</option>
                                    <!-- END: exams_config -->
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exams_reset_bank"
                                           value="1" id="exams_reset_bank" {ROW.ck_exams_reset_bank} />
                                    <label class="form-check-label" for="exams_reset_bank">
                                        <i class="fas fa-sync-alt me-1"></i>{LANG.exams_reset_bank}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>{LANG.exams_config}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-list-alt me-1"></i>{LANG.exams_type}
                        </label>
                        <div class="col-md-8">
                            <div class="d-flex flex-column gap-2">
                                <!-- BEGIN: question_type -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type"
                                           value="{TYPE.index}" id="type_{TYPE.index}" {TYPE.checked}
                                           onchange="nv_site_change_type($(this));" />
                                    <label class="form-check-label" for="type_{TYPE.index}">
                                        {TYPE.value}
                                    </label>
                                </div>
                                <!-- END: question_type -->
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" id="exams_code" {HIDDEN}>
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-key me-1"></i>{LANG.exams_code}
                        </label>
                        <div class="col-md-8">
                            <input type="text" name="code" class="form-control" value="{ROW.code}"
                                   maxlength="20" placeholder="Mã đề thi..." />
                        </div>
                    </div>
                    <div class="form-group" id="begintime" {HIDDEN}>
                        <label class="col-sm-5 text-right"><strong>{LANG.exams_time}</strong></label>
                        <div class="col-sm-19">
                            <div class="row">
                                <div class="col-xs-24 col-sm-12">
                                    <strong>{LANG.exams_begin_time}</strong>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="input-group">
                                                <input class="form-control datepicker" value="{ROW.begindate}" type="text" name="begindate" placeholder="dd/mm/YYYY" autocomplete="off" /> <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <em class="fa fa-calendar fa-fix">&nbsp;</em>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="input-group">
                                                <input class="form-control timepicker" type="text" name="begintime" value="{ROW.begintime}" placeholder="H:i" autocomplete="off" />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <em class="fa fa-clock-o fa-fix"> </em>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-24 col-sm-12">
                                    <strong>{LANG.exams_end_time}</strong>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="input-group">
                                                <input class="form-control datepicker" value="{ROW.enddate}" type="text" name="enddate" placeholder="dd/mm/YYYY" autocomplete="off" /> <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <em class="fa fa-calendar fa-fix">&nbsp;</em>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="input-group">
                                                <input class="form-control timepicker" type="text" name="endtime" value="{ROW.endtime}" placeholder="H:i" autocomplete="off" /> <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <em class="fa fa-clock-o fa-fix"> </em>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" id="num_question" {ROW.style_num_question}>
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-list-ol me-1"></i>{LANG.num_question}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8">
                            <input type="number" name="num_question" class="form-control required"
                                   value="{ROW.num_question}" maxlength="4" min="1"
                                   placeholder="Nhập số câu hỏi..." />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-trophy me-1"></i>{LANG.ladder}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8">
                            <input type="number" name="ladder" class="form-control required" id="ladder"
                                   value="{ROW.ladder}" maxlength="4" min="0"
                                   placeholder="Điểm đạt..." />
                            <!-- BEGIN: ladder_note -->
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>{LANG.ladder_note}
                            </div>
                            <!-- END: ladder_note -->
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-stopwatch me-1"></i>{LANG.timer} ({LANG.min})
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-8">
                            <input type="number" name="timer" id="timer" class="form-control required"
                                   value="{ROW.timer}" maxlength="4" min="1"
                                   placeholder="Thời gian làm bài (phút)..." />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-file-alt me-1"></i>{LANG.exams_per_page}
                        </label>
                        <div class="col-md-8">
                            <input type="number" name="per_page" class="form-control"
                                   value="{ROW.per_page}" min="0"
                                   placeholder="Số câu hỏi mỗi trang..." />
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>{LANG.exams_per_page_note}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" {HIDDEN}>
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-clock me-1"></i>{LANG.exams_max_time}
                        </label>
                        <div class="col-md-8">
                            <input type="number" name="exams_max_time" class="form-control"
                                   value="{ROW.exams_max_time}" min="0"
                                   placeholder="Thời gian tối đa..." />
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>{LANG.exams_max_time_note}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-random me-1"></i>{LANG.mix_question}
                        </label>
                        <div class="col-md-8">
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mix_question" value="0"
                                           {mix_question_checked0} id="mix_question_0" />
                                    <label class="form-check-label" for="mix_question_0">
                                        {LANG.mix_not}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mix_question" value="1"
                                           {mix_question_checked1} id="mix_question_1" />
                                    <label class="form-check-label" for="mix_question_1">
                                        {LANG.mix_all}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mix_question" value="2"
                                           {mix_question_checked2} id="mix_question_2" />
                                    <label class="form-check-label" for="mix_question_2">
                                        {LANG.mix_part}
                                    </label>
                                </div>
                            </div>
                            <div id="mix_question_value" class="mt-2" {show_hide_mix_question}>
                                <input type="text" name="mix_question_value" class="form-control"
                                       value="{mix_question_value}" placeholder="Nhập pattern..." />
                                <div class="form-text text-danger">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{LANG.pattern_mix_question_guider}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-save me-1"></i>{LANG.way_record}
                        </label>
                        <div class="col-md-8">
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="way_record[]" value="1"
                                           {way_record_1_checked} id="way_record_1" />
                                    <label class="form-check-label" for="way_record_1">
                                        {LANG.way_record_1}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="way_record[]" value="2"
                                           {way_record_2_checked} id="way_record_2" />
                                    <label class="form-check-label" for="way_record_2">
                                        {LANG.way_record_2}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BEGIN: display_useguide -->
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-info me-1"></i>{LANG.display_useguide}
                        </label>
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-3">
                                <!-- BEGIN: loop -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="useguide"
                                           value="{TYPE_USEGUIDE.index}" {TYPE_USEGUIDE.checked}
                                           id="useguide_{TYPE_USEGUIDE.index}" />
                                    <label class="form-check-label" for="useguide_{TYPE_USEGUIDE.index}">
                                        {TYPE_USEGUIDE.value}
                                    </label>
                                </div>
                                <!-- END: loop -->
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-list me-1"></i>{LANG.type_useguide}
                        </label>
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-3">
                                <!-- BEGIN: loop_type -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_useguide"
                                           value="{TYPE_USEGUIDE.index}" {TYPE_USEGUIDE.checked}
                                           id="type_useguide_{TYPE_USEGUIDE.index}" />
                                    <label class="form-check-label" for="type_useguide_{TYPE_USEGUIDE.index}">
                                        {TYPE_USEGUIDE.value}
                                    </label>
                                </div>
                                <!-- END: loop_type -->
                            </div>
                        </div>
                    </div>
                    <!-- END: display_useguide -->

                    <!-- BEGIN: price -->
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-dollar-sign me-1"></i>{LANG.exams_price} ({LANG.exams_price_unit})
                        </label>
                        <div class="col-md-8">
                            <input type="text" name="price" class="form-control" value="{ROW.price}"
                                   placeholder="Nhập giá đề thi..." />
                        </div>
                    </div>
                    <!-- END: price -->

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-bold">
                            <i class="fas fa-shield-alt me-1"></i>{LANG.config_block_copy_paste}
                        </label>
                        <div class="col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="block_copy_paste"
                                       {block_copy_paste_checked} id="block_copy_paste" />
                                <label class="form-check-label" for="block_copy_paste">
                                    {LANG.config_block_copy_paste_note}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- BEGIN: block_cat -->
            <div class="card shadow-sm mb-3" id="groups">
                <div class="card-header bg-secondary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-users me-1"></i>{LANG.groups}
                    </h6>
                </div>
                <div class="card-body p-2" style="max-height: 200px; overflow-y: auto;">
                    <!-- BEGIN: loop -->
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="{BLOCKS.bid}"
                               name="bids[]" {BLOCKS.checked} id="block_{BLOCKS.bid}" />
                        <label class="form-check-label small" for="block_{BLOCKS.bid}">
                            {BLOCKS.title}
                        </label>
                    </div>
                    <!-- END: loop -->
                </div>
            </div>
            <!-- END: block_cat -->

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user-friends me-1"></i>{LANG.exams_groups}
                    </h6>
                </div>
                <div class="card-body p-2" style="max-height: 200px; overflow-y: auto;">
                    <!-- BEGIN: groups -->
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="groups[]"
                               value="{OPTION.value}" {OPTION.checked}{OPTION.disabled}
                               id="groups_{OPTION.value}" />
                        <label class="form-check-label small groups-test {OPTION.class}"
                               for="groups_{OPTION.value}">
                            {OPTION.title}
                        </label>
                    </div>
                    <!-- END: groups -->
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-comments me-1"></i>{LANG.groups_comment}
                    </h6>
                </div>
                <div class="card-body p-2" style="max-height: 200px; overflow-y: auto;">
                    <!-- BEGIN: groups_comment -->
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="groups_comment[]"
                               value="{OPTION.value}" {OPTION.checked}
                               id="groups_comment_{OPTION.value}" />
                        <label class="form-check-label small" for="groups_comment_{OPTION.value}">
                            {OPTION.title}
                        </label>
                    </div>
                    <!-- END: groups_comment -->
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-success text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-1"></i>{LANG.groups_result}
                    </h6>
                </div>
                <div class="card-body p-2" style="max-height: 200px; overflow-y: auto;">
                    <!-- BEGIN: groups_result -->
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="groups_result[]"
                               value="{OPTION.value}" {OPTION.checked}
                               id="groups_result_{OPTION.value}" />
                        <label class="form-check-label small" for="groups_result_{OPTION.value}">
                            {OPTION.title}
                        </label>
                    </div>
                    <!-- END: groups_result -->
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-palette me-1"></i>{LANG.examp_template}
                    </h6>
                </div>
                <div class="card-body p-2">
                    <select class="form-select form-select-sm" name="template">
                        <!-- BEGIN: template -->
                        <option value="{EXAMS_TEMPLATE.index}" {EXAMS_TEMPLATE.selected}>{EXAMS_TEMPLATE.value}</option>
                        <!-- END: template -->
                    </select>
                </div>
            </div>
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-dark text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cogs me-1"></i>Tùy chọn khác
                    </h6>
                </div>
                <div class="card-body p-2">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="random_answer" value="1"
                               {ROW.random_answer_checked} id="random_answer" />
                        <label class="form-check-label small" for="random_answer">
                            {LANG.exams_random_answer}
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="rating" value="1"
                               {ROW.rating_checked} id="rating" />
                        <label class="form-check-label small" for="rating">
                            {LANG.exams_rating}
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="history_save" value="1"
                               {ROW.history_save_checked} id="history_save" />
                        <label class="form-check-label small" for="history_save">
                            {LANG.exams_history_save}
                            <i class="fas fa-question-circle text-info ms-1" data-bs-toggle="tooltip"
                               title="{LANG.exams_history_save_note}"></i>
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="multiple_test" value="1"
                               {ROW.multiple_test_checked} id="multiple_test" />
                        <label class="form-check-label small" for="multiple_test">
                            {LANG.exams_multiple_test}
                        </label>
                    </div>

                    <div class="form-check mb-2 save_max_score {ROW.save_max_score_class}">
                        <input class="form-check-input" {ROW.save_max_score_disabled} type="checkbox"
                               name="save_max_score" value="1" {ROW.save_max_score_checked} id="save_max_score" />
                        <label class="form-check-label small" for="save_max_score">
                            {LANG.save_max_score}
                            <i class="fas fa-question-circle text-info ms-1" data-bs-toggle="tooltip"
                               title="{LANG.save_max_score_note}"></i>
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="print" value="1"
                               {ROW.print_checked} id="print" />
                        <label class="form-check-label small" for="print">
                            {LANG.exams_print}
                            <i class="fas fa-question-circle text-info ms-1" data-bs-toggle="tooltip"
                               title="{LANG.accept_print_and_save_exams}"></i>
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="check_result" value="1"
                               {ROW.check_result_checked} id="check_result" />
                        <label class="form-check-label small" for="check_result">
                            {LANG.check_result}
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="view_mark_after_test" value="1"
                               {ROW.view_mark_after_test_checked} id="view_mark_after_test" />
                        <label class="form-check-label small" for="view_mark_after_test">
                            {LANG.view_mark_after_test}
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="view_question_after_test" value="1"
                               {ROW.view_question_after_test_checked} id="view_question_after_test" />
                        <label class="form-check-label small" for="view_question_after_test">
                            {LANG.view_question_after_test}
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="preview_question_test" value="1"
                               {ROW.preview_question_test_checked} id="preview_question_test" />
                        <label class="form-check-label small" for="preview_question_test">
                            {LANG.config_preview_question}
                            <i class="fas fa-question-circle text-info ms-1" data-bs-toggle="tooltip"
                               title="{LANG.config_preview_question_note}"></i>
                        </label>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-tags me-1"></i>{LANG.keywords}
                    </h6>
                </div>
                <div class="card-body p-2">
                    <select class="form-select form-select-sm" name="keywords[]" id="keywords" multiple="multiple">
                        <!-- BEGIN: keywords -->
                        <option value="{KEYWORDS.tid}" selected="selected">{KEYWORDS.title}</option>
                        <!-- END: keywords -->
                    </select>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="text-center">
                <input type="submit" class="btn btn-primary btn-lg" name="submit" value="{LANG.save}">
                <a class="btn btn-secondary btn-lg ms-2" href="javascript:history.back()">
                    <i class="fas fa-arrow-left me-2"></i>{LANG.cancel}
                </a>
                <!-- BEGIN: clone_exam -->
                <a class="btn btn-success btn-lg ms-2" href="{link_clone_exam}">
                    <i class="fas fa-copy me-2"></i>{LANG.clone}
                </a>
                <!-- END: clone_exam -->
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/notify.min.js"></script>
<script>
    var cachetopic = {};
    $("#AjaxTopicText").autocomplete({
        minLength: 2,
        delay: 500,
        source: function(request, response) {
            var term = request.term;
            if (term in cachetopic) {
                response(cachetopic[term]);
                return;
            }
            $.getJSON(script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable +
                "=topicajax", request,
                function(data, status, xhr) {
                    cachetopic[term] = data;
                    response(data);
                });
        }
    });

    // Initialize timepicker when document is ready
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 30,
        minTime: '30',
        maxTime: '11:59pm',
        defaultTime: 'value',
        startTime: '07:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $(".selectfile").click(function() {
        var area = "id_image";
        var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
        var currentpath = "{CURENTPATH}";
        var type = "image";
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path +
            "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420,
            "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });

    $('#keywords').select2({
        tags: true,
        language: '{NV_LANG_INTERFACE}',
        theme: 'bootstrap',
        tokenSeparators: [','],
        ajax: {
            url: script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable +
                "=exams-content&get_keywords=1",
            processResults: function(data, page) {
                return {
                    results: data
                };
            }
        }
    });

    $(".select2").select2({
        language: "{NV_LANG_INTERFACE}",
        theme: 'bootstrap'
    });

    $("#topicid").select2({
        language: "{NV_LANG_INTERFACE}",
        theme: 'bootstrap',
        tags: true
    });

    $(".datepicker").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: !0,
        changeYear: !0,
        showOtherMonths: !0,
        showOn: "focus",
        yearRange: "c:c+5"
    });

    $('input[name="history_save"], input[name="multiple_test"]').change(function() {
        if ($('input[name="history_save"]').is(':checked') && $('input[name="multiple_test"]').is(':checked')) {
            $('.save_max_score').removeClass('text-through').find('input').prop('disabled', false);
        } else {
            $('.save_max_score').addClass('text-through').find('input').prop('disabled', true);
        }
    });

    $('input[name="input_question"]').change(function() {
        var val = $('input[name="input_question"]:checked').val();
        if (val == 0 || val == 4) {
            $('#num_question').show().find('input').prop('required', true);
            $('#exams_config').hide().find('select').prop('required', false);
        } else if (val == 1) {
            $('#num_question').hide().find('input').prop('required', false);
            $('#exams_config').hide().find('select').prop('required', false);
        } else if (val == 3) {
            $('#num_question').hide().find('input').prop('required', false);
            $('#exams_config').hide().find('select').prop('required', false);
        } else {
            // val == 2
            $('#num_question').hide().find('input').prop('required', false);
            $('#exams_config').show().find('select').prop('required', true);
        }
    });

    $('select[name="exams_config"]').change(function() {
        if ($(this).val() == 0)
            return;
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=exams-content&nocache=' + new Date().getTime(),
            data: 'load_exams_config=1&id=' + $(this).val(),
            success: function(json) {
                if (!json.error) {
                    $('input[name="timer"]').val(json.data.timer);
                    if (json.data.random_question) {
                        $('input[name="random_question"]').prop('checked', true);
                    } else {
                        $('input[name="random_question"]').prop('checked', false);
                    }
                    if (json.data.random_answer) {
                        $('input[name="random_answer"]').prop('checked', true);
                    } else {
                        $('input[name="random_answer"]').prop('checked', false);
                    }
                }
            }
        });
    });

    $("input[name=print").change(function() {
        var checked = $(this).prop("checked");
        if (checked) {
            $("input[name=history_save").prop('checked', true);
        }
        console.log($(this).prop("checked"));
    })

    function nv_get_alias(id) {
        var title = strip_tags($("[name='title']").val());
        if (title != '') {
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=exams-content&nocache=' + new Date().getTime(), 'get_alias_title=' + encodeURIComponent(title),
                function(res) {
                    $("#" + id).val(strip_tags(res));
                });
        }
        return false;
    }

    function nv_site_change_type(_this) {

        if (_this.val() == 0) {
            $('#exams_code').hide();
            $('#begintime').hide();
            $('#begintime').hide();
            $('#test_limit').hide();
            $('#useguide').prop("checked", true);

            $('#groups_5').removeClass('text-through').find('input').prop('disabled', false);
            $('#groups_6').removeClass('text-through').find('input').prop('disabled', false);

            var count = $('.groups-test input').filter(':checked').length;
            if (count == 0) {
                $('#groups_6').removeClass('text-through').find('input').prop('checked', true);
            }
        } else {
            $('#exams_code').show();
            $('#begintime').show();
            $('#test_limit').show();
            $('#useguide').prop("checked", false);

            $('#groups_5').addClass('text-through').find('input').prop('disabled', true).prop('checked', false);
            $('#groups_6').addClass('text-through').find('input').prop('disabled', true).prop('checked', false);

            var count = $('.groups-test input').filter(':checked').length;
            if (count == 0) {
                if (typeof $.notify === 'function') {
                    $.notify('{LANG.error_required_groups}', {
                        className: 'info',
                        position: "right bottom"
                    });
                } else {
                    alert('{LANG.error_required_groups}');
                }
            }
        }
    }
</script>
<!-- BEGIN: auto_get_alias -->
<script type="text/javascript">
    //<![CDATA[
    $("[name='title']").change(function() {
        nv_get_alias('id_alias');
    });
    //]]>
</script>
<!-- END: auto_get_alias -->
<!-- BEGIN: clone_success -->
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function() {
        setTimeout(function() {
            alert('{LANG.clone_success}');
        }, 100)
    });
    //]]>
</script>
<!-- END: clone_success -->
<script>
    // Cập nhật CKEDITOR trước khi submit form
    $('#frm-submit').on('submit', function(e) {
        if (typeof(CKEDITOR) !== "undefined") {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        }
    });

    $("#sourcetext").select2({
        language: "{NV_LANG_INTERFACE}",
        theme: "bootstrap",
        tags: true,
        ajax: {
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                '=exams-content&get_source_json=1',
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
    $("#groups_6 input").change(function(e) {
        var checked = $(e.target).prop('checked');
        $("input[name='groups[]']").prop('checked', checked);
    });
    $("#groups_comment_6 input").change(function(e) {
        var checked = $(e.target).prop('checked');
        $("input[name='groups_comment[]']").prop('checked', checked);
    });
    $("#groups_result_6 input").change(function(e) {
        var checked = $(e.target).prop('checked');
        $("input[name='groups_result[]']").prop('checked', checked);
    });

    $("input[name='groups[]']").change(function(e) {
        var groups = $("input[name='groups[]']");
        var checked = true;
        for (var i = 0; i < groups.length; i++) {
            if ($(groups[i])[0].value != 6) {
                checked &= $(groups[i]).prop('checked');
            }
        }
        $("#groups_6 input").prop('checked', checked);
    });
    $("input[name='groups_comment[]']").change(function(e) {
        var groups = $("input[name='groups_comment[]']");
        var checked = true;
        for (var i = 0; i < groups.length; i++) {
            if ($(groups[i])[0].value != 6) {
                checked &= $(groups[i]).prop('checked');
            }
        }
        $("#groups_comment_6 input").prop('checked', checked);
    });
    $("input[name='groups_result[]']").change(function(e) {
        var groups = $("input[name='groups_result[]']");
        var checked = true;
        for (var i = 0; i < groups.length; i++) {
            if ($(groups[i])[0].value != 6) {
                checked &= $(groups[i]).prop('checked');
            }
        }
        $("#groups_result_6 input").prop('checked', checked);
    });
    $("input[name=mix_question]").change(function(e) {
        var mix_question = $(e.target).val();
        if (mix_question == 2) {
            $("#mix_question_value").fadeIn();
        } else {
            $("#mix_question_value").fadeOut();
        }
    });
</script>
<!-- BEGIN: unallow_input_question -->
<script type="text/javascript">
    var unallow_input_question = [{unallow_input_question}];
    $("input[name=input_question]").change(function(e) {
        $(".let_upgrade_input_question").hide();
        var input_question_value = parseInt($(e.target).val());
        if (unallow_input_question.includes(input_question_value)) {
            $("#exams_config").hide();
            $("#unallow_input_question_" + input_question_value).fadeIn();
        }
    });
</script>
<!-- END: unallow_input_question -->
<!-- BEGIN: price_js -->
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/jquery.number.min.js"></script>
<script>
    $('input[name="price"]').number(true, 0, ',', '.');
</script>
<!-- END: price_js -->
<!-- END: main -->
