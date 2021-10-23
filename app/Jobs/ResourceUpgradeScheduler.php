<?php

namespace App\Jobs;

use App\Models\LocationResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResourceUpgradeScheduler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $locationResources = LocationResource::where('is_upgrading', 1)->where('upgrade_endtime', '<', now())->get();


        foreach ($locationResources as $key => $locationResource) {
            // code...
            $locationResource->current_production_perhour = $locationResource->resource->production_perhour * ($locationResource->level + 1);
            if($locationResource->resource->production_perhour != 0){
                $locationResource->is_production = 1;
            }
            $locationResource->is_upgrading = 0;
            $locationResource->level += 1;
            $locationResource->upgrade_endtime = null;
            $locationResource->save();
        }
    }
}
