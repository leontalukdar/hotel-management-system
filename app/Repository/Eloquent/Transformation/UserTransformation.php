<?php


namespace App\Repository\Eloquent\Transformation;

class UserTransformation
{
    public function toArray($item)
    {
        return [
            'id' => $item->id,
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'email' => $item->email,
            'phone' => $item->phone,
            'registered_at' => $item->registered_at
        ];
    }
}
