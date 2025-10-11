@extends("layouts.app")

@section('title')
    انشاء مجموعة
@endsection

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class=" d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar p-3 ">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bolder fs-2 flex-column justify-content-center my-0">
                            اضافة مجموعة</h1>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">
                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST" action="{{ route('groups.store') }}"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.name')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{old("name")}}" class="form-control"
                                               name="name"
                                               placeholder="@lang('message.enter', ['item' => __('message.name')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class=""> @lang('message.description')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <textarea class="form-control" name="description"
                                                  placeholder="@lang('message.enter', ['item' => __('message.description')])"
                                        >{{old("description")}}</textarea>

                                    </div>
                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> التصنيف</span>
                                    </label>
                                    <select name="category_id" data-control="select2"
                                            data-placeholder="اختر التصنيف"
                                            class="form-select form-select-solid">
                                        <option value=""></option>

                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- الأعضاء --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2"><span
                                            class="required">الأعضاء</span></label>
                                    <select name="user_id[]" id="members_select" multiple
                                            data-control="select2"
                                            data-placeholder="اختر الأعضاء"
                                            class="form-select form-select-solid">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ in_array($user->id, old('user_id', [])) ? 'selected' : '' }}>
                                                {{ $user->full_name }} - {{ $user->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- القائد (سيتعبّى من الأعضاء المختارين عبر JS) --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2"><span class="required">القائد</span></label>
                                    <select name="leader_id" id="leader_select"
                                            data-control="select2"
                                            data-placeholder="اختر القائد"
                                            class="form-select form-select-solid">
                                        {{-- إذا فيه old input للأعضاء سيتم ملؤها بالـ JS عند التحميل --}}
                                        @if(old('user_id'))
                                            @foreach($users as $user)
                                                @if(in_array($user->id, old('user_id', [])))
                                                    <option
                                                        value="{{ $user->id }}" {{ old('leader_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->full_name }} - {{ $user->username }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required">صورة</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="file" class="form-control"
                                               name="image"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="">خارطه العمل</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="file" class="form-control"
                                               name="file"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="text-center pt-15">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">@lang('message.save')</span>
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
        document.addEventListener('DOMContentLoaded', function () {
            const membersSelect = document.getElementById('members_select');
            const leaderSelect = document.getElementById('leader_select');
            const oldLeader = {!! json_encode(old('leader_id')) !!};

            function fillLeaderOptionsFromSelected() {
                // جمع الأعضاء المختارين بغض النظر إذا كان Select2 مفعل أو لا
                let selected = [];

                if (window.jQuery && $(membersSelect).hasClass('select2-hidden-accessible')) {
                    const vals = $(membersSelect).val() || [];
                    selected = vals.map(v => {
                        const opt = membersSelect.querySelector(`option[value="${v}"]`);
                        return opt ? {value: opt.value, text: opt.text} : null;
                    }).filter(Boolean);
                } else {
                    selected = Array.from(membersSelect.selectedOptions).map(o => ({value: o.value, text: o.text}));
                }

                // تفريغ قائمة القائد
                leaderSelect.innerHTML = '';

                if (selected.length === 0) {
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.text = 'اختر قائداً بعد اختيار الأعضاء';
                    opt.disabled = true;
                    opt.selected = true;
                    leaderSelect.appendChild(opt);
                    if (window.jQuery && $(leaderSelect).hasClass('select2-hidden-accessible')) $(leaderSelect).trigger('change');
                    return;
                }

                // اضافة placeholder
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.text = 'اختر القائد';
                placeholder.disabled = true;
                placeholder.selected = true;
                leaderSelect.appendChild(placeholder);

                // اضافة الخيارات
                selected.forEach(s => {
                    const o = document.createElement('option');
                    o.value = s.value;
                    o.text = s.text;
                    leaderSelect.appendChild(o);
                });

                // اذا فيه قيمة قديمة للقائد نحددها
                if (oldLeader) {
                    leaderSelect.value = oldLeader;
                }

                // تحديث Select2 اذا مفعل
                if (window.jQuery && $(leaderSelect).hasClass('select2-hidden-accessible')) {
                    $(leaderSelect).trigger('change');
                }
            }

            // تهيئة Select2 لو موجود (اختياري — إنما لو موقعك يستخدمه عادة موجود)
            if (window.jQuery && $(membersSelect).select2) {
                $(membersSelect).select2({width: '100%', placeholder: 'اختر الأعضاء'});
                $(leaderSelect).select2({width: '100%', placeholder: 'اختر القائد'});

                // حدث التغيير لselect2
                $(membersSelect).on('change', fillLeaderOptionsFromSelected);
            } else {
                membersSelect.addEventListener('change', fillLeaderOptionsFromSelected);
            }

            // استدعاء أولي لملء القائد في حالة edit أو عند إعادة توجيه بعد خطأ
            fillLeaderOptionsFromSelected();
        });
    </script>
@endpush
