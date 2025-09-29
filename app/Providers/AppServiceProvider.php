<?php

namespace App\Providers;

use App\Models\Badge;
use App\Models\BehaviorLog;
use App\Models\Card;
use App\Models\CardCategory;
use App\Models\CardIssues;
use App\Models\CardItem;
use App\Models\Category;
use App\Models\Classes;
use App\Models\DeductionCard;
use App\Models\Grade;
use App\Models\Insignia;
use App\Models\Layer;
use App\Models\Level;
use App\Models\PointTransfer;
use App\Models\RechargeCard;
use App\Models\RechargeCardUser;
use App\Models\RedemptionRequest;
use App\Models\School;
use App\Models\Stage;
use App\Models\StoreItem;
use App\Models\StudentClass;
use App\Models\StudentGuardian;
use App\Models\StudentSubject;
use App\Models\Subject;
use App\Models\TeacherSubjectClass;
use App\Models\User;
use App\Observers\UserObserver;
use App\Policies\BadgePolicy;
use App\Policies\CardCategoryPolicy;
use App\Policies\CardIssuePolicy;
use App\Policies\CardItemPolicy;
use App\Policies\CardPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ClassesPolicy;
use App\Policies\DeductionCardPolicy;
use App\Policies\InsigniaPolicy;
use App\Policies\LayerPolicy;
use App\Policies\LevelPolicy;
use App\Policies\LogPolicy;
use App\Policies\PointTransferPolicy;
use App\Policies\RechargeCardPolicy;
use App\Policies\RedemptionRequestPolicy;
use App\Policies\SchoolPolicy;
use App\Policies\StoreItemPolicy;
use App\Policies\StudentClassPolicy;
use App\Policies\StudentGuardianPolicy;
use App\Policies\StudentSubjectPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TeacherSubjectClassPolicy;
use App\Policies\UserPolicy;
use App\Policies\GradePolicy;
use App\Policies\StagePolicy;
use Illuminate\Pagination\Paginator;
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
        User::observe(UserObserver::class);
        Paginator::useBootstrap();
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(School::class, SchoolPolicy::class);
        Gate::policy(Stage::class, StagePolicy::class);
        Gate::policy(Grade::class, GradePolicy::class);
        Gate::policy(Classes::class, ClassesPolicy::class);
        Gate::policy(Subject::class, SubjectPolicy::class);
        Gate::policy(StudentClass::class, StudentClassPolicy::class);
        Gate::policy(StudentSubject::class, StudentSubjectPolicy::class);
        Gate::policy(StudentGuardian::class, StudentGuardianPolicy::class);
        Gate::policy(TeacherSubjectClass::class, TeacherSubjectClassPolicy::class);
        Gate::policy(Card::class, CardPolicy::class);
        Gate::policy(CardCategory::class, CardCategoryPolicy::class);
        Gate::policy(CardItem::class, CardItemPolicy::class);
        Gate::policy(CardIssues::class, CardIssuePolicy::class);
        Gate::policy(PointTransfer::class, PointTransferPolicy::class);
        Gate::policy(DeductionCard::class, DeductionCardPolicy::class);
        Gate::policy(RechargeCard::class, RechargeCardPolicy::class);
        Gate::policy(RechargeCardUser::class, RechargeCardPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Layer::class, LayerPolicy::class);
        Gate::policy(Level::class, LevelPolicy::class);
        Gate::policy(Insignia::class, InsigniaPolicy::class);
        Gate::policy(Badge::class, BadgePolicy::class);
        Gate::policy(BehaviorLog::class, LogPolicy::class);
        Gate::policy(StoreItem::class, StoreItemPolicy::class);
        Gate::policy(RedemptionRequest::class, RedemptionRequestPolicy::class);


    }
}
