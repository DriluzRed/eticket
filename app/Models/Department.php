<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function events()
    {
        return $this->hasManyThrough(Event::class, City::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, City::class);
    }

    
}
