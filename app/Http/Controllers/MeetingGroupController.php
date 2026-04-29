<?php

namespace App\Http\Controllers;

use App\Models\MeetingGroup;
use Illuminate\Http\Request;

class MeetingGroupController extends Controller
{
    public function index()
    {
        $meetingGroups = MeetingGroup::orderBy('name')->paginate(10);
        $weekdays = MeetingGroup::getWeekdays();
        return view('meeting-groups-index', compact('meetingGroups', 'weekdays'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:meeting_groups,name',
            'description' => 'nullable|string|max:1000',
            'weekday' => 'nullable|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'time' => 'nullable|date_format:H:i',
            'is_public' => 'boolean'
        ]);

        MeetingGroup::create(array_merge($validated, [
            'is_public' => $request->boolean('is_public'),
        ]));

        return redirect()->route('meeting-groups.index')
            ->with('success', 'Sitzungsgruppe erfolgreich erstellt.');
    }

    public function update(Request $request, MeetingGroup $meetingGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:meeting_groups,name,' . $meetingGroup->id,
            'description' => 'nullable|string|max:1000',
            'weekday' => 'nullable|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'time' => 'nullable|date_format:H:i',
            'is_public' => 'boolean'
        ]);

        $meetingGroup->update(array_merge($validated, [
            'is_public' => $request->boolean('is_public'),
        ]));

        return redirect()->route('meeting-groups.index')
            ->with('success', 'Sitzungsgruppe erfolgreich aktualisiert.');
    }

    public function destroy(MeetingGroup $meetingGroup)
    {
        $meetingGroup->delete();

        return redirect()->route('meeting-groups.index')
            ->with('success', 'Sitzungsgruppe erfolgreich gelöscht.');
    }
}
