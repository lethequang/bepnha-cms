@extends("{$moduleName}.layout.master")
@section('content')
<?php
    $languages = json_decode(LANGUAGES);
?>
<div id="page-title">
    <h1 class="page-header text-overflow">{!! $title !!}</h1>
</div>

<ol class="breadcrumb">
    <li>
        <a href="{!! url("/{$controllerName}/show-all"); !!}">
            {!! $title !!}
        </a>
    </li>
    <li class="active">Thêm mới</li>
</ol>

<div id="page-content">
    <form role="form" class="form-horizontal" method="post">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Thêm mới</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        <strong>Tên key</strong>
                        <span class="symbol required"></span>
                    </label>
                    <div class="col-sm-7">
                        {!! Form::text("config_key", null, ['class' => 'form-control' , 'id' => "config_key"]) !!}
                        <span class="help-block has-error">{!! $errors->first("config_key") !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        <strong>Giá trị</strong>
                        <span class="symbol required"></span>
                    </label>
                    <div class="col-sm-7">
                        <?php foreach ($languages as $key => $value):?>
                            <div class="lang">
                                <label for="form-field-22">
                                    <?php echo $value?>
                                </label>
                                {!! Form::text("config_value_lang_{$key}", null, ['class' => 'form-control' , 'id' => "config_value_lang_{$key}"]) !!}
                                <span class="help-block has-error">{!! $errors->first("config_value_lang_{$key}") !!}</span>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button class="btn btn-primary btn-labeled fa fa-save">Lưu</button>
                <button type="reset" class="btn btn-default btn-labeled fa fa-refresh">Hủy</button>
            </div>
        </div>
    </form>
</div>
@endsection