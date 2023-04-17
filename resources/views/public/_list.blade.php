<ul class="place-list-list">
    @foreach ($items as $place)
        @include('places::public._list-item')
    @endforeach
</ul>
