<?php
    use App\MyCore\Inside\Helpers\DisplayColumnSort;
?>
@extends("{$moduleName}.layout.master")
@section('content')
<?php
    $searchOptions = array(
        'config_key_search'  => 'Tên key'
    );
?>

<div id="page-title">
    <h1 class="page-header text-overflow"><?php echo $title?></h1>
</div>

<ol class="breadcrumb">
    <li class="active"><?php echo $title?></li>
</ol>

<div id="page-content">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Danh sách</h3>
        </div>
        <div class="panel-body">
            <div class="bootstrap-table">
                <div class="fixed-table-toolbar">
                    <div class="bars pull-left">
                        <button onclick="window.location.href='{!! url("/{$moduleName}/{$controllerName}/add"); !!}'" type="button" class="btn btn-primary btn-labeled fa fa-plus">
                            Thêm mới
                        </button>

                        <button type="button" class="btn btn-default btn-labeled fa fa-remove remove" url="{!! url("/{$moduleName}/{$controllerName}/remove"); !!}">
                            Xóa
                        </button>
                    </div>
                    <form class="form-search pull-right span6" method="get">
                        <div class="columns columns-right btn-group pull-right">
                            <button class="btn btn-default" type="submit" title="Tìm kiếm"><i class="fa fa-search"></i></button>
                            <button  onclick="window.location.href='{!! url("{$moduleName}/{$controllerName}/show-all"); !!}'" class="btn btn-default" type="button" name="refresh" title="Tìm lại"><i class="fa fa-refresh"></i></button>
                        </div>
                        <div class="columns columns-right btn-group pull-right">
                            <select name="search_type" class="form-control" style="height: 31px;">
                                <option value="ALL">All</option>
                                <?php
                                    $searchKeyword = '';
                                    if (isset($params['search_keyword'])) :
                                        $searchKeyword = $params['search_keyword'];
                                    endif;

                                    $searchType = '';
                                    if (isset($params['search_type'])) :
                                        $searchType = $params['search_type'];
                                    endif;

                                    foreach ($searchOptions as $searchOptionKey => $searchOptionValue):
                                        $selected = '';
                                        if ($searchType == $searchOptionKey) {
                                            $selected = 'selected';
                                        }
                                ?>
                                    <option <?php echo $selected?> value="<?php echo $searchOptionKey?>"><?php echo $searchOptionValue?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="pull-right search">
                            <input type="text" class="form-control" name="search_keyword" placeholder="Tìm kiếm" value="<?php echo $searchKeyword?>">
                        </div>
                    </form>
                </div>
                <div class="fixed-table-container">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="bs-checkbox " style="width: 36px;">
                                    <div class="th-inner "><label class="form-checkbox form-normal form-primary form-text"><input name="btSelectAll" class="item-id-all" type="checkbox"></label></div>
                                </th>
                                <th>
                                    <div class="th-inner">
                                        Tên config
                                        {!! DisplayColumnSort::show('config_key') !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="th-inner">
                                        Ngày tạo
                                        {!! DisplayColumnSort::show('date_created') !!}
                                    </div>
                                </th>
                                <th>
                                    <div class="th-inner">
                                        Trạng thái
                                        {!! DisplayColumnSort::show('is_deleted') !!}
                                    </div>
                                </th>
                                <th style="width: 80px;">
                                    <div class="th-inner">Action</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginate as $row)
                                <tr>
                                    <td class="select-item">
                                        <label class="form-checkbox form-normal form-primary form-text">
                                            <input type="checkbox" class="item-id" value="{!! $row->config_id !!}">
                                        </label>
                                    </td>
                                    <td>
                                        <?php echo $row->config_key?>
                                    </td>
                                    <td>
                                        <?php
                                            $date = new DateTime($row->date_created);
                                            echo $date->format('m-d-Y H:i a');
                                        ?>
                                    </td>
                                    <td align="center">
                                        @if ($row->is_deleted)
                                            <span class="label label-sm label-danger">không hoạt động</span>
                                        @else
                                            <span class="label label-sm label-primary">Hoạt động</span>
                                        @endif
                                    </td>
                                    <td align="center">
                                        <a href="{!! url("/{$moduleName}/{$controllerName}/edit/{$row->config_id}"); !!}" class="add-tooltip btn btn-primary btn-icon icon-lg btn-xs" data-placement="top" data-original-title="Sửa"><i class="fa fa-pencil"></i></a>
                                        @if (!$row->is_deleted)
                                            <a href="{!! url("/{$moduleName}/{$controllerName}/remove/{$row->config_id}"); !!}" class="add-tooltip btn btn-danger btn-icon icon-lg btn-xs" data-placement="top" data-original-title="Xóa"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-6">
                            @include("{$moduleName}.pagination", [$paginate])
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection