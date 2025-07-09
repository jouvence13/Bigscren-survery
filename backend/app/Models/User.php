<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject; 
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject // 🔁 Implémentation ajoutée
{
    use Notifiable;

    /**
     * Obligatoire pour JWT
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Obligatoire pour JWT
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
