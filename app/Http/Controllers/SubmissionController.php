<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionsRequesst;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function store(StoreSubmissionsRequesst $request)
    {
        Submission::create([
            'title' => $request->title,
            'text' => $request->text
        ]);

        return redirect('submission-response');
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

    public function getAdminSubmissionView(Request $request)
    {
        $query = Submission::query();

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                ->orWhere('text', 'like', $searchTerm);
            });
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.submission', compact('submissions'));
    }
}
