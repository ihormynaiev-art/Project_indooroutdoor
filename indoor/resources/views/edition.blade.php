@extends('layout.mainlayout')
@section('title', 'IndoorOutdoor')
@section('description', "Discover a wide range of home improvement services at IndoorOutdoor, including additions, remodels, landscaping, and more. Your one-stop solution for all indoor and outdoor projects.")
@section('content')
    <div class="magazine-viewport">
        {!! $settings->edition_code !!}
    </div>
@endsection
