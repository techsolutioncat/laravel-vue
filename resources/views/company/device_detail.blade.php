@extends('layouts.app')

@include('layouts.head')

@section('title')
    会社管理
@endsection

@section('content')
    <div class="inner"><company-header company_name="{{$company_name}}" company_id="{{$company_id}}" path="1"></company-header></div>
    <device-detail-component back="/device"
                             :editable="{{$editable}}"
                             :is-admin="{{Auth::user()->isAdmin()}}"
                             :garbage="false"
                             :message_enabled="{{$message_enabled}}">
    </device-detail-component>
@endsection

@section('script')
@endsection
