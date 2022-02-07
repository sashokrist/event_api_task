<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Meet;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function dd;
use function response;

class MeetController extends Controller
{
    /**
     * List all  meets
     *
     * @OA\Get (
     *     path="/api/meets",
     *     tags={"meets"},
     *     operationId="allMeets",
     *
     *
     *
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *
     *
     * )
     */
    public function index()
    {
        return Meet::with('room')->get();
    }

    /**
     * Add a new meet  to calendar
     *
     * @OA\Post(
     *     path="/api/meet",
     *     tags={"meet"},
     *     operationId="addMeet",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="name values",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="Interview meeting",
     *             type="string",
     *             enum = {"Interview meeting2", "Interview meeting3"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="room_name",
     *         in="query",
     *         description="room_name values",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="room 1",
     *             type="string",
     *             enum = {"room 1", "room 2", "room 3"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="meet_date",
     *         in="query",
     *         description="meet date ex: 2022-02-01",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="2022-02-01",
     *             type="string",
     *             enum = {"2022-01-01", "2021-04-01"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="start",
     *         in="query",
     *         description="start time ex: 07:00:00 ",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="08:00:00",
     *             type="string",
     *             enum = {"10:00:00", "12:00:45"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="end",
     *         in="query",
     *         description="end time ex: 08:00:00 ",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="09:00:00",
     *             type="string",
     *             enum = {"11:00:00", "13:00:45"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'room_name' => 'required|max:255',
            'start' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $timeToRecerve = $request->start;
        $meet_date = $request->meet_date;
        $allRooms = Room::all();

        foreach ($allRooms as $item) {
            $m_date = $item->meet_date;
            $start = $item->start;
            $end = $item->end;
            if ($start <= $timeToRecerve && $timeToRecerve <= $end && $m_date === $meet_date) {
                dd('this time is occupied, please select another time');
            }

            $meet = Meet::create($request->all());
        }

        $room = new Room();
        $room->meet_id = $meet->id;
        $room->room_name = $request->room_name;
        $room->meet_date = $request->meet_date;
        $room->start = $request->start;
        $room->end = $request->end;
        $room->save();
        $meet = Meet::with('room')->where('id', $meet->id)->orderByDesc('created_at')->first();

        return response()->json($meet, 201);
    }

    /**
     * Update a meet
     *
     * @OA\Post(
     *     path="/api/meet/{meet}",
     *     tags={"meet"},
     *     operationId="updateMeet",
     *     @OA\Parameter(
     *         name="meet",
     *         in="path",
     *         description="Numeric ID of the meet to update",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="name values",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="Interview meeting",
     *             type="string",
     *             enum = {"Interview meeting2", "Interview meeting3"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="room_name",
     *         in="query",
     *         description="room_name values",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="room 1",
     *             type="string",
     *             enum = {"room 1", "room 2", "room 3"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="meet_date",
     *         in="query",
     *         description="meet date ex: 2022-02-01",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="2022-02-01",
     *             type="string",
     *             enum = {"2022-01-01", "2021-04-01"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="start",
     *         in="query",
     *         description="start time ex: 07:00:00 ",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="08:00:00",
     *             type="string",
     *             enum = {"10:00:00", "12:00:45"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="end",
     *         in="query",
     *         description="end time ex: 08:00:00 ",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="09:00:00",
     *             type="string",
     *             enum = {"11:00:00", "13:00:45"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *
     *
     * )
     */
    public function update(Request $request, Meet $meet)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'room_name' => 'required|max:255',
            'start' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $timeToRecerve = $request->start;
        $allRooms = Room::all();

        foreach ($allRooms as $item) {
            $start = $item->start;
            $end = $item->end;
            if ($start <= $timeToRecerve && $timeToRecerve <= $end) {
                dd('this time is occupied, please select another time');
            }

        }
        $meet->update($request->all());
       // dd($meet->id);
        $room = Room::where('meet_id', $meet->id)->first();
       // dd($room);
        $room->room_name = $request->room_name;
        $room->meet_date = $request->meet_date;
        $room->start = $request->start;
        $room->end = $request->end;
        $room->save();
        return response()->json($meet, 200);
    }

    /**
     * Delete a meet
     *
     * @OA\Delete (
     *     path="/api/meet/{meet}",
     *     tags={"meet"},
     *     operationId="deleteMeet",
     *     @OA\Parameter(
     *         name="meet",
     *         in="path",
     *         description="Numeric ID of the meet to get",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *         )
     *     ),
     *
     *
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *
     *
     * )
     */
    public function delete(Meet $meet)
    {
        $meet->delete();
        return response()->json(null, 204);
    }

    /**
     * List all  user meets
     *
     * @OA\Get (
     *     path="/api/meets-user",
     *     tags={"meets-user"},
     *     operationId="userMeets",
     *
     *
     *
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *
     *
     * )
     */
    public function userMeets()
    {
       // $meets = Meet::where('user_id', $user_id = 1)->get();
        $meets = User::with('meet')->where('id', 1)->get();
        return response()->json($meets, 200);
    }

    /**
     * List all  user meets for today
     *
     * @OA\Post (
     *     path="/meets-user-today",
     *     tags={"meets-user"},
     *     operationId="userTodayMeets",
     *
     *     @OA\Parameter(
     *         name="meet_date",
     *         in="query",
     *         description="meet date ex: 2022-02-01",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="2022-02-01",
     *             type="string",
     *             enum = {"2022-01-01", "2021-04-01"},
     *         )
     *     ),
     *
     *
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     * )
     */
    public function todayUserMeets(Request $request)
    {
        $checkDate = $request->meet_date;
        $meets = Meet::with('room')->where('user_id', 1)->get();
        foreach($meets as $item){
           $isAvailable = $item->room->meet_date;
            if ($checkDate === $isAvailable){
                return response()->json($meets, 200);
            }
        }
        return dd('no meets found');
    }
}
