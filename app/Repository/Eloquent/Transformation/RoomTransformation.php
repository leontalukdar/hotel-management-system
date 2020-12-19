<?php


namespace App\Repository\Eloquent\Transformation;

class RoomTransformation
{
    public function toArray($collection)
    {
        $map = $collection->map(function ($item) {
            return [
                'id' => $item->id,
                "room_number" => $item->room_number,
                "price" => $item->price,
                "locked" => $item->locked,
                "max_persons" => $item->max_persons,
                "room_type" => $item->room_type,
            ];
        });
        return $map;
    }
}
