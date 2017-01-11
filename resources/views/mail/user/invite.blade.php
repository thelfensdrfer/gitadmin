@extends('layouts.mail')

@section('title', 'Anmeldung')

@section('content')
    Hallo {{ $name }},<br><br>

    Sie erhalten diese E-Mail weil jemand ein Konto für Sie bei {{ Config::get('app.name') }} angelegt hat.<br><br>

    Benutzername: <code>Entspricht dem aus den Rechnerräumen</code><br>
    Passwort: <code>{{ $password }}</code><br><br>

    @include('mail._button', [
        'text' => 'Anmelden',
        'url' => $url,
    ])

    <br><br>

    Falls Sie Probleme mit dem Button haben, kopieren Sie folgende Adresse in Ihren Browser: {{ $url }}
@endsection
