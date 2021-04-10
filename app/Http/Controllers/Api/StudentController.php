<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid_student_data = $request->validate([
            'parent_name' => ['string', 'required', 'min:3', 'max:255'],
            'phone_number' => ['required', 'numeric'],
            'address' => ['string', 'required'],
            'bank_name' => ['string', 'required'],
            'account_number' => ['string', 'required'],
            'education_level' => ['string', 'required'],
            'class' => ['string', 'required'],
            'name' => ['string', 'required', 'min:3', 'max:255'],
            'password' => ['string', 'required', 'min:8', 'max:255'],
        ]);
        Student::create($valid_student_data);
        return response()->json([
            'message' => 'New student created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
