<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    /**
     * The Buildings that belong to the Resource.
     */
    public function locations()
    {
        return $this->belongsToMany('App\Models\Location', 'location_resources', 'resource_id', 'location_id')
                        ->using('App\Models\LocationResource')
                        ->withPivot([
                            'level',
                        ]);
    }
    
    /**
     * The Buildings that belong to the Resource.
     */
    public function related()
    {
        return $this->belongsToMany('App\Models\Resource', 'resource_related', 'resource_id', 'resource_related_id')
                        ->using('App\Models\ResourceRelated')
                        ->withPivot([
                            'eligible_level',
                        ]);
    }
    
    /**
     * The Buildings that belong to the Resource.
     */
    public function requirements()
    {
        return $this->belongsToMany('App\Models\Resource', 'resource_requirements', 'resource_id', 'resource_requirement_id')
                        ->using('App\Models\ResourceRequirement')
                        ->withPivot([
                            'value',
                            'level_multiplier',
                        ]);
    }
}
