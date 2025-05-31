<!-- BEGIN: main -->
<tr id="{id}" class="bank-type-row">
    <td>
        <div class="position-relative">
            <select class="form-select classid" name="classid[]" id="class_{id}" style="min-width: 250px;">
            </select>
            <div class="position-absolute top-50 end-0 translate-middle-y me-2 d-none" id="class_loading_{id}">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </td>
    <td>
        <div class="position-relative">
            <select class="form-select cat" name="cat[]" id="cat_{id}" onchange="change_cat({id}, this.value)" style="min-width: 250px;">
            </select>
            <div class="position-absolute top-50 end-0 translate-middle-y me-2 d-none" id="cat_loading_{id}">
                <div class="spinner-border spinner-border-sm text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </td>
    <!-- BEGIN: bank_type -->
    <td class="text-center">
        <div {not_none} id="not-{id}-{BANK_TYPE.id}" class="text-warning"
             title="{LANG.you_need_update_more_question}">
            <i class="fas fa-exclamation-triangle"></i>
            <small class="d-block">Chưa có câu hỏi</small>
        </div>
        <div {had_none} class="input-group input-group-sm justify-content-center" style="max-width: 100px; margin: 0 auto;">
            <input class="form-control text-center bank_type_{BANK_TYPE.id}"
                   data-max="{COUNT_MAX}"
                   data-bank-type="{BANK_TYPE.id}"
                   type="number"
                   min="0"
                   max="{COUNT_MAX}"
                   data-class-id="{class_id}"
                   data-cat-id="{cat_id}"
                   data-bank-type-id="{BANK_TYPE.id}"
                   name="config-{id}-{BANK_TYPE.id}"
                   value="{value}"
                   title="{LANG.tooltip_sllquestion} {COUNT_MAX}"
                   placeholder="0" />
        </div>
    </td>
    <!-- END: bank_type -->
    <td class="text-center">
        <span class="badge bg-info fs-6 num_question">{TOTAL}</span>
    </td>
</tr>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Initialize Bootstrap 5 tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Enhanced Select2 for class selection
    $('#class_{id}').select2({
        theme: 'bootstrap-5',
        language: '{NV_LANG_INTERFACE}',
        placeholder: '{LANG.cat_select}',
        allowClear: true,
        ajax: {
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-config-content-bank&bank_list=1',
            dataType: "json",
            delay: 300,
            data: function (params) {
                return {
                    search: params.term
                };
            },
            processResults: function (data) {
                // Clear category when class changes
                $('#cat_{id}').html('').trigger('change');
                return {
                    results: data
                };
            },
            cache: true,
            beforeSend: function() {
                $('#class_loading_{id}').removeClass('d-none');
            },
            complete: function() {
                $('#class_loading_{id}').addClass('d-none');
            }
        }
    });

    // Enhanced Select2 for category selection
    $('#cat_{id}').select2({
        theme: 'bootstrap-5',
        language: '{NV_LANG_INTERFACE}',
        placeholder: '{LANG.select_category}',
        allowClear: true,
        ajax: {
            type: 'POST',
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=exams-config-content-bank&bank_list=1',
            dataType: "json",
            delay: 300,
            data: function (params) {
                var parentid = $("#class_{id}").val();
                return {
                    search: params.term,
                    parentid: parentid
                };
            },
            processResults: function (data) {
                var parentid = $("#class_{id}").val();
                data = (parentid == 0) || (parentid == '') || (parentid == undefined) ? [] : data;
                return {
                    results: data
                };
            },
            cache: true,
            beforeSend: function() {
                $('#cat_loading_{id}').removeClass('d-none');
            },
            complete: function() {
                $('#cat_loading_{id}').addClass('d-none');
            }
        }
    });

    // Enhanced input validation
    $('#{id} input[type="number"]').on('input', function() {
        var $input = $(this);
        var max = parseInt($input.attr('max')) || 0;
        var value = parseInt($input.val()) || 0;

        if (value > max) {
            $input.addClass('is-invalid');
            $input.val(max);
        } else if (value < 0) {
            $input.addClass('is-invalid');
            $input.val(0);
        } else {
            $input.removeClass('is-invalid');
        }

        // Visual feedback for valid input
        if (value > 0 && value <= max) {
            $input.addClass('border-success');
            setTimeout(function() {
                $input.removeClass('border-success');
            }, 1500);
        }
    });

    // Row highlight on hover
    $('#{id}').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );
});
//]]>
</script>
<!-- BEGIN: class_id -->
<script type="text/javascript">
//<![CDATA[
    $(document).ready(function() {
        $('#class_{id}').append(new Option('{class_text}', '{class_id}', false, false)).trigger('change');
    })
//]]>
</script>
<!-- END: class_id -->
<!-- BEGIN: cat_id -->
<script type="text/javascript">
//<![CDATA[
    $(document).ready(function() {
        $('#cat_{id}').append(new Option('{cat_text}', '{cat_id}', false, false)).trigger('change');
    })
//]]>
</script>
<!-- END: cat_id -->
<!-- BEGIN: trigger_set_value -->
<script type="text/javascript">
//<![CDATA[

//]]>
</script>
<!-- END: trigger_set_value -->
<!-- END: main -->