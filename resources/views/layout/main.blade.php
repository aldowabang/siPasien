@include('partials.head')
    <body>

        @include('partials.header')

        <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                @yield('content')
            </div><!-- az-content-body -->
        </div>
        </div><!-- az-content -->
@include('partials.footer')