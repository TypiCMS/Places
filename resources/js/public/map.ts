import styles from './map-styles';
import getMarkerPopup from './map-popup';
import { MarkerClusterer, SuperClusterAlgorithm } from '@googlemaps/markerclusterer';

export default async (): Promise<void> => {
    const mapElement: HTMLDivElement = document.getElementById('map') as HTMLDivElement,
        apiUrl: string = mapElement.dataset.url as string,
        noButton: string = mapElement.dataset.noButton as string,
        locale: string = document.documentElement.getAttribute('lang') as string,
        buttonLabel: string = mapElement.dataset.buttonLabel as string,
        popupContent: HTMLDivElement = document.createElement('div') as HTMLDivElement,
        useCustomPopup: boolean = true,
        infoWindow: google.maps.InfoWindow = new google.maps.InfoWindow(),
        map: google.maps.Map = new google.maps.Map(mapElement, {
            mapTypeId: 'roadmap',
            zoom: 12,
            mapTypeControl: false,
            streetViewControl: false,
            styles,
        });
    let bounds: google.maps.LatLngBounds = new google.maps.LatLngBounds(),
        places: object[] = [],
        markers: google.maps.Marker[] = [],
        markerClusterer: MarkerClusterer = new MarkerClusterer({
            map,
            algorithm: new SuperClusterAlgorithm({ radius: 30 }),
            renderer: {
                render: ({ count, position }) => {
                    return new google.maps.Marker({
                        position,
                        icon: {
                            anchor: new google.maps.Point(15, 15),
                            url: '/img/marker-cluster.svg',
                        },
                        label: {
                            text: String(count),
                            color: 'rgba(255,255,255,1)',
                            fontSize: '12px',
                            fontWeight: '700',
                        },
                        zIndex: Number(google.maps.Marker.MAX_ZINDEX) + count,
                    });
                },
            },
        });

    try {
        const response = await fetch(apiUrl, {
            headers: { Accept: 'application/json' },
        });
        if (response.ok) {
            const data = await response.json();
            places = Array.isArray(data) ? data : [data];
        }
    } catch (error) {
        console.error(error);
    }

    const buildContent = ({ place }: { place: any }): string => {
        let coords: string[] = [];
        let htmlString: string = '<div class="popup-bubble-content">';
        htmlString += place.image ? '<img class="popup-bubble-content-image" src="/storage/' + place.image.path + '" height="40" alt="">' : '';
        htmlString += '<h3 class="popup-bubble-content-title">';
        htmlString += place.title[locale];
        htmlString += '</h3>';
        htmlString += '<div class="popup-bubble-content-address">';
        if (place.address) {
            coords.push(place.address);
        }
        htmlString += coords.join('<br>');
        htmlString += '</div>';
        if (!noButton) {
            htmlString += '<a class="popup-bubble-content-button" href="' + place.url + '">';
            htmlString += buttonLabel ?? 'More info';
            htmlString += '</a>';
        }
        htmlString += '</div>';

        return htmlString;
    };

    places.forEach((place: any) => {
        const position: google.maps.LatLng = new google.maps.LatLng(place.latitude, place.longitude),
            marker: google.maps.Marker = new google.maps.Marker({
                position,
                icon: place.id === 1 ? '/img/marker-1.svg' : '/img/marker-2.svg',
                title: place['title'][locale],
                optimized: false,
            });
        bounds.extend(position);
        marker.addListener('click', (): void => {
            popupContent.innerHTML = buildContent({ place });
            if (useCustomPopup) {
                // Custom Popup
                const MarkerPopup = getMarkerPopup();
                const popup = new MarkerPopup(position, popupContent);
                popup.setMap(map);
                setTimeout(() => {
                    map.panTo(position);
                    map.panBy(0, -50);
                }, 300);
            } else {
                // Default InfoWindow
                infoWindow.close();
                infoWindow.setContent(popupContent.innerHTML);
                infoWindow.open(marker.getMap(), marker);
            }
        });
        markers.push(marker);
        markerClusterer.addMarker(marker);
    });

    if (markers.length === 1) {
        google.maps.event.trigger(markers[0], 'click');
    } else {
        map.fitBounds(bounds, 0);
    }
};
