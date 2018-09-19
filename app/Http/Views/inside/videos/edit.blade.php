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
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group" style="clear: both">
                                <label class="control-label"><strong>Tên Video</strong> <span
                                            class="symbol required"></span></label>
                                {!! Form::text("name", $object['name'], ['class' => 'form-control' , "id" => "name", "placeholder" => 'Nhập tên Video']) !!}
                                <span class="help-block has-error">{!! $errors->first("name") !!}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><strong>Đầu bếp</strong></label>
                                {!! Form::text("chef", $object['chef'], ['class' => 'form-control' , "id" => "chef", "placeholder" => 'Đầu bếp']) !!}
                                <span class="help-block has-error">{!! $errors->first("chef") !!}</span>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="row">
                                    <label class="control-label"><strong>Thành phần món ăn 1</strong></label>
                                    {!! Form::textarea("ingredients", $object['ingredients'], ['class' => 'form-control' , "id" => "ingredients", "placeholder" => 'Thành phần món ăn']) !!}
                                    <span class="help-block has-error">{!! $errors->first("ingredients") !!}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                    <label class="control-label"><strong>Thành phần món ăn 2</strong></label>
                                    {!! Form::textarea("ingredients_2", $object['ingredients_2'], ['class' => 'form-control' , "id" => "ingredients_2", "placeholder" => 'Thành phần món ăn']) !!}
                                    <span class="help-block has-error">{!! $errors->first("ingredients_2") !!}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><strong>Các bước làm</strong></label>
                                {!! Form::textarea("steps", $object['steps'], ['class' => 'form-control' , "id" => "steps", "placeholder" => 'Các bước làm']) !!}
                                <span class="help-block has-error">{!! $errors->first("steps") !!}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><strong>Mô tả</strong></label>
                                {!! Form::textarea("description", $object['description'], ['class' => 'form-control' , "id" => "description", "placeholder" => 'Nhập mô tả Video']) !!}
                                <span class="help-block has-error">{!! $errors->first("description") !!}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><strong>Ghi chú</strong></label>
                                {!! Form::textarea("note", $object['note'], ['class' => 'form-control' , "id" => "note", "placeholder" => 'Nhập ghi chú', 'id'=>'note']) !!}
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
                                                        id="review_file_upload_video">{!! (strlen(old('video_name'))) ? old('video_name') : $object['video_location'] !!}</span>
                                            </button>
                                        </div>
                                        <input id="file_upload_video" name="file_upload_video" type="file"
                                               multiple="false">
                                        {!! Form::hidden("video_name", $object['video_location'], ["class" => 'name_review']) !!}
                                        {!! Form::hidden("is_new_video", 0, ["class" => 'new_review']) !!}
                                        <span class="help-block has-error">{!! $errors->first("video_name") !!}</span>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-left: 10px;">
                                    <div class="col-sm-6 btn-file">
                                        800x450
                                        <div class="fileupload-new thumbnail"
                                             style="width: 140px; height: 150px; margin-bottom: 3px;">
                                            @if (old('is_new_image') == 1)
                                                <img id="preview-file-upload" style="width: 140px; height: 140px;"
                                                     src="/upload/temp/{!! old('image_name') !!}">
                                            @elseif (strlen($object['image_location']) > 0)
                                                <img id="preview-file-upload" style="width: 140px; height: 140px;"
                                                     src="{!! $_ENV['MEDIA_URL_IMAGE'] !!}/{!! $object['image_location'] !!}">
                                            @endif
                                        </div>
                                        <input id="file_upload" name="file_upload" type="file" multiple="false">
                                        {!! Form::hidden("image_name", $object['image_location']) !!}
                                        {!! Form::hidden("is_new_image", 0) !!}
                                        <span class="help-block has-error">{!! $errors->first("image_name") !!}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" style="margin-left: 18px;">
                                    <label class="control-label"><strong>Thể loại chính</strong> <span
                                                class="symbol required"></span></label>
                                    {!! Form::select("pcategory_id", $pcategories, $object['pcategory_id'], ['class' => 'form-control' , "id" => "pcategory_id"]) !!}
                                    <span class="help-block has-error">{!! $errors->first("pcategory_id") !!}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" style="margin-left: 18px;">
                                    <label class="control-label"><strong>Thể loại phụ</strong> <span
                                                class="symbol required"></span></label>
                                    {!! Form::select("category_id", $categories, $object['category_id'], ['class' => 'form-control' , "id" => "category_id"]) !!}
                                    <span class="help-block has-error">{!! $errors->first("category_id") !!}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" style="margin-left: 18px;">
                                    <label class="control-label"><strong>Chọn buổi</strong> <span
                                                class="symbol required"></span></label>
                                    {!! Form::select("video_type_id", $types, $object['video_type_id'], ['class' => 'form-control' , "id" => "video_type_id"]) !!}
                                    <span class="help-block has-error">{!! $errors->first("video_type_id") !!}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-3" style="margin-left: 18px;">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Thời gian video</strong> <span
                                                    class="symbol required"></span></label>
                                        {!! Form::text("duration", $object['duration'], ['class' => 'form-control' , "id" => "video_duration", "placeholder" => 'VD: 05:00']) !!}
                                        <span class="help-block has-error">{!! $errors->first("duration") !!}</span>
                                    </div>
                                </div>
                                <div class="col-sm-3" style="margin-left: 40px;">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Thời gian làm</strong></label>
                                        {!! Form::text("time_to_done", $object['time_to_done'], ['class' => 'form-control' , "id" => "time_to_done", "placeholder" => 'VD: 05:00']) !!}
                                        <span class="help-block has-error">{!! $errors->first("time_to_done") !!}</span>
                                    </div>
                                </div>
                                <div class="col-sm-3" style="margin-left: 40px;">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Độ khó</strong></label>
                                        {!! Form::text("level", $object['level'], ['class' => 'form-control' , "id" => "level", "placeholder" => 'độ khó']) !!}
                                        <span class="help-block has-error">{!! $errors->first("level") !!}</span>
                                    </div>
                                </div>
                            </div>

                            {{--
                            <div class="col-sm-12" style="margin-left: 35px;">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-checkbox form-normal form-primary">
                                            {!! Form::checkbox("is_featured", 1, $object['is_featured'], ['class' => 'form-control' , "id" => "is_featured"]) !!}
                                            Nổi bật
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-checkbox form-normal form-primary">
                                            {!! Form::checkbox("is_like", 1, $object['is_like'], ['class' => 'form-control' , "id" => "is_like"]) !!}
                                            Món yêu thích
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-checkbox form-normal form-primary">
                                            {!! Form::checkbox("is_new", 1, $object['is_new'], ['class' => 'form-control' , "id" => "is_new"]) !!}
                                            Món mới
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-checkbox form-normal form-primary">
                                            {!! Form::checkbox("is_for_you", 1, $object['is_for_you'], ['class' => 'form-control' , "id" => "is_for_you"]) !!}
                                            Món cho bạn
                                        </label>
                                    </div>
                                </div>
                            </div>
                            --}}

                            <div class="col-sm-12">
                                <div class="form-group" style="margin-left: 18px;">
                                    <label class="control-label" for="form-field-1" style="margin-bottom: 10px;">
                                        <strong>Chọn tags</strong>
                                    </label>
                                    <div>
                                        @foreach($tags as $id=>$tag)
                                            <label><input
                                                        {{ isset($tag->checked)?'checked=true':''}} class="form-checkbox"
                                                        name="tags[]" value="{{ $id }}"
                                                        type="checkbox"/>{{ $tag->title }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" style="margin-left: 18px;">
                                    <label class="control-label" for="form-field-1" style="margin-bottom: 10px;">
                                        <strong>Chọn Home</strong>
                                    </label>
                                    <div>
                                        <label>
                                            <input {{ $object['is_home']==1?'checked=true':'' }} class="form-checkbox" name="is_home" type="checkbox"/>
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
                    <input id="_token" type="hidden" name="_token" value="{!! csrf_token() !!}">
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
                    $('input[name=is_new_image]').val(1);
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
            if (newReview === 1) {
                var url = '{!! url('/') !!}/upload/temp/' + nameReview;
            } else {
                    <?php $pathSource = $_ENV['MEDIA_URL_VIDEO'] . '/' . $object['video_location']; ?>
                var url = '{!! $pathSource !!}';
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
        })

        $('#ingredients,#note,#description,#steps,#ingredients_2').ckeditor({
            toolbar: [
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
                ['FontSize', 'TextColor', 'BGColor', 'Source']
            ]
        });

    </script>
@endsection