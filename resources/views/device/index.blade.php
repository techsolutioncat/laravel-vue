@extends('layouts.app')
@include('layouts.head')

@section('title')
    端末管理
@endsection

@section('content')
    <device-component is-admin="{{$isAdmin}}" garbage="/device/garbage" excel="true"></device-component>
@endsection


@section('script')
    <script !src="">
    </script>
@endsection