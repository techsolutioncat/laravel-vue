@extends('layouts.app')

@include('layouts.head')

@section('title')
    履歴管理
@endsection

@section('content')
    <history-header history_type="setting"></history-header>
    <setting-history-component></setting-history-component>
@endsection


@section('script')
    <script !src="">
    </script>
@endsection


