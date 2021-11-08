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

class Export implements WithColumnFormatting, ShouldAutoSize, FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return QueryBuilder::for(Place::class)
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
            __('Created at'),
            __('Updated at'),
            __('Published'),
            __('Address'),
            __('Email'),
            __('Website'),
            __('Phone'),
            __('Latitude'),
            __('Longitude'),
            __('Title'),
            __('Summary'),
            __('Body'),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
