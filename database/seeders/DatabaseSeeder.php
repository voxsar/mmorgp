<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Location;
use App\Models\Resource;
use App\Models\ResourceRelated;
use App\Models\LocationResource;
use App\Models\ResourceRequirement;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(4)->create();

        $user = User::find(1);
        $user->email = "voxsar@gmail.com";
        $user->save();

        Resource::create([
            'name' => 'clay',
            'production_perhour' => 24,
            'upgrade_timeseconds' => 30
        ]);

        Resource::create([
            'name' => 'crop',
            'production_perhour' => 18,
            'upgrade_timeseconds' => 40
        ]);

        Resource::create([
            'name' => 'iron',
            'production_perhour' => 42,
            'upgrade_timeseconds' => 50
        ]);

        Resource::create([
            'name' => 'wood',
            'production_perhour' => 11,
            'upgrade_timeseconds' => 15
        ]);

        Resource::create([
            'name' => 'main',
            'production_perhour' => 0,
            'upgrade_timeseconds' => 120
        ]);

        Resource::create([
            'name' => 'army',
            'production_perhour' => 0,
            'upgrade_timeseconds' => 180
        ]);

        ResourceRelated::create([
            'eligible_level' => 3,
            'resource_id' => 6,
            'resource_related_id' => 5
        ]);

        /**********************************/

        ResourceRequirement::create([
            'value' => '140',
            'level_multiplier' => '1.2',
            'resource_id' => 1,
            'resource_requirement_id' => 1,
        ]);

        ResourceRequirement::create([
            'value' => '160',
            'level_multiplier' => '0.6',
            'resource_id' => 1,
            'resource_requirement_id' => 2,
        ]);

        ResourceRequirement::create([
            'value' => '110',
            'level_multiplier' => '0.91',
            'resource_id' => 1,
            'resource_requirement_id' => 3,
        ]);

        ResourceRequirement::create([
            'value' => '120',
            'level_multiplier' => '0.845',
            'resource_id' => 1,
            'resource_requirement_id' => 4,
        ]);

        /**********************************/

        ResourceRequirement::create([
            'value' => '240',
            'level_multiplier' => '1.2',
            'resource_id' => 5,
            'resource_requirement_id' => 1,
        ]);

        ResourceRequirement::create([
            'value' => '60',
            'level_multiplier' => '0.6',
            'resource_id' => 5,
            'resource_requirement_id' => 2,
        ]);

        ResourceRequirement::create([
            'value' => '310',
            'level_multiplier' => '0.91',
            'resource_id' => 5,
            'resource_requirement_id' => 3,
        ]);

        ResourceRequirement::create([
            'value' => '180',
            'level_multiplier' => '0.845',
            'resource_id' => 5,
            'resource_requirement_id' => 4,
        ]);



        $count = 1;
        $size = 20;
        for ($row = 0; $row < $size; $row++) { 
            // code...
            for ($column = 0; $column < $size; $column++) { 
                // code...

                if($row == 4 && $column == 6){
                    $location = Location::create([
                        'name' => 'Main',
                        'posx' => 4,
                        'posy' => 6,
                        'user_id' => 1,
                    ]);

                    LocationResource::create([
                        'resource_id' => 1,
                        'location_id' => $location->id,
                        'production' => 480,
                        'is_production' => 1
                    ]);

                    LocationResource::create([
                        'resource_id' => 2,
                        'location_id' => $location->id,
                        'production' => 690,
                        'is_production' => 1
                    ]);

                    LocationResource::create([
                        'resource_id' => 3,
                        'location_id' => $location->id,
                        'production' => 810,
                        'is_production' => 1
                    ]);

                    LocationResource::create([
                        'resource_id' => 4,
                        'location_id' => $location->id,
                        'production' => 780,
                        'is_production' => 1
                    ]);

                    for ($resourceCount=0; $resourceCount < 26; $resourceCount++) { 
                        // code...
                        LocationResource::create([
                            'resource_id' => null,
                            'location_id' => $location->id,
                            'production' => 0,
                            'is_production' => 0,
                            'level' => 0
                        ]);
                    }
                }else{
                    $location = Location::create([
                        'posx' => $row,
                        'posy' => $column,
                    ]);

                    for ($resourceCount=0; $resourceCount < 12; $resourceCount++) { 
                        // code...
                        LocationResource::create([
                            'resource_id' => random_int(1, 4),
                            'location_id' => $location->id,
                            'production' => random_int(400, 800),
                            'is_production' => 1,
                        ]);
                    }
                    
                    $lrs = LocationResource::where('is_production', 1)->get();
                    foreach ($lrs as $key => $lr) {
                        // code...
                        $lr->current_production_perhour = $lr->resource->production_perhour;
                        $lr->save();
                    }

                    for ($resourceCount=0; $resourceCount < 18; $resourceCount++) { 
                        // code...
                        LocationResource::create([
                            'resource_id' => null,
                            'location_id' => $location->id,
                            'production' => 0,
                            'is_production' => 0,
                            'level' => 0
                        ]);
                    }
                }
                
                /*LocationResource::create([
                    'resource_id' => 1,
                    'location_id' => $count
                ]);
                $count++;*/
            }
        }


        /*Location::create([
            'posx' => 1,
            'posy' => 1,
            'user_id' => 1,
        ]);

        Location::create([
            'posx' => 1,
            'posy' => 2,
            'user_id' => 1,
        ]);

        Location::create([
            'name' => 'Main Village',
            'posx' => 2,
            'posy' => 1,
            'user_id' => 1,
        ]);

        Location::create([
            'posx' => 2,
            'posy' => 2,
            'user_id' => 1,
        ]);

        LocationResource::create([
            'resource_id' => 1,
            'location_id' => 1
        ]);

        LocationResource::create([
            'resource_id' => 1,
            'location_id' => 2
        ]);

        LocationResource::create([
            'resource_id' => 1,
            'location_id' => 3
        ]);*/

        
    }
}