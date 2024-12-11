<div class="d-flex justify-content-center mt-4 paginet">
    <ul class="pagination">
        <!-- Previous Page Link -->
        @if ($data->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">&laquo; Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $data->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
            </li>
        @endif

        <!-- Pagination Elements -->
        @php
            $start = max($data->currentPage() - 2, 1);
            $end = min($start + 4, $data->lastPage());
        @endphp

        @if($start > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $data->url(1) }}">1</a>
            </li>
            @if($start > 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $i == $data->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        @if($end < $data->lastPage())
            @if($end < $data->lastPage() - 1)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
            <li class="page-item">
                <a class="page-link" href="{{ $data->url($data->lastPage()) }}">{{ $data->lastPage() }}</a>
            </li>
        @endif

        <!-- Next Page Link -->
        @if ($data->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $data->nextPageUrl() }}" rel="next">Next &raquo;</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next &raquo;</span>
            </li>
        @endif
    </ul>
</div>
