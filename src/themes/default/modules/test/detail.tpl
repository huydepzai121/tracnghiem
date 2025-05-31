<!-- BEGIN: not_question -->
<div class="alert alert-warning">{LANG.not_question}</div>
<!-- END: not_question -->
<!-- BEGIN: main -->
<div id="breadcrumbs_mobile" class="col-xs-24 col-sm-24 box-coll hidden-lg hiddent-md ">
    <div class="col-xs-20 col-sm-20 title">{CAT_PARENT.title}</div>
    <!-- BEGIN: listcat_menu -->
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
    <!-- END: listcat_menu -->
</div>
<div class="clearfix"></div>
<div class="detail view-list">
    <div class="panel panel-default result_width edit_panel" data-spy="affix" data-offset-top="250">
        <!--         <div class="panel-heading">{LANG.exams_info}</div> -->
        <div class="panel-body edit_panel">
            <h1 class="m-bottom affix_hidden">{DATA.title}</h1>
            <div class="row">
                <!-- BEGIN: div -->
                <div class="col-lg-12 col-xs-24 col-sm-24 col-md-12 affix_hidden">
                    <!-- END: div -->
                    <!-- BEGIN: nondiv -->
                    <div class="col-lg-8 col-xs-16 col-sm-12 col-md-8 affix_hidden">
                        <!-- END: nondiv -->
                        <div class="row exam-info">
                            <div class="col-xs-24 col-sm-12 col-md-8">
                                <label>{LANG.question_total}</label>: {DATA.num_question}
                            </div>
                            <div class="col-xs-24 col-sm-12 col-md-16">
                                <label>{LANG.time_test}</label>: {DATA.timer} {LANG.min}
                            </div>
                        </div>
                        <!-- BEGIN: price -->
                        <div class="row exam-info">
                            <div class="col-xs-24 price">
                                <label>{LANG.exams_price}</label>: {DATA.price} {DATA.price_unit} /
                                {LANG.exams_price_unit}
                            </div>
                        </div>
                        <!-- END: price -->
                    </div>
                    <!-- BEGIN: div2 -->
                    <div class="col-lg-12 col-xs-24 col-sm-12 col-md-12 text-center">
                        <!-- END: div2 -->
                        <!-- BEGIN: nondiv2 -->
                        <div class="col-lg-8 col-xs-24 col-sm-12 col-md-8">
                            <!-- END: nondiv2 -->
                            <!-- BEGIN: save_test -->
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-8 text-right">
                                <button {DATA.disable_save_action} class="btn btn-success col-lg-24 col-xs-24"
                                    id="btn-save" style="margin-top: 5px;">{DATA.title_save_action}</button>
                            </div>
                            <!-- END: save_test -->
                            <!-- BEGIN: btn_start -->
                            <!-- BEGIN: code -->
                            <div class="col-lg-12 col-xs-24 col-sm-12 col-md-8">
                                <input type="text" id="code" class="form-control float-left m-bottom"
                                    style="margin-top: 5px;" placeholder="{LANG.exam_code_note}...">
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
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-8 text-left m-bottom">
                                <button class="btn btn-primary col-lg-24 col-xs-24" <!-- BEGIN: btn_start_disabled -->
                                    disabled="disabled"
                                    <!-- END: btn_start_disabled -->
                                    id="btn-start" onclick="startExams()" style="margin-top: 5px;">{LANG.exam_start}
                                </button>
                            </div>
                            <!-- BEGIN: begintime -->
                            <span class="text-danger show">{LANG.begintime_note}</span>
                            <!-- END: begintime -->
                            <!-- BEGIN: test_limit_note -->
                            <span class="text-danger">{DATA.test_limit_note}</span>
                            <!-- END: test_limit_note -->
                            <!-- BEGIN: alert_payment -->
                            <span class="text-danger">{DATA.alert_payment}</span>
                            <!-- END: alert_payment -->
                            <!-- BEGIN: alert_permission -->
                            <div class="clearfix"></div>
                            <span class="text-danger show">{DATA.alert_permission}</span>
                            <!-- END: alert_permission -->
                            <script type="text/javascript">
                                var exam_subject_id = '';
                            </script>
                            <!-- BEGIN: exam_subject_id -->
                            <script type="text/javascript">
                                var exam_subject_id = '&exam_subject_id={exam_subject_id}';
                            </script>
                            <!-- END: exam_subject_id -->
                            <script>
                                function startExams() {
                                    $.ajax({
                                            type: 'POST',
                                            url: nv_base_siteurl + 'index.php?' +
                                                nv_lang_variable + '=' + nv_lang_data + '&' +
                                                nv_name_variable + '=' + nv_module_name + '&' +
                                                nv_fc_variable + '=detail&nocache=' + new Date()
                                                .getTime(),
                                            data : 'sendinfo=1&id={DATA.id}&code=' + $('#code').val() + '&price={DATA.price}' + exam_subject_id ,
                                            success: function(data) {
                                                var r_split = data.split('_');
                                                if (r_split[0] == 'OK') {
                                                    alert('{LANG.exam_start_confirm}');
                                                    nv_test_unset_answer();
                                                    nv_test_unset_limit_audio();
                                                    window.location.href = window.location
                                                        .href;
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
                                            url: nv_base_siteurl + 'index.php?' +
                                                nv_lang_variable + '=' + nv_lang_data + '&' +
                                                nv_name_variable + '=' + nv_module_name + '&' +
                                                nv_fc_variable + '=detail&nocache=' + new Date()
                                                .getTime(),
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
                            <!-- END: btn_start -->
                            <!-- BEGIN: countdown -->
                            <script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/jquery.simple.timer.js"></script>
                            <div id="timer-box">
                                <span class="float-left affix_hidden">{LANG.countdown}: </span>
                                <div id="countdown" class="float-left red" data-seconds-left="{TIMER}"></div>
                                <span class="float-left red">&nbsp;{LANG.min} </span>
                                <script>
                                    $('#countdown').startTimer({
                                        onComplete: function(element) {
                                            $.post(script_name + '?' + nv_name_variable + '=' +
                                                nv_module_name + '&' + nv_fc_variable +
                                                '=detail&nocache=' + new Date().getTime(),
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
                            <!-- BEGIN: time_test -->
                            <div id="timer-box">
                                <p>{LANG.time_testting}: {DATA.time_test}</p>
                            </div>
                            <!-- END: time_test -->
                        </div>
                        <!-- BEGIN: button_resize_font -->
                        <div class="col-lg-4 col-xs-10 col-sm-24 col-md-4 text-center">
                            <button class="btn" id="up" style="padding: 5px 10px;">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </button>
                            <span id="font-size"></span>
                            <button class="btn" id="down" style="padding: 5px 10px;">
                                <i class="fa fa-search-minus" aria-hidden="true"></i>
                            </button>
                        </div>
                        <!-- END: button_resize_font -->
                        <div class="col-lg-4 col-xs-10 col-sm-24 col-md-4 text-center"
                            style="position: absolute; right: 0;">
                            <!-- BEGIN: print -->
                            <button class="btn btn-warning" onclick="nv_print('{PRINT_URL}'); return !1;">
                                <em class="fa fa-print">&nbsp;</em>{LANG.print}
                            </button>
                            <!-- END: print -->
                            <!-- BEGIN: btn_exam_save_bottom -->
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
                            <!-- END: btn_exam_save_bottom -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- BEGIN: alert -->
            <div class="alert alert-warning text-center">{LANG.exam_active_alert}</div>
            <!-- END: alert -->
            <!-- BEGIN: description -->
            <div class="panel panel-default get_width">
                <div class="panel-body">
                    <!-- BEGIN: imgposition_left -->
                    <div class="pull-left">
                        <img src="{DATA.image}" alt="{DATA.title}" class="img-thumbnail" width="100">
                    </div>
                    <!-- END: imgposition_left -->
                    <!-- BEGIN: showhometext -->
                    <em>{DATA.hometext}</em>
                    <!-- END: showhometext -->
                    <!-- BEGIN: imgposition_bottom -->
                    <div class="text-center imgposition">
                        <img src="{DATA.image}" alt="{DATA.title}">
                    </div>
                    <!-- END: imgposition_bottom -->
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
            <!-- BEGIN: admin -->
            <div class="m-bottom text-center">{ADMIN}</div>
            <!-- END: admin -->
            <!-- BEGIN: social -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="socialicon list-inline">
                        <li class="facebook">
                            <div class="fb-like" data-href="{SELFURL}" data-layout="button_count" data-action="like"
                                data-show-faces="false" data-share="true">&nbsp;</div>
                        </li>
                        <li>
                            <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                            <div class="zalo-share-button" data-href="{SELFURL}" data-oaid="{OAID}" data-layout="1"
                                data-color="blue" data-customize=false></div>
                        </li>
                        <li><a href="http://twitter.com/share" class="twitter-share-button">Tweet</a></li>
                    </ul>
                </div>
            </div>
            <!-- END: social -->
            {TESTING}
            <!-- BEGIN: source -->
            <p class="m-bottom text-right">
                <strong>{LANG.source}: </strong>{DATA.source}
            </p>
            <!-- END: source -->
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
                        <p class="h3">{LANG.topic}</p>
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
        <script type="text/javascript">
            $(window).resize(function() {
                var width = $('.get_width').width();
                $('.result_width').width(width);
            })
            $(window).resize();
        </script>
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
                if ((e.keyCode == 123 && e.originalEvent && e.originalEvent.code == 'F12') || (e.keyCode ==
                        73 && (e.ctrlKey || e.metaKey) && e.shiftKey) || (e.keyCode == 67 && (e.ctrlKey || e
                        .metaKey) && e.shiftKey) || (e.keyCode == 75 && (e.ctrlKey || e.metaKey) && e
                    .shiftKey) || (e.keyCode == 83 && (e.ctrlKey || e.metaKey) && e.shiftKey) || (e.keyCode ==
                        81 && (e.ctrlKey || e.metaKey) && e.shiftKey) || (e.keyCode == 116 && e.shiftKey && e
                        .originalEvent.code == 'F5') || (e.keyCode == 118 && e.shiftKey && e.originalEvent
                        .code == 'F7') || ((e.ctrlKey || e.metaKey) && (e.keyCode == 88 || e.keyCode == 65 || e
                        .keyCode == 67 || e.keyCode == 86 || e.keyCode == 83))) {
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
