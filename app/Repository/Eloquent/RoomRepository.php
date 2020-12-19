<?php

namespace App\Repository\Eloquent;

use App\Models\Room;
use App\Repository\Eloquent\Transformation\RoomTransformation;
use App\Repository\RoomRepositoryInterface;
use App\Traits\RespondsWithHttpStatus;
use App\Utils\ResponseMessage;
use Illuminate\Support\Facades\Auth;
use JWTAuthException;
use Symfony\Component\HttpFoundation\Response;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    use RespondsWithHttpStatus;

    private $model, $roomTransformation;

    public function __construct(Room $model, RoomTransformation $roomTransformation)
    {
        $this->model = $model;
        $this->roomTransformation = $roomTransformation;
        Auth::shouldUse('api');
    }

    public function roomList()
    {
        $rooms = $this->model->all();
        $map = $this->roomTransformation->toArray($rooms);
        return $this->apiResponse(ResponseMessage::ROOM_LIST, $map);
    }
}
