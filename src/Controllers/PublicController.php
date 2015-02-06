<?php
namespace TypiCMS\Modules\Places\Controllers;

use Illuminate\Support\Str;
use View;
use Request;
use Response;
use TypiCMS;
use TypiCMS\Modules\Places\Repositories\PlaceInterface;
use TypiCMS\Controllers\BasePublicController;

class PublicController extends BasePublicController
{

    public function __construct(PlaceInterface $place)
    {
        parent::__construct($place);
        $this->title['parent'] = Str::title(trans_choice('places::global.places', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        TypiCMS::setModel($this->repository->getModel());

        $this->title['child'] = '';

        $places = $this->repository->getAll();

        // if (Request::wantsJson()) {
        //     return Response::json($places, 200);
        // }

        return view('places::public.index')
            ->withPlaces($places);
    }

    /**
     * Search models.
     *
     * @return Response
     */
    public function search()
    {

        $models = $this->repository->getAll();

        return view('places::public.results')
            ->with(compact('models'));
    }

    /**
     * Show place.
     *
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        TypiCMS::setModel($model);

        $this->title['parent'] = $model->title;

        return view('places::public.show')
            ->with(compact('model'));
    }
}
