const geometry = '#dedede';
const road = '#f5f5f5';
const sea = '#ffffff';
const label = '#616161';
const stroke = '#ffffff';
export default [
    {
        elementType: 'geometry',
        stylers: [
            {
                color: geometry,
            },
        ],
    },
    {
        elementType: 'labels.icon',
        stylers: [
            {
                visibility: 'off',
            },
        ],
    },
    {
        elementType: 'labels.text.fill',
        stylers: [
            {
                color: label,
            },
        ],
    },
    {
        elementType: 'labels.text.stroke',
        stylers: [
            {
                color: geometry,
            },
        ],
    },
    {
        featureType: 'administrative',
        elementType: 'geometry',
        stylers: [
            {
                visibility: 'off',
            },
        ],
    },
    {
        featureType: 'administrative.country',
        elementType: 'geometry.stroke',
        stylers: [
            {
                color: stroke,
            },
            {
                visibility: 'on',
            },
        ],
    },
    {
        featureType: 'administrative.country',
        elementType: 'labels.text.stroke',
        stylers: [
            {
                visibility: 'off',
            },
        ],
    },
    {
        featureType: 'administrative.land_parcel',
        stylers: [
            {
                visibility: 'off',
            },
        ],
    },
    {
        featureType: 'administrative.locality',
        stylers: [
            {
                visibility: 'on',
            },
        ],
    },
    {
        featureType: 'administrative.neighborhood',
        stylers: [
            {
                visibility: 'off',
            },
        ],
    },
    {
        featureType: 'administrative.province',
        stylers: [
            {
                visibility: 'off',
            },
        ],
    },
    {
        featureType: 'poi',
        stylers: [
            {
                visibility: 'off',
            },
        ],
    },
    {
        featureType: 'road',
        elementType: 'geometry',
        stylers: [
            {
                color: road,
            },
        ],
    },
    {
        featureType: 'transit',
        stylers: [
            {
                visibility: 'off',
            },
        ],
    },
    {
        featureType: 'water',
        elementType: 'geometry',
        stylers: [
            {
                color: sea,
            },
        ],
    },
    {
        featureType: 'water',
        elementType: 'labels.text',
        stylers: [
            {
                visibility: 'off',
            },
        ],
    },
];
