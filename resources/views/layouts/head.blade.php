@section('head')
    <?php
        $path = parse_url(url()->current());
        $paths = explode("/", $path['path']);
        $category = $paths[1] ?? '';
    ?>
<header>
    <!-- ローディング画面 -->
    <div id="loading">
        <div class="half-circle-spinner">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            </div>
    </div>
    <div class="w_100p h_70 p_fixed main_color z_99">
        <div class="inner clearfix h_70">
            <div class="float_l left_10">
                <a href="{{ url('/') }}">
                    <h1 class="font_white font_25 h_70 l_height70 font_normal">エマージェ端末管理</h1>
                </a>
            </div>
            <div class="float_r">
                <ul class="text_c d_flex">
                    <!-- @if (Auth::user()->userRole->auth >= 3)
                        @if (strpos($category,'notice') !== false)
                                <li class="w_120 block border_l active">
                        @else
                            <li class="w_120 block border_l">
                        @endif
                            <a class="font_white font_14 block l_height70 textnone" href="{{route('notice')}}">

                                <span class="inblock w_14">
                                    <img class="w_100p" src="/img/news.png" >
                                </span>
                                <span class="font_white">
                                受信一覧
                                </span>
                            </a>
                        </li>
                    @endif -->

                    @if (Auth::user()->userRole->auth > 0)
                        @if (strpos($category,'history')  !== false)
                            <li class="w_120 block border_l active">
                        @else
                            <li class="w_120 block border_l">
                        @endif
                            <a class="font_white font_14 block l_height70 textnone" href="{{route('history')}}">
                                <span class="inblock w_14">
                                    <img class="w_100p" src="/img/history.png" >
                                </span>
                                <span class="font_white">
                                    履歴管理
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->userRole->auth >= 2)
                        @if (strpos($category,'device')  !== false)
                            <li class="w_120 block border_l active">
                        @else
                            <li class="w_120 block border_l">
                        @endif
                            <a class="font_14 block l_height70 textnone" href="{{route('device')}}">
                                <span class="inblock w_14">
                                    <img class="w_100p" src="/img/terminal.png" >
                                </span>
                                <span class="font_white">
                                    端末管理
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->userRole->auth >= 3)
                        @if (strpos($category,'admin')  !== false)
                            <li class="w_120 block border_l active">
                        @else
                            <li class="w_120 block border_l">
                        @endif
                                <a class="font_14 block l_height70 textnone" href="{{route('admin')}}">
                                    <span class="inblock w_14">
                                        <img class="w_100p" src="/img/admin.png" >
                                    </span>
                                    <span class="font_white">
                                    @if (Auth::user()->userRole->auth > 3)
                                        管理者管理
                                    @endif
                                    @if (Auth::user()->userRole->auth == 3)
                                        ユーザー管理
                                    @endif
                                    </span>
                                </a>
                            </li>
                    @endif

                    @if (Auth::user()->userRole->auth >= 2 || Auth::user()->userRole->auth == 0)
                        @if (strpos($category,'company') !== false)
                            <li class="w_120 block border_l active">
                        @else
                            <li class="w_120 block border_l">
                        @endif
                                <a class="font_14 block l_height70 textnone" href="{{route('company')}}">
                                    <span class="inblock w_14">
                                        <img class="w_100p" src="/img/company_info.png" >
                                    </span>
                                    <span class="font_white">
                                    契約先情報
                                    </span>
                                </a>
                            </li>
                    @endif

                    <li class="w_120 block border_l base_color">
                        <a class="font_main font_14 l_height70 textnone" id="logout_btn" href=""
                            onclick="event.preventDefault();
                            //document.getElementById('logout-form').submit();
                            ">
                                {{ __('ログアウト') }}
                        </a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="h_70"></div>
</header>
@endsection
