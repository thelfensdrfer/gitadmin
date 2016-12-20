@extends('layouts.app')

@section('content')
    <h2><i class="fa fa-database"></i> Repositories</h2>
    @foreach ($repositories as $name => $repository)
    	<h3>{{ $name }}</h3>
    	<pre><code>git clone ssh://git@l120v.studs.math.uni-wuppertal.de/{{ $name }}.git</code></pre>
    @endforeach

    <h2><i class="fa fa-lock"></i> SSH Schlüssel</h2>
    @foreach ($keys as $key)
    	<h3>{{ $key['name'] }}</h3>
    	<pre><code>{{ $key['content'] }}</code></pre>
    @endforeach
@endsection
