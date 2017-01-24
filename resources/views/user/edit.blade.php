@php
    $active = 'user';
@endphp

@extends('layouts.app')

@section('content')
    <h2>{{ $user->username }}</h2>

    {!! Form::model($user, ['route' => ['user.update', 'user' => $user->username], 'class' => 'ui form', 'method' => 'put']) !!}
        <div class="required field @if ($errors->has('name')) error @endif">
            <label title="Vor- und Nachname">Name</label>
            {!! Form::text('name', null, ['placeholder' => 'Max Mustermann']) !!}

            @if ($errors->has('name'))
                <div class="ui error message">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="required field @if ($errors->has('username')) error @endif">
            <label title="Benutzername in den Rechnerräumen">Benutzername</label>
            {!! Form::text('username', null, ['placeholder' => 'mmusterm']) !!}

            @if ($errors->has('username'))
                <div class="ui error message">{{ $errors->first('username') }}</div>
            @endif
        </div>

        <div class="required field @if ($errors->has('email')) error @endif">
            <label title="E-Mail Adresse unter der der Benutzer erreichbar ist">E-Mail Adresse</label>
            {!! Form::email('email', null, ['placeholder' => '1000000@uni-wuppertal.de']) !!}

            @if ($errors->has('email'))
                <div class="ui error message">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="field @if ($errors->has('admin')) error @endif">
            <div class="ui slider checkbox">
                {!! Form::checkbox('admin', '1') !!}
                <label title="Ein Administrator darf z.B. Benutzer und Repositories erstellen">Administrator</label>
            </div>

            @if ($errors->has('admin'))
                <div class="ui error message">{{ $errors->first('admin') }}</div>
            @endif
        </div>

        <button class="ui primary button" type="submit"><i class="fa fa-floppy-o"></i> Speichern</button>
    {!! Form::close() !!}
</div>

@endsection
