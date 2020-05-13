// Gmaps
var map = {
    apiUrl: document.getElementById('map').getAttribute('data-url'),
    locale: document.documentElement.getAttribute('lang'),
    map: null,
    places: [],
    infoWindow: null,
    buttonLabel: document.getElementById('map').getAttribute('data-button-label'),
    options: {
        mapTypeId: 'roadmap',
        center: { lat: 50.85, lng: 4.36 },
        zoom: 5,
        mapTypeControl: false,
        streetViewControl: false,
        styles: [
            {
                stylers: [{ visibility: 'simplified' }, { saturation: -50 }, { weight: 3 }],
            },
            {
                elementType: 'labels',
                stylers: [{ lightness: 20 }],
            },
            {
                featureType: 'road.highway',
                elementType: 'labels',
                stylers: [{ visibility: 'off' }],
            },
            {
                featureType: 'road.arterial',
                elementType: 'labels',
                stylers: [{ visibility: 'off' }],
            },
            {
                featureType: 'poi',
                stylers: [{ visibility: 'off' }],
            },
            {
                featureType: 'transit',
                stylers: [{ visibility: 'off' }],
            },
        ],
    },
    init: function() {
        this.map = new google.maps.Map(document.getElementById('map'), this.options);
        this.oms = new OverlappingMarkerSpiderfier(this.map, {
            markersWontMove: true,
            markersWontHide: true,
            basicFormatEvents: true,
        });
        this.infoWindow = new google.maps.InfoWindow({
            maxWidth: 260,
        });
        google.maps.event.addListenerOnce(this.map, 'bounds_changed', function() {
            if (this.getZoom() > 5) {
                this.setZoom(5);
            }
        });
        this.fetchData();
    },
    fetchData: function() {
        var self = this;
        var request = new XMLHttpRequest();
        request.open('GET', this.apiUrl, true);
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                var data = JSON.parse(this.response);
                if (!Array.isArray(data)) {
                    self.places = [data];
                } else {
                    self.places = data;
                }
                if (self.places.length > 0) {
                    self.setMarkers();
                }
            }
        };
        request.send();
    },
    setMarkers: function() {
        var bounds = new google.maps.LatLngBounds();
        for (var i = this.places.length - 1; i >= 0; i--) {
            if (this.places[i].longitude) {
                this.places[i].marker = new google.maps.Marker({
                    // icon: {
                    //     url: '/img/marker.png',
                    //     scaledSize: { width: 16, height: 24 },
                    // },
                    position: new google.maps.LatLng(this.places[i].latitude, this.places[i].longitude),
                    map: this.map,
                    title: this.places[i]['title'][this.locale],
                    content: this.buildContent(this.places[i]),
                });
                bounds.extend(this.places[i].marker.position);
                var self = this;
                this.places[i].marker.addListener('spider_click', function() {
                    self.onMarkerClick(this);
                });
                this.oms.trackMarker(this.places[i].marker);
            }
        }
        if (this.places.length > 1) {
            this.map.fitBounds(bounds);
        } else if (this.places.length === 1) {
            this.openMarker(this.places[0].marker);
        }
    },
    openMarker: function(marker) {
        this.map.panTo(marker.position);
        this.map.setZoom(13);
        google.maps.event.trigger(marker, 'click');
    },
    onMarkerClick: function(marker) {
        this.infoWindow.setContent(marker.content);
        this.infoWindow.open(this.map, marker);
    },
    buildContent: function(place) {
        var coords = [];
        var data = place.image
            ? '<img width="150" src="/storage/' + place.image.path + '" class="map-item-image">'
            : '';
        data += '<div class="map-item-info"><h3 class="map-item-title">';
        data += place.title[this.locale];
        data += '</h3>';
        data += '<div class="map-item-address">';
        if (place.address) {
            coords.push(place.address);
        }
        data += coords.join('<br>');
        data += '</div>';
        if (this.buttonLabel !== null) {
            data += '<a href="' + place.url + '"';
            data += 'class="btn btn-sm btn-outline-secondary">';
            data += this.buttonLabel;
            data += '</a>';
        }
        data += '</div>';

        return data;
    },
};
if (document.getElementById('map') !== null) {
    map.init();
}
