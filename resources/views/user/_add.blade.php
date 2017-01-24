<div class="ui small modal" id="user-add">
    <h3 class="header">
        Benutzer hinzufügen
    </h3>
    <div class="content">
        {!! Form::open(['route' => ['user.store', 'user' => $user->username], 'class' => 'ui form']) !!}
            <div class="ui error message">
                <h4 class="header">Es sind Fehler aufgetreten</h4>
                <ul class="list">
                </ul>
            </div>

            <div class="required field">
                <label title="Vor- und Nachname">Name</label>
                {!! Form::text('name', null, ['placeholder' => 'Max Mustermann']) !!}
            </div>

            <div class="required field">
                <label title="Benutzername in den Rechnerräumen">Benutzername</label>
                {!! Form::text('username', null, ['placeholder' => 'mmusterm']) !!}
            </div>

            <div class="required field">
                <label title="E-Mail Adresse unter der der Benutzer erreichbar ist">E-Mail Adresse</label>
                {!! Form::email('email', null, ['placeholder' => '1000000@uni-wuppertal.de']) !!}
            </div>

            <div class="field">
                <label title="Bis wie lange das Konto gültig sein soll">Gültig bis</label>
                <div class="ui calendar datepicker">
                    <div class="ui input left icon">
                        <i class="fa fa-calendar"></i>
                        {!! Form::text('valid_until') !!}
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="ui slider checkbox">
                    {!! Form::checkbox('invite', '1') !!}
                    <label title="E-Mail mit Passwort wird an Benutzer geschickt">Einladung verschicken</label>
                </div>
            </div>

            <div class="field">
                <div class="ui slider checkbox">
                    {!! Form::checkbox('admin', '1') !!}
                    <label title="Ein Administrator darf z.B. Benutzer und Repositories erstellen">Administrator</label>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="actions">
        <a href="#" class="ui deny button" id="user-add-cancel">
            Abbrechen
        </a>
        <button type="submit" href="#" class="ui positive icon button" id="user-add-approve">
            <i class="fa fa-plus"></i>
            Hinzufügen
        </button>
    </div>
</div>
