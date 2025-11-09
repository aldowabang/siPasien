<!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-90680653-2');
        </script>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Twitter -->
        <!-- <meta name="twitter:site" content="@bootstrapdash">
        <meta name="twitter:creator" content="@bootstrapdash">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Azia">
        <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template">
        <meta name="twitter:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png"> -->

        <!-- Facebook -->
        <!-- <meta property="og:url" content="https://www.bootstrapdash.com/azia">
        <meta property="og:title" content="Azia">
        <meta property="og:description" content="Responsive Bootstrap 4 Dashboard Template">

        <meta property="og:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
        <meta property="og:image:secure_url" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="600"> -->

        <!-- Meta -->
        <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
        <meta name="author" content="BootstrapDash">

    <title>SI Data Pasien | {{ $title }}</title>

        <!-- vendor css -->
        <link href="{{ asset('Azia/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('Azia/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('Azia/lib/typicons.font/typicons.css') }}" rel="stylesheet">
        <link href="{{ asset('Azia/lib/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
        <link href="{{ asset('Azia/lib/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('Azia/css/custom.cass') }}" rel="stylesheet">
        <link href="{{ asset('my/syle.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- azia CSS -->
        <link rel="stylesheet" href="{{ asset('Azia/css/azia.css') }}">
        <style>
            .breadcrumb {
                background-color: transparent;
                padding: 0;
                margin-bottom: 0;
            }
            .breadcrumb-item {
                font-size: 0.80rem;
            }
            .breadcrumb-item.active {
                color: #6c757d;
            }
            .breadcrumb-item a {
                color: #0b233a;
                text-decoration: none;
            }
            .breadcrumb-item a:hover {
                text-decoration: underline;
            }
            .buttom-radius {
                border-radius: 10px;
            }
            .card-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: transparent;
            }
            .card-title {
                margin-bottom: 0;
            }
            .card {
                padding: 20px;
                range: 5px;
                border-radius: 20px
            }
            .az-dashboard-one-title {
                margin-bottom: 20px;
                font: Roboto, sans-serif;
            }
            .az-dashboard-one-title h2 {
                font-size: 1.5rem;
                margin-bottom: 0;
            }
            .form-control{
                border-radius: 8px;
                padding: 10px;
                font-size: 0.9rem;
            }

            .select2-container .select2-selection--single {
                height: 38px !important; /* sesuaikan tinggi input form-control */
                border: 1px solid #ced4da !important;
                border-radius: 8px !important; /* ini bikin rounded sama */
                padding: 6px 12px !important;
                background-color: #fff !important;
            }

            .form-group label {
                font-weight: bold;
                margin-bottom: 5px;
            }

            .az-header-left{
                display: flex;
                align-items: center;
                font: lemon;
            }

            .az-logo{
                font-size: 1.5rem;
                font-weight: bold;
                font-family: 'Roboto', sans-serif;
                text-transform: uppercase;
                color: #1f28a3;
            }

            .shadow-sm{
                /* Bayangan berwarna biru */
                box-shadow: 0 .125rem .25rem rgba(0, 123, 255, 0.35) !important;
            }
            
        </style>

    </head>