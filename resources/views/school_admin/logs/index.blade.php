                @extends("layouts.app")

                @section('title')
                    السجلات
                @endsection
                @push("css")
                    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
                @endpush

                @section('content')
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid">
                            <div class="card mt-5 ">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center position-relative ">
                                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24">
                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                          height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                          fill="black"/>
                                                    <path
                                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                        fill="black"/>
                                                </svg>
                                            </span>
                                            <input type="text" data-kt-customer-table-filter="search"
                                                   class="form-control form-control-solid w-200px ps-15"
                                                   placeholder="@lang('message.search')"/>
                                        </div>

                                    </div>
                                    <div class="card-toolbar">
                                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                            <a class="btn btn-primary" href="{{ route('logs.create') }}">
                                                اصدار سجل جدبد
                                               </a>

                                        </div>

                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                        <thead class="text-center">
                                        <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-50px">رقم السجل</th>
                                            <th class="min-w-100px">المستخدم</th>
                                            <th class="min-w-100px">بواسطة</th>
                                            <th class="min-w-50px">النوع</th>
                                            <th class="min-w-50px">التصنيف</th>
                                            <th class="min-w-50px">البند</th>
                                            <th class="min-w-10px">النقاط</th>
                                            <th class="min-w-70px">حاله السجل</th>
                                            <th class="min-w-25px">الحالة</th>
                                            <th class="min-w-200px">اصدر في </th>
                                            <th class="min-w-120px text-center" colspan="1">@lang('message.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody class="fw-bold text-center  text-gray-600">


                                        @foreach($logs as $log)

                                            <tr>
                                                <td>{{$log->issue_number}}</td>
                                                <td>{{$log->issuedTo->full_name ?? $log->issuedTo->name}}</td>
                                                <td>{{$log->issuedBy->full_name}}</td>
                                                <td>{{$log->cardItem->category->card->name->label()}}</td>
                                                <td>{{$log->cardItem->category->name}}</td>
                                                <td>{{$log->cardItem->name}}</td>
                                                <td>{{$log->points_value}}</td>
                                                @if($log->active === true)
                                                    <td><span class="badge badge-success">نشط</span></td>
                                                @else
                                                    <td><span class="badge badge-danger">غير نشط</span></td>
                                                @endif
                                                @if($log->status === \App\Enum\StatusEnum::Approved)
                                                    <td><span class="badge badge-light-success">معتمد</span></td>
                                                @elseif($log->status === \App\Enum\StatusEnum::Pending)
                                                    <td><span class="badge badge-light-warning">قيد الانتظار</span></td>
                                                @else
                                                    <td><span class="badge badge-light-danger">مرفوض</span></td>
                                                @endif
                                                <td>{{toHijriWithTime($log->log_date)}}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center flex-shrink-0">
                                                        @if($log->status === \App\Enum\StatusEnum::Pending)
                                                        <a href="{{ route('logs.edit', $log->id) }}"
                                                           class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm ms-2">
    <span class="svg-icon svg-icon-3">
        <!-- أيقونة القلم -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24">
            <path opacity="0.3"
                  d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303Z"
                  fill="black"/>
            <path
                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                fill="black"/>
        </svg>
    </span>
                                                        </a>
                                                        <form method="POST" action="{{ route('logs.destroy',$log) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-icon btn-bg-light btn-active-color-primary deleted-btn btn-sm ms-2">
                                                                                                                <span
                                                                                                                    class="svg-icon svg-icon-3">
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
                                                        @endif

                                                        @can('approve',$log)
                                                        <form method="POST"
                                                              action="{{ route('logs.approve',$log) }}">
                                                            @csrf
                                                            @method('put')
                                                            <button type="submit"
                                                                    class="btn  btn-bg-light btn-active-color-primary  btn-sm  ms-2">
                                                                @lang('message.approve')
                                                            </button>
                                                        </form>
                                                        @endcan
                                                            @can('reject',$log)
                                                        <form method="POST"
                                                              action="{{ route('logs.reject',$log) }}">
                                                            @csrf
                                                            @method('put')
                                                            <button type="submit"
                                                                    class="btn  btn-bg-light btn-active-color-primary  btn-sm  ms-2">
                                                                @lang('message.reject')
                                                            </button>
                                                        </form>
                                                        @endcan
                                                            @can('activation',$log)
                                                        <form method="POST" action="{{ route('activation.logs', $log) }}">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="btn btn-sm text-white ms-2 {{ $log->active ? 'btn-danger' : 'btn-success' }}">
                                                                {{ $log->active ? 'تعطيل' : 'تفعيل' }}
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
