<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function representative()
    {
        return $this->belongsTo('App\User', 'representative_id');
    }
}
