@extends("layouts.app")

@section('title')
    الاوسمة و الميداليات التي تم ارسالها
@endsection
@push("css")
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xl">
            <div class="card   mt-5">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
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
                    <div class="card-toolbar">


                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead class="text-center">
                        <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">اسم المستخدم </th>
                            <th class="min-w-100px"> الوسام و الميداليه </th>
                            <th class="min-w-100px">قيمة النقاط</th>
                            <th class="min-w-50px">الصورة</th>
                            <th class="min-w-200px">اصدر في </th>

                        </tr>
                        </thead>
                        <tbody class="fw-bold text-center  text-gray-600">


                        @foreach($badges as $badge)

                            <tr>

                                <td>{{ $badge->issued_to->full_name ??$badge->issued_to->name }}</td>
                                <td>{{ $badge->badge->name }}</td>
                                <td>{{ $badge->badge->points_awarded }}</td>
                                <td><img src="{{ $badge->badge->image_url }}" alt="{{ $badge->badge->name }}" width="50px" height="50px"></td>
                                <td>{{ toHijriWithTime($badge->award_date) }}</td>

                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    </div>

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
