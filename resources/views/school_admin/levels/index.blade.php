@extends("layouts.app")

@section('title')
    المستويات
@endsection
@push("css")
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xl">
            <div class="card   mx-auto">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">

                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center position-relative mx-3 my-1">
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

                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            <a href="{{ route('categories.layers.levels.create',[$category,$layer]) }}" class="btn btn-primary" >
                                إضافة مستوي</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                        <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-250px">اسم المستوي</th>
                            <th class="min-w-250px">قيمة الجائزة</th>
                            <th class="min-w-250px">النقاط المطلوبة</th>


                            <th class="min-w-100px text-center" colspan="1">@lang('message.action')</th>
                        </tr>
                        </thead>
                        <tbody class="fw-bold  text-gray-600">


                        @foreach($levels as $level)

                            <tr>
                                <td>{{ $level->name }}</td>
                                <td>{{ $level->reward_value }}</td>
                                <td>{{ $level->points_required }}</td>

                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">
                                        <a href="javascript:void(0)"
                                           class="btn btn-icon btn-bg-light edit-btn btn-active-color-primary btn-sm ms-2"
                                           data-id="{{ $level->id }}"
                                           data-category_id="{{ $category->id}}"
                                           data-layer_id="{{ $layer->id}}"
                                           data-name="{{ $level->name }}"
                                           data-points_required="{{ $level->points_required }}"
                                           data-reward_value="{{ $level->reward_value }}"
                                        >
                                            <span class="svg-icon svg-icon-3">
																				<svg xmlns="http://www.w3.org/2000/svg"
                                                                                     width="24" height="24"
                                                                                     viewBox="0 0 24 24" >
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
                                        <form method="POST" action="{{ route('categories.layers.levels.destroy',[$category,$layer,$level]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary deleted-btn btn-sm ms-2">
                                                                                                <span class="svg-icon svg-icon-3">
																				<svg xmlns="http://www.w3.org/2000/svg"
                                                                                     width="24" height="24"
                                                                                     viewBox="0 0 24 24" >
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
    <div class="modal fade" id="kt_modal_stage_edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>تعديل المستوي</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                        </svg>
                    </span>
                    </div>
                </div>
                <form id="editStageForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-10 px-lg-17">
                        <div class="mb-5 fv-row">
                            <label class="required fs-5 fw-bold mb-2">@lang('message.name')</label>
                            <input type="text" class="form-control form-control-solid" name="name"/>
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required fs-5 fw-bold mb-2">قيمة المكافئة</label>
                            <input type="number" min="1" class="form-control form-control-solid" name="reward_value"/>
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required fs-5 fw-bold mb-2">النقاط المطلوبة</label>
                            <input type="number" min="1" class="form-control form-control-solid" name="points_required"/>
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

        $('.edit-btn').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var categoryId = $(this).data('category_id');
            var layerId = $(this).data('layer_id');
            var pointsRequired = $(this).data('points_required');
            var rewardValue = $(this).data('reward_value');



            var form = $('#editStageForm');
            form.attr('action', '/categories/' + categoryId + '/layers/' + layerId + '/levels/' + id);
            form.find('input[name="name"]').val(name);
            form.find('input[name="points_required"]').val(pointsRequired);
            form.find('input[name="reward_value"]').val(rewardValue);
            var modal = new bootstrap.Modal($('#kt_modal_stage_edit')[0]);
            modal.show();
        });
    </script>

    <script>
        $(document).ready(function () {
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
