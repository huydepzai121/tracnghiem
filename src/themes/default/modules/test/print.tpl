<!-- BEGIN: main -->
<style>
    body {
        background-color: #fff
    }
    
    .print {
        padding: 10px;
    }
    
    .print .url {
        border-bottom: solid 1px #ddd;
        margin-bottom: 5px
    }
    
    #hd_print {
        border-bottom: solid 1px #ddd;
        margin-bottom: 10px
    }
    
    ul.exam-info {
        padding: 0
    }
    
    ul.exam-info label {
        width: 150px;
    }
    
    table.table-middle td {
        vertical-align: middle !important
    }
    
    ul.exam-info {
        padding: 0;
        list-style: none
    }
</style>
<div class="print printMe">
    <div id="hd_print">
        <h2 class="pull-left">{DATA.site_name}</h2>
        <p class="pull-right">{DATA.site_url}</p>
        <div class="clearfix"></div>
    </div>
    <h1>{EXAM.title}</h1>
    <ul class="exam-info">
        <li><label>{LANG.question_total}</label>: {EXAM.num_question}</li>
        <li><label>{LANG.time_test}</label>: {EXAM.timer} {LANG.min}</li>
    </ul>
    {CONTENT}
    <!-- BEGIN: answer -->
    <h2>{LANG.answer}</h2>
    <div class="row">
        <!-- BEGIN: loop -->
        <!-- BEGIN: answer_1 -->
        <div class="col-xs-24 col-sm-8 col-md-8">
            <table class="table table-bordered table-middle">
                <tbody>
                    <tr>
                        <td width="50" class="text-center">{ANSWER.number}</td>
                        <td>{ANSWER.answer}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END: answer_1 -->
        <!-- BEGIN: answer_2 -->
        <div class="col-xs-24 col-sm-24 col-md-24">
            <table class="table table-bordered table-middle">
                <tbody>
                    <tr>
                        <td width="50" class="text-center">{ANSWER.number}</td>
                        <td>{ANSWER.answer}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END: answer_2 -->
        <!-- BEGIN: answer_4 -->
        <div class="col-xs-24 col-sm-8 col-md-8">
            <table class="table table-bordered table-middle">
                <tbody>
                    <tr>
                        <td width="50" class="text-center">{ANSWER.number}</td>
                        <td>{ANSWER.answer}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END: answer_4 -->
        <!-- END: loop -->
    </div>
    <!-- END: answer -->
    <!-- BEGIN: notbank -->
    <div class="clearfix">
        <div class="url">
            <strong>{LANG.print_url}: </strong>{DATA.url}
        </div>
        <div class="pull-left">&copy; {DATA.site_name}</div>
        <div class="pull-right">{DATA.site_email}</div>
        <div class="clearfix"></div>
    </div>
    <!-- END: notbank -->
</div>
<!-- BEGIN: print -->
<script type="text/javascript">
    $(document).ready(function() {
        window.print();
    });
</script>
<!-- END: print -->
<!-- END: main -->