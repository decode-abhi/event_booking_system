<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Event extends Model
{
    use HasFactory;
    protected  $fillable = [
            'title',
            'description',
            'start_time',
            'end_time',
            'location',
            'total_seats',
            'available_seats', 
    ];

    public function booking(){
        return $this->hasMany(Booking::class);
    }
}
