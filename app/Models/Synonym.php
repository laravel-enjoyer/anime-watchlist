<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Synonym extends Model
{
    use HasFactory;

    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }
}
