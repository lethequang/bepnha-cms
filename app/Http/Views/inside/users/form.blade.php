<form role="form" class="form-horizontal" method="post">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">{{ $pageTitle }}</h3>
			<div class = "clearfix clear-fix"></div>
        </div>
        <div class="panel-body">
			<?php
				$class = 'disabled';
			?>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="email_field">
                    <strong>Email</strong>
                    <span class="symbol required"></span>
                </label>
                <div class="col-sm-7">
                    {!! Form::text('email', $objectStaff->email, ['class' => 'form-control ', $class, 'id' => 'email_field']) !!}
                    <span class="help-block has-error">{!! $errors->first('email') !!}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">
                    <strong>Group</strong>
                    <span class="symbol required"></span>
                </label>
                <div class="col-sm-7 changeColor">
                    {!! Form::select('group', $groups, $objectStaff->group, ['class' => 'form-control ', $class]) !!}
                    <span class="help-block has-error">{!! $errors->first('group') !!}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="fullname_field">
                    <strong>Họ tên</strong>
                </label>
                <div class="col-sm-7">
                    {!! Form::text('fullname', $objectStaff->fullname, ['class' => 'form-control', 'id' => 'fullname_field']) !!}
                    <span class="help-block has-error">{!! $errors->first('fullname') !!}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="phone_field">
                    <strong>Số ĐT</strong>
                </label>
                <div class="col-sm-7">
                    {!! Form::text('phone', $objectStaff->phone, ['class' => 'form-control', 'id' => 'phone_field']) !!}
                    <span class="help-block has-error">{!! $errors->first('phone') !!}</span>
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-2 control-label" for="phone_field">
                    <strong>Mật khẩu</strong>
                </label>
                <div class="col-sm-7">
                    <a href="#" data-target="#reset-password-modal"
						data-toggle="modal"
						class="add-tooltip btn btn-warning"
						data-original-title="Đổi mật khẩu"
						data-id="' + value + '">
						Đổi mật khẩu
					</a>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="staff_id" value="{{ $objectStaff->id }}" class="hidden-staff-info">
            <button class="btn btn-primary btn-labeled fa fa-save">Lưu</button>
            <button id="btn-reset" type="reset" class="btn btn-default btn-labeled fa fa-refresh">Hủy</button>
        </div>
    </div>
</form>

<div class="modal fade" id="reset-password-modal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <form class="modal-content" method="post" id="reset-password-form" data-url="{{ url("/{$moduleName}/{$controllerName}/change-password") }}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h4 class="modal-title">Đổi mật khẩu</h4>
            </div>
            <div class="modal-body">
				<div class="form-group">
                    <label class="control-label" for="old_password_field">
                        <strong>Mật khẩu cũ</strong>
                        <span class="symbol required"></span>
                    </label>
                    {!! Form::password('old_password', ['class' => 'form-control', 'id' => 'old_password_field']) !!}
					<span class="help-block has-error">{!! $errors->first('old_password') !!}</span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="password_field">
                        <strong>Mật khẩu mới</strong>
                        <span class="symbol required"></span>
                    </label>
                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password_field']) !!}
					<span class="help-block has-error">{!! $errors->first('password') !!}</span>
                </div>
				<div class="form-group">
                    <label class="control-label" for="password_confirmation_field">
                        <strong>Nhập lại mật khẩu</strong>
                        <span class="symbol required"></span>
                    </label>
                    {!! Form::password('password_confirmation',['class' => 'form-control', 'id' => 'password_confirmation_field']) !!}
					<span class="help-block has-error">{!! $errors->first('password_confirmation') !!}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Đóng</button>
                {{ csrf_field() }}
                {{ Form::hidden('staff_id', null, ['id' => 'staff_id_hidden']) }}
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function(){
	// reset password modal
	$('#reset-password-modal').on('shown.bs.modal', function (e) {
		$('#old_password_field').focus();
		var staff_id = $('.hidden-staff-info').val();
		$('#staff_id_hidden').val(staff_id);
	});
	$('#reset-password-form').submit(function (e) {
		var url = $(this).data('url');
		if ($('#password_field').val() === '') {
			alert('Vui lòng nhập mật khẩu mới');
			$('#password_field').focus();
			return e.preventDefault();
		}
		var payload = $(this).serialize();
		$.post(url, payload).done(function(data){
			$('#reset-password-modal').modal('hide');
			$('#password_field').val('');
			$('#old_password_field').val('');
			$('#password_confirmation_field').val('');
			notifyMsg(data.msg, 'page');
		}).error(function(data){
			// Error...
			var errors = data.responseJSON;
			console.log(errors);
			var msg = '';
			$.each(errors, function(key, value){
				msg += value + '<br/>';
			});
			notifyMsg(msg, 'floating');
		});
		e.preventDefault();
	});
});

function notifyMsg(msg, container) {
	$.niftyNoty({
		type: 'info',
		title: 'Thông báo',
		message: msg,
		container: container,
		timer: 5000
	});
}

</script>