@if ($paginator->hasPages())
    <div class="review-pagination">
        <p>{{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of {{ $paginator->total() }}</p>
        <ul class="pagination">
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url . '&items=' . $paginator->perPage() }}"> {{ $page }} </a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </div>
@endif
