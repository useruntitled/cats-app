<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasAuthor;
    use HasFactory;

    protected $table = 'medias';

    protected $primaryKey = 'uuid';

    protected $casts = [
        'uuid' => 'string',
    ];

    protected $fillable = [
        'uuid',
        'format',
        'width',
        'user_id',
        'mediaAble_id',
        'mediaAble_type',
        'height',
        'href',
        'base64_preview',
        'is_video',
    ];
}
