@extends("layouts.app")

@section('title')
    تعديل سجل
@endsection
@push("css")
@endpush

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar p-3 ">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading text-dark fw-bolder fs-2 my-0">تعديل سجل</h1>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">
                    <div class="card card-flush">
                        <div class="card-body pt-6">
                            <form class="form" method="POST" action="{{ route('logs.update', $log->id) }}">
                                @csrf
                                @method('PUT')

                                {{-- الدور --}}
                                <div class="fv-row mb-7">
                                    <label class="form-label required">@lang('message.role')</label>
                                    <select name="role_id" id="role_id" data-control="select2"
                                            class="form-select form-select-solid">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id', $log->user->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ __('message.'.$role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- المستخدم --}}
                                <div class="fv-row mb-7">
                                    <label class="form-label required">@lang('message.user')</label>
                                    <select name="user_id" id="user_id" data-control="select2"
                                            class="form-select form-select-solid">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id', $log->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->full_name }}
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
                                                {{ (old('card_id', $log->cardItem->category->card->id) == $card->id) ? 'selected' : '' }}>
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






                                {{-- النشاط --}}
                                <div class="fv-row mb-7">
                                    <label class="form-label">نشاط السجل</label><br>
                                    <input type="hidden" name="active" value="0">
                                    <input type="checkbox" name="active" value="1"
                                        {{ old('active', $log->active) ? 'checked' : '' }}>
                                    <span class="ms-2">نشط</span>
                                </div>


                                <div class="text-center pt-15">
                                    <button type="submit" class="btn btn-primary">
                                        تحديث السجل
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
            // بيانات من السيرفر
            let cards = @json($cards);
            let log = @json($log);

            // حاول دعم كلا المفتاحين: cardItem أو card_item
            let logCardItem = log.cardItem ?? log.card_item ?? null;

            let $cardSelect = $('#cardSelect');
            let $categorySelect = $('#categorySelect');
            let $itemSelect = $('#itemSelect');

            // Helper لتحديث select2 لو كانت مُستخدمة
            function refreshSelect($el) {
                // لو تستخدم Select2
                if ($el.hasClass('select2-hidden-accessible')) {
                    $el.trigger('change.select2');
                } else {
                    $el.trigger('change');
                }
            }

            // تهيئة الحالة الافتراضية (معطّل إذا لا بيانات)
            function setInitialDisabledState() {
                if (!$cardSelect.val()) {
                    $categorySelect.prop('disabled', true);
                    $itemSelect.prop('disabled', true);
                }
            }
            setInitialDisabledState();

            // تحميل واظهار البيانات الحالية في الـ form
            function loadExistingData() {
                if (!logCardItem) return;

                let selectedItem = logCardItem;
                let selectedCategory = selectedItem.category ?? selectedItem.card_category ?? null;
                let selectedCard = selectedCategory ? (selectedCategory.card ?? selectedCategory.card_info ?? null) : null;

                // fallback: إذا البيانات في صيغة مختلفة داخل JSON
                if (!selectedCard && selectedCategory && selectedCategory.card_id) {
                    selectedCard = cards.find(c => c.id == selectedCategory.card_id) || null;
                }

                if (selectedCard) {
                    // اختار الكرت
                    $cardSelect.val(selectedCard.id);
                    refreshSelect($cardSelect);

                    // بناء قائمة التصنيفات من cards (تأكد إن الكرت موجود في array)
                    let cardObj = cards.find(c => c.id == selectedCard.id);
                    $categorySelect.empty().append('<option value="">اختر التصنيف</option>');
                    if (cardObj && Array.isArray(cardObj.categories) && cardObj.categories.length) {
                        cardObj.categories.forEach(cat => {
                            let isSelected = (selectedCategory && cat.id == selectedCategory.id) ? 'selected' : '';
                            $categorySelect.append('<option value="'+cat.id+'" '+isSelected+'>'+cat.name+'</option>');
                        });
                        $categorySelect.prop('disabled', false);
                    } else {
                        $categorySelect.prop('disabled', true);
                    }
                    refreshSelect($categorySelect);

                    // عناصر التصنيف
                    if (selectedCategory) {
                        let cat = (cardObj && cardObj.categories) ? cardObj.categories.find(c => c.id == selectedCategory.id) : null;
                        $itemSelect.empty().append('<option value="">اختر العنصر</option>');
                        if (cat && Array.isArray(cat.items) && cat.items.length) {
                            cat.items.forEach(it => {
                                let isSelected = (selectedItem && it.id == selectedItem.id) ? 'selected' : '';
                                $itemSelect.append('<option value="'+it.id+'" '+isSelected+'>'+it.name+' (نقاط: '+it.points+')</option>');
                            });
                            $itemSelect.prop('disabled', false);
                        } else {
                            $itemSelect.prop('disabled', true);
                        }
                        refreshSelect($itemSelect);
                    }
                }
            }

            loadExistingData();

            // عند تغيير الكرت
            $cardSelect.on('change', function () {
                let cardId = $(this).val();
                let card = cards.find(c => c.id == cardId);

                $categorySelect.empty().append('<option value="">اختر التصنيف</option>');
                $itemSelect.empty().append('<option value="">اختر العنصر</option>');

                if (card && Array.isArray(card.categories) && card.categories.length) {
                    card.categories.forEach(cat => {
                        $categorySelect.append('<option value="'+cat.id+'">'+cat.name+'</option>');
                    });
                    $categorySelect.prop('disabled', false);
                } else {
                    $categorySelect.prop('disabled', true);
                    $itemSelect.prop('disabled', true);
                }

                refreshSelect($categorySelect);
                refreshSelect($itemSelect);
            });

            // عند تغيير التصنيف
            $categorySelect.on('change', function () {
                let categoryId = $(this).val();
                let cardId = $cardSelect.val();
                let card = cards.find(c => c.id == cardId);
                let category = card ? card.categories.find(cat => cat.id == categoryId) : null;

                $itemSelect.empty().append('<option value="">اختر العنصر</option>');

                if (category && Array.isArray(category.items) && category.items.length) {
                    category.items.forEach(item => {
                        $itemSelect.append('<option value="'+item.id+'">'+item.name+' (نقاط: '+item.points+')</option>');
                    });
                    $itemSelect.prop('disabled', false);
                } else {
                    $itemSelect.prop('disabled', true);
                }

                refreshSelect($itemSelect);
            });

        });
    </script>
    <script>
        let allUsers = @json($users);

        $(document).ready(function () {
            let userSelect = $('#user_id');
            let currentRoleId = $('#role_id').val();

            // تحديث المستخدمين عند تغيير الدور
            $('#role_id').on('change', function () {
                let roleId = $(this).val();
                userSelect.empty();

                if (roleId) {
                    let filteredUsers = allUsers.filter(u => u.role_id == roleId);

                    filteredUsers.forEach(user => {
                        userSelect.append('<option value="' + user.id + '">' + user.full_name + ' - ' + user.username + '</option>');
                    });

                    userSelect.trigger('change');
                }
            });

            // تحميل المستخدمين للدور الحالي عند فتح الصفحة
            if (currentRoleId) {
                $('#role_id').trigger('change');
                userSelect.val("{{ old('user_id', $log->user_id) }}").trigger('change');
            }
        });
    </script>
@endpush
