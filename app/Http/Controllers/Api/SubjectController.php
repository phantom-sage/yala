<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return SubjectResource::collection(Subject::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $valid_subject_data = $request->validate([
            'name' => ['required', 'string'],
            'teacher_id' => ['sometimes', 'numeric'],
        ]);
        $subject = new Subject();
        $subject->name = $valid_subject_data['name'];
        if (isset($valid_subject_data['teacher_id']))
            $subject->teacher_id = $valid_subject_data['teacher_id'];
        $subject->save();
        return response()->json(['message' => 'New subject created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \App\Http\Resources\SubjectResource
     */
    public function show(Subject $subject): SubjectResource
    {
        return new SubjectResource($subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return JsonResponse
     */
    public function update(Request $request, Subject $subject): JsonResponse
    {
        $valid_subject_data = $request->validate([
            'name' => ['required', 'string'],
            'teacher_id' => ['sometimes', 'numeric'],
        ]);

        $subject->name = $valid_subject_data['name'];
        if (isset($valid_subject_data['teacher_id']))
            $subject->teacher_id = $valid_subject_data['teacher_id'];
        $subject->save();
        return response()->json(['message' => 'Subject updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Subject $subject
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Subject $subject): JsonResponse
    {
        $subject->delete();
        return response()
            ->json([
                'message' => 'Subject deleted successfully',
            ]);
    }
}
