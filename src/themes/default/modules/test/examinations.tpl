<!-- BEGIN: main -->
<div class="test">
    <div class="test viewlist">
        <!-- BEGIN: examinations -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="image pull-left">
                    <a href="{ROW.link_subject}" title="{ROW.title}" target="_self">
                        <img src="{ROW.image_url}" class="img-thumbnail" width="100"
                            alt="{ROW.link_subject}">
                    </a>
                </div>
                <h2>
                    <a href="{ROW.link_subject}" title="{ROW.title}"><strong>{ROW.title}</strong></a>
                </h2>
                <ul class="exam-info css-exam-info list-inline form-tooltip">
                    <li class="pointer" data-toggle="tooltip" data-original-title=" {LANG.examinations_subject}">
                        <em class="fa fa-heart-o">&nbsp;</em>{ROW.num_subject}<span class="hidden-xs"> {LANG.examinations_subject}</span>
                    </li>
                </ul>
                <ul class="list-inline help-block">
                    <li><em class="fa fa-clock-o">&nbsp;</em>{ROW.timer}</li>
                </ul>
            </div>
        </div>
        <!-- END: examinations -->
    </div>
</div>
<!-- BEGIN: page -->
<div class="text-center">{PAGE}</div>
<!-- END: page -->
<!-- END: main -->