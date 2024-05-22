<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    const PUBLISH = 'publish';

    public function publish(User $user, Post $post)
    {
        return $post->isAuthoredBy($user);
    }
}
