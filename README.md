# Places

Manage places and show them on a map.

## Installation

1. Require the package using composer:

```bash
composer require typicms/places
```

2. Add the service provider in your config/app.php file:

```
'providers' => [
    /*
     * TypiCMS Modules Service Providers.
     */
    TypiCMS\Modules\Places\Providers\ModuleProvider::class,
];
```

3. Publish files from this module to your project, run:

```bash
php artisan vendor:publish --provider="TypiCMS\Modules\Places\Providers\ModuleServiceProvider"
```

4. Set a Google Maps API key in your .env file.
   See [Google Maps Platform](https://developers.google.com/maps/documentation/javascript/get-api-key).

5. Install @googlemaps/markerclusterer:

```bash
yarn add @googlemaps/markerclusterer --dev
```

6. Uncomment the following lines in `/resources/js/public.js`:

```js
import initMap from './public/map';

window.initMap = initMap;
```

7. Import the scss file in `/resources/scss/public.scss`:

```scss
@import 'public/map';
```

8. Run `yarn dev` to compile the assets.

This module is part of [TypiCMS](https://github.com/TypiCMS/Base), a multilingual CMS based on
the [Laravel framework](https://github.com/laravel/framework).
