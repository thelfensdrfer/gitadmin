@extends('layouts.mail_text')

@section('title', 'Passwort zurücksetzen')

@section('content')
Hallo {{ $name }},

Sie erhalten diese E-Mail weil jemand ein Konto für Sie bei {{ Config::get('app.name') }} angelegt hat.

Benutzername: <code>Entspricht dem aus den Rechnerräumen</code>
Passwort: <code>{{ $password }}</code>

Anmeldung: {{ $url }}
@endsection
