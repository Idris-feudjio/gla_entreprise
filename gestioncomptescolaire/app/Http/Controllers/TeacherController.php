<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return response()->json(Teacher::all());
    }

    public function store(Request $request)
    {
        $teacher = Teacher::create($request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:teachers,email',
            'specialite' => 'nullable|string',
        ]));

        return response()->json($teacher, 201);
    }

    public function show(Teacher $teacher)
    {
        return response()->json($teacher);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $teacher->update($request->validate([
            'nom' => 'string',
            'prenom' => 'string',
            'email' => 'email|unique:teachers,email,' . $teacher->id,
            'specialite' => 'nullable|string',
        ]));

        return response()->json($teacher);
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json(['message' => 'Enseignant supprimé']);
    }
}
