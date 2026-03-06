<?php
namespace App\Actions\Teacher;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class UpdateTeacher
{
    public function execute(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:active,inactive',
            'teacher_code' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $teacher = Teacher::findOrFail($id);

        if ($request->filled('status')) {
            $teacher->status = $request->status;
        }

        if ($request->filled('teacher_code')) {
            $teacher->teacher_code = $request->teacher_code;
        }

        $teacher->save();

        return $teacher;
    }
}