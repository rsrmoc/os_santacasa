<!DOCTYPE html>
<html>
<head></head>
    <title>Amaral</title>

    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta charset="UTF-8">
    <meta name="description" content="Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <!-- Styles -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

    <link href="{{ asset('assets/plugins/pace-master/themes/blue/pace-theme-flash.css') }} " rel="stylesheet" />
    <link href="{{ asset('assets/plugins/uniform/css/uniform.default.min.css') }} " rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/fontawesome/css/font-awesome.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/line-icons/simple-line-icons.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css') }} " rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/waves/waves.min.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/switchery/switchery.min.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/3d-bold-navigation/css/style.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet"
        type="text/css" />


    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/modern.min.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/green.css') }} " class="theme-color" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css') }} " rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/plugins/3d-bold-navigation/js/modernizr.js') }} "></script>
    <script src="{{ asset('assets/plugins/offcanvasmenueffects/js/snap.svg-min.js') }} "></script>

    <link href="{{ asset('assets/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Jquery -->
    <script src="{{ asset('assets/plugins/jquery/jquery-2.1.4.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/3d-bold-navigation/js/modernizr.js') }} "></script>
    <script src="{{ asset('assets/plugins/offcanvasmenueffects/js/snap.svg-min.js') }} "></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }} "></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }} "></script>
</head>

<body class="page-header-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">

        <!-- header-->
        <x-layout.header />
        <!-- header-->

        <div class="page-inner">

            <!-- conteudo da pagina -->
            {{ $slot }}
            <!-- conteudo da pagina -->

            <div class="page-footer">
                <p class="no-s">2023 &copy; RPclinic</p>
            </div>

        </div>

    </main>

    <!-- footer-->
    <x-layout.footer />
    <!-- footer-->

    @if(isset($scripts))
        {{ $scripts }}
    @endif

    @if (session()->has('success'))
        <script>
            toastr["success"]("{{ session('success') }}");
        </script>
    @endif

    @if ($errors->any())
        <script>
            toastr["error"]("{{ $errors->first() }}");
        </script>
    @endif
</body>

</html>
