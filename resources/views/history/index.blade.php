@extends('layouts.app')

@include('layouts.head')

@section('title')
    履歴管理
@endsection

@section('content')
    @if($isAdmin)
    <history-header history_type="device"></history-header>
    @endif
    <history-component></history-component>
@endsection


@section('script')
    <script !src="">
    </script>
@endsection


