<h3><i class="fa fa-database"></i> Repositories @if ($theUser->admin)<small><a href="#" title="Repository hinzufügen" class="repository-add"><i class="fa fa-plus"></i></a></small>@endif</h3>
@foreach ($repositories as $name => $repository)
    <h3>{{ $name }} @if ($theUser->admin)<small><a href="#" data-url="{{ route('repository.destroy', ['name' => $name]) }}" title="Repository löschen" class="repository-delete"><i class="fa fa-trash"></i></a></small>@endif</h3>
    <pre><code>git clone ssh://git@l120v.studs.math.uni-wuppertal.de/{{ $name }}.git</code></pre>
@endforeach

<h3><i class="fa fa-lock"></i> SSH Schlüssel <small><a href="#" title="Schlüssel hinzufügen" class="key-add"><i class="fa fa-plus"></i></a></small></h3>
@foreach ($keys as $key)
    <h4>{{ $key['name'] }} <small><a href="#" data-url="{{ route('key.destroy', ['user' => $user->username, 'key' => $key['name']]) }}" title="Schlüssel löschen" class="key-delete"><i class="fa fa-trash"></i></a></small></h4>
    <pre><code>{{ $key['content'] }}</code></pre>
@endforeach

@if (!$dashboard)
    @include('repository._delete', [
        'user' => $user,
    ])

    @include('repository._add', [
        'user' => $user,
    ])
@endif

@include('key._delete', [
    'user' => $user,
])

@include('key._add', [
    'user' => $user,
])
