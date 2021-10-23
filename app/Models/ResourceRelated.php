<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ResourceRelated extends Pivot
{
    use HasFactory;

    /**
     * The Buildings that belong to the Resource.
     */
    public function resources()
    {
        return $this->belongsToMany('App\Models\Resource')
                        ->using('App\Models\ResourceRelated');
    }
}
