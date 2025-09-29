@extends("layouts.app")

@section('title')
    طلبات التبديل
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
                                   class="form-control form-control-solid w-250px ps-15"
                                   placeholder="@lang('message.search')"/>
                        </div>

                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                        <tr class=" text-gray-400 fw-bolder text-center fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">الاسم</th>
                            <th class="min-w-50px">اسم الجائزة</th>
                            <th class="min-w-50px">الصوره</th>
                            <th class="min-w-50px">النقاط</th>
                            <th class="min-w-50px">تاريخ الطلب</th>
                            <th class="min-w-50px">حالة الطلب</th>
                            <th class="min-w-120px text-center" colspan="1">@lang('message.action')</th>
                        </tr>
                        </thead>
                        <tbody class="fw-bold text-center   text-gray-600">


                        @foreach($requests as $request)

                            <tr>
                                <td>{{$request->user->full_name}}</td>
                                <td>{{$request->item->name}}</td>
                                <td><img width="50px" height="50px" src="{{Storage::disk('images')->url($request->item->image_url)}}" alt="{{$request->item->name}}"></td>
                                <td>{{$request->item->points_required}}</td>
                                <td>{{$request->request_date}}</td>
                                @if($request->status === \App\Enum\StatusEnum::Approved)
                                    <td><span class="badge badge-light-success">معتمد</span></td>
                                @elseif($request->status === \App\Enum\StatusEnum::Pending)
                                    <td><span class="badge badge-light-warning">قيد الانتظار</span></td>
                                @else
                                    <td><span class="badge badge-light-danger">مرفوض</span></td>
                                @endif

                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">
                                        @can('approve', $request)
                                        <form method="POST"
                                                  action="{{ route('exchange.requests.approved',$request) }}">
                                                @csrf
                                                @method('put')
                                                <button type="submit"
                                                        class="btn  btn-light-success btn-active-color-light  btn-sm  ms-2">
                                                    @lang('message.approve')
                                                </button>
                                            </form>
                                        @endcan
                                        @can('reject', $request)
                                            <form method="POST"
                                                  action="{{ route('exchange.requests.reject',$request) }}">
                                                @csrf
                                                @method('put')
                                                <button type="submit"
                                                        class="btn  btn-light-danger btn-active-color-light  btn-sm  ms-2">
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

    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset("assets/js/dynamic.js")}}"></script>
    <script src="{{asset("assets/js/custom/apps/customers/add.js")}}"></script>
    <script src="{{asset("assets/js/custom/widgets.js")}}"></script>

@endpush
