@extends("layouts.app")


@section('title')
    {{ __("message.list", ["item" => __('message.schools')]) }}
@endsection

@push("css")
@endpush

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xl">
            <div class="card   mx-auto" style="border-radius: 25px">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">

                    </div>

                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                        <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">@lang('message.school_name')</th>
                            <th class="min-w-100px">@lang('message.school_admin')</th>
                            <th class="min-w-100px">@lang('message.location')</th>
                            <th class="min-w-100px">@lang('message.email')</th>
                            <th class="min-w-100px">@lang('message.phone')</th>
                            <th class="min-w-100px">@lang('message.ministerial_number')</th>

                            <th class="min-w-100px text-center" colspan="1">@lang('message.action')</th>
                        </tr>
                        </thead>
                        <tbody class="fw-bold  text-gray-600">


                        @foreach($schools as $school)

                            <tr>
                                <td>{{ $school->name }}</td>
                                <td>{{ $school->manager->username }}</td>
                                <td>{{ $school->location }}</td>
                                <td>{{ $school->email }}</td>
                                <td>{{ $school->phone }}</td>
                                <td>{{ $school->ministerial_number }}</td>
                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">

                                        <a href="#" data-bs-target="#kt_modal_school"
                                           data-bs-toggle="modal"
                                           class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm ms-2">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-3">
																				<svg xmlns="http://www.w3.org/2000/svg"
                                                                                     width="24" height="24"
                                                                                     viewBox="0 0 24 24" fill="none">
																					<path opacity="0.3"
                                                                                          d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                          fill="black"/>
																					<path
                                                                                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                        fill="black"/>
																				</svg>
																			</span>
                                            <!--end::Svg Icon-->
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            <!--begin::Modal -->
                            <div class="modal fade" id="kt_modal_school" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <!--begin::Modal header-->
                                        <div class="modal-header" id="kt_modal_create_api_key_header">
                                            <!--begin::Modal title-->
                                            <h2>@lang("message.edit", ["item" => __("message.school")])</h2>
                                            <!--end::Modal title-->
                                            <!--begin::Close-->
                                            <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                 data-bs-dismiss="modal">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                <span class="svg-icon svg-icon-1">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none">
															<rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                                                  rx="1" transform="rotate(-45 6 17.3137)"
                                                                  fill="black"/>
															<rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                                  transform="rotate(45 7.41422 6)" fill="black"/>
														</svg>
													</span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->
                                        <!--begin::Form-->
                                        <form id="kt_modal_create_api_key_form" class="form"
                                              action="{{route("school.update",$school)}}" method="POST">
                                            @csrf
                                            @method("PUT")
                                            <!--begin::Modal body-->
                                            <div class="modal-body py-10 px-lg-17">
                                                <!--begin::Scroll-->
                                                <div class="scroll-y me-n7 pe-7" id="kt_modal_create_api_key_scroll"
                                                     data-kt-scroll="true"
                                                     data-kt-scroll-activate="{default: false, lg: true}"
                                                     data-kt-scroll-max-height="auto"
                                                     data-kt-scroll-dependencies="#kt_modal_create_api_key_header"
                                                     data-kt-scroll-wrappers="#kt_modal_create_api_key_scroll"
                                                     data-kt-scroll-offset="300px">

                                                    <div class="mb-5 fv-row">
                                                        <label
                                                            class="required fs-5 fw-bold mb-2">@lang('message.name')</label>
                                                        <input type="text" class="form-control form-control-solid"
                                                               placeholder="@lang('message.enter', ['item' => __('message.name')])"
                                                               name="name" value="{{$school->name}}"/>
                                                    </div>
                                                    <div class="mb-5 fv-row">
                                                        <label
                                                            class="fs-5 fw-bold mb-2">@lang('message.location')</label>

                                                        <input type="text" class="form-control form-control-solid"
                                                               placeholder="@lang('message.enter', ['item' => __('message.location')])"
                                                               name="location" value="{{$school->location}}"/>
                                                    </div>

                                                    <div class="mb-5 fv-row">
                                                        <label
                                                            class="required fs-5 fw-bold mb-2">@lang('message.email')</label>

                                                        <input type="email" class="form-control form-control-solid"
                                                               placeholder="@lang("message.enter", ["item" => __('message.email')])"
                                                               name="email" value="{{$school->email}}"/>
                                                    </div>

                                                    <div class="mb-5 fv-row">
                                                        <!--begin::Label-->
                                                        <label
                                                            class="required fs-5 fw-bold mb-2">@lang('message.phone')</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid"
                                                               placeholder="@lang('message.enter', ['item' => __('message.phone')])"
                                                               name="phone" value="{{$school->phone}}"/>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="mb-5 fv-row">
                                                        <!--begin::Label-->
                                                        <label
                                                            class="required fs-5 fw-bold mb-2">@lang('message.ministerial_number')</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid"
                                                               placeholder="@lang('message.enter', ['item' => __('message.ministerial_number')])"
                                                               name="ministerial_number" value="{{$school->ministerial_number}}"/>
                                                        <!--end::Input-->
                                                    </div>
                                                    {{--     <!--begin::Input group-->
                                                         <div class="d-flex flex-column mb-5 fv-row">
                                                             <!--begin::Label-->
                                                             <label class="required fs-5 fw-bold mb-2">Short Description</label>
                                                             <!--end::Label-->
                                                             <!--begin::Input-->
                                                             <textarea class="form-control form-control-solid" rows="3" name="description" placeholder="Describe your API"></textarea>
                                                             <!--end::Input-->
                                                         </div>
                                                         <!--end::Input group-->
                                                         <!--begin::Input group-->
                                                         <div class="d-flex flex-column mb-10 fv-row">
                                                             <!--begin::Label-->
                                                             <label class="required fs-5 fw-bold mb-2">Category</label>
                                                             <!--end::Label-->
                                                             <!--begin::Select-->
                                                             <select name="category" data-control="select2" data-hide-search="true" data-placeholder="Select a Category..." class="form-select form-select-solid">
                                                                 <option value="">Select a Category...</option>
                                                                 <option value="1">CRM</option>
                                                                 <option value="2">Project Alice</option>
                                                                 <option value="3">Keenthemes</option>
                                                                 <option value="4">General</option>
                                                             </select>
                                                             <!--end::Select-->
                                                         </div>
                                                         <!--end::Input group-->
                                                         <!--begin::Input group-->
                                                         <div class="mb-10">
                                                             <!--begin::Heading-->
                                                             <div class="mb-3">
                                                                 <!--begin::Label-->
                                                                 <label class="d-flex align-items-center fs-5 fw-bold">
                                                                     <span class="required">Specify Your API Method</span>
                                                                     <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Your billing numbers will be calculated based on your API method"></i>
                                                                 </label>
                                                                 <!--end::Label-->
                                                                 <!--begin::Description-->
                                                                 <div class="fs-7 fw-bold text-muted">If you need more info, please check budget planning</div>
                                                                 <!--end::Description-->
                                                             </div>
                                                             <!--end::Heading-->
                                                             <!--begin::Row-->
                                                             <div class="fv-row">
                                                                 <!--begin::Radio group-->
                                                                 <div class="btn-group w-100" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                                                                     <!--begin::Radio-->
                                                                     <label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success" data-kt-button="true">
                                                                         <!--begin::Input-->
                                                                         <input class="btn-check" type="radio" name="method" value="1" />
                                                                         <!--end::Input-->
                                                                         Open API</label>
                                                                     <!--end::Radio-->
                                                                     <!--begin::Radio-->
                                                                     <label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success active" data-kt-button="true">
                                                                         <!--begin::Input-->
                                                                         <input class="btn-check" type="radio" name="method" checked="checked" value="2" />
                                                                         <!--end::Input-->
                                                                         SQL Call</label>
                                                                     <!--end::Radio-->
                                                                     <!--begin::Radio-->
                                                                     <label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success" data-kt-button="true">
                                                                         <!--begin::Input-->
                                                                         <input class="btn-check" type="radio" name="method" value="3" />
                                                                         <!--end::Input-->
                                                                         UI/UX</label>
                                                                     <!--end::Radio-->
                                                                     <!--begin::Radio-->
                                                                     <label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success" data-kt-button="true">
                                                                         <!--begin::Input-->
                                                                         <input class="btn-check" type="radio" name="method" value="4" />
                                                                         <!--end::Input-->
                                                                         Docs</label>
                                                                     <!--end::Radio-->
                                                                 </div>
                                                                 <!--end::Radio group-->
                                                             </div>
                                                             <!--end::Row-->
                                                         </div>
                                                         <!--end::Input group-->--}}
                                                </div>
                                            </div>
                                            <!--end::Modal body-->
                                            <!--begin::Modal footer-->
                                            <div class="modal-footer flex-center">
                                                <!--begin::Button-->
                                                <button type="reset" id="kt_modal_create_api_key_cancel"
                                                        class="btn btn-light me-3">@lang('message.discard')</button>
                                                <!--end::Button-->
                                                <!--begin::Button-->
                                                <button type="submit" id="kt_modal_create_api_key_submit"
                                                        class="btn btn-primary">
                                                    <span class="indicator-label">@lang("message.submit")</span>
                                                    <span class="indicator-progress">Please wait...
														<span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                                <!--end::Button-->
                                            </div>
                                            <!--end::Modal footer-->
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Modal content-->
                                </div>
                                <!--end::Modal dialog-->
                            </div>

                        @endforeach

                        </tbody>
                    </table>
                    <div class="">

                        {{$schools->links()}}

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal with Table -->
@endsection

@push("script")
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

@endpush
