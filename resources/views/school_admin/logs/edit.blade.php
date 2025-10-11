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


                                {{-- موجه إلى --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">
                                        <span class="required">موجه إلى</span>
                                    </label>
                                    <select name="issued_to_type" id="issued_to_type" class="form-select form-select-solid" data-control="select2"  data-placeholder="اختر نوع المستلم">
                                        <option value="App\Models\User" {{ old('issued_to_type', $log->issued_to_type) == "App\Models\User" ? 'selected' : '' }}>مستخدم</option>
                                        <option value="App\Models\Group" {{ old('issued_to_type', $log->issued_to_type) == "App\Models\Group" ? 'selected' : '' }}>مجموعة</option>
                                    </select>
                                </div>
                                {{-- قسم المستخدم --}}
                                <div id="userSection" style="display: none;">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mb-2"><span class="required">@lang('message.role')</span></label>
                                        <select name="role_id" id="role_id" data-control="select2" class="form-select form-select-solid"  data-placeholder="اختر الدور">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id', $log->user?->role_id) == $role->id ? 'selected' : '' }}>
                                                    {{ __('message.'.$role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mb-2"><span class="required">@lang('message.user')</span></label>
                                        <select name="issued_to_id" id="user_id" data-control="select2" class="form-select form-select-solid"  data-placeholder="اختر المستخدم">
                                        </select>
                                        @error('issued_to_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- قسم المجموعة --}}
                                <div id="groupSection" style="display: none;">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mb-2"><span class="required">المجموعة</span></label>
                                        <select name="issued_to_id" id="group_id" data-control="select2" class="form-select form-select-solid"  data-placeholder="اختر المجموعه">
                                            @foreach($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ old('issued_to_id', $log->issued_to_type == 'App\\Models\\Group' ? $log->issued_to_id : '') == $group->id ? 'selected' : '' }}>
                                                    {{ $group->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('issued_to_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
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
                                            <option value="{{ $card->id }}" data-type="{{ $card->name }}"
                                                {{ (old('card_id', $log->cardItem->category->card->id) == $card->id) ? 'selected' : '' }}>
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

            // Helpers لتحديث select2 لو كانت مُستخدمة
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
        $(function () {
            // all users preloaded from Blade
            const allUsers = @json($users);

            const currentIssuedToType = @json(old('issued_to_type', $log->issued_to_type));
            let currentRoleId = @json(old('role_id', null)); // may be null
            const currentUserId = @json(old('issued_to_id', $log->issued_to_type === 'App\\Models\\User' ? $log->issued_to_id : null));
            const currentGroupId = @json(old('issued_to_id', $log->issued_to_type === 'App\\Models\\Group' ? $log->issued_to_id : null));

            // DOM
            const $issuedToType = $('#issued_to_type');
            const $userSection = $('#userSection');
            const $groupSection = $('#groupSection');
            const $roleSelect = $('#role_id');
            const $userSelect = $('#user_id');
            const $groupSelect = $('#group_id');

            // show/hide user/group sections (use endsWith to avoid backslash issues)
            function toggleIssuedToSections(type) {
                if (!type) {
                    $userSection.hide();
                    $groupSection.hide();
                    $userSelect.prop('disabled', true).prop('name', '');
                    $groupSelect.prop('disabled', true).prop('name', '');
                    return;
                }
                if (String(type).endsWith('User')) {
                    $userSection.show();
                    $groupSection.hide();
                    $userSelect.prop('disabled', false).prop('name', 'issued_to_id');
                    $groupSelect.prop('disabled', true).prop('name', '');
                } else if (String(type).endsWith('Group')) {
                    $groupSection.show();
                    $userSection.hide();
                    $groupSelect.prop('disabled', false).prop('name', 'issued_to_id');
                    $userSelect.prop('disabled', true).prop('name', '');
                } else {
                    $userSection.hide();
                    $groupSection.hide();
                    $userSelect.prop('disabled', true).prop('name', '');
                    $groupSelect.prop('disabled', true).prop('name', '');
                }
            }

            // fill users select by role (and optionally select a specific user)
            function filterUsersByRole(roleId, selectedUserId = null) {
                $userSelect.empty().append('<option value="">اختر المستخدم</option>');
                if (!roleId) {
                    if (typeof $userSelect.select2 === 'function') $userSelect.trigger('change.select2');
                    else $userSelect.trigger('change');
                    return;
                }

                const filtered = allUsers.filter(u => String(u.role_id) === String(roleId));
                filtered.forEach(u => {
                    const $opt = $('<option>').val(u.id).text(u.full_name + ' - ' + u.username);
                    if (selectedUserId && String(u.id) === String(selectedUserId)) $opt.prop('selected', true);
                    $userSelect.append($opt);
                });

                // trigger select2 or plain change
                if (typeof $userSelect.select2 === 'function') $userSelect.trigger('change.select2');
                else $userSelect.trigger('change');
            }

            // events
            $issuedToType.on('change', function () {
                toggleIssuedToSections($(this).val());
            });

            $roleSelect.on('change', function () {
                // when user changes role manually, we don't want to keep previous selected user by default
                const roleVal = $(this).val();
                filterUsersByRole(roleVal, null);
            });

            // --- Initialization on page load ---
            // 1) ensure issued_to_type select matches server value (if Blade didn't set the select value)
            if (currentIssuedToType && !$issuedToType.val()) {
                $issuedToType.val(currentIssuedToType);
                if (typeof $issuedToType.select2 === 'function') $issuedToType.trigger('change.select2');
            }

            // 2) show correct section immediately
            toggleIssuedToSections($issuedToType.val() || currentIssuedToType);

            // 3) If issuedToType is User, ensure role is set.
            if (String($issuedToType.val() || currentIssuedToType).endsWith('User')) {
                // If role not provided from server, try to infer from selected user
                if (!currentRoleId && currentUserId) {
                    const userObj = allUsers.find(u => String(u.id) === String(currentUserId));
                    if (userObj && userObj.role_id) {
                        currentRoleId = userObj.role_id;
                    }
                }

                // set roleSelect value (either server-provided or inferred)
                if (currentRoleId) {
                    $roleSelect.val(currentRoleId);
                    if (typeof $roleSelect.select2 === 'function') $roleSelect.trigger('change.select2');
                }

                // now populate users for that role and select current user
                if (currentRoleId) {
                    filterUsersByRole(currentRoleId, currentUserId);
                } else {
                    // if still no role, just clear users
                    $userSelect.empty().append('<option value="">اختر المستخدم</option>');
                    if (typeof $userSelect.select2 === 'function') $userSelect.trigger('change.select2');
                }
            }

            // 4) If issuedToType is Group -> select current group
            if (String($issuedToType.val() || currentIssuedToType).endsWith('Group')) {
                if (currentGroupId) {
                    $groupSelect.val(currentGroupId);
                    if (typeof $groupSelect.select2 === 'function') $groupSelect.trigger('change.select2');
                }
            }

            // Debug logs (إزالة في الإنتاج إذا أردت)
            // console.log({ currentIssuedToType, currentRoleId, currentUserId, currentGroupId });
        });
    </script>
@endpush
