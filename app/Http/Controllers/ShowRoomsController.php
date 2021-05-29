<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowRoomsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param RoomType $roomType
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request,RoomType $roomType = null)
    {
        //
        $rooms= Room::byType($roomType->id)->get();
        return view('rooms.index', ['rooms' => $rooms]);
    }
}
