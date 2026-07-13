<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerNote extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerNoteFactory> */
    use HasFactory;

    public const MAX_CONTENT_LENGTH = 800;

    /**
     * @var list<string>
     */
    protected $fillable = ['player_id', 'author_id', 'content'];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
