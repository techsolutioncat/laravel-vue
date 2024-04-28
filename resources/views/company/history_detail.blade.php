@extends('layouts.app')

@include('layouts.head')

@section('title')
    会社管理
@endsection

@section('content')
    <div class="inner"><company-header company_name="{{$company_name}}" company_id="{{$company_id}}" path="0"></company-header></div>
    <company-history-detail-component company_id="{{$company_id}}"></company-history-detail-component>
@endsection

@section('script')
@endsection
