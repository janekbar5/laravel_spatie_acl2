<?php
namespace App;

//use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable

{
    use Notifiable;
    use HasRoles;

    protected $fillable = ['name', 'email', 'password', 'remember_token'];
    
	
	///////////////////////////////////////////////////////////////////////////////////
	protected $connection = 'mongodb';
	protected $collection = 'users';
	public $timestamps = false;
	///////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
        //return $this->belongsToMany(Role::class, 'name');
    }
    
    
    
}
