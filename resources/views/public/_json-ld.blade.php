<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Place",
    "address": "{{ $place->address }}",
    "name": "{{ $place->title }}",
    "description": "{{ $place->summary !== '' ? $place->summary : strip_tags($place->body) }}",
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": "{{ $place->latitude }}",
        "longitude": "{{ $place->longitude }}"
    },
    "image": [
        "{{ $place->present()->image() }}"
    ],
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $place->uri() }}"
    }
}
</script>
