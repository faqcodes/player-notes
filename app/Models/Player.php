<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = ['name'];

    public function notes(): HasMany
    {
        return $this->hasMany(PlayerNote::class);
    }
}
