<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    private function bootEloquentMorphs(): void
    {
        Relation::morphMap([
            'App\Models\User' => User::class,
            'user' => User::class,
        ]);
    }

    private function bootPolicies(): void
    {
        Gate::policy(Post::class, PostPolicy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootEloquentMorphs();

        $this->bootPolicies();
    }
}
