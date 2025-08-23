 <!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{asset("assets/plugins/global/plugins.bundle.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("assets/css/style.bundle.css")}}" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="bg-body">
@include('partials.alert')

<div class="d-flex flex-column flex-root">

    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
        <div class="p-10 d-flex flex-center flex-column flex-column-fluid pb-lg-20">
            <div class="mb-12">
                <img alt="Logo" src="{{asset("assets/media/logos/logo-1.svg")}}" class="h-40px" />
            </div>

            <div class="p-10 mx-auto rounded shadow-sm w-lg-500px bg-body p-lg-15">
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-10 text-center">
                        <h1 class="mb-3 text-dark">Sign In </h1>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="form-label fs-6 fw-bolder text-dark">Username</label>
                        <input name="username"  class="form-control form-control-lg form-control-solid @error('username') is-invalid @enderror" value="{{old("username")}}" required autocomplete="username" autofocus  type="text"  />
                    </div>
                    <div class="mb-10 fv-row">
                        <div class="mb-2 d-flex flex-stack">
                            <label class="mb-0 form-label fw-bolder text-dark fs-6">Password</label>

                        </div>

                        <input class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror" type="password" name="password" autocomplete="off" />

                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" id="kt_sign_in_submit" class="mb-5 btn btn-lg btn-primary w-100">
                            <span class="indicator-label">Log in</span>
                            <span class="indicator-progress">Please wait...
									<span class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>var hostUrl = "assets/";</script>
<script src="{{asset("assets/plugins/global/plugins.bundle.js")}}"></script>
<script src="{{asset("assets/js/scripts.bundle.js")}}"></script>

<script src="{{asset("assets/js/custom/authentication/sign-in/general.js")}}"></script>

</body>
</html>
