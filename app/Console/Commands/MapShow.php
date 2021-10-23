<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Command;

class MapShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'map:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the current map';

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
        $locations = Location::all()->groupBy('posx');

        $headers = [];
        $rows = [];

        $headers[] = "X";
        foreach ($locations as $key => $maprows2) {
            array_push($headers, $key);
        }

/*  Invalid "grey" color; expected one of (black, red, green, yellow, blue, magenta, cyan, white, defau
  lt, gray, bright-red, bright-green, bright-yellow, bright-blue, bright-magenta, bright-cyan, bright
  -white).
*/
        foreach ($locations as $key1 => $maprows) {
            $rows[$key1]["x"] = "<fg=green>".$key1."</>";
            foreach ($maprows as $key2 => $mapcell) {
                if($mapcell->name == "Unoccupied"){
                    $id = $mapcell->fields->where('is_production', 1)->countBy('resource_id')->toArray();
                    $id = array_keys($id, max($id))[0];
                    switch($id){
                        case 1:
                                $rows[$key1][$key2] = "<fg=bright-yellow>■</>";
                            break;
                        case 2:
                                $rows[$key1][$key2] = "<fg=gray>■</>";
                            break;
                        case 3:
                                $rows[$key1][$key2] = "<fg=green>■</>";
                            break;
                        case 4:
                                $rows[$key1][$key2] = "<fg=red>■</>";
                            break;
                        default:
                                $rows[$key1][$key2] = "<fg=red>".$id."</>";
                            break;
                    }
                    
                }elseif($mapcell->name == "Main"){
                    $rows[$key1][$key2] = "<fg=green>M</>";
                }else{
                    $rows[$key1][$key2] = "<fg=yellow>".$mapcell->name."</>";
                }
                
            }
        }
        $this->table($headers, $rows);
        return Command::SUCCESS;
    }
}
