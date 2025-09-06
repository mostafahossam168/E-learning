<?php

namespace App\Console\Commands;

use App\Models\Otp;
use Illuminate\Console\Command;

class ClearExpiredOtps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-expired-otps';

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
        Otp::where('expires_at', '<', now())->delete();
        $this->info('تم حذف الأكواد المنتهية');
    }
}