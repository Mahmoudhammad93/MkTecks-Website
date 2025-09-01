@if ($paginator->hasPages())
    <nav aria-label="..." style="margin: 0 auto ;margin-top: 20px; margin-bottom: 20px;display: flex;">
        <ul style="margin: 0 auto" class="pagination pagination-primary">

            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">{{ trans('admin.Previous') }} →</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ trans('admin.Previous') }} →</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}"
                        rel="next">← {{ trans('admin.Next') }}</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">← {{ trans('admin.Next') }}</span></li>
            @endif
        </ul>
    </nav>
@endif
