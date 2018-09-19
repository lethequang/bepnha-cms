@extends("{$moduleName}.layout.master")
@section('content')

<div id="page-title">
    <h1 class="page-header text-overflow">Danh sách Video có lượt xem nhiều nhất</h1>
</div>

<ol class="breadcrumb">
    <li class="">Danh sách Video</li>
    <li class="active">Top 50 video</li>
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
        <div class="panel-body">
            <div id="table-toolbar">
                <a href="{!! url("/{$moduleName}/videos/export-excel-top-view/xls") !!}"><button class="btn btn-success">Download Excel xls</button></a>
                <a href="{!! url("/{$moduleName}/videos/export-excel-top-view/xlsx") !!}"><button class="btn btn-success">Download Excel xlsx</button></a>
            </div>
            <table id="demo-custom-toolbar" class="demo-add-niftycheck" data-toggle="table"
                    data-locale="vi-VN"
                    data-toolbar="#table-toolbar"
                    data-url="{!! url("/{$moduleName}/videos/ajax-data-top-view") !!}"
                    data-search="true"
                    data-show-refresh="true"
                    data-show-toggle="true"
                    data-show-columns="true"
                    data-pagination="true"
                    data-side-pagination="server"
                    data-page-size="{{ PAGE_LIST_COUNT }}"
                    data-query-params="queryParams"
                    data-cookie="true"
                    data-cookie-id-table="inside-top-video-show-all"
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
                        <th data-field="view_count" data-sortable="true">Lượt xem</th>
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

    $('#reset-page').click(function (){
    	var url = window.location.href;
    	window.location = url;
    });

    function formatImage(value, row, index) {

        var url = '<img src="{!! $_ENV['MEDIA_URL_IMAGE'] !!}/' + value +'" height="100" width="150">';

        return url;
    }

    function formatDisable(value, row, index) {
        return value === 0 ?
            '<span class="label label-sm label-primary">Hoạt động</span>' :
            '<span class="label label-sm label-danger">Không hoạt động</span>';
    }

    function formatProcessStatus(value, row, index) {

        if(value === 'pending')
        {
        	return '<span class="label label-sm label-primary">Chưa duyệt</span>'
        }
        else if(value === 'public')
        {
        	return '<span class="label label-sm label-primary">Đã duyệt</span>'
        }
        else
        {
            return '<span class="label label-sm label-danger">Đã xóa</span>';
        }
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

    function removeItems(items, e) {
        if (e) e.preventDefault();
        if (confirm('Xác nhận đổi trạng thái?')) {
            var url = '{{ url("/{$moduleName}/{$controllerName}/remove") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };
            $.post(url, data).done(function(data){
                notifyMsg(data.msg);
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-delete-row').prop('disabled', true);
            });
        }
    }

    function queryParams(params) {
        params.language_code = $('#language_filter').val();
        params.status = $('#status_filter').val();
        params.from = $('#from_filter').val();
        params.to = $('#to_filter').val();
        params.category = $('#category_filter').val();
        return params;
    }

    $(document).ready(function() {

        @if (session('msg'))
            notifyMsg('{{ session('msg') }}');
        @endif

        var $table = $('#demo-custom-toolbar'), $remove = $('#demo-delete-row');
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
            removeItems(ids);
        });

        // select_filter
        $('.custom_filter').chosen({width:'100%'});
        $('.custom_filter').on('change', function(evt, params) {
            $table.bootstrapTable('refresh');
        });

        $('#daterange').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true,
            language: 'vi'
        }).on('changeDate', function (e) {
            $table.bootstrapTable('refresh');
        });
    });

</script>
@endsection