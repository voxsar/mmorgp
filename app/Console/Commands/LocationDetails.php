<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Resource;
use App\Models\LocationResource;
use Illuminate\Console\Command;

class LocationDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:details {locationId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select the current resource';

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
        $locationId = $this->argument('locationId');
        $location = Location::find(3);
        if($locationId != null){
            $location = Location::find($locationId);
        }


        $headers = [
            'ID', 'Resource', 'Level', 'Production'
        ];

        $body = [];

        $this->info("Location Details for ".$location->name." (".$location->posx.",".$location->posy.")");
        foreach ($location->fields as $key => $field) {
            // code...
            if($field->resource != null){
                $body[] = [
                    $field->id, 
                    $field->resource->name, 
                    $field->level,
                    $field->production,
                ];
            }else{
                $body[] = [
                    $field->id, 
                    '*',
                    '*',
                    '*'
                ];
            }
        }
        $this->table($headers, $body);


        $rloop = true;
        while ($rloop) {
            $locationResourceId = $this->ask("Type the resource id to see select resource details");
            $resourceLocation = LocationResource::find($locationResourceId);
            $rloop = false;
            if($resourceLocation == null){
                $rloop = true;
            }
            $this->call('resource:details', ['locationResourceId' => $resourceLocation->id]);
        }

        return Command::SUCCESS;
    }
}
