<?php

namespace App\Console\Commands;

use App\Models\Coupone;
use Illuminate\Console\Command;

class ClearExpiredCoupones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-expired-coupones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Coupone::where('end_date', '<', now())->delete();
        $this->info('تم حذف الأكواد المنتهية');
    }
}