<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class CategoriesExport implements FromView, WithEvents
{
    public $items = [];
    public function __construct($items)
    {
        $this->items = $items;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class  => function (BeforeSheet $event) {
                $event->getDelegate()->setRightToLeft(true);
            }
        ];
    }
    public function view(): View
    {
        return view('exports.categories', [
            'items' => $this->items,
        ]);
    }
}