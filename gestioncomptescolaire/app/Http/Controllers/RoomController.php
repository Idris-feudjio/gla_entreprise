<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json(Room::all());
    }

    public function store(Request $request)
    {
        $room = Room::create($request->validate([
            'nom' => 'required|string',
            'capacite' => 'nullable|integer',
            'bloc' => 'nullable|string',
        ]));

        return response()->json($room, 201);
    }

    public function show(Room $room)
    {
        return response()->json($room);
    }

    public function update(Request $request, Room $room)
    {
        $room->update($request->validate([
            'nom' => 'string',
            'capacite' => 'nullable|integer',
            'bloc' => 'nullable|string',
        ]));

        return response()->json($room);
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(['message' => 'Salle supprimée']);
    }
}
