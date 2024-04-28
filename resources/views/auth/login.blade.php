@extends('layouts.app')

@include('auth.head')

@section('title')
    ログイン
@endsection

@section('content')
<main class="text_c top_50">

    <div class="w_230 auto p2020 border_ccc">
        <form method="POST" action="/login">
            @csrf
            <div class="bottom_10">
                <span class="right_5">{{ __('ログインID') }}</span>
                <input id="login_id" type="text" name="login_id" class="w_110 form-control @error('login_id') is-invalid @enderror">

            </div>
            <div>
                <span class="right_5">{{ __('パスワード') }}</span>
                <input id="password" type="password" name="password" class="w_110 form-control @error('password') is-invalid @enderror">
            </div>
            <div class="top_20">
                <button type="submit" class="l_btn create_btn">
                    {{ __('ログイン') }}
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
