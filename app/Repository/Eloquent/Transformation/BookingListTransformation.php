<?php


namespace App\Repository\Eloquent\Transformation;

class BookingListTransformation
{
    public function toArray($collection)
    {
        $map = $collection->map(function ($item) {
            return [
                'id' => $item->id,
                "first_name" => $item->user->first_name,
                "last_name" => $item->user->last_name,
                "room_number" => $item->room_number,
                "arrival" => $item->arrival,
                "checkout" => $item->checkout,
                "is_checkedout" => $item->is_checkedout,
                "total_payable" => $item->total_payable,
                "total_paid" => $item->payment->amount,
                "return_amount" => $item->payment->return_amount,
            ];
        });
        return $map;
    }
}
