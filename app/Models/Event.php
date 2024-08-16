<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'event_date', 'city_id', 'address', 'capacity',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function images()
    {
        return $this->hasMany(EventImage::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
