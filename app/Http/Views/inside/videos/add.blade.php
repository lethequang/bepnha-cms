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
            <a href="{!! url("/{$controllerName}/show-all") !!}">
                {!! $title !!}
            </a>
        </li>
        <li class="active">Thêm mới</li>
    </ol>
    <div id="page-content">
        <form role="form" method="post">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Thêm mới</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group" style="clear: both">
                                <label class="control-label"><strong>Tên Video</strong> <span
                                            class="symbol required"></span></label>
                                {!! Form::text("name", null, ['class' => 'form-control' , "id" => "name", "placeholder" => 'Nhập tên Video']) !!}
                                <span class="help-block has-error">{!! $errors->first("name") !!}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><strong>Đầu bếp</strong></label>
                                {!! Form::text("chef", null, ['class' => 'form-control' , "id" => "chef", "placeholder" => 'Đầu bếp']) !!}
                                <span class="help-block has-error">{!! $errors->first("chef") !!}</span>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="control-label"><strong>Thành phần món ăn 1</strong></label>
                                        {!! Form::textarea("ingredients", null, ['class' => 'form-control' , "id" => "ingredients", "placeholder" => 'Thành phần món ăn 1']) !!}
                                        <span class="help-block has-error">{!! $errors->first("ingredients") !!}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label"><strong>Thành phần món ăn 2</strong></label>
                                        {!! Form::textarea("ingredients_2", null, ['class' => 'form-control' , "id" => "ingredients_2", "placeholder" => 'Thành phần món ăn 2']) !!}
                                        <span class="help-block has-error">{!! $errors->first("ingredients_2") !!}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><strong>Các bước làm</strong></label>
                                {!! Form::textarea("steps", null, ['class' => 'form-control' , "id" => "steps", "placeholder" => 'Các bước làm']) !!}
                                <span class="help-block has-error">{!! $errors->first("steps") !!}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><strong>Mô tả</strong></label>
                                {!! Form::textarea("description", null, ['class' => 'form-control' , "id" => "description", "placeholder" => 'Nhập mô tả Video']) !!}
                                <span class="help-block has-error">{!! $errors->first("description") !!}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><strong>Ghi chú</strong></label>
                                {!! Form::textarea("note", null, ['class' => 'form-control' , "id" => "note", "placeholder" => 'Nhập ghi chú']) !!}
                                <span class="help-block has-error">{!! $errors->first("note") !!}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <div class="form-group" style="margin-left: 10px;">
                                    <div class="col-sm-6 btn-file">
                                        <div class="fileupload-new thumbnail" style="margin-bottom: 3px; border: 0;">
                                            <button class="btn btn-primary preview-video" type="button"
                                                    onclick="return modalReviewVideo(this)">
                                                <i class="fa fa-play"></i> <span
                                                        id="review_file_upload_video">{!! old('video_name') !!}</span>
                                            </button>
                                        </div>
                                        <input id="file_upload_video" name="file_upload_video" type="file" multiple="false">
                                        {!! Form::hidden("video_name", null, ["class" => 'name_review']) !!}
                                        {!! Form::hidden("is_new_video", 0, ["class" => 'new_review']) !!}
                                        <span class="help-block has-error">{!! $errors->first("video_name") !!}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" style="margin-left: 10px;">
                                    <div class="col-sm-6 btn-file">
                                        800x450
                                        <div class="fileupload-new thumbnail"
                                             style="width: 140px; height: 150px; margin-bottom: 3px;">
                                            @if (strlen(old('image_name')))
                                                <img id="preview-file-upload" style="width: 140px; height: 140px;"
                                                     src="/upload/temp/{!! old('image_name') !!}">
                                            @else
                                                <img id="preview-file-upload" style="width: 140px; height: 140px;"
                                                     src="/assets/inside/img/no-image.jpg">
                                            @endif
                                        </div>
                                        <input id="file_upload" name="file_upload" type="file" multiple="false">
                                        {!! Form::hidden("image_name") !!}
                                        {!! Form::hidden("is_new_image", 1) !!}
                                        <span class="help-block has-error">{!! $errors->first("image_name") !!}</span>
                                    </div>
                                    {{--
                                    <div class="col-sm-6 btn-file">
                                        <div class="fileupload-new thumbnail"
                                             style="width: 140px; height: 150px; margin-bottom: 3px;">
                                            @if (strlen(old('image_name1')))
                                                <img id="preview-file-upload1" style="width: 140px; height: 140px;"
                                                     src="/upload/temp/{!! old('image_name1') !!}">
                                            @else
                                                <img id="preview-file-upload1" style="width: 140px; height: 140px;"
                                                     src="/assets/inside/img/no-image.jpg">
                                            @endif
                                        </div>
                                        <input id="file_upload1" name="file_upload1" type="file" multiple="false">
                                        {!! Form::hidden("image_name1") !!}
                                        {!! Form::hidden("is_new_image1", 1) !!}
                                        <span class="help-block has-error">{!! $errors->first("image_name1") !!}</span>
                                    </div>
                                    --}}
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><strong>Thể loại chính</strong><span
                                                class="symbol required"></span></label>
                                    {!! Form::select("pcategory_id", $pcategories, null, ['class' => 'form-control' , "id" => "pcategory_id"]) !!}
                                    <span class="help-block has-error">{!! $errors->first("pcategory_id") !!}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><strong>Thể loại phụ</strong><span
                                                class="symbol required"></span></label>
                                    {!! Form::select("category_id", $categories, null, ['class' => 'form-control' , "id" => "category_id"]) !!}
                                    <span class="help-block has-error">{!! $errors->first("category_id") !!}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><strong>Chọn buổi</strong> <span
                                                class="symbol required"></span></label>
                                    {!! Form::select("video_type_id", $types, null, ['class' => 'form-control' , "id" => "video_type_id"]) !!}
                                    <span class="help-block has-error">{!! $errors->first("video_type_id") !!}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Thời gian video</strong> <span
                                                    class="symbol required"></span></label>
                                        {!! Form::text("duration", null, ['class' => 'form-control' , "id" => "video_duration", "placeholder" => 'VD: 05:00']) !!}
                                        <span class="help-block has-error">{!! $errors->first("duration") !!}</span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Thời gian làm</strong></label>
                                        {!! Form::text("time_to_done", null, ['class' => 'form-control' , "id" => "time_to_done", "placeholder" => 'VD: 05:00']) !!}
                                        <span class="help-block has-error">{!! $errors->first("time_to_done") !!}</span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Độ khó</strong></label>
                                        {!! Form::text("level", null, ['class' => 'form-control' , "id" => "level", "placeholder" => 'độ khó']) !!}
                                        <span class="help-block has-error">{!! $errors->first("level") !!}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="form-field-1"> <strong>Chọn tags</strong></label>
                                    <div>
                                        @foreach($tags as $tag)
                                            <label><input class="form-checkbox" name="tags[]" value="{{ $tag->id }}" type="checkbox"/>{{ $tag->title }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="form-field-1" style="margin-bottom: 10px;">
                                        <strong>Chọn Home</strong>
                                    </label>
                                    <div>
                                        <label>
                                            <input class="form-checkbox" name="is_home" type="checkbox"/>
                                            Chọn Home
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <a href='{!! url("/{$moduleName}/{$controllerName}/show-all") !!}'
                       class="btn btn-success btn-labeled fa fa-arrow-left pull-left">Về danh sách Video</a>
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button class="btn btn-primary btn-labeled fa fa-save">Lưu</button>
                    <button type="reset" class="btn btn-default btn-labeled fa fa-refresh">Hủy</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal" id="review_video" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--Modal header-->
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Review video</h4>
                </div>

                <!--Modal body-->
                <div class="modal-body">

                </div>

                <!--Modal footer-->
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#reset-page').click(function () {
            window.history.back();
        });
        $(function () {
            <?php
                $time = time();
            ?>
            $('#file_upload').uploadify({
                'swf': '/assets/inside/plugins/uploadify/uploadify.swf',
                'uploader': '/upload.php?timestamp=<?php echo $time?>&token=<?php echo md5('unique_salt' . $time);?>',
                'buttonText': '<i class="icon-picture"></i> Image Cover',
                'onUploadSuccess': function (file, data) {
                    $('#preview-file-upload').attr('src', '/upload/temp/' + data);
                    $('input[name=image_name]').val(data);
                },
                'fileSizeLimit': '5MB',
                'fileTypeDesc': 'Image Files',
                'fileTypeExts': '*.gif; *.jpg; *.jpeg; *.png; *.GIF; *.JPG; *.PNG',
                'multi': false
            });

            $('#file_upload_video').uploadify({
                'swf': '/assets/inside/plugins/uploadify/uploadify.swf',
                'uploader': '/upload.php?timestamp=<?php echo $time?>&token=<?php echo md5('unique_salt' . $time);?>',
                'buttonText': '<i class="icon-picture"></i> Chọn Video tải lên',
                'onUploadSuccess': function (file, data) {
                    $('#review_file_upload_video').text(data);
                    $('input[name=video_name]').val(data);
                    $('input[name=is_new_video]').val(1);
                },
                'fileSizeLimit': '1024MB',
                'fileTypeDesc': 'Video Files',
                'fileTypeExts': '*.mp4',
                'multi': false
            });

        });

        $('.has-error').each(function () {
            if ($(this).html().length == 0) {
                $(this).remove();
            }
        });

        if ($('.has-error').parent().hasClass('form-group')) {
            $('.has-error').parent().addClass('has-error');
        } else {
            $('.has-error').parent().parent().addClass('has-error');
        }

        function modalReviewVideo(object) {
            var nameReview = $(object).parent().parent().find('.name_review').val();
            var newReview = parseInt($(object).parent().parent().find('.new_review').val());

            var url = '';

            if (newReview === 1) {
                var url = '{!! url('/') !!}/upload/temp/' + nameReview;
            } else {

            }
            var html = '<video width="100%" height="100%" controls id="video_source" autoplay>';
            html += '<source type="video/mp4" src="' + url + '">';
            html += 'Your browser does not support the video tag.';
            html += '</video>';
            $('#review_video .modal-body').html(html);
            $('#review_video').modal('show');
        }

        $('#review_video').on('hidden.bs.modal', function () {
            $('#review_video .modal-body').html('');
        });
        $('#ingredients,#ingredients_2,#note,#description,#steps').ckeditor({
            toolbar: [
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
                ['FontSize', 'TextColor', 'BGColor', 'Source']
            ]
        });

    </script>
@endsection