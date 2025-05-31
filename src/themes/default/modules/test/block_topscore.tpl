<!-- BEGIN: main -->
<div class="tableUsers form-tooltip">
    <!-- BEGIN: loop -->
    <div class="userRow {ROW.class}" data-toggle="tooltip" data-html="true" data-original-title="<!-- BEGIN: field --><ul style='padding: 0'><li><label>{LANG.tester_info_fullname}:</label> {ROW.full_name}</li><!-- BEGIN: loop --><li><label>{FIELD.title}:</label> {FIELD.value}</li><!-- END: loop --></ul><!-- END: field -->">
        <div class="member">
            <div class="name">
                <!-- BEGIN: medal_icon -->
                <img src="{ROW.medal_icon}" alt="" width="20">
                <!-- END: medal_icon -->
                {ROW.full_name}
            </div>
            <!-- BEGIN: exam -->
            <a href="{ROW.link}" title="{ROW.title}"><small class="help-block" style="width: 150px;">{ROW.title}</small></a>
            <!-- END: exam -->
        </div>
        <div class="score" style="text-align: right;">
            <span class="text-red">{ROW.score}</span>/{ROW.ladder}
        </div>
    </div>
    <!-- END: loop -->
</div>
<!-- END: main -->