<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('settings.site_name') }} | Dashboard</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-iconpicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet"
          href="{{ asset('admin/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('admin/assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        var pusherKey = "{{ config('settings.pusher_key') }}";
        var pusherCluster = "{{ config('settings.pusher_cluster') }}";
        var loggedInUserId = "{{ auth()->user()->id }}";
    </script>
    <!-- /END GA -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .error{
            color: red;
        }
    </style>
    @vite('resources/js/app.js')
</head>

<body>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <livewire:layout.admin.sidebar />

{{--        @include('layouts.admin.sidebar')--}}

        <!-- Main Content -->
        <div class="main-content">
            {{$slot}}
            @yield('content')
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; {{ date('Y') }}
                <div class="bullet"></div>
                Developed By <a href="">home</a>
            </div>
            <div class="footer-right">

            </div>
        </footer>
    </div>
</div>
<!-- General JS Scripts -->
<script src="{{ asset('admin/assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/popper.js') }}"></script>
<script src="{{ asset('admin/assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/stisla.js') }}"></script>

{{--<script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>--}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('admin/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<!-- Template JS File -->
<script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>

<script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>
<!-- show dynamic validation message-->
<!-- toaster -->
<!-- select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.tiny.cloud/1/ibjqsfqbq2j50f5cvgx7pc4neteoxtwotttkk9lhqam9rkew/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    window.addEventListener('alert', event => {
        toastr[event.detail[0].types](event.detail[0].message,
            event.detail.title ?? ''), toastr.options = {
            "closeButton": true,
            "progressBar": true,
        }
    });
</script>

<script>
    $(document).ready(function () {

        $('body').on('click', '.delete-item', function (e) {
            e.preventDefault()

            let url = $(this).attr('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{ csrf_token() }}"},
                        success: function (response) {
                            if (response.status === 'success') {
                                toastr.success(response.message)

                                window.location.reload();

                            } else if (response.status === 'error') {
                                toastr.error(response.message)
                            }
                        },
                        error: function (error) {
                            console.error(error);
                        }
                    })
                }
            })
        })

    })

</script>

@stack('scripts')
</body>

</html>
