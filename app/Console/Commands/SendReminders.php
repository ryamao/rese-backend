<?php

namespace App\Console\Commands;

use App\Mail\ReservationReminderEmail;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '当日の予定をリマインドするメールを送信する';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $reservations = Reservation::whereDate('reserved_at', today())->get();

        foreach ($reservations as $reservation) {
            $mailable = new ReservationReminderEmail($reservation);
            Mail::to($reservation->user->email)->send($mailable);
        }
    }
}
