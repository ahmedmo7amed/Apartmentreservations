<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Authenticatable
{

    use SoftDeletes ,  HasFactory, Notifiable , HasRoles;

    protected $fillable = ['first_name', 'last_name', 'address', 'phone', 'email', 'country_id' , 'password'];


    protected $hidden = ['password', 'remember_token'];
    protected $guard = 'customers';
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',

        ];
    }

    // Automatically hash password when setting it
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
    /**
     * Set to null if empty
     * @param $input
     */
    public function setCountryIdAttribute($input)
    {
        $this->attributes['country_id'] = $input ? $input : null;
    }

    // public function country()
    // {
    //     return $this->belongsTo(Country::class, 'country_id')->withTrashed();
    // }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
