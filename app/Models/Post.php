<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Post extends Model
{
    use HasAuthor;
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'user_id',
        'published_at',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(PublishedScope::class);
    }

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaAble');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
