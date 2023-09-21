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
    TypiCMS\Modules\Places\Providers\ModuleServiceProvider::class,
];
```

3. Publish files from this module to your project, run:

```bash
php artisan vendor:publish --provider="TypiCMS\Modules\Places\Providers\ModuleServiceProvider"
```

4. Run the migration:

```bash
php artisan migrate
```

5. Set a Google Maps API key in your .env file.
   See [Google Maps Platform](https://developers.google.com/maps/documentation/javascript/get-api-key).

6. Install @googlemaps/markerclusterer and :

```bash
bun add @googlemaps/markerclusterer --dev
bun add @types/google.maps --dev
```

7. Uncomment the following lines in `/resources/js/public.js`:

```js
import initMap from './public/map';

window.initMap = initMap;
```

8. Add this line to the `/resources/scss/public.scss` file:

```scss
@import 'public/map';
```

9. Run `bun run dev` to compile the assets.

10. Connect to the admin panel, add some places, create a page linked to the module Places and visit this page to see
    the places on a map.

This module is part of [TypiCMS](https://github.com/TypiCMS/Base), a multilingual CMS based on
the [Laravel framework](https://github.com/laravel/framework).
