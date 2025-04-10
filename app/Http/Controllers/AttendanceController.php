<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return response()->json(Attendance::with(['student', 'session'])->get());
    }

    public function store(Request $request)
    {
        $attendance = Attendance::create($request->validate([
            'student_id' => 'required|exists:students,id',
            'session_id' => 'required|exists:sessions,id',
            'status' => 'required|in:present,absent',
            'commentaire' => 'nullable|string',
        ]));

        return response()->json($attendance, 201);
    }

    public function show(Attendance $attendance)
    {
        return response()->json($attendance->load(['student', 'session']));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $attendance->update($request->validate([
            'student_id' => 'exists:students,id',
            'session_id' => 'exists:sessions,id',
            'status' => 'in:present,absent',
            'commentaire' => 'nullable|string',
        ]));

        return response()->json($attendance);
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return response()->json(['message' => 'Présence supprimée']);
    }

    public function getBySession($sessionId)
    {
        $attendances = Attendance::with('student')
            ->where('session_id', $sessionId)
            ->get();

        return response()->json($attendances);
    }

    public function getAbsencesBySubject($studentId)
    {
        $absences = Attendance::with(['session.subject'])
            ->where('student_id', $studentId)
            ->where('status', 'absent')
            ->get()
            ->groupBy(function ($attendance) {
                return $attendance->session->subject->nom ?? 'Inconnu';
            });

        return response()->json($absences);
    }


}
