@php
    $active = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <h2><i class="fa fa-database"></i> Repositories</h2>
    @foreach ($repositories as $name => $repository)
    	<h3>{{ $name }}</h3>
    	<pre><code>git clone ssh://git@l120v.studs.math.uni-wuppertal.de/{{ $name }}.git</code></pre>
    @endforeach

    <h2><i class="fa fa-lock"></i> SSH Schlüssel <small><a href="#" title="Schlüssel hinzufügen" class="key-add"><i class="fa fa-plus"></i></a></small></h2>
    @foreach ($keys as $key)
    	<h3>{{ $key['name'] }} <small><a href="#" data-url="{{ route('key.destroy', ['user' => $user->username, 'key' => $key['name']]) }}" title="Schlüssel löschen" class="key-delete"><i class="fa fa-trash"></i></a></small></h3>
    	<pre><code>{{ $key['content'] }}</code></pre>
    @endforeach

    @include('key._delete')

    @include('key._add')
@endsection
