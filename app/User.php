<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'valid_until',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'valid_until',
        'created_at',
        'updated_at',
    ];

    /**
     * Check if the user is still valid.
     *
     * @return bool
     */
    public function getIsValidAttribute()
    {
        if ($this->valid_until === null)
            return true;

        return $this->valid_until->gte(\Carbon\Carbon::now());
    }
}
