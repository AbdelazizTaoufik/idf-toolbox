<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * A program part of the admin area (Benutzerverwaltung, Kummerkastenbeiträge,
 * Sitzungsgruppen) that admins can individually be granted access to.
 */
class AdminModule extends Model
{
    public const USERS = 'users';
    public const SUBMISSIONS = 'submissions';
    public const MEETING_GROUPS = 'meeting_groups';
    public const BOOK_LOANS = 'book_loans';

    /**
     * Keys of all modules that can be assigned, mapped to their display label.
     *
     * @var array<string, string>
     */
    public const LABELS = [
        self::USERS => 'Benutzerverwaltung',
        self::SUBMISSIONS => 'Kummerkastenbeiträge',
        self::MEETING_GROUPS => 'Sitzungsgruppen',
        self::BOOK_LOANS => 'Bücherverleih',
    ];

    protected $fillable = [
        'key',
        'label',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'admin_module_users')->withTimestamps();
    }
}
