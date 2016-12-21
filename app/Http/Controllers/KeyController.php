<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;

use VisualAppeal\Gitolite\Config as Repository;
use VisualAppeal\Gitolite\User as RepositoryUser;

class KeyController extends Controller
{
    public function destroy($username, $key)
    {
        $user = \Auth::user();
        if ($user->username !== $username)
            abort(403, 'Du darfst keinen Schlüssel eines anderen Benutzers löschen!');

        $config = new Repository(Config::get('services.gitolite.path'), false);
        $user = new RepositoryUser(\Auth::user()->username);

        // Try to find key in user config
        $keys = $user->getKeys();
        $index = 0;
        $pathToKeydir = dirname(dirname(Config::get('services.gitolite.path'))) . DIRECTORY_SEPARATOR . 'keydir' . DIRECTORY_SEPARATOR;

        foreach ($keys as $index => $path) {
            $name = str_replace($pathToKeydir, '', $path);
            $nameParts = explode('/', $name);
            if (count($nameParts) !== 3)
                throw new \Exception(sprintf('Could not parse key path %s', $name));

            if ($nameParts[1] === $key) {
                if ($user->removeKey($index)) {
                    $config->commitAndPush(sprintf('[GitAdmin] %s Schlüssel von %s entfernt', $key, \Auth::user()->username));
                    flash('Der SSH Schlüssel wurde aus dem Konto entfernt.', 'info');
                    return redirect()->back();
                } else {
                    flash('Der SSH Schlüssel konnte nicht aus dem Konto entfernt werden.', 'warning');
                    return redirect()->back();
                }
            }

            $index++;
        }

        abort(404, 'Der Schlüssel wurde nicht in deinem Konto gefunden!');
    }
}
