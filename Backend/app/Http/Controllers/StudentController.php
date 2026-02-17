<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Student::query()->with('user');

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            $students = $query->get();

            return response()->json([
                'list' => [
                    'data' => $students,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching students',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => ['required', 'integer', 'exists:users,id'],
                'student_code' => ['required', 'string', 'max:255', 'unique:students,student_code'],
                'status' => ['nullable', 'string', Rule::in(['active', 'inactive'])],
            ]);

            // Ensure one user has at most one student record
            if (Student::where('user_id', $validated['user_id'])->exists()) {
                throw ValidationException::withMessages([
                    'user_id' => ['This user is already linked to a student.'],
                ]);
            }

            $validated['status'] = $validated['status'] ?? 'active';
            $student = Student::create($validated);

            return response()->json([
                'data' => $student->load('user'),
                'message' => 'Student created successfully',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        try {
            $student->load('user');
            return response()->json([
                'data' => $student,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        try {
            $validated = $request->validate([
                'user_id' => ['sometimes', 'integer', 'exists:users,id'],
                'student_code' => [
                    'sometimes',
                    'string',
                    'max:255',
                    Rule::unique('students', 'student_code')->ignore($student->id),
                ],
                'status' => ['sometimes', 'string', Rule::in(['active', 'inactive'])],
            ]);

            if (isset($validated['user_id']) && $validated['user_id'] !== (int) $student->user_id) {
                if (Student::where('user_id', $validated['user_id'])->exists()) {
                    throw ValidationException::withMessages([
                        'user_id' => ['This user is already linked to a student.'],
                    ]);
                }
            }

            $student->update($validated);

            return response()->json([
                'data' => $student->fresh('user'),
                'message' => 'Student updated successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return response()->json([
                'message' => 'Student deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting student',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
