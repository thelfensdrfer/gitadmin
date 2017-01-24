<div class="ui small modal" id="repository-add">
    <h3 class="header">
        Repository hinzufügen
    </h3>
    <div class="content">
        {!! Form::open(['route' => ['repository.store', 'user' => $user->username], 'class' => 'ui form']) !!}
            <div class="ui error message">
                <h4 class="header">Es sind Fehler aufgetreten</h4>
                <ul class="list">
                </ul>
            </div>

            <div class="field">
                <label title="Name des Repositories">Name</label>
                {!! Form::text('name', null, ['placeholder' => 'z.B. "gruppe1/projekt-qt"']) !!}
            </div>
        {!! Form::close() !!}
    </div>
    <div class="actions">
        <a href="#" class="ui deny button" id="repository-add-cancel">
            Abbrechen
        </a>
        <button type="submit" href="#" class="ui positive icon button" id="repository-add-approve">
            <i class="fa fa-plus"></i>
            Hinzufügen
        </button>
    </div>
</div>
