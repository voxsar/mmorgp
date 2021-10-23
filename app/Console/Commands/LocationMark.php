<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Command;

class LocationMark extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:mark {posx} {--posy}';

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
        $posx = $this->argument('posx');
        $posy = $this->option('posy');
        $location = Location::find(3);
        if($posx != null && $posy != null){
            $location = Location::where('posx', $posx)->where('posy', $posy)->first();
        }
        if($location == null){
            $this->info("This is not a valid location");
        }
        $location->name = "O";
        $location->save();
        $this->info("Location Marked");
        return Command::SUCCESS;
    }
}
