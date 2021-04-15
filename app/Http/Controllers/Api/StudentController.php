<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return StudentResource::collection(Student::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $valid_student_data = $request->validate([
            'parent_name' => ['string', 'required', 'min:3', 'max:255'],
            'phone_number' => ['required', 'phone:SD'],
            'address' => ['string', 'required'],
            'bank_name' => ['string', 'required'],
            'account_number' => ['string', 'required'],
            'education_level' => ['string', 'required'],
            'class' => ['string', 'required'],
            'name' => ['string', 'required', 'min:3', 'max:255'],
            'password' => ['string', 'required', 'min:8', 'max:255'],
        ]);
        $student = new Student();
        $student->parent_name = $valid_student_data['parent_name'];
        $student->phone_number = $valid_student_data['phone_number'];
        $student->address = $valid_student_data['address'];
        $student->bank_name = $valid_student_data['bank_name'];
        $student->account_number = $valid_student_data['account_number'];
        $student->education_level = $valid_student_data['education_level'];
        $student->class = $valid_student_data['class'];
        $student->name = $valid_student_data['name'];
        $student->password = Hash::make($valid_student_data['password']);
        $student->save();
        return response()->json([
            'message' => 'New student created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return StudentResource
     */
    public function show(Student $student): StudentResource
    {
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Student $student): JsonResponse
    {
        $valid_student_data = $request->validate([
            'parent_name' => ['string', 'required', 'min:3', 'max:255'],
            'phone_number' => ['required', 'phone:SD'],
            'address' => ['string', 'required'],
            'bank_name' => ['string', 'required'],
            'account_number' => ['string', 'required'],
            'education_level' => ['string', 'required'],
            'class' => ['string', 'required'],
            'name' => ['string', 'required', 'min:3', 'max:255'],
            'password' => ['string', 'required', 'min:8', 'max:255'],
        ]);
        $student->parent_name = $valid_student_data['parent_name'];
        $student->phone_number = $valid_student_data['phone_number'];
        $student->address = $valid_student_data['address'];
        $student->bank_name = $valid_student_data['bank_name'];
        $student->account_number = $valid_student_data['account_number'];
        $student->education_level = $valid_student_data['education_level'];
        $student->class = $valid_student_data['class'];
        $student->name = $valid_student_data['name'];
        $student->password = Hash::make($valid_student_data['password']);
        $student->save();
        return response()->json([
            'message' => 'Student updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Student $student): JsonResponse
    {
        $student->delete();
        return response()
            ->json([
                'message' => 'Student deleted successfully',
            ]);
    }
}
