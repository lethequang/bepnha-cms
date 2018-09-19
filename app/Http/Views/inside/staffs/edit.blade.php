@extends("{$moduleName}.layout.master")
@section('content')
<div id="page-title">
    <h1 class="page-header text-overflow">{!! $title !!}</h1>
</div>

<ol class="breadcrumb">
    <li>
        <a href="{!! url("/{$moduleName}/{$controllerName}/show-all"); !!}">
           {!! $title !!}
        </a>
    </li>
    <li class="active">{{ $pageTitle }}</li>
</ol>

<div id="page-content">
    @include("{$moduleName}.{$controllerName}.form")
</div>
@endsection