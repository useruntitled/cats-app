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
}
