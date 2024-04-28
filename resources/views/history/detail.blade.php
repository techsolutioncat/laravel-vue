@extends('layouts.app')

@include('layouts.head')

@section('title')
    端末履歴詳細
@endsection

@section('content')
    @if($isAdmin)
    <history-header history_type="device"></history-header>
    @endif
    <history-detail-component :parent="'history'">
    </history-detail-component>
@endsection

@section('script')
    <script !src="">
    </script>

@endsection
<!--        <script>-->
<!--            import HistoryHeader from "../../js/components/HistoryHeader";-->
<!--            export default {-->
<!--                components: {HistoryHeader}-->
<!--            }-->
<!--        </script>-->
