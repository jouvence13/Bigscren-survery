<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
     // Allow mass assignment on these fields
    protected $fillable = ['number', 'body', 'type', 'options'];

    /**
     * A question can have many responses.
     */
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
