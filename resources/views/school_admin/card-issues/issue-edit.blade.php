
@extends("layouts.app")

@section('title')
    @lang('message.edit', ['item' => __('message.card_issue')])
@endsection

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class=" d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar p-3 ">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bolder fs-2 flex-column justify-content-center my-0">
                            @lang('message.edit', ['item' => __('message.card_issue')])
                        </h1>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">
                        <div class="card-body pt-6">
                            <form id="kt_modal_edit_form" class="form" method="POST"
                                  action="{{route('issues.update', $issue->id)}}">
                                @csrf
                                @method('PUT')

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.user')</span>
                                    </label>
                                    <select name="user_id" aria-label="Select Type" data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.user')])"
                                            class="form-select form-select-solid">
                                        <option value="">@lang('message.select', ['item' => __('message.users')])</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ (old('user_id', $issue->user_id) == $user->id) ? 'selected' : '' }}>
                                                {{ $user->full_name }} - {{ $user->role->name }}
                                            </option>
                                        @endforeach
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
                                            <option value="{{ $card->id }}" data-type="{{ $card->name }}"
                                                {{ (old('card_id', $issue->cardItem->category->card->id) == $card->id) ? 'selected' : '' }}>
                                                {{ $card->name }}
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

                                <div class="fv-row mb-7 {{ ($issue->cardItem->category->card->name !== 'حسم سلبي') ? 'd-none' : '' }}" id="paymentTypeWrapper">
                                    <label class="fs-6 fw-semibold form-label mb-2 " >
                                        <span class="required"> @lang('message.deduction_type')</span>
                                    </label>
                                    <select name="deduction_type" id="deduction_type" class="form-select form-select-solid" aria-label="Select Type"
                                            data-control="select2" data-placeholder="@lang('message.select', ['item' => __('message.deduction_type')])">
                                        <option value="">@lang('message.select', ['item' => __('message.deduction_type')])</option>
                                        @foreach(\App\Enum\DeductionTypeEnum::cases() as $type)
                                            <option value="{{ $type->value }}"
                                                {{ (old('deduction_type', $issue->deduction_type?->value) == $type->value) ? 'selected' : '' }}>
                                                @lang('message.'.$type->value)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="fv-row mb-7 {{ ($issue->deduction_type?->value !== 'deferred') ? 'd-none' : '' }}" id="deadlineWrapper">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.deduction_deadline')</span>
                                    </label>
                                    <input type="number" name="deduction_duration_days"
                                           value="{{ old('deduction_duration_days', $issue->deduction_duration_days ?? 1) }}"
                                           class="form-control form-control-solid"/>
                                </div>

                                <div class="text-center pt-15">
                                    <a href="{{ route('issues.index') }}" class="btn btn-light me-3">
                                        @lang('message.discard')
                                    </a>
                                    <button type="submit" class="btn btn-primary" data-kt-modal-action="submit">
                                        <span class="indicator-label">@lang('message.save')</span>
                                        <span class="indicator-progress">جاري التحديث ...
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
        $(function () {
            let cards = @json($cards);
            let issue = @json($issue);

            let $cardSelect       = $('#cardSelect');
            let $categorySelect   = $('#categorySelect');
            let $itemSelect       = $('#itemSelect');
            let $paymentTypeWrap  = $('#paymentTypeWrapper');
            let $deadlineWrapper  = $('#deadlineWrapper');
            let $deductionType    = $('#deduction_type');

            // تحميل البيانات الحالية عند فتح الصفحة
            function loadExistingData() {
                console.log('Loading existing data:', issue);

                if (issue.card_item && issue.card_item.category && issue.card_item.category.card) {
                    let selectedCard = issue.card_item.category.card;
                    let selectedCategory = issue.card_item.category;
                    let selectedItem = issue.card_item;

                    // العثور على الكرت في البيانات
                    let card = cards.find(c => c.id == selectedCard.id);

                    if (card) {
                        // تحميل التصنيفات
                        $categorySelect.empty().append('<option value="">اختر التصنيف</option>');
                        if (card.categories && card.categories.length > 0) {
                            $.each(card.categories, function (i, cat) {
                                let selected = (cat.id == selectedCategory.id) ? 'selected' : '';
                                $categorySelect.append('<option value="'+cat.id+'" '+selected+'>'+cat.name+'</option>');
                            });
                            $categorySelect.prop('disabled', false);
                        }

                        // تحميل العناصر
                        let category = card.categories.find(cat => cat.id == selectedCategory.id);
                        if (category) {
                            $itemSelect.empty().append('<option value="">اختر العنصر</option>');
                            if (category.items && category.items.length > 0) {
                                $.each(category.items, function (i, item) {
                                    let selected = (item.id == selectedItem.id) ? 'selected' : '';
                                    $itemSelect.append('<option value="'+item.id+'" '+selected+'>'+item.name+' (نقاط: '+item.points+')</option>');
                                });
                                $itemSelect.prop('disabled', false);
                            }
                        }

                        // إظهار حقول الخصم إذا كان النوع سلبي
                        if (selectedCard.name === 'حسم سلبي') {
                            $paymentTypeWrap.removeClass('d-none');

                            // إظهار حقل المدة إذا كان النوع مؤجل
                            if (issue.deduction_type === 'deferred') {
                                $deadlineWrapper.removeClass('d-none');
                            }
                        }
                    }
                }
            }

            // تحميل البيانات عند بداية التحميل
            setTimeout(function() {
                loadExistingData();
            }, 100);

            $('#cardSelect').on('change', function () {
                let cardId   = $(this).val();
                let cardType = $(this).find(':selected').data('type');
                let card     = cards.find(c => c.id == cardId);

                // reset
                $categorySelect.empty().append('<option value="">اختر التصنيف</option>');
                $itemSelect.empty().append('<option value="">اختر العنصر</option>');
                $paymentTypeWrap.addClass('d-none');
                $deadlineWrapper.addClass('d-none');

                if (card && card.categories && card.categories.length > 0) {
                    $.each(card.categories, function (i, cat) {
                        $categorySelect.append('<option value="'+cat.id+'">'+cat.name+'</option>');
                    });
                    $categorySelect.prop('disabled', false);

                    if (cardType === 'حسم سلبي') {
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

                if (category && category.items && category.items.length > 0) {
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
                } else {
                    $deadlineWrapper.addClass('d-none');
                }
            });
        });
    </script>
@endpush
