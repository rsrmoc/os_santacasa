<!DOCTYPE html>
<html>
<!-- Mirrored from phantom-themes.com/modern/Source/admin1/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 15 Oct 2021 13:55:05 GMT -->

<head>

    <!-- Title -->
    <title>Amaral | Login </title>

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

    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/modern.min.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/green.css') }} " class="theme-color" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css') }} " rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/plugins/3d-bold-navigation/js/modernizr.js') }} "></script>
    <script src="{{ asset('assets/plugins/offcanvasmenueffects/js/snap.svg-min.js') }} "></script>

</head>
<style>
    .form-login{
                position: relative;
                z-index: 1;
                background: #FFFFFF;
                max-width: 380px;
                margin: 0 auto 100px;
                padding: 45px;
                text-align: center;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); 
    }

</style> 
<body class="page-login">
    <main class="page-content">
        <div class="page-inner">
            <div id="main-wrapper"  >
                <div class="row form-login" 
                    <div class="col-md-12 center">
                        <div class="login-box" style="text-align: center;">
                            <img width="100%" src="{{ asset('assets/images/logo_login.png') }}" class=" " />

                            @if ($errors->any())
                                <div class="alert alert-danger text-left">
                                    <h4>Houve alguns erros:</h4>

                                    <ul>
                                        {!! implode('', $errors->all('<li>:message</li>')) !!}
                                    </ul>
                                </div>
                            @endif

                            <form class="m-t-md" style="margin-top: 10px;" action="{{ route('login-action') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email"
                                        required>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Senha"
                                        required>
                                </div>

                                <button type="submit" class="btn btn-info btn-block">Login</button>
                            </form>
                        </div>
                    </div>
                </div><!-- Row -->
            </div><!-- Main Wrapper -->
        </div><!-- Page Inner -->
    </main><!-- Page Content -->

    <!-- Javascripts -->
    <script src="{{ asset('assets/plugins/jquery/jquery-2.1.4.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/pace-master/pace.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/jquery-blockui/jquery.blockui.js') }} "></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/switchery/switchery.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/uniform/jquery.uniform.min.js') }} "></script>
    <script src="{{ asset('assets/plugins/offcanvasmenueffects/js/classie.js') }} "></script>
    <script src="{{ asset('assets/plugins/waves/waves.min.js') }} "></script>
    <script src="{{ asset('assets/js/modern.min.js') }} "></script>

</body>

</html>
