<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        return response()->json(Session::with(['subject', 'teacher', 'room'])->get());
    }

    public function store(Request $request)
    {
        $session = Session::create($request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ]));

        return response()->json($session, 201);
    }

    public function show(Session $session)
    {
        return response()->json($session->load(['subject', 'teacher', 'room']));
    }

    public function update(Request $request, Session $session)
    {
        $session->update($request->validate([
            'subject_id' => 'exists:subjects,id',
            'teacher_id' => 'exists:teachers,id',
            'room_id' => 'exists:rooms,id',
            'date' => 'date',
            'heure_debut' => 'string',
            'heure_fin' => 'string',
        ]));

        return response()->json($session);
    }

    public function destroy(Session $session)
    {
        $session->delete();
        return response()->json(['message' => 'Séance supprimée']);
    }

    public function getTeacher($sessionId)
    {
        $session = Session::with('teacher')->findOrFail($sessionId);
        return response()->json($session->teacher);
    }

}
