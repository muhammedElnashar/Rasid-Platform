<?php

namespace App\Providers;

use App\Models\Classes;
use App\Models\Grade;
use App\Models\School;
use App\Models\Stage;
use App\Models\StudentClass;
use App\Models\StudentGuardian;
use App\Models\Subject;
use App\Models\TeacherSubjectClass;
use App\Models\User;
use App\Policies\ClassesPolicy;
use App\Policies\SchoolPolicy;
use App\Policies\StudentClassPolicy;
use App\Policies\StudentGuardianPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TeacherSubjectClassPolicy;
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
        Gate::policy(School::class, SchoolPolicy::class);
        Gate::policy(Stage::class, StagePolicy::class);
        Gate::policy(Grade::class, GradePolicy::class);
        Gate::policy(Classes::class, ClassesPolicy::class);
        Gate::policy(Subject::class, SubjectPolicy::class);
        Gate::policy(StudentClass::class, StudentClassPolicy::class);
        Gate::policy(StudentGuardian::class, StudentGuardianPolicy::class);
        Gate::policy(TeacherSubjectClass::class, TeacherSubjectClassPolicy::class);
    }
}
