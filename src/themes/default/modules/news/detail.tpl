<!-- BEGIN: main -->
<link href="{ASSETS_STATIC_URL}/js/highlight/github.min.css" rel="stylesheet">
<div class="news_column panel panel-default">
    <div class="panel-body">
        <h1 class="title margin-bottom-lg">{DETAIL.title}</h1>
        <div class="row margin-bottom-lg">
            <div class="col-md-12">
                <span class="h5">{DETAIL.publtime}</span>
            </div>
            <div class="col-md-12">
                <ul class="list-inline text-right">
                    <!-- BEGIN: allowed_send -->
                    <li><a class="dimgray" title="{LANG.sendmail}" href="#" data-toggle="newsSendMailModal" data-obj="#newsSendMailModal" data-url="{URL_SENDMAIL}" data-ss="{CHECKSESSION}"><em class="fa fa-envelope fa-lg">&nbsp;</em></a></li>
                    <!-- START FORFOOTER -->
                    <div class="modal fade" id="newsSendMailModal" tabindex="-1" role="dialog" data-loaded="false">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="modal-title h2"><strong>{LANG.sendmail}</strong></div>
                                </div>
                                <div class="modal-body"></div>
                            </div>
                        </div>
                    </div>
                    <!-- END FORFOOTER -->
                    <!-- END: allowed_send -->
                    <!-- BEGIN: allowed_print -->
                    <li><a class="dimgray" rel="nofollow" title="{LANG.print}" href="#" data-toggle="newsPrint" data-url="{URL_PRINT}"><em class="fa fa-print fa-lg">&nbsp;</em></a></li>
                    <!-- END: allowed_print -->
                    <!-- BEGIN: allowed_save -->
                    <li><a class="dimgray" rel="nofollow" title="{LANG.savefile}" href="{URL_SAVEFILE}"><em class="fa fa-save fa-lg">&nbsp;</em></a></li>
                    <!-- END: allowed_save -->
                </ul>
            </div>
        </div>
        <!-- BEGIN: no_public -->
        <div class="alert alert-warning">
            {LANG.no_public}
        </div>
        <!-- END: no_public -->
        <!-- BEGIN: show_player -->
        <link rel="stylesheet" href="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/plyr/plyr.css" />
        <script src="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/plyr/plyr.polyfilled.js"></script>
        <div class="news-detail-player">
            <div class="player">
                <audio id="newsVoicePlayer" data-voice-id="{DETAIL.current_voice.id}" data-voice-path="{DETAIL.current_voice.path}" data-voice-title="{DETAIL.current_voice.title}" data-autoplay="{DETAIL.autoplay}"></audio>
            </div>
            <div class="source">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-microphone" aria-hidden="true"></i> <span data-news="voiceval" class="val">{DETAIL.current_voice.title}</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <!-- BEGIN: loop -->
                        <li><a href="#" data-news="voicesel" data-id="{VOICE.id}" data-path="{VOICE.path}" data-tokend="{NV_CHECK_SESSION}">{VOICE.title}</a></li>
                        <!-- END: loop -->
                    </ul>
                </div>
            </div>
            <div class="tools">
                <div class="news-switch">
                    <div class="news-switch-label">
                        {LANG.autoplay}:
                    </div>
                    <div data-news="switchapl" class="news-switch-btn{DETAIL.css_autoplay}" role="button" data-busy="false" data-tokend="{NV_CHECK_SESSION}">
                        <span class="news-switch-slider"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: show_player -->
        <!-- BEGIN: showhometext -->
        <div class="clearfix">
            <!-- BEGIN: imgthumb -->
            <!-- BEGIN: note -->
            <figure class="article left pointer" data-toggle="modalShowByObj" data-obj="#imgpreview">
                <div style="width:{DETAIL.image.width}px;">
                    <p class="text-center"><img alt="{DETAIL.image.alt}" src="{DETAIL.image.src}" alt="{DETAIL.image.note}" class="img-thumbnail"/></p>
                    <figcaption>{DETAIL.image.note}</figcaption>
                </div>
            </figure>
            <div id="imgpreview" style="display:none">
                <p class="text-center"><img alt="{DETAIL.image.alt}" src="{DETAIL.homeimgfile}" srcset="{DETAIL.srcset}" alt="{DETAIL.image.note}" class="img-thumbnail"/></p>
                <figcaption>{DETAIL.image.note}</figcaption>
            </div>
            <!-- END: note -->
            <!-- BEGIN: empty -->
            <figure class="article left noncaption pointer" style="width:{DETAIL.image.width}px;" data-toggle="modalShowByObj" data-obj="#imgpreview">
                <p class="text-center"><img alt="{DETAIL.image.alt}" src="{DETAIL.image.src}" alt="{DETAIL.image.note}" class="img-thumbnail"/></p>
            </figure>
            <div id="imgpreview" style="display:none">
                <p class="text-center"><img alt="{DETAIL.image.alt}" src="{DETAIL.homeimgfile}" srcset="{DETAIL.srcset}" alt="{DETAIL.image.note}" class="img-thumbnail"/></p>
            </div>
            <!-- END: empty -->
            <!-- END: imgthumb -->

            <div class="hometext m-bottom">{DETAIL.hometext}</div>

            <!-- BEGIN: imgfull -->
            <figure class="article center">
                <img alt="{DETAIL.image.alt}" src="{DETAIL.image.src}" srcset="{DETAIL.srcset}" width="{DETAIL.image.width}" class="img-thumbnail"/>
                <!-- BEGIN: note --><figcaption>{DETAIL.image.note}</figcaption><!-- END: note -->
            </figure>
            <!-- END: imgfull -->
        </div>
        <!-- END: showhometext -->
        <!-- BEGIN: related_top -->
        {RELATED_HTML}
        <!-- END: related_top -->
        <!-- BEGIN: navigation -->
        <script type="text/javascript" src="{ASSETS_STATIC_URL}/js/clipboard/clipboard.min.js"></script>
        <div id="navigation" class="navigation-cont auto_nav{DETAIL.auto_nav}" data-copied="{LANG.link_copied}">
            <div class="navigation-head">
                <em class="fa fa-list-ol"></em> {LANG.table_of_contents}
            </div>
            <div class="navigation-body">
                <ol class="navigation">
                    <!-- BEGIN: navigation_item -->
                    <li>
                        <a href="#" data-scroll-to="{NAVIGATION.1}" data-location="{NAVIGATION.2}">{NAVIGATION.0}</a>
                        <!-- BEGIN: sub_navigation -->
                        <ol class="sub-navigation">
                            <!-- BEGIN: sub_navigation_item -->
                            <li>
                                <a href="#" data-scroll-to="{SUBNAVIGATION.1}" data-location="{SUBNAVIGATION.2}">{SUBNAVIGATION.0}</a>
                            </li>
                            <!-- END: sub_navigation_item -->
                        </ol>
                        <!-- END: sub_navigation -->
                    </li>
                    <!-- END: navigation_item -->
                </ol>
            </div>
        </div>
        <!-- END: navigation -->
        <div id="news-bodyhtml" class="bodytext margin-bottom-lg">
            {DETAIL.bodyhtml}
        </div>
        <!-- BEGIN: related_bottom -->
        {RELATED_HTML}
        <!-- END: related_bottom -->
        <!-- BEGIN: files -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-download"></i> <strong>{LANG.files}</strong>
            </div>
            <div class="list-group news-download-file">
                <!-- BEGIN: loop -->
                <div class="list-group-item">
                    <!-- BEGIN: show_quick_viewfile -->
                    <span class="badge">
                        <a role="button" data-toggle="collapse" href="#file-{FILE.key}" aria-expanded="false" aria-controls="file-{FILE.key}">
                            <i class="fa fa-eye" data-rel="tooltip" data-content="{LANG.preview}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewfile -->
                    <!-- BEGIN: show_quick_viewimg -->
                    <span class="badge">
                        <a href="#" data-src="{FILE.src}" data-toggle="newsattachimage">
                            <i class="fa fa-eye" data-rel="tooltip" data-content="{LANG.preview}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewimg -->
                    <a href="{FILE.url}" title="{FILE.titledown} {FILE.title}" download>{FILE.titledown}: <strong>{FILE.title}</strong></a>
                    <!-- BEGIN: content_quick_viewfile -->
                    <div class="clearfix"></div>
                    <div class="collapse" id="file-{FILE.key}" data-src="{FILE.urlfile}" data-toggle="collapsefile" data-loaded="false">
                        <div class="well margin-top">
                            <iframe height="600" scrolling="yes" src="" width="100%"></iframe>
                        </div>
                    </div>
                    <!-- END: content_quick_viewfile -->
                </div>
                <!-- END: loop -->
            </div>
        </div>
        <!-- END: files -->
        <!-- BEGIN: author -->
        <div class="margin-bottom-lg">
            <!-- BEGIN: name -->
            <p class="h5 text-right">
                <strong>{LANG.author}: </strong>{DETAIL.author}
            </p>
            <!-- END: name -->
            <!-- BEGIN: source -->
            <p class="h5 text-right">
                <strong>{LANG.source}: </strong>{DETAIL.source}
            </p>
            <!-- END: source -->
        </div>
        <!-- END: author -->
        <!-- BEGIN: copyright -->
        <div class="alert alert-info margin-bottom-lg">
            {COPYRIGHT}
        </div>
        <!-- END: copyright -->
    </div>
</div>

<!-- BEGIN: keywords -->
<div class="news_column panel panel-default">
    <div class="panel-body">
        <div class="h5">
            <em class="fa fa-tags">&nbsp;</em><strong>{LANG.tags}: </strong><!-- BEGIN: loop --><a title="{KEYWORD}" href="{LINK_KEYWORDS}"><em>{KEYWORD}</em></a>{SLASH}<!-- END: loop -->
        </div>
    </div>
</div>
<!-- END: keywords -->

<!-- BEGIN: adminlink -->
<p class="text-center margin-bottom-lg">
    {ADMINLINK}
</p>
<!-- END: adminlink -->

<!-- BEGIN: allowed_rating -->
<div class="news_column panel panel-default">
    <div class="panel-body">
        <form id="form3B" action="" data-toggle="rating" data-id="{NEWSID}" data-checkss="{NEWSCHECKSS}" data-checked="{DETAIL.numberrating_star}">
            <div class="margin-bottom">
                <section class="rating<!-- BEGIN: disablerating --> disabled<!-- END: disablerating -->">
                    <input type="radio" id="rat_5" name="rate" value="5"/>
                    <label for="rat_5" data-title="{LANG.star_verygood}"></label>
                    <input type="radio" id="rat_4" name="rate" value="4"/>
                    <label for="rat_4" data-title="{LANG.star_good}"></label>
                    <input type="radio" id="rat_3" name="rate" value="3"/>
                    <label for="rat_3" data-title="{LANG.star_ok}"></label>
                    <input type="radio" id="rat_2" name="rate" value="2"/>
                    <label for="rat_2" data-title="{LANG.star_poor}"></label>
                    <input type="radio" id="rat_1" name="rate" value="1"/>
                    <label for="rat_1" data-title="{LANG.star_verypoor}"></label>
                </section>
                <span class="feedback small" data-default="{RATINGFEEDBACK}" data-success="{LANG.rating_success}">{RATINGFEEDBACK}</span>
            </div>
            <div class="ratingInfo margin-top hidden">
                <div id="stringrating">{STRINGRATING}</div>
                <!-- BEGIN: data_rating -->
                <div>
                    {LANG.rating_average}: <span id="numberrating">{DETAIL.numberrating}</span> / <span id="click_rating">{DETAIL.click_rating}</span> {LANG.rating_count}
                </div>
                <!-- END: data_rating -->
            </div>
        </form>
    </div>
</div>
<!-- END: allowed_rating -->

<!-- BEGIN: socialbutton -->
<div class="news_column panel panel-default">
    <div class="panel-body" style="margin-bottom:0">
        <div style="display:flex;align-items:flex-start;">
            <!-- BEGIN: facebook --><div class="margin-right"><div class="fb-like" style="float:left!important;margin-right:0!important" data-href="{DETAIL.link}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></div><!-- END: facebook -->
            <!-- BEGIN: twitter --><div class="margin-right"><a href="http://twitter.com/share" class="twitter-share-button">Tweet</a></div><!-- END: twitter -->
            <!-- BEGIN: zalo --><div><div class="zalo-share-button" data-href="" data-oaid="{ZALO_OAID}" data-layout="1" data-color="blue" data-customize=false></div></div><!-- END: zalo -->
        </div>
     </div>
</div>
<!-- END: socialbutton -->

<!-- BEGIN: comment -->
<div class="news_column panel panel-default">
    <div class="panel-body">
    {CONTENT_COMMENT}
    </div>
</div>
<!-- END: comment -->

<!-- BEGIN: others -->
<div class="news_column panel panel-default">
    <div class="panel-body other-news">
        <!-- BEGIN: topic -->
        <div class="clearfix">
            <p class="h3"><strong>{LANG.topic}</strong></p>
            <div class="clearfix">
                <ul class="detail-related related list-none list-items">
                    <!-- BEGIN: loop -->
                    <li>
                        <em class="fa fa-angle-right">&nbsp;</em>
                        <h4><a href="{TOPIC.link}" {TOPIC.target_blank} <!-- BEGIN: tooltip -->data-placement="{TOOLTIP_POSITION}" data-content="{TOPIC.hometext_clean}" data-img="{TOPIC.imghome}" data-rel="tooltip"<!-- END: tooltip --> title="{TOPIC.title}">{TOPIC.title}</a></h4>
                        <em>({TOPIC.time})</em>
                        <!-- BEGIN: newday -->
                        <span class="icon_new">&nbsp;</span>
                        <!-- END: newday -->
                    </li>
                    <!-- END: loop -->
                </ul>
            </div>
            <p class="text-right">
                <a title="{TOPIC.topictitle}" href="{TOPIC.topiclink}">{LANG.more}</a>
            </p>
        </div>
        <!-- END: topic -->

        <!-- BEGIN: related_new -->
        <p class="h3"><strong>{LANG.related_new}</strong></p>
        <div class="clearfix">
            <ul class="detail-related related list-none list-items">
                <!-- BEGIN: loop -->
                <li>
                    <em class="fa fa-angle-right">&nbsp;</em>
                    <h4><a href="{RELATED_NEW.link}" {RELATED_NEW.target_blank} <!-- BEGIN: tooltip -->data-placement="{TOOLTIP_POSITION}" data-content="{RELATED_NEW.hometext_clean}" data-img="{RELATED_NEW.imghome}" data-rel="tooltip"<!-- END: tooltip --> title="{RELATED_NEW.title}">{RELATED_NEW.title}</a></h4>
                    <em>({RELATED_NEW.time})</em>
                    <!-- BEGIN: newday -->
                    <span class="icon_new">&nbsp;</span>
                    <!-- END: newday -->
                </li>
                <!-- END: loop -->
            </ul>
        </div>
        <!-- END: related_new -->

        <!-- BEGIN: related -->
        <p class="h3"><strong>{LANG.related}</strong></p>
        <div class="clearfix">
            <ul class="detail-related related list-none list-items">
                <!-- BEGIN: loop -->
                <li>
                    <em class="fa fa-angle-right">&nbsp;</em>
                    <h4><a href="{RELATED.link}" {RELATED.target_blank} <!-- BEGIN: tooltip --> data-placement="{TOOLTIP_POSITION}" data-content="{RELATED.hometext_clean}" data-img="{RELATED.imghome}" data-rel="tooltip"<!-- END: tooltip --> title="{RELATED.title}">{RELATED.title}</a></h4>
                    <em>({RELATED.time})</em>
                    <!-- BEGIN: newday -->
                    <span class="icon_new">&nbsp;</span>
                    <!-- END: newday -->
                </li>
                <!-- END: loop -->
            </ul>
        </div>
        <!-- END: related -->
    </div>
</div>
<!-- END: others -->

<script type="text/javascript" src="{ASSETS_STATIC_URL}/js/highlight/highlight.min.js"></script>
<script type="text/javascript">hljs.initHighlightingOnLoad();</script>
<!-- END: main -->

<!-- BEGIN: no_permission -->
<div class="alert alert-info">
    {NO_PERMISSION}
</div>
<!-- END: no_permission -->

<!-- BEGIN: related_articles -->
<div class="margin-bottom-lg">
    <div class="h3 text-bold">{LANG.related_sarticles}:</div>
    <ul class="inline-related-articles">
        <!-- BEGIN: loop -->
        <li>
            <a href="{ARTICLE.link}"{ARTICLE.target_blank}<!-- BEGIN: tooltip --> data-content="{ARTICLE.hometext_clean}" data-img="{ARTICLE.imghome}" data-rel="tooltip"<!-- END: tooltip --> title="{ARTICLE.title}">{ARTICLE.title}</a>
            <!-- BEGIN: newday -->
            <span class="icon_new">&nbsp;</span>
            <!-- END: newday -->
        </li>
        <!-- END: loop -->
    </ul>
</div>
<!-- END: related_articles -->
