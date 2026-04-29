<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionsRequesst;
use App\Models\MeetingGroup;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function store(StoreSubmissionsRequesst $request)
    {
        Submission::create([
            'title' => $request->title,
            'text' => $request->text,
            'meeting_group_id' => $request->meeting_group_id
        ]);

        return redirect('submission-response');
    }

    public function destroy(Submission $submission)
    {
        $submission->delete();

        return response(null, 204);
    } 

    public function getCreateSubmissionView()
    {
        $meetingGroups = MeetingGroup::orderBy('name')->get();
        return view('create-submission', compact('meetingGroups'));
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

        if ($request->has('meeting_group_id') && !empty($request->meeting_group_id)) {
            $query->where('meeting_group_id', $request->meeting_group_id);
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(10);
        $meetingGroups = MeetingGroup::orderBy('name')->get();

        return view('admin.submission', compact('submissions', 'meetingGroups'));
    }
}
