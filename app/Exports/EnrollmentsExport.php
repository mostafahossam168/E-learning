<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class EnrollmentsExport implements FromView, WithEvents
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
        return view('exports.enrollments', [
            'items' =>  $this->items,
        ]);
    }
}