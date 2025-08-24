@extends("layouts.app")

@section('title')
    @lang('message.list', ['item' => __('message.teacher-subject-class')])
@endsection
@push("css")
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xl">
            <div class="card ">
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
                            <a href="{{ route('teacher-subject-classes.create') }}" class="btn btn-primary">
                                @lang('message.add',['item' => __('message.teacher-subject-class')])</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                        <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-150px">@lang('message.teacher')</th>
                            <th class="min-w-150px">@lang('message.subject')</th>
                            <th class="min-w-150px">@lang('message.class')</th>


                            <th class="min-w-100px text-center" colspan="1">@lang('message.action')</th>
                        </tr>
                        </thead>
                        <tbody class="fw-bold  text-gray-600">


                        @foreach($teacherSubjectClass as $record)

                            <tr>
                                <td>{{ $record->teacher->username }}</td>
                                <td>{{ $record->subject->name }}</td>
                                <td>{{ $record->class->name }}</td>

                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">
                                        <a href="javascript:void(0)"
                                           class="btn btn-icon btn-bg-light edit-btn btn-active-color-primary btn-sm ms-2"
                                           data-id="{{ $record->id }}"
                                           data-teacher_id="{{ $record->teacher_id }}"
                                           data-subject_id="{{ $record->subject_id }}"
                                           data-class_id="{{ $record->class_id }}">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     width="24" height="24"
                                                     viewBox="0 0 24 24">
                                                    <path opacity="0.3"
                                                          d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                          fill="black"/>
                                                    <path
                                                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                        fill="black"/>
                                                </svg>
                                            </span>
                                        </a>

                                        <!-- زر حذف -->
                                        <form method="POST"
                                              action="{{ route('teacher-subject-classes.destroy',$record) }}">
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

    <!-- Modal with Table -->
    <div class="modal fade" id="kt_modal_teacher_subject_class_edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>@lang('message.edit', ['item' => __('message.teacher-subject-class')])</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <form id="editTeacherSubjectClassForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-10 px-lg-17">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2 ">
                                <span class="required"> @lang('message.teacher')</span>
                            </label>
                            <select name="teacher_id" data-control="select2"
                                    data-placeholder="@lang('message.select', ['item' => __('message.teacher')])"
                                    class="form-select form-select-solid">
                                <option value="">@lang('message.select', ['item' => __('message.teacher')])</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2 ">
                                <span class="required"> @lang('message.subject')</span>
                            </label>
                            <select name="subject_id" data-control="select2"
                                    data-placeholder="@lang('message.select', ['item' => __('message.subject')])"
                                    class="form-select form-select-solid">
                                <option value="">@lang('message.select', ['item' => __('message.subject')])</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2 ">
                                <span class="required"> @lang('message.class')</span>
                            </label>
                            <select name="class_id" data-control="select2"
                                    data-placeholder="@lang('message.select', ['item' => __('message.class')])"
                                    class="form-select form-select-solid">
                                <option value="">@lang('message.select', ['item' => __('message.class')])</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
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
            // حذف
            $('.deleted-btn').click(function (e) {
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

            // تعديل
            $('.edit-btn').on('click', function () {
                var id = $(this).data('id');
                var teacherId = $(this).data('teacher_id');
                var subjectId = $(this).data('subject_id');
                var classId = $(this).data('class_id');

                var form = $('#editTeacherSubjectClassForm');
                form.attr('action', '/teacher-subject-classes/' + id);
                form.find('select[name="teacher_id"]').val(teacherId).trigger('change');
                form.find('select[name="subject_id"]').val(subjectId).trigger('change');
                form.find('select[name="class_id"]').val(classId).trigger('change');

                form.find('select[name="teacher_id"]').select2({
                    dropdownParent: $('#kt_modal_teacher_subject_class_edit'),
                    placeholder: form.find('select[name="teacher_id"]').data('placeholder'),
                    width: '100%'
                });
                form.find('select[name="subject_id"]').select2({
                    dropdownParent: $('#kt_modal_teacher_subject_class_edit'),
                    placeholder: form.find('select[name="subject_id"]').data('placeholder'),
                    width: '100%'
                });
                form.find('select[name="class_id"]').select2({
                    dropdownParent: $('#kt_modal_teacher_subject_class_edit'),
                    placeholder: form.find('select[name="class_id"]').data('placeholder'),
                    width: '100%'
                });

                var modal = new bootstrap.Modal($('#kt_modal_teacher_subject_class_edit')[0]);
                modal.show();
            });
        })
    </script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset("assets/js/dynamic.js")}}"></script>
    <script src="{{asset("assets/js/custom/apps/customers/add.js")}}"></script>
    <script src="{{asset("assets/js/custom/widgets.js")}}"></script>
@endpush
