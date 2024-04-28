@extends('layouts.app')

@include('layouts.head')

@section('title')
    端末履歴詳細
@endsection

@section('content')
    <history-header history_type="device"></history-header>
    <message-component></message-component>
@endsection

@section('script')
    <script !src="">
    </script>
@endsection
