@php
    $active = 'repository';
@endphp

@extends('layouts.app')

@section('content')
    <h2><i class="fa fa-database"></i> Repositories <small><a href="#" class="repository-add" title="Repository hinzufügen"><i class="fa fa-plus"></i></a></small></h2>

    <table class="ui single line table">
        <thead>
            <tr>
                <th>Name</th>
                <th class="center aligned">Aktionen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($repositories as $repository)
                <tr>
                    <td><a href="{{ route('repository.show', ['name' => $repository->getName()]) }}">{{ $repository->getName() }}</a></td>
                    <td class="center aligned">
                        <a href="{{ route('repository.edit', ['name' => $repository->getName()]) }}" title="Repository bearbeiten"><i class="fa fa-pencil"></i></a>
                        {!! Form::open(['route' => ['repository.destroy', 'name' => $repository->getName()], 'class' => 'inline', 'method' => 'delete']) !!}
                            <button type="submit" title="Repository löschen" class="button no-style"><i class="fa fa-trash"></i></a>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('repository._add')
@endsection
