@extends('layouts.app')
@include('layouts.head')

@section('title')
    端末管理（ゴミ箱）
@endsection

@section('content')
    <device-garbage-component></device-garbage-component>
    @include('device.import')
@endsection


@section('script')
    <script !src="">
    </script>
@endsection


