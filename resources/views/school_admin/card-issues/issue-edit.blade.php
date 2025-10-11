
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

                                {{-- موجه إلى --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">
                                        <span class="required">موجه إلى</span>
                                    </label>
                                    <select name="issued_to_type" id="issued_to_type" class="form-select form-select-solid" data-control="select2"  data-placeholder="اختر نوع المستلم">
                                        <option value="App\Models\User" {{ old('issued_to_type', $issue->issued_to_type) == "App\Models\User" ? 'selected' : '' }}>مستخدم</option>
                                        <option value="App\Models\Group" {{ old('issued_to_type', $issue->issued_to_type) == "App\Models\Group" ? 'selected' : '' }}>مجموعة</option>
                                    </select>
                                </div>
                                {{-- قسم المستخدم --}}
                                <div id="userSection" style="display: none;">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mb-2"><span class="required">@lang('message.role')</span></label>
                                        <select name="role_id" id="role_id" data-control="select2" class="form-select form-select-solid"  data-placeholder="اختر الدور">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id', $issue->user?->role_id) == $role->id ? 'selected' : '' }}>
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
                                                    {{ old('issued_to_id', $issue->issued_to_type == 'App\\Models\\Group' ? $issue->issued_to_id : '') == $group->id ? 'selected' : '' }}>
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
                                                {{ (old('card_id', $issue->cardItem->category->card->id) == $card->id) ? 'selected' : '' }}>
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

                                <div class="fv-row mb-7 d-none " id="restricted" >
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">التقييد</span>
                                    </label>

                                    <div class="input-group  mb-5">
                                        <input type="checkbox" name="is_restricted" value="1" {{ old('is_restricted', $issue->is_restricted) ? 'checked' : '' }}>


                                    </div>

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
            let $restricted       = $('#restricted');

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
                        if (selectedCard.name === 'negative') {
                            $paymentTypeWrap.removeClass('d-none');

                            // إظهار حقل المدة إذا كان النوع مؤجل
                            if (issue.deduction_type === 'deferred') {
                                $deadlineWrapper.removeClass('d-none');
                                $restricted.removeClass('d-none');

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
                $restricted.addClass('d-none');


                if (card && card.categories && card.categories.length > 0) {
                    $.each(card.categories, function (i, cat) {
                        $categorySelect.append('<option value="'+cat.id+'">'+cat.name+'</option>');
                    });
                    $categorySelect.prop('disabled', false);

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
                    $restricted.removeClass('d-none');

                } else {
                    $deadlineWrapper.addClass('d-none');
                    $restricted.addClass('d-none');

                }
            });
        });
    </script>
    <script>
        $(function () {
            // all users preloaded from Blade
            const allUsers = @json($users);

            const currentIssuedToType = @json(old('issued_to_type', $issue->issued_to_type));
            let currentRoleId = @json(old('role_id', null)); // may be null
            const currentUserId = @json(old('issued_to_id', $issue->issued_to_type === 'App\\Models\\User' ? $issue->issued_to_id : null));
            const currentGroupId = @json(old('issued_to_id', $issue->issued_to_type === 'App\\Models\\Group' ? $issue->issued_to_id : null));

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
