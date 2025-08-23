@extends("layouts.app")

@section('title')
    @lang('message.update', ['item' => __('message.school')])
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
                            @lang('message.update', ['item' => __('message.school')])
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("school.data.update")}}" >
                                @csrf
                                @method('PUT')

                                <div class="fv-row  mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">@lang('message.name')</span>
                                        <span>
                                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                        </span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{$school->name}}" class="form-control"
                                               name="name"
                                               placeholder="@lang('message.enter', ['item' => __('message.school_name')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="">@lang('message.email')</span>
                                        <span>
                                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                        </span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="email" value="{{$school->email}}" class="form-control"
                                               name="email"
                                               placeholder="@lang('message.enter', ['item' => __('message.email')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="">@lang('message.location')</span>
                                        <span>
                                            @error('location')<small class="text-danger">{{ $message }}</small>@enderror
                                        </span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{$school->location}}" class="form-control"
                                               name="location"
                                               placeholder="@lang('message.enter', ['item' => __('message.location')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="">@lang('message.phone')</span>
                                        <span>
                                            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                                        </span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{$school->phone}}" class="form-control"
                                               name="phone"
                                               placeholder="@lang('message.enter', ['item' => __('message.phone')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="">@lang('message.ministerial_number')</span>
                                        <span>
                                            @error('ministerial_number')<small class="text-danger">{{ $message }}</small>@enderror
                                        </span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{$school->ministerial_number}}" class="form-control"
                                               name="ministerial_number"
                                               placeholder="@lang('message.enter', ['item' => __('message.ministerial_number')])"
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

@endpush
