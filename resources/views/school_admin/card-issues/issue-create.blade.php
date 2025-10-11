@extends("layouts.app")

@section('title')
    @lang('message.add', ['item' => __('message.card_issue')])
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
                            @lang('message.create', ['item' => __('message.card_issue')])
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("issues.store")}}">
                                @csrf
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">موجه إلى</span>
                                    </label>
                                    <select name="issued_to_type" id="issued_to_type" class="form-select form-select-solid"
                                            data-control="select2" data-placeholder="اختر نوع المستلم">
                                        <option value="">اختر نوع المستلم</option>
                                        <option value="App\Models\User">مستخدم</option>
                                        <option value="App\Models\Group">مجموعة</option>
                                    </select>
                                </div>

                                {{-- قسم المستخدم --}}
                                <div id="userSection" style="display:none;">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mb-2 ">
                                            <span class="required">@lang('message.role')</span>
                                        </label>
                                        <select name="role_id" aria-label="Select Type" id="role_id" data-control="select2"
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
                                        <select name="issued_to_id" id="user_id" data-control="select2"
                                                data-placeholder="@lang('message.select', ['item' => __('message.user')])"
                                                class="form-select form-select-solid">
                                            <option value="">@lang('message.select', ['item' => __('message.user')])</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- قسم المجموعة --}}
                                <div id="groupSection" style="display:none;">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mb-2 ">
                                            <span class="required">المجموعة</span>
                                        </label>
                                        <select name="issued_to_id" id="group_id" class="form-select form-select-solid"
                                                data-control="select2" data-placeholder="اختر المجموعة" disabled>
                                            <option value="">اختر المجموعة</option>
                                            @foreach($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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

                                <div class="fv-row mb-7 d-none" id="paymentTypeWrapper">
                                    <label class="fs-6 fw-semibold form-label mb-2 " >
                                        <span class="required"> @lang('message.deduction_type')</span>
                                    </label>
                                    <select name="deduction_type" id="deduction_type"  class="form-select form-select-solid" aria-label="Select Type"
                                            data-control="select2" data-placeholder="@lang('message.select', ['item' => __('message.deduction_type')])">
                                        <option value="">@lang('message.select', ['item' => __('message.deduction_type')])</option>
                                    @foreach(\App\Enum\DeductionTypeEnum::cases() as $type)
                                            <option value="{{ $type->value }}" {{ old('deduction_type') == $type->value ? 'selected' : '' }}>
                                                @lang('message.'.$type->value)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="fv-row mb-7 d-none" id="deadlineWrapper">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.deduction_deadline')</span>
                                    </label>
                                    <input type="number" name="deduction_duration_days" value="1" class="form-control form-control-solid"/>
                                </div>

                                <div class="fv-row mb-7 d-none " id="restricted" >
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">التقييد</span>
                                    </label>

                                    <div class="input-group  mb-5">
                                        <input type="checkbox" value="{{old("is_restricted",1)}}"
                                               name="is_restricted"/>

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
            let $paymentTypeWrap  = $('#paymentTypeWrapper');
            let $deadlineWrapper  = $('#deadlineWrapper');
            let $restricted      = $('#restricted');

            $('#cardSelect').on('change', function () {
                let cardId   = $(this).val();
                let cardType = $(this).find(':selected').data('type'); // النوع من db
                let card     = cards.find(c => c.id == cardId);

                // reset
                $categorySelect.empty().append('<option value="">اختر التصنيف</option>');
                $itemSelect.empty().append('<option value="">اختر العنصر</option>');
                $paymentTypeWrap.addClass('d-none');
                $deadlineWrapper.addClass('d-none');

                if (card && card.categories.length > 0) {
                    $.each(card.categories, function (i, cat) {
                        $categorySelect.append('<option value="'+cat.id+'">'+cat.name+'</option>');
                    });
                    $categorySelect.prop('disabled', false);

                    // لو نوع الكرت سلبي → نظهر الدفع
                    if (cardType === 'negative') {
                        $paymentTypeWrap.removeClass('d-none');
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

            $('#deduction_type').on('change', function () {
                if ($(this).val() === 'deferred') {

                    $deadlineWrapper.removeClass('d-none');
                    $restricted.removeClass('d-none');

                } else {
                    $deadlineWrapper.addClass('d-none');
                }
            });
        });
    </script>
<script>
    $(document).ready(function () {
        let allUsers = @json($users);
        let $issuedType   = $('#issued_to_type');
        let $userSection  = $('#userSection');
        let $groupSection = $('#groupSection');
        let $roleSelect   = $('#role_id');
        let $userSelect   = $('#user_id');
        let $groupSelect  = $('#group_id'); // تأكد إن عندك select للمجموعة بالـ id ده

        // إظهار القسم المناسب وتفعيل/تعطيل الحقول
        $issuedType.on('change', function () {
            if ($(this).val() === 'App\\Models\\User') {
                $userSection.show();
                $userSelect.prop('disabled', false);

                $groupSection.hide();
                $groupSelect.prop('disabled', true);

            } else if ($(this).val() === 'App\\Models\\Group') {
                $groupSection.show();
                $groupSelect.prop('disabled', false);

                $userSection.hide();
                $userSelect.prop('disabled', true);

            } else {
                $userSection.hide();
                $userSelect.prop('disabled', true);

                $groupSection.hide();
                $groupSelect.prop('disabled', true);
            }
        });

        // فلترة المستخدمين بناءً على الدور
        $roleSelect.on('change', function () {
            let roleId = $(this).val();
            $userSelect.empty().append('<option value="">اختر المستخدم</option>');

            if (roleId) {
                let filteredUsers = allUsers.filter(u => u.role_id == roleId);
                filteredUsers.forEach(user => {
                    $userSelect.append(
                        '<option value="' + user.id + '">' +
                        user.full_name + ' - ' + user.username +
                        '</option>'
                    );
                });
                $userSelect.trigger('change');
            }
        });
    });

</script>
@endpush
