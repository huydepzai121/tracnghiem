<!-- BEGIN: main -->
<h1 class="m-bottom">{LANG.history}</h1>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover table-middle">
		<colgroup>
			<col width="50" />
			<col />
			<col width="150" />
			<col width="150" />
			<col width="80" />
			<col width="110" />
			<col width="60" />
			<col width="60" />
			<col width="90" />
			<col width="100" />
			<col />
		</colgroup>
		<thead>
			<tr>
				<th class="text-center">{LANG.stt}</th>
				<th class="text-center">{LANG.exam}</th>
				<th class="text-center">{LANG.begin_time}</th>				
				<th class="text-center">{LANG.time_testting}</th>
				<th class="text-center">{LANG.score}</th>
				<th class="text-center">{LANG.rating_multi_choice}</th>
				<th class="text-center">{LANG.question_true_s}</th>
				<th class="text-center">{LANG.question_false_s}</th>
				<th class="text-center">{LANG.question_skeep_s}</th>
				<th class="text-center " width="100">{LANG.score_constructed_response}</th>
				<th class="text-center"><em class="fa fa-cog">&nbsp;</em></th>
			</tr>
		</thead>
		<!-- BEGIN: generate_page -->
		<tfoot>
			<tr>
				<td class="text-center" colspan="10">{NV_GENERATE_PAGE}</td>
			</tr>
		</tfoot>
		<!-- END: generate_page -->
		<tbody>
			<!-- BEGIN: loop -->
			<tr class="pointer" onclick="nv_table_row_click(event, '{VIEW.link_view}', false);">
                <td class="text-center">{VIEW.number}</td>
                <td>{VIEW.exam.title}</td>
                <td class="text-center" data-label="{LANG.time_test}">{VIEW.begin_time}</td>
                <td class="text-center" data-label="{LANG.time_test}">{VIEW.time_test}</td>
                <td class="text-center" data-label="{LANG.score}">{VIEW.score}</td>                
                <td class="text-center" data-label="{LANG.rating}">{VIEW.rating.title}</td>
                <td class="text-center" data-label="{LANG.question_true_s}">{VIEW.count_true}</td>
                <td class="text-center" data-label="{LANG.question_false_s}">{VIEW.count_false}</td>
                <td class="text-center" data-label="{LANG.question_skeep_s}">{VIEW.count_skeep}</td>
                <td class="text-center" data-label="{LANG.question_skeep_s}">{VIEW.mark_constructed_response}</td>
                <td class="text-center form-tooltip"><span class="dropdown"> <a class="btn btn-primary dropdown-toggle hover-menu" href="" title="{LANG.share_now}"><i class="fa fa-bars" aria-hidden="true"></i></a>
                        <div class="dropdown-menu customize-dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <ul class="social-network social-circle">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={VIEW.url_share}" target="_blank" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a target="_blank" href="https://twitter.com/share?text=&url={VIEW.url_share}" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a target="_blank" href="https://plus.google.com/share?url={VIEW.url_share}" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                </span>
                <!-- BEGIN: del_history --> 
                <a data-toggle="tooltip" data-original-title="{LANG.delete_detail}" class="btn btn-danger" href="javascript:void(0);" onclick="nv_test_delete_history({VIEW.id}, '{OP}');" title="{LANG.delete}"><em class="fa fa-trash"></em></a></td>
                <!-- END: del_history -->
            </tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: main -->