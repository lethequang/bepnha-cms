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
                        <strong>Tên khu vực</strong> <span class="symbol required"></span>
                    </label>
                    <div class="col-sm-7">
                        {!! Form::text("name", $object['name'], ['class' => 'form-control' , "id" => "name"]) !!}
                        <span class="help-block has-error">{!! $errors->first("name") !!}</span>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <a href='{!! url("/{$moduleName}/{$controllerName}/show-all"); !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left">Về danh sách Khu Vực</a>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button class="btn btn-primary btn-labeled fa fa-save">Lưu</button>
                <button type="reset" class="btn btn-default btn-labeled fa fa-refresh">Hủy</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        var location = $('#location').val();
        var province = $('#province').val();
        var city = $('#city').val();

        $.get('/inside/storage/ajax-get-province/'+location, function(data) {
            $.each(data, function(key, value) {
                if(key != province)
                {
                    $('#province').append("<option value='" + key + "'>" + value + "</option>");
                }
            });
        });

        $.get('/inside/storage/ajax-get-city/'+province, function(data) {
            $.each(data, function(key, value) {
                if(key != city)
                {
                    $('#city').append("<option value='" + key + "'>" + value + "</option>");
                }
            });
        });
    });

    $(function() {
        <?php
            $time = time();
        ?>
        $('#file_upload').uploadify({
            'swf'      : '/assets/inside/plugins/uploadify/uploadify.swf',
            'uploader' : '/upload.php?timestamp=<?php echo $time?>&token=<?php echo md5('unique_salt' . $time);?>',
            'buttonText' : '<i class="icon-picture"></i> BROWSE...',
            'onUploadSuccess' : function (file, data) {
                $('#preview-file-upload').attr('src', '/upload/temp/' + data );
                $('input[name=image_name]').val(data);
                $('input[name=is_new_image]').val(1);
            },
            'multi'    : false
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