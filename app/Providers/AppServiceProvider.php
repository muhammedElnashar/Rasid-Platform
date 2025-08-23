<?php

namespace App\Providers;

use App\Models\Grade;
use App\Models\School;
use App\Models\Stage;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Policies\GradePolicy;
use App\Policies\StagePolicy;
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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(School::class, StagePolicy::class);
        Gate::policy(Stage::class, StagePolicy::class);
        Gate::policy(Grade::class, GradePolicy::class);
    }
}
