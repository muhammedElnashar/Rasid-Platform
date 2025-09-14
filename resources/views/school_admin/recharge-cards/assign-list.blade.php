@extends("layouts.app")

@section('title')
    @lang('message.list', ['item' => __('message.recharge_cards')])
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

                    </div>

                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                        <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-150px">@lang('message.name')</th>
                            <th class="min-w-150px">@lang('message.username')</th>
                            <th class="min-w-150px">@lang('message.max_uses')</th>
                            <th class="min-w-150px">@lang('message.used_count')</th>
                            <th class="min-w-150px">@lang('message.created_by')</th>


                            <th class="min-w-100px text-center" colspan="1">@lang('message.action')</th>
                        </tr>
                        </thead>
                        <tbody class="fw-bold  text-gray-600">


                        @foreach($assignCards as $card)

                            <tr>
                                <td>{{ $card->user->full_name }}</td>
                                <td>{{ $card->card->code }}</td>
                                <td>{{ $card->max_uses }}</td>
                                <td>{{ $card->used_count }}</td>
                                <td>{{ $card->assigner->full_name }}</td>

                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">


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
    <div class="modal fade" id="kt_modal_card_edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>@lang('message.edit', ['item' => __('message.card')])</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                        </svg>
                    </span>
                    </div>
                </div>
                <form id="editCardForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-10 px-lg-17">
                        <div class="mb-5 fv-row">
                            <label class="required fs-5 fw-bold mb-2">@lang('message.points')</label>
                            <input type="number" min="1" class="form-control form-control-solid" name="points"/>
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
