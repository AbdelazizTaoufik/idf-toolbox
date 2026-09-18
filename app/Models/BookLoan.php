<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookLoan extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'title',
        'note',
        'loan_photo_path',
        'loaned_at',
        'return_photo_path',
        'returned_at',
    ];

    protected $casts = [
        'loaned_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isReturned(): bool
    {
        return $this->returned_at !== null;
    }
}
