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
                                  action="{{route("school.data.update")}}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row  mb-7">
                                 <div class="col-6">
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
                                 <div class="col-6">
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

                                </div>

                                <div class="row mb-7">
                                    <div class="col-4">
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
                                    <div class="col-4">
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
                                    <div class="col-4">
                                        <label class="fs-6 fw-semibold form-label mb-2 ">
                                            <span class="">@lang('message.ministerial_number')</span>
                                            <span>
                                            @error('ministerial_number')<small
                                                    class="text-danger">{{ $message }}</small>@enderror
                                        </span>
                                        </label>

                                        <div class="input-group input-group-solid mb-5">
                                            <input type="text" value="{{$school->ministerial_number}}" class="form-control"
                                                   name="ministerial_number"
                                                   placeholder="@lang('message.enter', ['item' => __('message.ministerial_number')])"
                                                   autocomplete="off"/>

                                        </div>
                                    </div>


                                </div>

                                <div class="row mb-7">
                                    <div class="col-6">
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="">@lang('message.logo')</span>

                                        </label>

                                        <div class="input-group input-group-solid mb-5">
                                            <input type="file" class="form-control" name="logo"
                                                   placeholder="@lang('message.enter', ['item' => __('message.logo')])"
                                                   autocomplete="off"/>
                                        </div>

                                        <div class="input-group  mb-5">
                                            @if($school->logo)
                                                <img src="{{ Storage::disk('images')->url($school->logo) }}" alt="" width="150px"
                                                     height="150px">
                                            @endif

                                        </div>

                                    </div>
                                    <div class="col-6">
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="">@lang('message.documents')</span>

                                        </label>

                                        <div class="input-group input-group-solid mb-5">
                                            <input type="file" class="form-control" name="documents"
                                                   placeholder="@lang('message.enter', ['item' => __('message.documents')])"
                                                   autocomplete="off"/>
                                        </div>

                                        <div class="input-group  mb-5">
                                            @if($school->documents)
                                                <a href="{{ Storage::disk('files')->url($school->documents) }}" target="_blank">
                                                    @lang('message.view_file')
                                                </a>
                                            @endif

                                        </div>

                                    </div>



                                </div>
                                <div class="fv-row mb-7">

                                    <div class="text-center ">

                                        <button type="submit" class="btn btn-primary" data-kt-modal-action="submit">
                                            <span class="indicator-label">@lang('message.save')</span>
                                            <span class="indicator-progress">جاري الحفظ ...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
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
