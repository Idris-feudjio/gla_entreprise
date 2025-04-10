<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        return response()->json(Subject::with('teacher')->get());
    }

    public function store(Request $request)
    {
        $subject = Subject::create($request->validate([
            'nom' => 'required|string',
            'code' => 'required|string|unique:subjects,code',
            'teacher_id' => 'required|exists:teachers,id',
        ]));

        return response()->json($subject, 201);
    }

    public function show(Subject $subject)
    {
        return response()->json($subject->load('teacher'));
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update($request->validate([
            'nom' => 'string',
            'code' => 'string|unique:subjects,code,' . $subject->id,
            'teacher_id' => 'exists:teachers,id',
        ]));

        return response()->json($subject);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->json(['message' => 'Matière supprimée']);
    }
}
