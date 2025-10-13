@extends("layouts.app")

@section('title')
    اضافة جائزة
@endsection
@push("css")
@endpush

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

        <div class=" d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar p-3 ">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex mt-5 flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bolder fs-2 flex-column justify-content-center my-0">
                            انشاء جائزة
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("awards.store")}}" enctype="multipart/form-data">
                                @csrf



                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.name')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{old("name")}}" class="form-control"
                                               name="name"
                                               placeholder="@lang('message.enter', ['item' => __('message.name')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">صورة</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="file" value="{{old("image_url")}}" class="form-control"
                                               name="image_url"
                                               autocomplete="off"/>

                                    </div>

                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">النقاط المطلوبة</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="number" value="{{old("points_required")}}" class="form-control"
                                               name="points_required" min="1"
                                               placeholder="ادخل النقاط المطلوبة"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">المخزون</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="number" value="{{old("stock")}}" class="form-control"
                                               name="stock" min="0"
                                               placeholder="ادخل المخزون"
                                               autocomplete="off"/>

                                    </div>

                                </div>

                                <div class="fv-row mb-7">
                                    <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#role_section">
                                        <i class="bi bi-plus-circle"></i> إضافة شرط الدور
                                    </button>
                                    <button type="button" class="btn btn-light-primary" data-bs-toggle="collapse" data-bs-target="#level_section">
                                        <i class="bi bi-plus-circle"></i> إضافة شرط المستوى
                                    </button>
                                </div>

                                <div id="role_section" class="collapse">
                                    <div class="fv-row mb-7 mt-5">
                                        <label class="fs-6 fw-semibold form-label mb-2 ">
                                            <span class="required">الدور</span>
                                        </label>
                                        <select name="target_role" aria-label="Select Type" data-control="select2"
                                                data-placeholder="اختر الدور"
                                                class="form-select form-select-solid">
                                            <option value="">@lang('message.select', ['item' => __('message.type')])</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('target_role') == $role->id ? 'selected' : '' }}>
                                                    @lang('message.'.$role->name)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div id="level_section" class="collapse">

                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mb-2 ">
                                            <span class="required">المستوي</span>
                                        </label>
                                        <select name="target_level_id" aria-label="Select Type" data-control="select2"
                                                data-placeholder="اختر المستوي"
                                                class="form-select form-select-solid">
                                            <option value="">@lang('message.select', ['item' => __('message.type')])</option>
                                            @foreach($levels as $level)
                                                <option value="{{ $level->id }}" {{ old('target_level_id') == $level->id ? 'selected' : '' }}>
                                                    {{$level->category}} - {{$level->layer}} - {{$level->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="text-center pt-15">

                                    <button type="submit" class="btn btn-primary w-100 w-md-25" data-kt-modal-action="submit">
                                        <span class="indicator-label">@lang('message.save')</span>
                                        <span class="indicator-progress">جاري الحفظ ...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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

@push('script')
@endpush

