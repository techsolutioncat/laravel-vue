@extends('layouts.app')

@include('layouts.head')

@section('title')
    端末詳細
@endsection

@section('content')
    <device-detail-component :garbage="true" :message_enabled="{{$message_enabled}}">
    </device-detail-component>
@endsection

@section('script')
    <script !src="">
    </script>
@endsection
