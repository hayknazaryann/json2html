<ul class="list {{isset($child) ? 'child' : ''}} {{$req_depth >= $n ? 'd-block' : 'd-none'}}"  data-depth="{{$n}}">
    @forelse($items as $key => $item)
        <li class="item">
            <p class="item-title {{array_key_exists('items', $item) ? 'text-success' : 'text-danger'}}">
                {{$item['title']}}
            </p>
            @if(array_key_exists('items', $item))
                @include('lists.partials.items',['items' => $item['items'], 'child' => true, 'n' => ($n+1)])
            @endif
        </li>
    @empty
        <li>No items</li>
    @endforelse
</ul>
<script></script>

