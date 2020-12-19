<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_id', 'room_number', 'arrival', 'checkout', 'user_id', 'book_type', 'book_time', 'duration', 'total_due', 'total_payable', 'is_checkedout'
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBookedRoomIds($arrival, $checkout)
    {
        return self::where('checkout', '>', $arrival)->pluck('room_id')
            ->where('arrival', '<', $checkout)->toArray();
    }
}
