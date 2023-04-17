<ul class="place-list-results-list">
    @foreach ($items as $place)
        <li class="place-list-results-item">
            <a class="place-list-results-item-link" href="{{ $place->uri() }}">
                {{ $place->title }}
            </a>
        </li>
    @endforeach
</ul>
