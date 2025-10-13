@extends("layouts.app")

@section('title')
    رفع دفعة من المستخدمين
@endsection

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar p-3 ">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column mt-5 justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bolder fs-2 flex-column justify-content-center my-0">
                            رفع دفعة من المستخدمين
                        </h1>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">
                        <div class="card-body pt-6">



                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{ route('import.bulk.users') }}"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">
                                        <span class="required">الملف </span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="file"
                                               class="form-control @error('file') is-invalid @enderror"
                                               name="file"
                                               accept=".csv,.xlsx,.txt"
                                               required>
                                    </div>
                                </div>

                                <div class="text-center pt-15">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">رفع</span>
                                        <span class="indicator-progress">جاري الرفع ...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                    <a href="{{asset('assets/users.csv')}}" class="btn btn-primary" download>
                                        <span class="indicator-label">تنزيل الملف</span>
                                    </a>
                                </div>
                            </form>

                            <hr class="my-5">

                            <div class="alert alert-info">
                                <strong>ملاحظات هامة:</strong>
                                <ul class="mb-0">
                                    <li>يجب أن يحتوي الملف على الأعمدة: <code>full_name, email, role_id</code></li>
                                    <li>صيغة مسموحة: CSV, XLSX, TXT</li>
                                    <li>حجم الملف الأقصى: 2 ميجابايت</li>
                                    <li>Role_id => يجب أن يكون طالب (3) أو معلم (4) أو ولي امر (5) أو مشرف (6)'</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
