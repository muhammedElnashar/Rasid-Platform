@extends('layouts.app')
@section('title')
    @lang('message.list', ['item' => __('message.student_guardian')])
@endsection
@push('css')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>

@endpush
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                              height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                              fill="black"/>
														<path
                                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                            fill="black"/>
													</svg>
                            </span>
                            <input type="text" data-kt-customer-table-filter="search"
                                   class="form-control form-control-solid w-250px ps-15"
                                   placeholder="@lang('message.search')"/>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            {{--      <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                                          data-kt-menu-placement="bottom-end">
                                      <span class="svg-icon svg-icon-2">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                               viewBox="0 0 24 24" fill="none">
                                                              <path
                                                                  d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                                  fill="black"/>
                                                          </svg>
                                      </span>
                                      Filter
                                  </button>
                                  <!--begin::Menu 1-->
                                  <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true"
                                       id="kt-toolbar-filter">
                                      <!--begin::Header-->
                                      <div class="px-7 py-5">
                                          <div class="fs-4 text-dark fw-bolder">Filter Options</div>
                                      </div>
                                      <!--end::Header-->
                                      <!--begin::Separator-->
                                      <div class="separator border-gray-200"></div>
                                      <!--end::Separator-->
                                      <!--begin::Content-->
                                      <div class="px-7 py-5">

                                          <!--begin::Input group-->
                                          <div class="mb-10">
                                              <!--begin::Label-->
                                              <label class="form-label fs-5 fw-bold mb-3">Payment Type:</label>
                                              <!--end::Label-->
                                              <!--begin::Options-->
                                              <div class="d-flex flex-column flex-wrap fw-bold"
                                                   data-kt-customer-table-filter="payment_type">
                                                  <!--begin::Option-->
                                                  <label
                                                      class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                      <input class="form-check-input" type="radio" name="payment_type"
                                                             value="all" checked="checked"/>
                                                      <span class="form-check-label text-gray-600">All</span>
                                                  </label>
                                                  <!--end::Option-->
                                                  <!--begin::Option-->
                                                  <label
                                                      class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                      <input class="form-check-input" type="radio" name="payment_type"
                                                             value="visa"/>
                                                      <span class="form-check-label text-gray-600">Visa</span>
                                                  </label>
                                                  <!--end::Option-->
                                                  <!--begin::Option-->
                                                  <label
                                                      class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                      <input class="form-check-input" type="radio" name="payment_type"
                                                             value="mastercard"/>
                                                      <span class="form-check-label text-gray-600">Mastercard</span>
                                                  </label>
                                                  <!--end::Option-->
                                                  <!--begin::Option-->
                                                  <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                      <input class="form-check-input" type="radio" name="payment_type"
                                                             value="american_express"/>
                                                      <span class="form-check-label text-gray-600">American Express</span>
                                                  </label>
                                                  <!--end::Option-->
                                              </div>
                                              <!--end::Options-->
                                          </div>
                                          <!--end::Input group-->
                                          <!--begin::Actions-->
                                          <div class="d-flex justify-content-end">
                                              <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                                      data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset
                                              </button>
                                              <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                                      data-kt-customer-table-filter="filter">Apply
                                              </button>
                                          </div>
                                          <!--end::Actions-->
                                      </div>
                                      <!--end::Content-->
                                  </div>
      --}}
                            <a href="{{ route('student-guardian.create') }}"
                               class="btn btn-primary">@lang('message.add',['item' => __('message.student_guardian')])</a>

                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">@lang('message.student')</th>
                            <th class="min-w-125px">@lang('message.student_guardian')</th>
                            <th class="min-w-125px">@lang('message.relationship')</th>
                            <th class="text-center min-w-70px">@lang('message.action')</th>
                        </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                        @foreach($studentGuardians as $studentGuardian)
                            <tr>
                                <td>{{ $studentGuardian->student->username }}</td>
                                <td>{{ $studentGuardian->guardian->username }}</td>
                                <td>{{ __('message.'. $studentGuardian->relationship)  }}</td>
                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">

                                        <a href="javascript:void(0)"
                                           class="btn btn-icon btn-bg-light edit-btn btn-active-color-primary btn-sm ms-2"
                                           data-id="{{ $studentGuardian->id }}"
                                           data-student_id="{{ $studentGuardian->student_id }}"
                                           data-guardian_id="{{ $studentGuardian->guardian_id }}"
                                           data-relationship="{{ $studentGuardian->relationship }}"
                                        >
                                            <span class="svg-icon svg-icon-3">
                                                <svg
                                                                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                                                                            width="24"
                                                                                                                            height="24"
                                                                                                                            viewBox="0 0 24 24">
                                                                                                                            <path
                                                                                                                                opacity="0.3"
                                                                                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                                                                fill="black"/>
                                                                                                                            <path
                                                                                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                                                                fill="black"/>
                                                                                                                        </svg>
                                            </span>
                                        </a>


                                        <form method="POST"
                                              action="{{ route('student-guardian.destroy', $studentGuardian->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary deleted-btn btn-sm ms-2">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         width="24" height="24"
                                                         viewBox="0 0 24 24">
																					<path
                                                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                        fill="black"/>
																					<path opacity="0.5"
                                                                                          d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                          fill="black"/>
																					<path opacity="0.5"
                                                                                          d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                          fill="black"/>
																				</svg>
                                                </span>

                                            </button>
                                        </form>


                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

        <div class="modal fade" id="kt_modal_student_guardian_edit" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>@lang('message.edit', ['item' => __('message.student_guardian')])</h2>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                            </svg>
                        </span>
                        </div>
                    </div>
                    <form id="editStudentGuardianForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body py-10 px-lg-17">

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mb-2 ">
                                    <span class="required"> @lang('message.student')</span>
                                </label>

                                <select name="student_id" aria-label="Select Type"  data-control="select2"
                                        data-placeholder="@lang('message.select', ['item' => __('message.student')])"
                                        class="form-select form-select-solid">
                                    <option value="">@lang('message.select', ['item' => __('message.student')])</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->username }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mb-2 ">
                                    <span class="required"> @lang('message.guardian')</span>
                                </label>

                                <select name="guardian_id" aria-label="Select Type"  data-control="select2"
                                        data-placeholder="@lang('message.select', ['item' => __('message.guardian')])"
                                        class="form-select form-select-solid">
                                    <option value="">@lang('message.select', ['item' => __('message.guardian')])</option>
                                    @foreach($guardians as $guardian)
                                        <option value="{{ $guardian->id }}" {{ old('guardian_id') == $guardian->id ? 'selected' : '' }}>
                                            {{ $guardian->username }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mb-2 ">
                                    <span class="required"> @lang('message.relationship')</span>
                                </label>
                                <select name="relationship" aria-label="Select Type" data-control="select2"
                                        data-placeholder="@lang('message.select', ['item' => __('message.relationship')])"
                                        class="form-select form-select-solid">

                                    <option value="">@lang('message.select', ['item' => __('message.relationship')])</option>

                                    <option value="father" {{ old('relation') == 'father' ? 'selected' : '' }}>
                                        @lang('message.father')
                                    </option>

                                    <option value="mother" {{ old('relation') == 'mother' ? 'selected' : '' }}>
                                        @lang('message.mother')
                                    </option>


                                </select>

                            </div>

                        </div>

                        <div class="modal-footer flex-center">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">@lang('message.discard')</button>
                            <button type="submit" class="btn btn-primary">@lang("message.submit")</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


@endsection
@push("script")
    <script>
        $(document).ready(function () {
            $('.edit-btn').on('click', function() {
                var id = $(this).data('id');
                var studentId = $(this).data('student_id');
                var guardianId = $(this).data('guardian_id');
                var relationship = $(this).data('relationship');

                var form = $('#editStudentGuardianForm');
                form.attr('action', '/student-guardian/' + id);
                form.find('select[name="student_id"]').val(studentId).trigger('change');
                form.find('select[name="guardian_id"]').val(guardianId).trigger('change');
                form.find('select[name="relationship"]').val(relationship).trigger('change');

                form.find('select[name="student_id"]').select2({
                    dropdownParent: $('#kt_modal_student_guardian_edit'),
                    placeholder: form.find('select[name="student_id"]').data('placeholder'),
                    width: '100%'
                });
                form.find('select[name="guardian_id"]').select2({
                    dropdownParent: $('#kt_modal_student_guardian_edit'),
                    placeholder: form.find('select[name="guardian_id"]').data('placeholder'),
                    width: '100%'
                });
                form.find('select[name="relationship"]').select2({
                    dropdownParent: $('#kt_modal_student_guardian_edit'),
                    placeholder: form.find('select[name="relationship"]').data('placeholder'),
                    width: '100%'
                });

                var modal = new bootstrap.Modal($('#kt_modal_student_guardian_edit')[0]);
                modal.show();
            });

            $(`.deleted-btn`).click(function (e) {
                let form = $(this).parents('form');
                e.preventDefault();
                Swal.fire({
                    title: "{{ __('message.are_you_sure') }}",
                    text: "{{ __('message.you_will_not_be_able_to_recover_this') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "{{ __('message.no_cancel') }}",
                    confirmButtonText: "{{ __('message.yes_delete') }}"

                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

        })

    </script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset("assets/js/dynamic.js")}}"></script>
    <script src="{{asset("assets/js/custom/apps/customers/add.js")}}"></script>
    <script src="{{asset("assets/js/custom/widgets.js")}}"></script>
@endpush
