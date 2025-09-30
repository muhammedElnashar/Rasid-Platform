@extends('layouts.app')
@section('title')
الصفحة الشخصية
@endsection
@push('css')
    <style>
        .progress-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .progress-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .progress-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: shimmer 4s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { opacity: 0.5; transform: rotate(0deg); }
            50% { opacity: 0.8; transform: rotate(180deg); }
        }

        .progress-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .progress-icon {
            font-size: 2rem;
            margin-left: 1rem;
            position: relative;
            z-index: 2;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .progress-body {
            padding: 2.5rem;
            background: white;
        }

        .info-badges {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            margin-bottom: 2.5rem;
        }

        .info-badge-item {
            display: flex;
            align-items: center;
            padding: 1.2rem 1.8rem;
            background: #fafbfc;
            border-radius: 18px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .info-badge-item::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, currentColor, transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .info-badge-item:hover::before {
            transform: translateX(100%);
        }

        .info-badge-item:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .info-badge-item.category {
            border-color: rgba(99, 102, 241, 0.2);
            color: #4338ca;
        }

        .info-badge-item.layer {
            border-color: rgba(16, 185, 129, 0.2);
            color: #047857;
        }

        .info-badge-item.level {
            border-color: rgba(245, 158, 11, 0.2);
            color: #b45309;
        }

        .badge-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            margin-left: 1.2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .badge-icon.category {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }
        .badge-icon.layer {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }
        .badge-icon.level {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        }

        .badge-content h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
        }

        .badge-label {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 0.3rem;
        }

        .progress-track {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 3rem 0;
            padding: 0 1rem;
            position: relative;
        }

        .level-circle {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.3rem;
            position: relative;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
        }

        .level-circle.completed {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            box-shadow: 0 6px 25px rgba(16, 185, 129, 0.4);
        }

        .level-circle.current {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            color: white;
            box-shadow: 0 8px 30px rgba(245, 158, 11, 0.5);
            animation: currentGlow 2s ease-in-out infinite;
        }

        .level-circle.upcoming {
            background: #f8f9fa;
            color: #9ca3af;
            border: 3px solid #e5e7eb;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        @keyframes currentGlow {
            0%, 100% {
                box-shadow: 0 8px 30px rgba(245, 158, 11, 0.5);
                transform: scale(1);
            }
            50% {
                box-shadow: 0 12px 40px rgba(245, 158, 11, 0.7);
                transform: scale(1.05);
            }
        }

        .level-circle:hover {
            transform: scale(1.1);
        }

        .level-tooltip {
            position: absolute;
            bottom: -45px;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.85rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .level-circle:hover .level-tooltip {
            opacity: 1;
            transform: translateX(-50%) translateY(-8px);
        }

        .connector {
            flex: 1;
            height: 6px;
            border-radius: 3px;
            position: relative;
            margin: 0 -12px;
            z-index: 1;
            transition: all 0.6s ease;
        }

        .connector.completed {
            background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .connector.upcoming {
            background: #e5e7eb;
        }

        .progress-stats {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2.5rem 0;
            padding: 1.8rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 18px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .current-position {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 1rem 1.8rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1.2rem;
            margin-left: 1rem;
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
        }

        .remaining-alert {
            margin-top: 2rem;
            padding: 1.8rem;
            border-radius: 18px;
            border: none;
            position: relative;
            overflow: hidden;
            font-weight: 600;
        }

        .remaining-alert.alert-info {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(59, 130, 246, 0.05));
            border-left: 4px solid #3b82f6;
            color: #1e40af;
        }

        .remaining-alert.alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(16, 185, 129, 0.05));
            border-left: 4px solid #10b981;
            color: #047857;
        }

        .remaining-alert::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, currentColor, transparent);
            animation: progressLine 3s ease-in-out infinite;
        }

        @keyframes progressLine {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        @media (max-width: 768px) {
            .progress-track {
                flex-direction: column;
                gap: 1rem;
            }

            .connector {
                width: 6px;
                height: 25px;
                margin: -8px 0;
            }

            .level-circle {
                width: 55px;
                height: 55px;
                font-size: 1.1rem;
            }

            .info-badges {
                gap: 1rem;
            }

            .progress-body {
                padding: 1.8rem;
            }

            .progress-header {
                padding: 1.5rem;
            }
        }
    </style>

@endpush
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="d-flex flex-column flex-xl-row">
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                        <div class="card mb-5 mb-xl-8">
                            <div class="card-body">
                                <div class="d-flex flex-center flex-column py-5">
                                    <div class="symbol symbol-100px symbol-circle mb-7">
                                        <img src="assets/media/avatars/150-1.jpg" alt="image" />
                                    </div>
                                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{$user->full_name}}</a>
                                    <div class="mb-9">
                                        <div class="badge badge-lg badge-light-primary d-inline">{{$user->role->name}}</div>
                                    </div>
                                       <div class="d-flex flex-wrap flex-center">
                                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                            <div class="fs-4 fw-bolder text-center text-gray-700">
                                                <span class="w-50px">{{$user->fixed_points}}</span>
                                            </div>
                                            <div class="fw-bold text-muted"> نقاط ثابتة</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                            <div class="fs-4 fw-bolder text-center text-gray-700">
                                                <span class="w-50px">{{$user->flexible_points}}</span>

                                            </div>
                                            <div class="fw-bold text-muted">نقاط مرنة</div>
                                        </div>
                                           <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                            <div class="fs-4 fw-bolder text-center text-gray-700">
                                                <span class="w-50px">{{$user->current_negative_points}}</span>

                                            </div>
                                            <div class="fw-bold text-muted"> نقاط سوداء</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
                                        <span class="ms-2 rotate-180">
														<span class="svg-icon svg-icon-3">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
													</span></div>
                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit customer details">
														<a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_details">Edit</a>
													</span>
                                </div>
                                <div class="separator"></div>
                                <div id="kt_user_view_details" class="collapse show">
                                    <div class="pb-5 fs-6">
                                        <div class="fw-bolder mt-5">@lang('message.username')</div>
                                        <div class="text-gray-600">{{$user->username}}</div>
                                        <div class="fw-bolder mt-5">@lang('message.email')</div>
                                        <div class="text-gray-600">
                                            <a href="#" class="text-gray-600 text-hover-primary">{{$user->email}}</a>
                                        </div>
                                        <div class="fw-bolder mt-5">@lang('message.phone')</div>
                                        <div class="text-gray-600">{{$user->phone}}</div>
                                        <div class="fw-bolder mt-5">كود الشحن</div>
                                        <div class="text-gray-600">{{$user->settlement_code}}</div>
                                        @if(\Illuminate\Support\Facades\Auth::user()->isStudent())


                                        @foreach($parents as $parent)
                                            @if($parent->pivot->relationship === 'father')
                                                    <div class="fw-bolder mb-4 mt-5">اسم الاب</div>
                                                    <span class="fs-5  text-gray-600">{{$parent->full_name}}</span>
                                                @else
                                                    <div class="fw-bolder mb-4 mt-5">اسم الام</div>
                                                    <span class="fs-5  text-gray-600">{{$parent->full_name}}</span>
                                            @endif
                                        @endforeach
                                            <div class="fw-bolder mb-4 mt-5">@lang('message.subjects')</div>
                                            @foreach($studentSubjects as $subject)
                                                <span class="fs-5  badge badge-light-info">{{$subject->subject->name}}</span>
                                            @endforeach

                                            <div class="fw-bolder mb-4 mt-5">الفصل</div>
                                            @foreach($studentClass as $class)
                                                <span class="fs-5  badge badge-light-dark">{{$class->class->name}}</span>
                                            @endforeach


                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                            <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview">الترقيات</a>
                                </li>
                            <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_user_insignias">الشارات</a>
                                </li>
                            <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_user_badges">الاوسمة و الميداليات</a>
                                </li>
                            <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_user_view_overview_security">البيانات الاساسية</a>
                                </li>
                            @if(\Illuminate\Support\Facades\Auth::user()->isTeacher())
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_overview_tab">الفصول و المواد </a>
                                </li>
                            @endif

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active " id="kt_user_view_overview" role="tabpanel">
                                <div class="progress-container">
                                    @if($currentLayer && $currentLevel)
                                        <div class="progress-header">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-trophy-fill text-white progress-icon"></i>
                                                <h2 class="progress-title">رحلة التقدم</h2>
                                            </div>
                                        </div>

                                        <div class="progress-body">
                                            <div class="info-badges">
                                                <div class="info-badge-item category">
                                                    <div class="badge-icon category">
                                                        <i class="bi bi-collection text-white"></i>
                                                    </div>
                                                    <div class="badge-content">
                                                        <div class="badge-label">الفئة</div>
                                                        <h5>{{ $currentLayer->category->name }}</h5>
                                                    </div>
                                                </div>

                                                <div class="info-badge-item layer">
                                                    <div class="badge-icon layer">
                                                        <i class="bi bi-layers text-white"></i>
                                                    </div>
                                                    <div class="badge-content">
                                                        <div class="badge-label">الطبقة</div>
                                                        <h5>{{ $currentLayer->name }}</h5>
                                                    </div>
                                                </div>

                                                <div class="info-badge-item level">
                                                    <div class="badge-icon level">
                                                        <i class="bi bi-star-fill text-white"></i>
                                                    </div>
                                                    <div class="badge-content">
                                                        <div class="badge-label">المستوى الحالي</div>
                                                        <h5>{{ $currentLevel->name }}</h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- شريط التقدم -->
                                            <div class="progress-track">
                                                @foreach($levelsInLayer as $level)
                                                    <div class="level-circle {{ $level->id == $currentLevel->id ? 'current' : ($level->points_required <= $currentLevel->points_required ? 'completed' : 'upcoming') }}">
                                                        {{ $loop->iteration }}
                                                        <div class="level-tooltip">
                                                            {{ $level->id == $currentLevel->id ? 'المستوى الحالي' : ($level->points_required <= $currentLevel->points_required ? 'مكتمل' : 'القادم') }} - {{ $level->points_required }} نقطة
                                                        </div>
                                                    </div>
                                                    @if(!$loop->last)
                                                        <div class="connector {{ $level->points_required <= $currentLevel->points_required ? 'completed' : 'upcoming' }}"></div>
                                                    @endif
                                                @endforeach
                                            </div>

                                            <div class="progress-stats">
                                                <span class="current-position">{{ $levelsInLayer->search(fn($lvl) => $lvl->id == $currentLevel->id) + 1 }}</span>
                                                <span class="text-muted fw-semibold">/ {{ $levelsInLayer->count() }} مستوى داخل الطبقة {{ $currentLayer->name }}</span>
                                            </div>

                                            <!-- رسالة المتبقي للوصول للطبقة التالية -->
                                            @if($user->remaining_for_next_layer > 0)
                                                <div class="remaining-alert alert-info">
                                                    🎯 متبقي <strong>{{ $user->remaining_for_next_layer }} نقطة</strong> لإنهاء الطبقة <strong>{{ $currentLayer->name }}</strong>
                                                    والانتقال إلى الطبقة التالية 🚀
                                                </div>
                                            @else
                                                <div class="remaining-alert alert-success">
                                                    🎉 مبروك! أنهيت الطبقة <strong>{{ $currentLayer->name }}</strong>، ستنتقل تلقائيًا إلى الطبقة الأعلى.
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <!-- حالة عدم وجود طبقة/مستوى/فئة -->
                                        <div class="progress-header">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-emoji-smile text-white progress-icon"></i>
                                                <h2 class="progress-title">رحلة التقدم</h2>
                                            </div>
                                        </div>

                                        <div class="progress-body text-center py-10">
                                            <div class="mb-4">
                                                <i class="bi bi-flag-fill fs-1 text-primary opacity-75"></i>
                                            </div>
                                            <h4 class="fw-bold text-gray-700">لم تبدأ رحلتك بعد 🚀</h4>
                                            <p class="text-muted mb-0">
                                                لم يتم تعيين <strong>فئة</strong> أو <strong>طبقة</strong> أو <strong>مستوى</strong> لك حتى الآن.
                                                بمجرد تسجيل التقدم، ستظهر رحلتك هنا خطوة بخطوة.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="kt_user_insignias" role="tabpanel">
                                <div class="row g-4">
                                    @forelse($insignias as $insignia)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100 border-0 rounded-4 shadow-sm hover-card">
                                                <div class="card-body text-center p-4">
                                                    <!-- صورة -->
                                                    <div class="mb-3 position-relative">
                                                        <img src="{{ $insignia->getImageUrlAttribute() }}"
                                                             alt="{{ $insignia->name }}"
                                                             class="img-fluid rounded-circle border border-3 border-primary shadow-sm"
                                                             style="width:90px; height:90px; object-fit:cover;">
                                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary shadow">
                                <i class="fas fa-award"></i>
                            </span>
                                                    </div>

                                                    <!-- الاسم -->
                                                    <h5 class="fw-bold text-dark mb-1">{{ $insignia->name }}</h5>

                                                    <!-- النقاط -->
                                                    <span class="badge bg-gradient fw-semibold fs-6 px-3 py-2 mb-3">
                            +{{ $insignia->points_value }} نقطة
                        </span>

                                                    <!-- التاريخ -->
                                                    <p class="text-muted small mb-0">
                                                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                                        {{ \Carbon\Carbon::parse($insignia->pivot->award_date)->format('Y-m-d') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="text-center py-10">
                                                <i class="fas fa-award fa-4x text-primary opacity-50 mb-4"></i>
                                                <h4 class="fw-bold text-gray-700">لا توجد شارات</h4>
                                                <p class="text-muted">ابدأ بجمع النقاط للحصول على أول شارة 🎯</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="kt_user_badges" role="tabpanel">
                                <div class="row g-4">
                                    @forelse($badges as $badge)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100 border-0 rounded-4 shadow-sm hover-card">
                                                <div class="card-body text-center p-4">
                                                    <!-- صورة -->
                                                    <div class="mb-3 position-relative">
                                                        <img src="{{ $badge->getImageUrlAttribute() }}"
                                                             alt="{{ $badge->name }}"
                                                             class="img-fluid rounded-circle border border-3 border-warning shadow-sm"
                                                             style="width:90px; height:90px; object-fit:cover;">
                                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark shadow">
                                <i class="fas fa-medal"></i>
                            </span>
                                                    </div>

                                                    <!-- الاسم والوصف -->
                                                    <h5 class="fw-bold text-dark mb-1">{{ $badge->name }}</h5>
                                                    <p class="text-muted small mb-2">{{ $badge->description }}</p>

                                                    <!-- النقاط -->
                                                    <span class="badge bg-warning text-dark fw-semibold fs-6 px-3 py-2 mb-3">
                            +{{ $badge->points_awarded }} نقطة
                        </span>

                                                    <!-- التاريخ -->
                                                    <p class="text-muted small mb-0">
                                                        <i class="fas fa-calendar-alt me-1 text-warning"></i>
                                                        {{ \Carbon\Carbon::parse($badge->pivot->award_date)->format('Y-m-d') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="text-center py-10">
                                                <i class="fas fa-medal fa-4x text-warning opacity-50 mb-4"></i>
                                                <h4 class="fw-bold text-gray-700">لا توجد بادجات</h4>
                                                <p class="text-muted">اكسب المزيد من النقاط لتحصل على أول بادج 🏅</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <style>
                                .hover-card {
                                    transition: all 0.3s ease;
                                }
                                .hover-card:hover {
                                    transform: translateY(-6px);
                                    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
                                }
                                .bg-gradient {
                                    background: linear-gradient(45deg, #0062E6, #33AEFF);
                                    color: #fff;
                                }
                            </style>


                            <div class="tab-pane fade show " id="kt_user_view_overview_security" role="tabpanel">
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <div class="card-header border-0">
                                        <div class="card-title">
                                            <h2>@lang('message.profile')</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 pb-5">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                                <tbody class="fs-6 fw-bold text-gray-600">
                                                <tr>
                                                    <td>Password</td>
                                                    <td>******</td>
                                                    <td class="text-end">
                                                        <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                            <span class="svg-icon svg-icon-3">
																					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																						<path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
																						<path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
																					</svg>
																				</span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Table wrapper-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->


                            </div>

                            @if(\Illuminate\Support\Facades\Auth::user()->isTeacher())
                            <div class="tab-pane fade " id="kt_user_view_overview_tab" role="tabpanel">

                                <div class="card card-flush mb-6 mb-xl-9">

                                    <div class="card-body p-9 pt-4">
                                        <div class="tab-content">

                                            <div id="kt_schedule_day_1" class="tab-pane fade show active">
                                                @foreach($subjectClasses as $subjectClass)
                                                    <div class="d-flex flex-stack position-relative mt-6">
                                                        <div class="position-absolute h-100 w-4px bg-info rounded top-0 start-0"></div>

                                                        <div class="fw-bold ms-5">
                                                            <div class="fs-7 mb-1">الماده</div>
                                                            <a href="#" class="fs-5 fw-bolder text-dark text-hover-primary mb-2">{{$subjectClass->subject_name}}</a>
                                                            <hr>
                                                        </div>
                                                        <div class="fw-bold ms-5">
                                                            <div class="fs-7 mb-1">الفصل</div>
                                                            <a href="#" class="fs-5 fw-bolder text-dark text-hover-primary mb-2">{{$subjectClass->class_name}}</a>
                                                            <hr>
                                                        </div>
                                                        <div class="fw-bold ms-5">
                                                            <div class="fs-7 mb-1">الصف</div>
                                                            <a href="#" class="fs-5 fw-bolder text-dark text-hover-primary mb-2">{{$subjectClass->grade_name}}</a>
                                                            <hr>
                                                        </div>
                                                        <div class="fw-bold ms-5">
                                                            <div class="fs-7 mb-1">المرحلة</div>
                                                            <a href="#" class="fs-5 fw-bolder text-dark text-hover-primary mb-2">{{$subjectClass->stage_name}}</a>
                                                            <hr>
                                                        </div>


                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endif



                        </div>
                    </div>
                </div>

                <div class="modal fade" id="kt_modal_update_details" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Form-->
                            <form class="form" action="#" id="kt_modal_update_user_form">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_update_user_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bolder">Update User Details</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
																<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
															</svg>
														</span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body py-10 px-lg-17">
                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header" data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">
                                        <!--begin::User toggle-->
                                        <div class="fw-boldest fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_update_user_user_info" role="button" aria-expanded="false" aria-controls="kt_modal_update_user_user_info">User Information
                                            <span class="ms-2 rotate-180">
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
															<span class="svg-icon svg-icon-3">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
																</svg>
															</span>
                                                <!--end::Svg Icon-->
														</span></div>
                                        <!--end::User toggle-->
                                        <!--begin::User form-->
                                        <div id="kt_modal_update_user_user_info" class="collapse show">
                                            <!--begin::Input group-->
                                            <div class="mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold mb-2">
                                                    <span>Update Avatar</span>
                                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allowed file types: png, jpg, jpeg."></i>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Image input wrapper-->
                                                <div class="mt-1">
                                                    <!--begin::Image input-->
                                                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url(assets/media/avatars/blank.png)">
                                                        <!--begin::Preview existing avatar-->
                                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/150-1.jpg)"></div>
                                                        <!--end::Preview existing avatar-->
                                                        <!--begin::Edit-->
                                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                            <i class="bi bi-pencil-fill fs-7"></i>
                                                            <!--begin::Inputs-->
                                                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                                            <input type="hidden" name="avatar_remove" />
                                                            <!--end::Inputs-->
                                                        </label>
                                                        <!--end::Edit-->
                                                        <!--begin::Cancel-->
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																			<i class="bi bi-x fs-2"></i>
																		</span>
                                                        <!--end::Cancel-->
                                                        <!--begin::Remove-->
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																			<i class="bi bi-x fs-2"></i>
																		</span>
                                                        <!--end::Remove-->
                                                    </div>
                                                    <!--end::Image input-->
                                                </div>
                                                <!--end::Image input wrapper-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold mb-2">Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="Emma Smith" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold mb-2">
                                                    <span>Email</span>
                                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address must be active"></i>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="e.smith@kpmg.com.au" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->

                                        </div>

                                    </div>
                                    <!--end::Scroll-->
                                </div>
                                <!--end::Modal body-->
                                <!--begin::Modal footer-->
                                <div class="modal-footer flex-center">
                                    <!--begin::Button-->
                                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
														<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                                <!--end::Modal footer-->
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">Update Password</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
															<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
														</svg>
													</span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="kt_modal_update_password_form" class="form" action="#">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-10">
                                        <label class="required form-label fs-6 mb-2">Current Password</label>
                                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="current_password" autocomplete="off" />
                                    </div>
                                    <!--end::Input group=-->
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row" data-kt-password-meter="true">
                                        <!--begin::Wrapper-->
                                        <div class="mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bold fs-6 mb-2">New Password</label>
                                            <!--end::Label-->
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="new_password" autocomplete="off" />
                                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
																	<i class="bi bi-eye-slash fs-2"></i>
																	<i class="bi bi-eye fs-2 d-none"></i>
																</span>
                                            </div>
                                            <!--end::Input wrapper-->
                                            <!--begin::Meter-->
                                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                            </div>
                                            <!--end::Meter-->
                                        </div>
                                        <!--end::Wrapper-->
                                        <!--begin::Hint-->
                                        <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Input group=-->
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-10">
                                        <label class="form-label fw-bold fs-6 mb-2">Confirm New Password</label>
                                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm_password" autocomplete="off" />
                                    </div>
                                    <!--end::Input group=-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>

@endsection
