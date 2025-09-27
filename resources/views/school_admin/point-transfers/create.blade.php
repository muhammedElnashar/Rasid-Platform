@extends("layouts.app")

@section('title')
    @lang('message.add', ['item' => __('message.transfer')])
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
                            @lang('message.create', ['item' => __('message.transfer')])
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("transfer.store")}}">
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
                                        <span class="required"> @lang('message.transfer_points')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="number" value="{{old("amount")}}" class="form-control"
                                               name="amount" min="1"
                                               placeholder="@lang('message.enter', ['item' => __('message.transfer_points')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.reason_transfer')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                         <textarea name="reason"
                                                   class="form-control"
                                                   rows="3"
                                                   placeholder="@lang('message.enter', ['item' => __('message.reason_transfer')])"
                                                   autocomplete="off">{{ old('reason') }}</textarea>
                                    </div>
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.purpose')</span>
                                    </label>

                                    <select name="purpose" aria-label="Select Type" data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.purpose')])"
                                            class="form-select form-select-solid">
                                        <option
                                            value="">@lang('message.select', ['item' => __('message.purpose')])</option>
                                        @foreach(\App\Enum\PurposeEnum::cases() as $type)
                                            <option
                                                value="{{ $type->value }}" {{ old('purpose') == $type->value ? 'selected' : '' }}>
                                                @lang('message.'. $type->value)
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
    <script>
        let allUsers = @json($users);

        $(document).ready(function () {

            let userSelect = $('#user_id');

            $('select[name="role_id"]').on('change', function () {
                let roleId = $(this).val();
                userSelect.empty();

                if (roleId) {
                    let filteredUsers = allUsers.filter(u => u.role_id == roleId);

                    filteredUsers.forEach(user => {
                        userSelect.append('<option value="' + user.id + '">' + user.full_name +' - ' + user.username + '</option>');
                    });
                    userSelect.trigger('change'); // تحديث select2
                }
            });
        });
    </script>


@endpush
