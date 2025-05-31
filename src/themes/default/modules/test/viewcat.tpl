<!-- BEGIN: main -->
<div id="breadcrumbs_mobile" class="col-xs-24 col-sm-24 box-coll hidden-lg hidden-md ">
    <div class="col-xs-20 col-sm-20 title">{CAT.title}</div>
    <!-- BEGIN: empty -->
    <div class="col-xs-4 col-sm-4">
        <button class="btn-coll">
            <i class="fa fa-chevron-up fa-bars" aria-hidden="true"></i>
        </button>
    </div>
    <div class="listcat collapse">
        <!-- BEGIN: listcat -->
        <div class="col-xs-12 col-sm-12">
            <a class="breadum_coll" href="{LISTCAT.link}" title="{LISTCAT.title}">{LISTCAT.title}</a>
        </div>
        <!-- END: listcat -->
    </div>
    <!-- END: empty -->
</div>
<div class="clearfix"></div>
<div class="viewcat">
    <h1 class="hidden-xs hidden-sm">{CAT.title}</h1>
    <hr style="margin-top: 0;">
    <!-- BEGIN: description_html -->
    <p>{CAT.description_html}</p>
    <!-- END: description_html -->
    <!-- BEGIN: topscore -->
    <div class="table-responsive" id="topscore">
        <table class="table table-striped table-bordered table-hover table-middle">
            <caption>{LANG.topscore_list}</caption>
            <thead>
                <tr>
                    <th>{LANG.tester_info_fullname}</th>
                    <th width="150">{LANG.time_testting}</th>
                    <th width="100">{LANG.score}</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td>
                        <strong>{TOPSCORE.fullname}</strong><span class="help-block"><a href="{TOPSCORE.link}" title="{TOPSCORE.title}">{TOPSCORE.title}</a></span>
                    </td>
                    <td>{TOPSCORE.begin_time}</td>
                    <td>{TOPSCORE.score}</td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
    <!-- END: topscore -->
    {DATA}
    <!-- BEGIN: page -->
    <div class="text-center">{PAGE}</div>
    <!-- END: page -->
</div>
<!-- END: main -->