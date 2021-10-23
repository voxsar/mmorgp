<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LocationResource extends Pivot
{
    use HasFactory;

    protected $dates = ["upgrade_endtime"];

    /**
     * Which table the model belongs too
     *
     * @var bool
     */
    public $table = 'location_resources';


    /**
     * The location that this resource belongs too
     */
    public function location()
    {
        // code...
        return $this->belongsTo("App\Models\Location");
    }

    /**
     * The resource that this location belongs too
     */
    public function resource()
    {
        // code...
        return $this->belongsTo("App\Models\Resource");
    }
}
