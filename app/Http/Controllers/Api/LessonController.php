<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Models\Picture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return LessonResource::collection(Lesson::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $valid_lesson_data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string'],
            'pictures' => ['array', 'required'],
            'quiz' => ['sometimes', 'json'],
            'subject_id' => ['required', 'numeric'],
        ]);

        $lesson = new Lesson();
        $lesson->title = $valid_lesson_data['title'];
        $lesson->description = $valid_lesson_data['description'];
        $lesson->subject_id = $valid_lesson_data['subject_id'];
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
    public function show(Lesson $lesson): LessonResource
    {
        return new LessonResource($lesson);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return JsonResponse
     */
    public function update(Request $request, Lesson $lesson): JsonResponse
    {
        $valid_lesson_data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string'],
            'pictures' => ['array', 'required'],
            'quiz' => ['sometimes', 'json'],
            'subject_id' => ['required', 'numeric'],
        ]);

        # Delete all previous lesson pictures
        for ($i = 0; $i < count($lesson->pictures); $i++)
            Storage::disk('public')->delete($lesson->pictures[$i]->url);
        $lesson->pictures()->where('pictureable_type', '=', get_class($lesson))->delete();

        $lesson->title = $valid_lesson_data['title'];
        $lesson->description = $valid_lesson_data['description'];
        $lesson->subject_id = $valid_lesson_data['subject_id'];
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
            'message' => 'Lesson updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Lesson $lesson
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Lesson $lesson): JsonResponse
    {
        for ($i = 0; $i < count($lesson->pictures); $i++)
            Storage::disk('public')->delete($lesson->pictures[$i]->url);
        $lesson->pictures()->where('pictureable_type', '=', get_class($lesson))->delete();
        $lesson->delete();
        return response()->json([
            'message' => 'Lesson deleted successfully',
        ]);
    }


    /**
     * Add quiz to lesson.
     */
    public function add_quiz_to_lesson(Request $request, $id): JsonResponse
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
