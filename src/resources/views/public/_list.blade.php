<ul class="places-list">
    @foreach ($items as $place)
    @include('places::public._list-item')
    @endforeach
</ul>
