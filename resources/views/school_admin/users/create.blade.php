@extends("layouts.app")

@section('title')
    @lang('message.add', ['item' => __('message.users')])
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
                            @lang('message.create', ['item' => __('message.user')])
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("users.store")}}">
                                @csrf

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.full_name')</span>
                                        <span>
                                            @error('username')<small class="text-danger">{{ $message }}</small>@enderror
                                        </span>
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
                                        <span class="required"> @lang('message.email')</span>
                                        <span>
                                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                        </span>
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
                                        <span>
                                            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                                        </span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{old("phone")}}" class="form-control"
                                               name="phone"
                                               placeholder="@lang('message.enter', ['item' => __('message.phone')])"
                                               autocomplete="off"/>

                                    </div>
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.role')</span>
                                        <span>
                                            @error('role_id')<small class="text-danger">{{ $message }}</small>@enderror
                                        </span>
                                    </label>

                                    <select name="role_id" aria-label="Select Type" id="type" data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.role')])"
                                            class="form-select form-select-solid">
                                        <option value="">@lang('message.select', ['item' => __('message.role')])</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                @lang('message.'.$role->name)
                                            </option>
                                        @endforeach
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
