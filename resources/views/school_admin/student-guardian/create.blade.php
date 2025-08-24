@extends("layouts.app")

@section('title')
    @lang('message.add', ['item' => __('message.student_guardian')])
@endsection
@push("css")
@endpush

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

        <div class=" d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar p-3 ">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bolder fs-2 flex-column justify-content-center my-0">
                            @lang('message.create', ['item' => __('message.student_guardian')])
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("student-guardian.store")}}">
                                @csrf

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.student')</span>
                                    </label>

                                    <select name="student_id" aria-label="Select Type"  data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.student')])"
                                            class="form-select form-select-solid">
                                        <option value="">@lang('message.select', ['item' => __('message.student')])</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                                {{ $student->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.guardian')</span>
                                    </label>

                                    <select name="guardian_id" aria-label="Select Type"  data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.guardian')])"
                                            class="form-select form-select-solid">
                                        <option value="">@lang('message.select', ['item' => __('message.guardian')])</option>
                                        @foreach($guardians as $guardian)
                                            <option value="{{ $guardian->id }}" {{ old('guardian_id') == $guardian->id ? 'selected' : '' }}>
                                                {{ $guardian->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.relationship')</span>
                                    </label>
                                    <select name="relationship" aria-label="Select Type" data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.relationship')])"
                                            class="form-select form-select-solid">

                                        <option value="">@lang('message.select', ['item' => __('message.relationship')])</option>

                                        <option value="father" {{ old('relation') == 'father' ? 'selected' : '' }}>
                                            @lang('message.father')
                                        </option>

                                        <option value="mother" {{ old('relation') == 'mother' ? 'selected' : '' }}>
                                            @lang('message.mother')
                                        </option>


                                    </select>

                                </div>


                                <div class="text-center pt-15">

                                    <button type="submit" class="btn btn-primary" data-kt-modal-action="submit">
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
