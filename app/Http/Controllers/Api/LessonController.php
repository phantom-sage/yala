<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Models\Picture;
use http\Env\Response;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return LessonResource::collection(Lesson::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $valid_lesson_data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string'],
            'pictures' => ['array', 'required'],
            'quiz' => ['sometimes', 'json'],
        ]);

        $lesson = new Lesson();
        $lesson->title = $valid_lesson_data['title'];
        $lesson->description = $valid_lesson_data['description'];
        if ($request->input('quiz'))
            $lesson->quiz = $valid_lesson_data['quiz'];
        $lesson->save();
        foreach ($request->pictures as $picture)
        {
            $path = $picture->store('pictures', 'public');
            $new_picture = new Picture([
                'url' => $path,
                'pictureable_id' => $lesson->id,
                'pictureable_type' => get_class($lesson),
            ]);
            $lesson->pictures()->save($new_picture);
        }

        return response()->json([
            'message' => 'New lesson created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return LessonResource
     */
    public function show(Lesson $lesson)
    {
        return new LessonResource($lesson);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return response()->json([
            'message' => 'Lesson deleted successfully',
        ]);
    }


    /**
     * Add quiz to lesson.
     */
    public function add_quiz_to_lesson(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $lesson = Lesson::find($id);
        if (! $lesson)
            return response()->json(['message' => 'Lesson not found']);
        $valid_lesson_quiz_data = $request->validate([
            'quiz' => ['required', 'json'],
        ]);

        $lesson->quiz = $valid_lesson_quiz_data['quiz'];
        $lesson->save();
        return response()->json(['message' => 'Quiz added successfully']);
    }
}
