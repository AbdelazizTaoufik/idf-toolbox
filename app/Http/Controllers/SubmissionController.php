<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionsRequesst;
use App\Models\Submission;

class SubmissionController extends Controller
{
    public function store(StoreSubmissionsRequesst $request)
    {
        Submission::create([
            'title' => $request->title,
            'text' => $request->text
        ]);

        return view('response');
    }

    public function destroy(Submission $submission)
    {
        $submission->delete();

        return response(null, 204);
    } 

    public function getCreateSubmissionView ()
    {
        return view('create-submission');
    }

    public function getAdminSubmissionView()
    {
        $submissions = Submission::orderBy('created_at', 'desc')->get();

        return view('admin.submission', [
            'submissions' => $submissions
        ]);
    }
}
