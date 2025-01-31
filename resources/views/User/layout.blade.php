@include('User.head')

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    @include('User.header')

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    @include('User.slider')

    <!-- Latest Products Section -->
    @yield('latest')
    {{-- @include('User.body') --}}

    {{-- Other includes can be uncommented if needed --}}
    {{-- @include('User.latest') --}}
    {{-- @include('User.body') --}}

    @include('User.footer')

</body>