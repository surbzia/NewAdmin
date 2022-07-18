<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title> Phyllislavelle | ADMIN </title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendors/images/apple-touch-icon.png') }}">
    {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/logo.png') }}"> --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">


    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    </link>
    <link rel="stylesheet" type="text/css" href="/templete/vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="/templete/vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="/templete/plugins/datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/templete/plugins/datatables/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/templete/vendors/styles/style.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

</head>

<body>

    <style>
        .parent {
            height: 200px;
            background: #CCCCCC;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    <div id="app">
        <topbar></topbar>
        <left_nav></left_nav>
        <div class="">
            <div class="mb-15 ml-0 mt-15">
                <router-view />
            </div>
        </div>
    </div>
    </div>
    <!-- js -->
    <script src="/js/app.js"></script>
    <script src="/templete/vendors/scripts/core.js"></script>
    <script src="/templete/vendors/scripts/script.min.js"></script>
    <script src="/templete/vendors/scripts/process.js"></script>
    <script src="/templete/vendors/scripts/layout-settings.js"></script>
    <script src="/templete/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/templete/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="/templete/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="/templete/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="/templete/vendors/scripts/dashboard.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</body>

</html>
