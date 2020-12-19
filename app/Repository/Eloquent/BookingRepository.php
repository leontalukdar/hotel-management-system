<?php

namespace App\Repository\Eloquent;

use App\Http\Requests\BookRoomRequest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use App\Repository\BookingRepositoryInterface;
use App\Repository\Eloquent\Transformation\BookingListTransformation;
use App\Repository\Eloquent\Transformation\UserTransformation;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Collection;
use App\Traits\RespondsWithHttpStatus;
use App\Utils\ResponseMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use JWTAuthException;

class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{
    use RespondsWithHttpStatus;

    private $model, $room, $payment, $userTransformation, $bookingListTransfromation;

    public function __construct(Booking $model, Room $room, Payment $payment, UserTransformation $userTransformation, BookingListTransformation $bookingListTransformation)
    {
        $this->model = $model;
        $this->room = $room;
        $this->payment = $payment;
        $this->userTransformation = $userTransformation;
        $this->bookingListTransfromation = $bookingListTransformation;
        Auth::shouldUse('api');
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return void
     */
    public function bookRoom($request)
    {
        $bookedRoomIds = $this->model->getBookedRoomIds($request->arrival_time, $request->checkout_time);
        if (in_array($request->room_id, $bookedRoomIds)) {
            return $this->apiResponse(ResponseMessage::NOT_AVAILABLE, null, Response::HTTP_FORBIDDEN, false);
        }
        $room = $this->room->findOrFail($request->room_id);
        $arrivalTime = Carbon::parse($request->arrival_time);
        $checkoutTime = Carbon::parse($request->checkout_time);
        $duration =  $checkoutTime->diffInSeconds($arrivalTime);
        $paymentAmount = $request->payment_amount ? $request->payment_amount : 0;
        $booking = $this->model->create([
            'room_id' => $request->room_id,
            'room_number' => $room->room_number,
            'arrival' => $request->arrival_time,
            'checkout' => $request->checkout_time,
            'user_id' => Auth::user()->id,
            'book_type' => 'Default',
            'book_time' => Carbon::now(),
            'duration' => $duration,
            'total_payable' => $duration * $room->price / 86400,
            'total_due' => ($duration * $room->price / 86400) - $paymentAmount
        ]);

        $payment = $this->payment->create([
            'booking_id' => $booking->id,
            'user_id' => Auth::user()->id,
            'amount' => $paymentAmount,
            'payment_date' => Carbon::now()
        ]);

        return $this->apiResponse(ResponseMessage::BOOK_SUCCESS, $booking);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return void
     */
    public function checkout($request)
    {
        $booking = $this->model->where('is_checkedout', 0)
            ->where('id', $request->booking_id)->first();
        if (!$booking) {
            return $this->apiResponse(ResponseMessage::NOT_FOUND, null, Response::HTTP_NOT_FOUND, false);
        }
        if ($request->final_payment < $booking->total_due) {
            return $this->apiResponse(ResponseMessage::PAYMENT_ERROR, null, Response::HTTP_FORBIDDEN, false);
        }
        $booking->total_due = 0;
        $booking->is_checkedout = 1;
        $booking->save();
        $payment = $booking->payment;
        $payment->amount += $request->final_payment;
        $payment->return_amount = ($payment->amount - $booking->total_payable);
        $payment->payment_date = Carbon::now();
        $payment->save();

        return $this->apiResponse(ResponseMessage::CHECKOUT_SUCCESS, $payment);
    }

    public function bookingList()
    {
        $bookingList = $this->model->all();
        $map = $this->bookingListTransfromation->toArray($bookingList);
        return $this->apiResponse(ResponseMessage::BOOKING_LIST, $map);
    }
}
