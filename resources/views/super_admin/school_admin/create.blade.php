@extends("layouts.app")

@section('title')
    @lang('message.add', ['item' => __('message.admins')])
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
                            @lang('message.create', ['item' => __('message.admin')])
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("admin.store")}}">
                                @csrf

                                <input type="hidden" name="role_id" value="2">

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.full_name')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{old("full_name")}}" class="form-control"
                                               name="full_name"
                                               placeholder="@lang('message.enter', ['item' => __('message.full_name')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.school_name')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{old("school_name")}}" class="form-control"
                                               name="school_name"
                                               placeholder="@lang('message.enter', ['item' => __('message.school_name')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.email')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="email" value="{{old("email")}}" class="form-control"
                                               name="email"
                                               placeholder="@lang('message.enter', ['item' => __('message.email')])"
                                               autocomplete="off"/>

                                    </div>
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class=""> @lang('message.phone')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{old("phone")}}" class="form-control"
                                               name="phone"
                                               placeholder="@lang('message.enter', ['item' => __('message.phone')])"
                                               autocomplete="off"/>

                                    </div>
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
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password-field');
            const toggleIcon = document.getElementById('toggle-icon');
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>

@endpush
