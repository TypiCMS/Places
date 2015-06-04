<?php
namespace TypiCMS\Modules\Places\Http\Controllers;

use TypiCMS;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Places\Repositories\PlaceInterface;

class PublicController extends BasePublicController
{

    public function __construct(PlaceInterface $place)
    {
        parent::__construct($place);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function index()
    {
        $models = $this->repository->all();
        return view('places::public.index')
            ->with(compact('models'));
    }

    /**
     * Search models.
     *
     * @return \Illuminate\Support\Facades\Response
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
     * @return \Illuminate\Support\Facades\Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);
        return view('places::public.show')
            ->with(compact('model'));
    }
}
