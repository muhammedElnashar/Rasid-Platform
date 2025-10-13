@extends("layouts.app")

@section('title')
    انشاء الأوسمه و الميدليات
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
                            إضافة وسام او ميدالية جديدة
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("badges.store")}}" enctype="multipart/form-data">
                                @csrf

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">الإسم</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text"  value="{{old("name")}}" class="form-control"
                                               name="name"
                                               placeholder="ادخل الإسم"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">الوصف</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <textarea class="form-control" name="description" rows="3" placeholder="ادخل الوصف">{{old("description")}}</textarea>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">عدد النقاط المطلوبة</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="number" min="1" value="{{old("required_points")}}" class="form-control"
                                               name="required_points"
                                               placeholder=" ادخل قيمة النقاط المطلوبة"
                                               autocomplete="off"/>

                                    </div>
                                    <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">عدد النقاط المكتسبة</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="number" min="1" value="{{old("points_awarded")}}" class="form-control"
                                               name="points_awarded"
                                               placeholder=" ادخل قيمة النقاط المكتسبة"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">الصورة</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="file"   class="form-control"
                                               name="image"
                                               autocomplete="off"/>

                                    </div>

                                </div>


                                <div class="text-center pt-15">

                                    <button type="submit" class="btn btn-primary w-100 w-md-25" data-kt-modal-action="submit">
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
