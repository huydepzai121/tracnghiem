<!-- BEGIN: main -->
<div id="breadcrumbs_mobile" class="col-xs-24 col-sm-24 box-coll hidden-lg hidden-md ">
    <div class="col-xs-20 col-sm-20 title">{CAT_PARENT.title}</div>
    <!-- BEGIN: loop -->
    <div class="col-xs-4 col-sm-4">
        <button class="btn-coll">
            <i class="fa fa-chevron-up fa-bars" aria-hidden="true"></i>
        </button>
    </div>
    <div class="listcat collapse">
        <!-- BEGIN: loop -->
        <div class="col-xs-12 col-sm-12">
            <a class="breadum_coll" href="{LISTCAT.link}" title="{LISTCAT.title}">{LISTCAT.title}</a>
        </div>
        <!-- END: loop -->
    </div>
    <!-- END: loop -->
</div>
<div class="row detail test-gird">
    <div class="col-xs-24 col-sm-24 col-md-24">
        <div class="row">
            <div class="col-md-8 sticky-exams">
                <!-- BEGIN: countdown -->
                <script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/jquery.simple.timer.js"></script>
                <div id="timer-box" class="template2">
                    <span>{LANG.countdown}</span>
                    <div id="countdown" data-seconds-left="{TIMER}"></div>
                    <script>
                        $('#countdown').startTimer({
                            onComplete: function(element) {
                                $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' +
                                    nv_fc_variable + '=detail&nocache=' + new Date().getTime(),
                                    'set_end_time=1',
                                    function(res) {
                                        if (res == 'OK') {
                                            nv_save_test(1);
                                        } else {
                                            alert('{LANG.error_unknow}');
                                        }
                                    });
                            }
                        });
                        setTimeout(
                        	function(){
                                // $("#countdown").effect( "pulsate", 1000);
                                setInterval(function(){blink()}, 500);
                            },{TIMER_DANGER}
                        );

                        function blink() {
                            $("#countdown").fadeTo(100, 0.1).fadeTo(200, 1.0);
                            // $("#countdown").fadeTo('slow', 0.25).fadeTo('slow', 1.0);
                        }
                    </script>
                </div>
                <!-- END: countdown -->
                <div class="template2">
                    <h1>{DATA.title}</h1>
                    <ul class="exam-info">
                        <li><label>{LANG.question_total}</label>: {DATA.num_question}</li>
                        <li><label>{LANG.time_test}</label>: {DATA.timer} {LANG.min}</li>
                        <!-- BEGIN: price -->
                        <li><label>{LANG.exams_price}</label>: {DATA.price} {DATA.price_unit} / {LANG.exams_price_unit}
                        </li>
                        <!-- END: price -->
                        <!-- BEGIN: user_info -->
                        <li><label>{LANG.tester_info_fullname}</label> {USER_INFO.full_name}</li>
                        <!-- BEGIN: loop -->
                        <li><label>{FIELD.title}</label>: {FIELD.value}</li>
                        <!-- END: loop -->
                        <!-- END: user_info -->
                    </ul>
                </div>
                <div class="template2">
                    <!-- BEGIN: save_test -->
                    <button {DATA.disable_save_action} class="btn btn-success m-bottom"
                        id="btn-save">{DATA.title_save_action}</button>
                    <!-- END: save_test -->
                    <!-- BEGIN: btn_start -->
                    <!-- BEGIN: code -->
                    <div class="form-group">
                        <input type="text" id="code" style="width: 150px; margin: auto" class="form-control m-bottom"
                            placeholder="{LANG.exam_code_note}...">
                        <p class="text-red">{LANG.exam_code_warning}</p>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#code').on('keypress', function(event) {
                                if (event.keyCode === 13) {
                                    event.preventDefault();
                                    startExams();
                                }
                            });
                            $('#code').on('keyup', function() {
                                if ($(this).val().length > 0) {
                                    $('#btn-start').attr('disabled', false);
                                } else {
                                    $('#btn-start').attr('disabled', true);
                                }
                            });
                        });
                    </script>
                    <!-- END: code -->
                    <button class="btn btn-primary m-bottom" <!-- BEGIN: btn_start_disabled -->
                        disabled="disabled"
                        <!-- END: btn_start_disabled -->
                        id="btn-start" onclick="startExams()">{LANG.exam_start}
                    </button>
                    <script type="text/javascript">
                        var exam_subject_id = '';
                    </script>
                    <!-- BEGIN: exam_subject_id -->
                    <script type="text/javascript">
                        var exam_subject_id = '&exam_subject_id={exam_subject_id}';
                    </script>
                    <!-- END: exam_subject_id -->
                    <script type="text/javascript">
                        function startExams() {
                            $.ajax({
                                type: 'POST',
                                url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data +
                                    '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable +
                                    '=detail&nocache=' + new Date().getTime(),
                                data : 'sendinfo=1&id={DATA.id}&code=' + $('#code').val() + '&price={DATA.price}' + exam_subject_id ,
                                success: function(data) {
                                    //console.log('data=', data);
                                    var r_split = data.split('_');
                                    if (r_split[0] == 'OK') {
                                        alert('{LANG.exam_start_confirm}');
                                        window.location.href = window.location.href;
                                    } else {
                                        alert(r_split[1]);
                                    }
                                }
                            });
                        }
                        $(document).ready(function() {
                            $('#btn-save').click(function() {
                                $.ajax({
                                    type: 'POST',
                                    dataType: "json",
                                    url: nv_base_siteurl + 'index.php?' + nv_lang_variable +
                                        '=' + nv_lang_data + '&' + nv_name_variable + '=' +
                                        nv_module_name + '&' + nv_fc_variable +
                                        '=detail&nocache=' + new Date().getTime(),
                                    data : 'save_exam=1&id={DATA.id}',
                                    success: function(data) {
                                        if (data.status == 0) {
                                            alert(data.message);
                                            loginForm('');
                                        } else if (data.status == 2) {
                                            modalShow('', data.message);
                                        } else if (data.status == 1) {
                                            $('#btn-save').attr('disabled', true);
                                            $('#btn-save').html('<i class="fa fa-check" aria-hidden="true"></i>&nbsp;{LANG.exam_saved}');
                                        }
                                    }
                                });
                            });
                        });
                    </script>
                    <!-- BEGIN: begintime -->
                    <p class="text-danger">{LANG.begintime_note}</p>
                    <!-- END: begintime -->
                    <!-- BEGIN: test_limit_note -->
                    <p class="text-danger">{DATA.test_limit_note}</p>
                    <!-- END: test_limit_note -->
                    <!-- BEGIN: alert_permission -->
                    <p class="alert alert-danger">{DATA.alert_permission}</p>
                    <!-- END: alert_permission -->
                    <!-- BEGIN: alert_payment -->
                    <p class="alert alert-danger">{DATA.alert_payment}</p>
                    <!-- END: alert_payment -->
                    <!-- END: btn_start -->
                    <!-- BEGIN: button_test -->
                    <button type="submit" name="submit" class="btn btn-success" onclick="nv_save_test(0);">
                        <em class="fa fa-floppy-o">&nbsp;</em>{LANG.exams_success}
                    </button>
                    <!-- BEGIN: btn_exit_test -->
                    &nbsp; <a href="" class="cancelLink" onclick="nv_exit_test()"> {LANG.exams_exit} </a>
                    <!-- END: btn_exit_test -->
                    <script type="text/javascript">
                        var exams_exit_confirm = '{LANG.exams_exit_confirm}';
                        var url_back_module = '{url_back_module}';
                    </script>
                    <!-- END: button_test -->
                    <!-- BEGIN: time_test -->
                    <div id="timer-box">
                        <p>{LANG.time_test}</p>
                        {DATA.time_test}
                    </div>
                    <!-- BEGIN: print -->
                    <br />
                    <button class="btn btn-warning btn-xs" onclick="nv_print('{PRINT_URL}'); return !1;">
                        <em class="fa fa-print">&nbsp;</em>{LANG.print}
                    </button>
                    <!-- END: print -->
                    <!-- END: time_test -->
                </div>
                <!-- BEGIN: button_resize_font -->
                <div class="template2">
                    <span><strong>{LANG.button_resize_font}</strong></span>
                    <br>
                    <br>
                    <button class="btn" id="up" style="padding: 5px 10px;">
                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                    </button>
                    <span id="font-size"></span>
                    <button class="btn" id="down" style="padding: 5px 10px;">
                        <i class="fa fa-search-minus" aria-hidden="true"></i>
                    </button>
                </div>
                <!-- END: button_resize_font -->
                <!-- BEGIN: share_now -->
                <div class="row template2 margin-left margin-right">
                    <div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 share_now">
                        <div class="col-md-24">
                            <h1 class="text-center">{LANG.share_now}</h1>
                        </div>
                        <div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 text-center">
                            <ul class="social-network social-circle">
                                <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={URL_SHARE}"
                                        class="icoFacebook share-button" title="Facebook"><i
                                            class="fa fa-facebook"></i></a></li>
                                <!-- BEGIN: zalo_share_button -->
                                <li>
                                    <script src="https://sp.zalo.me/plugins/sdk.js"></script> <a
                                        class="zalo-share-button pointer" data-href="{URL_SHARE}" data-oaid="{OAID}"
                                        data-layout="2" data-color="blue" data-customize=true><i
                                            class="zb-logo-zalo"></i></a>
                                </li>
                                <!-- END: zalo_share_button -->
                                <li><a target="_blank" href="https://twitter.com/share?text=&url={URL_SHARE}"
                                        class="icoTwitter share-button" title="Twitter"><i
                                            class="fa fa-twitter"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END: share_now -->
                <!-- BEGIN: admin -->
                <div class="m-bottom text-center">{ADMIN}</div>
                <!-- END: admin -->
            </div>
            <div class="col-md-16">
                <!-- BEGIN: alert -->
                <div class="alert alert-warning text-center">{LANG.exam_active_alert}</div>
                <!-- END: alert -->
                <!-- BEGIN: description -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <!-- BEGIN: hometext -->
                        <p class="m-bottom">
                            <strong>{DATA.hometext}</strong>
                        </p>
                        <!-- END: hometext -->
                        <p>{DATA.description}</p>
                    </div>
                </div>
                <!-- END: description -->
                <!-- BEGIN: help_content -->
                <div class="panel panel-default">
                    <div class="panel-heading">{LANG.guide_test}</div>
                    <div class="panel-body">{DATA.help_content}</div>
                </div>
                <!-- END: help_content -->
                {TESTING}
                <!-- BEGIN: source -->
                <p class="m-bottom text-right">
                    <strong>{LANG.source}: </strong>{DATA.source}
                </p>
                <!-- END: source -->
            </div>
        </div>
    </div>



    <div class="col-xs-24 col-sm-24 col-md-24">
        <!-- BEGIN: keywords -->
        <div class="news_column panel panel-default">
            <div class="panel-body">
                <div class="h5">
                    <em class="fa fa-tags">&nbsp;</em><strong>{LANG.keywords}: </strong>
                    <!-- BEGIN: loop -->
                    <a title="{KEYWORD}" href="{LINK_KEYWORDS}"><em>{KEYWORD}</em></a>{SLASH}
                    <!-- END: loop -->
                </div>
            </div>
        </div>
        <!-- END: keywords -->
        <!-- BEGIN: comment -->
        <div class="panel panel-default">
            <div class="panel-body">{COMMENT}</div>
        </div>
        <!-- END: comment -->
        <!-- BEGIN: tested -->
        <div class="alert alert-info text-center">{LANG.exams_tested}</div>
        <!-- END: tested -->
        <!-- BEGIN: others -->
        <div class="news_column panel panel-default">
            <div class="panel-body other-news">
                <!-- BEGIN: other -->
                <div class="clearfix m-bottom">
                    <p class="h3">
                        <strong>{LANG.other}</strong>
                    </p>
                    <div class="clearfix">
                        <ul class="related">
                            <!-- BEGIN: loop -->
                            <li>
                                <h4>
                                    <a href="{OTHER.link}" title="{OTHER.title}"><em
                                            class="fa fa-angle-right">&nbsp;</em>{OTHER.title}</a>
                                    <!-- BEGIN: newday -->
                                    <span class="icon_new"></span>
                                    <!-- END: newday -->
                                </h4>
                            </li>
                            <!-- END: loop -->
                        </ul>
                    </div>
                </div>
                <!-- END: other -->
                <!-- BEGIN: topic -->
                <div class="clearfix m-bottom">
                    <p class="h3">
                        <strong>{LANG.topic}</strong>
                    </p>
                    <div class="clearfix">
                        <ul class="related">
                            <!-- BEGIN: loop -->
                            <li>
                                <h4>
                                    <a href="{TOPIC.link}" title="{TOPIC.title}"><em
                                            class="fa fa-angle-right">&nbsp;</em>{TOPIC.title}</a>
                                    <!-- BEGIN: newday -->
                                    <span class="icon_new"></span>
                                    <!-- END: newday -->
                                </h4>
                            </li>
                            <!-- END: loop -->
                        </ul>
                    </div>
                    <p class="text-right">
                        <a title="{LANG.more}" href="{DATA.topiclink}">{LANG.more}</a>
                    </p>
                </div>
                <!-- END: topic -->
                <!-- BEGIN: related_new -->
                <p class="h3">
                    <strong>{LANG.related_new}</strong>
                </p>
                <div class="clearfix m-bottom">
                    <ul class="related">
                        <!-- BEGIN: loop -->
                        <li>
                            <h4>
                                <a href="{RELATED_NEW.link}" title="{RELATED_NEW.title}"><em
                                        class="fa fa-angle-right">&nbsp;</em>{RELATED_NEW.title}</a>
                                <!-- BEGIN: newday -->
                                <span class="icon_new"></span>
                                <!-- END: newday -->
                            </h4>
                        </li>
                        <!-- END: loop -->
                    </ul>
                </div>
                <!-- END: related_new -->
                <!-- BEGIN: related -->
                <p class="h3">
                    <strong>{LANG.related}</strong>
                </p>
                <div class="clearfix">
                    <ul class="related">
                        <!-- BEGIN: loop -->
                        <li>
                            <h4>
                                <a href="{RELATED.link}" {RELATED.target_blank}><em
                                        class="fa fa-angle-right">&nbsp;</em>{RELATED.title}</a>
                                <!-- BEGIN: newday -->
                                <span class="icon_new"></span>
                                <!-- END: newday -->
                            </h4>
                        </li>
                        <!-- END: loop -->
                    </ul>
                </div>
                <!-- END: related -->
            </div>
        </div>
        <!-- END: others -->
    </div>
</div>
<!-- BEGIN: alert_close_browser -->
<script>
    window.onbeforeunload = function(e) {
        e = e || window.event;
        // For IE and Firefox prior to version 4
        if (e) {
            e.returnValue = 'Any string';
        }
        // For Safari
        return 'Any string';
    };
</script>
<!-- END: alert_close_browser -->
<!-- BEGIN: block_copy_paste -->
<script>
    jQuery(window).on('keydown', function(e) {
        if ((e.keyCode == 123 && e.originalEvent && e.originalEvent.code == 'F12') || (e.keyCode == 73 && (e
                .ctrlKey || e.metaKey) && e.shiftKey) || (e.keyCode == 67 && (e.ctrlKey || e.metaKey) && e
                .shiftKey) || (e.keyCode == 75 && (e.ctrlKey || e.metaKey) && e.shiftKey) || (e.keyCode == 83 &&
                (e.ctrlKey || e.metaKey) && e.shiftKey) || (e.keyCode == 81 && (e.ctrlKey || e.metaKey) && e
                .shiftKey) || (e.keyCode == 116 && e.shiftKey && e.originalEvent.code == 'F5') || (e.keyCode ==
                118 && e.shiftKey && e.originalEvent.code == 'F7') || ((e.ctrlKey || e.metaKey) && (e.keyCode ==
                88 || e.keyCode == 65 || e.keyCode == 67 || e.keyCode == 86 || e.keyCode == 83))) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
    jQuery(document).off('contextmenu').on('contextmenu', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
</script>
<!-- END: block_copy_paste -->
<!-- END: main -->
