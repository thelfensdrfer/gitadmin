@extends('layouts.main')

@section('main_content')
	@include('flash::message')

    <div class="ui container segment auth-wrapper">
        @yield('content')
    </div>
@endsection
