<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperGenre
 */
class Genre extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function anime(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class);
    }
}
