@extends('layouts.app')

@include('layouts.head')


@section('title')
    会社管理
@endsection

@section('content')
    <div class="inner"><company-header company_name="{{$company_name}}" company_id="{{$company_id}}" role="{{$role}}" path="0"></company-header></div>
    <history-component company_id="{{$company_id}}" isAdmin="false"></history-component>
@endsection

@section('script')
    <script !src="">
    </script>
@endsection
