<ul class="list {{isset($child) ? 'child d-none' : ''}}">
    @forelse($items as $item)
        <li class="item">
            <p class="item-title {{array_key_exists('items', $item) ? 'text-success' : 'text-danger'}}">
                {{--<i class="bi {{array_key_exists('items', $item) ? 'bi-arrow-down-circle-fill' : ''}}"></i>--}}
                {{$item['title']}}
            </p>
            @if(array_key_exists('items', $item))
                @include('lists.partials.items',['items' => $item['items'], 'child' => true])
            @endif
        </li>
    @empty
        <li>No items</li>
    @endforelse
</ul>

