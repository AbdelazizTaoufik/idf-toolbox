<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionsRequesst;
use App\Models\Submission;

class SubmissionController extends Controller
{
    public function store(StoreSubmissionsRequesst $request)
    {
        $submission = Submission::create([
            'title' => $request->title,
            'text' => $request->text
        ]);

        return response()->json($submission, 201);
    }

    public function destroy(Submission $submission)
    {
        $submission->delete();

        return response(null, 204);
    } 
}
