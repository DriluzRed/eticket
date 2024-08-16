<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'event_id', 'user_id', 'qr_code', 'quantity', 'confirmed', 'ticket_type_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function invitations()
    // {
    //     return $this->hasMany(Invitation::class);
    // }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
}
