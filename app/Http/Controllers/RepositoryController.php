<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use VisualAppeal\Gitolite\Config as Repository;
use VisualAppeal\Gitolite\User as RepositoryUser;

class RepositoryController extends Controller
{
    /**
     * Rules to validate a new key.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required',
    ];

    /**
     * Destroy public key of user.
     *
     * @param string $username
     * @param string $key
     * @return Response
     */
    public function destroy($username, $key)
    {
        if (!Auth::user()->admin) {
            $user = Auth::user();
            if ($user->username !== $username)
                abort(403, 'Du darfst keinen Schlüssel eines anderen Benutzers löschen!');
        }

        $config = new Repository(Config::get('services.gitolite.path'), false);
        $user = new RepositoryUser($username, Config::get('services.gitolite.path'));

        // Try to find key in user config
        $index = $this->findKeyByName($user, $key);
        if ($index === null)
            abort(404, 'Der Schlüssel wurde nicht in deinem Konto gefunden!');

        if ($user->removeKey($index)) {
            $config->saveAndPush(sprintf('[GitAdmin] %s Schlüssel von %s entfernt', $key, $username));
            flash('Der SSH Schlüssel wurde aus dem Konto entfernt.', 'info');
        } else {
            flash('Der SSH Schlüssel konnte nicht aus dem Konto entfernt werden.', 'warning');
        }

        return redirect()->back();
    }

    /**
     * Create new public key for user.
     *
     * @param Request $request
     * @param string $username
     * @return Response
     */
    public function store(Request $request, $username)
    {
        if (!Auth::user()->admin)
            abort(403, 'Du darfst kein Repository erstellen!');

        $this->validate($request, $this->rules);

        $config = new Repository(Config::get('services.gitolite.path'), false);
        $user = new RepositoryUser(\Auth::user()->username, Config::get('services.gitolite.path'));
        $name = $request->input('name');

        $repository = $config->createOrFindRepository($name);

        flash('Der SSH Schlüssel wurde erfolgreich erstellt.', 'success');

        return redirect()->back();
    }
}
