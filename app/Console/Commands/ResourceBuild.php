<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Resource;
use App\Models\ResourceRelated;
use App\Models\LocationResource;
use App\Models\ResourceRequirement;
use Illuminate\Console\Command;

class ResourceBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:build {locationResourceId}';
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
        $locationResourceId = $this->argument('locationResourceId');
        $locationResource = LocationResource::find(3);
        if($locationResourceId != null){
            $locationResource = LocationResource::find($locationResourceId);
        }

        $this->info("You can select a resource to build on this slot");

        $headers = [
            'ID', 'Resource', 'Production/PH', 'Damage', 'Consumption/PH', 'Upgrade Time'
        ];

        $body = [];

        $resources = Resource::all();

        foreach ($resources as $key => $resource) {
            $body[] = [
                $resource->id, 
                $resource->name, 
                $resource->production_perhour,
                $resource->damage_perattack,
                $resource->consumption_perhour,
                $resource->upgrade_timeseconds,
            ];
        }

        $this->table($headers, $body);

        $rloop = true;

        while ($rloop) {
            $resourceId = $this->ask("Type in the ID, to build a resource on this slot");
            
            $resource = Resource::find($resourceId);
            if($resource != null){
                $locationResource->resource_id = $resource->id;
                $locationResource->save();
                $locationResource->current_production_perhour = $locationResource->resource->production_perhour * ($locationResource->level + 1);
                $locationResource->is_upgrading = 1;
                $locationResource->upgrade_endtime = now()->addSeconds($locationResource->resource->upgrade_timeseconds);
                $locationResource->save();
                $rloop = false;
            }

            if($resourceId == "exit"){
                $rloop = false;
            }
        }

        return Command::SUCCESS;
    }
}
