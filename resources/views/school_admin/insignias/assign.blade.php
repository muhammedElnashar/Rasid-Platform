@extends("layouts.app")

@section('title')
    اصدار الشارات
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
                            اصدار الشارات
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{ route('insignias.assign') }}">
                                @csrf

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.role')</span>
                                    </label>

                                    <select name="role_id" aria-label="Select Type" id="type" data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.role')])"
                                            class="form-select form-select-solid">
                                        <option value="">@lang('message.select', ['item' => __('message.role')])</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ __('message.'.$role->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">@lang('message.user')</span>
                                    </label>

                                    <select name="user_id" id="user_id"
                                            data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.user')])"
                                            class="form-select form-select-solid">
                                        <option value="">@lang('message.select', ['item' => __('message.user')])</option>
                                    </select>
                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">الشارات</span>
                                    </label>

                                    <select name="insignia_id" data-control="select2"
                                            data-placeholder="اختر الشارة"
                                            class="form-select form-select-solid">
                                        <option value="">الشارات</option>
                                        @foreach($insignias as $insignia)
                                            <option value="{{ $insignia->id }}">{{ $insignia->name }} - @lang('message.points') ( {{$insignia->points_value}} )</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="text-center pt-15">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">@lang('message.save')</span>
                                        <span class="indicator-progress">جاري الحفظ ...
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

@push('script')
    <script>
        let allUsers = @json($users);

        $(document).ready(function () {
            $('[data-control="select2"]').select2({
                width: '100%',
                allowClear: true,
                placeholder: "اختر المستخدمين"
            });

            let userSelect = $('#user_id');

            $('select[name="role_id"]').on('change', function () {
                let roleId = $(this).val();
                userSelect.empty();

                if (roleId) {
                    let filteredUsers = allUsers.filter(u => u.role_id == roleId);

                    filteredUsers.forEach(user => {
                        userSelect.append('<option value="' + user.id + '">' + user.full_name + '</option>');
                    });
                    userSelect.trigger('change'); // تحديث select2
                }
            });
        });
    </script>
@endpush
