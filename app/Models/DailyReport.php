<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'officer_id',
        'location_id',
        'report_date',
        'entry_type',
        'total_count',
        'male_count',
        'female_count',
        'asylum_male',
        'asylum_female',
        'deport_male',
        'deport_female',
        'return_male',
        'return_female',
        'nationalities',
        'mode',
        'flight_number',
        'origin',
        'destination',
    ];

    protected $casts = [
        'report_date' => 'date',
        'nationalities' => 'array',
    ];

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
