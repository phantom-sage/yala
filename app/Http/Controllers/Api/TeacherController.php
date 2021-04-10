<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
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
        $valid_teacher_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'string', 'max:255'],
            'educational_card_number' => ['required', 'string', 'max:255'],
            'educational_card_picture' => ['required', 'image', 'file'],
            'class' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);
        $path = $request->educational_card_picture->store('profiles', 'public');
        Teacher::create([
            'name' => $valid_teacher_data['name'],
            'qualification' => $valid_teacher_data['qualification'],
            'educational_card_number' => $valid_teacher_data['educational_card_number'],
            'educational_card_picture' => $path,
            'class' => $valid_teacher_data['class'],
            'subject' => $valid_teacher_data['subject'],
            'address' => $valid_teacher_data['address'],
            'phone_number' => $valid_teacher_data['phone_number'],
            'bank_name' => $valid_teacher_data['bank_name'],
            'account_number' => $valid_teacher_data['account_number'],
            'password' => Hash::make($valid_teacher_data['password']),
        ]);
        return response()->json([
            'message' => 'New teacher created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
