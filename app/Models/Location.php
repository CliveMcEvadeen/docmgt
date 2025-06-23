<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address'];

    public function officers()
    {
        return $this->belongsToMany(User::class, 'officer_assignments', 'location_id', 'officer_id');
    }
}
