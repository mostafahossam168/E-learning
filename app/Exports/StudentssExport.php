<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentssExport  implements FromView, WithEvents
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
        return view('exports.students', [
            'items' => $this->items,
        ]);
    }
}
