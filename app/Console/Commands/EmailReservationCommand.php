<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Facades\App\Libraries\Notifications;
use Illuminate\Notifications\Notification;
use App\Libraries\NotificationsInterface;
use App\Notifications\Reservation;

class EmailReservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:notify 
    {count : The number booking to retrive}
    {--dry-run= : To have this command do no actual work}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify reservation holders';

    /**
     * Undocumented function
     *
     * @param \Facades\App\Libraries\Notifications $notify
     */   
     protected $notify;
    /**
     * Undocumented function
     *
     * @param \Facades\App\Libraries\Notifications $notify
     */
    public function __construct(\Facades\App\Libraries\Notifications $notify)
    {
        $this->notify = $notify;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return 0;
        $answer = $this->choice(
            'What service should we use?',
            ['sms', 'email'],
            'email'
        );
        var_dump($answer);
        $count = $this->argument('count');
        if (!is_numeric($count)) {
            $this->alert('The count must be a number');
            return 1;
        }
        $bookings = \App\Models\Booking::with(['room.roomType', 'users'])->limit($count)->get();
        $this->info(sprintf('The number of bookings to alert for is: %d', $bookings->count()));
        $bar = $this->output->createProgressBar($bookings->count());
        $bar->start();
        foreach ($bookings as $booking) {
            $this->processBooking($booking);
            $bar->advance();
        }
        $bar->finish();
        $this->comment('Command completed');
    }

    public function processBooking($booking)
    {
        if ($this->option('dry-run')) {
            $this->info('Would process booking');
        } else {
            $booking->notify(new Reservation('Mart Martin'));
            // Notifications::send();
        }
    }
}
