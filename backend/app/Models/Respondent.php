<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
     protected $fillable = ['email', 'token'];

    /**
     * A respondent has many responses.
     */
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
