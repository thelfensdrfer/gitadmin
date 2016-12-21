@extends('layouts.app')

@section('content')
    <h2><i class="fa fa-database"></i> Repositories</h2>
    @foreach ($repositories as $name => $repository)
    	<h3>{{ $name }}</h3>
    	<pre><code>git clone ssh://git@l120v.studs.math.uni-wuppertal.de/{{ $name }}.git</code></pre>
    @endforeach

    <h2><i class="fa fa-lock"></i> SSH Schlüssel <small><a href="#" title="Schlüssel hinzufügen"><i class="fa fa-plus"></i></a></small></h2>
    @foreach ($keys as $key)
    	<h3>{{ $key['name'] }} <small><a href="#" data-url="{{ route('key.remove', ['user' => $user->username, 'key' => $key['name']]) }}" title="Schlüssel löschen" class="key-delete"><i class="fa fa-trash"></i></a></small></h3>
    	<pre><code>{{ $key['content'] }}</code></pre>
    @endforeach

    <div class="ui basic small modal" id="confirm-key-delete">
        <div class="ui icon header">
            Schlüssel löschen
        </div>
        <div class="content">
            <p>Soll der SSH Schlüssel wirklich gelöscht werden? Der Schlüssel kann später nicht wiederhergestellt werden.</p>
        </div>
        <div class="actions">
            <a href="#" class="ui basic inverted button" id="confirm-key-delete-cancel">
                Nein
            </a>
            <a href="#" class="ui red inverted button" id="confirm-key-delete-approve">
                <i class="fa fa-trash"></i>
                Ja
            </a>
        </div>
    </div>
@endsection
