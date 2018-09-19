@extends("{$moduleName}.layout.login")
@section('content')
<div class="center">
	<h1>
		<i class="icon-leaf green"></i>
		<span style = "color: #dd5a43!important;">CMS</span>
		<span style = "color: #69aa46!important;">Bếp Nhà App</span>
	</h1>
	<h4 style="color: #478fca!important;  margin-bottom: 14px;">© bepnha.tv - 2017</h4>
</div>
<div class="cls-content-sm panel">
    <div class="panel-body" style="border: 6px solid #394557;">
       <h4 style="border-bottom: 1px solid #d5e3ef; color: #478fca!important; font-size: 16px; line-height: 28px; margin-bottom: 16px; margin-top: 0px; padding-bottom: 4px;">ĐĂNG NHẬP HỆ THỐNG</h4>
        <form method="post">
            <input type="hidden" value="{!! csrf_token() !!}" name="_token">
            @if(Session::has('message'))
                <div class="alert alert-danger fade in">
                    <button class="close" data-dismiss="alert"><span>×</span></button>
                    {{Session::get('message')}}
                </div>
            @endif
            @if(count($errors->all()))
                <div class="alert alert-danger fade in">
                    <button class="close" data-dismiss="alert"><span>×</span></button>
                    Email hoặc password không chính xác!
                </div>
            @endif

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                    <input name="email" type="text" placeholder="Email" class="form-control" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                    <input name="password" type="password" class="form-control" value="{{ old('password') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 text-left checkbox">
                    <label class="form-checkbox form-normal form-primary form-text">
                        <input type="checkbox" name="is_remember_me" value="1"> Ghi nhớ
                    </label>
                </div>
                    <div class="col-lg-12 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary btn-labeled fa fa-user fa-lg" name="signup" value="Sign up">Đăng nhập</button>
                    </div>
            </div>
        </form>
    </div>
</div>
@endsection