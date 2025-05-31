<!-- BEGIN: main -->
<div class="test">
    <div class="test viewlist">
        <!-- BEGIN: examinations_subject -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="image pull-left">
                    <a href="{ROW.link_detail}" title="{ROW.title}" target="_self">
                        <img src="{ROW.image_url}" class="img-thumbnail" width="100"
                            alt="{ROW.link_detail}">
                    </a>
                </div>
                <h2>
                    <a href="{ROW.link_detail}" title="{ROW.title}"><strong>{ROW.title}</strong></a>
                </h2>
                <ul class="exam-info css-exam-info list-inline form-tooltip">
                    <li class="pointer" data-toggle="tooltip" data-original-title="{LANG.ladder}">
                        <em class="fa fa-star">&nbsp;</em>{LANG.ladder}<span class="hidden-xs"> {ROW.ladder}</span>
                    </li>
                    <li class="pointer" data-toggle="tooltip" data-original-title="{LANG.timer}">
                        <em class="fa fa-pencil">&nbsp;</em>{LANG.timer}<span class="hidden-xs"> {ROW.timer} {LANG.min}</span>
                    </li>
                </ul>
                <ul class="list-inline help-block">
                    <li><em class="fa fa-clock-o">&nbsp;</em>{ROW.timer_begin_end}</li>
                </ul>
            </div>
        </div>
        <!-- END: examinations_subject -->
    </div>
</div>
<!-- BEGIN: page -->
<div class="text-center">{PAGE}</div>
<!-- END: page -->
<!-- END: main -->