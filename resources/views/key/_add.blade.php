<div class="ui small modal" id="key-add">
    <h3 class="header">
        Schlüssel hinzufügen
    </h3>
    <div class="content">
        {!! Form::open(['route' => ['key.store', 'user' => $user->username], 'class' => 'ui form']) !!}
            <div class="ui error message">
                <h4 class="header">Es sind Fehler aufgetreten</h4>
                <ul class="list">
                </ul>
            </div>

            <div class="field">
                <label title="Name des Schlüssels">Name</label>
                {!! Form::text('name', null, ['placeholder' => 'z.B. "Desktop" oder "Laptop"']) !!}
            </div>

            <div class="required field">
                <label>Public Key</label>
                {!! Form::textarea('key', null, ['placeholder' => 'ssh-rsa ABCDEFGHIJKLMNOPQRSTUVWXYZ uni@example.com']) !!}
            </div>
        {!! Form::close() !!}
    </div>
    <div class="actions">
        <a href="#" class="ui deny button" id="key-add-cancel">
            Abbrechen
        </a>
        <button type="submit" href="#" class="ui positive icon button" id="key-add-approve">
            <i class="fa fa-plus"></i>
            Hinzufügen
        </button>
    </div>
</div>
