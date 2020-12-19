<?php

namespace App\Http\Controllers\Room;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRoomRequest;
use App\Http\Requests\CheckoutRequest;
use App\Repository\BookingRepositoryInterface;
use App\Repository\RoomRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use App\Utils\ResponseMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    use RespondsWithHttpStatus;

    private $roomRepository, $bookingRepository;

    /**
     * Undocumented function
     *
     * @param RoomRepositoryInterface $roomRepository
     */
    public function __construct(RoomRepositoryInterface $roomRepository, BookingRepositoryInterface $bookingRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->bookingRepository = $bookingRepository;
        Auth::shouldUse('api');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function roomList()
    {
        return $this->roomRepository->roomList();
    }

    /**
     * Undocumented function
     *
     * @param BookRoomRequest $request
     * @return void
     */
    public function bookRoom(BookRoomRequest $request)
    {
        DB::beginTransaction();
        try {
            $res = $this->bookingRepository->bookRoom($request);
            DB::commit();
            return $res;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Booking error", [
                'error' => $e->getMessage()
            ]);
            return $this->apiResponse(ResponseMessage::SERVER_ERROR, null, Response::HTTP_INTERNAL_SERVER_ERROR, false);
        }
    }

    /**
     * Undocumented function
     *
     * @param CheckoutRequest $request
     * @return void
     */
    public function checkout(CheckoutRequest $request)
    {
        DB::beginTransaction();
        try {
            $res = $this->bookingRepository->checkout($request);
            DB::commit();
            return $res;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Checkout error", [
                'error' => $e->getMessage()
            ]);
            return $this->apiResponse(ResponseMessage::SERVER_ERROR, null, Response::HTTP_INTERNAL_SERVER_ERROR, false);
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function bookingList()
    {
        return $this->bookingRepository->bookingList();
    }
}
