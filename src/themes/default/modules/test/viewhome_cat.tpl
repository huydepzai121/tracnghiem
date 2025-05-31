<!-- BEGIN: main -->
<div class="viewhome_cat">
    <!-- BEGIN: indexfile_2 -->
    <div class="viewcat_main_bottom">
        <!-- BEGIN: cat -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="pull-left">
                    <a href="{CAT.link}" title="{CAT.title}">{CAT.title}</a>
                </h2>
                <div class="pull-right">
                    <!-- BEGIN: rss -->
                    <a class="rss pull-right" href="{CAT.link_rss}" title=""><em class="fa fa-rss">&nbsp;</em></a>
                    <!-- END: rss -->
                    <!-- BEGIN: link_pullright -->
                    <ul class='ul_pull hidden-xs hidden-sm'>
                        <!-- BEGIN: loop -->
                        <li><a href="{DATA_PANEL.link}">{DATA_PANEL.title}</a></li>
                        <!-- END: loop -->
                    </ul>
                    <span class="pull-right menu-title">
                        <div class="button_st">
                            <div class="dropdown">
                                <!-- BEGIN: button_drop -->
                                <button type="button" data-toggle="dropdown" class="fa fa-angle-down hidden-md hidden-lg">&nbsp;</button>
                                <!-- END: button_drop -->
                                <ul class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <!-- BEGIN: loop_mobile -->
                                    <li><a title="{DATA_PANEL.title}" href="{DATA_PANEL.link}">{DATA_PANEL.title}</a></li>
                                    <!-- END: loop_mobile -->
                                </ul>
                            </div>
                        </div>
                    </span>
                    <!-- END: link_pullright -->
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <!-- BEGIN: first -->
                <div class="m-bottom">
                    <!-- BEGIN: image -->
                    <div class="image pull-left">
                        <a href="{DATA.link}" title="{DATA.title}"><img src="{DATA.image}" class="img-thumbnail" width="{IMGWIDTH1}" alt="{DATA.title}" /></a>
                    </div>
                    <!-- END: image -->
                    <h3>
                        <a href="{DATA.link}" title="{DATA.title}"><strong>{DATA.title}</strong></a>
                        <!-- BEGIN: newday -->
                        <span class="icon_new"></span>
                        <!-- END: newday -->
                    </h3>
                    <!-- BEGIN: hometext -->
                    <p>{DATA.hometext}</p>
                    <!-- END: hometext -->
                    <div class="clearfix"></div>
                </div>
                <!-- END: first -->
                <!-- BEGIN: related -->
                <ul class="other">
                    <!-- BEGIN: loop -->
                    <li><h3>
                            <a href="{DATA.link}" title="{DATA.title}">{DATA.title}</a>
                            <!-- BEGIN: newday -->
                            <span class="icon_new"></span>
                            <!-- END: newday -->
                        </h3></li>
                    <!-- END: loop -->
                </ul>
                <!-- END: related -->
            </div>
        </div>
        <!-- END: cat -->
    </div>
    <!-- END: indexfile_2 -->
    <!-- BEGIN: indexfile_3 -->
    <div class="viewcat_main_right">
        <!-- BEGIN: cat -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{CAT.link}" title="{CAT.title}">{CAT.title}</a>
                <div class="pull-right">
                    <!-- BEGIN: rss -->
                    <a class="rss pull-right" href="{CAT.link_rss}" title=""><em class="fa fa-rss">&nbsp;</em></a>
                    <!-- END: rss -->
                    <!-- BEGIN: link_pullright -->
                    <ul class='ul_pull hidden-xs hidden-sm'>
                        <!-- BEGIN: loop -->
                        <li><a href="{DATA_PANEL.link}">{DATA_PANEL.title}</a></li>
                        <!-- END: loop -->
                    </ul>
                    <span class="pull-right menu-title">
                        <div class="button_st">
                            <div class="dropdown">
                                <!-- BEGIN: button_drop -->
                                <button type="button" data-toggle="dropdown" class="fa fa-angle-down hidden-md hidden-lg">&nbsp;</button>
                                <!-- END: button_drop -->
                                <ul class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <!-- BEGIN: loop_mobile -->
                                    <li><a title="{DATA_PANEL.title}" href="{DATA_PANEL.link}">{DATA_PANEL.title}</a></li>
                                    <!-- END: loop_mobile -->
                                </ul>
                            </div>
                        </div>
                    </span>
                    <!-- END: link_pullright -->
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <!-- BEGIN: first -->
                    <div class="col-xs-24 col-sm-12 col-md-14">
                        <div class="m-bottom">
                            <!-- BEGIN: image -->
                            <div class="image pull-left">
                                <a href="{DATA.link}" title="{DATA.title}"><img src="{DATA.image}" class="img-thumbnail" width="{IMGWIDTH1}" alt="{DATA.title}" /></a>
                            </div>
                            <!-- END: image -->
                            <h2>
                                <a href="{DATA.link}" title="{DATA.title}">{DATA.title}</a>
                                <!-- BEGIN: newday -->
                                <span class="icon_new"></span>
                                <!-- END: newday -->
                            </h2>
                            <!-- BEGIN: hometext -->
                            <p>{DATA.hometext}</p>
                            <!-- END: hometext -->
                        </div>
                    </div>
                    <!-- END: first -->
                    <!-- BEGIN: related -->
                    <div class="col-xs-24 col-sm-12 col-md-10">
                        <ul class="other">
                            <!-- BEGIN: loop -->
                            <li><h3>
                                    <a href="{DATA.link}" title="{DATA.title}">{DATA.title}</a>
                                    <!-- BEGIN: newday -->
                                    <span class="icon_new"></span>
                                    <!-- END: newday -->
                                </h3></li>
                            <!-- END: loop -->
                        </ul>
                    </div>
                    <!-- END: related -->
                </div>
            </div>
        </div>
        <!-- END: cat -->
    </div>
    <!-- END: indexfile_3 -->
    <!-- BEGIN: indexfile_5 -->
    <div class="viewcat_main_bottom_large">
        <!-- BEGIN: cat -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{CAT.link}" title="{CAT.title}">{CAT.title}</a>
                <div class="pull-right">
                    <!-- BEGIN: rss -->
                    <a class="rss pull-right" href="{CAT.link_rss}" title=""><em class="fa fa-rss">&nbsp;</em></a>
                    <!-- END: rss -->
                    <!-- BEGIN: link_pullright -->
                    <ul class='ul_pull hidden-xs hidden-sm'>
                        <!-- BEGIN: loop -->
                        <li><a href="{DATA_PANEL.link}">{DATA_PANEL.title}</a></li>
                        <!-- END: loop -->
                    </ul>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light visible-xs visible-sm" style="min-height: unset; position: relative;">
                        <!-- BEGIN: button_drop -->
                        <button class="navbar-toggler button-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown_{BUTTON_ID}" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-angle-down"> </i>
                        </button>
                        <!-- END: button_drop -->
                        <div class="collapse navbar-collapse" id="navbarNavDropdown_{BUTTON_ID}">
                            <ul class="navbar-nav navbar-mobile">
                                <!-- BEGIN: loop_mobile -->
                                <li><a title="{DATA_PANEL.title}" href="{DATA_PANEL.link}">{DATA_PANEL.title}</a></li>
                                <!-- END: loop_mobile-->
                            </ul>
                        </div>
                    </nav>
                    <!-- END: link_pullright -->
                </div>
            </div>
            <div class="panel-body">
                <!-- BEGIN: subcat -->
                <div class="list">
                    <!-- BEGIN: image -->
                    <div class="image pull-left">
                        <a href="{SUBCAT.link}" title="{SUBCAT.title}"><img src="{SUBCAT.image}" class="img-thumbnail" width="{IMGWIDTH1}" alt="{SUBCAT.title}" /></a>
                    </div>
                    <!-- END: image -->
                    <h2>
                        <a href="{SUBCAT.link}" title="{SUBCAT.title}">{SUBCAT.title}</a>
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <!-- END: subcat -->
            </div>
        </div>
        <!-- END: cat -->
    </div>
    <!-- END: indexfile_5 -->
    <!-- BEGIN: indexfile_4 -->
    <div class="viewcat_two_column">
        <div class="row">
            <!-- BEGIN: cat -->
            <div class="col-xs-24 col-sm-12 col-md-12 two_column">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{CAT.link}" title="{CAT.title}">{CAT.title}</a>
                        <!-- BEGIN: rss -->
                        <a class="rss pull-right" href="{CAT.link_rss}" title=""><em class="fa fa-rss">&nbsp;</em></a>
                        <!-- END: rss -->
                    </div>
                    <div class="panel-body">
                        <!-- BEGIN: first -->
                        <div class="m-bottom">
                            <!-- BEGIN: image -->
                            <div class="image pull-left">
                                <a href="{DATA.link}" title="{DATA.title}"><img src="{DATA.image}" class="img-thumbnail" width="{IMGWIDTH1}" alt="{DATA.title}" /></a>
                            </div>
                            <!-- END: image -->
                            <h2>
                                <a href="{DATA.link}" title="{DATA.title}">{DATA.title}</a>
                                <!-- BEGIN: newday -->
                                <span class="icon_new"></span>
                                <!-- END: newday -->
                            </h2>
                            <!-- BEGIN: hometext -->
                            <p>{DATA.hometext}</p>
                            <!-- END: hometext -->
                            <div class="clearfix"></div>
                        </div>
                        <!-- END: first -->
                        <!-- BEGIN: related -->
                        <ul class="other">
                            <!-- BEGIN: loop -->
                            <li><h3>
                                    <a href="{DATA.link}" title="{DATA.title}">{DATA.title}</a>
                                    <!-- BEGIN: newday -->
                                    <span class="icon_new"></span>
                                    <!-- END: newday -->
                                </h3></li>
                            <!-- END: loop -->
                        </ul>
                        <!-- END: related -->
                    </div>
                </div>
            </div>
            <!-- END: cat -->
        </div>
    </div>
    <script type="text/javascript">
                    var cat2ColTimer;
                    $.scrollbarWidth = function() {
                        var a, b, c;
                        if (c === undefined) {
                            a = $('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo('body');
                            b = a.children();
                            c = b.innerWidth() - b.height(99).innerWidth();
                            a.remove()
                        }
                        return c
                    };
                    function fixColumnHeight() {
                        var winW = $(document).width() + $.scrollbarWidth();
                        if (winW < 992) {
                            $('.two_column .panel-body').height('auto');
                        } else {
                            $.each($('.two_column .panel-body'), function(k, v) {
                                if (k % 2 == 0) {
                                    $($('.two_column .panel-body')[k]).height('auto');
                                    $($('.two_column .panel-body')[k + 1]).height('auto');
                                    var height1 = $($('.two_column .panel-body')[k]).height();
                                    var height2 = $($('.two_column .panel-body')[k + 1]).height();
                                    var height = (height1 > height2 ? height1 : height2);
                                    $($('.two_column .panel-body')[k]).height(height);
                                    $($('.two_column .panel-body')[k + 1]).height(height);
                                }
                            });
                        }
                    }
                    $(window).on('load', function() {
                        cat2ColTimer = setTimeout(function() {
                            fixColumnHeight();
                        }, 100)
                    });
                    $(function() {
                        $(window).resize(function() {
                            clearTimeout(cat2ColTimer)
                            cat2ColTimer = setTimeout(function() {
                                fixColumnHeight();
                            }, 100)
                        });
                    });
                </script>
    <!-- END: indexfile_4 -->
</div>
<!-- END: main -->
