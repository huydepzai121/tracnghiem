<!-- BEGIN: main -->
<div class="test viewlist">
    <!-- BEGIN: loop -->
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- BEGIN: image -->
            <div class="image pull-left">
                <a href="{DATA.link}" title="{DATA.title}"><img src="{DATA.image}" class="img-thumbnail" width="{IMGWIDTH1}" alt="{DATA.title}" /></a>
            </div>
            <!-- END: image -->
            <h2>
                <a href="{DATA.link}" title="{DATA.title}"><strong>{DATA.title}</strong></a>
                <!-- BEGIN: newday -->
                <span class="icon_new"></span>
                <!-- END: newday -->
            </h2>
            <ul class="exam-info css-exam-info list-inline form-tooltip">
                    <li class="pointer" data-toggle="tooltip" data-original-title="{LANG.question_total}"><em class="fa fa-heart-o">&nbsp;</em>{DATA.num_question}<span class="hidden-xs"> {LANG.question_low}</span></li>
                    <li class="pointer" data-toggle="tooltip" data-original-title="{LANG.time_test}"><em class="fa fa-clock-o">&nbsp;</em>{DATA.timer}<span class="hidden-xs"> {LANG.min}</span></li>
               </ul>
            <ul class="list-inline help-block">
                <li><em class="fa fa-clock-o">&nbsp;</em>{DATA.addtime}</li>
                <li><em class="fa fa-search">&nbsp;</em>{LANG.hitstotal}: {DATA.hitstotal}</li>
                <li><em class="fa fa-comment-o">&nbsp;</em>{LANG.hitscm}: {DATA.hitscm}</li>
                <!-- <li><em class="fa fa-user-o">&nbsp;</em>{DATA.fullname}</li> -->
            </ul>
            <!-- BEGIN: hometext -->
            <p class="hometext">{DATA.hometext}</p>
            <!-- END: hometext -->
            <!-- BEGIN: admin -->
            <div class="admin">{ADMIN}</div>
            <!-- END: admin -->
        </div>
    </div>
    <!-- END: loop -->
    <!-- BEGIN: page -->
    <div class="text-center">{PAGE}</div>
    <!-- END: page -->
</div>
<!-- END: main -->