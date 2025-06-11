<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Places\Exports\Export;
use TypiCMS\Modules\Places\Http\Requests\FormRequest;
use TypiCMS\Modules\Places\Models\Place;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('places::admin.index');
    }

    public function export(Request $request): BinaryFileResponse
    {
        $filename = date('Y-m-d') . ' ' . config('app.name') . ' places.xlsx';

        return Excel::download(new Export(), $filename);
    }

    public function create(): View
    {
        $model = new Place();

        return view('places::admin.create')
            ->with(compact('model'));
    }

    public function edit(Place $place): View
    {
        return view('places::admin.edit')
            ->with(['model' => $place]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $place = Place::create($request->validated());

        return $this->redirect($request, $place)
            ->withMessage(__('Item successfully created.'));
    }

    public function update(Place $place, FormRequest $request): RedirectResponse
    {
        $place->update($request->validated());

        return $this->redirect($request, $place)
            ->withMessage(__('Item successfully updated.'));
    }

    public function files(Place $place): JsonResponse
    {
        $data = [
            'models' => $place->files,
        ];

        return response()->json($data, 200);
    }
}
