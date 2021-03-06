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
        <a href="{!! url("/{$moduleName}/{$controllerName}/show-all") !!}">
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
                        <strong>Tên Category</strong> <span class="symbol required"></span>
                    </label>
                    <div class="col-sm-7">
                        {!! Form::text("name", $object['name'], ['class' => 'form-control' , "id" => "name"]) !!}
                        <span class="help-block has-error">{!! $errors->first("name") !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        <strong>Category type</strong>
                    </label>
                    <div class="col-sm-7">
                        {!! Form::select("type", $cat_types, $object['type'], ['class' => 'form-control' ]) !!}
                        <span class="help-block has-error">{!! $errors->first("parent_cate") !!}</span>
                    </div>
                </div>
                <div class="form-group" style="margin-left: 150px;">
                    <div class="col-sm-3">
                        <div class="col-sm-10 btn-file">
                            480x415
                            <div class="fileupload-new thumbnail" style="width: 140px; height: 150px; margin-bottom: 3px;">
                                @if (old('is_new_image') == 1)
                                    <img id="preview-file-upload" style="width: 140px; height: 140px;" src="/upload/temp/{!! old('image_name') !!}">
                                @elseif (strlen($object['icon_location']) > 0)
                                    <img id="preview-file-upload" style="width: 140px; height: 140px;" src="{!! $_ENV['MEDIA_URL_IMAGE'] !!}/{!! $object['icon_location'] !!}">
                                @endif
                            </div>
                            <input id="file_upload" name="file_upload" type="file" multiple="false">
                            {!! Form::hidden("image_name", $object['icon_location']) !!}
                            {!! Form::hidden("is_new_image", 0) !!}
                            <span class="help-block has-error">{!! $errors->first("image_name") !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <a href='{!! url("/{$moduleName}/{$controllerName}/show-all") !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left">Về danh sách Category</a>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button class="btn btn-primary btn-labeled fa fa-save">Lưu</button>
                <button type="reset" class="btn btn-default btn-labeled fa fa-refresh">Hủy</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">

    $(function() {
        <?php
            $time = time();
        ?>
        $('#file_upload').uploadify({
            'swf'      : '/assets/inside/plugins/uploadify/uploadify.swf',
            'uploader' : '/upload.php?timestamp=<?php echo $time?>&token=<?php echo md5('unique_salt' . $time);?>',
            'buttonText' : '<i class="icon-picture"></i> Menu Icon',
            'onUploadSuccess' : function (file, data) {
                $('#preview-file-upload').attr('src', '/upload/temp/' + data );
                $('input[name=image_name]').val(data);
                $('input[name=is_new_image]').val(1);
            },
            'fileSizeLimit': '5MB',
        	'fileTypeDesc': 'Image Files',
            'fileTypeExts': '*.gif; *.jpg; *.jpeg; *.png; *.GIF; *.JPG; *.PNG',
            'multi'    : false
        });
    });

</script>
@endsection