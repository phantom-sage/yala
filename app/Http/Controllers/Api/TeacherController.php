<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return TeacherResource::collection(Teacher::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $valid_teacher_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'string', 'max:255'],
            'educational_card_number' => ['required', 'string', 'max:255'],
            'educational_card_picture' => ['required', 'image', 'file'],
            'class' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'subject_id' => ['numeric', 'required'],
        ]);
        $subject = Subject::find($valid_teacher_data['subject_id']);
        if (! $subject)
            return response()->json(['message' => 'Subject not found']);

        $path = $request->file('educational_card_picture')->store('profiles', 'public');
        $teacher = new Teacher();
        $teacher->name = $valid_teacher_data['name'];
        $teacher->qualification = $valid_teacher_data['qualification'];
        $teacher->educational_card_number = $valid_teacher_data['educational_card_number'];
        $teacher->educational_card_picture = $path;
        $teacher->class = $valid_teacher_data['class'];
        $teacher->address = $valid_teacher_data['address'];
        $teacher->phone_number = $valid_teacher_data['phone_number'];
        $teacher->bank_name = $valid_teacher_data['bank_name'];
        $teacher->account_number = $valid_teacher_data['account_number'];
        $teacher->password = Hash::make($valid_teacher_data['password']);
        $teacher->save();

        $subject->teacher_id = $teacher->id;
        $subject->save();

        return response()->json([
            'message' => 'New teacher created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return TeacherResource
     */
    public function show(Teacher $teacher): TeacherResource
    {
        return new TeacherResource($teacher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return JsonResponse
     */
    public function update(Request $request, Teacher $teacher): JsonResponse
    {
        $valid_teacher_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'string', 'max:255'],
            'educational_card_number' => ['required', 'string', 'max:255'],
            'educational_card_picture' => ['required', 'image', 'file'],
            'class' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'subject_id' => ['numeric', 'required'],
        ]);
        $subject = Subject::find($valid_teacher_data['subject_id']);
        if (! $subject)
            return response()->json(['message' => 'Subject not found']);
        Storage::disk('public')->delete($teacher->educational_card_picture);
        $path = $request->file('educational_card_picture')->store('profiles', 'public');
        $teacher->name = $valid_teacher_data['name'];
        $teacher->qualification = $valid_teacher_data['qualification'];
        $teacher->educational_card_number = $valid_teacher_data['educational_card_number'];
        $teacher->educational_card_picture = $path;
        $teacher->class = $valid_teacher_data['class'];
        $teacher->address = $valid_teacher_data['address'];
        $teacher->phone_number = $valid_teacher_data['phone_number'];
        $teacher->bank_name = $valid_teacher_data['bank_name'];
        $teacher->account_number = $valid_teacher_data['account_number'];
        $teacher->password = Hash::make($valid_teacher_data['password']);
        $teacher->save();

        $subject->teacher_id = $teacher->id;
        $subject->save();

        return response()->json([
            'message' => 'Teacher updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Teacher $teacher
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Teacher $teacher): JsonResponse
    {
        Storage::disk('public')->delete($teacher->educational_card_picture);
        $teacher->delete();
        return response()
            ->json([
                'message' => 'Teacher deleted successfully',
            ]);
    }

}
