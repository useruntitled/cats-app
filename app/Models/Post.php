<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasAuthor;
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'user_id',
    ];
}
