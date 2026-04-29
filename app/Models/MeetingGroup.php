<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingGroup extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'description',
        'weekday',
        'time',
        'is_public'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'time' => 'datetime:H:i'
    ];

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public static function getWeekdays()
    {
        return [
            'monday' => 'Montag',
            'tuesday' => 'Dienstag',
            'wednesday' => 'Mittwoch',
            'thursday' => 'Donnerstag',
            'friday' => 'Freitag',
            'saturday' => 'Samstag',
            'sunday' => 'Sonntag'
        ];
    }
}
