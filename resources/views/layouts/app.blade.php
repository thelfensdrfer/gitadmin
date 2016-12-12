@extends('layouts.main')

@section('content')
    <div class="ui secondary pointing menu">
        <a class="item active">
            Home
        </a>
        <a class="item">
            Messages
        </a>
        <a class="item">
            Friends
        </a>
        <div class="right menu">
            <a class="ui item">
                Logout
            </a>
        </div>
    </div>
    <div class="ui segment">
        @yield('content')
    </div>
@endsection
