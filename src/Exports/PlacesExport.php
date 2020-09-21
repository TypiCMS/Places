<?php

namespace TypiCMS\Modules\Places\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Places\Models\Place;

class PlacesExport implements WithColumnFormatting, ShouldAutoSize, FromCollection, WithHeadings, WithMapping
{
    protected $collection;

    public function __construct($request)
    {
        $this->collection = QueryBuilder::for(Place::class)
            ->allowedSorts(['id', 'status_translated', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->get();
    }

    public function map($model): array
    {
        return [
            Date::dateTimeToExcel($model->created_at),
            Date::dateTimeToExcel($model->updated_at),
            $model->status,
            $model->address,
            $model->email,
            $model->website,
            $model->phone,
            $model->fax,
            $model->latitude,
            $model->longitude,
            $model->title,
            $model->summary,
            $model->body,
        ];
    }

    public function headings(): array
    {
        return [
            'created_at',
            'updated_at',
            'published',
            'address',
            'email',
            'website',
            'phone',
            'fax',
            'latitude',
            'longitude',
            'title',
            'summary',
            'body',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }

    public function collection()
    {
        return $this->collection;
    }
}
