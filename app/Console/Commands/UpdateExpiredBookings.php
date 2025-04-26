<?php

namespace App\Console\Commands;

use App\Models\Pemesanan;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Notifications\PemesananStatusChanged;
use Illuminate\Support\Facades\Notification;

class UpdateExpiredBookings extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update pemesanan yang statusnya pending lebih dari 24 jam menjadi expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredBookings = Pemesanan::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->get();

        foreach ($expiredBookings as $booking) {
            $booking->update(['status' => 'expired']);
            $booking->user->notify(new PemesananStatusChanged($booking));
        }

        $this->info('Expired bookings updated.');
    }
}
