<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'full_name', // add this for modal compatibility
        'password',
        'email',
        'mobile_no',
        'email_code',
        'email_verified_at',
        'role'
    ];

    protected $appends=['full_name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function getFullNameAttribute(){
        if (!empty($this->attributes['full_name'])) {
            return $this->attributes['full_name'];
        }
        return trim(($this->firstname ?? '') . ' ' . ($this->lastname ?? ''));
    }

    public function assignedLocations()
    {
        return $this->belongsToMany(Location::class, 'officer_assignments', 'officer_id', 'location_id');
    }
    
    public function assignment()
    {
        return $this->hasOne(\App\Models\OfficerAssignment::class, 'officer_id');
    }
}
