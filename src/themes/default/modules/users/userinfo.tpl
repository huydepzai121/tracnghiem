<!-- BEGIN: main -->
<!-- BEGIN: changepass_request2 -->
<div class="alert alert-danger">
    {CHANGEPASS_INFO}
</div>
<!-- END: changepass_request2 -->
<!-- BEGIN: changeemail_request2 -->
<div class="alert alert-danger">
    {CHANGEEMAIL_INFO}
</div>
<!-- END: changeemail_request2 -->

<div class="page panel panel-default">
    <div class="panel-body">
        <h2 class="margin-bottom-lg">{LANG.user_info}</h2>
        <div class="row">
            <figure data-toggle="changeAvatar" data-url="{URL_AVATAR}" class="avatar left pointer">
                <div style="width:80px;">
                    <p class="text-center"><img src="{IMG.src}" alt="{USER.username}" title="{USER.username}" width="80" class="img-thumbnail bg-gainsboro m-bottom" /></p>
                    <figcaption>{IMG.title}</figcaption>
                </div>
            </figure>
            <div>
                <ul class="nv-list-item xsm">
                    <li><em class="fa fa-angle-right">&nbsp;</em> {LANG.account2}: <span class="text-break"><strong>{USER.username}</strong> ({USER.email})</span></li>
                    <li><em class="fa fa-angle-right">&nbsp;</em> <span class="text-break">{USER.current_mode}</span></li>
                    <li><em class="fa fa-angle-right">&nbsp;</em> {LANG.current_login}: {USER.current_login}</li>
                    <li><em class="fa fa-angle-right">&nbsp;</em> {LANG.ip}: {USER.current_ip}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN: change_login_note -->
<div class="alert alert-danger">
    <em class="fa fa-exclamation-triangle ">&nbsp;</em> {USER.change_name_info}
</div>
<!-- END: change_login_note -->
<!-- BEGIN: pass_empty_note -->
<div class="alert alert-danger">
    <em class="fa fa-exclamation-triangle ">&nbsp;</em> {USER.pass_empty_note}
</div>
<!-- END: pass_empty_note -->
<!-- BEGIN: question_empty_note -->
<div class="alert alert-danger">
    <em class="fa fa-exclamation-triangle ">&nbsp;</em> {USER.question_empty_note}
</div>
<!-- END: question_empty_note -->
<div class="table-responsive margin-bottom-lg">
    <table class="table table-bordered table-striped">
        <colgroup>
            <col style="width:45%" />
        </colgroup>
        <tbody>
            <tr>
                <td>{LANG.name}</td>
                <td>{USER.full_name}</td>
            </tr>
            <tr>
                <td>{LANG.birthday}</td>
                <td>{USER.birthday}</td>
            </tr>
            <tr>
                <td>{LANG.gender}</td>
                <td>{USER.gender}</td>
            </tr>
            <tr>
                <td>{LANG.showmail}</td>
                <td>{USER.view_mail}</td>
            </tr>
            <tr>
                <td>{LANG.regdate}</td>
                <td>{USER.regdate}</td>
            </tr>
            <!-- BEGIN: langinterface -->
            <tr>
                <td>{GLANG.langinterface}</td>
                <td>{USER.langinterface}</td>
            </tr>
            <!-- END: langinterface -->
            <!-- BEGIN: field -->
            <!-- BEGIN: loop -->
            <tr>
                <td>{FIELD.title}</td>
                <td>{FIELD.value}</td>
            </tr>
            <!-- END: loop -->
            <!-- END: field -->
            <!-- BEGIN: group_manage -->
            <tr>
                <td>{LANG.group_manage_count}</td>
                <td>{USER.group_manage} <a href="{URL_GROUPS}" title="{LANG.group_manage_list}">({LANG.group_manage_list})</a></td>
            </tr>
            <!-- END: group_manage -->
            <tr>
                <td>{LANG.st_login2}</td>
                <td>{USER.st_login}</td>
            </tr>
            <tr>
                <td>{LANG.login_name}</td>
                <td>{USER.login_name}</td>
            </tr>
            <tr>
                <td>{LANG.2step_status}</td>
                <td>{USER.active2step} (<a href="{URL_2STEP}">{LANG.2step_link}</a>)</td>
            </tr>
            <tr>
                <td>{LANG.last_login}</td>
                <td>{USER.last_login}</td>
            </tr>
        </tbody>
    </table>
</div>

<ul class="nav navbar-nav">
    <!-- BEGIN: navbar --><li><a href="{NAVBAR.href}"><em class="fa fa-caret-right margin-right-sm"></em>{NAVBAR.title}</a></li><!-- END: navbar -->
</ul>
<!-- END: main -->
