<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Resource;
use App\Models\ResourceRelated;
use App\Models\LocationResource;
use App\Models\ResourceRequirement;
use Illuminate\Console\Command;

class ResourceDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:details {locationResourceId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows the details of the resources and options to upgrade';

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

        if($resource != null){
            $this->info("Resource Details for ".$resource->name);

            if($locationResource->is_upgrading == 1){
                $this->info("Resource is currently in upgrade ".$locationResource->upgrade_endtime->diffInSeconds(now())." Seond(s) Remaining");
            }else{
                $this->info("Resource is not in an upgrade");
            }

            $this->info("Resource Production on Current ".($locationResource->resource->production_perhour * $locationResource->level));

            $this->info("Resource Production on Upgrade ".($locationResource->resource->production_perhour * ($locationResource->level + 1)));

            $this->info("Resource required to upgrade the current resource");

            $headers = [
                'ID', 'Resource', 'Current Cost', 'Upgrade Cost', 'Currently Upgradable', 'After Upgrade'
            ];

            $body = [];

            foreach ($resource->requirements as $key => $requirement) {
                // code...
                $currentVal = (($locationResource->level * $requirement->pivot->level_multiplier) * $requirement->pivot->value);
                $upradeVal = ((($locationResource->level + 1) * $requirement->pivot->level_multiplier) * $requirement->pivot->value);

                $body[] = [
                    $requirement->id, 
                    $requirement->name, 
                    $currentVal,
                    $upradeVal,
                    $upradeVal < $locationResource->production ? "Yes" : "No",
                    ($locationResource->production - $upradeVal)
                ];
                
            }
            $this->table($headers, $body);
        }else{
            $this->info("Empty slot, you can build something here");
            $headers = [
                'ID', 'Resource', 'Current Cost', 'Upgrade Cost', 'Currently Upgradable', 'After Upgrade'
            ];

            $body = [];
            $this->table($headers, $body);
        }

        $rloop = true;

        while ($rloop) {
            $upgrade = $this->ask("Type upgrade or any other key return");
            
            switch ($upgrade) {
                case 'upgrade':
                        if($resource != null){
                            $this->call("resource:upgrade", ['locationResourceId' => $locationResource->id]);
                            $rloop = false;
                        }else{

                        }
                    break;

                case 'build':
                        $this->call("resource:build", ['locationResourceId' => $locationResource->id]);
                        $rloop = false;
                    break;

                case 'exit':
                        return Command::SUCCESS;
                    break;
                default:
                        $rloop = false;
                        $this->call('resource:details', ['locationResourceId' => $locationResource->id]);
                    break;
            }

            
        }
        return Command::SUCCESS;
    }
}
