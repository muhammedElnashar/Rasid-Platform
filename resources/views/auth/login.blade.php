 <!DOCTYPE html>
<html lang="en" direction="rtl" dir="rtl" style="direction: rtl;">
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{asset("assets/plugins/global/plugins.bundle.rtl.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("assets/css/style.bundle.rtl.css")}}" rel="stylesheet" type="text/css" />
</head>
<style>
    .custom-footer {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-top: 1px solid #e4e6ef;
        font-size: 15px;
        color: #444;
        box-shadow: 0 -2px 6px rgba(0,0,0,0.04);
    }

    .custom-footer .text-primary {
        color: #009ef7 !important; /* لون أزرق أنيق */
    }

    .custom-footer p {
        margin: 0;
    }

    @media (max-width: 768px) {
        .custom-footer {
            font-size: 14px;
            text-align: center;
        }
    }
</style>



<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<body id="kt_body" class="bg-body">
@include('partials.alert')

<div class="d-flex flex-column flex-root">

    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url('assets/media/illustrations/sketchy-1/14.png')">
        <div class="p-10 d-flex flex-center flex-column flex-column-fluid pb-lg-20">
            <div class="logo">
                <img alt="Logo" src="{{asset("3.png")}}" class="h-300px"   />
            </div>

            <div class="p-10 mx-auto rounded shadow-sm w-lg-500px bg-body p-lg-15">
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-10 text-center">
                        <h1 class="mb-3 text-dark">تسجيل الدخول</h1>
                    </div>

                    <!-- اسم المستخدم -->
                    <div class="mb-10 fv-row">
                        <label class="form-label fs-6 fw-bolder text-dark">اسم المستخدم</label>
                        <div class="input-group input-group-lg">
                         <span class="input-group-text bg-light border-0">
                         <i class="bi bi-person-fill"></i>
                        </span>
                            <input name="username" type="text"
                                   class="form-control form-control-solid @error('username') is-invalid @enderror"
                                   value="{{ old('username') }}" required autocomplete="username" autofocus />
                        </div>
                    </div>

                    <!-- كلمة السر -->
                    <div class="mb-10 fv-row">
                        <div class="mb-2 d-flex flex-stack">
                            <label class="mb-0 form-label fw-bolder text-dark fs-6">كلمة السر</label>
                        </div>
                        <div class="input-group input-group-lg">
        <span class="input-group-text bg-light border-0">
            <i class="bi bi-lock-fill text-muted"></i>
        </span>
                            <input type="password" name="password"
                                   class="form-control form-control-solid @error('password') is-invalid @enderror"
                                   autocomplete="off" />
                        </div>
                    </div>

                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" id="kt_sign_in_submit" class="mb-5 btn btn-lg btn-primary w-100">
                            <span class="indicator-label">تسجيل </span>
                            <span class="indicator-progress">Please wait...
									<span class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- الفوتر -->
    <!-- 🌟 Footer -->
    <footer class="custom-footer mt-12 py-6 bg-gray-50 border-t border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 d-flex flex-column flex-md-row justify-content-around align-items-center gap-4">
            <p class="mb-0 text-lg font-semibold text-gray-700 transition-colors duration-300 hover:text-primary">
                جميع الحقوق محفوظة © {{ date('Y') }}
                <span class="text-primary font-bold">نظام راصد التحفيزي</span>
            </p>
            <p class="mb-0 text-base text-gray-600">
                فكرة <span class="font-bold text-gray-800 hover:text-primary transition-colors duration-300">أ. عبدالعزيز حريصي</span>
            </p>
        </div>
    </footer>


</div>

<script>var hostUrl = "assets/";</script>
<script src="{{asset("assets/plugins/global/plugins.bundle.js")}}"></script>
<script src="{{asset("assets/js/scripts.bundle.js")}}"></script>

<script src="{{asset("assets/js/custom/authentication/sign-in/general.js")}}"></script>

</body>
</html>
