@extends('layouts.auth')

@section('content')
    <form class="ui form" role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}

        <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail Addresse</label>

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Passwort</label>

            <input id="password" type="password" class="form-control" name="password" required>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="field">
            <button type="submit" class="ui primary button">
                Anmelden
            </button>

            <a class="btn btn-link" href="{{ url('/password/reset') }}">
                Passwort vergessen?
            </a>
        </div>
    </form>
@endsection
