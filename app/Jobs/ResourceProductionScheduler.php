<?php

namespace App\Jobs;

use App\Models\LocationResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResourceProductionScheduler implements ShouldQueue
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
        $locationResources = LocationResource::where('is_production', 1)->get();
        foreach ($locationResources as $key => $locationResource) {
            // code...
            $locationResource->production += ($locationResource->current_production_perhour * $locationResource->level);
            $locationResource->save();
        }
    }
}
