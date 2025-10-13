@extends("layouts.app")

@section('title')
    تعديل جائزة
@endsection

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar p-3 ">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex mt-5 flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bolder fs-2 flex-column justify-content-center my-0">
                            تعديل جائزة
                        </h1>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">
                        <div class="card-body pt-6">
                            <form id="kt_modal_edit_form" class="form" method="POST"
                                  action="{{ route('awards.update', $award->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- الاسم --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">
                                        <span class="required"> @lang('message.name')</span>
                                    </label>
                                    <div class="input-group input-group-solid mb-5">

                                    <input type="text" class="form-control" name="name"
                                           value="{{ old('name', $award->name) }}"
                                           placeholder="@lang('message.enter', ['item' => __('message.name')])"/>
                                    </div>
                                </div>

                                {{-- الصورة --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">
                                        <span class="required">صورة</span>
                                    </label>
                                    <div class="input-group input-group-solid mb-5">

                                    <input type="file" class="form-control" name="image_url"/>
                                </div>
                                    @if($award->image_url)
                                        <div class="mt-3">
                                            <img src="{{ Storage::disk('images')->url($award->image_url) }}" alt="award image" width="120" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>

                                {{-- النقاط المطلوبة --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">
                                        <span class="required">النقاط المطلوبة</span>
                                    </label>
                                    <div class="input-group input-group-solid mb-5">

                                    <input type="number" class="form-control" name="points_required" min="1"
                                           value="{{ old('points_required', $award->points_required) }}"
                                           placeholder="ادخل النقاط المطلوبة"/>
                                </div>
                                </div>

                                {{-- المخزون --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">
                                        <span class="required">المخزون</span>
                                    </label>
                                    <div class="input-group input-group-solid mb-5">

                                    <input type="number" class="form-control" name="stock" min="0"
                                           value="{{ old('stock', $award->stock) }}"
                                           placeholder="ادخل المخزون"/>

                                </div>
                                </div>

                                {{-- زر إظهار أقسام الدور والمستوى --}}
                                <div class="fv-row mb-7">
                                    <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#role_section">
                                        <i class="bi bi-plus-circle"></i> تعديل شرط الدور
                                    </button>
                                    <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#level_section">
                                        <i class="bi bi-plus-circle"></i> تعديل شرط المستوى
                                    </button>
                                </div>

                                {{-- اختيار الدور --}}
                                <div id="role_section" class="collapse {{ $award->target_role ? 'show' : '' }}">
                                    <div class="fv-row mb-7 mt-5">
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">الدور</span>
                                        </label>

                                        <select name="target_role" class="form-select form-select-solid"
                                                data-control="select2" data-placeholder="اختر الدور">
                                            <option value="">@lang('message.select', ['item' => __('message.type')])</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('target_role', $award->target_role) == $role->id ? 'selected' : '' }}>
                                                    @lang('message.'.$role->name)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- اختيار المستوى --}}
                                <div id="level_section" class="collapse {{ $award->target_level_id ? 'show' : '' }}">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">المستوي</span>
                                        </label>
                                        <select name="target_level_id" class="form-select form-select-solid"
                                                data-control="select2" data-placeholder="اختر المستوي">
                                            <option value="">@lang('message.select', ['item' => __('message.type')])</option>
                                            @foreach($levels as $level)
                                                <option value="{{ $level->id }}" {{ old('target_level_id', $award->target_level_id) == $level->id ? 'selected' : '' }}>
                                                    {{ $level->category }} - {{ $level->layer }} - {{ $level->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- زر الحفظ --}}
                                <div class="text-center pt-15">
                                    <button type="submit" class="btn btn-primary w-100 w-md-25">
                                        <span class="indicator-label">@lang('message.save')</span>
                                        <span class="indicator-progress">جاري التحديث...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
