<form role="form" class="form-horizontal" method="post">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $pageTitle }}</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">
                    <strong>Group</strong>
                    <span class="symbol required"></span>
                </label>
                <div class="col-sm-7">
                    @if ($object->id === null)
                        {!! Form::select('group', $groups, $object->group, ['class' => 'form-control', 'id' => 'group_select']) !!}
                    @else
                        {!! Form::select('group', $groups, $object->group, [
                            'class' => 'form-control',
                            'id' => 'group_select',
                            'disabled' => 'disabled',
                        ]) !!}
                    @endif
                    <span class="help-block has-error">{!! $errors->first('group') !!}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="email_field">
                    <strong>Email</strong>
                    <span class="symbol required"></span>
                </label>
                <div class="col-sm-7">
                    @if ($object->id === null)
                        {!! Form::text('email', $object->email, ['class' => 'form-control', 'id' => 'email_field']) !!}
                    @else
                        {!! Form::text('email', $object->email, [
                            'class' => 'form-control',
                            'id' => 'email_field',
                            ]) !!}
                    @endif
                    <span class="help-block has-error">{!! $errors->first('email') !!}</span>
                </div>
            </div>
            @if (empty($object->id))
            <div class="form-group">
                <label class="col-sm-2 control-label" for="password_field">
                    <strong>Mật khẩu</strong>
                    <span class="symbol required"></span>
                </label>
                <div class="col-sm-7">
                    {!! Form::text('password', $object->password, ['class' => 'form-control', 'id' => 'password_field']) !!}
                    <span class="help-block has-error">{!! $errors->first('password') !!}</span>
                </div>
            </div>
            @endif
            <div class="form-group">
                <label class="col-sm-2 control-label" for="fullname_field">
                    <strong>Họ tên</strong>
                </label>
                <div class="col-sm-7">
                    {!! Form::text('fullname', $object->fullname, ['class' => 'form-control', 'id' => 'fullname_field']) !!}
                    <span class="help-block has-error">{!! $errors->first('fullname') !!}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="phone_field">
                    <strong>Số ĐT</strong>
                </label>
                <div class="col-sm-7">
                    {!! Form::text('phone', $object->phone, ['class' => 'form-control', 'id' => 'phone_field']) !!}
                    <span class="help-block has-error">{!! $errors->first('phone') !!}</span>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <a href='{!! url("/{$moduleName}/{$controllerName}/show-all"); !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left">Về danh sách</a>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="staff_id" value="{{ $object->id }}">
            <button class="btn btn-primary btn-labeled fa fa-save">Lưu</button>
            <button id="btn-reset" type="reset" class="btn btn-default btn-labeled fa fa-refresh">Hủy</button>
        </div>
    </div>
</form>

<!--Bootstrap Table [ OPTIONAL ]-->

<script src="/assets/inside/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="/assets/inside/plugins/bootstrap-table/locale/bootstrap-table-vi-VN.min.js"></script>

<script type="text/javascript">
    $('#demo-custom-toolbar').bootstrapTable({
        search: true,
        showRefresh: true,
        showToggle: true,
        showColumns: true,
        pagination: true,
    });

//     $('#group_select').on('change', function(e) {
//         var group = $(this).val();
//         if (!group) return;
//         var url = '{{ url("/{$moduleName}/{$controllerName}/staff-code") }}' + '/' + group;
//         $.get(url, function( data ) {
//             $('#email_field').val(data);
//         });
//     });
</script>