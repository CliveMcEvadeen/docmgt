<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficerAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['officer_id', 'location_id'];

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
