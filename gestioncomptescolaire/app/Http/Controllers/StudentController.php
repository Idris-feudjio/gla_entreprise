<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return response()->json(Student::all());
    }

    public function store(Request $request)
    {
        $student = Student::create($request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:students,email',
            'matricule' => 'required|string|unique:students,matricule',
        ]));

        return response()->json($student, 201);
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->validate([
            'nom' => 'string',
            'prenom' => 'string',
            'email' => 'email|unique:students,email,' . $student->id,
            'matricule' => 'string|unique:students,matricule,' . $student->id,
        ]));

        return response()->json($student);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Étudiant supprimé']);
    }
}
