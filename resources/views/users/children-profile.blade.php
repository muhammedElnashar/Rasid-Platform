@extends('layouts.app')
@section('title')
    الصفحة  الشخصية
@endsection
@push('css')
    <style>
        .progress-slider-container {
            position: relative;
            margin-bottom: 2rem;
        }

        .slider-navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .nav-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .nav-btn:hover:not(:disabled) {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .nav-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .slider-dots {
            display: flex;
            gap: 0.5rem;
            max-width: 300px;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .slider-dots::-webkit-scrollbar {
            display: none;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #d1d5db;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .dot.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 30px;
            border-radius: 5px;
        }

        .slides-wrapper {
            position: relative;
            overflow: hidden;
        }

        .slide {
            display: none;
            animation: slideIn 0.5s ease;
        }

        .slide.active {
            display: block;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .progress-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
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
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            animation: shimmer 4s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% {
                opacity: 0.5;
                transform: rotate(0deg);
            }
            50% {
                opacity: 0.8;
                transform: rotate(180deg);
            }
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .progress-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .category-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            margin: 0.3rem 0 0 0;
            font-weight: 500;
        }

        .progress-icon {
            font-size: 2rem;
            margin-left: 1rem;
            animation: pulse 2s ease-in-out infinite;
        }

        .position-badge {
            background: rgba(255, 255, 255, 0.25);
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .progress-body {
            padding: 2.5rem;
            background: white;
        }

        .info-badges {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            margin-bottom: 2rem;
        }

        .info-badge-item {
            display: flex;
            align-items: center;
            padding: 1.2rem 1.8rem;
            background: #fafbfc;
            border-radius: 18px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
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

        .current-layer-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            padding: 1rem;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 2rem;
            box-shadow: 0 6px 25px rgba(16, 185, 129, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        .progress-track {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2.5rem 0;
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
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
            bottom: -60px;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 0.7rem 1.2rem;
            border-radius: 10px;
            font-size: 0.85rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            line-height: 1.5;
        }

        .badge-current {
            background: rgba(245, 158, 11, 0.9);
            padding: 0.2rem 0.6rem;
            border-radius: 8px;
            font-size: 0.75rem;
            margin-top: 0.2rem;
            display: inline-block;
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
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
            0%, 100% {
                transform: translateX(-100%);
            }
            50% {
                transform: translateX(100%);
            }
        }

        .layer-info-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(99, 102, 241, 0.03));
            border-radius: 16px;
            border: 1px solid rgba(99, 102, 241, 0.2);
            color: #4338ca;
            font-size: 1rem;
            margin-top: 2rem;
        }

        .layer-info-box i {
            font-size: 1.3rem;
        }

        @media (max-width: 768px) {
            .progress-track {
                overflow-x: auto;
                justify-content: flex-start;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .progress-track::-webkit-scrollbar {
                display: none;
            }

            .level-circle {
                width: 50px;
                height: 50px;
                font-size: 1rem;
                flex-shrink: 0;
            }

            .connector {
                width: 30px;
                height: 4px;
                margin: 0;
                flex-shrink: 0;
                flex: none;
            }

            .progress-body {
                padding: 1.5rem;
            }

            .progress-header {
                padding: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .position-badge {
                align-self: flex-end;
            }

            .nav-btn {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .progress-title {
                font-size: 1.4rem;
            }

            .category-subtitle {
                font-size: 0.9rem;
            }

            .info-badge-item {
                padding: 1rem 1.2rem;
            }

            .badge-icon {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }

            .badge-content h5 {
                font-size: 1rem;
            }
        }
    </style>
    <style>
        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .bg-gradient {
            background: linear-gradient(45deg, #0062E6, #33AEFF);
            color: #fff;
        }
    </style>

@endpush
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="d-flex flex-column flex-xl-row">
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                        <div class="card mt-5 mb-5 mb-xl-8">
                            <div class="card-body">
                                <div class="d-flex flex-center flex-column py-5">
                                    <div class="symbol symbol-100px symbol-circle mb-7">
                                        @if($user->image)
                                            <img
                                                src="{{\Illuminate\Support\Facades\Storage::disk('images')->url($user->image)}}"
                                                alt="image"/>
                                        @else
                                            <img src="{{asset('assets/media/avatars/150-1.jpg')}}" alt="image"/>
                                        @endif
                                    </div>
                                    <a href="#"
                                       class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{$user->full_name}}</a>
                                    <div class="mb-9">
                                        <div
                                            class="badge badge-lg badge-light-primary d-inline">{{__('message.'.$user->role->name)}}</div>
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
                                    <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse"
                                         href="#kt_user_view_details" role="button" aria-expanded="false"
                                         aria-controls="kt_user_view_details">تفاصيل
                                        <span class="ms-2 rotate-180">
														<span class="svg-icon svg-icon-3">
															<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none">
																<path
                                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                    fill="black"/>
															</svg>
														</span>
													</span>
                                    </div>
                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover"
                                          title="Edit customer details">

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

                                            <div class="fw-bolder mb-4 mt-5">@lang('message.subjects')</div>
                                            @foreach($studentSubjects as $subject)
                                                <span
                                                    class="fs-5  badge badge-light-info">{{$subject->subject->name}}</span>
                                            @endforeach

                                            <div class="fw-bolder mb-4 mt-5">الفصل</div>
                                            @foreach($studentClass as $class)
                                                <span
                                                    class="fs-5  badge badge-light-dark">{{$class->class->name}}</span>
                                            @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                   href="#kt_user_view_overview">الترقيات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                                   href="#kt_user_insignias">الشارات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                                   href="#kt_user_badges">الاوسمة و الميداليات</a>
                            </li>


                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="kt_user_view_overview" role="tabpanel">
                                <div class="progress-slider-container">
                                    <!-- Slider Navigation -->
                                    <div class="slider-navigation">
                                        <button class="nav-btn prev-btn" id="prevBtn">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                        <div class="slider-dots" id="sliderDots"></div>
                                        <button class="nav-btn next-btn" id="nextBtn">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                    </div>

                                    <!-- Slides Container -->
                                    <div class="slides-wrapper" id="slidesWrapper">
                                        @php
                                            $allLayers = [];
                                            foreach($categories as $category) {
                                                foreach($category->layers as $layer) {
                                                    $allLayers[] = [
                                                        'category' => $category,
                                                        'layer' => $layer
                                                    ];
                                                }
                                            }
                                        @endphp

                                        @foreach($allLayers as $index => $item)
                                            @php
                                                $category = $item['category'];
                                                $layer = $item['layer'];
                                                $isCurrentLayer = $layer->id == $currentLayer?->id;
                                            @endphp

                                            <div class="slide {{ $isCurrentLayer ? 'active' : '' }}" data-layer="{{ $layer->id }}">
                                                <div class="progress-container">
                                                    <!-- Header -->
                                                    <div class="progress-header">
                                                        <div class="header-content">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi bi-trophy-fill text-white progress-icon"></i>
                                                                <div>
                                                                    <h2 class="progress-title">{{ $layer->name }}</h2>
                                                                    <p class="category-subtitle">{{ $category->name }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="position-badge">
                                                                طبقة {{ $index + 1 }} من {{ count($allLayers) }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Body -->
                                                    <div class="progress-body">
                                                        <!-- Info Badges -->
                                                        <div class="info-badges">
                                                            <div class="info-badge-item category">
                                                                <div class="badge-icon category">
                                                                    <i class="bi bi-collection text-white"></i>
                                                                </div>
                                                                <div class="badge-content">
                                                                    <div class="badge-label">الفئة</div>
                                                                    <h5>{{ $category->name }}</h5>
                                                                </div>
                                                            </div>

                                                            <div class="info-badge-item layer">
                                                                <div class="badge-icon layer">
                                                                    <i class="bi bi-layers text-white"></i>
                                                                </div>
                                                                <div class="badge-content">
                                                                    <div class="badge-label">الطبقة</div>
                                                                    <h5>{{ $layer->name }}</h5>
                                                                </div>
                                                            </div>

                                                            @if($isCurrentLayer && $currentLevel)
                                                                <div class="info-badge-item level">
                                                                    <div class="badge-icon level">
                                                                        <i class="bi bi-star-fill text-white"></i>
                                                                    </div>
                                                                    <div class="badge-content">
                                                                        <div class="badge-label">المستوى الحالي</div>
                                                                        <h5>{{ $currentLevel->name }}</h5>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Current Layer Indicator -->
                                                        @if($isCurrentLayer)
                                                            <div class="current-layer-badge">
                                                                <i class="bi bi-check-circle-fill"></i>
                                                                <span>الطبقة الحالية</span>
                                                            </div>
                                                        @endif

                                                        <!-- Levels Progress Track -->
                                                        <div class="progress-track">
                                                            @foreach($layer->levels as $level)
                                                                @php
                                                                    $isCompleted = false;
                                                                    $isCurrent = false;

                                                                    if ($currentLayer && $currentLevel) {
                                                                        // إذا كانت الطبقة الحالية نفسها
                                                                        if ($layer->id == $currentLayer->id) {
                                                                            $isCurrent = $level->id == $currentLevel->id;
                                                                            $isCompleted = $level->points_required <= $currentLevel->points_required;
                                                                        }
                                                                        // إذا كانت الطبقة قبل الطبقة الحالية
                                                                        elseif ($layer->id < $currentLayer->id) {
                                                                            $isCompleted = true;
                                                                        }
                                                                        // إذا كانت الطبقة بعد الحالية تبقى غير مكتملة (false)
                                                                    }
                                                                @endphp


                                                                <div class="level-circle {{ $isCurrent ? 'current' : ($isCompleted ? 'completed' : 'upcoming') }}">
                                                                    {{ $loop->iteration }}
                                                                    <div class="level-tooltip">
                                                                        <strong>{{ $level->name }}</strong><br>
                                                                        {{ $level->points_required }} نقطة
                                                                        @if($isCurrent)
                                                                            <br><span class="badge-current">الحالي</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                @if(!$loop->last)
                                                                    <div class="connector {{ $isCompleted ? 'completed' : 'upcoming' }}"></div>
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <!-- Progress Stats -->
                                                        @if($isCurrentLayer && $currentLevel)
                                                            <div class="progress-stats">
                                    <span class="current-position">
                                        {{ $layer->levels->search(fn($lvl) => $lvl->id == $currentLevel->id) + 1 }}
                                    </span>
                                                                <span class="text-muted fw-semibold">
                                        / {{ $layer->levels->count() }} مستوى في {{ $layer->name }}
                                    </span>
                                                            </div>

                                                            <!-- Remaining Points Alert -->
                                                            @if($user->remaining_for_next_layer > 0)
                                                                <div class="remaining-alert alert-info">
                                                                    🎯 متبقي <strong>{{ $user->remaining_for_next_layer }} نقطة</strong>
                                                                    لإنهاء الطبقة <strong>{{ $layer->name }}</strong>
                                                                    والانتقال إلى الطبقة التالية 🚀
                                                                </div>
                                                            @else
                                                                <div class="remaining-alert alert-success">
                                                                    🎉 مبروك! أنهيت الطبقة <strong>{{ $layer->name }}</strong>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <!-- Show total levels in non-current layers -->
                                                            <div class="layer-info-box">
                                                                <i class="bi bi-info-circle"></i>
                                                                <span>هذه الطبقة تحتوي على <strong>{{ $layer->levels->count() }} مستوى</strong></span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if(empty($allLayers))
                                            <div class="slide active">
                                                <div class="progress-container">
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
                                                            لم يتم تعيين أي طبقات حتى الآن.
                                                            بمجرد تسجيل التقدم، ستظهر رحلتك هنا خطوة بخطوة.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="kt_user_insignias" role="tabpanel">
                                <div class="row g-4">
                                    @forelse($insignias as $insignia)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100 border-0 rounded-4 shadow-sm hover-card">
                                                <div class="card-body text-center p-4 border border-3 border-primary ">
                                                    <!-- صورة -->
                                                    <div class="mb-3 position-relative">
                                                        <img src="{{ $insignia->getImageUrlAttribute() }}"
                                                             alt="{{ $insignia->name }}"
                                                             class="img-fluid rounded-circle border border-3 border-primary shadow-sm"
                                                             style="width:90px; height:90px; object-fit:cover;">

                                                    </div>

                                                    <!-- الاسم -->
                                                    <h5 class="fw-bold text-dark mb-1">{{ $insignia->name }}</h5>

                                                    <!-- النقاط -->
                                                    <span class="badge bg-primary fw-semibold fs-6 px-3 py-2 mb-3">
                            +{{ $insignia->points_value }} نقطة
                        </span>

                                                    <!-- التاريخ -->
                                                    <p class="text-muted small mb-0">
                                                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                                        {{ toHijriWithTime($insignia->pivot->award_date) }}
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
                                            <div class="card h-100 border-0 rounded-4  shadow-sm hover-card">
                                                <div class="card-body text-center p-4 border border-info border-3  ">
                                                    <!-- صورة -->
                                                    <div class="mb-3 position-relative ">
                                                        <img src="{{ $badge->getImageUrlAttribute() }}"
                                                             alt="{{ $badge->name }}"
                                                             class="img-fluid rounded-circle border border-3 border-info shadow-sm"
                                                             style="width:90px; height:90px; object-fit:cover;">
                                                    </div>

                                                    <!-- الاسم والوصف -->
                                                    <h5 class="fw-bold text-dark mb-1">{{ $badge->name }}</h5>
                                                    <p class="text-muted small mb-2">{{ $badge->description }}</p>

                                                    <!-- النقاط -->
                                                    <span
                                                        class="badge bg-info text-white fw-semibold fs-6 px-3 py-2 mb-3">
                                                        +{{ $badge->points_awarded }} نقطة
                                                    </span>

                                                    <!-- التاريخ -->
                                                    <p class="text-muted small mb-0">
                                                        <i class="fas fa-calendar-alt me-1 text-info"></i>
                                                        {{ toHijriWithTime($badge->pivot->award_date) }}
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






                        </div>
                    </div>
                </div>
                <div class="flex-lg-row-fluid ms-lg-15">
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_issues">الاصدارات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_unsettle">البطاقات
                                الغير مسدده</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_deductionCard">كروت
                                الحسم و الاستبعاد</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_logs">
                                السجلات</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_transfers">سجل
                                التحويلات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_rechargeCard">كروت الشحن</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_awards">الجوائز</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_groups">المجموعات</a>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTab">
                        <div class="tab-pane fade show active " id="kt_issues" role="tabpanel">
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-toolbar">
                                        <div class="kt-table-filter-container">
                                            <a type="button" class="btn btn-light-primary me-3"
                                               data-kt-menu-trigger="click"
                                               data-kt-menu-placement="bottom-end">
                            	<span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
												<path
                                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                    fill="black"/>
											</svg>
										</span>
                                                @lang('message.filter')
                                            </a>

                                            <!-- القائمة -->
                                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                                 data-kt-menu="true">
                                                <div class="px-7 py-5">
                                                    <!-- فلتر Status -->
                                                    <div class="mb-10">
                                                        <label
                                                            class="form-label fs-5 fw-bold mb-3">@lang('message.status')</label>
                                                        <div class="d-flex flex-column flex-wrap fw-bold">
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="" checked/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.all')</span>
                                                            </label>
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="@lang('message.pending')"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.pending')</span>
                                                            </label>
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="@lang('message.approved')"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.approved')</span>
                                                            </label>
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="@lang('message.rejected')"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.rejected')</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <!-- أزرار -->
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-primary"
                                                                data-kt-menu-dismiss="true"
                                                                data-kt-table-filter="filter">تطبيق
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                          height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                          fill="black"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"/>
                                </svg>
                            </span>
                                            <input type="text" data-kt-customer-table-filter="search"
                                                   class="form-control form-control-solid w-250px ps-15"
                                                   placeholder="@lang('message.search')"/>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body pt-0 pb-5">
                                    <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed gy-5" id="kt_issues_table">
                                            <thead>
                                            <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-25px">@lang('message.issue_number')</th>
                                                <th class="min-w-25px">نوع الكرت</th>
                                                <th class="min-w-25px">@lang('message.issued_by')</th>
                                                <th class="min-w-25px">@lang('message.item')</th>
                                                <th class="min-w-25px">@lang('message.points')</th>
                                                <th class="min-w-25px">@lang('message.deduction_type')</th>
                                                <th class="min-w-50px">@lang('message.issue_date')</th>
                                                <th class="min-w-25px">@lang('message.status')</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach($approvedIssues as $issue)

                                                <tr>
                                                    @if($issue->points > 0 )
                                                        <td><span
                                                                class="badge badge-light-success"> {{ $issue->issue_number }}</span>
                                                        </td>
                                                    @else
                                                        <td><span
                                                                class="badge badge-light-danger"> {{ $issue->issue_number }}</span>
                                                        </td>
                                                    @endif
                                                    @if($issue->points > 0 )
                                                        <td><span class="badge badge-light-success">دعم ايجابي</span>
                                                        </td>
                                                    @else
                                                        <td><span class="badge badge-light-danger"> حسم سلبي </span>
                                                        </td>
                                                    @endif
                                                    <td>{{ $issue->issuer->full_name }}</td>
                                                    <td>{{ $issue->cardItem->name }}</td>
                                                    <td>{{ $issue->cardItem->points }}</td>
                                                    <td>
                                                        {{ $issue->deduction_type?->value ? __('message.' . $issue->deduction_type->value) : 'لا يوجد' }}
                                                    </td>
                                                    <td>{{ toHijriWithTime($issue->issue_date)}}</td>
                                                    @if($issue->status === \App\Enum\StatusCardEnum::Approved)
                                                        <td><span
                                                                class="badge badge-light-success">@lang('message.'.$issue->status->value)</span>
                                                        </td>
                                                    @elseif($issue->status === \App\Enum\StatusCardEnum::Rejected)
                                                        <td><span
                                                                class="badge badge-light-danger">@lang('message.'.$issue->status->value)</span>
                                                        </td>
                                                    @else
                                                        <td><span
                                                                class="badge badge-light-warning">@lang('message.'.$issue->status->value)</span>
                                                        </td>
                                                    @endif                            </tr>

                                            @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                            </div>
                            <!--end::Card-->


                        </div>
                        <div class="tab-pane fade show  " id="kt_unsettle" role="tabpanel">
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-toolbar">

                                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                          height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                          fill="black"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"/>
                                </svg>
                            </span>
                                            <input type="text" data-kt-customer-table-filter="search"
                                                   class="form-control form-control-solid w-250px ps-15"
                                                   placeholder="@lang('message.search')"/>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body pt-0 pb-5">
                                    <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed gy-5" id="kt_unsettle_table">
                                            <thead>
                                            <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-50px">@lang('message.issue_number')</th>
                                                <th class="min-w-100px">@lang('message.username')</th>
                                                <th class="min-w-25px">@lang('message.points')</th>
                                                <th class="min-w-100px">@lang('message.remaining_points')</th>
                                                <th class="min-w-100px">@lang('message.issue_date')</th>
                                                <th class="min-w-100px">@lang('message.deduction_deadline')</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach($unsettledIssues as $card)

                                                <tr>
                                                    <td><span
                                                            class="badge badge-light-danger">{{ $card->issue_number }}</span>
                                                    </td>
                                                    <td>{{ $card->issuer->full_name }}</td>
                                                    <td>{{ $card->points }}</td>
                                                    <td>{{ $card->remaining_points }}</td>
                                                    <td>{{ toHijriWithTime($card->issue_date)}}</td>
                                                    <td>{{ toHijri($card->deduction_deadline) }}</td>


                                                </tr>

                                            @endforeach
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
                        <div class="tab-pane fade show  " id="kt_deductionCard" role="tabpanel">
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-toolbar">
                                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                          height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                          fill="black"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"/>
                                </svg>
                            </span>
                                            <input type="text" data-kt-customer-table-filter="search"
                                                   class="form-control form-control-solid w-250px ps-15"
                                                   placeholder="@lang('message.search')"/>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body pt-0 pb-5">
                                    <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed gy-5"
                                               id="kt_deductionCard_table">
                                            <thead>
                                            <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-150px">@lang('message.name')</th>
                                                <th class="min-w-150px">@lang('message.cycle_number')</th>
                                                <th class="min-w-150px">@lang('message.negative_points_at_time')</th>
                                                <th class="min-w-150px">@lang('message.applied_at')</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach($deductionCards as $card)
                                                <tr>
                                                    <td>{{$card->name}}</td>
                                                    <td>{{$card->pivot->cycle_number}}</td>
                                                    <td>{{$card->pivot->negative_points_at_time}}</td>

                                                    <td>{{toHijriWithTime($card->pivot->applied_at)}}</td>

                                                </tr>

                                            @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                            </div>
                            <!--end::Card-->


                        </div>
                        <div class="tab-pane fade show  " id="kt_logs" role="tabpanel">
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-toolbar">
                                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                          height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                          fill="black"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"/>
                                </svg>
                            </span>
                                            <input type="text" data-kt-customer-table-filter="search"
                                                   class="form-control form-control-solid w-250px ps-15"
                                                   placeholder="@lang('message.search')"/>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body pt-0 pb-5">
                                    <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed gy-5" id="kt_logs_table">
                                            <thead>
                                            <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-25px">رقم السجل</th>
                                                <th class="min-w-25px">من اصدرة</th>
                                                <th class="min-w-25px">النوع</th>
                                                <th class="min-w-25px">التصنيف</th>
                                                <th class="min-w-25px">البند</th>
                                                <th class="min-w-25px">النقاط</th>
                                                <th class="min-w-25px">حاله السجل</th>
                                                <th class="min-w-25px">الحالة</th>
                                                <th class="min-w-25px">تاريخ السجل</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach($logs as $log)

                                                <tr>
                                                    <td>{{$log->issue_number}}</td>
                                                    <td>{{$log->issuedBy->full_name}}</td>
                                                    <td>{{$log->cardItem->category->card->name->label()}}</td>
                                                    <td>{{$log->cardItem->category->name}}</td>
                                                    <td>{{$log->cardItem->name}}</td>
                                                    <td>{{$log->points_value}}</td>
                                                    @if($log->active === true)
                                                        <td><span class="badge badge-success">نشط</span></td>
                                                    @else
                                                        <td><span class="badge badge-danger">غير نشط</span></td>
                                                    @endif
                                                    @if($log->status === \App\Enum\StatusEnum::Approved)
                                                        <td><span class="badge badge-light-success">معتمد</span></td>
                                                    @elseif($log->status === \App\Enum\StatusEnum::Pending)
                                                        <td><span class="badge badge-light-warning">قيد الانتظار</span>
                                                        </td>
                                                    @else
                                                        <td><span class="badge badge-light-danger">مرفوض</span></td>
                                                    @endif
                                                    <td>{{toHijriWithTime($log->log_date)}}</td>


                                                </tr>

                                            @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                            </div>
                            <!--end::Card-->


                        </div>
                        <div class="tab-pane fade show  " id="kt_transfers" role="tabpanel">
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-toolbar">
                                        <div class="kt-table-filter-container">
                                            <a type="button" class="btn btn-light-primary me-3"
                                               data-kt-menu-trigger="click"
                                               data-kt-menu-placement="bottom-end">
                            	<span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
												<path
                                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                    fill="black"/>
											</svg>
										</span>
                                                @lang('message.filter')
                                            </a>

                                            <!-- القائمة -->
                                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                                 data-kt-menu="true">
                                                <div class="px-7 py-5">

                                                    <!-- فلتر الحالة -->
                                                    <div class="mb-10">
                                                        <label
                                                            class="form-label fs-5 fw-bold mb-3">@lang('message.status')</label>
                                                        <div class="d-flex flex-column flex-wrap fw-bold">
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="" checked/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.all')</span>
                                                            </label>
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="@lang('message.pending')"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.pending')</span>
                                                            </label>
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="@lang('message.approved')"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.approved')</span>
                                                            </label>
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="@lang('message.rejected')"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.rejected')</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <!-- فلتر الاتجاه (إرسال / استلام) -->
                                                    <div class="mb-10">
                                                        <label class="form-label fs-5 fw-bold mb-3">نوع التحويل</label>
                                                        <div class="d-flex flex-column flex-wrap fw-bold">
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                <input class="form-check-input" type="radio"
                                                                       name="direction" value="" checked/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.all')</span>
                                                            </label>

                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                <input class="form-check-input" type="radio"
                                                                       name="direction" value="ارسال"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">المرسلة</span>
                                                            </label>

                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                <input class="form-check-input" type="radio"
                                                                       name="direction" value="استلام"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">المستلمة</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <!-- الأزرار -->
                                                    <div class="d-flex justify-content-end">

                                                        <button type="button" class="btn btn-primary"
                                                                data-kt-menu-dismiss="true"
                                                                data-kt-table-filter="filter">
                                                            تطبيق
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                          height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                          fill="black"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"/>
                                </svg>
                            </span>
                                            <input type="text" data-kt-customer-table-filter="search"
                                                   class="form-control form-control-solid w-250px ps-15"
                                                   placeholder="@lang('message.search')"/>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body pt-0 pb-5">
                                    <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed gy-5" id="kt_transfers_table">
                                            <thead>
                                            <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-100px">المرسل</th>
                                                <th class="min-w-100px">المستلم</th>
                                                <th class="min-w-100px">النقاط</th>
                                                <th class="min-w-100px">نوع التحويل</th>
                                                <th class="min-w-100px">السبب</th>
                                                <th class="min-w-100px">الحالة</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach($transfers as $transfer)
                                                <tr>
                                                    <td>{{$transfer->sender->full_name}}</td>
                                                    <td>{{$transfer->receiver->full_name}}</td>
                                                    <td>{{$transfer->amount}}</td>
                                                    <td>
                                                        @if ($transfer->sender_id == $user->id)
                                                            <span class="badge badge-light-danger">ارسال</span>
                                                        @else
                                                            <span class="badge badge-light-success">استلام</span>
                                                        @endif
                                                    </td>

                                                    <td>{{$transfer->reason}}</td>
                                                    @if($transfer->status === \App\Enum\StatusEnum::Pending)
                                                        <td><span
                                                                class="badge badge-light-warning">@lang('message.'.$transfer->status->value)</span>
                                                        </td>
                                                    @elseif($transfer->status === \App\Enum\StatusEnum::Approved)
                                                        <td><span
                                                                class="badge badge-light-success">@lang('message.'.$transfer->status->value)</span>
                                                        </td>
                                                    @else
                                                        <td><span
                                                                class="badge badge-light-danger">@lang('message.'.$transfer->status->value)</span>
                                                        </td>
                                                    @endif


                                                </tr>

                                            @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                            </div>
                            <!--end::Card-->


                        </div>
                        <div class="tab-pane fade show  " id="kt_rechargeCard" role="tabpanel">
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-toolbar">

                                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                          height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                          fill="black"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"/>
                                </svg>
                            </span>
                                            <input type="text" data-kt-customer-table-filter="search"
                                                   class="form-control form-control-solid w-250px ps-15"
                                                   placeholder="@lang('message.search')"/>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body pt-0 pb-5">
                                    <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed gy-5" id="kt_rechargeCard_table">
                                            <thead>
                                            <tr class=" text-gray-400  fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">@lang('message.name')</th>
                                                <th class="min-w-125px">الكرت</th>
                                                <th class="min-w-125px">@lang('message.max_uses')</th>
                                                <th class="min-w-125px">@lang('message.used_count')</th>
                                                <th class="min-w-125px">@lang('message.status')</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach($childCards as $card)

                                                <tr>
                                                    <td>{{ $card->name }}</td>
                                                    <td>{{ $card->pivot->code }}</td>
                                                    <td>{{ $card->pivot->max_uses }}</td>
                                                    <td>{{ $card->pivot->used_count }}</td>
                                                    @if($card->pivot->is_active == 1)
                                                        <td><span class="badge badge-light-success"> نشط</span></td>
                                                    @else
                                                        <td><span class="badge badge-light-danger"> غير نشط</span></td>
                                                    @endif


                                                </tr>

                                            @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                            </div>
                            <!--end::Card-->


                        </div>
                        <div class="tab-pane fade show  " id="kt_awards" role="tabpanel">
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-toolbar">
                                        <div class="kt-table-filter-container">
                                            <a type="button" class="btn btn-light-primary me-3"
                                               data-kt-menu-trigger="click"
                                               data-kt-menu-placement="bottom-end">
                            	<span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
												<path
                                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                    fill="black"/>
											</svg>
										</span>
                                                @lang('message.filter')
                                            </a>

                                            <!-- القائمة -->
                                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                                 data-kt-menu="true">
                                                <div class="px-7 py-5">

                                                    <!-- فلتر الحالة -->
                                                    <div class="mb-10">
                                                        <label
                                                            class="form-label fs-5 fw-bold mb-3">@lang('message.status')</label>
                                                        <div class="d-flex flex-column flex-wrap fw-bold">
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="" checked/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.all')</span>
                                                            </label>
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="@lang('message.pending')"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.pending')</span>
                                                            </label>
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="@lang('message.approved')"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.approved')</span>
                                                            </label>
                                                            <label
                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="radio"
                                                                       name="status"
                                                                       value="@lang('message.rejected')"/>
                                                                <span
                                                                    class="form-check-label text-gray-600">@lang('message.rejected')</span>
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <!-- الأزرار -->
                                                    <div class="d-flex justify-content-end">

                                                        <button type="button" class="btn btn-primary"
                                                                data-kt-menu-dismiss="true"
                                                                data-kt-table-filter="filter">
                                                            تطبيق
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                          height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                          fill="black"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"/>
                                </svg>
                            </span>
                                            <input type="text" data-kt-customer-table-filter="search"
                                                   class="form-control form-control-solid w-250px ps-15"
                                                   placeholder="@lang('message.search')"/>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body pt-0 pb-5">
                                    <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed gy-5" id="kt_awards_table">
                                            <thead>
                                            <tr class=" text-gray-400 fw-bolder  fs-7 text-uppercase gs-0">
                                                <th class="min-w-50px">كود التسليم</th>
                                                <th class="min-w-50px">اسم الجائزة</th>
                                                <th class="min-w-50px">الصوره</th>
                                                <th class="min-w-50px">النقاط</th>
                                                <th class="min-w-50px">تاريخ الطلب</th>
                                                <th class="min-w-50px">حالة الطلب</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach($awards as $request)

                                                <tr>
                                                    @if($request->delivery_code)
                                                        <td>{{$request->delivery_code}}</td>
                                                    @else
                                                        <td>لم يصدر</td>
                                                    @endif

                                                    <td>{{$request->item->name}}</td>
                                                    <td><img width="50px" height="50px" src="{{Storage::disk('images')->url($request->item->image_url)}}" alt="{{$request->item->name}}"></td>
                                                    <td>{{$request->item->points_required}}</td>
                                                    <td>{{toHijriWithTime($request->request_date)}}</td>
                                                    @if($request->status === \App\Enum\StatusEnum::Approved)
                                                        <td><span class="badge badge-light-success">معتمد</span></td>
                                                    @elseif($request->status === \App\Enum\StatusEnum::Pending)
                                                        <td><span class="badge badge-light-warning">قيد الانتظار</span></td>
                                                    @else
                                                        <td><span class="badge badge-light-danger">مرفوض</span></td>
                                                    @endif

                                                </tr>

                                            @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                            </div>
                            <!--end::Card-->


                        </div>
                        <div class="tab-pane fade show  " id="kt_groups" role="tabpanel">
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-toolbar">

                                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                          height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                          fill="black"/>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"/>
                                </svg>
                            </span>
                                            <input type="text" data-kt-customer-table-filter="search"
                                                   class="form-control form-control-solid w-250px ps-15"
                                                   placeholder="@lang('message.search')"/>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body pt-0 pb-5">
                                    <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed gy-5" id="kt_awards_table">
                                            <thead>
                                            <tr class=" text-gray-400 fw-bolder   fs-7 text-uppercase gs-0">
                                                <th class="min-w-150px">اسم المجموعه</th>
                                                <th class="min-w-100px"> القائد</th>
                                                <th class="min-w-100px text-center" colspan="1">@lang('message.action')</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach($groups as $groupUser)

                                                <tr>
                                                    <td>{{ $groupUser->group->name }}</td>
                                                    <td>{{ $groupUser->group->leader->full_name }}</td>



                                                    <td>
                                                        <div class="d-flex justify-content-center flex-shrink-0">
                                                            <a href="{{route('user.group.profile',$groupUser->group)}}"
                                                               class="btn btn-icon btn-bg-light edit-btn btn-active-color-primary btn-sm ms-2"
                                                            >
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                                            </a>

                                                            <!-- زر حذف -->


                                                        </div>

                                                    </td>
                                                </tr>

                                            @endforeach

                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                            </div>
                            <!--end::Card-->


                        </div>


                    </div>
                </div>



            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>

@endsection
@push("script")
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{asset("assets/js/dynamic.js")}}"></script>
    <script src="{{asset("assets/js/custom/apps/customers/add.js")}}"></script>
    <script src="{{asset("assets/js/custom/widgets.js")}}"></script>
    <script>
        KTDynamicTable.init(
            "#kt_issues_table",
            '[data-kt-customer-table-filter="search"]',
            '.kt-table-filter-container' // ضع هذا على div يحتوي كل الفلاتر
        );
        KTDynamicTable.init(
            "#kt_unsettle_table",
            '[data-kt-customer-table-filter="search"]',
            '.kt-table-filter-container' // ضع هذا على div يحتوي كل الفلاتر
        );
        KTDynamicTable.init(
            "#kt_deductionCard_table",
            '[data-kt-customer-table-filter="search"]',
            '.kt-table-filter-container' // ضع هذا على div يحتوي كل الفلاتر
        );
        KTDynamicTable.init(
            "#kt_transfers_table",
            '[data-kt-customer-table-filter="search"]',
            '.kt-table-filter-container' // ضع هذا على div يحتوي كل الفلاتر
        );
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slidesWrapper = document.getElementById('slidesWrapper');
            const slides = document.querySelectorAll('.slide');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const dotsContainer = document.getElementById('sliderDots');

            let currentSlide = 0;

            // Create dots
            slides.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.className = `dot ${index === currentSlide ? 'active' : ''}`;
                dot.addEventListener('click', () => goToSlide(index));
                dotsContainer.appendChild(dot);
            });

            const dots = document.querySelectorAll('.dot');

            function updateSlider() {
                slides.forEach((slide, index) => {
                    slide.classList.toggle('active', index === currentSlide);
                });

                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentSlide);
                });

                prevBtn.disabled = currentSlide === 0;
                nextBtn.disabled = currentSlide === slides.length - 1;

                // Auto-scroll dots to show active dot
                const activeDot = dots[currentSlide];
                if (activeDot) {
                    activeDot.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                }
            }

            function goToSlide(index) {
                currentSlide = index;
                updateSlider();
            }

            prevBtn.addEventListener('click', () => {
                if (currentSlide > 0) {
                    currentSlide--;
                    updateSlider();
                }
            });

            nextBtn.addEventListener('click', () => {
                if (currentSlide < slides.length - 1) {
                    currentSlide++;
                    updateSlider();
                }
            });

            // Find the slide with current layer and show it
            slides.forEach((slide, index) => {
                if (slide.classList.contains('active')) {
                    currentSlide = index;
                }
            });

            updateSlider();

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft' && currentSlide < slides.length - 1) {
                    currentSlide++;
                    updateSlider();
                } else if (e.key === 'ArrowRight' && currentSlide > 0) {
                    currentSlide--;
                    updateSlider();
                }
            });

            // Touch swipe support
            let touchStartX = 0;
            let touchEndX = 0;

            slidesWrapper.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            slidesWrapper.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                if (touchEndX < touchStartX - 50 && currentSlide < slides.length - 1) {
                    currentSlide++;
                    updateSlider();
                }
                if (touchEndX > touchStartX + 50 && currentSlide > 0) {
                    currentSlide--;
                    updateSlider();
                }
            }
        });
    </script>

@endpush
