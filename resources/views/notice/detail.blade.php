@extends('layouts.app')

@include('layouts.head')

@section('title')
    受信一覧詳細
@endsection

@section('content')
    <div class="inner">
        <section class="top_20 bottom_20">
            <h2 class="font_20 border_title p_left10 l_height20">受信一覧詳細</h2>
        </section>
    </div>
    <history-detail-component :parent="'notice'">
    </history-detail-component>
@endsection

@section('script')
    <script !src="">
    </script>
@endsection
