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
        <a href="{!! url("/{$moduleName}/{$controllerName}/show-all"); !!}">
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
                        <strong>Tên khu vực</strong> <span class="symbol required"></span>
                    </label>
                    <div class="col-sm-7">
                        {!! Form::text("name", null, ['class' => 'form-control' , "id" => "name"]) !!}
                        <span class="help-block has-error">{!! $errors->first("name") !!}</span>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <a href='{!! url("/{$moduleName}/{$controllerName}/show-all"); !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left">Về danh sách Khu Vực</a>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button class="btn btn-primary btn-labeled fa fa-save">Lưu</button>
                <button id="btn-reset" type="reset" class="btn btn-default btn-labeled fa fa-refresh">Hủy</button>
            </div>
        </div>
    </form>
</div>
<!--Bootstrap Datepicker [ OPTIONAL ]-->
<link href="/assets/inside/plugins/bootstrap-datetimepicker/css/datetimepicker.css" rel="stylesheet">
<script src="/assets/inside/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="/assets/inside/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.vi.js"></script>

<!-- CKFinder -->
<script src="/assets/inside/plugins/ckfinder/ckfinder.js"></script>

<script type="text/javascript">
function BrowseServer(name) {
    var config = {};
    config.startupPath = 'Images:/products/';
    var finder = new CKFinder(config);
    finder.selectActionFunction = SetFileField;
    finder.selectActionData = name;
    finder.callback = function (api) {
        api.disableFolderContextMenuOption('Batch', true);
    };
    finder.popup();
}
function SetFileField(fileUrl, data) {
    var file = fileUrl.replace(/\/\//g, '/');
    if (data["selectActionData"] == 'image_name') {
        file = '/thumb.php?src=' + file + '&w=320&h=190';
    }
    $('#' + data["selectActionData"]).val(file);
    $('#' + data["selectActionData"]).parent().find('.preview-file-upload').attr('src', file);
}

$(function () {
    var date = new Date();
    var browseImage = function () {
        $('.browse-image').click(function () {
            var name = $(this).attr('data-target');
            BrowseServer(name);
        });
    };
    browseImage();

    $('.changeFeature select').change(function () {
        var value = $(this).val();
        var name = $(this).attr('name');
        $.get('/inside/product/ajax-get-feature/' + value, function (data) {
            console.log('input [name="' + name + '_code"]');
            $('input[name="' + name + '_code"]').val(data.code);
        });
    });


    $('#location').change(function() {
    	var value = $(this).val();
        $.get('/inside/storage/ajax-get-province/'+value, function(data) {
        	$("#province").empty();
            $("#province").append("<option>---- Chọn Tỉnh/TP ----</option>");
            $("#city").empty();
            $("#city").append("<option>---- Chọn Quận/Huyện ----</option>");
            $.each(data, function(i, value) {
                $('#province').append("<option value='" + i + "'>" + value + "</option>");
            });
        });
    });

    $('#province').change(function() {
    	var value = $(this).val();
        $.get('/inside/storage/ajax-get-city/'+value, function(data) {
        	$("#city").empty();
            $("#city").append("<option>---- Chọn Quận/Huyện ----</option>");
            $.each(data, function(i, value) {
                $('#city').append("<option value='" + i + "'>" + value + "</option>");
            });
        });
    });

});
</script>
@endsection