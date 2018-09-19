@extends("{$moduleName}.layout.master")
@section('head')
    <link href="/assets/inside/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <script src="/assets/inside/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
@endsection
@section('content')
    <?php
    $languages = json_decode(LANGUAGES);
    ?>
    <div id="page-title">
        <h1 class="page-header text-overflow">{!! $title !!}</h1>
    </div>

    <ol class="breadcrumb">
        <li>
            <a href="{!! url("/{$moduleName}/{$controllerName}/show-all"); !!}">
                {!! $title !!}
            </a>
        <li class="active">Chỉnh sửa</li>
    </ol>

    <div id="page-content">
        <form role="form" class="form-horizontal" method="post">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Chỉnh sửa</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">
                            <strong>Tên</strong> <span class="symbol required"></span>
                        </label>
                        <div class="col-sm-7">
                            {!! Form::text("title", $object['title'], ['class' => 'form-control' , "id" => "title"]) !!}
                            <span class="help-block has-error">{!! $errors->first("name") !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">
                            <strong>Danh sách tag</strong> <span class="symbol required"></span>
                        </label>
                        <div class="col-sm-7">
                            @foreach($object['tags'] as $id=>$tag)
                                <label><input {{ isset($tag->checked)?'checked=true':''}} class="form-checkbox" name="tags[]" value="{{ $id }}" type="checkbox" />{{ $tag->title }}</label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <a href='{!! url("/{$moduleName}/{$controllerName}/show-all"); !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left">Về danh sách</a>
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button class="btn btn-primary btn-labeled fa fa-save">Lưu</button>
                    <button type="reset" class="btn btn-default btn-labeled fa fa-refresh">Hủy</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('foot')
    <script language="JavaScript">

    </script>
@endsection