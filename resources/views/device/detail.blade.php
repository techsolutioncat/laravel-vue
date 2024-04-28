@extends('layouts.app')

@include('layouts.head')

@section('title')
    端末詳細
@endsection

@section('content')
    @if(isset($company))
    <div class="inner">
        <company-header company_name="{{$company->name}}"
                        company_id="{{$company->id}}"
                        path="1">
        </company-header>
    </div>
    @endif
    <device-detail-component>
    </device-detail-component>
@endsection

@section('script')
    <script !src="">
    </script>
@endsection
