@extends("layouts.app")

@section('title')
    @lang('message.list', ['item' => __('message.transfers')])
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
                    <h3 class="card-title"></h3>
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
                        <div class="kt-table-filter-container">
                            <a type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                               data-kt-menu-placement="bottom-end">
                            	<span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
												<path
                                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                    fill="black"/>
											</svg>
										</span>
                                @lang('message.filter')
                            </a>

                            <!-- القائمة -->
                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                <div class="px-7 py-5">
                                    <!-- فلتر Status -->
                                    <div class="mb-10">
                                        <label class="form-label fs-5 fw-bold mb-3">@lang('message.status')</label>
                                        <div class="d-flex flex-column flex-wrap fw-bold">
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                <input class="form-check-input" type="radio" name="status"
                                                       value="@lang('message.all')" checked/>
                                                <span class="form-check-label text-gray-600">@lang('message.all')</span>
                                            </label>
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                <input class="form-check-input" type="radio" name="status"
                                                       value="@lang('message.pending')"/>
                                                <span
                                                    class="form-check-label text-gray-600">@lang('message.pending')</span>
                                            </label>
                                            <label
                                                class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                <input class="form-check-input" type="radio" name="status"
                                                       value="@lang('message.approved')"/>
                                                <span
                                                    class="form-check-label text-gray-600">@lang('message.approved')</span>
                                            </label>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="status"
                                                       value="@lang('message.rejected')"/>
                                                <span
                                                    class="form-check-label text-gray-600">@lang('message.rejected')</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- أزرار -->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                                data-kt-menu-dismiss="true" data-kt-table-filter="reset">Reset
                                        </button>
                                        <button type="button" class="btn btn-primary" data-kt-menu-dismiss="true"
                                                data-kt-table-filter="filter">Apply
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                        <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-25px">@lang('message.sender')</th>
                            <th class="min-w-25px">@lang('message.receiver')</th>
                            <th class="min-w-25px">@lang('message.transfer_points')</th>
                            <th class="min-w-25px">@lang('message.reason_transfer')</th>
                            <th class="min-w-25px">@lang('message.purpose')</th>
                            <th class="min-w-25px">@lang('message.status')</th>
                            <th class="min-w-120px text-center" colspan="1">@lang('message.action')</th>
                        </tr>
                        </thead>
                        <tbody class="fw-bold text-center  text-gray-600">


                        @foreach($transfers as $transfer)

                            <tr>
                                <td>{{$transfer->sender->full_name??$transfer->sender->name}}</td>
                                <td>{{$transfer->receiver->full_name??$transfer->receiver->name}}</td>
                                <td>{{$transfer->amount}}</td>
                                <td>{{$transfer->reason}}</td>
                                <td>@lang('message.'.$transfer->purpose->value)</td>
                                @if($transfer->status === \App\Enum\StatusEnum::Pending)
                                    <td><span
                                            class="badge badge-light-warning"> @lang('message.'.$transfer->status->value)</span>
                                    </td>
                                @elseif($transfer->status === \App\Enum\StatusEnum::Approved)
                                    <td><span
                                            class="badge badge-light-success"> @lang('message.'.$transfer->status->value)</span>
                                    </td>
                                @else
                                    <td><span
                                            class="badge badge-light-danger"> @lang('message.'.$transfer->status->value)</span>
                                    </td>

                                @endif

                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">
                                        @can('approve',$transfer)
                                            <form method="POST"
                                                  action="{{route('transfer.approved',$transfer)}}">
                                                @csrf
                                                @method('put')
                                                <button type="submit"
                                                        class="btn  btn-bg-light btn-active-color-primary  btn-sm  ms-2">
                                                    @lang('message.approve')
                                                </button>
                                            </form>
                                        @endcan
                                        @can('reject',$transfer)
                                            <form method="POST"
                                                  action="{{route('transfer.rejected',$transfer)}}">
                                                @csrf
                                                @method('put')
                                                <button type="submit"
                                                        class="btn  btn-bg-light btn-active-color-primary  btn-sm  ms-2">
                                                    @lang('message.reject')
                                                </button>
                                            </form>
                                        @endcan

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

@endsection

@push("script")
    <script>
        $(document).ready(function () {
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

        })

    </script>

    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset("assets/js/dynamic.js")}}"></script>
    <script src="{{asset("assets/js/custom/apps/customers/add.js")}}"></script>
    <script src="{{asset("assets/js/custom/widgets.js")}}"></script>

@endpush
