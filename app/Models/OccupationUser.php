<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OccupationUser extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'occupation_id',
        'salary'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function occupacion(): BelongsTo
    {
        return $this->belongsTo(Occupation::class);
    }
}
