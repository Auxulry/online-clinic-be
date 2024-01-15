<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPoli extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'poli_id',
        'date',
        'number'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);

    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }
}
