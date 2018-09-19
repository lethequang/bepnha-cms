@extends("{$moduleName}.layout.master")
@section('content')

<div id="page-title">
    <h1 class="page-header text-overflow"><?php echo $title?></h1>
</div>

<ol class="breadcrumb">
    <li class=""><?php echo $title?></li>
    <li class="active">Danh sách</li>
</ol>

<div id="page-content">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Danh sách</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3">
                    {!! Form::select('group_filter', $groups, null, [
                        'id' => 'group_filter',
                        'class' => 'custom_filter',
                        'data-placeholder' => 'Lọc theo Group']) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::select('status_filter', $status, null, [
                        'id' => 'status_filter',
                        'class' => 'custom_filter',
                        'data-placeholder' => 'Lọc theo trạng thái']) !!}
                </div>
            </div>
            <div id="table-toolbar">
                <button id="demo-delete-row" class="btn btn-danger btn-labeled fa fa-times" disabled>Đổi trạng thái</button>
                <a href="{!! url("/{$moduleName}/{$controllerName}/add") !!}" class="btn btn-primary btn-labeled fa fa-plus">Thêm</a>
            </div>
            <table id="demo-custom-toolbar" class="demo-add-niftycheck" data-toggle="table"
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
                    data-cookie-id-table="inside-staffs-show-all"
                    data-cookie-expire="{!! config('params.bootstrapTable.extension.cookie.cookieExpire') !!}"
                    >
                <thead>
                    <tr>
                        <th data-field="check_id" data-checkbox="true">ID</th>
                        <th data-field="email" data-sortable="true">Mã / email</th>
                        <th data-field="fullname" data-sortable="true">Họ tên</th>
                        <th data-field="phone" data-sortable="true">Số ĐT</th>
                        <th data-field="group_name" data-align="center" data-sortable="true" data-formatter="formatGroupName">
                            Vị trí
                        </th>
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

<div class="modal fade" id="reset-password-modal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <form class="modal-content" id="reset-password-form" data-url="{{ url("/{$moduleName}/{$controllerName}/reset-password") }}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h4 class="modal-title">Reset mật khẩu</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="password_field">
                        <strong>Mật khẩu mới</strong>
                        <span class="symbol required"></span>
                    </label>
                    {!! Form::text('password', null, ['class' => 'form-control', 'id' => 'password_field']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Đóng</button>
                {{ csrf_field() }}
                {{ Form::hidden('staff_id', null, ['id' => 'staff_id_hidden']) }}
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<!--Bootstrap Table [ OPTIONAL ]-->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<style type="text/css">
.chosen-container {
    margin: 0;
}

</style>

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
        var changePwdBtn = [
            '<button data-target="#reset-password-modal" data-toggle="modal" ',
            'class="add-tooltip btn btn-warning btn-icon icon-lg btn-xs" ',
            'data-placement="top" data-original-title="Reset mật khẩu" data-id="' + value + '">',
            '<i class="fa fa-key"></i></button>'
        ].join('');
        return [editBtn, removeBtn, changePwdBtn].join(' ');
    }

    function formatDisable(value, row, index) {
        return value === 0 ?
            '<span class="label label-sm label-primary">Hoạt động</span>' :
            '<span class="label label-sm label-danger">Không hoạt động</span>';
    }

    function formatGroupName(value, row, index) {
        var colors = {
            1: 'primary',
            2: 'success',
            3: 'mint',
            4: 'warning',
            5: 'danger'
        };
        var className = colors[row.group] || 'gray';
        return '<span class="label label-sm label-' + className + '">' + value + '</span>'
    }

    function queryParams(params) {
        params.group = $('#group_filter').val();
        params.status = $('#status_filter').val();
        return params;
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
        if (confirm('Xác nhận?')) {
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

        // group filter
        $('.custom_filter').chosen({width:'100%'});
        $('.custom_filter').on('change', function(evt, params) {
            $table.bootstrapTable('refresh');
        });

        // reset password modal
        $('#reset-password-modal').on('shown.bs.modal', function (e) {
            $('#password_field').focus();
            var staff_id = $(e.relatedTarget).data('id');
            $('#staff_id_hidden').val(staff_id);
        });
        $('#reset-password-form').submit(function (e) {
            var url = $(this).data('url');
            if ($('#password_field').val() === '') {
                alert('Vui lòng nhập mật khẩu mới');
                $('#password_field').focus();
                return e.preventDefault();
            }
            var payload = $(this).serialize();
            $.post(url, payload).done(function(data){
                $('#reset-password-modal').modal('hide');
                $('#password_field').val('');
                notifyMsg(data.msg);
            });
            e.preventDefault();
        });
    });
</script>
@endsection