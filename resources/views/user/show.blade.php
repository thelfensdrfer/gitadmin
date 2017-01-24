@php
    $active = 'user';
@endphp

@extends('layouts.app')

@section('content')
    <h2><i class="fa fa-user"></i> {{ $user->username }}</h2>

    @include('user._show', [
        'repositories' => $repositories,
        'keys' => $keys,
        'user' => $user,
        'dashboard' => false,
    ])
@endsection
