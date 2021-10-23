<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Location;

class UserLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:locations {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show locations of the userr';

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
        $user = $this->argument('userId');
        $user = User::find($user);
        $locations = $user->locations;

        $headers = [
            'Location Name', 'X', 'Y'
        ];

        $body = null;

        foreach ($locations as $key => $location) {
            // code...
            $body[] = [$location->name, $location->posx, $location->posy];
        }

        $this->table($headers, $body);
        return Command::SUCCESS;
    }
}
