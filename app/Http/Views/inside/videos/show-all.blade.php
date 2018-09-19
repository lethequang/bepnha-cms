@extends("{$moduleName}.layout.master")
@section('content')

<div id="page-title">
    <h1 class="page-header text-overflow"><?php echo $title?></h1>
</div>

<ol class="breadcrumb">
    <li class=""><?php echo $title?></li>
    <li class="active">Danh sách Video</li>
</ol>

@if (Session::has('video-success-message'))
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Thành công!</h4>
        {{ Session::get('video-success-message') }}
    </div>
    @elseif (Session::has('video-error-message'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Lỗi!</h4>
        {{ Session::get('video-error-message') }}
    </div>
@endif

<div id="page-content">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Danh sách Video</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3">
                    {!! Form::select('status_filter', $status, $filters['status'], [
                        'id' => 'status_filter',
                        'class' => 'custom_filter',
                        'data-placeholder' => 'Lọc theo trạng thái']) !!}
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="input-daterange input-group" id="date_from">
                            <span class="input-group-addon">Từ</span>
                            <input type="text" class="form-control" id="from_filter" value="{{ $filters['from'] }}" placeholder="----- Ngày bắt đầu -----" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="input-daterange input-group" id="date_to">
                            <span class="input-group-addon">Đến</span>
                            <input type="text" class="form-control" id="to_filter" value="{{ $filters['to'] }}" placeholder="----- Ngày kết thúc -----" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-1">
                    <button id="reset-page" class="btn btn-default" type="button" name="refresh" title="Reset">Làm lại</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    {!! Form::select('pcategory_filter', $pcategories, $filters['pcategory'], [
                        'id' => 'pcategory_filter',
                        'class' => 'custom_filter',
                        'data-placeholder' => 'Lọc theo category chính'
                        ]) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::select('category_filter', $categories, $filters['category'], [
                        'id' => 'category_filter',
                        'class' => 'custom_filter',
                        'data-placeholder' => 'Lọc theo category phụ'
                        ]) !!}
                </div>
            </div>
            <div id="table-toolbar">
                <a href="{!! url("/{$moduleName}/{$controllerName}/add") !!}" class="btn btn-primary btn-labeled fa fa-plus">Thêm</a>
                <button id="demo-active-row" class="btn btn-success btn-labeled fa fa-times" disabled>Kích hoạt</button>
                {{--
                <button id="demo-featured-row" class="btn btn-success btn-labeled fa fa-times" disabled>Nổi bật</button>
                <button id="demo-unfeatured-row" class="btn btn-danger btn-labeled fa fa-times" disabled>Bỏ nổi bật</button>
                --}}
                <button id="demo-inactive-row" class="btn btn-danger btn-labeled fa fa-times" disabled>Bỏ kích hoạt</button>
            </div>
            <table id="demo-custom-toolbar" class="demo-add-niftycheck" data-toggle="table"
                    data-locale="vi-VN"
                    data-toolbar="#table-toolbar"
                    data-url="{!! url("/{$moduleName}/{$controllerName}/ajax-data") !!}"
                    data-search="true"
                    data-show-refresh="true"
                    data-show-toggle="true"
                    data-show-columns="true"
                    data-pagination="true"
                    data-side-pagination="server"
                    data-page-size="{{ PAGE_LIST_COUNT }}"
                    data-query-params="queryParams"
                    data-cookie="true"
                    data-cookie-id-table="inside-video-show-all"
                    data-cookie-expire="{!! config('params.bootstrapTable.extension.cookie.cookieExpire') !!}"
                    >
                <thead>
                    <tr>
                        <th data-field="check_id" data-checkbox="true">ID</th>
                        <th data-field="name" data-sortable="true">Tên Video</th>
                        <th data-field="image_location" data-sortable="true" data-formatter="formatImage">Image Location</th>
                        <th data-field="duration" data-sortable="true">Duration</th>
                        <th data-field="category_name" data-sortable="true">Thuộc Category</th>
                        <th data-field="date_created" data-sortable="true">Ngày tạo</th>
                        {{--
                        <th data-field="is_featured" data-align="center" data-sortable="true" data-formatter="formatFeatured">
                            Nổi bật
                        </th>
                        --}}
                        <th data-field="disable" data-align="center" data-sortable="true" data-formatter="formatDisable">
                            Trạng thái
                        </th>
                        <th data-field="id" data-align="center" data-formatter="actionColumn">Thao tác</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<style type="text/css">
    .bootstrap-select {
        margin: 0;
    }
</style>

<!--Bootstrap Table [ OPTIONAL ]-->
<script src="/assets/inside/plugins/bootstrap-table/bootstrap-table.js"></script>
<script src="/assets/inside/plugins/bootstrap-table/locale/bootstrap-table-vi-VN.min.js"></script>
<script src="/assets/inside/plugins/bootstrap-table/extensions/cookie/bootstrap-table-cookie.js"></script>

<!--Bootstrap Select [ OPTIONAL ]-->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<!--Bootstrap Datepicker [ OPTIONAL ]-->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.vi.min.js" charset="UTF-8"></script>

<script type="text/javascript">
    function actionColumn(value, row, index) {
        var editBtn = [
            '<a href="{{ url("/{$moduleName}/{$controllerName}/edit") }}/' + value + '" ',
            'class="add-tooltip btn btn-primary btn-icon icon-lg btn-xs" data-placement="top" data-original-title="Sửa">',
            '<i class="fa fa-pencil"></i></a>'
        ].join('');
        var removeBtn = [
            '<a href="#" onclick="inActiveItems([' + value + '], event)"',
            'class="add-tooltip btn btn-danger btn-icon icon-lg btn-xs" data-placement="top" data-original-title="Đổi trạng thái">',
            '<i class="fa fa-trash-o"></i></a>'
        ].join('');

        return [editBtn, removeBtn].join(' ');
    }

    function formatImage(value, row, index) {

        var url = '<img src="{!! $_ENV['MEDIA_URL_IMAGE'] !!}/' + value +'" height="100" width="150">';

        return url;
    }

    function formatDisable(value, row, index) {
        return value === 0 ?
            '<span class="label label-sm label-success">Hoạt động</span>' :
            '<span class="label label-sm label-danger">Không hoạt động</span>';
    }

    function formatFeatured(value, row, index) {
        return value === 1 ?
            '<span class="label label-sm label-success">Nổi bật</span>' :
            '<span class="label label-sm label-danger">Không nổi bật</span>';
    }

    function formatRecipe(value, row, index) {
        return value === 1 ?
            '<span class="label label-sm label-success">Sổ tay</span>' :
            '<span class="label label-sm label-danger">Không sổ tay</span>';
    }

    function formatGroupName(value, row, index) {
        var colors = {
            7: 'pink',
            8: 'purple'
        };
        var className = colors[row.group] || 'gray';
        return '<span class="label label-sm label-' + className + '">' + value + '</span>'
    }

    function notifyMsg(msg) {
        $.niftyNoty({
            type: 'dark',
            title: 'Thông báo',
            message: msg,
            container: 'floating',
            timer: 5000
        });
    }

    function inActiveItems(items, e) {
        if (e) e.preventDefault();
        if (confirm('Xác nhận bỏ kích hoạt Video?')) {
            var url = '{{ url("/{$moduleName}/{$controllerName}/remove") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };
            $.post(url, data).done(function(data){
                notifyMsg(data.msg);
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-featured-row').prop('disabled', true);
                $('#demo-unfeatured-row').prop('disabled', true);
                $('#demo-inactive-row').prop('disabled', true);
                $('#demo-recipe-row').prop('disabled', true);
                $('#demo-unrecipe-row').prop('disabled', true);
                $('#demo-active-row').prop('disabled', true);
            });
        }
    }

    function activeItems(items, e) {
        if (e) e.preventDefault();
        if (confirm('Xác nhận kích hoạt Video?')) {
            var url = '{{ url("/{$moduleName}/{$controllerName}/active") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };
            $.post(url, data).done(function(data){
                notifyMsg(data.msg);
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-featured-row').prop('disabled', true);
                $('#demo-unfeatured-row').prop('disabled', true);
                $('#demo-inactive-row').prop('disabled', true);
                $('#demo-recipe-row').prop('disabled', true);
                $('#demo-unrecipe-row').prop('disabled', true);
                $('#demo-active-row').prop('disabled', true);
            });
        }
    }

    function featuredItems(items, e) {
        if (e) e.preventDefault();
        if (confirm('Xác nhận thiết lập trạng thái Video nổi bật?')) {
            var url = '{{ url("/{$moduleName}/{$controllerName}/featured") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };
            $.post(url, data).done(function(data){
                notifyMsg(data.msg);
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-featured-row').prop('disabled', true);
                $('#demo-unfeatured-row').prop('disabled', true);
                $('#demo-inactive-row').prop('disabled', true);
                $('#demo-recipe-row').prop('disabled', true);
                $('#demo-unrecipe-row').prop('disabled', true);
                $('#demo-active-row').prop('disabled', true);
            });
        }
    }

    function unFeaturedItems(items, e) {
        if (e) e.preventDefault();
        if (confirm('Xác nhận bỏ trạng thái nổi bật Video?')) {
            var url = '{{ url("/{$moduleName}/{$controllerName}/un-featured") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };
            $.post(url, data).done(function(data){
                notifyMsg(data.msg);
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-featured-row').prop('disabled', true);
                $('#demo-unfeatured-row').prop('disabled', true);
                $('#demo-inactive-row').prop('disabled', true);
                $('#demo-recipe-row').prop('disabled', true);
                $('#demo-unrecipe-row').prop('disabled', true);
                $('#demo-active-row').prop('disabled', true);
            });
        }
    }

    function recipeItems(items, e) {
        if (e) e.preventDefault();
        if (confirm('Xác nhận thiết lập sổ tay nấu ăn?')) {
            var url = '{{ url("/{$moduleName}/{$controllerName}/recipe") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };
            $.post(url, data).done(function(data){
                notifyMsg(data.msg);
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-featured-row').prop('disabled', true);
                $('#demo-unfeatured-row').prop('disabled', true);
                $('#demo-inactive-row').prop('disabled', true);
                $('#demo-recipe-row').prop('disabled', true);
                $('#demo-unrecipe-row').prop('disabled', true);
                $('#demo-active-row').prop('disabled', true);
            });
        }
    }

    function unRecipeItems(items, e) {
        if (e) e.preventDefault();
        if (confirm('Xác nhận bỏ sổ tay nấu ăn?')) {
            var url = '{{ url("/{$moduleName}/{$controllerName}/un-recipe") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };
            $.post(url, data).done(function(data){
                notifyMsg(data.msg);
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-featured-row').prop('disabled', true);
                $('#demo-unfeatured-row').prop('disabled', true);
                $('#demo-inactive-row').prop('disabled', true);
                $('#demo-recipe-row').prop('disabled', true);
                $('#demo-unrecipe-row').prop('disabled', true);
                $('#demo-active-row').prop('disabled', true);
            });
        }
    }

    function queryParams(params) {
        params.status = $('#status_filter').val();
        params.from = $('#from_filter').val();
        params.to = $('#to_filter').val();
        params.pcategory = $('#pcategory_filter').val();
        params.category = $('#category_filter').val();
        params.featured = $('#featured_filter').val();
        params.is_new = $('#new_filter').val();
        params.is_like = $('#like_filter').val();
        params.is_for_you = $('#for_you_filter').val();
        return params;
    }

    $(document).ready(function() {

        @if (session('msg'))
            notifyMsg('{{ session('msg') }}');
        @endif

        var $table = $('#demo-custom-toolbar'),

        $remove = $('#demo-inactive-row');
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
        }).on('load-success.bs.table', function () {
            var tooltip = $('.add-tooltip');
            if (tooltip.length)tooltip.tooltip();
        });

        $remove.click(function () {
            var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id
            });
            inActiveItems(ids);
        });

        $active = $('#demo-active-row');
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $active.prop('disabled', !$table.bootstrapTable('getSelections').length);
        }).on('load-success.bs.table', function () {
            var tooltip = $('.add-tooltip');
            if (tooltip.length)tooltip.tooltip();
        });

        $active.click(function () {
            var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id
            });
            activeItems(ids);
        });

        $featured = $('#demo-featured-row');
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $featured.prop('disabled', !$table.bootstrapTable('getSelections').length);
        }).on('load-success.bs.table', function () {
            var tooltip = $('.add-tooltip');
            if (tooltip.length)tooltip.tooltip();
        });

        $featured.click(function () {
            var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id
            });
            featuredItems(ids);
        });

        $unfeatured = $('#demo-unfeatured-row');
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $unfeatured.prop('disabled', !$table.bootstrapTable('getSelections').length);
        }).on('load-success.bs.table', function () {
            var tooltip = $('.add-tooltip');
            if (tooltip.length)tooltip.tooltip();
        });

        $unfeatured.click(function () {
            var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id
            });
            unFeaturedItems(ids);
        });

        $recipe = $('#demo-recipe-row');
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $recipe.prop('disabled', !$table.bootstrapTable('getSelections').length);
        }).on('load-success.bs.table', function () {
            var tooltip = $('.add-tooltip');
            if (tooltip.length)tooltip.tooltip();
        });

        $recipe.click(function () {
            var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id
            });
            recipeItems(ids);
        });

        $unrecipe = $('#demo-unrecipe-row');
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $unrecipe.prop('disabled', !$table.bootstrapTable('getSelections').length);
        }).on('load-success.bs.table', function () {
            var tooltip = $('.add-tooltip');
            if (tooltip.length)tooltip.tooltip();
        });

        $unrecipe.click(function () {
            var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id
            });
            unRecipeItems(ids);
        });

        // select_filter
        $('.custom_filter').chosen({width:'100%'});
        $('.custom_filter').on('change', function(evt, params) {
            $table.bootstrapTable('refresh');
        });

        $('#date_from,#date_to').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true,
            language: 'vi'
        }).on('changeDate', function (e) {
            $table.bootstrapTable('refresh');
        });

        $('#reset-page').click(function () {
            document.getElementById('to_filter').value = '';
            document.getElementById('from_filter').value = '';
            document.getElementById('status_filter').value = 'active';
            $('#status_filter').trigger('chosen:updated');
            document.getElementById('pcategory_filter').value = '';
            $('#pcategory_filter').trigger('chosen:updated');
            document.getElementById('category_filter').value = '';
            $('#category_filter').trigger('chosen:updated');
            $table.bootstrapTable('refresh');
            return false;
        });
    });

</script>
@endsection