<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;

use VisualAppeal\Gitolite\Config as Repository;
use VisualAppeal\Gitolite\User as RepositoryUser;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = new Repository(Config::get('services.gitolite.path'), false);
        $user = new RepositoryUser(\Auth::user()->username);

        $pathToKeydir = dirname(dirname(Config::get('services.gitolite.path'))) . DIRECTORY_SEPARATOR . 'keydir' . DIRECTORY_SEPARATOR;
        $keys = array_map(function($path) use ($pathToKeydir, $user) {
            $name = str_replace($pathToKeydir, '', $path);
            $nameParts = explode('/', $name);
            if (count($nameParts) !== 3)
                throw new \Exception(sprintf('Could not parse key path %s', $name));

            return [
                'name' => $nameParts[1],
                'content' => file_get_contents($path)
            ];
        }, $user->getKeys());

        return view('dashboard', [
            'user' => \Auth::user(),
            'repositories' => $config->getRepositoriesForUser($user),
            'keys' => $keys,
        ]);
    }
}
