<ul class="list-places">
    @foreach ($items as $place)
    @include('places::public._list-item')
    @endforeach
</ul>
