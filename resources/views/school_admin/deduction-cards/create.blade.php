@extends("layouts.app")

@section('title')
    @lang('message.add', ['item' => __('message.deduction_card')])
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
                            @lang('message.create', ['item' => __('message.deduction_card')])
                        </h1>

                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card card-flush">


                        <div class="card-body pt-6">
                            <form id="kt_modal_add_form" class="form" method="POST"
                                  action="{{route("deduction-cards.store")}}">
                                @csrf



                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.name')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="text" value="{{old("name")}}" class="form-control"
                                               name="name" min="1"
                                               placeholder="@lang('message.enter', ['item' => __('message.name')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.description')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                         <textarea name="description"
                                                   class="form-control"
                                                   rows="3"
                                                   placeholder="@lang('message.enter', ['item' => __('message.description')])"
                                                   autocomplete="off">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.color')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="color" value="{{old("color")}}" class="form-control"
                                               name="color" min="1"
                                               placeholder="@lang('message.enter', ['item' => __('message.corlo')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.threshold')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="number" value="{{old("threshold")}}" class="form-control"
                                               name="threshold" min="1"
                                               placeholder="@lang('message.enter', ['item' => __('message.threshold')])"
                                               autocomplete="off"/>

                                    </div>

                                </div>

                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.type')</span>
                                    </label>

                                    <select name="type" aria-label="Select Type" data-control="select2"
                                            data-placeholder="@lang('message.select', ['item' => __('message.type')])"
                                            class="form-select form-select-solid">
                                        <option
                                            value="">@lang('message.select', ['item' => __('message.type')])</option>
                                        @foreach(\App\Enum\DeductionCardTypeEnum::cases() as $type)
                                            <option
                                                value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                                                @lang('message.'. $type->value)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="fv-row mb-7 d-none" id="deduction_percent_box">
                                    <label class="fs-6 fw-semibold form-label mb-2 ">
                                        <span class="required"> @lang('message.deduction_percent')</span>
                                    </label>

                                    <div class="input-group input-group-solid mb-5">
                                        <input type="number" value="{{ old('deduction_percent', 0) }}"
                                               class="form-control"
                                               id="deduction_percent"
                                               name="deduction_percent" min="0"
                                               placeholder="@lang('message.enter', ['item' => __('message.deduction_percent')])"
                                               autocomplete="off"/>
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
        document.addEventListener("DOMContentLoaded", function () {
            // تأكد إن jQuery متاح (select2 يعتمد عليه عادة)
            if (typeof window.jQuery === 'undefined') {
                console.warn('jQuery غير موجود — إذا كنت تستخدم select2 فعّل jQuery أولاً.');
            }

            var $typeSelect = $("select[name='type']");
            var $deductionBox = $("#deduction_percent_box");
            var $deductionInput = $("#deduction_percent");

            // نص الترجمة لاسم "تنبيه" للمقارنة (إذا قمت بترجمة الاسم في resources)
            var alertLabel = "{{ __('message.alert') }}".trim();

            function shouldHide(selectedVal, selectedText) {
                // اخفاء لو القيمة فارغة أو لو القيمة هي 'alert'
                // او لو نص الخيار يطابق ترجمة 'تنبيه'
                return !selectedVal || selectedVal === "alert" || selectedText === alertLabel;
            }

            function toggleDeduction() {
                var val = $typeSelect.val();
                var txt = $typeSelect.find('option:selected').text().trim();

                if (shouldHide(val, txt)) {
                    $deductionBox.addClass('d-none');
                    $deductionInput.val(0).prop('disabled', true);
                } else {
                    $deductionBox.removeClass('d-none');
                    $deductionInput.prop('disabled', false);
                }
            }

            // نفّذ بعد تأخير صغير لتجنب مشاكل تهيئة select2 قبل الكود
            setTimeout(toggleDeduction, 60);

            // استمع لتغييرات الـselect العادية و أيضاً لحدث select2
            $typeSelect.on('change select2:select select2:unselect', toggleDeduction);
        });
    </script>
@endpush

