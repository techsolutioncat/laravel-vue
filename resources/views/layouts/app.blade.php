<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') |{{ config('app.name', 'Laravel') }}</title>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>

    <!-- Fonts -->

    <link rel="shortcut icon" href="/img/favicon.png" type="image/vnd.microsoft.icon">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @yield('head')
    <main class="py-4">
        @if(session('error'))
        <div class="w_100p p1020">
            <div class="inner p1020">
                    <span class="font_alert font_16">
                        {{session('error') ?? ''}}
                    </span>
                @if(session('error_list'))
                @foreach(session('error_list') as $error)
                <p class="font_alert font_14">{{$error}}</p>
                @endforeach
                @endif
            </div>
        </div>
        @endif

        {{--@if(session('validation'))--}}
        {{--
        <div class="w_100p p1020">--}}
            {{--
            <div class="inner p1020">--}}
                {{-- <p class="font_alert font_14">--}}
                    {{--{{session('validation') ?? ''}}--}}
                    {{--                    </p>--}}
                {{--                </div>
            --}}
            {{--            </div>
        --}}
        {{--@endif--}}

        @error('message')
        <modal-component message="{{$errors->first('message')}}"></modal-component>
        @enderror

        @yield('content')
    </main>
    <div class="pop modal-content pop-box" id="logout-modal" style="width:400px!important;">

        <p class="top_10 bottom_20 text_c">ログアウトしますか？</p>

        <div class="top_20">
            <div class="text_c space">
                <a class="return_btn l_btn space_normal right_5 modal-close">キャンセル</a>
                <a class="details_btn l_btn space_normal left_5"
                   onclick="document.getElementById('logout-form').submit();">OK</a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
@section('scripts')
 <!-- Here you call the select2 js plugin -->
@endsection
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/vue.min.js') }}"></script>
<script src="{{ asset('js/vue-simple-search-dropdown.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
</script>
@yield('script')
</body>
</html>
