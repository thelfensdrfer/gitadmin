@php
    $active = 'user';
@endphp

@extends('layouts.app')

@section('content')
    <h2><i class="fa fa-users"></i> Benutzer <small><a href="#" class="user-add" title="Benutzer hinzufügen"><i class="fa fa-plus"></i></a></small></h2>

    <table class="ui single line table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Benutzername</th>
                <th>E-Mail Adresse</th>
                <th>Gültig bis</th>
                <th>Admin</th>
                <th class="center aligned">Aktionen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="{{ $user->isValid ? '' : 'negative' }}">
                    <td>{{ $user->name }}</td>
                    <td><a href="{{ route('user.show', ['user' => $user->username]) }}">{{ $user->username }}</a></td>
                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    <td>{{ ($user->valid_until !== null) ? $user->valid_until->format('d.m.Y') : '' }}</td>
                    <td>@if ($user->admin) <i class="fa fa-check"></i> @endif</td>
                    <td class="center aligned">
                        <a href="{{ route('user.edit', ['user' => $user->username]) }}" title="Benutzer bearbeiten"><i class="fa fa-pencil"></i></a>
                        {!! Form::open(['route' => ['user.destroy', 'user' => $user->username], 'class' => 'inline', 'method' => 'delete']) !!}
                            <button type="submit" title="Benutzer löschen" class="button no-style"><i class="fa fa-trash"></i></a>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('user._add')
@endsection
