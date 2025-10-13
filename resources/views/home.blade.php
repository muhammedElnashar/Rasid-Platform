@extends('layouts.app')

@section('title')
    الصفحة الرئيسية
@endsection

@push('css')
    <style>
        .dashboard-container {
            min-height: 80vh;
            padding: 2rem 0;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(45deg);
            transition: all 0.6s ease;
        }

        .stats-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
        }

        .stats-card:hover::before {
            top: -30%;
            right: -30%;
        }

        .card-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -20px;
            left: 30px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stats-card:hover .card-icon {
            transform: rotate(10deg) scale(1.1);
            background: rgba(255, 255, 255, 0.3);
        }

        .card-icon i {
            font-size: 2.5rem;
            color: #fff;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .card-content {
            margin-top: 3rem;
            position: relative;
            z-index: 2;
        }

        .card-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .card-value {
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        /* Gradient variants */
        .gradient-blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        }



        /* Decorative elements */
        .decoration-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            position: absolute;
            opacity: 0.1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .circle-1 { top: 50px; right: 100px; }
        .circle-2 { bottom: 100px; left: 150px; width: 100px; height: 100px; }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-card {
            animation: fadeInUp 0.6s ease backwards;
        }

        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }
        .stats-card:nth-child(4) { animation-delay: 0.4s; }

        /* Responsive */
        @media (max-width: 768px) {
            .card-value {
                font-size: 2.5rem;
            }


            .stats-card {
                margin-bottom: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container position-relative ">
        <!-- Decorative elements -->
        <div class="decoration-circle circle-1"></div>
        <div class="decoration-circle circle-2"></div>

        <div class="container">
            <!-- Page Header -->
            @if(\Illuminate\Support\Facades\Auth::user()->isSuperAdmin())
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">مديرين المدرسة</div>
                                <div class="card-value">{{ number_format($users) }}</div>
                                <div class="card-subtitle">إجمالي المديرين </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(\Illuminate\Support\Facades\Auth::user()->isSchoolAdmin())
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">الطلاب</div>
                                <div class="card-value">{{ number_format($students) }}</div>
                                <div class="card-subtitle">إجمالي عدد الطلاب </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">المعلمين</div>
                                <div class="card-value">{{ number_format($teachers) }}</div>
                                <div class="card-subtitle">إجمالي عدد المعلمين </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">اولياء الامور</div>
                                <div class="card-value">{{ number_format($parents) }}</div>
                                <div class="card-subtitle">إجمالي عدد اولياء الامور </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-user-alt"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">المديرين</div>
                                <div class="card-value">{{ number_format($moderators) }}</div>
                                <div class="card-subtitle">إجمالي عدد المديرين </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-caret-square-up"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">طلبات الاستبدال المعلقة</div>
                                <div class="card-value">{{ number_format($redemptionRequests) }}</div>
                                <div class="card-subtitle">إجمالي عدد الطلبات المعلقة </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-caret-square-down"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">طلبات الاستبدال المعتمدة</div>
                                <div class="card-value">{{ number_format($approvedRedemptionRequests) }}</div>
                                <div class="card-subtitle">إجمالي عدد الطلبات المعتمده </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(\Illuminate\Support\Facades\Auth::user()->isModerator()
            ||\Illuminate\Support\Facades\Auth::user()->isStudent()
            ||\Illuminate\Support\Facades\Auth::user()->isTeacher()||
             \Illuminate\Support\Facades\Auth::user()->isGuardian())
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">الطلاب</div>
                                <div class="card-value">{{ number_format($students) }}</div>
                                <div class="card-subtitle">إجمالي عدد الطلاب </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">المعلمين</div>
                                <div class="card-value">{{ number_format($teachers) }}</div>
                                <div class="card-subtitle">إجمالي عدد المعلمين </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">اولياء الامور</div>
                                <div class="card-value">{{ number_format($parents) }}</div>
                                <div class="card-subtitle">إجمالي عدد اولياء الامور </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-card gradient-blue">
                            <div class="card-icon">
                                <i class="fas fa-user-alt"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-label">المديرين</div>
                                <div class="card-value">{{ number_format($moderators) }}</div>
                                <div class="card-subtitle">إجمالي عدد المديرين </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
