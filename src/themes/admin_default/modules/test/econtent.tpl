<!-- BEGIN: main -->
<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                <!-- BEGIN: title -->
                <li role="presentation"><a href="#{ROW.action}" aria-controls="{ROW.action}" role="tab" data-toggle="tab">{ROW.title}</a></li>
                <!-- END: title -->
            </ul>

            <div class="tab-content">
                <!-- BEGIN: content -->
                <div role="tabpanel" class="tab-pane" id="{ROW.action}">
                    <div class="m-bottom">{ROW.econtent}</div>
                </div>
                <!-- END: content -->
                <div class="row">
                    <!-- BEGIN: note -->
                    <div class="col-xs-24 col-sm-12 col-md-8">
                        <strong>[{NOTE.index}]</strong>: {NOTE.value}
                    </div>
                    <!-- END: note -->
                </div>
            </div>
        </div>
    </div>
    <div class="form-group" style="text-align: center">
        <input class="btn btn-primary loading" name="submit" type="submit" value="{LANG.save}" />
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#myTabs a:first').tab('show');
    });
</script>
<!-- END: main -->