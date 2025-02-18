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

        return response($submission, 201);
    }
}
