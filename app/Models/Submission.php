<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'text',
        'meeting_group_id'
    ];

    public function meetingGroup(): BelongsTo
    {
        return $this->belongsTo(MeetingGroup::class);
    }
}
