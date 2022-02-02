<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Meet;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;

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
     *     operationId="deleteMeet",
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
        return Meet::all();
    }

    private function isBetween()
    {
        $timeToReserve = Carbon::createFromTimestamp(request()->start_time);
        $allDates = Meet::all();
        foreach ($allDates as $item) {
            $start = Carbon::createFromTimestamp($item->start_time);
            $end = Carbon::createFromTimestamp($item->end_time);
            if ($timeToReserve->between($start, $end, true)) {
                dd('Your time is In Between');
            }
        }
        return true;
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
     *         name="room",
     *         in="query",
     *         description="room values",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="room 1",
     *             type="string",
     *             enum = {"room 1", "room 2", "room 3"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="start_time",
     *         in="query",
     *         description="start time ex: 2022-02-01 07:16:45 ",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="2022-02-01 07:16:45",
     *             type="string",
     *             enum = {"2022-02-02 07:00:00", "2022-11-01 12:00:00", "2021-04-01 07:00:45"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="end_time",
     *         in="query",
     *         description="end time ex: 2022-02-01 07:16:45 ",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="2022-02-01 07:16:45",
     *             type="string",
     *             enum = {"2022-02-02 07:00:00", "2022-11-01 12:00:00", "2021-04-01 07:00:45"},
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
        if ($this->isBetween()){
            $meet = Meet::create($request->all());
        }
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
     *             enum = {"2", "3"}
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
     *         name="room",
     *         in="query",
     *         description="room values",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="room 1",
     *             type="string",
     *             enum = {"room 1", "room 2", "room 3"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="start_time",
     *         in="query",
     *         description="start time ex: 2022-02-01 07:16:45 ",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="2022-02-01 07:16:45",
     *             type="string",
     *             enum = {"2022-02-02 07:00:00", "2022-11-01 12:00:00", "2021-04-01 07:00:45"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="end_time",
     *         in="query",
     *         description="end time ex: 2022-02-01 07:16:45 ",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="2022-02-01 07:16:45",
     *             type="string",
     *             enum = {"2022-02-02 07:00:00", "2022-11-01 12:00:00", "2021-04-01 07:00:45"},
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
        if ($this->isBetween()) {
            $meet->update($request->all());
        }
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
     * List all  meets
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
        $meets = Meet::where('user_id', $user_id = 1)->get();
        return response()->json($meets, 200);
    }

    public function todayUserMeets()
    {
        $meets = DB::table('meets')
            ->where('user_id', 1)
            ->whereDate('start_time', now())
            ->get();
        return response()->json($meets, 200);
    }
}
