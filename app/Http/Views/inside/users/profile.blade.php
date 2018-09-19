@extends("{$moduleName}.layout.master")
@section('content')
<div id="page-title">
    <h1 class="page-header text-overflow">{!! $title !!}</h1>
</div>
<div id="page-content">
	@if(Session::has('msg'))
	<div class="alert alert-{{Session::get('msg')['status']}}" role="alert">
		<!--<button class="close" type="button">
			<i class="fa fa-times-circle"></i>
		</button>-->
		<div class="media">
			<div class="media-left">
				<span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
					<i class="fa fa-thumbs-up fa-lg"></i>
				</span>
			</div>
			<div class="media-body">
				<h4>Thông báo</h4>
				<p class="alert-message">{{ Session::get('msg')['value']}}</p>
			</div>
		</div>
	</div>
	@endif
    @include("{$moduleName}.{$controllerName}.form")
</div>
@endsection