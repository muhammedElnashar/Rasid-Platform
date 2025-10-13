@extends("layouts.app")

@section('title') تعديل مجموعة @endsection

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">

            <div id="kt_app_toolbar" class="app-toolbar p-3">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex mt-5 flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bolder fs-2 flex-column justify-content-center my-0">
                            تعديل مجموعة
                        </h1>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">
                        <div class="card-body pt-6">
                            <form id="kt_modal_edit_form" class="form" method="POST" action="{{ route('groups.update', $group->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- اسم المجموعة --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2">
                                        <span class="required">@lang('message.name')</span>
                                    </label>
                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text"
                                               class="form-control"
                                               name="name"
                                               value="{{ old('name', $group->name) }}"
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
                                        >{{old("description",$group->description)}}</textarea>

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
                                            <option value="{{ $category->id }}" {{(old('category_id',$group->category_id) == $category->id ) ? 'selected' : ''}}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- الأعضاء --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2"><span class="required">الأعضاء</span></label>
                                    <select name="user_id[]" id="members_select" multiple
                                            data-control="select2"
                                            data-placeholder="اختر الأعضاء"
                                            class="form-select form-select-solid">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ in_array($user->id, old('user_id', $group->members->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $user->full_name }} - {{ $user->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- القائد --}}
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2"><span class="required">القائد</span></label>
                                    <select name="leader_id" id="leader_select"
                                            data-control="select2"
                                            data-placeholder="اختر القائد"
                                            class="form-select form-select-solid">
                                        @foreach($users as $user)
                                            @if(in_array($user->id, old('user_id', $group->members->pluck('id')->toArray())))
                                                <option value="{{ $user->id }}"
                                                    {{ old('leader_id', $group->leader_id) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->full_name }} - {{ $user->username }}
                                                </option>
                                            @endif
                                        @endforeach
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
                                <div>
                                    <img src="{{Storage::disk('images')->url($group->image)}} " alt="" width="100px" height="100px">
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
                                <div>
                                    <a href="{{Storage::disk('files')->url($group->file)}}" target="_blank">خارطه العمل</a>
                                </div>
                                <div class="text-center pt-15">
                                    <button type="submit" class="btn btn-primary w-100 w-md-25">
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
            const oldLeader = {!! json_encode(old('leader_id', $group->leader_id)) !!};

            function fillLeaderOptionsFromSelected() {
                let selected = [];

                if (window.jQuery && $(membersSelect).hasClass('select2-hidden-accessible')) {
                    const vals = $(membersSelect).val() || [];
                    selected = vals.map(v => {
                        const opt = membersSelect.querySelector(`option[value="${v}"]`);
                        return opt ? { value: opt.value, text: opt.text } : null;
                    }).filter(Boolean);
                } else {
                    selected = Array.from(membersSelect.selectedOptions).map(o => ({ value: o.value, text: o.text }));
                }

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

                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.text = 'اختر القائد';
                placeholder.disabled = true;
                leaderSelect.appendChild(placeholder);

                selected.forEach(s => {
                    const o = document.createElement('option');
                    o.value = s.value;
                    o.text = s.text;
                    if (oldLeader == s.value) {
                        o.selected = true;
                    }
                    leaderSelect.appendChild(o);
                });

                if (window.jQuery && $(leaderSelect).hasClass('select2-hidden-accessible')) {
                    $(leaderSelect).trigger('change');
                }
            }

            if (window.jQuery && $(membersSelect).select2) {
                $(membersSelect).select2({ width: '100%', placeholder: 'اختر الأعضاء' });
                $(leaderSelect).select2({ width: '100%', placeholder: 'اختر القائد' });
                $(membersSelect).on('change', fillLeaderOptionsFromSelected);
            } else {
                membersSelect.addEventListener('change', fillLeaderOptionsFromSelected);
            }

            fillLeaderOptionsFromSelected();
        });
    </script>
@endpush
