@extends('layouts.main')

@section('main_content')
    <div class="ui secondary pointing menu">
        <a href="{{ route('dashboard') }}" class="item active">
            <i class="fa fa-tachometer"></i>&nbsp;Dashboard
        </a>
        <div class="right menu">
            {!! Form::open(['route' => 'auth.logout', 'class' => 'ui item']) !!}
                <button type="submit" class="text-button">Abmelden</button>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="ui segment">
        @yield('content')
    </div>
@endsection
