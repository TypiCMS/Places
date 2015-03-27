<?php
namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Support\Str;
use View;
use Request;
use Response;
use TypiCMS;
use TypiCMS\Modules\Places\Repositories\PlaceInterface;
use TypiCMS\Http\Controllers\BasePublicController;

class PublicController extends BasePublicController
{

    public function __construct(PlaceInterface $place)
    {
        parent::__construct($place);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        TypiCMS::setModel($this->repository->getModel());

        $models = $this->repository->all();

        return view('places::public.index')
            ->with(compact('models'));
    }

    /**
     * Search models.
     *
     * @return Response
     */
    public function search()
    {

        $models = $this->repository->all();

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

        return view('places::public.show')
            ->with(compact('model'));
    }
}
