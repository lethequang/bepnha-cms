@extends("{$moduleName}.layout.master")
@section('content')

<div id="page-title">
    <h1 class="page-header text-overflow"><?php echo $title?></h1>
</div>

<ol class="breadcrumb">
    <li class=""><?php echo $title?></li>
    <li class="active">Danh sách nhóm người dùng</li>
</ol>

<div id="page-content">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Danh sách nhóm người dùng</h3>
        </div>
        <div class="panel-body">
            <div id="table-toolbar">
                <button id="demo-delete-row" class="btn btn-danger btn-labeled fa fa-times" disabled>Đổi trạng thái</button>
                <a href="{!! url("/{$moduleName}/{$controllerName}/add") !!}" class="btn btn-primary btn-labeled fa fa-plus">Thêm</a>
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
                    data-cookie="true"
                    data-cookie-id-table="inside-location-show-all"
                    data-cookie-expire="{!! config('params.bootstrapTable.extension.cookie.cookieExpire') !!}"
                    >
                <thead>
                    <tr>
                        <th data-field="check_id" data-checkbox="true">ID</th>
                        <th data-field="name" data-sortable="true">Tên nhóm</th>
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
<script type="text/javascript">

    function actionColumn(value, row, index) {
        var editBtn = [
            '<a href="{{ url("/{$moduleName}/{$controllerName}/edit") }}/' + value + '" ',
            'class="add-tooltip btn btn-primary btn-icon icon-lg btn-xs" data-placement="top" data-original-title="Sửa">',
            '<i class="fa fa-pencil"></i></a>'
        ].join('');
        var removeBtn = [
            '<a href="#" onclick="removeItems([' + value + '], event)"',
            'class="add-tooltip btn btn-danger btn-icon icon-lg btn-xs" data-placement="top" data-original-title="Đổi trạng thái">',
            '<i class="fa fa-trash-o"></i></a>'
        ].join('');

        return [editBtn, removeBtn].join(' ');
    }

    function formatDisable(value, row, index) {
        return value === 0 ?
            '<span class="label label-sm label-primary">Hoạt động</span>' :
            '<span class="label label-sm label-danger">Không hoạt động</span>';
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
        if (confirm('Xác nhận xóa?')) {
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
    });

</script>
@endsection