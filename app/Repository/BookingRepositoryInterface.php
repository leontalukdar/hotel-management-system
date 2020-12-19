<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface BookingRepositoryInterface
{
    public function bookRoom($request);

    public function checkout($request);

    public function bookingList();
}
