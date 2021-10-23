<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Resource;
use App\Models\ResourceRelated;
use App\Models\LocationResource;
use App\Models\ResourceRequirement;
use Illuminate\Console\Command;

class ResourceUpgrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:upgrade {locationResourceId}';

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
        $resource = $locationResource->resource;


        if($locationResource->is_upgrading == 1){
            $this->info("<fg=red>Cannot upgrade, resource is already upgrading</>");
        }else{
            $locationResource->current_production_perhour = $resource->production_perhour;
            $locationResource->upgrade_endtime = now()->addSeconds($resource->upgrade_timeseconds * $locationResource->level);
            $locationResource->is_upgrading = 1;
            $locationResource->save();

            foreach ($resource->requirements as $key => $requirement) {
                $upradeVal = ((($locationResource->level + 1) * $requirement->pivot->level_multiplier) * $requirement->pivot->value);
                
                $locationresources = $locationResource->location->fields->where('is_production', 1);
                foreach($locationresources as $locationresource){
                    if($locationresource->resource_id == $requirement->id){
                        $locationresource->production -= $upradeVal;
                        $locationresource->save();
                    }
                }
            }

            $this->info("Resource Scheduled to upgrade, completion at ".$locationResource->upgrade_endtime->diffForHumans(now()));
        }
        return Command::SUCCESS;
    }
}
