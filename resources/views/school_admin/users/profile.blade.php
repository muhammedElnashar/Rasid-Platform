@extends('layouts.app')
@section('title')
    الصفحة الشخصية
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
        .animation-alert {
            position: relative;
            overflow: visible;
        }



        .animation-alert::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(90deg, #10b981, #34d399, #10b981);
            border-radius: inherit;
            z-index: -1;
            opacity: 0.6;
            animation: rotateBorder 3s linear infinite;
        }

        @keyframes rotateBorder {
            0% {
                clip-path: polygon(0% 0%, 100% 0%, 100% 0%, 0% 0%);
            }
            25% {
                clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 0%);
            }
            50% {
                clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
            }
            75% {
                clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%, 0% 0%);
            }
            100% {
                clip-path: polygon(0% 0%, 100% 0%, 100% 0%, 0% 0%);
            }
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
                        <div class="card mb-5 mt-5 mb-xl-8 animation-alert border-primary">
                            <div class="card-body ">
                                <div class="d-flex flex-center flex-column py-5">
                                    <div class="symbol symbol-100px border border-3 border-success mb-7">
                                        @if($user->image)
                                            <img
                                                src="{{\Illuminate\Support\Facades\Storage::disk('images')->url($user->image)}}"
                                                alt="image"/>
                                        @else
                                            <img src="{{asset('assets/media/avatars/150-26.jpg')}}" alt="image"/>
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
                                         aria-controls="kt_user_view_details">التفاصيل
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
                                        <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                           data-bs-target="#kt_modal_update_details">تعديل</a>
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
                                        @if(\Illuminate\Support\Facades\Auth::user()->isStudent() )

                                            @foreach($parents as $parent)
                                                <div class="fw-bolder mb-4 mt-5">
                                                    اسم {{ \App\Enum\RelationEnum::from($parent->pivot->relationship)->label() }}
                                                </div>
                                                <span class="fs-5 text-gray-600">{{ $parent->full_name }}</span>
                                            @endforeach
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

                                        @endif
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

                            @if(\Illuminate\Support\Facades\Auth::user()->isTeacher())
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                       data-bs-toggle="tab" href="#kt_user_view_overview_tab">الفصول و المواد </a>
                                </li>
                            @endif

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
                                                <div class="card-body text-center p-4 border border-3 border-primary">
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
                                                        {{ toHijri($insignia->pivot->award_date) }}
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
                                                <div class="card-body text-center p-4 border border-3 border-info">
                                                    <!-- صورة -->
                                                    <div class="mb-3 position-relative">
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
                                                        {{ toHijri($badge->pivot->award_date) }}
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




                            @if(\Illuminate\Support\Facades\Auth::user()->isTeacher())
                                <div class="tab-pane fade " id="kt_user_view_overview_tab" role="tabpanel">

                                    <div class="card card-flush mb-6 mb-xl-9">

                                        <div class="card-body p-9 pt-4">
                                            <div class="tab-content">

                                                <div id="kt_schedule_day_1" class="tab-pane fade show active">
                                                    @foreach($subjectClasses as $subjectClass)
                                                        <div class="d-flex flex-stack position-relative mt-6">
                                                            <div
                                                                class="position-absolute h-100 w-4px bg-info rounded top-0 start-0"></div>

                                                            <div class="fw-bold ms-5">
                                                                <div class="fs-7 mb-1">الماده</div>
                                                                <a href="#"
                                                                   class="fs-5 fw-bolder text-dark text-hover-primary mb-2">{{$subjectClass->subject_name}}</a>
                                                                <hr>
                                                            </div>
                                                            <div class="fw-bold ms-5">
                                                                <div class="fs-7 mb-1">الفصل</div>
                                                                <a href="#"
                                                                   class="fs-5 fw-bolder text-dark text-hover-primary mb-2">{{$subjectClass->class_name}}</a>
                                                                <hr>
                                                            </div>
                                                            <div class="fw-bold ms-5">
                                                                <div class="fs-7 mb-1">الصف</div>
                                                                <a href="#"
                                                                   class="fs-5 fw-bolder text-dark text-hover-primary mb-2">{{$subjectClass->grade_name}}</a>
                                                                <hr>
                                                            </div>
                                                            <div class="fw-bold ms-5">
                                                                <div class="fs-7 mb-1">المرحلة</div>
                                                                <a href="#"
                                                                   class="fs-5 fw-bolder text-dark text-hover-primary mb-2">{{$subjectClass->stage_name}}</a>
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

                <!--begin::Modal - Update User Details-->
                <div class="modal fade" id="kt_modal_update_details" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <div class="modal-content">
                            <form class="form" id="update_user_form" method="POST" enctype="multipart/form-data"
                                  action="{{route('update.profile')}}">
                                @csrf
                                @method('PUT')

                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <h2 class="fw-bolder mb-0">تحديث بيانات المستخدم</h2>
                                    <button type="button" class="btn btn-icon btn-sm btn-active-light-primary"
                                            data-bs-dismiss="modal">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                                <!--end::Modal header-->

                                <!--begin::Modal body-->
                                <div class="modal-body py-10 px-lg-17">
                                    <div class="d-flex flex-column scroll-y me-n7 pe-7" style="max-height:70vh;">

                                        <!--begin::Avatar Upload-->
                                        <div class="mb-7 text-center">
                                            <label class="fs-6 fw-bold mb-2 d-block">الصورة الشخصية</label>
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                 style="background-image: url('{{ asset('assets/media/avatars/blank.png') }}')">
                                                <!--begin::Preview-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                     style="background-image: url('{{ Auth::user()->image ? Storage::disk('images')->url(Auth::user()->image) : asset('assets/media/avatars/blank.png') }}')">
                                                </div>

                                                <!--end::Preview-->

                                                <!--begin::Edit-->
                                                <label
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    title="تغيير الصورة">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="avatar_remove" />

                                                </label>
                                                <!--end::Edit-->

                                                <!--begin::Cancel-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    title="إلغاء التغيير">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                                <!--end::Cancel-->

                                                <!--begin::Remove-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                    title="إزالة الصورة">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                                <!--end::Remove-->
                                            </div>
                                        </div>
                                        <!--end::Avatar Upload-->

                                        <!--begin::Input - Email-->
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold mb-2">البريد الإلكتروني</label>
                                            <input type="email" class="form-control form-control-solid" name="email"
                                                   value="{{ Auth::user()->email }}" placeholder="example@email.com"
                                                   required/>
                                        </div>
                                        <!--end::Input-->

                                        <!--begin::Input - Phone-->
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-bold mb-2">رقم الهاتف</label>
                                            <input type="text" class="form-control form-control-solid" name="phone"
                                                   value="{{ Auth::user()->phone }}" placeholder="05XXXXXXXX" required/>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Modal body-->

                                <!--begin::Modal footer-->
                                <div class="modal-footer flex-center">
                                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">إلغاء
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">حفظ التغييرات</span>
                                        <span class="indicator-progress">الرجاء الانتظار...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Modal footer-->

                            </form>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->



            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>

@endsection
@push('script')
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
