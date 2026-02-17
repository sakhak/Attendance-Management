<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EnrollmentController extends Controller
{
    /**
     * Enroll a student in a class.
     * Prevents duplicate enrollment and blocks inactive students.
     */
    public function enroll(Request $request)
    {
        try {
            $validated = $request->validate([
                'class_id' => ['required', 'integer', 'exists:classes,id'],
                'student_id' => ['required', 'integer', 'exists:students,id'],
                'enrolled_on' => ['nullable', 'date'],
            ]);

            $student = Student::findOrFail($validated['student_id']);

            if ($student->status !== \App\Models\StudentStatus::ACTIVE) {
                throw ValidationException::withMessages([
                    'student_id' => ['Cannot enroll an inactive or suspended student.'],
                ]);
            }

            $exists = Enrollment::where('class_id', $validated['class_id'])
                ->where('student_id', $validated['student_id'])
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'student_id' => ['This student is already enrolled in this class.'],
                ]);
            }

            $class = Classes::findOrFail($validated['class_id']);
            $validated['grade_level_id'] = $class->grade_level_id;
            $validated['enrolled_on'] = $validated['enrolled_on'] ?? now()->toDateString();

            $enrollment = Enrollment::create($validated);

            return response()->json([
                'data' => $enrollment->load(['student.user', 'classes']),
                'message' => 'Student enrolled successfully',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Resource not found',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error enrolling student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Unenroll a student from a class.
     */
    public function unenroll(Request $request)
    {
        try {
            $validated = $request->validate([
                'class_id' => ['required', 'integer', 'exists:classes,id'],
                'student_id' => ['required', 'integer', 'exists:students,id'],
            ]);

            $deleted = Enrollment::where('class_id', $validated['class_id'])
                ->where('student_id', $validated['student_id'])
                ->delete();

            if (!$deleted) {
                return response()->json([
                    'message' => 'Enrollment not found or already removed.',
                ], 404);
            }

            return response()->json([
                'message' => 'Student unenrolled successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error unenrolling student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * List students enrolled in a class.
     */
    public function listClassStudents(Classes $class)
    {
        try {
            $students = Enrollment::query()
                ->where('class_id', $class->id)
                ->with(['student.user'])
                ->get()
                ->map(fn (Enrollment $e) => $e->student)
                ->filter()
                ->values();

            return response()->json([
                'list' => [
                    'data' => $students,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching class students',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
