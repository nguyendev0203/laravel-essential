<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailReservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:notify {count : The number booking to retrive}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify reservation holders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $count = $this->argument('count');
        if(!is_numeric($count)){
            $this->alert('The count must be a number');
            return 1;
        }
        $bookings = \App\Models\Booking::with(['room.roomType','users'])->get();
        $this->info(sprintf('The number of bookings to alert for is: %d', $bookings->count()));
        $bar = $this->output->createProgressBar($bookings->count());
        $bar->start();
        foreach ($bookings as $booking) {
            $this->error('Nothing happened');
            $bar->advance();
        }
        $bar->finish();
        $this->comment('Command completed');
    }
}
