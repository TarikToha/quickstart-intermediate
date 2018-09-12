<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all of the paper for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Paper::class);
    }

    public function isAdmin()
    {
        return $this->user_type == 'admin';
    }

    public function hasMoodle()
    {
        if (!is_null($this->session) && date_diff(date_create($this->session), date_create())->days == 0) {
            return true;
        }

        if (!is_null($this->moodle)) {
            DB::table('users')
                ->where('id', Auth::id())
                ->update([
                    'moodle' => null
                ]);
        }

        return false;
    }
}
