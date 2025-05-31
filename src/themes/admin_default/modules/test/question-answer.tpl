<!-- BEGIN: main -->
<div class="card border-0" id="answer">
<input type="hidden" name="numfile" value="{NUMFILE.numfile}">
    <div class="card-body">
        <!-- BEGIN: question_type_1 -->
        <!-- BEGIN: answer_input -->
        <!-- BEGIN: loop -->
        <div class="mb-3" id="row-{ANSWER.index}">
            <div class="row align-items-center">
                <div class="col-md-1">
                    <span class="badge bg-primary fs-6 answer_index">{ANSWER.letter}</span>
                </div>
                <div class="col-md-7">
                    <input type="hidden" name="answer[{ANSWER.index}][id]" value="{ANSWER.id}">
                    <input type="text" name="answer[{ANSWER.index}][content]"
                           value="{ANSWER.content}" class="form-control"
                           placeholder="Nhập nội dung đáp án...">
                </div>
                <!-- BEGIN: is_true -->
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="answer[{ANSWER.index}][is_true]" value="1"
                               {ANSWER.checked} id="is_true_{ANSWER.index}" />
                        <label class="form-check-label" for="is_true_{ANSWER.index}">
                            Đáp án đúng
                        </label>
                    </div>
                </div>
                <!-- END: is_true -->
                <!-- BEGIN: point -->
                <div class="col-md-1">
                    <input type="text" name="answer[{ANSWER.index}][point]"
                           class="form-control" value="{ANSWER.point}"
                           placeholder="Điểm" />
                </div>
                <!-- END: point -->
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-sm"
                            title="{LANG.answer_delete}" onclick="nv_remove_answer({ANSWER.index});">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- END: loop -->
        <script>
			$(document).ready(function() {
				var numfile = $('input[name="numfile"]').val();
				$('#addfile').click(function(e) {
					numfile = $('input[name="numfile"]').val();
					numfile = parseInt(numfile);
					e.preventDefault();
					var html = '';
					html += '<div class="mb-3" id="row-' + numfile + '">';
					html += '    <div class="row align-items-center">';
					html += '        <div class="col-md-1">';
					html += '            <span class="badge bg-primary fs-6 answer_index">' + anyString.charAt(numfile) + '</span>';
					html += '        </div>';
					html += '        <div class="col-md-7">';
					html += '            <input type="hidden" name="answer[' + numfile + '][id]" value="' + (numfile + 1) + '">';
					html += '            <input type="text" name="answer[' + numfile + '][content]" value="" class="form-control" placeholder="Nhập nội dung đáp án...">';
					html += '        </div>';
					<!-- BEGIN: is_true_js -->
					html += '        <div class="col-md-2">';
					html += '            <div class="form-check">';
					html += '                <input class="form-check-input" type="checkbox" name="answer[' + numfile + '][is_true]" value="1" id="is_true_' + numfile + '" />';
					html += '                <label class="form-check-label" for="is_true_' + numfile + '">Đáp án đúng</label>';
					html += '            </div>';
					html += '        </div>';
					<!-- END: is_true_js -->
					<!-- BEGIN: point_js -->
					html += '        <div class="col-md-1">';
					html += '            <input type="text" name="answer[' + numfile + '][point]" class="form-control" placeholder="Điểm" />';
					html += '        </div>';
					<!-- END: point_js -->
					html += '        <div class="col-md-1">';
					html += '            <button type="button" class="btn btn-outline-danger btn-sm" title="{LANG.answer_delete}" onclick="nv_remove_answer(' + numfile + ');">';
					html += '                <i class="fas fa-trash"></i>';
					html += '            </button>';
					html += '        </div>';
					html += '    </div>';
					html += '</div>';
					$('#listanswer').before(html);
					$('input[name="numfile"]').val( numfile + 1);
					$('.answer_index').reindex();
				});
			});
		</script>
        <!-- END: answer_input -->
        <!-- BEGIN: answer_editor -->
        <!-- BEGIN: loop -->
        <div class="mb-4" id="row-{ANSWER.index}">
            <div class="card border-2 answer-card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary fs-6 me-2 answer_index">{ANSWER.letter}</span>
                        <strong class="text-primary">{LANG.answer} <span class="answer_index">{ANSWER.letter}</span></strong>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <!-- BEGIN: is_true -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="answer[{ANSWER.index}][is_true]" value="1"
                                   {ANSWER.checked} id="is_true_editor_{ANSWER.index}" />
                            <label class="form-check-label fw-semibold text-success"
                                   for="is_true_editor_{ANSWER.index}">
                                <i class="fas fa-check-circle"></i> {LANG.answer_is_true}
                            </label>
                        </div>
                        <!-- END: is_true -->
                        <button type="button" class="btn btn-outline-danger btn-sm"
                                onclick="nv_remove_answer({ANSWER.index});">
                            <i class="fas fa-trash-alt"></i> {LANG.delete}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="answer[{ANSWER.index}][id]" value="{ANSWER.id}" />
                    <div class="editor-wrapper">
                        {ANSWER.content}
                    </div>
                    <!-- BEGIN: point -->
                    <div class="mt-3">
                        <div class="input-group" style="max-width: 200px;">
                            <span class="input-group-text"><i class="fas fa-star text-warning"></i></span>
                            <input type="text" name="answer[{ANSWER.index}][point]"
                                   class="form-control" value="{ANSWER.point}"
                                   placeholder="{LANG.question_type_5_point}" />
                        </div>
                    </div>
                    <!-- END: point -->
                </div>
            </div>
        </div>
        <!-- END: loop -->
        <script>
			$(document).ready(function() {
				$('#addfile').click(function(e) {
					numfile = $('input[name="numfile"]').val();
					numfile = parseInt(numfile);
					e.preventDefault();
					var editor = '';

					$.ajax({
						type : 'POST',
						url : script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question-content',
						data : 'get_answer_editor=1&name=answer[' + numfile + '][content]',
						dataType : 'html',
						success : function(editor) {
							var html = '';
							html += '<div class="mb-4" id="row-' + numfile + '">';
							html += '    <div class="card border-2 answer-card">';
							html += '        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">';
							html += '            <div class="d-flex align-items-center">';
							html += '                <span class="badge bg-primary fs-6 me-2 answer_index">' + anyString.charAt(numfile) + '</span>';
							html += '                <strong class="text-primary">{LANG.answer} <span class="answer_index">' + anyString.charAt(numfile) + '</span></strong>';
							html += '            </div>';
							html += '            <div class="d-flex align-items-center gap-3">';
							<!-- BEGIN: is_true_js -->
							html += '                <div class="form-check">';
							html += '                    <input class="form-check-input" type="checkbox" name="answer[' + numfile + '][is_true]" value="1" id="is_true_editor_' + numfile + '" />';
							html += '                    <label class="form-check-label fw-semibold text-success" for="is_true_editor_' + numfile + '">';
							html += '                        <i class="fas fa-check-circle"></i> {LANG.answer_is_true}';
							html += '                    </label>';
							html += '                </div>';
							<!-- END: is_true_js -->
							html += '                <button type="button" class="btn btn-outline-danger btn-sm" onclick="nv_remove_answer(' + numfile + ');">';
							html += '                    <i class="fas fa-trash-alt"></i> {LANG.delete}';
							html += '                </button>';
							html += '            </div>';
							html += '        </div>';
							html += '        <div class="card-body">';
							html += '            <input type="hidden" name="answer[' + numfile + '][id]" value="' + (numfile + 1) + '" />';
							html += '            <div class="editor-wrapper">';
							html += editor;
							html += '            </div>';
							<!-- BEGIN: point_js -->
							html += '            <div class="mt-3">';
							html += '                <div class="input-group" style="max-width: 200px;">';
							html += '                    <span class="input-group-text"><i class="fas fa-star text-warning"></i></span>';
							html += '                    <input type="text" name="answer[' + numfile + '][point]" class="form-control" placeholder="{LANG.question_type_5_point}" />';
							html += '                </div>';
							html += '            </div>';
							<!-- END: point_js -->
							html += '        </div>';
							html += '    </div>';
							html += '</div>';

							$('#listanswer').before(html);
							$('input[name="numfile"]').val( numfile + 1);
							$('.answer_index').reindex();
							numfile += 1;
						}
					});
				});
			});
		</script>
        <!-- END: answer_editor -->
        <!-- END: question_type_1 -->
        <!-- BEGIN: question_type_2 -->
        <!-- BEGIN: answer_input -->
        <!-- BEGIN: loop -->
        <div class="form-group" id="row-{ANSWER.index}">
            <label class="col-sm-3 control-label"><strong>{LANG.answer} <span class="answer_index">{ANSWER.letter}</span></strong></label>
            <div class="col-sm-21">
                <div class="row">
                    <div class="col-xs-16">
                        <div class="input-group">
                            <div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="" data-original-title="{LANG.answer_delete}" onclick="nv_remove_answer({ANSWER.index});">
                                <em class="fa fa-trash-o fa-pointer">&nbsp;</em>
                            </div>
                            <input type="hidden" name="answer[{ANSWER.index}][id]" value="{ANSWER.id}" class="form-control"> <input type="text" name="answer[{ANSWER.index}][content]" value="{ANSWER.content}" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" name="answer[{ANSWER.index}][is_true]" value="{ANSWER.is_true}" />
                    </div>
                </div>
            </div>
        </div>
        <!-- END: loop -->
        <script>
			$(document).ready(function() {
				$('#addfile').click(function(e) {
					numfile = $('input[name="numfile"]').val();
					numfile = parseInt(numfile);
					e.preventDefault();
					var html = '';
					html += '<div class="form-group" id="row-' + numfile + '">';
					html += '	<label class="col-sm-3 control-label"><strong>{LANG.answer} <span class="answer_index">' + anyString.charAt(numfile) + '</span></strong></label>';
					html += '	<div class="col-sm-21">';
					html += '		<div class="row">';
					html += '			<div class="col-xs-16">';
					html += '				<div class="input-group">';
					html += '					<div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="" data-original-title="{LANG.answer_delete}" onclick="nv_remove_answer(' + numfile + ');">';
					html += '						<em class="fa fa-trash-o fa-pointer">&nbsp;</em>';
					html += '					</div>';
					html += '					<input type="hidden" name="answer[' + numfile + '][id]" value="' + (numfile + 1) + '" class="form-control">';
					html += '					<input type="text" name="answer[' + numfile + '][content]" class="form-control">';
					html += '				</div>';
					html += '			</div>';
					html += '			<div class="col-xs-8">';
					html += '				<input type="text" class="form-control" name="answer[' + numfile + '][is_true]"  value="1" />';
					html += '			</div>';
					html += '		</div>';
					html += '	</div>';
					html += '</div>';
					$('#listanswer').before(html);
					$('input[name="numfile"]').val( numfile + 1);
					$('.answer_index').reindex();
					$('[data-toggle="tooltip"]').tooltip();
				});
			});
		</script>
        <!-- END: answer_input -->
        <!-- BEGIN: answer_editor -->
        <!-- BEGIN: loop -->
        <div class="form-group" id="row-{ANSWER.index}">
            <label class="col-sm-3 control-label"><strong>{LANG.answer} <span class="answer_index">{ANSWER.letter}</span></strong></label>
            <div class="col-sm-21">
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control w200 pull-left" name="answer[{ANSWER.index}][is_true]" value="{ANSWER.is_true}" placeholder="{LANG.answer_is_true}" />
                                <button class="pull-right btn btn-danger btn-xs" onclick="nv_remove_answer({ANSWER.index});">
                                    <em class="fa fa-trash-o">&nbsp;</em>{LANG.delete}
                                </button></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="answer[{ANSWER.index}][id]" value="{ANSWER.id}" /> {ANSWER.content}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END: loop -->
        <script>
			$(document).ready(function() {
				$('#addfile').click(function(e) {
					numfile = $('input[name="numfile"]').val();
					numfile = parseInt(numfile);
					e.preventDefault();
					var editor = '';

					$.ajax({
						type : 'POST',
						url : script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=question-content',
						data : 'get_answer_editor=1&name=answer[' + numfile + '][content]',
						dataType : 'html',
						success : function(editor) {
							var html = '';
							html += '<div class="form-group answer-item" id="row-' + numfile + '">';
							html += '	<label class="col-sm-3 control-label"><strong>{LANG.answer} <span class="answer_index">' + anyString.charAt(numfile) + '</span></strong></label>';
							html += '	<div class="col-sm-21">';
							html += '		<table class="table table-striped table-bordered table-hover">';
							html += '			<tbody>';
							html += '				<tr>';
							html += '					<td>';
							html += '						<input type="text" class="form-control w200 pull-left" name="answer[' + numfile + '][is_true]" value="1" placeholder="{LANG.answer_is_true}" />';
							html += '						<button class="pull-right btn btn-danger btn-xs" onclick="nv_remove_answer(' + numfile + ');"><em class="fa fa-trash-o">&nbsp;</em>{LANG.delete}</button>';
							html += '					</td>';
							html += '				</tr>';
							html += '				<tr>';
							html += '					<td>';
							html += '						<input type="hidden" name="answer[' + numfile + '][id]" value="' + (numfile + 1) + '" />';
							html += editor;
							html += '					</td>';
							html += '				</tr>';
							html += '			</tbody>';
							html += '		</table>';
							html += '	</div>';
							html += '</div>';
							$('#listanswer').before(html);
							$('input[name="numfile"]').val( numfile + 1);
							$('.answer_index').reindex();
							numfile += 1;
						}
					});
				});
			});
		</script>
        <!-- END: answer_editor -->
        <!-- END: question_type_2 -->
        <!-- BEGIN: question_type_4 -->
        <div class="form-group" id="row-{ANSWER.index}">
            <label class="col-sm-3 text-right"><strong>{LANG.answer} <span class="answer_index">{ANSWER.letter}</span></strong></label>
            <div class="col-sm-21">
                <!-- BEGIN: loop -->
                <label><input type="radio" name="answer" value="{OPTION.index}"{OPTION.checked}>{OPTION.value}</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <!-- END: loop -->
            </div>
        </div>
        <!-- END: question_type_4 -->
        <!-- BEGIN: answer_add -->
        <div id="listanswer" data-numfile="{NUMFILE.numfile}"></div>
        <div class="text-center mt-3">
            <button type="button" class="btn btn-primary" id="addfile">
                <i class="fas fa-plus me-2"></i>{LANG.answer_add}
            </button>
        </div>
        <!-- END: answer_add -->
    </div>
</div>
<!-- END: main -->