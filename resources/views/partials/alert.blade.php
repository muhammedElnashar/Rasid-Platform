<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            title: 'تم بنجاح',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'حسنًا',
            timer: 1500,
        });

    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: 'خطأ',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'حسنًا',
            timer: 1500,

        });
    </script>
@endif

@if (session('warning'))
    <script>
        Swal.fire({
            title: 'تحذير',
            text: '{{ session('warning') }}',
            icon: 'warning',
            confirmButtonText: 'حسنًا',
            timer: 1500,

        });
    </script>
@endif
@if ($errors->any())
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });

        let errors = @json($errors->all());

        let errorList = "<ul style='margin:0; padding-left:15px; text-align:start'>";
        errors.forEach(error => {
            errorList += `<li style="font-weight:bold;">${error}</li>`;
        });
        errorList += "</ul>";

        Toast.fire({
            icon: 'error',
            title: errorList
        });
    </script>
@endif




<?php
