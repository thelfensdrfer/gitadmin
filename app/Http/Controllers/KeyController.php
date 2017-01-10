<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;

use VisualAppeal\Gitolite\Config as Repository;
use VisualAppeal\Gitolite\User as RepositoryUser;

class KeyController extends Controller
{
    /**
     * Rules to validate a new key.
     *
     * @var array
     */
    protected $rules = [
        'key' => 'required',
    ];

    /**
     * Find a key by its name and returns the index in the config.
     *
     * @param VisualAppeal\Gitolite\User $user
     * @param string $key
     * @return int|null
     */
    protected function findKeyByName(\VisualAppeal\Gitolite\User $user, $key)
    {
        $keys = $user->getKeys();
        $index = 0;
        $pathToKeydir = dirname(dirname(Config::get('services.gitolite.path'))) . DIRECTORY_SEPARATOR . 'keydir' . DIRECTORY_SEPARATOR;

        foreach ($keys as $index => $path) {
            $name = str_replace($pathToKeydir, '', $path);
            $nameParts = explode('/', $name);
            if (count($nameParts) !== 3)
                throw new \Exception(sprintf('Could not parse key path %s', $name));

            if ($nameParts[1] === $key) {
                return $index;
            }

            $index++;
        }

        return null;
    }

    /**
     * Destroy public key of user.
     *
     * @param string $username
     * @param string $key
     * @return Response
     */
    public function destroy($username, $key)
    {
        $user = \Auth::user();
        if ($user->username !== $username)
            abort(403, 'Du darfst keinen Schlüssel eines anderen Benutzers löschen!');

        $config = new Repository(Config::get('services.gitolite.path'), false);
        $user = new RepositoryUser(\Auth::user()->username, Config::get('services.gitolite.path'));

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

        return redirect()->route('dashboard');
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
        $user = \Auth::user();
        if ($user->username !== $username)
            abort(403, 'Du darfst keinen Schlüssel für einen anderen Benutzers erstellen!');

        $this->validate($request, $this->rules);

        $config = new Repository(Config::get('services.gitolite.path'), false);
        $user = new RepositoryUser(\Auth::user()->username, Config::get('services.gitolite.path'));
        $name = $request->input('name', 'default');

        // Try to find key in user config
        $index = $this->findKeyByName($user, $name);
        if ($index !== null)
            return response()->json([
                'name' => ['Einen Schlüssel mit dem Namen gibt es bereits in dem Konto.']
            ], 422);

        // Create new file in gitolite repository
        $directory = dirname(dirname(Config::get('services.gitolite.path'))) . DIRECTORY_SEPARATOR . 'keydir' . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR . $name;
        $path = $directory . DIRECTORY_SEPARATOR . $username . '.pub';

        // Create key directory
        if (!is_dir($directory))
            if (!@mkdir($directory, 0777, true))
                abort(500, 'Das Verzeichnis für den Public Key konnte nicht erstellt werden!');

        // Create public key
        if (!@file_put_contents($path, $request->input('key')))
            abort(500, 'Der Public Key konnte nicht erstellt werden!');

        $user->addKey($path);
        if (!$config->saveAndPush(sprintf('[GitAdmin] %s Schlüssel von %s hinzugefügt', $name, $username)))
            abort(500, 'Der Public Key konnte nicht mit dem Server synchronisiert werden!');
        flash('Der SSH Schlüssel wurde erfolgreich erstellt.', 'success');

        dd('test');

        return [
            'redirect' => route('dashboard'),
        ];
    }
}
