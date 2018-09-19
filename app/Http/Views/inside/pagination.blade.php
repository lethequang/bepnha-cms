@if ($paginate->lastPage() > 1)
    <?php 
        $urlParams = (isset($params['search_type'])) ? "&search_type={$params['search_type']}" : '';
        $urlParams .= (isset($params['search_keyword'])) ? "&search_keyword=" . urlencode($params['search_keyword']) : '';
    ?>
    <ul class="pagination pagination-sm" style="float: right;">
        @if($paginate->currentPage() != 1)
            <li>
                <a href="{{ $paginate->url(1) . $urlParams }}" class="item{{ ($paginate->currentPage() == 1) ? ' uk-disabled' : '' }}">
                    <i class="icon left arrow"></i> ← Đầu trang
                </a>
            </li>
        @endif

        @for ($i = 1; $i <= $paginate->lastPage(); $i++)
            <li>
                <a href="{{ $paginate->url($i) . $urlParams }}" class="item{{ ($paginate->currentPage() == $i) ? ' uk-active' : '' }}">{{ $i }}</a>
            </li>
        @endfor

        @if($paginate->currentPage() != $paginate->lastPage())
            <li>
                <a href="{{ $paginate->url($paginate->currentPage()+1) . $urlParams }}" class="item{{ ($paginate->currentPage() == $paginate->lastPage()) ? ' uk-disabled' : '' }}">
                    Cuối cùng → <i class="icon right arrow"></i>
                </a>
            </li>
        @endif
    </ul>
@endif