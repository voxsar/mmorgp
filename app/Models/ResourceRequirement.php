<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ResourceRequirement extends Pivot
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $table = 'resource_requirements';

    /**
     * The Buildings that belong to the Resource.
     */
    public function resources()
    {
        return $this->belongsToMany('App\Models\Resource')
                        ->using('App\Models\ResourceRelated');
    }
}
