<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'status',
        'email_verified_at',        
        'type',
        'account_id'        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')                
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('first_name', 'like', '%'.$search.'%')            
                ->orWhere('last_name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')  
                ->orWhere('mobile', 'like', '%'.$search.'%')
                ->orWhere('status', 'like', '%'.$search.'%')  
                ->orWhere('type', 'like', '%'.$search.'%')
                ->orWhere('account_id', 'like', '%'.$search.'%');
    }

}
