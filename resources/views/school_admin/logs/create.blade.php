@extends("layouts.app")

@section('title')
    اضافة سجل
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
                            انشاء سجل جديد
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("logs.store")}}">
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
                                        <span class="required"> @lang('message.card')</span>
                                    </label>
                                    <select name="card_id" id="cardSelect" data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.card')])"
                                            class="form-select form-select-solid">
                                        <option value="">@lang('message.select', ['item' => __('message.card')])</option>
                                        @foreach($cards as $card)
                                            <option value="{{ $card->id }}" data-type="{{ $card->name }}">
                                                {{ $card->name->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.category')</span>
                                    </label>
                                    <select id="categorySelect" class="form-select form-select-solid" aria-label="Select Type"
                                            data-control="select2" data-placeholder="@lang('message.select', ['item' => __('message.category')])">
                                    </select>
                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.item')</span>
                                    </label>
                                    <select name="card_item_id" id="itemSelect" class="form-select form-select-solid" aria-label="Select Type"
                                            data-control="select2" data-placeholder="@lang('message.select', ['item' => __('message.item')])">
                                    </select>
                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">نشاط السجل</span>
                                    </label>

                                    <div class="form-check form-check-custom form-check-solid">
                                        <input type="hidden" name="active" value="0">

                                        <input type="checkbox"
                                               class="form-check-input"
                                               name="active"
                                               value="1"
                                            {{ old('active', 1) ? 'checked' : '' }} />
                                        <label class="form-check-label">مفعل</label>
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
        $(function () {
            let cards = @json($cards);

            let $categorySelect   = $('#categorySelect');
            let $itemSelect       = $('#itemSelect');

            $('#cardSelect').on('change', function () {
                let cardId   = $(this).val();
                let cardType = $(this).find(':selected').data('type'); // النوع من db
                let card     = cards.find(c => c.id == cardId);

                // reset
                $categorySelect.empty().append('<option value="">اختر التصنيف</option>');
                $itemSelect.empty().append('<option value="">اختر العنصر</option>');

                if (card && card.categories.length > 0) {
                    $.each(card.categories, function (i, cat) {
                        $categorySelect.append('<option value="'+cat.id+'">'+cat.name+'</option>');
                    });
                    $categorySelect.prop('disabled', false);

                    // لو نوع الكرت سلبي → نظهر الدفع
                    if (cardType === 'حسم سلبي') {
                    }
                } else {
                    $categorySelect.prop('disabled', true);
                    $itemSelect.prop('disabled', true);
                }
            });

            $categorySelect.on('change', function () {
                let categoryId = $(this).val();
                let cardId     = $('#cardSelect').val();
                let card       = cards.find(c => c.id == cardId);
                let category   = card ? card.categories.find(cat => cat.id == categoryId) : null;

                $itemSelect.empty().append('<option value="">اختر العنصر</option>');

                if (category && category.items.length > 0) {
                    $.each(category.items, function (i, item) {
                        $itemSelect.append('<option value="'+item.id+'">'+item.name+' (نقاط: '+item.points+')</option>');
                    });
                    $itemSelect.prop('disabled', false);
                } else {
                    $itemSelect.prop('disabled', true);
                }
            });

        });
    </script>
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
                        userSelect.append('<option value="' + user.id + '">' + user.full_name + ' - ' + user.username + '</option>');
                    });
                    userSelect.trigger('change'); // تحديث select2
                }
            });
        });
    </script>

@endpush

