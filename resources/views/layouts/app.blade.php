<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Option 1: CoreUI for Bootstrap CSS -->
    {{--    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.0.0/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-KGkYqG3gD435LMZAC/8byquZiD5665LheNozmHAqp8vrOKBaBL/bFUO5Er5tMRNi" crossorigin="anonymous">--}}
    {{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
    <!-- Option 2: CoreUI PRO for Bootstrap CSS -->


    <link rel="stylesheet" href="css/coreuicss.css">
    <link rel="stylesheet" href="css/simplebar.css">
    <link rel="stylesheet" href="css/simplebar2.css">

    <script src="js/simplebar2.js"></script>
    <script src="js/coreui.js"></script>
    <script src="js/color-mode.js"></script>


    {{--        <script src="https://cdn.jsdelivr.net/npm/@coreui/icons@3.0.1/dist/cjs/index.min.js"></script>--}}
    {{--        <link href="https://cdn.jsdelivr.net/npm/@coreui/icons@3.0.1/css/all.min.css" rel="stylesheet">--}}
    <link href="{{asset('css/style.css')}}" rel="stylesheet">


    {{--    <!-- Latest compiled and minified CSS -->--}}
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">--}}

    {{--    <!-- Latest compiled and minified JavaScript -->--}}
    {{--    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>--}}

    {{--    <!-- (Optional) Latest compiled and minified JavaScript translation files -->--}}
    {{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-*.min.js"></script>--}}


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@v1.14.0-beta2/dist/css/bootstrap-select.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script defer
            src="https://cdn.jsdelivr.net/npm/bootstrap-select@v1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-es_ES.js"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>

</head>
<body>

<div class="sidebar sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <img class="sidebar-brand-full" width="110" height="32" alt="CoreUI Logo" src="{{asset('img/logo1.png')}}">
            <img class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo" src="{{asset('img/logo2.png')}}">
        </div>
        <button class="btn-close d-lg-none" type="button" aria-label="Close"
                onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-title" data-coreui-i18n="theme">Alumnado</li>
        <li class="nav-item"><a class="nav-link" href="{{route('users.index')}}">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-spreadsheet')}}"></use>
                </svg>
                <span data-coreui-i18n="dashboard">General</span></a></li>

        <li class="nav-item"><a class="nav-link" href="{{route('parte.index')}}">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-ban')}}"></use>
                </svg>
                <span data-coreui-i18n="dashboard">Crear Parte</span></a></li>

        <li class="nav-item"><a class="nav-link" href="{{route('parte.resumen')}}">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-balance-scale')}}"></use>
                </svg>
                <span data-coreui-i18n="dashboard">Resumen Incidencias</span></a></li>
        <!-- Gestión para jefatura -->
        <li class="nav-title" data-coreui-i18n="theme">Gestión</li>
        <li class="nav-item"><a class="nav-link" href="{{route('gestion.incidencias')}}">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-sad')}}"></use>
                </svg>
                <span data-coreui-i18n="dashboard">Incidencias</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('gestion.negativas')}}">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-ban')}}"></use>
                </svg>
                <span data-coreui-i18n="dashboard">Conductas Negativas</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('gestion.correcciones')}}">
                <svg class="nav-icon">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-balance-scale')}}"></use>
                </svg>
                <span data-coreui-i18n="dashboard">Correcciones Aplicadas</span></a></li>
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>



<div class="wrapper d-flex flex-column min-vh-100">
    <header class="header header-sticky p-0 mb-4">
        <div class="container-fluid px-4 border-bottom">
            <button id="buttone" class="header-toggler" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
                    style="margin-inline-start: -14px">
                <svg class="icon icon-lg">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
                </svg>
            </button>

            <ul class="header-nav d-none d-md-flex ms-auto">



            </ul>
            <ul class="header-nav ms-auto ms-md-0">


                <li class="nav-item dropdown">
                    <button class="btn btn-link nav-link" type="button" aria-expanded="false"
                            data-coreui-toggle="dropdown">
                        <svg class="icon icon-lg theme-icon-active">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-contrast"></use>
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                        <li>
                            <button class="dropdown-item d-flex align-items-center" type="button"
                                    data-coreui-theme-value="light">
                                <svg class="icon icon-lg me-3">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-sun"></use>
                                </svg>
                                <span data-coreui-i18n="light">Claro</span>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center" type="button"
                                    data-coreui-theme-value="dark">
                                <svg class="icon icon-lg me-3">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-moon"></use>
                                </svg>
                                <span data-coreui-i18n="dark">Oscuro</span>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center active" type="button"
                                    data-coreui-theme-value="auto">
                                <svg class="icon icon-lg me-3">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-contrast"></use>
                                </svg>
                                Automatico
                            </button>
                        </li>
                    </ul>
                </li>
                <li class="nav-item py-1">
                    <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
                </li>
                <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#"
                                                 role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md"><img class="avatar-img" src="{{asset('img/user.png')}}"
                                                           alt="user@email.com"></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2"
                             data-coreui-i18n="account">Cuenta
                        </div>
                        <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg class="icon me-2">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                            </svg>
                            <span data-coreui-i18n="logout">Cerrar Session</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <div class="body flex-grow-1">
        <div class="container-lg px-4">
            @yield('content')
        </div>
    </div>
</div>



@stack('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'data-coreui-theme') {
                    if ($('html').attr('data-coreui-theme') === 'dark') {
                        $('.sidebar-brand-full').attr('src', '{{asset("img/logo_dark.png")}}');
                    } else {
                        $('.sidebar-brand-full').attr('src', '{{asset("img/logo1.png")}}');
                    }
                }
            });
        });

        observer.observe(document.documentElement, { attributes: true });

        if ($('html').attr('data-coreui-theme') === 'dark') {
            $('.sidebar-brand-full').attr('src', '{{asset("img/logo_dark.png")}}');
        } else {
            $('.sidebar-brand-full').attr('src', '{{asset("img/logo1.png")}}');
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.bootstrap-select').each(function () {
            $(this).find('button:first').removeClass().addClass('form-select text-start').css('padding-left', '9px');
        });

        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'data-coreui-theme') {
                    if ($('html').attr('data-coreui-theme') === 'dark') {
                        $('.bootstrap-select button:not(:first)').removeClass('btn-light').addClass('btn-dark');
                    } else {
                        $('.bootstrap-select button:not(:first)').removeClass('btn-dark').addClass('btn-light');
                    }
                }
            });
        });

        observer.observe(document.documentElement, {attributes: true});

        if ($('html').attr('data-coreui-theme') === 'dark') {
            $('.bootstrap-select button:not(:first)').removeClass('btn-light').addClass('btn-dark');
        } else {
            $('.bootstrap-select button:not(:first)').removeClass('btn-dark').addClass('btn-light');
        }
    });
    $('#buttone').on('click', function () {

        if ($(window).width() >= 992) {
            $('.dataTables_scrollHeadInner').attr('style', 'width: 100% !important;');
        }

    });




</script>
</body>
</html>





