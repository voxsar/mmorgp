<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The Resources that belong to this location
     * This is a many to many relation using a middle table called location resource
     */
    public function resources()
    {
        return $this->belongsToMany('App\Models\Resource', 'location_resources', 'location_id', 'resource_id')
                        ->using('App\Models\LocationResource')
                        ->withPivot([
                            'level',
                        ]);
    }

    /**
     * These all the empty resource fields of the many to many resource that odes not have any resources assigned
     */
    public function fields()
    {
        // code...
        return $this->hasMany("App\Models\LocationResource", "location_id");
    }

    /**
     * This is the user this location belongs to
    */
    public function user()
    {
        // code...
        return $this->belongsTo('App\Models\User');
    }
}
