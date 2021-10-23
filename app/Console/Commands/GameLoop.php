<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Location;
use Illuminate\Console\Command;

class GameLoop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $user = null;
        $location = Location::find(87);

        while(true){

            if($user == null){
                //$user = $this->call("game:login");
                $user = User::find(1);
            }

            $this->info("1] Map");
            $this->info("2] Your Locations");
            $this->info("3] Go To Location via Coordinates");
            $this->info("4] Mark A Location");
            $this->info("5] Logout");
            $this->info("6] Settings");

            $command = $this->ask($user->name.', What would you like to do');

            switch ($command) {
                case '6':
                        $this->info("Name ".$user->name);
                    break;
                case '1':
                    // code...
                        $this->call('map:show');
                    break;
                case '2':
                    // code...
                        $this->call('user:locations', ['userId' => $user->id]);
                    break;
                case '3':
                    // code...
                        $this->info('Select a location via coordinates');
                        $posx = $this->ask('Select x coordinate');
                        $posy = $this->ask('Select y coordinate');
                        $location = $this->call('location:select', [
                            'posx' => $posx,
                            '--posy' => $posy
                        ]);
                        $location = Location::find($location);
                        $locationId = $location->id;
                        $this->call('location:details', ['locationId' => $locationId]);
                    break;
                case 'location:details':
                    // code...
                        $locationId = $location->id;
                        $this->call('location:details', ['locationId' => $locationId]);
                    break;


                //Debug
                case '4':
                    // code...
                        $this->info('Select a location coordinate to mark');
                        $posx = $this->ask('Select x coordinate');
                        $posy = $this->ask('Select y coordinate');
                        $this->call('location:mark', [
                            'posx' => $posx,
                            '--posy' => $posy
                        ]);
                    break;
                case '5':
                        $this->info("<fg=yellow>You have been logged out</>");
                        $user = null;
                    break;

                default:
                    // code...
                    break;
            }
        }
        return Command::SUCCESS;
    }
}
